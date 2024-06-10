<?php
class Smartmail_Software_Store_Public {
    public function __construct() {
        add_shortcode('smartmail_ebooks_display', array($this, 'display_ebooks'));
        add_shortcode('smartmail_software_display', array($this, 'display_software'));
    }

    public function display_ebooks() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_ebooks';
        $ebooks = $wpdb->get_results("SELECT * FROM $table_name");

        ob_start();
        echo '<div class="smartmail-ebooks">';
        foreach ($ebooks as $ebook) {
            echo '<div class="ebook">';
            echo '<h2>' . esc_html($ebook->title) . '</h2>';
            echo '<p>' . esc_html($ebook->description) . '</p>';
            echo '<p>Price: $' . esc_html($ebook->price) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    }

    public function display_software() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_software';
        $software = $wpdb->get_results("SELECT * FROM $table_name");

        ob_start();
        echo '<div class="smartmail-software">';
        foreach ($software as $item) {
            echo '<div class="software-item">';
            echo '<h2>' . esc_html($item->title) . '</h2>';
            echo '<p>' . esc_html($item->description) . '</p>';
            echo '<p>Price: $' . esc_html($item->price) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    }
}

new Smartmail_Software_Store_Public();
