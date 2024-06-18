<div class="wrap">
    <h1><?php _e('Settings', 'smartmail-software-store'); ?></h1>
    <form method="post" action="options.php">
        <?php settings_fields('smartmail_software_store_settings_group'); ?>
        <?php do_settings_sections('smartmail_software_store'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Setting 1', 'smartmail-software-store'); ?></th>
                <td><input type="text" name="setting_1" value="<?php echo esc_attr(get_option('setting_1')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Setting 2', 'smartmail-software-store'); ?></th>
                <td><input type="text" name="setting_2" value="<?php echo esc_attr(get_option('setting_2')); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
