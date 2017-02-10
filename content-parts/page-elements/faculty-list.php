<?php
$people_list_title = get_sub_field('listing_title');
$people_list_type = get_sub_field('people_list_type');
$individual_people = get_sub_field('individual_people');
$terms = get_sub_field('faculty_type');

// checks if user has selected specific
// taxonomy terms and set the query accordingly
if( $terms ):
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
else:
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'uw_staff',
	'orderby'=> 'title',
	'order' => 'ASC'
);
endif;

// $query = new WP_Query( $args );
$show_email		= get_sub_field( 'show_email' );
$show_phone		= get_sub_field( 'show_phone' );
$show_title		= get_sub_field( 'show_title' );
$show_address	= get_sub_field( 'show_address' );
$show_bio	= get_sub_field( 'show_bio' );
$columns		= get_sub_field( 'columns');
$last_to_first	= get_sub_field( 'last_name_first');
$foundation_grid_cols = '';
$one_column_layout = false;

if ( $columns == 3 ) { $foundation_grid_cols = 4; } // Default
elseif ( $columns == 2 ) { $foundation_grid_cols = 6; }
elseif ( $columns == 4 ) { $foundation_grid_cols = 3; }
else { $foundation_grid_cols = 12; $one_column_layout = true; }
?>



		<?php
	  if( get_posts($args) ) :
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
		if ( $one_column_layout ) { echo '<div class="row"><div class="column shrink">'; }
	?>
			<div class="faculty-image">
				<a href="<?php the_permalink($person->ID) ?>" tabindex="-1" aria-hidden="true">
					<?php
					if ( $image_id ) :
						echo wp_get_attachment_image( $image_id, 'uw-headshot' );
					else : ?>
						<img class="buckyhead" src="<?php  echo get_template_directory_uri() . '/dist/images/bucky-head.png'; ?>"/>
					<?php endif; ?>
				</a>
			</div>


		<?php if ( $one_column_layout ) { echo '</div><div class="column">'; } ?>

			<h3><a href="<?php the_permalink($person->ID); ?>">
				<?php echo $last_to_first ? get_field( 'last_name', $person->ID ). ', ' .get_field( 'first_name', $person->ID ) : get_field( 'first_name', $person->ID ). ' ' .get_field( 'last_name', $person->ID ) ?>
			</a></h3>
			<?php echo $show_title ? '<p>' . get_field( 'title_position', $person->ID ) . '</p>' : ''; ?>

			<?php echo $show_email ? '<p><a href="mailto:' . get_field( 'email', $person->ID ) . '">' . get_field( 'email', $person->ID ) . '</a></p>' : '' ?>

			<?php echo $show_phone ? '<p>' . get_field( 'phone', $person->ID ) . '</p>' : '' ?>

			<?php echo $show_address ? get_field ( 'address', $person->ID ) : '' ; ?>

			<?php echo $show_bio ? '<p class="bio">' . get_field ( 'biography', $person->ID )  . '</p>' : '' ;

		if ( $one_column_layout ) { echo '</div></div>'; } ?>
		</div>
	</div>

	<?php endforeach; endif; wp_reset_postdata(); ?>
</div>
