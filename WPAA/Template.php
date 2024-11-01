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
 * Content Template
 *
 * This file contains the class WPAA_Template
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.WPAA
 */

/**
 * WPAA_Template contains logic for rendering templates
 *
 * @package com.mdbitz.wordpress.amazon_associate.WPAA
 */
class WPAA_Template {

    /**
     * Install Template DB Tables
     */
    public static function install() {
        global $wpdb;
        $sql = "CREATE TABLE IF NOT EXISTS `". $wpdb->prefix . "wpaa_template` (`ID` int(11) NOT NULL AUTO_INCREMENT, `NAME` varchar(100) NOT NULL, `TYPE_ID` int(11) NOT NULL, `CONTENT` text, `DESCRIPTION` text, `CSS` text, `ACTIVE` TINYINT( 1 ) NOT NULL DEFAULT '1', PRIMARY KEY (`ID`) );";
        if( FALSE !== $wpdb->query($sql) ) {
            $isql = "INSERT INTO `wp_wpaa_template` (`NAME`, `TYPE_ID`, `CONTENT`, `DESCRIPTION`, `CSS`, `ACTIVE`) VALUES " .
"('Product Summary', 0, '<div class=\"wpaa_product\">\r\n    <div class=\"wpaa_product_title\">\r\n        <a href=\"%URL%\" target=\"_BLANK\">%TITLE%</a>\r\n    </div>\r\n    <div class=\"wpaa_product_title\">%DESC_SHORT%<br /><a href=\"%URL%\" target=\"_BLANK\">Read More</a></div>\r\n    <div class=\"wpaa_product_image\">\r\n        <img src=\"%IMAGE%\" />\r\n    </div>\r\n</div>', 'Basic Product Summary ', '.wpaa_product {\r\n  border: solid black thick;\r\n}', 0),".
"('Basic Ad', 0, '<div style=\"text-align:center;\">\r\n<a target=\"_BLANK\" href=\"%URL%\">%TITLE%</a><br />\r\n<a target=\"_BLANK\" href=\"%URL%\"><img src=\"%IMAGE%\" /></a></div>', 'Basic Ad displaying Product title, image and on click links to product in new window. ', '', 1),".
"('Buy Now', 0, '<form target=\"_blank\" method=\"post\" action=\"http://www.amazon.com/gp/aws/cart/add.html\">\r\n<input type=\"hidden\" value=\"%TAG%\" name=\"AssociateTag\">\r\n<input type=\"hidden\" value=\"%ASIN%\" name=\"ASIN.1\">\r\n<input type=\"hidden\" value=\"1\" name=\"Quantity.1\">\r\n<input width=\"161\" type=\"image\" height=\"27\" border=\"0\" src=\"http://g-ecx.images-amazon.com/images/G/01/associates/buttons/buy-button-assoc-lg._V192587358_.gif\">\r\n</form>', 'Buy Now Button', '', 1),".
"('Book Ad', 0, '<div class=\"wpaa_product\">\r\n<table>\r\n<tr>\r\n<td class=\"productImage\">\r\n	<a target=\"_blank\" href=\"%URL%\"><img src=\"%SMALL_IMAGE%\"></a>\r\n</td>\r\n<td class=\"productInfo\">\r\n<div id=\"productInfo\">\r\n<p class=\"title\"><a id=\"productTitle\" target=\"_blank\" href=\"%URL%\" style=\"visibility: visible;\">%TITLE%</a></p>\r\n<p id=\"author\" style=\"visibility: visible;\">by %AUTHOR%</p>\r\n<p class=\"priceBlock\">\r\n	<strong>Price: </strong><span class=\"price\"><b>%PRICE%</b></span>\r\n</p>\r\n</div>\r\n<div class=\"addToCart\">\r\n<form target=\"_blank\" method=\"post\" action=\"http://www.amazon.com/gp/aws/cart/add.html\">\r\n<input type=\"hidden\" value=\"%TAG%\" name=\"AssociateTag\">\r\n<input type=\"hidden\" value=\"%ASIN%\" name=\"ASIN.1\">\r\n<input type=\"hidden\" value=\"1\" name=\"Quantity.1\">\r\n<input width=\"161\" type=\"image\" height=\"27\" border=\"0\" src=\"http://g-ecx.images-amazon.com/images/G/01/associates/buttons/buy-button-assoc-lg._V192587358_.gif\">\r\n</form>\r\n</div>\r\n</td>\r\n</tr></table>\r\n</div>', 'Book Product Display', '\r\n.wpaa_product {\r\n    height: 124px;\r\n    position: relative;\r\n    width: 400px;\r\n}\r\n\r\n.wpaa_product .productImage {\r\n    text-align: center;\r\n    vertical-align: top;\r\n    width: 90px;\r\n}\r\n\r\n.wpaa_product .productInfo {\r\n    vertical-align: top;\r\n    background-color: #FFFFFF;\r\n    color: #000000;\r\n    font-family: ''Verdana'',sans-serif;\r\n    font-size: 11px;\r\n    line-height: 14px;\r\n    padding: 0;\r\n    width: 310px;\r\n}\r\n\r\n.wpaa_product .productInfo p.title {\r\n    font-weight: bold;\r\n    margin: 0;\r\n}\r\n\r\n.wpaa_product .productInfo p {\r\n    margin: 1px;\r\n}', 1),".
"('Book Summary', 0, '<div class=\"wpaa_product\">\r\n<table>\r\n<tr>\r\n<td class=\"productImage\">\r\n	<a target=\"_blank\" href=\"%URL%\"><img src=\"%SMALL_IMAGE%\"></a>\r\n</td>\r\n<td class=\"productInfo\">\r\n<div id=\"productInfo\">\r\n<p class=\"title\"><a id=\"productTitle\" target=\"_blank\" href=\"%URL%\" style=\"visibility: visible;\">%TITLE%</a></p>\r\n<p id=\"author\" style=\"visibility: visible;\">by %AUTHOR%</p>\r\n<p class=\"priceBlock\">\r\n	<strong>Price: </strong><span class=\"price\"><b>%PRICE%</b></span>\r\n</p>\r\n<p class=\"summary\">%DESC_SHORT%</p>\r\n<p class=\"readMore\">\r\n	<a target=\"_blank\" href=\"%URL%\">Read More...</a>\r\n</p>\r\n</div>\r\n<div class=\"addToCart\">\r\n<form target=\"_blank\" method=\"post\" action=\"http://www.amazon.com/gp/aws/cart/add.html\">\r\n<input type=\"hidden\" value=\"%TAG%\" name=\"AssociateTag\">\r\n<input type=\"hidden\" value=\"%ASIN%\" name=\"ASIN.1\">\r\n<input type=\"hidden\" value=\"1\" name=\"Quantity.1\">\r\n<input width=\"161\" type=\"image\" height=\"27\" border=\"0\" src=\"http://g-ecx.images-amazon.com/images/G/01/associates/buttons/buy-button-assoc-lg._V192587358_.gif\">\r\n</form>\r\n</div>\r\n</td>\r\n</tr></table>\r\n</div>', 'Book Product Summary', '\r\n.wpaa_product {\r\n    height: 124px;\r\n    position: relative;\r\n    width: 400px;\r\n}\r\n\r\n.wpaa_product .productImage {\r\n    text-align: center;\r\n    vertical-align: top;\r\n    width: 90px;\r\n}\r\n\r\n.wpaa_product .productInfo {\r\n    vertical-align: top;\r\n    background-color: #FFFFFF;\r\n    color: #000000;\r\n    font-family: ''Verdana'',sans-serif;\r\n    font-size: 11px;\r\n    line-height: 14px;\r\n    padding: 0;\r\n    width: 310px;\r\n}\r\n\r\n.wpaa_product .productInfo p.title {\r\n    font-weight: bold;\r\n    margin: 0;\r\n}\r\n\r\n.wpaa_product .productInfo p {\r\n    margin: 1px;\r\n}', 1);";
            $wpdb->query( $isql);
        }

    }

