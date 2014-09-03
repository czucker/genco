<?php
/**
 * TPC! Memory Usage Log Class
 * 
 * @package TPC_Memory_Usage
 * @subpackage Core
 */

if (!defined('ABSPATH'))
	die('-1');

/**
 * This class uses dependency injection to avoid tight coupling between object.  
 * Developers can easily add a custom logging class by implementing the 
 * Tpcmem_Log_Adapter_Interface class. Uses principles set forth by the Zend 
 * Framework coding conventions, and can easily be used for any ZF project.
 * 
 * @package Tpcmem
 * @subpackage Tpcmem_Log
 */
class Tpcmem_Log {
	/**
	 * Instance of TPC! Memory Usage logger object
	 * 
	 * @var Tpcmem_Log
	 */
	protected static $_instance = null;
	
	/**
	 * Options for logging
	 * 
	 * @var array
	 */
	protected $_options = array(
		'log_enabled'	=> false,
		'log_mode'		=> null
	);
	
	/**
	 * Memory usage log levels
	 * 
	 * @var int
	 */
	const LOG_CRIT = 2;
	const LOG_INFO = 6;
	
	/**
	 * Memory usage variable
	 * 
	 * @var array
	 */
	protected $_usageData = array();
	
	/**
	 * Last recorded memory usage
	 * 
	 * @var int
	 */
	protected $_lastRecorded = null;
	
	/**
	 * Peak memory usage for current script
	 * 
	 * @var array
	 */
	protected $_peakMemoryUsage = null;
	
	/**
	 * The object that handles writing to log file, database, etc.
	 * 
	 * @var Tpcmem_Log_Adapter_Interface
	 */
	protected $_log = null;
	
	/**
	 * Whether or not threshold was logged
	 * 
	 * @var bool
	 */
	protected $_thresholdLogged = false;
	
	/**
	 * Constructor
	 * 
	 * Instantiate using {@link getInstance()}; tpcmem is a
	 * singleton object.
	 * 
	 * @return void
	 */
	protected function __construct() {
	}
	
	/**
	 * Inject the log adapter (file-based, database, etc.).
	 * 
	 * @param Tpcmem_Log_Adapter_Interface
	 * @return Tpcmem_Log
	 */
	public function setLogger(Tpcmem_Log_Adapter_Interface $adapter, $options = array()) {
		$this->_log = $adapter;
		
		if (!is_array($options)) {
			require_once 'Tpcmem/Log/Exception.php';
			throw new Tpcmem_Log_Exception('Options passed were not an array');
		}
		
		$this->setOption('log_enabled', true);
		// Check if log mode is set, otherwise default to checkpoints only
		if (isset($options['log_mode']) && in_array($options['log_mode'], array_keys($this->getLogModes()))) {
			$this->setOption('log_mode', $options['log_mode']);
		} else {
			$this->setOption('log_mode', 'checkpoints_only');
		}
		
		return $this;
	}
	
	/**
	 * Log a message at the specified priority.
	 * 
	 * @param string $message
	 * @param int $priority
	 * @throws Tpcmem_Log_Exception
	 * @return void
	 */
	protected function _log($message, $priority) {
		if (!$this->_options['log_enabled']) {
			return;
		}
		
		if (!(isset($this->_options['log_enabled']) || $this->_log instanceof Tpcmem_Log_Adapter_Interface)) {
			require_once 'Tpcmem/Log/Exception.php';
			throw new Tpcmem_Log_Exception('Logging is enabled, but logger is not set');
		}
		
		// Default to checkpoints only if 'log_mode' is not set, or invalid
		if (!in_array($this->_options['log_mode'], array_keys($this->getLogModes()))) {
			$this->setOption('log_mode', 'checkpoints_only');
		}
		
		switch ($priority) {
			case Tpcmem_Log::LOG_CRIT:
				$logLevels = array('always', 'threshold');
				break;
			case Tpcmem_Log::LOG_INFO:
				$logLevels = array('always', 'checkpoints_only');
				break;
			default:
				$logLevels = array();
				break;
		}
		
		if (!in_array($this->_options['log_mode'], $logLevels))
			return;
		
		$this->_log->log($message, $priority);
	}
	
	/**
	 * Set the specified option.
	 *
	 * @param string $name Name of the option
	 * @param mixed $value Value of the option
	 * @throws Tpcmem_Log_Exception
	 * @return void
	 */
	public function setOption($name, $value) {
		if (!is_string($name)) {
			require_once 'Tpcmem/Log/Exception.php';
			throw new Tpcmem_Log_Exception("Incorrect option name : $name");
		}
		
		$name = strtolower($name);
		if (array_key_exists($name, $this->_options)) {
			$this->_setOption($name, $value);
			return;
		}
	}
	
