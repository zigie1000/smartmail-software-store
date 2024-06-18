<?php

class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_plugin_admin_menu']);
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Store', // Page title
            'SmartMail Store', // Menu title
            'manage_options',  // Capability
            'smartmail-software-store', // Menu slug
            [$this, 'display_plugin_admin_page'], // Function
            'dashicons-admin-generic', // Icon URL
            6 // Position
        );

        add_submenu_page(
            'smartmail-software-store', 
            'Settings', 
            'Settings', 
            'manage_options', 
            'smartmail-software-store-settings', 
            [$this, 'display_plugin_admin_settings_page']
        );

        add_submenu_page(
            'smartmail-software-store', 
            'eBooks', 
            'eBooks', 
            'manage_options', 
            'smartmail-software-store-ebooks', 
            [$this, 'display_plugin_admin_ebooks_page']
        );

        add_submenu_page(
            'smartmail-software-store', 
            'Software', 
            'Software', 
            'manage_options', 
            'smartmail-software-store-software', 
            [$this, 'display_plugin_admin_software_page']
        );
    }

    public function display_plugin_admin_page() {
        include_once(SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-page.php');
    }

    public function display_plugin_admin_settings_page() {
        include_once(SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-settings-page.php');
    }

    public function display_plugin_admin_ebooks_page() {
        include_once(SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-ebooks-page.php');
    }

    public function display_plugin_admin_software_page() {
        include_once(SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-software-page.php');
    }
}

if (class_exists('SmartMail_Software_Store_Admin')) {
    new SmartMail_Software_Store_Admin();
}
?>
