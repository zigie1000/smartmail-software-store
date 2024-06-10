<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// Ensure the plugin is being called within WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Includes
include_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
include_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';

// Activation and Deactivation Hooks
function smartmail_software_store_activate() {
    smartmail_create_ebooks_table();
    smartmail_create_software_table();
}
register_activation_hook(__FILE__, 'smartmail_software_store_activate');

// Enqueue Scripts and Styles
function smartmail_software_store_scripts() {
    wp_enqueue_style('smartmail-software-store-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('smartmail-software-store-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_software_store_scripts');

// Create Admin Menu
function smartmail_software_store_admin_menu() {
    add_menu_page(
        'SmartMail Software Store',
        'SmartMail Software Store',
        'manage_options',
        'smartmail-software-store',
        'smartmail_software_store_admin_page',
        'dashicons-store',
        6
    );
}
add_action('admin_menu', 'smartmail_software_store_admin_menu');

// Admin Page
function smartmail_software_store_admin_page() {
    include plugin_dir_path(__FILE__) . 'admin/admin-page.php';
}
