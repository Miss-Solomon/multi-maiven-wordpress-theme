<?php
/**
 * Multi Maiven Theme Customizer
 *
 * @package Multi_Maiven
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function mm_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'mm_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'mm_customize_partial_blogdescription',
            )
        );
    }

    // Primary Color
    $wp_customize->add_setting('mm_primary_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_primary_color', array(
        'label'    => __('Primary Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('mm_secondary_color', array(
        'default'           => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_secondary_color', array(
        'label'    => __('Secondary Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_secondary_color',
    )));

    // Text Color
    $wp_customize->add_setting('mm_text_color', array(
        'default'           => '#1e293b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_text_color', array(
        'label'    => __('Text Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_text_color',
    )));
    
    // Link Color
    $wp_customize->add_setting('mm_link_color', array(
        'default'           => '#2563eb',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_link_color', array(
        'label'    => __('Link Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_link_color',
    )));
    
    // Link Hover Color
    $wp_customize->add_setting('mm_link_hover_color', array(
        'default'           => '#1d4ed8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_link_hover_color', array(
        'label'    => __('Link Hover Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_link_hover_color',
    )));

    // Add Typography Section
    $wp_customize->add_section('mm_typography', array(
        'title'    => __('Typography', 'multi-maiven'),
        'priority' => 35,
    ));

    // Base Font Family
    $wp_customize->add_setting('mm_font_family', array(
        'default'           => 'system',
        'sanitize_callback' => 'mm_sanitize_font_family',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('mm_font_family', array(
        'type'     => 'select',
        'label'    => __('Font Family', 'multi-maiven'),
        'section'  => 'mm_typography',
        'choices'  => array(
            'system'    => __('System Font', 'multi-maiven'),
            'georgia'   => __('Georgia, serif', 'multi-maiven'),
            'times'     => __('Times New Roman, serif', 'multi-maiven'),
            'arial'     => __('Arial, sans-serif', 'multi-maiven'),
            'helvetica' => __('Helvetica, sans-serif', 'multi-maiven'),
        ),
    ));

    // Font Size
    $wp_customize->add_setting('mm_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('mm_font_size', array(
        'type'        => 'range',
        'label'       => __('Base Font Size (px)', 'multi-maiven'),
        'section'     => 'mm_typography',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Add Layout Section
    $wp_customize->add_section('mm_layout', array(
        'title'    => __('Layout Options', 'multi-maiven'),
        'priority' => 40,
    ));

    // Container Width
    $wp_customize->add_setting('mm_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('mm_container_width', array(
        'type'        => 'range',
        'label'       => __('Container Width (px)', 'multi-maiven'),
        'section'     => 'mm_layout',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1400,
            'step' => 20,
        ),
    ));

    // Sidebar Position
    $wp_customize->add_setting('mm_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'mm_sanitize_sidebar_position',
    ));

    $wp_customize->add_control('mm_sidebar_position', array(
        'type'    => 'radio',
        'label'   => __('Sidebar Position', 'multi-maiven'),
        'section' => 'mm_layout',
        'choices' => array(
            'left'  => __('Left', 'multi-maiven'),
            'right' => __('Right', 'multi-maiven'),
            'none'  => __('No Sidebar', 'multi-maiven'),
        ),
    ));

    // Remove header controls from here, as they are now managed in header-builder.php
}
add_action('customize_register', 'mm_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function mm_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function mm_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitization functions
 */
function mm_sanitize_font_family($input) {
    $valid_fonts = array('system', 'georgia', 'times', 'arial', 'helvetica');
    return in_array($input, $valid_fonts) ? $input : 'system';
}

function mm_sanitize_sidebar_position($input) {
    $valid_positions = array('left', 'right', 'none');
    return in_array($input, $valid_positions) ? $input : 'right';
}

function mm_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mm_customize_preview_js() {
    $theme = wp_get_theme();
    $version = $theme->get('Version');
    wp_enqueue_script('mm-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), $version, true);
}
add_action('customize_preview_init', 'mm_customize_preview_js');

/**
 * Output customizer styles
 */
function mm_customizer_css() {
    $primary_color = get_theme_mod('mm_primary_color', '#2563eb');
    $secondary_color = get_theme_mod('mm_secondary_color', '#64748b');
    $text_color = get_theme_mod('mm_text_color', '#1e293b');
    $link_color = get_theme_mod('mm_link_color', '#2563eb');
    $link_hover_color = get_theme_mod('mm_link_hover_color', '#1d4ed8');
    $font_size = get_theme_mod('mm_font_size', '16');
    $container_width = get_theme_mod('mm_container_width', '1200');
    $header_bg_color = get_theme_mod('mm_header_bg_color', '#ffffff');
    $footer_bg_color = get_theme_mod('mm_footer_bg_color', '#f8fafc');
    $footer_text_color = get_theme_mod('mm_footer_text_color', '#1e293b');

    $font_family_map = array(
        'system'    => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'georgia'   => 'Georgia, serif',
        'times'     => '"Times New Roman", serif',
        'arial'     => 'Arial, sans-serif',
        'helvetica' => 'Helvetica, sans-serif',
    );
    $font_family = get_theme_mod('mm_font_family', 'system');
    $font_family_css = isset($font_family_map[$font_family]) ? $font_family_map[$font_family] : $font_family_map['system'];

    ?>
    <style type="text/css">
        :root {
            --mm-color-primary: <?php echo esc_attr($primary_color); ?>;
            --mm-color-secondary: <?php echo esc_attr($secondary_color); ?>;
            --mm-color-text: <?php echo esc_attr($text_color); ?>;
            --mm-color-link: <?php echo esc_attr($link_color); ?>;
            --mm-color-link-hover: <?php echo esc_attr($link_hover_color); ?>;
            --mm-font-family-base: <?php echo esc_attr($font_family_css); ?>;
            --mm-font-size-base: <?php echo esc_attr($font_size); ?>px;
            --mm-container-width: <?php echo esc_attr($container_width); ?>px;
            --mm-footer-bg-color: <?php echo esc_attr($footer_bg_color); ?>;
            --mm-footer-text-color: <?php echo esc_attr($footer_text_color); ?>;
        }
        .site-header {
            background-color: <?php echo esc_attr($header_bg_color); ?>;
        }
        <?php if (get_theme_mod('mm_sticky_header', false)) : ?>
        .site-header {
            position: sticky;
            top: 0;
            z-index: 999;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'mm_customizer_css');
