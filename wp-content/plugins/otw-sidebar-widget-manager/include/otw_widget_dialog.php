<?php
/** OTW widget appearence dialog
  *
  */
$sidebar = '';
$widget = '';

if( isset( $_GET['sidebar'] ) ){
	$sidebar = $_GET['sidebar'];
}
if( isset( $_GET['widget'] ) ){
	$widget = $_GET['widget'];
}

global $wp_registered_sidebars, $wp_sbm_int_items, $otw_sbm_plugin_url;

$with_exclude_items = array( 'postsincategory', 'postsintag', 'post_in_ctx' );

//validat input data
if( !$sidebar ){
	wp_die( '<div>'.__( 'Invalid sidebar', 'otw_sbm' ).'</div>' );
}

//validat input data
if( !$sidebar || !$widget ){
	wp_die( '<div>'.__( 'Invalid sidebar or widget', 'otw_sbm' ).'</div>' );
}


//validate that this sidebar exists
if( !isset( $wp_registered_sidebars[ $sidebar ] ) ){
	wp_die( '<div>'.__( 'Requested not registered sidebar '.$sidebar.'|'.$widget, 'otw_sbm' ).'</div>' );
}

$otw_sidebars = get_option( 'otw_sidebars' );

if( !is_array( $otw_sidebars ) ){
	$otw_sidebars = array();
}

$sidebar_widgets = get_option('sidebars_widgets');

//check if widget is part of this sidebar
if( !isset( $sidebar_widgets[ $sidebar ] ) || !count( $sidebar_widgets[ $sidebar ] ) || !in_array( $widget, $sidebar_widgets[ $sidebar ]  ) ){
	wp_die( '<div>'.__( 'Requested widget is not assinged to this sidebar '.$sidebar.'|'.$widget, 'otw_sbm' ).'</div>' );
}

