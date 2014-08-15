<?php
/** Manage plugin options
  *
  */

global $wp_sbm_int_items, $wp_sbm_tmc_items, $otw_sbm_widget_settings, $wp_sbm_gm_items, $wp_sbm_cs_items;

$otw_options = get_option( 'otw_plugin_options' );

$db_values = array();

if( isset( $_POST['otw_sbm_items_limit'] ) ){
	$db_values['otw_sbm_items_limit'] = $_POST['otw_sbm_items_limit'];
}elseif( isset( $otw_options['otw_sbm_items_limit'] ) ){
	$db_values['otw_sbm_items_limit'] = $otw_options['otw_sbm_items_limit'];
}else{
	$db_values['otw_sbm_items_limit'] = 20;
}

foreach( $otw_sbm_widget_settings as $s_type => $s_data ){

	if( isset( $_POST['otw_sbm_'.$s_type] ) ){
		$db_values[ 'otw_sbm_'.$s_type ] =  $_POST['otw_sbm_'.$s_type];
	}elseif( isset( $otw_options['otw_sbm_'.$s_type] ) ){
		$db_values[ 'otw_sbm_'.$s_type ] =  $otw_options['otw_sbm_'.$s_type];
	}else{
		$db_values[ 'otw_sbm_'.$s_type ] = $s_data[1];
	}
}

if( !isset( $otw_options['activate_old_grid'] ) ){
	$otw_options['activate_old_grid'] = false;
}

$db_values['shortcode_editor_button_for'] = array();
foreach( $wp_sbm_tmc_items as $item_key => $wpItem )
{
	$db_values['shortcode_editor_button_for'][ $item_key ] = '';
	
	if( isset( $_POST['otw_sbm_editor_shortcodes'] ) ){
	
		if( isset( $_POST['otw_sbm_editor_shortcodes'][ $item_key ] ) && $_POST['otw_sbm_editor_shortcodes'][ $item_key ] == 1  ){
			$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
		}
	
	}elseif( isset( $otw_options['shortcode_editor_button_for'] ) && isset( $otw_options['shortcode_editor_button_for'][ $item_key ] ) ){
	
		if( $otw_options['shortcode_editor_button_for'][ $item_key ] == 1 ){
			$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
		}
	}elseif( !isset( $otw_options['shortcode_editor_button_for'] ) || !isset( $otw_options['shortcode_editor_button_for'][ $item_key ] ) ){
		$db_values['shortcode_editor_button_for'][ $item_key ] = ' checked="checked"';
	}
}
$db_values['otw_gm_metabox_for'] = array();
foreach( $wp_sbm_tmc_items as $item_key => $wpItem )
{
	$db_values['otw_gm_metabox_for'][ $item_key ] = '';
	
	if( isset( $_POST['otw_gm_metabox_for'] ) ){
	
		if( isset( $_POST['otw_gm_metabox_for'][ $item_key ] ) && $_POST['otw_gm_metabox_for'][ $item_key ] == 1  ){
			$db_values['otw_gm_metabox_for'][ $item_key ] = ' checked="checked"';
		}
	
	}elseif( isset( $otw_options['otw_gm_metabox_for'] ) && isset( $otw_options['otw_gm_metabox_for'][ $item_key ] ) ){
	
		if( $otw_options['otw_gm_metabox_for'][ $item_key ] == 1 ){
			$db_values['otw_gm_metabox_for'][ $item_key ] = ' checked="checked"';
		}
	}elseif( !isset( $otw_options['otw_gm_metabox_for'] ) || !isset( $otw_options['otw_gm_metabox_for'][ $item_key ] ) ){
		$db_values['otw_gm_metabox_for'][ $item_key ] = ' checked="checked"';
	}
}
$db_values['otw_cs_metabox_for'] = array();
foreach( $wp_sbm_tmc_items as $item_key => $wpItem )
{
	$db_values['otw_cs_metabox_for'][ $item_key ] = '';
	
	if( isset( $_POST['otw_cs_metabox_for'] ) ){
	
		if( isset( $_POST['otw_cs_metabox_for'][ $item_key ] ) && $_POST['otw_cs_metabox_for'][ $item_key ] == 1  ){
			$db_values['otw_cs_metabox_for'][ $item_key ] = ' checked="checked"';
		}
	
	}elseif( isset( $otw_options['otw_cs_metabox_for'] ) && isset( $otw_options['otw_cs_metabox_for'][ $item_key ] ) ){
	
		if( $otw_options['otw_cs_metabox_for'][ $item_key ] == 1 ){
			$db_values['otw_cs_metabox_for'][ $item_key ] = ' checked="checked"';
		}
	}elseif( !isset( $otw_options['otw_cs_metabox_for'] ) || !isset( $otw_options['otw_cs_metabox_for'][ $item_key ] ) ){
		$db_values['otw_cs_metabox_for'][ $item_key ] = ' checked="checked"';
	}
}
$message = '';
$massages = array();
$messages[1] = __( 'Options saved', 'otw_sbm' );

