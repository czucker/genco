<?php
/**
 * Memory Usage Reports
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */

if (!defined('ABSPATH'))
	die('-1');

// Initialize page variables
$action = isset($_POST['action']) ? $_POST['action'] : '';
$itemsPerPage = isset($_POST['itemsPerPage']) ? $_POST['itemsPerPage'] : 20;
$currentPage = isset($_GET['p']) ? $_GET['p'] : 1;
$checkpointAction = isset($_REQUEST['checkpointAction']) && $_REQUEST['checkpointAction'] != -1
				  ? $_REQUEST['checkpointAction'] : false;

function tpcmem_bulk_delete_records() {
	check_admin_referer('tpcmem-bulk-records');
	
	$usagecheck = $_POST['usagecheck'];
	
	if (count($usagecheck) == 0) {
		return;
	}
	
	$deleted = 0;
	foreach ($usagecheck as $usage_id) {
		$usage_id = (int) $usage_id;
		
		if (tpcmem_delete_usage_record($usage_id))
			$deleted++;
	}
	
	return $deleted;
}

if ('delete' == $action)
	tpcmem_bulk_delete_records();

$reportArgs = array();
if ($checkpointAction)
	$reportArgs['checkpoint_action'] = $checkpointAction;

clean_usage_record_cache(0);
$reportPaginator = tpcmem_initialize_paginator(
	tpcmem_get_usage_records($reportArgs),
	$currentPage,
	$itemsPerPage
);
?>

<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php echo esc_html($title); ?></h2>

<form id="tpcmem-reports-filter" action="<?php echo admin_url('admin.php?page=tpcmem-reports'); ?>" method="post">
<div class="tablenav">
<div class="alignleft actions">
<select name="action">
	<option value="-1" selected="selected">Bulk Actions</option>
	<option value="delete"><?php esc_html_e('Delete Records'); ?></option>
</select>
<input type="submit" value="<?php esc_attr_e('Apply'); ?>" name="doaction" id="doaction" class="button-secondary action" />
<?php wp_nonce_field('tpcmem-bulk-records'); ?>

<select name="checkpointAction">
<option value="-1">Show All</option>
<?php tpcmem_dropdown_checkpoint_actions($checkpointAction); ?>
</select>

<select name="itemsPerPage">
<?php tpcmem_dropdown_items_per_page($itemsPerPage); ?>
</select>
<input type="submit" id="tpcmem-record-submit" value="Filter" class="button-secondary" />
</div>
</div>
<?php if ($reportPaginator->getCurrentItemCount() > 0): ?>
<table id="tpcmemReportsTable" class="widefat fixed" cellspacing="0">
<thead>
<tr>
	<th scope="col" id="cb" class="manage-column column-cb check-column"><input type="checkbox" /></th>
	<th>Date &amp; Time</th>
	<th>Checkpoint Action</th>
	<th>Memory Usage</th>
	<th>Priority</th>
</tr>
</thead>
<tfoot>
<tr>
	<th scope="col" id="cb" class="manage-column column-cb check-column"><input type="checkbox" /></th>
	<th>Date &amp; Time</th>
	<th>Checkpoint Action</th>
	<th>Memory Usage</th>
	<th>Priority</th>
</tr>
</tfoot>
<tbody>
<?php foreach ($reportPaginator as $usageLog): ?>
<tr id="usage-<?php echo (int) $usageLog->id; ?>">
	<th scope="row" class="check-column"><input type="checkbox" name="usagecheck[]" value="<?php echo (int) $usageLog->id; ?>" /></th>
	<td><?php echo esc_html(get_date_from_gmt($usageLog->time)); ?></td>
	<td><?php echo esc_html($usageLog->checkpoint_action); ?></td>
	<td><?php echo esc_html(tpcmem_bytes_to_mb($usageLog->usage) . ' MB'); ?></td>
	<td><?php echo esc_html(tpcmem_priority_text($usageLog->priority)); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php tpcmem_generate_paginator($reportPaginator); ?>
<?php else: ?>
<p>Sorry, we did not find any records. Please try your search again.</p>
<?php endif; ?>

</form>
</div><!-- .wrap -->