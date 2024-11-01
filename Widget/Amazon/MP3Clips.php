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
 * MP3 Clips Amazon Widget
 *
 * This file contains the class Widget_Amazon_MP3Clips
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_MP3Clips is the implemenation of the Amaozn MP3 Clips Widget
 * as a WordPress Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_MP3Clips extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_MP3Clips() {

        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_MP3Clips', 'description'=>__('Amazon MP3 Clips Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-mp3-clips-widget' );

        parent::WP_Widget('amazon-mp3-clips-widget', __('Amazon MP3 Clips Widget','wpaa'), $widget_settings, $widget_options);
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
        AmazonWidget::MP3Clips( $instance );
        if( isset( $after_widget ) ) {
            echo $after_widget;
        }
    }

    /**
     * @see WP_Widget::update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['width'] = $this->get_strip_tags($new_instance, 'width');
        $instance['height'] = $this->get_strip_tags($new_instance, 'height');
        $instance['widgetTitle'] = $this->get_strip_tags($new_instance, 'widgetTitle');
        $instance['title'] = $this->get_strip_tags($new_instance, 'title');
        $instance['widgetType'] = $this->get_strip_tags($new_instance, 'widgetType');
        $instance['browseNode'] = $this->get_strip_tags($new_instance, 'browseNode');
        $instance['ASIN'] = $this->get_strip_tags($new_instance, 'ASIN');
        $instance['keywords'] = $this->get_strip_tags($new_instance, 'keywords');
        if( isset( $new_instance['shuffleTracks'] ) ) {
            $instance['shuffleTracks'] = "True";
        } else {
            $instance['shuffleTracks'] = "False";
        }
        $instance['maxResults'] = $this->get_strip_tags($new_instance, 'maxResults');
        $instance['marketPlace'] = $this->get_strip_tags($new_instance, 'marketPlace');
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $instance = wp_parse_args( (array) $instance, AmazonWidget_MP3Clips::getDefaultOptions() );
        $width = isset( $instance['width']) ? esc_attr($instance['width']) : "";
        $height = isset( $instance['height']) ? esc_attr($instance['height']) : "";
        $widgetTitle = isset( $instance['widgetTitle']) ? esc_attr($instance['widgetTitle']) : "";
        $title = isset( $instance['title']) ? esc_attr($instance['title']) : "";
        $widgetType = isset( $instance['widgetType']) ? esc_attr($instance['widgetType']) : "";
        $browseNode = isset( $instance['browseNode']) ? esc_attr($instance['browseNode']) : "";
        $ASIN = isset( $instance['ASIN']) ? esc_attr($instance['ASIN']) : "";
        $keywords = isset( $instance['keywords']) ? esc_attr($instance['keywords']) : "";
        $shuffleTracks = false;
        if( isset($instance['shuffleTracks']) && $instance['shuffleTracks'] == "True" ) {
            $shuffleTracks = true;
        }
        $maxResults = isset( $instance['maxResults']) ? esc_attr($instance['maxResults']) : "";
        $marketPlace = isset( $instance['marketPlace']) ? esc_attr($instance['marketPlace']) : "";
        ?>
<div class="wpaa_widget">
    <h3><?php _e('Basic Properties','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __("Widget Title:",'wpaa'), 'widgetTitle', $widgetTitle );
        echo $this->textinputWithLabel( __('Width:','wpaa'), 'width', $width );
        echo $this->textinputWithLabel( __('Height:','wpaa'), 'height', $height );
        echo $this->selectWithLabel( __('Market Place:','wpaa'), 'marketPlace', AmazonWidget_Abstract::getAvailableMarkets(), $marketPlace );
        ?>
    <h3><?php _e('Widget Options','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __('Title:','wpaa'), 'title', $title );
        $js = "onchange=\" changeAmazonWidgetMP3Clips( '" . $this->get_field_id('widgetType') . "', '" . $this->get_field_id('ASIN') . "', '" . $this->get_field_id('keywords') . "', '" . $this->get_field_id('browseNode') . "' )\"";
        echo $this->selectWithLabel( __('Widget Type:','wpaa'), 'widgetType', AmazonWidget_Carousel::getAvailableTypes(), $widgetType, $js );
        echo $this->textinputWithLabel( __("Browse Node:",'wpaa'), 'browseNode', $browseNode );
        echo $this->textinputWithlabel( __("ASIN:",'wpaa'), 'ASIN', $ASIN );
        echo $this->textinputWithlabel( __("Keywords:",'wpaa'), 'keywords', $keywords );
        echo $this->checkboxWithLabel( __("Shuffle Tracks:",'wpaa'), 'shuffleTracks', $shuffleTracks );
        echo $this->textinputWithlabel( __("Max Results:",'wpaa'), 'maxResults', $maxResults );
        $jsParams = "'" . $this->get_field_id('width') .
                "', '" . $this->get_field_id( 'height' ) .
                "', '" . $this->get_field_id('marketPlace') .
                "', '" . $this->get_field_id('title') .
                "', '" . $this->get_field_id('widgetType') .
                "', '" . $this->get_field_id('browseNode') .
                "', '" . $this->get_field_id('ASIN') .
                "', '" . $this->get_field_id('keywords') .
                "', '" . $this->get_field_id('shuffleTracks') .
                "', '" . $this->get_field_id('maxResults') . "'";
        echo '<input type="button" style="float:right" onclick="previewAmazonWidgetMP3Clips( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '" />';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.changeAmazonWidgetMP3Clips ) {

    } else {
        function changeAmazonWidgetMP3Clips( id, asin_id, keywords_id, node_id ) {
            var value = jQuery( "#" + id ).val();
            if( value == "ASINList" ) {
                jQuery( "#" + asin_id ).removeAttr('disabled');
                jQuery( "#" + keywords_id ).attr('disabled','disabled');
                jQuery( "#" + node_id ).attr('disabled','disabled');
            } else if ( value == "SearchAndAdd" ) {
                jQuery( "#" + asin_id ).attr('disabled','disabled');
                jQuery( "#" + keywords_id ).removeAttr('disabled');
                jQuery( "#" + node_id ).removeAttr('disabled');
            } else {
                jQuery( "#" + asin_id ).attr('disabled','disabled');
                jQuery( "#" + keywords_id ).attr('disabled','disabled');
                jQuery( "#" + node_id ).removeAttr('disabled');
            }
        }
        function previewAmazonWidgetMP3Clips( path, width, height, marketPlace, title, widgetType, browseNode, ASIN, keywords, shuffleTracks, maxResults ) {
            var queryStr = '?widget=MP3Clips' + 
                '&width=' + jQuery( "#" + width ).val() +
                '&height=' + jQuery( "#" + height ).val() +
                "&marketPlace=" + jQuery( "#" + marketPlace ).val() +
                '&title=' + jQuery( "#" + title ).val() + 
                '&widgetType=' + jQuery( "#" + widgetType ).val() +
                '&browseNode=' + jQuery( "#" + browseNode ).val() +
                '&ASIN=' + jQuery( "#" + ASIN ).val() +
                '&keywords=' + jQuery( "#" + keywords ).val() +
                '&shuffleTracks=' + jQuery( "#" + shuffleTracks + ":checked" ).val() +
                '&maxResults=' + jQuery( "#" + maxResults ).val();
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "MP3 Clips Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'ajax'
		});
            return false;
        }
    }
    jQuery( "#<?php echo $this->get_field_id('widgetType');?>" ).change();
</script>
        <?php
    }

} // class Widget_Amazon_MP3Clips