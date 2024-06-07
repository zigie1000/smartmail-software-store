// JavaScript for SmartMail Software Store plugin

document.addEventListener('DOMContentLoaded', function() {
    console.log('SmartMail Software Store script loaded');

    // Example: Toggle item details
    const items = document.querySelectorAll('.software-store-item');
    items.forEach(function(item) {
        item.addEventListener('click', function() {
            const description = item.querySelector('.software-store-item-description');
            if (description.style.display === 'none' || description.style.display === '') {
                description.style.display = 'block';
            } else {
                description.style.display = 'none';
            }
        });
    });
});
