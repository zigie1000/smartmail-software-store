<?php
class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('SmartMail Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store',
            array($this, 'admin_index'),
            'dashicons-store',
            110
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store-settings',
            array($this, 'settings_page')
        );
        add_submenu_page(
            'smartmail-software-store',
            __('eBooks', 'smartmail-software-store'),
            __('eBooks', 'smartmail-software-store'),
            'manage_options',
            'edit.php?post_type=ebook'
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            'edit.php?post_type=software'
        );
    }

    public function admin_index() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'templates/admin-page.php';
    }

    public function settings_page() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'templates/admin-settings-page.php';
    }
}
?>
