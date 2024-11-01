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
 * AmazonProduct_Operation
 *
 * This file contains the class AmazonProduct_Operation
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Operation defines the Amazon Operations
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Operation implements AmazonProduct_iValidConstant {

    /**
     *  BrowseNodeLookup
     */
    const BROWSE_NODE_LOOKUP = "BrowseNodeLookup";

    /**
     *  CartAdd
     */
    const CART_ADD = "CartAdd";

    /**
     *  CartClear
     */
    const CART_CLEAR = "CartClear";

    /**
     *  CartCreate
     */
    const CART_CREATE = "CartCreate";

    /**
     *  CartGet
     */
    const CART_GET = "CartGet";

    /**
     *  CartModify
     */
    const CART_MODIFY = "CartModify";

    /**
     *  ItemLookup
     */
    const ITEM_LOOKUP = "ItemLookup";

    /**
     *  ItemSearch
     */
    const ITEM_SEARCH =  "ItemSearch";

    /**
     *  SellerListingLookup
     */
    const SELLER_LISTING_LOOKUP = "SellerListingLookup";

    /**
     *  SellerListingSearch
     */
    const SELLER_LISTING_SEARCH = "SellerListingSearch";

    /**
     *  SellerLookup
     */
    const SELLER_LOOKUP = "SellerLookup";

    /**
     *  SimilarityLookup
     */
    const SIMILARITY_LOOKUP = "SimilarityLookup";

    /**
     * is String a Valid Operation Constant
     *
     * @param obj value to test
     * @return boolean
     */
    public static function  isValid( $obj) {
        if( $obj == self::BROWSE_NODE_LOOKUP || $obj == self::CART_ADD ||
                $obj == self::CART_CLEAR || $obj == self::CART_CREATE ||
                $obj == self::CART_GET || $obj == self::CART_MODIFY ||
                $obj == self::ITEM_LOOKUP || $obj == self::ITEM_SEARCH ||
                $obj == self::SELLER_LISTING_LOOKUP ||
                $obj == self::SELLER_LISTING_SEARCH ||
                $obj == self::SELLER_LOOKUP || $obj == self::SIMILARITY_LOOKUP
                ) {
            return true;
        } else {
            return false;
        }
    }

}