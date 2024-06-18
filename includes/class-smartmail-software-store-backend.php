<?php
/**
 * The backend functionality of the plugin.
 */
class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function register_custom_post_types() {
        register_post_type('smartmail_ebook', array(
            'labels' => array(
                'name' => __('Ebooks'),
                'singular_name' => __('Ebook')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields')
        ));
        register_post_type('smartmail_software', array(
            'labels' => array(
                'name' => __('Software'),
                'singular_name' => __('Software')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields')
        ));
    }

    public function add_meta_boxes() {
        add_meta_box(
            'smartmail_ebook_details',
            __('Ebook Details'),
            array($this, 'display_ebook_meta_box'),
            'smartmail_ebook',
            'normal',
            'high'
        );
        add_meta_box(
            'smartmail_software_details',
            __('Software Details'),
            array($this, 'display_software_meta_box'),
            'smartmail_software',
            'normal',
            'high'
        );
    }

    public function display_ebook_meta_box($post) {
        // Display fields for ebook details
        echo '<label for="ebook_author">Author:</label>';
        echo '<input type="text" name="ebook_author" value="' . get_post_meta($post->ID, 'ebook_author', true) . '" />';
        echo '<br>';
        echo '<label for="ebook_price">Price:</label>';
        echo '<input type="text" name="ebook_price" value="' . get_post_meta($post->ID, 'ebook_price', true) . '" />';
    }

    public function display_software_meta_box($post) {
        // Display fields for software details
        echo '<label for="software_version">Version:</label>';
        echo '<input type="text" name="software_version" value="' . get_post_meta($post->ID, 'software_version', true) . '" />';
        echo '<br>';
        echo '<label for="software_price">Price:</label>';
        echo '<input type="text" name="software_price" value="' . get_post_meta($post->ID, 'software_price', true) . '" />';
    }

    public function save_post_meta($post_id) {
        if (isset($_POST['ebook_author'])) {
            update_post_meta($post_id, 'ebook_author', sanitize_text_field($_POST['ebook_author']));
        }
        if (isset($_POST['ebook_price'])) {
            update_post_meta($post_id, 'ebook_price', sanitize_text_field($_POST['ebook_price']));
        }
        if (isset($_POST['software_version'])) {
            update_post_meta($post_id, 'software_version', sanitize_text_field($_POST['software_version']));
        }
        if (isset($_POST['software_price'])) {
            update_post_meta($post_id, 'software_price', sanitize_text_field($_POST['software_price']));
        }
    }
}
