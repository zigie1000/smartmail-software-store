<?php

class SmartMail_Software_Store_Admin {

    public static function add_plugin_admin_menu() {
        add_menu_page(
            __('SmartMail Software Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store',
            array(self::class, 'render_admin_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('eBooks', 'smartmail-software-store'),
            __('eBooks', 'smartmail-software-store'),
            'manage_options',
            'smartmail-ebooks',
            array(self::class, 'render_ebooks_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software',
            array(self::class, 'render_software_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            'smartmail-settings',
            array(self::class, 'render_settings_page')
        );
    }

    public static function render_admin_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-page.php';
    }

    public static function render_ebooks_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-ebooks-page.php';
    }

    public static function render_software_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-software-page.php';
    }

    public static function render_settings_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-settings-page.php';
    }
}

?>
