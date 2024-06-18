<?php

class SmartMail_Software_Store_Backend {

    public static function add_plugin_backend_menu() {
        add_menu_page(
            __('SmartMail Software Store Backend', 'smartmail-software-store'),
            __('SmartMail Store Backend', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store-backend',
            array(self::class, 'render_backend_page')
        );
    }

    public static function render_backend_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-backend-page.php';
    }
}

?>
