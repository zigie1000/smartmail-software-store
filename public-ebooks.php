<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to manage and sell software.
Version: 1.0
Author: Marco Zagato
Author URI: info@smartmail.store
*/

function smartmail_ebooks_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'smartmail_ebooks_create_table');

function smartmail_ebooks_display() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    $output = '<div class="smartmail-ebooks">';
    foreach ($results as $row) {
        $output .= '<div class="ebook">';
        $output .= '<h3>' . esc_html($row->title) . '</h3>';
        $output .= '<p>' . esc_html($row->description) . '</p>';
        $output .= '<p>Price: ' . esc_html($row->price) . '</p>';
        $output .= '</div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('smartmail_ebooks_display', 'smartmail_ebooks_display');

function smartmail_ebooks_add_page() {
    $page = array(
        'post_title'    => 'Ebooks Store',
        'post_content'  => '[smartmail_ebooks_display]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );

    wp_insert_post($page);
}
register_activation_hook(__FILE__, 'smartmail_ebooks_add_page');
?>
