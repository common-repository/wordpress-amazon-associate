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
        previewWidget();
    },

    insert : function() {
        var content = '[amazon_product_cloud title="' + jQuery('#title').val() + '" ';
        content += ' market_place="' + jQuery('#market_place').val() + '" ';
        content += ' category="' + jQuery('#category').val() + '" ';
        content += ' height="' + jQuery('#height').val() + '" ';
        content += ' width="' + jQuery('#width').val() + '" ';
        if( jQuery('#show_title:checked').val() != undefined ) {
            content += ' show_title="True" ';
        } else {
            content += ' show_title="False"';
        }
        if( jQuery('#show_popovers:checked').val() != undefined ) {
            content += ' show_popovers="True" ';
        } else {
            content += ' show_popovers="False"';
        }
        content += ' background_color="' + jQuery('#background_color').val() + '" ';
        content += ' hover_background_color="' + jQuery('#hover_background_color').val() + '" ';
        content += ' popover_border_color="' + jQuery('#popover_border_color').val() + '" ';
        content += ' hover_text_color="' + jQuery('#hover_text_color').val() + '" ';
        content += ' title_text_color="' + jQuery('#title_text_color').val() + '" ';
        content += ' title_font="' + jQuery('#title_font').val() + '" ';
        content += ' title_font_size="' + jQuery('#title_font_size').val() + '" ';
        content += ' cloud_text_color="' + jQuery('#cloud_text_color').val() + '" ';
        content += ' cloud_font="' + jQuery('#cloud_font').val() + '" ';
        content += ' cloud_font_size="' + jQuery('#cloud_font_size').val() + '" ';
        if( jQuery('#curved_corners:checked').val() != undefined ) {
            content += ' curved_corners="True" ';
        } else {
            content += ' curved_corners="False"';
        }
        if( jQuery('#show_amazon_logo_as_text:checked').val() != undefined ) {
            content += ' show_amazon_logo_as_text="True" ';
        } else {
            content += ' show_amazon_logo_as_text="False"';
        }
        content += '/]';
        tinyMCEPopup.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(AmazonWidgetDialog.init, AmazonWidgetDialog);