<?php
/** Create/edit otw sidebar
  *
  */
	global $wp_registered_sidebars, $validate_messages, $wp_sbm_int_items;
	
	$otw_sidebar_values = array(
		'sbm_loaded'             =>  false,
		'sbm_title'              =>  '',
		'sbm_description'        =>  '',
		'sbm_replace'            =>  '',
		'sbm_status'             =>  'inactive',
		'sbm_widget_alignment'   =>  'vertical'
	);
	
	$with_global_selection = array();
	$with_exclude_items = array( 'postsincategory', 'postsintag', 'post_in_ctx' );
	
	$otw_sidebar_id = '';
	
	$page_title = __( 'Create New Sidebar', 'otw_sbm' );
	
	$sbm_valid_for_values = array();

	if( isset( $_GET['sidebar'] ) ){
		
		$otw_sidebar_id = $_GET['sidebar'];
		$otw_sidebars = get_option( 'otw_sidebars' );
		
		if( is_array( $otw_sidebars ) && isset( $otw_sidebars[ $otw_sidebar_id ] ) ){
			
			$otw_sidebar_values['sbm_loaded'] = true;
			$otw_sidebar_values['sbm_title'] = $otw_sidebars[ $otw_sidebar_id ]['title'];
			$otw_sidebar_values['sbm_description'] = $otw_sidebars[ $otw_sidebar_id ]['description'];
			$otw_sidebar_values['sbm_replace'] = $otw_sidebars[ $otw_sidebar_id ]['replace'];
			$otw_sidebar_values['sbm_status'] = $otw_sidebars[ $otw_sidebar_id ]['status'];
			if( isset( $otw_sidebars[ $otw_sidebar_id ]['widget_alignment'] ) ){
				$otw_sidebar_values['sbm_widget_alignment'] = $otw_sidebars[ $otw_sidebar_id ]['widget_alignment'];
			}
			$otw_sidebar_values['sbm_validfor'] = $otw_sidebars[ $otw_sidebar_id ]['validfor'];
			if( isset( $otw_sidebars[ $otw_sidebar_id ]['exclude_posts_for'] ) ){
				$otw_sidebar_values['sbm_exclude_posts_for'] = $otw_sidebars[ $otw_sidebar_id ]['exclude_posts_for'];
			}
			$page_title = __( 'Edit Sidebar', 'otw_sbm' );
			
		}
	}
	//apply post values
	if( isset( $_POST['otw_action'] ) ){
		foreach( $otw_sidebar_values as $otw_field_key => $otw_field_default_value ){
			if( isset( $_POST[ $otw_field_key ] ) ){
				$otw_sidebar_values[ $otw_field_key ] = $_POST[ $otw_field_key ];
			}
		}
	}
	
	foreach( $wp_sbm_int_items as $wp_item_type => $wp_item_data ){
	
		if( isset( $otw_sidebar_values['sbm_validfor'][ $wp_item_type ] ) ){
			$sbm_valid_for_values[ $wp_item_type ] = implode(',', array_keys( $otw_sidebar_values['sbm_validfor'][ $wp_item_type ] ) );
		}elseif( !$otw_sidebar_values['sbm_loaded'] && in_array( $wp_item_type, array( 'wpmllanguages', 'userroles' ) ) ){
			$db_full_items = otw_sbm_get_filtered_items( $wp_item_type, '', 0, 0 );
			$keys = array( 'all' );
			if( isset( $db_full_items[1] ) && is_array( $db_full_items[1] ) ){
				foreach( $db_full_items[1] as $db_full_wpItem ){
					$key = otw_wp_item_attribute( $wp_item_type, 'ID', $db_full_wpItem );
					$keys[ $key ] = $key;
				}
			}
			$sbm_valid_for_values[ $wp_item_type ] = implode( ",", $keys );
		}else{
			$sbm_valid_for_values[ $wp_item_type ] = '';
		}
		
		if( isset( $_POST['otw_smb_'.$wp_item_type.'_validfor'] ) ){
			$sbm_valid_for_values[ $wp_item_type ] = $_POST['otw_smb_'.$wp_item_type.'_validfor'];
		}
		//$wp_sbm_int_items[ $wp_item_type ][0] = otw_get_wp_items( $wp_item_type );
	}
	
/** set class name of each item block
  *  @param array
  *  @return void
  */
