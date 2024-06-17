<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A plugin to manage and sell software and eBooks.
 * Version: 1.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Include the required files.
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';

// Activation and deactivation hooks.
register_activation_hook(__FILE__, 'activate_smartmail_software_store');
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

/**
 * The code that runs during plugin activation.
 */
function activate_smartmail_software_store()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';
    Software_Store_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_smartmail_software_store()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-software-store-activator.php';
    Software_Store_Activator::deactivate();
}

// Initialize the admin functionality of the plugin.
if (is_admin()) {
    $admin_plugin = new SmartMail_Software_Store_Admin();
    $admin_plugin->run();
}

// Initialize the public-facing functionality of the plugin.
$public_plugin = new SmartMail_Software_Store_Public();
$public_plugin->run();
?>
