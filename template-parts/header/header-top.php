<?php
$show_top_bar = get_theme_mod('show_top_bar', true);
$only_for_users = get_theme_mod('top_bar_logged_in_only', false);
$reverse = get_theme_mod('top_bar_reverse_layout', false);

if (!$show_top_bar || ($only_for_users && !is_user_logged_in())) return;

$top_left   = do_shortcode(get_theme_mod('top_bar_left', ''));
$top_center = do_shortcode(get_theme_mod('top_bar_center', ''));
$top_right  = do_shortcode(get_theme_mod('top_bar_right', ''));

$top_bar_bg_color = get_theme_mod('top_bar_bg_color', '#f9f9f9');
$top_bar_text_color = get_theme_mod('top_bar_text_color', '#333333');

// Content variables are no longer swapped here
// The reverse layout is handled by CSS using the flexbox order property
?>
<?php if ($top_bar_bg_color || $top_bar_text_color): ?>
<style type="text/css">
.top-header-bar {
<?php if ($top_bar_bg_color): ?>
  background: <?php echo esc_attr($top_bar_bg_color); ?>;
<?php endif; ?>
<?php if ($top_bar_text_color): ?>
  color: <?php echo esc_attr($top_bar_text_color); ?>;
<?php endif; ?>
}
.top-header-bar a {
<?php if ($top_bar_text_color): ?>
  color: <?php echo esc_attr($top_bar_text_color); ?>;
<?php endif; ?>
}
</style>
<?php endif; ?>

<div class="top-header-bar<?php echo $reverse ? ' reverse-layout' : ''; ?>">
  <div class="container">
    <div class="top-header-inner">
      <div class="top-header-left"><?php echo $top_left; ?></div>
      <div class="top-header-center"><?php echo $top_center; ?></div>
      <div class="top-header-right"><?php echo $top_right; ?></div>
    </div>
  </div>
</div>
