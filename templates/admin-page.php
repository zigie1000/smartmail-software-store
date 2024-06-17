<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://smartmail.store
 * @since      1.0.0
 *
 * @package    SmartMail_Software_Store
 * @subpackage SmartMail_Software_Store/admin/partials
 */
?>

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" name="options" action="options.php">
        <?php settings_fields('smartmail-software-store-settings-group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="smartmail_software_store_settings_field">Settings field description</label>
                </th>
                <td>
                    <input type="text" id="smartmail_software_store_settings_field" name="smartmail_software_store_settings_field" value="<?php echo esc_attr(get_option('smartmail_software_store_settings_field')); ?>" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
