<?php
/**
 * The template for displaying the footer
 *
 * @package Multi_Maiven
 */

?>

    <?php do_action('mm_footer_before'); ?>

    <footer id="colophon" class="site-footer">
        <?php do_action('mm_footer_inside_before'); ?>
        
        <?php if ( get_theme_mod( 'footer_ad_code' ) ) : ?>
            <div class="responsive-footer-ad responsive-header-ad">
                <div class="ad-desktop">
                    <?php echo get_theme_mod( 'footer_ad_code' ); ?>
                </div>
                <div class="ad-mobile">
                    <?php echo get_theme_mod( 'footer_ad_code' ); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="footer-content mm-container">
            <div class="site-info">
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'multi-maiven')); ?>">
                    <?php
                    /* translators: %s: CMS name, i.e. WordPress. */
                    printf(esc_html__('Proudly powered by %s', 'multi-maiven'), 'WordPress');
                    ?>
                </a>
                <span class="sep"> | </span>
                <?php
                /* translators: 1: Theme name, 2: Theme author. */
                printf(esc_html__('Theme: %1$s by %2$s.', 'multi-maiven'), 'Multi Maiven', '<a href="#">Your Name</a>');
                ?>
            </div><!-- .site-info -->
        </div><!-- .footer-content -->
        
        <?php do_action('mm_footer_inside_after'); ?>
    </footer><!-- #colophon -->

    <?php do_action('mm_footer_after'); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
