<?php
/**
 * Multi Maiven functions and definitions
 *
 * @package Multi_Maiven
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mm_setup() {
    /*
     * Make theme available for translation.
     */
    load_theme_textdomain('multi-maiven', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menus() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'multi-maiven'),
            'footer-left' => esc_html__('Footer Left', 'multi-maiven'),
            'footer-right' => esc_html__('Footer Right', 'multi-maiven'),
            'header-left' => esc_html__('Header Left', 'multi-maiven'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'mm_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Enqueue editor styles.
    add_editor_style('style-editor.css');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Remove support for block templates.
    remove_theme_support('block-templates');
}
add_action('after_setup_theme', 'mm_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function mm_content_width() {
    $GLOBALS['content_width'] = apply_filters('mm_content_width', 640);
}
add_action('after_setup_theme', 'mm_content_width', 0);

/**
 * Register widget area.
 */
function mm_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'multi-maiven'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'multi-maiven'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Footer Area', 'multi-maiven'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'multi-maiven'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'mm_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function mm_scripts() {
    wp_enqueue_style('mm-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('mm-style', 'rtl', 'replace');

    wp_enqueue_script('mm-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    
    // Enqueue responsive ads script
    wp_enqueue_script('mm-responsive-ads', get_template_directory_uri() . '/js/responsive-ads.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Enqueue customizer scripts only in customizer
    if (is_customize_preview()) {
        wp_enqueue_script('mm-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'mm_scripts');

// Enqueue Font Awesome Free
function mm_enqueue_fontawesome() {
    wp_enqueue_style('fontawesome-free', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'mm_enqueue_fontawesome');

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Include theme customizer functionality.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Include template tags.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Include theme hooks.
 */
require get_template_directory() . '/inc/theme-hooks.php';

/**
 * Include header builder functionality.
 */
require get_template_directory() . '/inc/header-builder.php';

/**
 * Include footer builder functionality.
 */
require get_template_directory() . '/inc/footer-builder.php';

/**
 * Reorder Customizer Sections
 */
function mm_reorder_customizer_sections($wp_customize) {
    // Set priorities for sections in the order specified
    // 1. Site Identity (already exists with default priority)
    $wp_customize->get_section('title_tagline')->priority = 10;
    
    // 2. Homepage Settings
    if ($wp_customize->get_section('static_front_page')) {
        $wp_customize->get_section('static_front_page')->priority = 20;
    }
    
    // 3. Header Builder
    if ($wp_customize->get_section('mm_header_builder')) {
        $wp_customize->get_section('mm_header_builder')->priority = 30;
    }
    
    // 4. Footer Builder
    if ($wp_customize->get_section('mm_footer_builder')) {
        $wp_customize->get_section('mm_footer_builder')->priority = 40;
    }
    
    // 5. Colors
    if ($wp_customize->get_section('colors')) {
        $wp_customize->get_section('colors')->priority = 50;
    }
    if ($wp_customize->get_section('mm_colors')) {
        $wp_customize->get_section('mm_colors')->priority = 51;
    }
    
    // 6. Typography
    if ($wp_customize->get_section('mm_typography')) {
        $wp_customize->get_section('mm_typography')->priority = 60;
    }
    
    // 7. Background Image
    if ($wp_customize->get_section('background_image')) {
        $wp_customize->get_section('background_image')->priority = 70;
    }
    
    // 8. Layout Options
    if ($wp_customize->get_section('mm_layout')) {
        $wp_customize->get_section('mm_layout')->priority = 80;
    }
    
    // 9. Menus (already exists with default priority)
    if ($wp_customize->get_panel('nav_menus')) {
        $wp_customize->get_panel('nav_menus')->priority = 90;
    }
    
    // 10. Widgets (already exists with default priority)
    if ($wp_customize->get_panel('widgets')) {
        $wp_customize->get_panel('widgets')->priority = 100;
    }
    
    // 11. Advertisements
    if ($wp_customize->get_section('header_ad_section')) {
        $wp_customize->get_section('header_ad_section')->priority = 110;
    }
    
    // 12. Additional CSS (already exists with default priority)
    if ($wp_customize->get_section('custom_css')) {
        $wp_customize->get_section('custom_css')->priority = 120;
    }
}
add_action('customize_register', 'mm_reorder_customizer_sections', 999); // High priority to run after all sections are registered

/**
 * Custom template tags for this theme.
 */
function mm_fallback_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'multi-maiven') . '</a></li>';
    
    // Add sample pages if they exist
    $pages = get_pages(array('number' => 5));
    foreach ($pages as $page) {
        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */

/**
 * Adds custom classes to the array of body classes.
 */
function mm_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'mm_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mm_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'mm_pingback_header');

/**
 * Remove jQuery migrate
 */
function mm_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'mm_remove_jquery_migrate');

/**
 * Optimize WordPress for better performance
 */
function mm_optimize_wordpress() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove WordPress version from RSS
    add_filter('the_generator', '__return_empty_string');
}
add_action('init', 'mm_optimize_wordpress');

/**
 * Add preload for critical resources
 */
function mm_add_preload_tags() {
    // Preload main stylesheet
    printf(
        '<link rel="preload" href="%s" as="style">',
        esc_url(get_stylesheet_uri())
    );
    
    // Preload navigation script
    printf(
        '<link rel="preload" href="%s" as="script">',
        esc_url(get_template_directory_uri() . '/js/navigation.js')
    );
}
add_action('wp_head', 'mm_add_preload_tags', 1);

/**
 * Add support for custom color palette
 */
function mm_add_editor_color_palette() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary', 'multi-maiven'),
            'slug'  => 'primary',
            'color' => '#2563eb',
        ),
        array(
            'name'  => esc_html__('Secondary', 'multi-maiven'),
            'slug'  => 'secondary',
            'color' => '#64748b',
        ),
        array(
            'name'  => esc_html__('Dark', 'multi-maiven'),
            'slug'  => 'dark',
            'color' => '#1e293b',
        ),
        array(
            'name'  => esc_html__('Light', 'multi-maiven'),
            'slug'  => 'light',
            'color' => '#f8fafc',
        ),
    ));
}
add_action('after_setup_theme', 'mm_add_editor_color_palette');

/**
 * Add Advertising controls to the Customizer (Header and Footer Ads)
 */
function mm_customize_advertising_register( $wp_customize ) {
    $wp_customize->add_section( 'header_ad_section', array(
        'title'    => __( 'Advertisements', 'multi-maiven' ),
        'priority' => 30,
    ) );

    // Header Ad Settings
    $wp_customize->add_setting( 'header_ad_code_desktop', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'header_ad_code_desktop', array(
        'label'       => __( 'Header Ad Code (Desktop - 728x90)', 'multi-maiven' ),
        'description' => __( 'Ad code for desktop devices (728x90 recommended)', 'multi-maiven' ),
        'section'     => 'header_ad_section',
        'type'        => 'textarea',
    ) );

    $wp_customize->add_setting( 'header_ad_code_mobile', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'header_ad_code_mobile', array(
        'label'       => __( 'Header Ad Code (Mobile - 320x100)', 'multi-maiven' ),
        'description' => __( 'Ad code for mobile devices (320x100 recommended)', 'multi-maiven' ),
        'section'     => 'header_ad_section',
        'type'        => 'textarea',
    ) );

    // Footer Ad Settings
    $wp_customize->add_setting( 'footer_ad_code_desktop', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footer_ad_code_desktop', array(
        'label'       => __( 'Footer Ad Code (Desktop - 728x90)', 'multi-maiven' ),
        'description' => __( 'Ad code for desktop devices (728x90 recommended)', 'multi-maiven' ),
        'section'     => 'header_ad_section',
        'type'        => 'textarea',
    ) );

    $wp_customize->add_setting( 'footer_ad_code_mobile', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footer_ad_code_mobile', array(
        'label'       => __( 'Footer Ad Code (Mobile - 320x100)', 'multi-maiven' ),
        'description' => __( 'Ad code for mobile devices (320x100 recommended)', 'multi-maiven' ),
        'section'     => 'header_ad_section',
        'type'        => 'textarea',
    ) );
}
add_action( 'customize_register', 'mm_customize_advertising_register' );

