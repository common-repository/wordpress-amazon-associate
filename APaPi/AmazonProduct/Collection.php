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
 * Collection
 *
 * This file contains the class AmazonProduct_Collection
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Collection defines the Collection object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>CollectionParent</li>
 *   <li>Items</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Collection extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        $this->set( "Items", array() );
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "CollectionParent":
                    $this->set( $item->nodeName, new AmazonProduct_CollectionItem( $item ) );
                    break;
                case "CollectionItem":
                    $objects = $this->Items;
                    $objects[] = new AmazonProduct_CollectionItem( $item );;
                    $this->set( "Items", $objects );
                    break;
                default:
                    $this->processNode( $node );
                    break;
            }
        }
    }

}