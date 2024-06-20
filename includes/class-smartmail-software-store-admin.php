<?php
if (!class_exists('SmartMail_Software_Store_Admin')) {
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
                'smartmail-software-store-ebooks',
                array($this, 'ebooks_page')
            );
            add_submenu_page(
                'smartmail-software-store',
                __('Software', 'smartmail-software-store'),
                __('Software', 'smartmail-software-store'),
                'manage_options',
                'smartmail-software-store-software',
                array($this, 'software_page')
            );
        }

        public function admin_index() {
            require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-index.php';
        }

        public function settings_page() {
            require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-settings-page.php';
        }

        public function ebooks_page() {
            require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-ebooks-page.php';
        }

        public function software_page() {
            require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-software-page.php';
        }
    }
}
?>
