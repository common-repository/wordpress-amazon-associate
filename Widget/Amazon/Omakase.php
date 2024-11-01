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
 * Omakase Amazon Widget
 *
 * This file contains the class Widget_Amazon_Omakase
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_Omakase is the implemenation of the Amaozn Omakase Widget
 * as a WordPress Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_Omakase extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_Omakase() {
        
        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_Omakase', 'description'=>__('Amazon Omakase Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-omakase-widget' );

        parent::WP_Widget('amazon-omakase-widget', __('Amazon Omakase Widget','wpaa'), $widget_settings, $widget_options);
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
        $title = apply_filters('widget_title', $instance['title']);
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        $instance['tag'] = $wpaa->getAssociateId();
        AmazonWidget::Omakase( $instance );
        if( isset( $after_widget ) ) {
            echo $after_widget;
        }
    }

    /**
     * @see WP_Widget::update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['size'] = $this->get_strip_tags($new_instance,'size');
        $instance['title'] = $this->get_strip_tags($new_instance,'title');
        $instance['locale'] = $this->get_strip_tags($new_instance,'locale');
        $instance['ad_logo'] = $this->get_strip_tags($new_instance,'ad_logo');
        $instance['ad_border'] = $this->get_strip_tags($new_instance,'ad_border');
        $instance['ad_product_images'] = $this->get_strip_tags($new_instance,'ad_product_images');
        $instance['ad_link_target'] = $this->get_strip_tags($new_instance,'ad_link_target');
        $instance['ad_price'] = $this->get_strip_tags($new_instance,'ad_price');
        $instance['ad_discount'] = $this->get_strip_tags($new_instance,'ad_discount');
        $instance['color_border'] = $this->get_strip_tags($new_instance,'color_border');
        $instance['color_text'] = $this->get_strip_tags($new_instance,'color_text');
        $instance['color_background'] = $this->get_strip_tags($new_instance,'color_background');
        $instance['color_link'] = $this->get_strip_tags($new_instance,'color_link');
        $instance['color_price'] = $this->get_strip_tags($new_instance,'color_price');
        $instance['color_logo'] = $this->get_strip_tags($new_instance,'color_logo');
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $instance = wp_parse_args( (array) $instance, AmazonWidget_Omakase::getDefaultOptions() );
        $size = isset( $instance['size']) ? esc_attr($instance['size']) : "";
        $title = isset( $instance['title']) ? esc_attr($instance['title']) : "";
        $locale = isset( $instance['locale']) ? esc_attr($instance['locale']) : "";
        $ad_border = isset( $instance['ad_border']) ? esc_attr($instance['ad_border']) : "";
        $ad_logo = isset( $instance['ad_logo']) ? esc_attr($instance['ad_logo']) : "";
        $ad_product_images = isset( $instance['ad_product_images']) ? esc_attr($instance['ad_product_images']) : "";
        $ad_link_target = isset( $instance['ad_link_target']) ? esc_attr($instance['ad_link_target']) : "";
        $ad_price = isset( $instance['ad_price']) ? esc_attr($instance['ad_price']) : "";
        $ad_discount = isset( $instance['ad_discount']) ? esc_attr($instance['ad_discount']) : "";
        $color_border = isset( $instance['color_border']) ? esc_attr($instance['color_border']) : "";
        $color_background = isset( $instance['color_background']) ? esc_attr($instance['color_background']) : "";
        $color_text = isset( $instance['color_text']) ? esc_attr($instance['color_text']) : "";
        $color_link = isset( $instance['color_link']) ? esc_attr($instance['color_link']) : "";
        $color_price = isset( $instance['color_price']) ? esc_attr($instance['color_price']) : "";
        $color_logo = isset( $instance['color_logo']) ? esc_attr($instance['color_logo']) : "";
        ?>
<div class="wpaa_widget">
    <h3><?php _e('Basic Properties','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __("Widget Title:",'wpaa'), 'title', $title );
        echo $this->selectWithLabel( __('Size:','wpaa'), 'size', AmazonWidget_Omakase::getBannerSizes(), $size );
        echo $this->selectWithLabel( __('Locale:','wpaa'), 'locale', AmazonWidget_Omakase::getAvailableLocales(), $locale );
        ?>
    <h3><?php _e('Widget Options','wpaa'); ?></h3>
        <?php
        echo $this->selectWithLabel( __('Logo Display:','wpaa'), 'ad_logo', AmazonWidget_Omakase::getLogoOptions(), $ad_logo );
        echo $this->selectWithLabel( __('Product Images:','wpaa'), 'ad_product_images', AmazonWidget_Omakase::getImagesOptions(), $ad_product_images );
        echo $this->selectWithLabel( __("Link Target:",'wpaa'), 'ad_link_target', AmazonWidget_Omakase::getOpenOptions() , $ad_link_target );
        echo $this->selectWithLabel( __("Prices:",'wpaa'), 'ad_price', AmazonWidget_Omakase::getPriceOptions() , $ad_price );
        echo $this->selectWithLabel( __("Border:",'wpaa'), 'ad_border', AmazonWidget_Omakase::getBorderOptions() , $ad_border );
        echo $this->selectWithLabel( __("Amazon Discount:",'wpaa'), 'ad_discount', AmazonWidget_Omakase::getDiscountOptions() , $ad_discount );
        echo $this->textinputWithlabel( __("Border Color:",'wpaa'), 'color_border', $color_border );
        echo $this->textinputWithlabel( __("Background Color:",'wpaa'), 'color_background', $color_background );
        echo $this->textinputWithlabel( __("Details Text Color:",'wpaa'), 'color_text', $color_text );
        echo $this->textinputWithlabel( __("Link Color:",'wpaa'), 'color_link', $color_link );
        echo $this->textinputWithlabel( __("Price Color:",'wpaa'), 'color_price', $color_price );
        echo $this->textinputWithlabel( __("Amazon.com Text Color:",'wpaa'), 'color_logo', $color_logo );
        $jsParams = "'". $this->get_field_id('size') .
                "', '" . $this->get_field_id('locale') .
                "', '" . $this->get_field_id('ad_logo') .
                "', '" . $this->get_field_id('ad_product_images') .
                "', '" . $this->get_field_id('ad_link_target') .
                "', '" . $this->get_field_id('ad_price') .
                "', '" . $this->get_field_id('ad_border') .
                "', '" . $this->get_field_id('ad_discount') .
                "', '" . $this->get_field_id('color_border') .
                "', '" . $this->get_field_id('color_background') .
                "', '" . $this->get_field_id('color_text') .
                "', '" . $this->get_field_id('color_link') .
                "', '" . $this->get_field_id('color_price') .
                "', '" . $this->get_field_id('color_logo') . "'";
        echo '<input type="button" style="float:right" onclick="previewAmazonWidgetOmakase( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '"/>';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.previewAmazonWidgetOmakase ) {

    } else {
        function previewAmazonWidgetOmakase( path, size, locale, ad_logo, ad_product_images, ad_link_target, ad_price, ad_border, ad_discount, color_border, color_background, color_text, color_link, color_price, color_logo ) {
            var queryStr = '?widget=Omakase' +
                '&size=' + jQuery( "#" + size ).val() +
                "&locale=" + jQuery( "#" + locale ).val() +
                '&ad_logo=' + jQuery( "#" + ad_logo ).val() +
                '&ad_product_images=' + jQuery( "#" + ad_product_images ).val() +
                '&ad_link_target=' + jQuery( "#" + ad_link_target ).val() +
                '&ad_price=' + jQuery( "#" + ad_price ).val() +
                '&ad_border=' + jQuery( "#" + ad_border ).val() +
                '&ad_discount=' + jQuery( "#" + ad_discount ).val() +
                '&color_border=' + encodeURIComponent(jQuery( "#" + color_border ).val()) +
                '&color_background=' + encodeURIComponent(jQuery( "#" + color_background ).val()) +
                '&color_text=' + encodeURIComponent(jQuery( "#" + color_text ).val()) +
                '&color_link=' + encodeURIComponent(jQuery( "#" + color_link ).val()) +
                '&color_price=' + encodeURIComponent(jQuery( "#" + color_price ).val()) +
                '&color_logo=' + encodeURIComponent(jQuery( "#" + color_logo ).val());
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Omakase Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'iframe'
		});
            return false;
        }
    }
    jQuery( "#<?php echo $this->get_field_id('widgetType');?>").change();
</script>
        <?php
    }

} // class Widget_Amazon_Carousel