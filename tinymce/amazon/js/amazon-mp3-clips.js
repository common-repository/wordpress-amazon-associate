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
        jQuery( "#title" ).val( tinyMCEPopup.editor.selection.getContent({format : 'text'}) );
        previewWidget();
    },

    insert : function() {
        var value = jQuery( "#widgetType" ).val();
        var content = '[amazon_mp3_clips widget_type="' + value + '" ';
        content += ' width="' + jQuery('#width').val() + '" ';
        content += ' height="' + jQuery('#height').val() + '" ';
        content += ' title="' + jQuery('#title').val() + '" ';
        content += ' market_place="' + jQuery('#marketPlace').val() + '" ';
        if( jQuery('#shuffleTracks:checked').val() != undefined ) {
            content += ' shuffle_tracks="' + jQuery('#shuffleTracks:checked').val() + '" ';
        } else {
            content += ' shuffle_tracks="False"';
        }
        content += ' max_results="' + jQuery('#maxResults').val() + '" ';
        // output options per widget type
        if( value == "ASINList" ) {
            content += ' asin="' + jQuery('#ASIN').val() + '" ';
        } else if ( value == "SearchAndAdd" ) {
            content += ' keywords="' + jQuery('#keywords').val() + '" ';
            content += ' browse_node="' + jQuery('#browseNode').val() + '" ';
        } else {
            content += ' browse_node="' + jQuery('#browseNode').val() + '" ';
        }

        content += '/]';
        tinyMCEPopup.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.close();
    }
};

tinyMCEPopup.onInit.add(AmazonWidgetDialog.init, AmazonWidgetDialog);