<?php
/*
 * copyright (c) 2010,2011 MDBitz - Matthew John Denton - mdbitz.com
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
 * WPAA IP2Nation Module
 *
 * This file contains the class WPAA_Module_IP2Nation
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

if( !class_exists( 'WP_Http' ) ) {
    include_once( ABSPATH . WPINC. '/class-http.php' );
}

/**
 * WordPress Amazon Associate Plugin : IP2Nation Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_IP2Nation extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-ip2nation";

    /**
     * Configuration Page User Level
     * @var String
     */
    protected $options_lvl = "manage_options";

    /**
     * DB Name
     * @var String
     */
    protected $db = "ip2nation";

    /**
     * DB File Location
     * @var array
     */
    protected $db_remote_file = array(
        "http://www.ip2nation.com/ip2nation.zip"
    );

    /**
     * ip2nation status
     * @var Array
     */
    private $status = array();

    /**
     * ip2nation installation status
     * @var Array
     */
    private $install_status = array();

    /**
     * ip2nation determined geo location
     * @var Array
     */
    private $geo_locale = null;

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
        $this->getStatus();
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        add_submenu_page($this->parent_hook, "ip2nation", "ip2nation", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * get module hook
     * @return string
     */
    public function getHook() {
        return $this->hook;
    }

    /**
     * return user Geo Locale by IP 
     */
    public function getGeoLocale() {
        if( is_null($this->geo_locale) ) {
            global $wpdb, $_SERVER;
            $ip = $_SERVER['REMOTE_ADDR'];
            $sql = "SELECT country FROM $this->db WHERE ip < INET_ATON('$ip') ORDER BY ip DESC LIMIT 0,1";
            $this->geo_locale = $this->localeByCountry($wpdb->get_var($sql));
        }
        return $this->geo_locale;
    }

    /**
     * is ip2nation database installed
     * @return boolean
     */
    public function isInstalled() {
        return $this->status['installed'];
    }

    /**
     * return Locale associated with given Country Code
     * @param string $country
     */
    private function localeByCountry( $country ) {
        $locale = "US";
        switch( $country ) {
            // UK
            case 'uk':	// United Kingdom
            case 'gb':	// Great Britain (UK)
            case 'gi':	// Gibraltar
            case 'ie':	// Ireland
            case 'eu':	// Europe
            case 'dk':	// Denmark
            case 'fi':	// Finland
            case 'is':	// Iceland
            case 'nl':	// Netherlands
            case 'no':	// Norway
            case 'se':	// Sweden
                $locale = 'UK';
                break;
            //CA
            case 'ca':	// Canada
            case 'pm':	// St. Pierre and Miquelon
                $locale = 'CA';
                break;
            // DE
            case 'de':	// Germany
            case 'at':	// Austria
            case 'li':	// Liechtenstein
            case 'na':	// Namibia
            case 'ch':	// Switzerland
            case 'cz':	// Czech Republic
            case 'pl':	// Poland
            case 'sk':	// Slovak Republic
                 $locale = 'DE';
                 break;
            // FR
            case 'fr':	// France
            case 'be':	// Belgium
            case 'gp':	// Guadeloupe
            case 'gf':	// French Guiana
            case 'pf':	// French Polynesia
            case 'tf':	// French Southern Territories
            case 'ht':	// Haiti
            case 'lu':	// Luxembourg
                $locale = 'FR';
                break;
            // ES
            case 'es':  // Spain
            case 'pt':  // Portugal
                $locale = "ES";
                break;
            // JP
            case 'jp':
                $locale = 'JP'; // Japan
                break;
            // CN
            case 'cn':  // China
                $locale = 'CN';
                break;
            // IT
            case 'it':  // Italy
                $locale = 'IT';
                break;
        }
        return $locale;
    }

    /**
     * Get ip2nation database info
     * @global WPDB $wpdb
     */
    private function getStatus () {
        global $wpdb;
        $updated_ts = null;
        $remote_ts = null;

        // get installed ip2nation information
        $sql = "SHOW TABLE STATUS WHERE Name LIKE '". $this->db ."'";
        $db_info = $wpdb->get_row($sql);
        if ($db_info) {
            $this->status['installed'] = true;
            $updated_ts = strtotime($db_info->Update_time);
            $this->status['updated_ts'] = date('D, d M Y H:i:s', $updated_ts);
        } else {
            $this->status['installed'] = false;
        }

    }

    /**
     * Init 
     */
    public function doAction() {
        $this->uninstall();
        $this->install();
    }

    /**
     * Save Plugin Settings
     */
    public function install() {
        if( isset($_POST['wpaa_ip2nation_edit']) && isset($_POST['wpaa-ip2nation-meta-nonce']) ) {
            $wpaa_edit = $_POST["wpaa_ip2nation_edit"];
            $nonce = $_POST['wpaa-ip2nation-meta-nonce'];
            if (isset($wpaa_edit) && !empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-ip2nation-meta-nonce')) {

                global $wpdb;

                $upload_dir = wp_upload_dir();
                $temp_zip_file = $upload_dir['basedir'] . '/ip2nation.zip';
                $upload_path = $upload_dir['basedir'] . '/';

                // Download zip file...
                $request = new WP_Http;
                foreach( $this->db_remote_file as $remote_file ) {
                    $result = $request->request( $remote_file );
                    if( $result instanceof WP_Error ) {
                        $this->install_status = __('<strong>Error:</strong> Failure while downloading remote file form ip2nation, please try to re-install.', 'wpaa');
                    } else {
                        // Save file to temp directory
                        $content = $result['body'];
                        $zip_size = file_put_contents ($temp_zip_file, $content);
                        if (!$zip_size) {
                            $this->install_status = __('<strong>Error:</strong> Failure to save content locally, please try to re-install.', 'wpaa');
                            return;
                        }

                        $sql = null;
                        // require PclZip if not loaded
                        if(! class_exists('PclZip')) {
                            require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
                        }

                        // unzip Archive
                        $archive = new PclZip($temp_zip_file);
                        if ($archive->extract(PCLZIP_OPT_PATH, $upload_path, PCLZIP_OPT_REMOVE_ALL_PATH) == 0) {
                            $this->install_status = __('<strong>Error:</strong> Failure to unzip archive, please try to re-install', 'wpaa');
                            return ;
                        } else {
                            $sql = file_get_contents( $upload_path . 'ip2nation.sql', true );
                            unlink(  $upload_path . 'ip2nation.sql' );
                        }
                        unlink( $temp_zip_file );

                        if( $sql != null ) {
                            // Install the database
                            $index = 0;
                            $end = strpos($sql, ';', $index)+1;
                            $query = substr ($sql, $index, ($end-$index));
                            while ($query !== FALSE) {
                                if ($wpdb->query($query) === FALSE) {
                                    $this->install_status = sprintf(__("<strong>Error:</strong> ip2nation archive downloaded but failed to install due to error: [%s]", "wpaa"), $wpdb->last_error);
                                    return ;
                                }
                                $index=$end;
                                $end = strpos($sql, ';', $index)+1;
                                $query = substr ($sql, $index, ($end-$index));
                            }
                            $this->install_status = __("<strong>Success:</strong> ip2nation database installed successfully.", "wpaa");
                            $this->getStatus();
                            return ;
                        }
                    }
                }

            }
        }
    }

    public function uninstall() {
        if( isset($_POST['wpaa_ip2nation_uninstall']) && isset($_POST['wpaa-ip2nation-uninstall-meta-nonce']) ) {
            $wpaa_edit = $_POST["wpaa_ip2nation_uninstall"];
            $nonce = $_POST['wpaa-ip2nation-uninstall-meta-nonce'];
            if (isset($wpaa_edit) && !empty($wpaa_edit) && wp_verify_nonce($nonce, 'wpaa-ip2nation-uninstall-meta-nonce')) {
                global $wpdb;
                $sql = 'DROP TABLE ' . $this->db;
                if ($wpdb->query($sql) === FALSE) {
                    $this->install_status = __("<strong>Failure:</strong> IP2Nation database table could not be deleted.", "wpaa");
                    return;
                } else {
                    $this->install_status = __("<strong>Success:</strong> IP2Nation database table was deleted successfully.", "wpaa");
                }
                $this->status['installed'] = false;
            }
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
        global $wpdb;
        $updated_ts = null;
        $remote_ts = null;

        // get installed ip2nation information
        $sql = "SHOW TABLE STATUS WHERE Name LIKE '". $this->db ."'";
        $db_info = $wpdb->get_row($sql);
        if ($db_info) {
            $this->status['installed'] = true;
            $updated_ts = strtotime($db_info->Update_time);
            $this->status['updated_ts'] = date('D, d M Y H:i:s', $updated_ts);
        } else {
            $this->status['installed'] = false;
        }

        // lookup remote ip2nation information
        $request = new WP_Http;
        // default status
        $this->status['available'] = false;
        $this->status['update'] = false;
        foreach( $this->db_remote_file as $remote_file ) {
            $result = $request->head( $remote_file );
            if( $result instanceof WP_Error ) {

            } else {
                $this->status['available'] = true;
                $remote_ts = strtotime($result['headers']['last-modified']);
                $this->status['remote_ts'] = date('D, d M Y H:i:s', $remote_ts);
                // check if update is available
                if( $remote_ts > $updated_ts ) {
                    $this->status['update'] = true;
                } else {
                    $this->status['update'] = false;
                }
            }
        }
        
        // output installation message if set
        if( ! empty( $this->install_status ) ) {
            echo '<div class="updated fade">' . $this->install_status . '</div>';
        }

        ?>
<div class="wrap">
    <h2>WordPress Amazon Associate: <?php _e('ip2nation', 'wpaa'); ?></h2>
    <div class="postbox-container" style="width:500px;" >
        <div class="metabox-holder">
            <div class="meta-box-sortables">
                <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_ip2nation_edit" type="hidden" name="wpaa_ip2nation_edit" />
                    <input type="hidden" name="wpaa-ip2nation-meta-nonce" value="<?php echo wp_create_nonce('wpaa-ip2nation-meta-nonce') ?>" />
                            <?php

                            $content = '<div class="admin_config_box">';
                            if( $this->status['installed'] ) {
                                $content .= '<table border="0" class="admin_table">';
                                $content .= '<tr><td><strong>' . __('Last Updated:', 'wpaa') . '</strong></td><td>' . $this->status['updated_ts'] . '</td></tr>';
                                if( $this->status['available'] === true ) {
                                    if( ! $this->status['update'] ) {
                                        $content .= '<tr><td><strong>' . __('Installed Version:', 'wpaa') . '</strong></td><td>' . $this->status['remote_ts'] . '</td></tr>';
                                    } else {
                                        $content .= '<tr><td><strong>' . __('Available Version:', 'wpaa') . '</strong></td><td>' . $this->status['remote_ts'] . '</td></tr>';
                                    }
                                }
                                $content .= '</table>';
                                if( $this->status['update'] ) {
                                    $content .= '<div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Update','wpaa') . ' &raquo;" /></div>';
                                    $content .= '<div class="clear"></div>';
                                }
                            } else {
                                $content .= '<p>' . __("The ip2nation database is not installed. If you want to enable link localization by IP Address please install the database by using the <em>install</em> button below.") . "</p>";
                                $content .= '<div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Install','wpaa') . ' &raquo;" /></div>';
                                $content .= '<div class="clear"></div>';
                            }
                            $content .= '<p>' . __("ip2nation is utilized to lookup a users country by their ip address. If installed you can configure the WordPress Amazon Associate plugin to localize links automatically for your website visitors.") . '</p>';
                            $content .= '</div>';
                            $this->postbox("ip2nation_status", __("ip2nation status",'wpaa'), $content);
                            ?>
                </form>
                <?php if( $this->status['installed'] ) { ?>
                <form action="<?php echo admin_url('admin.php?page=' . $this->hook); ?>" method="post" id="wpaa-conf">
                    <input value="wpaa_ip2nation_uninstall" type="hidden" name="wpaa_ip2nation_uninstall" />
                    <input type="hidden" name="wpaa-ip2nation-uninstall-meta-nonce" value="<?php echo wp_create_nonce('wpaa-ip2nation-uninstall-meta-nonce') ?>" />
                            <?php

                            $content = '<div class="admin_config_box">';
                            $content .= '<p>' . __("If you no longer want to use ip2nation for Geo-Localization than you can delete the ip2nation database by clicking uninstall.") . '</p>';
                            $content .= '<div class="alignright"><input class="button-primary" type="submit" name="submit" value="' . __('Uninstall','wpaa') . ' &raquo;" /></div>';
                            $content .= '<div class="clear"></div>';
                            $content .= '</div>';
                            $this->postbox("ip2nation_uninstall", __("ip2nation uninstall",'wpaa'), $content);
                            ?>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
        $this->doAdminSideBar('plugin-ip2nation');
?>
</div>
        <?php
    }

}