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
 * BrowseNode
 *
 * This file contains the class AmazonProduct_BrowseNode
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_BrowseNode defines the BrowseNode object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>BrowseNodeId</li>
 *   <li>Name</li>
 *   <li>Ancestors</li>
 *   <li>Children</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_BrowseNode extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "Ancestors":
                case "Children":
                    $objects = array();
                    foreach( $item->childNodes as $browseNode ) {
                        $objects[] = new AmazonProduct_BrowseNode( $browseNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "TopSellers":
                    $objects = array();
                    foreach( $item->childNodes as $itemNode ) {
                        $objects[] = new AmazonProduct_Item( $itemNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "TopItemSet":
                    $set = new AmazonProduct_TopItemSet( $item );
                    $this->set( $set->Type, $set  );
                    break;
                default:
                    $this->processNode( $item );
                    break;
            }
        }
    }

}