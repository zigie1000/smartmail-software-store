<?php

class SmartMail_Software_Store_Activator {

    public static function activate() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'smartmail_ebooks';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title tinytext NOT NULL,
            description text NOT NULL,
            price float NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}
?>
