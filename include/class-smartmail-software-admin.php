<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class SmartMail_Software_Store_Admin {
    public function create_admin_menu() {
        add_menu_page(
            'Software Store',
            'Software Store',
            'manage_options',
            'smartmail-software-store',
            array( $this, 'admin_page' ),
            'dashicons-store',
            6
        );
    }

    public function admin_page() {
        include plugin_dir_path( __FILE__ ) . '../admin.php';
    }

    public function register_settings() {
        register_setting( 'smartmail_software_store_group', 'smartmail_software_store_data' );

        add_settings_section(
            'smartmail_software_store_section',
            'Add New Software or Ebook',
            null,
            'smartmail-software-store'
        );

        add_settings_field(
            'smartmail_software_store_name',
            'Name',
            array( $this, 'name_callback' ),
            'smartmail-software-store',
            'smartmail_software_store_section'
        );

        add_settings_field(
            'smartmail_software_store_description',
            'Description',
            array( $this, 'description_callback' ),
            'smartmail-software-store',
            'smartmail_software_store_section'
        );

        add_settings_field(
            'smartmail_software_store_price',
            'Price',
            array( $this, 'price_callback' ),
            'smartmail-software-store',
            'smartmail_software_store_section'
        );

        add_settings_field(
            'smartmail_software_store_file',
            'File URL',
            array( $this, 'file_callback' ),
            'smartmail-software-store',
            'smartmail_software_store_section'
        );

        add_settings_field(
            'smartmail_software_store_type',
            'Type',
            array( $this, 'type_callback' ),
            'smartmail-software-store',
            'smartmail_software_store_section'
        );
    }

    public function name_callback() {
        $data = get_option( 'smartmail_software_store_data' );
        ?>
        <input type="text" name="smartmail_software_store_data[name]" value="<?php echo esc_attr( $data['name'] ); ?>">
        <?php
    }

    public function description_callback() {
        $data = get_option( 'smartmail_software_store_data' );
        ?>
        <textarea name="smartmail_software_store_data[description]"><?php echo esc_attr( $data['description'] ); ?></textarea>
        <?php
    }

    public function price_callback() {
        $data = get_option( 'smartmail_software_store_data' );
        ?>
        <input type="text" name="smartmail_software_store_data[price]" value="<?php echo esc_attr( $data['price'] ); ?>">
        <?php
    }

    public function file_callback() {
        $data = get_option( 'smartmail_software_store_data' );
        ?>
        <input type="text" name="smartmail_software_store_data[file]" value="<?php echo esc_url( $data['file'] ); ?>">
        <?php
    }

    public function type_callback() {
        $data = get_option( 'smartmail_software_store_data' );
        ?>
        <select name="smartmail_software_store_data[type]">
            <option value="software" <?php selected( $data['type'], 'software' ); ?>>Software</option>
            <option value="ebook" <?php selected( $data['type'], 'ebook' ); ?>>Ebook</option>
        </select>
        <?php
    }
}