    public static function getTypeOptions( ) {
        return array(
            "ASIN" => "ASIN",
            "ASIN List" => "Random from comma seperated ASINs"
        );
    }

    public static function preview( $template, $asin ) {
        $options =  array( 'content'=>null, 'template'=>null,
                'locale'=> null, 'type' => 'ASIN', 'target' => '_blank',
                'rel' => "nofollow", 'container' => null, 'container_class' => null,
                'container_style' => null, 'id' => $asin, 'echo' => true );
        echo WPAA_Template::doHTML( $template, $options, "Error in Template" );
    }

    /**
     * Output WPAA Template
     *
     * @global WPAA $wpaa
     * @param Array $options
     */
    public static function toHTML( $options ) {
        // set Default Values
        $options = shortcode_atts( array( 'content'=>null, 'template'=>null,
                'locale'=> null, 'type' => 'ASIN', 'target' => '_blank',
                'rel' => "nofollow", 'container' => null, 'container_class' => null,
                'container_style' => null, 'id' => null, 'echo' => true ),
                $options );

        // Generate HTML
        $output_str = $options['content'];
        // validate template id or name is set
        if ( !is_null($options['template']) ) {
            $template = WPAA_Template::getTemplateMix( $options['template'] );
            $output_str = WPAA_Template::doHTML( $template, $options, $output_str );
        }


        // Generate Response
        if( $options['echo'] ) {
            echo WPAA_ShortCodeHandler::doStyle($options, $output_str );
        } else {
            return WPAA_ShortCodeHandler::doStyle( $options, $output_str );
        }
    }

