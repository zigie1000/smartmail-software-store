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
            'SmartMail Software Store Backend',
            'SmartMail Store Backend',
            'manage_options',
            'smartmail-software-store-backend',
            array($this, 'display_plugin_backend_page'),
            'dashicons-store',
            26
        );
    }

    public function display_plugin_backend_page() {
        include_once('templates/admin-backend-page.php');
    }
}
?>
