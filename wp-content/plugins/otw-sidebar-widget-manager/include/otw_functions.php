<?php
/** list of functions used by otw sidebar
  *
  */

require_once( plugin_dir_path( __FILE__ ).'otw_sbm_core.php' );

/**
 * add tinymce plugin
 */
function add_otw_tinymce_plugin($plugin_array){
	global $otw_sbm_plugin_url;
	
	if( otw_register_tinymce_button_plugin() ){
		$plugin_array['otwsbm'] = $otw_sbm_plugin_url.'/js/otw_editor_plugin.js';
	}
	return $plugin_array;
}
/**
 * register button plugin
 */
function register_otw_tinymce_button($buttons){
	if( otw_register_tinymce_button_plugin() ){
		array_push($buttons, "separator", "otwsbm");
	}
	return $buttons;
}

/**
 *
 */
function otw_register_tinymce_button_plugin(){
	global $otw_plugin_options;
	
	if( !isset( $otw_plugin_options['shortcode_editor_button_for'] ) ){
		return true;
	}
	$check_for = array();
	$current_page = get_current_screen();
	
	if( isset( $current_page->base ) && ( $current_page->base == 'post' ) && isset( $current_page->post_type ) ){
		
		switch( $current_page->post_type ){
		
			case 'post':
			case 'page':
					$check_for[] = $current_page->post_type;
				break;
			default:
					$check_for[] = 'cpt';
				break;
		}
	}
	
	if( count( $check_for ) ){
		
		foreach( $check_for as $type ){
			if( isset( $otw_plugin_options['shortcode_editor_button_for'][ $type ] ) && $otw_plugin_options['shortcode_editor_button_for'][ $type ] ){
				return true;
			}
		}
	}
	return false;
}

/** admin notices
 * 
 */
function otw_sbm_admin_notice(){
	$plugin_error = get_option( 'otw_sbm_plugin_error' );
	
	if( $plugin_error ){
		echo '<div class="error"><p>';
		echo 'Select Sidebar & Widget Manager Plugin Error: '.$plugin_error;
		echo '</p></div>';
	}
}

/** set item row attributes
 *
 *  @param string $node_tag
 *  @param string $wp_item_type
 *  @param string $sidebar
 *  @param string $widget
 *  @param array $wpItem
 *  @return string
 *
 */
if (!function_exists( "otw_sidebar_item_row_attributes" )){
	function otw_sidebar_item_row_attributes( $node_tag, $wp_item_type, $sidebar, $widget, $wpItem ){
		
		global $wp_registered_sidebars;
		
		$attributes = array();
		
		switch( $node_tag )
		{
			case 'p':
					$attributes['class'] = array();
					if( isset( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ]['_otw_wc'][ $widget ] ) && in_array( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ]['_otw_wc'][ $widget ], array( 'vis', 'invis' ) ) ){
						if( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ]['_otw_wc'][ $widget ] == 'invis' ){
							$attributes['class'][] = 'sitem_notselected';
						}else{
							$attributes['class'][] = 'sitem_selected';
						}
					}
					elseif( isset( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ][ otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ]['exclude_widgets'][ $widget ] ) ){
						$attributes['class'][] = 'sitem_notselected';
					}else{
						$attributes['class'][] = 'sitem_selected';
					}
				break;
			case 'a':
					$attributes['class'] = array();
					$attributes['class'][] = $sidebar.'|'.$widget.'|'.$wp_item_type.'|'.otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem );
					switch( $wp_item_type ){
						case 'page':
						case 'category':
						case 'postsincategory':
								if( isset( $wpItem->_sub_level ) && $wpItem->_sub_level ){
									$attributes['style'][] = 'margin-left: '.( $wpItem->_sub_level * 20  ).'px';
								}
							break;
					}
				break;
		}
		
		$html = '';
		foreach( $attributes as $attribute => $att_values ){
			$html .= ' '.$attribute.'="'.implode( ' ', $att_values ).'"';
		}
		
		echo $html;
	}
}


/** set html ot each item row
  *  @param string 
  *  @param string 
  *  @param string
  *  @param array
  *  @return void
  */
