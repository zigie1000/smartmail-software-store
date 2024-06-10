<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Function to create the ebooks table
function smartmail_create_ebooks_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // Table doesn't exist, create it
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text NOT NULL,
            price varchar(255) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Hook to create the table on plugin activation
register_activation_hook(__FILE__, 'smartmail_create_ebooks_table');

// Shortcode for displaying ebook items
function smartmail_ebooks_display() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $items = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <div class="ebook-store-items">
        <?php foreach ($items as $item) { ?>
            <div class="ebook-store-item">
                <div class="ebook-store-item-title"><?php echo esc_html($item->title); ?></div>
                <div class="ebook-store-item-description"><?php echo esc_html($item->description); ?></div>
                <div class="ebook-store-item-price"><?php echo esc_html($item->price); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('smartmail_ebooks_display', 'smartmail_ebooks_display');
?>
