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
            'SmartMail Backend',
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_backend_page'),
            'dashicons-admin-generic',
            27
        );
    }

    public function display_plugin_backend_page() {
        include_once 'partials/smartmail-software-store-backend-display.php';
    }
}
?>
