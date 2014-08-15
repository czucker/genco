<?php
/**
Plugin Name: Sidebar & Widget Manager
Plugin URI: http://OTWthemes.com
Description:  Get full control over your sidebars (widgetized areas) and widgets. You can now customize each page with specific content and widgets that are relative to the content on that page. No coding required.
Author: OTWthemes.com
Version: 3.8

Author URI: http://themeforest.net/user/OTWthemes
*/

load_plugin_textdomain('otw_sbm',false,dirname(plugin_basename(__FILE__)) . '/languages/');

$wp_sbm_int_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_sbm' ), __( 'All pages', 'otw_sbm' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_sbm' ), __( 'All posts', 'otw_sbm' ) ),
	'postsincategory'   => array( array(), __( 'All posts from category', 'otw_sbm' ), __( 'All categories', 'otw_sbm' ) ),
	'postsintag'        => array( array(), __( 'All posts from tag', 'otw_sbm' ), __( 'All tags', 'otw_sbm' ) ),
	'category'          => array( array(), __( 'Categories archives', 'otw_sbm' ), __( 'All categories archives', 'otw_sbm' ) ),
	'posttag'           => array( array(), __( 'Tags archives', 'otw_sbm' ), __( 'All tags archives', 'otw_sbm' ) ),
	'author_archive'    => array( array(), __( 'Author archives', 'otw_sbm' ), __( 'All author archives', 'otw_sbm' ) ),
	'templatehierarchy' => array( array(), __( 'Template Hierarchy', 'otw_sbm'), __( 'All templates', 'otw_sbm' ) ),
	'pagetemplate'      => array( array(), __( 'Page Templates', 'otw_sbm' ), __( 'All page templates', 'otw_sbm' ) ),
	'archive'           => array( array(), __( 'Archives', 'otw_sbm' ), __( 'All archives', 'otw_sbm' ) ),
	'userroles'         => array( array(), __( 'User roles/Logged in as', 'otw_sbm' ), __( 'All roles', 'otw_sbm' ) ),
);
$wp_sbm_tmc_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_sbm' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_sbm' ) ),
	'cpt'               => array( array(), __( 'Custom Post Types', 'otw_sbm' ) )
);
$otw_sbm_widget_settings = array( 
	'before_widget' => array( __( 'HTML to be placed before every widget.', 'otw_sbm' ), '<div id="%1$s" class="widget %2$s">' ),
	'after_widget' => array( __( 'HTML to be placed after every widget.', 'otw_sbm' ), '</div>' ),
	'before_title' =>array( __( 'HTML to be placed before every widget title.', 'otw_sbm' ), ' <h3 class="widgettitle">' ),
	'after_title' =>array(  __( 'HTML to be placed after every widget title.', 'otw_sbm' ), '</h3>' )
);
$wp_sbm_gm_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_sbm' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_sbm' ) ),
	'cpt'               => array( array(), __( 'Custom Post Types', 'otw_sbm' ) )
);
$wp_sbm_cs_items = array(
	'page'              => array( array(), __( 'Pages', 'otw_sbm' ) ),
	'post'              => array( array(), __( 'Posts', 'otw_sbm' ) ),
	'cpt'               => array( array(), __( 'Custom Post Types', 'otw_sbm' ) )
);
global $otw_plugin_options;

$otw_plugin_options = get_option( 'otw_plugin_options' );

$otw_sbm_plugin_url = plugins_url( substr( dirname( __FILE__ ), strlen( dirname( dirname( __FILE__ ) ) ) ) );

require_once( plugin_dir_path( __FILE__ ).'/include/otw_functions.php' );

//otw components
$otw_sbm_grid_manager_component = false;
$otw_sbm_grid_manager_object = false;

$otw_sbm_shortcode_component = false;

$otw_sbm_form_component = false;

$otw_sbm_content_sidebars_component = false;

//load core component functions
@include_once( 'include/otw_components/otw_functions/otw_functions.php' );

if( !function_exists( 'otw_register_component' ) ){
	wp_die( 'Please include otw components' );
}

//register grid manager component
otw_register_component( 'otw_grid_manager', dirname( __FILE__ ).'/include/otw_components/otw_grid_manager/', $otw_sbm_plugin_url.'/include/otw_components/otw_grid_manager/' );

