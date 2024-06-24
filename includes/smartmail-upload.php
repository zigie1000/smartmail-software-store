<?php
/*
Plugin Name: SmartMail Uploads
Description: Upload eBooks and software, and handle downloads after purchase.
Author: Marco Zagato
Author URI: https://smartmail.store
Version: 1.0
*/

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

// Ensure WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', 'smartmail_woocommerce_inactive_notice');
    return;
}

function smartmail_woocommerce_inactive_notice(): void {
    echo '<div class="error"><p><strong>SmartMail Uploads:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
}

// Register Custom Post Type for Digital Products
function smartmail_register_digital_products_post_type(): void {
    $labels = array(
        'name'               => _x('Digital Products', 'post type general name', 'smartmail'),
        'singular_name'      => _x('Digital Product', 'post type singular name', 'smartmail'),
        'menu_name'          => _x('Digital Products', 'admin menu', 'smartmail'),
        'name_admin_bar'     => _x('Digital Product', 'add new on admin bar', 'smartmail'),
        'add_new'            => _x('Add New', 'digital product', 'smartmail'),
        'add_new_item'       => __('Add New Digital Product', 'smartmail'),
        'new_item'           => __('New Digital Product', 'smartmail'),
        'edit_item'          => __('Edit Digital Product', 'smartmail'),
        'view_item'          => __('View Digital Product', 'smartmail'),
        'all_items'          => __('All Digital Products', 'smartmail'),
        'search_items'       => __('Search Digital Products', 'smartmail'),
        'parent_item_colon'  => __('Parent Digital Products:', 'smartmail'),
        'not_found'          => __('No digital products found.', 'smartmail'),
        'not_found_in_trash' => __('No digital products found in Trash.', 'smartmail')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'digital-products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );

    register_post_type('digital_product', $args);
}
add_action('init', 'smartmail_register_digital_products_post_type');

// Add Meta Boxes for Digital Products
function smartmail_add_digital_products_meta_boxes(): void {
    add_meta_box(
        'digital_product_details',
        'Digital Product Details',
        'smartmail_digital_product_details_callback',
        'digital_product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'smartmail_add_digital_products_meta_boxes');

function smartmail_digital_product_details_callback($post): void {
    wp_nonce_field(basename(__FILE__), 'smartmail_nonce');
    $file_url = get_post_meta($post->ID, '_file_url', true);
    ?>

    <table class="form-table">
        <tr>
            <th><label for="file_url">File URL</label></th>
            <td><input type="text" name="file_url" id="file_url" value="<?php echo esc_attr($file_url); ?>" class="regular-text"></td>
        </tr>
    </table>

    <?php
}

function smartmail_save_digital_product_details(int $post_id): void {
if (!isset($_POST['smartmail_nonce']) || !wp_verify_nonce($_POST['smartmail_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if ('digital_product' !== $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $file_url = isset($_POST['file_url']) ? esc_url_raw($_POST['file_url']) : '';

    update_post_meta($post_id, '_file_url', $file_url);
}
add_action('save_post', 'smartmail_save_digital_product_details');

// Add download link to WooCommerce order
function smartmail_add_download_link_to_order($item_id, $item, $order_id) {
    $product_id = $item->get_product_id();
    $file_url = get_post_meta($product_id, '_file_url', true);

    if ($file_url) {
        $order = wc_get_order($order_id);
        $download_link = '<a href="' . esc_url($file_url) . '">Download your digital product</a>';
        $order->add_order_note( $download_link );
    }
}
add_action('woocommerce_order_item_meta_end', 'smartmail_add_download_link_to_order', 10, 3);
?>                                                        
