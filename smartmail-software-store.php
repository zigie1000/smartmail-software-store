<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to manage and sell software and ebooks.
Version: 1.0.0
Author: Marco Zagato
Author URI: https://smartmail.store
*/

class SmartMail_Software_Store {
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types() {
        // Register eBooks post type
        $labels = array(
            'name' => _x('eBooks', 'Post Type General Name', 'smartmail-software-store'),
            'singular_name' => _x('eBook', 'Post Type Singular Name', 'smartmail-software-store'),
            'menu_name' => __('eBooks', 'smartmail-software-store'),
            'name_admin_bar' => __('eBook', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
            'add_new_item' => __('Add New eBook', 'smartmail-software-store'),
            'new_item' => __('New eBook', 'smartmail-software-store'),
            'edit_item' => __('Edit eBook', 'smartmail-software-store'),
            'view_item' => __('View eBook', 'smartmail-software-store'),
            'all_items' => __('All eBooks', 'smartmail-software-store'),
            'search_items' => __('Search eBooks', 'smartmail-software-store'),
            'parent_item_colon' => __('Parent eBooks:', 'smartmail-software-store'),
            'not_found' => __('No eBooks found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No eBooks found in Trash.', 'smartmail-software-store')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'ebook'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('ebook', $args);

        // Register Software post type
        $labels = array(
            'name' => _x('Software', 'Post Type General Name', 'smartmail-software-store'),
            'singular_name' => _x('Software', 'Post Type Singular Name', 'smartmail-software-store'),
            'menu_name' => __('Software', 'smartmail-software-store'),
            'name_admin_bar' => __('Software', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
            'add_new_item' => __('Add New Software', 'smartmail-software-store'),
            'new_item' => __('New Software', 'smartmail-software-store'),
            'edit_item' => __('Edit Software', 'smartmail-software-store'),
            'view_item' => __('View Software', 'smartmail-software-store'),
            'all_items' => __('All Software', 'smartmail-software-store'),
            'search_items' => __('Search Software', 'smartmail-software-store'),
            'parent_item_colon' => __('Parent Software:', 'smartmail-software-store'),
            'not_found' => __('No Software found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No Software found in Trash.', 'smartmail-software-store')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'software'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('software', $args);
    }
}

new SmartMail_Software_Store();

// Include the custom plugin file
require_once plugin_dir_path(__FILE__) . 'includes/smartmail-software-store-custom.php';
