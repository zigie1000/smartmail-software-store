<?php
/**
 * Backend class for SmartMail Software Store Plugin
 * 
 * Handles the backend functionalities.
 */
class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            __('SmartMail Store Backend', 'smartmail-software-store'),
            __('SmartMail Store Backend', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_backend_dashboard'),
            'dashicons-admin-tools',
            26
        );

        add_submenu_page(
            $this->plugin_name . '-backend',
            __('Add/Edit/Delete eBooks', 'smartmail-software-store'),
            __('Ebooks', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-backend-ebooks',
            array($this, 'display_plugin_backend_ebooks')
        );

        add_submenu_page(
            $this->plugin_name . '-backend',
            __('Add/Edit/Delete Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-backend-software',
            array($this, 'display_plugin_backend_software')
        );
    }

    public function display_plugin_backend_dashboard() {
        include_once 'templates/admin-backend-page.php';
    }

    public function display_plugin_backend_ebooks() {
        include_once 'templates/admin-backend-ebooks-page.php';
    }

    public function display_plugin_backend_software() {
        include_once 'templates/admin-backend-software-page.php';
    }
}
?>
