<?php
/** Sidebar actions
  *  - delete sidebar
  *  - activate
  *  - deactivate
  */
	$otw_sidebar_values = array(
		'sbm_title'       =>  '',
		'sbm_description' =>  '',
		'sbm_replace'     =>  '',
		'sbm_status'      =>  'inactive'
	);
	
	$otw_sidebar_id = '';
	$otw_action = '';
	
	if( isset( $_GET['action'] ) ){
		
		switch( $_GET['action'] ){
			
			case 'delete':
					$otw_action = 'delete_otw_sidebar';
					$page_title = __( 'Delete Sidebar', 'otw_sbm' );
					$confirm_text = __( 'Please confirm to delete the sidebar', 'otw_sbm' );
				break;
			case 'activate':
					$otw_action = 'activate_otw_sidebar';
					$page_title = __( 'Activate Sidebar', 'otw_sbm' );
					$confirm_text = __( 'Please confirm to activate the sidebar', 'otw_sbm' );
				break;
			case 'deactivate':
					$otw_action = 'deactivate_otw_sidebar';
					$page_title = __( 'Deactivate Sidebar', 'otw_sbm' );
					$confirm_text = __( 'Please confirm to deactivate the sidebar', 'otw_sbm' );
				break;
		}
	}
	if( !$otw_action ){
		wp_die( __( 'Invalid sidebar action', 'otw_sbm' ) );
	}
	if( isset( $_GET['sidebar'] ) ){
		
		$otw_sidebar_id = $_GET['sidebar'];
		$otw_sidebars = get_option( 'otw_sidebars' );
		
		if( is_array( $otw_sidebars ) && isset( $otw_sidebars[ $otw_sidebar_id ] ) ){
			
			$otw_sidebar_values['sbm_title'] = $otw_sidebars[ $otw_sidebar_id ]['title'];
			$otw_sidebar_values['sbm_description'] = $otw_sidebars[ $otw_sidebar_id ]['description'];
			$otw_sidebar_values['sbm_replace'] = $otw_sidebars[ $otw_sidebar_id ]['replace'];
			$otw_sidebar_values['sbm_status'] = $otw_sidebars[ $otw_sidebar_id ]['status'];
			$otw_sidebar_values['sbm_validfor'] = $otw_sidebars[ $otw_sidebar_id ]['validfor'];
		}
	}
	if( !$otw_sidebar_id ){
		wp_die( __( 'Invalid sidebar', 'otw_sbm' ) );
	}
	
?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php echo $page_title; ?>
		<a class="button add-new-h2" href="admin.php?page=otw-sbm"><?php _e( 'Back To List Of Sidebars', 'otw_sbm' );?></a>
	</h2>
	<div id="ajax-response"></div>
	<div class="form-wrap" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_action" value="<?php echo $otw_action?>" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-sbm-action'); ?>

			<div id="post-body">
				<div id="post-body-content">
					<div id="col-right">
						<div class="form-field form-required">
							<?php _e( 'Sidebar title', 'otw_sbm' );?>:
							<strong><?php echo $otw_sidebar_values['sbm_title']?></strong>
						</div>
						<div class="form-field">
							<?php _e( 'Status', 'otw_sbm' );?>:
							<strong><?php _e( ucfirst( $otw_sidebar_values['sbm_status']  ), 'otw_sbm' )?></strong>
						</div>
						<div class="form-field">
							<?php _e( 'Description', 'otw_sbm' )?>:
							<strong><?php echo $otw_sidebar_values['sbm_description']?></strong>
						</div>
					</div>
					<div id="col-left">
						<p>
							<?php echo $confirm_text;?>
						</p>
						<p class="submit">
							<input type="submit" value="<?php _e( 'Confirm', 'otw_sbm') ?>" name="submit" class="button"/>
							<input type="submit" value="<?php _e( 'Cancel', 'otw_sbm' ) ?>" name="cancel" class="button"/>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>