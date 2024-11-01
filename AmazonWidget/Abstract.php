<?php

/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
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
 * Abstract
 *
 * This file contains the class AmazonWidget_Abstract
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_Abstract is base class for all Amazon Widgets
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
abstract class AmazonWidget_Abstract {

    /**
     * @var string Script Source
     */
    protected $_script_url = "http://wms.assoc-amazon.com/20070822/US/js/swfobject_1_5.js";
    
    /**
     * @var array Object Values
     */
    protected $_values = array();

    /**
     * Constructor
     *
     * @param string $xml XML Representation of Object
     */
    public function __construct($args = null) {
        foreach ($args as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * magic method to return non public properties
     *
     * @see     get
     * @param   mixed $property
     * @return  mixed
     */
    public function __get($property) {
        return $this->get($property);
    }

    /**
     * get specifed property
     *
     * @param mixed $property
     * @return mixed
     */
    public function get($property) {
        if (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
            return null;
        }
    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set($property, $value) {
        $this->set($property, $value);
    }

    /**
     * set property to specified value
     *
     * @param mixed $property
     * @param mixed $value
     * @return void
     */
    public function set($property, $value) {
        $property = $this->convert($property);
        if ($this->isValid($property)) {
            $this->_values[$property] = $value;
        }
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string 
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "market_place":
                return "marketPlace";
                break;
            default:
                return $property;
                break;
        }
    }

    /**
     * is property valid for this object
     * 
     * @param String $property 
     * @return boolean
     */
    public function isValid($property) {
        switch ($property) {
            case "tag":
            case "width":
            case "title":
            case "marketPlace":
            case "widget":
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * return Amazon Widget HTML
     * @return String
     */
    public function toHTML() {
        global $wpaa;
        $output = '<script type="text/javascript">';
        $output .= 'var amzn_wdgt= { ';
        if( empty( $this->_values['marketPlace']) ) {
            $this->_values['marketPlace'] = self::getGeoMarket();
        }
        $this->set( "tag", $this->getAssociateId() );
        $prop_array = array();
        foreach ($this->_values as $property => $value) {
            if( ! empty( $value ) ) {
                $prop_array[] = $property . ':"' . $value . '"';
            }
        }
        $output .= implode(", ", $prop_array);
        $output .= ' };';
        $output .= '</script>';
        $output .= '<script type="text/javascript" src="' . $this->_script_url . '"></script>';
        return $output;
    }

    /**
     * return Associative Array of Default Amazon Widget Options
     *
     * @return array
     */
    abstract public static function getDefaultOptions();

    /**
     * return Associative Array of Default Amazon Widget Short Code Options
     *
     * @return array
     */
    abstract public static function getDefaultShortCodeOptions();

    /**
     * return Associative Array of available Markets
     *
     * @return array
     */
    public static function getAvailableMarkets() {
        return array(
            "" => "-Geo Locale-",
            "US" => "United States",
            "CA" => "Canada",
            "FR" => "France",
            "DE" => "Germany",
            "JP" => "Japan",
            "GB" => "United Kingdom");
    }

    /**
     * get Default Market based on Locale settings
     * @global WPAA $wpaa
     * @return string
     */
    public static function getDefaultMarket() {
        global $wpaa;
        switch( $wpaa->getLocale() ) {
            case "UK":
                return "GB";
                break;
            default:
                return $wpaa->getLocale();
                break;
        }
    }

    /**
     * get Default Market based on Locale settings
     * @global WPAA $wpaa
     * @return string
     */
    public static function getGeoMarket() {
        global $wpaa;
        switch( $wpaa->getGeoLocale() ) {
            case "UK":
                return "GB";
                break;
            default:
                return $wpaa->getGeoLocale();
                break;
        }
    }

    /**
     * get AssociateId based on MarketPlace
     * @global WPAA $wpaa
     * @return string
     */
    protected function getAssociateId() {
        global $wpaa;
        global $post;
        $author_id = null;
        if( !is_null( $post ) && isset( $post->post_author ) ) {
            $author_id = $post->post_author;
        }
        switch( $this->_values['marketPlace'] ) {
            case "GB":
                return $wpaa->getAssociateId( "UK", $author_id );
                break;
            case "US":
            case "CA":
            case "DE":
            case "ES":
            case "FR":
            case "JP":
            case "IT":
            case "CN":
                return $wpaa->getAssociateId( $this->_values['marketPlace'], $author_id );
                break;
            default:
                return $wpaa->getAssociateId( null, $author_id );
                break;
        }
    }

}