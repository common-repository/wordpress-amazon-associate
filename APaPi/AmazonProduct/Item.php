<?php
/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of AmazonProductAPI.
 *
 * AmazonProductAPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AmazonProductAPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AmazonProductAPI. If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Item
 *
 * This file contains the class AmazonProduct_Item
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct Item Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>Accessories</li>
 *   <li>AlternateVersions</li>
 *   <li>ASIN</li>
 *   <li>BrowseNodes</li>
 *   <li>Collections</li>
 *   <li>CustomerReviews</li>
 *   <li>DetailPageURL</li>
 *   <li>EditorialReviews</li>
 *   <li>ImageSets</li>
 *   <li>ItemAttributes</li>
 *   <li>ItemLinks</li>
 *   <li>LargeImage</li>
 *   <li>ListmaniaLists</li>
 *   <li>MediumImage</li>
 *   <li>OfferSummary</li>
 *   <li>Offers</li>
 *   <li>SalesRank</li>
 *   <li>SimilarProducts</li>
 *   <li>SmallImage</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Item extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "SmallImage":
                case "MediumImage":
                case "LargeImage":
                    $this->set( $item->nodeName, new AmazonProduct_Image( $item ) );
                    break;
                case "ImageSets":
                    $imageSets = array();
                    foreach( $item->childNodes as $imageSetNode ) {
                        $imageSets[] = new AmazonProduct_ImageSet( $imageSetNode );
                    }
                    $this->set( $item->nodeName, $imageSets );
                    break;
                case "Accessories":
                    $accessories = array();
                    foreach( $item->childNodes as $accessoryNode ) {
                        $accessories[] = new AmazonProduct_Accessory( $accessoryNode );
                    }
                    $this->set( $item->nodeName, $accessories );
                    break;
                case "AlternateVersions":
                    $alternateVersions = array();
                    foreach( $item->childNodes as $alternateVersionNode ) {
                        $alternateVersions[] = new AmazonProduct_AlternateVersion( $alternateVersionNode );
                    }
                    $this->set( $item->nodeName, $alternateVersions );
                    break;
                case "BrowseNodes":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_BrowseNode( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "Collections":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_Collection( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "EditorialReviews":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_EditorialReview( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "ItemLinks":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_ItemLink( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "ItemAttributes":
                    $this->set( $item->nodeName, new AmazonProduct_ItemAttributes( $item ) );
                    break;
                case "OfferSummary":
                    $this->set( $item->nodeName, new AmazonProduct_OfferSummary( $item ) );
                    break;
                case "Offers":
                    $this->set( $item->nodeName, new AmazonProduct_Offers( $item ) );
                    break;
                case "CustomerReviews":
                    $this->set( $item->nodeName, new AmazonProduct_CustomerReviews( $item ) );
                    break;
                case "SimilarProducts":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_SimilarProduct( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "ListmaniaLists":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_listmaniaList( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                default:
                    $this->processNode( $item );
                    break;
            }
        }
    }

}