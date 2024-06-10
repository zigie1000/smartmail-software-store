<?php
/**
 * Plugin Name: SmartMail Software Store
 * Plugin URI: https://smartmail.store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 * Text Domain: smartmail-software-store
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('SMARTMAIL_SOFTWARE_STORE_VERSION', '1.0.0');

// The code that runs during plugin activation.
function activate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-activator.php';
    SmartMail_Software_Store_Activator::activate();
}

// The code that runs during plugin deactivation.
function deactivate_smartmail_software_store() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-deactivator.php';
    SmartMail_Software_Store_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smartmail_software_store');
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

// The core plugin class.
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store.php';

// Run the plugin.
function run_smartmail_software_store() {
    $plugin = new SmartMail_Software_Store();
    $plugin->run();
}
run_smartmail_software_store();
?>
