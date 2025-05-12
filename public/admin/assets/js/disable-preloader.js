// This script disables the preloader on all pages
document.addEventListener('DOMContentLoaded', function() {
    // Find and remove the preloader element
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.display = 'none';
    }
    
    // Also remove any spinner elements
    const spinners = document.querySelectorAll('.spinner');
    spinners.forEach(function(spinner) {
        spinner.style.display = 'none';
    });
});