/**
 * Simple form submission handler
 */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('familyForm');

    if (form) {
        // Add a timestamp parameter to avoid caching issues
        if (form.action.indexOf('?') === -1) {
            form.action = form.action + '?t=' + Date.now();
        } else {
            form.action = form.action + '&t=' + Date.now();
        }
    }
});
