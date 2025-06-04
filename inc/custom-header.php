<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * @package Multi_Maiven
 */

/**
 * Set up the WordPress core custom header feature.
 */
function mm_custom_header_setup() {
    add_theme_support(
        'custom-header',
        apply_filters(
            'mm_custom_header_args',
            array(
                'default-image'      => '',
                'default-text-color' => '1e293b',
                'width'              => 1200,
                'height'             => 250,
                'flex-height'        => true,
                'wp-head-callback'   => 'mm_header_style',
            )
        )
    );
}
add_action('after_setup_theme', 'mm_custom_header_setup');

if (!function_exists('mm_header_style')) :
    /**
     * Styles the header image and text displayed on the blog.
     */
    function mm_header_style() {
        $header_text_color = get_header_textcolor();

        /*
         * If no custom options for text are set, let's bail.
         * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support('custom-header').
         */
        if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
        ?>
        <style type="text/css">
        <?php
        // Has the text been hidden?
        if (!display_header_text()) :
            ?>
            .site-title,
            .site-description {
                position: absolute;
                clip: rect(1px, 1px, 1px, 1px);
            }
        <?php
        // If the user has set a custom color for the text use that.
        else :
            ?>
            .site-title a,
            .site-description {
                color: #<?php echo esc_attr($header_text_color); ?>;
            }
        <?php endif; ?>
        </style>
        <?php
    }
endif;

/**
 * Add header image to custom header background
 */
function mm_header_image() {
    if (get_header_image()) {
        ?>
        <style type="text/css">
            .site-header {
                background-image: url(<?php echo esc_url(get_header_image()); ?>);
                background-size: cover;
                background-position: center;
            }
            .site-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: -1;
            }
            .site-header .site-branding * {
                color: #fff;
            }
            .site-header .main-navigation a {
                color: #fff;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'mm_header_image');
