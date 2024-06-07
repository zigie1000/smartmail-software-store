<?php
/*
Plugin Name: SmartMail Software Store
Description: A plugin to sell software and ebooks downloads on SmartMail Store.
Version: 1.0
Author: Marco Zagato
Author Email: info@smartmail.store
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'smartmail_log' ) ) {
    function smartmail_log( $message ) {
        if ( WP_DEBUG === true ) {
            if ( is_array( $message ) || is_object( $message ) ) {
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}

smartmail_log('SmartMail Software Store plugin is loading');

require_once plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-public.php';

class SmartMail_Software_Store {
    private $admin;
    private $public;

    public function __construct() {
        smartmail_log('Initializing SmartMail Software Store');
        $this->admin = new SmartMail_Software_Store_Admin();
        $this->public = new SmartMail_Software_Store_Public();

        add_action( 'admin_menu', array( $this->admin, 'create_admin_menu' ) );
        add_action( 'admin_init', array( $this->admin, 'register_settings' ) );
        add_action( 'wp_enqueue_scripts', array( $this->public, 'enqueue_public_scripts' ) );
        add_shortcode( 'software_store', array( $this->public, 'display_software_store' ) );
        add_shortcode( 'ebook_store', array( $this->public, 'display_ebook_store' ) );
    }

    public static function create_store_pages() {
        smartmail_log('Creating store pages');
        if (null == get_page_by_title('Software Store')) {
            wp_insert_post(array(
                'post_title'    => 'Software Store',
                'post_content'  => '[software_store]',
                'post_status'   => 'publish',
                'post_type'     => 'page'
            ));
        }

        if (null == get_page_by_title('Ebook Store')) {
            wp_insert_post(array(
                'post_title'    => 'Ebook Store',
                'post_content'  => '[ebook_store]',
                'post_status'   => 'publish',
                'post_type'     => 'page'
            ));
        }
    }
}

register_activation_hook(__FILE__, array('SmartMail_Software_Store', 'create_store_pages'));

new SmartMail_Software_Store();
