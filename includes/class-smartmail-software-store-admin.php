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
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-admin-generic',
            26
        );

        add_submenu_page(
            $this->plugin_name,
            'Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_settings_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'Backend',
            'Backend',
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_backend_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once 'partials/smartmail-software-store-admin-display.php';
    }

    public function display_plugin_settings_page() {
        include_once 'partials/smartmail-software-store-admin-settings-display.php';
    }

    public function display_plugin_backend_page() {
        include_once 'partials/smartmail-software-store-admin-backend-display.php';
    }
}
?>
