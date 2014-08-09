<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

add_action ('after_setup_theme' , 'hb_create_taxonomies' , 0);
function hb_create_taxonomies () {
 
	// FAQ Categories
	$faq_category_labels = array(
		'name' => __( 'FAQ Categories', 'hbthemes' ),
		'singular_name' => __( 'FAQ Category', 'hbthemes' ),
		'search_items' =>  __( 'Search FAQ Categories', 'hbthemes' ),
		'all_items' => __( 'All FAQ Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent FAQ Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent FAQ Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit FAQ Category', 'hbthemes' ),
		'update_item' => __( 'Update FAQ Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New FAQ Category', 'hbthemes' ),
		'new_item_name' => __( 'New FAQ Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used FAQ categories', 'hbthemes' )
	); 	

	register_taxonomy('faq_categories', 'faq' ,array(
		'hierarchical' => true,
		'labels' => $faq_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('faq_category','hbthemes') ),
	));

	// Testimonial Categories
	$testimonial_category_labels = array(
		'name' => __( 'Testimonial Categories', 'hbthemes' ),
		'singular_name' => __( 'Testimonial Category', 'hbthemes' ),
		'search_items' =>  __( 'Search Testimonial Categories', 'hbthemes' ),
		'all_items' => __( 'All Testimonial Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent Testimonial Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit Testimonial Category', 'hbthemes' ),
		'update_item' => __( 'Update Testimonial Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New Testimonial Category', 'hbthemes' ),
		'new_item_name' => __( 'New Testimonial Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used Testimonial categories', 'hbthemes' )
	); 	

	register_taxonomy('testimonial_categories', 'hb_testimonials' ,array(
		'hierarchical' => true,
		'labels' => $testimonial_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('testimonial_category','hbthemes') ),
	));


	// Client Categories
	$client_category_labels = array(
		'name' => __( 'Client Categories', 'hbthemes' ),
		'singular_name' => __( 'Client Category', 'hbthemes' ),
		'search_items' =>  __( 'Search Client Categories', 'hbthemes' ),
		'all_items' => __( 'All Client Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent Client Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent Client Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit Client Category', 'hbthemes' ),
		'update_item' => __( 'Update Client Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New Client Category', 'hbthemes' ),
		'new_item_name' => __( 'New Client Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used Client categories', 'hbthemes' )
	); 	

	register_taxonomy('client_categories', 'clients' ,array(
		'hierarchical' => true,
		'labels' => $client_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('client_category','hbthemes') ),
	));

	// Employee Categories
	$employee_category_labels = array(
		'name' => __( 'Team Categories', 'hbthemes' ),
		'singular_name' => __( 'Team Member Category', 'hbthemes' ),
		'search_items' =>  __( 'Search Team Member Categories', 'hbthemes' ),
		'all_items' => __( 'All Team Member Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent Team Member Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent Team Member Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit Team Member Category', 'hbthemes' ),
		'update_item' => __( 'Update Team Member Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New Team Member Category', 'hbthemes' ),
		'new_item_name' => __( 'New Team Member Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used Team Member categories', 'hbthemes' )
	); 	

	register_taxonomy('team_categories', 'team' ,array(
		'hierarchical' => true,
		'labels' => $employee_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('team_member_category','hbthemes') ),
	));

	// Portfolio Categories
	$portfolio_category_labels = array(
		'name' => __( 'Portfolio Categories', 'hbthemes' ),
		'singular_name' => __( 'Portfolio Category', 'hbthemes' ),
		'search_items' =>  __( 'Search Portfolio Categories', 'hbthemes' ),
		'all_items' => __( 'All Portfolio Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent Portfolio Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit Portfolio Category', 'hbthemes' ),
		'update_item' => __( 'Update Portfolio Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New Portfolio Category', 'hbthemes' ),
		'new_item_name' => __( 'New Portfolio Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used Portfolio categories', 'hbthemes' )
	); 	

	register_taxonomy('portfolio_categories', 'portfolio' ,array(
		'hierarchical' => true,
		'labels' => $portfolio_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('portfolio_category','hbthemes') ),
	));

	// Portfolio Categories
	$gallery_category_labels = array(
		'name' => __( 'Gallery Categories', 'hbthemes' ),
		'singular_name' => __( 'Gallery Category', 'hbthemes' ),
		'search_items' =>  __( 'Search Gallery Categories', 'hbthemes' ),
		'all_items' => __( 'All Gallery Categories', 'hbthemes' ),
		'parent_item' => __( 'Parent Gallery Category', 'hbthemes' ),
		'parent_item_colon' => __( 'Parent Gallery Category:', 'hbthemes' ),
		'edit_item' => __( 'Edit Gallery Category', 'hbthemes' ),
		'update_item' => __( 'Update Gallery Category', 'hbthemes' ),
		'add_new_item' => __( 'Add New Gallery Category', 'hbthemes' ),
		'new_item_name' => __( 'New Gallery Category Name', 'hbthemes' ),
		'choose_from_most_used'	=> __( 'Choose from the most used Gallery categories', 'hbthemes' )
	); 	

	register_taxonomy('gallery_categories', 'gallery' ,array(
		'hierarchical' => true,
		'labels' => $gallery_category_labels,
		'query_var' => true,
		'rewrite' => array( 'slug' => __('gallery_category','hbthemes') ),
	));

}
?>