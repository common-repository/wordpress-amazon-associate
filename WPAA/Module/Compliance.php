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
 * WPAA Compliance Module
 *
 * This file contains the class WPAA_Module_Compliance
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Compliance Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_Compliance extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-compliance";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-compliance";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $options_lvl = "manage_options";

    /**
     * Module Options
     * @var Array
     */
    protected $options = array();

    /**
     * Options Page Message
     * @var string
     */
    protected $message = null;

    /**
     * Supported Plugins
     * @var Array
     */
    protected $plugins = array (
        'WP-Amazon-Search-Widget' => 'WP-Amazon-Search Widget',
        'WP-Amazon-MP3-Widget' => 'WP-Amazon-MP3-Widget',
        'WP-Amazon-Carousel' => 'WP-Amazon-Carousel'
    );

    /**
     * Widgets ShortCode mapping
     * @var Array
     */
    protected $shortCodeMap = array (
        'WP-Amazon-Search-Widget' => array('search' => 'amazonSearchHandler'),
        'WP-Amazon-MP3-Widget' => array('mp3' => 'amazonMP3ClipsHandler'),
        'WP-Amazon-Carousel' => array('carousel' => 'amazonCarouselHandler')
    );

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
        add_action('admin_init', array(&$this, 'doAction'));
        $this->loadOptions();
    }

    /**
     * Perform required action
     */
    public function doAction() {
        if( isset( $_POST['wpaa-action']) ) {
            switch( $_POST['wpaa-action'] ) {
                case "saveSettings":
                    $this->saveSettings();
                    break;
                case "importAmazonAffiliateLinkLocalizer":
                    $this->importAmazonAffiliateLinkLocalizerSettings();
                    break;
                case "importAmazonLink":
                    $this->importAmazonLinkSettings();
                    break;
            }
        }
    }

    /**
     * Save Module Settings
     */
    public function saveSettings() {
        if( isset( $_POST["wpaa_compliance_edit"]) && isset( $_POST["wpaa-compliance-meta-nonce"] ) ) {
            $wpaa_edit = $_POST["wpaa_compliance_edit"];
            $nonce = $_POST['wpaa-compliance-meta-nonce'];
            if ( !empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-compliance-meta-nonce')) {

                // update compliance settings
                foreach( $this->plugins as $id => $name ) {
                    //update WP-Amazon-Search
                    if (isset($_POST[$id])) {
                        $this->options[$id] = true;
                    } else {
                        $this->options[$id] = false;
                    }
                }
                update_option($this->options_name, $this->options);
                $this->message = __("<strong>Success:</strong> Settings updated successfully.", "wpaa");
            }
        }
    }

    /**
     * Import Settings from: Amazon Affiliate Link Localizer Settings
     */
    public function importAmazonAffiliateLinkLocalizerSettings() {
        global $wpaa;
        $options = $wpaa->getAssociateTags();
        $tags = array(
            "US" =>get_option( 'amzn_com' ),
            "UK" => get_option( 'amzn_co_uk' ),
            "DE" => get_option( 'amzn_de' ),
            "FR" => get_option( 'amzn_fr' ),
            "CA" => get_option( 'amzn_ca' ),
            "JP" => get_option( 'amzn_jp' )
        );
        foreach( $tags as $key => $value ) {
            if( ! empty($key) ) {
                $options[ $key] = $value;
            }
        }
        $wpaa->saveAssociateTags( $options);
        $this->message = __("<strong>Success:</strong> Amazon Associate settings were successfully imported from", "wpaa") . " Amazon Affiliate Link Localizer Plugin.";
    }

    /**
     * Import Settings from: Amazon Link Settings
     */
    public function importAmazonLinkSettings() {
        global $wpaa;
        $options = $wpaa->getAssociateTags();
        $remoteOptions = get_option( 'AmazonLinkOptions' );
        if( ! empty($remoteOptions['tag_us']) && $remoteOptions['tag_us'] != "lipawe-20" ){
            $options['US'] = $remoteOptions['tag_us'];
        }
        if( ! empty($remoteOptions['tag_uk']) && $remoteOptions['tag_uk'] != "livpauls-21" ){
            $options['UK'] = $remoteOptions['tag_uk'];
        }
        if( ! empty($remoteOptions['tag_de']) && $remoteOptions['tag_de'] != "lipas03-21" ){
            $options['DE'] = $remoteOptions['tag_de'];
        }
        if( ! empty($remoteOptions['tag_fr']) && $remoteOptions['tag_fr'] != "lipas03-21" ){
            $options['FR'] = $remoteOptions['tag_fr'];
        }
        if( ! empty($remoteOptions['tag_jp']) && $remoteOptions['tag_jp'] != "Livpaul21-22" ){
            $options['JP'] = $remoteOptions['tag_jp'];
        }
        if( ! empty($remoteOptions['tag_ca']) && $remoteOptions['tag_ca'] != "lipas-20" ){
            $options['CA'] = $remoteOptions['tag_ca'];
        }
        $wpaa->saveAssociateTags( $options);
        $this->message = __("<strong>Success:</strong> Amazon Associate settings were successfully imported from", "wpaa") . " Amazon Link Plugin.";
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_submenu_page($this->parent_hook, "Compliance", "Compliance", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * load Options
     */
    private function loadOptions() {
        foreach( $this->plugins as $id => $name ) {
            $this->options[$id] = false;
        }
        $saved_options = get_option($this->options_name);
        if ($saved_options != null) {
            foreach ($saved_options as $key => $value) {
                $this->options[$key] = $value;
            }
        }
    }

    /**
     * get ShortCode Compliance Mappings for selected plugins
     *
     */
    function getCompliantShortCodeMappings() {
        $mapping = array();
        foreach( $this->plugins as $id => $name ) {
            if( $this->options[$id] === true ) {
                $mapping[$id] = $this->shortCodeMap[$id];
            }
        }
        return $mapping;
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
    <h2>WordPress Amazon Associate: <?php _e('Plugin Compliance', 'wpaa'); ?></h2>
    <div class="postbox-container" style="width:500px;" >
        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_compliance_edit" type="hidden" name="wpaa_compliance_edit" />
                    <input type="hidden" name="wpaa-action" value="saveSettings" />
                    <input type="hidden" name="wpaa-compliance-meta-nonce" value="<?php echo wp_create_nonce('wpaa-compliance-meta-nonce') ?>" />
                            <?php

                            $content = '<div class="admin_config_box">';
                            $content .= "<p>" . __("Are you already using a different WordPress Plugin but would like to use") . " <Strong>WordPress Amazon Associate</strong>?" . __(" Don't worry about modifying your existing pages/posts and templates instead you can simply enable compliance with their ShortCode by clicking the appropriate checkboxes.") . "</p>";
                            $content .= '<table border="0" class="admin_table">';
                            foreach( $this->plugins as $id => $name ) {
                                $content .= '<tr><td><strong>' . $name . '</strong></td><td>' . $this->checkbox($id, $this->options[$id]) . '</td></tr>';
                            }
                            $content .= '</table>';
                            $content .= '<br/><div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update Settings','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '</div>';
                            $this->postbox("amazon_web_service_settings", __("Amazon Plugin ShortCode Compliance",'wpaa'), $content);
                            ?>
                </form>
                
                            <?php
                            $content = '<div class="admin_config_box"';
                            $content .= '<p>' . __("If you have configured your Amazon Associate Tags(Ids) with any of the following plugins, you can import them using the buttons below.") . "</p>";
                            $content .= '<table border="0" class="admin_table">';
                            
                            $content .= '<tr><th>Amazon Affiliate Link Localizer:</th><td>';
                            $content .= '<form action="' . admin_url('admin.php?page=' . $this->hook) . '" method="post" id="wpaa-importAALL">';
                            $content .= '<input value="wpaa_compliance_edit" type="hidden" name="wpaa_compliance_edit" />';
                            $content .= '<input type="hidden" name="wpaa-action" value="importAmazonAffiliateLinkLocalizer" />';
                            $content .= '<input type="hidden" name="wpaa-compliance-meta-nonce" value="' . wp_create_nonce('wpaa-compliance-meta-nonce') . '" />';
                            $content .= '<input class="button-primary" type="submit" name="submit" value="' . __('Import','wpaa') . ' &raquo;" />';
                            $content .= '</form>';
                            $content .= '</td></tr>';

                            $content .= '<tr><th>Amazon Link:</th><td>';
                            $content .= '<form action="' . admin_url('admin.php?page=' . $this->hook) . '" method="post" id="wpaa-importAL">';
                            $content .= '<input value="wpaa_compliance_edit" type="hidden" name="wpaa_compliance_edit" />';
                            $content .= '<input type="hidden" name="wpaa-action" value="importAmazonLink" />';
                            $content .= '<input type="hidden" name="wpaa-compliance-meta-nonce" value="' . wp_create_nonce('wpaa-compliance-meta-nonce') . '" />';
                            $content .= '<input class="button-primary" type="submit" name="submit" value="' . __('Import','wpaa') . ' &raquo;" />';
                            $content .= '</form>';
                            $content .= '</td></tr>';

                            $content .= '</table>';
                            $content .= '</div>';
                            $this->postbox("wpaa_compliance_import", __("Import Plugin Settings",'wpaa'), $content);
                            ?>
            </div>
        </div>
    </div>
<?php
        $this->doAdminSideBar('plugin-compliance');
?>
</div>
        <?php
    }

}