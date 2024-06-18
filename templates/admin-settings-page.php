<div class="wrap">
    <h1>SmartMail Store Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('smartmail_store_settings_group');
        do_settings_sections('smartmail_store_settings_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Logo URL</th>
                <td><input type="text" name="smartmail_store_logo" value="<?php echo esc_attr(get_option('smartmail_store_logo')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Allowed eBook Types</th>
                <td><input type="text" name="smartmail_store_ebook_types" value="<?php echo esc_attr(get_option('smartmail_store_ebook_types')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Allowed Software Types</th>
                <td><input type="text" name="smartmail_store_software_types" value="<?php echo esc_attr(get_option('smartmail_store_software_types')); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
