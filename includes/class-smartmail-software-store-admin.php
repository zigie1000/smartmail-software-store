<?php
/**
 * Admin settings for the SmartMail Software Store plugin.
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
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            26
        );
        add_submenu_page(
            $this->plugin_name,
            'Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_admin_settings_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Backend',
            'Backend',
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_admin_backend_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Ebooks',
            'Ebooks',
            'manage_options',
            $this->plugin_name . '-ebooks',
            array($this, 'display_plugin_admin_ebooks_page')
        );
        add_submenu_page(
            $this->plugin_name,
            'Software',
            'Software',
            'manage_options',
            $this->plugin_name . '-software',
            array($this, 'display_plugin_admin_software_page')
        );
    }

    public function display_plugin_admin_page() {
        echo '<h1>SmartMail Software Store</h1>';
        echo '<p>Welcome to the SmartMail Software Store admin page.</p>';
    }

    public function display_plugin_admin_settings_page() {
        echo '<h1>Settings</h1>';
        echo '<p>Settings for the SmartMail Software Store.</p>';
        echo '<form method="post" action="options.php">';
        settings_fields('smartmail_store_settings_group');
        do_settings_sections('smartmail_store_settings_group');
        echo '<table class="form-table">';
        echo '<tr valign="top"><th scope="row">Setting 1</th><td><input type="text" name="setting_1" value="' . esc_attr(get_option('setting_1')) . '" /></td></tr>';
        echo '<tr valign="top"><th scope="row">Setting 2</th><td><input type="text" name="setting_2" value="' . esc_attr(get_option('setting_2')) . '" /></td></tr>';
        echo '</table>';
        submit_button();
        echo '</form>';
    }

    public function display_plugin_admin_backend_page() {
        echo '<h1>Backend</h1>';
        echo '<p>Manage backend settings for SmartMail Software Store.</p>';
        // Backend management functionalities
    }

    public function display_plugin_admin_ebooks_page() {
        echo '<h1>Ebooks</h1>';
        echo '<p>Manage ebooks for the SmartMail Software Store.</p>';
        // Ebooks management functionalities
    }

    public function display_plugin_admin_software_page() {
        echo '<h1>Software</h1>';
        echo '<p>Manage software for the SmartMail Software Store.</p>';
        // Software management functionalities
    }
}
