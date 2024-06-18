<?php

class SmartMail_Software_Store_Admin {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            26
        );
        add_submenu_page(
            $this->plugin_name,
            'SmartMail Software Store Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_admin_settings_page')
        );
    }

    public function display_plugin_admin_page() {
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store</h1>
            <form method="post" action="options.php">
                <?php settings_fields('smartmail-software-store-settings-group'); ?>
                <?php do_settings_sections('smartmail-software-store-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Settings field description</th>
                    <td><input type="text" name="smartmail_software_store_settings_field" value="<?php echo esc_attr(get_option('smartmail_software_store_settings_field')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function display_plugin_admin_settings_page() {
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('smartmail-software-store-settings-group'); ?>
                <?php do_settings_sections('smartmail-software-store-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Settings field description</th>
                    <td><input type="text" name="smartmail_software_store_settings_field" value="<?php echo esc_attr(get_option('smartmail_software_store_settings_field')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
?>
