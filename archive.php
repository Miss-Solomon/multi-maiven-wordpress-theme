<?php
/**
 * The template for displaying archive pages
 *
 * @package Multi_Maiven
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="mm-container">
        <div class="content-area <?php echo is_active_sidebar('sidebar-1') ? 'has-sidebar' : ''; ?>">
            <div class="main-content">
                <?php if (have_posts()) : ?>
                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="archive-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                    <?php
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;

                    the_posts_navigation();

                else :
                    get_template_part('template-parts/content', 'none');
                endif;
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
