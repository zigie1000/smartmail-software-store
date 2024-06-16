<?php

// Admin menu for managing products
function smartmail_register_admin_menu() {
    add_menu_page(
        'SmartMail Software Store',
        'SmartMail Store',
        'manage_options',
        'smartmail-software-store',
        'smartmail_admin_page',
        'dashicons-admin-generic',
        6
    );
}
add_action('admin_menu', 'smartmail_register_admin_menu');

// Admin page content
function smartmail_admin_page() {
    global $wpdb;
    $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
    $software_table_name = $wpdb->prefix . 'smartmail_software';

    $ebooks = $wpdb->get_results("SELECT * FROM $ebooks_table_name");
    $software = $wpdb->get_results("SELECT * FROM $software_table_name");

    echo '<div class="wrap">';
    echo '<h1>SmartMail Software Store</h1>';

    // Display form for adding a new product
    echo '<h2>Add New Product</h2>';
    echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post" enctype="multipart/form-data">';
    echo '<input type="hidden" name="action" value="add_product">';
    echo '<label for="product_type">Product Type:</label>';
    echo '<select name="product_type" id="product_type">';
    echo '<option value="ebook">eBook</option>';
    echo '<option value="software">Software</option>';
    echo '</select><br>';
    echo '<label for="title">Title:</label>';
    echo '<input type="text" name="title" id="title" required><br>';
    echo '<label for="description">Description:</label>';
    echo '<textarea name="description" id="description" required></textarea><br>';
    echo '<label for="price">Price:</label>';
    echo '<input type="text" name="price" id="price" required><br>';
    echo '<label for="rrp">RRP:</label>';
    echo '<input type="text" name="rrp" id="rrp" required><br>';
    echo '<label for="image">Image URL:</label>';
    echo '<input type="text" name="image_url" id="image_url"><br>';
    echo '<label for="sku">SKU:</label>';
    echo '<input type="text" name="sku" id="sku"><br>';
    echo '<label for="barcode">Barcode:</label>';
    echo '<input type="text" name="barcode" id="barcode"><br>';
    echo '<label for="quantity">Quantity:</label>';
    echo '<input type="text" name="quantity" id="quantity" required><br>';
    echo '<label for="file">File URL:</label>';
    echo '<input type="text" name="file_url" id="file_url"><br>';
    echo '<input type="submit" value="Add Product">';
    echo '</form>';

    // Display existing products with edit and delete options
    echo '<h2>Existing Products</h2>';

    echo '<h3>eBooks</h3>';
    foreach ($ebooks as $ebook) {
        echo '<div>';
        echo '<h4>' . esc_html($ebook->title) . '</h4>';
        echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';
        echo '<input type="hidden" name="action" value="edit_product">';
        echo '<input type="hidden" name="product_id" value="' . esc_attr($ebook->id) . '">';
        echo '<input type="hidden" name="product_type" value="ebook">';
        echo '<label for="title">Title:</label>';
        echo '<input type="text" name="title" value="' . esc_attr($ebook->title) . '"><br>';
        echo '<label for="description">Description:</label>';
        echo '<textarea name="description">' . esc_textarea($ebook->description) . '</textarea><br>';
        echo '<label for="price">Price:</label>';
        echo '<input type="text" name="price" value="' . esc_attr($ebook->price) . '"><br>';
        echo '<label for="rrp">RRP:</label>';
        echo '<input type="text" name="rrp" value="' . esc_attr($ebook->rrp) . '"><br>';
        echo '<label for="image_url">Image URL:</label>';
        echo '<input type="text" name="image_url" value="' . esc_attr($ebook->image_url) . '"><br>';
        echo '<label for="sku">SKU:</label>';
        echo '<input type="text" name="sku" value="' . esc_attr($ebook->sku) . '"><br>';
        echo '<label for="barcode">Barcode:</label>';
        echo '<input type="text" name="barcode" value="' . esc_attr($ebook->barcode) . '"><br>';
        echo '<label for="quantity">Quantity:</label>';
        echo '<input type="text" name="quantity" value="' . esc_attr($ebook->quantity) . '"><br>';
        echo '<label for="file_url">File URL:</label>';
        echo '<input type="text" name="file_url" value="' . esc_attr($ebook->file_url) . '"><br>';
        echo '<input type="submit" value="Update">';
        echo '</form>';

        echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';
        echo '<input type="hidden" name="action" value="delete_product">';
        echo '<input type="hidden" name="product_id" value="' . esc_attr($ebook->id) . '">';
        echo '<input type="hidden" name="product_type" value="ebook">';
        echo '<input type="submit" value="Delete">';
        echo '</form>';
        echo '</div>';
    }

    echo '<h3>Software</h3>';
    foreach ($software as $item) {
        echo '<div>';
        echo '<h4>' . esc_html($item->title) . '</h4>';
        echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';
        echo '<input type="hidden" name="action" value="edit_product">';
        echo '<input type="hidden" name="product_id" value="' . esc_attr($item->id) . '">';
        echo '<input type="hidden" name="product_type" value="software">';
        echo '<label for="title">Title:</label>';
        echo '<input type="text" name="title" value="' . esc_attr($item->title) . '"><br>';
        echo '<label for="description">Description:</label>';
        echo '<textarea name="description">' . esc_textarea($item->description) . '</textarea><br>';
        echo '<label for="price">Price:</label>';
        echo '<input type="text" name="price" value="' . esc_attr($item->price) . '"><br>';
        echo '<label for="rrp">RRP:</label>';
        echo '<input type="text" name="rrp" value="' . esc_attr($item->rrp) . '"><br>';
        echo '<label for="image_url">Image URL:</label>';
        echo '<input type="text" name="image_url" value="' . esc_attr($item->image_url) . '"><br>';
        echo '<label for="sku">SKU:</label>';
        echo '<input type="text" name="sku" value="' . esc_attr($item->sku) . '"><br>';
        echo '<label for="barcode">Barcode:</label>';
        echo '<input type="text" name="barcode" value="' . esc_attr($item->barcode) . '"><br>';
        echo '<label for="quantity">Quantity:</label>';
        echo '<input type="text" name="quantity" value="' . esc_attr($item->quantity) . '"><br>';
        echo '<label for="file_url">File URL:</label>';
        echo '<input type="text" name="file_url" value="' . esc_attr($item->file_url) . |oai:code-citation|
        echo '<input type="text" name="file_url" value="' . esc_attr($item->file_url) . '"><br>';
        echo '<input type="submit" value="Update">';
        echo '</form>';

        echo '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';
        echo '<input type="hidden" name="action" value="delete_product">';
        echo '<input type="hidden" name="product_id" value="' . esc_attr($item->id) . '">';
        echo '<input type="hidden" name="product_type" value="software">';
        echo '<input type="submit" value="Delete">';
        echo '</form>';
        echo '</div>';
    }

    echo '</div>';
}

