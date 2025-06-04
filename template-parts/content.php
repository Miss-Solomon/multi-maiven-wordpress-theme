<?php
/**
 * Template part for displaying posts
 *
 * @package Multi_Maiven
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

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

    <?php if (has_post_thumbnail() && !is_singular()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail('medium', array('class' => 'featured-image')); ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="mm-button read-more">
                <?php esc_html_e('Read More', 'multi-maiven'); ?>
            </a>
        <?php endif; ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php mm_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
