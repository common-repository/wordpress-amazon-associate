<?php
/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * WordPress Amazon Associate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress Amazon Associate.
 * If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * WPAA_CacheHandler
 *
 * This file contains the class WPAA_CacheHandler
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * Cache Handler Class for WordPress Amazon Associate plugin
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class WPAA_CacheHandler {

    /**
     * PHP Cache
     * @var array
     */
    private $_cache = array();

    /**
     * Cache Table
     * @var string
     */
    private $_table = "";

    /**
     * is Cache Enabled
     * @var boolean
     */
    private $_enabled = true;

    /**
     * cache expires after x days
     * @var int
     */
    private $_expire = 14;

    /**
     * Constructor
     * @param string $parent_hook
     * @param string $version
     * @param string $last_updated
     */
    function __construct( $table, $enabled = true, $expire = 14 ) {
        $this->_table = $table;
        $this->_enabled = $enabled;
        $this->_expire = $expire;
    }

    /**
     * lookup Amazon Product
     * @global WPAA $wpaa
     * @global WPDB $wpdb
     * @param string $id
     * @param string $locale
     * @param string $type
     * @param string $responseGroup
     */
    public function getProduct( $id, $locale=null, $type="ASIN", $responseGroup=null ) {
        global $wpaa;
        global $wpdb;
        $locale = $wpaa->getGeoLocale( $locale );
        if( is_array( $responseGroup) ) {
           $responseGroup = implode( ",", $responseGroup );
        }
        
        if( $this->_enabled ) { // cache is enabled
            $cache_index = $locale . $id . $type . $responseGroup;
            if( isset( $this->_cache[$cache_index] ) ) { // check php cache
                $result = $this->_cache[$cache_index];
                // if product does not exist for locale then get product from default locale
                if( !$result->isSuccess() && $locale != $wpaa->getLocale() ) {
                    $result = $this->getProduct( $id, $wpaa->getLocale(), $type, $responseGroup );
                }
                return $this->filterAmazonId( $result );
            } else {
                //lookup product in db cache
                $sql = $wpdb->prepare( "Select data, updated_ts FROM `$this->_table` WHERE id='%s' AND locale='%s' AND type='%s' AND response_group='%s';", $id, $locale, $type, $responseGroup );
                $result = $wpdb->get_row( $sql );
                //product not in cache
                if( is_null( $result ) ) {
                    $result = $this->getProductByAPI($id, $locale, $type, $responseGroup);
                    //cache result in db
                    $sql = $wpdb->insert( $this->_table, array( 'id' => $id, 'locale' => $locale, 'type' => $type, 'response_group' => $responseGroup, 'data' => serialize( $result ), 'updated_ts' => date( 'Y-m-d', time() ) ) );
                    // cache result in php
                    $this->_cache[$cache_index] = $result;
                    // if product does not exist for locale then get product from default locale
                    if( !$result->isSuccess() && $locale != $wpaa->getLocale() ) {
                        return $this->getProduct( $id, $wpaa->getLocale(), $type, $responseGroup );
                    }
                    return $result;
                } else {

                    // cache has expired
                    if( $this->_expire > 0  && strtotime ( '+' . $this->_expire . ' day' , strtotime( $result->updated_ts ) ) < time() ) {
                        $result = $this->getProductByAPI($id, $locale, $type, $responseGroup);
                        //cache result in db
                        $sql = $wpdb->update( $this->_table, array( 'data' => serialize( $result ), 'updated_ts' => date( 'Y-m-d', time() ) ), array( 'id' => $id, 'locale' => $locale, 'type' => $type, 'response_group' => $responseGroup ) );
                        // cache result in php
                        $this->_cache[$cache_index] = $result;
                        // if product does not exist for locale then get product from default locale
                        if( !$result->isSuccess() && $locale != $wpaa->getLocale() ) {
                            return $this->getProduct( $id, $wpaa->getLocale(), $type, $responseGroup );
                        }
                        return $result;
                    } else {
                        //unserialize db cache
                        $obj = unserialize($result->data);
                        // cache result in php
                        $this->_cache[$cache_index] = $obj;
                        // if product does not exist for locale then get product from default locale
                        if( !$obj->isSuccess() && $locale != $wpaa->getLocale() ) {
                            return $this->getProduct( $id, $wpaa->getLocale(), $type, $responseGroup );
                        }
                        return $this->filterAmazonId($obj);
                    }
                }
            }
        } else { // cache is disabled
            $obj = $this->getProductByAPI($id, $locale, $type, $responseGroup);
            // if product does not exist for locale then get product from default locale
            if( !$obj->isSuccess() && $locale != $wpaa->getLocale() ) {
                return $this->getProductByAPI( $id, $wpaa->getLocale(), $type, $responseGroup );
            } else {
                return $obj;
            }
        }
    }

    /**
     * check if Amazon Product exists in given locale
     * @global WPAA $wpaa
     * @global WPDB $wpdb
     * @param string $id
     * @param string $locale
     * @param string $type
     * @param string $responseGroup
     */
    public function productExists( $id, $locale=null, $type="ASIN", $responseGroup=null ) {
        global $wpaa;
        global $wpdb;
        $locale = $wpaa->getGeoLocale( $locale );

        if( $this->_enabled ) { // cache is enabled
            $cache_index = $locale . $id . $type . $responseGroup;
            if( isset( $this->_cache[$cache_index] ) ) { // check php cache
                $result = $this->_cache[$cache_index];
                return $result->isSuccess();
            } else {
                //lookup product in db cache
                $sql = $wpdb->prepare( "Select data, updated_ts FROM `$this->_table` WHERE id='%s' AND locale='%s' AND type='%s' AND response_group='%s';", $id, $locale, $type, $responseGroup );
                $result = $wpdb->get_row( $sql );

                //product not in cache
                if( is_null( $result ) ) {
                    $result = $this->getProductByAPI($id, $locale, $type, $responseGroup);
                    //cache result in db
                    $sql = $wpdb->insert( $this->_table, array( 'id' => $id, 'locale' => $locale, 'type' => $type, 'response_group' => $responseGroup, 'data' => serialize( $result ), 'updated_ts' => date( 'Y-m-d', time() ) ) );
                    // cache result in php
                    $this->_cache[$cache_index] = $result;
                    return $result->isSuccess();
                } else {

                    // cache has expired
                    if( $this->_expire > 0  && strtotime ( '+' . $this->_expire . ' day' , strtotime( $result->updated_ts ) ) < time() ) {
                        $result = $this->getProductByAPI($id, $locale, $type, $responseGroup);
                        //cache result in db
                        $sql = $wpdb->update( $this->_table, array( 'data' => serialize( $result ), 'updated_ts' => date( 'Y-m-d', time() ) ), array( 'id' => $id, 'locale' => $locale, 'type' => $type, 'response_group' => $responseGroup ) );
                        // cache result in php
                        $this->_cache[$cache_index] = $result;
                        // if product does not exist for locale then get product from default locale
                        return $result->isSuccess();
                    } else {
                        //unserialize db cache
                        $result = unserialize($result->data);
                        // cache result in php
                        $this->_cache[$cache_index] = $result;
                        return $result->isSuccess();
                    }
                }
            }
        } else { // cache is disabled
            $result = $this->getProductByAPI($id, $locale, $type, $responseGroup);
            // if product does not exist for locale then get product from default locale
            return $result->isSuccess();
        }
    }

    /**
     * get Product from Amazon Product API
     * @global WPAA $wpaa
     * @param string $id
     * @param string $locale
     * @param string $type
     * @param string $responseGroup
     */
    private function getProductByAPI( $id, $locale, $type, $responseGroup) {
        global $wpaa;
        return $wpaa->getAPI( $locale )->lookup( $id, $type, $responseGroup);
    }

    /**
     * Update Associate Tag based on Plugin settings.
     *
     * @param AmazonProduct_Result $obj
     * @return AmazonProduct_Result
     */
    private function filterAmazonId( $result ) {
        global $wpaa;
        if ($result->isSuccess() && isset($result->Items[0])) {
            $result->Items[0]->set('DetailPageURL', $wpaa->replace_associate_tag( urldecode( $result->Items[0]->DetailPageURL ) ) );
        }
        return $result;
    }

}