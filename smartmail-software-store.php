<?php
/*
Plugin Name: SmartMail Software Store
Description: The main plugin that integrates custom functionalities.
Author: Marco Zagato
Author URI: https://smartmail.store
Version: 1.0
*/

// Include the custom plugin file (adjust the path if necessary)
require_once plugin_dir_path(__FILE__) . 'includes/smartmail-software-store-custom.php';

class SmartMail_Software_Store_Activator {
    public static function activate() {
        // Create custom post types for eBooks and Software
        self::create_custom_post_types();
    }

    private static function create_custom_post_types() {
        // Register eBook post type
        $ebook_labels = array(
            'name'               => _x('eBooks', 'post type general name', 'smartmail-software-store'),
            'singular_name'      => _x('eBook', 'post type singular name', 'smartmail-software-store'),
            'menu_name'          => _x('eBooks', 'admin menu', 'smartmail-software-store'),
            'name_admin_bar'     => _x('eBook', 'add new on admin bar', 'smartmail-software-store'),
            'add_new'            => _x('Add New', 'eBook', 'smartmail-software-store'),
            'add_new_item'       => __('Add New eBook', 'smartmail-software-store'),
            'new_item'           => __('New eBook', 'smartmail-software-store'),
            'edit_item'          => __('Edit eBook', 'smartmail-software-store'),
            'view_item'          => __('View eBook', 'smartmail-software-store'),
            'all_items'          => __('All eBooks', 'smartmail-software-store'),
            'search_items'       => __('Search eBooks', 'smartmail-software-store'),
            'parent_item_colon'  => __('Parent eBooks:', 'smartmail-software-store'),
            'not_found'          => __('No eBooks found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No eBooks found in Trash.', 'smartmail-software-store')
        );

        $ebook_args = array(
            'labels'             => $ebook_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'ebook'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('ebook', $ebook_args);

        // Register Software post type
        $software_labels = array(
            'name'               => _x('Software', 'post type general name', 'smartmail-software-store'),
            'singular_name'      => _x('Software', 'post type singular name', 'smartmail-software-store'),
            'menu_name'          => _x('Software', 'admin menu', 'smartmail-software-store'),
            'name_admin_bar'     => _x('Software', 'add new on admin bar', 'smartmail-software-store'),
            'add_new'            => _x('Add New', 'Software', 'smartmail-software-store'),
            'add_new_item'       => __('Add New Software', 'smartmail-software-store'),
            'new_item'           => __('New Software', 'smartmail-software-store'),
            'edit_item'          => __('Edit Software', 'smartmail-software-store'),
            'view_item'          => __('View Software', 'smartmail-software-store'),
            'all_items'          => __('All Software', 'smartmail-software-store'),
            'search_items'       => __('Search Software', 'smartmail-software-store'),
            'parent_item_colon'  => __('Parent Software:', 'smartmail-software-store'),
            'not_found'          => __('No Software found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No Software found in Trash.', 'smartmail-software-store')
        );

        $software_args = array(
            'labels'             => $software_labels,
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
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('software', $software_args);
    }
}
?>
