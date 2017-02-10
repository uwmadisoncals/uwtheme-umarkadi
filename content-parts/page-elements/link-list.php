<?php
// Group of Links
$use_menu = get_sub_field( 'use_predefined_menu' );
$header_text = get_sub_field( 'links_header' );

if ( !empty($header_text) )
  echo '<h4>' . $header_text . '</h4>';

if ( $use_menu != 'Yes' ) {
  if( have_rows('links_group') ): ?>
    <ul class="uw-link-list">

      <?php while ( have_rows('links_group') ) : the_row();
        $kind_of_link = get_sub_field('kind_of_link');
        $link_name = get_sub_field('link_display_name');


        if ($kind_of_link == 'External Link'){
          $link_location = get_sub_field('external_link_location');
        }else if($kind_of_link == 'Internal Link') {
          $link_location = get_sub_field('internal_link_location');
        }else {
          $link_location = '#';
        }
        ?>

        <li>
          <a href="<?php echo $link_location; ?>">
            <?php echo $link_name . ' ' . get_svg('uw-symbol-more'); ?>
          </a>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif;
} else {

  //Filtering a Class in Navigation Menu Item
  // add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
  // function special_nav_class($classes, $item){
  //  $classes[] = 'columns small-12 medium-6 row';
  //  return $classes;
  // }

  $menu = get_sub_field('select_menu');
  $arrows = ' ' . get_svg('uw-symbol-more');
  wp_nav_menu(
    array(
      'menu' => $menu->name,
      'container' => false,
      'menu_class' => 'uw-link-list',
      //'depth' => 1,
      'link_after' => $arrows,
      'walker' => new Aria_Walker_Nav_Menu(),
      'fallback_cb' => false
    )
  );
}