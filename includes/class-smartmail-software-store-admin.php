<?php
class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-admin.js', array('jquery'), $this->version, false);
    }

    public function add_admin_menu() {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-store',
            array($this, 'admin_index'),
            'dashicons-store',
            110
        );

        add_submenu_page(
            'smartmail-store',
            'Settings',
            'Settings',
            'manage_options',
            'smartmail-store-settings',
            array($this, 'settings_page')
        );

        add_submenu_page(
            'smartmail-store',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-store-ebooks',
            array($this, 'ebooks_page')
        );

        add_submenu_page(
            'smartmail-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-store-software',
            array($this, 'software_page')
        );

        add_submenu_page(
            'smartmail-store',
            'SmartMail Store Backend',
            'SmartMail Store Backend',
            'manage_options',
            'smartmail-store-backend',
            array($this, 'backend_page')
        );
    }

    public function admin_index() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-index.php';
    }

    public function settings_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-settings-page.php';
    }

    public function ebooks_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-ebooks-page.php';
    }

    public function software_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-software-page.php';
    }

    public function backend_page() {
        include_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-backend-page.php';
    }
}

if (class_exists('SmartMail_Software_Store_Admin')) {
    new SmartMail_Software_Store_Admin();
}
?>
