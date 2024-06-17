<?php

/**
 * SmartMail Software Store Public Class
 *
 * @package SmartMail Software Store
 * @author Marco Zagato
 * @author URI https://smartmail.store
 */

class SmartMail_Software_Store_Public {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_styles() {
        wp_enqueue_style('smartmail-software-store', plugin_dir_url(__FILE__) . 'css/style.css', array(), '1.0.0', 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('smartmail-software-store', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0.0', true);
    }
}

new SmartMail_Software_Store_Public();
