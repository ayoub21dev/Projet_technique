import './bootstrap';
import 'preline';

// Type definition for HSStaticMethods in global window object
window.HSStaticMethods = window.HSStaticMethods || {};

// Initialize Preline
document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods.autoInit) {
        window.HSStaticMethods.autoInit();
    }
});
