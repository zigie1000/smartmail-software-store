<?php
// Function to create the database table for ebooks
function create_ebooks_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    
    // Check if table already exists
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text NOT NULL,
            price float NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

// Hook the function to the plugin activation hook
register_activation_hook(__FILE__, 'create_ebooks_table');

// Function to display ebooks
function display_smartmail_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    
    if (!empty($results)) {
        $output = '<div class="smartmail-ebooks">';
        foreach ($results as $row) {
            $output .= '<div class="ebook">';
            $output .= '<h2>' . esc_html($row->title) . '</h2>';
            $output .= '<p>' . esc_html($row->description) . '</p>';
            $output .= '<p>Price: $' . esc_html($row->price) . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
    } else {
        $output = '<p>No ebooks found</p>';
    }
    
    return $output;
}

// Register the shortcode
add_shortcode('smartmail_ebooks_display', 'display_smartmail_ebooks');

// Function to create a page automatically
function create_smartmail_ebooks_page() {
    // Check if the page already exists
    $page = get_page_by_path('smartmail-ebooks');
    if (!$page) {
        // Create post object
        $my_post = array(
            'post_title'    => wp_strip_all_tags('SmartMail Ebooks'),
            'post_content'  => '[smartmail_ebooks_display]',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
        );
        
        // Insert the post into the database
        wp_insert_post($my_post);
    }
}

// Hook the function to the plugin activation hook
register_activation_hook(__FILE__, 'create_smartmail_ebooks_page');
