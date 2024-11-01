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
 * AmazonProduct_ResponseGroup
 *
 * This file contains the class AmazonProduct_ResponseGroup
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_ResponseGroup defines the result groups available
 * from the Amazon Product API
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_ResponseGroup {
    
    /**
     *  Accessories
     */
    const ACCESSORIES = "Accessories";

    /**
     *  AlternateVersions
     */
    const ALTERNATE_VERSIONS = "AlternateVersions";

    /**
     *  BroseNodeInfo
     */
    const BROWSE_NODE_INFO = "BrowseNodeInfo";

    /**
     *  BrowseNodes
     */
    const BROWSE_NODES = "BrowseNodes";

    /**
     *  Cart
     */
    const CART = "Cart";

    /**
     *  CartNewReleases
     */
    const CART_NEW_RELEASES = "CartNewReleases";

    /**
     *  CartTopSellers
     */
    const CART_TOP_SELLERS = "CartTopSellers";

    /**
     *  CartSimilarities
     */
    const CART_SIMILARITIES = "CartSimilarities";

    /**
     *  Collections
     */
    const COLLECTIONS = "Collections";

    /**
     *  EditorialReview
     */
    const EDITORIAL_REVIEW = "EditorialReview";

    /**
     *  Images
     */
    const IMAGES = "Images";

    /**
     *  ItemAttributes
     */
    const ITEM_ATTRIBUTES = "ItemAttributes";

    /**
     *  ItemIds
     */
    const ITEM_IDS = "ItemIds";

    /**
     *  Large
     */
    const LARGE = "Large";

    /**
     *  Medium
     */
    const MEDIUM = "Medium";

    /**
     *  MostGifted
     */
    const MOST_GIFTED = "MostGifted";

    /**
     *  MostWishedFor
     */
    const MOST_WISHED_FOR = "MostWishedFor";

    /**
     *  NewReleases
     */
    const NEW_RELEASES = "NewReleases";

    /**
     *  OfferFull
     */
    const OFFER_FULL = "OfferFull";

    /**
     *  OfferListings
     */
    const OFFER_LISTINGS = "OfferListings";

    /**
     *  Offers
     */
    const OFFERS = "Offers";

    /**
     *  OfferSummary
     */
    const OFFER_SUMMARY = "OfferSummary";

    /**
     *  PromotionSummary
     */
    const PROMOTION_SUMMARY = "PromotionSummary";

    /**
     *  RelatedItems
     */
    const RELATED_ITEMS = "RelatedItems";

    /**
     *  Request
     */
    const REQUEST = "Request";

    /**
     *  Reviews
     */
    const REVIEWS = "Reviews";

    /**
     *  SalesRank
     */
    const SALES_RANK = "SalesRank";

    /**
     *  SearchBins
     */
    const SEARCH_BINS = "SearchBins";

    /**
     *  Seller
     */
    const SELLER = "Seller";

    /**
     *  SellerListing
     */
    const SELLER_LISTING = "SellerListing";

    /**
     *  Similarities
     */
    const SIMILARITIES = "Similarities";

    /**
     *  Small
     */
    const SMALL = "Small";

    /**
     *  TopSellers
     */
    const TOP_SELLERS = "TopSellers";

    /**
     *  Tracks
     */
    const TRACKS = "Tracks";

    /**
     *  Variations
     */
    const VARIATIONS = "Variations";

    /**
     *  VariationImages
     */
    const VARIATION_IMAGES = "VariationImages";

    /**
     *  VariationMatrix
     */
    const VARIATION_MATRIX = "VariationMatrix";

    /**
     *  VariationOffers
     */
    const VARIATION_OFFERS = "VariationOffers";

    /**
     *  VariationSummary
     */
    const VARIATION_SUMMARY = "VariationSummary";

    /**
     * is String a Valid Response Group Constant
     *
     * @param obj value to test
     * @return boolean
     */
    public static function  isValid( $obj) {
        if( $obj == self::ACCESSORIES || $obj == self::ALTERNATE_VERSIONS ||
                $obj == self::BROWSE_NODES || $obj == self::BROWSE_NODE_INFO ||
                $obj == self::CART || $obj == self::CART_NEW_RELEASES ||
                $obj == self::CART_SIMILARITIES ||
                $obj == self::CART_TOP_SELLERS ||
                $obj == self::COLLECTIONS || $obj == self::EDITORIAL_REVIEW ||
                $obj == self::IMAGES || $obj == self::ITEM_ATTRIBUTES ||
                $obj == self::ITEM_IDS || $obj == self::LARGE ||
                $obj == self::MEDIUM || $obj == self::MOST_GIFTED ||
                $obj == self::MOST_WISHED_FOR || $obj == self::NEW_RELEASES ||
                $obj == self::OFFERS || $obj == self::OFFER_FULL ||
                $obj == self::OFFER_LISTINGS || $obj == self::OFFER_SUMMARY ||
                $obj == self::PROMOTION_SUMMARY ||
                $obj == self::RELATED_ITEMS ||
                $obj == self::REQUEST || $obj == self::REVIEWS ||
                $obj == self::SALES_RANK || $obj == self::SEARCH_BINS ||
                $obj == self::SELLER || $obj == self::SELLER_LISTING ||
                $obj == self::SIMILARITIES || $obj == self::SMALL ||
                $obj == self::TOP_SELLERS || $obj == self::TRACKS ||
                $obj == self::VARIATIONS || $obj == self::VARIATION_IMAGES ||
                $obj == self::VARIATION_MATRIX ||
                $obj == self::VARIATION_OFFERS ||
                $obj == self::VARIATION_SUMMARY
                ) {
            return true;
        } else {
            return false;
        }
    }

}
