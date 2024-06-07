<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

smartmail_log('Loading SmartMail_Software_Store_Public class');

class SmartMail_Software_Store_Public {
    public function __construct() {
        smartmail_log('Constructing SmartMail_Software_Store_Public');
    }

    public function enqueue_public_scripts() {
        smartmail_log('Enqueueing public scripts');
        wp_enqueue_style( 'smartmail-software-store-style', plugin_dir_url( __FILE__ ) . '../css/style.css' );
        wp_enqueue_script( 'smartmail-software-store-script', plugin_dir_url( __FILE__ ) . '../js/script.js', array('jquery'), null, true );
    }

    public function display_software_store() {
        smartmail_log('Displaying software store');
        ob_start();
        include plugin_dir_path( __FILE__ ) . '../public-software.php';
        return ob_get_clean();
    }

    public function display_ebook_store() {
        smartmail_log('Displaying ebook store');
        ob_start();
        include plugin_dir_path( __FILE__ ) . '../public-ebooks.php';
        return ob_get_clean();
    }
}