/**
 * Display responsive banner ads with different sizes for desktop and mobile
 * 
 * @param string $location The location of the ad (header or footer)
 * @return void
 */
function mm_display_responsive_ad( $location = 'header' ) {
    // Get ad codes for desktop and mobile
    $desktop_ad = get_theme_mod( $location . '_ad_code_desktop', '' );
    $mobile_ad = get_theme_mod( $location . '_ad_code_mobile', '' );
    
    // If no ads are set, return early (container won't be displayed)
    if ( empty( $desktop_ad ) && empty( $mobile_ad ) ) {
        return;
    }
    
    // Container class
    $container_class = 'responsive-' . $location . '-ad';
    
    // Start output buffer
    ob_start();
    ?>
    <div class="<?php echo esc_attr( $container_class ); ?>">
        <?php if ( ! empty( $desktop_ad ) ) : ?>
            <div class="desktop-ad">
                <?php echo wp_kses_post( $desktop_ad ); ?>
            </div>
        <?php endif; ?>
        
        <?php if ( ! empty( $mobile_ad ) ) : ?>
            <div class="mobile-ad">
                <?php echo wp_kses_post( $mobile_ad ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    
    // Return the output buffer
    echo ob_get_clean();
}

// Top Bar Shortcodes
function mm_topbar_login_link() {
    if (is_user_logged_in()) {
        return '<a href="' . esc_url(wp_logout_url(home_url())) . '"><i class="fas fa-sign-out-alt"></i> Log Out</a>';
    } else {
        return '<a href="' . esc_url(wp_login_url()) . '"><i class="fas fa-sign-in-alt"></i> Log In</a>';
    }
}
add_shortcode('login_link', 'mm_topbar_login_link');

function mm_logged_in_only($atts, $content = null) {
    return is_user_logged_in() ? do_shortcode($content) : '';
}
add_shortcode('if_logged_in', 'mm_logged_in_only');

function mm_logged_out_only($atts, $content = null) {
    return !is_user_logged_in() ? do_shortcode($content) : '';
}
add_shortcode('if_logged_out', 'mm_logged_out_only');

add_action('admin_menu', function() {
    global $submenu;
    if (!empty($submenu['themes.php'])) {
        foreach ($submenu['themes.php'] as $index => $item) {
            // Check if the menu label is "Header"
            if (isset($item[0]) && strtolower(trim(strip_tags($item[0]))) === 'header') {
                unset($submenu['themes.php'][$index]);
            }
        }
        // Re-index the array to avoid menu gaps
        $submenu['themes.php'] = array_values($submenu['themes.php']);
    }
}, PHP_INT_MAX);

// Link Color Customizer Settings
function mm_customize_link_colors( $wp_customize ) {
    // Link Color
    $wp_customize->add_setting('mm_link_color', array(
        'default'           => '#2563eb', // Set your default
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
        'default'           => '#1e40af', // Set your default
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mm_link_hover_color', array(
        'label'    => __('Link Hover Color', 'multi-maiven'),
        'section'  => 'colors',
        'settings' => 'mm_link_hover_color',
    )));
}
add_action( 'customize_register', 'mm_customize_link_colors' );

