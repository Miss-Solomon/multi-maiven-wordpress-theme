<?php
/**
 * Footer Builder Functionality
 *
 * @package Multi_Maiven
 */

/**
 * Register customizer settings for footer builder
 */
function mm_footer_builder_customize_register($wp_customize) {
    // Add Footer Builder Section
    $wp_customize->add_section('mm_footer_builder', array(
        'title'    => __('Footer Builder', 'multi-maiven'),
        'priority' => 47,
    ));

    // 1. Footer Background Color
    $wp_customize->add_setting('mm_footer_bg_color', array(
        'default'           => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_footer_bg_color', array(
        'label'    => __('Footer Background Color', 'multi-maiven'),
        'section'  => 'mm_footer_builder',
        'settings' => 'mm_footer_bg_color',
    )));

    // 2. Footer Text Color
    $wp_customize->add_setting('mm_footer_text_color', array(
        'default'           => '#1e293b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_footer_text_color', array(
        'label'    => __('Footer Text Color', 'multi-maiven'),
        'section'  => 'mm_footer_builder',
        'settings' => 'mm_footer_text_color',
    )));

    // 3. Copyright Text Editor
    $wp_customize->add_setting('mm_copyright_text', array(
        'default'           => sprintf(
            /* translators: %1$s: Theme name, %2$s: Theme author. */
            __('Proudly powered by WordPress | Theme: %1$s by %2$s.', 'multi-maiven'),
            'Multi Maiven',
            '<a href="#">Your Name</a>'
        ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_copyright_text', array(
        'type'        => 'textarea',
        'label'       => __('Copyright Text', 'multi-maiven'),
        'section'     => 'mm_footer_builder',
        'description' => __('Enter your copyright text or other footer information. HTML is allowed.', 'multi-maiven'),
    ));

    // 4. Footer Top Padding
    $wp_customize->add_setting('mm_footer_padding_top', array(
        'default'           => '30',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_footer_padding_top', array(
        'type'        => 'range',
        'label'       => __('Footer Top Padding (px)', 'multi-maiven'),
        'section'     => 'mm_footer_builder',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // 5. Footer Bottom Padding
    $wp_customize->add_setting('mm_footer_padding_bottom', array(
        'default'           => '30',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_footer_padding_bottom', array(
        'type'        => 'range',
        'label'       => __('Footer Bottom Padding (px)', 'multi-maiven'),
        'section'     => 'mm_footer_builder',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // 6. Show Footer Border
    $wp_customize->add_setting('mm_footer_border', array(
        'default'           => true,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('mm_footer_border', array(
        'type'    => 'checkbox',
        'label'   => __('Show Footer Top Border', 'multi-maiven'),
        'section' => 'mm_footer_builder',
    ));
    
    
    // Bottom Footer Bar Settings
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'mm_bottom_bar_heading', array(
        'type'        => 'hidden',
        'section'     => 'mm_footer_builder',
        'description' => '<h3 style="margin-top:30px;border-bottom:1px solid #ddd;padding-bottom:10px;color:#23282d;">' . __('Bottom Footer Bar', 'multi-maiven') . '</h3>',
        'priority'    => 20,
    )));
    
    // 7. Enable Bottom Footer Bar
    $wp_customize->add_setting('mm_show_bottom_bar', array(
        'default'           => true,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('mm_show_bottom_bar', array(
        'type'    => 'checkbox',
        'label'   => __('Enable Bottom Footer Bar', 'multi-maiven'),
        'section' => 'mm_footer_builder',
    ));
    
    // 8. Reverse Left/Right Layout
    $wp_customize->add_setting('mm_bottom_bar_reverse_layout', array(
        'default'           => false,
        'sanitize_callback' => 'mm_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('mm_bottom_bar_reverse_layout', array(
        'type'    => 'checkbox',
        'label'   => __('Reverse Left/Right Layout', 'multi-maiven'),
        'section' => 'mm_footer_builder',
    ));
    
    // 9. Bottom Footer Bar Background Color
    $wp_customize->add_setting('mm_bottom_bar_bg_color', array(
        'default'           => '#f9f9f9',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_bottom_bar_bg_color', array(
        'label'    => __('Bottom Footer Bar Background Color', 'multi-maiven'),
        'section'  => 'mm_footer_builder',
    )));
    
    // 10. Bottom Footer Bar Text Color
    $wp_customize->add_setting('mm_bottom_bar_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_bottom_bar_text_color', array(
        'label'    => __('Bottom Footer Bar Text Color', 'multi-maiven'),
        'section'  => 'mm_footer_builder',
    )));
    
    // 11. Left Content
    $wp_customize->add_setting('mm_bottom_bar_left', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('mm_bottom_bar_left', array(
        'type'        => 'textarea',
        'label'       => __('Left Content (e.g. Footer Menu)', 'multi-maiven'),
        'section'     => 'mm_footer_builder',
        'description' => __('Enter content for the left side of the bottom footer bar. HTML is allowed. If left empty and a footer menu is set, it will display the footer menu.', 'multi-maiven'),
    ));
    
    // 12. Right Content
    $wp_customize->add_setting('mm_bottom_bar_right', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('mm_bottom_bar_right', array(
        'type'        => 'textarea',
        'label'       => __('Right Content (e.g. Social Icons)', 'multi-maiven'),
        'section'     => 'mm_footer_builder',
        'description' => __('Enter content for the right side of the bottom footer bar. HTML is allowed.', 'multi-maiven'),
    ));
}
add_action('customize_register', 'mm_footer_builder_customize_register');

/**
 * Output footer elements based on customizer settings
 */
function mm_footer_elements() {
    // Apply footer styles
    $footer_bg_color = get_theme_mod('mm_footer_bg_color', '#f8fafc');
    $footer_text_color = get_theme_mod('mm_footer_text_color', '#1e293b');
    $footer_padding_top = get_theme_mod('mm_footer_padding_top', '30');
    $footer_padding_bottom = get_theme_mod('mm_footer_padding_bottom', '30');
    $footer_border = get_theme_mod('mm_footer_border', true);

    // Add inline styles
    add_action('wp_head', 'mm_footer_inline_styles');
}
add_action('after_setup_theme', 'mm_footer_elements');

/**
 * Output footer inline styles
 */
function mm_footer_inline_styles() {
    $footer_bg_color = get_theme_mod('mm_footer_bg_color', '#f8fafc');
    $footer_text_color = get_theme_mod('mm_footer_text_color', '#1e293b');
    $footer_padding_top = get_theme_mod('mm_footer_padding_top', '30');
    $footer_padding_bottom = get_theme_mod('mm_footer_padding_bottom', '30');
    $footer_border = get_theme_mod('mm_footer_border', true);
    
    $border_style = $footer_border ? '1px solid var(--mm-color-border)' : 'none';
    
    ?>
    <style type="text/css">
        .site-footer {
            background-color: <?php echo esc_attr($footer_bg_color); ?>;
            color: <?php echo esc_attr($footer_text_color); ?>;
            padding-top: <?php echo esc_attr($footer_padding_top); ?>px;
            padding-bottom: <?php echo esc_attr($footer_padding_bottom); ?>px;
            border-top: <?php echo esc_attr($border_style); ?>;
        }
        .site-footer a {
            color: <?php echo esc_attr($footer_text_color); ?>;
            text-decoration: underline;
        }
        .site-footer a:hover {
            opacity: 0.8;
        }
    </style>
    <?php
}

/**
 * Enqueue footer builder JavaScript
 */
function mm_footer_builder_scripts() {
    if (is_customize_preview()) {
        $theme = wp_get_theme();
        $version = $theme->get('Version');
        wp_enqueue_script('mm-footer-builder', get_template_directory_uri() . '/js/footer-builder.js', array('customize-preview', 'jquery'), $version, true);
    }
}
add_action('customize_preview_init', 'mm_footer_builder_scripts');
