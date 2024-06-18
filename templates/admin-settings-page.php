<div class="wrap">
    <h1>Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('smartmail_software_store_options_group');
        do_settings_sections('smartmail_software_store_options_group');
        ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Setting 1</th>
            <td><input type="text" name="smartmail_software_store_setting_1" value="<?php echo get_option('smartmail_software_store_setting_1'); ?>" /></td>
            </tr>
             
            <tr valign="top">
            <th scope="row">Setting 2</th>
            <td><input type="text" name="smartmail_software_store_setting_2" value="<?php echo get_option('smartmail_software_store_setting_2'); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>
