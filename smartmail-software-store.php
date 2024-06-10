<?php
/**
 * Plugin Name: Smartmail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0.0
 * Author: Marco Zagato
 * Author URI: http://smartmail.store
 * License: Proprietary
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'SMARTMAIL_SOFTWARE_STORE_VERSION', '1.0.0' );

function activate_smartmail_software_store() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-software-store-activator.php';
    Smartmail_Software_Store_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_smartmail_software_store' );

require plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-admin.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-smartmail-software-store-public.php';

function run_smartmail_software_store() {
    $plugin = new Smartmail_Software_Store();
    $plugin->run();
}
run_smartmail_software_store();

class Smartmail_Software_Store {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'smartmail-software-store';
        $this->version = SMARTMAIL_SOFTWARE_STORE_VERSION;
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-smartmail-software-store-loader.php';
        $this->loader = new Smartmail_Software_Store_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Smartmail_Software_Store_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
    }

    private function define_public_hooks() {
        $plugin_public = new Smartmail_Software_Store_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_public, 'add_shortcode' );
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}