	private function _setOption($name, $value) {
		if (!is_string($name) || !array_key_exists($name, $this->_options)) {
			require_once 'Tpcmem/Log/Exception.php';
			throw new Tpcmem_Log_Exception("Incorrect option name : $name");
		}
		
		$this->_options[$name] = $value;
	}
	
	public function getOption($name) {
		if (is_string($name)) {
			$name = strtolower($name);
			if (array_key_exists($name, $this->_options)) {
				return $this->_options[$name];
			}
		}
		
		require_once 'Tpcmem/Log/Exception.php';
		throw new Tpcmem_Log_Exception("Incorrect option name : $name");
	}
	
	/**
	 * Enforce singleton; disallow cloning
	 *
	 * @return void
	 */
	private function __clone() {
	}
	
	/**
	 * Singleton instance
	 *
	 * @return tpcmem
	 */
	public function getInstance($options = null) {
		if (null === self::$_instance)
			self::$_instance = new self($options);
		
		return self::$_instance;
	}
	
	/**
	 * Record memory usage.
	 * 
	 * @param array $data Contains checkpoint action/hook, description, time(), and the memory usage in bytes.
	 * @return array $data
	 */
	public function record(Array $data) {
		if (!function_exists('memory_get_usage'))
			return false;
		
		if (!isset($data['checkpoint_action']))
			$data['checkpoint_action'] = 'unknown';
		
		if (!isset($data['checkpoint_desc']))
			$data['checkpoint_desc'] = 'Unknown';
		
		if (!isset($data['time']))
			$data['time'] = time();
		
		if (!isset($data['usage']))
			$data['usage'] = $this->current();
		
		// Log memory usage data
		$this->_usageData[] = $data;
		
		// Log to file if enabled
		$this->_log($data, Tpcmem_Log::LOG_INFO);
		
		if (!is_array($this->_peakMemoryUsage) || $this->_peakMemoryUsage['usage'] < $data['usage'])
			$this->_peakMemoryUsage = $data;

		return $data;
	}
	
	/**
	 * Retrieve the number of times memory usage has been recorded.
	 *
	 * @return int|false Number of times memory usage has been recorded, or false on failure.
	 */
	public function count() {
		if (!is_array($this->_usageData))
			return false;
		
		$count = count($this->_usageData);
		
		return $count;
	}
	
	/**
	 * Returns the amount of memory allocated to PHP.
	 *
	 * @param bool Optional. Defaults to false. Set this to TRUE to get the real size of memory allocated from the system. If not set or FALSE only the memory used by emalloc() is reported.
	 * @return int The amount of memory, in bytes, that's been allocated to this PHP script.
	 */
	public function current($realUsage = false) {
		if (!function_exists('memory_get_usage'))
			return false;
		
		$usage = memory_get_usage($realUsage);
		
		return $usage;
	}
	
	/**
	 * Returns the peak of memory allocated by PHP.
	 * 
	 * @param bool Optional. Defaults to false. Set this to TRUE to get the real size of memory allocated from the system. If not set or FALSE only the memory used by emalloc() is reported.
	 * @return int The peak of memory, in bytes, that's been allocated to this PHP script.
	 */
	public function peak($realUsage = false) {
		if (!function_exists('memory_get_peak_usage'))
			return false;
		
		$usage = memory_get_peak_usage($realUsage);
		
		return $usage;
	}
	
	/**
	 * Retrieve the peak memory usage for the current script.
	 * 
	 * @return array|null
	 */
	public function scriptPeak() {
		return $this->_peakMemoryUsage;
	}
	
	/**
	 * Retrieves PHP memory limit from 'memory_limit' php.ini directive.
	 * 
	 * @return string The PHP memory limit
	 */
	public function phpLimit() {
		return @get_cfg_var('memory_limit');
	}
	
	/**
	 * Log the exceeded memory usage threshold, if logging is on.
	 * 
	 * @param int $threshold The memory usage threshold.
	 * @param int $usage The memory usage.
	 * @return bool Returns true if logged, false otherwise.
	 */
	public function thresholdExceeded($threshold, $usage) {
		if ($this->_thresholdLogged)
			return false;
		
		$usage['threshold'] = $threshold;
		
		$this->_log($usage, Tpcmem_Log::LOG_CRIT);
		$this->_thresholdLogged = true;
		
		return true;
	}
	
	public function getLogModes() {
		return array(
			'always' => 'Always',
			'checkpoints_only' => 'At checkpoints',
			'threshold' => 'Usage exceeds threshold',
			'0' => 'Off'
		);
	}
}