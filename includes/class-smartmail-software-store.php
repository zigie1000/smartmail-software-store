<?php
class SmartMail_Software_Store {
    private static $instance = null;

    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function load_dependencies() {
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/class-smartmail-software-store-admin.php';
        require_once SMARTMAIL_SOFTWARE_STORE_PLUGIN_DIR . 'includes/admin/class-smartmail-software-store-file-upload.php';
    }

    private function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin();
        new SmartMail_Software_Store_File_Upload();  // Added to initialize the file upload functionality
    }
}
?>
