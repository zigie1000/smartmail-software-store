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
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_backend_dashboard'),
            'dashicons-admin-generic',
            27
        );
    }

    public function display_plugin_backend_dashboard() {
        include_once 'partials/admin-backend-page.php';
    }

    public function add_ebook($ebook) {
        // Code to add an ebook
    }

    public function edit_ebook($ebook_id, $ebook) {
        // Code to edit an ebook
    }

    public function delete_ebook($ebook_id) {
        // Code to delete an ebook
    }

    public function list_ebooks() {
        // Code to list all ebooks
    }

    public function add_software($software) {
        // Code to add a software
    }

    public function edit_software($software_id, $software) {
        // Code to edit a software
    }

    public function delete_software($software_id) {
        // Code to delete a software
    }

    public function list_software() {
        // Code to list all software
    }
}
