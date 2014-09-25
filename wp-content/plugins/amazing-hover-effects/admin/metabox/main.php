<?php



return array(
	array(
		'type'      => 'group',
		'repeating' => true,
		'sortable'  => true,
		'name'      => 'hover_info',
		'priority'  => 'high',
		'title'     => __('Hover Info', 'vp_textdomain'),
		'fields'    => array(
		
		
		
				array(
    'type' => 'notebox',
    'name' => 'nb_1',
    'label' => __('Author Comment', 'vp_textdomain'),
    'description' => __('If you want to enable this awesome features, simply buy pro version here <a href="http://www.bolobd.com/plugins/amazing-hover-effects/">Amazing Hover Effects Pro</a>', 'vp_textdomain'),
    'status' => 'info',
    ),
	
			array(
					'type' => 'upload',
					'name' => 'image',
					'label' => __('Hover Image', 'vp_textdomain'),
				),
				
				
			array(
				'type'  => 'textbox',
				'name'  => 'title',
				'label' => __('Heading', 'vp_textdomain'),
				'default' => 'Heading Here',
				
			),			
			
			
			array(
				'type'  => 'textarea',
				'name'  => 'description',
				'label' => __('Description', 'vp_textdomain'),
				'default' => 'Description goes here',
			),
			
			
				array(
				'type'  => 'textbox',
				'name'  => 'link',
				'label' => __('Image Link (Pro Only)', 'vp_textdomain'),
				'default' => '#',
			),

		),
	),
);

/**
 * EOF
 */