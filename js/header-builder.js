/**
 * Multi Maiven Header Builder JavaScript
 * Handles drag-and-drop functionality for header elements
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Initialize sortable functionality for header elements
        if ($('.mm-sortable-list').length) {
            $('.mm-sortable-list').sortable({
                placeholder: 'mm-sortable-placeholder',
                axis: 'y',
                cursor: 'move',
                tolerance: 'pointer',
                
                update: function(event, ui) {
                    updateHeaderElements();
                },
                
                start: function(event, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.addClass('mm-sortable-placeholder');
                }
            });
        }

        // Update header elements order
        function updateHeaderElements() {
            const $sortableList = $('.mm-sortable-list');
            const $hiddenInput = $sortableList.siblings('input[type="hidden"]');
            
            if ($sortableList.length && $hiddenInput.length) {
                const elements = [];
                
                $sortableList.find('.mm-sortable-item').each(function() {
                    elements.push($(this).data('value'));
                });
                
                $hiddenInput.val(elements.join(',')).trigger('change');
                
                // Update the customizer setting
                const settingId = $hiddenInput.attr('id').replace('_customize-input-', '');
                if (wp.customize && wp.customize(settingId)) {
                    wp.customize(settingId).set(elements);
                }
            }
        }

        // Add visual feedback for sortable items
        $('.mm-sortable-item').on('mouseenter', function() {
            $(this).addClass('mm-item-hover');
        }).on('mouseleave', function() {
            $(this).removeClass('mm-item-hover');
        });

        // Handle checkbox toggles for header elements
        $('.mm-header-elements-control').on('change', 'input[type="checkbox"]', function() {
            const $checkbox = $(this);
            const elementType = $checkbox.val();
            const $sortableList = $('.mm-sortable-list');
            
            if ($checkbox.is(':checked')) {
                // Add element to the list
                const elementLabel = $checkbox.siblings('label').text();
                const $newItem = $('<li class="mm-sortable-item" data-value="' + elementType + '">' + elementLabel + '</li>');
                $sortableList.append($newItem);
            } else {
                // Remove element from the list
                $sortableList.find('[data-value="' + elementType + '"]').remove();
            }
            
            updateHeaderElements();
        });

        // Preview header layout changes
        $('input[name="_customize-radio-mm_header_layout"]').on('change', function() {
            const layout = $(this).val();
            previewHeaderLayout(layout);
        });

        function previewHeaderLayout(layout) {
            const $preview = $('#customize-preview iframe');
            
            if ($preview.length) {
                const previewWindow = $preview[0].contentWindow;
                const previewDoc = previewWindow.document;
                const $body = $(previewDoc.body);
                
                // Remove existing layout classes
                $body.removeClass('header-default header-centered header-split header-left_aligned');
                
                // Add new layout class
                $body.addClass('header-' + layout);
                
                // Apply layout-specific styles in preview
                const $headerContainer = $(previewDoc).find('.header-container');
                const $siteBranding = $(previewDoc).find('.site-branding');
                const $mainNavigation = $(previewDoc).find('.main-navigation');
                
                // Reset styles
                $headerContainer.css({
                    'flex-direction': '',
                    'justify-content': ''
                });
                $siteBranding.css({
                    'margin-bottom': '',
                    'justify-content': '',
                    'text-align': ''
                });
                $mainNavigation.css('margin-left', '');
                
                switch (layout) {
                    case 'centered':
                        $headerContainer.css('flex-direction', 'column');
                        $siteBranding.css('margin-bottom', '1rem');
                        break;
                    case 'split':
                        // Split layout implementation would go here
                        break;
                }
            }
        }

        // Live preview for top of header padding
        $('input[data-customize-setting-link="mm_header_padding_top"]').on('input', function() {
            const value = $(this).val();
            updatePreviewCSS('.header-container', {
                'padding-top': value + 'px'
            });
        });
        // Live preview for bottom of header padding
        $('input[data-customize-setting-link="mm_header_padding_bottom"]').on('input', function() {
            const value = $(this).val();
            updatePreviewCSS('.header-container', {
                'padding-bottom': value + 'px'
            });
        });

        // Real-time preview for header border
        $('input[data-customize-setting-link="mm_header_border"]').on('change', function() {
            const isChecked = $(this).is(':checked');
            updatePreviewCSS('.site-header', {
                'border-bottom': isChecked ? '1px solid var(--mm-color-border)' : 'none'
            });
        });

        // Real-time preview for sticky header
        $('input[data-customize-setting-link="mm_sticky_header"]').on('change', function() {
            const isChecked = $(this).is(':checked');
            const $preview = $('#customize-preview iframe');
            
            if ($preview.length) {
                const previewDoc = $preview[0].contentWindow.document;
                const $header = $(previewDoc).find('.site-header');
                const $body = $(previewDoc.body);
                
                if (isChecked) {
                    $header.addClass('sticky');
                    $body.addClass('sticky-header');
                } else {
                    $header.removeClass('sticky');
                    $body.removeClass('sticky-header');
                }
            }
        });

        // Helper function to update preview CSS
        function updatePreviewCSS(selector, styles) {
            const $preview = $('#customize-preview iframe');
            
            if ($preview.length) {
                const previewDoc = $preview[0].contentWindow.document;
                const $element = $(previewDoc).find(selector);
                
                $element.css(styles);
            }
        }

        // Live preview for logo position
        $('input[name="_customize-radio-mm_logo_position"]').on('change', function() {
            const position = $(this).val();
            let styles = {
                'justify-content': '',
                'text-align': ''
            };
            
            switch (position) {
                case 'center':
                    styles = {
                        'justify-content': 'center',
                        'text-align': 'center'
                    };
                    break;
            }
            
            updatePreviewCSS('.site-branding', styles);
        });

        // Live preview for menu position
        $('input[name="_customize-radio-mm_menu_position"]').on('change', function() {
            const position = $(this).val();
            let justifyContent = '';
            
            switch (position) {
                case 'center':
                    justifyContent = 'center';
                    break;
                case 'left':
                    justifyContent = 'flex-start';
                    break;
                default:
                    justifyContent = 'flex-end';
            }
            
            updatePreviewCSS('.main-navigation', {
                'justify-content': justifyContent
            });
        });

        // Add custom CSS for sortable elements
        const customCSS = `
            .mm-sortable-list {
                list-style: none;
                padding: 0;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 4px;
                background: #f9f9f9;
                min-height: 40px;
            }
            
            .mm-sortable-item {
                padding: 10px 15px;
                background: #fff;
                border-bottom: 1px solid #eee;
                cursor: move;
                position: relative;
                transition: all 0.2s ease;
            }
            
            .mm-sortable-item:last-child {
                border-bottom: none;
            }
            
            .mm-sortable-item:hover,
            .mm-item-hover {
                background: #f0f0f1;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            
            .mm-sortable-item:before {
                content: '⋮⋮';
                position: absolute;
                left: 5px;
                top: 50%;
                transform: translateY(-50%);
                color: #ccc;
                font-size: 12px;
                line-height: 1;
            }
            
            .mm-sortable-placeholder {
                background: #f0f0f1 !important;
                border: 2px dashed #ccc !important;
                height: 40px !important;
                margin: 2px 0;
            }
            
            .ui-sortable-helper {
                background: #fff !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
                transform: rotate(2deg);
            }
        `;
        
        const styleElement = document.createElement('style');
        styleElement.type = 'text/css';
        styleElement.textContent = customCSS;
        document.head.appendChild(styleElement);

        // Initialize tooltips for header builder elements
        $('.mm-sortable-item').attr('title', 'Drag to reorder');

        // Handle element visibility toggles
        $('.mm-element-toggle').on('change', function() {
            const $toggle = $(this);
            const elementType = $toggle.data('element');
            const isVisible = $toggle.is(':checked');
            
            // Update preview
            const $preview = $('#customize-preview iframe');
            if ($preview.length) {
                const previewDoc = $preview[0].contentWindow.document;
                const $element = $(previewDoc).find('.header-' + elementType);
                
                if (isVisible) {
                    $element.show();
                } else {
                    $element.hide();
                }
            }
        });

    });

})(jQuery);
