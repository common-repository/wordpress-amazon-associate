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

$args = AmazonWidget_Omakase::getDefaultOptions();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Insert Amazon Omakase Widget</title>
        <script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/amazon-omakase.js"></script>
        <link rel="stylesheet" type="text/css" href="css/amazon.css" />
    </head>
    <body>
        <table border="0" cellspacing="0" cellpadding="0" style="width:100%">
            <tr>
                <td valign="top" width="200">
                    <h3>Basic Properties</h3>
                    <label>Size:</label><br/>
                    <select class="widefat" name="size" id="size">
                        <?php
                        foreach (AmazonWidget_Omakase::getBannerSizes() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['size']) && $args['size'] == $option_value) {
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
                    <label>Locale:</label><br/>
                    <select class="widefat" name="locale" id="locale">
                         <?php
                        foreach (AmazonWidget_Omakase::getAvailableLocales() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['locale']) && $args['locale'] == $option_value) {
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
                    <label>Logo Display:</label><br/>
                    <select class="widefat" name="ad_logo" id="ad_logo">
                         <?php
                        foreach (AmazonWidget_Omakase::getLogoOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_logo']) && $args['ad_logo'] == $option_value) {
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
                    <label>Product Images:</label><br/>
                    <select class="widefat" name="ad_product_images" id="ad_product_images">
                         <?php
                        foreach (AmazonWidget_Omakase::getImagesOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_product_images']) && $args['ad_product_images'] == $option_value) {
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
                    <label>Link Target:</label><br/>
                    <select class="widefat" name="ad_link_target" id="ad_link_target">
                        <?php
                        foreach (AmazonWidget_Omakase::getOpenOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_link_target']) && $args['ad_link_target'] == $option_value) {
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
                    <label>Prices:</label><br/>
                    <select class="widefat" name="ad_price" id="ad_price">
                        <?php
                        foreach (AmazonWidget_Omakase::getPriceOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_price']) && $args['ad_price'] == $option_value) {
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
                    <label>Border:</label><br/>
                    <select class="widefat" name="ad_border" id="ad_border">
                        <?php
                        foreach (AmazonWidget_Omakase::getBorderOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_border']) && $args['ad_border'] == $option_value) {
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
                    <label>Amazon Discount:</label><br/>
                    <select class="widefat" name="ad_discount" id="ad_discount">
                        <?php
                        foreach (AmazonWidget_Omakase::getDiscountOptions() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['ad_discount']) && $args['ad_discount'] == $option_value) {
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
                    <label>Border Color:</label><br/>
                    <input class="widefat" id="color_border" name="color_border" size="30" value="<?php if( isset($args['color_border']) ){ echo $args['color_border'];} ?>" type="text" />
                    <br/>
                    <label>Background Color:</label><br/>
                    <input class="widefat" id="color_background" name="color_background" size="30" value="<?php if( isset($args['color_background']) ){ echo $args['color_background'];} ?>" type="text" />
                    <br/>
                    <label>Details Text Color:</label><br/>
                    <input class="widefat" id="color_text" name="color_text" size="30" value="<?php if( isset($args['color_text']) ){ echo $args['color_text'];} ?>" type="text" />
                    <br/>
                    <label>Link Color:</label><br/>
                    <input class="widefat" id="color_link" name="color_link" size="30" value="<?php if( isset($args['color_link']) ){ echo $args['color_link'];} ?>" type="text" />
                    <br/>
                    <label>Price Color:</label><br/>
                    <input class="widefat" id="color_price" name="color_price" size="30" value="<?php if( isset($args['color_price']) ){ echo $args['color_price'];} ?>" type="text" />
                    <br/>
                    <label>Amazon.com Text Color:</label><br/>
                    <input class="widefat" id="color_logo" name="color_logo" size="30" value="<?php if( isset($args['color_logo']) ){ echo $args['color_logo'];} ?>" type="text" />
                    <br/>
                    <script type="text/javascript">
                        function previewWidget( ) {
                             var queryStr = '?widget=Omakase' +
                                '&size=' + jQuery( "#size" ).val() +
                                "&locale=" + jQuery( "#locale" ).val() +
                                '&ad_logo=' + jQuery( "#ad_logo" ).val() +
                                '&ad_product_images=' + jQuery( "#ad_product_images" ).val() +
                                '&ad_link_target=' + jQuery( "#ad_link_target" ).val() +
                                '&ad_price=' + jQuery( "#ad_price" ).val() +
                                '&ad_border=' + jQuery( "#ad_border" ).val() +
                                '&ad_discount=' + jQuery( "#ad_discount" ).val() +
                                '&color_border=' + encodeURIComponent(jQuery( "#color_border" ).val()) +
                                '&color_background=' + encodeURIComponent(jQuery( "#color_background" ).val()) +
                                '&color_text=' + encodeURIComponent(jQuery( "#color_text" ).val()) +
                                '&color_link=' + encodeURIComponent(jQuery( "#color_link" ).val()) +
                                '&color_price=' + encodeURIComponent(jQuery( "#color_price" ).val()) +
                                '&color_logo=' + encodeURIComponent(jQuery( "#color_logo" ).val());
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
                <td colspan="2">
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