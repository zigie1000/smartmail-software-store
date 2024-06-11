<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.0
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// Create custom database tables on plugin activation
function smartmail_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Table for ebooks
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Create the page and insert the shortcode
    $page_title = 'SmartMail Ebooks';
    $page_content = '[smartmail_ebooks_display]';
    $page = array(
        'post_title'    => $page_title,
        'post_content'  => $page_content,
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );

    // Check if the page already exists
    if (!get_page_by_title($page_title)) {
        wp_insert_post($page);
    }
}
register_activation_hook(__FILE__, 'smartmail_create_tables');

// Enqueue styles and scripts
function smartmail_enqueue_assets() {
    wp_enqueue_style('smartmail-store-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('smartmail-store-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_enqueue_assets');

// Shortcode to display ebooks
function smartmail_display_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $ebooks = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="smartmail-ebooks">';
    foreach ($ebooks as $ebook) {
        echo '<div class="software-store-item">';
        echo '<h2 class="software-store-item-title">' . esc_html($ebook->title) . '</h2>';
        echo '<div class="software-store-item-description">' . esc_html($ebook->description) . '</div>';
        echo '<p class="software-store-item-price">Price: $' . esc_html($ebook->price) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('smartmail_ebooks_display', 'smartmail_display_ebooks');

// Register admin menu
function smartmail_register_admin_menu() {
    add_menu_page(
        'SmartMail Software Store',
        'SmartMail Store',
        'manage_options',
        'smartmail-software-store',
        'smartmail_admin_page',
        'dashicons-store',
        6
    );
}
add_action('admin_menu', 'smartmail_register_admin_menu');

// Admin page callback
function smartmail_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['smartmail_ebook'])) {
        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $price = floatval($_POST['price']);

        $wpdb->insert(
            $table_name,
            array(
                'title' => $title,
                'description' => $description,
                'price' => $price
            )
        );
        echo '<div class="notice notice-success is-dismissible"><p>Product added successfully.</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>SmartMail Software Store</h1>
        <form method="post" action="">
            <h2>Add New Product</h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Title</th>
                    <td><input type="text" name="title" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Description</th>
                    <td><textarea name="description" required></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Price</th>
                    <td><input type="number" step="0.01" name="price" required /></td>
                </tr>
            </table>
            <input type="hidden" name="smartmail_ebook" value="1" />
            <?php submit_button('Add Product'); ?>
        </form>
        <h2>Existing Products</h2>
        <table class="widefat fixed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $wpdb->get_results("SELECT * FROM $table_name");
                foreach ($products as $product) {
                    echo '<tr>';
                    echo '<td>' . $product->id . '</td>';
                    echo '<td>' . $product->title . '</td>';
                    echo '<td>' . $product->description . '</td>';
                    echo '<td>$' . $product->price . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
