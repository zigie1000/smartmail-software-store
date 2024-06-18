<?php

class SmartMail_Software_Store_Admin {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smartmail-software-store-admin.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smartmail-software-store-admin.js', array( 'jquery' ), $this->version, false );
    }

    public function display_admin_page() {
        include_once 'templates/admin-page.php';
    }

    public function display_admin_ebooks_page() {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_admin_software_page() {
        include_once 'templates/admin-software-page.php';
    }

    public function display_admin_settings_page() {
        include_once 'templates/admin-settings-page.php';
    }

    public function display_admin_backend_page() {
        include_once 'templates/admin-backend-page.php';
    }
}

?>
