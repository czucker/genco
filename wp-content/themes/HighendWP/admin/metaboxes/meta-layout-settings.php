<?php

$sidebar_list = array( array('value' => '', 'label' => 'None') );
$sidebar_list[] = array(
	'value' => 'hb-default-sidebar',
	'label' => __('Default Sidebar', 'hbthemes'),
);
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
		'name' => 'hb_page_layout_sidebar',
		'label' => __('Page Layout', 'hbthemes'),
		'description' => __('Choose a page sidebar layout.', 'hbthemes'),
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
				'value' => 'right-sidebar',
				'label' => __('Right Sidebar', 'hbthemes'),
			),
			array(
				'value' => 'left-sidebar',
				'label' => __('Left Sidebar', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'select',
		'name' => 'hb_choose_sidebar',
		'label' => __('Sidebars', 'hbthemes'),
		'items' => $sidebar_list,
		'default' => '',
		'dependency' => array(
			'field' => 'hb_page_layout_sidebar',
			'function' => 'hb_page_layout_sidebar_dependency',
		),
	),
	array(
		'type' => 'select',
		'name' => 'hb_footer_widgets',
		'label' => __('Footer Widgets','hbthemes'),
		'description' => __('Choose if you want to display the footer area with widgets.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'show',
				'label' => __('Show Widgets', 'hbthemes'),
			),
			array(
				'value' => 'hide',
				'label' => __('Hide Widgets', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'select',
		'name' => 'hb_pre_footer_callout',
		'label' => __('Footer Callout Area','hbthemes'),
		'description' => __('Choose if you want to display the pre footer callout area.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'show',
				'label' => __('Show Pre Footer Area', 'hbthemes'),
			),
			array(
				'value' => 'hide',
				'label' => __('Hide Pre Footer Area', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'select',
		'name' => 'hb_header_widgets',
		'label' => __('Header Widgets','hbthemes'),
		'description' => __('Choose if you want to display the header area with widgets.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'show',
				'label' => __('Show Widgets', 'hbthemes'),
			),
			array(
				'value' => 'hide',
				'label' => __('Hide Widgets', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
);
?>