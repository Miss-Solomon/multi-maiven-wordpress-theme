<?php
/**
 * Theme hooks and filters
 *
 * @package Multi_Maiven
 */

/**
 * Header hooks
 */
if (!function_exists('mm_header_before')) :
    function mm_header_before() {
        do_action('mm_header_before');
    }
endif;

if (!function_exists('mm_header_after')) :
    function mm_header_after() {
        do_action('mm_header_after');
    }
endif;

if (!function_exists('mm_header_inside_before')) :
    function mm_header_inside_before() {
        do_action('mm_header_inside_before');
    }
endif;

if (!function_exists('mm_header_inside_after')) :
    function mm_header_inside_after() {
        do_action('mm_header_inside_after');
    }
endif;

/**
 * Content hooks
 */
if (!function_exists('mm_content_before')) :
    function mm_content_before() {
        do_action('mm_content_before');
    }
endif;

if (!function_exists('mm_content_after')) :
    function mm_content_after() {
        do_action('mm_content_after');
    }
endif;

if (!function_exists('mm_entry_before')) :
    function mm_entry_before() {
        do_action('mm_entry_before');
    }
endif;

if (!function_exists('mm_entry_after')) :
    function mm_entry_after() {
        do_action('mm_entry_after');
    }
endif;

/**
 * Footer hooks
 */
if (!function_exists('mm_footer_before')) :
    function mm_footer_before() {
        do_action('mm_footer_before');
    }
endif;

if (!function_exists('mm_footer_after')) :
    function mm_footer_after() {
        do_action('mm_footer_after');
    }
endif;

if (!function_exists('mm_footer_inside_before')) :
    function mm_footer_inside_before() {
        do_action('mm_footer_inside_before');
    }
endif;

if (!function_exists('mm_footer_inside_after')) :
    function mm_footer_inside_after() {
        do_action('mm_footer_inside_after');
    }
endif;

/**
 * Add custom body classes
 */
function mm_custom_body_classes($classes) {
    // Add sticky header class
    if (get_theme_mod('mm_sticky_header', false)) {
        $classes[] = 'sticky-header';
    }

    // Add sidebar position class
    $sidebar_position = get_theme_mod('mm_sidebar_position', 'right');
    if ($sidebar_position !== 'none') {
        $classes[] = 'sidebar-' . $sidebar_position;
    }

    return $classes;
}
add_filter('body_class', 'mm_custom_body_classes');

/**
 * Add schema markup to various elements
 */
function mm_add_schema_markup() {
    if (is_single()) {
        add_filter('the_content', 'mm_add_article_schema');
    }
}
add_action('wp_head', 'mm_add_schema_markup');

/**
 * Add article schema markup
 */
function mm_add_article_schema($content) {
    if (is_single() && in_the_loop() && is_main_query()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name')
            )
        );

        if (has_post_thumbnail()) {
            $schema['image'] = wp_get_attachment_image_url(get_post_thumbnail_id(), 'full');
        }

        $content = '<script type="application/ld+json">' . json_encode($schema) . '</script>' . $content;
    }

    return $content;
}

/**
 * Enhance WordPress search
 */
function mm_search_filter($query) {
    if ($query->is_search() && $query->is_main_query() && !is_admin()) {
        $query->set('post_type', array('post', 'page'));
    }
    return $query;
}
add_filter('pre_get_posts', 'mm_search_filter');

/**
 * Add custom excerpt length
 */
function mm_custom_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mm_custom_excerpt_length', 999);

/**
 * Custom excerpt more
 */
function mm_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mm_custom_excerpt_more');

/**
 * Add custom image sizes
 */
function mm_add_image_sizes() {
    add_image_size('mm-featured', 800, 450, true);
    add_image_size('mm-thumbnail', 300, 200, true);
    add_image_size('mm-large', 1200, 675, true);
}
add_action('after_setup_theme', 'mm_add_image_sizes');

/**
 * Add image size names to media library
 */
function mm_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'mm-featured' => __('Featured Image', 'multi-maiven'),
        'mm-thumbnail' => __('Small Thumbnail', 'multi-maiven'),
        'mm-large' => __('Large Featured', 'multi-maiven'),
    ));
}
add_filter('image_size_names_choose', 'mm_custom_image_sizes');
