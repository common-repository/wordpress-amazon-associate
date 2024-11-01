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
require_once( '../../../../wp-load.php');
// User can Edit Content
if (current_user_can('edit_posts') ) {
?>
<html>
    <head></head>
    <body>
        <?php
        $width = '600';
        if (!empty($_GET['width']) && is_numeric( $_GET['width']) ) {
            $width = $_GET['width'];
        }
        $height = '600';
        if (!empty($_GET['height']) && is_numeric( $_GET['height'])) {
            $height = $_GET['height'];
        }
        if( !empty( $_GET['size'])) {
             $dimensions = split( "x", $_GET['size'] );
             $width = $dimensions[0];
             $height = $dimensions[1];
        }
        ?>
        <div id="preview_section_demo" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;">
            <?php

            $widget = $_GET['widget'];
            unset($_GET['widget']);
            foreach ($_GET as $key => $value) {
                $_GET[$key] = urldecode($value);
                if (empty($value) || $value == 'undefined') {
                    if( $widget != "ProductCloud" ) {
                        unset($_GET[$key]);
                    } else {
                        if( $key != "marketPlace" ) {
                            $_GET[$key] = "false";
                        }
                    }
                }
            }

            switch ($widget) {
                case "Carousel":
                    AmazonWidget::Carousel($_GET);
                    break;
                case "MP3Clips":
                    AmazonWidget::MP3Clips($_GET);
                    break;
                case "MyFavorites":
                    AmazonWidget::MyFavorites($_GET);
                    break;
                case "Search":
                    AmazonWidget::Search($_GET);
                    break;
                case "Omakase":
                    AmazonWidget::Omakase($_GET);
                    break;
                case "ProductCloud":
                    AmazonWidget::ProductCloud($_GET);
                    break;
                case "Template":
                    WPAA_Template::toHTML($_GET);
                    break;
                case "TemplatePreview":
                    $template = new stdClass();
                    $template->CONTENT = urldecode($_REQUEST['CONTENT']);
                    $template->CSS = urldecode($_REQUEST['CSS']);
                    WPAA_Template::preview( $template, $_REQUEST['ID'] );
                    break;
            }
            ?>
        </div>
    </body>
</html>
<?php }