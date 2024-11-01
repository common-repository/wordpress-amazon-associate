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

var AmazonProductDialog = {

    Items : null,
    product : null,

    init : function() {
        jQuery( "#LinkText" ).val( tinyMCEPopup.editor.selection.getContent({format : 'text'}) );
        jQuery( "#AltText" ).val( tinyMCEPopup.editor.selection.getContent({format : 'text'}) );
        jQuery("#tabs").tabs();
        jQuery("#Type").change( function() {
            var productType = jQuery( "#Type" ).val();
            if( productType == "Image" ) {
                jQuery( ".TextType").hide();
                jQuery( ".EnhancedType").hide();
                jQuery( ".ImageType").show();
            } else if( productType == "Text" ) {
                jQuery( ".EnhancedType").hide();
                jQuery( ".ImageType").hide();
                jQuery( ".TextType").show();
            } else {
                jQuery( ".ImageType").hide();
                jQuery( ".TextType").hide();
                jQuery( ".EnhancedType").show();
            }
        });
    },

    insert : function() {
        var content = "";
        // Extended
        if( jQuery( "#Type").val() == "Enhanced" ) {
            content = '[amazon_enhanced asin="' + jQuery("#ASIN").val() + '" ';
			content += 'container="' + jQuery("#Container").val() + '" container_class="' + jQuery("#ContainerClass").val() + '" ';
            if( jQuery('#newWindow:checked').val() == undefined ) {
                content += 'new_window="false" ';
            }
            if( jQuery('#showBorder:checked').val() == undefined ) {
                content += 'show_border="false" ';
            }
            if( jQuery('#largerImage:checked').val() == undefined ) {
                content += 'larger_image="false" ';
            }
            content += 'price="' + jQuery( "#price" ).val() + '" ';
            content += 'background_color="' + jQuery( "#backgroundColor").val() + '" ';
            content += 'link_color="' + jQuery( "#textColor").val() + '" ';
            content += 'text_color="' + jQuery( "#linkColor").val() + '" ';
            content += '/]';
        // Image
        } else if( jQuery( "#Type").val() == "Image" ) {
            if( jQuery('#ShortCode:checked').val() != undefined ) {
                content = '[amazon_image id="' + jQuery("#ASIN").val() + '" target="' + jQuery("#Target").val() + '" size="' + jQuery("#ProductImage").val() + '" link="true" ';
                content += ' container="' + jQuery("#Container").val() + '" container_class="' + jQuery("#ContainerClass").val() + '" ';
                if( jQuery('#Locale').val() != "" ) {
                    content += 'locale="' + jQuery("#Locale").val() + '" ';
                }
                content += ']' + jQuery("#AltText").val() + '[/amazon_image]';
            } else {
                content = '[amazon_link id="' + jQuery("#ASIN").val() + '" target="' + jQuery("#Target").val() +  '" ';
                if( jQuery('#Locale').val() != "" ) {
                    content += 'locale="' + jQuery("#Locale").val() + '" ';
                }
                content += ' container="' + jQuery("#Container").val() + '" container_class="' + jQuery("#ContainerClass").val() + '" ';
                content += ']';
                var imgSize = jQuery("#ProductImage").val();
                content += '<img alt="' + jQuery("#AltText").val() + '" src="';
                if( imgSize == "Small" ) {
                    content += this.product.SmallImage.URL;
                } else if( imgSize == "Medium" ) {
                    content += this.product.MediumImage.URL;
                } else if( imgSize == "Large" ) {
                    content += this.product.LargeImage.URL;
                }
                content += '" />';
                content += '[/amazon_link]';
            }
        // Link
        } else {
            content = '[amazon_link id="' + jQuery("#ASIN").val() + '" target="' + jQuery("#Target").val() +  '" ';
            if( jQuery('#Locale').val() != "" ) {
                content +='locale="' + jQuery("#Locale").val() + '" ';
            }
            content += ' container="' + jQuery("#Container").val() + '" container_class="' + jQuery("#ContainerClass").val() + '" ';
            content += ']' + jQuery("#LinkText").val() + '[/amazon_link]';
        }
        tinyMCEPopup.execCommand('mceInsertContent', false, content);
        tinyMCEPopup.close();
    },

    updateProduct : function( id ) {
        this.product = this.Items[id];
        jQuery( "#ASIN" ).val( this.product.ASIN );
        jQuery( "#AltText" ).val( this.product.ItemAttributes.Title );

        jQuery('#Type').find('option').remove().end()
                .append('<option value="Text">Text</option>')
                .append('<option value="Enhanced">Enhanced</option>')
                .val('Text');
        if( 'ImageSets' in this.product ) {
            var select_txt = '<select id="ProductImage" name="ProductImage" >';
            select_txt += '<option value="Small">Small: ' + this.product.SmallImage.Width + 'px X ' + this.product.SmallImage.Height + 'px</option>';
            select_txt += '<option value="Medium">Medium: ' + this.product.MediumImage.Width + 'px X ' + this.product.MediumImage.Height + 'px</option>';
            select_txt += '<option value="Large">Large: ' + this.product.LargeImage.Width + 'px X ' + this.product.LargeImage.Height + 'px</option>';
            select_txt += "</select>";
            jQuery( "#SelectImageArea").html( select_txt );
            jQuery('#Type').find('option').end()
                .append('<option value="Image">Image</option>')
                .val('Text');
        }
        jQuery("#tabs").tabs( "select", 0 );
    },

    doProductSearch : function( ) {
        var Keywords = jQuery("#Keywords").val();
        var SearchIndex = jQuery("#SearchIndex").val();
        var date=new Date();
        jQuery.ajax({
            url: "../../servlet/index.php",
            type: 'POST',
            dataType: 'jsonp',
            data: 'Action=ItemSearch&SearchIndex=' + SearchIndex + '&Keywords=' + Keywords + '&Random=' + date.getTime(),
            success: function(data) {
                if( data.IsValid == "True" ) {
                    AmazonProductDialog.Items = data.Items;
                    var html_txt = '<table border="1" cellspacing="0" cellpadding="0" class="resultTable">';
                    html_txt += "<tr><th>Select</th><th>ASIN</th><th>Image</th><th>Title</th><th>Price (new)</th></tr>";
                    jQuery.each(data.Items, function(i,item){
                        var row_txt = "<tr>";
                        row_txt += '<td><div class="mceActionPanel"><input type="button" class="updateButton" value="Select" onclick="AmazonProductDialog.updateProduct(' + i + ');" /></div></td>';
                        // append ASIN
                        row_txt += '<td><a target="_blank" href="' + item.DetailPageURL + '" >' + item.ASIN + "</a></td>";
                        // append Image
                        if( 'SmallImage' in item ) {
                            row_txt += '<td><img src="' + item.SmallImage.URL + '" /></td>';
                        } else {
                            row_txt += '<td></td>';
                        }
                        // append Title
                        row_txt += "<td>" + item.ItemAttributes.Title + "</td>";
                         // append Price
                        if( 'OfferSummary' in item && 'LowestNewPrice' in item.OfferSummary && 'FormattedPrice' in item.OfferSummary.LowestNewPrice) {
                          row_txt += "<td>" + item.OfferSummary.LowestNewPrice.FormattedPrice + "</td>";
                        } else {
                            row_txt += '<td>--</td>';
                        }
                        row_txt += "</tr>";
                        html_txt += row_txt;
                    });
                    html_txt += '</table>';
                    jQuery( "#SearchResults" ).html(  html_txt );
                } else {
                    jQuery( "#SearchResults" ).html( '<div>No Results found for submitted Search, please try again with different criteria.</div>' );
                }
            }
        });
    }
};

tinyMCEPopup.onInit.add(AmazonProductDialog.init, AmazonProductDialog);