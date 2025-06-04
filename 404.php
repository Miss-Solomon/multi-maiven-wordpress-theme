<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Multi_Maiven
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="mm-container">
        <div class="content-area">
            <div class="main-content">
                <section class="error-404 not-found entry">
                    <header class="page-header entry-header">
                        <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'multi-maiven'); ?></h1>
                    </header><!-- .page-header -->

                    <div class="page-content entry-content">
                        <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'multi-maiven'); ?></p>

                        <?php get_search_form(); ?>

                        <div class="widget-area">
                            <div class="widget">
                                <h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'multi-maiven'); ?></h2>
                                <ul>
                                    <?php
                                    wp_list_categories(
                                        array(
                                            'orderby'    => 'count',
                                            'order'      => 'DESC',
                                            'show_count' => 1,
                                            'title_li'   => '',
                                            'number'     => 10,
                                        )
                                    );
                                    ?>
                                </ul>
                            </div><!-- .widget -->

                            <?php
                            /* translators: %1$s: smiley */
                            $mm_archive_content = '<p>' . sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'multi-maiven'), convert_smilies(':)')) . '</p>';
                            the_widget('WP_Widget_Archives', 'dropdown=1', "before_title=<h2 class='widget-title'>&after_title=</h2>&before_widget=<div class='widget'>&after_widget=</div>&");

                            the_widget('WP_Widget_Tag_Cloud');
                            ?>
                        </div><!-- .widget-area -->
                    </div><!-- .page-content -->
                </section><!-- .error-404 -->
            </div><!-- .main-content -->
        </div><!-- .content-area -->
    </div><!-- .mm-container -->
</main><!-- #primary -->

<?php
get_footer();
