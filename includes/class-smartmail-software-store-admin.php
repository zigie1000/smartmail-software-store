<?php

class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
        // Include necessary files if needed
    }

    private function define_admin_hooks() {
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page'),
            'dashicons-admin-generic',
            26
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
            'Backend',
            'Backend',
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_backend_page')
        );
    }

    public function display_plugin_setup_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-page.php';
    }
    
    public function display_settings_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-settings-page.php';
    }

    public function display_backend_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-backend-page.php';
    }
}

?>
