<?php
/**
 * @package RVSpotDrop
 * Setup the WordPress core custom header feature.
 *
 * @uses rvspotdrop_header_style()
*/
function rvspotdrop_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'rvspotdrop_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'rvspotdrop_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'rvspotdrop_custom_header_setup' );

if ( ! function_exists( 'rvspotdrop_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see rvspotdrop_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'rvspotdrop_header_style' );

function rvspotdrop_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        .middle-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'rvspotdrop-basic-style', $custom_css );
	endif;
}
endif;