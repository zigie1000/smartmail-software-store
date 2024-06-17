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
        include_once 'partials/smartmail-software-store-admin-display.php';
    }
}

// Initialize the admin class and hook it into WordPress
function initialize_smartmail_software_store_admin() {
    $plugin_admin = new SmartMail_Software_Store_Admin('smartmail-software-store', '1.0.0');
    add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
    add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
    add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
}
initialize_smartmail_software_store_admin();

?>