//register form component
otw_register_component( 'otw_form', dirname( __FILE__ ).'/include/otw_components/otw_form/', $otw_sbm_plugin_url.'/include/otw_components/otw_form/' );

//register shortcode component
otw_register_component( 'otw_shortcode', dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', $otw_sbm_plugin_url.'/include/otw_components/otw_shortcode/' );

//register content sidebars component
otw_register_component( 'otw_content_sidebars', dirname( __FILE__ ).'/include/otw_components/otw_content_sidebars/', $otw_sbm_plugin_url.'/include/otw_components/otw_content_sidebars/' );

/** calls list of available sidebars
  *
  */
function otw_sidebars_list(){
	if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ){
		require_once( 'include/otw_manage_sidebar.php' );
	}else{
		require_once( 'include/otw_list_sidebars.php' );
	}
}

/** calls page where to create new sidebars
  *
  */
function otw_sidebars_manage(){
	require_once( 'include/otw_manage_sidebar.php' );
}

/** delete sidebar
  *
  */
function otw_sidebars_action(){
	require_once( 'include/otw_sidebar_action.php' );
}

/** plugin options
  *
  */
function otw_sidebars_options(){
	require_once( 'include/otw_sidebar_options.php' );
}

/** calls page with widget_dialog
  *
  */
function otw_sidebars_widget_dialog(){
	require_once( 'include/otw_widget_dialog.php' );
}
function otw_sidebars_ajax_widget_dialog(){
	require_once( 'include/otw_widget_dialog.php' );
	die;
}
function otw_editor_dialog(){
	require_once( 'include/otw_editor_dialog.php' );
	die;
}
function otw_sbm_pcm_columns_dialog(){
	require_once( 'include/otw_sbm_pcm_columns_dialog.php' );
	die;
}
function otw_sbm_items_by_type(){
	require_once( 'include/otw_sbm_items_by_type.php' );
	die;
}

/** admin menu actions
  * add the top level menu and register the submenus.
  */ 
function otw_admin_actions(){
	global $otw_sbm_plugin_url;
add_menu_page(__('Sidebars and Widgets', 'otw_sbm'), __('Sidebars and Widgets', 'otw_sbm'), 'manage_options', 'otw-sbm', 'otw_sidebars_list', $otw_sbm_plugin_url.'/images/otw-sbm-icon.png');
add_submenu_page( 'otw-sbm', __('Sidebars', 'otw_sbm'), __('Sidebars', 'otw_sbm'), 'manage_options', 'otw-sbm', 'otw_sidebars_list' );
add_submenu_page( 'otw-sbm', __('Add Sidebar', 'otw_sbm'), __('Add Sidebar', 'otw_sbm'), 'manage_options', 'otw-sbm-add', 'otw_sidebars_manage' );
add_submenu_page( 'otw-sbm', __('Plugin Options', 'otw_sbm'), __('Plugin Options', 'otw_sbm'), 'manage_options', 'otw-sbm-options', 'otw_sidebars_options' );
add_submenu_page( __FILE__, __('Set up widget appearance', 'otw_sbm'), __('Set up widget appearance', 'otw_sbm'), 'manage_options', 'otw-sbm-widget-dialog', 'otw_sidebars_widget_dialog' );
add_submenu_page( __FILE__, __('Manage widget', 'otw_sbm'), __('Manage widget', 'otw_sbm'), 'manage_options', 'otw-sbm-action', 'otw_sidebars_action' );
}

/** include needed javascript scripts based on current page
  *  @param string
  */
