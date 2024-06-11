<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.3
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

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
            wc_product_id bigint(20) NOT NULL,
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

    // Create or update WooCommerce product
    function smartmail_create_or_update_wc_product($product_data, $wc_product_id = 0) {
        $product = new WC_Product_Downloadable($wc_product_id);

        $product->set_name($product_data['title']);
        $product->set_description($product_data['description']);
        $product->set_regular_price($product_data['price']);
        $product->set_catalog_visibility('visible');
        $product->set_image_id(smartmail_get_image_id($product_data['image_url']));
        $product->set_status('publish');
        $product->set_downloadable(true);

        if (!empty($product_data['file_url'])) {
            $product->set_downloads(array(
                array(
                    'name' => $product_data['title'],
                    'file' => $product_data['file_url']
                )
            ));
        }

        if ($wc_product_id == 0) {
            $wc_product_id = $product->save();
        } else {
            $product->save();
        }

        return $wc_product_id;
    }

    // Get image ID from URL
    function smartmail_get_image_id($image_url) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
        return $attachment[0];
    }

    // Handle file upload
    function smartmail_handle_file_upload($file) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded_file = wp_handle_upload($file, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename($file_loc);
            $file_type = wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => sanitize_file_name($file_name),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file_loc);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            return wp_get_attachment_url($attach_id);
        }

        return false;
    }

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
            echo '<form action="' . esc_url(wc_get_cart_url()) . '" method="post">';
            echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($ebook->wc_product_id) . '">';
            echo '<button type="submit" class="button">Add to Cart</button>';
            echo '</form>';
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
            $wc_product_id = isset($_POST['wc_product_id']) ? intval($_POST['wc_product_id']) : 0;

            $file_url = '';
            if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $file_url = smartmail_handle_file_upload($_FILES['file']);
            }

            $product_data = array(
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'image_url' => $image_url,
                'file_url' => $file_url
            );

            $wc_product_id = smartmail_create_or_update_wc_product($product_data, $wc_product_id);

            if (isset($_POST['id']) && $_POST['id'] != '') {
                $wpdb->update(
                    $table_name,
                    array(
                        'title' => $title,
                        'description' => $description,
                        'price' => $price,
                        'rrp' => $rrp,
                        'image_url' => $image_url,
                        'wc_product_id' => $wc_product_id
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
                        'image_url' => $image_url,
                        'wc_product_id' => $wc_product_id
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
            <form method="post" action="" enctype="multipart/form-data">
                <h2><?php echo isset($product) ? 'Edit Product' : 'Add New Product'; ?></h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Title</th>
                        <td><input type="text

" name="title" value="<?php echo isset($product) ? esc_attr($product->title) : ''; ?>" required /></td>
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
                    <tr valign="top">
                        <th scope="row">File</th>
                        <td><input type="file" name="file" /></td>
                    </tr>
                    <?php if (isset($product)) : ?>
                        <input type="hidden" name="wc_product_id" value="<?php echo esc_attr($product->wc_product_id); ?>" />
                    <?php endif; ?>
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
                        if (!empty($product->image_url)) {
                            echo '<td><img src="' . esc_url($product->image_url) . '" width="50" /></td>';
                        } else {
                            echo '<td>No image</td>';
                        }
                        echo '<td><a href="?page=smartmail-software-store&edit_id=' . esc_attr($product->id) . '" class="button">Edit</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
?>
