<?php
/**
 * SmartMail Software Store Admin Class
 * 
 * @package SmartMail_Software_Store
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-admin.js', array('jquery'), $this->version, false);
    }

    public function add_menu() {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-software-store',
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            6
        );

        add_submenu_page(
            'smartmail-software-store',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-ebooks',
            array($this, 'display_ebooks_admin_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-software',
            array($this, 'display_software_admin_page')
        );
    }

    public function display_plugin_admin_page() {
        include_once 'templates/admin-page.php';
    }

    public function display_ebooks_admin_page() {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_software_admin_page() {
        include_once 'templates/admin-software-page.php';
    }
}
?>
