<?php

/**
 * SmartMail Software Store Admin Class
 *
 * @package SmartMail Software Store
 * @author Marco Zagato
 * @author URI https://smartmail.store
 */

class SmartMail_Software_Store_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'settings_init'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            'smartmail_software_store',
            array($this, 'admin_page'),
            'dashicons-store',
            6
        );
    }

    public function settings_init() {
        register_setting('smartmail_software_store_settings', 'smartmail_software_store_settings');

        add_settings_section(
            'smartmail_software_store_section',
            __('SmartMail Software Store Settings', 'smartmail-software-store'),
            array($this, 'settings_section_callback'),
            'smartmail_software_store_settings'
        );

        add_settings_field(
            'smartmail_software_store_text_field_0',
            __('Settings field description', 'smartmail-software-store'),
            array($this, 'settings_field_0_render'),
            'smartmail_software_store_settings',
            'smartmail_software_store_section'
        );
    }

    public function settings_field_0_render() {
        $options = get_option('smartmail_software_store_settings');
        ?>
        <input type='text' name='smartmail_software_store_settings[smartmail_software_store_text_field_0]' value='<?php echo $options['smartmail_software_store_text_field_0']; ?>'>
        <?php
    }

    public function settings_section_callback() {
        echo __('This section description', 'smartmail-software-store');
    }

    public function admin_page() {
        ?>
        <form action='options.php' method='post'>
            <h2>SmartMail Software Store</h2>
            <?php
            settings_fields('smartmail_software_store_settings');
            do_settings_sections('smartmail_software_store_settings');
            submit_button();
            ?>
        </form>
        <?php
    }
}

if (is_admin()) {
    new SmartMail_Software_Store_Admin();
}
