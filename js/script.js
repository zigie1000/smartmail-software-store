jQuery(document).ready(function($) {
    // Toggle software description on title click
    $('.software-store-item-title').on('click', function() {
        $(this).next('.software-store-item-description').slideToggle();
    });
});
