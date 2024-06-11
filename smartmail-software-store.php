// Handle subscription form submission
function smartmail_handle_subscription() {
    if (isset($_POST['smartmail_subscribe'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_subscriptions';

        $full_name = sanitize_text_field($_POST['full_name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $address = sanitize_textarea_field($_POST['address']);
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;

        $wpdb->insert(
            $table_name,
            array(
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'newsletter' => $newsletter
            )
        );
    }
}
add_action('init', 'smartmail_handle_subscription');

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
        $sku = sanitize_text_field($_POST['sku']);
        $barcode = sanitize_text_field($_POST['barcode']);
        $quantity = intval($_POST['quantity']);
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
            'file_url' => $file_url,
            'sku' => $sku,
            'barcode' => $barcode,
            'quantity' => $quantity
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
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'quantity' => $quantity,
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
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'quantity' => $quantity,
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
                <tr valign="top">
                    <th scope="row">File</th>
                    <td><input type="file" name="file" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">SKU</th>
                    <td><input type="text" name="sku" value="<?php echo isset($product) ? esc_attr($product->sku) : ''; ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Barcode</th>
                    <td><input type="text" name="barcode" value="<?php echo isset($product) ? esc_attr($product->barcode) : ''; ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Quantity</th>
                    <td><input type="number" name="quantity" value="<?php echo isset($product) ? esc_attr($product->quantity) : ''; ?>" /></td>
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
                    <th>SKU</th>
                    <th>Barcode</th>
                    <th>Quantity</th>
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
echo ‘’;
} else {
echo ‘No image’;
}
echo ‘’ . esc_html($product->sku) . ‘’;
echo ‘’ . esc_html($product->barcode) . ‘’;
echo ‘’ . esc_html($product->quantity) . ‘’;
echo ‘Edit’;
echo ‘’;
}
?>
             
