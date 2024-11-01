/*
 * copyright (c) 2010 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of WordPress Amazon Associate Plugin.
 *
 * WordPress Amazon Associate is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Sofatware Foundation, either version 3 of the
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
tinyMCEPopup.requireLangPack();

var AmazonWidgetDialog = {

    init : function() {
        jQuery( "#defaultSearchTerm" ).val( tinyMCEPopup.editor.selection.getContent({format : 'text'}) );
        previewWidget();
    },

    insert : function() {
        var content = '[amazon_search design="' + jQuery('#design').val() + '" ';
        content += ' width="' + jQuery('#width').val() + '" ';
        content += ' market_place="' + jQuery('#marketPlace').val() + '" ';
	content += ' color_theme="' + jQuery('#colorTheme').val() + '" ';
        content += ' default_search_term="' + jQuery('#defaultSearchTerm').val() + '" ';
        content += ' search_index="' + jQuery('#searchIndex').val() + '" ';
        content += ' columns="' + jQuery('#columns').val() + '" ';
        content += ' rows="' + jQuery('#rows').val() + '" ';
        content += ' outer_background_color="' + jQuery('#outerBackgroundColor').val() + '" ';
        content += ' inner_background_color="' + jQuery('#innerBackgroundColor').val() + '" ';
        content += ' background_color="' + jQuery('#backgroundColor').val() + '" ';
        content += ' border_color="' + jQuery('#borderColor').val() + '" ';
        content += ' header_text_color="' + jQuery('#headerTextColor').val() + '" ';
        content += ' linked_text_color="' + jQuery('#linkedTextColor').val() + '" ';
        content += ' body_text_color="' + jQuery('#bodyTextColor').val() + '" ';
        var shuffleProducts = jQuery( "#shuffleProducts:checked" ).val();
        if( shuffleProducts != undefined ) {
            content += ' shuffle_products="' + shuffleProducts + '" ';
        } else {
            content += ' shuffle_products="False"';
        }
        var showImage = jQuery( "#showImage:checked" ).val();
        if( showImage != undefined ) {
            content += ' show_image="' + showImage + '" ';
        } else {
            content += ' show_image="False"';
        }
        var showPrice = jQuery( "#showPrice:checked" ).val();
        if( showPrice != undefined ) {
            content += ' show_price="' + showPrice + '" ';
        } else {
            content += ' show_price="False"';
        }
        var showRating = jQuery( "#showRating:checked" ).val();
        if( showRating != undefined ) {
            content += ' show_rating="' + showRating + '" ';
        } else {
            content += ' show_rating="False"';
        }
        var roundedCorners = jQuery( "#roundedCorners:checked" ).val();
        if( roundedCorners != undefined ) {
            content += ' rounded_corners="' + roundedCorners + '" ';
        } else {
            content += ' rounded_corners="False"';
        }
        content += '/]';
        tinyMCEPopup.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(AmazonWidgetDialog.init, AmazonWidgetDialog);