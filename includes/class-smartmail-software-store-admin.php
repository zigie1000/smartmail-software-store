<?php

class SmartMail_Software_Store_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'register_admin_menu'));
        add_action('admin_post_add_ebook', array($this, 'handle_ebook_submission'));
        add_action('admin_post_add_software', array($this, 'handle_software_submission'));
        add_action('admin_post_edit_product', array($this, 'handle_edit_submission'));
        add_action('admin_post_delete_product', array($this, 'handle_delete_submission'));
    }

    public function register_admin_menu() {
        add_menu_page(
            'SmartMail Software Store',
            'SmartMail Store',
            'manage_options',
            'smartmail-software-store',
            array($this, 'admin_ebooks_page'),
            'dashicons-admin-generic',
            6
        );

        add_submenu_page(
            'smartmail-software-store',
            'eBooks',
            'eBooks',
            'manage_options',
            'smartmail-software-store-ebooks',
            array($this, 'admin_ebooks_page')
        );

        add_submenu_page(
            'smartmail-software-store',
            'Software',
            'Software',
            'manage_options',
            'smartmail-software-store-software',
            array($this, 'admin_software_page')
        );
    }

    public function admin_ebooks_page() {
        global $wpdb;
        $ebooks_table_name = $wpdb->prefix . 'smartmail_ebooks';

        $ebooks = $wpdb->get_results("SELECT * FROM $ebooks_table_name");

        include plugin_dir_path(__FILE__) . '../templates/admin-ebooks-page.php';
    }

    public function admin_software_page() {
        global $wpdb;
        $software_table_name = $wpdb->prefix . 'smartmail_software';

        $software = $wpdb->get_results("SELECT * FROM $software_table_name");

        include plugin_dir_path(__FILE__) . '../templates/admin-software-page.php';
    }

    public function handle_ebook_submission() {
        $this->handle_form_submission('ebook');
    }

    public function handle_software_submission() {
        $this->handle_form_submission('software');
    }

    private function handle_form_submission($product_type) {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $table_name = $product_type == 'ebook' ? $wpdb->prefix . 'smartmail_ebooks' : $wpdb->prefix . 'smartmail_software';

        if (isset($_POST['action']) && $_POST['action'] == "add_$product_type") {
            $this->add_product($table_name);
        } elseif (isset($_POST['action']) && $_POST['action'] == 'edit_product') {
            $this->edit_product($table_name);
        } elseif (isset($_POST['action']) && $_POST['action'] == 'delete_product') {
            $this->delete_product($table_name);
        }

        $redirect_url = admin_url('admin.php?page=smartmail-software-store');
        if ($product_type == 'software') {
            $redirect_url = admin_url('admin.php?page=smartmail-software-store-software');
        }
        wp_redirect($redirect_url);
        exit;
    }

    private function add_product($table_name) {
        global $wpdb;
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

    private function edit_product($table_name) {
        global $wpdb;
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

    private function delete_product($table_name) {
        global $wpdb;
        $product_id = intval($_POST['product_id']);

        $wpdb->delete($table_name, array('id' => $product_id));
    }
}

new SmartMail_Software_Store_Admin();
