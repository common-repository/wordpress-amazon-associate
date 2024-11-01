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
 * ImageSet
 *
 * This file contains the class AmazonProduct_ImageSet
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.amazon.product
 */

/**
 * AmazonProduct_ImageSet defines the ImageSet object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>Category</li>
 *   <li>SwatchImage</li>
 *   <li>SmallImage</li>
 *   <li>ThumbnailImage</li>
 *   <li>TinyImage</li>
 *   <li>MediumImage</li>
 *   <li>LargeImage</li>
 * </ul>
 *
 * @package com.mdbitz.amazon.product
 */
class AmazonProduct_ImageSet extends AmazonProduct_Abstract {

    /**
     * parse Object from XML
     *
     * @param XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML( $node ) {
        //process Attributes
        foreach( $node->attributes as $attrName => $attrNode ) {
            $this->set( $attrName, $attrNode->nodeValue );
        }
        //process Images
        foreach ( $node->childNodes as $item ) {
            if( $item->nodeName != "#text" ) {
                $this->set( $item->nodeName, new AmazonProduct_Image( $item ) );
            }
        }
    }

}