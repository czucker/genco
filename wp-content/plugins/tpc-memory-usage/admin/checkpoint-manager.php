<?php
/**
 * TPC! Memory Usage Checkpoint Administration
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */

if (!defined('ABSPATH'))
	die('-1');

// Handle checkpoint add/edit/delete
$checkpoint_status = false;
switch ($action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '') {
	case 'add':
		check_admin_referer('add-checkpoint');
		
		$checkpoint_status = tpcmem_add_checkpoint();
		break;
	
	case 'save':
		$checkpoint_id = (int) $_POST['checkpoint_id'];
		check_admin_referer('update-checkpoint_' . $checkpoint_id);
		
		$checkpoint_status = tpcmem_edit_checkpoint($checkpoint_id);
		break;
	
	case 'delete':
		$checkpoint_id = (int) $_GET['checkpoint_id'];
		check_admin_referer('delete-checkpoint_' . $checkpoint_id);
		
		tpcmem_delete_checkpoint($checkpoint_id);
		break;
	
	case 'refresh':
		check_admin_referer('tpcmem-refresh-checkpoints');
		
		tpcmem_revert_to_default_checkpoints();
		break;
		
	default:
		break;
}

// Get checkpoints now that any add/edit/delete action has been completed
$checkpoints = tpcmem_get_checkpoints();
?>
<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php echo esc_html($title); ?></h2>

<?php if ($checkpoint_status): ?>
<div id="message" class="updated fade">
	<p><strong>Success!</strong> Checkpoint <?php if ('add' == $action) { ?>added<?php } else { ?>updated<?php } ?>! 
	(ID #<?php echo (int) $checkpoint_status; ?>)</p>
</div>
<?php elseif ('delete' == $action): ?>
<div id="message" class="updated fade">
	<p><strong>Success!</strong> Checkpoint deleted.</p>
</div>
<?php endif; ?>
<?php if ($checkpoints): ?>
<table class="fixed widefat" cellspacing="0">
<thead>
<tr>
	<th>Action/Hook</th>
	<th>Description</th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php foreach ((array) $checkpoints as $checkpoint): ?>
<tr id="checkpoint-<?php echo esc_attr($checkpoint->checkpoint_id); ?>">
	<?php $edit_link = tpcmem_get_edit_checkpoint_link($checkpoint); ?>
	<td><strong><a class="row-title" href="<?php echo $edit_link; ?>" title="<?php echo esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), $checkpoint->checkpoint_action)); ?>"><?php echo esc_html($checkpoint->checkpoint_action); ?></a></strong><br/>
		<div class="row-actions">
		<?php
		$actions = array();
		$actions['edit'] = '<a href="' . $edit_link . '">' . __('Edit') . '</a>';
		$actions['delete'] = "<a class='submitdelete' href='" . wp_nonce_url("admin.php?action=delete&amp;page=tpcmem-checkpoint-manager&amp;checkpoint_id=$checkpoint->checkpoint_id", 'delete-checkpoint_' . $checkpoint->checkpoint_id) . "' onclick=\"if ( confirm('" . esc_js(sprintf( __("You are about to delete this checkpoint '%s'\n  'Cancel' to stop, 'OK' to delete."), $checkpoint->checkpoint_action )) . "') ) { return true;}return false;\">" . __('Delete') . "</a>";
		$action_count = count($actions);
		$i = 0;
		foreach ($actions as $action => $cAction) {
			(++$i == $action_count) ? $sep = '' : $sep = ' | ';
			echo "<span class='{$action}'>{$cAction}{$sep}</span>";
		}
		?>
		</div>
	</td>
	<td><?php echo esc_html($checkpoint->checkpoint_desc); ?></td>
	<td><a href="<?php echo admin_url('admin.php?page=tpcmem-reports&checkpointAction=' . esc_attr($checkpoint->checkpoint_action)); ?>">View Reports</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p>No checkpoints found.</p>
<?php endif; ?>

<div class="tablenav">
	<input type="button" id="tpcmemAddCheckpoint" value="Add Checkpoint" />
	<input type="button" id="tpcmemRefreshCheckpoints" value="Reset Checkpoints" />
	<?php wp_nonce_field('tpcmem-refresh-checkpoints', 'refreshCheckpointsNonce'); ?>
</div>
</div>