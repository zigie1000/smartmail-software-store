<?php
class SmartMail_Software_Store_File_Upload {
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_custom_meta_boxes'));
        add_action('save_post', array($this, 'save_custom_meta_boxes'), 10, 2);
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
        // Save eBook file
        if (isset($_POST['ebook_file_nonce']) && wp_verify_nonce($_POST['ebook_file_nonce'], 'save_ebook_file')) {
            if (isset($_FILES['ebook_file']) && !empty($_FILES['ebook_file']['name'])) {
                $uploaded_file = $_FILES['ebook_file'];
                $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
                if (isset($upload['url'])) {
                    update_post_meta($post_id, '_ebook_file_url', $upload['url']);
                }
            }
        }

        // Save Software file
        if (isset($_POST['software_file_nonce']) && wp_verify_nonce($_POST['software_file_nonce'], 'save_software_file')) {
            if (isset($_FILES['software_file']) && !empty($_FILES['software_file']['name'])) {
                $uploaded_file = $_FILES['software_file'];
                $upload = wp_handle_upload($uploaded_file, array('test_form' => false));
                if (isset($upload['url'])) {
                    update_post_meta($post_id, '_software_file_url', $upload['url']);
                }
            }
        }
    }
}

new SmartMail_Software_Store_File_Upload();
?>
