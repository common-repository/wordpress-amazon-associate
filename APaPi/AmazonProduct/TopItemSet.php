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
 * TopItemSet
 *
 * This file contains the class AmazonProduct_TopItemSet
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_TopItemSet defines the TopItemSet object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>Type</li>
 *   <li>Items</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_TopItemSet extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        $objects = array();
        foreach ( $node->childNodes as $item ) {
            if( $item->nodeName == "TopItem" ) {
                $objects[] = new AmazonProduct_Item( $item );
            } else {
                $this->processNode( $item );
            }
        }
        $this->set( "Items", $objects );
    }

}