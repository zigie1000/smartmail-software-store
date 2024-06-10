<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Shortcode for displaying software items
function smartmail_software_store_display_software() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_software_store_software';
    $items = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    ?>
    <div class="software-store-items">
        <?php foreach ($items as $item) { ?>
            <div class="software-store-item">
                <div class="software-store-item-title"><?php echo esc_html($item->name); ?></div>
                <div class="software-store-item-description"><?php echo esc_html($item->description); ?></div>
                <div class="software-store-item-price"><?php echo esc_html($item->price); ?></div>
            </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('smartmail_software_store_software', 'smartmail_software_store_display_software');
