/**
 * Multi Maiven Footer Builder Live Preview
 * Handles live preview functionality in WordPress Customizer for footer options
 */

(function($) {
    'use strict';

    // Footer Background Color
    wp.customize('mm_footer_bg_color', function(value) {
        value.bind(function(to) {
            $('.site-footer').css('background-color', to);
        });
    });

    // Footer Text Color
    wp.customize('mm_footer_text_color', function(value) {
        value.bind(function(to) {
            $('.site-footer').css('color', to);
            $('.site-footer a').css('color', to);
        });
    });

    // Copyright Text
    wp.customize('mm_copyright_text', function(value) {
        value.bind(function(to) {
            $('.bottom-footer-center').html(to);
        });
    });

    // Footer Top Padding
    wp.customize('mm_footer_padding_top', function(value) {
        value.bind(function(to) {
            $('.site-footer').css('padding-top', to + 'px');
        });
    });

    // Footer Bottom Padding
    wp.customize('mm_footer_padding_bottom', function(value) {
        value.bind(function(to) {
            $('.site-footer').css('padding-bottom', to + 'px');
        });
    });

    // Footer Border
    wp.customize('mm_footer_border', function(value) {
        value.bind(function(to) {
            if (to) {
                $('.site-footer').css('border-top', '1px solid var(--mm-color-border)');
            } else {
                $('.site-footer').css('border-top', 'none');
            }
        });
    });
    
    // Bottom Footer Bar Background Color
    wp.customize('mm_bottom_bar_bg_color', function(value) {
        value.bind(function(to) {
            $('.bottom-footer-bar').css('background-color', to);
        });
    });
    
    // Bottom Footer Bar Text Color
    wp.customize('mm_bottom_bar_text_color', function(value) {
        value.bind(function(to) {
            $('.bottom-footer-bar').css('color', to);
            $('.bottom-footer-bar a').css('color', to);
        });
    });
    
    // Bottom Footer Bar Left Content
    wp.customize('mm_bottom_bar_left', function(value) {
        value.bind(function(to) {
            // Check if layout is reversed
            var isReversed = $('.bottom-footer-bar').hasClass('reverse-layout');
            
            // Update the appropriate div based on reverse layout status
            if (isReversed) {
                $('.bottom-footer-right').html(to);
            } else {
                $('.bottom-footer-left').html(to);
            }
        });
    });
    
    // Bottom Footer Bar Right Content
    wp.customize('mm_bottom_bar_right', function(value) {
        value.bind(function(to) {
            // Check if layout is reversed
            var isReversed = $('.bottom-footer-bar').hasClass('reverse-layout');
            
            // Update the appropriate div based on reverse layout status
            if (isReversed) {
                $('.bottom-footer-left').html(to);
            } else {
                $('.bottom-footer-right').html(to);
            }
        });
    });

})(jQuery);
