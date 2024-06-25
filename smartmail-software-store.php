<?php
/*
Plugin Name: SmartMail Software Store Customizations
Description: Custom post types, meta boxes, and export functionality for the SmartMail Software Store.
Author: Marco Zagato
Author URI: https://smartmail.store
Version: 1.0
*/

declare(strict_types=1);

// Ensure WooCommerce is active before proceeding
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', 'smartmail_woocommerce_inactive_notice');
    return;
}

function smartmail_woocommerce_inactive_notice(): void {
    echo '<div class="error"><p><strong>SmartMail Software Store Customizations:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
}

// Error logging function
function smartmail_log_error(string $message): void {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log($message);
    }
}

// Register Custom Post Type for Software
function smartmail_register_software_post_type(): void {
    try {
        $labels = array(
            'name'               => _x('Software', 'post type general name', 'smartmail'),
            'singular_name'      => _x('Software', 'post type singular name', 'smartmail'),
            'menu_name'          => _x('Software', 'admin menu', 'smartmail'),
            'name_admin_bar'     => _x('Software', 'add new on admin bar', 'smartmail'),
            'add_new'            => _x('Add New', 'software', 'smartmail'),
            'add_new_item'       => __('Add New Software', 'smartmail'),
            'new_item'           => __('New Software', 'smartmail'),
            'edit_item'          => __('Edit Software', 'smartmail'),
            'view_item'          => __('View Software', 'smartmail'),
            'all_items'          => __('All Software', 'smartmail'),
            'search_items'       => __('Search Software', 'smartmail'),
            'parent_item_colon'  => __('Parent Software:', 'smartmail'),
            'not_found'          => __('No software found.', 'smartmail'),
            'not_found_in_trash' => __('No software found in Trash.', 'smartmail')
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'software'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'custom-fields', 'thumbnail'),
        );

        register_post_type('software', $args);
    } catch (Exception $e) {
        smartmail_log_error("Error registering software post type: " . $e->getMessage());
        add_action('admin_notices', function() {
            echo '<div class="error"><p><strong>SmartMail Software Store Customizations:</strong> An error occurred while registering the software post type.</p></div>';
        });
    }
}
add_action('init', 'smartmail_register_software_post_type');

// Register Custom Post Type for eBooks
function smartmail_register_ebooks_post_type(): void {
    try {
        $labels = array(
            'name'               => _x('eBooks', 'post type general name', 'smartmail'),
            'singular_name'      => _x('eBook', 'post type singular name', 'smartmail'),
            'menu_name'          => _x('eBooks', 'admin menu', 'smartmail'),
            'name_admin_bar'     => _x('eBook', 'add new on admin bar', 'smartmail'),
            'add_new'            => _x('Add New', 'ebook', '
