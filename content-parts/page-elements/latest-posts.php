<?php
$header = get_sub_field('header_text');
$post_list_type = get_sub_field('post_list_type');
$category_ids = get_sub_field('category_id');
$individual_posts = get_sub_field('individual_post');
$custom_post_type = get_sub_field('custom_post_type');
$count = get_sub_field('number_of_posts');
$show_date = get_sub_field('show_date');
$show_date = get_sub_field('show_date');
$show_excerpt = get_sub_field('show_excerpt');
$show_image = get_sub_field('show_image');


// checks if user has selected specific
// taxonomy terms and set the query accordingly
if ( $post_list_type == "Posts by Categories" ){
	$args = array(
        'category__in' => $category_ids,
    	'posts_per_page' => $count,
    	'post_type' => 'post',
    	'orderby'=> 'title',
    	'order' => 'ASC'
    );
} elseif ( $post_list_type == "Select Individual Posts" ){
    // redefine $list_posts - individual posts are already selected
    $list_posts = $individual_posts;
} elseif ( $post_list_type == "Custom Post Types" ) {
	$args = array(
			'post_type' => $custom_post_type,
			'posts_per_page' => $count,
			'orderby'=> 'title',
			'order' => 'ASC'
		);
} else {
    // default args
    $args = array(
    	'posts_per_page' => $count,
    	'post_type' => 'post',
    	'orderby'=> 'title',
    	'order' => 'ASC'
    );
}

if (!empty($header)) {
  echo '<div class="uw-mini-bar"><h2 class="uw-content-box-header">' . $header . '</h2></div>';
 }
 if ( $post_list_type !== "Select Individual Posts") {
     // get array of posts matching defined $args
     $list_posts = get_posts($args);
 }
// Checking for array of posts and has posts
if ( is_array($list_posts) && !empty($list_posts) ) {
    echo '<ul class="uw-headlines-list">';
    global $post;
    // for each item of array, put it in $post
    foreach( $list_posts as $post ) {
        setup_postdata( $post );
        echo '<li class="latest-news-post">';
		// check post for featured img
		if( $show_image ) {
			if ( has_post_thumbnail() ) {
        		echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'uw-headshot');
			}
		}
        echo '<h3 class="uw-mini-bar"><a href="' . get_permalink($post->ID) . '">' . get_the_title() . '</a></h3>';
        if ($show_excerpt) {
          echo '<span class="uw-headlines-list-excerpt">' . get_the_excerpt($post->ID) . '</span>';
        }
        if ( $show_date ) {
          echo '<span class="post-date">' . get_the_date() . '</span>';
        }
        echo '</li>';
    }
    echo '</ul>';
} else {
  echo '<p>No posts currently available to show';
}
wp_reset_postdata();
?>
