<?php

$image_id = get_sub_field('single_image');

if ( $image_id ) :
	echo wp_get_attachment_image( $image_id, 'full' );
endif;