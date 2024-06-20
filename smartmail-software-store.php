<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to manage and sell software and ebooks.
Version: 1.0.0
Author: Marco Zagato
Author URI: https://smartmail.store
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin path
if ( ! defined( 'SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR' ) ) {
    define( 'SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Include required files
require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store-activator.php';
require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store-deactivator.php';
require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store.php';
require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/class-smartmail-software-store-file-upload.php';

// Activation and deactivation hooks
register_activation_hook( __FILE__, array( 'SmartMail_Software_Store_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SmartMail_Software_Store_Deactivator', 'deactivate' ) );

// Initialize the main plugin class
add_action( 'plugins_loaded', array( 'SmartMail_Software_Store', 'get_instance' ) );

?>
