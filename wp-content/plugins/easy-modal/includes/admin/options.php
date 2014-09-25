<?php
add_filter('emodal_existing_addon_images', 'emodal_core_addon_images', 10);
function emodal_core_addon_images($array)
{
	return array_merge($array, array(
		'premium-support',
		'pro-developer',
		'pro-bundle',
		'unlimited-themes',
		'scroll-pops',
		'force-user-action',
		'age-verification',
		'advanced-theme-editor',
		'exit-modals',
		'auto-open',
		'login-modals',
	));
}



add_filter('emodal_model_modal_meta_defaults', 'emodal_model_modal_meta_core_defaults', 10);
function emodal_model_modal_meta_core_defaults($options){
	if(empty($options['display']['overlay_disabled'] )) $options['display']['overlay_disabled'] = 0;
	if(empty($options['display']['size'])) $options['display']['size'] = 'medium';
	if(empty($options['display']['custom_width'])) $options['display']['custom_width'] = '';
	if(empty($options['display']['custom_width_unit'])) $options['display']['custom_width_unit'] = '%';
	if(empty($options['display']['custom_height'])) $options['display']['custom_height'] = '';
	if(empty($options['display']['custom_height_unit'])) $options['display']['custom_height_unit'] = 'em';
	if(empty($options['display']['custom_height_auto'])) $options['display']['custom_height_auto'] = 1;

	if(empty($options['display']['location'])) $options['display']['location'] = 'center top';
	if(empty($options['display']['position']['top'])) $options['display']['position']['top'] = 100;
	if(empty($options['display']['position']['left'])) $options['display']['position']['left'] = 0;
	if(empty($options['display']['position']['bottom'])) $options['display']['position']['bottom'] = 0;
	if(empty($options['display']['position']['right'])) $options['display']['position']['right'] = 0;
	if(empty($options['display']['position']['fixed'])) $options['display']['position']['fixed'] = 0;

	if(empty($options['display']['animation']['type'])) $options['display']['animation']['type'] = 'fade';
	if(empty($options['display']['animation']['speed'])) $options['display']['animation']['speed'] = 350;
	if(empty($options['display']['animation']['origin'])) $options['display']['animation']['origin'] = 'center top';

	if(empty($options['close']['overlay_click'])) $options['close']['overlay_click'] = 0;
	if(empty($options['close']['esc_press'])) $options['close']['esc_press'] = 1;
	return $options;
}