function otw_sidebar_block_class( $item_type, $sidebar_data, $validfor_data ){
	
	if( strlen( trim( $validfor_data ) ) ){
		return;
	}
	
	if( isset( $_POST['otw_action'] ) ){
		if( ( !isset( $_POST[ 'otw_sbi_'.$item_type ] ) || !count( $_POST[ 'otw_sbi_'.$item_type ] ) ) && !isset( $_POST['otw_all_selection_'.$item_type]) ){
			echo ' otw_closed';
		}
	}else{
		if( !$sidebar_data['sbm_loaded'] ){
		
			switch( $item_type ){
				case 'wpmllanguages':
				case 'userroles':
					break;
				default:
						if( !isset( $sidebar_data['sbm_validfor'][ $item_type ] ) || !count( $sidebar_data['sbm_validfor'][ $item_type ] ) ){
							echo ' otw_closed';
						}
					break;
			}
		}else{
			if( !isset( $sidebar_data['sbm_validfor'][ $item_type ] ) || !count( $sidebar_data['sbm_validfor'][ $item_type ] ) ){
				echo ' otw_closed';
			}
		}
	}
}

/** set class name of each item parent block
  *  @param array
  *  @return void
  */
function otw_parent_sidebar_block_class( $item_type, $sidebar_data, $validfor_data ){
	
	if( strlen( trim( $validfor_data ) ) ){
		return;
	}
	if( isset( $_POST['otw_action'] ) ){
		if( ( !isset( $_POST[ 'otw_sbi_'.$item_type ] ) || !count( $_POST[ 'otw_sbi_'.$item_type ] ) ) && !isset( $_POST['otw_all_selection_'.$item_type]) ){
			echo ' closed';
		}
	}else{
		if( !$sidebar_data['sbm_loaded'] ){
		
			switch( $item_type ){
				case 'wpmllanguages':
				case 'userroles':
					break;
				default:
						if( !isset( $sidebar_data['sbm_validfor'][ $item_type ] ) || !count( $sidebar_data['sbm_validfor'][ $item_type ] ) ){
							echo ' closed';
						}
					break;
			}
		}else{
			if( !isset( $sidebar_data['sbm_validfor'][ $item_type ] ) || !count( $sidebar_data['sbm_validfor'][ $item_type ] ) ){
				echo ' closed';
			}
		}
	}
}


/**
 * Check if global is selected
 */
function otw_global_selection( $item_type, $sidebar_data ){
	
	$selected = '';
	
	if( isset( $_POST['otw_action'] ) ){
		
		if( isset( $_POST['otw_all_selection_'.$item_type] ) ){
			$selected = ' checked="checked"';
		}
	}else{
		if( isset( $sidebar_data['sbm_validfor'][ $item_type ] ) && isset( $sidebar_data['sbm_validfor'][ $item_type ]['all'] ) && isset( $sidebar_data['sbm_validfor'][ $item_type ]['all']['type'] ) && ( $sidebar_data['sbm_validfor'][ $item_type ]['all']['type'] == 'global' ) ){
			$selected = ' checked="checked"';
		}
	}
	
	return $selected;
}

/**
 * Check if global is exclude selected
 */
