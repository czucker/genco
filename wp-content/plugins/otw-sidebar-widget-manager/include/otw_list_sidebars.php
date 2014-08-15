<?php
/** List with all available otw sitebars
  *
  *
  */
global $_wp_column_headers;

$_wp_column_headers['toplevel_page_otw-sbm'] = array(
	'title' => __( 'Title', 'otw_sbm' ),
	'description' => __( 'Description', 'otw_sbm' ),
	'status' => __( 'Status', 'otw_sbm' ),
	'shortcode' => __( 'ShortCode', 'otw_sbm')

);

$otw_sidebar_list = get_option( 'otw_sidebars' );

$message = '';
$massages = array();
$messages[1] = __( 'Sidebar saved.', 'otw_sbm' );
$messages[2] = __( 'Sidebar deleted.', 'otw_sbm' );
$messages[3] = __( 'Sidebar activated.', 'otw_sbm' );
$messages[4] = __( 'Sidebar deactivated.', 'otw_sbm' );


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
		<?php _e('Available Custom Sidebars', 'otw_sbm') ?>
		<a class="button add-new-h2" href="admin.php?page=otw-sbm-add"><?php _e('Add New', 'otw_sbm') ?></a>
	</h2>
	
	<form class="search-form" action="" method="get">
	</form>
	
	<br class="clear" />
	<?php if( is_array( $otw_sidebar_list ) && count( $otw_sidebar_list ) ){?>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<?php foreach( $_wp_column_headers['toplevel_page_otw-sbm'] as $key => $name ){?>
					<th><?php echo $name?></th>
				<?php }?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<?php foreach( $_wp_column_headers['toplevel_page_otw-sbm'] as $key => $name ){?>
					<th><?php echo $name?></th>
				<?php }?>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach( $otw_sidebar_list as $sidebar_item ){?>
				<tr>
					<?php foreach( $_wp_column_headers['toplevel_page_otw-sbm'] as $column_name => $column_title ){
						
						$edit_link = admin_url( 'admin.php?page=otw-sbm&amp;action=edit&amp;sidebar='.$sidebar_item['id'] );
						$delete_link = admin_url( 'admin.php?page=otw-sbm-action&amp;sidebar='.$sidebar_item['id'].'&amp;action=delete' );
						$status_link = '';
						switch( $sidebar_item['status'] ){
							case 'active':
									$status_link = admin_url( 'admin.php?page=otw-sbm-action&amp;sidebar='.$sidebar_item['id'].'&amp;action=deactivate' );
									$status_link_name = __( 'Deactivate', 'otw_sbm' );
								break;
							case 'inactive':
									$status_link = admin_url( 'admin.php?page=otw-sbm-action&amp;sidebar='.$sidebar_item['id'].'&amp;action=activate' );
									$status_link_name = __( 'Activate', 'otw_sbm' );
								break;
						}
						switch($column_name) {

							case 'cb':
									echo '<th scope="row" class="check-column"><input type="checkbox" name="itemcheck[]" value="'. esc_attr($sidebar_item['id']) .'" /></th>';
								break;
							case 'title':
									echo '<td><strong><a href="'.$edit_link.'" title="'.esc_attr(sprintf(__('Edit &#8220;%s&#8221;', 'otw_sbm'), $sidebar_item['title'])).'">'.$sidebar_item['title'].'</a></strong><br />';
									
									echo '<div class="row-actions">';
									echo '<a href="'.$edit_link.'">' . __('Edit', 'otw_sbm') . '</a>';
									echo ' | <a href="'.$delete_link.'">' . __('Delete', 'otw_sbm'). '</a>';
									if( $status_link ){
									echo ' | <a href="'.$status_link.'">' . $status_link_name. '</a>';
									}
									echo '</div>';
									
									echo '</td>';
								break;
							case 'description':
									echo '<td>'.$sidebar_item['description'].'</td>';
								break;
							case 'status':
									switch( $sidebar_item['status'] ){
										case 'active':
												echo '<td class="sidebar_active">'.__( 'Active', 'otw_sbm' ).'</td>';
											break;
										case 'inactive':
												echo '<td class="sidebar_inactive">'.__( 'Inactive', 'otw_sbm' ).'</td>';
											break;
										default:
												echo '<td>'.__( 'Unknown', 'otw_sbm' ).'</td>';
											break;
									}
								break;
							case 'shortcode':
									if( !isset( $sidebar_item['replace'] ) || empty( $sidebar_item['replace'] ) ){
										echo '<td>[otw_is sidebar='.$sidebar_item['id'].']</td>';
									}else{
										echo '<td>&nbsp;</td>';
									}
								break;
						}
					}?>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<?php }else{ ?>
		<p><?php _e('No custom sidebars found.', 'otw_sbm')?></p>
	<?php } ?>
</div>
