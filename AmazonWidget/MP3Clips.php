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
 * MP3 Clips
 *
 * This file contains the class AmazonWidget_MP3Clips
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_MP3Clips is plugin implementation of the Amazon MP3 Clips Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_MP3Clips extends AmazonWidget_Abstract {

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
        $this->_values["widget"] = "MP3Clips";
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
            case "browse_node":
                return "browseNode";
                break;
            case "asin":
                return "ASIN";
                break;
            case "shuffle_tracks":
                return "shuffleTracks";
                break;
            case "max_results":
                return "maxResults";
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
            case "browseNode":
            case "ASIN":
            case "keywords":
            case "shuffleTracks":
            case "maxResults":
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
                "BestSellers" => "Best Sellers" );
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
                    "browseNode" => "Browse Node" );
                break;
            case "Bestsellers":
                return array(
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
            "title" => "Best Selling Amazon MP3 Clips",
            "width" => "250",
            "height" => "250",
            "shuffleTracks" => "True",
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
            "title" => "Best Selling Amazon MP3 Clips",
            "width" => "250",
            "height" => "250",
            "shuffle_tracks" => "True",
            "max_results" => null,
            "browse_node" => null,
            "asin" => null,
            "keywords" => null,
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