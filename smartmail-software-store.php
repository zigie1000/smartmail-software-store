<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.1
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// Create custom database tables on plugin activation
function smartmail_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        rrp float NOT NULL,
        image_url varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $page_title = 'SmartMail Ebooks';
    $page_content = '[smartmail_ebooks_display]';
    $page = array(
        'post_title'    => $page_title,
        'post_content'  => $page_content,
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );

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
        if (!empty($ebook->image_url)) {
            echo '<img class="software-store-item-image" src="' . esc_url($ebook->image_url) . '" alt="' . esc_html($ebook->title) . '">';
        }
        echo '<h2 class="software-store-item-title">' . esc_html($ebook->title) . '</h2>';
        echo '<div class="software-store-item-description">' . esc_html($ebook->description) . '</div>';
        echo '<p class="software-store-item-price">Price: $' . esc_html($ebook->price) . '</p>';
        echo '<p class="software-store-item-rrp">RRP: $' . esc_html($ebook->rrp) . '</p>';
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
        $rrp = floatval($_POST['rrp']);
        $image_url = esc_url_raw($_POST['image_url']);

        if (isset($_POST['id']) && $_POST['id'] != '') {
            $wpdb->update(
                $table_name,
                array(
                    'title' => $title,
                    'description' => $description,
                    'price' => $price,
                    'rrp' => $rrp,
                    'image_url' => $image_url
                ),
                array('id' => intval($_POST['id']))
            );
            echo '<div class="notice notice-success is-dismissible"><p>Product updated successfully.</p></div>';
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'title' => $title,
                    'description' => $description,
                    'price' => $price,
                    'rrp' => $rrp,
                    'image_url' => $image_url
                )
            );
            echo '<div class="notice notice-success is-dismissible"><p>Product added successfully.</p></div>';
        }
    }

    if (isset($_GET['edit_id'])) {
        $edit_id = intval($_GET['edit_id']);
        $product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $edit_id));
    }

    ?>
    <div class="wrap">
        <h1>SmartMail Software Store</h1>
        <form method="post" action="">
            <h2><?php echo isset($product) ? 'Edit Product' : 'Add New Product'; ?></h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Title</th>
                    <td><input type="text" name="title" value="<?php echo isset($product) ? esc_attr($product->title) : ''; ?>" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Description</th>
                    <td><textarea name="description" required><?php echo isset($product) ? esc_textarea($product->description) : ''; ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Price</th>
                    <td><input type="number" step="0.01" name="price" value="<?php echo isset($product) ? esc_attr($product->price) : ''; ?>" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Recommended Retail Price (RRP)</th>
                    <td><input type="number" step="0.01" name="rrp" value="<?php echo isset($product) ? esc_attr($product->rrp) : ''; ?>" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Image URL</th>
                    <td><input type="text" name="image_url" value="<?php echo isset($product) ? esc_url($product->image_url) : ''; ?>" required /></td>
                </tr>
            </table>
            <input type="hidden" name="smartmail_ebook" value="1" />
            <?php if (isset($product)) : ?>
                <input type="hidden" name="id" value="<?php echo esc_attr($product->id); ?>" />
            <?php endif; ?>
            <?php submit_button(isset($product) ? 'Update Product' : 'Add Product'); ?>
        </form>
        <h2>Existing Products</h2>
        <table class="widefat fixed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>RRP</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $wpdb->get_results("SELECT * FROM $table_name");
                foreach ($products as $product) {
                    echo '<tr>';
                    echo '<td>' . esc_html($product->id) . '</td>';
                    echo '<td>' . esc_html($product->title) . '</td>';
                    echo '<td>' . esc_html($product->description) . '</td>';
                    echo '<td>$' . esc_html($product->price) . '</td>';
                    echo '<td>$' . esc_html($product->rrp) . '</td>';
                    echo '<td><img src="' . esc_url($product->image_url) . '" alt="' . esc_html($product->title) . '" style="max-width: 100px;"></td>';
                    echo '<td><a href="?page=smartmail-software-store&edit_id=' . esc_attr($product->id) . '">Edit</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
