<?php

class SmartMail_Software_Store_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_post_add_product', array($this, 'handle_form_submission'));
        add_action('admin_post_edit_product', array($this, 'handle_form_submission'));
        add_action('admin_post_delete_product', array($this, 'handle_form_submission'));
    }

    public function register_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-software-store',
            array($this, 'admin_page'),
            'dashicons-admin-generic',
            6
        );
    }

    public function admin_page() {
        global $wpdb;
        $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
        $software_table_name = $wpdb->prefix . 'smartmail_software';

        $ebooks = $wpdb->get_results("SELECT * FROM $ebooks_table_name");
        $software = $wpdb->get_results("SELECT * FROM $software_table_name");

        include plugin_dir_path(__FILE__) . '../templates/admin-page.php';
    }

    public function handle_form_submission() {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';
        $software_table_name = $wpdb->prefix . 'smartmail_software';

        if (isset($_POST['action']) && $_POST['action'] == 'add_product') {
            $this->add_product($ebooks_table_name, $software_table_name);
        } elseif (isset($_POST['action']) && $_POST['action'] == 'edit_product') {
            $this->edit_product($ebooks_table_name, $software_table_name);
        } elseif (isset($_POST['action']) && $_POST['action'] == 'delete_product') {
            $this->delete_product($ebooks_table_name, $software_table_name);
        }

        wp_redirect(admin_url('admin.php?page=smartmail-software-store'));
        exit;
    }

    private function add_product($ebooks_table_name, $software_table_name) {
        global $wpdb;
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $price = floatval($_POST['price']);
        $rrp = floatval($_POST['rrp']);
        $image_url = sanitize_text_field($_POST['image_url']);
        $sku = sanitize_text_field($_POST['sku']);
        $barcode = sanitize_text_field($_POST['barcode']);
        $quantity = intval($_POST['quantity']);
        $file_url = sanitize_text_field($_POST['file_url']);

        $wpdb->insert($table_name, array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'rrp' => $rrp,
            'image_url' => $image_url,
            'sku' => $sku,
            'barcode' => $barcode,
            'quantity' => $quantity,
            'file_url' => $file_url
        ));
    }

    private function edit_product($ebooks_table_name, $software_table_name) {
        global $wpdb;
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $product_id = intval($_POST['product_id']);
        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $price = floatval($_POST['price']);
        $rrp = floatval($_POST['rrp']);
        $image_url = sanitize_text_field($_POST['image_url']);
        $sku = sanitize_text_field($_POST['sku']);
        $barcode = sanitize_text_field($_POST['barcode']);
        $quantity = intval($_POST['quantity']);
        $file_url = sanitize_text_field($_POST['file_url']);

        $wpdb->update($table_name, array(
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'rrp' => $rrp,
            'image_url' => $image_url,
            'sku' => $sku,
            'barcode' => $barcode,
            'quantity' => $quantity,
            'file_url' => $file_url
        ), array('id' => $product_id));
    }

    private function delete_product($ebooks_table_name, $software_table_name) {
        global $wpdb;
        $product_type = sanitize_text_field($_POST['product_type']);
        $table_name = $product_type == 'ebook' ? $ebooks_table_name : $software_table_name;
        $product_id = intval($_POST['product_id']);

        $wpdb->delete($table_name, array('id' => $product_id));
    }
}

new SmartMail_Software_Store_Admin();
?>
