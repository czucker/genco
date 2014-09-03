<?php
/**
 * TPC! Memory Usage File Adapter for Logger
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
class Tpcmem_Log_Adapter_File implements Tpcmem_Log_Adapter_Interface {
	/**
	 * Zend_Log object reference
	 * 
	 * @var string
	 */
	protected $_log = null;
	
	public function __construct($logFile) {
		/** Zend_Log */
		require_once 'Zend/Log.php';
		
		/** Zend_Log_Writer_Stream */
		require_once 'Zend/Log/Writer/Stream.php';
		
		$this->_log = new Zend_Log(new Zend_Log_Writer_Stream($logFile));
	}
	
	public function log(Array $event, $priority) {
		switch ($priority) {
			case Tpcmem_Log::LOG_INFO:
				$message = tpcmem_bytes_to_mb($event['usage']) . "M {$event['checkpoint_action']}";
				break;
			case Tpcmem_Log::LOG_CRIT:
				$message = "Memory usage exceeded {$event['threshold']}M ({$event['usage']}M)";
				break;
		}
		
		$this->_log->log($message, $priority);
		return $this;
	}
}