<?php
/*
  Plugin Name: WordPress Amazon Associate
  Plugin URI: http://labs.mdbitz.com/wordpress/wordpress-amazon-associate/
  Description: Quickly and eaily monetize your webiste through the integration of Amazon products and widgets tagged with your associate id.
  Author: MDBitz - Matthew John Denton
  Version: 2.0.0
  Requires at least: 3.2.1
  Author URI: http://labs.mdbitz.com
  License: GPL v3
 */

/*
 * copyright (c) 2010,2011,2012 MDBitz - Matthew John Denton - mdbitz.com
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
 * WordPress Amazon Associate Plugin
 *
 * This file configures and initializes the
 * WordPress Amazon Associate Plugin
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.wordpress.amazon_associate
 */

// Plugin Version / Update Date
global $wpaa_version;
global $wpaa_update_date;
$wpaa_version = "2.0.0";
$wpaa_update_date = "09-11-2012";

// load Admin Class
require_once plugin_dir_path(__FILE__) . 'WPAA.php';
spl_autoload_register(array('WPAA', 'autoload'));
$wpaa = new WPAA( $wpaa_version, $wpaa_update_date );