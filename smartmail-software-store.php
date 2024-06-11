<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// Create custom database tables on plugin activation
function smartmail_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Table for ebooks
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
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
register_activation_hook(__FILE__, 'smartmail_create_tables');

// Enqueue styles and scripts
function smartmail_enqueue_assets() {
    wp_enqueue_style('smartmail-store-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('smartmail-store-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_enqueue_assets');

// Shortcode to display ebooks
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

// Register admin menu
function smartmail_register_admin_menu() {
    add_menu_page(
        'SmartMail Software Store',
        'SmartMail Store',
        'manage_options',
        'smartmail-software-store',
        'smartmail_admin_page',
        'dashicons-store',
        6
    );
}
add_action('admin_menu', 'smartmail_register_admin_menu');

// Admin page callback
function smartmail_admin_page() {
    echo '<div class="wrap">';
    echo '<h1>SmartMail Software Store</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields('smartmail-settings-group');
    do_settings_sections('smartmail-software-store');
    submit_button();
    echo '</form>';
    echo '</div>';
}
