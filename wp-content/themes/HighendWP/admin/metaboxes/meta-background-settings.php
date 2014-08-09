<?php
return array(

	array(
		'type' => 'select',
		'name' => 'hb_background_page_settings',
		'description' => __('Change the background of this page or use the Default Theme Options Settings.','hbthemes'),
		'label' => __('Background Settings', 'hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'image',
				'label' => __('Image', 'hbthemes'),
			),
			array(
				'value' => 'color',
				'label' => __('Solid Color', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'color',
		'name' => 'hb_page_background_color',
		'label' => __('Solid Color', 'hbthemes'),
		'description' => __('Choose a solid color for your background.','hbthemes'),
		'default' => '',
		'dependency' => array(
			'field' => 'hb_background_page_settings',
			'function' => 'hb_background_color_page_settings_dependency',
		),
	),

	array(
		'type' => 'upload',
		'name' => 'hb_page_background_image',
		'label' => __('Background Image', 'hbthemes'),
		'description' => __('Upload an image for your background.','hbthemes'),
		'default' => '',
		'dependency' => array(
			'field' => 'hb_background_page_settings',
			'function' => 'hb_background_image_page_settings_dependency',
		),
	),
	array(
		'type' => 'color',
		'name' => 'hb_content_background_color',
		'label' => __('Content Background Color', 'hbthemes'),
		'description' => __('Specify the color of the content area.','hbthemes'),
		'default' => '',
	),

);
?>