function otw_global_exclude_selection( $item_type, $sidebar_data ){
	
	$excluded = '';
	
	if( isset( $_POST['otw_action'] ) ){
		
		if( isset( $_POST['otw_exclude_items_'.$item_type] ) ){
			$excluded = $_POST['otw_exclude_items_'.$item_type];
		}
	}else{
		if( isset( $sidebar_data['sbm_validfor'][ $item_type ] ) && isset( $sidebar_data['sbm_validfor'][ $item_type ]['all'] ) && isset( $sidebar_data['sbm_validfor'][ $item_type ]['all']['type'] ) && ( $sidebar_data['sbm_validfor'][ $item_type ]['all']['type'] == 'global' ) && isset( $sidebar_data['sbm_validfor'][ $item_type ]['all']['exclude'] ) ){
			$excluded = $sidebar_data['sbm_validfor'][ $item_type ]['all']['exclude'];
		}
	}
	
	return $excluded;
}
?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php echo $page_title; ?>
		<a class="button add-new-h2" href="admin.php?page=otw-sbm"><?php _e('Back To Available Sidebars', 'otw_sbm')?></a>
	</h2>
	<?php if( isset( $validate_messages ) && count( $validate_messages ) ){?>
		<div id="message" class="error">
			<?php foreach( $validate_messages as $v_message ){
				echo '<p>'.$v_message.'</p>';
			}?>
		</div>
	<?php }?>
	<div class="form-wrap" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_action" value="manage_otw_sidebar" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-sbm-manage'); ?>

			<div id="post-body">
				<div id="post-body-content">
					<div id="col-right" style="width: 65%;" class="otw_sbm_<?php echo $otw_sidebar_id?>">
					
						<div class="otw_sbm_global_manage_settings">
							<a href="javascript:;" class="otw_all_global_manage_vis"><?php _e( 'Visible everywhere', 'otw_sbm' )?></a>
							|
							<a href="javascript:;" class="otw_all_global_manage_invis"><?php _e( 'Invisible everywhere', 'otw_sbm' )?></a>
							<br /><i><?php _e( 'This will not affect the "User roles/Logged in as" tab settings.', 'otw_sbm' ) ?></i>
						</div>
						<?php if( is_array( $wp_sbm_int_items ) && count( $wp_sbm_int_items ) ){?>
						
							<?php foreach( $wp_sbm_int_items as $wp_item_type => $wp_item_data ){?>
							
								<div class="meta-box-sortables">
									<div class="postbox<?php otw_parent_sidebar_block_class( $wp_item_type, $otw_sidebar_values, $sbm_valid_for_values[ $wp_item_type ] )?>">
										<div title="<?php _e('Click to toggle', 'otw_sbm')?>" class="handlediv sitem_toggle"><br></div>
										<h3 class="hndle sitem_header"><span><?php echo $wp_item_data[1]?></span></h3>
										
										<div class="inside sitems<?php otw_sidebar_block_class( $wp_item_type, $otw_sidebar_values, $sbm_valid_for_values[ $wp_item_type ] )?>" id="otw_sbm_type_<?php echo $wp_item_type?>">
											
												<div class="otw_sidebar_item_filter" id="otw_type_<?php echo $wp_item_type ?>_filter" >
													<div id="otw_type_<?php echo $wp_item_type ?>_search" class="otw_sidebar_filter_search">
														<label for="otw_type_<?php echo $wp_item_type ?>_search_field"><?php _e( 'Search', 'otw_sbm' )?></label>
														<input type="text" id="otw_type_<?php echo $wp_item_type ?>_search_field" class="otw_sbm_q_filter" value=""/>
													</div>
													<div id="otw_type_<?php echo $wp_item_type ?>_clear" class="otw_sidebar_filter_clear">
														<a href="javascript:;" id="otw_type_<?php echo $wp_item_type ?>_clear"><?php _e( 'reset', 'otw_sbm' )?></a>
													</div>
													<div id="otw_type_<?php echo $wp_item_type ?>_order" class="otw_sidebar_filter_order">
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
													<div id="otw_type_<?php echo $wp_item_type ?>_show" class="otw_sidebar_filter_show">
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
														<a href="javascript:;" class="otw_sbm_select_all_items" rel="<?php echo $wp_item_type?>"><?php _e( 'Select All', 'otw_sbm' )?></a>
														|
														<a href="javascript:;" class="otw_sbm_unselect_all_items" rel="<?php echo $wp_item_type?>"><?php _e( 'Unselect All', 'otw_sbm' )?></a>
													</div>
													<div class="otw_sbm_selected_items">
														<span class="otw_selected_items_number"></span>&nbsp;<span class="otw_seleted_items_plural"><?php _e( 'items are', 'otw_sbm' );?></span><span class="otw_selected_items_singular"><?php _e('item is', 'otw_sbm' )?></span>&nbsp;<?php _e( 'selected', 'otw_sbm' )?>
													</div>
												</div>
												<div class="a_item">
												<?php if( is_array( $wp_item_data[0] ) && count( $wp_item_data[0] ) ){?>
													<?php foreach( $wp_item_data[0] as $wpItem ){?>
														<p<?php otw_sidebar_item_attributes( 'p', $wp_item_type, otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ), $otw_sidebar_values, $wpItem )?>>
															<input type="checkbox" id="otw_sbi_<?php echo $wp_item_type?>_sbi_<?php echo otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ?>"<?php otw_sidebar_item_attributes( 'c', $wp_item_type, otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ), $otw_sidebar_values, array() )?> value="<?php echo otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ?>" name="otw_sbi_<?php echo $wp_item_type?>[<?php echo otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ?>]" /><label for="otw_sbi_<?php echo $wp_item_type?>_sbi_<?php echo otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ) ?>"<?php otw_sidebar_item_attributes( 'l', $wp_item_type, otw_wp_item_attribute( $wp_item_type, 'ID', $wpItem ), $otw_sidebar_values, $wpItem )?> ><a href="javascript:;"><?php echo otw_wp_item_attribute( $wp_item_type, 'TITLE', $wpItem ) ?></a></label>
														</p>
													<?php }?>
												<?php }else{ echo '&nbsp;'; }?>
												</div>
												<?php
													$exclude_type = $wp_item_type;
													
													if( preg_match( "/^post_in_ctx_(.*)$/", $exclude_type ) ){
														$exclude_type = 'post_in_ctx';
													}
													
													if( in_array( $exclude_type, $with_exclude_items ) ){?>
														<div class="otw_exclude_items">
															<span><?php _e( 'Exclude posts from the above result-set by given id or slug. Separate with commas.' ); ?></span><br />
															<input type="text" name="otw_exclude_posts_<?php echo $wp_item_type ?>" value="<?php echo otw_wp_item_exclude( 'post', $wp_item_type, $otw_sidebar_values ) ?>" />
														</div>
												<?php }?>
											<input type="hidden" id="otw_sbm_type_<?php echo $wp_item_type?>_validfor" class="otw_sbm_validfor" value="<?php echo $sbm_valid_for_values[ $wp_item_type ]?>" name="otw_smb_<?php echo $wp_item_type?>_validfor" />
										</div>
									</div>
								</div>
								
							<?php }?>
							
						<?php } ?>
					</div>
					<div id="col-left" style="width: 35%;">
						<div class="form-field form-required">
							<label for="sbm_title"><?php _e( 'Sidebar title', 'otw_sbm' );?></label>
							<input type="text" id="sbm_title" value="<?php echo $otw_sidebar_values['sbm_title']?>" tabindex="1" size="30" name="sbm_title"/>
							<p><?php _e( 'The name is how it appears on your site.', 'otw_sbm' );?></p>
						</div>
						<div class="form-field">
							<label for="sbm_status"><?php _e( 'Status', 'otw_sbm' );?></label>
							<select id="sbm_status" tabindex="2" style="width: 170px;" name="sbm_status">
								<option value=""<?php if( $otw_sidebar_values['sbm_status'] == '' ){ echo ' selected="selected" ';}?>>--/--</option>
								<option value="active"<?php if( $otw_sidebar_values['sbm_status'] == 'active' ){ echo ' selected="selected" ';}?>><?php _e( 'Active', 'otw_sbm' )?></option>
								<option value="inactive"<?php if( $otw_sidebar_values['sbm_status'] == 'inactive' ){ echo ' selected="selected" ';}?>><?php _e( 'Inactive', 'otw_sbm' )?></option>
							</select>
						</div>
						<?php if( is_array( $wp_registered_sidebars ) && count( $wp_registered_sidebars ) ){?>
						<div class="form-field">
							<label for="sbm_replace"><?php _e( 'Replace Existing SideBar', 'otw_sbm' );?></label>
							<select id="sbm_replace" tabindex="3" style="width: 270px;" name="sbm_replace">
								<option value="">--/--</option>
								<?php foreach( $wp_registered_sidebars as $lp_wp_sidebar_id => $lp_wp_sidebar ){?>
									<?php if( !preg_match( '/^otw\-sidebar\-/', $lp_wp_sidebar_id ) && ( $otw_sidebar_id != $lp_wp_sidebar_id ) ){?>
										<?php
											$selected = '';
											if( $otw_sidebar_values['sbm_replace'] == $lp_wp_sidebar_id ){
												$selected = ' selected="selected"';
											}
										?>
										<option value="<?php echo $lp_wp_sidebar_id?>"<?php echo $selected?>><?php echo $lp_wp_sidebar['name']?></option>
									<?php }?>
									
								<?php }?>
							</select>
							<p><?php _e( 'Replace existing sidebar. It will be replaced only for selected templates from the right column.', 'otw_sbm' );?></p>
						</div>
						<?php }?>
						<div class="form-field" id="sbm_widget_alignment_cnt">
							<label for="sbm_widget_alignment"><?php _e( 'Widget Alignment', 'otw_sbm' );?></label>
							<select id="sbm_widget_alignment" tabindex="2" style="width: 170px;" name="sbm_widget_alignment">
								<option value="vertical"<?php if( in_array( $otw_sidebar_values['sbm_widget_alignment'], array( '', 'vertical' ) ) ){ echo ' selected="selected" ';}?>><?php _e( 'Vertical (WP default)', 'otw_sbm' )?></option>
								<option value="horizontal"<?php if( $otw_sidebar_values['sbm_widget_alignment'] == 'horizontal' ){ echo ' selected="selected" ';}?>><?php _e( 'Horizontal', 'otw_sbm' )?></option>
							</select>
						</div>
						<div class="form-field">
							<label for="sbm_description"><?php _e( 'Description', 'otw_sbm' )?></label>
							<textarea id="sbm_description" name="sbm_description" tabindex="4" rows="3" cols="10"><?php echo $otw_sidebar_values['sbm_description']?></textarea>
							<p><?php _e( 'Short description for your reference at the admin panel.', 'otw_sbm')?></p>
						</div>
						<p class="submit">
							<input type="submit" value="<?php _e( 'Save Sidebar', 'otw_sbm') ?>" name="submit" class="button"/>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>