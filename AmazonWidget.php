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
 * Amazon Widget
 *
 * This file contains the class AmazonWidget
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * AmazonWidget is a utility class to easily ouput Amazon Widgets
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class AmazonWidget {

    /**
     * Output Amazon Carousel WIdget
     * @param array $args associate array of widget parameters
     */
    public static function Carousel( $args ) {
        $widget = new AmazonWidget_Carousel( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

    /**
     * Output Amazon MP3Clips WIdget
     * @param array $args associate array of widget parameters
     */
    public static function MP3Clips( $args ) {
        $widget = new AmazonWidget_MP3Clips( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

    /**
     * Output Amazon My Favorites Widget
     * @param array $args associate array of widget parameters
     */
    public static function MyFavorites( $args ) {
        $widget = new AmazonWidget_MyFavorites( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

    /**
     * Output Amazon Search WIdget
     * @param array $args associate array of widget parameters
     */
    public static function Search( $args ) {
        $widget = new AmazonWidget_Search( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

    /**
     * Output Amazon Omakase Widget
     * @param array $args associate array of widget parameters
     */
    public static function Omakase( $args ) {
        $widget = new AmazonWidget_Omakase( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

    /**
     * Output Amazon Product Cloud Widget
     * @param array $args associate array of widget parameters
     */
    public static function ProductCloud( $args ) {
        $widget = new AmazonWidget_ProductCloud( $args );
        echo WPAA_ShortCodeHandler::doStyle( $args, $widget->toHTML() );
    }

}