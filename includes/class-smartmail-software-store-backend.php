<?php

class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-store'
        );

        add_submenu_page(
            $this->plugin_name,
            'Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_settings_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'eBooks',
            'eBooks',
            'manage_options',
            $this->plugin_name . '-ebooks',
            array($this, 'display_ebooks_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'Software',
            'Software',
            'manage_options',
            $this->plugin_name . '-software',
            array($this, 'display_software_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once plugin_dir_path(__FILE__) . 'admin/partials/admin-page.php';
    }

    public function display_settings_page() {
        include_once plugin_dir_path(__FILE__) . 'admin/partials/admin-settings-page.php';
    }

    public function display_ebooks_page() {
        include_once plugin_dir_path(__FILE__) . 'admin/partials/admin-ebooks-page.php';
    }

    public function display_software_page() {
        include_once plugin_dir_path(__FILE__) . 'admin/partials/admin-software-page.php';
    }
}
?>
