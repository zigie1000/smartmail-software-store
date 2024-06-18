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
            array($this, 'display_plugin_admin_dashboard'),
            'dashicons-store',
            25
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
            'eBooks',
            'eBooks',
            'manage_options',
            $this->plugin_name . '-ebooks',
            array($this, 'display_plugin_ebooks_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'Software',
            'Software',
            'manage_options',
            $this->plugin_name . '-software',
            array($this, 'display_plugin_software_page')
        );
    }

    public function display_plugin_admin_dashboard() {
        include_once 'templates/admin-page.php';
    }

    public function display_plugin_settings_page() {
        include_once 'templates/admin-settings-page.php';
    }

    public function display_plugin_ebooks_page() {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_plugin_software_page() {
        include_once 'templates/admin-software-page.php';
    }
}
?>
