<?php
/*
Plugin Name: Exit Alert
Plugin URI:
Description: A Plugin to show an alert before users exit the page
Author: Rogerio Batista
Author URI: https://www.facebook.com/rogeriobatistadev/
Version: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require_once __DIR__ . '/config-dependencies.php';
require_once __DIR__ . '/installer.php';
defineDbName();
register_activation_hook( __FILE__, 'EA_install' );
register_deactivation_hook(__FILE__, 'EA_uninstall');

require_once __DIR__ . '/config-menu.php';
add_action("admin_menu", "addMenu");

require_once __DIR__ . '/shortcode.php';
add_shortcode('exitMessage', 'shortcode_exit_message');

require_once __DIR__ . '/show-message.php';
add_action('wp_head', 'show_ea_message');