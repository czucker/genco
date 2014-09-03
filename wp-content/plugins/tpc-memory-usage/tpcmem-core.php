<?php
/**
 * TPC! Memory Usage Core API
 * 
 * @package TPC_Memory_Usage
 * @subpackage Core
 */

if (!defined('ABSPATH'))
	die('-1');

/**
 * Initialize TPC! Memory Usage.
 * 
 * @global tpcmem $tpcmem
 * @return void
 */
function tpcmem_init() {
	global $tpcmem, $wpdb;
	
	/**
	 * Create new 'tpcmem' instance
	 * 
	 * @var Tpcmem
	 */
	require_once 'Tpcmem/Log.php';
	$tpcmem = Tpcmem_Log::getInstance();
	
	if (defined('TPCMEM_LOGGING') && (bool) TPCMEM_LOGGING) {
		if (defined('TPCMEM_LOGGING_TYPE')) {
			switch (TPCMEM_LOGGING_TYPE) {
				case 'file':
					/** Tpcmem_Log_Adapter_File */
					require_once 'Tpcmem/Log/Adapter/File.php';
					$logAdapter = new Tpcmem_Log_Adapter_File(TPCMEM_LOG);
					break;
				
				case 'db':
					/** Tpcmem_Log_Adapter_Mysql */
					require_once 'Tpcmem/Log/Adapter/Mysql.php';
					$logAdapter = new Tpcmem_Log_Adapter_Mysql($wpdb, TPCMEM_DB_LOG);
					break;
				
				default:
					break;
			}
			
			if ($logAdapter instanceof Tpcmem_Log_Adapter_Interface) {
				$tpcmem->setLogger($logAdapter, array(
					'log_enabled' => true,
					'log_mode'	  => TPCMEM_LOGGING
				));
			}
		}
	}
	
	$tpcmem->record(array(
		'checkpoint_action' => 'tpcmem::getInstance()',
		'checkpoint_desc' => 'Started tpcmem'
	));
	
	tpcmem_register_checkpoints();
	
	// If comment display is turned on, show HTML comments in proper location on page
	if (is_tpcmem_comments_on()) {
		switch (get_option('tpc_memory_usage_location')) {
			case 'header':
				add_action('wp_header', 'tpcmem_display_comments');
				add_action('admin_head', 'tpcmem_display_comments');
				break;
			
			case 'footer':
				add_action('wp_footer', 'tpcmem_display_comments');
				add_action('admin_footer', 'tpcmem_display_comments');
				break;
			
			default:
				// Don't display HTML comments
				break;
		}
	}
}

/**
 * Activate TPC! Memory Usage plugin.
 * 
 * Creates checkpoints table, and adds options.
 * 
 * @since 0.7
 * @return void
 */
function tpcmem_activate() {
	global $wpdb;
	
	// Default keys and options
	add_option('tpc_memory_usage_location', 'footer');
	add_option('tpc_memory_usage_graph', 'peak');
	add_option('tpc_memory_usage_admin_footer', true);
	add_option('tpc_memory_usage_log', 'high');
	add_option('tpc_memory_usage_log_highest', get_default_tpcmem_log_to_edit());
	add_option('tpc_memory_usage_allowed_users', 'admin');
	add_option('tpc_memory_usage_email_high_usage', 32);
	add_option('tpc_memory_usage_email_recipients', '');
	add_option('tpc_memory_usage_logging', false);
	add_option('tpc_memory_usage_logging_type', 'file');
	
	/**
	 * Check if hooks table has already been created
	 * 
	 * @since 0.7
	 */
	if ($wpdb->get_var("SHOW TABLES LIKE '" . TPCMEM_DB_CHECKPOINTS . "'") != TPCMEM_DB_CHECKPOINTS) {
		$sql = "CREATE TABLE " . TPCMEM_DB_CHECKPOINTS . " ("
			 . " checkpoint_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
			 . " checkpoint_action VARCHAR(50) NOT NULL,"
			 . " checkpoint_desc TEXT NOT NULL"
			 . ");";
		$wpdb->query($sql);
		
		tpcmem_insert_default_checkpoints();
	}
	
	/**
	 * Check if log table has already been created
	 * 
	 * @since 0.9
	 */
	if ($wpdb->get_var("SHOW TABLES LIKE '" . TPCMEM_DB_LOG . "'") != TPCMEM_DB_LOG) {
		$sql = "CREATE TABLE `" . TPCMEM_DB_LOG . "` ("
			 . " `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,"
			 . " `checkpoint_action` VARCHAR(50) NOT NULL,"
			 . " `time` DATETIME NOT NULL,"
			 . " `usage` INT UNSIGNED NOT NULL,"
			 . " `priority` TINYINT UNSIGNED NOT NULL,"
			 . " `threshold` SMALLINT UNSIGNED NULL DEFAULT NULL"
			 . ");";
		$wpdb->query($sql);
	}
}

