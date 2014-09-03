<?php
/**
 * TPC! Memory Usage MySQL Database Adapter for Logger
 * 
 * @package TPC_Memory_Usage
 * @subpackage Core
 */

if (!defined('ABSPATH'))
	die('-1');

/** Tpcmem_Log_Adapter_Interface */
require_once 'Tpcmem/Log/Adapter/Interface.php';

/**
 * @package Tpcmem
 * @subpackage Tpcmem_Log
 */
class Tpcmem_Log_Adapter_Mysql implements Tpcmem_Log_Adapter_Interface {
	/**
	 * Database object reference
	 * 
	 * @var wpdb
	 */
	private $_db = null;
	
	/**
	 * Name of the log table in the database
	 * 
	 * @var string
	 */
	private $_table;
	
	/**
	 * Constructor
	 * 
	 * @param wpdb $db
	 * @param string $table
	 * @param array $columnMap
	 */
	public function __construct($db, $table) {
		$this->_db = $db;
		$this->_table = $table;
	}
	
	public function log(Array $event, $priority) {
		if (null === $this->_db) {
			require_once 'Tpcmem/Log/Exception.php';
			throw new Tpcmem_Log_Exception('Database adapter is null');
		}
		
		$event = array_merge(array(
			'checkpoint_action' => 'unknown',
			'time' => 0,
			'usage' => 0,
			'priority' => $priority,
			'threshold' => ''
		), $event);
		
		if (!$event['time'])
			$event['time'] = time();
		$event['time'] = date('Y-m-d H:i:s', $event['time']);
		
		// Make sure 'checkpoint_desc' is not set, otherwise query will not work (@todo maybe use column map?)
		unset($event['checkpoint_desc']);
		
		// Usage not set, no point in logging this
		if (!$event['usage'])
			return false;
		
		$this->_db->insert($this->_table, $event);
		
		return $this;
	}
}