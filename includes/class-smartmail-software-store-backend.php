<?php

function smartmail_software_store_backend_page() {
    ?>
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
    <?php
}

function smartmail_software_store_backend_menu() {
    add_menu_page(
        __('SmartMail Software Store Backend', 'smartmail-software-store'),
        __('Software Store Backend', 'smartmail-software-store'),
        'manage_options',
        'smartmail_software_store_backend',
        'smartmail_software_store_backend_page'
    );
}
add_action('admin_menu', 'smartmail_software_store_backend_menu');
