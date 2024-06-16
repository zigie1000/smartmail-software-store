<?php

class SmartMail_Software_Store_Public {

    public function __construct() {
        add_shortcode('smartmail_display_ebooks', array($this, 'display_ebooks'));
        add_shortcode('smartmail_display_software', array($this, 'display_software'));
        add_shortcode('subscription_form', array($this, 'display_subscription_form'));
    }

    public function display_ebooks() {
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

    public function display_software() {
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

    public function display_subscription_form() {
        ob_start();
        ?>
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
        return ob_get_clean();
    }
}
?>
