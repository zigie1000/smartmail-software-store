<?php
/**
 * Plugin Name: SmartMail Software Store
 * Plugin URI: https://smartmail.store
 * Description: A plugin to manage and sell eBooks and Software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

if (!defined('WPINC')) {
    die;
}

require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-backend.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-frontend.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';

function activate_smartmail_software_store() {
    SmartMail_Software_Store_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_smartmail_software_store');

function run_smartmail_software_store() {
    $plugin = new SmartMail_Software_Store();
    $plugin->run();
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
        $this->admin = new SmartMail_Software_Store_Admin($this->plugin_name, $this->version);
        $this->backend = new SmartMail_Software_Store_Backend($this->plugin_name, $this->version);
        $this->frontend = new SmartMail_Software_Store_Frontend($this->plugin_name, $this->version);
    }

    private function define_admin_hooks() {
        add_action('admin_menu', array($this->admin, 'add_plugin_admin_menu'));
        add_action('admin_menu', array​⬤