    private static function doHTML( $template, $options, $output_str ) {
        global $wpaa;
        // Process Types
        if( $options['type'] == "ASIN List" ) {
            $ids = explode( ',', $options['id'] );
            $options['id'] = trim(array_rand(array_flip($ids), 1)); // flip so returns value
            $options['type'] = 'ASIN';
        }

        if( ! is_null( $options['id'] ) ) {
            // Get Product
            $result = $wpaa->getCacheHandler()->getProduct( $options['id'], $options['locale'], $options['type'], array( 'ItemAttributes','EditorialReview','Images') );
            // Process
            if ($result->isSuccess() && isset($result->Items[0])) {
                $tag = $wpaa->getAssociateId( $options['locale'] );
                $output_str = WPAA_Template::process( $template, $result->Items[0], $tag );
            }

            // Add CSS Styles
            if( $template->CSS != null && trim($template->CSS) != '' ){
                $output_str = '<style type="text/css">' . $template->CSS . '</style>' . $output_str;
            }
        }
        return $output_str;
    }

    /**
     * Delete Specified Templates from the System
     */
    public static function deleteTemplates( $ids ) {
        global $wpdb;
        return $wpdb->query(
			"DELETE FROM `" . $wpdb->prefix . "wpaa_template` WHERE ID IN (" . implode(", ", $ids) . ");"
        );
    }

    /**
     * Delete Specified Template from System
     */
    public static function deleteTemplate( $id ) {
        global $wpdb;
        return $wpdb->query(
                $wpdb->prepare(  "DELETE FROM `" . $wpdb->prefix . "wpaa_template` WHERE ID = %d", $id)
        );
    }

    /**
     * Enable specified Templates
     */
    public static function enableTemplates( $ids ) {
        global $wpdb;
        return $wpdb->query(
			"UPDATE `" . $wpdb->prefix . "wpaa_template` SET ACTIVE = 1 WHERE ID IN (" . implode(", ", $ids) . ");"
        );
    }

    /**
     * Enable Specified Template
     */
    public static function enableTemplate( $id ) {
        global $wpdb;
        return $wpdb->update( $wpdb->prefix . "wpaa_template",
                array( 'ACTIVE' => 1 ),
                array( 'ID' => $id )
        );
    }

    /**
     * Disable specified Templates
     */
    public static function disableTemplates( $ids ) {
        global $wpdb;
        return $wpdb->query( "UPDATE `" . $wpdb->prefix . "wpaa_template` SET ACTIVE = 0 WHERE ID IN (" . implode(", ", $ids) . ");" );
    }

    /**
     * Disable Specified Template
     */
    public static function disableTemplate( $id ) {
        global $wpdb;
        return $wpdb->update( $wpdb->prefix . "wpaa_template",
                array( 'ACTIVE' => 0 ),
                array( 'ID' => $id )
        );
    }

