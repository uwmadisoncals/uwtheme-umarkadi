<?php
/**
 * The header for the theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UW Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	
	<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'')})(document.documentElement)</script>

	<?php
		// get theme mods
	  $uwmadison_title_style = get_theme_mod('uwmadison_main_title_color','uw-red-title');
		$uwmadison_header_style = get_theme_mod('uwmadison_header_style','uw-white-top-bar');
	?>
</head>

<body <?php body_class(); ?>>
	<a class="show-on-focus" href="#main" id="skip-link">Skip to main content</a>
	<div class="uw-global-bar <?php echo ($uwmadison_header_style == "uw-white-top-bar") ? "uw-global-bar-inverse" : "" ?>">
		<a class="uw-global-name-link" href="http://www.wisc.edu">U<span>niversity <span class="uw-of">of</span> </span>W<span>isconsin</span>–Madison</a>
	</div>
	<header class="uw-header <?php echo (site_uses_search()) ? "uw-has-search" : ""; ?>">
		<div class="uw-header-container">
			<div class="uw-header-crest-title">
				<?php get_template_part('content-parts/page-elements/header', 'crest'); ?>
				<div class="uw-title-tagline">
					<?php $title_tag = is_front_page() ? "h1" : "div"; ?>
					<<?php echo $title_tag; ?> id="site-title" class="uw-site-title <?php echo $uwmadison_title_style;?> ">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo get_bloginfo( 'name' ); ?></a>
					</<?php echo $title_tag; ?>>
					<?php $tagline = get_bloginfo( 'description' ); ?>
					<?php if (!empty($tagline)) { ?>
						<div id="site-description" class="uw-site-tagline"><?php echo $tagline ?></div>
					<?php } ?>
				</div>
			</div>
			<?php
				if (site_uses_search()) { ?>
					<div class="uw-header-search">
						<?php get_search_form();?>
					</div>
			<?php } ?>
		</div>
	</header><!-- #branding -->

	<?php if (has_any_menus()) { ?>
		<button class="uw-mobile-menu-button-bar <?php echo ($uwmadison_header_style == "uw-white-top-bar") ? "" : "uw-mobile-menu-button-bar-reversed" ?>" aria-label="Open menu" aria-expanded="false" aria-controls="uw-top-menus"><span>Menu</span><?php echo get_svg('uw-symbol-menu'); echo get_svg('uw-symbol-close'); ?></button>

		<div id="uw-top-menus" class="uw-is-visible uw-horizontal uw-hidden" aria-hidden="false">
			<?php if (has_main_menu()) { ?>
				<div class="uw-main-nav">
					<?php
						/* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */
							$menu_class = "uw-nav-menu";
							$menu_class .= ($uwmadison_header_style == "uw-white-top-bar") ? "" : " uw-nav-menu-reverse";
					?>
					<nav class="<?php echo $menu_class; ?>" aria-label="<?php _e( 'Main Menu', 'uw-theme' ); ?>">
						<?php
							$fallback_cb = (uses_fallback_menu()) ? 'uwmadison_page_menu_fallback' : false;
							wp_nav_menu(
								array(
									'theme_location' => 'main_menu',
									'container' => false,
									'menu_id' => "uw-main-nav",
									'menu_class' => false,
									'depth' => 2,
									'walker' => new Aria_Walker_Nav_Menu(),
									'fallback_cb' => $fallback_cb
								)
							); ?>
					</nav>
				</div>
			<?php } ?>
			<?php if (has_secondary_menu()) { ?>
				<div class="uw-secondary-nav">
					<?php
						$menu_class = "uw-nav-menu uw-nav-menu-secondary";
						$menu_class .= ($uwmadison_header_style == "uw-white-top-bar") ? " uw-nav-menu-secondary-reverse" : ""; ?>
						<nav class="<?php echo $menu_class; ?>" aria-label="<?php _e( 'Secondary Menu', 'uw-theme' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'utility_menu',
										'container' => false,
										'menu_id' => "uw-secondary-nav",
										'menu_class' => 'utility-menu',
										'depth' => 2,
										'walker' => new Aria_Walker_Nav_Menu(),
										'fallback_cb' => false
									)
								);
							?>
						</nav>
				</div>
			<?php } ?>
		</div>
	<?php } ?>

