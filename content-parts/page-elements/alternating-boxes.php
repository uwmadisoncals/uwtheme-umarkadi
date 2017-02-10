<?php
if(get_sub_field('alternating_content_area_headline')) {
  echo '<h2 class="uw-mini-bar uw-mini-bar-center text-center">' . get_sub_field('alternating_content_area_headline') . '</h2>';
}
?>

<?php if( have_rows('content_box') ):

  while( have_rows('content_box') ): the_row();
    $headline = get_sub_field('alternating_content_headline');
    $text = get_sub_field('alternating_content_text');
    $image = get_sub_field('alternating_content_image');
?>

  <div class="alternating-content">
    <div class="alternating-content-box">
      <div class="column">
        <?php
          if($headline){ echo '<h3>' . $headline . '</h3>'; }
          if($text){ echo $text; }
          get_template_part( 'content-parts/page-elements/link', 'list' );
        ?>
      </div>
    </div>
    <div class="alternating-content-box">
      <?php if($image):?>
        <img src="<?php echo $image['sizes']['uw-3x2']; ?>" alt="<?php echo $image['alt'] ?>" />
      <?php endif; ?>
    </div>
  </div>

  <?php endwhile; ?>
<?php endif; ?>