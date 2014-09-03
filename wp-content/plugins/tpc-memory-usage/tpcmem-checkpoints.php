<?php
/**
 * TPC! Memory Usage Checkpoint API
 * 
 * @package TPC_Memory_Usage
 * @subpackage Checkpoint
 */

if (!defined('ABSPATH'))
	die('-1');

function tpcmem_get_checkpoint($checkpoint, $output = OBJECT) {
	global $wpdb;
	
	if (is_object($checkpoint)) {
		$_checkpoint = $checkpoint;
		wp_cache_add($_checkpoint->checkpoint_id, $_checkpoint, 'tpcmem-checkpoint');
	} elseif (!$_checkpoint = wp_cache_get($checkpoint, 'tpcmem-checkpoint')) {
		if (!$_checkpoint = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . TPCMEM_DB_CHECKPOINTS . " WHERE checkpoint_id = %d LIMIT 1", $checkpoint)))
			return false;
		wp_cache_add($_checkpoint->checkpoint_id, $_checkpoint, 'tpcmem-checkpoint');
	}
	
	return tpcmem_db($_checkpoint, $output);
}

function tpcmem_get_checkpoints() {
	global $wpdb;
	
	if (!$checkpoints = wp_cache_get('tpcmem_get_checkpoints', 'tpcmem-checkpoint')) {
		$checkpoints = $wpdb->get_results("SELECT * FROM " . TPCMEM_DB_CHECKPOINTS . " ORDER BY checkpoint_action ASC");
		wp_cache_add('tpcmem_get_checkpoints', $checkpoints, 'tpcmem-checkpoint');
	}
	
	return $checkpoints;
}

function tpcmem_add_checkpoint() {
	return tpcmem_edit_checkpoint();
}

function tpcmem_edit_checkpoint($checkpoint_id = '') {
	if (!empty($checkpoint_id)) {
		$_POST['checkpoint_id'] = (int) $checkpoint_id;
		return tpcmem_update_checkpoint($_POST);
	} else {
		return tpcmem_insert_checkpoint($_POST);
	}
}

function tpcmem_get_default_checkpoint_to_edit() {
	$checkpoint->checkpoint_action = '';
	$checkpoint->checkpoint_desc = '';
	return $checkpoint;
}

function tpcmem_delete_checkpoint($checkpoint_id) {
	global $wpdb;
	
	do_action('tpcmem_delete_checkpoint', $checkpoint_id);
	
	$wpdb->query($wpdb->prepare("DELETE FROM " . TPCMEM_DB_CHECKPOINTS . " WHERE checkpoint_id = %d", $checkpoint_id));
	
	do_action('tpcmem_deleted_checkpoint', $checkpoint_id);
	
	tpcmem_clean_checkpoint_cache($checkpoint_id);
	
	return true;
}

function tpcmem_insert_checkpoint($cdata) {
	global $wpdb;
	
	$defaults = array('checkpoint_id' => 0, 'checkpoint_action' => '', 'checkpoint_desc' => '');
	
	$cdata = wp_parse_args($cdata, $defaults);
	
	extract(stripslashes_deep($cdata), EXTR_SKIP);
	
	$update = false;
	if (!empty($checkpoint_id))
		$update = true;
	
	if (trim($checkpoint_action) == '')
		return 0;
	
	if ($update) {
		if (false === $wpdb->query($wpdb->prepare("UPDATE " . TPCMEM_DB_CHECKPOINTS . " SET checkpoint_action = %s, checkpoint_desc = %s WHERE checkpoint_id = %d", $checkpoint_action, $checkpoint_desc, $checkpoint_id))) {
			return 0;
		}
	} else {
		if (false === $wpdb->query($wpdb->prepare("INSERT INTO " . TPCMEM_DB_CHECKPOINTS . " (checkpoint_action, checkpoint_desc) VALUES (%s, %s)", $checkpoint_action, $checkpoint_desc))) {
			return 0;
		}
		$checkpoint_id = (int) $wpdb->insert_id;
	}
	
	if ($update)
		do_action('tpcmem_edit_checkpoint', $checkpoint_id);
	else
		do_action('tpcmem_add_checkpoint', $checkpoint_id);
	
	tpcmem_clean_checkpoint_cache($checkpoint_id);
	
	return $checkpoint_id;
}

function tpcmem_update_checkpoint($cdata) {
	$checkpoint_id = (int) $cdata['checkpoint_id'];
	
	$checkpoint = tpcmem_get_checkpoint($checkpoint_id, ARRAY_A);
	
	// Escape data from database
	$checkpoint = add_magic_quotes($checkpoint);
	
	// Merge old and new fields with new fields taking precedence over old ones
	$cdata = array_merge($checkpoint, $cdata);
	
	return tpcmem_insert_checkpoint($cdata);
}