add_filter('emodal_model_theme_meta_defaults', 'emodal_model_theme_meta_core_defaults', 10);
function emodal_model_theme_meta_core_defaults($options){


	if(empty($options['overlay']['background']['color'])) $options['overlay']['background']['color'] = '#ffffff';
	if(empty($options['overlay']['background']['opacity'])) $options['overlay']['background']['opacity'] = 100;

	if(empty($options['container']['padding'])) $options['container']['padding'] = 18;
	if(empty($options['container']['background']['color'])) $options['container']['background']['color'] = '#f9f9f9';
	if(empty($options['container']['background']['opacity'])) $options['container']['background']['opacity'] = 100;
	if(empty($options['container']['border']['style'])) $options['container']['border']['style'] = 'none';
	if(empty($options['container']['border']['color'])) $options['container']['border']['color'] = '#000000';
	if(empty($options['container']['border']['width'])) $options['container']['border']['width'] = 1;
	if(empty($options['container']['border']['radius'])) $options['container']['border']['radius'] = 0;
	if(empty($options['container']['boxshadow']['inset'])) $options['container']['boxshadow']['inset'] = 'no';
	if(empty($options['container']['boxshadow']['horizontal'])) $options['container']['boxshadow']['horizontal'] = 1;
	if(empty($options['container']['boxshadow']['vertical'])) $options['container']['boxshadow']['vertical'] = 1;
	if(empty($options['container']['boxshadow']['blur'])) $options['container']['boxshadow']['blur'] = 3;
	if(empty($options['container']['boxshadow']['spread'])) $options['container']['boxshadow']['spread'] = 0;
	if(empty($options['container']['boxshadow']['color'])) $options['container']['boxshadow']['color'] = '#020202';
	if(empty($options['container']['boxshadow']['opacity'])) $options['container']['boxshadow']['opacity'] = 23;

	if(empty($options['title']['font']['color'])) $options['title']['font']['color'] = '#000000';
	if(empty($options['title']['font']['size'])) $options['title']['font']['size'] = 32;
	if(empty($options['title']['font']['family'])) $options['title']['font']['family'] = 'Tahoma';
	if(empty($options['title']['text']['align'])) $options['title']['text']['align'] = 'left';
	if(empty($options['title']['textshadow']['horizontal'])) $options['title']['textshadow']['horizontal'] = 0;
	if(empty($options['title']['textshadow']['vertical'])) $options['title']['textshadow']['vertical'] = 0;
	if(empty($options['title']['textshadow']['blur'])) $options['title']['textshadow']['blur'] = 0;
	if(empty($options['title']['textshadow']['color'])) $options['title']['textshadow']['color'] = '#020202';
	if(empty($options['title']['textshadow']['opacity'])) $options['title']['textshadow']['opacity'] = 23;

	if(empty($options['content']['font']['color'])) $options['content']['font']['color'] = '#8c8c8c';
	if(empty($options['content']['font']['family'])) $options['content']['font']['family'] = 'Times New Roman';

	if(empty($options['close']['text'])) $options['close']['text'] = __('CLOSE', EMCORE_SLUG);
	if(empty($options['close']['location'])) $options['close']['location'] = 'topright';
	if(empty($options['close']['position']['top'])) $options['close']['position']['top'] = 0;
	if(empty($options['close']['position']['left'])) $options['close']['position']['left'] = 0;
	if(empty($options['close']['position']['bottom'])) $options['close']['position']['bottom'] = 0;
	if(empty($options['close']['position']['right'])) $options['close']['position']['right'] = 0;
	if(empty($options['close']['padding'])) $options['close']['padding'] = 8;
	if(empty($options['close']['background']['color'])) $options['close']['background']['color'] = '#00b7cd';
	if(empty($options['close']['background']['opacity'])) $options['close']['background']['opacity'] = 100;
	if(empty($options['close']['font']['color'])) $options['close']['font']['color'] = '#ffffff';
	if(empty($options['close']['font']['size'])) $options['close']['font']['size'] = 12;
	if(empty($options['close']['font']['family'])) $options['close']['font']['family'] = 'Times New Roman';
	if(empty($options['close']['border']['style'])) $options['close']['border']['style'] = 'none';
	if(empty($options['close']['border']['color'])) $options['close']['border']['color'] = '#ffffff';
	if(empty($options['close']['border']['width'])) $options['close']['border']['width'] = 1;
	if(empty($options['close']['border']['radius'])) $options['close']['border']['radius'] = 0;
	if(empty($options['close']['boxshadow']['inset'])) $options['close']['boxshadow']['inset'] = 'no';
	if(empty($options['close']['boxshadow']['horizontal'])) $options['close']['boxshadow']['horizontal'] = 0;
	if(empty($options['close']['boxshadow']['vertical'])) $options['close']['boxshadow']['vertical'] = 0;
	if(empty($options['close']['boxshadow']['blur'])) $options['close']['boxshadow']['blur'] = 0;
	if(empty($options['close']['boxshadow']['spread'])) $options['close']['boxshadow']['spread'] = 0;
	if(empty($options['close']['boxshadow']['color'])) $options['close']['boxshadow']['color'] = '#020202';
	if(empty($options['close']['boxshadow']['opacity'])) $options['close']['boxshadow']['opacity'] = 23;
	if(empty($options['close']['textshadow']['horizontal'])) $options['close']['textshadow']['horizontal'] = 0;
	if(empty($options['close']['textshadow']['vertical'])) $options['close']['textshadow']['vertical'] = 0;
	if(empty($options['close']['textshadow']['blur'])) $options['close']['textshadow']['blur'] = 0;
	if(empty($options['close']['textshadow']['color'])) $options['close']['textshadow']['color'] = '#000000';
	if(empty($options['close']['textshadow']['opacity'])) $options['close']['textshadow']['opacity'] = 23;
	return $options;
}


add_filter('emodal_size_unit_options', 'emodal_core_size_unit_options',10);
function emodal_core_size_unit_options($options){
	return array_merge($options, array(
		// option => value
		__('PX', EMCORE_SLUG) => 'px',
		__('%', EMCORE_SLUG) => '%',
		__('EM', EMCORE_SLUG) => 'em',
		__('REM', EMCORE_SLUG) => 'rem',
	));
}

add_filter('emodal_border_style_options', 'emodal_core_border_style_options',10);
function emodal_core_border_style_options($options){
	return array_merge($options, array(
		// option => value
		__('None', EMCORE_SLUG) => 'none',
		__('Solid', EMCORE_SLUG) => 'solid',
		__('Dotted', EMCORE_SLUG) => 'dotted',
		__('Dashed', EMCORE_SLUG) => 'dashed',
		__('Double', EMCORE_SLUG) => 'double',
		__('Groove', EMCORE_SLUG) => 'groove',
		__('Inset', EMCORE_SLUG) => 'inset',
		__('Outset', EMCORE_SLUG) => 'outset',
		__('Ridge', EMCORE_SLUG) => 'ridge',
	));
}

add_filter('emodal_font_family_options', 'emodal_core_font_family_options',10);
function emodal_core_font_family_options($options){
	return array_merge($options, array(
		// option => value
		__('Sans-Serif', EMCORE_SLUG) => 'Sans-Serif',
		__('Tahoma', EMCORE_SLUG) => 'Tahoma',
		__('Georgia', EMCORE_SLUG) => 'Georgia',
		__('Comic Sans MS', EMCORE_SLUG) => 'Comic Sans MS',
		__('Arial', EMCORE_SLUG) => 'Arial',
		__('Lucida Grande', EMCORE_SLUG) => 'Lucida Grande',
		__('Times New Roman', EMCORE_SLUG) => 'Times New Roman',
	));
}

