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
 * Design
 *
 * This file contains the class AmazonWidget_Design
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_Design is abstract representation of Amazon Widgets with
 * Designs and Themes.
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
abstract class AmazonWidget_Design extends AmazonWidget_Abstract {

    /**
     * @var string Script Source
     */
    protected $_script_url = "http://wms.assoc-amazon.com/20070822/US/js/AmazonWidgets.js";

    /**
     * Constructor
     *
     * @param string $xml XML Representation of Object
     */
    public function __construct($args) {
        parent::__construct($args);
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "show_image":
                return "showImage";
                break;
            case "show_price":
                return "showPrice";
                break;
            case "show_rating":
                return "showRating";
                break;
            case "color_theme":
                return "colorTheme";
                break;
            case "outer_background_color":
                return "outerBackgroundColor";
                break;
            case "inner_background_color":
                return "innerBackgroundColor";
                break;
            case "background_color":
                return "backgroundColor";
                break;
            case "border_color":
                return "borderColor";
                break;
            case "header_text_color":
                return "headerTextColor";
                break;
            case "linked_text_color":
                return "linkedTextColor";
                break;
            case "body_text_color":
                return "bodyTextColor";
                break;
            case "rounded_corners":
                return "roundedCorners";
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
            case "columns":
            case "rows":
            case "showImage":
            case "showPrice":
            case "showRating":
            case "design":
            case "colorTheme":
            case "outerBackgroundColor":
            case "innerBackgroundColor":
            case "backgroundColor":
            case "borderColor":
            case "headerTextColor":
            case "linkedTextColor":
            case "bodyTextColor":
            case "roundedCorners":
                return true;
                break;
            default:
                return parent::isValid( $property );
                break;
        }
    }

    /**
     * get Array of Available Designs
     *
     * @return array
     */
    public static function getAvailableDesigns() {
        return array( "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5" );
    }

    /**
     * get Color Themes for a Design Style
     *
     * @param string $design Design Id
     * @return array
     */
    public static function getDesignColorThemes( $design ) {
        switch( $design ) {
            case "1":
                return array( "Blues" => "Blues",
                    "Pistachio" => "Pistachio",
                    "RedGrey" => "RedGrey",
                    "Pink" => "Pink",
                    "Pumpkin" => "Pumpkin" );
                break;
            case "2":
                return array( "Default" => "Default",
                    "Blue" => "Blue",
                    "Grey" => "Grey",
                    "Orange" => "Orange",
                    "Pink" => "Pink",
                    "White" => "White" );
                break;
            case "3":
                return array( "Cinnamon" => "Cinnamon",
                    "Peppermint" => "Peppermint",
                    "Spearmint" => "Spearmint");
                break;
            case "4":
                return array( "Onyx" => "Onyx",
                    "Cobalt" => "Cobalt",
                    "Ruby" => "Ruby" );
                break;
            case "5":
                return array( "BrushedSteel" => "BrushedSteel",
                    "BrushedNickel" => "BrushedNickel",
                    "BrushedCopper" => "BrushedCopper");
                break;
        }
    }

    /**
     * get Design Parameters that can be modified
     *
     * @param String $design Design Id
     * @return array
     */
    public function getDesignParameters( $design ) {
        switch( $design ) {
            case "1":
                return array(
                    "outerBackgroundColor" => "Outer Background Color",
                    "innerBackgroundColor" => "Inner Background Color",
                    "headerTextColor" => "Header Text Color",
                    "linkedTextColor" => "Linked Text Color",
                    "bodyTextColor" => "Body Text Color",
                    "roundedCorners" => "Rounded Corners" );
                break;
            case "2":
                return array(
                    "outerBackgroundColor" => "Outer Background Color",
                    "backgroundColor" => "Background Color",
                    "borderColor" => "Border Color",
                    "headerTextColor" => "Header Text Color",
                    "linkedTextColor" => "Linked Text Color",
                    "bodyTextColor" => "Body Text Color" );
                break;
            case "3":
            case "4":
            case "5":
                return array(
                    "headerTextColor" => "Header Text Color",
                    "linkedTextColor" => "Linked Text Color",
                    "bodyTextColor" => "Body Text Color" );
                break;
        }
    }

    /**
     * return Amazon Widget HTML
     * @return String
     */
    public function toHTML() {

        switch( $this->_values['design'] ) {
            case "1":
                unset( $this->_values['backgroundColor']);
                unset( $this->_values['borderColor']);
                break;
            case "2":
                unset( $this->_values['innerBackgroundColor']);
                unset( $this->_values['roundedCorners'] );
                break;
            default:
                unset( $this->_values['backgroundColor']);
                unset( $this->_values['borderColor']);
                unset( $this->_values['roundedCorners'] );
                unset( $this->_values['outerBackgroundColor'] );
                unset( $this->_values['innerBackgroundColor'] );
                break;
        }
        return parent::toHTML();
    }

}