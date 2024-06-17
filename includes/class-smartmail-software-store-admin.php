<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://smartmail.store
 * @since      1.0.0
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/admin
 */

class SmartMail_Software_Store_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartmail-software-store-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartmail-software-store-admin.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_admin_menu() {
        add_menu_page('SmartMail Software Store', 'SmartMail Store', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-admin-generic', 26);
        add_submenu_page($this->plugin_name, 'Settings', 'Settings', 'manage_options', $this->plugin_name . '-settings', array($this, 'display_plugin_admin_settings'));
    }

    public function display_plugin_setup_page() {
        include_once('templates/admin-page.php');
    }

    public function display_plugin_admin_settings() {
        include_once('templates/admin-settings-page.php');
    }

    public function add_action_links($links) {
        $settings_link = array('<a href="' . admin_url('admin.php?page=' . $this->plugin_name . '-settings') . '">' . __('Settings', 'smartmail-software-store') . '</a>',);
        return array_merge($settings_link, $links);
    }

    public function settings_init() {
        register_setting('smartmailSoftwareStore', 'smartmail_software_store_settings');

        add_settings_section(
            'smartmail_software_store_section',
            __('Settings', 'smartmail-software-store'),
            array($this, 'settings_section_callback'),
            'smartmailSoftwareStore'
        );

        add_settings_field(
            'smartmail_software_store_text_field',
            __('Settings field description', 'smartmail-software-store'),
            array($this, 'settings_field_callback'),
            'smartmailSoftwareStore',
            'smartmail_software_store_section'
        );
    }

    public function settings_section_callback() {
        echo __('This section description', 'smartmail-software-store');
    }

    public function settings_field_callback() {
        $options = get_option('smartmail_software_store_settings');
        echo '<input type="text" name="smartmail_software_store_settings[smartmail_software_store_text_field]" value="' . $options['smartmail_software_store_text_field'] . '">';
    }

    public function run() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links'));
        add_action('admin_init', array($this, 'settings_init'));
    }
}
