<?php

class SmartMail_Software_Store_Backend {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_backend_menu'));
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            __('SmartMail Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            'smartmail-store',
            array($this, 'display_admin_page'),
            'dashicons-store'
        );

        add_submenu_page(
            'smartmail-store',
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            'smartmail-store-settings',
            array($this, 'display_settings_page')
        );

        add_submenu_page(
            'smartmail-store',
            __('eBooks', 'smartmail-software-store'),
            __('eBooks', 'smartmail-software-store'),
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'display_ebooks_page')
        );

        add_submenu_page(
            'smartmail-store',
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            'smartmail-store-software',
            array($this, 'display_software_page')
        );
    }

    public function display_admin_page() {
        include plugin_dir_path(__FILE__) . '../templates/admin-page.php';
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
