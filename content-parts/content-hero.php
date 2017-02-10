<?php
if( have_rows('hero_content_area') ) :
	echo '<div class="uw-hero uw-hero-constrained-height">';

	while ( have_rows('hero_content_area') ) : the_row();
		if ( get_row_layout() == 'single_image' ) :
			$image_id = get_sub_field('the_image');
			$has_inset = get_sub_field('add_inset_content') == 'Single Image with Featured Content Inset';
			$css_class = $has_inset ? array('class' => 'has-inset') : array();

			echo wp_get_attachment_image( $image_id, 'uw-hero', false, $css_class );

			// Add inset stuff here
			if ( $has_inset ) : ?>
				<div class="uw-hero-inset">
				<?php

				$image_id = get_sub_field('inset_image'); 
				$image_html = wp_get_attachment_image( $image_id, 'uw-2panel-slider' );

				if ( !empty($image_html) ):
				?>
					<div class="uw-hero-inset-image">
						<?php echo $image_html; ?>
					</div>
				<?php endif; ?>
				<?php if ( get_sub_field( 'use_post_object' ) == 'Auto-fill from site' ) {
					$post_object = get_sub_field('inset_post_object');

					if( $post_object ):

						// override $post
						$post = $post_object;
						setup_postdata( $post );

						add_filter( 'excerpt_length', function ( $length ) {
							return 28;
						}, 999 );
						$excerpt = get_the_excerpt();

						?>
						<div class="uw-hero-inset-content">
							<h3 class="uw-mini-bar uw-content-box-header"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo $excerpt; ?></p>
						</div>
						<?php wp_reset_postdata();
					endif;
				}
				else {

					echo '<div class="uw-hero-inset-content"><div class="uw-mini-bar">'. get_sub_field( 'inset_text' ) .'</div>';

					if ( get_sub_field( 'inset_link' ) ) : echo '<ul class="uw-link-list"><li class="links"><a href="'. get_sub_field('inset_link') .'">Read More ' . get_svg('uw-symbol-more') . '</a></li></ul>'; endif;
					echo '</div>';
				}
				echo "</div>";
			endif;
		else:
			if( !wp_script_is(get_template_directory_uri().'/dist/vendor/slick.min.js', 'enqueue') ) {
				// Register the Slick JavaScript library
				wp_register_script('slick-js', get_template_directory_uri().'/dist/vendor/slick.min.js', null, '1.6.0');
				wp_enqueue_script('slick-js');

				// Add the slick init inline script
				$slick_opts = preg_replace('/XXXX/', '',
				"document.addEventListener('DOMContentLoaded', function(e) {
					 jQuery('.slick-slider-hero').slick({
					  slidesToShow: 1,
					  slidesToScroll: 1,
					  arrows: true,
            prevArrow: '<button type=\"button\" class=\"slick-prev uw-carousel-arrow\" aria-label=\"previous\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-left') )."<span class=\"show-for-sr\">Previous</span></button>',
            nextArrow: '<button type=\"button\" class=\"slick-next uw-carousel-arrow\" aria-label=\"next\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-right') )."<span class=\"show-for-sr\">Next</span></button>',
					  dots:true,
					  mobileFirst:true
					});
				});");
				// WordPress 4.5 feature
				wp_add_inline_script( 'slick-js', $slick_opts );
			}

			echo '<div class="slick-slider-hero slick-with-uw-buttons">';

			while (have_rows('carousel_creation')) : the_row();
				$image_id = get_sub_field('carousel_images');
				echo wp_get_attachment_image( $image_id, 'uw-hero' );
			endwhile;

			echo '</div>';
		endif;
	endwhile;

	echo '</div>';
endif;