<?php
/**
 * Plugin Name: SmartMail Software Store
 * Description: A WordPress plugin to manage and sell eBooks and software.
 * Version: 1.5
 * Author: Marco Zagato
 * Author URI: https://smartmail.store
 */

function smartmail_store_enqueue_scripts() {
    wp_enqueue_style('smartmail-store-style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('smartmail-store-script', plugins_url('/js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'smartmail_store_enqueue_scripts');

// Add this to the top of your file or wherever you want to place the button
function display_subscription_button() {
    ?>
    <button id="subscribeButton" class="subscribe-button">Subscribe for Offers</button>

    <div id="subscribeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Subscribe to Our Newsletter</h2>
            <form action="" method="post" id="subscriptionForm">
                <label for="full_name">Full Name*</label>
                <input type="text" id="full_name" name="full_name" required>

                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>

                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number">

                <label for="address">Address</label>
                <input type="text" id="address" name="address">

                <label for="newsletter_optin">Subscribe to Newsletter</label>
                <input type="checkbox" id="newsletter_optin" name="newsletter_optin">

                <input type="submit" value="Subscribe">
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'display_subscription_button');

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    // Create custom database tables on plugin activation
    function smartmail_create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // eBooks table
        $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
        $sql = "CREATE TABLE $ebooks_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title tinytext NOT NULL,
            description text NOT NULL,
            price float NOT NULL,
            rrp float NOT NULL,
            image_url varchar(255) NOT NULL,
            sku varchar(50) DEFAULT '',
            barcode varchar(50) DEFAULT '',
            quantity int DEFAULT 0,
            file_url varchar(255) NOT NULL,
            wc_product_id bigint(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Software table
        $software_table_name = $wpdb->prefix . 'smartmail_software';
        $sql = "CREATE TABLE $software_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title tinytext NOT NULL,
            description text NOT NULL,
            price float NOT NULL,
            rrp float NOT NULL,
            image_url varchar(255) NOT NULL,
            sku varchar(50) DEFAULT '',
            barcode varchar(50) DEFAULT '',
            quantity int DEFAULT 0,
            file_url varchar(255) NOT NULL,
            wc_product_id bigint(20) NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta($sql);

        // Subscription table
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

        // Create pages for eBooks and software
        $ebook_page_title = 'SmartMail Ebooks';
        $ebook_page_content = '[smartmail_ebooks_display]';
        $ebook_page = array(
            'post_title'    => $ebook_page_title,
            'post_content'  => $ebook_page_content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        if (!get_page_by_title($ebook_page_title)) {
            wp_insert_post($ebook_page);
        }

        $software_page_title = 'SmartMail Software';
        $software_page_content = '[smartmail_software_display]';
        $software_page = array(
            'post_title'    => $software_page_title,
            'post_content'  => $software_page_content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );

        if (!get_page_by_title($software_page_title)) {
            wp_insert_post($software_page);
        }
// Shortcode function to display software and ebooks
function smartmail_display_items() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_items';
    $items = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="software-store-items">';
    foreach ($items as $item) {
        echo '<div class="software-store-item">';
        echo '<h2 class="software-store-item-title">' . esc_html($item->title) . '</h2>';
        echo '<div class="software-store-item-description">';
        echo '<p>' . esc_html($item->description) . '</p>';
        echo '<p>Price: $' . esc_html($item->price) . '</p>';
        echo '<p>RRP: $' . esc_html($item->rrp) . '</p>';
        echo '<p>SKU: ' . esc_html($item->sku) . '</p>';
        echo '<p>Barcode: ' . esc_html($item->barcode) . '</p>';
        echo '<p>In Stock: ' . esc_html($item->stock) . '</p>';
        echo '<form method="post" action="' . esc_url(home_url('/')) . '?add-to-cart=' . $item->id . '">';
        echo '<input type="hidden" name="item_id" value="' . $item->id . '">';
        echo '<button type="submit">Add to Cart</button>';
        echo '</form>';
        echo '</div>'; // .software-store-item-description
        echo '</div>'; // .software-store-item
    }
    echo '</div>'; // .software-store-items
    echo '<div class="subscribe-button"><button id="subscribe-button">Subscribe for offers and news</button></div>';
    echo '<div id="subscribe-form" style="display:none;">
            <form method="post" action="">
                <label for="full-name">Full Name*</label>
                <input type="text" id="full-name" name="full_name" required>
                <label for="email">Email*</label>
                <input type="email" id="email" name="email" required>
                <label for="phone-number">Phone Number</label>
                <input type="text" id="phone-number" name="phone_number">
                <label for="address">Address</label>
                <input type="text" id="address" name="address">
                <label for="newsletter">Subscribe to Newsletter</label>
                <input type="checkbox" id="newsletter" name="newsletter">
                <button type="submit">Subscribe</button>
            </form>
          </div>';
    return ob_get_clean();
}
add_shortcode('smartmail_display_items', 'smartmail_display_items');
   
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
// JavaScript to handle subscribe button click
function smartmail_store_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#subscribe-button').click(function() {
                $('#subscribe-form').toggle();
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'smartmail_store_script');
    
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

    // Shortcode to display eBooks
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
            echo '<a href="' . get_permalink(get_page_by_title('SmartMail Subscription')) . '" class="subscribe-link">Subscribe to our newsletter</a>';
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    }
    add_shortcode('smartmail_ebooks_display', 'smartmail_display_ebooks');

    // Shortcode to display software
    function smartmail_display_software() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_software';
        $software = $wpdb->get_results("SELECT * FROM $table_name");

        ob_start();
        echo '<div class="smartmail-software">';
        foreach ($software as $item) {
            echo '<div class="software-store-item">';
            if (!empty($item->image_url)) {
                echo '<img class="software-store-item-image" src="' . esc_url($item->image_url) . '" alt="' . esc_html($item->title) . '">';
            }
            echo '<h2 class="software-store-item-title">' . esc_html($item->title) . '</h2>';
            echo '<div class="software-store-item-description">' . esc_html($item->description) . '</div>';
            echo '<p class="software-store-item-price">Price: $' . esc_html($item->price) . '</p>';
            echo '<p class="software-store-item-rrp">RRP: $' . esc_html($item->rrp) . '</p>';
            echo '<p class="software-store-item-sku">SKU: ' . esc_html($item->sku) . '</p>';
            echo '<p class="software-store-item-barcode">Barcode: ' . esc_html($item->barcode) . '</p>';
            echo '<p class="software-store-item-quantity">In Stock: ' . esc_html($item->quantity) . '</p>';
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
            echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($item->wc_product_id) . '">';
            echo '<button type="submit" class="button">Add to Cart</button>';
            echo '</form>';
            echo '<a href="' . get_permalink(get_page_by_title('SmartMail Subscription')) . '" class="subscribe-link">Subscribe to our newsletter</a>';
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    }
    add_shortcode('smartmail_software_display', 'smartmail_display_software');

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
                    <textarea name="address"></textarea>
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

