<?php
/**
 * Admin class for SmartMail Software Store Plugin
 * 
 * Handles the admin area functionalities.
 */
class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            __('SmartMail Software Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_dashboard'),
            'dashicons-store',
            26
        );

        add_submenu_page(
            $this->plugin_name,
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_admin_settings')
        );

        add_submenu_page(
            $this->plugin_name,
            __('Ebooks', 'smartmail-software-store'),
            __('Ebooks', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-ebooks',
            array($this, 'display_plugin_admin_ebooks')
        );

        add_submenu_page(
            $this->plugin_name,
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name . '-software',
            array($this, 'display_plugin_admin_software')
        );
    }

    public function display_plugin_admin_dashboard() {
        include_once 'templates/admin-page.php';
    }

    public function display_plugin_admin_settings() {
        include_once 'templates/admin-settings-page.php';
    }

    public function display_plugin_admin_ebooks() {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_plugin_admin_software() {
        include_once 'templates/admin-software-page.php';
    }
}
?>
