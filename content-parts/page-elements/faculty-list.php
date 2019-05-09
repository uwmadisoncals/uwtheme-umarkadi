<?php
$people_list_title = get_sub_field('listing_title');
$people_list_type = get_sub_field('people_list_type');
$individual_people = get_sub_field('individual_people');
$terms = get_sub_field('faculty_type');

// checks if user has selected specific
// taxonomy terms and set the query accordingly
	if( $people_list_type == "Faculty/Staff by category" && $terms ):
		$args = array(
		'posts_per_page' => -1,
		'post_type' => 'uw_staff',
		'tax_query' => array(
			array(
				'taxonomy' => 'uw_staff_type',
				'field' => 'term_id',
				'terms' => $terms
			)
		),
		'orderby'=> 'title',
		'order' => 'ASC'
	);
else :
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'uw_staff',
	'orderby'=> 'title',
	'order' => 'ASC'
);
endif;

?>

<?php
if( get_posts($args) ) :
	$columns		= get_sub_field( 'columns');
	$foundation_grid_cols = '';
	$one_column_layout = false;
	$last_to_first	= get_sub_field( 'last_name_first');
	$show_credentials = get_sub_field( 'show_credentials' );
	$show_email		= get_sub_field( 'show_email' );
	$show_phone		= get_sub_field( 'show_phone' );
	$show_title		= get_sub_field( 'show_title' );
	$show_linkedin	= get_sub_field( 'show_linkedin' );
	$show_address	= get_sub_field( 'show_address' );
	$show_bio	= get_sub_field( 'show_bio' );
	$display_photos = get_sub_field('display_photos');
	$image_size = get_sub_field('image_size');
	$custom_width = get_sub_field('custom_image_width');
	$custom_height= get_sub_field('custom_image_height');

	if ( $columns == 3 ) { $foundation_grid_cols = 4; } // Default
	elseif ( $columns == 2 ) { $foundation_grid_cols = 6; }
	elseif ( $columns == 4 ) { $foundation_grid_cols = 3; }
	else { $foundation_grid_cols = 12; $one_column_layout = true; }

  if ($people_list_title) :
    echo '<h2 class="text-center uw-mini-bar-center">' . $people_list_title . '</h2>';
  endif;
  ?>
  <div class="faculty-list">

  <?php
	if($people_list_type == "Select individual people" && $individual_people) :
    $people = $individual_people;
  else :
    $people = get_posts($args);
  endif;
	foreach($people as $person) :
	$image_id = get_field( 'headshot', $person->ID );

?>

<div class="faculty-member column small-12 medium-<?php echo $foundation_grid_cols ?>">
	<div class="faculty-member-content">

	<?php
	if ( $one_column_layout ) :
		echo '<div class="row">';
		if ( $display_photos ) :
			echo '<div class="column shrink">';
		endif;
	endif;

	if($display_photos) :
		if ( $image_size == 'Thumbnail (site default)') :
			$image_src = 'thumbnail';
			$image_class = 'thumbnail';
		elseif ($image_size == 'Custom') :
			$image_src = array($custom_width, $custom_height);
			$image_class = 'custom';
		else :
			$image_src = 'uw-headshot';
			$image_class = 'default';
		endif;
	?>

		<div
			class="faculty-image<?php echo ' ' . $image_class; ?>"
			<?php if($image_size == 'Custom') : //set custom dimensions as max-width and max-height ?>
				style="max-width: <?php echo $custom_width; ?>px; max-height: <?php echo $custom_height; ?>px;"
			<?php endif; ?>
			>
			<a href="<?php the_permalink($person->ID) ?>" tabindex="-1" aria-hidden="true">
				<?php
				if ( $image_id ) :
					echo wp_get_attachment_image( $image_id, $image_src );
				else : 
					$alt_text = $last_to_first ? get_field( 'last_name', $person->ID ). ', ' .get_field( 'first_name', $person->ID ) : get_field( 'first_name', $person->ID ). ' ' .get_field( 'last_name', $person->ID ); ?>
					<img class="buckyhead" src="<?php  echo get_template_directory_uri() . '/dist/images/bucky-head.png'; ?>" alt="<?php echo $alt_text; ?>" />
				<?php endif; ?>
			</a>
		</div>
	<?php endif; //end if($display_photos) ?>

	<?php
	if ( $one_column_layout ) :
		if($display_photos) :
			echo '</div>';
		endif;
		echo '<div class="column">';
	endif;
	?>

		<h3><a href="<?php the_permalink($person->ID); ?>">
			<?php echo $last_to_first ? get_field( 'last_name', $person->ID ). ', ' .get_field( 'first_name', $person->ID ) : get_field( 'first_name', $person->ID ). ' ' .get_field( 'last_name', $person->ID ) ?>
		</a></h3>
		<?php echo $show_credentials ? '<p><b>' . get_field( 'credentials', $person->ID ) . '</b></p>' : ''; ?>
		<?php echo $show_title ? '<p>' . get_field( 'title_position', $person->ID ) . '</p>' : ''; ?>

		<?php echo $show_email ? '<p><a href="mailto:' . get_field( 'email', $person->ID ) . '">' . get_field( 'email', $person->ID ) . '</a></p>' : '' ?>

		<?php echo $show_phone ? '<p>' . get_field( 'phone', $person->ID ) . '</p>' : '' ?>

		<?php echo $show_address ? get_field ( 'address', $person->ID ) : '' ; ?>

		<?php
		$linkedin_icon = get_field( 'linkedin', $person->ID );

		if ( $show_linkedin ) : ?>
			<?php if ( !empty( $linkedin_icon ) ) : ?>
				<ul class="uw-social-icons">
					<li class="uw-social-icon">
						<a href="<?php echo $linkedin_icon; ?>"> <?php echo get_svg('uw-symbol-linkedin', array("aria-hidden" => "true")) ?>
						</a>
					</li>
				</ul>
			<?php endif; ?>
		<?php endif;?>

		<?php 
				if ( $show_bio ) :
				$biography_format = get_sub_field( 'biography_format' );
				$biography_excerpt = trim( get_the_excerpt( $person->ID ) );
				if ( $biography_format == "excerpt" && $biography_excerpt !== '' ) :
					// show excerpt
					echo sprintf( '<p class="bio">%s</p>', get_the_excerpt( $person->ID ) );
				elseif ( $biography_format == "excerpt" && $biography_excerpt === '' ) :
					// show truncated biography 
					echo sprintf( '<p class="bio">%s</p>', wp_trim_words( get_field ( 'biography', $person->ID ), uwmadison_custom_excerpt_length( '' ) ) );
				else :
					// show biography 
					echo sprintf( '<p class="bio">%s</p>', get_field( 'biography', $person->ID ) );
				endif;
		endif;
		

	if ($one_column_layout ) :
		echo '</div></div>';
	endif;
	?>
	</div>
</div>

<?php endforeach; wp_reset_postdata(); endif;  ?>
</div>