    /**
     * Add/Edit Template to system
     */
    public static function modifyTemplate( $template ) {
        global $wpdb;
        $sql = '';
        $payload = array(
                'NAME' => stripslashes($template['NAME']),
                'DESCRIPTION' => stripslashes($template['DESCRIPTION']),
                'CONTENT' => stripslashes($template['CONTENT']),
                'CSS' => stripslashes($template['CSS']),
                'ACTIVE' => $template['ACTIVE'],
                'TYPE_ID' => $template['TYPE']
        );
        // Edit
        if( isset( $template['ID'] ) ) {
            return $wpdb->update( $wpdb->prefix . "wpaa_template",
                    $payload,
                    array( 'ID' => $template['ID'] )
            );
        }
        // Add
        else {
            return $wpdb->insert( $wpdb->prefix . "wpaa_template",
                    $payload
            );
        }

    }

    /**
     * Get Templates with defined Order
     */
    public static function getTemplates( $orderBy = null, $order = null ) {
        global $wpdb;
        $sql = '';
        if( $orderBy == null ) {
            $sql = "Select ID, NAME, ACTIVE, DESCRIPTION FROM `" . $wpdb->prefix . "wpaa_template`;";
        } else {
            $sql = "Select ID, NAME, ACTIVE, DESCRIPTION FROM `" . $wpdb->prefix . "wpaa_template` order by " . $orderBy . " " . $order . ";";
        }
        return $wpdb->get_results($sql, 'ARRAY_A');
    }

    /**
     * Get Active Templates
     */
    public static function getActiveTemplates( ) {
        global $wpdb;
        $sql = "Select ID, NAME, DESCRIPTION FROM `" . $wpdb->prefix . "wpaa_template` WHERE ACTIVE = 1 order by NAME ASC ;";
        return $wpdb->get_results($sql, 'ARRAY_A');
    }
    
    /**
     * Get Template by ID
     */
    public static function getTemplate( $id ) {
        global $wpdb;
        $sql = $wpdb->prepare( "Select * FROM `" . $wpdb->prefix . "wpaa_template` WHERE ID=%d;", $id );
        $result = $wpdb->get_row( $sql );
        return $result;
    }

    /**
     * is Template defined in system
     *
     * @global <type> $wpdb
     * @param <type> $name
     * @return <type>
     */
    public static function templateExist( $name ) {
        global $wpdb;
        $sql = $wpdb->prepare( "Select ID FROM `" . $wpdb->prefix . "wpaa_template` WHERE NAME='%s';", $name );
        $result = $wpdb->get_row( $sql );
        if( $result == null ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get Template by ID or NAME
     */
    public static function getTemplateMix( $id_name ) {
        global $wpdb;
        //lookup template
        $sql = $wpdb->prepare( "Select * FROM `" . $wpdb->prefix . "wpaa_template` WHERE ACTIVE = 1 AND (ID='%s' OR  NAME='%s');", $id_name, $id_name );
        $result = $wpdb->get_row( $sql );
        return $result;
    }

    /**
     * Process Template for given Product
     *
     * @param Object $template Template
     * @param AmazonProduct_Item $product Amazon Product
     */
    public static function process( $template, $product, $tag ) {
        $output = $template->CONTENT;
        $dw = new WPAA_Template_DataWrapper( $product, $tag );
        $output = WPAA_Template::processStatements($output, $dw);
        $output = WPAA_Template::processTags($output, $dw);
        return $output;
    }

    /**
     * Process Statements
     *
     * @param String $output
     * @param WPAA_Template_DataWrapper $dw Data Wrapper
     */
    public static function processStatements( $output, $dw ) {
        // To be done as phase 2 of Templates
        return $output;
    }

    /**
     * Process Tags
     *
     * @param String $output
     * @param WPAA_Template_DataWrapper $dw Data Wrapper
     */
    public static function processTags( $output, $dw ) {
        // Identify All Template Tags Used
        preg_match_all('[%(?P<TAG>.*?)%]', $output, $matches, PREG_PATTERN_ORDER);
        // Clean for Unique Tags
        $tags = array_unique( $matches['TAG'] );
        // Iterate through Tags
        foreach( $tags as $tag ) {
            // Replace Tag with data
            $output = str_replace( '%' . $tag . '%', $dw->getTagValue($tag), $output );
        }
        return $output;
    }

} // class WPAA_Template