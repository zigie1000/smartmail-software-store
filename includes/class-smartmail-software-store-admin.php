<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://smartmail.store
 * @since      1.0.0
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples of hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/admin
 * @author     Marco Zagato <info@smartmail.store>
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
            __('SmartMail Software Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page'),
            'dashicons-store',
            2
        );
    }

    public function display_plugin_setup_page() {
        include_once 'templates/admin-page.php';
    }
}
?>
