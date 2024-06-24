<?php

class SmartMail_Software_Store_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        // Enqueue the main CSS file for the plugin
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-public.css', array(), $this->version, 'all');

        // Enqueue the CSS file for eBooks
        wp_enqueue_style($this->plugin_name . '-ebooks', plugin_dir_url(__FILE__) . 'css/smartmail-ebooks-store.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-public.js', array('jquery'), $this->version, false);
    }
}

// Hook the methods to the appropriate actions
add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
