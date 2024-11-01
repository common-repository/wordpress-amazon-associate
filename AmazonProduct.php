<?php

/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * WordPress Amazon Associate is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress Amazon Associate.
 * If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Amazon Product
 *
 * This file contains the class AmazonProduct
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * AmazonProduct is a utility class to easily ouput Amazon Products
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class AmazonProduct {

    /**
     * Ouput Amazon Product Link
     * 
     * @global WPAA $wpaa
     *
     * @param string $content Link Text
     * @param string $id Product Id
     * @param string $locale Locale
     * @param string $type Id Type
     * @param string $target link target
     */
    public static function link( $options ) {
        global $wpaa;
        // set Default Values
        $options = shortcode_atts( array( 'content'=>null, 'id'=>null,
            'locale'=> null, 'type' => 'ASIN', 'target' => '_blank',
            'rel' => "nofollow", 'container' => null, 'container_class' => null,
            'container_style' => null, 'title' => null, 'echo' => true ),
            $options );
        // Generate Link
        $output_str = $options['content'];
        if (!is_null($options['id'])) {
            $result = $wpaa->getCacheHandler()->getProduct( $options['id'], $options['locale'], $options['type'] );
            if ($result->isSuccess() && isset($result->Items[0])) {
                $output_str = '<a href="' . urldecode($result->Items[0]->DetailPageURL) . '" target="' . $options['target'] . '" rel="' . $options['rel'] . '" title="' . (is_null($options['title']) ? '' : $options['title']) . '" >' . $options['content'] . '</a>';
            }
        }
        // Generate Response
        if( $options['echo'] ) {
            echo WPAA_ShortCodeHandler::doStyle($options, $output_str );
        } else {
            return WPAA_ShortCodeHandler::doStyle( $options, $output_str );
        }
    }

    /**
     * Ouput Amazon Product Image
     *
     * @global WPAA $wpaa
     *
     * @param string $content Link Text
     * @param string $id Product Id
     * @param string $size Image Size
     * @param boolean $link Should Image be a Link
     * @param locale $locale Locale
     * @param string $type Id Type
     * @param string $target link target
     */
    public static function image($options ) {
        global $wpaa;
        // set default values
        $options = shortcode_atts( array( 'content' => null, 'id'=>null,
            'locale'=>null, 'size'=>'medium', 'type' => 'ASIN', 'link' => false,
            'target' => '_blank', 'rel' => "nofollow", 'class'=> null,
            'container'=>null, 'container_class' => null,
            'container_style' => null, 'alt' => null, 'title' => null, 
            'echo' => true ), $options );
        // Genrate Image
        $output_str = $options['content'];
        if (!is_null($options['id'])) {
            $response_group = AmazonProduct_ResponseGroup::ITEM_ATTRIBUTES ."," . AmazonProduct_ResponseGroup::IMAGES;
            $result = $wpaa->getCacheHandler()->getProduct( $options['id'], $options['locale'], $options['type'], $response_group );
            if ($result->isSuccess() && isset($result->Items[0])) {
                $options['size'] = strtolower($options['size']);
                $image = null;
                switch ($options['size']) {
                    case "small":
                        $image = $result->Items[0]->SmallImage;
                        break;
                    case "large":
                        $image = $result->Items[0]->LargeImage;
                        break;
                    default :
                        $image = $result->Items[0]->MediumImage;
                        break;
                }
                if( ! is_null($image) ) {
                    if( ! is_null($options['class']) ) {
                        $image->set( "class", $options['class'] );
                    }
                    if( ! is_null($options['rel']) ) {
                        $image->set( "rel", $options['rel'] );
                    }
                    if( ! is_null($options['title']) ) {
                        $image->set("title", $options['title'] );
                    } else {
                        $image->set("title", $options['content'] );
                    }
                    if( ! is_null($options['alt']) ) {
                        $image->set("alt", $options['alt'] );
                    }
                }
                $output_str = '';
                if ($options['link']) {
                    $output_str = '<a href="' . urldecode($result->Items[0]->DetailPageURL) . '" target="' . $options['target'] . '">';
                }
                if (!is_null($image)) {
                    $output_str .= $image->toHTML();
                } else {
                    $output_str .= $options['content'];
                }
                if ($options['link']) {
                    $output_str .= '</a>';
                }
            }
        }
        // Generate Response
        if( $options['echo'] ) {
            echo WPAA_ShortCodeHandler::doStyle($options, $output_str );
        } else {
            return WPAA_ShortCodeHandler::doStyle( $options, $output_str );
        }
    }
    
    /**
     * Ouput Amazon Product Enhanced Link
     * 
     * @global WPAA $wpaa
     *
     * @param string $id Product Id
     * @param string $locale Locale
     */
    public static function enhanced($options ) {
        global $wpaa;
        // set defaults
        $options = shortcode_atts( array( 'content' => null, 'asin' => null,
            'locale' => null, 'new_window' => true, 'show_border' => true,
            'larger_image' => true, 'price' => "All",
            'background_color' => "FFFFFF", 'text_color' => "000000",
            'link_color' => "0000FF", 'container' => null,
            'container_class' => null, 'container_style' => null,
            'echo' => true), $options );

        $outputStr = '<iframe src="';
        // get Locale
        $locale = $wpaa->getGeoLocale( $options['locale'] );
        //validate Product Exists
        if( ! $wpaa->getCacheHandler()->productExists( $options['asin'], $locale ) ) {
            $locale = $wpaa->getLocale();
        }

        // Append service url
        $outputStr .= WPAA_URIHandler::getRemoteContentURI( $locale ) . '?';
        // Append Link Target
        if( $options['new_window'] === true ) {
            $outputStr .= 'lt1=_blank&';
        } else {
            $outputStr .= 'lt1=_top&';
        }
        // Append Show Border
        if( $options['show_border'] === true ) {
            $outputStr .= 'bc1=000000&';
        } else {
            $outputStr .= 'bc1=FFFFFF&';
        }
        // Append Image Size
        if( $options['larger_image'] === true ) {
            $outputStr .= 'IS2=1&';
        } else {
            $outputStr .= 'IS1=1&';
        }
        // Append Pricing Options
        if( $options['price'] == "New" ) {
            $outputStr .= 'nou=1&';
        } else if ( $options['price'] == "Hide" ) {
            $outputStr .= 'npa=1&';
        }
        // Append Style Options
        $outputStr .= 'bg1=' . $options['background_color'] . '&';
        $outputStr .= 'fc1=' . $options['text_color'] . '&';
        $outputStr .= 'lc1=' . $options['link_color'] . '&';
        // Append Associate Tag
        global $post;
        $author_id = null;
        if( !is_null( $post ) && isset( $post->post_author ) ) {
            $author_id = $post->post_author;
        }
        $outputStr .= 't=' . $wpaa->getAssociateId( $locale, $author_id ) . '&';
        // Append Miscellaneous
        $outputStr .= 'o=' . $wpaa->locale_o[ $locale ] . '&';
        $outputStr .= 'p=8&l=as1&m=amazon&f=ifr&';
        // Append ASIN ID
        $outputStr .= 'asins=' . $options['asin'];
        // Close IFrame
        $outputStr .= '" style="width:120px;height:240px;" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>';

        // Generate Response
        if( $options['echo'] ) {
            echo WPAA_ShortCodeHandler::doStyle($options, $outputStr );
        } else {
            return WPAA_ShortCodeHandler::doStyle( $options, $outputStr );
        }
    }
    
}
