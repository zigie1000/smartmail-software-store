<?php
/**
 * Activator class for SmartMail Software Store Plugin
 * 
 * Handles the activation tasks for the plugin.
 */
class SmartMail_Software_Store_Activator {

    /**
     * Activation hook
     *
     * This function runs during the plugin activation.
     * 
     * @since 1.0.0
     */
    public static function activate() {
        // Ensure the environment meets requirements
        self::check_requirements();

        // Create necessary database tables
        self::create_database_tables();

        // Create custom post types for eBooks and Software
        self::create_custom_post_types();

        // Set default options
        self::set_default_options();

        // Flush rewrite rules to avoid 404 errors
        flush_rewrite_rules();
    }

    /**
     * Checks for environment requirements
     *
     * @since 1.0.0
     */
    private static function check_requirements() {
        global $wp_version;

        if (version_compare($wp_version, '5.0', '<')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('This plugin requires WordPress version 5.0 or higher.', 'smartmail-software-store'));
        }
    }

    /**
     * Creates necessary database tables
     *
     * @since 1.0.0
     */
    private static function create_database_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}smartmail_store_products (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_name varchar(255) NOT NULL,
            product_description text NOT NULL,
            product_type varchar(50) NOT NULL,
            price float NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Sets default options
     *
     * @since 1.0.0
     */
    private static function set_default_options() {
        add_option('smartmail_store_default_currency', 'USD');
        add_option('smartmail_store_items_per_page', 10);
    }

    /**
     * Creates custom post types for eBooks and Software
     *
     * @since 1.0.0
     */
    private static function create_custom_post_types() {
        // Register eBook post type
        $ebook_labels = array(
            'name'               => _x('eBooks', 'post type general name', 'smartmail-software-store'),
            'singular_name'      => _x('eBook', 'post type singular name', 'smartmail-software-store'),
            'menu_name'          => _x('eBooks', 'admin menu', 'smartmail-software-store'),
            'name_admin_bar'     => _x('eBook', 'add new on admin bar', 'smartmail-software-store'),
            'add_new'            => _x('Add New', 'eBook', 'smartmail-software-store'),
            'add_new_item'       => __('Add New eBook', 'smartmail-software-store'),
            'new_item'           => __('New eBook', 'smartmail-software-store'),
            'edit_item'          => __('Edit eBook', 'smartmail-software-store'),
            'view_item'          => __('View eBook', 'smartmail-software-store'),
            'all_items'          => __('All eBooks', 'smartmail-software-store'),
            'search_items'       => __('Search eBooks', 'smartmail-software-store'),
            'parent_item_colon'  => __('Parent eBooks:', 'smartmail-software-store'),
            'not_found'          => __('No eBooks found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No eBooks found in Trash.', 'smartmail-software-store')
        );

        $ebook_args = array(
            'labels'             => $ebook_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'ebook'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('ebook', $ebook_args);

        // Register Software post type
        $software_labels = array(
            'name'               => _x('Software', 'post type general name', 'smartmail-software-store'),
            'singular_name'      => _x('Software', 'post type singular name', 'smartmail-software-store'),
            'menu_name'          => _x('Software', 'admin menu', 'smartmail-software-store'),
            'name_admin_bar'     => _x('Software', 'add new on admin bar', 'smartmail-software-store'),
            'add_new'            => _x('Add New', 'Software', 'smartmail-software-store'),
            'add_new_item'       => __('Add New Software', 'smartmail-software-store'),
            'new_item'           => __('New Software', 'smartmail-software-store'),
            'edit_item'          => __('Edit Software', 'smartmail-software-store'),
            'view_item'          => __('View Software', 'smartmail-software-store'),
            'all_items'          => __('All Software', 'smartmail-software-store'),
            'search_items'       => __('Search Software', 'smartmail-software-store'),
            'parent_item_colon'  => __('Parent Software:', 'smartmail-software-store'),
            'not_found'          => __('No Software found.', 'smartmail-software-store'),
            'not_found_in_trash' => __('No Software found in Trash.', 'smartmail-software-store')
        );

        $software_args = array(
            'labels'             => $software_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'software'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('software', $software_args);
    }
}
?>
