<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SmartMail_Software_Store_Public {
    public function __construct() {
        add_shortcode('smartmail_software_store_items', array($this, 'display_items'));
    }

    public function display_items() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_software_store';
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
}

new SmartMail_Software_Store_Public();
