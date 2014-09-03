<?php
/**
 * Manage checkpoint administration actions
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */

if (!defined('ABSPATH'))
	die('-1');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch ($action) {
	case 'edit':
		$checkpoint_id = (int) $_GET['checkpoint_id'];
		
		if (!$checkpoint = tpcmem_get_checkpoint($checkpoint_id))
			wp_die(__('Checkpoint not found.'));
		
		include('edit-checkpoint-form.php');
		break;
	
	default:
		$checkpoint = tpcmem_get_default_checkpoint_to_edit();
		
		include('edit-checkpoint-form.php');
		break;

}
