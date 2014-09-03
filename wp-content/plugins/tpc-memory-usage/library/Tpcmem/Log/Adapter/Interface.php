<?php
/**
 * TPC! Memory Usage Adapter Interface for Logger
 * 
 * @package TPC_Memory_Usage
 * @subpackage Core
 */

if (!defined('ABSPATH'))
	die('-1');

/**
 * @package Tpcmem
 * @subpackage Tpcmem_Log
 */
interface Tpcmem_Log_Adapter_Interface {
	public function log(array $event, $priority);
}