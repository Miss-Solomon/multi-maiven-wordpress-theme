/**
 * Multi Maiven Customizer Live Preview
 * Handles live preview functionality in WordPress Customizer
 */

(function($) {
    'use strict';

    // Site title and description
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header text color
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                });
            } else {
                $('.site-title, .site-description').css({
                    'clip': 'auto',
                    'position': 'relative'
                });
                $('.site-title a, .site-description').css({
                    'color': '#' + to
                });
            }
        });
    });

    // Colors
    wp.customize('mm_primary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-color-primary', to);
        });
    });

    wp.customize('mm_secondary_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-color-secondary', to);
        });
    });

    wp.customize('mm_text_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-color-text', to);
        });
    });
    
    wp.customize('mm_link_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-color-link', to);
        });
    });
    
    wp.customize('mm_link_hover_color', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-color-link-hover', to);
        });
    });

    // Typography
    wp.customize('mm_font_family', function(value) {
        value.bind(function(to) {
            const fontMap = {
                'system': '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'georgia': 'Georgia, serif',
                'times': '"Times New Roman", serif',
                'arial': 'Arial, sans-serif',
                'helvetica': 'Helvetica, sans-serif'
            };
            updateCSSProperty('--mm-font-family-base', fontMap[to] || fontMap.system);
        });
    });

    wp.customize('mm_font_size', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-font-size-base', to + 'px');
        });
    });

    // Layout
    wp.customize('mm_container_width', function(value) {
        value.bind(function(to) {
            updateCSSProperty('--mm-container-width', to + 'px');
        });
    });

    // Header Options
    wp.customize('mm_sticky_header', function(value) {
        value.bind(function(to) {
            if (to) {
                $('.site-header').addClass('sticky');
                $('body').addClass('sticky-header');
            } else {
                $('.site-header').removeClass('sticky');
                $('body').removeClass('sticky-header');
            }
        });
    });

    wp.customize('mm_header_bg_color', function(value) {
        value.bind(function(to) {
            $('.site-header').css('background-color', to);
        });
    });

    // Top of Header Padding (px)
    wp.customize('mm_header_padding_top', function(value) {
        value.bind(function(to) {
            $('.header-container').css({
                'padding-top': to + 'px'
            });
        });
    });
    // Bottom of Header Padding (px)
    wp.customize('mm_header_padding_bottom', function(value) {
        value.bind(function(to) {
            $('.header-container').css({
                'padding-bottom': to + 'px'
            });
        });
    });

    wp.customize('mm_header_border', function(value) {
        value.bind(function(to) {
            if (to) {
                $('.site-header').css('border-bottom', '1px solid var(--mm-color-border)');
            } else {
                $('.site-header').css('border-bottom', 'none');
            }
        });
    });

    // Header Builder
    wp.customize('mm_header_layout', function(value) {
        value.bind(function(to) {
            // Remove existing layout classes
            $('body').removeClass('header-default header-centered header-split header-left_aligned');
            // Add new layout class
            $('body').addClass('header-' + to);
            
            // Apply layout-specific styles
            const headerContainer = $('.header-container');
            const siteBranding = $('.site-branding');
            const mainNavigation = $('.main-navigation');
            
            // Reset styles
            headerContainer.css({
                'flex-direction': '',
                'justify-content': ''
            });
            siteBranding.css({
                'margin-bottom': '',
                'justify-content': '',
                'text-align': ''
            });
            mainNavigation.css({
                'margin-left': ''
            });
            
            switch (to) {
                case 'centered':
                    headerContainer.css('flex-direction', 'column');
                    siteBranding.css('margin-bottom', '1rem');
                    break;
            }
        });
    });

    wp.customize('mm_logo_position', function(value) {
        value.bind(function(to) {
            const siteBranding = $('.site-branding');
            siteBranding.css({
                'justify-content': '',
                'text-align': ''
            });
            
            if (to === 'center') {
                siteBranding.css({
                    'justify-content': 'center',
                    'text-align': 'center'
                });
            }
        });
    });

    wp.customize('mm_menu_position', function(value) {
        value.bind(function(to) {
            const mainNavigation = $('.main-navigation');
            mainNavigation.css('justify-content', '');
            
            if (to === 'center') {
                mainNavigation.css('justify-content', 'center');
            } else if (to === 'left') {
                mainNavigation.css('justify-content', 'flex-start');
            }
        });
    });

    // Helper function to update CSS custom properties
    function updateCSSProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    // Handle real-time updates for form elements
    $(document).ready(function() {
        // Live update for text inputs
        $('.customize-control input[type="text"], .customize-control textarea').on('input', function() {
            const setting = $(this).data('customize-setting-link');
            if (setting) {
                wp.customize(setting).set($(this).val());
            }
        });

        // Live update for checkboxes
        $('.customize-control input[type="checkbox"]').on('change', function() {
            const setting = $(this).data('customize-setting-link');
            if (setting) {
                wp.customize(setting).set($(this).is(':checked'));
            }
        });

        // Live update for select elements
        $('.customize-control select').on('change', function() {
            const setting = $(this).data('customize-setting-link');
            if (setting) {
                wp.customize(setting).set($(this).val());
            }
        });

        // Live update for range inputs
        $('.customize-control input[type="range"]').on('input', function() {
            const setting = $(this).data('customize-setting-link');
            if (setting) {
                wp.customize(setting).set($(this).val());
            }
        });

        // Update range input display values
        $('.customize-control input[type="range"]').each(function() {
            const $input = $(this);
            const $output = $input.siblings('.range-value');
            if ($output.length) {
                $output.text($input.val());
                $input.on('input', function() {
                    $output.text($(this).val());
                });
            }
        });
    });

    // Footer Options are handled in footer-builder.js

    // Communicate with customizer panel
    wp.customize.bind('ready', function() {
        // Focus on elements when customizer control is focused
        wp.customize.previewer.bind('focus-control', function(controlId) {
            const focusMap = {
                'blogname': '.site-title a',
                'blogdescription': '.site-description',
                'mm_primary_color': '.mm-button, .wp-block-button__link',
                'mm_link_color': 'a',
                'mm_link_hover_color': 'a:hover',
                'mm_header_bg_color': '.site-header',
                'mm_footer_bg_color': '.site-footer',
                'mm_copyright_text': '.site-info',
                'custom_logo': '.custom-logo'
            };
            
            if (focusMap[controlId]) {
                const $element = $(focusMap[controlId]);
                if ($element.length) {
                    $element.addClass('mm-customize-focus');
                    setTimeout(function() {
                        $element.removeClass('mm-customize-focus');
                    }, 1000);
                }
            }
        });
    });

})(jQuery);
