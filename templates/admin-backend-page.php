<div class="wrap">
    <h1><?php esc_html_e('SmartMail Software Store Backend', 'smartmail-software-store'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('smartmail_software_store_backend_options_group');
        do_settings_sections('smartmail_software_store_backend');
        submit_button();
        ?>
    </form>
</div>
