<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
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
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            26
        );

        add_submenu_page(
            'smartmail-store',
            'SmartMail Store Settings',
            'Settings',
            'manage_options',
            'smartmail-store-settings',
            array($this, 'display_plugin_admin_settings_page')
        );

        add_submenu_page(
            'smartmail-store',
            'SmartMail Store eBooks',
            'eBooks',
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'display_plugin_admin_ebooks_page')
        );

        add_submenu_page(
            'smartmail-store',
            'SmartMail Store Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'display_plugin_admin_software_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once('partials/admin-page.php');
    }

    public function display_plugin_admin_settings_page() {
        include_once('partials/admin-settings-page.php');
    }

    public function display_plugin_admin_ebooks_page() {
        include_once('partials/admin-ebooks-page.php');
    }

    public function display_plugin_admin_software_page() {
        include_once('partials/admin-software-page.php');
    }
}

new SmartMail_Software_Store_Admin();
?>
