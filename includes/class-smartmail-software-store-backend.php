<?php

class SmartMail_Software_Store_Backend {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_backend_menu'));
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-store-backend',
            array($this, 'display_backend_page'),
            'dashicons-store',
            26
        );

        add_submenu_page(
            'smartmail-store-backend',
            'Software Backend',
            'Software Backend',
            'manage_options',
            'smartmail-store-software-backend',
            array($this, 'display_software_backend_page')
        );
    }

    public function display_backend_page() {
        include_once plugin_dir_path(__FILE__) . 'partials/admin-backend-page.php';
    }

    public function display_software_backend_page() {
        include_once plugin_dir_path(__FILE__) . 'partials/admin-software-backend-page.php';
    }
}

if (is_admin()) {
    $smartmail_store_backend = new SmartMail_Software_Store_Backend();
}
?>
