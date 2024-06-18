<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SmartMail_Software_Store_Backend {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_backend_menu'));
    }

    public function add_plugin_backend_menu() {
        add_submenu_page(
            'smartmail-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'display_plugin_backend_page')
        );
    }

    public function display_plugin_backend_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-software-page.php';
    }
}

new SmartMail_Software_Store_Backend();
?>
