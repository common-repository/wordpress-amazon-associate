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
 * Carousel
 *
 * This file contains the class AmazonWidget_Carousel
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_Carousel is plugin implementation of the Amazon Carousel Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_Carousel extends AmazonWidget_Abstract {

    /**
     * Constructor
     *
     * @param string $xml XML Representation of Object
     */
    public function __construct($args = null) {
        if( is_null( $args ) ){
            $args = self::getDefaultOptions();
        }
        parent::__construct($args);
        $this->_values["widget"] = "Carousel";
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "widget_type":
                return "widgetType";
                break;
            case "search_index":
                return "searchIndex";
                break;
            case "browse_node":
                return "browseNode";
                break;
            case "asin":
                return "ASIN";
                break;
            case "shuffle_products":
                return "shuffleProducts";
                break;
            case "show_border":
                return "showBorder";
                break;
            default:
                return parent::convert( $property );
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
            case "height":
            case "widgetType":
            case "searchIndex":
            case "browseNode":
            case "ASIN":
            case "keywords":
            case "shuffleProducts":
            case "showBorder":
                return true;
                break;
            default:
                return parent::isValid( $property );
                break;
        }
    }
    
    /**
     * get Array of available Widget Types
     *
     * @return array
     */
    public static function getAvailableTypes() {
        return array( "ASINList" => "ASIN List",
                "SearchAndAdd" => "Search and Add",
                "Bestsellers" => "Best Sellers",
                "NewReleases" => "New Releases",
                "MostWishedFor" => "Most Wished For",
                "MostGifted" => "Most Gifted" );
    }

    /**
     * get Type Parameters that can be modified
     *
     * @param String $type Widget Type
     * @return array
     */
    public static function getTypeParameters( $type ) {
        switch( $type ) {
            case "ASINList":
                return array(
                    "ASIN" => "ASIN" );
                break;
            case "SearchAndAdd":
                return array(
                    "keywords" => "Keywords",
                    "searchIndex" => "Search Index",
                    "browseNode" => "Browse Node" );
                break;
            case "Bestsellers":
            case "NewReleases":
            case "MostWishedFor":
            case "MostGifted":
                return array(
                    "searchIndex" => "Search Index",
                    "browseNode" => "Browse Node" );
                break;
        }
    }

    /**
     * return Associative Array of Default Amazon Widget Options
     *
     * @return array
     */
    public static function getDefaultOptions() {
        return array(
            "widgetType" => "Bestsellers",
            "searchIndex" => "Books",
            "title" => "Bestselling Books",
            "width" => "600",
            "height" => "200",
            "marketPlace" => self::getDefaultMarket() );
    }

    /**
     * return Associative Array of Default Amazon Widget Short Code Options
     *
     * @return array
     */
    public static function getDefaultShortCodeOptions() {
        return array(
            "widget_type" => "Bestsellers",
            "search_index" => "Books",
            "title" => "Bestselling Books",
            "width" => "600",
            "height" => "200",
            "browse_node" => null,
            "asin" => null,
            "keywords" => null,
            "shuffle_products" => null,
            "show_border" => null,
            "market_place" => self::getDefaultMarket() );
    }

    /**
     * return Amazon Widget HTML
     * @return String
     */
    public function toHTML() {

        switch( $this->_values['widgetType'] ) {
            case "ASINList":
                unset( $this->_values['keywords'] );
                unset( $this->_values['searchIndex'] );
                unset( $this->_values['browseNode'] );
                break;
            case "SearchAndAdd":
                unset( $this->_values['ASIN'] );
                break;
            default:
                unset( $this->_values['ASIN'] );
                unset( $this->_values['keywords'] );
                break;
        }
        return parent::toHTML();
    }

}