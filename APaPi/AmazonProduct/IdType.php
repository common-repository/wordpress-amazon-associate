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
 * AmazonProduct_IdType
 *
 * This file contains the class AmazonProduct_IdType
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_IdType defines the Amazon ID types
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_IdType implements AmazonProduct_iValidConstant {

    /**
     *  ASIN
     */
    const ASIN = "ASIN";

    /**
     *  EAN
     */
    const EAN = "EAN";

    /**
     *  ISBN
     */
    const ISBN = "ISBN";

    /**
     *  SKU
     */
    const SKU = "SKU";

    /**
     *  UPC
     */
    const UPC = "UPC";

    /**
     * is String a Valid Id Type Constant
     *
     * @param obj value to test
     * @return boolean
     */
    public static function isValid($obj) {
        if ($obj == self::ASIN || $obj == self::EAN ||
                $obj == self::ISBN || $obj == self::SKU ||
                $obj == self::UPC
        ) {
            return true;
        } else {
            return false;
        }
    }

}