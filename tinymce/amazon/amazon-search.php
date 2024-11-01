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

$args = AmazonWidget_Search::getDefaultOptions();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Insert Amazon Search Widget</title>
        <script type="text/javascript" src="../../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/amazon-search.js"></script>
        <link rel="stylesheet" type="text/css" href="css/amazon.css" />
    </head>
    <body>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td valign="top" width="200">
                    <h3>Basic Properties</h3>
                    <label>Width:</label><br/>
                    <input class="widefat" id="width" name="width" size="30" value="<?php if( isset($args['width']) ){ echo $args['width'];} ?>" type="text" />
                    <br/>
                    <label>Market Place:</label><br/>
                    <select class="widefat" name="marketPlace" id="marketPlace">
                        <?php
                        foreach (AmazonWidget_Abstract::getAvailableMarkets() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['marketPlace']) && $args['marketPlace'] == $option_value) {
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
                    <label>Default Search Term:</label><br/>
                    <input class="widefat" id="defaultSearchTerm" name="defaultSearchTerm" size="30" value="<?php if( isset($args['defaultSearchTerm']) ){ echo $args['defaultSearchTerm'];} ?>" type="text" />
                    <br/>
                    <label>Search Index:</label><br/>
                    <select class="widefat" name="searchIndex" id="searchIndex">
                        <?php
                        foreach (AmazonProduct_SearchIndex::SupportedSearchIndexes() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['searchIndex']) && $args['searchIndex'] == $option_value) {
                                $selected_txt = ' SELECTED';
                            }
                            if ($option_text == '') {
                                $option_text = $option_value;
                            }
                            echo '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
                        }
                        ?>
                    </select><br/>
                    <label>Columns:</label><br/>
                    <input class="widefat" id="columns" name="columns" size="30" value="<?php if( isset($args['columns']) ){ echo $args['columns'];} ?>" type="text" />
                    <br/>
                    <label>Rows:</label><br/>
                    <input class="widefat" id="rows" name="rows" size="30" value="<?php if( isset($args['rows']) ){ echo $args['rows'];} ?>" type="text" />
                    <br/>
                    <label>Shuffle Products:</label>
                    <input class="checkbox" value="True" id="shuffleProducts" name="shuffleProducts" checked="checked" type="checkbox" />
                    <br/>
                    <label>Show Image:</label>
                    <input class="checkbox" value="True" id="showImage" name="showImage" checked="checked" type="checkbox" />
                    <br/>
                    <label>Show Price:</label>
                    <input class="checkbox" value="True" id="showPrice" name="showPrice" checked="checked" type="checkbox" />
                    <br/>
                    <label>Show Rating:</label>
                    <input class="checkbox" value="True" id="showRating" name="showRating" checked="checked" type="checkbox" />
                    <br/>
                </td>
                <td valign="top" width="200">
                    <h3>Design Options</h3>
                    <label>Design:</label><br/>
                    <select class="widefat" onchange=" changeWidget()" name="design" id="design">
                        <?php
                        foreach (AmazonWidget_Design::getAvailableDesigns() as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['design']) && $args['design'] == $option_value) {
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
                    <label>Color Theme:</label><br/>
                    <select class="widefat" name="colorTheme" id="colorTheme">
                        <?php
                        foreach (AmazonWidget_Design::getDesignColorThemes($args['design']) as $option_value => $option_text) {
                            $selected_txt = '';
                            if ( isset($args['colorTheme']) && $args['colorTheme'] == $option_value) {
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
                    <label>Outer Background Color:</label><br/>
                    <input class="widefat" id="outerBackgroundColor" name="outerBackgroundColor" size="30" value="<?php if( isset($args['outerBackgroundColor']) ){ echo $args['outerBackgroundColor'];} ?>" type="text" />
                    <br/>
                    <label>Inner Background Color:</label><br/>
                    <input disabled="disabled" class="widefat" id="innerBackgroundColor" name="innerBackgroundColor" size="30" value="<?php if( isset($args['innerBackgroundColor']) ){ echo $args['innerBackgroundColor'];} ?>" type="text" />
                    <br/>
                    <label>Background Color:</label><br/>
                    <input class="widefat" id="backgroundColor" name="backgroundColor" size="30" value="<?php if( isset($args['backgroundColor']) ){ echo $args['backgroundColor'];} ?>" type="text" />
                    <br/>
                    <label>Border Color:</label><br/>
                    <input class="widefat" id="borderColor" name="borderColor" size="30" value="<?php if( isset($args['borderColor']) ){ echo $args['borderColor'];} ?>" type="text" />
                    <br/>
                    <label>Header Text Color:</label><br/>
                    <input class="widefat" id="headerTextColor" name="headerTextColor" size="30" value="<?php if( isset($args['headerTextColor']) ){ echo $args['headerTextColor'];} ?>" type="text" />
                    <br/>
                    <label>Linked Text Color:</label><br/>
                    <input class="widefat" id="linkedTextColor" name="linkedTextColor" size="30" value="<?php if( isset($args['linkedTextColor']) ){ echo $args['linkedTextColor'];} ?>" type="text" />
                    <br/>
                    <label>Body Text Color:</label><br/>
                    <input class="widefat" id="bodyTextColor" name="bodyTextColor" size="30" value="<?php if( isset($args['bodyTextColor']) ){ echo $args['bodyTextColor'];} ?>" type="text" />
                    <br/>
                    <label>Rounded Corners:</label>
                    <input disabled="disabled" class="checkbox" value="True" id="roundedCorners" name="roundedCorners" type="checkbox" />
                    <br/>
                    <script type="text/javascript">
                        function changeWidget(  ) {
                            var value = jQuery( "#design" ).val();
                            if( value == "1" ) {
                                jQuery('#colorTheme' ).find('option').remove().end()
                                .append('<?php
                                    $options = "";
                                    $colorThemes = AmazonWidget_Design::getDesignColorThemes("1");
                                    foreach ($colorThemes as $key => $value) {
                                        $options .= '<option value="' . $key . '" >' . $value . '</option>';
                                    }
                                    echo $options;
                                    ?>').val('Blues');
                                jQuery( "#outerBackgroundColor").removeAttr('disabled');
                                jQuery( "#innerBackgroundCOlor").removeAttr('disabled');
                                jQuery( "#backgroundColor").attr('disabled','disabled');
                                jQuery( "#borderColor").attr('disabled','disabled');
                                jQuery( "#roundedCorners").removeAttr('disabled');
                            } else if ( value == "2" ) {
                                jQuery('#colorTheme').find('option').remove().end()
                                .append('<?php
                                    $options = "";
                                    $colorThemes = AmazonWidget_Design::getDesignColorThemes("2");
                                    foreach ($colorThemes as $key => $value) {
                                        $options .= '<option value="' . $key . '" >' . $value . '</option>';
                                    }
                                    echo $options;
                                    ?>').val('Default');
                                jQuery( "#outerBackgroundColor").removeAttr('disabled');
                                jQuery( "#innerBackgroundColor").attr('disabled','disabled');
                                jQuery( "#backgroundColor").removeAttr('disabled');
                                jQuery( "#borderColor").removeAttr('disabled');
                                jQuery( "#roundedCorners").attr('disabled','disabled');
                            } else if ( value == "3" ) {
                                jQuery('#colorTheme').find('option').remove().end()
                                .append('<?php
                                    $options = "";
                                    $colorThemes = AmazonWidget_Design::getDesignColorThemes("3");
                                    foreach ($colorThemes as $key => $value) {
                                        $options .= '<option value="' . $key . '" >' . $value . '</option>';
                                    }
                                    echo $options;
                                    ?>').val('Peppermint');
                                jQuery( "#outerBackgroundColor").attr('disabled','disabled');
                                jQuery( "#innerBackgroundColor").attr('disabled','disabled');
                                jQuery( "#backgroundColor").attr('disabled','disabled');
                                jQuery( "#borderColor").attr('disabled','disabled');
                                jQuery( "#roundedCorners").attr('disabled','disabled');
                            } else if ( value == "4" ) {
                                jQuery('#colorTheme' ).find('option').remove().end()
                                .append('<?php
                                    $options = "";
                                    $colorThemes = AmazonWidget_Design::getDesignColorThemes("4");
                                    foreach ($colorThemes as $key => $value) {
                                        $options .= '<option value="' . $key . '" >' . $value . '</option>';
                                    }
                                    echo $options;
                                    ?>').val('Onyx');
                                jQuery( "#outerBackgroundColor").attr('disabled','disabled');
                                jQuery( "#innerBackgroundColor").attr('disabled','disabled');
                                jQuery( "#backgroundColor").attr('disabled','disabled');
                                jQuery( "#borderColor").attr('disabled','disabled');
                                jQuery( "#roundedCorners").attr('disabled','disabled');
                            } else {
                                jQuery('#colorTheme').find('option').remove().end()
                                .append('<?php
                                    $options = "";
                                    $colorThemes = AmazonWidget_Design::getDesignColorThemes("5");
                                    foreach ($colorThemes as $key => $value) {
                                        $options .= '<option value="' . $key . '" >' . $value . '</option>';
                                    }
                                    echo $options;
                                    ?>').val('BrushedSteel');
                                    jQuery( "#outerBackgroundColor").attr('disabled','disabled');
                                    jQuery( "#innerBackgroundColor").attr('disabled','disabled');
                                    jQuery( "#backgroundColor").attr('disabled','disabled');
                                    jQuery( "#borderColor").attr('disabled','disabled');
                                    jQuery( "#roundedCorners").attr('disabled','disabled');
                            }
                        }

                        function previewWidget( ) {
                            var queryStr = '?widget=Search' +
                                '&width=' + jQuery( "#width").val() +
                                "&marketPlace=" + jQuery( "#marketPlace").val() +
                                '&defaultSearhTerm=' + jQuery( "#defaultSearchTerm").val() +
                                '&searchIndex=' + jQuery( "#searchIndex").val() +
                                '&ASIN=' + jQuery( "#ASIN").val() +
                                '&columns=' + jQuery( "#columns").val() +
                                '&rows=' + jQuery( "#rows").val() +
                                '&design=' + jQuery( "#design").val() +
                                '&colorTheme=' + jQuery( "#colorTheme").val() +
                                '&outerBackgroundColor=' + encodeURIComponent(jQuery( "#outerBackgroundColor").val()) +
                                '&innerBackgroundColor=' + encodeURIComponent(jQuery( "#innerBackgroundColor").val()) +
                                '&backgroundColor=' + encodeURIComponent(jQuery( "#backgroundColor").val()) +
                                '&borderColor=' + encodeURIComponent(jQuery( "#borderColor").val()) +
                                '&headerTextColor=' + encodeURIComponent(jQuery( "#headerTextColor").val()) +
                                '&linkedTextColor=' + encodeURIComponent(jQuery( "#linkedTextColor").val()) +
                                '&bodyTextColor=' + encodeURIComponent(jQuery( "#bodyTextColor").val());
                            var shuffleProducts = jQuery( "#shuffleProducts:checked" ).val();
                            if( shuffleProducts != undefined ) {
                                queryStr += '&shuffleProducts=' + shuffleProducts;
                            }
                            var showImage = jQuery( "#showImage:checked" ).val();
                            if( showImage != undefined ) {
                                queryStr += '&showImage=' + jQuery( "#" + showImage + ":checked").val();
                            }
                            var showPrice = jQuery( "#showPrice:checked" ).val();
                            if( showPrice != undefined ) {
                                queryStr += '&showPrice=' + jQuery( "#" + showPrice + ":checked").val();
                            }
                            var showRating = jQuery( "#showRating:checked" ).val();
                            if( showRating != undefined ) {
                                queryStr += '&showRating=' + jQuery( "#" + showRating + ":checked").val();
                            }
                            var roundedCorners = jQuery( "#roundedCorners:checked" ).val();
                            if( roundedCorners != undefined ) {
                                queryStr += '&roundedCorners=' + jQuery( "#" + roundedCorners + ":checked").val();
                            }
                            var url = '<?php echo $wpaa->getPluginPath('/servlet/preview.php'); ?>';
                            jQuery( '#widgetPreview' ).html( '<iframe id="previewFrame" scrolling="auto" frameborder="0" hspace="0" height="360" style="width:100%" src="' + url + queryStr + '" ></iframe>' );
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