function tpcmem_deactivate() {
	// Does nothing at the moment.
}

/**
 * Send high memory usage e-mail notification.
 * 
 * @param float $memoryExceeded Memory usage threshold.
 * @param float $memoryUsage Peak memory usage.
 * @return void
 */
function tpcmem_max_memory_notification($memoryExceeded, $memoryUsage) {
	global $tpcmem;
	
	$tpcmem->thresholdExceeded($memoryExceeded, $memoryUsage);
	
	$subject  = sprintf( __('[%1$s] High memory usage notification'), get_option('blogname') );
	$message  = sprintf( __('WordPress memory usage exceeded %1$s MB'), $memoryExceeded ) . "\r\n";
	$message .= sprintf( __('WordPress peak memory usage: %1$s MB'), tpcmem_bytes_to_mb($memoryUsage['usage']) ) . "\r\n";
	$message .= sprintf( __('Number of database queries: %1$s'), get_num_queries() ) . "\r\n";
	
	// Get recipients, otherwise default back to WP admin e-mail address
	$send_to = get_option('tpc_memory_usage_email_recipients');
	if (!$send_to || trim($send_to) == '')
		$send_to = get_option('admin_email');

	return @wp_mail( get_option('admin_email'), $subject, $message );
}

/**
 * Whether or not the current user is allowed to view memory usage information.
 * 
 * @return bool True if allowed, false otherwise.
 */
function is_tpcmem_capable() {
	$allowed = get_option('tpc_memory_usage_allowed_users');
	if ('all' == $allowed || ($allowed == 'admin' && current_user_can('manage_options')))
		return true;
	return false;
}

function is_tpcmem_enabled() {
	if ('off' == get_option('tpc_memory_usage_allowed_users'))
		return true;
	return false;
}

function is_tpcmem_comments_on() {
	if ('none' == get_option('tpc_memory_usage_location'))
		return false;
	return true;
}

/**
 * Check if logging is enabled.
 * 
 * @global Tpcmem_Log $tpcmem
 * @return bool True if logging is enabled, false if disabled.
 */
function is_tpcmem_logging_enabled() {
	global $tpcmem;
	if ($tpcmem->getOption('log_enabled'))
		return true;
	return false;
}

/**
 * Retrieve the default value for the dashboard graph (peak or current).
 * 
 * @return int Either peak or current memory usage in bytes.
 */
function tpcmem_graph_peak_or_current() {
	global $tpcmem;
	
	if ('peak' == get_option('tpc_memory_usage_graph')) {
		$mem = $tpcmem->peak();
	} else {
		$mem = $tpcmem->current();
	}
	
	return $mem;
}

/**
 * Return database results in desired format.
 * 
 * @param object $results
 * @param string $output
 * @return mixed Depends on $output value.
 */
function tpcmem_db($results, $output) {
	if ( $output == OBJECT ) {
		return $results;
	} elseif ( $output == ARRAY_A ) {
		return get_object_vars($results);
	} elseif ( $output == ARRAY_N ) {
		return array_values(get_object_vars($results));
	} else {
		return $results;
	}
}