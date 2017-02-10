<?php
/**
 * The basic/main template file that pulls everything together.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */


/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

get_header(); ?>

<div id="page" class="content">
	<main id="main" class="site-main">

	<?php if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); } ?>

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header>
				<h1 class="page-title uw-mini-bar"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'content-parts/content', get_post_format() );

		// End the loop.
		endwhile;

		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'uw-theme' ),
			'next_text'          => __( 'Next page', 'uw-theme' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'uw-theme' ) . ' </span>',
		) );

	// If no content, include the "No posts found" template.
	else :
		get_template_part( 'content-parts/content', 'none' );

	endif;
	?>

	</main>

	<?php if (is_home()) { get_sidebar(); } ?>

</div>

<?php get_footer(); ?>


