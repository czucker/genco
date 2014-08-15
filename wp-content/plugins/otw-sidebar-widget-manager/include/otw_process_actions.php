<?php
/**
 * Process otw actions
 *
 */
if( isset( $_POST['otw_action'] ) ){
	
	require_once( ABSPATH . WPINC . '/pluggable.php' );
	
	switch( $_POST['otw_action'] ){
		
		case 'activate_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'active';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-sbm&message=3' );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'deactivate_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'inactive';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-sbm&message=4' );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'delete_otw_sidebar':
				if( isset( $_POST['cancel'] ) ){
					wp_redirect( 'admin.php?page=otw-sbm' );
				}else{
					
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						
						$new_sidebars = array();
						
						//remove the sidebar from otw_sidebars
						foreach( $otw_sidebars as $sidebar_key => $sidebar ){
						
							if( $sidebar_key != $otw_sidebar_id ){
							
								$new_sidebars[ $sidebar_key ] = $sidebar;
							}
						}
						update_option( 'otw_sidebars', $new_sidebars );
						
						//remove sidebar from widget
						$widgets = get_option( 'sidebars_widgets' );
						
						if( isset( $widgets[ $otw_sidebar_id ] ) ){
							
							$new_widgets = array();
							foreach( $widgets as $sidebar_key => $widget ){
								if( $sidebar_key != $otw_sidebar_id ){
								
									$new_widgets[ $sidebar_key ] = $widget;
								}
							}
							update_option( 'sidebars_widgets', $new_widgets );
						}
						
						wp_redirect( admin_url( 'admin.php?page=otw-sbm&message=2' ) );
					}else{
						wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
					}
				}
			break;
		case 'manage_otw_options':
				
				global $wp_sbm_int_items, $wp_sbm_tmc_items, $otw_sbm_widget_settings, $wp_sbm_gm_items, $wp_sbm_cs_items;
				
				$options = array();
				
				if( isset( $_POST['sbm_activate_appearence'] ) && strlen( trim( $_POST['sbm_activate_appearence'] ) ) ){
					$options['activate_appearence'] = true;
				}else{
					$options['activate_appearence'] = false;
				}
				
				if( isset( $_POST['sbm_activate_old_grid'] ) && strlen( trim( $_POST['sbm_activate_old_grid'] ) ) ){
					$options['activate_old_grid'] = true;
				}else{
					$options['activate_old_grid'] = false;
				}
				
				if( isset( $_POST['otw_sbm_items_limit'] ) && strlen( trim( $_POST['otw_sbm_items_limit'] ) ) && intval( $_POST['otw_sbm_items_limit'] ) ){
					$options['otw_sbm_items_limit'] = intval( $_POST['otw_sbm_items_limit'] );
				}else{
					$options['otw_sbm_items_limit'] = 20;
				}
				
				$options['shortcode_editor_button_for'] = array();
				foreach( $wp_sbm_tmc_items as $wp_item_type => $wpItem ){
					if( isset( $_POST['otw_sbm_editor_shortcodes'] ) && is_array( $_POST['otw_sbm_editor_shortcodes'] ) && isset( $_POST['otw_sbm_editor_shortcodes'][ $wp_item_type ] ) ){
						$options['shortcode_editor_button_for'][ $wp_item_type ] = $_POST['otw_sbm_editor_shortcodes'][ $wp_item_type ];
					}else{
						$options['shortcode_editor_button_for'][ $wp_item_type ] = 0;
					}
				}
				
				$options['otw_gm_metabox_for'] = array();
				foreach( $wp_sbm_gm_items as $wp_item_type => $wpItem ){
					if( isset( $_POST['otw_gm_metabox_for'] ) && is_array( $_POST['otw_gm_metabox_for'] ) && isset( $_POST['otw_gm_metabox_for'][ $wp_item_type ] ) ){
						$options['otw_gm_metabox_for'][ $wp_item_type ] = $_POST['otw_gm_metabox_for'][ $wp_item_type ];
					}else{
						$options['otw_gm_metabox_for'][ $wp_item_type ] = 0;
					}
				}
				$options['otw_cs_metabox_for'] = array();
				foreach( $wp_sbm_cs_items as $wp_item_type => $wpItem ){
					if( isset( $_POST['otw_cs_metabox_for'] ) && is_array( $_POST['otw_cs_metabox_for'] ) && isset( $_POST['otw_cs_metabox_for'][ $wp_item_type ] ) ){
						$options['otw_cs_metabox_for'][ $wp_item_type ] = $_POST['otw_cs_metabox_for'][ $wp_item_type ];
					}else{
						$options['otw_cs_metabox_for'][ $wp_item_type ] = 0;
					}
				}
				
				foreach( $otw_sbm_widget_settings as $s_type => $s_data ){
					
					if( isset( $_POST['otw_sbm_'.$s_type] ) ){
						$options[ 'otw_sbm_'.$s_type ] = stripslashes( $_POST['otw_sbm_'.$s_type] );
					}
				}
				
				update_option( 'otw_plugin_options', $options );
				wp_redirect( admin_url( 'admin.php?page=otw-sbm-options&message=1' ) );
			break;
		case 'manage_otw_sidebar':
				global $validate_messages, $wp_sbm_int_items, $wpdb;
				
				$validate_messages = array();
				$valid_page = true;
				if( !isset( $_POST['sbm_title'] ) || !strlen( trim( $_POST['sbm_title'] ) ) ){
					$valid_page = false;
					$validate_messages[] = __( 'Please type valid sidebar title', 'otw_sbm' );
				}
				if( !isset( $_POST['sbm_status'] ) || !strlen( trim( $_POST['sbm_status'] ) ) ){
					$valid_page = false;
					$validate_messages[] = __( 'Please select status', 'otw_sbm' );
				}
				if( $valid_page ){
					
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( !is_array( $otw_sidebars ) ){
						$otw_sidebars = array();
					}
					$items_to_remove = array();
					if( isset( $_GET['sidebar'] ) && isset( $otw_sidebars[ $_GET['sidebar'] ] ) ){
						$otw_sidebar_id = $_GET['sidebar'];
						$sidebar = $otw_sidebars[ $_GET['sidebar'] ];
					}else{
						$sidebar = array();
						$otw_sidebar_id = false;
					}
					
					$sidebar['title'] = (string) $_POST['sbm_title'];
					$sidebar['description'] = (string) $_POST['sbm_description'];
					$sidebar['replace'] = (string) $_POST['sbm_replace'];
					$sidebar['status'] = (string) $_POST['sbm_status'];
					$sidebar['widget_alignment'] = (string) $_POST['sbm_widget_alignment'];
					
					//save selected items
					$otw_sbi_items = array_keys( $wp_sbm_int_items );
					
					$widgets = get_option( 'sidebars_widgets' );
					
					foreach( $otw_sbi_items as $otw_sbi_item ){
						
						
						if( isset( $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] ) && strlen( trim( $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] ) ) ){
							
							$sidebar['validfor'][ $otw_sbi_item ] = array();
							
							$posted_items = explode( ',', $_POST['otw_smb_'.$otw_sbi_item.'_validfor'] );
							
							foreach( $posted_items as $item_id ){
								$sidebar['validfor'][ $otw_sbi_item ][ $item_id ] = array();
								$sidebar['validfor'][ $otw_sbi_item ][ $item_id ]['id'] = $item_id;
								
								if( isset( $_POST['otw_exclude_sub_object_'.$otw_sbi_item.'_'.$item_id ] ) && strlen( trim( $_POST['otw_exclude_sub_object_'.$otw_sbi_item.'_'.$item_id ] ) ) ){
									$sidebar['validfor'][ $otw_sbi_item ][ $item_id ]['exclude_post'] = $_POST['otw_exclude_sub_object_'.$otw_sbi_item.'_'.$item_id ];
								}
							}
							
						}else{
							$sidebar['validfor'][ $otw_sbi_item ] = array();
						}
						//global selection
						if( isset( $_POST['otw_all_selection_'.$otw_sbi_item] ) && ( $_POST['otw_all_selection_'.$otw_sbi_item] == 1 ) ){
							
							if( !isset( $sidebar['validfor'] ) ){
								$sidebar['validfor'] = array();
							}
							if( !isset( $sidebar['validfor'][ $otw_sbi_item ] ) ){
								$sidebar['validfor'][ $otw_sbi_item ] = array();
							}
							
							$sidebar['validfor'][ $otw_sbi_item ]['all'] = array();
							$sidebar['validfor'][ $otw_sbi_item ]['all']['id'] = 'all';
							$sidebar['validfor'][ $otw_sbi_item ]['all']['type'] = 'global';
							$sidebar['validfor'][ $otw_sbi_item ]['all']['exclude'] = '';
							
							/*
							if( isset( $_POST['otw_exclude_items_'.$otw_sbi_item] ) ){
								$sidebar['validfor'][ $otw_sbi_item ]['all']['exclude'] = $_POST['otw_exclude_items_'.$otw_sbi_item];
							}*/
						}
						//save excluded posts for some types
						if( isset( $_POST['otw_exclude_posts_'.$otw_sbi_item] ) && strlen( $_POST['otw_exclude_posts_'.$otw_sbi_item] ) ){
							if( !isset( $sidebar['exclude_posts_for'] ) ){
								$sidebar['exclude_posts_for'] = array();
							}
							$sidebar['exclude_posts_for'][ $otw_sbi_item ] = $_POST['otw_exclude_posts_'.$otw_sbi_item];
						}elseif( isset( $sidebar['exclude_posts_for'] ) && isset( $sidebar['exclude_posts_for'][ $otw_sbi_item ] ) ){
							unset( $sidebar['exclude_posts_for'][ $otw_sbi_item ] );
						}
					}
					
					if( $otw_sidebar_id === false ){
						
						$otw_sidebar_id = 'otw-sidebar-'.( get_next_otw_sidebar_id() );
						$sidebar['id'] = $otw_sidebar_id;
					}
					
					$otw_sidebars[ $otw_sidebar_id ] = $sidebar;
					
					if( !update_option( 'otw_sidebars', $otw_sidebars ) && $wpdb->last_error ){
						
						$valid_page = false;
						$validate_messages[] = __( 'DB Error: ', 'otw_sbm' ).$wpdb->last_error.'. Tring to save '.strlen( maybe_serialize( $otw_sidebars ) ).' bytes.';
					}else{
						wp_redirect( 'admin.php?page=otw-sbm&message=1' );
					}
				}
			break;
	}
}
function get_next_otw_sidebar_id(){

	$next_id = 0;
	$existing_sidebars = get_option( 'otw_sidebars' );
	
	if( is_array( $existing_sidebars ) && count( $existing_sidebars ) ){
	
		foreach( $existing_sidebars as $key => $s_data ){
			
			if( preg_match( "/^otw\-sidebar\-([0-9]+)$/", $key, $matches ) ){
			
				if( $matches[1] > $next_id ){
					$next_id = $matches[1];
				}
			}
		}
	}
	return $next_id + 1;
}
?>