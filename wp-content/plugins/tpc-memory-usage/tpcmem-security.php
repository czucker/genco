<?php
/**
 * TPC! Memory Usage Security API
 * 
 * @package TPC
 * @subpackage Security
 */

if (!defined('ABSPATH'))
	die('-1');

class tpcmem_security {
	/**
	 * Instance of TPC! Security object
	 * 
	 * @var tpcmem_security
	 */
	protected static $_instance = null;
	
	/**
	 * Holds results of security checks
	 * 
	 * @var array
	 */
	protected $_security = array();
	
	protected function __construct() {
		/**
		 * register_globals default setting changed from ON to OFF in
		 * PHP 4.2.0 and above.
		 */
		$this->_security['register_globals'] = ini_get('register_globals');
		$this->_security['safe_mode'] = ini_get('safe_mode');
		$this->_security['display_errors'] = ini_get('display_errors');
		$this->_security['mod_security'] = $this->checkModSecurity();
		$this->_security['magic_quotes_gpc'] = (int) get_magic_quotes_gpc();
		$this->_security['server_signature'] = isset($_SERVER['SERVER_SIGNATURE']) && trim($_SERVER['SERVER_SIGNATURE']) != '' ? true : false;
		$this->_security['allow_url_fopen'] = ini_get('allow_url_fopen');
		$this->_security['allow_url_include'] = ini_get('allow_url_include');
		$this->_security['open_basedir'] = (ini_get('open_basedir') && trim(ini_get('open_basedir')) != '') ? true : false;
	}
	
	/**
	 * Enforce singleton; disallow cloning
	 *
	 * @return void
	 */
	private function __clone() {
	}
	
	public function results() {
		return $this->_security;
	}
	
	/**
	 * Singleton instance
	 *
	 * @return tpcmem_security
	 */
	public function getInstance() {
		if (null === self::$_instance)
			self::$_instance = new self();
		
		return self::$_instance;
	}
	
	public function checkModSecurity() {
		if (function_exists('apache_get_modules')) {
			$apache_mods = apache_get_modules();
			$modSecurity = in_array('mod_security', $apache_mods) || in_array('mod_security2', $apache_mods) ? true : false;
			if (!$modSecurity && in_array('security2_module', $apache_mods))
				$modSecurity = 'N/A';
		} else {
			$modSecurity = 'N/A';
		}
		
		return $modSecurity;
	}
	
	/**
	 * Check if WP has random authentication keys defined.
	 * 
	 * @return bool True if unique authentication keys are defined, false if standard phrase is being used.
	 */
	public function checkUniqueKeys() {
		foreach (array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY') as $key) {
			if (defined($key)) {
				if ('put your unique phrase here' == constant($key))
					return false;
			} else {
				return false;
			}
		}
		
		return true;
	}
}

/**
 * Alias of tpcmem_security::results().
 * 
 * Retrieve results of security check.
 * 
 * @return array
 */
function tpcmem_check_security() {
	return tpcmem_security::getInstance()->results();
}

/**
 * Alias of tpcmem_security::checkUniqueKeys().
 * 
 * Check if WP has random authentication keys defined.
 * 
 * @return bool True if unique authentication keys are defined, false if standard phrase is being used.
 */
function tpcmem_check_unique_keys() {
	return tpcmem_security::getInstance()->checkUniqueKeys();
}