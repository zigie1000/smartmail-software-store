<?php
/*
* Plugin Name: SmartMail Software Store
* Description: A WordPress plugin to manage and sell eBooks and software.
* Version: 1.5
* Author: Marco Zagato
* Author URI: https://smartmail.store
*/

// Include front-end and back-end files
include_once plugin_dir_path(__FILE__) . 'smartmail-software-store-frontend.php';
include_once plugin_dir_path(__FILE__) . 'smartmail-software-store-backend.php';

// Enqueue scripts and styles
function smartmail_enqueue_scripts() {
    wp_enqueue_style('smartmail-store-style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('smartmail-store-script', plugins_url('/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_enqueue_scripts');

// Create custom database tables on plugin activation
function smartmail_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // eBooks table
    $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
    $sql = "CREATE TABLE $ebooks_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        rrp float NOT NULL,
        image_url varchar(255) NOT NULL,
        sku varchar(50) DEFAULT '',
        barcode varchar(50) DEFAULT '',
        quantity int DEFAULT 0,
        file_url varchar(255) NOT NULL,
        wc_product_id bigint(20) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Software table
    $software_table_name = $wpdb->prefix . 'smartmail_software';
    $sql = "CREATE TABLE $software_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        rrp float NOT NULL,
        image_url varchar(255) NOT NULL,
        sku varchar(50) DEFAULT '',
        barcode varchar(50) DEFAULT '',
        quantity int DEFAULT 0,
        file_url varchar(255) NOT NULL,
        wc_product_id bigint(20) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql);

    // Subscription table
    $subscription_table_name = $wpdb->prefix . 'smartmail_subscriptions';
    $sql = "CREATE TABLE $subscription_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        full_name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(15),
        address text DEFAULT '',
        newsletter_optin boolean DEFAULT false,
        PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'smartmail_create_tables');

// Create necessary pages on plugin activation
function smartmail_create_pages() {
    // Create eBook page
    $ebook_page_title = 'eBooks';
    $ebook_page_content = '[smartmail_display_ebooks]';
    $ebook_page_check = get_page_by_title($ebook_page_title);
    $ebook_page = array(
        'post_title' => $ebook_page_title,
        'post_content' => $ebook_page_content,
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    if (!isset($ebook_page_check->ID)) {
        wp_insert_post($ebook_page);
    }

    // Create Software page
    $software_page_title = 'Software';
    $software_page_content = '[smartmail_display_software]';
    $software_page_check = get_page_by_title($software_page_title);
    $software_page = array(
        'post_title' => $software_page_title,
        'post_content' => $software_page_content,
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    if (!isset($software_page_check->ID)) {
        wp_insert_post($software_page);
    }

    // Create Subscription page
    $subscription_page_title = 'Subscribe';
    $subscription_page_content = '[subscription_form]';
    $subscription_page_check = get_page_by_title($subscription_page_title);
    $subscription_page = array(
        'post_title' => $subscription_page_title,
        'post_content' => $subscription_page_content,
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    if (!isset($subscription_page_check->ID)) {
        wp_insert_post($subscription_page);
    }
}
register_activation_hook(__FILE__, 'smartmail_create_pages');
?>
