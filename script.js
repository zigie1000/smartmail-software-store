jQuery(document).ready(function($) {
    $('.buy-now-button').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});
