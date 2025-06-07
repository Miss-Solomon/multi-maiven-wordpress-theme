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
        
        <div class="footer-menus-container mm-container">
            <div class="footer-left-menu">
                <?php mm_display_vertical_footer_menu('footer-left', '', 'footer-left-nav'); ?>
            </div>
            
            <div class="footer-ad-container">
                <?php 
                // Display responsive footer ad
                mm_display_responsive_ad( 'footer' );
                ?>
            </div>
            
            <div class="footer-right-menu">
                <?php mm_display_vertical_footer_menu('footer-right', '', 'footer-right-nav'); ?>
            </div>
        </div>
        
        <?php 
        // Include the bottom footer bar
        get_template_part('template-parts/footer/footer-bottom');
        ?>
        
        <?php do_action('mm_footer_inside_after'); ?>
    </footer><!-- #colophon -->

    <?php do_action('mm_footer_after'); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
