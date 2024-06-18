<div class="wrap">
    <h1><?php _e('Settings', 'smartmail-software-store'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('smartmail_store_settings_group');
        do_settings_sections('smartmail_store_settings_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Setting 1', 'smartmail-software-store'); ?></th>
                <td><input type="text" name="smartmail_store_setting1" value="<?php echo esc_attr(get_option('smartmail_store_setting1')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e('Setting 2', 'smartmail-software-store'); ?></th>
                <td><input type="text" name="smartmail_store_setting2" value="<?php echo esc_attr(get_option('smartmail_store_setting2')); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
