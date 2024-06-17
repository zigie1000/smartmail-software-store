<?php

class SmartMail_Software_Store_Public {

    public function __construct() {
        add_shortcode('smartmail_store', array($this, 'display_store'));
    }

    public function display_store($atts) {
        $atts = shortcode_atts(array(
            'type' => 'ebook',
        ), $atts, 'smartmail_store');

        ob_start();

        if ($atts['type'] == 'ebook') {
            $this->display_ebooks();
        } else {
            $this->display_software();
        }

        return ob_get_clean();
    }

    private function display_ebooks() {
        $args = array(
            'post_type' => 'ebook',
            'posts_per_page' => -1,
        );
        $ebooks = get_posts($args);
        ?>
        <div class="smartmail-store">
            <h2>eBooks</h2>
            <?php foreach ($ebooks as $ebook): ?>
            <div class="ebook">
                <h3><?php echo esc_html($ebook->post_title); ?></h3>
                <p><?php echo esc_html($ebook->post_content); ?></p>
                <p>Price: <?php echo esc_html(get_post_meta($ebook->ID, 'price', true)); ?></p>
                <p>Quantity: <?php echo esc_html(get_post_meta($ebook->ID, 'quantity', true)); ?></p>
                <a href="<?php echo esc_url(get_post_meta($ebook->ID, 'file_url', true)); ?>">Download</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    private function display_software() {
        $args = array(
            'post_type' => 'software',
            'posts_per_page' => -1,
        );
        $software = get_posts($args);
        ?>
        <div class="smartmail-store">
            <h2>Software</h2>
            <?php foreach ($software as $item): ?>
            <div class="software">
                <h3><?php echo esc_html($item->post_title); ?></h3>
                <p><?php echo esc_html($item->post_content); ?></p>
                <p>Price: <?php echo esc_html(get_post_meta($item->ID, 'price', true)); ?></p>
                <p>Quantity: <?php echo esc_html(get_post_meta($item->ID, 'quantity', true)); ?></p>
                <a href="<?php echo esc_url(get_post_meta($item->ID, 'file_url', true)); ?>">Download</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
