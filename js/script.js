jQuery(document).ready(function($) {
    // Toggle software description on title click
    $('.software-store-item-title').on('click', function() {
        $(this).next('.software-store-item-description').slideToggle();
    });

    // Toggle ebook description on title click
    $('.ebook-item-title').on('click', function() {
        $(this).next('.ebook-item-description').slideToggle();
    });
});
