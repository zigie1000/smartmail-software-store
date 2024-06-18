<?php
// Ensure this constant is defined
if (!defined('SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR')) {
    define('SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

class SmartMail_Software_Store_Backend {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_backend_menu'));
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            __('SmartMail Store', 'textdomain'),
            __('SmartMail Store', 'textdomain'),
            'manage_options',
            'smartmail-software-store',
            array($this, 'backend_page'),
            'dashicons-store'
        );
    }

    public function backend_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-page.php';
    }
}

new SmartMail_Software_Store_Backend();
?>
