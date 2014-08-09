<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

VP_Security::instance()->whitelist_function('hb_page_title_background_color_dependency');

function hb_page_title_background_color_dependency( $value ) {
	if ( $value == 'hb-color-background' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_title_background_image_dependency');

function hb_page_title_background_image_dependency( $value ) {
	if ( $value == 'hb-image-background' ) return true;
	return false;
}


VP_Security::instance()->whitelist_function('hb_page_title_rev_slider_dependency');

function hb_page_title_rev_slider_dependency( $value ) {
	if (  $value == 'slider-page-title' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_title_h1_dependency');

function hb_page_title_h1_dependency( $value ) {
	if ( $value != 'none' && $value != 'slider-page-title' ) return true;
	return false;
}


VP_Security::instance()->whitelist_function('hb_page_subtitle_dependency');

function hb_page_subtitle_dependency( $value ) {
	if ( $value != 'none' && $value != 'slider-page-title' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_title_style_dependency');

function hb_page_title_style_dependency( $value ) {
	if ( $value != 'none' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_metabox_toggle');

function hb_metabox_toggle( $value ) {
	return $value;
}

VP_Security::instance()->whitelist_function('hb_contact_image_background');

function hb_contact_image_background( $value ) {
	if ( $value == 'image' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_contact_map_background');

function hb_contact_map_background( $value ) {
	if ( $value == 'map' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_portfolio_sidebar_position');

function hb_portfolio_sidebar_position( $value ) {
	if ( $value != 'fullwidth' && $value != 'default' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_background_image_page_settings_dependency');

function hb_background_image_page_settings_dependency( $value ) {
	if ( $value == 'image' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_background_color_page_settings_dependency');

function hb_background_color_page_settings_dependency( $value ) {
	if ( $value == 'color' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_layout_sidebar_dependency');

function hb_page_layout_sidebar_dependency( $value ) {
	if ( $value == 'right-sidebar' || $value == 'left-sidebar' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_title_options');

function hb_page_title_options( $value ) {
	if ( $value == 'custom' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_featured_section_type_video');

function hb_featured_section_type_video( $value ) {
	if ( $value == 'video' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_featured_section_type_alternative_image');

function hb_featured_section_type_alternative_image( $value ) {
	if ( $value == 'alternative_image' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_featured_section_type_revslider');

function hb_featured_section_type_revslider( $value ) {
	if ( $value == 'revslider' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_featured_image');

function hb_page_featured_image( $value ) {
	if (  $value == 'featured_image' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_featured_revslider');

function hb_page_featured_revslider( $value ) {
	if (  $value == 'revolution' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_featured_layer');

function hb_page_featured_layer( $value ) {
	if (  $value == 'layer' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_page_featured_video');

function hb_page_featured_video( $value ) {
	if (  $value == 'video' ) return true;
	return false;
}

?>