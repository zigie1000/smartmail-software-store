<?php
/**
 * The public-specific functionality of the plugin.
 *
 * @link       https://smartmail.store
 * @since      1.0.0
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/public
 */

class SmartMail_Software_Store_Public {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        // Enqueue the main CSS file for the plugin
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-public.css', array(), $this->version, 'all');

        // Enqueue the CSS file for eBooks
        wp_enqueue_style($this->plugin_name . '-ebooks', plugin_dir_url(__FILE__) . 'css/smartmail-ebooks-store.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-public.js', array('jquery'), $this->version, false);
    }
}

// Hook the methods to the appropriate actions
$smartmail_software_store_public = new SmartMail_Software_Store_Public('smartmail-software-store', '1.0.0');
add_action('wp_enqueue_scripts', array($smartmail_software_store_public, 'enqueue_styles'));
add_action('wp_enqueue_scripts', array($smartmail_software_store_public, 'enqueue_scripts'));
?>
