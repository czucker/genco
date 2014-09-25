<?php



return array(
	array(
		'type'      => 'group',
		'repeating' => false,
		'sortable'  => true,
		'name'      => 'effects',
		'priority'  => 'high',
		'title'     => __('Hover Effects Setting', 'vp_textdomain'),
		
		'fields' => array(				

				array(
    'type' => 'notebox',
    'name' => 'nb_1',
    'label' => __('Author Comment', 'vp_textdomain'),
    'description' => __('If you want to enable this awesome features, simply buy pro version here <a href="http://www.bolobd.com/plugins/amazing-hover-effects/">Amazing Hover Effects Pro</a>', 'vp_textdomain'),
    'status' => 'info',
    ),

				array(
					'type' => 'select',
					'name' => 'effect',
					'label' => __('Effect', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => 'effect1',
							'label' => 'effect1',
						),
						array(
							'value' => 'effect2',
							'label' => 'effect2',
						),		
						array(
							'value' => 'effect3',
							'label' => 'effect3',
						),
						array(
							'value' => 'effect4',
							'label' => 'effect4',
						),	
						array(
							'value' => 'effect5',
							'label' => 'effect5',
						),
						array(
							'value' => 'effect6',
							'label' => 'effect6',
						),		
						array(
							'value' => 'effect7',
							'label' => 'effect7',
						),
						array(
							'value' => 'effect11',
							'label' => 'effect8',
						),		
						array(
							'value' => 'effect9',
							'label' => 'effect9',
						),
						array(
							'value' => 'effect14',
							'label' => 'effect10',
						),
						array(
							'value' => 'effect15',
							'label' => 'effect11',
						),
						array(
							'value' => 'effect12',
							'label' => 'effect12',
						),
						array(
							'value' => 'effect16',
							'label' => 'effect13',
						),

					),
				),
					
					
				array(
					'type' => 'select',
					'name' => 'animation',
					'label' => __('Animation Direction', 'vp_textdomain'),
					'default' => array(
								'{{first}}',
								),
					'items' => array(
						array(
							'value' => 'left_to_right',
							'label' => 'Left To Right',
						),
						array(
							'value' => 'right_to_left',
							'label' => 'Right To Left',
						),	
						array(
							'value' => 'top_to_bottom',
							'label' => 'Top To Bottom',
						),	
						array(
							'value' => 'bottom_to_top',
							'label' => 'Bottom To Top',
						),

					),
				),	
				
				
				array(
					'type' => 'radiobutton',
					'name' => 'colored',
					'label' => __('Colored?', 'vp_textdomain'),
					'items' => array(
						array(
							'value' => 'colored',
							'label' => __('Yes', 'vp_textdomain'),
						),
						array(
								'value' => '',
								'label' => __('No', 'vp_textdomain'),
				),
					),
				),
			
							array(
					'type' => 'slider',
					'name' => 'width',
					'label' => __('Image Width', 'vp_textdomain'),
					'description' => __('(Pro Only)', 'vp_textdomain'),
					'min' => '100',
					'max' => '300',
					'step' => '1',
					'default' => '220',
				),	
				
				array(
					'type' => 'slider',
					'name' => 'height',
					'label' => __('Image Height', 'vp_textdomain'),
					'description' => __('(Pro Only)', 'vp_textdomain'),
					'min' => '100',
					'max' => '300',
					'step' => '1',
					'default' => '220',
				),	

				array(
					'type' => 'slider',
					'name' => 'letf_right',
					'label' => __('Move Image Left Right', 'vp_textdomain'),
					'description' => __('(Pro Only)', 'vp_textdomain'),
					'min' => '-20',
					'max' => '100',
					'step' => '1',
					'default' => '12',
				),
		
			/*	array(
					'type' => 'notebox',
					'name' => 'nb_11',
					'label' => __('Info Announcement', 'vp_textdomain'),
					'description' => __('<a href="#">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas</a>', 'vp_textdomain'),
					'status' => 'info',
					),
			*/
		),
	),
);
		
		
?>