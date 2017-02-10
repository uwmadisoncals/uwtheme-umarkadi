<?php 
  // get iframe HTML
  $iframe = get_sub_field('embed');

  // get iframe src
  preg_match('/src="(.+?)"/', $iframe, $matches);
  $src = $matches[1];

  if ( strpos($src, "youtube") !== false || strpos($src, "vimeo") !== false ) {
    echo '<div class="uw-oembed uw-oembed-video">' . get_sub_field('embed') . '</div>';
  } else {
    echo '<div class="uw-oembed">' . get_sub_field('embed') . '</div>';
  }
 ?>
