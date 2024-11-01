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
 * WPAA MultiUser Module
 *
 * This file contains the class WPAA_Module_MultiUser
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */

/**
 * WordPress Amazon Associate Plugin : Multi User Module
 *
 * @package com.mdbitz.wordpress.amazon_associate.wpaa.module
 */
class WPAA_Module_MultiUser extends MDBitz_Plugin {

    /**
     * Parent Hook
     * @var String
     */
    protected $parent_hook = "";

    /**
     * Page Hook
     * @var String
     */
    protected $hook = "wordpress-amazon-associate-multi-user";

    /**
     * Page Name
     * @var String
     */
    protected $options_name = "wordpress-amazon-associate-multi-user";

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
        add_action( 'show_user_profile', array(&$this, 'extend_user_profile') );
        add_action( 'edit_user_profile', array(&$this, 'extend_user_profile') );
        add_action( 'personal_options_update', array(&$this, 'save_user_profile') );
        add_action( 'edit_user_profile_update', array(&$this, 'save_user_profile') );
    }

    /**
     * @see MDBitz_WP_Plugin::registerAdminMenu
     */
    public function registerAdminMenu() {
        //add_submenu_page($this->parent_hook, "Multi User", "Multi User", $this->options_lvl, $this->hook, array(&$this, 'doPage'));
    }

    /**
     * extend User Profile with Amazon Associate information
     */
    function extend_user_profile( $user ) {
        global $wpaa;
?>
	<h3><?php _e("Amazon Assoicate Settings", "wpaa"); ?></h3>
        <table class="form-table">
            <?php if ( $wpaa->isLocaleEnabled( "US" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_us.gif'); ?>" />&nbsp;<a href="https://affiliate-program.amazon.com/" target="_blank"><?php _e('United States', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-US" id="AssociateTag-US" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-US', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "CA" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_ca.gif'); ?>" />&nbsp;<a href="https://associates.amazon.ca/" target="_blank"><?php _e('Canada', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-CA" id="AssociateTag-CA" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-CA', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "CN" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_cn.gif'); ?>" />&nbsp;<a href="https://associates.amazon.cn/" target="_blank"><?php _e('China', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-CN" id="AssociateTag-CN" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-CN', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "DE" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_de.gif'); ?>" />&nbsp;<a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Gemany', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-DE" id="AssociateTag-DE" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-DE', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "FR" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_fr.gif'); ?>" />&nbsp;<a href="https://partenaires.amazon.fr/" target="_blank"><?php _e('France', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-FR" id="AssociateTag-FR" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-FR', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "IT" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_it.gif'); ?>" />&nbsp;<a href="https://programma-affiliazione.amazon.it/" target="_blank"><?php _e('Italy', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-IT" id="AssociateTag-IT" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-IT', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "JP" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_jp.gif'); ?>" />&nbsp;<a href="https://affiliate.amazon.co.jp/" target="_blank"><?php _e('Japan', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-JP" id="AssociateTag-JP" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-JP', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } if ( $wpaa->isLocaleEnabled( "UK" ) ) { ?>
            <tr>
                <th><img alt="" width="18" height="11" src="<?php echo $wpaa->getPluginPath( '/imgs/flag_uk.gif'); ?>" />&nbsp;<a href="https://affiliate-program.amazon.co.uk/" target="_blank"><?php _e('United Kingdom', 'wpaa');?></a></th>
                <td><input type="text" name="AssociateTag-UK" id="AssociateTag-UK" value="<?php echo esc_attr( get_user_meta( $user->ID, 'AssociateTag-UK', true ) ); ?>" class="regular-text" /></td>
            </tr>
            <?php } ?>
        </table>
<?php
    }

    /**
     * update user profile with extended information
     * @param int $user_id
     * @return boolean
     */
    function save_user_profile( $user_id ) {
        
        if ( current_user_can( 'edit_user', $user_id ) ) {
            update_user_meta( $user_id, 'AssociateTag-US', $_POST['AssociateTag-US'] );
            update_user_meta( $user_id, 'AssociateTag-CA', $_POST['AssociateTag-CA'] );
            update_user_meta( $user_id, 'AssociateTag-CN', $_POST['AssociateTag-CN'] );
            update_user_meta( $user_id, 'AssociateTag-DE', $_POST['AssociateTag-DE'] );
            update_user_meta( $user_id, 'AssociateTag-FR', $_POST['AssociateTag-FR'] );
            update_user_meta( $user_id, 'AssociateTag-IT', $_POST['AssociateTag-IT'] );
            update_user_meta( $user_id, 'AssociateTag-JP', $_POST['AssociateTag-JP'] );
            update_user_meta( $user_id, 'AssociateTag-UK', $_POST['AssociateTag-UK'] );
        }
       
    }

    /**
     * get Associate ID of User for specified locale
     * @param int $user_id
     * @param string $locale
     * @return string
     */
    function getUserAssociateId( $user_id, $locale ) {
         return trim(esc_attr( get_user_meta( $user_id, 'AssociateTag-' . $locale, true ) ) );
    }

}