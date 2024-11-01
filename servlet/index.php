<?php
/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Sofatware Foundation, either version 3 of the
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

// load WordPress
require_once( '../../../../wp-load.php');

// initialize APaPi library
$api = $wpaa->getAPI( $wpaa->getLocale() );

$result = null;
switch( $_REQUEST['Action'] ) {
    case "ValidateAccess":
        if( ! empty($_REQUEST['AccessKey']) && ! empty($_REQUEST['SecretKey'])) {
            $api->setAccessKey( $_REQUEST['AccessKey'] );
            $api->setSecretKey( $_REQUEST['SecretKey'] );
            $api->setLocale( $_REQUEST['Locale'] );
            switch( $_REQUEST['Locale'] ) {
                case 'US':
                    $result = $api->browseNodeLookup("1000");
                    break;
                case "UK":
                    $result = $api->browseNodeLookup("1025612");
                    break;
                case "CA":
                    $result = $api->browseNodeLookup("927726");
                    break;
                case "CN":
                    $result = $api->browseNodeLookup("658390051");
                    break;
                case "DE":
                    $result = $api->browseNodeLookup("541686");
                    break;
                case "ES":
                    $result = $api->browseNodeLookup("599364031");
                    break;
                case "FR":
                    $result = $api->browseNodeLookup("468256");
                    break;
                case "IT":
                    $result = $api->browseNodeLookup("411663031");
                    break;
                case "JP":
                    $result = $api->browseNodeLookup("465610");
                    break;
            }
        }
        break;
    case "ItemLookup":
        if( isset( $_REQUEST['Id'] ) ) {
            $type = "ASIN";
            if( isset( $_REQUEST['Type'] ) ) {
                $type = $_REQUEST['Type'];
            }
            if( isset( $_REQUEST['ResponseGroup'] ) ) {
                $result = $wpaa->getCacheHandler()->getProduct( $_REQUEST['Id'], $wpaa->getLocale(), $type, $_REQUEST['ResponseGroup']);
            } else {
                $result = $wpaa->getCacheHandler()->getProduct( $_REQUEST['Id'], $wpaa->getLocale(), $type);
            }
        }
        break;
    case "ItemSearch":
        $responseGroup = AmazonProduct_ResponseGroup::MEDIUM;
        $searchIndex = AmazonProduct_SearchIndex::ALL;
        $criteria = array();
        foreach($_REQUEST as $key=>$val) {
            switch($key ) {
                case "ResponseGroup":
                    $responseGroup = $val;
                    break;
                case "SearchIndex":
                    $searchIndex = $val;
                    break;
                case "Action":
                case "callback":
                case "Random":
                    break;
                default:
                    $criteria[$key] = $val;
                    break;
            }
        }
        $result = $api->search( $criteria, $searchIndex, $responseGroup );
        break;
    case "SimilarityLookup":
        if( isset( $_REQUEST['Id'] ) ) {
            $type = AmazonProduct_SimilarityType::INTERSECTION;
            if( isset( $_REQUEST['Type'] ) ) {
                $type = $_REQUEST['Type'];
            }
            $responseGroup = AmazonProduct_ResponseGroup::MEDIUM;
            if( isset( $_REQUEST['ResponseGroup'] ) ) {
                $responseGroup = $_REQUEST['ResponseGroup'];
            }
            $result = $api->similarityLookup( $_REQUEST['Id'], $responseGroup, $type );
        }
        break;
}

// json format result
$json = "";
if( is_null( $result ) ) {
    $json = '{ "IsValid" : "False", "Message" : "Invalid Request" }';
} else {
    $json = $result->toJSON();
}

//get callback
if( isset($_REQUEST['callback']) ) {
    //return jsonp
    echo $_REQUEST['callback'] . '(' . $json . ')';
} else {
    // return json
    echo $json;
}