<?php

// Shortcode to display eBooks
function smartmail_display_ebooks() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_ebooks';
    $ebooks = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="smartmail-ebooks">';
    foreach ($ebooks as $ebook) {
        echo '<div class="software-store-item">';
        if (!empty($ebook->image_url)) {
            echo '<img class="software-store-item-image" src="' . esc_url($ebook->image_url) . '" alt="' . esc_html($ebook->title) . '">';
        }
        echo '<h2 class="software-store-item-title">' . esc_html($ebook->title) . '</h2>';
        echo '<p class="software-store-item-description">' . esc_html($ebook->description) . '</p>';
        echo '<p class="software-store-item-price">$' . esc_html($ebook->price) . '</p>';
        echo '<a class="software-store-item-button" href="' . esc_url($ebook->file_url) . '">Download</a>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('smartmail_display_ebooks', 'smartmail_display_ebooks');

// Shortcode to display software
function smartmail_display_software() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_software';
    $software = $wpdb->get_results("SELECT * FROM $table_name");

    ob_start();
    echo '<div class="smartmail-software">';
    foreach ($software as $item) {
        echo '<div class="software-store-item">';
        if (!empty($item->image_url)) {
            echo '<img class="software-store-item-image" src="' . esc_url($item->image_url) . '" alt="' . esc_html($item->title) . '">';
        }
        echo '<h2 class="software-store-item-title">' . esc_html($item->title) . '</h2>';
        echo '<p class="software-store-item-description">' . esc_html($item->description) . '</p>';
        echo '<p class="software-store-item-price">$' . esc_html($item->price) . '</p>';
        echo '<a class="software-store-item-button" href="' . esc_url($item->file_url) . '">Download</a>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('smartmail_display_software', 'smartmail_display_software');

// Display subscription button and form
function display_subscription_button() {
    ?>
    <button id="subscribeButton" class="subscribe-button"> |oai:code-citation|
        <button id="subscribeButton" class="subscribe-button">Subscribe for Offers</button>
    <div id="subscribeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Subscribe to Our Newsletter</h2>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" id="subscriptionForm">
                <input type="hidden" name="action" value="handle_subscription_form">
                <label for="fullname">Full Name *</label>
                <input type="text" id="fullname" name="full_name" required>
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number">
                <label for="address">Address</label>
                <input type="text" id="address" name="address">
                <label for="newsletter_optin">Subscribe to Newsletters</label>
                <input type="checkbox" id="newsletter_optin" name="newsletter_optin">
                <input type="submit" value="Subscribe">
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'display_subscription_button');

// Handle subscription form submissions
function handle_subscription_form() {
    if (!isset($_POST['email'])) {
        wp_redirect(home_url());
        exit;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'smartmail_subscriptions';

    $full_name = sanitize_text_field($_POST['full_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone_number']);
    $address = sanitize_text_field($_POST['address']);
    $newsletter_optin = isset($_POST['newsletter_optin']) ? 1 : 0;

    $result = $wpdb->insert(
        $table_name,
        [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'newsletter_optin' => $newsletter_optin
        ],
        [
            '%s', '%s', '%s', '%s', '%d'
        ]
    );

    if ($result) {
        wp_redirect(home_url());
    } else {
        wp_redirect(home_url('?subscribe=error'));
    }
    exit;
}
add_action('admin_post_nopriv_handle_subscription_form', 'handle_subscription_form');
add_action('admin_post_handle_subscription_form', 'handle_subscription_form');

// JavaScript to handle subscribe button click
function smartmail_store_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#subscribeButton').click(function() {
            $('#subscribeModal').toggle();
        });

        $('.close').click(function() {
            $('#subscribeModal').hide();
        });

        $(window).click(function(event) {
            if (event.target == document.getElementById('subscribeModal')) {
                $('#subscribeModal').hide();
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'smartmail_store_script');

?>
