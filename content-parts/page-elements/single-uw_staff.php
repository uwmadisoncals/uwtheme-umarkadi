<?php
  $last_to_first  = get_sub_field( 'last_name_first') || false;
  $first_name = get_field( 'first_name' );
  $last_name = get_field('last_name');
  $email = get_field( 'email' );
  $phone = get_field( 'phone' );
  $position = get_field( 'title_position' );
  $address = get_field( 'address' );
  $linkedin = get_field( 'linkedin' );
?>

<div class="faculty-headshot-contact">
  <div class="faculty-contact">
    <h1 class="page-title uw-mini-bar"><?php echo $last_to_first ? $last_name. ', ' .$first_name : $first_name. ' ' .$last_name ?></h1>
    <h2> <?php echo !empty($position) ? '<p>' . $position . '</p>' : null; ?> </h2>
  <?php
    echo !empty($email) ? '<p><a href="mailto:' . $email . '">' . $email . '</a></p>' : null;
    echo !empty($phone) ? '<p>' . $phone . '</p>' : null;
    echo !empty($address) ? '<p class="faculty-address">' . $address . '</p>' : null;
    echo !empty($linkedin) ? '<ul class="uw-social-icons"><li class="uw-social-icon"><a href="' . $linkedin . '">' . get_svg('uw-symbol-linkedin', array("aria-hidden" => "true")) . '</a></li></ul>' : null;
  ?>

  <?php if( have_rows('extra_fields') ): ?>
    <dl class="faculty-extra">
      <?php while ( have_rows('extra_fields') ) : the_row(); ?>
        <?php
          $extra_label = get_sub_field("extra_label");
          $extra_value = get_sub_field("extra_value");
          $extra_url = get_sub_field("extra_url");
        ?>
        <dt class="faculty-extra-label"><?php echo $extra_label; ?></dt>
        <dd class="faculty-extra-value">
          <?php if ( !empty($extra_url) ) : ?><a href="<?php echo $extra_url ?>"><?php endif; ?>
            <?php echo $extra_value; ?>
          <?php if ( !empty($extra_url) ) : ?></a><?php endif; ?>
        </dd>
      <?php endwhile; ?>
    </dl>
  <?php endif; ?>

  </div>
  <div class="faculty-headshot">
    <?php
    $image_id = get_field( 'headshot' );
		$alt_text = $last_to_first ? $last_name. ', ' .$first_name : $first_name. ' ' .$last_name;	
    if ( $image_id ) :
      echo '<p>' . wp_get_attachment_image( $image_id, 'medium' ) . '</p>';
    else :
      echo '<p><img src="' . get_template_directory_uri() . '/dist/images/bucky-head.png" alt="' . $alt_text . '" /></p>';
    endif;
    ?>
  </div>
</div>

<div class="faculty-bio">
  <?php echo get_field( 'biography'); ?>
</div>
