<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to manage and sell eBooks and software.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

try {
    require_once plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
} catch (Exception $e) {
    error_log('Error including required files: ' . $e->getMessage());
    wp_die('There was an error initializing the plugin. Please check the error logs for more details.');
}

register_activation_hook(__FILE__, array('Software_Store_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('Software_Store_Activator', 'deactivate'));

if (is_admin()) {
    try {
        new SmartMail_Software_Store_Admin();
    } catch (Exception $e) {
        error_log('Error initializing admin functionalities: ' . $e->getMessage());
        wp_die('There was an error initializing the admin functionalities. Please check the error logs for more details.');
    }
} else {
    try {
        new SmartMail_Software_Store_Public();
    } catch (Exception $e) {
        error_log('Error initializing public functionalities: ' . $e->getMessage());
        wp_die('There was an error initializing the public functionalities. Please check the error logs for more details.');
    }
}

class SmartMail_Software_Store {
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types() {
        register_post_type('ebook', array(
            'labels' => array(
                'name' => __('eBooks'),
                'singular_name' => __('eBook')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
        ));

        register_post_type('software', array(
            'labels' => array(
                'name' => __('Software'),
                'singular_name' => __('Software')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
        ));
    }
}

try {
    new SmartMail_Software_Store();
} catch (Exception $e) {
    error_log('Error initializing post types: ' . $e->getMessage());
    wp_die('There was an error initializing the post types. Please check the error logs for more details.');
}
?>
