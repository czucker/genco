<?php
/**
 * TPC! Memory Usage Formatting API
 * 
 * @package TPC_Memory_Usage
 * @subpackage Formatting
 */

if (!defined('ABSPATH'))
	die('-1');

/**
 * Converts bytes to megabytes.
 * 
 * @param int The number of bytes.
 * @return int The number of megabytes.
 */
function tpcmem_bytes_to_mb($value) {
	if (!$value)
		return 0;
	
	$value = round( $value / 1024 / 1024, 2 );
	
	return $value;
}

/**
 * Make percent using two specified values or memory limit if $value2 is not specified.
 * 
 * @param int $value1 Memory usage (peak or otherwise for our purposes).
 * @param int $value2 Memory limit. If not set, defaults to runtime memory limit.
 * @param string $suffix Defaults to nothing. Example $suffix is '%'.
 * @return string|int Formatted percentage string or value.
 */
function tpcmem_get_percent_of_limit($value1, $value2 = false, $suffix = false) {
	global $tpcmem;
	
	if (!$value2)
		$value2 = @ini_get('memory_limit');
	
	if ($value2 <= 0)
		return 0;
	
	$value = round($value1 / $value2 * 100, 0);
	
	if ($suffix)
		return $value . $suffix;
	
	return $value;
}