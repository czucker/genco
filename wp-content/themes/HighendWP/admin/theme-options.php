<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

$theme_files_url = get_template_directory_uri(). '/admin/assets/images/theme-files/';
$admin_email = get_option( 'admin_email' );
$theme_options_url = admin_url('themes.php?page=highend_options');

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

/* Read Textures Folder and convert to array */
$texture_images_path = get_template_directory(). '/admin/assets/images/textures/'; // change this to where you store your bg images
$texture_images_url = get_template_directory_uri().'/admin/assets/images/textures/'; // change this to where you store your bg images
$texture_images = array();
if ( is_dir($texture_images_path) ) {
    if ($texture_images_dir = opendir($texture_images_path) ) {
    	$text_counter = 0; 
        while ( ($texture_images_file = readdir($texture_images_dir)) !== false ) {
			if(stristr($texture_images_file, ".png") !== false || stristr($texture_images_file, ".jpg") !== false) {
				$texture_images[$text_counter] = $texture_images_url . $texture_images_file;
				$text_counter++;
			}
		}   
	}
}

$texture_images_array = array();
if ( !empty ($texture_images) ){
	$text_count = 0;
	foreach ($texture_images as $tex_image) {
		$texture_images_array[] = array(
			'value' => $tex_image,
			'label' => 'Texture ' . $text_count,
			'img' =>  $tex_image
		);
		$text_count++;
	}	
}

