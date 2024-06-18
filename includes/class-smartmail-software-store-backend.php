<?php

class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_backend_menu() {
        add_menu_page(
            'SmartMail Software Store Backend',
            'SmartMail Backend',
            'manage_options',
            $this->plugin_name . '-backend',
            array($this, 'display_plugin_backend_page'),
            'dashicons-admin-generic',
            27
        );
    }

    public function display_plugin_backend_page() {
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store Backend</h1>
            <form method="post" action="options.php">
                <?php settings_fields('smartmail-software-store-backend-group'); ?>
                <?php do_settings_sections('smartmail-software-store-backend-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Backend field description</th>
                    <td><input type="text" name="smartmail_software_store_backend_field" value="<?php echo esc_attr(get_option('smartmail_software_store_backend_field')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
?>
