<?php
// Contents for the admin-settings-page.php template
?>

<h1>SmartMail Software Store Settings</h1>
<form method="post" action="options.php">
    <?php
    settings_fields('smartmail_software_store_settings_group');
    do_settings_sections('smartmail_software_store_settings');
    submit_button();
    ?>
</form>
