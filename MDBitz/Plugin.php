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
 * MDBitz_Plugin
 *
 * This file contains the class MDBitz_Plugin
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */
if (!class_exists('MDBitz_Plugin')) {

    /**
     * Base class for all WordPress Plugin Admin Pages
     *
     * @package com.mdbitz.wordpress.amazon_associate
     */
    abstract class MDBitz_Plugin {

        /**
         * Plugin Version
         * @var String
         */
        protected $version = '-';

        /**
         * Plugin Last Updated
         * @var String
         */
        protected $last_updated = '-';

        /**
         * Constructor
         */
        function __construct() {
            add_action('admin_menu', array(&$this, 'registerAdminMenu'));
        }

        /**
         * Register Plugin Admin Menu
         */
        abstract public function registerAdminMenu();

        /**
         * returns HTML checkbox input
         *
         * @param String $id input id and name
         * @param String $value is checked
         * @return String
         */
        public function checkbox($id, $value = false) {
            return '<input class="checkbox" type="checkbox" value="true" id="' . $id . '" name="' . $id . '" ' . ( ($value == true) ? "checked" : "" ) . ' />';
        }

        /**
         * returns HTML radio input
         *
         * @param String $id input id and name
         * @param String $value is checked
         * @return String
         */
        public function radio($id, $value, $selected = false) {
            return '<input class="radio" type="radio" value="' . $value . '" name="' . $id . '" ' . ( ($selected == true) ? "checked" : "" ) . ' />';
        }

        /**
         * returns HTML text input
         *
         * @param String $id input id and name
         * @param String $value input value
         * @return String
         */
        public function textinput($id, $value) {
            return '<input class="text" type="text" id="' . $id . '" name="' . $id . '" size="30" value="' . $value . '"/>';
        }

        /**
         * returns HTML select input
         *
         * @param String $id input id and name
         * @param array $options Array of Options
         * @param String $selected value selected option value
         * @return String
         */
        public function select($id, $options, $selected_value) {
            $output_txt = '<select class="select" name="' . $id . '" id="' . $id . '">';
            foreach ($options as $option_value => $option_text) {
                $selected_txt = '';
                if ($selected_value == $option_value) {
                    $selected_txt = ' SELECTED';
                }
                if ($option_text == '') {
                    $option_text = $option_value;
                }
                $output_txt .= '<option value="' . $option_value . '"' . $selected_txt . '>' . $option_text . '</option>';
            }
            $output_txt .= '</select>';
            return $output_txt;
        }

        /**
         * Create a potbox widget
         */
        function postbox($id, $title, $content) {
            ?>
<div id="<?php echo $id; ?>" class="postbox">
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3 class="hndle"><span><?php echo $title; ?></span></h3>
    <div class="inside"><?php echo $content; ?></div>
</div>
            <?php
        }

        /**
         * Output Admin SideBar
         */
        function doAdminSideBar($source) {
?>
<div class="postbox-container" style="width:300px;"  >
    <div class="metabox-holder">
        <div class="meta-box-sortables">
<?php
            $content = '<div class="admin_config_box">';
            $content .= '<strong>' . __('Author:','wpaa') . '</strong> <a href="http://mdbitz.com/" target="_blank">MDBitz- Matthew Denton</a><br/><br/>';
            $content .= '<strong>' . __('Project Website:','wpaa') . '</strong> <a href="http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/?utm_source=' . $source . '&utm_medium=about-us&utm_campaign=plugin" target="_blank">labs.mdbitz.com</a><br/><br/>';
            $content .= '<strong>' . __('Version:','wpaa') . '</strong> ' . $this->version . '<br/><br/>';
            $content .= '<strong>' . __('Last Updated:','wpaa') . '</strong> ' . $this->last_updated;
            $content .= '</div>';
            $this->postbox("about", __("About this Plugin",'wpaa'), $content);

            $content = '<div class="admin_config_box">';
            $content .= '<a href="http://wordpress.org/extend/plugins/wordpress-amazon-associate/" target="_blank">' . __('Rate this plugin','wpaa') . '</a> ' . __('on WordPress') . '<br/><br/>';
            $content .= '<a href="http://wordpress.org/extend/plugins/wordpress-amazon-associate/" target="_blank">' . __('Notify','wpaa') . '</a> ' .  __('WordPress users this plugin works with your WordPress version','wpaa') . '<br/><br/>';
            $content .= '<strong>Share this plugin with others</strong><br/><br/>';
            //facebook
            $content .= '<a href="http://www.facebook.com/sharer.php?u=http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/&t=Awesome%20WordPress%20Plugin:%20%20WordPress%20Amazon%20Associate" target="_blank"><img src="' . WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/imgs/fb.png" alt="Facebook" /></a>';
            //digg
            $content .= '&nbsp;&nbsp;<a href="http://digg.com/submit?url=http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/" target="_blank"><img src="' . WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/imgs/digg.gif" alt="Digg" /></a>';
            //stubmleupon
            $content .= '&nbsp;&nbsp;<a href="http://www.stumbleupon.com/badge/?url=http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/" target="_blank"><img src="' . WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/imgs/stumbleupon.gif" alt="Stumble Upon" /></a>';
            //delicious
            $content .= '&nbsp;&nbsp;<a href="http://delicious.com/save?v=5&noui&jump=close&url=http://labs.mdbitz.com/wordpress/wordpress-amazon-associate-plugin/" target="_blank"><img src="' . WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/imgs/deli.gif" alt="Delicous" /></a>';
            //twitter
            $content .= '&nbsp;&nbsp;<a href="http://twitter.com/home/?status=WordPress+Amazon+Associate+%2C+the+all-in-one+Amazon+Associate+WordPress+Plugin+http://tinyurl.com/wpaaplugin" target="_blank"><img src="' . WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/imgs/twitter.gif" alt="Twitter" /></a>';
            $content .= '</div>';
            $this->postbox("feedback", __("User Feedback",'wpaa'), $content);

            $content = '<div class="admin_center" >';
            $content .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
                        ">
                        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>';
            $content .= '</div>';
            $this->postbox("donate", __("Show your support!",'wpaa'), $content);
?>
        </div>
    </div>
</div>
<?php
        }

    }

}