<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

VP_Security::instance()->whitelist_function('hb_global_layout_dependency');
function hb_global_layout_dependency( $value ) {

	if ( $value ===  "hb-boxed-layout" ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_color_manager_function_n');
function hb_color_manager_function_n( $value ) {

	if ( $value ===  "hb_color_manager_schemes" ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_color_manager_function');
function hb_color_manager_function( $value ) {

	if ( $value ===  "hb_color_manager_color_customizer" ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_font_body_type');
function hb_font_body_type( $value ) {

	if ( $value ===  "hb_font_custom" ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_background_image_repeat_dependency');
function hb_background_image_repeat_dependency( $value ) {
	if ( $value != null && $value != '' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_upload_or_predefined_dependency');
function hb_upload_or_predefined_dependency( $value ) {
	if ( $value == 'upload-image' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_upload_or_pred_dependency');
function hb_upload_or_pred_dependency( $value ) {
	if ( $value == 'predefined-texture' ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_enable_custom_pin_function');
function hb_enable_custom_pin_function( $value ) {
	if ( $value == true ) return true;
	return false;
}


VP_Security::instance()->whitelist_function('hb_logo_align_dependency');
function hb_logo_align_dependency( $value ) {
	if ( $value == "nav-type-2 centered-nav") return false;
	return true;
}

VP_Security::instance()->whitelist_function('hb_sticky_header_dependency');
function hb_sticky_header_dependency( $value ) {
	if ( $value == "nav-type-1" || $value == "nav-type-4") return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_sticky_header_dependency_alt');
function hb_sticky_header_dependency_alt( $value ) {
	if ( $value == "nav-type-2 centered-nav") return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_header_text_dependency');
function hb_header_text_dependency( $value ) {
	if ( $value == "nav-type-2" ) return true;
	return false;
}

VP_Security::instance()->whitelist_function('hb_maint_dependency');
function hb_maint_dependency( $value ) {
	return $value;
}

VP_Security::instance()->whitelist_function('hb_navigation_animation_binding');
function hb_navigation_animation_binding( $value ){

	$ret_array = array(
		'default-skin' => array (
				array(
					'value' => 'no-effect',
					'label' => __('None', 'hbthemes'),
				),
			),
		'second-skin' => array(
				array(
					'value' => 'no-effect',
					'label' => __('None', 'hbthemes'),
				),
			),
		'third-skin' => array(
				array(
					'value' => 'no-effect',
					'label' => __('None', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-1',
					'label' => __('Brackets Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-9',
					'label' => __('Top Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-2',
					'label' => __('Bottom Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-4',
					'label' => __('Bottom Border Effect 2', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-7',
					'label' => __('Thick Bottom Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-3',
					'label' => __('Top Border Effect 2', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-10',
					'label' => __('Bottom Border Grow Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-8',
					'label' => __('Borders Grow Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-11',
					'label' => __('Bottom Circles Effect', 'hbthemes'),
				),
			),
		'minimal-skin' => array(
				array(
					'value' => 'no-effect',
					'label' => __('None', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-1',
					'label' => __('Brackets Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-9',
					'label' => __('Top Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-2',
					'label' => __('Bottom Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-4',
					'label' => __('Bottom Border Effect 2', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-7',
					'label' => __('Thick Bottom Border Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-3',
					'label' => __('Top Border Effect 2', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-5',
					'label' => __('Grey Hover Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-6',
					'label' => __('Focus Hover Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-10',
					'label' => __('Bottom Border Grow Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-8',
					'label' => __('Borders Grow Effect', 'hbthemes'),
				),
				array(
					'value' => 'hb-effect-11',
					'label' => __('Bottom Circles Effect', 'hbthemes'),
				),
			),
	);

	return $ret_array[$value];
}

function hb_get_social_medias() {
	$socmeds = array(
		array('value' => 'facebook', 'label' => 'Facebook'),
		array('value' => 'blogger', 'label' => 'Blogger'),
		array('value' => 'delicious', 'label' => 'Delicious'),
		array('value' => 'deviantart', 'label' => 'DeviantArt'),
		array('value' => 'dribbble', 'label' => 'Dribbble'),
		array('value' => 'envelop', 'label' => 'Email'),
		array('value' => 'flickr', 'label' => 'Flickr'),
		array('value' => 'forrst', 'label' => 'Forrst'),
		array('value' => 'foursquare', 'label' => 'Foursquare'),
		array('value' => 'github', 'label' => 'Github'),
		array('value' => 'google-plus', 'label' => 'Google+'),
		array('value' => 'instagram', 'label' => 'Instagram'),
		array('value' => 'lastfm', 'label' => 'Last.FM'),
		array('value' => 'linkedin', 'label' => 'LinkedIn'),
		array('value' => 'pinterest', 'label' => 'Pinterest'),
		array('value' => 'reddit', 'label' => 'Reddit'),
		array('value' => 'feed-2', 'label' => 'RSS'),
		array('value' => 'skype', 'label' => 'Skype'),
		array('value' => 'soundcloud', 'label' => 'SoundCloud'),
		array('value' => 'stumbleupon', 'label' => 'StumbleUpon'),
		array('value' => 'tumblr', 'label' => 'Tumblr'),
		array('value' => 'twitter', 'label' => 'Twitter'),
		array('value' => 'vimeo', 'label' => 'Vimeo'),
		array('value' => 'xing', 'label' => 'Xing'),
		array('value' => 'behance', 'label' => 'Behance'),
		array('value' => 'vk', 'label' => 'VKontakte'),
		array('value' => 'wordpress', 'label' => 'WordPress'),
		array('value' => 'yahoo', 'label' => 'Yahoo!'),
		array('value' => 'yelp', 'label' => 'Yelp'),
		array('value' => 'youtube', 'label' => 'Youtube'),
		array('value' => 'custom-url', 'label' => 'Custom'),
	);
	return $socmeds;
}
?>