<?php
/*
 * copyright (c) 2011 MDBitz - Matthew John Denton - mdbitz.com
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
 * WPAA Amazon Widget Module
 *
 * This file contains the class WPAA_Module_Widget
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Amazon Widget Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_Widget extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-widget";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-widget";

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
                "AmazonCarouselWidget" => true,
                "AmazonMyFavoritesWidget" => true,
                "AmazonMP3ClipsWidget" => true,
                "AmazonOmakaseWidget" => true,
                "AmazonProductCloudWidget" => true,
                "AmazonSearchWidget" => true,
                "AmazonTemplateWidget" => true
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
        $this->parent_hook = $parent_hook;
        $this->version = $version;
        $this->last_updated = $last_updated;
        add_action('admin_head', array(&$this, 'doPageHead'));
        add_action('admin_print_scripts', array(&$this, 'doPageScripts'));
        add_action('admin_print_styles', array(&$this, 'doPageStyles'));
        add_action('admin_init', array(&$this, 'saveSettings'));
        add_action('widgets_init', array(&$this, 'init_widgets'));
        $this->loadOptions();
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_submenu_page($this->parent_hook, "Widgets", "Widgets", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * get module hook
     * @return string
     */
    public function getHook() {
        return $this->hook;
    }

    /**
     * is Widget Enabled
     * @return boolean
     */
    public function isEnabled( $widget ) {
        return $this->options[$widget];
    }

    /**
     * enable Plugin Widgets
     */
    public function init_widgets() {
        if ($this->options['AmazonCarouselWidget']) {
            register_widget("Widget_Amazon_Carousel");
        }
        if ($this->options['AmazonMyFavoritesWidget']) {
            register_widget("Widget_Amazon_MyFavorites");
        }
        if ($this->options['AmazonMP3ClipsWidget']) {
            register_widget("Widget_Amazon_MP3Clips");
        }
        if ($this->options['AmazonSearchWidget']) {
            register_widget("Widget_Amazon_Search");
        }
        if ($this->options['AmazonOmakaseWidget']) {
            register_widget("Widget_Amazon_Omakase");
        }
        if ($this->options['AmazonProductCloudWidget']) {
            register_widget("Widget_Amazon_ProductCloud");
        }
        if ($this->options['AmazonTemplateWidget']) {
            register_widget("Widget_Amazon_Template");
        }
    }

    /**
     * load Options
     */
    private function loadOptions() {
        $saved_options = get_option($this->options_name);

        if ($saved_options !== false ) {
            foreach ($saved_options as $key => $value) {
                $this->options[$key] = $value;
            }
        }
        update_option($this->options_name, $this->options);
    }

    /**
     * Save Plugin Settings
     */
    public function saveSettings() {
        if( isset( $_POST["wpaa_widget_edit"]) && isset( $_POST["wpaa-widget-meta-nonce"] ) ) {

            $wpaa_edit = $_POST["wpaa_widget_edit"];
            $nonce = $_POST['wpaa-widget-meta-nonce'];
            if ( !empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-widget-meta-nonce')) {
                //update AmazonCarouselWidget
                if (isset($_POST['AmazonCarouselWidget'])) {
                    $this->options['AmazonCarouselWidget'] = true;
                } else {
                    $this->options['AmazonCarouselWidget'] = false;
                }
                //update AmazonMyFavoritesWidget
                if (isset($_POST['AmazonMyFavoritesWidget'])) {
                    $this->options['AmazonMyFavoritesWidget'] = true;
                } else {
                    $this->options['AmazonMyFavoritesWidget'] = false;
                }
                //update AmazonMP3ClipsWidget
                if (isset($_POST['AmazonMP3ClipsWidget'])) {
                    $this->options['AmazonMP3ClipsWidget'] = true;
                } else {
                    $this->options['AmazonMP3ClipsWidget'] = false;
                }
                //update AmazonSearchWidget
                if (isset($_POST['AmazonSearchWidget'])) {
                    $this->options['AmazonSearchWidget'] = true;
                } else {
                    $this->options['AmazonSearchWidget'] = false;
                }
                //update AmazonOmakaseWidget
                if (isset($_POST['AmazonOmakaseWidget'])) {
                    $this->options['AmazonOmakaseWidget'] = true;
                } else {
                    $this->options['AmazonOmakaseWidget'] = false;
                }
                //update AmazonProductCloudWidget
                if (isset($_POST['AmazonProductCloudWidget'])) {
                    $this->options['AmazonProductCloudWidget'] = true;
                } else {
                    $this->options['AmazonProductCloudWidget'] = false;
                }
                //update AmazonTemplateWidget
                if (isset($_POST['AmazonTemplateWidget'])) {
                    $this->options['AmazonTemplateWidget'] = true;
                } else {
                    $this->options['AmazonTemplateWidget'] = false;
                }
                update_option($this->options_name, $this->options);

                $this->message = __("<strong>Success:</strong> Settings successfully updated.", "wpaa");
            }
        }
    }

    /**
     * Update Widget Settings
     */
    public function updateSettings( $newOptions ) {
        //update AmazonCarouselWidget
        if (isset($newOptions['AmazonCarouselWidget'])) {
            $this->options['AmazonCarouselWidget'] = $newOptions['AmazonCarouselWidget'];
        }
        //update AmazonMyFavoritesWidget
        if (isset($newOptions['AmazonMyFavoritesWidget'])) {
            $this->options['AmazonMyFavoritesWidget'] = $newOptions['AmazonMyFavoritesWidget'];
        }
        //update AmazonMP3ClipsWidget
        if (isset($newOptions['AmazonMP3ClipsWidget'])) {
            $this->options['AmazonMP3ClipsWidget'] = $newOptions['AmazonMP3ClipsWidget'];
        }
        //update AmazonSearchWidget
        if (isset($newOptions['AmazonSearchWidget'])) {
            $this->options['AmazonSearchWidget'] = $newOptions['AmazonSearchWidget'];
        }
        //update AmazonOmakaseWidget
        if (isset($newOptions['AmazonOmakaseWidget'])) {
            $this->options['AmazonOmakaseWidget'] = $newOptions['AmazonOmakaseWidget'];
        }
        //update AmazonProductCloudWidget
        if (isset($newOptions['AmazonProductCloudWidget'])) {
            $this->options['AmazonProductCloudWidget'] = $newOptions['AmazonProductCloudWidget'];
        }
        //update AmazonTemplateWidget
        if (isset($newOptions['AmazonTemplateWidget'])) {
            $this->options['AmazonTemplateWidget'] = $newOptions['AmazonTemplateWidget'];
        }
        update_option($this->options_name, $this->options);
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
     * output Widgets Page
     */
    public function doPage() {
        // output  message if set
        if( ! empty( $this->message ) ) {
            echo '<div class="updated fade">' . $this->message . '</div>';
        }

        ?>
<div class="wrap">
    <h2>WordPress Amazon Associate: <?php _e('Widgets', 'wpaa'); ?></h2>
    <div class="postbox-container" style="width:500px;" >
        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_widget_edit" type="hidden" name="wpaa_widget_edit" />
                    <input type="hidden" name="wpaa-widget-meta-nonce" value="<?php echo wp_create_nonce('wpaa-widget-meta-nonce') ?>" />
                    <?php
                            $content = '<div class="admin_config_box">';
                            $content .= '<table border="0" class="admin_table">';
                            $content .= '<tr><td><strong>' . __('Amazon Carousel:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonCarouselWidget", $this->options["AmazonCarouselWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon MP3 Clips:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonMP3ClipsWidget", $this->options["AmazonMP3ClipsWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon My Favorites:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonMyFavoritesWidget", $this->options["AmazonMyFavoritesWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon Omakase:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonOmakaseWidget", $this->options["AmazonOmakaseWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon Product Cloud:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonProductCloudWidget", $this->options["AmazonProductCloudWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon Search:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonSearchWidget", $this->options["AmazonSearchWidget"]) . '</td></tr>';
                            $content .= '<tr><td><strong>' . __('Amazon Template:','wpaa') . '</strong></td><td>' . $this->checkbox("AmazonTemplateWidget", $this->options["AmazonTemplateWidget"]) . '</td></tr>';
                            $content .= '</table>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= "<p>" . __("Don't need a provided widget? Then feel free to disable it here so your Widget menu is a little less cluttered.",'wpaa') . "</p>";
                            $content .= '</div>';
                            $this->postbox("amazon_widget_settings", __("Amazon Widget Settings",'wpaa'), $content);
                    ?>
                </form>
            </div>
        </div>
    </div>
<?php
        $this->doAdminSideBar('plugin-widget');
?>
</div>
        <?php
    }

}