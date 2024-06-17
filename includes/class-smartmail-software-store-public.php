<?php
/**
 * SmartMail Software Store Public Class
 * 
 * @package SmartMail_Software_Store
 * @author Marco Zagato
 * @author URI: https://smartmail.store
 */

class SmartMail_Software_Store_Public {

    public function __construct() {
        // Hook into WordPress
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_styles() {
        wp_enqueue_style('smartmail-software-store-public-css', plugin_dir_url(__FILE__) . 'css/style.css');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('smartmail-software-store-public-js', plugin_dir_url(__FILE__) . 'js/script.js');
    }
}

if (class_exists('SmartMail_Software_Store_Public')) {
    $smartmail_software_store_public = new SmartMail_Software_Store_Public();
}
