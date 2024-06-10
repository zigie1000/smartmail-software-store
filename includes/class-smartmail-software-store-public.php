<?php

class SmartMail_Software_Store_Public {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), $this->version, false);
    }

    public function display_ebooks() {
        ob_start();
        global $wpdb;
        $table_name = $wpdb->prefix . 'smartmail_ebooks';
        $results = $wpdb->get_results("SELECT * FROM $table_name");

        if ($results) {
            echo '<ul>';
            foreach ($results as $row) {
                echo '<li>';
                echo '<h2>' . esc_html($row->title) . '</h2>';
                echo '<p>' . esc_html($row->description) . '</p>';
                echo '<p>Price: ' . esc_html($row->price) . '</p>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No ebooks found.</p>';
        }

        return ob_get_clean();
    }
}

function register_shortcodes() {
    add_shortcode('smartmail_ebooks_display', array(new SmartMail_Software_Store_Public('smartmail-software-store', '1.0.0'), 'display_ebooks'));
}
add_action('init', 'register_shortcodes');
?>
