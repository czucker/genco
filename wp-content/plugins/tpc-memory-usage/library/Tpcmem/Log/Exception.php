<?php
/**
 * TPC! Memory Usage Exception for Logger
 * 
 * @package TPC_Memory_Usage
 * @subpackage Core
 */

if (!defined('ABSPATH'))
	die('-1');

/** Zend_Exception */
require_once 'Zend/Exception.php';

/**
 * @package Tpcmem
 * @subpackage Tpcmem_Log
 */
class Tpcmem_Log_Exception extends Zend_Exception {
}