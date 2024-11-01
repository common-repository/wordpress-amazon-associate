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
 * Image
 *
 * This file contains the class AmazonProduct_Image
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_Image defines the Image object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>URL</li>
 *   <li>Height</li>
 *   <li>Width</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_Image extends AmazonProduct_Abstract {

    public function toHTML() {
        $html_txt = "<img ";
        foreach( $this->_values as $key => $value ) {
            if( $key == "URL" ) {
                $html_txt .= 'src="' . $value . '" ';
            } else {
                $html_txt .= strtolower( $key ) . '="' . $value . '" ';
            }
        }
        $html_txt .= "/>";
        return $html_txt;
    }
}