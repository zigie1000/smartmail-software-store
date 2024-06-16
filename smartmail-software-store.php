<?php
/*
* Plugin Name: SmartMail Software Store
* Description: A WordPress plugin to manage and sell eBooks and software.
* Version: 1.5
* Author: Marco Zagato
* Author URI: https://smartmail.store
*/

// Include the necessary files
include_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';
include_once plugin_dir_path(__FILE__) . 'smartmail-software-store-frontend.php';
include_once plugin_dir_path(__FILE__) . 'smartmail-software-store-backend.php';

// Register activation hook
register_activation_hook(__FILE__, array('Software_Store_Activator', 'activate'));

// Enqueue scripts and styles
function smartmail_enqueue_scripts() {
    wp_enqueue_style('smartmail-store-style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('smartmail-store-script', plugins_url('/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_enqueue_scripts');

// Initialize the admin and public classes
function run_smartmail_software_store() {
    $plugin_admin = new Smartmail_Software_Store_Admin();
    $plugin_public = new Smartmail_Software_Store_Public();

    $plugin_admin->register_hooks();
    $plugin_public->register_hooks();
}
add_action('plugins_loaded', 'run_smartmail_software_store');
?>
