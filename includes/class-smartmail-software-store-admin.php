<?php
/**
 * The admin-specific functionality of the plugin.
 */
class SmartMail_Software_Store_Admin
{
    private $plugin_name;
    private $version;

    public function __construct()
    {
        $this->plugin_name = 'smartmail-software-store';
        $this->version = '1.0';

        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
    }

    public function add_plugin_admin_menu()
    {
        add_menu_page(
            'SmartMail Store',
            'SmartMail Store',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_admin_page'),
            'dashicons-store',
            6
        );

        add_submenu_page(
            $this->plugin_name,
            'eBooks',
            'eBooks',
            'manage_options',
            'ebooks',
            array($this, 'display_ebooks_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'Software',
            'Software',
            'manage_options',
            'software',
            array($this, 'display_software_page')
        );
    }

    public function display_plugin_admin_page()
    {
        include_once 'templates/admin-page.php';
    }

    public function display_ebooks_page()
    {
        include_once 'templates/admin-ebooks-page.php';
    }

    public function display_software_page()
    {
        include_once 'templates/admin-software-page.php';
    }
}
?>
