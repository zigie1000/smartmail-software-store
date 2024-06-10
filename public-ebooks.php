<?php
// Add this to ensure the table is created upon plugin activation
function smartmail_create_ebooks_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        price float NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'smartmail_create_ebooks_table');

function smartmail_display_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $ebooks = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="smartmail-ebooks">';
    foreach ($ebooks as $ebook) {
        echo '<div class="ebook">';
        echo '<h2>' . esc_html($ebook->title) . '</h2>';
        echo '<p>' . esc_html($ebook->description) . '</p>';
        echo '<p>Price: ' . esc_html($ebook->price) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('smartmail_ebooks_display', 'smartmail_display_ebooks');
