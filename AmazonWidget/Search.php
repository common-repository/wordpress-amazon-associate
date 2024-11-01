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
 * Search
 *
 * This file contains the class AmazonWidget_Search
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_Search is plugin implementation of the
 * Amazon Search Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_Search extends AmazonWidget_Design {

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
        $this->_values["widget"] = "Search";
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "search_index":
                return "searchIndex";
                break;
            case "default_search_term":
                return "defaultSearchTerm";
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
            case "searchIndex":
            case "defaultSearchTerm":
                return true;
                break;
            default:
                return parent::isValid( $property );
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
            "columns" => "1",
            "rows" => "3",
            "defaultSearchTerm" => "Jim Butcher",
            "searchIndex" => "Books",
            "width" => "256",
            "showImage" => "True",
            "showPrice" => "True",
            "showRating" => "True",
            "design" => "2",
            "colorTheme" => "Default",
            "headerTextColor" => "#FFFFFF",
            "outerBackgroundColor" => "#000000",
            "marketPlace" => self::getDefaultMarket() );
    }

    /**
     * return Associative Array of Default Amazon Widget Short Code Options
     *
     * @return array
     */
    public static function getDefaultShortCodeOptions() {
        return array(
            "columns" => "1",
            "rows" => "3",
            "default_search_term" => "Jim Butcher",
            "search_index" => "Books",
            "width" => "256",
            "show_image" => "True",
            "show_price" => "True",
            "show_rating" => "True",
            "design" => "2",
            "color_theme" => "Default",
            "header_text_color" => "#FFFFFF",
            "outer_background_color" => "#000000",
            "inner_background_color" => null,
            "linked_text_color" => null,
            "body_text_color" => null,
            "rounded_corners" => null,
            "background_color" => null,
            "border_color" => null,
            "market_place" => self::getDefaultMarket() );
    }

}