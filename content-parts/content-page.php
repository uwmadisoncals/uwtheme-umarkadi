<?php
/**
 * The template partial that displays content on page.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */
function output_page_elements() {
	switch( get_row_layout() ) {
		case 'text_block':
			get_template_part( 'content-parts/page-elements/text', 'block' );
			break;
		case 'image':
			get_template_part( 'content-parts/page-elements/image', 'content' );
			break;
		case 'image_carousel':
			get_template_part( 'content-parts/page-elements/image', 'carousel' );
			break;
		case 'image_gallery':
			get_template_part( 'content-parts/page-elements/image', 'gallery' );
			break;
		case 'faculty_list_options':
			get_template_part( 'content-parts/page-elements/faculty', 'list' );
			break;
		case 'accordion_panel':
			get_template_part( 'content-parts/page-elements/accordion', 'panel' );
			break;
		case 'tabbed_content':
			get_template_part( 'content-parts/page-elements/tabbed', 'content' );
			break;
		case 'embed_content':
			get_template_part( 'content-parts/page-elements/embed', 'content' );
			break;
		case 'group_of_links':
			get_template_part( 'content-parts/page-elements/content', 'links' );
			break;
		case 'latest_posts':
			get_template_part( 'content-parts/page-elements/latest', 'posts' );
			break;
		case 'featured_content':
			get_template_part( 'content-parts/page-elements/featured', 'content' );
			break;
		case 'stylized_quote':
			get_template_part( 'content-parts/page-elements/stylized', 'quote' );
			break;
		case 'alternating_content_boxes':
			get_template_part( 'content-parts/page-elements/alternating', 'boxes' );
			break;
		case 'todaywiscedu_events':
			get_template_part( 'content-parts/page-elements/today', 'events' );
			break;
		case 'documents_listing':
			get_template_part( 'content-parts/page-elements/documents', 'list' );
		break;
		case 'page_element_action_hook':
			$action_hook_slug = get_sub_field('action_hook_slug');
			$action_hook_slug = preg_replace('/[^A-Za-z-]+/', '_', $action_hook_slug);
			if ( !empty($action_hook_slug) )
				do_action( $action_hook_slug );
			break;
		default: echo 'Page element not found';
	}
}

/**
 * Extract unique acf_fc_layout values within a layout row for use as a CSS class list
 *
 * @param Array $row an ACF layout row array
 * @return String space-delimited string of acf_fc_layout values
 **/
function elements_as_classes($row) {
	$elements = array();
	if (function_exists('array_column')) {
		foreach ($row as $key => $value) {
			if ("array" == gettype($value)) {
				$elements = array_merge($elements,array_unique(array_column($value, 'acf_fc_layout')));
			}
		}
	}
	if (!empty($elements)) {
		return " " . implode(" ",array_map(function($text){return "has_".$text;},array_unique($elements)));
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if(!is_front_page()): ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="page-title uw-mini-bar">', '</h1>' ); ?>
	</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		if( have_rows('primary_content_area')) :
			while ( have_rows('primary_content_area') ): the_row();

				$row_headline = get_sub_field('row_headline');
				$background = get_sub_field('background_choice');
				$background_image = null;
				//set background based on user choice
					if($background =='Badger Red') {
						$bg_color = 'primary-background row-dark-background';
					}elseif($background =='White') {
						$bg_color = 'white-background';
					}elseif($background =='Dark Red') {
						$bg_color = 'secondary-background row-dark-background';
					}elseif($background =='Light Gray') {
						$bg_color = 'lightest-gray-background';
					}elseif($background =='Dark Gray') {
						$bg_color = 'dark-gray-background row-dark-background';
					}elseif($background =='Blue-Gray') {
						$bg_color = 'blue-gray-background';
					}elseif($background == 'Upload Image'){
						$background_image = get_sub_field('background_image');
						$bg_color = 'has_background-image';
					}else {
						$bg_color = 'default-background';
					}

				echo '<div class="uw-outer-row row-' . get_row_index() . elements_as_classes( get_row()) . ' ' . $bg_color . '" ';
				if($background_image) {
					echo 'style="background-image: url(' . $background_image['url'] . '); background-repeat: no-repeat; background-size: cover;"';
				}
				echo '>';

				echo '<div class="uw-inner-row">';
					if($row_headline) {
						echo '<div class="uw-column uw-row-header"><h2>' . $row_headline . '</h2></div>';
					}

				// One Column Content Layout
				if( get_row_layout() == 'one_column_content_layout' ) :
						echo '<div class="uw-column one-column">';
							while ( have_rows('one_column_page_elements') ) : the_row();
								echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
									output_page_elements();
								echo '</div>';
							endwhile;
						echo '</div>';

				// Two Column Content Layout
				elseif( get_row_layout() == 'two_column_content_layout' ) :
					// Left Column (can be wide, narrow, or equal)
					if(get_sub_field('column_display') == "Left 60%  Right 40%"):
						echo '<div class="uw-column wide-column">';
					elseif(get_sub_field('column_display') == "Left 40%  Right 60%"):
						echo '<div class="uw-column narrow-column">';
					else:
						echo '<div class="uw-column equal-column">';
					endif;
						while ( have_rows('first_column_page_elements') ) : the_row();
							echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
								output_page_elements();
							echo '</div>';
						endwhile;
					echo '</div>';

					// Right Column (can be wide, narrow, or equal)
					if(get_sub_field('column_display') == "Left 60%  Right 40%"):
						echo '<div class="uw-column narrow-column">';
					elseif(get_sub_field('column_display') == "Left 40%  Right 60%"):
						echo '<div class="uw-column wide-column">';
					else:
						echo '<div class="uw-column equal-column">';
					endif;
					while ( have_rows('second_column_page_elements') ) : the_row();
						echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
							output_page_elements();
						echo '</div>';
					endwhile;
					echo '</div>';

				// Three Column Content Layout
				elseif( get_row_layout() == 'three_column_content_layout' ) :
					echo '<div class="uw-column three-column">';
					while ( have_rows('first_column_page_elements') ) : the_row();
						echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
							output_page_elements();
						echo '</div>';
					endwhile;
					echo '</div><div class="uw-column three-column">';
					while ( have_rows('second_column_page_elements') ) : the_row();
						echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
							output_page_elements();
						echo '</div>';
					endwhile;
					echo '</div><div class="uw-column three-column">';
					while ( have_rows('third_column_page_elements') ) : the_row();
						echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
							output_page_elements();
						echo '</div>';
					endwhile;
					echo '</div>';
				endif;

				echo '</div></div>'; // end of uw-row-full and uw-inner-row

			endwhile;
		else :
			echo '<div class="uw-outer-row"><div class="uw-inner-row"><div class="uw-column"><div class="uw-pe uw-pe-text-block">';
				the_content();
			echo '</div></div></div></div>';
		endif;

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'uw-theme' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'uw-theme' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	</div>

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'uw-theme' ),
				get_the_title()
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer>'
		);
	?>

</article>