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
