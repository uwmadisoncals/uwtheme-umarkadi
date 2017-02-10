<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package UW Theme
 */

get_header(); ?>

	<div id="primary" class="content-area row">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'uw-theme' ); ?></h1>
				</header>

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'uw-theme' ); ?></p>

					<?php get_search_form(); ?>
				</div>
			</section>

		</main>

		<?php get_sidebar( 'content-bottom' ); ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>