<?php 
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php

function hb_register_customizer( $wp_customize ) {


	/* CHANGE TRANSPORT METHOD
    ================================================== */

    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';



	/* FOCUS COLOR SECTION
    ================================================== */
	$wp_customize->add_section( 'hb_focus_color_section' , array(
		'title'      	=> __('Color - Accent','hbthemes'),
		'priority'   	=> 300,
		'description'   => null
	));

	$wp_customize->add_setting( 'hb_focus_color_setting' , array(
		'default'		=> '#1dc6df',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_focus_color_setting', array(
		'label'			=> __( 'Accent Color', 'mytheme' ),
		'section'		=> 'hb_focus_color_section'
	)));


	/* TOP BAR SECTION
    ================================================== */
    $wp_customize->add_section( 'hb_top_bar_section' , array(
		'title'      	=> __('Color - Top Bar','hbthemes'),
		'priority'   	=> 301,
		'description'   => 'Accent color will be used as link hover color.'
	));


    // Background
	$wp_customize->add_setting( 'hb_top_bar_bg_setting' , array(
		'default'		=> '#ffffff',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_top_bar_bg_setting', array(
		'label'			=> __( 'Background Color', 'hbthemes' ),
		'section'		=> 'hb_top_bar_section'
	)));


	// Border Color
	$wp_customize->add_setting( 'hb_top_bar_border_setting' , array(
		'default'		=> '#e1e1e1',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_top_bar_border_setting', array(
		'label'			=> __( 'Border Color', 'hbthemes' ),
		'section'		=> 'hb_top_bar_section'
	)));


	// Text Color
	$wp_customize->add_setting( 'hb_top_bar_text_color_setting' , array(
		'default'		=> '#777777',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_top_bar_text_color_setting', array(
		'label'			=> __( 'Text Color', 'hbthemes' ),
		'section'		=> 'hb_top_bar_section'
	)));


	// Link Color
	$wp_customize->add_setting( 'hb_top_bar_link_color_setting' , array(
		'default'		=> '#444',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_top_bar_link_color_setting', array(
		'label'			=> __( 'Link Color', 'hbthemes' ),
		'section'		=> 'hb_top_bar_section'
	)));



    /* NAVIGATION BAR SECTION
    ================================================== */
	$wp_customize->add_section( 'hb_nav_bar_section' , array(
		'title'      	=> __('Color - Navigation Bar','hbthemes'),
		'priority'   	=> 302,
		'description'   => 'Accent color will be used as link hover color.'
	));

	// Background
	$wp_customize->add_setting( 'hb_nav_bar_bg_setting' , array(
		'default'		=> '#ffffff',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_bg_setting', array(
		'label'			=> __( 'Background Color', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 20,
	)));

	// Background Stuck
	$wp_customize->add_setting( 'hb_nav_bar_stuck_bg_setting' , array(
		'default'		=> '#ffffff',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_stuck_bg_setting', array(
		'label'			=> __( 'Background Color (Sticky)', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 50,
	)));

	// Text Color
	$wp_customize->add_setting( 'hb_nav_bar_text_setting' , array(
		'default'		=> '#444',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_text_setting', array(
		'label'			=> __( 'Text Color', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 30,
	)));

	// Text Color Stuck
	$wp_customize->add_setting( 'hb_nav_bar_stuck_text_setting' , array(
		'default'		=> '#444',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_stuck_text_setting', array(
		'label'			=> __( 'Text Color (Sticky)', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 60,
	)));


	// Border Color
	$wp_customize->add_setting( 'hb_nav_bar_border_setting' , array(
		'default'		=> '#e1e1e1',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_border_setting', array(
		'label'			=> __( 'Border Color', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 40,
	)));


	// Border Color (Stuck)
	$wp_customize->add_setting( 'hb_nav_bar_stuck_border_setting' , array(
		'default'		=> '#e1e1e1',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_nav_bar_stuck_border_setting', array(
		'label'			=> __( 'Border Color (Sticky)', 'hbthemes' ),
		'section'		=> 'hb_nav_bar_section',
		'priority'   	=> 70,
	)));



    /* PRE-FOOTER SECTION
    ================================================== */
    $wp_customize->add_section( 'hb_pfooter_section' , array(
		'title'      	=> __('Color - Callout (Pre Footer)','hbthemes'),
		'priority'   	=> 303,
		'description'   => 'Accent color will be used as link hover color.'
	));

	// Background
	$wp_customize->add_setting( 'hb_pfooter_bg_setting' , array(
		'default'		=> '#ececec',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_pfooter_bg_setting', array(
		'label'			=> __( 'Background Color', 'hbthemes' ),
		'section'		=> 'hb_pfooter_section',
		'priority'   	=> 20,
	)));

	// Color
	$wp_customize->add_setting( 'hb_pfooter_text_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_pfooter_text_setting', array(
		'label'			=> __( 'Text Color', 'hbthemes' ),
		'section'		=> 'hb_pfooter_section',
		'priority'   	=> 30,
	)));



    /* FOOTER SECTION
    ================================================== */
    $wp_customize->add_section( 'hb_footer_section' , array(
		'title'      	=> __('Color - Footer','hbthemes'),
		'priority'   	=> 304,
		'description'   => 'Accent color will be used as link hover color.'
	));


	// Background
	$wp_customize->add_setting( 'hb_footer_bg_setting' , array(
		'default'		=> '#222',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_footer_bg_setting', array(
		'label'			=> __( 'Background Color', 'hbthemes' ),
		'section'		=> 'hb_footer_section',
		'priority'   	=> 20,
	)));

	// Color
	$wp_customize->add_setting( 'hb_footer_text_setting' , array(
		'default'		=> '#999',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_footer_text_setting', array(
		'label'			=> __( 'Text Color', 'hbthemes' ),
		'section'		=> 'hb_footer_section',
		'priority'   	=> 30,
	)));

	// Link Color
	$wp_customize->add_setting( 'hb_footer_link_setting' , array(
		'default'		=> '#fff',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_footer_link_setting', array(
		'label'			=> __( 'Link Color', 'hbthemes' ),
		'section'		=> 'hb_footer_section',
		'priority'   	=> 40,
	)));


    /* COPYRIGHT LINE SECTION
    ================================================== */
  	$wp_customize->add_section( 'hb_copyright_section' , array(
		'title'      	=> __('Color - Copyright Bar','hbthemes'),
		'priority'   	=> 305,
		'description'   => 'Accent color will be used as link hover color.'
	));


	// Background
	$wp_customize->add_setting( 'hb_copyright_bg_setting' , array(
		'default'		=> '#292929',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_copyright_bg_setting', array(
		'label'			=> __( 'Background Color', 'hbthemes' ),
		'section'		=> 'hb_copyright_section',
		'priority'   	=> 20,
	)));

	// Color
	$wp_customize->add_setting( 'hb_copyright_text_setting' , array(
		'default'		=> '#999',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_copyright_text_setting', array(
		'label'			=> __( 'Text Color', 'hbthemes' ),
		'section'		=> 'hb_copyright_section',
		'priority'   	=> 30,
	)));

	// Link Color
	$wp_customize->add_setting( 'hb_copyright_link_setting' , array(
		'default'		=> '#fff',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_copyright_link_setting', array(
		'label'			=> __( 'Link Color', 'hbthemes' ),
		'section'		=> 'hb_copyright_section',
		'priority'   	=> 40,
	)));



	/* CONTENT SECTION
    ================================================== */
  	$wp_customize->add_section( 'hb_content_section' , array(
		'title'      	=> __('Color - Content','hbthemes'),
		'priority'   	=> 306,
		'description'   => 'Accent color will be used as link hover color.'
	));


	// Background
	$wp_customize->add_setting( 'hb_content_bg_setting' , array(
		'default'		=> '#444444',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_bg_setting', array(
		'label'			=> __( 'Body Background Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 20,
	)));


	// Content Background
	$wp_customize->add_setting( 'hb_content_c_bg_setting' , array(
		'default'		=> '#f9f9f9',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_c_bg_setting', array(
		'label'			=> __( 'Content Background Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 30,
	)));


	// Content Text Color
	$wp_customize->add_setting( 'hb_content_text_color_setting' , array(
		'default'		=> '#343434',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_text_color_setting', array(
		'label'			=> __( 'Content Text Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 40,
	)));


	// Content Text Color
	$wp_customize->add_setting( 'hb_content_link_color_setting' , array(
		'default'		=> '#222',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_link_color_setting', array(
		'label'			=> __( 'Content Link Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 40,
	)));


	// Content Text Color
	$wp_customize->add_setting( 'hb_content_border_setting' , array(
		'default'		=> '#e1e1e1',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_border_setting', array(
		'label'			=> __( 'Various Borders Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 50,
	)));


	// H1
	$wp_customize->add_setting( 'hb_content_h1_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h1_setting', array(
		'label'			=> __( 'H1 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 50,
	)));

	// H2
	$wp_customize->add_setting( 'hb_content_h2_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h2_setting', array(
		'label'			=> __( 'H2 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 51,
	)));

	// H3
	$wp_customize->add_setting( 'hb_content_h3_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h3_setting', array(
		'label'			=> __( 'H3 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 52,
	)));

	// H4
	$wp_customize->add_setting( 'hb_content_h4_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h4_setting', array(
		'label'			=> __( 'H4 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 53,
	)));

	// H5
	$wp_customize->add_setting( 'hb_content_h5_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h5_setting', array(
		'label'			=> __( 'H5 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 54,
	)));

	// H6
	$wp_customize->add_setting( 'hb_content_h6_setting' , array(
		'default'		=> '#323436',
		'type'			=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'transport'		=> 'postMessage'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hb_content_h6_setting', array(
		'label'			=> __( 'H6 Color', 'hbthemes' ),
		'section'		=> 'hb_content_section',
		'priority'   	=> 55,
	)));

}
add_action( 'customize_register', 'hb_register_customizer', 1 );


function hb_customize_script(){
	wp_enqueue_script( 
		  'hb-customizer',
		  get_template_directory_uri().'/scripts/hb-customizer-final.js',
		  array( 'jquery','customize-preview' ),
		  rand(),
		  false
	);
}
add_action( 'customize_preview_init', 'hb_customize_script', 999 );

	
?>