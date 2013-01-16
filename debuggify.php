<?php
/*
Plugin Name: Debuggify
Description: Google Analytics For Web Developers
Version: 1.0
Author: Ankur Agarwal
Author URI: https://github.com/debuggify
Plugin URI: https://github.com/debuggify/debuggify_wordpress
*/

/**
 * Define some useful constants
 **/
define('DEBUGGIFY_VERSION', '1.0');
define('DEBUGGIFY_DIR', plugin_dir_path(__FILE__));
define('DEBUGGIFY_URL', plugin_dir_url(__FILE__));


/**
 * Assets director paths
 */
define('DEBUGGIFY_IMAGE_URL', DEBUGGIFY_URL.'assets/img/');
define('DEBUGGIFY_CSS_URL', DEBUGGIFY_URL.'assets/css/');
define('DEBUGGIFY_JS_URL', DEBUGGIFY_URL.'assets/js/');

require_once(DEBUGGIFY_DIR.'includes/core.php');


/**
 * Load files
 **/
function debuggify_load(){

  if(is_admin()) //load admin files only in admin
    require_once(DEBUGGIFY_DIR.'includes/admin.php');

}

debuggify_load();

/**
 * Activation, Deactivation and Uninstall Functions
 *
 **/
register_activation_hook(__FILE__, 'debuggify_activation');
register_deactivation_hook(__FILE__, 'debuggify_deactivation');


function debuggify_activation() {

	//actions to perform once on plugin activation go here
  //register uninstaller
  register_uninstall_hook(__FILE__, 'debuggify_uninstall');
}

function debuggify_deactivation() {
	// actions to perform once on plugin deactivation go here
}

function debuggify_uninstall(){
  //actions to perform once on plugin uninstall go here

}

// Add sidebar link to settings page
add_action('admin_menu', 'debuggify_menu_link');

/**
 * Show Debuggify Menu on WP Admin Dashboard
 */
function debuggify_menu_link() {

  if (function_exists('add_menu_page')) {

    $debuggify_landing_page = add_menu_page( __( 'Debuggify', 'debuggify' ), __( 'Debuggify', 'debuggify' ), 'administrator', basename(__FILE__), 'debuggify_landing', DEBUGGIFY_IMAGE_URL.'logo_16x16.png');
    $debuggify_landing_page = add_submenu_page( basename(__FILE__), __( 'Dashboard' ), __( 'Dashboard', 'debuggify' ), 'administrator', basename(__FILE__), 'debuggify_landing' );

    add_action( "admin_print_scripts-$debuggify_landing_page", 'debuggify_admin_scripts' );
    add_action( "admin_print_styles-$debuggify_landing_page", 'debuggify_admin_styles' );
  }
}

function debuggify_landing(){
  require_once 'includes/admin_settings.php';
}

/**
 * Styles for admin pages
 */
function debuggify_admin_scripts() {
    wp_enqueue_script('debuggify-admin-js', DEBUGGIFY_JS_URL.'debuggify.admin.js', array('jquery','jquery-ui-sortable'), DEBUGGIFY_VERSION, true);
    echo debuggify_google_analytics();
}

/**
 * Scripts for admin pages
 */

function debuggify_admin_styles() {
  wp_enqueue_style('debuggify-admin-css', DEBUGGIFY_CSS_URL.'debuggify.admin.css', array('wp.cs'), DEBUGGIFY_VERSION);
}


?>