<?php
/**
 * Custom template tags for this theme
 *
 * @package Multi_Maiven
 */

if (!function_exists('mm_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function mm_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'multi-maiven'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
    }
endif;

if (!function_exists('mm_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function mm_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'multi-maiven'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
    }
endif;

if (!function_exists('mm_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function mm_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'multi-maiven'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'multi-maiven') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'multi-maiven'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'multi-maiven') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'multi-maiven'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'multi-maiven'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('mm_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     */
    function mm_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

/**
 * Custom breadcrumb function
 */
if (!function_exists('mm_breadcrumb')) :
    function mm_breadcrumb() {
        if (is_front_page()) {
            return;
        }

        $breadcrumb = '<nav class="breadcrumb" aria-label="' . esc_attr__('Breadcrumb', 'multi-maiven') . '">';
        $breadcrumb .= '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'multi-maiven') . '</a>';

        if (is_category() || is_single()) {
            $breadcrumb .= ' &raquo; ';
            if (is_single()) {
                $category = get_the_category();
                if ($category) {
                    $breadcrumb .= '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>';
                    $breadcrumb .= ' &raquo; ';
                }
                $breadcrumb .= '<span>' . get_the_title() . '</span>';
            } else {
                $breadcrumb .= '<span>' . single_cat_title('', false) . '</span>';
            }
        } elseif (is_page()) {
            $breadcrumb .= ' &raquo; <span>' . get_the_title() . '</span>';
        } elseif (is_search()) {
            $breadcrumb .= ' &raquo; <span>' . sprintf(esc_html__('Search Results for "%s"', 'multi-maiven'), get_search_query()) . '</span>';
        } elseif (is_tag()) {
            $breadcrumb .= ' &raquo; <span>' . single_tag_title('', false) . '</span>';
        } elseif (is_archive()) {
            $breadcrumb .= ' &raquo; <span>' . wp_title('', false) . '</span>';
        }

        $breadcrumb .= '</nav>';

        return $breadcrumb;
    }
endif;

/**
 * Custom pagination function
 */
if (!function_exists('mm_pagination')) :
    function mm_pagination() {
        global $wp_query;

        if ($wp_query->max_num_pages <= 1) {
            return;
        }

        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $max   = intval($wp_query->max_num_pages);

        if ($paged >= 1) {
            $links[] = $paged;
        }

        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<nav class="pagination" aria-label="' . esc_attr__('Posts navigation', 'multi-maiven') . '">';

        if (get_previous_posts_link()) {
            printf('<div class="nav-previous">%s</div>', get_previous_posts_link(esc_html__('&laquo; Newer Posts', 'multi-maiven')));
        }

        if (get_next_posts_link()) {
            printf('<div class="nav-next">%s</div>', get_next_posts_link(esc_html__('Older Posts &raquo;', 'multi-maiven')));
        }

        echo '</nav>';
    }
endif;

/**
 * Estimated reading time
 */
if (!function_exists('mm_estimated_reading_time')) :
    function mm_estimated_reading_time() {
        $content = get_post_field('post_content', get_the_ID());
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Average reading speed

        if ($reading_time == 1) {
            $timer = " minute";
        } else {
            $timer = " minutes";
        }
        $totalreadingtime = $reading_time . $timer;

        return $totalreadingtime;
    }
endif;
