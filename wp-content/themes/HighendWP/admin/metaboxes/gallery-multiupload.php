<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 */

/********************* META BOX DEFINITIONS ***********************/

add_action( 'admin_init', 'rw_register_meta_boxes' );
function rw_register_meta_boxes()
{
	
	global $meta_boxes;
	global $data;
	global $wpdb;

	$prefix = 'hb_';
	$meta_boxes = array();
	
	$meta_boxes[] = array(
		'id'		=> 'gallery_images',
		'title'		=> 'Gallery Images',
		'pages'		=> array( 'post' , 'gallery' ),
		'context' => 'normal',
	
		'fields'	=> array(
			array(
				'name'	=> 'Gallery Images',
				'desc'	=> 'Upload gallery images for the slideshow.',
				'id'	=> $prefix . 'gallery_images',
				'type'	=> 'plupload_image',
				'html' => '',
				'max_file_uploads' => 1000,
			)
			
		)
	);

	$meta_boxes[] = array(
		'id'		=> 'portfolio_images',
		'title'		=> 'Portfolio Flex Slider Images',
		'pages'		=> array( 'portfolio' ),
		'context' => 'normal',
	
		'fields'	=> array(
			array(
				'name'	=> 'Flex Slider Images',
				'desc'	=> 'Upload images for the flexslider.',
				'id'	=> $prefix . 'portfolio_flexslider_images',
				'type'	=> 'plupload_image',
				'html' => '',
				'max_file_uploads' => 1000,
			)
			
		)
	);
	foreach ( $meta_boxes as $meta_box ) {
		new RW_Meta_Box( $meta_box );
	}
}