<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

function hb_styles_setup () {

	// Enqueue Responsive Style if selected from the Theme Options
	if ( hb_options('hb_responsive') ) {
	wp_register_style( 'hb_responsive', get_template_directory_uri() . '/css/responsive.css' );
	wp_enqueue_style( 'hb_responsive' );
	}

	// IcoMoon
	wp_register_style( 'hb_icomoon', get_template_directory_uri() . '/css/icomoon.css' );
	wp_enqueue_style( 'hb_icomoon' );

}
add_action('wp_enqueue_scripts', 'hb_styles_setup');
?>