<?php

class SmartMail_Software_Store_Backend {
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_settings_link($links) {
        $settings_link = '<a href="options-general.php?page=' . $this->plugin_name . '">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public function define_admin_hooks() {
        $plugin_admin = new SmartMail_Software_Store_Admin($this->plugin_name, $this->version);

        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));

        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
    }
}
?>
