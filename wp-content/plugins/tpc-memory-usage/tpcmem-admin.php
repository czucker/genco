<?php
/**
 * TPC! Memory Usage Administration API
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */

if (!defined('ABSPATH'))
	die('-1');

function tpcmem_admin_init() {
	global $tpcmem;
	
	if (is_tpcmem_capable()) {
		add_action('wp_dashboard_setup', 'tpcmem_admin_dashboard');
		add_action('admin_footer_text', 'tpcmem_admin_footer');
	}
	
	add_filter('tpcmem_mb_suffix', 'tpcmem_bytes_to_mb');
	add_filter('tpcmem_mb_suffix', create_function('$a', '{return $a."M";}'));
	add_filter('tpcmem_percent_of_limit', 'tpcmem_bytes_to_mb');
	add_filter('tpcmem_percent_of_limit', 'tpcmem_get_percent_of_limit');
	
	register_setting('tpc_memory_usage', 'tpc_memory_usage_location');
	register_setting('tpc_memory_usage', 'tpc_memory_usage_graph');
	register_setting('tpc_memory_usage', 'tpc_memory_usage_admin_footer');
	register_setting('tpc_memory_usage', 'tpc_memory_usage_log');
	register_setting('tpc_memory_usage', 'tpc_memory_usage_allowed_users');
	
	if (isset($_GET['page'])) {
		switch ($_GET['page']) {
			case 'tpc-memory-usage':
				wp_enqueue_script('tpcmem-overview');
				
			case 'tpcmem-checkpoint':
				wp_enqueue_style('tpcmem');
				break;
			
			case 'tpcmem-checkpoint-manager':
				wp_enqueue_script('tpcmem');
				break;
			
			case 'tpcmem-reports':
				wp_enqueue_style('tpcmem');
				wp_enqueue_script('tpcmem-reports');
				break;
				
			default:
				break;
		}
	}
}

/**
 * Register TPC! Memory Usage admin menu items.
 * 
 * @uses add_menu_page()
 * @return void
 */
function tpcmem_admin_menu() {
	add_menu_page(__('TPC! Memory Usage'), __('Memory Usage'), 'level_8', TPCMEM_FOLDER, 'tpcmem_admin_page', '');
	tpcmem_add_page(__('System Overview'), __('System Overview'), 'level_8', TPCMEM_FOLDER, 'tpcmem_admin_page');
	tpcmem_add_page(__('Checkpoints'), __('Checkpoints'), 'level_8', 'tpcmem-checkpoint-manager', 'tpcmem_admin_page');
	tpcmem_add_page(__('Add Checkpoint'), __('Add Checkpoint'), 'level_8', 'tpcmem-checkpoint', 'tpcmem_admin_page');
	tpcmem_add_page(__('Reports'), __('Reports'), 'level_8', 'tpcmem-reports', 'tpcmem_admin_page');
	tpcmem_add_page(__('Memory Usage Settings'), __('Settings'), 'level_8', 'tpcmem-settings', 'tpcmem_admin_page');
}

/**
 * The bootstrap for loading TPC! Memory Usage admin pages.
 * 
 * @return void
 */
function tpcmem_admin_page() {
	global $title;
	
	$title = get_admin_page_title();
	
	switch ($_GET['page']) {
		case 'tpc-memory-usage':
			require_once('admin/overview.php');
			break;
		case 'tpcmem-checkpoint-manager':
			require_once('admin/checkpoint-manager.php');
			break;
		case 'tpcmem-checkpoint':
			require_once('admin/checkpoint.php');
			break;
		case 'tpcmem-reports':
			require_once('admin/reports.php');
			break;
		case 'tpcmem-settings':
			require_once('admin/settings.php');
			break;
		default:
			break;
	}
}

/**
 * Add a submenu item to the TPC! Memory Usage admin menu.
 * 
 * @param $page_title
 * @param $menu_title
 * @param $access_level
 * @param $file
 * @param $function
 * @return void
 */
function tpcmem_add_page($page_title, $menu_title, $access_level, $file, $function = '') {
	add_submenu_page(TPCMEM_FOLDER, $page_title, $menu_title, $access_level, $file, $function);
}

/**
 * Add the TPC! Memory Usage dashboard widget.
 * 
 * @uses wp_enqueue_style()
 * @uses wp_add_dashboard_widget()
 */
function tpcmem_admin_dashboard() {
	wp_enqueue_style('tpcmem');
	wp_add_dashboard_widget('tpc_memory_usage_dashboard', 'Memory Usage Overview', 'tpcmem_display_dashboard_widget');
}

/**
 * Retrieve MySQL global variables.
 * 
 * @return array|false
 */
function tpcmem_get_mysql_vars() {
	global $wpdb;
	
	if (!$results = $wpdb->get_results('SHOW GLOBAL VARIABLES'))
		return false;
	
	foreach ($results as $result) {
		$mysql_vars[$result->Variable_name] = $result->Value;
	}
	
	return $mysql_vars;
}

/**
 * Retrieve MySQL status variables.
 * 
 * @return array|false
 */
function tpcmem_get_mysql_status() {
	global $wpdb;
	
	if (!$results = $wpdb->get_results('SHOW GLOBAL STATUS'))
		return false;
	
	foreach ($results as $result) {
		$mysql_status[$result->Variable_name] = $result->Value;
	}
	
	return $mysql_status;
}

/**
 * Convert MySQL uptime value into string (x days, x hours, etc.)
 * 
 * @param int $uptime The uptime value.
 * @return string The uptime string.
 */
function tpcmem_get_mysql_uptime_string($uptime) {
	$uptime_seconds = $uptime % 60;
	$uptime_minutes = (int) (($uptime % 3600) / 60);
	$uptime_hours = (int) (($uptime % 86400) / 3600);
	$uptime_days = (int) ($uptime / 86400);
	
	if ($uptime_days > 0) {
		$uptime_string = "{$uptime_days} days, {$uptime_hours} hours, {$uptime_minutes} minutes, {$uptime_seconds} seconds";
	} elseif ($uptime_hours > 0) {
		$uptime_string = "{$uptime_hours} hours, {$uptime_minutes} minutes, {$uptime_seconds} seconds";
	} elseif ($uptime_minutes > 0) {
		$uptime_string = "{$uptime_minutes} minutes, {$uptime_seconds} seconds";
	} else {
		$uptime_string = "{$uptime_seconds} seconds";
	}
	
	return $uptime_string;
}
