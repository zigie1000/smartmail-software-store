class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('add_meta_boxes', array($this, 'add_custom_meta_boxes'));
        add_action('save_post', array($this, 'save_custom_meta_boxes'), 10, 2);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('SmartMail Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store',
            array($this, 'admin_index'),
            'dashicons-store',
            110
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store-settings',
            array($this, 'settings_page')
        );
        add_submenu_page(
            'smartmail-software-store',
            __('eBooks', 'smartmail-software-store'),
            __('eBooks', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store-ebooks',
            array($this, 'ebooks_page')
        );
        add_submenu_page(
            'smartmail-software-store',
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store-software',
            array($this, 'software_page')
        );
    }

    public function admin_index() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-index.php';
    }

    public function settings_page() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-settings-page.php';
    }

    public function ebooks_page() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-ebooks-page.php';
    }

    public function software_page() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/admin-software-page.php';
    }

    public function add_custom_meta_boxes() {
        add_meta_box(
            'ebook_file',
            __('eBook File', 'smartmail-software-store'),
            array($this, 'render_ebook_file_meta_box'),
            'ebook',
            'side',
            'default'
        );
        add_meta_box(
            'software_file',
            __('Software File', 'smartmail-software-store'),
            array($this, 'render_software_file_meta_box'),
            'software',
            'side',
            'default'
        );
    }

    public function render_ebook_file_meta_box($post) {
        wp_nonce_field('save_ebook_file', 'ebook_file_nonce');
        $file_url = get_post_meta($post->ID, '_ebook_file_url', true);
        echo '<input type="file" name="ebook_file" id="ebook_file" />';
        if ($file_url) {
            echo '<p>' . __('Current File:', 'smartmail-software-store') . ' <a href="' . esc_url($file_url) . '" target="_blank">' . basename($file_url) . '</a></p>';
        }
    }

    public function render_software_file_meta_box($post) {
        wp_nonce_field('save_software_file', 'software_file_nonce');
        $file_url = get_post_meta($post->ID, '_software_file_url', true);
        echo '<input type="file" name="software_file" id="software_file" />';
        if ($file_url) {
            echo '<p>' . __('Current File:', 'smartmail-software-store') . ' <a href="' . esc_url($file_url) . '" target="_blank">' . basename($file_url) . '</a></p>';
        }
    }

    public function save_custom_meta_boxes($post_id) {
        if (!isset($_POST['ebook_file_nonce']) || !wp_verify_nonce($_POST['ebook_file_nonce'], 'save_ebook_file')) {
            return $post_id;
        }
        if (!isset($_POST['software_file_nonce']) || !wp_verify_nonce($_POST['software_file_nonce'], 'save_software_file')) {
            return $post_id;
        }

        // Save eBook file
        if (isset($_FILES['ebook_file']) && !empty($_FILES['ebook_file']['name'])) {
            $uploaded_file = $_FILES['ebook_file'];
            $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
            if (isset($upload['url'])) {
                update_post_meta($post_id, '_ebook_file_url', $upload['url']);
            }
        }

        // Save Software file
        if (isset($_FILES['software_file']) && !empty($_FILES['software_file']['name'])) {
            $uploaded_file = $_FILES['software_file'];
            $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
            if (isset($upload['url'])) {
                update_post_meta($post_id, '_software_file_url', $upload['url']);
            }
        }
    }
}