if( isset( $_POST['otw_action'] ) && in_array( $_POST['otw_action'], array( 'exclude_posts' ) ) ){

	$response = 0;
	
	$otw_widget_settings = get_option( 'otw_widget_settings' );
	
	if( !isset( $otw_widget_settings[ $sidebar ] ) ){
		$otw_widget_settings[ $sidebar ] = array();
	}
	
	$value = '';
	
	if( isset( $_POST['posts'] ) ){
		$value = trim( $_POST['posts'] );
	}
	
	if( isset( $_POST['item_type'] ) && strlen( $_POST['item_type'] ) ){
	
		$item_type = $_POST['item_type'];
		
		if( !isset( $otw_widget_settings[ $sidebar ][ $item_type ] ) ){
			$otw_widget_settings[ $sidebar ][ $item_type ] = array();
		}
		
		if( !isset( $otw_widget_settings[ $sidebar ][ $item_type ]['_otw_ep'] ) || !is_array( $otw_widget_settings[ $sidebar ][ $item_type ]['_otw_ep'] ) ){
			$otw_widget_settings[ $sidebar ][ $item_type ]['_otw_ep'] = array();
		}
		$otw_widget_settings[ $sidebar ][ $item_type ]['_otw_ep'][ $widget ] = $value;
		
		$response = 1;
		
	}
	update_option( 'otw_widget_settings', $otw_widget_settings );
	
	echo $response;
	
	return;
	
}
if( isset( $_POST['otw_action'] ) && in_array( $_POST['otw_action'], array( 'glvis', 'glinvis' ) ) ){
	
	$response = '';
	$otw_widget_settings = get_option( 'otw_widget_settings' );
	
	if( !isset( $otw_widget_settings[ $sidebar ] ) ){
		$otw_widget_settings[ $sidebar ] = array();
	}
	
	$otw_action = '';
	
	switch( $_POST['otw_action'] ){
		case 'glvis':
				$otw_action = 'vis';
			break;
		case 'glinvis':
				$otw_action = 'invis';
			break;
	}
	$response = $otw_action;
	
	$valid_objects = array();
	
	if( array_key_exists( $sidebar, $otw_sidebars ) ){
			
		if( isset( $otw_sidebars[ $sidebar ]['validfor'] ) ){
				
			$valid_objects = array_keys( $otw_sidebars[ $sidebar ]['validfor'] );
		}
	}else{
		$valid_objects = array_keys( $wp_sbm_int_items );
	}
	
	if( is_array( $valid_objects ) && count( $valid_objects ) ){
		
		foreach( $valid_objects as $item_type ){
		
			if( $item_type != 'userroles' ){
				
				if( !isset( $otw_widget_settings[ $sidebar ][ $item_type ]['_otw_wc'] ) || !is_array( $otw_widget_settings[ $sidebar ][ $item_type ]['_otw_wc'] ) ){
					$otw_widget_settings[ $sidebar ][ $item_type ]['_otw_wc'] = array();
				}
				
				foreach( $sidebar_widgets[ $sidebar ] as $widget_type ){
					
					if( $widget_type == $widget ){
						$otw_widget_settings[ $sidebar ][ $item_type ]['_otw_wc'][ $widget_type ] = $otw_action;
					}
				}
			}
		}
	}
	
	update_option( 'otw_widget_settings', $otw_widget_settings );
		
	echo $response;
	
	return;
	
}elseif( isset( $_POST['otw_action'] ) && in_array( $_POST['otw_action'], array( 'vis', 'invis' ) ) ){

	if( isset( $_POST['item_type'] ) ){
		
		$response = '';
		$otw_widget_settings = get_option( 'otw_widget_settings' );
		
		if( !isset( $otw_widget_settings[ $sidebar ] ) ){
			$otw_widget_settings[ $sidebar ] = array();
		}
		
		if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ] ) ){
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ] = array();
		}
		
		$current_wc = '';
		if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'] ) || !is_array( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'] ) ){
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'] = array();
		}
		
		if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] ) ){
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] = '';
		}else{
			$current_wc = $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ];
		}
		
		if( $current_wc == $_POST['otw_action'] ){
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] = '';
			$response = 'none';
		}else{
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] = $_POST['otw_action'];
			$response  = $_POST['otw_action'];
		}
		
		update_option( 'otw_widget_settings', $otw_widget_settings );
		
		echo $response;
		
		return;
	}
	
}
if( isset( $_POST['otw_action'] ) && ( $_POST['otw_action'] == 'update' ) ){
	
	if( isset( $_POST['item_type'] ) && isset( $_POST['item_id'] ) ){
	
		$otw_widget_settings = get_option( 'otw_widget_settings' );
		
		if( !isset( $otw_widget_settings[ $sidebar ] ) ){
			$otw_widget_settings[ $sidebar ] = array();
		}
		
		//create item selection if not create but all used
		if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ] ) ){
			
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ] = array();
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['id'] = $_POST['item_id'];
			$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'] = array();
			
		}
		
		//process action to excluded widgets
		if( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][$widget] ) && in_array( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ],array( 'vis', 'invis' ) ) ){
		
			if( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] == 'invis' ){
				
				
				if( is_array( $otw_sidebars ) && array_key_exists( $sidebar, $otw_sidebars ) ){
					
					if( isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $_POST['item_type'] ] ) ){
						
						foreach( $wp_registered_sidebars[ $sidebar ]['validfor'][ $_POST['item_type'] ] as $wp_sb_item_id => $wp_sb_item_data ){
							
							if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ] ) ){
								
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ] = array();
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['id'] = $wp_sb_item_id;
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'] = array();
							}
							$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] = $widget;
						}
					}
				}else{
					$wp_all_items = otw_get_wp_items( $_POST['item_type'] );
					
					if( is_array( $wp_all_items ) && count( $wp_all_items ) ){
						
						foreach( $wp_all_items as $wp_all_item ){
							
							$wp_sb_item_id = otw_wp_item_attribute( $_POST['item_type'], 'ID', $wp_all_item );
							if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ] ) ){
								
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ] = array();
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['id'] = $wp_sb_item_id;
								$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'] = array();
							}
							$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] = $widget;
						}
					}
				}
				
				if( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] ) ){
					unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] );
					echo 'sitem_selected_from_invis';
				}else{
					echo 'sitem_selected_from_invis';
				}
				unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] );
				
			}elseif( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] == 'vis' ){
				
				
				if( is_array( $otw_sidebars ) && array_key_exists( $sidebar, $otw_sidebars ) ){
					
					if( isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $_POST['item_type'] ] ) ){
						
						foreach( $wp_registered_sidebars[ $sidebar ]['validfor'][ $_POST['item_type'] ] as $wp_sb_item_id => $wp_sb_item_data ){
							
							if( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] ) ){
								unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] );
							}
						}
					}
				}else{
					$wp_all_items = otw_get_wp_items( $_POST['item_type'] );
					
					if( is_array( $wp_all_items ) && count( $wp_all_items ) ){
						
						foreach( $wp_all_items as $wp_all_item ){
							
							$wp_sb_item_id = otw_wp_item_attribute( $_POST['item_type'], 'ID', $wp_all_item );
							if( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] ) ){
								unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $wp_sb_item_id ]['exclude_widgets'][ $widget ] );
							}
						}
					}
				}
				
				if( !isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] ) ){
					$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] = $widget;
					echo 'sitem_selected_from_vis';
				}else{
					echo 'sitem_selected_from_vis';
				}
				
				unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ]['_otw_wc'][ $widget ] );
				
			}
			
		}elseif( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ] ) ){
			if( isset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] ) ){
				unset( $otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ] );
				echo 'sitem_selected';
			}else{
				$otw_widget_settings[ $sidebar ][ $_POST['item_type'] ][ $_POST['item_id'] ]['exclude_widgets'][ $widget ]  = $widget;
				echo 'sitem_notselected';
			}
			
		}
		
		update_option( 'otw_widget_settings', $otw_widget_settings );
	}
	return;
}
$otw_widget_settings = get_option( 'otw_widget_settings' );

