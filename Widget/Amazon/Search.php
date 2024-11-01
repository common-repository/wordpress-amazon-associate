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
 * Search Amazon Widget
 *
 * This file contains the class Widget_Amazon_Search
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */

/**
 * Widget_Amazon_Search is the implemenation of the Amaozn Search
 * Widget as a WordPress Widget
 *
 * @package com.mdbitz.wordpress.amazon_associate.Widget.Amazon
 */
class Widget_Amazon_Search extends Widget_MDBitz_Base {

    /**
     * constructor
     */
    function Widget_Amazon_Search() {

        /* Widget Settings */
        $widget_settings = array( 'classname'=>'Widget_Amazon_Search', 'description'=>__('Amazon Search Widget','wpaa') );

        /* Widget Control Options */
        $widget_options = array ( 'width' => 250, 'height' => 600, 'id_base' => 'amazon-search-widget' );;

        parent::WP_Widget('amazon-search-widget', __('Amazon Search Widget','wpaa'), $widget_settings, $widget_options);
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
        AmazonWidget::Search( $instance );
        if( isset( $after_widget ) ) {
            echo $after_widget;
        }
    }

    /**
     * @see WP_Widget::update
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['width'] = $this->get_strip_tags($new_instance,'width');
        $instance['widgetTitle'] = $this->get_strip_tags($new_instance,'widgetTitle');
        $instance['marketPlace'] = $this->get_strip_tags($new_instance,'marketPlace');
        $instance['searchIndex'] = $this->get_strip_tags($new_instance,'searchIndex');
        $instance['defaultSearchTerm'] = $this->get_strip_tags($new_instance,'defaultSearchTerm');
        $instance['columns'] = $this->get_strip_tags($new_instance,'columns');
        $instance['rows'] = $this->get_strip_tags($new_instance,'rows');
        if( isset( $new_instance['showImage'] ) ) {
            $instance['showImage'] = "True";
        } else {
            $instance['showImage'] = "False";
        }
        if( isset( $new_instance['showPrice'] ) ) {
            $instance['showPrice'] = "True";
        } else {
            $instance['showPrice'] = "false";
        }
        if( isset( $new_instance['showRating'] ) ) {
            $instance['showRating'] = "True";
        } else {
            $instance['showRating'] = "False";
        }
        $instance['design'] = $this->get_strip_tags($new_instance,'design');
        $instance['colorTheme'] = $this->get_strip_tags($new_instance,'colorTheme');
        $instance['outerBackgroundColor'] = $this->get_strip_tags($new_instance,'outerBackgroundColor');
        $instance['innerBackgroundColor'] = $this->get_strip_tags($new_instance,'innerBackgroundColor');
        $instance['backgroundColor'] = $this->get_strip_tags($new_instance,'backgroundColor');
        $instance['borderColor'] = $this->get_strip_tags($new_instance,'borderColor');
        $instance['headerTextColor'] = $this->get_strip_tags($new_instance,'headerTextColor');
        $instance['linkedTextColor'] = $this->get_strip_tags($new_instance,'linkedTextColor');
        $instance['bodyTextColor'] = $this->get_strip_tags($new_instance,'bodyTextColor');
        if( isset( $new_instance['roundedCorners'] ) ) {
            $instance['roundedCorners'] = "True";
        } else {
            $instance['roundedCorners'] = "False";
        }
        return $instance;
    }

    /**
     * @see WP_Widget::form
     */
    function form($instance) {
        global $wpaa;
        $instance = wp_parse_args( (array) $instance, AmazonWidget_Search::getDefaultOptions() );
        $width = isset( $instance['width']) ? esc_attr($instance['width']) : "";
        $widgetTitle = isset( $instance['widgetTitle']) ? esc_attr($instance['widgetTitle']) : "";
        $marketPlace = isset( $instance['marketPlace']) ? esc_attr($instance['marketPlace']) : "";
        $searchIndex = isset( $instance['searchIndex']) ? esc_attr($instance['searchIndex']) : "";
        $defaultSearchTerm = isset( $instance['defaultSearchTerm']) ? esc_attr($instance['defaultSearchTerm']) : "";
        $columns = isset( $instance['columns']) ? esc_attr($instance['columns']) : "";
        $rows = isset( $instance['rows']) ? esc_attr($instance['rows']) : "";
        $showImage = false;
        if( isset($instance['showImage']) && $instance['showImage'] == "True" ) {
            $showImage = true;
        }
        $showPrice = false;
        if( isset($instance['showPrice']) && $instance['showPrice'] == "True" ) {
            $showPrice = true;
        }
        $showRating = false;
        if( isset($instance['showRating']) && $instance['showRating'] == "True" ) {
            $showRating = true;
        }
        $design = isset( $instance['design']) ? esc_attr($instance['design']) : "";
        $colorTheme = isset( $instance['colorTheme']) ? esc_attr($instance['colorTheme']) : "";
        $outerBackgroundColor = isset( $instance['outerBackgroundColor']) ? esc_attr($instance['outerBackgroundColor']) : "";
        $innerBackgroundColor = isset( $instance['innerBackgroundColor']) ? esc_attr($instance['innerBackgroundColor']) : "";
        $backgroundColor = isset( $instance['backgroundColor']) ? esc_attr($instance['backgroundColor']) : "";
        $borderColor = isset( $instance['borderColor']) ? esc_attr($instance['borderColor']) : "";
        $headerTextColor = isset( $instance['headerTextColor']) ? esc_attr($instance['headerTextColor']) : "";
        $linkedTextColor = isset( $instance['linkedTextColor']) ? esc_attr($instance['linkedTextColor']) : "";
        $bodyTextColor = isset( $instance['bodyTextColor']) ? esc_attr($instance['bodyTextColor']) : "";
        $roundedCorners = false;
        if( isset($instance['roundedCorners']) && $instance['roundedCorners'] == "True" ) {
            $roundedCorners = true;
        }
        ?>
<div class="wpaa_widget">
    <h3><?php _e('Basic Properties','wpaa'); ?></h3>
        <?php
        echo $this->textinputWithLabel( __("Widget Title:",'wpaa'), 'widgetTitle', $widgetTitle );
        echo $this->textinputWithLabel( __('Width:','wpaa'), 'width', $width );
        echo $this->selectWithLabel( __('Market Place:','wpaa'), 'marketPlace', AmazonWidget_Abstract::getAvailableMarkets(), $marketPlace );
        ?><h3><?php _e('Widget Options','wpaa'); ?></h3><?php
        echo $this->selectWithLabel( __('Search Index:','wpaa'), 'searchIndex', AmazonProduct_SearchIndex::SupportedSearchIndexes(), $searchIndex );
        echo $this->textinputWithLabel( __('Default Search Term:','wpaa'), 'defaultSearchTerm', $defaultSearchTerm );
        echo $this->textinputWithLabel( __('Columns:','wpaa'), 'columns', $columns );
        echo $this->textinputWithLabel( __('Rows:','wpaa'), 'rows', $rows );
        echo $this->checkboxWithLabel( __('Show Image:','wpaa'), 'showImage', $showImage );
        echo $this->checkboxWithLabel( __('Show Price:','wpaa'), 'showPrice', $showPrice );
        echo $this->checkboxWithLabel( __('Show Rating:','wpaa'), 'showRating', $showRating );
        ?><h3><?php _e('Design Options','wpaa'); ?></h3><?php
        $js = "onchange=\" changeAmazonWidgetDesign( '" . $this->get_field_id('design') . "', '" . $this->get_field_id('colorTheme') . "', '" . $this->get_field_id('outerBackgroundColor') . "', '" . $this->get_field_id('innerBackgroundColor') . "', '" . $this->get_field_id('backgroundColor') . "', '" . $this->get_field_id('borderColor') . "', '" . $this->get_field_id('roundedCorners') . "' )\"";
        echo $this->selectWithLabel( __('Design:','wpaa'), 'design', AmazonWidget_Design::getAvailableDesigns(), $design, $js );
        echo $this->selectWithLabel( __('Color Theme:','wpaa'), 'colorTheme', AmazonWidget_Design::getDesignColorThemes( $design ), $colorTheme );
        echo $this->textinputWithLabel( __('Outer Background Color:','wpaa'), 'outerBackgroundColor', $outerBackgroundColor );
        echo $this->textinputWithLabel( __('Inner Background Color:','wpaa'), 'innerBackgroundColor', $innerBackgroundColor );
        echo $this->textinputWithLabel( __('Background Color:','wpaa'), 'backgroundColor', $backgroundColor );
        echo $this->textinputWithLabel( __('Border Color:','wpaa'), 'borderColor', $borderColor );
        echo $this->textinputWithLabel( __('Header Text Color:','wpaa'), 'headerTextColor', $headerTextColor );
        echo $this->textinputWithLabel( __('Linked Text Color:','wpaa'), 'linkedTextColor', $linkedTextColor );
        echo $this->textinputWithLabel( __('Body Text Color:','wpaa'), 'bodyTextColor', $bodyTextColor );
        echo $this->checkboxWithLabel( __('Rounded Corners:','wpaa'), 'roundedCorners', $roundedCorners );
        $jsParams = "'" . $this->get_field_id('width') .
                "', '" . $this->get_field_id('height') .
                "', '" . $this->get_field_id('marketPlace') .
                "', '" . $this->get_field_id('searchIndex') .
                "', '" . $this->get_field_id('defaultSearchTerm') .
                "', '" . $this->get_field_id('columns') .
                "', '" . $this->get_field_id('rows') .
                "', '" . $this->get_field_id('showImage') .
                "', '" . $this->get_field_id('showPrice') .
                "', '" . $this->get_field_id('showRating') .
                "', '" . $this->get_field_id('design') .
                "', '" . $this->get_field_id('colorTheme') .
                "', '" . $this->get_field_id('outerBackgroundColor') .
                "', '" . $this->get_field_id('innerBackgroundColor') .
                "', '" . $this->get_field_id('backgroundColor') .
                "', '" . $this->get_field_id('borderColor') .
                "', '" . $this->get_field_id('headerTextColor') .
                "', '" . $this->get_field_id('linkedTextColor') .
                "', '" . $this->get_field_id('bodyTextColor') .
                "', '" . $this->get_field_id('roundedCorners') . "'";
        echo '<input type="button" style="float:right" onclick="javascript:previewAmazonWidgetSearch( \'' . $wpaa->getPluginPath( '/servlet/preview.php') . '\', '  . $jsParams . ');" value="' . __("Preview Widget") . '" />';
        ?>
        <div style="clear:both"></div>
</div>
<script type="text/javascript">
    var wsPreview = true;
    if( window.changeAmazonDesign ) {

    } else {
        function changeAmazonWidgetDesign( id, theme_id, ob_id, ib_id, bg_id, br_id, rc_id ) {
            var value = jQuery( "#" + id ).val();
            if( value == "1" ) {
                jQuery('#' + theme_id ).find('option').remove().end()
                    .append('<?php
                        $options = "";
                        $colorThemes = AmazonWidget_Design::getDesignColorThemes( "1" );
                        foreach( $colorThemes as $key => $value ) {
                            $options .= '<option value="' . $key . '" >' . $value . '</option>';
                        }
                        echo $options;
                    ?>').val('Blues');
                jQuery( "#" + ob_id).removeAttr('disabled');
                jQuery( "#" + ib_id).removeAttr('disabled');
                jQuery( "#" + bg_id).attr('disabled','disabled');
                jQuery( "#" + br_id).attr('disabled','disabled');
                jQuery( "#" + rc_id).removeAttr('disabled');
            } else if ( value == "2" ) {
                jQuery('#' + theme_id).find('option').remove().end()
                    .append('<?php
                        $options = "";
                        $colorThemes = AmazonWidget_Design::getDesignColorThemes( "2" );
                        foreach( $colorThemes as $key => $value ) {
                            $options .= '<option value="' . $key . '" >' . $value . '</option>';
                        }
                        echo $options;
                    ?>').val('Default');
                jQuery( "#" + ob_id).removeAttr('disabled');
                jQuery( "#" + ib_id).attr('disabled','disabled');
                jQuery( "#" + bg_id).removeAttr('disabled');
                jQuery( "#" + br_id).removeAttr('disabled');
                jQuery( "#" + rc_id).attr('disabled','disabled');
            } else if ( value == "3" ) {
                jQuery('#' + theme_id).find('option').remove().end()
                    .append('<?php
                        $options = "";
                        $colorThemes = AmazonWidget_Design::getDesignColorThemes( "3" );
                        foreach( $colorThemes as $key => $value ) {
                            $options .= '<option value="' . $key . '" >' . $value . '</option>';
                        }
                        echo $options;
                    ?>').val('Peppermint');
                jQuery( "#" + ob_id).attr('disabled','disabled');
                jQuery( "#" + ib_id).attr('disabled','disabled');
                jQuery( "#" + bg_id).attr('disabled','disabled');
                jQuery( "#" + br_id).attr('disabled','disabled');
                jQuery( "#" + rc_id).attr('disabled','disabled');
            } else if ( value == "4" ) {
                jQuery('#' + theme_id ).find('option').remove().end()
                    .append('<?php
                        $options = "";
                        $colorThemes = AmazonWidget_Design::getDesignColorThemes( "4" );
                        foreach( $colorThemes as $key => $value ) {
                            $options .= '<option value="' . $key . '" >' . $value . '</option>';
                        }
                        echo $options;
                    ?>').val('Onyx');
                jQuery( "#" + ob_id).attr('disabled','disabled');
                jQuery( "#" + ib_id).attr('disabled','disabled');
                jQuery( "#" + bg_id).attr('disabled','disabled');
                jQuery( "#" + br_id).attr('disabled','disabled');
                jQuery( "#" + rc_id).attr('disabled','disabled');
            } else {
                jQuery('#' + theme_id).find('option').remove().end()
                    .append('<?php
                        $options = "";
                        $colorThemes = AmazonWidget_Design::getDesignColorThemes( "5" );
                        foreach( $colorThemes as $key => $value ) {
                            $options .= '<option value="' . $key . '" >' . $value . '</option>';
                        }
                        echo $options;
                    ?>').val('BrushedSteel');
                jQuery( "#" + ob_id).attr('disabled','disabled');
                jQuery( "#" + ib_id).attr('disabled','disabled');
                jQuery( "#" + bg_id).attr('disabled','disabled');
                jQuery( "#" + br_id).attr('disabled','disabled');
                jQuery( "#" + rc_id).attr('disabled','disabled');
            }
        }
        function previewAmazonWidgetSearch( path, width, height, marketPlace,
                searchIndex, defaultSearchTerm, columns, rows,
                showImage, showPrice, showRating, design, colorTheme,
                outerBackgroundColor, innerBackgroundColor,
                backgroundColor, borderColor, headerTextColor,
                linkedTextColor, bodyTextColor, roundedCorners )
        {
            var queryStr = '?widget=Search' + 
                '&width=' + jQuery( "#" + width ).val() +
                '&height=' + jQuery( "#" + height ).val() +
                "&marketPlace=" + jQuery( "#" + marketPlace ).val() +
                '&searchIndex=' + jQuery( "#" + searchIndex ).val() +
                '&defaultSearchTerm=' + jQuery( "#" + defaultSearchTerm ).val() +
                '&columns=' + jQuery( "#" + columns ).val() +
                '&rows=' + jQuery( "#" + rows ).val() +
                '&showImage=' + jQuery( "#" + showImage + ":checked" ).val() +
                '&showPrice=' + jQuery( "#" + showPrice + ":checked" ).val() +
                '&showRating=' + jQuery( "#" + showRating + ":checked" ).val() +
                '&design=' + jQuery( "#" + design ).val() +
                '&colorTheme=' + jQuery( "#" + colorTheme ).val() +
                '&outerBackgroundColor=' + encodeURIComponent(jQuery( "#" + outerBackgroundColor ).val()) +
                '&innerBackgroundColor=' + encodeURIComponent(jQuery( "#" + innerBackgroundColor ).val()) +
                '&backgroundColor=' + encodeURIComponent(jQuery( "#" + backgroundColor ).val()) +
                '&borderColor=' + encodeURIComponent(jQuery( "#" + borderColor ).val()) +
                '&headerTextColor=' + encodeURIComponent(jQuery( "#" + headerTextColor ).val()) +
                '&linkedTextColor=' + encodeURIComponent(jQuery( "#" + linkedTextColor ).val()) +
                '&bodyTextColor=' + encodeURIComponent(jQuery( "#" + bodyTextColor ).val()) +
                '&roundedCorners=' + jQuery( "#" + roundedCorners + ":checked" ).val();
            jQuery.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'          : 'none',
			'transitionOut'         : 'none',
			'title'			: "Search Preview",
			'href'			: encodeURI(path + queryStr),
			'type'			: 'iframe'
		});
            return false;
        }
    }
    jQuery( "#<?php echo $this->get_field_id('design');?>" ).change();
    jQuery('#<?php echo $this->get_field_id('colorTheme');?>').val("<?php echo $colorTheme; ?>");
</script>
        <?php
    }

} // class Widget_Amazon_Search