if( isset( $_GET['message'] ) && isset( $messages[ $_GET['message'] ] ) ){
	$message .= $messages[ $_GET['message'] ];
}
?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php _e('Plugin Options', 'otw_sbm') ?>
	</h2>
	<div class="form-wrap otw-options" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_action" value="manage_otw_options" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-sbm-options'); ?>

			<div id="post-body">
				<div id="post-body-content">
					<div class="form-field">
						<input type="checkbox" id="sbm_activate_appearence" name="sbm_activate_appearence" value="1" style="width: 15px;" <?php if( isset( $otw_options['activate_appearence'] ) && $otw_options['activate_appearence'] ){ echo ' checked="checked" ';}?> /></label>
						<label for="sbm_activate_appearence" class="selectit"><?php _e( 'Enable widgets management', 'otw_sbm' )?>
						<p><?php _e( 'Control every single widgets visibility on different pages, post, categories, tags, custom post types and taxonomies. When widget control is enabled it will add a button called Set Visibility at the bottom of each widgets panel (Appearance -> Widgets).  You can choose where is the widget displayed on or hidden from.', 'otw_sbm' );?></p>
					</div>
					<div class="form-field">
						<label for="otw_sbm_items_limit"><?php _e( 'Items per page default', 'otw_sbm' )?></label>
						<select id="otw_sbm_items_limit" name="otw_sbm_items_limit" style="width: 100px;">
							<?php for( $cI = 5; $cI <= 50; $cI++ ){?>
								<?php
									if( $db_values['otw_sbm_items_limit'] == $cI ){
										$selected = ' selected="selected"';
									}else{
										$selected = '';
									}
								?>
								<option<?php echo $selected;?>><?php echo $cI?></option>
							<?php }?>
						</select>
						<p><?php _e( 'This is the default number of items to show in the lists when you add/eddit sidebars and set widget visibility.', 'otw_sbm' );?></p>
					</div>
					<div class="form-field">
						<label for="otw_sbm_editor_shortcodes"><?php _e( 'Show Insert Sidebar Shortcode button in the editor for', 'otw_sbm' )?></label>
						<div class="otw_left_labels">
							<?php foreach( $wp_sbm_tmc_items as $wp_item_type => $wpItem){?>
								<span>
									<input type="checkbox"<?php echo $db_values['shortcode_editor_button_for'][ $wp_item_type ]?> id="otw_sbm_editor_shortcodes_<?php echo $wp_item_type;?>" name="otw_sbm_editor_shortcodes[<?php echo $wp_item_type;?>]" value="1"/>
									<label for="otw_sbm_editor_shortcodes_<?php echo $wp_item_type;?>"><?php echo $wpItem[1];?></label>
								</span>
							<?php }?>
						</div>
					</div>
					<div class="form-field">
						<label for="otw_gm_metabox_for"><?php _e( 'Show OTW Grid Manger metabox in', 'otw_sbm' )?></label>
						<div class="otw_left_labels">
							<?php foreach( $wp_sbm_gm_items as $wp_item_type => $wpItem){?>
								<span>
									<input type="checkbox"<?php echo $db_values['otw_gm_metabox_for'][ $wp_item_type ]?> id="otw_gm_metabox_for_<?php echo $wp_item_type;?>" name="otw_gm_metabox_for[<?php echo $wp_item_type;?>]" value="1"/>
									<label for="otw_gm_metabox_for_<?php echo $wp_item_type;?>"><?php echo $wpItem[1];?></label>
								</span>
							<?php }?>
						</div>
					</div>
					<div class="form-field">
						<label for="otw_cs_metabox_for"><?php _e( 'Show OTW Content Sidebars metabox in', 'otw_sbm' )?></label>
						<div class="otw_left_labels">
							<?php foreach( $wp_sbm_cs_items as $wp_item_type => $wpItem){?>
								<span>
									<input type="checkbox"<?php echo $db_values['otw_cs_metabox_for'][ $wp_item_type ]?> id="otw_cs_metabox_for_<?php echo $wp_item_type;?>" name="otw_cs_metabox_for[<?php echo $wp_item_type;?>]" value="1"/>
									<label for="otw_cs_metabox_for_<?php echo $wp_item_type;?>"><?php echo $wpItem[1];?></label>
								</span>
							<?php }?>
						</div>
					</div>
					<div class="form-field">
						<input type="checkbox" id="sbm_activate_old_grid" name="sbm_activate_old_grid" value="1" style="width: 15px;" <?php if( isset( $otw_options['activate_old_grid'] ) && $otw_options['activate_old_grid'] ){ echo ' checked="checked" ';}?> /></label>
						<label for="sbm_activate_old_grid" class="selectit"><?php _e( 'Enable old grid', 'otw_sbm' )?>
						<p><?php _e( 'This will enable the old grid system interface and css classes used in plugin versions before 3.0. This option will be available for some time and then we will move to the new grid only. This is to make sure that all users have time to switch to the new grid system.', 'otw_sbm' );?></p>
					</div>
					<div class="form-field">
						<label><?php _e('New sidebar settings', 'otw_sbm');?></label>
						<p><?php _e( 'The following are the default settings for a new sidebar created with this plugin. Note that these will not affect any sidebar replacing an existing theme sidebar. The settings for such sidebars come from the theme. We do that to make sure the replaced sidebar will have the exact same styles as the original one.', 'otw_sbm') ?></p>
					</div>
					<?php foreach( $otw_sbm_widget_settings as $s_type => $s_data ){?>
					<div class="form-field">
						<label for="otw_sbm_<?php echo $s_type; ?>"><?php echo $s_type; ?></label>
						<input type="text" value="<?php echo htmlentities( $db_values['otw_sbm_'.$s_type])?>" id="otw_sbm_<?php echo $s_type; ?>" name="otw_sbm_<?php echo $s_type; ?>" style="width: 600px;"/>
						<p><?php echo $s_data[0]; ?></p>
					</div>
					<?php }?>
					
					<p class="submit">
						<input type="submit" value="<?php _e( 'Save Options', 'otw_sbm') ?>" name="submit" class="button"/>
					</p>
				</div>
			</div>
		</form>
	</div>
</div>