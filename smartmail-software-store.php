<?php
/**
 * Plugin Name: SmartMail Software Store
 * Plugin URI: https://smartmail.store
 * Description: A plugin to manage and display eBooks and Software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 * License: GPL2
 */

if (!defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-deactivator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';

function activate_smartmail_software_store() {
    SmartMail_Software_Store_Activator::activate();
}

function deactivate_smartmail_software_store() {
    SmartMail_Software_Store_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smartmail_software_store');
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

function run_smartmail_software_store() {
    $plugin = new SmartMail_Software_Store_Admin('smartmail-software-store', '1.0.0');
    $plugin->run();
}

run_smartmail_software_store();
