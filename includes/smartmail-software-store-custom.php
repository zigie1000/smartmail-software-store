<?php
/*
Plugin Name: SmartMail Software Store Customizations
Description: Custom post types, meta boxes, and export functionality for the SmartMail Software Store.
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
    echo '<div class="error"><p><strong>SmartMail Software Store Customizations:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
}

// Error logging function
function smartmail_log_error(string $message): void {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log($message);
    }
}

// Register Custom Post Type for Software
function smartmail_register_software_post_type(): void {
    try {
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
    } catch (Exception $e) {
        smartmail_log_error("Error registering software post type: " . $e->getMessage());
        add_action('admin_notices', function() {
            echo '<div class="error"><p><strong>SmartMail Software Store Customizations:</strong> An error occurred while registering the software post type.</p></div>';
        });
    }
}
add_action('init', 'smartmail_register_software_post_type');

// Register Custom Post Type for eBooks
function smartmail_register_ebooks_post_type(): void {
    try {
        $labels = array(
            'name'               => _x('eBooks', 'post type general name', 'smartmail'),
            'singular_name'      => _x('eBook', 'post type singular name', 'smartmail'),
            'menu_name'          => _x('eBooks', 'admin menu', 'smartmail'),
            'name_admin_bar'     => _x('eBook', 'add new on admin bar', 'smartmail'),
            'add_new'            => _x('Add New', 'ebook', 'smartmail'),
            'add_new_item'       => __('Add New eBook', 'smartmail'),
            'new_item'           => __('New eBook', 'smartmail'),
            'edit_item'          => __('Edit eBook', 'smartmail'),
            'view_item'          => __('View eBook', 'smartmail'),
            'all_items'          => __('All eBooks', 'smartmail'),
            'search_items'       => __('Search eBooks', 'smartmail'),
            'parent_item_colon'  => __('Parent eBooks:', 'smartmail'),
            'not_found'          => __('No eBooks found.', 'smartmail'),
            'not_found_in_trash' => __('No eBooks found in Trash.', 'smartmail')
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'ebooks'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'custom-fields', 'thumbnail'),
        );

        register_post_type('ebooks', $args);
    } catch (Exception $e) {
        smartmail_log_error("Error registering eBooks post type: " . $e->getMessage());
        add_action('admin_notices', function() {
            echo '<div class="error"><p><strong>SmartMail Software Store Customizations:</strong> An error occurred while registering the eBooks post type.</p></div>';
        });
    }
}
add_action('init', 'smartmail_register_ebooks_post_type');

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
    try {
        wp_nonce_field(basename(__FILE__), 'smartmail_nonce');
        $software_id = get_post_meta($post->ID, '_software_id', true);
        $price = get_post_meta($post->ID, '_price', true);
        $rrp = get_post_meta($post->ID, '_rrp', true);
        $quantity = get_post_meta($post->ID, '_quantity', true);
        $sku = get_post_meta($post->ID, '_sku', true);
        $category = get_post_meta($post->ID, '_category', true);
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
        </table>

        <h2>Custom Fields</h2>
        <?php
        $custom_fields = get_post_custom($post->ID);
        foreach ($custom_fields as $key => $value) {
            if ('_' !== $key[0]) {
                echo '<p>';
                echo '<label for="' . esc_attr($key) . '">' . esc_html($key) . '</label> ';
                echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($value[0]) . '" class="regular-text" />';
                echo '</p>';
            }
        }
    } catch (Exception $e) {
        smartmail_log_error("Error displaying software details meta box: " . $e->getMessage());
    }
}

// Save Meta Boxes for Software
function smartmail_save_software_meta_boxes($post_id): void {
    if (!isset($_POST['smartmail_nonce']) || !wp_verify_nonce($_POST['smartmail_nonce'], basename(__FILE__))) {
        return;
    }

    $fields = [
        'software_id' => '_software_id',
        'price' => '_price',
        'rrp' => '_rrp',
        'quantity' => '_quantity',
        'sku' => '_sku',
        'category' => '_category',
    ];

    foreach ($fields as $key => $field) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$key]));
        }
    }

    // Save custom fields
    $custom_fields = get_post_custom($post_id);
    foreach ($custom_fields as $key => $value) {
        if ('_' !== $key[0] && isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
}
add_action('save_post', 'smartmail_save_software_meta_boxes');

// Add Meta Boxes for eBooks
function smartmail_add_ebooks_meta_boxes(): void {
    add_meta_box(
        'ebook_details',
        'eBook Details',
        'smartmail_ebook_details_callback',
        'ebooks',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'smartmail_add_ebooks_meta_boxes');

function smartmail_ebook_details_callback($post): void {
    try {
        wp_nonce_field(basename(__FILE__), 'smartmail_nonce');
        $ebook_id = get_post_meta($post->ID, '_ebook_id', true);
        $price = get_post_meta($post->ID, '_price', true);
        $author = get_post_meta($post->ID, '_author', true);
        $publisher = get_post_meta($post->ID, '_publisher', true);
        $isbn = get_post_meta($post->ID, '_isbn', true);
        $category = get_post_meta($post->ID, '_category', true);
        ?>

        <table class="form-table">
            <tr>
                <th><label for="ebook_id">eBook ID</label></th>
                <td><input type="text" name="ebook_id" id="ebook_id" value="<?php echo esc_attr($ebook_id); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="price">Price</label></th>
                <td><input type="text" name="price" id="price" value="<?php echo esc_attr($price); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="author">Author</label></th>
                <td><input type="text" name="author" id="author" value="<?php echo esc_attr($author); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="publisher">Publisher</label></th>
                <td><input type="text" name="publisher" id="publisher" value="<?php echo esc_attr($publisher); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="isbn">ISBN</label></th>
                <td><input type="text" name="isbn" id="isbn" value="<?php echo esc_attr($isbn); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="category">Category</label></th>
                <td><input type="text" name="category" id="category" value="<?php echo esc_attr($category); ?>" class="regular-text"></td>
            </tr>
        </table>

        <h2>Custom Fields</h2>
        <?php
        $custom_fields = get_post_custom($post->ID);
        foreach ($custom_fields as $key => $value) {
            if ('_' !== $key[0]) {
                echo '<p>';
                echo '<label for="' . esc_attr($key) . '">' . esc_html($key) . '</label> ';
                echo '<input type="text" name="' . esc_attr($key) . '" value="' . esc_attr($value[0]) . '" class="regular-text" />';
                echo '</p>';
            }
        }
    } catch (Exception $e) {
        smartmail_log_error("Error displaying eBook details meta box: " . $e->getMessage());
    }
}

// Save Meta Boxes for eBooks
function smartmail_save_ebooks_meta_boxes($post_id): void {
    if (!isset($_POST['smartmail_nonce']) || !wp_verify_nonce($_POST['smartmail_nonce'], basename(__FILE__))) {
        return;
    }

    $fields = [
        'ebook_id' => '_ebook_id',
        'price' => '_price',
        'author' => '_author',
        'publisher' => '_publisher',
        'isbn' => '_isbn',
        'category' => '_category',
    ];

    foreach ($fields as $key => $field) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$key]));
        }
    }

    // Save custom fields
    $custom_fields = get_post_custom($post_id);
    foreach ($custom_fields as $key => $value) {
        if ('_' !== $key[0] && isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
}
add_action('save_post', 'smartmail_save_ebooks_meta_boxes');

// Add admin settings menu
function smartmail_add_admin_menu(): void {
    add_menu_page(
        'SmartMail Settings',
        'SmartMail Settings',
        'manage_options',
        'smartmail-settings',
        'smartmail_settings_page',
        'dashicons-admin-generic',
        80
    );
}
add_action('admin_menu', 'smartmail_add_admin_menu');

function smartmail_settings_page(): void {
    ?>
    <div class="wrap">
        <h1>SmartMail Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_settings_group');
            do_settings_sections('smartmail-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function smartmail_register_settings(): void {
    register_setting('smartmail_settings_group', 'smartmail_setting_1');
    register_setting('smartmail_settings_group', 'smartmail_setting_2');

    add_settings_section(
        'smartmail_settings_section',
        'General Settings',
        null,
        'smartmail-settings'
    );

    add_settings_field(
        'smartmail_setting_1',
        'Setting 1',
        'smartmail_setting_1_callback',
        'smartmail-settings',
        'smartmail_settings_section'
    );

    add_settings_field(
        'smartmail_setting_2',
        'Setting 2',
        'smartmail_setting_2_callback',
        'smartmail-settings',
        'smartmail_settings_section'
    );
}
add_action('admin_init', 'smartmail_register_settings');

function smartmail_setting_1_callback(): void {
    $setting = esc_attr(get_option('smartmail_setting_1'));
    echo "<input type='text' name='smartmail_setting_1' value='$setting' class='regular-text'>";
}

function smartmail_setting_2_callback(): void {
    $setting = esc_attr(get_option('smartmail_setting_2'));
    echo "<input type='text' name='smartmail_setting_2' value='$setting' class='regular-text'>";
}
?>
        
