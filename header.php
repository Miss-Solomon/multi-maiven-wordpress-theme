<?php
/**
 * The header for our theme
 *
 * @package Multi_Maiven
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'multi-maiven'); ?></a>

	<?php do_action('mm_header_before'); ?>

	<?php
	if ( get_theme_mod( 'show_top_bar', true ) ) {
	    get_template_part( 'template-parts/header/header', 'top' );
	}
	?>

	<?php
		// Get Customizer Settings
		$header_layout = get_theme_mod('mm_header_layout', 'default');
		$logo_position = get_theme_mod('mm_logo_position', 'left');
	?>

	<header id="masthead" class="site-header layout-<?php echo esc_attr($header_layout); ?> logo-<?php echo esc_attr($logo_position); ?>">
		<?php do_action('mm_header_inside_before'); ?>

		<div class="header-container mm-container">
		<?php if ($header_layout === 'split') : ?>
		    <nav class="main-navigation main-navigation-left">
		        <?php
		        $left_menu_id = get_theme_mod('mm_left_menu');
		        if ($left_menu_id) {
		            wp_nav_menu(array(
		                'menu'           => $left_menu_id,
		                'menu_id'        => 'header-left-menu',
		                'container'      => false,
		                'theme_location' => '',
		                'fallback_cb'    => false,
		            ));
		        } else {
		            wp_nav_menu(array(
		                'theme_location' => 'header-left',
		                'menu_id'        => 'header-left-menu',
		                'fallback_cb'    => false,
		            ));
		        }
		        ?>
		    </nav>
		    <div class="site-branding">
		        <?php
		        the_custom_logo();
		        if (is_front_page() && is_home()) :
		            ?>
		            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
		        <?php
		        else :
		            ?>
		            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
		        <?php
		        endif;
		        $description = get_bloginfo('description', 'display');
		        if ($description || is_customize_preview()) :
		            ?>
		            <p class="site-description"><?php echo esc_html($description); ?></p>
		        <?php endif; ?>
		    </div>
		    <nav class="main-navigation main-navigation-right">
		        <?php
		        wp_nav_menu(array(
		            'theme_location' => 'menu-1',
		            'menu_id'        => 'primary-menu',
		            'fallback_cb'    => false,
		        ));
		        ?>
		    </nav>
		<?php else : ?>
		    <div class="site-branding">
		        <?php
		        the_custom_logo();
		        if (is_front_page() && is_home()) :
		            ?>
		            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
		        <?php
		        else :
		            ?>
		            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
		        <?php
		        endif;
		        $description = get_bloginfo('description', 'display');
		        if ($description || is_customize_preview()) :
		            ?>
		            <p class="site-description"><?php echo esc_html($description); ?></p>
		        <?php endif; ?>
		    </div><!-- .site-branding -->
		    <nav id="site-navigation" class="main-navigation">
		        <?php
		        wp_nav_menu(array(
		            'theme_location' => 'menu-1',
		            'menu_id'        => 'primary-menu',
		        ));
		        ?>
		    </nav><!-- #site-navigation -->
		<?php endif; ?>
		</div>

		<?php 
		// Display responsive header ad
		mm_display_responsive_ad( 'header' );
		?>

		<?php do_action('mm_header_inside_after'); ?>
	</header>

	<?php do_action('mm_header_after'); ?>
