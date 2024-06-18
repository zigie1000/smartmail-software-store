<?php
echo '<div class="wrap">';
echo '<h1>' . esc_html__('Settings', 'smartmail-software-store') . '</h1>';
echo '<form method="post" action="options.php">';
settings_fields('smartmail-software-store-settings-group');
do_settings_sections('smartmail-software-store-settings-group');
submit_button();
echo '</form>';
echo '</div>';
?>
