<div class="ebook-store">
    <?php
    $data = get_option('smartmail_software_store_data');
    if ($data && $data['type'] == 'ebook') {
        ?>
        <div class="ebook-item">
            <img src="<?php echo esc_url($data['file']); ?>" alt="<?php echo esc_attr($data['name']); ?>">
            <h2><?php echo esc_html($data['name']); ?></h2>
            <p><?php echo esc_html($data['description']); ?></p>
            <p>Price: $<?php echo esc_html($data['price']); ?></p>
            <a href="<?php echo esc_url(edd_get_checkout_uri(array('edd_action' => 'add_to_cart', 'download_id' => 2))); ?>" class="buy-now-button">Buy Now</a>
        </div>
        <?php
    } else {
        echo '<p>No ebooks available</p>';
    }
    ?>
</div>
