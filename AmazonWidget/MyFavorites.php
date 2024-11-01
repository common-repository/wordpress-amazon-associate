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
 * My Favorites
 *
 * This file contains the class AmazonWidget_MyFavorites
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_MyFavorites is plugin implementation of the
 * Amazon MyFavorites Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_MyFavorites extends AmazonWidget_Design {

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
        $this->_values["widget"] = "MyFavorites";
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "asin":
                return "ASIN";
                break;
            case "shuffle_products":
                return "shuffleProducts";
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
            case "ASIN":
            case "shuffleProducts":
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
            "title" => "Henri-Cartier-Bresson: Photographer Extraordinaire",
            "width" => "250",
            "ASIN" => "0893817449,0500410607,050054199X,0500286426,0893818755,050054333X,0500543178,0945506562",
            "showImage" => "True",
            "showPrice" => "True",
            "showRating" => "True",
            "design" => "2",
            "colorTheme" => "Orange",
            "headerTextColor" => "#FFFFFF",
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
            "title" => "Henri-Cartier-Bresson: Photographer Extraordinaire",
            "width" => "250",
            "asin" => "0893817449,0500410607,050054199X,0500286426,0893818755,050054333X,0500543178,0945506562",
            "show_image" => "True",
            "show_price" => "True",
            "show_rating" => "True",
            "design" => "2",
            "color_theme" => "Orange",
            "header_text_color" => "#FFFFFF",
            "shuffle_products" => null,
            "outer_background_color" => null,
            "inner_background_color" => null,
            "linked_text_color" => null,
            "body_text_color" => null,
            "rounded_corners" => null,
            "background_color" => null,
            "border_color" => null,
            "market_place" => self::getDefaultMarket() );
    }

}