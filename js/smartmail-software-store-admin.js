/* Admin JS for SmartMail Software Store */
jQuery(document).ready(function($) {
    // Custom admin scripts can be added here
    console.log("SmartMail Software Store Admin JS Loaded");
    
    // Example: Toggle settings sections
    $('.smartmail-settings-toggle').on('click', function() {
        $(this).next('.smartmail-settings-section').slideToggle();
    });
});
