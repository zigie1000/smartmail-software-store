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