function enqueue_otw_scripts( $requested_page ){
	global $otw_sbm_plugin_url;
	switch( $requested_page ){
	
		case 'widgets.php':
				global $otw_plugin_options;
				if( isset( $otw_plugin_options['activate_appearence'] ) && $otw_plugin_options['activate_appearence'] ){
					wp_enqueue_script("otw_widgets", $otw_sbm_plugin_url.'/js/otw_widgets.js' , array( 'jquery', 'jquery-ui-dialog', 'thickbox' ), '3.1' );
					wp_enqueue_script("otw_widget_appearence", $otw_sbm_plugin_url.'/js/otw_widgets_appearence.js' , array( 'jquery' ), '3.1' );
					wp_enqueue_style (  'wp-jquery-ui-dialog' );
				}
			break;
		case 'toplevel_page_otw-sbm':
				if( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ){
					wp_enqueue_script("otw_manage_sidebar", $otw_sbm_plugin_url.'/js/otw_manage_sidebar.js'  , array( 'jquery' ), '3.1' );
				}
			break;
		case 'admin_page_otw-sbm-manage':
		case 'sidebars-and-widgets_page_otw-sbm-add':
				wp_enqueue_script("otw_manage_sidebar", $otw_sbm_plugin_url.'/js/otw_manage_sidebar.js', array( 'jquery' ), '3.1' );
			break;
		case 'admin_page_otw-sbm-widget-dialog':
				wp_enqueue_script("otw_widget_appearence", $otw_sbm_plugin_url.'/js/otw_widgets_appearence.js' , array( 'jquery' ), '3.1' );
			break;
		case 'post.php':
		case 'post-new.php':
		case 'edit.php':
				if( get_post_type() == 'page' ){
					wp_enqueue_script("otw_widget_appearence", $otw_sbm_plugin_url.'/js/otw_sbm_pcm.js' , array( 'jquery' ), '3.1' );
				}
			break;
	}
}
/**
 * include needed styles
 */
function enqueue_otw_styles( $requested_page ){
	global $otw_sbm_plugin_url;
	wp_enqueue_style( 'otw_sidebar', $otw_sbm_plugin_url.'/css/otw_sbm_admin.css', array( 'thickbox' ), '3.1' );
}
/** init otw sidebars
  *
  */
