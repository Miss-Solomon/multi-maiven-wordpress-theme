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
            'footer-menu' => esc_html__('Footer Menu', 'multi-maiven'),
            'header-left' => esc_html__('Header Left', 'multi-maiven'), // New left header menu
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
    
    // Remove query strings from static resources
    function mm_remove_script_version($src) {
        $parts = explode('?ver', $src);
        return $parts[0];
    }
    add_filter('script_loader_src', 'mm_remove_script_version', 15, 1);
    add_filter('style_loader_src', 'mm_remove_script_version', 15, 1);
    
    // Remove WordPress version from RSS
    add_filter('the_generator', '__return_empty_string');
    
    // Remove WordPress version from scripts and styles
    function mm_remove_wp_version_strings($src) {
        global $wp_version;
        parse_str(parse_url($src, PHP_URL_QUERY), $query);
        if (!empty($query['ver']) && $query['ver'] === $wp_version) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('script_loader_src', 'mm_remove_wp_version_strings');
    add_filter('style_loader_src', 'mm_remove_wp_version_strings');
}
add_action('init', 'mm_optimize_wordpress');

/**
 * Add preload for critical resources
 */
function mm_add_preload_tags() {
    // Preload main stylesheet
    echo '<link rel="preload" href="' . get_stylesheet_uri() . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    
    // Preload navigation script
    echo '<link rel="preload" href="' . get_template_directory_uri() . '/js/navigation.js" as="script">';
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

    $wp_customize->add_setting( 'header_ad_code', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'header_ad_code', array(
        'label'   => __( 'Ad Code for Header', 'multi-maiven' ),
        'section' => 'header_ad_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( 'footer_ad_code', array(
        'default'   => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footer_ad_code', array(
        'label'   => __( 'Ad Code for Footer', 'multi-maiven' ),
        'section' => 'header_ad_section',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'mm_customize_advertising_register' );

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
function mm_customize_register( $wp_customize ) {
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
add_action( 'customize_register', 'mm_customize_register' );
