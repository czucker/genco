<?php
/*
Plugin Name: Amazing Hover Effects 
Plugin URI: http://www.bolobd.com/plugins/amazing-hover-effects/
Description: Amazing Hover Effects is an impressive hover effects collection, powered by pure CSS3 and iHover, no dependency.
Author: Noor-E-Alam
Author URI: http://bolobd.com
Version: 1.3
*/

//Loading CSS
function amazing_hover_effects_style() {

	wp_enqueue_style('ahew_stylesheet', plugins_url( '/css/ihover.css' , __FILE__ ) );

}

add_action( 'wp_enqueue_scripts', 'amazing_hover_effects_style' );

if(!class_exists('VP_AutoLoader')){
// Setup Contants
defined( 'VP_PLUGIN_VERSION' ) or define( 'VP_PLUGIN_VERSION', '2.0' );
defined( 'VP_PLUGIN_URL' )     or define( 'VP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
defined( 'VP_PLUGIN_DIR' )     or define( 'VP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
defined( 'VP_PLUGIN_FILE' )    or define( 'VP_PLUGIN_FILE', __FILE__ );

// Load Languages
add_action('plugins_loaded', 'ahew_load_textdomain');

function ahew_load_textdomain()
{
	load_plugin_textdomain( 'vp_textdomain', false, dirname( plugin_basename( __FILE__ ) . '/vafpress-framework/lang/' ) ); 
}

// Lood Bootstrap
require 'framework/bootstrap.php';

}

// Registering Custom Post
add_action( 'init', 'amazing_hover_effects_custom_post' );
function amazing_hover_effects_custom_post() {
	register_post_type( 'hover-effect',
		array(
			'labels' => array(
				'name' => __( 'Hover Effects' ),
				'singular_name' => __( 'Hover Effect' ),
				'add_new_item' => __( 'Add New Hover Effect' )
			),
			'public' => true,
			'supports' => array('title'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'hover-effects'),
			'menu_icon' => '',
			'menu_position' => 5,
		)
	);
	
}

// Registering Custom post's category
add_action( 'init', 'amazing_hover_effects_custom_post_taxonomy'); 
function amazing_hover_effects_custom_post_taxonomy() {
	register_taxonomy(
		'hover_cat',  
		'hover-effect',
		array(
			'hierarchical'          => true,
			'label'                         => 'Hover Effects Category',
			'query_var'             => true,
			'show_admin_column'             => true,
			'rewrite'                       => array(
				'slug'                  => 'he-category',
				'with_front'    => true
				)
			)
	);
}
  
 

require 'admin/metabox/icon.php';

// Load Metaboxes 

new VP_Metabox(array
(
			'id'          => 'infosmeta',
			'types'       => array('hover-effect'),
			'title'       => __('Hover Image, Title, Description ', 'vp_textdomain'),
			'priority'    => 'high',
			'template' => VP_PLUGIN_DIR . '/admin/metabox/main.php'
));
new VP_Metabox(array
(
			'id'          => 'effectsmeta',
			'types'       => array('hover-effect'),
			'title'       => __('Hover Effects Setting', 'vp_textdomain'),
			'priority'    => 'high',
			'template' => VP_PLUGIN_DIR . '/admin/metabox/effects.php'
));


// Register Shortcode
function amazing_hover_effects_shortcode($atts){
	extract( shortcode_atts( array(
	
		'category' => '',	
		
	), $atts) );
	
	
	    $q = new WP_Query(
        array('posts_per_page' => -1, 'post_type' => 'hover-effect', 'hover_cat' => $category)
        );
	
		while($q->have_posts()) : $q->the_post();
		$id = get_the_ID();	


					
					
	$infos = vp_metabox('infosmeta.hover_info', false);	
	//$shape = vp_metabox('effectsmeta.effects.0.shape', false);	
	$effect = vp_metabox('effectsmeta.effects.0.effect', false);	
	$animation = vp_metabox('effectsmeta.effects.0.animation', false);	
	$colored = vp_metabox('effectsmeta.effects.0.colored', false);	
	
	$i = 0;

		$output = '<ul class="ihover-container">';

		foreach ($infos as $info) {	
		
		
		$output .='<li class="hover_effects_li">';
		
		if($effect=="effect6"){
            $output .= '<div class="ih-item  circle '.$colored.' '.$effect.' scale_up"><a href="#">';
        }else{
			$output .='<div class="ih-item  circle '.$colored.' '.$effect.' '.$animation.'"><a href="#">';
		}
		$output .='<div class="img"><img src="'.$info['image'].'"></div>';
		$output .='<div class="info"><h3>'.$info['title'].'</h3><p>'.$info['description'].'</p></div></a></div></li>';


		$i++;
	}

	endwhile;
	$output .='</ul>';
	$output .= '<style>
					.ihover-container {
							clear: both;
							display: inline-block;
							list-style-type: none;
							margin: 0;
							padding: 0;
							position: relative;
							width: 100%;
						}
						.ihover-container li {
							background: none repeat scroll 0 0 transparent;
							float: left;
							list-style: none outside none;
							margin: 0 12px 50px 0;
							padding: 0;
							width: 300px;
						}
						.ihover-container li img {
							border-radius: 0;
							box-shadow: none;
							display: block;
							margin: 0;
							padding: 0;
						}
				</style>';
	wp_reset_query();
	return $output;
}

add_shortcode('hover', 'amazing_hover_effects_shortcode');	

add_filter('widget_text', 'do_shortcode');

//Tinymce Button Add

add_action('admin_head', 'amazing_hover_effects_tc_button');

function amazing_hover_effects_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
   	return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
	// check if WYSIWYG is enabled
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "amazing_hover_effects_tc_button_add_tinymce_plugin");
		add_filter('mce_buttons', 'amazing_hover_effects_tc_button_add_tinymce_plugin_register_my_tc_button');
	}
}

function amazing_hover_effects_tc_button_add_tinymce_plugin($plugin_array) {
   	$plugin_array ['ihover_tc_button'] = plugins_url( '/admin/tinymce/button.js', __FILE__ );
   	return $plugin_array;
}


function amazing_hover_effects_tc_button_add_tinymce_plugin_register_my_tc_button($buttons) {
   array_push($buttons, "ihover_tc_button");
   return $buttons;
}




?>