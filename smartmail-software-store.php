<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to manage and sell software.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Activation Hook
register_activation_hook(__FILE__, 'smartmail_software_store_activate');
function smartmail_software_store_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_software_store';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation Hook
register_deactivation_hook(__FILE__, 'smartmail_software_store_deactivate');
function smartmail_software_store_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_software_store';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/public.php';

// Enqueue Scripts and Styles
function smartmail_software_store_enqueue_scripts() {
    wp_enqueue_style('smartmail-software-store-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('smartmail-software-store-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_software_store_enqueue_scripts');
