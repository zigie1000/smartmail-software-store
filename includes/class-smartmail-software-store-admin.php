<?php

class SmartMail_Software_Store_Admin {

    public static function add_plugin_admin_menu() {
        add_menu_page(
            __('SmartMail Software Store', 'smartmail-software-store'),
            __('SmartMail Store', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software-store',
            array(self::class, 'render_admin_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('eBooks', 'smartmail-software-store'),
            __('eBooks', 'smartmail-software-store'),
            'manage_options',
            'smartmail-ebooks',
            array(self::class, 'render_ebooks_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('Software', 'smartmail-software-store'),
            __('Software', 'smartmail-software-store'),
            'manage_options',
            'smartmail-software',
            array(self::class, 'render_software_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            __('Settings', 'smartmail-software-store'),
            __('Settings', 'smartmail-software-store'),
            'manage_options',
            'smartmail-settings',
            array(self::class, 'render_settings_page')
        );
    }

    public static function render_admin_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-page.php';
    }

    public static function render_ebooks_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-ebooks-page.php';
    }

    public static function render_software_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-software-page.php';
    }

    public static function render_settings_page() {
        include_once plugin_dir_path(__FILE__) . '../templates/admin-settings-page.php';
    }

    public static function init_settings() {
        register_setting('smartmail_software_store_settings', 'smartmail_software_store_settings');
        
        add_settings_section(
            'smartmail_software_store_main_section',
            __('Main Settings', 'smartmail-software-store'),
            null,
            'smartmail_software_store_settings'
        );

        add_settings_field(
            'setting_1',
            __('Setting 1', 'smartmail-software-store'),
            array(self::class, 'render_setting_field'),
            'smartmail_software_store_settings',
            'smartmail_software_store_main_section',
            array('setting_1')
        );

        add_settings_field(
            'setting_2',
            __('Setting 2', 'smartmail-software-store'),
            array(self::class, 'render_setting_field'),
            'smartmail_software_store_settings',
            'smartmail_software_store_main_section',
            array('setting_2')
        );
    }

    public static function render_setting_field($args) {
        $options = get_option('smartmail_software_store_settings');
        $value = isset($options[$args[0]]) ? esc_attr($options[$args[0]]) : '';
        echo '<input type="text" id="' . esc_attr($args[0]) . '" name="smartmail_software_store_settings[' . esc_attr($args[0]) . ']" value="' . $value . '" />';
    }
}

add_action('admin_menu', array('SmartMail_Software_Store_Admin', 'add_plugin_admin_menu'));
add_action('admin_init', array('SmartMail_Software_Store_Admin', 'init_settings'));

?>
