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
 * ItemAttributes
 *
 * This file contains the class AmazonProduct_ItemAttributes
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct ItemAttributes Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>Author - String or Array</li>
 *   <li>Binding</li>
 *   <li>EAN</li>
 *   <li>ISBN</li>
 *   <li>IsEligibleForTradeIn</li>
 *   <li>Label</li>
 *   <li>Languages</li>
 *   <li>ListPrice</li>
 *   <li>Manufacturer</li>
 *   <li>NumberOfPages</li>
 *   <li>ProductGroup</li>
 *   <li>ProductTypeName</li>
 *   <li>PublicationDate</li>
 *   <li>Publisher</li>
 *   <li>ReadingLevel</li>
 *   <li>Studio</li>
 *   <li>Title</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_ItemAttributes extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "Languages":
                    $objects = array();
                    foreach( $item->childNodes as $childNode ) {
                        $objects[] = new AmazonProduct_Language( $childNode );
                    }
                    $this->set( $item->nodeName, $objects );
                    break;
                case "ListPrice":
                    $this->set( $item->nodeName, new AmazonProduct_Price( $item ) );
                    break;
                default:
                    $this->processNode( $item );
                    break;
            }
        }
    }

}