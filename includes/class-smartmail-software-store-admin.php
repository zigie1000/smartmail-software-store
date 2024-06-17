<?php
class SmartMail_Software_Store_Admin {
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-admin.js', array('jquery'), $this->version, false);
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
            'Settings', 
            'Settings', 
            'manage_options', 
            $this->plugin_name . '-settings', 
            array($this, 'display_plugin_admin_settings')
        );
        add_submenu_page(
            $this->plugin_name, 
            'eBooks', 
            'eBooks', 
            'manage_options', 
            $this->plugin_name . '-ebooks', 
            array($this, 'display_plugin_admin_ebooks')
        );
        add_submenu_page(
            $this->plugin_name, 
            'Software', 
            'Software', 
            'manage_options', 
            $this->plugin_name . '-software', 
            array($this, 'display_plugin_admin_software')
        );
    }

    public function display_plugin_admin_dashboard() {
        include_once('templates/admin-page.php');
    }

    public function display_plugin_admin_settings() {
        include_once('templates/admin-settings-page.php');
    }

    public function display_plugin_admin_ebooks() {
        include_once('templates/admin-ebooks-page.php');
    }

    public function display_plugin_admin_software() {
        include_once('templates/admin-software-page.php');
    }
}
?>
