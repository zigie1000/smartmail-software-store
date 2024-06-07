<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

smartmail_log('Loading SmartMail_Software_Store_Admin class');

class SmartMail_Software_Store_Admin {
    public function __construct() {
        smartmail_log('Constructing SmartMail_Software_Store_Admin');
        add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function create_admin_menu() {
        smartmail_log('Creating admin menu');
        add_menu_page(
            'SmartMail Software Store',
            'Software Store',
            'manage_options',
            'smartmail-software-store',
            array( $this, 'admin_page' ),
            'dashicons-store',
            6
        );
    }

    public function register_settings() {
        smartmail_log('Registering settings');
        register_setting( 'smartmail-software-store-group', 'software_store_settings' );
    }

    public function admin_page() {
        smartmail_log('Displaying admin page');
        ?>
        <div class="wrap">
            <h1>SmartMail Software Store Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'smartmail-software-store-group' ); ?>
                <?php do_settings_sections( 'smartmail-software-store-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Some Setting</th>
                        <td><input type="text" name="some_setting" value="<?php echo esc_attr( get_option('some_setting') ); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
