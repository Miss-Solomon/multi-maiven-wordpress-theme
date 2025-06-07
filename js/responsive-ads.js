/**
 * Responsive Ads Script
 * 
 * This script handles the responsive behavior of ads in the theme.
 * It ensures that ad containers are collapsed when they don't contain any ad code.
 */

(function() {
    'use strict';

    /**
     * Check if an element is empty (has no content or only whitespace)
     * 
     * @param {HTMLElement} element - The element to check
     * @return {boolean} - True if the element is empty, false otherwise
     */
    function isElementEmpty(element) {
        // Check if the element exists
        if (!element) return true;
        
        // Check if it has no children and no text content (or only whitespace)
        return element.children.length === 0 && (!element.textContent || element.textContent.trim() === '');
    }

/**
 * Initialize the responsive ads functionality
 */
function initResponsiveAds() {
    // Get all ad containers
    const headerAdContainer = document.querySelector('.responsive-header-ad');
    const footerAdContainer = document.querySelector('.responsive-footer-ad');
    
    // Process header ad container
    if (headerAdContainer) {
        const desktopAd = headerAdContainer.querySelector('.desktop-ad');
        const mobileAd = headerAdContainer.querySelector('.mobile-ad');
        
        // Check if both desktop and mobile ads are empty
        if ((desktopAd && isElementEmpty(desktopAd)) && (mobileAd && isElementEmpty(mobileAd))) {
            headerAdContainer.style.display = 'none';
        }
    }
    
    // Process footer ad container
    if (footerAdContainer) {
        const desktopAd = footerAdContainer.querySelector('.desktop-ad');
        const mobileAd = footerAdContainer.querySelector('.mobile-ad');
        
        // Check if both desktop and mobile ads are empty
        if ((desktopAd && isElementEmpty(desktopAd)) && (mobileAd && isElementEmpty(mobileAd))) {
            footerAdContainer.style.display = 'none';
        }
    }
}

    // Run when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', initResponsiveAds);
})();
