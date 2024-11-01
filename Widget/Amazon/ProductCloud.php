<?php
/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
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
 * ProductCloud Amazon Widget
 *
 * This file contains the class Widget_Amazon_ProductCloud
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_ProductCloud is the implemenation of the Amaozn Product Cloud Widget
 * as a WordPress Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_ProductCloud extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_ProductCloud() {

        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_ProductCloud', 'description'=>__('Amazon Product Cloud Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-product-cloud-widget' );

        parent::WP_Widget('amazon-product-cloud-widget', __('Amazon Product Cloud Widget','wpaa'), $widget_settings, $widget_options);
    }

    /**
     * @see WP_Widget::widget
     */
    function widget($args, $instance) {
        global $wpaa;
	extract($args);
        if( isset( $before_widget ) ) {
            echo $before_widget;
        }
        $title = apply_filters('widget_title', $instance['widgetTitle']);
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        $instance['tag'] = $wpaa->getAssociateId();
        AmazonWidget::ProductCloud( $instance );
        if( isset( $after_widget ) ) {
            echo $after_widget;
        }
    }

    /**
     * @see WP_Widget::update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['widgetTitle'] = $this->get_strip_tags($new_instance, 'widgetTitle');
        $instance['popoverBorderColor'] = $this->get_strip_tags($new_instance,'popoverBorderColor');
        $instance['backgroundColor'] = $this->get_strip_tags($new_instance,'backgroundColor');
        $instance['titleTextColor'] = $this->get_strip_tags($new_instance,'titleTextColor');
        $instance['width'] = $this->get_strip_tags($new_instance,'width');
        $instance['cloudFontSize'] = $this->get_strip_tags($new_instance,'cloudFontSize');
        if( isset( $new_instance['showEditIcon'] ) ) {
            $instance['showEditIcon'] = "true";
        } else {
            $instance['showEditIcon'] = "false";
        }
        $instance['marketPlace'] = $this->get_strip_tags($new_instance,'marketPlace');
        $instance['titleFont'] = $this->get_strip_tags($new_instance,'titleFont');
        $instance['titleFontSize'] = $this->get_strip_tags($new_instance,'titleFontSize');
        $instance['title'] = $this->get_strip_tags($new_instance,'title');
        $instance['category'] = $this->get_strip_tags($new_instance,'category');
        $instance['height'] = $this->get_strip_tags($new_instance,'height');
        if( isset( $new_instance['curvedCorners'] ) ) {
            $instance['curvedCorners'] = "true";
        } else {
            $instance['curvedCorners'] = "false";
        }
        $instance['hoverBackgroundColor'] = $this->get_strip_tags($new_instance,'hoverBackgroundColor');
        $instance['hoverTextColor'] = $this->get_strip_tags($new_instance,'hoverTextColor');
        if( isset( $new_instance['showAmazonLogoAsText'] ) ) {
            $instance['showAmazonLogoAsText'] = "true";
        } else {
            $instance['showAmazonLogoAsText'] = "false";
        }
        if( isset( $new_instance['showTitle'] ) ) {
            $instance['showTitle'] = "true";
        } else {
            $instance['showTitle'] = "false";
        }
        $instance['cloudTextColor'] = $this->get_strip_tags($new_instance,'cloudTextColor');
        if( isset( $new_instance['showPopovers'] ) ) {
            $instance['showPopovers'] = "true";
        } else {
            $instance['showPopovers'] = "false";
        }
        $instance['cloudFont'] = $this->get_strip_tags($new_instance,'cloudFont');
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $instance = wp_parse_args( (array) $instance, AmazonWidget_ProductCloud::getDefaultOptions() );
        $widgetTitle = isset( $instance['widgetTitle']) ? esc_attr($instance['widgetTitle']) : "";
        $popoverBorderColor = isset( $instance['popoverBorderColor']) ? esc_attr($instance['popoverBorderColor']) : "";
        $backgroundColor = isset( $instance['backgroundColor']) ? esc_attr($instance['backgroundColor']) : "";
        $titleTextColor = isset( $instance['titleTextColor']) ? esc_attr($instance['titleTextColor']) : "";
        $width = isset( $instance['width']) ? esc_attr($instance['width']) : "";
        $cloudFontSize = isset( $instance['cloudFontSize']) ? esc_attr($instance['cloudFontSize']) : "";
        $showEditIcon = false;
        if( isset($instance['showEditIcon']) && $instance['showEditIcon'] == "true" ) {
            $showEditIcon = true;
        }
        $marketPlace = isset( $instance['marketPlace']) ? esc_attr($instance['marketPlace']) : "";
        $titleFont = isset( $instance['titleFont']) ? esc_attr($instance['titleFont']) : "";
        $titleFontSize = isset( $instance['titleFontSize']) ? esc_attr($instance['titleFontSize']) : "";
        $title = isset( $instance['title']) ? esc_attr($instance['title']) : "";
        $category = isset( $instance['category']) ? esc_attr($instance['category']) : "";
        $height = isset( $instance['height']) ? esc_attr($instance['height']) : "";
        $curvedCorners = false;
        if( isset($instance['curvedCorners']) && $instance['curvedCorners'] == "true" ) {
            $curvedCorners = true;
        }
        $hoverBackgroundColor = isset( $instance['hoverBackgroundColor']) ? esc_attr($instance['hoverBackgroundColor']) : "";
        $hoverTextColor = isset( $instance['hoverTextColor']) ? esc_attr($instance['hoverTextColor']) : "";
        $showAmazonLogoAsText = false;
        if( isset($instance['showAmazonLogoAsText']) && $instance['showAmazonLogoAsText'] == "true" ) {
            $showAmazonLogoAsText = true;
        }
        $showTitle = false;
        if( isset($instance['showTitle']) && $instance['showTitle'] == "true" ) {
            $showTitle = true;
        }
        $cloudTextColor = isset( $instance['cloudTextColor']) ? esc_attr($instance['cloudTextColor']) : "";
        $showPopovers = false;
        if( isset($instance['showPopovers']) && $instance['showPopovers'] == "true" ) {
            $showPopovers = true;
        }
        $cloudFont = isset( $instance['cloudFont']) ? esc_attr($instance['cloudFont']) : "";
        ?>
<div class="wpaa_widget">
    <h3><?php _e('Basic Properties','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __("WordPress Widget Title:",'wpaa'), 'widgetTitle', $widgetTitle );
        echo $this->textinputWithLabel( __("Amazon Widget Title:",'wpaa'), 'title', $title );
        echo $this->selectWithLabel( __('Market Place:','wpaa'), 'marketPlace', AmazonWidget_ProductCloud::getAvailableMarkets(), $marketPlace );

        ?>
    <h3><?php _e('Widget Options','wpaa'); ?></h3>
        <?php
        echo $this->selectWithLabel( __('Category:', 'wpaa'), 'category', AmazonProduct_SearchIndex::SupportedSearchIndexes(), $category );
        echo $this->textinputWithLabel( __("Width:",'wpaa'), 'width', $width );
        echo $this->textinputWithLabel( __("Height:",'wpaa'), 'height', $height );
        echo $this->checkboxWithLabel( __('Show Title:', 'wpaa'), 'showTitle', $showTitle );
        echo $this->checkboxWithLabel( __('Show Product Preview:', 'wpaa'), 'showPopovers', $showPopovers );
        ?>
    <h3><?php _e('Color and Design', 'wpaa'); ?></h3>
        <?php
        echo $this->textinputWithlabel( __("Background Color:",'wpaa'), 'backgroundColor', $backgroundColor );
        echo $this->textinputWithlabel( __("Hover Background Color:",'wpaa'), 'hoverBackgroundColor', $hoverBackgroundColor );
        echo $this->textinputWithlabel( __("Pop-over Border:",'wpaa'), 'popoverBorderColor', $popoverBorderColor );
        echo $this->textinputWithlabel( __("Hover Text Color:",'wpaa'), 'hoverTextColor', $hoverTextColor );
        echo $this->textinputWithlabel( __("Title Text Color:",'wpaa'), 'titleTextColor', $titleTextColor );
        echo $this->selectWithlabel( __("Title Text Font:",'wpaa'), 'titleFont', AmazonWidget_ProductCloud::getAvailableFonts(), $titleFont );
        echo $this->textinputWithlabel( __("Title Text Size:",'wpaa'), 'titleFontSize', $titleFontSize );
        echo $this->textinputWithlabel( __("Link Text Color:",'wpaa'), 'cloudTextColor', $cloudTextColor );
        echo $this->selectWithlabel( __("Link Text Font:",'wpaa'), 'cloudFont', AmazonWidget_ProductCloud::getAvailableFonts(), $cloudFont );
        echo $this->textinputWithlabel( __("Link Text Size:",'wpaa'), 'cloudFontSize', $cloudFontSize );
        echo $this->checkboxWithLabel( __('Rounded Corners:', 'wpaa'), 'curvedCorners', $curvedCorners);
        echo $this->checkboxWithLabel( __('Amazon.com logo as Text:', 'wpaa'), 'showAmazonLogoAsText', $showAmazonLogoAsText );

        $jsParams = "'". $this->get_field_id('title') .
                "', '" . $this->get_field_id('marketPlace') .
                "', '" . $this->get_field_id('width') .
                "', '" . $this->get_field_id('height') .
                "', '" . $this->get_field_id('category') .
                "', '" . $this->get_field_id('showTitle') .
                "', '" . $this->get_field_id('showPopovers') .
                "', '" . $this->get_field_id('backgroundColor') .
                "', '" . $this->get_field_id('hoverBackgroundColor') .
                "', '" . $this->get_field_id('popoverBorderColor') .
                "', '" . $this->get_field_id('hoverTextColor') .
                "', '" . $this->get_field_id('titleTextColor') .
                "', '" . $this->get_field_id('titleFont') .
                "', '" . $this->get_field_id('titleFontSize') .
                "', '" . $this->get_field_id('cloudTextColor') .
                "', '" . $this->get_field_id('cloudFont') .
                "', '" . $this->get_field_id('cloudFontSize') .
                "', '" . $this->get_field_id('curvedCorners') .
                "', '" . $this->get_field_id('showAmazonLogoAsText') . "'";
        echo '<input type="button" style="float:right" onclick="previewAmazonWidgetProductCloud( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '"/>';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.previewAmazonWidgetProductCloud ) {

    } else {
        function previewAmazonWidgetProductCloud(
            path, title, marketPlace, width, height, category, showTitle, showPopovers,
            backgroundColor, hoverBackgroundColor, popoverBorderColor, hoverTextColor,
            titleTextColor, titleFont, titleFontSize, cloudTextColor, cloudFont,
            cloudFontSize, curvedCorners, showAmazonLogoAsText
        ) {
            var queryStr = '?widget=ProductCloud' +
                '&title=' + jQuery( "#" + title ).val() +
                "&marketPlace=" + jQuery( "#" + marketPlace ).val() +
                '&width=' + jQuery( "#" + width ).val() +
                '&height=' + jQuery( "#" + height ).val() +
                '&category=' + jQuery( "#" + category ).val() +
                '&showTitle=' + jQuery( "#" + showTitle + ":checked" ).val() +
                '&showPopovers=' + jQuery( "#" + showPopovers + ":checked" ).val() +
                '&backgroundColor=' + encodeURIComponent(jQuery( "#" + backgroundColor ).val()) +
                '&hoverBackgroundColor=' + encodeURIComponent(jQuery( "#" + hoverBackgroundColor ).val()) +
                '&popoverBorderColor=' + encodeURIComponent(jQuery( "#" + popoverBorderColor ).val()) +
                '&hoverTextColor=' + encodeURIComponent(jQuery( "#" + hoverTextColor ).val()) +
                '&titleTextColor=' + encodeURIComponent(jQuery( "#" + titleTextColor ).val()) +
                '&cloudTextColor=' + encodeURIComponent(jQuery( "#" + cloudTextColor ).val()) +
                '&titleFont=' + jQuery( "#" + titleFont ).val() +
                '&titleFontSize=' + jQuery( "#" + titleFontSize ).val() +
                '&cloudFont=' + jQuery( "#" + cloudFont ).val() +
                '&cloudFontSize=' + jQuery( "#" + cloudFontSize ).val() +
                '&curvedCorners=' + jQuery( "#" + curvedCorners + ":checked" ).val() +
                '&showAmazonLogoAsText=' + jQuery( "#" + showAmazonLogoAsText + ":checked" ).val()
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Product Cloud Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'iframe'
		});
            return false;
        }
    }
</script>
        <?php
    }

} // class Widget_Amazon_ProductCloud