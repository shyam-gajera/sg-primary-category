<?php
/*
Plugin Name: Select Primary Category
Description: A plugin that allows the users to select a primary category for posts
Version:     1.0
Author:      Shyam Gajera
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: select-primary-category

Select Primary Category is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Select Primary Category is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Select Primary Category. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Define the global variables
 */
define( 'SPC_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SPC_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );

/**
 * Load the Main class
 */
require SPC_PATH . 'includes/class-spc-main.php';
$spc_main = new SPC_Main();
$spc_main->load();

/**
 * Load the Admin class
 */
if ( is_admin() ) {
	require SPC_PATH . 'includes/class-spc-admin.php';
	$spc_admin = new SPC_Admin();
	$spc_admin->load();
}
