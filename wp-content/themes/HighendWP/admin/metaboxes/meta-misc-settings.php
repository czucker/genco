<?php 
$all_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) ); 

$field_menus = array();
if ( !empty($all_menus) )
{
	foreach ($all_menus as $menu) {
		$field_menus[] = array(
			'value' => $menu->slug,
			'label' => $menu->name,
		);
	}
}

return array(
	array(
		'type' => 'select',
		'name' => 'hb_boxed_stretched_page',
		'label' => __('Boxed or Stretched Layout','hbthemes'),
		'description' => __('Choose between stretched and boxed layout or use the Default Theme Options Settings.','hbthemes'),
		'items' => array(
			array(
				'value' => 'default',
				'label' => __('Use Highend Options Settings', 'hbthemes'),
			),
			array(
				'value' => 'hb-boxed-layout',
				'label' => __('Boxed', 'hbthemes'),
			),
			array(
				'value' => 'hb-stretched-layout',
				'label' => __('Stretched', 'hbthemes'),
			),
		),
		'default' => 'default',
	),
	array(
		'type' => 'toggle',
		'name' => 'hb_onepage',
		'label' => __('Enable One Page Elements','hbthemes'),
		'description' => __('Check this box in order to enable one page features such as one-page navigation (set in Appearance > Menus) and one page sections. This is REQUIRED if you want to use One Page for your website. Create sub-pages inside this page by using One Page Sections from the Visual Composer elements. Note that sidebars are not available for One Page website.','hbthemes'),
		'default' => false,
	),
	array(
		'type' => 'toggle',
		'name' => 'hb_onepage_also',
		'label' => __('Use One Page menu for Mobile Menu?','hbthemes'),
		'description' => __('Check this box if you want to use the One Page menu as your Mobile Menu for this page.','hbthemes'),
		'default' => false,
	),
	array(
		'type' => 'textbox',
		'name' => 'hb_page_extra_class',
		'label' => __('Extra Classes', 'hbthemes'),
		'default' => '',
		'description' => __('Enter an extra class for this page. Separate each class with a blank space.', 'hbthemes'),
	),	
	array(
		'type' => 'toggle',
		'name' => 'hb_disable_navigation',
		'label' => __('Disable Main Navigation Menu','hbthemes'),
		'description' => __('Check this box in order to disable the main menu navigation on the current page.','hbthemes'),
		'default' => false,
	),
	array(
		'type' => 'toggle',
		'name' => 'hb_special_header_style',
		'label' => __('Enable Special Header Style','hbthemes'),
		'description' => __('Enable this field if you want to enable the special header style. Please note that this will override the Header Style settings from the Theme Options on this page only.','hbthemes'),
		'default' => false,
	),
	array(
		'type' => 'upload',
		'name' => 'hb_page_alternative_logo',
		'label' => __('Alternative Logo', 'hbthemes'),
		'description' => __('Upload an alternative logo for this page. This will replace the default logo set in the Theme Options','hbthemes'),
		'default' => '',
	),

); ?>