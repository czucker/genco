<?php
/**
 * TPC! Memory Usage Logger API
 * 
 * @package TPC_Memory_Usage
 * @subpackage Logger
 */

if (!defined('ABSPATH'))
	die('-1');

function tpcmem_get_usage_record($record, $output = OBJECT) {
	global $wpdb;
	
	if (is_object($record)) {
		wp_cache_add($record->id, $record, 'tpcmem-log');
		$_record = $record;
	} else {
		if (!$_record = wp_cache_get($record, 'tpcmem-log')) {
			if (!$_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . TPCMEM_DB_LOG . " WHERE id = %d LIMIT 1", $record)))
				return false;
			wp_cache_add($_record->id, $_record, 'tpcmem-log');
		}
	}
	
	return tpcmem_db($_record, $output);
}

function tpcmem_get_usage_records($args = '') {
	global $wpdb;
	
	$defaults = array(
		'orderby' => 'time', 'order' => 'DESC',
		'checkpoint_action' => '', 'search' => '',
		'limit' => -1
	);
	
	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);
	
	$cache = array();
	$key = md5(serialize($r));
	if ($cache = wp_cache_get('tpcmem_get_usage_records', 'tpcmem-log')) {
		if (is_array($cache) && isset($cache[$key]))
			return apply_filters('tpcmem_get_usage_records', $cache[$key], $r);
	}
	
	if (!is_array($cache))
		$cache = array();
	
	$inclusions = '';
	if (!empty($checkpoint_action)) {
		$inclusions .= $wpdb->prepare(" AND checkpoint_action = %s", $checkpoint_action);
	}
	
	if (!empty($search)) {
		$search = like_escape($search);
		$search = " AND checkpoint_action LIKE '%{$checkpoint_action}%'";
	}
	
	$orderby = strtolower($orderby);
	
	$query = "SELECT * FROM " . TPCMEM_DB_LOG . " WHERE 1=1 $inclusions $search";
	$query .= " ORDER BY $orderby $order";
	if ($limit != -1)
		$query .= " LIMIT $limit";
	
	$results = $wpdb->get_results($query);
	
	$cache[$key] = $results;
	wp_cache_set('tpcmem_get_usage_records', $cache, 'tpcmem-log');
	
	return apply_filters('tpcmem_get_usage_records', $results, $r);
}

function tpcmem_delete_usage_record($id) {
	global $wpdb;
	
	do_action('tpcmem_delete_usage_record');
	
	$wpdb->query($wpdb->prepare("DELETE FROM " . TPCMEM_DB_LOG . " WHERE id = %d", $id));
	
	do_action('tpcmem_deleted_usage_record');
	
	return true;
}

/**
 * Deletes memory usage log cache.
 * 
 * @param int $id Usage record ID.
 * @return void
 */
function clean_usage_record_cache($id) {
	wp_cache_delete($id, 'tpcmem-log');
	wp_cache_delete('tpcmem_get_usage_records', 'tpcmem-log');
}

/**
 * Retrieve unique checkpoint_actions from log table.
 * 
 * @return array
 */
function tpcmem_get_distinct_logged_checkpoints() {
	global $wpdb;
	
	if (!$actions = wp_cache_get('tpcmem_get_distinct_checkpoint_actions', 'tpcmem-log')) {
		if (!$actions = $wpdb->get_col('SELECT DISTINCT checkpoint_action FROM ' . TPCMEM_DB_LOG . ' ORDER BY checkpoint_action ASC'))
			return false;
		wp_cache_add('tpcmem_get_distinct_checkpoint_actions', $actions, 'tpcmem-log');
	}
	
	return $actions;
}