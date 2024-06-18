<?php
// Contents for the admin-page.php template
?>

<h1>SmartMail Software Store</h1>
<form method="post" action="options.php">
    <?php
    settings_fields('smartmail_software_store_options_group');
    do_settings_sections('smartmail_software_store');
    submit_button();
    ?>
</form>