if (!function_exists( "otw_sidebar_item_attributes" )){
	function otw_sidebar_item_attributes( $tag, $item_type, $item_id, $sidebar_data, $item_data ){
		
		$attributes = '';
		
		switch( $tag ){
			case 'p':
					$attributes_array = array();
					if( isset( $_POST['otw_action'] ) ){
						if( isset( $_POST[ 'otw_sbi_'.$item_type ][ $item_id ] ) || isset( $_POST[ 'otw_sbi_'.$item_type ][ 'all' ] ) ){
							$attributes_array['class'][] = 'sitem_selected';
						}else{
							$attributes_array['class'][] = 'sitem_notselected';
						}
					}else{
						if( isset( $sidebar_data['sbm_validfor'][ $item_type ]['all'] ) ){
							$attributes_array['class'][] = 'sitem_selected';
						}elseif( isset( $sidebar_data['sbm_validfor'][ $item_type ][ $item_id ] ) ){
							$attributes_array['class'][] = 'sitem_selected';
						}else{
							$attributes_array['class'][] = 'sitem_notselected';
						}
					}
					if( isset( $attributes_array['class'] ) ){
						$attributes .= ' class="'.implode( ' ', $attributes_array['class'] ).'"';
					}
				break;
			case 'c':
					if( isset( $_POST['otw_action'] ) ){
						if( isset( $_POST[ 'otw_sbi_'.$item_type ][ $item_id ] )  || isset( $_POST[ 'otw_sbi_'.$item_type ][ 'all' ] ) ){
							$attributes .= ' checked="checked"';
						}
					}else{
						if( isset( $sidebar_data['sbm_validfor'][ $item_type ]['all'] ) ){
							$attributes .= ' checked="checked"';
						}elseif( isset( $sidebar_data['sbm_validfor'][ $item_type ][ $item_id ] ) ){
							$attributes .= ' checked="checked"';
						}
					}
				break;
			case 'ap':
					if( isset( $_POST['otw_action'] ) ){
						if( isset( $_POST[ 'otw_sbi_'.$item_type ][ $item_id ] ) ){
							$attributes .= ' class="all sitem_selected"';
						}else{
							$attributes .= ' class="all sitem_notselected"';
						}
					}else{
						if( isset( $sidebar_data['sbm_validfor'][ $item_type ][ $item_id ] ) ){
							$attributes .= ' class="all sitem_selected"';
						}else{
							$attributes .= ' class="all sitem_notselected"';
						}
					}
				break;
			case 'ac':
					if( isset( $_POST['otw_action'] ) ){
						if( isset( $_POST[ 'otw_sbi_'.$item_type ][ $item_id ] ) ){
							$attributes .= ' checked="checked"';
						}
					}else{
						if( isset( $sidebar_data['sbm_validfor'][ $item_type ][ $item_id ] ) ){
							$attributes .= ' checked="checked"';
						}
					}
				break;
			case 'l':
					if( isset( $item_data->_sub_level ) && $item_data->_sub_level ){
						$attributes .= ' style="margin-left: '.( $item_data->_sub_level * 20 ).'px"';
					}
				break;
		}
		echo $attributes;
	}
}

function otw_sbm_plugin_activate(){
	
	$options = get_option( 'otw_plugin_options' );
	
	$options['activate_appearence'] = true;
	update_option( 'otw_plugin_options', $options );
}

/**
 * Add more items based on installed plugins etc.
 */
function otw_sidebar_add_items(){
	
	global $wp_sbm_int_items;
	
	//wpml
	$active_plugins = get_option( 'active_plugins' );
	
	if( otw_installed_plugin( 'wpml' ) ){
		$wp_sbm_int_items['wpmllanguages'] = array();
		$wp_sbm_int_items['wpmllanguages'][0] = array();
		$wp_sbm_int_items['wpmllanguages'][1] = __( 'WPML plugin language', 'otw_sbm' );
		$wp_sbm_int_items['wpmllanguages'][2] = __( 'All WPML plugin languages', 'otw_sbm' );
	}
	if( otw_installed_plugin( 'bbpress' ) ){
		$wp_sbm_int_items['bbp_page'] = array();
		$wp_sbm_int_items['bbp_page'][0] = array();
		$wp_sbm_int_items['bbp_page'][1] = __( 'bbPress pages', 'otw_sbm' );
		$wp_sbm_int_items['bbp_page'][2] = __( 'All bbPress pages', 'otw_sbm' );
	}
	if( otw_installed_plugin( 'buddypress' ) ){
		$wp_sbm_int_items['buddypress_page'] = array();
		$wp_sbm_int_items['buddypress_page'][0] = array();
		$wp_sbm_int_items['buddypress_page'][1] = __( 'BuddyPress pages', 'otw_sbm' );
		$wp_sbm_int_items['buddypress_page'][2] = __( 'All BuddyPress pages', 'otw_sbm' );
	}
}
?>