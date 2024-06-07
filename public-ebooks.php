<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$data = get_option( 'smartmail_software_store_data' );
if ( $data && $data['type'] == 'ebook' ) {
    echo '<div class="ebook-store">';
    echo '<div class="ebook-item">';
    echo '<img src="' . esc_url( $data['file'] ) . '" alt="' . esc_attr( $data['name'] ) . '">';
    echo '<h2>' . esc_html( $data['name'] ) . '</h2>';
    echo '<p>' . esc_html( $data['description'] ) . '</p>';
    echo '<p>Price: $' . esc_html( $data['price'] ) . '</p>';
    echo '<a href="' . esc_url( edd_get_checkout_uri( array( 'edd_action' => 'add_to_cart', 'download_id' => 2 ) ) ) . '" class="buy-now-button">Buy Now</a>';
    echo '</div>';
    echo '</div>';
} else {
    echo '<p>No ebooks available.</p>';
}
?>
