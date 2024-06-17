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

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_plugin_admin_page' ),
            'dashicons-store',
            26
        );
    }

    public function display_plugin_admin_page() {
        include_once plugin_dir_path(__FILE__) . 'partials/smartmail-software-store-admin-display.php';
    }
}
?>
