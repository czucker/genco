<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhl_rewrite_frontend {
	var $rhl_rewrite_enabled = false;
	function rhl_rewrite_frontend(){
		global $rhl_plugin;
		require_once RHL_PATH.'includes/pluggable.php';
		if('1'==get_option('rhl_rewrite_enabled')){
			if( isset($_REQUEST['skip_modal_login']) && $_REQUEST['skip_modal_login']==$rhl_plugin->get_option('panic_key','',true)){
				
			}else{
				$this->rhl_rewrite_enabled = true;
			}		
		}
		
		if( !$this->rhl_rewrite_enabled && '1'==$rhl_plugin->get_option('enable_rhl_admin_rewrite','',true)){
			$this->check_rules_manually_added();//checked if rules have been added
		}
		
		if( $this->rhl_rewrite_enabled ){	
			//this filter should be always active as soon as rewrite rules are in place, or ajaxurl will not work.
			add_filter('admin_url',array(&$this,'admin_url'),10,3);
			
			//replace wp-login.php
			foreach(array('site_url','logout_url','login_url','lostpassword_url','register') as $filter){
				add_filter($filter,array(&$this,'replace_login'),10,1);
			}
		}
	}
	
	function replace_login($url){
		global $rhl_plugin;
		$rewrite_login = $rhl_plugin->get_option('rewrite_login','',true);
		if(''!=$rewrite_login){
			return str_replace('/wp-login.php', sprintf('/%s',$rewrite_login) ,$url);
		} 
		return $url;
	}
	
	function admin_url($url,$path,$blog_id){
		global $rhl_plugin;
		$rewrite_admin = $rhl_plugin->get_option('rewrite_admin','',true);
		if(''!=$rewrite_admin){
			return str_replace('/wp-admin', sprintf('/%s',$rewrite_admin) ,$url);
		} 
		return $url;
	}
	
	function check_rules_manually_added(){
	
	}	
}
?>