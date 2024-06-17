<?php
/**
 * Admin functionality of the plugin.
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/admin
 */
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
            26
        );

        add_submenu_page(
            $this->plugin_name,
            'SmartMail Software Store Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_settings_page')
        );
    }

    public function display_plugin_setup_page() {
        include_once 'templates/admin-page.php';
    }

    public function display_plugin_settings_page() {
        include_once 'templates/admin-settings-page.php';
    }

    public function register_settings() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    public function validate($input) {
        // Validation logic
        return $input;
    }
}
