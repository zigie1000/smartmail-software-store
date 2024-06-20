<?php
class SmartMail_Software_Store {
    private static $instance = null;

    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        add_action('init', array($this, 'register_custom_post_types')); // Use init hook for registering custom post types
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
        $plugin_admin = new SmartMail_Software_Store_Admin();
    }

    public function register_custom_post_types() {
        // Register eBooks post type
        $labels = array(
            'name' => _x('eBooks', 'Post Type General Name', 'smartmail-software-store'),
            'singular_name' => _x('eBook', 'Post Type Singular Name', 'smartmail-software-store'),
            'menu_name' => __('eBooks', 'smartmail-software-store'),
            'name_admin_bar' => __('eBook', 'smartmail-software-store'),
            'archives' => __('eBook Archives', 'smartmail-software-store'),
            'attributes' => __('eBook Attributes', 'smartmail-software-store'),
            'parent_item_colon' => __('Parent eBook:', 'smartmail-software-store'),
            'all_items' => __('All eBooks', 'smartmail-software-store'),
            'add_new_item' => __('Add New eBook', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
            'new_item' => __('New eBook', 'smartmail-software-store'),
            'edit_item' => __('Edit eBook', 'smartmail-software-store'),
            'update_item' => __('Update eBook', 'smartmail-software-store'),
            'view_item' => __('View eBook', 'smartmail-software-store'),
            'view_items' => __('View eBooks', 'smartmail-software-store'),
            'search_items' => __('Search eBook', 'smartmail-software-store'),
            'not_found' => __('Not found', 'smartmail-software-store'),
            'not_found_in_trash' => __('Not found in Trash', 'smartmail-software-store'),
            'featured_image' => __('Featured Image', 'smartmail-software-store'),
            'set_featured_image' => __('Set featured image', 'smartmail-software-store'),
            'remove_featured_image' => __('Remove featured image', 'smartmail-software-store'),
            'use_featured_image' => __('Use as featured image', 'smartmail-software-store'),
            'insert_into_item' => __('Insert into eBook', 'smartmail-software-store'),
            'uploaded_to_this_item' => __('Uploaded to this eBook', 'smartmail-software-store'),
            'items_list' => __('eBooks list', 'smartmail-software-store'),
            'items_list_navigation' => __('eBooks list navigation', 'smartmail-software-store'),
            'filter_items_list' => __('Filter eBooks list', 'smartmail-software-store'),
        );
        $args = array(
            'label' => __('eBook', 'smartmail-software-store'),
            'description' => __('Post Type Description', 'smartmail-software-store'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
            'taxonomies' => array('category', 'post_tag'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
        );
        register_post_type('ebook', $args);

        // Register Software post type
        $labels = array(
            'name' => _x('Software', 'Post Type General Name', 'smartmail-software-store'),
            'singular_name' => _x('Software', 'Post Type Singular Name', 'smartmail-software-store'),
            'menu_name' => __('Software', 'smartmail-software-store'),
            'name_admin_bar' => __('Software', 'smartmail-software-store'),
            'archives' => __('Software Archives', 'smartmail-software-store'),
            'attributes' => __('Software Attributes', 'smartmail-software-store'),
            'parent_item_colon' => __('Parent Software:', 'smartmail-software-store'),
            'all_items' => __('All Software', 'smartmail-software-store'),
            'add_new_item' => __('Add New Software', 'smartmail-software-store'),
            'add_new' => __('Add New', 'smartmail-software-store'),
            'new_item' => __('New Software', 'smartmail-software-store'),
            'edit_item' => __('Edit Software', 'smartmail-software-store'),
            'update_item' => __('Update Software', 'smartmail-software-store'),
            'view_item' => __('View Software', 'smartmail-software-store'),
            'view_items' => __('View Software', 'smartmail-software-store'),
            'search_items' => __('Search Software', 'smartmail-software-store'),
            'not_found' => __('Not found', 'smartmail-software-store'),
            'not_found_in_trash' => __('Not found in Trash', 'smartmail-software-store'),
            'featured_image' => __('Featured Image', 'smartmail-software-store'),
            'set_featured_image' => __('Set featured image', 'smartmail-software-store'),
            'remove_featured_image' => __('Remove featured image', 'smartmail-software-store'),
            'use_featured_image' => __('Use as featured image', 'smartmail-software-store'),
            'insert_into_item' => __('Insert into Software', 'smartmail-software-store'),
            'uploaded_to_this_item' => __('Uploaded to this Software', 'smartmail-software-store'),
            'items_list' => __('Software list', 'smartmail-software-store'),
            'items_list_navigation' => __('Software list navigation', 'smartmail-software-store'),
            'filter_items_list' => __('Filter Software list', 'smartmail-software-store'),
        );
        $args = array(
            'label' => __('Software', 'smartmail-software-store'),
            'description' => __('Post Type Description', 'smartmail-software-store'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
            'taxonomies' => array('category', 'post_tag'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in
