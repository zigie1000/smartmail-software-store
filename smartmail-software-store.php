<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A plugin to manage and sell eBooks and Software products.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

if (!defined('WPINC')) {
    die;
}

define('SMARTMAIL_SOFTWARE_STORE_VERSION', '1.0.0');

function activate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
    SmartMail_Software_Store_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_smartmail_software_store');

function deactivate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-deactivator.php';
    SmartMail_Software_Store_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store.php';
