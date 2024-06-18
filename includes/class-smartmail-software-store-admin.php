<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-store',
            array($this, 'display_admin_page'),
            'dashicons-store',
            6
        );

        add_submenu_page(
            'smartmail-store',
            'Settings',
            'Settings',
            'manage_options',
            'smartmail-store-settings',
            array($this, 'display_settings_page')
        );

        add_submenu_page(
            'smartmail-store',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'display_ebooks_page')
        );

        add_submenu_page(
            'smartmail-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'display_software_page')
        );
    }

    public function display_admin_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-page.php';
    }

    public function display_settings_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-settings-page.php';
    }

    public function display_ebooks_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-ebooks-page.php';
    }

    public function display_software_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-software-page.php';
    }
}

new SmartMail_Software_Store_Admin();
?>
