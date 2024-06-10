<?php
/*
Plugin Name: SmartMail Software Store
Description: A WordPress plugin to manage and sell software.
Version: 1.0.0
Author: Marco Zagato
Author URI: https://smartmail.store
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function smartmail_software_store_install() {
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

    // Add a page to display the ebooks
    $page = array(
        'post_title'    => 'Ebooks',
        'post_content'  => '[smartmail_ebooks_display]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );
    wp_insert_post($page);
}

register_activation_hook(__FILE__, 'smartmail_software_store_install');

function smartmail_software_store_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    // Delete the ebooks page
    $page = get_page_by_title('Ebooks');
    if ($page) {
        wp_delete_post($page->ID, true);
    }
}

register_deactivation_hook(__FILE__, 'smartmail_software_store_deactivate');

function smartmail_software_store_enqueue_scripts() {
    wp_enqueue_style('smartmail-software-store-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('smartmail-software-store-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'smartmail_software_store_enqueue_scripts');

function smartmail_ebooks_display() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    foreach ($results as $row) {
        echo '<div class="ebook">';
        echo '<h2>' . esc_html($row->title) . '</h2>';
        echo '<p>' . esc_html($row->description) . '</p>';
        echo '<p>Price: ' . esc_html($row->price) . '</p>';
        echo '</div>';
    }
    return ob_get_clean();
}

add_shortcode('smartmail_ebooks_display', 'smartmail_ebooks_display');
