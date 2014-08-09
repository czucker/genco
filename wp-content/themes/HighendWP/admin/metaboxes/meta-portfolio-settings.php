<?php
$revolutionslider = array();
$revolutionslider[] = array(
	'value' => 'none',
	'label' => __('None' , 'hbthemes')
	);

if(class_exists('RevSlider')){
    $slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	foreach($arrSliders as $revSlider) { 
		$revolutionslider[] = array(
			'value' => $revSlider->getAlias(),
			'label' => $revSlider->getTitle()
		);
	}
}

return array(
	array(
		'type' => 'select',
		'name' => 'hb_featured_section_type',
		'label' => __('Featured Section','hbthemes'),
		'description' => __('Choose what to display in the featured section of the portfolio page.','hbthemes'),
		'items' => array(
			array(
				'value' => 'hide',
				'label' => __('Hide', 'hbthemes'),
			),
			array(
				'value' => 'featured_image',
				'label' => __('Featured Image', 'hbthemes'),
			),
			array(
				'value' => 'alternative_image',
				'label' => __('Alternative Image', 'hbthemes'),
			),
			array(
				'value' => 'video',
				'label' => __('Video', 'hbthemes'),
			),
			array(
				'value' => 'revslider',
				'label' => __('Revolution Slider', 'hbthemes'),
			),
			array(
				'value' => 'flexslider',
				'label' => __('Flexslider', 'hbthemes'),
			),
		),
		'default' => 'hide',
	),
	array(
		'type' => 'upload',
		'name' => 'hb_portfolio_alternative_image',
		'label' => __('Alternative Featured Image', 'hbthemes'),
		'description' => __('Upload an image different from the default Featured image. This one will show on your portfolio item page.', 'hbthemes'),
		'default' => "",
		'dependency' => array(
			'field' => 'hb_featured_section_type',
		    'function' => 'hb_featured_section_type_alternative_image',
		),
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_portfolio_video',
		'label' => __('Video Link', 'hbthemes'),
		'description' => __('Enter a link to the video representing this item.', 'hbthemes'),
		'default' => "",
		'dependency' => array(
			'field' => 'hb_featured_section_type',
		    'function' => 'hb_featured_section_type_video',
		),
	),
	array(
		'type' => 'select',
		'description' => __('Choose a Revolution Slider to represent your portfolio item.', 'hbthemes'),
		'name' => 'hb_portfolio_rev_sliders',
		'label' => __('Revolution Slider', 'hbthemes'),
		'items' => $revolutionslider,
		'dependency' => array(
			'field' => 'hb_featured_section_type',
		    'function' => 'hb_featured_section_type_revslider',
		),
	),

	array(
    	'type' => 'toggle',
        'name' => 'hb_portfolio_button',
        'label' => __('Add Demo Button','hbthemes'),
        'description' => __('Add a button which will be titled as specified and will lead to a link describing or showcasing your portfolio item.','hbthemes'),
        'default' => true,
    ),
    array(
		'type' => 'textbox',
		'name' => 'hb_portfolio_button_title',
		'label' => __('Button Title', 'hbthemes'),
		'default' => 'Launch The Project',
		'description' => __('Enter the custom custom title.', 'hbthemes'),
		'dependency' => array(
			'field' => 'hb_portfolio_button',
		    'function' => 'vp_dep_boolean',
		),
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_portfolio_button_link',
		'label' => __('Button Link', 'hbthemes'),
		'description' => __('Enter the link which to your portfolio item.', 'hbthemes'),
		'default' => '',
		'dependency' => array(
			'field' => 'hb_portfolio_button',
		    'function' => 'vp_dep_boolean',
		),
	),
	array(
    	'type' => 'toggle',
        'name' => 'hb_portfolio_button_target',
        'label' => __('Open Link In New Tab','hbthemes'),
        'description' => __('Set if the button will open the link in a new tab.','hbthemes'),
        'default' => true,
        'dependency' => array(
			'field' => 'hb_portfolio_button',
		    'function' => 'vp_dep_boolean',
		),
    ),
);
?>