/**
 * Display a horizontal footer menu
 * 
 * @param string $theme_location The menu location to display
 * @param string $menu_class Additional CSS classes for the menu
 * @param string $container_class Additional CSS classes for the container
 * @return void
 */
function mm_display_horizontal_footer_menu($theme_location = 'footer-left', $menu_class = '', $container_class = '') {
    if (!has_nav_menu($theme_location)) {
        return;
    }
    
    $menu_class = 'footer-menu-horizontal ' . $menu_class;
    $container_class = 'footer-navigation-horizontal ' . $container_class;
    
    wp_nav_menu(array(
        'theme_location' => $theme_location,
        'menu_class'     => $menu_class,
        'container'      => 'nav',
        'container_class' => $container_class,
        'depth'          => 1,
        'fallback_cb'    => false,
    ));
}

/**
 * Display a vertical footer menu
 * 
 * @param string $theme_location The menu location to display
 * @param string $menu_class Additional CSS classes for the menu
 * @param string $container_class Additional CSS classes for the container
 * @return void
 */
function mm_display_vertical_footer_menu($theme_location = 'footer-left', $menu_class = '', $container_class = '') {
    if (!has_nav_menu($theme_location)) {
        return;
    }
    
    $menu_class = 'footer-menu-vertical ' . $menu_class;
    $container_class = 'footer-navigation-vertical ' . $container_class;
    
    wp_nav_menu(array(
        'theme_location' => $theme_location,
        'menu_class'     => $menu_class,
        'container'      => 'nav',
        'container_class' => $container_class,
        'depth'          => 1,
        'fallback_cb'    => false,
    ));
}
