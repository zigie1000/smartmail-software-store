<?php
echo '<div class="wrap">';
echo '<h1>' . esc_html__('Settings', 'smartmail-software-store') . '</h1>';
echo '<p>' . esc_html__('Settings for the SmartMail Software Store.', 'smartmail-software-store') . '</p>';

// Add form for settings
echo '<form method="post" action="options.php">';
settings_fields('smartmail_software_store_settings_group');
do_settings_sections('smartmail_software_store_settings_group');
submit_button();
echo '</form>';

echo '</div>';
?>
