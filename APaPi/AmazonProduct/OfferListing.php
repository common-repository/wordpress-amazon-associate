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
 * OfferListing
 *
 * This file contains the class AmazonProduct_OfferListing
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct OfferListing Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>OfferListingId</li>
 *   <li>Price</li>
 *   <li>AmountSaved</li>
 *   <li>PercentageSaved</li>
 *   <li>Availability</li>
 *   <li>AvailabilityAttributes</li>
 *   <li>QuantityRestriction</li>
 *   <li>IsEligableForSuperSaverShipping</li>
 *   <li>IsFulfilledByAmazon</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_OfferListing extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "Price":
                case "AmountSaved":
                    $this->set( $item->nodeName, new AmazonProduct_Price( $item ) );
                    break;
                case "AvailabilityAttributes":
                    $this->set( $item->nodeName, new AmazonProduct_AvailabilityAttributes( $item ) );
                    break;
                case "QuantityRestriction":
                    $this->set( $item->nodeName, new AmazonProduct_QuantityRestriction( $item ) );
                    break;
                default:
                    $this->processNode( $item );
                    break;
            }
        }
    }

}