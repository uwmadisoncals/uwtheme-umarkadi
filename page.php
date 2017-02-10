<?php
/**
 * The standard Page template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */

get_header();

// Include the page content template.
get_template_part( 'content-parts/content', 'hero' ); ?>

<div id="page" class="content page-builder">

	<main id="main" class="site-main">
		<?php

		if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); }
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main>

</div>

<?php get_template_part( 'content-parts/content', 'lower' ); ?>

<?php get_footer(); ?>