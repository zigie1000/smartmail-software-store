<div class="wrap">
    <h1>SmartMail Software Store</h1>
    <form method="post" action="options.php">
        <?php settings_fields('smartmail_software_store_options_group'); ?>
        <?php do_settings_sections('smartmail_software_store'); ?>
        <?php submit_button(); ?>
    </form>
</div>
