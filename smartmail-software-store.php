<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A plugin to manage and display eBooks and Software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

if (!defined('WPINC')) {
    die;
}

function activate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
    SmartMail_Software_Store_Activator::activate();
}

function deactivate_smartmail_software_store() {
    // Code for deactivation
}

register_activation_hook(__FILE__, 'activate_smartmail_software_store');
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
