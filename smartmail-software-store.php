<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell software.
 * Version: 1.5
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
            sku varchar(50) DEFAULT '',
            barcode varchar(50) DEFAULT '',
            quantity int DEFAULT 0,
            wc_product_id bigint(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $subscription_table_name = $wpdb->prefix . 'smartmail_subscriptions';
        $sql = "CREATE TABLE $subscription_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            full_name tinytext NOT NULL,
            email varchar(100) NOT NULL,
            phone varchar(20) DEFAULT '',
            address text DEFAULT '',
            newsletter boolean DEFAULT false,
            PRIMARY KEY  (id)
        ) $charset_collate;";
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

        $subscription_page_title = 'SmartMail Subscription';
        $subscription_page_content = '[smartmail_subscription_form]';
        $subscription_page = array(
            'post_title'    => $subscription_page_title,
            'post_content'  => $subscription_page_content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        if (!get_page_by_title($subscription_page_title)) {
            wp_insert_post($subscription_page);
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
            echo '<p class="software-store-item-sku">SKU: ' . esc_html($ebook->sku) . '</p>';
            echo '<p class="software-store-item-barcode">Barcode: ' . esc_html($ebook->barcode) . '</p>';
            echo '<p class="software-store-item-quantity">In Stock: ' . esc_html($ebook->quantity) . '</p>';
            echo '<form action="' . esc_url(wc_get_cart_url()) . '" method="post" class="subscribe-form">';
            echo '<div class="subscribe-fields">';
            echo '<label for="full_name">Full Name<span class="required">*</span></label>';
            echo '<input type="text" name="full_name" required>';
            echo '<label for="email">Email<span class="required">*</span></label>';
            echo '<input type="email" name="email" required>';
            echo '<label for="phone">Phone Number</label>';
            echo '<input type="tel" name="phone">';
            echo '<label for="address">Address</label>';
            echo '<textarea name="address"></textarea>';
            echo '<label for="newsletter">Subscribe to Newsletter</label>';
            echo '<input type="checkbox" name="newsletter">';
            echo '</div>';
            echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($ebook->wc_product_id) . '">';
            echo '<button type="submit" class="button">Add to Cart</button>';
            echo '</form>';
            echo '<a href="' . get_permalink(get_page_by_title('SmartMail Subscription')) . '" class="subscribe-link">Subscribe to our newsletter</a>';
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    }
    add_shortcode('smartmail_ebooks_display', 'smartmail_display_ebooks');

    // Shortcode to display subscription form
    function smartmail_display_subscription_form() {
        ob_start();
        ?>
        <div class="smartmail-subscription-form">
            <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                <h2>Subscribe to our newsletter</h2>
                <p>
                    <label for="full_name">Full Name<span class="required">*</span></label>
                    <input type="text" name="full_name" required>
                </p>
                <p>
                    <label for="email">Email<span class="required">*</span></label>
                    <input type="email" name="email" required>
                </p>
                <p>
                    <label for="phone">Phone Number</label>
                    <input type="tel" name="phone">
                </p>
                <p>
                    <label for="address">Address</label>
                    <textarea name="address

"></textarea>
                </p>
                <p>
                    <label for="newsletter">Subscribe to Newsletter</label>
                    <input type="checkbox" name="newsletter">
                </p>
                <p>
                    <input type="submit" name="smartmail_subscribe" value="Subscribe" class="button">
                </p>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode('smartmail_subscription_form', 'smartmail_display_subscription_form');

    // Handle subscription form submission
    function smartmail_handle_subscription() {
        if (isset($_POST['smartmail_subscribe'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_subscriptions';
            $data = array(
                'full_name' => sanitize_text_field($_POST['full_name']),
                'email' => sanitize_email($_POST['email']),
                'phone' => sanitize_text_field($_POST['phone']),
                'address' => sanitize_textarea_field($_POST['address']),
                'newsletter' => isset($_POST['newsletter']) ? 1 : 0,
            );
            $wpdb->insert($table_name, $data);
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
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('smartmail-settings-group');
                do_settings_sections('smartmail-software-store');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    // Register settings
    function smartmail_register_settings() {
        register_setting('smartmail-settings-group', 'smartmail_settings');
        add_settings_section('smartmail-settings-section', 'Settings', null, 'smartmail-software-store');
        add_settings_field('smartmail-setting-field', 'Setting', 'smartmail_setting_field_callback', 'smartmail-software-store', 'smartmail-settings-section');
    }
    add_action('admin_init', 'smartmail_register_settings');

    function smartmail_setting_field_callback() {
        $options = get_option('smartmail_settings');
        ?>
        <input type="text" name="smartmail_settings[setting]" value="<?php echo esc_attr($options['setting']); ?>">
        <?php
    }

    // Add ebook product
    function smartmail_add_ebook($title, $description, $price, $rrp, $image_url, $sku, $barcode, $quantity, $file_url) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_ebooks';
        $wc_product_id = smartmail_create_or_update_wc_product(compact('title', 'description', 'price', 'rrp', 'image_url', 'sku', 'barcode', 'quantity', 'file_url'));
        $wpdb->insert($table_name, array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'rrp' => $rrp,
            'image_url' => $image_url,
            'sku' => $sku,
            'barcode' => $barcode,
            'quantity' => $quantity,
            'wc_product_id' => $wc_product_id
        ));
    }

    // Admin page content for managing ebooks
    function smartmail_admin_page_content() {
        ?>
        <div class="wrap">
            <h1>Manage Ebooks</h1>
            <form method="post" action="">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Title</th>
                        <td><input type="text" name="title" required></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Description</th>
                        <td><textarea name="description" required></textarea></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Price</th>
                        <td><input type="number" name="price" step="0.01" required></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">RRP</th>
                        <td><input type="number" name="rrp" step="0.01" required></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Image URL</th>
                        <td><input type="url" name="image_url" required></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">SKU</th>
                        <td><input type="text" name="sku"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Barcode</th>
                        <td><input type="text" name="barcode"></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Quantity</th>
                        <td><input type="number" name="quantity" required></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">File URL</th>
                        <td><input type="url" name="file_url" required></td>
                    </tr>
                </table>
                <input type="submit" name="add_ebook" value="Add Ebook" class="button button-primary">
            </form>
        </div>
        <?php
    }

    // Handle admin page form submission
    function smartmail_handle_admin_page_form() {
        if (isset($_POST['add_ebook'])) {
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $price = floatval($_POST['price']);
            $rrp = floatval($_POST['rrp']);
            $image_url = esc_url_raw($_POST['image_url']);
            $sku = sanitize_text_field($_POST['sku']);
            $barcode = sanitize_text_field($_POST['barcode']);
            $quantity = intval($_POST['quantity']);
            $file_url = esc_url_raw($_POST['file_url']);
            smartmail_add_ebook($title, $description, $price, $rrp, $image_url, $sku, $barcode, $quantity, $file_url);
        }
    }
    add_action('admin_post_add_ebook', 'smartmail_handle_admin_page_form');
}
?>
