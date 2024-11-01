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
 * ProductCloud
 *
 * This file contains the class AmazonWidget_ProductCloud
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */

/**
 * AmazonWidget_ProductCloud is the plugin representation of theOmakase Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.AmazonWidget
 */
class AmazonWidget_ProductCloud extends AmazonWidget_Abstract {

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
        $this->_values["templateId"] = "8006";
        $this->_values["serviceVersion"] = "20070822";
        $this->_values['theme_version'] = 0;
        $this->_values['showEditIcon'] = 'true';
    }

    /**
     * Converts Properties from ShortCode to valid Format
     *
     * @param string $property
     * @return string
     */
    protected function convert( $property ) {
        switch( $property ) {
            case "popover_border_color":
                return "popoverBorderColor";
                break;
            case "background_color":
                return "backgroundColor";
                break;
            case "title_text_color":
                return "titleTextColor";
                break;
            case "cloud_font_size":
                return "cloudFontSize";
                break;
            case "service_version":
                return "serviceVersion";
                break;
            case "show_edit_icon":
                return "showEditIcon";
                break;
            case "market_place":
                return "marketPlace";
                break;
            case "title_font":
                return "titleFont";
                break;
            case "template_id":
                return "templateId";
                break;
            case "title_font_size":
                return "titleFontSize";
                break;
            case "curved_corners":
                return "curvedCorners";
                break;
            case "hover_background_color":
                return "hoverBackgroundColor";
                break;
            case "hover_text_color":
                return "hoverTextColor";
                break;
            case "show_amazon_logo_as_text":
                return "showAmazonLogoAsText";
                break;
            case "show_title":
                return "showTitle";
                break;
            case "cloud_text_color":
                return "cloudTextColor";
                break;
            case "show_popovers":
                return "showPopovers";
                break;
            case "cloud_font":
                return "cloudFont";
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
            case "popoverBorderColor":
            case "backgroundColor":
            case "tag":
            case "titleTextColor":
            case "width":
            case "cloudFontSize":
            case "serviceVersion":
            case "showEditIcon":
            case "marketPlace":
            case "titleFont":
            case "templateId":
            case "titleFontSize":
            case "theme_version":
            case "title":
            case "category":
            case "height":
            case "curvedCorners":
            case "hoverBackgroundColor":
            case "hoverTextColor":
            case "showAmazonLogoAsText":
            case "showTitle":
            case "cloudTextColor":
            case "showPopovers":
            case "cloudFont":
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
                if( $value == "true" || $value == "false" ) {
                    $prop_array[] = '"' . $property . '":' . $value;
                } else {
                    $prop_array[] = '"' . $property . '":"' . $value . '"';
                }
            }
        }
        $output .= implode(", ", $prop_array);
        $output .= ' };';
        $output .= '</script>';
        $output .= '<script charset="utf-8" type="text/javascript" src="https://wms.assoc-amazon.com/20070822/' . $this->_values['marketPlace'] . '/js/8006.js"></script>';
        return $output;
    }

    /**
     * return Associative Array of Default Amazon Widget Options
     *
     * @return array
     */
    public static function getDefaultOptions() {
        return array(
            "popoverBorderColor" => "#918C8C",
            "backgroundColor" => "#ffffff",
            "titleTextColor" => "#000000",
            "width" => "336",
            "cloudFontSize" => "14px",
            "serviceVersion" => "20070822",
            "showEditIcon" => true,
            "marketPlace" => "US",
            "titleFont" => "Verdana",
            "templateId" => "8006",
            "titleFontSize" => "13px",
            "theme_version" => "0",
            "title" => "Product Cloud Widget",
            "category" => "All",
            "height" => "280",
            "curvedCorners" => false,
            "hoverBackgroundColor" => "#cc6600",
            "hoverTextColor" => "#ffffff",
            "showAmazonLogoAsText" => false,
            "showTitle" => true,
            "cloudTextColor" => "#003399",
            "showPopovers" => true,
            "cloudFont" => "Verdana"
        );
    }

    /**
     * return Associative Array of Default Amazon Widget Short Code Options
     *
     * @return array
     */
    public static function getDefaultShortCodeOptions() {
         return array(
            "popover_border_color" => "#918C8C",
            "background_color" => "#ffffff",
            "title_text_color" => "#000000",
            "width" => "336",
            "cloud_font_size" => "14px",
            "service_version" => "20070822",
            "show_edit_icon" => true,
            "market_place" => "US",
            "title_font" => "Verdana",
            "template_id" => "8006",
            "title_font_size" => "13px",
            "theme_version" => "0",
            "title" => "Product Cloud Widget",
            "category" => "All",
            "height" => "280",
            "curved_corners" => false,
            "hover_background_color" => "#cc6600",
            "hover_text_color" => "#ffffff",
            "show_amazon_logo_as_text" => false,
            "show_title" => true,
            "cloud_text_color" => "#003399",
            "show_popovers" => true,
            "cloud_font" => "Verdana"
        );
    }

    /**
     * Available Fonts as identified by
     * 
     * @return array
     */
    public static function getAvailableFonts() {
        return array (
            "Verdana" => "Verdana",
            "Helvetica" => "Helvetica",
            "Georgia" => "Georgia",
            "MS Sans" => "MS Sans"
        );
    }

}