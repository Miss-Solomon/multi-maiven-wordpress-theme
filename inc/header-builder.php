<?php
/**
 * Header Builder Functionality
 *
 * @package Multi_Maiven
 */

/**
 * Register customizer settings for header builder
 */
function mm_header_builder_customize_register($wp_customize) {
    // Add Header Builder Section
    $wp_customize->add_section('mm_header_builder', array(
        'title'    => __('Header Builder', 'multi-maiven'),
        'priority' => 46,
    ));

    // 1. Sticky Header checkbox
    $wp_customize->add_setting('mm_sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_sticky_header', array(
        'type'    => 'checkbox',
        'label'   => __('Enable Sticky Header', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ));

    // 2. Enable Top Header checkbox
    $wp_customize->add_setting('show_top_bar', [
        'default' => true,
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('show_top_bar', [
        'label' => __('Enable Top Header', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'checkbox',
    ]);

    // 3. Only show to logged-in users checkbox
    $wp_customize->add_setting('top_bar_logged_in_only', [
        'default' => false,
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('top_bar_logged_in_only', [
        'label' => __('Only show Top Header to logged-in users', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'checkbox',
    ]);

    // 4. Reverse Left/Right Layout checkbox
    $wp_customize->add_setting('top_bar_reverse_layout', [
        'default' => false,
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('top_bar_reverse_layout', [
        'label' => __('Reverse Left/Right Layout', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'checkbox',
    ]);

    // 5. Top Header Bar Background Color
    $wp_customize->add_setting('top_bar_bg_color', [
        'default' => '#f9f9f9',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'top_bar_bg_color', [
        'label' => __('Top Header Bar Background Color', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ]));

    // 6. Top Header Bar Text Color
    $wp_customize->add_setting('top_bar_text_color', [
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'top_bar_text_color', [
        'label' => __('Top Header Bar Text Color', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ]));

    // 7. Left Content (e.g. Social Icons)
    $wp_customize->add_setting('top_bar_left', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('top_bar_left', [
        'label' => __('Left Content (e.g. Social Icons)', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'textarea',
    ]);

    // 8. Center Content (e.g. Promo)
    $wp_customize->add_setting('top_bar_center', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('top_bar_center', [
        'label' => __('Center Content (e.g. Promo)', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'textarea',
    ]);

    // 9. Right Content (e.g. Login)
    $wp_customize->add_setting('top_bar_right', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('top_bar_right', [
        'label' => __('Right Content (e.g. Login)', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'type' => 'textarea',
    ]);

    // 10. Header Background Color
    $wp_customize->add_setting('mm_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_header_bg_color', array(
        'label'    => __('Header Background Color', 'multi-maiven'),
        'section'  => 'mm_header_builder',
        'settings' => 'mm_header_bg_color',
    )));

    // 11. Header Image
    $wp_customize->add_setting('header_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_image', array(
        'label'    => __('Header Image', 'multi-maiven'),
        'section'  => 'mm_header_builder',
        'settings' => 'header_image',
    )));

    // 12. Header Layout
    $wp_customize->add_setting('mm_header_layout', array(
        'default'           => 'default',
        'sanitize_callback' => 'mm_sanitize_header_layout',
    ));
    $wp_customize->add_control('mm_header_layout', array(
        'type'        => 'select',
        'label'       => __('Header Layout', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Select the layout for your site header', 'multi-maiven'),
        'choices'     => array(
            'default'      => __('Default (Logo Left, Menu Right)', 'multi-maiven'),
            'centered'     => __('Centered Logo', 'multi-maiven'),
            'split'        => __('Split Menu', 'multi-maiven'),
        ),
    ));

    // 13. Logo Position
    $wp_customize->add_setting('mm_logo_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'mm_sanitize_logo_position',
    ));
    $wp_customize->add_control('mm_logo_position', array(
        'type'    => 'radio',
        'label'   => __('Logo Position', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'choices' => array(
            'left'   => __('Left', 'multi-maiven'),
            'center' => __('Center', 'multi-maiven'),
        ),
    ));

    // 14. Top of Header Padding (px)
    $wp_customize->add_setting('mm_header_padding_top', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_header_padding_top', array(
        'type'        => 'range',
        'label'       => __('Top of Header Padding (px)', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 5,
        ),
    ));

    // 14b. Bottom of Header Padding (px)
    $wp_customize->add_setting('mm_header_padding_bottom', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_header_padding_bottom', array(
        'type'        => 'range',
        'label'       => __('Bottom of Header Padding (px)', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 5,
        ),
    ));

    // 15. Show Header Border checkbox
    $wp_customize->add_setting('mm_header_border', array(
        'default'           => true,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_header_border', array(
        'type'    => 'checkbox',
        'label'   => __('Show Header Border', 'multi-maiven'),
        'section' => 'mm_header_builder',
    ));

    // 16. Transparent Header on Front Page checkbox
    $wp_customize->add_setting('mm_transparent_header', array(
        'default'           => false,
        'sanitize_callback' => 'mm_sanitize_checkbox',
    ));
    $wp_customize->add_control('mm_transparent_header', array(
        'type'        => 'checkbox',
        'label'       => __('Transparent Header on Front Page', 'multi-maiven'),
        'section'     => 'mm_header_builder',
        'description' => __('Make the header transparent on the front page', 'multi-maiven'),
    ));

    // 17. Menu Position
    $wp_customize->add_setting('mm_menu_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'mm_sanitize_menu_position',
    ));
    $wp_customize->add_control('mm_menu_position', array(
        'type'    => 'radio',
        'label'   => __('Menu Position', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'choices' => array(
            'left'   => __('Left', 'multi-maiven'),
            'center' => __('Center', 'multi-maiven'),
            'right'  => __('Right', 'multi-maiven'),
        ),
    ));

    // 18. Left Header Menu (Split Layout)
    $wp_customize->add_setting('mm_left_menu', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $menus = get_terms('nav_menu', array('hide_empty' => false));
    $menu_choices = array('' => __('— Select —', 'multi-maiven'));
    if (!empty($menus) && !is_wp_error($menus)) {
        foreach ($menus as $menu) {
            $menu_choices[$menu->term_id] = $menu->name;
        }
    }
    $wp_customize->add_control('mm_left_menu', array(
        'type'    => 'select',
        'label'   => __('Left Header Menu (Split Layout)', 'multi-maiven'),
        'section' => 'mm_header_builder',
        'choices' => $menu_choices,
        'description' => __('Select a menu to display on the left in split layout.', 'multi-maiven'),
    ));
}
add_action('customize_register', 'mm_header_builder_customize_register');

/**
 * Sanitization functions
 */
function mm_sanitize_header_layout($input) {
    $valid_layouts = array('default', 'centered', 'split');
    return in_array($input, $valid_layouts) ? $input : 'default';
}

function mm_sanitize_logo_position($input) {
    $valid_positions = array('left', 'center');
    return in_array($input, $valid_positions) ? $input : 'left';
}

function mm_sanitize_menu_position($input) {
    $valid_positions = array('left', 'center', 'right');
    return in_array($input, $valid_positions) ? $input : 'right';
}

/**
 * Output header elements based on customizer settings
 */
function mm_header_elements() {
    $header_layout = get_theme_mod('mm_header_layout', 'default');
    $elements = get_theme_mod('mm_header_elements', array('logo', 'menu'));

    if (!is_array($elements)) {
        $elements = explode(',', $elements);
    }

    // Apply header layout class
    $header_class = 'header-' . $header_layout;
    add_filter('body_class', function($classes) use ($header_class) {
        $classes[] = $header_class;
        return $classes;
    });

    // Apply header styles
    $header_padding_top = get_theme_mod('mm_header_padding_top', '20');
    $header_padding_bottom = get_theme_mod('mm_header_padding_bottom', '20');
    $header_border = get_theme_mod('mm_header_border', true);
    $transparent_header = get_theme_mod('mm_transparent_header', false);

    $logo_position = get_theme_mod('mm_logo_position', 'left');
    $menu_position = get_theme_mod('mm_menu_position', 'right');

    // Add inline styles
    add_action('wp_head', function() use ($header_padding_top, $header_padding_bottom, $header_border, $transparent_header, $logo_position, $menu_position) {
        ?>
        <style type="text/css">
            .header-container {
                padding-top: <?php echo esc_attr($header_padding_top); ?>px;
                padding-bottom: <?php echo esc_attr($header_padding_bottom); ?>px;
                border-bottom: <?php echo $header_border ? '1px solid var(--mm-color-border)' : 'none'; ?>;
            }

            <?php if ($logo_position === 'center') : ?>
            .site-branding {
                justify-content: center;
                text-align: center;
            }
            <?php endif; ?>

            <?php if ($menu_position === 'center') : ?>
            .main-navigation {
                justify-content: center;
            }
            <?php elseif ($menu_position === 'left') : ?>
            .main-navigation {
                justify-content: flex-start;
            }
            <?php endif; ?>

            <?php if ($transparent_header && is_front_page()) : ?>
            .site-header {
                background-color: transparent;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                z-index: 999;
                border-bottom: none;
            }
            .site-header .site-title a,
            .site-header .site-description,
            .site-header .main-navigation a {
                color: #fff;
            }
            <?php endif; ?>

            <?php if ($header_layout === 'centered') : ?>
            .header-container {
                flex-direction: column;
            }
            .site-branding {
                margin-bottom: 1rem;
            }
            <?php elseif ($header_layout === 'split') : ?>
            /* Split menu layout - requires JavaScript to implement fully */
            <?php endif; ?>
        </style>
        <?php
    });
}
add_action('after_setup_theme', 'mm_header_elements');

/**
 * Enqueue header builder JavaScript
 */
function mm_header_builder_scripts() {
    if (is_customize_preview()) {
        $theme = wp_get_theme();
        $version = $theme->get('Version');
        wp_enqueue_script('mm-header-builder', get_template_directory_uri() . '/js/header-builder.js', array('customize-preview', 'jquery', 'jquery-ui-sortable'), $version, true);
    }
}
add_action('customize_preview_init', 'mm_header_builder_scripts');
