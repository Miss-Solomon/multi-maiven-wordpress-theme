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
        
        <?php 
        // Display responsive footer ad
        mm_display_responsive_ad( 'footer' );
        ?>
        
        <div class="footer-content mm-container">
            <div class="site-info">
                <?php
                // Display the copyright text from customizer or fallback to default
                $copyright_text = get_theme_mod('mm_copyright_text', 
                    sprintf(
                        /* translators: %1$s: Theme name, %2$s: Theme author. */
                        __('Proudly powered by WordPress | Theme: %1$s by %2$s.', 'multi-maiven'),
                        'Multi Maiven',
                        '<a href="#">Your Name</a>'
                    )
                );
                echo wp_kses_post($copyright_text);
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
