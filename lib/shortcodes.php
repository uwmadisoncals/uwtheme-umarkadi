<?php

/**
 * Shortcode for including social links as set in Customizer
 *
 * @return String unordered list with social icons
 **/
function uwmadison_social_shortcode( $atts ) {
  // extend here with shortcode attrs if we want
  // $atts = shortcode_atts( array(
  //   'show_text_link' => 'false',
  // ), $atts, 'uwmadison_social' );
  $uwmadison_social = get_theme_mod( "uwmadison_social" );
  return uwmadison_social_links($uwmadison_social);
}
add_shortcode( 'uwmadison_social', 'uwmadison_social_shortcode' );


/**
 * Shortcode for including contact info as set in Customizer
 *
 * @return String markup for contact info
 **/
function uwmadison_contact_shortcode( $atts ) {
  // extend here with shortcode attrs if we want
  // $atts = shortcode_atts( array(
  //   'show_text_link' => 'false',
  // ), $atts, 'uwmadison_social' );
  return uwmadison_contact_info($include_social = false);
}
add_shortcode( 'uwmadison_contact', 'uwmadison_contact_shortcode' );


/**
 * Shortcode for including search form in content
 *
 * @return String markup for search form
 **/
function uwmadison_search_form_shortcode() {
	// filter markup to eliminate duplicate IDs
	add_filter( 'get_search_form', function( $form ) {
		return preg_replace('/id="([^"]+)"/i', 'id="$1-2"', $form);
	}, 10, 1 ); 
  return get_search_form(false);
}
add_shortcode( 'uw-search-input', 'uwmadison_search_form_shortcode' );