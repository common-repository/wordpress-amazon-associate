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
 * OfferSummary
 *
 * This file contains the class AmazonProduct_OfferSummary
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct OfferSummary Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>LowestNewPrice</li>
 *   <li>TotalNew</li>
 *   <li>TotalUsed</li>
 *   <li>TotalCollectible</li>
 *   <li>TotalRefurbished</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_OfferSummary extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "LowestNewPrice":
                    $this->set( $item->nodeName, new AmazonProduct_Price( $item ) );
                    break;
                default:
                    $this->processNode( $item );
                    break;
            }
        }
    }

}