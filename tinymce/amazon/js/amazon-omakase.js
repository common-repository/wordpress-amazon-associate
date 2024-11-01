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
        var content = '[amazon_omakase size="' + jQuery('#size').val() + '" ';
        content += ' locale="' + jQuery('#locale').val() + '" ';
        content += ' ad_logo="' + jQuery('#ad_logo').val() + '" ';
        content += ' ad_product_images="' + jQuery('#ad_product_images').val() + '" ';
        content += ' ad_link_target="' + jQuery('#ad_link_target').val() + '" ';
        content += ' ad_price="' + jQuery('#ad_price').val() + '" ';
        content += ' ad_border="' + jQuery('#ad_border').val() + '" ';
        content += ' ad_discount="' + jQuery('#ad_discount').val() + '" ';
        content += ' color_border="' + jQuery('#color_border').val() + '" ';
        content += ' color_background="' + jQuery('#color_background').val() + '" ';
        content += ' color_text="' + jQuery('#color_text').val() + '" ';
        content += ' color_link="' + jQuery('#color_link').val() + '" ';
        content += ' color_price="' + jQuery('#color_price').val() + '" ';
        content += ' color_logo="' + jQuery('#color_logo').val() + '" ';
        content += '/]';
        tinyMCEPopup.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(AmazonWidgetDialog.init, AmazonWidgetDialog);