return array(
	'title' => __('Highend Theme Options', 'hbthemes'),
	'logo'  => $theme_files_url . 'highend_logo.png',
	'menus' => array(
		array(
			'title' => __('General Settings', 'hbthemes'),
			'name' => 'hb_general_settings',
			'icon' => 'font-awesome:hb-moon-settings',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_general_notebox_5',
					'label' => __('Import Demo Content?', 'hbthemes'),
					'description' => __('<p>If you would like to import the demo content, please go to the <strong>Demo Importer</strong> section.</p><p>By importing the demo content you will get the same website as our demo.</p>', 'hbthemes'),
					'status' => 'normal',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_favicon',
					'label' => __('Favicon', 'hbthemes'),
					'description' => __('Upload a 16px x 16px png/gif image that will represent your website favicon.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_apple_icon',
					'label' => __('iOS Icon 57x57', 'hbthemes'),
					'description' => __('Upload a 57px x 57px png image that will be your website bookmark on non-retina iOS devices.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_apple_icon_72',
					'label' => __('iOS Icon 72x72', 'hbthemes'),
					'description' => __('Upload a 72px x 72px Png image that will be your website bookmark on non-retina iOS devices.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_apple_icon_114',
					'label' => __('iOS Icon 114x114', 'hbthemes'),
					'description' => __('Upload a 114px x 114px png image that will be your website bookmark on retina iOS devices.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_apple_icon_144',
					'label' => __('iOS Icon 144x144', 'hbthemes'),
					'description' => __('Upload a 144px x 144px png image that will be your website bookmark on retina iOS devices.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_ios_bookmark_title',
					'label' => __('Custom iOS Bookmark Title', 'hbthemes'),
					'description' => __('Enter a custom title for your site for when it is added as an iOS bookmark.', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_responsive',
					'label' => __('Responsive Design', 'hbthemes'),
					'description' => __('Enable/Disable the responsive behaviour of the theme', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_smooth_scrolling',
					'label' => __('Smooth Scrolling', 'hbthemes'),
					'description' => __('Enable/Disable the smooth scrolling effect with fancy scrollbar.', 'hbthemes'),
					'default' => '0',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_queryloader',
					'label' => __('Site Preloader', 'hbthemes'),
					'description' => __('Enable/Disable site preloader with fancy effect. If you have set your website logo in Theme Options, it will be used in preloader as well.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_disable_page_comments',
					'label' => __('Page Comments', 'hbthemes'),
					'description' => __('Enable/Disable comments on all pages except the post pages. It is possible to disable them individually using page meta settings.', 'hbthemes'),
					'default' => '0',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_breadcrumbs',
					'label' => __('Breadcrumbs', 'hbthemes'),
					'default' => '1',
					'description' => __('Enable/Disable breadcrumbs on your website. It is possible to disable them individually using page meta settings.', 'hbthemes'),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_to_top_button',
					'label' => __('Back To Top Button', 'hbthemes'),
					'description' => __('Enable/Disable the back to top button on your website.', 'hbthemes'),
					'default' => '1',
				),
				
				array(
					'type' => 'select',
					'name' => 'hb_pagination_style',
					'label' => __('Default Pagination Style', 'hbthemes'),
					'default' => 'standard',
					'items' => array(
						array(
							'value' => 'standard',
							'label' => __('Standard', 'hbthemes'),
						),
						array(
							'value' => 'ajax',
							'label' => __('Load More', 'hbthemes'),
						),
					),
					'description' => __('Choose between standard pagination and fancy ajax page loading. It is possible to choose this individually using page meta settings.','hbthemes'),
				),
				array(
					'type' => 'select',
					'name' => 'hb_back_to_top_icon',
					'label' => __('Back To Top Button Icon', 'hbthemes'),
					'description' => __('Choose an icon for the back to top button.', 'hbthemes'),
					'default' => 'hb-moon-arrow-up-4',
					'dependency' => array(
						'field' => 'hb_to_top_button',
						'function' => 'hb_background_image_repeat_dependency',
					),
					'items' => array(
						array(
							'value' => 'hb-moon-arrow-up-4',
							'label' => __('Default Arrow Up', 'hbthemes'),
						),
						array(
							'value' => 'icon-angle-up',
							'label' => __('Angle Up', 'hbthemes'),
						),
						array(
							'value' => 'icon-arrow-up',
							'label' => __('Bold Arrow Up', 'hbthemes'),
						),
						array(
							'value' => 'hb-moon-arrow-up-2',
							'label' => __('Triangle Arrow Up', 'hbthemes'),
						),
						array(
							'value' => 'hb-moon-arrow-up-15',
							'label' => __('Special Arrow Up', 'hbthemes'),
						),
						array(
							'value' => 'hb-moon-arrow-up',
							'label' => __('Bold Angle Up', 'hbthemes'),
						),

					),
				),
				array(
					'type' => 'codeeditor',
					'name' => 'hb_analytics_code',
					'label' => __('Tracking Code', 'hbthemes'),
					'description' => __('Enter your Google Analytics (or other) tracking code here. Remember to include the entire script, if you just enter your tracking ID it won\'t work. You need to enter the &lt;script&gt; tag. Ignore errors regarding script tag. ', 'hbthemes'),
					'theme' => 'github',
					'mode' => 'javascript',
				),
				array(
					'type' => 'codeeditor',
					'name' => 'hb_custom_script',
					'label' => __('Custom Script', 'hbthemes'),
					'description' => __('Javascript that will be executed on document ready. Do not type the &lt;script&gt; tag.', 'hbthemes'),
					'theme' => 'github',
					'mode' => 'javascript',
				),
				array(
					'type' => 'codeeditor',
					'name' => 'hb_custom_css',
					'label' => __('Custom CSS', 'hbthemes'),
					'description' => __('If you have any custom CSS you would like added to the site, please enter it here.', 'hbthemes'),
					'theme' => 'crimson_editor',
					'mode' => 'css',
				),
			),
		),
		array(
			'title' => __('Layout Settings', 'hbthemes'),
			'name' => 'hb_layout_settings',
			'icon' => 'font-awesome:icon-columns',
			'menus' => array(
				array(
					'title' => __('General Layout', 'hbthemes'),
					'name' => 'hb_general_layout_settings',
					'icon' => 'font-awesome:icon-th-large',
					'controls' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_global_layout',
							'label' => __('Choose Layout', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb-boxed-layout',
									'label' => __('Boxed', 'hbthemes'),
								),
								array(
									'value' => 'hb-stretched-layout',
									'label' => __('Stretched', 'hbthemes'),
								),
							),
							'default' => array(
								'hb-stretched-layout',
							),
						),
						array(
							'type' => 'section',
							'title' => __('Boxed Layout Settings', 'hbthemes'),
							'name' => 'hb_boxed_layout_settings',
							'dependency' => array(
								'field' => 'hb_global_layout',
								'function' => 'hb_global_layout_dependency',
								),
							'fields' => array(
									array(
										'type' => 'radiobutton',
										'name' => 'hb_boxed_layout_type',
										'label' => __('Choose Type', 'hbthemes'),
										'description' => __('Attached boxed layout has no margin at the top or bottom.','hbthemes'),
										'items' => array(
											array(
												'value' => 'hb_boxed_layout_attached',
												'label' => __('Attached', 'hbthemes'),
											),
											array(
												'value' => 'hb_boxed_layout_regular',
												'label' => __('With Margin', 'hbthemes'),
											),
										),
										'default' => array(
											'hb_boxed_layout_regular',
										),
									),
									array(
										'type' => 'toggle',
										'name' => 'hb_boxed_shadow',
										'label' => __('Container Shadow', 'hbthemes'),
										'description' => __('Toggle whether or not to show a shadow around your boxed layout.', 'hbthemes'),
										'default' => '1',
									),

									array(
										'type' => 'radiobutton',
										'name' => 'hb_upload_or_predefined_image',
										'label' => __('Background Image', 'hbthemes'),
										'description' => __('Your default background image. You can upload different image using meta fields for any page. Set background color in Color Manager section.', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'predefined-texture',
												'label' => __('Choose from built-in textures', 'hbthemes'),
											),
											array(
												'value' => 'upload-image',
												'label' => __('Upload your own image', 'hbthemes'),
											),
											array(
												'value' => 'plain-color',
												'label' => __('Plain color', 'hbthemes'),
											),
										),
										'default' => array(
											'predefined-texture',
										),
									),
									array(
								        'type' => 'radioimage',
								        'name' => 'hb_predefined_bg_texure',
								        'label' => __('Built-in Texture Images', 'vp_textdomain'),
								        'description' => __('Select a texture by clicking on it.', 'vp_textdomain'),
								        'item_max_height' => '70',
								        'item_max_width' => '70',
								        'items' => $texture_images_array,
								        'default' => array(
								            '{{first}}',
								        ),
								        'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_pred_dependency',
										),
								    ),

									array(
										'type' => 'upload',
										'name' => 'hb_default_background_image',
										'label' => __('Default Background Image', 'hbthemes'),
										'description' => __('Upload a default background image (or texture). This image can be changed individually for each page.', 'hbthemes'),
										'default' => '',
										'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_predefined_dependency',
										),

									),
									array(
										'type' => 'radiobutton',
										'name' => 'hb_background_repeat',
										'label' => __('Background Repeat', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'no-repeat',
												'label' => __('No Repeat', 'hbthemes'),
											),
											array(
												'value' => 'repeat',
												'label' => __('Repeat', 'hbthemes'),
											),
										),
										'default' => array(
											'no-repeat',
										),
										'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_predefined_dependency',
										),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'hb_background_attachment',
										'label' => __('Background Attachment', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'scroll',
												'label' => __('Scroll', 'hbthemes'),
											),
											array(
												'value' => 'fixed',
												'label' => __('Fixed', 'hbthemes'),
											),
										),
										'default' => array(
											'scroll',
										),
										'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_predefined_dependency',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_background_position',
										'label' => __('Background Position', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'left top',
												'label' => __('Left Top', 'hbthemes'),
											),
											array(
												'value' => 'left center',
												'label' => __('Left Center', 'hbthemes'),
											),
											array(
												'value' => 'left bottom',
												'label' => __('Left Bottom', 'hbthemes'),
											),
											array(
												'value' => 'right top',
												'label' => __('Right Top', 'hbthemes'),
											),
											array(
												'value' => 'right center',
												'label' => __('Right Center', 'hbthemes'),
											),
											array(
												'value' => 'right bottom',
												'label' => __('Right Bottom', 'hbthemes'),
											),
											array(
												'value' => 'center top',
												'label' => __('Center Top', 'hbthemes'),
											),
											array(
												'value' => 'center center',
												'label' => __('Center Center', 'hbthemes'),
											),
											array(
												'value' => 'center bottom',
												'label' => __('Center Bottom', 'hbthemes'),
											),
										),
										'default' => array(
											'center top',
										),
										'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_predefined_dependency',
										),
									),
									array(
										'type' => 'toggle',
										'name' => 'hb_background_stretch',
										'label' => __('Stretch Image', 'hbthemes'),
										'description' => __('Stretch Image to fit the browser dimensions.', 'hbthemes'),
										'default' => '1',
										'dependency' => array(
											'field' => 'hb_upload_or_predefined_image',
											'function' => 'hb_upload_or_predefined_dependency',
										),
									),
							),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'hb_content_width',
							'label' => __('Choose Content Width', 'hbthemes'),
							'description' => __('Choose between 940px, 1140px and full width. You can use any width by entering Custom CSS.' , 'hbthemes'),
							'items' => array(
								array(
									'value' => '940px',
									'label' => __('940px', 'hbthemes'),
								),
								array(
									'value' => '1140px',
									'label' => __('1140px', 'hbthemes'),
								),
								array(
									'value' => 'fw-100',
									'label' => __('Fullwidth 100%', 'hbthemes'),
								),
							),
							'default' => array(
								'1140px',
							),
						),
					),
				),
				array(
					'title' => __('Header Layout', 'hbthemes'),
					'name' => 'hb_header_layout_settings',
					'icon' => 'font-awesome:icon-picture',
					'controls' => array(
						array(
							'type' => 'notebox',
							'name' => 'hb_header_notebox_1',
							'label' => __('Header Layout Combinations', 'hbthemes'),
							'description' => __('Play around with the header layout settings and build hundreds of header combinations.', 'hbthemes'),
							'status' => 'normal',
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_top_header_bar',
							'label' => __('Top Header Bar', 'hbthemes'),
							'description' => __('Enable/Disable a bar on top of your website containing various infomation about your website.', 'hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'section',
							'title' => __('Top Header Settings', 'hbthemes'),
							'name' => 'hb_top_header_settings',
							'description' => __('You can leave some fields empty to ignore them.' , 'hbthemes'),
							'dependency' => array(
								'field' => 'hb_top_header_bar',
								'function' => 'vp_dep_boolean',
								),
							'fields' => array(
								array(
									'type' => 'radiobutton',
									'name' => 'hb_top_header_container',
									'label' => __('Top Header Container', 'hbthemes'),
									'description' => __('Choose between wide and aligned container. Wide container requires stretched layout.' , 'hbthemes'),
									'items' => array(
										array(
											'value' => 'container',
											'label' => __('Aligned Container', 'hbthemes'),
										),
										array(
											'value' => 'container-wide',
											'label' => __('Wide Container', 'hbthemes'),
										),
									),
									'default' => array(
										'container',
									),
								),
								/*
								array(
									'type' => 'radioimage',
									'name' => 'hb_header_bar_layout',
									'label' => __('Top Header Bar Style', 'hbthemes'),
									'description' => __('Choose your top header bar style.', 'hbthemes'),
									'item_max_height' => '80',
									'item_max_width' => '432',
									'items' => array(
										array(
											'value' => 'style-1',
											'label' => __('White Style', 'hbthemes'),
											'img' => 'http://placehold.it/432x80',
										),
										array(
											'value' => 'style-2',
											'label' => __('Grey Style', 'hbthemes'),
											'img' => 'http://placehold.it/432x80',
										),
										array(
											'value' => 'style-3',
											'label' => __('Dark Style', 'hbthemes'),
											'img' => 'http://placehold.it/432x80',
										),
										array(
											'value' => 'style-4',
											'label' => __('Secondary Color', 'hbthemes'),
											'img' => 'http://placehold.it/432x80',
										),
										array(
											'value' => 'style-5',
											'label' => __('Primary Color', 'hbthemes'),
											'img' => 'http://placehold.it/432x80',
										),
									),
									'default' => array(
										'style-1',
									),
								),*/

								array(
									'type' => 'textarea',
									'name' => 'hb_top_header_info_text',
									'label' => __('Left Widget: Info Text', 'hbthemes'),
									'description' => __('Enter a small description.', 'hbthemes'),
									'default' => 'Call us toll free <strong>0800 1800 900</strong>',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_map',
									'label' => __('Left Widget: Map Dropdown', 'hbthemes'),
									'description' => __('Show up a Google Map which is completely specified in the Map Settings. Map is opened when clicked on the button in the top bar.', 'hbthemes'),
									'default' => '1',
								),
								array(
									'type' => 'textbox',
									'name' => 'hb_top_header_map_text',
									'label' => __('Left Widget: Map Button Text', 'hbthemes'),
									'description' => __('Enter text for the map button. When users click on this map it will open your location on Google Maps.', 'hbthemes'),
									'default' => 'Find us on Map',
								),
								array(
									'type' => 'textbox',
									'name' => 'hb_top_header_email',
									'label' => __('Left Widget: Email', 'hbthemes'),
									'description' => __('Enter your contact email. Example: name@email.com. Default value is your admin email set in WordPress Settings. Feel free to change it.', 'hbthemes'),
									'default' => $admin_email,
									'validation' => 'email'
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_socials_enable',
									'label' => __('Right Widget: Social Icons', 'hbthemes'),
									'description' => __('Show social icons in top header section. Icons are pulled from the "Social Links" section.', 'hbthemes'),
									'default' => '1',
								),
								array(
                                    'type' => 'sorter',
                                    'name' => 'hb_top_header_socials',
                                    'label' => __('Social Networks', 'hbthemes'),
                                    'description' => __('Select and sort your social network choices. Don\'t forget to fill in your own profiles in "Social Links" section', 'hbthemes'),
                                    'items' => array(
                                        'data' => array(
                                        	array(
                                                'source' => 'function',
                                                'value' => 'hb_get_social_medias',
                                            ),
                                        ),
                                    ),
                                    'default' => '{{first}}',
                                    'dependency' => array(
										'field' => 'hb_top_header_socials_enable',
										'function' => 'vp_dep_boolean',
									),
                                ),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_login',
									'label' => __('Right Widget: Login', 'hbthemes'),
									'description' => __('Show login button in top header section. When logged-in, it will show a personal menu dropdown.', 'hbthemes'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_languages',
									'label' => __('Right Widget: WPML Languages', 'hbthemes'),
									'description' => __('Show language selector in top header section. Requires WPML plugin.', 'hbthemes'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_checkout',
									'label' => __('Right Widget: Checkout Button', 'hbthemes'),
									'description' => __('Show the checkout button for your e-shop. Requires WooCommerce plugin.', 'hbthemes'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_top_header_link',
									'label' => __('Right Widget: Custom Button', 'hbthemes'),
									'description' => __('Show a custom button in the top header bar.', 'hbthemes'),
									'default' => '0',
								),
								array(
							        'type' => 'fontawesome',
							        'name' => 'hb_top_header_link_icon',
							        'label' => __('Button Icon', 'hbthemes'),
							        'description' => __('Choose icon for the button.', 'hbthemes'),
							        'default' => array(
							            '{{first}}',
							        ),
							        'dependency' => array(
										'field' => 'hb_top_header_link',
										'function' => 'vp_dep_boolean',
									),
							    ),
								array(
									'type' => 'textbox',
									'name' => 'hb_top_header_link_txt',
									'label' => __('Button Title', 'hbthemes'),
									'description' => "",
									'default' => 'Enter your text here...',
									'dependency' => array(
										'field' => 'hb_top_header_link',
										'function' => 'vp_dep_boolean',
									),
								),
								array(
									'type' => 'textbox',
									'name' => 'hb_top_header_link_link',
									'label' => __('Button Link', 'hbthemes'),
									'description' => "",
									'default' => 'http://hb-themes.com',
									'dependency' => array(
										'field' => 'hb_top_header_link',
										'function' => 'vp_dep_boolean',
									),
								),
							),
						),
						array(
							'type' => 'section',
							'title' => __('Header Layout', 'hbthemes'),
							'name' => 'hb_general_header_settings',
							'description' => __('Fill in general header layout settings.' , 'hbthemes'),
							'fields' => array(
								array(
									'type' => 'radiobutton',
									'name' => 'hb_main_header_container',
									'label' => __('Main Header Container', 'hbthemes'),
									'description' => __('Choose between wide and aligned container for the main container where logo and navigation are located.' , 'hbthemes'),
									'items' => array(
										array(
											'value' => 'container',
											'label' => __('Aligned Container', 'hbthemes'),
										),
										array(
											'value' => 'container-wide',
											'label' => __('Wide Container', 'hbthemes'),
										),
									),
									'default' => array(
										'container',
									),
								),

								array(
									'type' => 'radioimage',
									'name' => 'hb_header_layout_style',
									'label' => __('Main Header Layout', 'hbthemes'),
									'description' => __('Choose your main header layout.', 'hbthemes'),
									'item_max_height' => '500',
									'item_max_width' => '1400',
									'items' => array(
										array(
											'value' => 'nav-type-1',
											'label' => __('Type 1 (Supports Sticky Header)', 'hbthemes'),
											'img' => $theme_files_url . '/header-1.png',
										),
										array(
											'value' => 'nav-type-2',
											'label' => __('Type 2', 'hbthemes'),
											'img' => $theme_files_url . '/header-2.png',
										),
										array(
											'value' => 'nav-type-2 centered-nav',
											'label' => __('Type 3 (Supports Sticky Header)', 'hbthemes'),
											'img' => $theme_files_url . '/header-3.png',
										),
									),
									'default' => array(
										'nav-type-1',
									),
								),
								
								array(
									'type' => 'radiobutton',
									'name' => 'hb_logo_alignment',
									'label' => __('Logo Alignment', 'hbthemes'),
									'description' => __('Select Alignment for your logo.' , 'hbthemes'),
									'items' => array(
										array(
											'value' => '',
											'label' => __('Left', 'hbthemes'),
										),
										array(
											'value' => ' align-logo-right',
											'label' => __('Right', 'hbthemes'),
										),
									),
									'default' => '{{first}}',
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_logo_align_dependency',
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_sticky_header_alt',
									'label' => __('Sticky Header', 'hbthemes'),
									'description' => __('Enable sticky header.', 'hbthemes'),
									'default' => '0',
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_sticky_header_dependency_alt',
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_sticky_header',
									'label' => __('Sticky Header', 'hbthemes'),
									'description' => __('Enable sticky header.', 'hbthemes'),
									'default' => '1',
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_sticky_header_dependency',
									),
								),
								array(
									'type' => 'slider',
									'min' => '30',
									'max' => '100',
									'step' => '5',
									'default' => '60',
									'name' => 'hb_sticky_header_height',
									'label' => __('Sticky Header Height', 'hbthemes'),
									'description' => __('Choose the sticky header height in pixels. Applicable only if the option above is ON. Minimum 30px, maximum 100px. We recommend 60.', 'hbthemes'),
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_sticky_header_dependency',
									),
								),
								array(
									'type' => 'slider',
									'min' => '60',
									'max' => '200',
									'step' => '5',
									'default' => '80',
									'name' => 'hb_regular_header_height',
									'label' => __('Header Height', 'hbthemes'),
									'description' => __('Choose the header height in pixels when not in sticky mode. Minimum 60px, maximum 200px. We recommend 80.', 'hbthemes'),
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_sticky_header_dependency',
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_enable_sticky_shop_button',
									'label' => __('Sticky Cart Button', 'hbthemes'),
									'description' => __('Enable sticky cart button on the right hand side. WooCommerce is required.', 'hbthemes'),
									'default' => '1',
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_sticky_header_dependency',
									),
								),
								array(
									'type' => 'textarea',
									'name' => 'hb_header_right_text',
									'label' => __('Additional Text Box', 'hbthemes'),
									'description' => __('Enter any text that will be displayed on the right side of the header. You can use any HTML synthax. Only applicable to Header Layout Type 2.', 'hbthemes'),
									'default' => 'Ultimate WordPress Theme<br/>With Powerful Page Builder',
									'dependency' => array(
										'field' => 'hb_header_layout_style',
										'function' => 'hb_header_text_dependency',
									),
								),
							),
						),
						array(
							'type' => 'section',
							'title' => __('Navigation Layout', 'hbthemes'),
							'name' => 'hb_navigation_layout',
							'description' => __('Choose navigation layout.' , 'hbthemes'),
							'fields' => array(

								array(
									'type' => 'radioimage',
									'name' => 'hb_header_layout_skin',
									'label' => __('Navigation Skin', 'hbthemes'),
									'description' => __('Choose your main navigation skin.', 'hbthemes'),
									'item_max_height' => '500',
									'item_max_width' => '1400',
									'items' => array(
										array(
											'value' => 'default-skin',
											'label' => __('First', 'hbthemes'),
											'img' => $theme_files_url . '/menu-1.jpg',
										),
										array(
											'value' => 'second-skin',
											'label' => __('Second', 'hbthemes'),
											'img' => $theme_files_url . '/menu-2.jpg',
										),
										array(
											'value' => 'third-skin',
											'label' => __('Third', 'hbthemes'),
											'img' => $theme_files_url . '/menu-3.jpg',
										),
										array(
											'value' => 'minimal-skin',
											'label' => __('Fourth', 'hbthemes'),
											'img' => $theme_files_url . '/menu-4.jpg',
										),
									),
									'default' => array(
										'third-skin',
									),
								),
								array(
									'type' => 'select',
									'name' => 'hb_navigation_animation',
									'label' => __('Navigation Animation', 'hbthemes'),
									'description' => __('Choose your main navigation effect. Different animations are supported for different navigation skins. Fourth skin supports all animations.', 'hbthemes'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'binding',
												'field'  => 'hb_header_layout_skin',
												'value'  => 'hb_navigation_animation_binding',
											),
										),
									),
									'default' => 'hb-effect-10',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_search_in_menu',
									'label' => __('Search in Navigation', 'hbthemes'),
									'description' => __('Enable/Disable search in your main navigation bar in the header area.', 'hbthemes'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'hb_ajax_search',
									'label' => __('Search Autocomplete', 'hbthemes'),
									'description' => __('Enable/Disable AJAX autocomplete forsearch in your main navigation bar in the header area.', 'hbthemes'),
									'default' => '1',
									'dependency' => array(
										'field' => 'hb_search_in_menu',
										'function' => 'vp_dep_boolean',
									),
								),
								array(
									'type' => 'select',
									'name' => 'hb_main_navigation_color',
									'label' => __('Navigation Dropdown Color', 'hbthemes'),
									'description' => __('Choose your main navigation dropdown color scheme.', 'hbthemes'),
									'items' => array(
										array(
											'value' => 'dark-menu-dropdown',
											'label' => __('Dark','hbthemes')
										),
										array(
											'value' => 'light-menu-dropdown',
											'label' => __('Light','hbthemes'),
										),
									),
									'default' => 'dark-menu-dropdown',
								),
							),
						),
					),
				),
				array(
					'title' => __('Pre-Footer Callout', 'hbthemes'),
					'name' => 'hb_pre_footer_callout_settings',
					'icon' => 'font-awesome:hb-moon-align-center-horizontal',
					'controls' => array(
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_pre_footer_area',
							'label' => __('Pre-Footer Callout Area', 'hbthemes'),
							'description' => __('Enable/Disable site-wide pre-footer callout area. You can also disable this area using meta fields on any page.','hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_pre_footer_text',
							'label' => __('Callout Text', 'hbthemes'),
							'description' => __('Enter a text for the callout area.', 'hbthemes'),
							'default' => 'Experience something completely different. The most powerful theme ever.',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_pre_footer_button_text',
							'label' => __('Button Text', 'hbthemes'),
							'description' => "Enter text for the pre footer button. Leave empty if you do not want to use it.",
							'default' => 'Buy Today!',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_pre_footer_button_link',
							'label' => __('Button Link', 'hbthemes'),
							'description' => "It's important to write the full url with http:// prefix.",
							'default' => 'http://hb-themes.com',
						),
						array(
							'type' => 'fontawesome',
							'name' => 'hb_pre_footer_button_icon',
							'label' => __('Pre-Footer Callout Icon', 'hbthemes'),
							'description' => __('Choose any icon for the callout button. Leave empty to ignore icon.', 'hbthemes'),
							'default' => '',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'hb_pre_footer_button_target',
							'label' => __('Button link opens in:', 'hbthemes'),
							'items' => array(
								array(
									'value' => '_blank',
									'label' => __('New Tab', 'hbthemes'),
									),
								array(
									'value' => '_self',
									'label' => __('Same Tab', 'hbthemes'),
									),
								),
							'default' => '_self',
						),
					),
				),
				array(
					'title' => __('Footer Layout', 'hbthemes'),
					'name' => 'hb_footer_layout_settings',
					'icon' => 'font-awesome:hb-moon-file-3',
					'controls' => array(
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_footer_widgets',
							'label' => __('Footer Widgets', 'hbthemes'),
							'description' => __('Enable/Disable footer area filled with widgets in optional layout. You can also disable footer area through meta fields on any page.','hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_footer_separators',
							'label' => __('Footer Column Separators', 'hbthemes'),
							'description' => __('Display vertical line separators between widget columns. Looks nice if you have lots of footer widgets.','hbthemes'),
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_enable_footer_widgets',
								'function' => 'vp_dep_boolean',
								),
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_footer_background',
							'label' => __('Footer Background Overlay', 'hbthemes'),
							'description' => __('Display beautiful earth overlay image in the footer area. Appropriate for corporate and agency websites.','hbthemes'),
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_enable_footer_widgets',
								'function' => 'vp_dep_boolean',
								),
						),
						array(
							'type' => 'section',
							'title' => __('Footer Widgets Layout', 'hbthemes'),
							'name' => 'hb_footer_widgets_layout',
							'dependency' => array(
								'field' => 'hb_enable_footer_widgets',
								'function' => 'vp_dep_boolean',
								),
							'fields' => array(
									array(
										'type' => 'radioimage',
										'name' => 'hb_footer_layout',
										'label' => __('Choose Layout', 'hbthemes'),
										'description' => __('Choose layout of the footer area.', 'hbthemes'),
										'item_max_height' => '55',
										'item_max_width' => '120',
										'items' => array(
											array(
												'value' => 'style-1',
												'label' => __('1/4 + 1/4 + 1/4 + 1/4', 'hbthemes'),
												'img' => $theme_files_url . '/footer-1.png',
											),
											array(
												'value' => 'style-2',
												'label' => __('1/4 + 1/4 + 1/2', 'hbthemes'),
												'img' => $theme_files_url . '/footer-2.png',
											),
											array(
												'value' => 'style-3',
												'label' => __('1/2 + 1/4 + 1/4', 'hbthemes'),
												'img' => $theme_files_url . '/footer-3.png',
											),
											array(
												'value' => 'style-4',
												'label' => __('1/4 + 1/2 + 1/4', 'hbthemes'),
												'img' => $theme_files_url . '/footer-4.png',
											),
											array(
												'value' => 'style-5',
												'label' => __('1/3 + 1/3 + 1/3', 'hbthemes'),
												'img' => $theme_files_url . '/footer-5.png',
											),
											array(
												'value' => 'style-6',
												'label' => __('2/3 + 1/3', 'hbthemes'),
												'img' => $theme_files_url . '/footer-6.png',
											),
											array(
												'value' => 'style-7',
												'label' => __('1/3 + 2/3', 'hbthemes'),
												'img' => $theme_files_url . '/footer-7.png',
											),
											array(
												'value' => 'style-8',
												'label' => __('1/2 + 1/2', 'hbthemes'),
												'img' => $theme_files_url . '/footer-8.png',
											),
											array(
												'value' => 'style-9',
												'label' => __('1/3 + 3/4', 'hbthemes'),
												'img' => $theme_files_url . '/footer-9.png',
											),
											array(
												'value' => 'style-10',
												'label' => __('3/4 + 1/4', 'hbthemes'),
												'img' => $theme_files_url . '/footer-10.png',
											),
											array(
												'value' => 'style-11',
												'label' => __('1/1', 'hbthemes'),
												'img' => $theme_files_url . '/footer-11.png',
											),
										),
										'default' => array(
											'style-1',
										),
									),
							),
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_footer_copyright',
							'label' => __('Copyright Line', 'hbthemes'),
							'description' => __('Enable/Disable a copyright line and footer navigation at the bottom of your website. You can also disable footer area through meta fields on any page.','hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_backlink',
							'label' => __('Show HB-Themes Backlink', 'hbthemes'),
							'description' => __('If enabled, a backlink to our site will be shown in the copyright area. This is not required, but always appreciated.','hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'section',
							'title' => __('Copyright Line Settings', 'hbthemes'),
							'name' => 'hb_footer_copyright_settings',
							'dependency' => array(
								'field' => 'hb_enable_footer_copyright',
								'function' => 'vp_dep_boolean',
								),
							'fields' => array(
									array(
										'type' => 'radiobutton',
										'name' => 'hb_copyright_style',
										'label' => __('Copyright Layout', 'hbthemes'),
										'description' => __('Simple copyright layout hides the footer navigation and centers the copyright text. Looks nice if you don\'t need a footer navigation.', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'simple-copyright',
												'label' => __('Simple', 'hbthemes'),
											),
											array(
												'value' => 'normal-copyright',
												'label' => __('Normal', 'hbthemes'),
											),
										),
										'default' => array(
											'normal-copyright',
										),
									),
									array(
										'type' => 'textarea',
										'name' => 'hb_copyright_line_text',
										'label' => __('Copyright Text', 'hbthemes'),
										'description' => __('Enter your copyright text. HTML tags are allowed. You can use [the-year] and [wp-link] shortcodes. [the-year] shows the current year, while [wp-link] shows a link to WordPress website.', 'hbthemes'),
										'default' => '&copy; [the-year] &middot; Your Website.',
									),
									
							),
						),
						array(
							'type' => 'toggle',
							'name' => 'hb_fixed_footer_effect',
							'label' => __('Fixed Footer Effect', 'hbthemes'),
							'description' => __('Enable the fixed footer effect which is very popular for One Page websites.','hbthemes'),
							'default' => '0',
						),
					),
				),
				array(
					'title' => __('Default Settings', 'hbthemes'),
					'name' => 'hb_default_layout_settings',
					'icon' => 'font-awesome:hb-moon-checkbox-checked',
					'controls' => array(
						array(
							'type' => 'notebox',
							'name' => 'hb_default_settings_notebox',
							'label' => __('Default Page Layout Settings', 'hbthemes'),
							'description' => __('Set the default meta settings values for new posts and pages. These settings will also be applied to your archives and search pages.', 'hbthemes'),
							'status' => 'normal',
						),
						array(
							'type' => 'section',
							'title' => __('Sidebar Layout', 'hbthemes'),
							'name' => 'hb_default_sidebar_layout',
							'fields' => array(

									array(
										'type' => 'radiobutton',
										'name' => 'hb_page_layout_sidebar',
										'label' => __('Sidebar Layout', 'hbthemes'),
										'items' => array(
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
										'default' => array(
											'right-sidebar',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_choose_sidebar',
										'label' => __('Default Sidebar', 'hbthemes'),
										'items' => $sidebar_list,
										'default' => 'hb-default-sidebar',
									),
							),
						),
						array(
							'type' => 'section',
							'title' => __('Page Title', 'hbthemes'),
							'name' => 'hb_default_page_title',
							'fields' => array(
									array(
										'type' => 'radiobutton',
										'name' => 'hb_page_title_type',
										'label' => __('Title Type', 'hbthemes'),
										'items' => array(
												array(
													'value' => 'none',
													'label' => __('Hide Page Title', 'hbthemes'),
												),
												array(
													'value' => 'hb-color-background',
													'label' => __('Page Title with Background Color', 'hbthemes'),
												),
												array(
													'value' => 'hb-image-background',
													'label' => __('Page Title with Background Image', 'hbthemes'),
												),
											),
										'default' => array(
											'hb-color-background',
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
									    'default' => '#fafafa',
									),
									array(
										'type' => 'upload',
										'name' => 'hb_page_title_background_image',
										'label' => __('Upload Image', 'hbthemes'),
										'description' => __('Upload an image different from the default image set in the Theme Options. ', 'hbthemes'),
										'default' => '',
										'dependency' => array(
											'field' => 'hb_page_title_type',
									        'function' => 'hb_page_title_background_image_dependency',
									    ),
									),
									array(
										'type' => 'toggle',
										'name' => 'hb_page_title_background_image_parallax',
										'label' => __('Parallax', 'hbthemes'),
										'default' => '1',
										'description' => __('Enable/Disable Parallax effect for the uploaded image.', 'hbthemes'),
										'dependency' => array(
											'field' => 'hb_page_title_type',
									        'function' => 'hb_page_title_background_image_dependency',
									    ),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'hb_page_title_style',
										'label' => __('Style', 'hbthemes'),
										'description' => __('Choose between simple and fancy style.', 'hbthemes'),
										'items' => array(
											array(
												'value' => 'simple-title',
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
											'simple-title',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
									        'function' => 'hb_page_title_h1_dependency',
									    ),
									),
									array(
										'type' => 'radiobutton',
										'name' => 'hb_page_title_alignment',
										'label' => __('Title Alignment', 'hbthemes'),
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
											'alignleft',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
											'function' => 'hb_page_title_h1_dependency',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_page_title_height',
										'label' => __('Default Title Height', 'hbthemes'),
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
											'normal-padding',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
											'function' => 'hb_page_title_h1_dependency',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_page_title_color',
										'label' => __('Choose Color Style', 'hbthemes'),
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
											'dark-text',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
											'function' => 'hb_page_title_h1_dependency',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_page_title_animation',
										'label' => __('Entrance Title Animation', 'hbthemes'),
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
											'',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
											'function' => 'hb_page_title_h1_dependency',
										),
									),
									array(
										'type' => 'select',
										'name' => 'hb_page_title_subtitle_animation',
										'label' => __('Entrance Subtitle Animation', 'hbthemes'),
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
											'',
										),
										'dependency' => array(
											'field' => 'hb_page_title_type',
											'function' => 'hb_page_title_h1_dependency',
										),
									),
							),
						),
					),
				),
			),
		),
		array(
			'title' => __('Logo Settings', 'hbthemes'),
			'name' => 'hb_logo_settings',
			'icon' => 'font-awesome:hb-moon-star',
			'controls' => array(
				array(
					'type' => 'upload',
					'name' => 'hb_logo_option',
					'label' => __('Logo', 'hbthemes'),
					'description' => __('Upload any size logo. Your logo will be resized to fit the navigation wrapper. Suggested dimensions are: 318x72 px. ', 'hbthemes'),
					'default' => $theme_files_url . 'highend_logo.png',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_logo_option_retina',
					'label' => __('Retina Logo', 'hbthemes'),
					'description' => __('Upload your logo for Retina screens. Exactly 2x the size of your original logo. Suggested dimensions are: 636x144 px. ', 'hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_wordpress_logo',
					'label' => __('WordPress Login Logo', 'hbthemes'),
					'description' => __('Change the default WordPress login logo. Dimensions should be 274x63 px.', 'hbthemes'),
					'default' => $theme_files_url . 'highend_logo.png',
				),
			),	
		),
		array(
			'title' => __('Contact Settings', 'hbthemes'),
			'name' => 'hb_contact_settings',
			'icon' => 'font-awesome:hb-moon-envelop',
			'controls' => array(
				// Controls here
				array(
					'type' => 'textbox',
					'name' => 'hb_contact_settings_email',
					'label' => __('Email Address', 'hbthemes'),
					'description' => __('Enter email address where the emails from Contact Template and Quick Contact Box will be sent to. Default value is your administrator email set in WordPress Settings.', 'hbthemes'),
					'default' => $admin_email,
				),

				array(
					'type' => 'section',
					'title' => __('Quick Contact Box', 'hbthemes'),
					'name' => 'hb_quick_contact_box',
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'hb_enable_quick_contact_box',
							'label' => __('Quick Contact Box', 'hbthemes'),
							'description' => __('Enable/Disable the Quick Contact Box on your website. It will show a simple ajax form (name, email, message) with validation...', 'hbthemes'),
							'default' => '1',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_quick_contact_box_title',
							'label' => __('Contact Box Title', 'hbthemes'),
							'description' => __('Enter a title for the Contact Box.', 'hbthemes'),
							'default' => __('Contact Us', 'hbthemes'),
							'dependency' => array(
								'field' => 'hb_enable_quick_contact_box',
								'function' => 'hb_maint_dependency',
							),
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_quick_contact_box_text',
							'label' => __('Contact Box Description', 'hbthemes'),
							'description' => __('Enter a description for the Contact Box.', 'hbthemes'),
							'default' => __('We\'re currently offline. Send us an email and we\'ll get back to you, asap.', 'hbthemes'),
							'dependency' => array(
								'field' => 'hb_enable_quick_contact_box',
								'function' => 'hb_maint_dependency',
							),
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_quick_contact_box_button_title',
							'label' => __('Contact Box Button Title', 'hbthemes'),
							'description' => __('Enter a title for the Contact Box submit button.', 'hbthemes'),
							'default' => __('Send Message', 'hbthemes'),
							'dependency' => array(
								'field' => 'hb_enable_quick_contact_box',
								'function' => 'hb_maint_dependency',
							),
						),
						array(
							'type' => 'fontawesome',
							'name' => 'hb_quick_contact_box_button_icon',
							'label' => __('Contact Box Button Icon', 'hbthemes'),
							'description' => __('Choose any icon for the submit button. Leave empty to ignore.', 'hbthemes'),
							'default' => 'hb-moon-paper-plane',
							'dependency' => array(
								'field' => 'hb_enable_quick_contact_box',
								'function' => 'hb_maint_dependency',
							),
						),
					),
				),
			),
		),
		array(
			'title' => __('Blog Settings', 'hbthemes'),
			'name' => 'hb_blog_settings',
			'icon' => 'font-awesome:icon-pencil',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_general_notebox_blog',
					'label' => __('Note', 'hbthemes'),
					'description' => __('<p>The settings below will be applied to the blog page templates, shortcodes and widgets.</p><p>You can use Custom CSS for additional changes.</p>', 'hbthemes'),
					'status' => 'normal',
				),
				array(
					'type' => 'slider',
					'min' => '0',
					'max' => '100',
					'step' => '5',
					'default' => '20',
					'name' => 'hb_blog_excerpt_length',
					'label' => __('Excerpt Length', 'hbthemes'),
					'description' => __('Choose the excerpt length. Number of words to display in excerpt.', 'hbthemes'),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_by_author',
					'label' => __('Display By Author', 'hbthemes'),
					'description' => __('Enable/Disable meta information about the post author.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_date',
					'label' => __('Display Date', 'hbthemes'),
					'description' => __('Enable/Disable post date information.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_comments',
					'label' => __('Display Comments Count', 'hbthemes'),
					'description' => __('Enable/Disable comments count information.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_categories',
					'label' => __('Display Categories', 'hbthemes'),
					'description' => __('Enable/Disable categories information on single blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_tags',
					'label' => __('Display Tags', 'hbthemes'),
					'description' => __('Enable/Disable tags information on single blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_related_posts',
					'label' => __('Related Posts', 'hbthemes'),
					'description' => __('Show/Hide related posts (by categories) on single blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_next_prev',
					'label' => __('Next & Previous Posts', 'hbthemes'),
					'description' => __('Show/Hide buttons for previous and next post on single blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_likes',
					'label' => __('Post Likes', 'hbthemes'),
					'description' => __('Enable/Disable likes on your blog posts - allow your website visitors to like blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_featured_image',
					'label' => __('Featured Image', 'hbthemes'),
					'description' => __('Show featured image of the blog post above the content on single blog posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'slider',
					'min' => '30',
					'max' => '1000',
					'step' => '1',
					'default' => '350',
					'name' => 'hb_blog_image_height',
					'label' => __('Single post featured image height', 'hbthemes'),
					'description' => __('Set height for featured image displayed on your single blog page.', 'hbthemes'),
					'dependency' => array(
						'field' => 'hb_blog_enable_featured_image',
						'function' => 'vp_dep_boolean',
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_author_info',
					'label' => __('About the author box', 'hbthemes'),
					'description' => __('Enable/Disable about the author box on single blog posts. Fill in the author info in your Profile Settings.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_blog_enable_share',
					'label' => __('Share Box', 'hbthemes'),
					'description' => __('Enable/Disable the share box on blog single posts.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'textarea',
					'name' => 'hb_comment_form_text',
					'default' => "Your email is safe with us.",
					'label' => __('Comment Form Description', 'hbthemes'),
					'description' => __('Enter a small description for the comment form. Showed below "Leave a Reply" text.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_archives_title',
					'default' => "Archive",
					'label' => __('Archives title', 'hbthemes'),
					'description' => __('Enter a title for all of your archive pages. Subtitles will describe the page in more detail.', 'hbthemes'),
				),
			),
		),
		array(
			'title' => __('Portfolio Settings', 'hbthemes'),
			'name' => 'hb_portfolio_settings',
			'icon' => 'font-awesome:hb-moon-briefcase',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_general_notebox_portfolio',
					'label' => __('Note', 'hbthemes'),
					'description' => __('<p>The settings below will be applied to the portfolio page templates, shortcodes and widgets.</p><p>You can use Custom CSS for additional changes.</p>', 'hbthemes'),
					'status' => 'normal',
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_portfolio_layout',
					'label' => __('Default Layout', 'hbthemes'),
					'description' => __('Meta sidebar will show meta information about the portfolio. You can add meta informations while creating/editing a portfolio item.', 'hbthemes'),
					'items' => array(
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
					'default' => array(
						'hb_meta_sidebar',
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_portfolio_sidebar_side',
					'label' => __('Sidebar Position', 'hbthemes'),
					'items' => array(
						array(
							'value' => 'left-sidebar',
							'label' => __('Left Sidebar', 'hbthemes'),
							),
						array(
							'value' => 'right-sidebar',
							'label' => __('Right Sidebar', 'hbthemes'),
							),
						),
					'default' => array(
						'left-sidebar',
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_portfolio_content_layout',
					'label' => __('Content Layout', 'hbthemes'),
					'description' => __('Choose default content layout for your portfolio item page. It is the layout of your portfolio featured artwork.', 'hbthemes'),
					'items' => array(
						array(
							'value' => 'totalfullwidth',
							'label' => __('Total Fullwidth', 'hbthemes'),
						),
						array(
							'value' => 'fullwidth',
							'label' => __('Fullwidth', 'hbthemes'),
						),
						array(
							'value' => 'split',
							'label' => __('Split', 'hbthemes'),
						),
					),
					'default' => array(
						'fullwidth',
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_enable_likes',
					'label' => __('Likes', 'hbthemes'),
					'description' => __('Enable/Disable likes on portfolios.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_enable_related_posts',
					'label' => __('Related Posts', 'hbthemes'),
					'description' => __('Show/Hide related portfolio items on single portfolios.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_enable_next_prev',
					'label' => __('Next & Previous Posts', 'hbthemes'),
					'description' => __('Show/Hide buttons for previous and next projects on single portfolios.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_enable_share',
					'label' => __('Share Post', 'hbthemes'),
					'description' => __('Show/Hide Social Share buttons on a portfolio single page.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_taxonomy_filter',
					'label' => __('Filter on Portfolio Category Archive', 'hbthemes'),
					'description' => __('Enable/Disable filter on your Portfolio Category Archive.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_portfolio_taxonomy_sorter',
					'label' => __('Sorter on Portfolio Category Archive', 'hbthemes'),
					'description' => __('Enable/Disable sorter on your Portfolio Category Archive.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'slider',
					'name' => 'hb_portfolio_taxonomy_columns',
					'label' => __('Portfolio Column Count on your Portfolio Category Archive.', 'hbthemes'),
					'min' => 2,
					'max' => 4,
					'step' => 1,
					'description' => "",
					'default' => 3,
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_portfolio_taxonomy_orientation',
					'label' => __('Thumbnail Orientation','hbthemes'),
					'description' => __('Choose thumbnail orientation on your Portfolio Category Archive.','hbthemes'),
					'default' => 'landscape',
					'items' => array(
						array(
							'label' => __('Landscape','hbthemes'),
							'value' => 'landscape',
						),
						array(
							'label' => __('Portrait','hbthemes'),
							'value' => 'portrait',
						),
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_portfolio_taxonomy_ratio',
					'label' => __('Thumbnail Ratio','hbthemes'),
					'description' => __('Choose thumbnail ratio on your Portfolio Category Archive.','hbthemes'),
					'default' => 'ratio1',
					'items' => array(
						array(
							'label' => __('16:9','hbthemes'),
							'value' => 'ratio1',
						),
						array(
							'label' => __('4:3','hbthemes'),
							'value' => 'ratio2',
						),
						array(
							'label' => __('3:2','hbthemes'),
							'value' => 'ratio4',
						),
						array(
							'label' => __('3:1','hbthemes'),
							'value' => 'ratio5',
						),
						array(
							'label' => __('1:1','hbthemes'),
							'value' => 'ratio3',
						),
					),
				),
			),
		),
		array(
			'title' => __('Team Members Settings', 'hbthemes'),
			'name' => 'hb_staff_settings',
			'icon' => 'font-awesome:hb-moon-user',
			'controls' => array(
				array(
					'type' => 'radiobutton',
					'name' => 'hb_staff_layout',
					'label' => __('Default Layout', 'hbthemes'),
					'description' => __('Meta sidebar will show meta information about the staff member. You can add meta informations while creating/editing a staff member.', 'hbthemes'),
					'items' => array(
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
					'default' => array(
						'metasidebar',
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'hb_staff_sidebar_side',
					'label' => __('Sidebar Position', 'hbthemes'),
					'items' => array(
						array(
							'value' => 'left-sidebar',
							'label' => __('Left Sidebar', 'hbthemes'),
							),
						array(
							'value' => 'right-sidebar',
							'label' => __('Right Sidebar', 'hbthemes'),
							),
						),
					'default' => array(
						'left-sidebar',
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_staff_enable_related_posts',
					'label' => __('More Members', 'hbthemes'),
					'description' => __('Show/Hide more team members at the bottom of the single staff pages.', 'hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_staff_enable_next_prev',
					'label' => __('Next & Previous Members', 'hbthemes'),
					'description' => __('Show/Hide buttons for previous and next staff members on single staff pages.', 'hbthemes'),
					'default' => '1',
				),
			),
		),
		array(
			'title' => __('WooCommerce Settings', 'hbthemes'),
			'name' => 'hb_woocommerce_settings',
			'icon' => 'font-awesome:hb-moon-cart-checkout',
			'controls' => array(
				array(
					'type' => 'slider',
					'min' => '4',
					'max' => '32',
					'step' => '4',
					'default' => '12',
					'name' => 'hb_woo_count',
					'label' => __('Product Count', 'hbthemes'),
					'description' => __('Choose product count shown on Shop page and categories. Default 12.', 'hbthemes'),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_woo_enable_likes',
					'label' => __('Enable Likes', 'hbthemes'),
					'description' => __('Enable likes in shop pages (shop, category and single products).','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'section',
					'title' => __('Shop/Category Layout', 'hbthemes'),
					'name' => 'hb_woo_sidebar_layout',
					'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_woo_layout_sidebar',
							'label' => __('Shop Layout', 'hbthemes'),
							'description' => __('Choose the layout for WooCommerce shop/category pages.','hbthemes'),
							'items' => array(
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
						'default' => array(
							'fullwidth',
						),
					),
					array(
						'type' => 'select',
						'name' => 'hb_woo_choose_sidebar',
						'label' => __('Choose Sidebar', 'hbthemes'),
						'items' => $sidebar_list,
						'default' => '{{last}}',
						'description' => __("Choose the sidebar for WooCommerce shop/category pages.","hbthemes")
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('Single Product Layout', 'hbthemes'),
					'name' => 'hb_woo_sp_sidebar_layout',
					'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_woo_sp_layout_sidebar',
							'label' => __('Sidebar Layout', 'hbthemes'),
							'description' => __('Choose the layout for WooCommerce single product pages.','hbthemes'),
							'items' => array(
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
						'default' => array(
							'fullwidth',
						),
					),
					array(
						'type' => 'select',
						'name' => 'hb_woo_sp_choose_sidebar',
						'label' => __('Choose Sidebar', 'hbthemes'),
						'description' => __("Choose the sidebar for WooCommerce single product pages.","hbthemes"),
						'items' => $sidebar_list,
						'default' => '{{last}}',
						),
					array(
						'type' => 'toggle',
						'name' => 'hb_woo_enable_share',
						'label' => __('Enable Share', 'hbthemes'),
						'description' => __('Enable share feature in single shop pages (product description pages).','hbthemes'),
						'default' => '1',
					),
					),
				),
			),
		),
		array(
			'title' => __('Social Links', 'hbthemes'),
			'name' => 'hb_social_links',
			'icon' => 'font-awesome:hb-moon-twitter',
			'controls' => array(
				array(
					'type' => 'toggle',
					'name' => 'hb_soc_links_new_tab',
					'label' => __('Open links in new tab?', 'hbthemes'),
					'description' => __('Enable this field if you want to open your social links in new tab.', 'hbthemes'),
					'default' => '0',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_twitter_link',
					'label' => __('Twitter', 'hbthemes'),
					'description' => __('Enter your Twitter url here. Example: http://twitter.com/HBThemes', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_facebook_link',
					'label' => __('Facebook', 'hbthemes'),
					'description' => __('Enter your Facebook url here. Example: http://facebook.com/hbthemes', 'hbthemes'),
					'default' => 'http://facebook.com/hbthemes',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_vkontakte_link',
					'label' => __('VKontakte', 'hbthemes'),
					'description' => __('Enter your VKontakte url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_skype_link',
					'label' => __('Skype', 'hbthemes'),
					'description' => __('Enter your Skype username here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_instagram_link',
					'label' => __('Instagram', 'hbthemes'),
					'description' => __('Enter your Instagram url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_pinterest_link',
					'label' => __('Pinterest', 'hbthemes'),
					'description' => __('Enter your Pinterest url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_google-plus_link',
					'label' => __('Google+', 'hbthemes'),
					'description' => __('Enter your Google+ url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_dribbble_link',
					'label' => __('Dribbble', 'hbthemes'),
					'description' => __('Enter your Dribbble url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_digg_link',
					'label' => __('Digg', 'hbthemes'),
					'description' => __('Enter your Digg url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_xing_link',
					'label' => __('Xing', 'hbthemes'),
					'description' => __('Enter your Xing url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_myspace_link',
					'label' => __('MySpace', 'hbthemes'),
					'description' => __('Enter your MySpace url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_soundcloud_link',
					'label' => __('SoundCloud', 'hbthemes'),
					'description' => __('Enter your SoundCloud url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_youtube_link',
					'label' => __('YouTube', 'hbthemes'),
					'description' => __('Enter your YouTube url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_vimeo_link',
					'label' => __('Vimeo', 'hbthemes'),
					'description' => __('Enter your Vimeo url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_flickr_link',
					'label' => __('Flickr', 'hbthemes'),
					'description' => __('Enter your Flickr url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_tumblr_link',
					'label' => __('Tumblr', 'hbthemes'),
					'description' => __('Enter your Tumblr url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_yahoo_link',
					'label' => __('Yahoo', 'hbthemes'),
					'description' => __('Enter your Yahoo url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_foursquare_link',
					'label' => __('Foursquare', 'hbthemes'),
					'description' => __('Enter your Foursquare url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_blogger_link',
					'label' => __('Blogger', 'hbthemes'),
					'description' => __('Enter your Blogger url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_wordpress_link',
					'label' => __('WordPress', 'hbthemes'),
					'description' => __('Enter your WordPress url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_lastfm_link',
					'label' => __('LastFm', 'hbthemes'),
					'description' => __('Enter your LastFm url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_github_link',
					'label' => __('GitHub', 'hbthemes'),
					'description' => __('Enter your GitHub url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_linkedin_link',
					'label' => __('LinkedIn', 'hbthemes'),
					'description' => __('Enter your LinkedIn url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_yelp_link',
					'label' => __('Yelp', 'hbthemes'),
					'description' => __('Enter your Yelp url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_forrst_link',
					'label' => __('Forrst', 'hbthemes'),
					'description' => __('Enter your Forrst url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_deviantart_link',
					'label' => __('DeviantArt', 'hbthemes'),
					'description' => __('Enter your DeviantArt url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_stumbleupon_link',
					'label' => __('StumbleUpon', 'hbthemes'),
					'description' => __('Enter your StumbleUpon url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_delicious_link',
					'label' => __('Delicious', 'hbthemes'),
					'description' => __('Enter your Delicious url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_reddit_link',
					'label' => __('Reddit', 'hbthemes'),
					'description' => __('Enter your Reddit url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_behance_link',
					'label' => __('Behance', 'hbthemes'),
					'description' => __('Enter your Behance url here.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_mail_link',
					'label' => __('Email', 'hbthemes'),
					'description' => __('Enter your Email url here. Example: mailto: test@test.com', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_feed-2_link',
					'label' => __('RSS', 'hbthemes'),
					'description' => __('Enter your RSS url here. Example: http://yourwebsite.com/feed', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_custom-url_link',
					'label' => __('Custom Link', 'hbthemes'),
					'description' => __('Enter your Custom Link url here. Example: http://hb-themes.com', 'hbthemes'),
				),
				array(
					'type' => 'section',
					'name' => 'hb_twitter_api_section',
					'title' => __('Twitter API Settings', 'hbthemes'),
					'description' => __('You must fill in all fields.', 'hbthemes'),
					'fields' => array(
						array(
							'type' => 'notebox',
							'name' => 'hb_twitter_notebox_1',
							'description' => __('<p>You will have to fill in your Twitter Application details below if you want to use Twitter Widget.</p><p>You can create your Twitter App & obtain keys here: <a target="_blank" href="https://dev.twitter.com/apps">https://dev.twitter.com/apps</a></p>', 'hbthemes'),
							'status' => 'normal',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_twitter_consumer_key',
							'label' => __('Twitter API Key', 'hbthemes'),
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_twitter_consumer_secret',
							'label' => __('Twitter API Secret', 'hbthemes'),
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_twitter_access_token',
							'label' => __('Twitter Access Token', 'hbthemes'),
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_twitter_access_token_secret',
							'label' => __('Twitter Access Token Secret', 'hbthemes'),
						),
					),
				),
			),	
		),

		array(
			'title' => __('Share Settings', 'hbthemes'),
			'name' => 'hb_share_settings',
			'icon' => 'font-awesome:hb-moon-share-3',
			'controls' => array(

				array(
					'type' => 'toggle',
					'name' => 'hb_share_facebook',
					'label' => __('Facebook Share', 'hbthemes'),
					'description' => __('Enable Facebook share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_twitter',
					'label' => __('Twitter Share', 'hbthemes'),
					'description' => __('Enable Twitter share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_gplus',
					'label' => __('Google+ Share', 'hbthemes'),
					'description' => __('Enable Google+ share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_linkedin',
					'label' => __('LinkedIn Share', 'hbthemes'),
					'description' => __('Enable LinkedIn share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_pinterest',
					'label' => __('Pinterest Share', 'hbthemes'),
					'description' => __('Enable Pinterest share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_tumblr',
					'label' => __('Tumblr Share', 'hbthemes'),
					'description' => __('Enable Tumblr share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_vkontakte',
					'label' => __('VKontakte Share', 'hbthemes'),
					'description' => __('Enable VKontakte share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_reddit',
					'label' => __('Reddit Share', 'hbthemes'),
					'description' => __('Enable Reddit share in share box.','hbthemes'),
					'default' => '1',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_share_email',
					'label' => __('Email Share', 'hbthemes'),
					'description' => __('Enable email share in share box.','hbthemes'),
					'default' => '1',
				),
				
			),
		),

		array(
			'title' => __('Map Settings', 'hbthemes'),
			'name' => 'hb_map_contact',
			'icon' => 'font-awesome:hb-moon-location-2',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_map_notebox_1',
					'label' => __('Latitude & Longitude Converter', 'hbthemes'),
					'description' => __('You can use the online converter to convert an address into latitude & longitude. <a href="http://www.latlong.net/convert-address-to-lat-long.html">LatLong</a>', 'hbthemes'),
					'status' => 'normal',
				),
				array(
					'type' => 'slider',
					'min' => '1',
					'max' => '18',
					'step' => '1',
					'default' => '16',
					'name' => 'hb_map_zoom',
					'label' => __('Map Zoom Level', 'hbthemes'),
					'description' => __('Value between 1 and 18. 18 is the street level zoom, while 1 is whole earth.', 'hbthemes'),
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_map_latitude',
					'label' => __('Map Center Latitude', 'hbthemes'),
					'description' => __('Please enter the latitude for the center of the map.', 'hbthemes'),
					'default' => '48.856614',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_map_longitude',
					'label' => __('Map Center Longitude', 'hbthemes'),
					'description' => __('Please enter the longitude for the center of the map.', 'hbthemes'),
					'default' => '2.352222',
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_custom_pin',
					'label' => __('Custom Marker Image', 'hbthemes'),
					'description' => __('Enable the custom marker (pin) image for all your markers on the map.','hbthemes'),
					'default' => '0',
				),
				array(
					'type' => 'upload',
					'name' => 'hb_custom_marker_image',
					'label' => __('Custom Marker Image', 'hbthemes'),
					'description' => __('Please upload an image that will be used for all the markers on your map.', 'hbthemes'),
					'default' => '',
					'dependency' => array(
						'field' => 'hb_enable_custom_pin',
						'function' => 'hb_enable_custom_pin_function',
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_map_color',
					'label' => __('Enable Styled Map', 'hbthemes'),
					'description' => __('Check this box if you want your map to be styled with focus color.', 'hbthemes'),
					'default' => '1',
				),

				array(
			        'type' => 'color',
			        'name' => 'hb_map_focus_color',
			        'label' => __('Map Focus Color', 'hbthemes'),
			        'description' => __('Pick the focus color for your map. Styled map option has to be ENABLED.', 'hbthemes'),
			        'default' => '#ff6838',
			    ),

				array(
					'type' => 'section',
					'title' => __('Location 1', 'hbthemes'),
					'name' => 'hb_map_location_1',
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_1_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 1.', 'hbthemes'),
							'default' => '48.856614',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_1_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 1.', 'hbthemes'),
							'default' => '2.352222',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_1_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 1 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_2',
					'label' => __('Location 2', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 2', 'hbthemes'),
					'name' => 'hb_map_location_2',
					'dependency' => array(
						'field' => 'hb_enable_location_2',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_2_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 2.', 'hbthemes'),
							'default' => '48.856614',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_2_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 2.', 'hbthemes'),
							'default' => '2.352227',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_2_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 2 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),

				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_3',
					'label' => __('Location 3', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 3', 'hbthemes'),
					'name' => 'hb_map_location_3',
					'dependency' => array(
						'field' => 'hb_enable_location_3',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_3_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 2.', 'hbthemes'),
							'default' => '48.856615',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_3_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 2.', 'hbthemes'),
							'default' => '2.352221',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_3_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 3 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),


				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_4',
					'label' => __('Location 4', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 4', 'hbthemes'),
					'name' => 'hb_map_location_4',
					'dependency' => array(
						'field' => 'hb_enable_location_4',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_4_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 4.', 'hbthemes'),
							'default' => '48.856619',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_4_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 4.', 'hbthemes'),
							'default' => '2.352229',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_4_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 4 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),


				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_5',
					'label' => __('Location 5', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 5', 'hbthemes'),
					'name' => 'hb_map_location_5',
					'dependency' => array(
						'field' => 'hb_enable_location_5',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_5_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 5.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_5_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 5.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_5_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 5 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),

				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_6',
					'label' => __('Location 6', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 6', 'hbthemes'),
					'name' => 'hb_map_location_6',
					'dependency' => array(
						'field' => 'hb_enable_location_6',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_6_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 6.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_6_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 6.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_6_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 6 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_7',
					'label' => __('Location 7', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 7', 'hbthemes'),
					'name' => 'hb_map_location_7',
					'dependency' => array(
						'field' => 'hb_enable_location_7',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_7_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 7.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_7_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 7.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_7_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 7 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_8',
					'label' => __('Location 8', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 8', 'hbthemes'),
					'name' => 'hb_map_location_8',
					'dependency' => array(
						'field' => 'hb_enable_location_8',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_8_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 8.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_8_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 8.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_8_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 8 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),

				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_9',
					'label' => __('Location 9', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 9', 'hbthemes'),
					'name' => 'hb_map_location_9',
					'dependency' => array(
						'field' => 'hb_enable_location_9',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_9_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 9.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_9_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 9.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_9_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 8 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),

				array(
					'type' => 'toggle',
					'name' => 'hb_enable_location_10',
					'label' => __('Location 10', 'hbthemes'),
					'default' => '0',
				),

				array(
					'type' => 'section',
					'title' => __('Location 10', 'hbthemes'),
					'name' => 'hb_map_location_10',
					'dependency' => array(
						'field' => 'hb_enable_location_10',
						'function' => 'hb_enable_custom_pin_function',
					),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'hb_map_10_latitude',
							'label' => __('Latitude', 'hbthemes'),
							'description' => __('Please enter the latitude for the location 10.', 'hbthemes'),
							'default' => '48.856610',
						),
						array(
							'type' => 'textbox',
							'name' => 'hb_map_10_longitude',
							'label' => __('Longitude', 'hbthemes'),
							'description' => __('Please enter the longitude for the the location 10.', 'hbthemes'),
							'default' => '2.352220',
						),
						array(
							'type' => 'textarea',
							'name' => 'hb_location_10_info',
							'label' => __('Info Box', 'hbthemes'),
							'description' => __('Enter the info for location 10 which is showed when clicked on marker.', 'hbthemes'),
							'default' => 'Enter your info here or leave it empty.',
						),
					),
				),
			),
		),
		array(
			'title' => __('Font Settings', 'hbthemes'),
			'name' => 'hb_font_settings',
			'icon' => 'font-awesome:hb-moon-font-size',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_general_notebox_5',
					'label' => __('Google Web Fonts', 'hbthemes'),
					'description' => __('<p>You can find preview for Google Web Fonts here: <a href="http://www.google.com/fonts/">http://www.google.com/fonts/</a></p>', 'hbthemes'),
					'status' => 'normal',
				),
				array(
					'type' => 'section',
			        'title' => __('Body Font Settings', 'hbthemes'),
			        'name' => 'hb_body_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_body',
							'label' => __('Body Font', 'hbthemes'),
							'description' => __('Specify body font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_body_face',
						    'label' => __('Body Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),

						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_body_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_body_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),

						array(
							'type' => 'slider',
							'name' => 'hb_font_body_size',
							'label' => __('Body Font Size', 'hbthemes'),
							'description' => __('Specify body font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '40',
							'step' => '1',
							'default' => '13',
							'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_body_weight',
						    'label' => __('Body Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_body_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_body_line_height',
							'label' => __('Body Font Line Height', 'hbthemes'),
							'description' => __('Specify body font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_body_letter_spacing',
							'label' => __('Body Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify body font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_body',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Navigation Font Settings', 'hbthemes'),
			        'name' => 'hb_navigation_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_navigation',
							'label' => __('Navigation Font', 'hbthemes'),
							'description' => __('Specify navigation font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_navigation_face',
						    'label' => __('Navigation Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_nav_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_navigation_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_navigation_size',
							'label' => __('Navigation Font Size', 'hbthemes'),
							'description' => __('Specify navigation font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '60',
							'step' => '1',
							'default' => '13',
							'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_nav_weight',
						    'label' => __('Navigation Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_navigation_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_navigation_line_height',
							'label' => __('Navigation Font Line Height', 'hbthemes'),
							'description' => __('Specify navigation font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_navigation_letter_spacing',
							'label' => __('Navigation Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify navigation font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_navigation',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Copyright Font Settings', 'hbthemes'),
			        'name' => 'hb_copyright_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_copyright',
							'label' => __('Copyright Font', 'hbthemes'),
							'description' => __('Specify copyright font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_copyright_face',
						    'label' => __('Copyright Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_copyright_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_copyright_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_copyright_size',
							'label' => __('Copyright Font Size', 'hbthemes'),
							'description' => __('Specify copyright font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '40',
							'step' => '1',
							'default' => '12',
							'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_copyright_weight',
						    'label' => __('Copyright Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_copyright_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_copyright_line_height',
							'label' => __('Copyright Font Line Height', 'hbthemes'),
							'description' => __('Specify copyright font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_copyright_letter_spacing',
							'label' => __('Copyright Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify copyright font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_copyright',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 1 Font Settings', 'hbthemes'),
			        'name' => 'hb_h1_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h1',
							'label' => __('Heading 1 Font', 'hbthemes'),
							'description' => __('Specify Heading 1 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h1_face',
						    'label' => __('Heading 1 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h1_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h1_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h1_size',
							'label' => __('Heading 1 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 1 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '30',
							'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h1_weight',
						    'label' => __('H1 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h1_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h1_line_height',
							'label' => __('Heading 1 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 1 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '36',
							'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h1_letter_spacing',
							'label' => __('Heading 1 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 1 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h1',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 2 Font Settings', 'hbthemes'),
			        'name' => 'hb_h2_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h2',
							'label' => __('Heading 2 Font', 'hbthemes'),
							'description' => __('Specify Heading 2 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h2_face',
						    'label' => __('Heading 2 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h2_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h2_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h2_size',
							'label' => __('Heading 2 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 2 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '24',
							'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h2_weight',
						    'label' => __('H2 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h2_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h2_line_height',
							'label' => __('Heading 2 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 2 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '30',
							'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h2_letter_spacing',
							'label' => __('Heading 2 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 2 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h2',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 3 Font Settings', 'hbthemes'),
			        'name' => 'hb_h3_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h3',
							'label' => __('Heading 3 Font', 'hbthemes'),
							'description' => __('Specify Heading 3 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h3_face',
						    'label' => __('Heading 3 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h3_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h3_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h3_size',
							'label' => __('Heading 3 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 3 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '20',
							'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h3_weight',
						    'label' => __('H3 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h3_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h3_line_height',
							'label' => __('Heading 3 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 3 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '26',
							'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h3_letter_spacing',
							'label' => __('Heading 3 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 3 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h3',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 4 Font Settings', 'hbthemes'),
			        'name' => 'hb_h4_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h4',
							'label' => __('Heading 4 Font', 'hbthemes'),
							'description' => __('Specify Heading 4 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h4_face',
						    'label' => __('Heading 4 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h4_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h4_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h4_size',
							'label' => __('Heading 4 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 4 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '18',
							'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h4_weight',
						    'label' => __('H4 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h4_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h4_line_height',
							'label' => __('Heading 4 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 4 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '24',
							'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h4_letter_spacing',
							'label' => __('Heading 4 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 4 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h4',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 5 Font Settings', 'hbthemes'),
			        'name' => 'hb_h5_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h5',
							'label' => __('Heading 5 Font', 'hbthemes'),
							'description' => __('Specify Heading 5 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h5_face',
						    'label' => __('Heading 5 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h5_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h5_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h5_size',
							'label' => __('Heading 5 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 5 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '16',
							'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h5_weight',
						    'label' => __('H5 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h5_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h5_line_height',
							'label' => __('Heading 5 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 5 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h5_letter_spacing',
							'label' => __('Heading 5 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 5 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h5',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Heading 6 Font Settings', 'hbthemes'),
			        'name' => 'hb_h6_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_font_h6',
							'label' => __('Heading 6 Font', 'hbthemes'),
							'description' => __('Specify Heading 6 font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_font_h6_face',
						    'label' => __('Heading 6 Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_h6_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h6_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h6_size',
							'label' => __('Heading 6 Font Size', 'hbthemes'),
							'description' => __('Specify Heading 6 font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '80',
							'step' => '1',
							'default' => '16',
							'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_h6_weight',
						    'label' => __('H6 Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_font_h6_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h6_line_height',
							'label' => __('Heading 6 Font Line Height', 'hbthemes'),
							'description' => __('Specify Heading 6 font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_font_h6_letter_spacing',
							'label' => __('Heading 6 Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify Heading 6 font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_font_h6',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
				array(
					'type' => 'section',
			        'title' => __('Pre-Footer Callout Font Settings', 'hbthemes'),
			        'name' => 'hb_pre_footer_font_settings',
			        'fields' => array(
						array(
							'type' => 'radiobutton',
							'name' => 'hb_pre_footer_font',
							'label' => __('Callout Font Settings', 'hbthemes'),
							'description' => __('Specify Pre-Footer callout font settings here.', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb_font_default',
									'label' => __('Default', 'hbthemes'),
								),
								array(
									'value' => 'hb_font_custom',
									'label' => __('Custom Google Web Font', 'hbthemes'),
									),
								),
								'default' => array(
									'hb_font_default',
								),
							),
						array(
						    'type' => 'select',
						    'name' => 'hb_pre_footer_font_face',
						    'label' => __('Callout Font Face', 'hbthemes'),
						    'description' => __('Select Font', 'hbthemes'),
						    'default' => '{{first}}',
						    'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'function',
						                'value' => 'vp_get_gwf_family',
						            ),
						        ),
						    ),
						),
						array(
						    'type' => 'multiselect',
						    'name' => 'hb_font_pre_footer_subsets',
						    'label' => __('Font Subsets', 'hbthemes'),
						    'description' => __('Select Font Subsets', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_pre_footer_font_face',
						                'value' => 'vp_get_gwf_subset',
						            ),
						        ),
						    ),
						    'default' => array(
						        '{{first}}',
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_pre_footer_font_size',
							'label' => __('Callout Font Size', 'hbthemes'),
							'description' => __('Specify callout font size in pixels.', 'hbthemes'),
							'min' => '8',
							'max' => '40',
							'step' => '1',
							'default' => '13',
							'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						),
						array(
						    'type' => 'radiobutton',
						    'name' => 'hb_font_pre_footer_weight',
						    'label' => __('Callout Font Weight', 'hbthemes'),
						    'description' => __('Select font weight', 'hbthemes'),
						    'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						    'items' => array(
						        'data' => array(
						            array(
						                'source' => 'binding',
						                'field' => 'hb_pre_footer_font_face',
						                'value' => 'vp_get_gwf_weight',
						            ),
						        ),
						    ),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_pre_footer_line_height',
							'label' => __('Callout Line Height', 'hbthemes'),
							'description' => __('Specify callout font line height in pixels.', 'hbthemes'),
							'min' => '1',
							'max' => '100',
							'step' => '1',
							'default' => '22',
							'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						),
						array(
							'type' => 'slider',
							'name' => 'hb_pre_footer_letter_spacing',
							'label' => __('Callout Font Letter Spacing', 'hbthemes'),
							'description' => __('Specify callout font letter spacing in pixels.', 'hbthemes'),
							'min' => '-5',
							'max' => '5',
							'step' => '1',
							'default' => '0',
							'dependency' => array(
								'field' => 'hb_pre_footer_font',
								'function' => 'hb_font_body_type',
							),
						),
					),
				),
			),
		),
		array(
			'title' => __('Color Manager', 'hbthemes'),
			'name' => 'hb_color_customize_options_b',
			'icon' => 'font-awesome:hb-moon-palette',
			'controls' => array(
				array(
					'type' => 'radiobutton',
					'name' => 'hb_color_manager_type',
					'label' => '',
					'description' => __('Choose which colors to use.','hbthemes'),
					'items' => array(
						array(
							'value' => 'hb_color_manager_schemes',
							'label' => __('Color Schemes', 'hbthemes'),
							),
						array(
							'value' => 'hb_color_manager_color_customizer',
							'label' => __('Color Customizer', 'hbthemes'),
							),
						),
					'default' => array(
						'hb_color_manager_schemes',
						),
					),
				
				array(
					'type' => 'section',
					'title' => __('Live Color Customizer', 'hbthemes'),
					'name' => 'hb_color_customizer_section',
					'fields' => array(
						array(
							'type' => 'notebox',
							'name' => 'hb_general_notebox_991',
							'label' => null,
							'description' => __('<p>Please "Save Changes" after changing the above options.</p>Changes need to be saved before running the Customizer.</p>', 'hbthemes'),
							'status' => 'normal',
						),
						array(
					        'type' => 'html',
					        'name' => 'hb_customizer_field',
							'default' => hb_color_customizer_html(),
						),	
					),
					'dependency' => array(
						'field' => 'hb_color_manager_type',
						'function' => 'hb_color_manager_function',
					),
				),

				array(
					'type' => 'section',
					'title' => __('Color Shemes', 'hbthemes'),
					'name' => 'hb_scheme_section',
					'description' => __('Choose from a list of inbuilt schemes. You can create your own using color customizer.' , 'hbthemes'),
					'fields' => array(
						array(
							'type' => 'select',
							'name' => 'hb_scheme_chooser',
							'label' => __('Color Schemes', 'hbthemes'),
							'default' => 'default_scheme',
							'items' => array(
								array(
									'value' => 'default_scheme',
									'label' => __('Default - Minimal Blue', 'hbthemes'),
								),
								array(
									'value' => 'minimal_red',
									'label' => __('Minimal Red', 'hbthemes'),
								),
								array(
									'value' => 'minimal_green',
									'label' => __('Minimal Green', 'hbthemes'),
								),
								array(
									'value' => 'minimal_green_alt',
									'label' => __('Minimal Green Alternative', 'hbthemes'),
								),
								array(
									'value' => 'minimal_blue_alt',
									'label' => __('Minimal Blue Alternative', 'hbthemes'),
								),
								array(
									'value' => 'minimal_pink',
									'label' => __('Minimal Pink', 'hbthemes'),
								),
								array(
									'value' => 'minimal_yellow',
									'label' => __('Minimal Yellow', 'hbthemes'),
								),
								array(
									'value' => 'minimal_orange',
									'label' => __('Minimal Orange', 'hbthemes'),
								),
								array(
									'value' => 'minimal_purple',
									'label' => __('Minimal Purple', 'hbthemes'),
								),
								array(
									'value' => 'minimal_grey',
									'label' => __('Minimal Grey', 'hbthemes'),
								),
								array(
									'value' => 'business_blue',
									'label' => __('Business Blue', 'hbthemes'),
								),
								array(
									'value' => 'dark_elegance',
									'label' => __('Dark Elegance', 'hbthemes'),
								),
								array(
									'value' => 'orchyd',
									'label' => __('Orchyd', 'hbthemes'),
								)
								
							),
							'description' => __('Choose a pre-defined color scheme.<p>More schemes coming with every update!</p>','hbthemes'),
						),
					),
					'dependency' => array(
						'field' => 'hb_color_manager_type',
						'function' => 'hb_color_manager_function_n',
					),
				),
			),
		), 

		array(
			'title' => __('Coming Soon Mode', 'hbthemes'),
			'name' => 'hb_theme_maintenance',
			'icon' => 'font-awesome:hb-moon-construction',
			'controls' => array(
				array(
					'type' => 'notebox',
					'name' => 'hb_maint_notebox_2',
					'label' => __('Maintenance Mode Info', 'hbthemes'),
					'description' => __('Welcome to HB Maintenance Settings.<p>&nbsp;</p>If you enable the maintenance mode, only logged-in admins will be able to see the website. Other users will see the coming soon page created from the settings below.', 'hbthemes'),
					'status' => 'normal',
				),
				array(
			        'type' => 'toggle',
			        'label' => __('Under Construction Mode', 'hbthemes'),
			        'description' => __('Enable the maintenance mode (under construction) for your website.', 'hbthemes'),
			        'name' => 'hb_enable_maintenance',
			       	'default' => '0',
				),

				array(
					'type' => 'select',
					'name' => 'hb_maintenance_layout_position',
					'description' => 'Choose the layout position for the Coming Soon Page.',
					'label' => __('Layout Position', 'hbthemes'),
						'items' => array(
							array(
								'value' => 'left-alignment',
								'label' => __('Left', 'hbthemes'),
							),
							array(
								'value' => 'center-alignment',
								'label' => __('Center', 'hbthemes'),
							),
							array(
								'value' => 'right-alignment',
								'label' => __('Right', 'hbthemes'),
							),
						),
						'default' => array(
							'left-alignment',
					),
					'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
				),

				array(
					'type' => 'upload',
					'name' => 'hb_maintenance_logo',
					'label' => __('Logo', 'hbthemes'),
					'description' => __('Upload your logo for the maintenance page. Dimensions should be 177x40px. ', 'hbthemes'),
					'default' => '',
					'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
				),

				array(
			        'type' => 'toggle',
			        'label' => __('Countdown Timer', 'hbthemes'),
			        'description' => __('Show a countdown timer to your website launch.', 'hbthemes'),
			        'name' => 'hb_maintenance_enable_countdown',
			       	'default' => '0',
			       	'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
				),

				array(
					'type' => 'section',
			        'title' => __('Countdown Settings', 'hbthemes'),
			        'name' => 'hb_countdown_section',
			        'dependency' => array(
						'field' => 'hb_maintenance_enable_countdown',
						'function' => 'hb_maint_dependency',
					),
			        'fields' => array(
			        	array(
					        'type' => 'date',
					        'name' => 'hb_countdown_date',
					        'label' => __('Launch Date', 'hbthemes'),
					        'description' => __('Choose the date when your website will be launched. The countdown will count to that day.', 'hbthemes'),
					        'min_date' => 'today',
					        'format' => 'yy-mm-dd',
					        'default' => '+1D',
				    	),

				    	array(
					        'type' => 'slider',
					        'name' => 'hb_countdown_hours',
					        'label' => __('Launch Hour', 'hbthemes'),
					        'description' => __('Choose the time for the launch in hours. Range between 0 and 23. (24 hour format).', 'hbthemes'),
					        'min' => '0',
					        'max' => '23',
					        'step' => '1',
					        'default' => '8',
					    ),

					    array(
					        'type' => 'slider',
					        'name' => 'hb_countdown_minutes',
					        'label' => __('Launch Minutes', 'hbthemes'),
					        'description' => __('Choose the time for the launch in minutes. Range between 0 and 59.', 'hbthemes'),
					        'min' => '0',
					        'max' => '59',
					        'step' => '1',
					        'default' => '30',
					    ),
					    array(
							'type' => 'select',
							'name' => 'hb_countdown_style',
							'label' => __('Counter Style', 'hbthemes'),
							'items' => array(
								array(
									'value' => 'hb-dark-style',
									'label' => __('Dark', 'hbthemes'),
								),
								array(
									'value' => 'hb-light-style',
									'label' => __('Light', 'hbthemes'),
								),
							),
							'default' => array(
								'hb-light-style',
							),
						),
				    ),
				),

		        array(
		            'type' => 'wpeditor',
		            'name' => 'hb_maintenance_content',
		            'label' => __('Maintenance Content', 'hbthemes'),
		            'description' => __('Enter the content for maintenance page which will be showed below logo and countdown if those are selected. Shortcodes are supported. H1 and H4 have special stylings', 'hbthemes'),
		            'use_external_plugins' => '1',
		            'default' => '<h1>We are working on something awesome!</h1><h4>Phasellus sit amet turpis euismod, dignissim ante eget.</h4><h4>Proin porttitor facilisis semper. Maecenas aliquam, sapien vel.</h4>',
		            'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
				),

				array(
			        'type' => 'color',
			        'name' => 'hb_maintenance_bg_color',
			        'label' => __('Background Color', 'hbthemes'),
			        'description' => __('Pick the background color. Will be visible if image is not set.', 'hbthemes'),
			        'default' => '#323436',
			        'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
			    ),

			    array(
					'type' => 'upload',
					'name' => 'hb_maintenance_bg_image',
					'label' => __('Background Image', 'hbthemes'),
					'description' => __('Upload image for the maintenance background. Suggested dimensions are 1920x1080px. ', 'hbthemes'),
					'default' => '',
					'dependency' => array(
						'field' => 'hb_enable_maintenance',
						'function' => 'hb_maint_dependency',
					),
				),
			),
		),
		array(
			'title' => __('System Diagnostics', 'hbthemes'),
			'name' => 'hb_theme_diagnostic',
			'icon' => 'font-awesome:hb-moon-cog-6',
			'controls' => array(
				array(
			        'type' => 'html',
			        'name' => 'hb_diagnostic_field',
			       	'default' => hb_system_diagnostic(),
				),
			),
		),
		array(
			'title' => __('Demo Importer', 'hbthemes'),
			'name' => 'hb_demo_importer',
			'icon' => 'font-awesome:hb-moon-download',
			'controls' => array(
				array(
			        'type' => 'html',
			        'name' => 'hb_demo_importer_field',
			        'default' => hb_demo_import_html(),
				),
			),
		),
	),
);

function hb_nummerize( $size ) {
	$let = substr( $size, -1 );
	$ret = substr( $size, 0, -1 );
	switch( strtoupper( $let ) ) {
	case 'P':
	$ret *= 1024;
	case 'T':
	$ret *= 1024;
	case 'G':
	$ret *= 1024;
	case 'M':
	$ret *= 1024;
	case 'K':
	$ret *= 1024;
	}	
	return $ret;
}

function hb_system_diagnostic() {
	$to_ret = "";

	if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $item_uri = $theme_data->get('ThemeURI');
        $theme_name = $theme_data->get('Name');
        $version = $theme_data->get('Version');
        $theme_author = $theme_data->get('Author');
    }
    $to_ret .= '<p>Below information is useful to diagnose some of the possible reasons to malfunctions, performance issues or any errors.<br/>You can faciliate the process of support by providing below information to our support staff.<br/><br/>You need to reset the Theme Options (Backup Settings > Restore Default) in order to see changes.<br/><br/><strong>If Highend Options are not saving changes - you need to increase your WP_MEMORY_LIMIT. Please follow <a href="http://hb-themes.com/forum/all/topic/theme-options-not-saving-changes-resolved-fix/" target="_blank">these steps.</a></strong></p>';

    $to_ret .= '<div class="vp-section">';
    $to_ret .= '<div class="vp-controls">';

    $to_ret .= '<div class="vp-field"><div class="label"><strong>Theme Name:</strong></div><div class="field">'.$theme_name.'</div></div>';
    $to_ret .= '<div class="vp-field"><div class="label"><strong>Theme Version:</strong></div><div class="field">'.$version.'</div></div>';
    $to_ret .= '<div class="vp-field"><div class="label"><strong>Theme Author:</strong></div><div class="field">'.$theme_author.'</div></div>';
    $to_ret .= '<div class="vp-field"><div class="label"><strong>Site URL:</strong></div><div class="field">'.home_url().'</div></div>';
	$to_ret .= '<div class="vp-field"><div class="label"><strong>Theme Demo:</strong></div><div class="field">'.$item_uri.'</div></div>';
	$to_ret .= '<div class="vp-field"><div class="label"><strong>WordPress Version:</strong></div><div class="field">'.get_bloginfo('version').'</div></div>';
	$to_ret .= '<div class="vp-field"><div class="label"><strong>WordPress Language:</strong></div><div class="field">'.get_bloginfo('language').'</div></div>';
	$to_ret .= '<div class="vp-field"><div class="label"><strong>Admin Email:</strong></div><div class="field">'.get_bloginfo('admin_email').'</div></div>';
	$to_ret .= '<div class="vp-field"><div class="label"><strong>Server Information:</strong></div><div class="field">'.esc_html( $_SERVER['SERVER_SOFTWARE'] ).'</div></div>';

	if ( function_exists( 'phpversion' ) ) {
		$to_ret .= '<div class="vp-field"><div class="label"><strong>PHP Version:</strong></div><div class="field">'.esc_html( phpversion() ).'</div></div>';
	}

	if (function_exists( 'size_format' )) {
		$error = "";
		$mem_limit = hb_nummerize(WP_MEMORY_LIMIT);
        if ( $mem_limit < 67108864 ) {
        	$error = "<span style='color:red;'><br/>Recommended memory limit should be at least 64MB. Please, take a look at: <a href='http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' target='_blank'>Increasing memory allocated to PHP</a> for more information. Don't forget to reset Theme Options after that.</span>";
        }
		$to_ret .= '<div class="vp-field"><div class="label"><strong>WP Memory Limit:</strong></div><div class="field">'.size_format( $mem_limit ).' '. $error .'</div></div>';
	}

	$to_ret .= '<div class="vp-field"><div class="label"><strong>WP Max Upload Size:</strong></div><div class="field">' . size_format( wp_max_upload_size() ).'</div></div>';

	$error_exec = "";
	if ( ini_get("max_execution_time") < 120 ){
		$error_exec = "<span style='color:red;'><br/>Recommended max_execution_time should be at least 120. Please, take a look at: <a href='http://hb-themes.com/forum/all/topic/how-to-increase-max_execution_time-variable/' target='_blank'>Increasing max_execution_time instructions</a> for more information. Don't forget to reset Theme Options after that.</span>";
	}
	$to_ret .= '<div class="vp-field"><div class="label"><strong>Max Execution Time:</strong></div><div class="field">' . ini_get("max_execution_time") . ' '. $error_exec .'</div></div>';

	if ( defined('WP_DEBUG') && WP_DEBUG ) {
		$to_ret .= '<div class="vp-field"><div class="label"><strong>WP Debug Mode:</strong></div><div class="field">Enabled</div></div>';
	} else {
		$to_ret .= '<div class="vp-field"><div class="label"><strong>WP Debug Mode:</strong></div><div class="field">Disabled</div></div>';
	}

    $to_ret .= '</div>';
    $to_ret .= '</div>';

    $to_ret .= '<div class="hb-buttons">';
 	$to_ret .= '<a href="http://forum.hb-themes.com" class="vp-button button button-primary">Support Forum</a>';
 	$to_ret .= '<a href="http://documentation.hb-themes.com/highend" class="vp-button button button-primary">Documentation</a>';
 	$to_ret .= '<a href="http://www.youtube.com/user/hbthemes" class="vp-button button button-primary">Video Tutorials</a>';
    $to_ret .= '</div>';

    return $to_ret;
}

function hb_demo_import_html(){
	$to_return = "";

	$to_return .= "<p>Demo Import will replicate our demo on your website.<br/>Please, use it carefully, it will replace some of your data. Also, make sure you don't have any issues (marked as red) in the <a href=\"" . admin_url('themes.php?page=highend_options#hb_theme_diagnostic') . "\" target=\"_blank\">System Diagnostics</a> section, before importing the demo.</p>";
	$to_return .= "<p>The following data will be imported:</p>";
	$to_return .= "<ol>";
	$to_return .= "<li>Blog Posts from Highend Demo.</li>";
	$to_return .= "<li>All Pages from Highend Demo.</li>";
	$to_return .= "<li>All Custom Post Types items from Highend Demo.</li>";
	$to_return .= "<li>Comments from Highend Demo.</li>";
	$to_return .= "<li>Sliders from Highend Demo. (You need to install and activate sliders first).</li>";
	$to_return .= "<li>Media library from Highend Demo.</li>";
	$to_return .= "<li>Theme Options from Highend Demo.</li>";
	$to_return .= "<li>Widgets and Sidebars from Highend Demo.</li>";
	$to_return .= "<li>WordPress Menus from Highend Demo.</li>";
	$to_return .= "</ol>";
	$to_return .= "<p>FULL Demo Import process can take up to 35 minutes to complete. <strong>DO NOT interrupt the process.</strong></p>";
	$to_return .= "<p>The imported stuff cannot be deleted at once, so we suggest to import the demo on your test website, not live website.</p>";


	$to_return .= '<div class="hb-buttons">';
 	$to_return .= '<a href="#" class="vp-button button button-primary hb-import-button full-demo-import">' . __('Import FULL Demo Content', 'hbthemes') . '</a>';
 	$to_return .= '<a href="#" class="vp-button button button-primary hb-import-button light-demo-import">' . __('Import LIGHT Demo Content*', 'hbthemes') . '</a>';
 	$to_return .= '</div>';

 	$to_return .= "<p>*LIGHT demo content does not include images and sliders. If the full demo fails, try importing the light version.</p>";
 	$to_return .= "<p>Due to large demo export files, on some servers the demo import will fail and cause Error 500 - Internal Server Error.<br/>In that case, please open a support topic on <a href='http://forum.hb-themes.com/'>our forum</a>.<br/><br/>Currently, the one click demo import IS NOT available for iPage hosted websites.</p>";

 	return $to_return;
}

function hb_color_customizer_html(){
	$to_return = "";
	$to_return .= '<div class="hb-buttons">';
 	$to_return .= '<a href="' . admin_url('customize.php') . '" class="vp-button button button-primary">'. __('Run Live Color Customizer', 'hbthemes') . '</a>';
 	$to_return .= '</div>';

 	return $to_return;
}
?>