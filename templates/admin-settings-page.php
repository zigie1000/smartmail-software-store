<div class="wrap">
    <h1><?php _e('Settings', 'smartmail-software-store'); ?></h1>
    <form method="post" action="options.php">
        <?php
            settings_fields('smartmail_software_store_settings');
            do_settings_sections('smartmail_software_store_settings');
            submit_button();
        ?>
    </form>
</div>
