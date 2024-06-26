<?php
/*
Plugin Name: SmartMail Software Store
Description: Core functionality for the SmartMail Software Store.
Author: Marco Zagato
Author URI: https://smartmail.store
Version: 1.0
*/

declare(strict_types=1);

// Ensure WooCommerce is active before proceeding
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', 'smartmail_woocommerce_inactive_notice');
    return;
}

function smartmail_woocommerce_inactive_notice(): void {
    echo '<div class="error"><p><strong>SmartMail Software Store:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
}

// Include custom functionality
require_once plugin_dir_path(__FILE__) . 'smartmail-software-store-custom.php';