function otw_sidebar_init(){
	
	global $wp_registered_sidebars, $otw_replaced_sidebars, $wp_sbm_int_items, $otw_sbm_plugin_url, $pagenow, $otw_sbm_grid_manager_component, $otw_sbm_shortcode_component, $otw_sbm_form_component, $otw_sbm_grid_manager_object, $otw_sbm_widget_settings, $otw_plugin_options;
	
	otw_sidebar_add_items();
	
	$otw_registered_sidebars = get_option( 'otw_sidebars' );
	$otw_widget_settings = get_option( 'otw_widget_settings' );
	
	if( !is_array( $otw_widget_settings ) ){
		$otw_widget_settings = array();
		update_option( 'otw_widget_settings', $otw_widget_settings );
	}
	
	if( is_array( $otw_registered_sidebars ) && count( $otw_registered_sidebars ) ){
		
		foreach( $otw_registered_sidebars as $otw_sidebar_id => $otw_sidebar ){
			
			$sidebar_params = array();
			$sidebar_params['id']  = $otw_sidebar_id;
			$sidebar_params['name']  = $otw_sidebar['title'];
			$sidebar_params['description']  = $otw_sidebar['description'];
			$sidebar_params['replace']  = $otw_sidebar['replace'];
			$sidebar_params['status']  = $otw_sidebar['status'];
			if( isset( $otw_sidebar['widget_alignment'] ) ){
				$sidebar_params['widget_alignment']  = $otw_sidebar['widget_alignment'];
			}
			$sidebar_params['validfor']  = $otw_sidebar['validfor'];
			
			if( isset( $otw_sidebar['exclude_posts_for'] ) ){
				$sidebar_params['exclude_posts_for']  = $otw_sidebar['exclude_posts_for'];
			}
			
			//collect all replacements for faster search in font end
			if( strlen( $sidebar_params['replace'] ) ){
				
				if( !isset( $otw_replaced_sidebars[ $sidebar_params['replace'] ] ) ){
					$otw_replaced_sidebars[ $sidebar_params['replace'] ] = array();
				}
				$otw_replaced_sidebars[ $sidebar_params['replace'] ][ $sidebar_params['id'] ] = $sidebar_params['id'];
				
				if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ] ) ){
					if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ]['class'] ) ){
						$sidebar_params['class'] = $wp_registered_sidebars[ $sidebar_params['replace'] ]['class'];
					}
					if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ]['before_widget'] ) ){
						$sidebar_params['before_widget'] = $wp_registered_sidebars[ $sidebar_params['replace'] ]['before_widget'];
					}
					if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ]['after_widget'] ) ){
						$sidebar_params['after_widget'] = $wp_registered_sidebars[ $sidebar_params['replace'] ]['after_widget'];
					}
					if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ]['before_title'] ) ){
						$sidebar_params['before_title'] = $wp_registered_sidebars[ $sidebar_params['replace'] ]['before_title'];
					}
					if( isset( $wp_registered_sidebars[ $sidebar_params['replace'] ]['after_title'] ) ){
						$sidebar_params['after_title'] = $wp_registered_sidebars[ $sidebar_params['replace'] ]['after_title'];
					}
				}
				
			}else{
				
				foreach( $otw_sbm_widget_settings as $s_type => $s_data ){
					
					if( isset( $otw_plugin_options[ 'otw_sbm_'.$s_type ] ) ){
						$sidebar_params[ $s_type ] = $otw_plugin_options[ 'otw_sbm_'.$s_type ];
					}else{
						$sidebar_params[ $s_type ] = $s_data[1];
					}
				}
			}
			
			register_sidebar( $sidebar_params );
		}
	}
	
	//apply validfor settings to all sidebars
	if( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) ){
		foreach( $wp_registered_sidebars as $wp_widget_key => $wo_widget_data ){
		
			if( array_key_exists( $wp_widget_key, $otw_widget_settings ) ){
				$wp_registered_sidebars[ $wp_widget_key ]['widgets_settings'] = $otw_widget_settings[ $wp_widget_key ];
			}else{
				$wp_registered_sidebars[ $wp_widget_key ]['widgets_settings'] = array();
			}
		}
	}
	
	$custom_post_types = get_post_types( array(  'public'   => true, '_builtin' => false ), 'object' );
	
	if( is_array( $custom_post_types ) ){
		foreach( $custom_post_types as $c_key => $c_cust ){
			
			if( otw_installed_plugin( 'bbpress' ) && $c_key == 'reply' ){
				//skip reply they appear on same pages as topics
			}else{
				$wp_sbm_int_items[ 'cpt_'. $c_cust->name ] = array( array(), $c_cust->label, __( 'All ', 'otw_sbm' ).$c_cust->labels->name );
			}
		}
	}
	
	$custom_taxonomies = get_taxonomies( array(  'public'   => true, '_builtin' => false ), 'object' );
	
	if( is_array( $custom_taxonomies ) ){
		foreach( $custom_taxonomies as $c_cust ){
			$wp_sbm_int_items[ 'ctx_'. $c_cust->name ] = array( array(), $c_cust->label.' '.__( 'archives', 'otw_sbm' ),__( 'All ', 'otw_sbm' ).$c_cust->label.' '.__('archives', 'otw_sbm' ) );
			foreach( $c_cust->object_type as $c_object ){
				
				if( $c_object_info = get_post_type_object( $c_object ) ){
					$wp_sbm_int_items[ $c_object.'_in_ctx_'. $c_cust->name ] = array( array(), __( 'All', 'otw_sbm' ).' '.$c_object_info->labels->name.' '.__( 'from taxonomy', 'otw_sbm' ).' '.$c_cust->label, __( 'All', 'otw_sbm' ).' '.$c_object_info->labels->name.' '.__( 'from taxonomy', 'otw_sbm' ).' '.$c_cust->label );
				}
			}
			
		}
	}
	//otw grid manager component
	$otw_sbm_grid_manager_component = otw_load_component( 'otw_grid_manager' );
	$otw_sbm_grid_manager_object = otw_get_component( $otw_sbm_grid_manager_component );
	
	if( isset( $otw_plugin_options['otw_gm_metabox_for'] ) )
	{
		$otw_sbm_grid_manager_object->show_metabox_for = $otw_plugin_options['otw_gm_metabox_for'];
	}
	
	include_once( plugin_dir_path( __FILE__ ).'include/otw_labels/otw_sbm_grid_manager_object.labels.php' );
	$otw_sbm_grid_manager_object->init();
	
	//shortcode component
	$otw_sbm_shortcode_component = otw_load_component( 'otw_shortcode' );
	$otw_sbm_shortcode_object = otw_get_component( $otw_sbm_shortcode_component );
	$otw_sbm_shortcode_object->shortcodes['sidebars'] = array( 'title' => __('Sidebars', 'otw_sbm'),'enabled' => true,'children' => false,'order' => 132,'parent' => false, 'path' => dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', 'url' => $otw_sbm_plugin_url.'/include/otw_components/otw_shortcode/' );
	$otw_sbm_shortcode_object->shortcodes['sidebar'] = array( 'title' => __('OTW Sidebar', 'otw_sbm'),'enabled' => false,'children' => false,'order' => 100000, 'path' => dirname( __FILE__ ).'/include/otw_components/otw_shortcode/', 'url' => $otw_sbm_plugin_url.'/include/otw_components/otw_shortcode/' );
	
	include_once( plugin_dir_path( __FILE__ ).'include/otw_labels/otw_sbm_shortcode_object.labels.php' );
	$otw_sbm_shortcode_object->init();
	
	//form component
	$otw_sbm_form_component = otw_load_component( 'otw_form' );
	$otw_sbm_form_object = otw_get_component( $otw_sbm_form_component );
	include_once( plugin_dir_path( __FILE__ ).'include/otw_labels/otw_sbm_form_object.labels.php' );
	$otw_sbm_form_object->init();
	
	$otw_sbm_content_sidebars_component = otw_load_component( 'otw_content_sidebars' );
	$otw_sbm_content_sidebars_object = otw_get_component( $otw_sbm_content_sidebars_component );
	$otw_sbm_content_sidebars_object->meta_name  = 'otw_content_sidebars_settings';
	
	if( isset( $otw_plugin_options['otw_cs_metabox_for'] ) )
	{
		$otw_sbm_content_sidebars_object->show_metabox_for = $otw_plugin_options['otw_cs_metabox_for'];
	}
	include_once( plugin_dir_path( __FILE__ ).'include/otw_labels/otw_sbm_content_sidebars_object.labels.php' );
	$otw_sbm_content_sidebars_object->init();
	
	if( is_admin() ){
		
		require_once( plugin_dir_path( __FILE__ ).'/include/otw_process_actions.php' );
		
		/*
		if( get_user_option('rich_editing') ){
			
			add_filter('mce_external_plugins', 'add_otw_tinymce_plugin');
			add_filter('mce_buttons', 'register_otw_tinymce_button');
		}*/
		add_action('add_meta_boxes', 'otw_sbm_meta_boxes');
		add_action('save_post','otw_sbm_pcm_save');
	}else{
	
		wp_register_style('otw_sbm.css', $otw_sbm_plugin_url.'/css/otw_sbm.css' );
		wp_enqueue_style('otw_sbm.css');
		add_filter('the_content','otw_sbm_pcm_show');
	}
}
$otw_replaced_sidebars = array();


/** 
 *call init plugin function
 */
add_action('init', 'otw_sidebar_init', 10000 );
/**
 * register admin menu 
 */
add_action('admin_menu', 'otw_admin_actions');
add_action('admin_notices', 'otw_sbm_admin_notice');
add_filter('sidebars_widgets', 'otw_sidebars_widgets', 100000);

/**
 * include plugin js and css
 */
add_action('admin_enqueue_scripts', 'enqueue_otw_scripts');
add_action('admin_print_styles', 'enqueue_otw_styles' );
add_shortcode('otw_is', 'otw_call_sidebar');
add_shortcode( 'sbm_column', 'otw_sbm_shortcode_column' );
//register some admin actions
if( is_admin() ){
	add_action( 'wp_ajax_otw_widget_dialog', 'otw_sidebars_ajax_widget_dialog' );
	add_action( 'wp_ajax_otw_editor_dialog', 'otw_editor_dialog' );
	add_action( 'wp_ajax_otw_sbm_pcm_columns', 'otw_sbm_pcm_columns_dialog' );
	add_action( 'wp_ajax_otw_sbm_items_by_type', 'otw_sbm_items_by_type' );
}
register_activation_hook(  __FILE__,'otw_sbm_plugin_activate');
?>
