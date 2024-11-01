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
 * AmazonProduct_Condition
 *
 * This file contains the class AmazonProduct_Condition
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Condition defines the Amazon supported condition types
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Condition implements AmazonProduct_iValidConstant {

    /**
     *  All
     */
    const ALL = "All";

    /**
     *  New
     */
    const _NEW = "New";

    /**
     *  Used
     */
    const USED = "Used";

    /**
     *  Collectible
     */
    const COLLECTIBLE = "Collectible";

    /**
     *  Refurbished
     */
    const REFURBISHED = "Refurbished";

    /**
     * is String a Valid Condition Constant
     *
     * @param obj value to test
     * @return boolean
     */
    public static function isValid( $obj ) {
        if ($obj == self::ALL || $obj == self::COLLECTIBLE ||
                $obj == self::REFURBISHED || $obj == self::USED ||
                $obj == self::_NEW
        ) {
            return true;
        } else {
            return false;
        }
    }

}