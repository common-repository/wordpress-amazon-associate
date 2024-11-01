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
 * WPAA Cache Module
 *
 * This file contains the class WPAA_Module_Cache
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Cache Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_Cache extends MDBitz_Plugin {

    /**
     * Cache Table Name
     * @var String
     */
    protected $tbl_name = "wpaa_cache";

    /**
     * Cache Handler
     * @var WPAA_CacheHandler
     */
    protected $cacheHandler = null;

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-cache";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-cache";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $options_lvl = "manage_options";

    /**
     * Module Options
     * @var Array
     */
    protected $options = array(
        'enabled' => true,
        'expire' => 14,
        'db-version' => "1.0"
    );

    /**
     * Options Page Message
     * @var string
     */
    protected $message = null;

    /**
     * Constructor
     * @param string $parent_hook
     * @param string $version
     * @param string $last_updated
     */
    function __construct( $parent_hook, $version, $last_updated ) {
        parent::__construct();
        global $wpdb;
        $this->parent_hook = $parent_hook;
        $this->version = $version;
        $this->last_updated = $last_updated;
        $this->tbl_name = $wpdb->prefix . $this->tbl_name;
        add_action('admin_head', array(&$this, 'doPageHead'));
        add_action('admin_print_scripts', array(&$this, 'doPageScripts'));
        add_action('admin_print_styles', array(&$this, 'doPageStyles'));
        add_action('admin_init', array(&$this, 'saveSettings'));
        $this->loadOptions();
        $this->cacheHandler = new WPAA_CacheHandler( $this->tbl_name, $this->options['enabled'], $this->options['expire'] );
    }

    /**
     * return the CacheHandler
     * @return WPAA_CacheHandler
     */
    public function getCacheHandler() {
        return $this->cacheHandler;
    }

    /**
     * Save Module Settings
     */
    public function saveSettings() {
        if( isset($_POST['wpaa_cache_edit']) && isset($_POST['wpaa-cache-meta-nonce']) ) {
            $wpaa_edit = $_POST["wpaa_cache_edit"];
            $nonce = $_POST['wpaa-cache-meta-nonce'];
            if (!empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-cache-meta-nonce')) {
                $this->message = __("<strong>Success:</strong> Settings updated successfully.", "wpaa");
                if (isset($_POST['enabled'])) {
                    $this->options['enabled'] = true;
                } else {
                    $this->options['enabled'] = false;
                }
                if (isset($_POST['expire']) ) {
                    if( is_numeric($_POST['expire']) ) {
                        $this->options['expire'] = intval($_POST['expire']);
                    } else {
                        $this->message = __("<strong>Error:</strong> Please enter a valid integer for Expiration Days option.", "wpaa");
                    }
                }
                if (isset($_POST['clear'])) {
                    $this->clear();
                }
                update_option($this->options_name, $this->options);
            }
        }

    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_submenu_page($this->parent_hook, "Product Cache", "Product Cache", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * load Options
     */
    private function loadOptions() {
        $saved_options = get_option($this->options_name);
        $version = $this->options['db-version'];

        if ($saved_options !== false ) {
            foreach ($saved_options as $key => $value) {
                $this->options[$key] = $value;
            }
            if( $this->options['db-version'] == $version ) {
                return;
            }
        }
        // install db
        $this->install();
        $this->options['db-version'] = $version;
        update_option($this->options_name, $this->options);
    }

    /**
     * Install Cache Database
     */
    public function install() {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tbl_name . ' ( locale VARCHAR(2) NOT NULL, type VARCHAR(30) NULL, id VARCHAR(30) NULL, response_group VARCHAR(255) NULL, updated_ts date default NULL, data text NULL, UNIQUE KEY cache_id_idx (locale, type, id, response_group(100)), KEY updated_idx (updated_ts) ) CHARACTER SET utf8 COLLATE utf8_general_ci; ';
        $wpdb->query($sql);
    }

    /**
     * Clears database of cached product information
     * @global <type> $wpdb 
     */
    public function clear() {
        global $wpdb;
        $sql = 'DELETE FROM ' . $this->tbl_name;
        $wpdb->query($sql);
        if ($wpdb->query($sql) === FALSE) {
            $this->message = __("<strong>Failure:</strong> Settings updated but could not clear cache.", "wpaa");
        } else {
            $this->message = __("<strong>Success:</strong> Settings updated and Cache cleared successfully.", "wpaa");
        }
    }

    /**
     * Output Admin Page header scripts
     */
    public function doPageHead() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_script('jquery');
        }
    }

    /**
     * Output Config Page Styles
     */
    function doPageStyles() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_style('dashboard');
            wp_enqueue_style('thickbox');
            wp_enqueue_style('global');
            wp_enqueue_style('wp-admin');
            wp_enqueue_style('wpaa-admin-css', WP_CONTENT_URL . '/plugins/wordpress-amazon-associate/css/admin.css');
        }
    }

    /**
     * Output Page Scripts
     */
    function doPageScripts() {
        if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
            wp_enqueue_script('postbox');
            wp_enqueue_script('dashboard');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');
        }
    }

    /**
     * output Compliance Page
     */
    public function doPage() {
        // output message if set
        if( ! empty( $this->message ) ) {
            echo '<div class="updated fade">' . $this->message . '</div>';
        }
        ?>
<div class="wrap">
    <h2>WordPress Amazon Associate: <?php _e('Product Cache', 'wpaa'); ?></h2>
    <div class="postbox-container" style="width:500px;" >
        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_cache_edit" type="hidden" name="wpaa_cache_edit" />
                    <input type="hidden" name="wpaa-cache-meta-nonce" value="<?php echo wp_create_nonce('wpaa-cache-meta-nonce') ?>" />
                            <?php

                            $content = '<div class="admin_config_box">';
                            $content .= "<p><Strong>WordPress Amazon Associate</strong>" . __(" comes built with an advanced product cache. We minimize the calls your website makes to the Advertising Product API by caching responses in a local database so that your users get their content faster. Please use the below settings to configure if the cache is used and for how long data is valid.") . "</p>";
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('is Enabled?', 'wpaa') . '</strong></td><td>' . $this->checkbox("enabled", $this->options['enabled']) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Products in cache will expire after _ days?', 'wpaa') . '</strong></td><td>' . $this->textinput("expire", $this->options['expire']) . '</td></tr>';
                            $content .= '<tr><td colspan="2"><small>* ' . __('Entering 0 will mean that products in the cache do not expire.') . '</small></td></tr>';
                            $content .= '<tr><td><strong>' . __('Clear Cache?', 'wpaa') . '</strong></td><td>' . $this->checkbox("clear") . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '</div>';
                            $this->postbox("amazon_cache_settings", __("Product Cache Settings",'wpaa'), $content);
                            ?>
                </form>
            </div>
        </div>
    </div>
<?php
        $this->doAdminSideBar('plugin-cache');
?>
</div>
<?php
    }

}