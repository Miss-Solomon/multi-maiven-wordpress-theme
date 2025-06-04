<?php
/**
 * The template for displaying all single posts
 *
 * @package Multi_Maiven
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="mm-container">
        <div class="content-area <?php echo is_active_sidebar('sidebar-1') ? 'has-sidebar' : ''; ?>">
            <div class="main-content">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                        <header class="entry-header">
                            <?php
                            the_title('<h1 class="entry-title">', '</h1>');

                            if ('post' === get_post_type()) :
                                ?>
                                <div class="entry-meta">
                                    <?php
                                    mm_posted_on();
                                    mm_posted_by();
                                    ?>
                                </div><!-- .entry-meta -->
                            <?php endif; ?>
                        </header><!-- .entry-header -->

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large'); ?>
                            </div><!-- .post-thumbnail -->
                        <?php endif; ?>

                        <div class="entry-content">
                            <?php
                            the_content(
                                sprintf(
                                    wp_kses(
                                        /* translators: %s: Name of current post. Only visible to screen readers */
                                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'multi-maiven'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post(get_the_title())
                                )
                            );

                            wp_link_pages(
                                array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'multi-maiven'),
                                    'after'  => '</div>',
                                )
                            );
                            ?>
                        </div><!-- .entry-content -->

                        <footer class="entry-footer">
                            <?php mm_entry_footer(); ?>
                        </footer><!-- .entry-footer -->
                    </article><!-- #post-<?php the_ID(); ?> -->

                    <?php
                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'multi-maiven') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'multi-maiven') . '</span> <span class="nav-title">%title</span>',
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
                ?>
            </div><!-- .main-content -->

            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside><!-- #secondary -->
            <?php endif; ?>
        </div><!-- .content-area -->
    </div><!-- .mm-container -->
</main><!-- #primary -->

<?php
get_footer();
