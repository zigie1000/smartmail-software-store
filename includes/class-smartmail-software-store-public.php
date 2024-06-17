<?php
if (!class_exists('SmartMail_Software_Store_Public')) {
    class SmartMail_Software_Store_Public {
        public function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function enqueue_styles() {
            wp_enqueue_style('smartmail-software-store-public', plugin_dir_url(__FILE__) . 'css/smartmail-software-store-public.css', array(), '1.0.0', 'all');
        }

        public function enqueue_scripts() {
            wp_enqueue_script('smartmail-software-store-public', plugin_dir_url(__FILE__) . 'js/smartmail-software-store-public.js', array('jquery'), '1.0.0', false);
        }

        public function display_ebooks_page() {
            include plugin_dir_path(__FILE__) . 'templates/ebooks-page.php';
        }

        public function display_software_page() {
            include plugin_dir_path(__FILE__) . 'templates/software-page.php';
        }
    }
}
