<?php
$sidebar_list = array( array('value' => '', 'label' => 'None') );
$generated_sidebars = get_option('sbg_sidebars');
if ( !empty ($generated_sidebars) ){
	foreach ($generated_sidebars as $sidebar_key => $sidebar_value) {
		$sidebar_list[] = array(
			'value' => $sidebar_value,
			'label' => $sidebar_value,
		);
	}
}


return array(
	array(
		'type' => 'select',
		'name' => 'hb_portfolio_content_layout',
		'label' => __('Content Layout', 'hbthemes'),
		'description' => __('Choose a content layout for the portfolio item page.', 'hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'fullwidth',
				'label' => __('Fullwidth', 'hbthemes'),
			),
			array(
				'value' => 'metasidebar',
				'label' => __('With Meta Details Sidebar', 'hbthemes'),
			),
			array(
				'value' => 'wpsidebar',
				'label' => __('With Widget Area Sidebar', 'hbthemes'),
			),
		),
		'default' => 'default',						
	),
	array(
		'type' => 'select',
		'name' => 'hb_portfolio_sidebar_position',
		'label' => __('Sidebar Position', 'hbthemes'),
		'description' => __('Choose on which side will the sidebar appear.', 'hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'left-sidebar',
				'label' => __('Left Sidebar', 'hbthemes'),
			),
			array(
				'value' => 'right-sidebar',
				'label' => __('Right Sidebar', 'hbthemes'),
			),
		),
		'default' => 'default',		
		'dependency' => array(
			'field' => 'hb_portfolio_content_layout',
			'function' => 'hb_portfolio_sidebar_position',
		),				
	),
	array(
		'type'        => 'textbox',
	    'name'        => 'hb_meta_sidebar_title',
	    'label'       => __('Meta Sidebar Title', 'hbthemes'),
	    'description' => __('Define the meta sidebar title.', 'hbthemes'),
	),
	array(
	    'type'      => 'group',
	    'repeating' => true,
	    'name'      => 'hb_meta_details',
	    'sortable' => true,
	    'title'     => __('Meta Sidebar Item', 'hbthemes'),
		'description' => __('Add as many items by clicking the Add More button.', 'hbthemes'),
	    'fields'    => array(
	        array(
	            'type'        => 'textbox',
	            'name'        => 'hb_meta_sidebar_detail',
	            'label'       => __('Detail Title', 'hbthemes'),
	            'description' => __('Define the detail title.', 'hbthemes'),
	        ),
	        array(
	            'type'        => 'textarea',
	            'name'        => 'hb_meta_sidebar_detail_content',
	            'label'       => __('Detail Content', 'hbthemes'),
	            'description' => __('Define the detail content.', 'hbthemes'),
	        ),
	    ),
	),
	array(
		'type' => 'select',
		'name' => 'hb_choose_sidebar',
		'label' => __('WordPress Sidebar', 'hbthemes'),
		'items' => $sidebar_list,
		'default' => '',
		'description' => __('Choose a sidebar generated in the Sidebar Manager.', 'hbthemes'),
	),
);
?>