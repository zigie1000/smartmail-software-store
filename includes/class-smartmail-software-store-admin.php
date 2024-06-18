<?php
// Ensure this constant is defined
if (!defined('SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR')) {
    define('SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

class SmartMail_Software_Store_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('SmartMail Store', 'textdomain'),
            __('SmartMail Store', 'textdomain'),
            'manage_options',
            'smartmail-software-store',
            array($this, 'admin_page'),
            'dashicons-store'
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Settings', 'textdomain'),
            __('Settings', 'textdomain'),
            'manage_options',
            'smartmail-software-store-settings',
            array($this, 'settings_page')
        );
        add_submenu_page(
            'smartmail-software-store',
            __('eBooks', 'textdomain'),
            __('eBooks', 'textdomain'),
            'manage_options',
            'smartmail-software-store-ebooks',
            array($this, 'ebooks_page')
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Software', 'textdomain'),
            __('Software', 'textdomain'),
            'manage_options',
            'smartmail-software-store-software',
            array($this, 'software_page')
        );
    }

    public function admin_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-page.php';
    }

    public function settings_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-settings-page.php';
    }

    public function ebooks_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-ebooks-page.php';
    }

    public function software_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin-software-page.php';
    }
}

new SmartMail_Software_Store_Admin();
?>
