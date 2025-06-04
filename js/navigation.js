/**
 * Multi Maiven Navigation JavaScript
 * Handles mobile menu functionality and accessibility
 */

(function() {
    'use strict';

    const toggleButton = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.main-navigation');
    const menu = navigation ? navigation.querySelector('ul') : null;

    // Return early if we don't have the elements we need
    if (!toggleButton || !navigation || !menu) {
        return;
    }

    // Toggle mobile menu
    toggleButton.addEventListener('click', function() {
        const expanded = toggleButton.getAttribute('aria-expanded') === 'true';
        
        // Toggle aria-expanded
        toggleButton.setAttribute('aria-expanded', !expanded);
        
        // Toggle navigation active class
        navigation.classList.toggle('active');
        
        // Toggle body class to prevent scrolling when menu is open
        document.body.classList.toggle('menu-open');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!navigation.contains(event.target) && navigation.classList.contains('active')) {
            toggleButton.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    });

    // Handle escape key to close menu
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && navigation.classList.contains('active')) {
            toggleButton.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('active');
            document.body.classList.remove('menu-open');
            toggleButton.focus();
        }
    });

    // Handle resize to close mobile menu if window gets larger
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && navigation.classList.contains('active')) {
            toggleButton.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    });

    // Add keyboard navigation support for menu items
    const menuItems = menu.querySelectorAll('a');
    
    menuItems.forEach((item, index) => {
        item.addEventListener('keydown', function(event) {
            let nextItem;
            
            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    nextItem = menuItems[index + 1] || menuItems[0];
                    nextItem.focus();
                    break;
                    
                case 'ArrowUp':
                    event.preventDefault();
                    nextItem = menuItems[index - 1] || menuItems[menuItems.length - 1];
                    nextItem.focus();
                    break;
                    
                case 'Home':
                    event.preventDefault();
                    menuItems[0].focus();
                    break;
                    
                case 'End':
                    event.preventDefault();
                    menuItems[menuItems.length - 1].focus();
                    break;
            }
        });
    });

    // Sticky header functionality
    const header = document.querySelector('.site-header');
    let lastScrollTop = 0;

    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (header.classList.contains('sticky') || 
            document.body.classList.contains('sticky-header')) {
            
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // Hide header on scroll down, show on scroll up
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }
        }
        
        lastScrollTop = scrollTop;
    }

    // Throttle scroll events for better performance
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(handleScroll, 10);
    });

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                event.preventDefault();
                
                const headerHeight = header.offsetHeight;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL without jumping
                history.pushState(null, null, '#' + targetId);
            }
        });
    });

    // Focus management for accessibility
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex="0"], [contenteditable]'
        );
        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }

    // Apply focus trapping to mobile menu when open
    navigation.addEventListener('transitionend', function() {
        if (navigation.classList.contains('active')) {
            trapFocus(navigation);
        }
    });

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading class to body and remove it when page is fully loaded
        document.body.classList.add('loading');
        
        window.addEventListener('load', function() {
            document.body.classList.remove('loading');
        });
    });

})();
