<?php
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

// load WordPress
require_once( '../../../../../wp-load.php');

$args = AmazonWidget_ProductCloud::getDefaultShortCodeOptions();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Insert Amazon Product Cloud Widget</title>
        <script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/amazon-product-cloud.js"></script>
        <link rel="stylesheet" type="text/css" href="css/amazon.css" />
    </head>
    <body>
        <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
            <tr>
                <td valign="top" width="200">
                    <h3>Basic Properties</h3>
                    <label>Title:</label><br/>
                    <input class="widefat" id="title" name="title" size="30" value="<?php if( isset($args['title']) ){ echo $args['title'];} ?>" type="text" />
                    <br/>
                    <label>Market Place:</label><br/>
                    <select class="widefat" name="market_place" id="market_place">
                        <?php
                        foreach (AmazonWidget_Abstract::getAvailableMarkets() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['market_place']) && $args['market_place'] == $option_value) {
                                $selected_txt = ' SELECTED';
                            }
                            if ($option_text == '') {
                                $option_text = $option_value;
                            }
                            echo '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
                        }
                        ?>
                    </select>
                    <br/>
                    <h3>Widget Options</h3>
                    <label>Category:</label><br/>
                    <select class="widefat" name="category" id="category">
                         <?php
                        foreach (AmazonProduct_SearchIndex::SupportedSearchIndexes() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['category']) && $args['category'] == $option_value) {
                                $selected_txt = ' SELECTED';
                            }
                            if ($option_text == '') {
                                $option_text = $option_value;
                            }
                            echo '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
                        }
                        ?>
                    </select>
                    <br/>
                    <label>Width:</label<br/>
                    <input class="widefat" id="width" name="width" size="30" value="<?php if( isset($args['width']) ){ echo $args['width'];} ?>" type="text" />
                    <br/>
                    <label>Height:</label<br/>
                    <input class="widefat" id="height" name="height" size="30" value="<?php if( isset($args['height']) ){ echo $args['height'];} ?>" type="text" />
                    <br/>
                    <label>Show Title:</label>
                    <input class="checkbox" value="True" id="show_title" name="show_title" <?php if( isset($args['show_title']) && $args['show_title'] === true ) { echo 'checked="checked"'; } ?> type="checkbox" />
                    <br/>
                    <label>Show Product Preview:</label>
                    <input class="checkbox" value="True" id="show_popovers" name="show_popovers" <?php if( isset($args['show_popovers']) && $args['show_popovers'] === true ) { echo 'checked="checked"'; } ?> type="checkbox" />
                    <br/>
                </td>
                <td valign="top" width="200">
                    <h3>Color &amp; Design Options</h3>
                    <label>Background Color:</label><br/>
                    <input class="widefat" id="background_color" name="background_color" size="30" value="<?php if( isset($args['background_color']) ){ echo $args['background_color'];} ?>" type="text" />
                    <br/>
                    <label>Hover Background Color:</label><br/>
                    <input class="widefat" id="hover_background_color" name="hover_background_color" size="30" value="<?php if( isset($args['hover_background_color']) ){ echo $args['hover_background_color'];} ?>" type="text" />
                    <br/>
                    <label>Pop-over Border Color:</label><br/>
                    <input class="widefat" id="popover_border_color" name="popover_border_color" size="30" value="<?php if( isset($args['popover_border_color']) ){ echo $args['popover_border_color'];} ?>" type="text" />
                    <br/>
                    <label>Hover Text Color:</label><br/>
                    <input class="widefat" id="hover_text_color" name="hover_text_color" size="30" value="<?php if( isset($args['hover_text_color']) ){ echo $args['hover_text_color'];} ?>" type="text" />
                    <br/>
                    <label>Title Text Color:</label><br/>
                    <input class="widefat" id="title_text_color" name="title_text_color" size="30" value="<?php if( isset($args['title_text_color']) ){ echo $args['title_text_color'];} ?>" type="text" />
                    <br/>
                    <label>Title Text Font:</label><br/>
                    <select class="widefat" name="title_font" id="title_font">
                        <?php
                        foreach (AmazonWidget_ProductCloud::getAvailableFonts() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['title_font']) && $args['title_font'] == $option_value) {
                                $selected_txt = ' SELECTED';
                            }
                            if ($option_text == '') {
                                $option_text = $option_value;
                            }
                            echo '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
                        }
                        ?>
                    </select>
                    <br/>
                    <label>Title Text Size:</label><br/>
                    <input class="widefat" id="title_font_size" name="title_font_size" size="30" value="<?php if( isset($args['title_font_size']) ){ echo $args['title_font_size'];} ?>" type="text" />
                    <br/>
                    <label>Link Text Color:</label><br/>
                    <input class="widefat" id="cloud_text_color" name="cloud_text_color" size="30" value="<?php if( isset($args['cloud_text_color']) ){ echo $args['cloud_text_color'];} ?>" type="text" />
                    <br/>
                    <label>Link Text Font:</label><br/>
                    <select class="widefat" name="cloud_font" id="cloud_font">
                        <?php
                        foreach (AmazonWidget_ProductCloud::getAvailableFonts() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['title_font']) && $args['title_font'] == $option_value) {
                                $selected_txt = ' SELECTED';
                            }
                            if ($option_text == '') {
                                $option_text = $option_value;
                            }
                            echo '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
                        }
                        ?>
                    </select>
                    <br/>
                    <label>Link Text Size:</label><br/>
                    <input class="widefat" id="cloud_font_size" name="cloud_font_size" size="30" value="<?php if( isset($args['cloud_font_size']) ){ echo $args['cloud_font_size'];} ?>" type="text" />
                    <br/>
                    <label>Rounded Corners:</label>
                    <input class="checkbox" value="True" id="curved_corners" name="curved_corners" <?php if( isset($args['curved_corners']) && $args['curved_corners'] === true ) { echo 'checked="checked"'; } ?> type="checkbox" />
                    <br/>
                    <label>Amazon.com logo as Text:</label>
                    <input class="checkbox" value="True" id="show_amazon_logo_as_text" name="show_amazon_logo_as_text" <?php if( isset($args['show_amazon_logo_as_text']) && $args['show_amazon_logo_as_text'] === true ) { echo 'checked="checked"'; } ?> type="checkbox" />
                    <br/>
                    <script type="text/javascript">
                        function previewWidget( ) {
                             var queryStr = '?widget=ProductCloud' +
                                '&title=' + jQuery( "#title" ).val() +
                                "&marketPlace=" + jQuery( "#market_place" ).val() +
                                '&width=' + jQuery( "#width" ).val() +
                                '&height=' + jQuery( "#height" ).val() +
                                '&category=' + jQuery( "#category" ).val() +
                                '&showTitle=' + jQuery( "#show_title:checked" ).val() +
                                '&showPopovers=' + jQuery( "#show_popovers:checked" ).val() +
                                '&backgroundColor=' + encodeURIComponent(jQuery( "#background_color" ).val()) +
                                '&hoverBackgroundColor=' + encodeURIComponent(jQuery( "#hover_background_color" ).val()) +
                                '&popoverBorderColor=' + encodeURIComponent(jQuery( "#popover_border_color" ).val()) +
                                '&hoverTextColor=' + encodeURIComponent(jQuery( "#hover_text_color" ).val()) +
                                '&titleTextColor=' + encodeURIComponent(jQuery( "#title_text_color" ).val()) +
                                '&cloudTextColor=' + encodeURIComponent(jQuery( "#cloud_text_color" ).val()) +
                                '&titleFont=' + jQuery( "#title_font" ).val() +
                                '&titleFontSize=' + jQuery( "#title_font_size" ).val() +
                                '&cloudFont=' + jQuery( "#cloud_font" ).val() +
                                '&cloudFontSize=' + jQuery( "#cloud_font_size" ).val() +
                                '&curvedCorners=' + jQuery( "#curved_corners:checked" ).val() +
                                '&showAmazonLogoAsText=' + jQuery( "#show_amazon_logo_as_text:checked" ).val()
                            var url = '<?php echo $wpaa->getPluginPath( '/servlet/preview.php'); ?>';
                            jQuery( '#widgetPreview' ).html( '<iframe id="previewFrame" scrolling="auto" frameborder="0" hspace="0" height="400" style="width:100%" src="' + url + queryStr + '" ></iframe>' );
                            return false;
                        }
                    </script>
                </td>
                <td valign="top">
                    <h3>Preview</h3>
                    <div id="widgetPreview">
                        --
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="mceActionPanel">
                        <input class="updateButton" onclick="previewWidget() " value="Preview" type="button" />
                        <input style="float: right;" type="button" id="insert" name="insert" value="{#insert}" onclick="AmazonWidgetDialog.insert();" />
                        <input style="float: right;" type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
                        <div style="clear:both"></div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>