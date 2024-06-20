<?php
class SmartMail_Software_Store {
    private static $instance = null;
    private $plugin_admin;

    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->register_custom_post_types();
    }

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function load_dependencies() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store-admin.php';
    }

    private function define_admin_hooks() {
        $this->plugin_admin = new SmartMail_Software_Store_Admin();
    }

    private function register_custom_post_types() {
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types() {
        // Register eBook post type
        $labels = array(
            'name' => __('eBooks', 'smartmail-software-store'),
            'singular_name' => __('eBook', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
            'add_new_item' => __('Add New eBook', 'smartmail-software-store'),
            'edit_item' => __('Edit eBook', 'smartmail-software-store'),
            'new_item' => __('New eBook', 'smartmail-software-store'),
            'view_item' => __('View eBook', 'smartmail-software-store'),
            'search_items' => __('Search eBooks', 'smartmail-software-store'),
            'not_found' => __('No eBooks found', 'smartmail-software-store'),
            'not_found_in_trash' => __('No eBooks found in Trash', 'smartmail-software-store'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-book',
        );

        register_post_type('ebook', $args);

        // Register Software post type
        $labels = array(
            'name' => __('Software', 'smartmail-software-store'),
            'singular_name' => __('Software', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