// Handle form submission for adding eBooks and Software
function smartmail_store_handle_form() {
    if (!isset($_POST['smartmail_form_nonce']) || !wp_verify_nonce($_POST['smartmail_form_nonce'], 'smartmail_form_action')) {
        return;
    }

    global $wpdb;

    if (isset($_POST['add_ebook'])) {
        $table_name = $wpdb->prefix . 'smartmail_ebooks';
        $wpdb->insert($table_name, array(
            'title' => sanitize_text_field($_POST['title']),
            'description' => sanitize_textarea_field($_POST['description']),
            'price' => floatval($_POST['price']),
            'rrp' => floatval($_POST['rrp']),
            'sku' => sanitize_text_field($_POST['sku']),
            'barcode' => sanitize_text_field($_POST['barcode']),
            'quantity' => intval($_POST['quantity']),
            'image_url' => esc_url_raw($_POST['image_url'])
        ));
    }

    if (isset($_POST['add_software'])) {
        $table_name = $wpdb->prefix . 'smartmail_software';
        $wpdb->insert($table_name, array(
            'title' => sanitize_text_field($_POST['title']),
            'description' => sanitize_textarea_field($_POST['description']),
            'price' => floatval($_POST['price']),
            'rrp' => floatval($_POST['rrp']),
            'sku' => sanitize_text_field($_POST['sku']),
            'barcode' => sanitize_text_field($_POST['barcode']),
            'quantity' => intval($_POST['quantity']),
            'image_url' => esc_url_raw($_POST['image_url'])
        ));
    }
}
add_action('admin_post_nopriv_smartmail_store_handle_form', 'smartmail_store_handle_form');
add_action('admin_post_smartmail_store_handle_form', 'smartmail_store_handle_form');
    
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
        add_submenu_page(
            'smartmail-software-store',
            'Manage eBooks',
            'Manage eBooks',
            'manage_options',
            'smartmail-manage-ebooks',
            'smartmail_manage_ebooks_page'
        );
        add_submenu_page(
            'smartmail-software-store',
            'Manage Software',
            'Manage Software',
            'manage_options',
            'smartmail-manage-software',
            'smartmail_manage_software_page'
        );
    }
    add_action('admin_menu', 'smartmail_register_admin_menu');

    // Admin page callback
    function smartmail_admin_page() {
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store</h1>
            <p>Welcome to the SmartMail Software Store. Use the submenus to manage eBooks and software products.</p>
        </div>
        <?php
    }

    // Manage eBooks page callback
    function smartmail_manage_ebooks_page() {
        ?>
        <div class="wrap">
            <h1>Manage eBooks</h1>
            <form method="post" action="admin-post.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_ebook">
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
                        <th scope="row">Image</th>
                        <td><input type="file" name="image" required></td>
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
                        <th scope="row">File</th>
                        <td><input type="file" name="file" required></td>
                    </tr>
                </table>
                <input type="submit" name="add_ebook" value="Add eBook" class="button button-primary">
            </form>
            <h2>Existing eBooks</h2>
            <?php smartmail_admin_page_content('ebook'); ?>
        </div>
        <?php
    }

    // Manage software page callback
    function smartmail_manage_software_page() {
        ?>
        <div class="wrap">
            <h1>Manage Software</h1>
            <form method="post" action="admin-post.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_software">
                <table class="form-table">
                    <tr valign="top">
                        <th scope

="row">Title</th>
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
                        <th scope="row">Image</th>
                        <td><input type="file" name="image" required></td>
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
                        <th scope="row">File</th>
                        <td><input type="file" name="file" required></td>
                    </tr>
                </table>
                <input type="submit" name="add_software" value="Add Software" class="button button-primary">
            </form>
            <h2>Existing Software</h2>
            <?php smartmail_admin_page_content('software'); ?>
        </div>
        <?php
    }

    // Admin page content for managing eBooks and software
    function smartmail_admin_page_content($type) {
        global $wpdb;
        $table_name = $type === 'ebook' ? $wpdb->prefix . 'smartmail_ebooks' : $wpdb->prefix . 'smartmail_software';
        $items = $wpdb->get_results("SELECT * FROM $table_name");
        ?>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>RRP</th>
                    <th>SKU</th>
                    <th>Barcode</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->title; ?></td>
                        <td><?php echo $item->description; ?></td>
                        <td><?php echo $item->price; ?></td>
                        <td><?php echo $item->rrp; ?></td>
                        <td><?php echo $item->sku; ?></td>
                        <td><?php echo $item->barcode; ?></td>
                        <td><?php echo $item->quantity; ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=smartmail-software-store&edit_' . $type . '=' . $item->id); ?>">Edit</a> |
                            <a href="<?php echo admin_url('admin-post.php?action=delete_' . $type . '&id=' . $item->id); ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    // Handle adding eBook
    function smartmail_handle_add_ebook() {
        if (isset($_POST['add_ebook'])) {
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $price = floatval($_POST['price']);
            $rrp = floatval($_POST['rrp']);
            if ($rrp < $price) {
                wp_die('RRP cannot be less than the price.');
            }
            $image = smartmail_handle_file_upload($_FILES['image']);
            $sku = sanitize_text_field($_POST['sku']);
            $barcode = sanitize_text_field($_POST['barcode']);
            $quantity = intval($_POST['quantity']);
            $file_url = smartmail_handle_file_upload($_FILES['file']);
            smartmail_add_ebook($title, $description, $price, $rrp, $image, $sku, $barcode, $quantity, $file_url);
            wp_redirect(admin_url('admin.php?page=smartmail-manage-ebooks'));
            exit;
        }
    }
    add_action('admin_post_add_ebook', 'smartmail_handle_add_ebook');

    // Handle adding software
    function smartmail_handle_add_software() {
        if (isset($_POST['add_software'])) {
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $price = floatval($_POST['price']);
            $rrp = floatval($_POST['rrp']);
            if ($rrp < $price) {
                wp_die('RRP cannot be less than the price.');
            }
            $image = smartmail_handle_file_upload($_FILES['image']);
            $sku = sanitize_text_field($_POST['sku']);
            $barcode = sanitize_text_field($_POST['barcode']);
            $quantity = intval($_POST['quantity']);
            $file_url = smartmail_handle_file_upload($_FILES['file']);
            smartmail_add_software($title, $description, $price, $rrp, $image, $sku, $barcode, $quantity, $file_url);
            wp_redirect(admin_url('admin.php?page=smartmail-manage-software'));
            exit;
        }
    }
    add_action('admin_post_add_software', 'smartmail_handle_add_software');

    // Add eBook product
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
            'file_url' => $file_url,
            'wc_product_id' => $wc_product_id
        ));
    }

    // Add software product
    function smartmail_add_software($title, $description, $price, $rrp, $image_url, $sku, $barcode, $quantity, $file_url) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_software';
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
            'file_url' => $file_url,
            'wc_product_id' => $wc_product_id
        ));
    }

    // Handle eBook deletion
    function smartmail_delete_ebook() {
        if (isset($_GET['action']) && $_GET['action'] == 'delete_ebook' && isset($_GET['id'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_ebooks';
            $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
            wp_redirect(admin_url('admin.php?page=smartmail-manage-ebooks'));
            exit;
        }
    }
    add_action('admin_post_delete_ebook', 'smartmail_delete_ebook');

    // Handle software deletion
    function smartmail_delete_software() {
        if (isset($_GET['action']) && $_GET['action'] == 'delete_software' && isset($_GET['id'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_software';
            $wpdb->delete($table_name, array('id' => intval($_GET['id'])));
            wp_redirect(admin_url('admin.php?page=smartmail-manage-software'));
            exit;
        }
    }
    add_action('admin_post_delete_software', 'smartmail_delete_software');

    // Handle eBook editing
    function smartmail_edit_ebook() {
        if (isset($_GET

['page']) && $_GET['page'] == 'smartmail-software-store' && isset($_GET['edit_ebook'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_ebooks';
            $ebook = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['edit_ebook'])));
            if ($ebook) {
                ?>
                <div class="wrap">
                    <h1>Edit eBook</h1>
                    <form method="post" action="<?php echo admin_url('admin-post.php?action=update_ebook'); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $ebook->id; ?>">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">Title</th>
                                <td><input type="text" name="title" value="<?php echo esc_attr($ebook->title); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Description</th>
                                <td><textarea name="description" required><?php echo esc_textarea($ebook->description); ?></textarea></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Price</th>
                                <td><input type="number" name="price" step="0.01" value="<?php echo esc_attr($ebook->price); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">RRP</th>
                                <td><input type="number" name="rrp" step="0.01" value="<?php echo esc_attr($ebook->rrp); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Image</th>
                                <td><input type="file" name="image"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">SKU</th>
                                <td><input type="text" name="sku" value="<?php echo esc_attr($ebook->sku); ?>"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Barcode</th>
                                <td><input type="text" name="barcode" value="<?php echo esc_attr($ebook->barcode); ?>"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Quantity</th>
                                <td><input type="number" name="quantity" value="<?php echo esc_attr($ebook->quantity); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">File</th>
                                <td><input type="file" name="file"></td>
                            </tr>
                        </table>
                        <input type="submit" name="update_ebook" value="Update eBook" class="button button-primary">
                    </form>
                </div>
                <?php
            }
        }
    }
    add_action('admin_init', 'smartmail_edit_ebook');

    // Handle software editing
    function smartmail_edit_software() {
        if (isset($_GET['page']) && $_GET['page'] == 'smartmail-software-store' && isset($_GET['edit_software'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_software';
            $software = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['edit_software'])));
            if ($software) {
                ?>
                <div class="wrap">
                    <h1>Edit Software</h1>
                    <form method="post" action="<?php echo admin_url('admin-post.php?action=update_software'); ?>" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $software->id; ?>">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">Title</th>
                                <td><input type="text" name="title" value="<?php echo esc_attr($software->title); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Description</th>
                                <td><textarea name="description" required><?php echo esc_textarea($software->description); ?></textarea></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Price</th>
                                <td><input type="number" name="price" step="0.01" value="<?php echo esc_attr($software->price); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">RRP</th>
                                <td><input type="number" name="rrp" step="0.01" value="<?php echo esc_attr($software->rrp); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Image</th>
                                <td><input type="file" name="image"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">SKU</th>
                                <td><input type="text" name="sku" value="<?php echo esc_attr($software->sku); ?>"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Barcode</th>
                                <td><input type="text" name="barcode" value="<?php echo esc_attr($software->barcode); ?>"></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">Quantity</th>
                                <td><input type="number" name="quantity" value="<?php echo esc_attr($software->quantity); ?>" required></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row">File</th>
                                <td><input type="file" name="file"></td>
                            </tr>
                        </table>
                        <input type="submit" name="update_software" value="Update Software" class="button button-primary">
                    </form>
                </div>
                <?php
            }
        }
    }
    add_action('admin_init', 'smartmail_edit_software');

    // Handle eBook update
    function smartmail_update_ebook() {
        if (isset($_POST['update_ebook'])) {
            $id = intval($_POST['id']);
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $price = floatval($_POST['price']);
            $rrp = floatval($_POST['rrp']);
            if ($rrp < $price) {
                wp_die('RRP cannot be less than the price.');
            }
            $image = !empty($_FILES['image']['name']) ? smartmail_handle_file_upload($_FILES['image']) : '';
            $sku = sanitize_text_field($_POST['sku']);
            $barcode = sanitize_text_field($_POST['barcode']);
            $quantity = intval($_POST['quantity']);
            $file_url = !empty($_FILES['file']['name']) ? smartmail_handle_file_upload($_FILES['file']) : '';

            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_ebooks';
            $data = array(
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'rrp' => $rrp,
                'sku' => $sku,
                'barcode' => $barcode,
                'quantity' => $quantity
            );
            if ($image) {
                $data['image_url'] = $image;
            }
            if ($file_url) {
                $data['file_url'] = $file_url;
            }
            $wpdb->update($table_name, $data, array('id' => $id));

            $product_data = array(
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'rrp' => $rrp,
                'image_url' => $image,
                'sku' => $sku,
                'barcode' => $barcode,
                'quantity' => $quantity,
                'file_url' => $file_url
            );
            smartmail_create_or_update_wc_product($product_data, $wpdb->get_var($wpdb->prepare("SELECT wc_product_id FROM $table_name WHERE id = %d", $id)));

            wp_redirect(admin_url('admin.php?page=smartmail-manage-ebooks'));
            exit;
        }
    }
    add_action('admin_post_update_ebook', 'smartmail_update_ebook');

    // Handle software update
    function smartmail_update_software() {
        if (isset($_POST['update_software'])) {
            $id = intval($_POST['id']);
            $title = sanitize_text_field($_POST['title']);
            $description = sanitize_textarea_field($_POST['description']);
            $price = floatval($_POST['price']);
            $rrp = floatval($_POST['rrp']);
            if ($rrp < $price) {
                wp_die('RRP cannot be less than the price.');
            }
            $image = !empty($_FILES['image']['name']) ? smartmail_handle_file_upload($_FILES['image']) : '';
            $sku = sanitize_text_field($_POST['sku']);
            $barcode = sanitize_text_field($_POST['barcode']);
            $quantity = intval($_POST['quantity']);
            $file_url = !empty($_FILES['

file']['name']) ? smartmail_handle_file_upload($_FILES['file']) : '';

            global $wpdb;
            $table_name = $wpdb->prefix . 'smartmail_software';
            $data = array(
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'rrp' => $rrp,
                'sku' => $sku,
                'barcode' => $barcode,
                'quantity' => $quantity
            );
            if ($image) {
                $data['image_url'] = $image;
            }
            if ($file_url) {
                $data['file_url'] = $file_url;
            }
            $wpdb->update($table_name, $data, array('id' => $id));

            $product_data = array(
                'title' => $title,
                'description' => $description,
                'price' => $price,
                'rrp' => $rrp,
                'image_url' => $image,
                'sku' => $sku,
                'barcode' => $barcode,
                'quantity' => $quantity,
                'file_url' => $file_url
            );
            smartmail_create_or_update_wc_product($product_data, $wpdb->get_var($wpdb->prepare("SELECT wc_product_id FROM $table_name WHERE id = %d", $id)));

            wp_redirect(admin_url('admin.php?page=smartmail-manage-software'));
            exit;
        }
    }
    add_action('admin_post_update_software', 'smartmail_update_software');
}
?>
