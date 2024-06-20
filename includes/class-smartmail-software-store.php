<?php
class SmartMail_Software_Store {
    private static $instance = null;

    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->register_custom_post_types();
    }

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function load_dependencies() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store-admin.php';
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/class-smartmail-software-store-file-upload.php';
    }

    private function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin();
        new SmartMail_Software_Store_File_Upload();
    }

    private function register_custom_post_types() {
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types() {
        // Register eBook post type
        $labels = array(
            'name'               => _x( 'eBooks', 'post type general name', 'smartmail-software-store' ),
            'singular_name'      => _x( 'eBook', 'post type singular name', 'smartmail-software-store' ),
            'menu_name'          => _x( 'eBooks', 'admin menu', 'smartmail-software-store' ),
            'name_admin_bar'     => _x( 'eBook', 'add new on admin bar', 'smartmail-software-store' ),
            'add_new'            => _x( 'Add New', 'ebook', 'smartmail-software-store' ),
            'add_new_item'       => __( 'Add New eBook', 'smartmail-software-store' ),
            'new_item'           => __( 'New eBook', 'smartmail-software-store' ),
            'edit_item'          => __( 'Edit eBook', 'smartmail-software-store' ),
            'view_item'          => __( 'View eBook', 'smartmail-software-store' ),
            'all_items'          => __( 'All eBooks', 'smartmail-software-store' ),
            'search_items'       => __( 'Search eBooks', 'smartmail-software-store' ),
            'parent_item_colon'  => __( 'Parent eBooks:', 'smartmail-software-store' ),
            'not_found'          => __( 'No eBooks found.', 'smartmail-software-store' ),
            'not_found_in_trash' => __( 'No eBooks found in Trash.', 'smartmail-software-store' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'ebook' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

        register_post_type( 'ebook', $args );

        // Register Software post type
        $labels = array(
            'name'               => _x( 'Software', 'post type general name', 'smartmail-software-store' ),
            'singular_name'      => _x( 'Software', 'post type singular name', 'smartmail-software-store' ),
            'menu_name'          => _x( 'Software', 'admin menu', 'smartmail-software-store' ),
            'name_admin_bar'     => _x( 'Software', 'add new on admin bar', 'smartmail-software-store' ),
            'add_new'            => _x( 'Add New', 'software', 'smartmail-software-store' ),
            'add_new_item'       => __( 'Add New Software', 'smartmail-software-store' ),
            'new_item'           => __( 'New Software', 'smartmail-software-store' ),
            'edit_item'          => __( 'Edit Software', 'smartmail-software-store' ),
            'view_item'          => __( 'View Software', 'smartmail-software-store' ),
            'all_items'          => __( 'All Software', 'smartmail-software-store' ),
            'search_items'       => __( 'Search Software', 'smartmail-software-store' ),
            'parent_item_colon'  => __( 'Parent Software:', 'smartmail-software-store' ),
            'not_found'          => __( 'No Software found.', 'smartmail-software-store' ),
            'not_found_in_trash' => __( 'No Software found in Trash.', 'smartmail-software-store' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug'
