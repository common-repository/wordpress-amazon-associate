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
 * Omakase
 *
 * This file contains the class AmazonWidget_Omakase
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_Omakase is the plugin representation of theOmakase Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_Omakase extends AmazonWidget_Abstract {

    /**
     * @var string Script Source
     */
    protected $_script_url = "/s/ads.js";

    /**
     * set property to specified value
     *
     * @param mixed $property
     * @param mixed $value
     * @return void
     */
    public function set($property, $value) {
        if ($this->isValid($property)) {
            switch( $property ) {
                case "size":
                    if( array_key_exists( $value, self::getBannerSizes() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_logo":
                    if( array_key_exists( $value, self::getLogoOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_border":
                    if( array_key_exists( $value, self::getBorderOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_product_images":
                    if( array_key_exists( $value, self::getImagesOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_link_target":
                    if( array_key_exists( $value, self::getOpenOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_price":
                    if( array_key_exists( $value, self::getPriceOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                case "ad_discount":
                    if( array_key_exists( $value, self::getDiscountOptions() ) ) {
                        $this->_values[$property] = $value;
                    }
                break;
                default:
                    $this->_values[$property] = $value;
                break;
            }
        }
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        return $property;
    }

    /**
     * is property valid for this object
     *
     * @param String $property
     * @return boolean
     */
    public function isValid($property) {
        switch ($property) {
            case "locale":
            case "ad_tag":
            case "size":
            case "ad_logo":
            case "ad_border":
            case "ad_product_images":
            case "ad_link_target":
            case "ad_price":
            case "ad_discount":
            case "color_border":
            case "color_background":
            case "color_text":
            case "color_link":
            case "color_price":
            case "color_logo":
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
        global $post;
        $locale = $this->_values['locale'];
        if( isset( $this->_values['locale'] ) ) {
            if( ! empty($this->_values['locale']) ) {
                $locale = $this->_values['locale'];
            }
            unset( $this->_values['locale']);
        }
        $author_id = null;
        if( !is_null( $post ) && isset( $post->post_author ) ) {
            $author_id = $post->post_author;
        }
        $this->_values['ad_tag'] = $wpaa->getAssociateId( $locale, $author_id );
        $output = '<script type="text/javascript"><!--
            ';
        foreach( $this->_values as $property => $value ) {
            switch( $property ) {
                case "size":
                    $dimensions = split( "x", $value );
                    $output .= ' amazon_ad_width = "' . $dimensions[0] . '";';
                    $output .= ' amazon_ad_height = "' . $dimensions[1] . '";';
                    break;
                default :
                    $output .= ' amazon_' . $property . ' = "' . $value . '";';
                break;
            }
        }
        $output .= '
            //--></script>';
        $output .= '<script type="text/javascript" src="http://www.assoc-amazon.' . WPAA_URIHandler::getDomain( $locale ) . $this->_script_url . '"></script>';
        return $output;
    }

    /**
     * return Associative Array of Default Amazon Widget Options
     *
     * @return array
     */
    public static function getDefaultOptions() {
        return array(
            "size" => "728x90",
            "ad_logo" => "show",
            "ad_border" => "show",
            "ad_product_images" => "show",
            "ad_link_target" => "same",
            "ad_price" => "all",
            "ad_discount" => "add",
            "color_border" => "000000",
            "color_background" => "FFFFFF",
            "color_text" => "000000",
            "color_link" => "3399FF",
            "color_price" => "990000",
            "color_logo" => "CC6600",
            "locale" => ""
        );
    }

    /**
     * return Associative Array of Default Amazon Widget Short Code Options
     *
     * @return array
     */
    public static function getDefaultShortCodeOptions() {
        return self::getDefaultOptions();
    }

    /**
     * get Supported Widget Dimensions
     *
     * @return array
     */
    public static function getBannerSizes() {
        return array(
            "120x600" => "120x600",
            "120x240" => "120x240",
            "160x600" => "120x600",
            "180x150" => "180x150",
            "468x60" =>  "468x60",
            "728x90" => "728x90",
            "300x250" => "300x250",
            "600x520" => "600x520"
        );
    }

    /**
     * get Supported Amazon logo options
     * @return array
     */
    public static function getLogoOptions() {
        return array(
            "show" => "Show as logo",
            "hide" => "Show as text"
        );
    }

    /**
     * get Supported Amazon Product image options
     * @return array
     */
    public static function getImagesOptions() {
        return array(
            "show" => "Show Product Images",
            "hide" => "Hide Product Images"
        );
    }

    /**
     * get Supported target options
     * @return array
     */
    public static function getOpenOptions() {
        return array(
            "same" => "Same Window",
            "new" => "New Window"
        );
    }

    /**
     * get Supported Price Options
     * @return array
     */
    public static function getPriceOptions() {
        return array(
            "all" => "Show all prices",
            "retail" => "Show Amazon prices only"
        );
    }

    /**
     * get Supported Widget border options
     * @return array
     */
    public static function getBorderOptions() {
        return array(
            "show" => "Show border",
            "hide" => "Hide border"
        );
    }

    /**
     * get Supported Discount options
     * @return array
     */
    public static function getDiscountOptions() {
        return array(
            "add" => "Add Discount Sticker",
            "remove" => "Remove Discount Sticker"
        );
    }


    /**
     * return Associative Array of available Markets
     *
     * @return array
     */
    public static function getAvailableLocales() {
        return array (
            "" => "-Geo Locale-",
            "US" => "US",
            "CA" => "CA",
            "DE" => "DE",
            "FR" => "FR",
            "JP" => "JP",
            "UK" => "UK"

        );
    }

}