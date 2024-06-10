<?php

class Smartmail_Software_Store_Public {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smartmail-software-store-public.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smartmail-software-store-public.js', array( 'jquery' ), $this->version, false );
    }

    public function add_shortcode() {
        add_shortcode('smartmail_ebooks_display', array($this, 'smartmail_display_ebooks'));
    }

    public function smartmail_display_ebooks() {
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
}
