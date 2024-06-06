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

        // Hook into plugin activation
        register_activation_hook(__FILE__, array($this, 'create_store_pages'));
    }

    public function create_store_pages() {
        // Create the software store page
        if (null == get_page_by_title('Software Store')) {
            wp_insert_post(array(
                'post_title'    => 'Software Store',
                'post_content'  => '<h1>Welcome to Our Software Store</h1>
                                    <p>Explore our collection of premium software designed to boost your productivity and efficiency. Each product is carefully curated to meet your needs. Shop now and transform your digital experience.</p>
                                    <h2>Featured Software</h2>
                                    [software_store]
                                    <p>Need help? Contact our <a href="mailto:support@smartmail.store">support team</a> for assistance.</p>',
                'post_status'   => 'publish',
                'post_type'     => 'page'
            ));
        }

        // Create the ebook store page
        if (null == get_page_by_title('Ebook Store')) {
            wp_insert_post(array(
                'post_title'    => 'Ebook Store',
                'post_content'  => '<h1>Discover Our Ebook Collection</h1>
                                    <p>Dive into our extensive range of ebooks, covering various topics to enrich your knowledge and skills. Whether you\'re looking for professional development or personal growth, we have something for everyone.</p>
                                    <h2>Featured Ebooks</h2>
                                    [ebook_store]
                                    <p>Need help? Contact our <a href="mailto:support@smartmail.store">support team</a> for assistance.</p>',
                'post_status'   => 'publish',
                'post_type'     => 'page'
            ));
        }
    }
}

new SmartMail_Software_Store();
