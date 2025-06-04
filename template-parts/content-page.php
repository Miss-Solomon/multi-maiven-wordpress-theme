<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Multi_Maiven
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'multi-maiven'),
                'after'  => '</div>',
            )
        );
        ?>
    </div><!-- .entry-content -->

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <span class="edit-link">
                <?php
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
                    )
                );
                ?>
            </span>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
