<?php
/*
Plugin Name: SmartMail Software Store
Description: A WordPress plugin to manage and sell software.
Version: 1.0
Author: Marco Zagato
Author URI: info@smartmail.store
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function activate_smartmail_software_store() {
    // Custom activation code here.
}
register_activation_hook(__FILE__, 'activate_smartmail_software_store');

function deactivate_smartmail_software_store() {
    // Custom deactivation code here.
}
register_deactivation_hook(__FILE__, 'deactivate_smartmail_software_store');

function smartmail_software_store_enqueue_scripts() {
    wp_enqueue_style('smartmail-software-store-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('smartmail-software-store-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_software_store_enqueue_scripts');

require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-admin.php';
require plugin_dir_path(__FILE__) . 'includes/class-smartmail-software-store-public.php';

function run_smartmail_software_store() {
    $plugin = new SmartMail_Software_Store();
    $plugin->run();
}
run_smartmail_software_store();
?>
