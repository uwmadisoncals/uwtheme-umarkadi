<?php
if( have_rows('lower_content_area') ):
    echo '<div class="uw-hero">';

    while ( have_rows('lower_content_area') ) : the_row();
        if ( get_row_layout() == 'single_image' ) :
            $image_id = get_sub_field('the_image'); 
            echo wp_get_attachment_image( $image_id, 'uw-hero' );

        else :
            if( !wp_script_is(get_template_directory_uri().'/dist/vendor/slick.min.js', 'enqueue') ) {
                // Register the Slick JavaScript library
                wp_register_script('slick-js', get_template_directory_uri().'/dist/vendor/slick.min.js', null, '1.6.0');
                wp_enqueue_script('slick-js');

                // Add the slick init inline script
                $slick_opts = preg_replace('/\s/', '',
                "document.addEventListener('DOMContentLoaded', function(e) {
                     jQuery('.slick-slider').slick({
                      slidesToShow: 1,
                      slidesToScroll: 1,
                      arrows: true,
                      dots:true,
                      mobileFirst:true
                    });
                });");
                // WordPress 4.5 feature
                wp_add_inline_script( 'slick-js', $slick_opts );
            }

            echo '<div class="slick-slider">';

            while (have_rows('carousel_creation')) : the_row();
                $image_id = get_sub_field('carousel_images'); 
                echo wp_get_attachment_image( $image_id, 'uw-hero' );
            endwhile;

            echo '</div>';
        endif;
    endwhile;

    echo '</div>';
endif;