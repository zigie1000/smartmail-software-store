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
            26
        );

        add_submenu_page(
            $this->plugin_name,
            'Ebooks',
            'Ebooks',
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

    public function display_plugin_admin_dashboard() {
        include_once 'partials/admin-settings-page.php';
    }

    public function display_ebooks_page() {
        include_once 'partials/admin-ebooks-page.php';
    }

    public function display_software_page() {
        include_once 'partials/admin-software-page.php';
    }
}
