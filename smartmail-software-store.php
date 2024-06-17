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
        $this->define_backend_hooks();
        $this->define_frontend_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-backend.php';
        require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-frontend.php';
    }

    private function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin($this->plugin_name, $this->version);
        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
    }

    private function define_public_hooks() {
        $plugin_public = new SmartMail_Software_Store_Public($this->plugin_name, $this->version);
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($plugin_public, 'enqueue_scripts'));
    }

    private function define_backend_hooks() {
        $plugin_backend = new SmartMail_Software_Store_Backend($this->plugin_name, $this->version);
        add_action('admin_menu', array($plugin_backend, 'add_plugin_backend_menu'));
    }

    private function define_frontend_hooks() {
        $plugin_frontend = new SmartMail_Software_Store_Frontend($this->plugin_name, $this->version);
        add_action('wp_enqueue_scripts', array($plugin_frontend, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($plugin_frontend, 'enqueue_scripts'));
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
