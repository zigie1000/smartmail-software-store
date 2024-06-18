<?php

class SmartMail_Software_Store_Backend {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_backend_menu'));
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            'SmartMail Store Backend',
            'SmartMail Store Backend',
            'manage_options',
            'smartmail-store-backend',
            array($this, 'display_backend_page'),
            'dashicons-admin-generic',
            26
        );

        add_submenu_page(
            'smartmail-store-backend',
            'Settings',
            'Settings',
            'manage_options',
            'smartmail-store-settings',
            array($this, 'display_settings_page')
        );

        add_submenu_page(
            'smartmail-store-backend',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'display_ebooks_page')
        );

        add_submenu_page(
            'smartmail-store-backend',
            'Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'display_software_page')
        );
    }

    public function display_backend_page() {
        include plugin_dir_path(__FILE__) . '../templates/admin-backend-page.php';
    }

    public function display_settings_page() {
        include plugin_dir_path(__FILE__) . '../templates/admin-settings-page.php';
    }

    public function display_ebooks_page() {
        include plugin_dir_path(__FILE__) . '../templates/admin-ebooks-page.php';
    }

    public function display_software_page() {
        include plugin_dir_path(__FILE__) . '../templates/admin-software-page.php';
    }
}

new SmartMail_Software_Store_Backend();
?>
