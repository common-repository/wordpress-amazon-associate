<?php
/*
 * copyright (c) 2011 MDBitz - Matthew John Denton - mdbitz.com
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
 * WPAA_URIHandler
 *
 * This file contains the class WPAA_URIHandler
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * URI Handler Class for WordPress Amazon Associate plugin
 *
 * Contains all Amazon URLs utilized in plugin
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class WPAA_URIHandler {

   /**
     * Resource Content URI
     * @param String $locale
     * @return String Remote Comtent URI
     */
    public static function getRemoteContentURI( $locale ) {
        switch( $locale ) {
            case "UK":
                return "http://rcm-uk.amazon.co.uk/e/cm";
                break;
            case "DE":
                return "http://rcm-de.amazon.de/e/cm";
                break;
            case "ES":
                return "http://rcm-es.amazon.es/e/cm";
                break;
            case "FR":
                return "http://rcm-fr.amazon.fr/e/cm";
                break;
            case "JP":
                return "http://rcm-jp.amazon.co.jp/e/cm";
                break;
            case "CA":
                return "http://rcm-ca.amazon.ca/e/cm";
                break;
            case "CN":
                return "http://rcm-cn.amazon.cn/e/cm";
                break;
            case "IT":
                return "http://rcm-it.amazon.it/e/cm";
                break;
            case "US":
            default:
                return "http://rcm.amazon.com/e/cm";
                break;
        }
    }

    /**
     * return Locale Domains
     *
     * @return array
     */
    public static function getDomain($locale) {
        switch( $locale ) {
            case "CA":
                return "ca";
            break;
            case "DE":
                return "de";
            break;
            case "FR":
                return "fr";
            break;
            case "JP":
                return "jp";
            break;
            case "UK":
                return "co.uk";
            break;
            default:
                return "com";
            break;
        };
    }

}