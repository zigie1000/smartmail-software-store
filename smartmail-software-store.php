<?php
/*
Plugin Name: SmartMail Software Store
Description: A comprehensive plugin to manage the SmartMail Software Store.
Author: Marco Zagato
Author URI: https://smartmail.store
Version: 1.0
*/

declare(strict_types=1);

// Ensure WooCommerce is active before proceeding
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', 'smartmail_woocommerce_inactive_notice');
    return;
}

function smartmail_woocommerce_inactive_notice(): void {
    echo '<div class="error"><p><strong>SmartMail Software Store:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
}

// Error logging function
function smartmail_log_error(string $message): void {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log($message);
    }
}

// Register Custom Post Type for Software
function smartmail_register_software_post_type(): void {
    $labels = array(
        'name'               => _x('Software', 'post type general name', 'smartmail'),
        'singular_name'      => _x('Software', 'post type singular name', 'smartmail'),
        'menu_name'          => _x('Software', 'admin menu', 'smartmail'),
        'name_admin_bar'     => _x('Software', 'add new on admin bar', 'smartmail'),
        'add_new'            => _x('Add New', 'software', 'smartmail'),
        'add_new_item'       => __('Add New Software', 'smartmail'),
        'new_item'           => __('New Software', 'smartmail'),
        'edit_item'          => __('Edit Software', 'smartmail'),
        'view_item'          => __('View Software', 'smartmail'),
        'all_items'          => __('All Software', 'smartmail'),
        'search_items'       => __('Search Software', 'smartmail'),
        'parent_item_colon'  => __('Parent Software:', 'smartmail'),
        'not_found'          => __('No software found.', 'smartmail'),
        'not_found_in_trash' => __('No software found in Trash.', 'smartmail')
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
        'supports'           => array('title', 'editor', 'custom-fields', 'thumbnail'),
    );

    register_post_type('software', $args);
}
add_action('init', 'smartmail_register_software_post_type');

// Add Meta Boxes for Software
function smartmail_add_software_meta_boxes(): void {
    add_meta_box(
        'software_details',
        'Software Details',
        'smartmail_software_details_callback',
        'software',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'smartmail_add_software_meta_boxes');

function smartmail_software_details_callback($post): void {
    wp_nonce_field(basename(__FILE__), 'smartmail_nonce');
    $software_id = get_post_meta($post->ID, '_software_id', true);
    $price = get_post_meta($post->ID, '_price', true);
    $rrp = get_post_meta($post->ID, '_rrp', true);
    $quantity = get_post_meta($post->ID, '_quantity', true);
    $sku = get_post_meta($post->ID, '_sku', true);
    $category = get_post_meta($post->ID, '_category', true);
    $file = get_post_meta($post->ID, '_file', true);
    ?>

    <table class="form-table">
        <tr>
            <th><label for="software_id">Item ID</label></th>
            <td><input type="text" name="software_id" id="software_id" value="<?php echo esc_attr($software_id); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="price">Price</label></th>
            <td><input type="text" name="price" id="price" value="<?php echo esc_attr($price); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="rrp">RRP</label></th>
            <td><input type="text" name="rrp" id="rrp" value="<?php echo esc_attr($rrp); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="quantity">Quantity</label></th>
            <td><input type="text" name="quantity" id="quantity" value="<?php echo esc_attr($quantity); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="sku">SKU</label></th>
            <td><input type="text" name="sku" id="sku" value="<?php echo esc_attr($sku); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="category">Category</label></th>
            <td><input type="text" name="category" id="category" value="<?php echo esc_attr($category); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="file">File</label></th>
            <td><input type="file" name="file" id="file" class="regular-text"></td>
        </tr>
    </table>

    <h2>Custom Fields</h2>
    <?php
    $custom_fields = get_post_custom($post->ID);
    foreach ($custom_fields as $key => $value) {
        if ('_' !== $key[0]) {
            echo '<p>';
            echo '<label for="' . esc_attr($key) . '">' . esc_html($key) . '</label>';
            echo '<input type="text" name="' . esc_attr($key) . '" value="' .
                esc_attr($value[0]) . '" class="regular-text" />';
            echo '</p>';
        }
    }
}

function smartmail_save_software_details(int $post_id): void {
    if (!isset($_POST['smartmail_nonce']) || !wp_verify_nonce($_POST['smartmail_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if ('software' !== $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $software_id = isset($_POST['software_id']) ? sanitize_text_field($_POST['software_id']) : '';
    $price = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
    $rrp = isset($_POST['rrp']) ? sanitize_text_field($_POST['rrp']) : '';
    $quantity = isset($_POST['quantity']) ? sanitize_text_field($_POST['quantity']) : '';
    $sku = isset($_POST['sku']) ? sanitize_text_field($_POST['sku']) : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $file = isset($_FILES['file']) ? $_FILES['file'] : '';

    update_post_meta($post_id, '_software_id', $software_id);
    update_post_meta($post_id, '_price', $price);
    update_post_meta($post_id, '_rrp', $rrp);
    update_post_meta($post_id, '_quantity', $quantity);
    update_post_meta($post_id, '_sku', $sku);
    update_post_meta($post_id, '_category', $category);

    if ($file && !empty($file['name'])) {
        $upload = wp_handle_upload($file, array('test_form' => false));
        if (isset($upload['url'])) {
            update_post_meta($post_id, '_file', $upload['url']);
        }
    }

    foreach ($_POST as $key => $value) {
        if ('_' !== $key[0]) {
            update_post_meta($post_id, sanitize_text_field($key), sanitize_text_field($value));
        }
    }
}
add_action('save_post', 'smartmail_save_software_details');

// Shortcode for displaying Software
function smartmail_display_software_shortcode($atts) {
    ob_start();
    $query = new WP_Query(array(
        'post_type' => 'software',
        'posts_per_page' => -1,
    ));

    if ($query->have_posts()) {
        echo '<ul class="software-list">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>';
    echo '<h2>' . get_the_title() . '</h2>';
    echo '<div>' . get_the_content() . '</div>';
    echo '</li>';
}
echo '</ul>';
} else {
    echo '<p>No software found.</p>';
}
wp_reset_postdata();
return ob_get_clean();
}
add_shortcode('smartmail_software_display', 'smartmail_display_software_shortcode');
?>
