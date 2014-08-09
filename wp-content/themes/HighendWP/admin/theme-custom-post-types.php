<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
 
function hb_register_post_types () {	
	register_post_type ( 'team' , 
			array(
				'labels' => array ( 
					'name' => __('Team Members','hbthemes'),
					'all_items' => __( 'All Members' , 'hbthemes' ),
					'singular_name' => __( 'Team Member' , 'hbthemes' ) ,		
					'add_new' => __( 'Add New', 'hbthemes' ),
					'add_new_item' => __( 'Add New Team Member', 'hbthemes' ),
					'edit_item' => __( 'Edit Team Member', 'hbthemes' ),
					'new_item' =>  __( 'New Team Member', 'hbthemes' ),
					'view_item' =>  __( 'View Team Member', 'hbthemes' ),
					'search_items' =>  __( 'Search Team Members', 'hbthemes' ),
					'not_found' =>  __( 'No team members have been added yet', 'hbthemes' ),
					'not_found_in_trash' => __( 'Nothing found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'editor',
						'title', 
						'excerpt',
						'thumbnail',
						'page-attributes',
						),
				'query_var' => true,
				'exclude_from_search' => false,
				'show_in_nav_menus' => true,
				'menu_icon' => 'dashicons-id',
			)
		);


	register_post_type ( 'clients' , 
			array(
				'labels' => array ( 
					'name' => __('Clients','hbthemes'),
					'all_items' => __( 'All Clients' , 'hbthemes' ),
					'singular_name' => __( 'Client' , 'hbthemes' ) ,		
					'add_new' => __( 'Add New Client', 'hbthemes' ),
					'add_new_item' => __( 'Add New Client', 'hbthemes' ),
					'edit_item' => __( 'Edit Client', 'hbthemes' ),
					'new_item' =>  __( 'New Client', 'hbthemes' ),
					'view_item' =>  __( 'View Client', 'hbthemes' ),
					'search_items' =>  __( 'Search For Clients', 'hbthemes' ),
					'not_found' =>  __( 'No Clients found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No Clients found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title', 
						'page-attributes',
						),
				'query_var' => true,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'menu_icon' => 'dashicons-businessman',
			)
		);


	register_post_type ( 'faq' , 
			array(
				'labels' => array ( 
					'name' => __('FAQ','hbthemes'),
					'all_items' => __( 'All FAQ Items' , 'hbthemes' ),
					'singular_name' => __( 'FAQ Item' , 'hbthemes' ) ,		
					'add_new' => __( 'Add New FAQ Item', 'hbthemes' ),
					'add_new_item' => __( 'Add New FAQ Item', 'hbthemes' ),
					'edit_item' => __( 'Edit FAQ Item', 'hbthemes' ),
					'new_item' =>  __( 'New FAQ Item', 'hbthemes' ),
					'view_item' =>  __( 'View FAQ Item', 'hbthemes' ),
					'search_items' =>  __( 'Search For FAQ Items', 'hbthemes' ),
					'not_found' =>  __( 'No FAQ Items found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No FAQ Items found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title', 
						'editor', 
						'page-attributes',
						'custom-fields',
						'comments'
						),
				'query_var' => true,
				'exclude_from_search' => false,
				'show_in_nav_menus' => true,
				'menu_icon' => 'dashicons-editor-help',
			)
		);

	register_post_type ( 'hb_pricing_table', 
			array(
				'labels' => array ( 
					'name' => __('Pricing Tables','hbthemes'),
					'all_items' => __( 'All Pricing Tables' , 'hbthemes' ),
					'singular_name' => __( 'Pricing Table' , 'hbthemes' ) ,		
					'add_new' => __( 'Add Pricing Table', 'hbthemes' ),
					'add_new_item' => __( 'Add New Pricing Table', 'hbthemes' ),
					'edit_item' => __( 'Edit Pricing Table', 'hbthemes' ),
					'new_item' =>  __( 'New Pricing Table', 'hbthemes' ),
					'view_item' =>  __( 'View Pricing Table', 'hbthemes' ),
					'search_items' =>  __( 'Search For Pricing Tables', 'hbthemes' ),
					'not_found' =>  __( 'No Pricing Tables found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No Pricing Tables found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title',  
						'page-attributes',
						'custom-fields',
						),
				'query_var' => false,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'menu_icon' => 'dashicons-tag',
			)
		);

	register_post_type ( 'hb_testimonials', 
			array(
				'labels' => array ( 
					'name' => __('Testimonials','hbthemes'),
					'all_items' => __( 'All Testimonials' , 'hbthemes' ),
					'singular_name' => __( 'Testimonial' , 'hbthemes' ) ,		
					'add_new' => __( 'Add Testimonial', 'hbthemes' ),
					'add_new_item' => __( 'Add New Testimonial', 'hbthemes' ),
					'edit_item' => __( 'Edit Testimonial', 'hbthemes' ),
					'new_item' =>  __( 'New Testimonial', 'hbthemes' ),
					'view_item' =>  __( 'View Testimonial', 'hbthemes' ),
					'search_items' =>  __( 'Search For Testimonials', 'hbthemes' ),
					'not_found' =>  __( 'No Testimonials found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No Testimonials found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title',  
						'page-attributes',
						'custom-fields',
						'editor',
						),
				'query_var' => false,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'menu_icon' => 'dashicons-format-quote',
			)
		);

	register_post_type ( 'portfolio' , 
			array(
				'labels' => array ( 
					'name' => __('Portfolio','hbthemes'),
					'all_items' => __( 'All Portfolio Items' , 'hbthemes' ),
					'singular_name' => __( 'Portfolio Item' , 'hbthemes' ) ,		
					'add_new' => __( 'Add New Portfolio Item', 'hbthemes' ),
					'add_new_item' => __( 'Add New Portfolio Item', 'hbthemes' ),
					'edit_item' => __( 'Edit Portfolio Item', 'hbthemes' ),
					'new_item' =>  __( 'New Portfolio Item', 'hbthemes' ),
					'view_item' =>  __( 'View Portfolio Item', 'hbthemes' ),
					'search_items' =>  __( 'Search For Portfolio Items', 'hbthemes' ),
					'not_found' =>  __( 'No Portfolio Items found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No Portfolio Items found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title', 
						'editor', 
						'thumbnail',
						'page-attributes',
						'custom-fields',
						'comments',
						),
				'query_var' => true,
				'exclude_from_search' => false,
				'show_in_nav_menus' => true,
				'menu_icon' => 'dashicons-portfolio',
				'rewrite' => array( 'slug' , 'portfolio-item' )
			)
		);



	register_post_type ( 'gallery' , 
			array(
				'labels' => array ( 
					'name' => __('Gallery','hbthemes'),
					'all_items' => __( 'All Gallery Items' , 'hbthemes' ),
					'singular_name' => __( 'Gallery Item' , 'hbthemes' ) ,		
					'add_new' => __( 'Add New Gallery Item', 'hbthemes' ),
					'add_new_item' => __( 'Add New Gallery Item', 'hbthemes' ),
					'edit_item' => __( 'Edit Gallery Item', 'hbthemes' ),
					'new_item' =>  __( 'New Gallery Item', 'hbthemes' ),
					'view_item' =>  __( 'View Gallery Item', 'hbthemes' ),
					'search_items' =>  __( 'Search For Gallery Items', 'hbthemes' ),
					'not_found' =>  __( 'No Gallery Items found', 'hbthemes' ),
					'not_found_in_trash' => __( 'No Gallery Items found in Trash', 'hbthemes' ),
					'parent_item_colon' => ''
				),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array(
						'title', 
						'editor', 
						'thumbnail',
						'page-attributes',
						'custom-fields',
						),
				'query_var' => true,
				'exclude_from_search' => false,
				'show_in_nav_menus' => true,
				'menu_icon' => 'dashicons-format-gallery',
			)
		);

}
add_action( 'after_setup_theme', 'hb_register_post_types' , 0);
?>