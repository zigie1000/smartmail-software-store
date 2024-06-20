<?php

function smartmail_software_store_software_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('SmartMail Software', 'smartmail-software-store'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_software_store_software_options_group');
            do_settings_sections('smartmail_software_store_software');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function smartmail_software_store_software_menu() {
    add_submenu_page(
        'smartmail_software_store_backend',
        __('SmartMail Software', 'smartmail-software-store'),
        __('Software', 'smartmail-software-store'),
        'manage_options',
        'smartmail_software_store_software',
        'smartmail_software_store_software_page'
    );
}
add_action('admin_menu', 'smartmail_software_store_software_menu');