function tpcmem_register_checkpoints() {
	// If there are no checkpoints in the database, use default checkpoints
	if (!$checkpoints = tpcmem_get_checkpoints())
		return false;
	
	foreach ((array) $checkpoints as $c) {
		add_action(
			$c->checkpoint_action,
			create_function(null,
				'{
				   tpcmem_checkpoint(array(
					"checkpoint_action" => "' . esc_html($c->checkpoint_action) . '",
					"checkpoint_desc"	=> "' . esc_html($c->checkpoint_desc) . '"
				   ));
				 }'), 15, 1);
	}
}

function get_default_tpcmem_log_to_edit() {
	return array('checkpoint_action' => 'unknown', 'checkpoint_desc' => 'Unknown', 'time' => 0, 'usage' => '');
}

function tpcmem_get_default_checkpoints() {
	return array(
		array('checkpoint_action' => 'sanitize_comment_cookies', 'checkpoint_desc' => 'Sanitize comment cookies'),
		array('checkpoint_action' => 'setup_theme', 'checkpoint_desc' => 'Setup theme'),
		array('checkpoint_action' => 'init', 'checkpoint_desc' => 'WordPress initialization'),
		array('checkpoint_action' => 'wp_head', 'checkpoint_desc' => 'Display front-end header'),
		array('checkpoint_action' => 'publish_future_post', 'checkpoint_desc' => 'Publish future post'),
		array('checkpoint_action' => 'do_feed_rdf', 'checkpoint_desc' => 'RDF feed'),
		array('checkpoint_action' => 'do_feed_rss', 'checkpoint_desc' => 'RSS feed'),
		array('checkpoint_action' => 'do_feed_rss2', 'checkpoint_desc' => 'RSS2 feed'),
		array('checkpoint_action' => 'do_feed_atom', 'checkpoint_desc' => 'Atom feed'),
		array('checkpoint_action' => 'do_pings', 'checkpoint_desc' => 'Pings'),
		array('checkpoint_action' => 'admin_print_scripts', 'checkpoint_desc' => 'Print admin scripts'),
		array('checkpoint_action' => 'admin_print_footer_scripts', 'checkpoint_desc' => 'Print admin footer scripts'),
		array('checkpoint_action' => 'admin_print_styles', 'checkpoint_desc' => 'Print admin styles'),
		array('checkpoint_action' => 'pre_post_update', 'checkpoint_desc' => 'Pre-post update'),
		array('checkpoint_action' => 'publish_post', 'checkpoint_desc' => 'Publish post'),
		array('checkpoint_action' => 'future_post', 'checkpoint_desc' => 'Future post'),
		array('checkpoint_action' => 'future_page', 'checkpoint_desc' => 'Future page'),
		array('checkpoint_action' => 'save_post', 'checkpoint_desc' => 'Save post'),
		array('checkpoint_action' => 'template_redirect', 'checkpoint_desc' => 'Template redirect'),
		array('checkpoint_action' => 'edit_post', 'checkpoint_desc' => 'Edit post'),
		array('checkpoint_action' => 'edit_form_advanced', 'checkpoint_desc' => 'Edit form advanced'),
		array('checkpoint_action' => 'shutdown', 'checkpoint_desc' => 'Shutdown'),
		array('checkpoint_action' => 'loop_start', 'checkpoint_desc' => 'Start of WordPress loop'),
		array('checkpoint_action' => 'loop_end', 'checkpoint_desc' => 'End of WordPress loop'),
		array('checkpoint_action' => 'wp', 'checkpoint_desc' => 'Executed at startup by WP_Query::main()'),
	);
}

/**
 * Insert default checkpoints into the database.
 * 
 * @uses $wpdb WordPress Database Object
 * @uses tpcmem_get_default_checkpoints()
 * @return void
 */
function tpcmem_insert_default_checkpoints() {
	global $wpdb;
	
	// Insert default checkpoints
	$checkpoints = tpcmem_get_default_checkpoints();
	foreach ($checkpoints as $checkpoint) {
		$wpdb->insert(TPCMEM_DB_CHECKPOINTS, $checkpoint);
	}
}

function tpcmem_revert_to_default_checkpoints() {
	global $wpdb;
	
	$wpdb->query("DELETE FROM " . TPCMEM_DB_CHECKPOINTS);
	
	tpcmem_insert_default_checkpoints();
	
	tpcmem_clean_checkpoint_cache(0);
}

/**
 * @uses $tpcmem tpcmem
 * @param $data
 * @return unknown_type
 */
function tpcmem_checkpoint(Array $data) {
	global $tpcmem;
	
	$tpcmem->record($data);
	
	// Shutting down...
	if ($data['checkpoint_action'] == 'shutdown') {
		// Check if any new records were set
		$record = get_option('tpc_memory_usage_log_highest');
		
		if (!is_array($record))
			return false;
		
		$current = $tpcmem->scriptPeak();
		
		if ($current['usage'] > $record['usage'])
			update_option('tpc_memory_usage_log_highest', $current);
		
		// Check if notification e-mail is turned on
		$notify = get_option('tpc_memory_usage_email_high_usage');
		if (!$notify)
			return;
		
		// Send notification e-mail if memory limit exceeded
		$current_in_mb = tpcmem_bytes_to_mb($current['usage']);
		if ($current_in_mb > $notify)
			tpcmem_max_memory_notification(get_option('tpc_memory_usage_email_high_usage'), $current);
	}
}

function tpcmem_get_edit_checkpoint_link($checkpoint_id) {
	$checkpoint = tpcmem_get_checkpoint($checkpoint_id);
	
	$location = admin_url('admin.php?action=edit&amp;checkpoint_id=' . (int) $checkpoint->checkpoint_id . '&amp;page=tpcmem-checkpoint');
	return apply_filters('tpcmem_get_edit_checkpoint_link', $location);
}

/**
 * Deletes checkpoint cache.
 * 
 * @param int $checkpoint_id The checkpoint ID to clear cache for.
 * @return void
 */
function tpcmem_clean_checkpoint_cache($checkpoint_id) {
	wp_cache_delete($checkpoint_id, 'tpcmem-checkpoint');
	wp_cache_delete('tpcmem_get_checkpoints', 'tpcmem-checkpoint');
}