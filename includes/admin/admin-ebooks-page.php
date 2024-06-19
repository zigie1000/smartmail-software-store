<?php

function smartmail_software_store_ebooks_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('SmartMail eBooks', 'smartmail-software-store'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('smartmail_software_store_ebooks_options_group');
            do_settings_sections('smartmail_software_store_ebooks');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function smartmail_software_store_ebooks_menu() {
    add_submenu_page(
        'smartmail_software_store_backend',
        __('SmartMail eBooks', 'smartmail-software-store'),
        __('eBooks', 'smartmail-software-store'),
        'manage_options',
        'smartmail_software_store_ebooks',
        'smartmail_software_store_ebooks_page'
    );
}
add_action('admin_menu', 'smartmail_software_store_ebooks_menu');
