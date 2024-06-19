<div class="wrap">
    <h1><?php _e('Software Page', 'smartmail-software-store'); ?></h1>
    <form method="post" action="options.php">
        <?php
        // Output security fields for the registered setting "smartmail_software_store_options"
        settings_fields('smartmail_software_store_options');
        // Output setting sections and their fields
        // (sections are registered for "smartmail_software_store", each field is registered to a specific section)
        do_settings_sections('smartmail_software_store');
        // Output save settings button
        submit_button(__('Save Changes', 'smartmail-software-store'));
        ?>
    </form>
</div>
