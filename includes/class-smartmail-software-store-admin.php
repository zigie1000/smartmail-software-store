<?php
/**
 * SmartMail Software Store
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/includes
 * @author     Marco Zagato
 * @author URI https://smartmail.store
 */

class SmartMail_Software_Store {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'smartmail-software-store';
        $this->version = '1.0.0';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-smartmail-software-store-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-smartmail-software-store-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-smartmail-software-store-public.php';

        $this->loader = new SmartMail_Software_Store_Loader();
    }

    private function set_locale() {
        $plugin_i18n = new SmartMail_Software_Store_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin($this->plugin_name, $this->version);
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_submenu_pages');
    }

    private function define_public_hooks() {
        $plugin_public = new SmartMail_Software_Store_Public($this->plugin_name, $this->version);
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }
}
