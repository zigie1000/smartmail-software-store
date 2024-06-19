<div class="wrap">
    <h1>SmartMail Store Settings</h1>
    <form method="post" action="options.php">
        <?php
            settings_fields('smartmail_store_settings_group');
            do_settings_sections('smartmail_store_settings_group');
            submit_button();
        ?>
    </form>
</div>
