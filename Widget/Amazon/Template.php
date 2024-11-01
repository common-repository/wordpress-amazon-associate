<?php
/*
 * copyright (c) 2012 MDBitz - Matthew John Denton - mdbitz.com
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
 * Amazon Template Widget
 *
 * This file contains the class Widget_Amazon_Banner
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_Template enables use of templates as widgets
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_Template extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_Template() {

        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_Template', 'description'=>__('Amazon Template Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-template-widget' );

        parent::WP_Widget('amazon-template-widget', __('Amazon Template Widget','wpaa'), $widget_settings, $widget_options);
    }

    /**
     * @see WP_Widget::widget
     */
    function widget($args, $instance) {
        global $wpaa;
	extract($args);
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        WPAA_Template::toHTML( $instance ); // auto echo
        echo $after_widget;
    }

    /**
     * @see WP_Widget::update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['container'] = strip_tags($new_instance['container']);
        $instance['container_class'] = strip_tags($new_instance['container_class']);
        $instance['container_style'] = strip_tags($new_instance['container_style']);
        $instance['template'] = strip_tags($new_instance['template']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['id'] = strip_tags($new_instance['id']);
        $instance['locale'] = strip_tags($new_instance['locale']);
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $container = esc_attr($instance['container']);
        $container_class = esc_attr($instance['container_class']);
        $container_style = esc_attr($instance['container_style']);
        $title = esc_attr($instance['title']);
        $type = esc_attr($instance['type']);
        $template = esc_attr($instance['template']);
        $locale = esc_attr($instance['locale']);
        $id = esc_attr($instance['id']);
        ?>
<div class="wpaa_widget">
    <h3><?php _e('Basic Properties','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __("WidgetTitle:",'wpaa'), 'title', $title );
        echo $this->selectWithLabel( __('Locale:', 'wpaa'), 'locale', $wpaa->getEnabledLocales(true, $locale ), $locale );
        $activeTemplates = WPAA_Template::getActiveTemplates();
        $templates = array( );
        foreach( $activeTemplates as $aTemplate) {
            $templates[$aTemplate['ID']] = $aTemplate['NAME'];
        }
        echo $this->selectWithLabel( __('Template:','wpaa'), 'template', $templates, $template );
        echo $this->selectWithLabel( __('Type:','wpaa'), 'type', WPAA_Template::getTypeOptions(), $type ); // need type to be ASIN for now
        echo $this->textinputWithlabel( __("Product(s):",'wpaa'), 'id', $id );
        echo $this->textinputWithlabel( __("Container:",'wpaa'), 'container', $container );
        echo $this->textinputWithlabel( __("Container Class:",'wpaa'), 'container_class', $container_class );
        echo $this->textinputWithlabel( __("Container Style:",'wpaa'), 'container_style', $container_style );

        $jsParams = "'". $this->get_field_id('locale') .
                "', '" . $this->get_field_id('template') .
                "', '" . $this->get_field_id('id') .
                "', '" . $this->get_field_id('type') .
                "', '" . $this->get_field_id('container') .
                "', '" . $this->get_field_id('container_class') .
                "', '" . $this->get_field_id('container_style') . "'";
        echo '<input type="button" style="float:right" onclick="previewAmazonWidgetTemplate( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '"/>';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.changeAmazonWidgetTemplate ) {

    } else {
        function changeAmazonWidgetTemplate( ) {

        }
        function previewAmazonWidgetTemplate( path, locale, template, id, type, container, container_class, container_style ) {
            var queryStr = '?widget=Template' +
                '&width=500&height=400' +
                '&locale=' + jQuery( "#" + locale ).val() +
                '&template=' + jQuery( "#" + template ).val() +
                "&id=" + jQuery( "#" + id ).val() +
                '&type=' + jQuery( "#" + type ).val() +
                '&container=' + jQuery( "#" + container ).val() +
                '&container_class=' + jQuery( "#" + container_class ).val() +
                '&container_style=' + jQuery( "#" + container_style ).val();
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Template Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'ajax'
		});
            return false;
        }
    }
</script>
        <?php
    }

} // class Widget_Amazon_Template