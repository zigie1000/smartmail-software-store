<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0
 * Author: Marco Zagato
 * Author URI: info@smartmail.store
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue Scripts and Styles
function enqueue_smartmail_software_store_assets() {
    wp_enqueue_script('smartmail-software-store-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('smartmail-software-store-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_smartmail_software_store_assets');

// Create Database Table for Ebooks
function smartmail_create_ebooks_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'smartmail_create_ebooks_table');

// Display Ebooks with Shortcode
function smartmail_display_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $ebooks = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="smartmail-ebooks">';
    foreach ($ebooks as $ebook) {
        echo '<div class="ebook">';
        echo '<h2>' . esc_html($ebook->title) . '</h2>';
        echo '<p>' . esc_html($ebook->description) . '</p>';
        echo '<p>Price: ' . esc_html($ebook->price) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('smartmail_ebooks_display', 'smartmail_display_ebooks');

// Admin and Public Class Includes
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
require plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';
?>
