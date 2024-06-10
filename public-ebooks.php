
<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Shortcode for displaying ebook items
function smartmail_software_store_display_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_software_store_ebooks';
    $items = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <div class="ebook-store-items">
        <?php foreach ($items as $item) { ?>
            <div class="ebook-store-item">
                <div class="ebook-store-item-title"><?php echo esc_html($item->name); ?></div>
                <div class="ebook-store-item-description"><?php echo esc_html($item->description); ?></div>
                <div class="ebook-store-item-price"><?php echo esc_html($item->price); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('smartmail_software_store_ebooks', 'smartmail_software_store_display_ebooks');
