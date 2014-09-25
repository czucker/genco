<?php

/*
 * Plugin Name: Change Memory Limit
 * Description: Update the WordPress default memory limit. Never run into the dreaded "allowed memory size of 33554432 bytes exhausted" error again!
 * Version: 1.0
 * Author: Simon
 * Author URI: http://www.oiopublisher.com
 */
 

class change_mem_limit {

	var $min_limit = 32;
	var $install_limit = 64;

	var $error = null;
	var $page_name = 'change-mem';

	var $errors = array(
		'unable' => 'Oops, it looks like your default memory limit cannot be changed. Please speak to your web host about "changing the default php memory limit".',
		'minimum' => 'Please set the memory limit to at least %limit%Mb.',
	);

	function init() {
		//set limit
		$this->set_limit();
		//redirect user?
		if($redirect = get_option('change_mem_redirect')) {
			delete_option('change_mem_redirect');
			header("Location: " . $redirect);
			exit();
		}
		//activation hook
		register_activation_hook(__FILE__, array(&$this, 'admin_install'));
		//add menu hook
		add_action('admin_menu', array(&$this, 'admin_menu'));
		//add other hooks?
		if(isset($_GET['page']) && $_GET['page'] == $this->page_name) {
			add_action('admin_init', array(&$this, 'admin_logic'));
			add_action('admin_notices', array(&$this, 'admin_error'));
		}
	}

	function get_usage($decimal=2) {
		//set vars
		$usage = null;
		//get usage?
		if(function_exists('memory_get_usage')) {
			$usage = memory_get_usage();
			$usage = $usage / (1024 * 1024);
			$usage = number_format($usage, $decimal, '.', '');
		}
		//return
		return $usage;
		
	}

	function get_limit() {
		//set vars
		$limit = null;
		//get limit?
		if(function_exists('ini_get')) {
			$limit = (int) ini_get('memory_limit');
		}
		//return
		return $limit ? $limit : null;
	}

	function set_limit($limit=null) {
		//anything to process?
		if(!function_exists('ini_set')) {
			$this->error = $this->errors['unable'];
			return;
		}
		//set vars
		$old = $this->get_limit();
		$limit = (int) $limit ? $limit : get_option('change_mem_limit');
		$is_admin = (bool) (isset($_GET['page']) && $_GET['page'] == $this->page_name);
		//update limit?
		if($limit > 0 && $old != $limit && ($is_admin || $limit > $old)) {
			//change setting
			@ini_set('memory_limit', $limit . 'M');
			//check new limit
			$new = $this->get_limit();
			//did it work?
			if(!$new || $new == $old) {
				$this->error = $this->errors['unable'];
			}
		}
	}

	function admin_install() {
		//set initial limit?
		if(!get_option('change_mem_limit')) {
			$limit = defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : 32;
			$limit = $limit > $this->install_limit ? $limit : $this->install_limit;
			update_option('change_mem_limit', $limit);
		}
		//set redirect url
		update_option('change_mem_redirect', 'options-general.php?page=' . $this->page_name);
	}

	function admin_logic() {
		//update limit?
		if(isset($_POST['process']) && $_POST['process'] == $this->page_name) {
			//get limit
			$limit = (int) $_POST['mem_limit'];
			//valid update?
			if($limit < $this->min_limit) {
				$this->error = str_replace('%limit%', $this->min_limit, $this->errors['minimum']);
				return;
			}
			//update options
			update_option('change_mem_limit', $limit);
			//set & check limit
			$this->set_limit($limit);
		}
	}

	function admin_error() {
		if($this->error) {
			echo '<div class="error"><p>' . $this->error . '</p></div>';
		}
	}

	function admin_menu() {
		//add to 'options' submenu
		add_options_page('Memory limit', 'Memory limit', 'manage_options', $this->page_name, array(&$this, 'admin_page'));
	}

	function admin_page() {
		//display form
		echo '<div class="wrap">' . "\n";
		echo '<h2>Change memory limit</h2>' . "\n";
		echo '<p>The default WordPress memory limit is sometimes not enough, especially if you have a lot of plugins installed. This plugin allows you to increase the memory limit without editing any WordPress files.</p>' . "\n";
		echo '<form method="post" action="options-general.php?page=' . $this->page_name . '">' . "\n";
		echo '<input type="hidden" name="process" value="' . $this->page_name . '" />' . "\n";
		echo '<br />' . "\n";
		echo '<p><b>Your WordPress memory limit is currently set at:</b> <input type="text" name="mem_limit" size="10" value="' . get_option('change_mem_limit') . '" /> MB &nbsp; <input type="submit" value="Update" /></p>' . "\n";
		echo '<br />' . "\n";
		echo '<p>Your memory usage is approximately ' . ($this->get_usage() ? $this->get_usage(1) . 'MB' : 'unknown') . '.</p>' . "\n";
		echo '</form>' . "\n";
		echo '</div>' . "\n";
	}

}

//load it!
$change_mem = new change_mem_limit();
$change_mem->init();