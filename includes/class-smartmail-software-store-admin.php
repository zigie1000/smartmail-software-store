<?php
/**
 * SmartMail Software Store Admin Class
 * 
 * @package SmartMail_Software_Store
 * @author Marco Zagato
 * @author URI: https://smartmail.store
 */

class SmartMail_Software_Store_Admin {

    public function __construct() {
        // Hook into the admin menu
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function run() {
        // Define the plugin functionality here
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Software Store', 
            'SmartMail Store', 
            'manage_options', 
            'smartmail-software-store', 
            array($this, 'display_plugin_admin_page'),
            'dashicons-admin-generic',
            26
        );
        add_submenu_page(
            'smartmail-software-store', 
            'eBooks', 
            'eBooks', 
            'manage_options', 
            'smartmail-software-store-ebooks', 
            array($this, 'display_ebooks_page')
        );
        add_submenu_page(
            'smartmail-software-store', 
            'Software', 
            'Software', 
            'manage_options', 
            'smartmail-software-store-software', 
            array($this, 'display_software_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once 'templates/admin-page.php';
    }

    public function display_ebooks_page() {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_software_page() {
        include_once 'templates/admin-software-page.php';
    }

    public function enqueue_styles() {
        wp_enqueue_style('smartmail-software-store-admin-css', plugin_dir_url(__FILE__) . 'css/style.css');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('smartmail-software-store-admin-js', plugin_dir_url(__FILE__) . 'js/script.js');
    }
}

if (class_exists('SmartMail_Software_Store_Admin')) {
    $smartmail_software_store_admin = new SmartMail_Software_Store_Admin();
    $smartmail_software_store_admin->run();
}
