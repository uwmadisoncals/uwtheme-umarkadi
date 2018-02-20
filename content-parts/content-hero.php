<?php
if( have_rows('hero_content') ) :
  while ( have_rows('hero_content') ) : the_row();
    if ( get_row_layout() == 'hero_carousel' ) :
      $heros = get_sub_field('hero_carousel_repeater');
      $hero_count = count($heros);
      if ( $hero_count > 1 ) :
        if( !wp_script_is(get_template_directory_uri().'/dist/vendor/slick.min.js', 'enqueue') ) :
          // Register the Slick JavaScript library
          wp_register_script('slick-js', get_template_directory_uri().'/dist/vendor/slick.min.js', null, '1.6.0');
          wp_enqueue_script('slick-js');

          // Add the slick init inline script and filter to show only enabled slides
          $slick_opts = "document.addEventListener('DOMContentLoaded', function(e) {

            if (window.innerWidth < 640) {
              jQuery('.uw-hero').on('init afterChange', function(event, slick){
                setTimeout(function(){
                  jQuery('.uw-hero').find('.slick-arrow button').css('top',(jQuery('.uw-hero').find('[data-slick-index=0] img').height() - 16) + 'px');
                },100);
              });
            }

            jQuery('.uw-hero').slick({
              adaptiveHeight: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: true,
              prevArrow: '<div class=\"uw-carousel-arrow-wrapper uw-carousel-arrow-wrapper-left\"><button type=\"button\" class=\"slick-prev uw-carousel-arrow\" aria-label=\"previous\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-left') )."<span class=\"show-for-sr\">Previous</span></button></div>',
              nextArrow: '<div class=\"uw-carousel-arrow-wrapper uw-carousel-arrow-wrapper-right\"><button type=\"button\" class=\"slick-next uw-carousel-arrow\" aria-label=\"next\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-right') )."<span class=\"show-for-sr\">Next</span></button></div>',
              dots:false,
              mobileFirst:true,
              draggable: false,
              swipe: false,
            }).slick('slickFilter', '.uw-hero-enabled');

          });";
          // WordPress 4.5 feature
          wp_add_inline_script( 'slick-js', $slick_opts );
        endif;
      endif;
      ?>

      <div class="uw-hero">

      <?php
      while ( have_rows('hero_carousel_repeater') ) : the_row();
        $hero_layout = get_sub_field('hero_layout');
        $hero_image = get_sub_field('hero_image');

        echo '<div'; // start of slide
          // check if slide is disabled
          if(!get_sub_field('disable_this_hero')) :
            echo ' class="uw-hero-enabled"';
          endif;
        echo '>';

        echo wp_get_attachment_image( $hero_image, 'uw-hero');


      if($hero_layout == 'inset' || $hero_layout == 'headline') :
        $use_post_object = get_sub_field( 'use_post_object' );
        $post_object = get_sub_field('inset_post_object');
        $inset_link_title = get_sub_field('inset_link_title');
        $inset_link = get_sub_field('inset_link');

        if($hero_layout == 'inset') :
          $inset_image = get_sub_field('inset_image');
          $inset_text = get_sub_field( 'inset_text' );
          $add_a_link = get_sub_field( 'add_a_link' ); 
        endif;

        if($hero_layout == 'headline') :
          $inset_image = null;
          $inset_text = get_sub_field('inset_headline');
          $add_a_link = get_sub_field( 'add_a_link' ); 
        endif;


        // Featured Content Inset

        //start of inset wrapper
        echo '<div class="uw-hero-inset-wrapper row align-middle';
          if($hero_layout == 'headline') :
            echo ' uw-hero-headline-wrapper';
          endif;
        echo '">';

          //start of inset
          echo '<div';
            if($hero_layout == 'inset') :
              echo ' class="uw-hero-inset"';
            endif;
            if($hero_layout == 'headline') :
              echo ' class="uw-hero-headline"';
            endif;
          echo '>';

        // Display the Inset Image if one exists.
          if($hero_layout == 'inset' && $inset_image) : ?>
            <div class="uw-hero-inset-image">
              <?php echo wp_get_attachment_image( $inset_image, 'medium_large' ); ?>
            </div>
          <?php endif;?>


          <?php
          // if autofill from site is selected
          if ( $use_post_object && $post_object ) :
            // override $post
            $post = get_sub_field('inset_post_object');
            setup_postdata( $post );

            add_filter( 'excerpt_length', function ( $length ) {
              return 28;
            }, 999 );
            $excerpt = get_the_excerpt();

            ?>
            <div class="uw-hero-inset-content">
              <p><?php echo $excerpt; ?></p>

              <a href="<?php the_permalink();?>">
                Go to <?php the_title(); echo get_svg('uw-symbol-more');?>
              </a>

            </div>

            <?php wp_reset_postdata();

          else : // if autofill from site is not selected
            ?>
              <div class="uw-hero-inset-content">
                <?php echo $inset_text; ?>
                  <?php if($add_a_link) :
                    if ( get_sub_field( 'inset_link' ) ) : ?>
                    <a href="<?php echo get_sub_field('inset_link');?>">
                      <?php echo $inset_link_title . ' ' . get_svg('uw-symbol-more');?>
                    </a>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endif;
        echo '</div>'; // end of inset
        echo '</div>'; // end of inset wrapper
      endif; // end of layouts for inset or headline

      echo '</div>'; //end of slide

      endwhile; // end of hero_content_area_repeater
      echo '</div>'; // end of .uw-hero
    endif; // end of hero_carousel
  endwhile;
endif; // end of hero content area

// don't delete me ?>