/** set class name for all selection links
 *
 *  @param string $type vis|invis
 *  @param string $sidebar
 *  @param string $widget
 *  @param string $wp_item_type
 *  @return string
 */
function otw_sidebar_item_all_class( $type, $sidebar, $widget, $wp_item_type ){

	global $wp_registered_sidebars;
	$class = '';
	
	if( isset( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ]['_otw_wc'][ $widget ] ) ){
	
		if( $wp_registered_sidebars[ $sidebar ]['widgets_settings'][ $wp_item_type ]['_otw_wc'][ $widget ] == $type ){
			$class .= ' all_selected';
		}
	}
	
	echo $class;
}


foreach( $wp_sbm_int_items as $wp_item_type => $wp_item_data ){
	
	if( is_array( $otw_sidebars ) && array_key_exists( $sidebar, $otw_sidebars ) ){
		if( !$wp_registered_sidebars[ $sidebar ]['replace'] ){
			$wp_sbm_int_items[ $wp_item_type ][0] = array( 1 );
		}elseif( isset( $wp_registered_sidebars[ $sidebar ]['validfor'][ $wp_item_type ] )  && count( $wp_registered_sidebars[ $sidebar ]['validfor'][ $wp_item_type ] )){
			$wp_sbm_int_items[ $wp_item_type ][0] = array( 1 );
		}else{
			$wp_sbm_int_items[ $wp_item_type ][0] = array();
		}
	}else{
		$wp_sbm_int_items[ $wp_item_type ][0] = array( 1 );//otw_get_wp_items( $wp_item_type );
	}
}
?>
<div class="otw_wv_dialog_content" id="otw_dialog_content">

<div class="d_info">
	<div class="updated visupdated">
		<p><?php _e( 'A selected page template includes all pages using that template.', 'otw_sbm' )?><br />
		<?php _e( 'Template hierarchy Page includes all pages.', 'otw_sbm' )?></p>
	</div>
