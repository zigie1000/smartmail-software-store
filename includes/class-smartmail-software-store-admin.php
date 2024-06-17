<?php
class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

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
            array($this, 'display_plugin_setup_page'),
            'dashicons-store',
            2
        );
        add_submenu_page(
            $this->plugin_name,
            'Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '_settings',
            array($this, 'display_plugin_settings_page')
        );
    }

    public function display_plugin_setup_page() {
        include_once 'templates/admin-software-page.php';
    }

    public function display_plugin_settings_page() {
        include_once 'templates/admin-settings-page.php';
    }

    public function register_admin_settings() {
        register_setting(
            'smartmail_software_store_settings',
            'smartmail_software_store_settings',
            array($this, 'sanitize')
        );
        add_settings_section(
            'smartmail_software_store_setting_section',
            'SmartMail Software Store Settings',
            array($this, 'section_info'),
            'smartmail_software_store_settings'
        );
        add_settings_field(
            'setting_field_description',
            'Settings field description',
            array($this, 'setting_field_callback'),
            'smartmail_software_store_settings',
            'smartmail_software_store_setting_section'
        );
    }

    public function sanitize($input) {
        return $input;
    }

    public function section_info() {
        echo 'This section description';
    }

    public function setting_field_callback() {
        printf(
            '<input type="text" id="setting_field_description" name="smartmail_software_store_settings[setting_field_description]" value="%s" />',
            isset($this->options['setting_field_description']) ? esc_attr($this->options['setting_field_description']) : ''
        );
    }
}
