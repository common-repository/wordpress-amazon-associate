<?php
/*
 * copyright (c) 2012 MDBitz - Matthew John Denton - mdbitz.com
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
 * Amazon Product Response Data Wrapper
 *
 * This file contains the class WPAA_Template_DataWrapper
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.WPAA.Template
 */

/**
 * WPAA_Template_DataWrapper contains Mapping of Template Fields to
 * APaPi Result object.
 *
 * @package com.mdbitz.wordpress.amazon_associate.WPAA.Template
 */
class WPAA_Template_DataWrapper {

    /**
     * @var array data
     */
    protected $_data = null;

    /**
     * @var array attributes
     */
    protected $_attr = null;

    /**
     * @var Associate Tag
     */
    protected $_tag = null;

    /**
     * Constructor
     * @param string data
     */
    function __construct( $data, $tag ) {
        $this->_data = $data;
        $this->_tag = $tag;
        if( $data->ItemAttributes() != null ) {
            $this->_attr= $data->ItemAttributes();
        }
    }

    /**
     * Get Tag Value
     * @param String tag
     */
    public function getTagValue( $tag ) {
        $value = null;
        // Verify Item Attributes exist in data
        if( $this->_attr != null ) {
            switch ($tag) {
                case "ASIN":
                    $value = $this->_data->ASIN();
                    break;
                case "URL":
                case "LINK":
                    $value= $this->_data->DetailPageURL();
                    break;
                case "SMALL_IMAGE":
                    if( $this->_data->SmallImage() != null ) {
                        $image = $this->_data->SmallImage();
                        $value = $image->URL();
                    } else {
                        $value = $wpaa->getPluginPath( '/imgs/no_image_small.png');
                    }
                    break;
                case "MEDIUM_IMAGE":
                case "IMAGE":
                    if( $this->_data->MediumImage() != null ) {
                        $image = $this->_data->MediumImage();
                        $value = $image->URL();
                    } else {
                        $value = $wpaa->getPluginPath( '/imgs/no_image_medium.png');
                    }
                    break;
                case "LARGE_IMAGE":
                    if( $this->_data->LargeImage() != null ) {
                        $image = $this->_data->LargeImage();
                        $value = $image->URL();
                    } else {
                        $value = $wpaa->getPluginPath( '/imgs/no_image_large.png');
                    }
                    break;
                case "ARTIST":
                    $value = $this->_attr->Artist();
                    break;
                case "AUTHOR":
                    $value = $this->_attr->Author();
                    break;
                case "EAN":
                    $value = $this->_attr->EAN();
                    break;
                case "ISBN":
                    $value = $this->_attr->ISBN();
                    break;
                case "PRICE":
                    if( $this->_attr->ListPrice() != null ) {
                        $value = $this->_attr->ListPrice()->FormattedPrice();
                    }
                    break;
                case "PUBLISH_DATE":
                    $value = $this->_attr->PublishDate();
                    break;
                case "RELEASE_DATE":
                    $value = $this->_attr->ReleaseDate();
                    break;
                case "TITLE":
                    $value = $this->_attr->Title();
                    break;
                case "PRODUCT_GROUP":
                    $value = $this->_attr->ProductGroup();
                    break;
                case "MANUFACTURER":
                    $value = $this->_attr->Manufacturer();
                    break;
                case "PUBLISHER":
                    $value = $this->_attr->Publisher();
                    break;
                case "STUDIO":
                    $value = $this->_attr->Studio();
                    break;
                case "LABEL":
                    $value = $this->_attr->Label();
                    break;
                case "MPN":
                    $value = $this->_attr->MPN();
                    break;
                case "SKU":
                    $value = $this->_attr->SKU();
                    break;
                case "UPC":
                    $value = $this->_attr->UPC();
                    break;
                case "DESCRIPTION":
                case "DESC_FULL":
                case "DESC_SHORT":
                    if( $this->_data->EditorialReviews() != null ) {
                        $reviews = $this->_data->EditorialReviews();
                        foreach( $reviews as $review ) {
                            if( $review->Source() == "Product Description" ) {
                                $value = $review->Content();
                                if( $tag == "DESC_SHORT" ) {
                                    $value = substr($value, 0, 100) . ' ...';
                                }
                                break;
                            }
                        }
                    }
                    break;
                case "TAG":
                case "ASSOCIATE_ID":
                case "ASSOCIATE_TAG":
                    $value = $this->_tag;
                    break;
            }
        }
        return $value;
    }


} // class WPAA_Template_DataWrapper