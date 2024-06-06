<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to sell software and ebooks downloads on SmartMail Store.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-public.php';

class SmartMail_Software_Store {
    private $admin;
    private $public;

    public function __construct() {
        $this->admin = new SmartMail_Software_Store_Admin();
        $this->public = new SmartMail_Software_Store_Public();

        add_action( 'admin_menu', array( $this->admin, 'create_admin_menu' ) );
        add_action( 'admin_init', array( $this->admin, 'register_settings' ) );
        add_action( 'wp_enqueue_scripts', array( $this->public, 'enqueue_public_scripts' ) );
        add_shortcode( 'software_store', array( $this->public, 'display_software_store' ) );
        add_shortcode( 'ebook_store', array( $this->public, 'display_ebook_store' ) );
    }
}

new SmartMail_Software_Store();
