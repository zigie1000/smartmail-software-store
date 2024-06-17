class SmartMail_Software_Store_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-public.js', array('jquery'), $this->version, false);
    }

    public function register_custom_post_types() {
        $this->register_ebook_post_type();
        $this->register_software_post_type();
    }

    private function register_ebook_post_type() {
        $labels = array(
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

        $args = array(
            'labels'             => $labels,
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

        register_post_type('ebook', $args);
    }

    private function register_software_post_type() {
        $labels = array(
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

        $args = array(
            'labels'             => $labels,
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

        register_post_type('software', $args);
    }
}
?>
