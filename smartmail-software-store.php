<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A plugin to manage and display eBooks and Software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SmartMail_Software_Store {
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'smartmail-software-store';
        $this->version = '1.0.0';
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
    }

    private function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin($this->plugin_name, $this->version);
        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
    }

    private function define_public_hooks() {
        $plugin_public = new SmartMail_Software_Store_Public($this->plugin_name, $this->version);
    }

    public static function activate() {
        SmartMail_Software_Store_Activator::activate();
    }

    public static function deactivate() {
        // Deactivation code here
    }
}

register_activation_hook(__FILE__, array('SmartMail_Software_Store', 'activate'));
register_deactivation_hook(__FILE__, array('SmartMail_Software_Store', 'deactivate'));

$plugin = new SmartMail_Software_Store();
