<?php

/**
 * The backend-specific functionality of the plugin.
 *
 * @link       https://smartmail.store
 * @since      1.0.0
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/backend
 */
class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-backend.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-backend.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            'SmartMail Software Store Backend',
            'SmartMail Backend',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_backend_page'),
            'dashicons-admin-tools',
            26
        );
    }

    public function display_plugin_backend_page() {
        include_once plugin_dir_path(__FILE__) . 'templates/backend-page.php';
    }
}
?>
