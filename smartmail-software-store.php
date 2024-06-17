<?php
/**
 * Plugin Name: SmartMail Software Store
 * Plugin URI:  https://smartmail.store
 * Description: A plugin to manage and display eBooks and Software.
 * Version:     1.0.0
 * Author:      Marco Zagato
 * Author URI:  https://smartmail.store
 * Text Domain: smartmail-software-store
 * Domain Path: /languages
 */

if (!defined('WPINC')) {
    die;
}

define('SMARTMAIL_SOFTWARE_STORE_VERSION', '1.0.0');

function activate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
    SmartMail_Software_Store_Activator::activate();
}

function deactivate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-deactivator.php';
    SmartMail_Software_Store_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smartmail_software_store');
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store.php';

function run_smartmail_software_store() {
    $plugin = new SmartMail_Software_Store();
    $plugin->run();
}

run_smartmail_software_store();
