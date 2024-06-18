<div class="wrap">
    <h1>Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields('smartmail_software_store_settings_group'); ?>
        <?php do_settings_sections('smartmail_software_store_settings'); ?>
        <?php submit_button(); ?>
    </form>
</div>
