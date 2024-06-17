<?php
/**
 * Plugin Name: SmartMail Software Store
 * Plugin URI: https://smartmail.store
 * Description: A plugin to manage software and ebook sales.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-deactivator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';

register_activation_hook(__FILE__, array('SmartMail_Software_Store_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('SmartMail_Software_Store_Deactivator', 'deactivate'));

class SmartMail_Software_Store {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu() {
        add_menu_page('SmartMail Store', 'SmartMail Store', 'manage_options', 'smartmail_store', array($this, 'create_admin_page'), 'dashicons-store', 6);
        add_submenu_page('smartmail_store', 'eBooks', 'eBooks', 'manage_options', 'smartmail_store_ebooks', array($this, 'create_ebooks_page'));
        add_submenu_page('smartmail_store', 'Software', 'Software', 'manage_options', 'smartmail_store_software', array($this, 'create_software_page'));
    }

    public function create_admin_page() {
        include plugin_dir_path(__FILE__) . 'templates/admin-page.php';
    }

    public function create_ebooks_page() {
        include plugin_dir_path(__FILE__) . 'templates/admin-ebooks-page.php';
    }

    public function create_software_page() {
        include plugin_dir_path(__FILE__) . 'templates/admin-software-page.php';
    }

    public function register_settings() {
        // Register settings here
    }
}

new SmartMail_Software_Store();
?>