add_filter('emodal_text_align_options', 'emodal_core_text_align_options',10);
function emodal_core_text_align_options($options){
	return array_merge($options, array(
		// option => value
		__('Left', EMCORE_SLUG) => 'left',
		__('Center', EMCORE_SLUG) => 'center',
		__('Right', EMCORE_SLUG) => 'right'
	));
}


add_filter('emodal_modal_display_size_options', 'emodal_dropdown_divider',20);
function emodal_dropdown_divider($options){
	return array_merge($options, array(
		// value => option
		__('-----------------------') => ''
	));
}

add_filter('emodal_modal_display_size_options', 'emodal_modal_display_size_options_responsive',10);
function emodal_modal_display_size_options_responsive($options){
	return array_merge($options, array(
		// option => value
		__('Auto', EMCORE_SLUG) => 'auto',
		__('Responsive', EMCORE_SLUG) => '',
		__('Normal', EMCORE_SLUG) => 'normal',
		__('Nano', EMCORE_SLUG) => 'nano',
		__('Tiny', EMCORE_SLUG) => 'tiny',
		__('Small', EMCORE_SLUG) => 'small',
		__('Medium', EMCORE_SLUG) => 'medium',
		__('Large', EMCORE_SLUG) => 'large',
		__('X Large', EMCORE_SLUG) => 'x-large'
	));
}

add_filter('emodal_modal_display_size_options', 'emodal_modal_display_size_options_nonresponsive',30);
function emodal_modal_display_size_options_nonresponsive($options){
	return array_merge($options, array(
		// value => option
		'<strong>' . __('Non-Responsive', EMCORE_SLUG) . '</strong>' => '',
		__('Custom', EMCORE_SLUG) => 'custom',
	));
}


add_filter('emodal_modal_display_animation_type_options', 'emodal_core_modal_display_animation_type_options',10);
function emodal_core_modal_display_animation_type_options($options){
	return array_merge($options, array(
		// option => value
		__('None', EMCORE_SLUG) => 'none',
		__('Slide', EMCORE_SLUG) => 'slide',
		__('Fade', EMCORE_SLUG) => 'fade',
		__('Fade and Slide', EMCORE_SLUG) => 'fadeAndSlide',
		__('Grow', EMCORE_SLUG) => 'grow',
		__('Grow and Slide', EMCORE_SLUG) => 'growAndSlide',
	));
}


add_filter('emodal_modal_display_animation_origin_options', 'emodal_core_modal_display_animation_origins_options',10);
function emodal_core_modal_display_animation_origins_options($options){
	return array_merge($options, array(
		// option => value
		__('Top', EMCORE_SLUG) => 'top',
		__('Left', EMCORE_SLUG) => 'left',
		__('Bottom', EMCORE_SLUG) => 'bottom',
		__('Right', EMCORE_SLUG) => 'right',
		__('Top Left', EMCORE_SLUG) => 'left top',
		__('Top Center', EMCORE_SLUG) => 'center top',
		__('Top Right', EMCORE_SLUG) => 'right top',
		__('Middle Left', EMCORE_SLUG) => 'left center',
		__('Middle Center', EMCORE_SLUG) => 'center center',
		__('Middle Right', EMCORE_SLUG) => 'right center',
		__('Bottom Left', EMCORE_SLUG) => 'left bottom',
		__('Bottom Center', EMCORE_SLUG) => 'center bottom',
		__('Bottom Right', EMCORE_SLUG) => 'right bottom',
		//__('Mouse', EMCORE_SLUG) => 'mouse',
	));
}

add_filter('emodal_modal_display_location_options', 'emodal_core_modal_display_location_options',10);
function emodal_core_modal_display_location_options($options){
	return array_merge($options, array(
		// option => value
		__('Top Left', EMCORE_SLUG) => 'left top',
		__('Top Center', EMCORE_SLUG) => 'center top',
		__('Top Right', EMCORE_SLUG) => 'right top',
		__('Middle Left', EMCORE_SLUG) => 'left center',
		__('Middle Center', EMCORE_SLUG) => 'center ',
		__('Middle Right', EMCORE_SLUG) => 'right center',
		__('Bottom Left', EMCORE_SLUG) => 'left bottom',
		__('Bottom Center', EMCORE_SLUG) => 'center bottom',
		__('Bottom Right', EMCORE_SLUG) => 'right bottom',
	));
}

add_filter('emodal_theme_close_location_options', 'emodal_core_theme_close_location_options',10);
function emodal_core_theme_close_location_options($options){
	return array_merge($options, array(
		// option => value
		__('Top Left', EMCORE_SLUG) => 'topleft',
		__('Top Right', EMCORE_SLUG) => 'topright',
		__('Bottom Left', EMCORE_SLUG) => 'bottomleft',
		__('Bottom Right', EMCORE_SLUG) => 'bottomright',
	));
}