// Handle form submissions for adding, editing, and deleting products
function smartmail_handle_form_submission() {
    if (!current_user_can('manage_options')) {
        return;
    }

    global $wpdb;
    $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
    $software_table_name = $wpdb->prefix . 'smartmail_software';

    if (isset($_POST['action']) && $_POST['action'] == 'add_product') {
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $price = floatval($_POST['price']);
        $rrp = floatval($_POST['rrp']);
        $image_url = sanitize_text_field($_POST['image_url']);
        $sku = sanitize_text_field($_POST['sku']);
        $barcode = sanitize_text_field($_POST['barcode']);
        $quantity = intval($_POST['quantity']);
        $file_url = sanitize_text_field($_POST['file_url']);

        $wc_product_id = smartmail_create_or_update_wc_product(array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'image_url' => $image_url,
            'sku' => $sku,
            'quantity' => $quantity,
            'file_url' => $file_url,
            'rrp' => $rrp
        ));

        $wpdb->insert($table_name, array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'rrp' => $rrp,
            'image_url' => $image_url,
            'sku' => $sku,
            'barcode' => $barcode,
            'quantity' => $quantity,
            'file_url' => $file_url,
            'wc_product_id' => $wc_product_id
        ));
    }

    if (isset($_POST['action']) && $_POST['action'] == 'edit_product') {
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $product_id = intval($_POST['product_id']);
        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $price = floatval($_POST['price']);
        $rrp = floatval($_POST['rrp']);
        $image_url = sanitize_text_field($_POST['image_url']);
        $sku = sanitize_text_field($_POST['sku']);
        $barcode = sanitize_text_field($_POST['barcode']);
        $quantity = intval($_POST['quantity']);
        $file_url = sanitize_text_field($_POST['file_url']);

        $product_data = array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'image_url' => $image_url,
            'sku' => $sku,
            'quantity' => $quantity,
            'file_url' => $file_url,
            'rrp' => $rrp
        );

        $product = $wpdb->get_row($wpdb->prepare("SELECT wc_product_id FROM $table_name WHERE id = %d", $product_id));
        smartmail_create_or_update_wc_product($product_data, $product->wc_product_id);

        $wpdb->update($table_name, $product_data, array('id' => $product_id));
    }

    if (isset($_POST['action']) && $_POST['action'] == 'delete_product') {
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $product_id = intval($_POST['product_id']);

        $product = $wpdb->get_row($wpdb->prepare("SELECT wc_product_id FROM $table_name WHERE id = %d", $product_id));
        wp_delete_post($product->wc_product_id, true);

        $wpdb->delete($table_name, array('id' => $product_id));
    }

    wp_redirect(admin_url('admin.php?page=smartmail-software-store'));
    exit;
}
add_action('admin_post_add_product', 'smartmail_handle_form_submission');
add_action('admin_post_edit_product', 'smartmail_handle_form_submission');
add_action('admin_post_delete_product', 'smartmail_handle_form_submission');

// Create or update WooCommerce product
function smartmail_create_or_update_wc_product($product_data, $wc_product_id = 0) {
    $product = new WC_Product_Downloadable($wc_product_id);
    $product->set_name($product_data['title']);
    $product->set_description($product_data['description']);
    $product->set_regular_price($product_data['price']);
    $product->set_catalog_visibility('visible');
    $product->set_image_id(smartmail_get_image_id($product_data['image_url']));
    $product->set_status('publish');
    $product->set_sku($product_data['sku']);
    $product->set_manage_stock(true);
    $product->set_stock_quantity($product_data['quantity']);
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
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}
?>
