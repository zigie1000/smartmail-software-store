<?php
// Add Upload Field to eBook and Software Custom Post Types
function smartmail_add_upload_meta_box(): void {
    add_meta_box(
        'smartmail_upload_meta_box',
        'File Upload',
        'smartmail_upload_meta_box_callback',
        ['ebook', 'software'],
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'smartmail_add_upload_meta_box');

function smartmail_upload_meta_box_callback($post): void {
    wp_nonce_field(basename(__FILE__), 'smartmail_nonce');
    $uploaded_file = get_post_meta($post->ID, '_uploaded_file', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="uploaded_file">Upload File</label></th>
            <td>
                <input type="file" id="uploaded_file" name="uploaded_file" value="<?php echo esc_attr($uploaded_file); ?>" class="regular-text">
            </td>
        </tr>
    </table>
    <?php
}

function smartmail_save_upload_meta_box($post_id): void {
    if (!isset($_POST['smartmail_nonce']) || !wp_verify_nonce($_POST['smartmail_nonce'], basename(__FILE__))) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] === UPLOAD_ERR_OK) {
        $upload = wp_upload_bits($_FILES['uploaded_file']['name'], null, file_get_contents($_FILES['uploaded_file']['tmp_name']));
        if (!$upload['error']) {
            update_post_meta($post_id, '_uploaded_file', $upload['url']);
        }
    }
}
add_action('save_post', 'smartmail_save_upload_meta_box');

// Display download link after successful payment
function smartmail_display_download_link($content) {
    if (is_singular(['ebook', 'software']) && is_main_query()) {
        $uploaded_file = get_post_meta(get_the_ID(), '_uploaded_file', true);
        if ($uploaded_file) {
            $content .= '<p><a href="' . esc_url($uploaded_file) . '" download>Download File</a></p>';
        }
    }
    return $content;
}
add_filter('the_content', 'smartmail_display_download_link');
