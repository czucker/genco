<?php 
return array(
	array(
		'type' => 'toggle',
		'name' => 'hb_hide_featured_image',
		'label' => __('Hide Featured Image', 'hbthemes'),
		'default' => '0',
		'description' => __('Check this box if you want to hide the featured image output on this single page/post.', 'hbthemes'),
	),
	array(
		'type' => 'select',
		'name' => 'hb_breadcrumbs',
		'label' => __('Breadrumbs.','hbthemes'),
		'description' => __('Choose whether to show the breadcrumbs on this page.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'show',
				'label' => __('Show', 'hbthemes'),
			),
			array(
				'value' => 'hide',
				'label' => __('Hide', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_page_title_h1',
		'label' => __('Title', 'hbthemes'),
		'default' => '',
		'description' => __('Enter the custom page title.', 'hbthemes'),
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_page_subtitle',
		'label' => __('Subtitle', 'hbthemes'),
		'description' => __('Enter the page subtitle.', 'hbthemes'),
		'default' => '',
	),
	array(
		'type' => 'select',
		'name' => 'hb_page_title_option',
		'label' => __('Page Title Advanced Settings.','hbthemes'),
		'description' => __('Choose whether to use the Theme Options Settings or set Custom Settings.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'custom',
				'label' => __('Custom', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type'      => 'group',
		'repeating' => false,
		'length'    => 1,
		'name'      => 'hb_title_settings_group',
		'title'     => __('Page Title Advanced Settings', 'hbthemes'),
		'fields'    => array(
			array(
				'type' => 'radiobutton',
				'name' => 'hb_page_title_type',
				'label' => __('Title Layout', 'hbthemes'),
				'description' => __('Select one of the following title layouts.', 'hbthemes'),
				'items' => array(
					array(
						'value' => 'none',
						'label' => __('Hide Page Title', 'hbthemes'),
					),
					array(
						'value' => 'hb-color-background',
						'label' => __('Page Title with Simple Background Color', 'hbthemes'),
					),
					array(
						'value' => 'hb-image-background',
						'label' => __('Page Title with Background Image', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_type'),
				),
			),
			array(
				'type' => 'color',
				'name' => 'hb_page_title_background_color',
				'label' => __('Background Color', 'hbthemes'),
				'dependency' => array(
					'field' => 'hb_page_title_type',
					'function' => 'hb_page_title_background_color_dependency',
				),
				'default' => hb_options('hb_page_title_background_color')
			),
			array(
				'type' => 'upload',
				'name' => 'hb_page_title_background_image',
				'label' => __('Custom Image', 'hbthemes'),
				'description' => __('Upload an image different from the default image set in the Theme Options. ', 'hbthemes'),
				'default' => hb_options('hb_page_title_background_image'),
				'dependency' => array(
					'field' => 'hb_page_title_type',
					'function' => 'hb_page_title_background_image_dependency',
				),
			),
			array(
				'type' => 'toggle',
				'name' => 'hb_page_title_background_image_parallax',
				'label' => __('Parallax', 'hbthemes'),
				'default' => hb_options('hb_page_title_background_image_parallax'),
				'description' => __('Enable Parallax effect on the uploaded image.', 'hbthemes'),
				'dependency' => array(
					'field' => 'hb_page_title_type',
					'function' => 'hb_page_title_background_image_dependency',
				),
			),
			array(
				'type' => 'radiobutton',
				'name' => 'hb_page_title_alignment',
				'label' => __('Alignment', 'hbthemes'),
				'description' => __('Choose title and subtitle alignment.', 'hbthemes'),
				'items' => array(
					array(
						'value' => 'alignleft',
						'label' => __('Left', 'hbthemes'),
					),
					array(
						'value' => 'aligncenter',
						'label' => __('Center', 'hbthemes'),
					),
					array(
						'value' => 'alignright',
						'label' => __('Right', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_alignment'),
				),						
			),
			array(
				'type' => 'radiobutton',
				'name' => 'hb_page_title_style',
				'label' => __('Style', 'hbthemes'),
				'description' => __('Choose between simple, fancy and bordered style.', 'hbthemes'),
				'items' => array(
					array(
						'value' => '',
						'label' => __('Simple', 'hbthemes'),
					),
					array(
						'value' => 'stroke-title',
						'label' => __('Fancy', 'hbthemes'),
					),
					array(
						'value' => 'border-style',
						'label' => __('Bordered', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_style'),
				),
			),
			array(
				'type' => 'select',
				'name' => 'hb_page_title_height',
				'description' => __('Select a the height of the Page Title Section.','hbthemes'),
				'label' => __('Choose Height Scheme', 'hbthemes'),
				'items' => array(
					array(
						'value' => 'extra-large-padding',
						'label' => __('Extra Large', 'hbthemes'),
					),
					array(
						'value' => 'large-padding',
						'label' => __('Large', 'hbthemes'),
					),
					array(
						'value' => 'normal-padding',
						'label' => __('Normal', 'hbthemes'),
					),
					array(
						'value' => 'small-padding',
						'label' => __('Small', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_height'),
				),
			),
			array(
				'type' => 'select',
				'name' => 'hb_page_title_color',
				'description' => __('Select a color scheme for your page title.','hbthemes'),
				'label' => __('Choose Color Scheme', 'hbthemes'),
				'items' => array(
					array(
						'value' => 'light-text',
						'label' => __('Light Text', 'hbthemes'),
					),
					array(
						'value' => 'dark-text',
						'label' => __('Dark Text', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_color'),
				),
			),
			array(
				'type' => 'select',
				'name' => 'hb_page_title_animation',
				'label' => __('Title Animation', 'hbthemes'),
				'description' => __('Select an entrance animation for the title.','hbthemes'),
				'items' => array(
					array(
						'value' => '',
						'label' => __('None', 'hbthemes'),
					),
					array(
						'value' => 'bounce-up',
						'label' => __('Bounce Up', 'hbthemes'),
					),
					array(
						'value' => 'bottom-to-top',
						'label' => __('Bottom To Top', 'hbthemes'),
					),
					array(
						'value' => 'top-to-bottom',
						'label' => __('Top To Bottom', 'hbthemes'),
					),
					array(
						'value' => 'left-to-right',
						'label' => __('Left To Right', 'hbthemes'),
					),
					array(
						'value' => 'right-to-left',
						'label' => __('Right To Left', 'hbthemes'),
					),
					array(
						'value' => 'scale-up',
						'label' => __('Scale Up', 'hbthemes'),
					),
					array(
						'value' => 'fade-in',
						'label' => __('Fade In', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_animation'),
				),
				'dependency' => array(
					'field' => 'hb_page_title_type',
					'function' => 'hb_page_title_h1_dependency',
				),
			),
			array(
				'type' => 'select',
				'name' => 'hb_page_title_subtitle_animation',
				'description' => __('Select an entrance animation for the subtitle.','hbthemes'),
				'label' => __('Subtitle Animation', 'hbthemes'),
				'items' => array(
					array(
						'value' => '',
						'label' => __('None', 'hbthemes'),
					),
					array(
						'value' => 'bounce-up',
						'label' => __('Bounce Up', 'hbthemes'),
					),
					array(
						'value' => 'bottom-to-top',
						'label' => __('Bottom To Top', 'hbthemes'),
					),
					array(
						'value' => 'top-to-bottom',
						'label' => __('Top To Bottom', 'hbthemes'),
					),
					array(
						'value' => 'left-to-right',
						'label' => __('Left To Right', 'hbthemes'),
					),
					array(
						'value' => 'right-to-left',
						'label' => __('Right To Left', 'hbthemes'),
					),
					array(
						'value' => 'scale-up',
						'label' => __('Scale Up', 'hbthemes'),
					),
					array(
						'value' => 'fade-in',
						'label' => __('Fade In', 'hbthemes'),
					),
				),
				'default' => array(
					hb_options('hb_page_title_subtitle_animation'),
				),
				'dependency' => array(
					'field' => 'hb_page_title_type',
					'function' => 'hb_page_title_h1_dependency',
				),
			),
		),
		'dependency' => array(
			'field' => 'hb_page_title_option',
			'function' => 'hb_page_title_options',
		),
	),
); 
?>