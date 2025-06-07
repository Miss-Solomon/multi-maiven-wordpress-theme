<?php
$show_bottom_bar = get_theme_mod('mm_show_bottom_bar', true);
$reverse = get_theme_mod('mm_bottom_bar_reverse_layout', false);

if (!$show_bottom_bar) return;

$bottom_left   = do_shortcode(get_theme_mod('mm_bottom_bar_left', ''));
$bottom_right  = do_shortcode(get_theme_mod('mm_bottom_bar_right', ''));

// Get copyright text for center content
$copyright_text = get_theme_mod('mm_copyright_text', 
    sprintf(
        /* translators: %1$s: Theme name, %2$s: Theme author. */
        __('Proudly powered by WordPress | Theme: %1$s by %2$s.', 'multi-maiven'),
        'Multi Maiven',
        '<a href="#">Your Name</a>'
    )
);

$bottom_bar_bg_color = get_theme_mod('mm_bottom_bar_bg_color', '#f9f9f9');
$bottom_bar_text_color = get_theme_mod('mm_bottom_bar_text_color', '#333333');

// Display footer left menu in the left area if no custom content is set
if (empty($bottom_left) && has_nav_menu('footer-left')) {
    ob_start();
    wp_nav_menu(array(
        'theme_location' => 'footer-left',
        'menu_class'     => 'bottom-footer-menu',
        'container'      => 'nav',
        'container_class' => 'footer-navigation-vertical',
        'depth'          => 1,
        'fallback_cb'    => false,
    ));
    $bottom_left = ob_get_clean();
}
?>
<?php if ($bottom_bar_bg_color || $bottom_bar_text_color): ?>
<style type="text/css">
.bottom-footer-bar {
<?php if ($bottom_bar_bg_color): ?>
  background: <?php echo esc_attr($bottom_bar_bg_color); ?>;
<?php endif; ?>
<?php if ($bottom_bar_text_color): ?>
  color: <?php echo esc_attr($bottom_bar_text_color); ?>;
<?php endif; ?>
}
.bottom-footer-bar a {
<?php if ($bottom_bar_text_color): ?>
  color: <?php echo esc_attr($bottom_bar_text_color); ?>;
<?php endif; ?>
}
</style>
<?php endif; ?>

<div class="bottom-footer-bar<?php echo $reverse ? ' reverse-layout' : ''; ?>">
  <div class="container">
    <div class="bottom-footer-inner">
      <div class="bottom-footer-left"><?php echo $bottom_left; ?></div>
      <div class="bottom-footer-center"><?php echo wp_kses_post($copyright_text); ?></div>
      <div class="bottom-footer-right"><?php echo $bottom_right; ?></div>
    </div>
  </div>
</div>
