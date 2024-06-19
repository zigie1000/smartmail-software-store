<?php
class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-store',
            array($this, 'admin_index'),
            'dashicons-store',
            110
        );

        add_submenu_page(
            'smartmail-store',
            'Settings',
            'Settings',
            'manage_options',
            'smartmail-store-settings',
            array($this, 'settings_page')
        );

        add_submenu_page(
            'smartmail-store',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'ebooks_page')
        );

        add_submenu_page(
            'smartmail-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'software_page')
        );

        add_submenu_page(
            'smartmail-store',
            'SmartMail Store Backend',
            'SmartMail Store Backend',
            'manage_options',
            'smartmail-store-backend',
            array($this, 'backend_page')
        );
    }

    public function admin_index() {
        echo '<h1>SmartMail Software Store Admin</h1>';
    }

    public function settings_page() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-settings-page.php';
    }

    public function ebooks_page() {
        require_once SMARTMAIL
