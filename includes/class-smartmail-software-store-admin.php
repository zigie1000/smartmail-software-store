<?php

class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-software-store',
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            26
        );

        add_submenu_page(
            'smartmail-software-store',
            'Settings',
            'Settings',
            'manage_options',
            'smartmail-software-store-settings',
            array($this, 'display_plugin_settings_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            'Backend',
            'Backend',
            'manage_options',
            'smartmail-software-store-backend',
            array($this, 'display_plugin_backend_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once('templates/admin-page.php');
    }

    public function display_plugin_settings_page() {
        include_once('templates/admin-settings-page.php');
    }

    public function display_plugin_backend_page() {
        include_once('templates/admin-backend-page.php');
    }
}
?>
