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
 * Carousel Amazon Widget
 *
 * This file contains the class Widget_Amazon_Carousel
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_Carousel is the implemenation of the Amaozn Carousel Widget
 * as a WordPress Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_Carousel extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_Carousel() {
        
        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_Carousel', 'description'=>__('Amazon Carousel Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-carousel-widget' );

        parent::WP_Widget('amazon-carousel-widget', __('Amazon Carousel Widget','wpaa'), $widget_settings, $widget_options);
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
        AmazonWidget::Carousel( $instance );
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
        $instance['searchIndex'] = $this->get_strip_tags($new_instance, 'searchIndex');
        $instance['browseNode'] = $this->get_strip_tags($new_instance, 'browseNode');
        $instance['ASIN'] = $this->get_strip_tags($new_instance, 'ASIN');
        $instance['keywords'] = $this->get_strip_tags($new_instance, 'keywords');
        if( isset( $new_instance['shuffleProducts'] ) ) {
            $instance['shuffleProducts'] = "True";
        } else {
            $instance['shuffleProducts'] = "False";
        }
        if( isset( $new_instance['showBorder'] ) ) {
            $instance['showBorder'] = "True";
        } else {
            $instance['showBorder'] = "False";
        }
        $instance['marketPlace'] = $this->get_strip_tags($new_instance, 'marketPlace');
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $instance = wp_parse_args( (array) $instance, AmazonWidget_Carousel::getDefaultOptions() );
        $width = isset($instance['width']) ? esc_attr($instance['width']): "";
        $height = isset($instance['height']) ? esc_attr($instance['height']) : "";
        $widgetTitle = isset($instance['widgetTitle']) ? esc_attr($instance['widgetTitle']) : "";
        $title = isset($instance['title']) ? esc_attr($instance['title']) : "";
        $widgetType = isset($instance['widgetType']) ? esc_attr($instance['widgetType']) : "";
        $searchIndex = isset($instance['searchIndex']) ? esc_attr($instance['searchIndex']) : "";
        $browseNode = isset($instance['browseNode']) ? esc_attr($instance['browseNode']) : "";
        $ASIN = isset($instance['ASIN']) ? esc_attr($instance['ASIN']) : "";
        $keywords = isset($instance['keywords']) ? esc_attr($instance['keywords']) : "";
        $shuffleProducts = false;
        if( isset($instance['shuffleProducts']) && $instance['shuffleProducts'] == "True" ) {
            $shuffleProducts = true;
        }
        $showBorder = false;
        if( isset($instance['showBorder']) && $instance['showBorder'] == "True" ) {
            $showBorder = true;
        }
        $marketPlace = isset($instance['marketPlace'])? esc_attr($instance['marketPlace']) : "";
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
        $js = "onchange=\" changeAmazonWidgetCarousel( '" . $this->get_field_id('widgetType') . "', '" . $this->get_field_id('ASIN') . "', '" . $this->get_field_id('keywords') . "', '" . $this->get_field_id('browseNode') . "', '" . $this->get_field_id('searchIndex') . "' )\"";
        echo $this->selectWithLabel( __('Widget Type:','wpaa'), 'widgetType', AmazonWidget_Carousel::getAvailableTypes(), $widgetType, $js );
        echo $this->selectWithLabel( __('Search Index:','wpaa'), 'searchIndex', AmazonProduct_SearchIndex::SupportedSearchIndexes(), $searchIndex );
        echo $this->textinputWithLabel( __("Browse Node:",'wpaa'), 'browseNode', $browseNode );
        echo $this->textinputWithlabel( __("ASIN:",'wpaa'), 'ASIN', $ASIN );
        echo $this->textinputWithlabel( __("Keywords:",'wpaa'), 'keywords', $keywords );
        echo $this->checkboxWithLabel( __("Shuffle Products:",'wpaa'), 'shuffleProducts', $shuffleProducts );
        echo $this->checkboxWithLabel( __("Show Border:",'wpaa'), 'showBorder', $showBorder );
        $jsParams = "'". $this->get_field_id('width') .
                "', '" . $this->get_field_id('height') .
                "', '" . $this->get_field_id('marketPlace') .
                "', '" . $this->get_field_id('title') .
                "', '" . $this->get_field_id('widgetType') .
                "', '" . $this->get_field_id('searchIndex') .
                "', '" . $this->get_field_id('browseNode') .
                "', '" . $this->get_field_id('ASIN') .
                "', '" . $this->get_field_id('keywords') .
                "', '" . $this->get_field_id('shuffleProducts') .
                "', '" . $this->get_field_id('showBorder') . "'";
        echo '<input type="button" style="float:right" onclick="previewAmazonWidgetCarousel( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '"/>';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.changeAmazonWidgetCarousel ) {

    } else {
        function changeAmazonWidgetCarousel( id, asin_id, keywords_id, node_id, index_id ) {
            var value = jQuery( "#" + id ).val();
            if( value == "ASINList" ) {
                jQuery( "#" + asin_id ).removeAttr('disabled');
                jQuery( "#" + keywords_id ).attr('disabled','disabled');
                jQuery( "#" + node_id ).attr('disabled','disabled');
                jQuery( "#" + index_id ).attr('disabled','disabled');
            } else if ( value == "SearchAndAdd" ) {
                jQuery( "#" + asin_id ).attr('disabled','disabled');
                jQuery( "#" + keywords_id ).removeAttr('disabled');
                jQuery( "#" + node_id ).removeAttr('disabled');
                jQuery( "#" + index_id ).removeAttr('disabled');
            } else {
                jQuery( "#" + asin_id ).attr('disabled','disabled');
                jQuery( "#" + keywords_id ).attr('disabled','disabled');
                jQuery( "#" + node_id ).removeAttr('disabled');
                jQuery( "#" + index_id ).removeAttr('disabled');
            }
        }
        function previewAmazonWidgetCarousel( path, width, height, marketPlace, title, widgetType, searchIndex, browseNode, ASIN, keywords, shuffleProducts, showBorder ) {
            var queryStr = '?widget=Carousel' +
                '&width=' + jQuery( "#" + width ).val() +
                '&height=' + jQuery( "#" + height ).val() +
                "&marketPlace=" + jQuery( "#" + marketPlace ).val() +
                '&title=' + jQuery( "#" + title ).val() +
                '&widgetType=' + jQuery( "#" + widgetType ).val() +
                '&searchIndex=' + jQuery( "#" + searchIndex ).val() +
                '&browseNode=' + jQuery( "#" + browseNode ).val() +
                '&ASIN=' + jQuery( "#" + ASIN ).val() +
                '&keywords=' + jQuery( "#" + keywords ).val() +
                '&shuffleProducts=' + jQuery( "#" + shuffleProducts + ":checked" ).val() +
                '&showBorder=' + jQuery( "#" + showBorder + ":checked" ).val();
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Carousel Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'ajax'
		});
            return false;
        }
    }
    jQuery( "#<?php echo $this->get_field_id('widgetType');?>").change();
</script>
        <?php
    }

} // class Widget_Amazon_Carousel