</div>
<?php if( is_array( $wp_sbm_int_items ) && count( $wp_sbm_int_items ) ){?>
	<div class="otw_sbm_global_settings">
		<a href="javascript:;" class="otw_all_global_vis" rel="<?php echo $sidebar?>|<?php echo $widget?>|glvis"><?php _e( 'Visible everywhere', 'otw_sbm' )?></a>
		|
		<a href="javascript:;" class="otw_all_global_invis" rel="<?php echo $sidebar?>|<?php echo $widget?>|glinvis"><?php _e( 'Invisible everywhere', 'otw_sbm' )?></a>
		<br /><i><?php _e( 'This will not affect the "User roles/Logged in as" tab settings.', 'otw_sbm' ) ?></i>
	</div>
	<?php foreach( $wp_sbm_int_items as $wp_item_type => $wp_item_data ){?>
		
		<?php if( is_array( $wp_item_data[0] ) && count( $wp_item_data[0] ) ){?>
			<div class="meta-box-sortables metabox-holder">
				<div class="postbox">
					<div title="<?php _e('Click to toggle', 'otw_sbm')?>" class="handlediv sitem_toggle"><br></div>
					<h3 class="hndle sitem_header" title="<?php _e('Click to toggle', 'otw_sbm')?>"><span><?php echo $wp_item_data[1]?></span></h3>
					
					<div class="inside sitems<?php if( count( $wp_item_data[0] ) > 15 ){ echo ' mto';}?>" id="otw_sbm_app_type_<?php echo $wp_item_type?>" rel="<?php echo $sidebar?>|<?php echo $widget?>|<?php echo $wp_item_type?>" >
						<div class="otw_sidebar_wv_item_filter">
							<div id="otw_type_page_wv_search" class="otw_sidebar_wv_filter_search">
								<label for="otw_type_<?php echo $wp_item_type ?>_search_field"><?php _e( 'Search', 'otw_sbm' )?></label>
								<input type="text" id="otw_type_<?php echo $wp_item_type ?>_search_field" class="otw_sbm_wv_q_filter" value=""/>
							</div>
							<div id="otw_type_page_wv_clear" class="otw_sidebar_wv_filter_clear">
								<a href="javascript:;" id="otw_type_<?php echo $wp_item_type ?>_wv_clear"><?php _e( 'reset', 'otw_sbm' )?></a>
							</div>
							<div id="otw_type_page_wv_order" class="otw_sidebar_wv_filter_order">
								<label for="otw_type_<?php echo $wp_item_type ?>_order_field"><?php _e( 'Order', 'otw_sbm' )?></label>
								<select id="otw_type_<?php echo $wp_item_type ?>_order_field">
									<?php $sort_options = otw_get_item_sort_options( $wp_item_type);?>
									<?php if( count( $sort_options ) ){?>
										<?php foreach( $sort_options as $s_key => $s_value ){ ?>
											<option value="<?php echo $s_key?>"><?php echo $s_value?></option>
										<?php }?>
									<?php }?>
								</select>
							</div>
							<div id="otw_type_page_wv_show" class="otw_sidebar_wv_filter_show">
								<label for="otw_type_<?php echo $wp_item_type ?>_show_field"><?php _e( 'Show', 'otw_sbm' )?></label>
								<select id="otw_type_<?php echo $wp_item_type ?>_show_field">
									<option value="all"><?php _e( 'All', 'otw_sbm' )?></option>
									<option value="all_selected"><?php _e( 'All Selected', 'otw_sbm' )?></option>
									<option value="all_unselected"><?php _e( 'All Unselected', 'otw_sbm' )?></option>
								</select>
							</div>
							
						</div>
						<div class="otw_sbm_all_actions">
							<div class="otw_sbm_all_links">
								<a href="javascript:;" class="otw_sbm_select_all_items all_vis" rel="<?php echo $sidebar?>|<?php echo $widget?>|<?php echo $wp_item_type?>|vis"><?php _e( 'Select All', 'otw_sbm' )?></a>
									|
								<a href="javascript:;" class="otw_sbm_unselect_all_items all_invis" rel="<?php echo $sidebar?>|<?php echo $widget?>|<?php echo $wp_item_type?>|invis"><?php _e( 'Unselect All', 'otw_sbm' )?></a>
							</div>
							<div class="otw_sbm_selected_items">
								<span class="otw_selected_items_number"></span>&nbsp;<span class="otw_seleted_items_plural"><?php _e( 'items are', 'otw_sbm' );?></span><span class="otw_selected_items_singular"><?php _e('item is', 'otw_sbm' )?></span>&nbsp;<?php _e( 'selected', 'otw_sbm' )?>
							</div>
						</div>
						<div class="lf_items">
						</div>
						<?php
							$exclude_type = $wp_item_type;
							
							if( preg_match( "/^post_in_ctx_(.*)$/", $exclude_type ) ){
								$exclude_type = 'post_in_ctx';
							}
							
							if( in_array( $exclude_type, $with_exclude_items ) ){?>
								<div class="otw_widget_exclude_items">
									<span><?php _e( 'Exclude posts from the above result-set by given id or slug. Separate with commas.' ); ?></span><br />
									<input type="text" id="otw_exclude_posts_<?php echo $wp_item_type ?>"  name="otw_exclude_posts_<?php echo $wp_item_type ?>" value="<?php echo otw_wp_item_widget_exclude( 'post', $sidebar, $widget, $wp_item_type, $otw_widget_settings ) ?>" />
									<input type="button" id="otw_save_excluded_<?php echo $wp_item_type ?>" value="<?php _e( 'Save', 'otw_sbm' ) ?>" class="button otw_save_excluded" rel="<?php echo $sidebar?>|<?php echo $widget?>|<?php echo $wp_item_type?>" />
									<img src="<?php echo $otw_sbm_plugin_url ?>/images/loading.gif" border="0" id="otw_exclude_loading_<?php echo $wp_item_type ?>" />
								</div>
						<?php }?>
					</div>
					
				</div>
			</div>
		<?php }?>
	<?php }?>
	<script type="text/javascript">
		otw_init_appearence_dialog();
	</script>
<?php }?>
</div>
