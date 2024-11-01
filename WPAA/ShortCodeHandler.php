<?php
/*
 * copyright (c) 2010,2011,2012 MDBitz - Matthew John Denton - mdbitz.com
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
 * WPAA_ShortCodeHandler
 *
 * This file contains the class WPAA_ShortCodeHandler
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

/**
 * Short Code Handler Class for WordPress Amazon Associate plugin
 *
 * @package com.mdbitz.wordpress.amazon_associate
 */
class WPAA_ShortCodeHandler {

    /**
     * Constructor
     */
    function __construct( $mappings = null) {
        add_shortcode('amazon_link', array(&$this,'amazonLinkHandler'));
        add_shortcode('amazon_image', array(&$this,'amazonImageHandler'));
        add_shortcode('amazon_enhanced', array(&$this,'amazonEnhancedHandler'));
        add_shortcode('amazon_banner', array(&$this,'amazonBannerHandler'));
        add_shortcode('amazon_carousel', array(&$this,'amazonCarouselHandler'));
        add_shortcode('amazon_mp3_clips', array(&$this,'amazonMP3ClipsHandler'));
        add_shortcode('amazon_my_favorites', array(&$this,'amazonMyFavoritesHandler'));
        add_shortcode('amazon_search', array(&$this,'amazonSearchHandler'));
        add_shortcode('amazon_omakase', array(&$this,'amazonOmakaseHandler'));
        add_shortcode('amazon_product_cloud', array(&$this,'amazonProductCloudHandler'));
        add_shortcode('amazon_template', array(&$this,'amazonTemplateHandler'));
        if( $mappings != null ) {
            foreach( $mappings as $mapping) {
                foreach( $mapping as $name => $function ) {
                    add_shortcode( $name, array(&$this,$function));
                }
            }
        }
    }

    /**
     * Amazon Template Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonTemplateHandler( $atts, $content=null, $code="" ) {
        $atts['content'] = $content;
        $atts['echo'] = false;
        return WPAA_Template::toHTML( $atts );
    }

    /**
     * Amazon Link Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonLinkHandler( $atts, $content=null, $code="" ) {
        global $wpaa;
        $atts['content'] = $content;
        $atts['echo'] = false;
        return AmazonProduct::link( $atts );
    }

    /**
     * Amazon Image Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonImageHandler( $atts, $content=null, $code="" ) {
        global $wpaa;
        $atts['content'] = $content;
        $atts['echo'] = false;
        return AmazonProduct::image($atts);
    }

    /**
     * Amazon Enhanced Link Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonEnhancedHandler( $atts, $content=null, $code="" ) {
        global $wpaa;
        $atts['content'] = $content;
        $atts['echo'] = false;
        return AmazonProduct::enhanced( $atts );
    }

    /**
     * Amazon Banner Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonBannerHandler( $atts, $content=null, $code="" ) {
        $banner = AmazonBanner::Banner( $atts );
        if( empty( $banner ) ) {
            return $content;
        } else {
            return $banner;
        }
    }

    /**
     * Amazon Carousel Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonCarouselHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_Carousel( $this->mergeWidgetOptions( AmazonWidget_Carousel::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Amazon MP3 Clips Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonMP3ClipsHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_MP3Clips( $this->mergeWidgetOptions( AmazonWidget_MP3Clips::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Amazon My Favorites Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonMyFavoritesHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_MyFavorites( $this->mergeWidgetOptions( AmazonWidget_MyFavorites::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Amazon Search Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonSearchHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_Search( $this->mergeWidgetOptions( AmazonWidget_Search::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Amazon Omakase Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonOmakaseHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_Omakase( $this->mergeWidgetOptions( AmazonWidget_Omakase::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Amazon ProductCloud Short Code Handler
     * @param array $atts
     * @param string $content
     * @param string $code
     */
    public function amazonProductCloudHandler( $atts, $content=null, $code="" ) {
        $widget = new AmazonWidget_ProductCloud( $this->mergeWidgetOptions( AmazonWidget_ProductCloud::getDefaultShortCodeOptions(), $atts ) );
        return self::doStyle( $atts, $widget->toHTML() );
    }

    /**
     * Merge Widget Options and include plugin compliance settings
     * @param Array $defaultArgs
     * @param Array $atts
     * @return Array
     */
    private function mergeWidgetOptions( $defaultArgs, $atts ) {
        if( isset( $atts['marketplace'] ) ) {
            $atts['market_place'] = $atts['marketplace'];
            unset( $atts['marketplace'] );
        }
        return shortcode_atts( $defaultArgs, $atts );
    }

    /**
     * Append Container, class and style if enabled
     * @param array $options
     * @param string $output_str
     * @return <type>
     */
    public static function doStyle( $options, $output_str ) {
        $output = "";
        if( ! empty($options['container']) ) {
            // strip inclusion of html entities
            $options['container'] = strip_tags( $options['container'] );
            $output = "<" . $options['container'];
            if( ! empty($options['container_class']) ) {
                $output .= ' class="' . htmlentities(strip_tags($options['container_class']), ENT_COMPAT) . '"';
            }
            if( ! empty($options['container_style']) ) {
                $output .= ' style="' . htmlentities(strip_tags($options['container_style']), ENT_COMPAT) . '"';
            }
            return $output . ">" . $output_str . "</" . $options['container'] . ">";
        } else {
            return $output_str;
        }
    }

}