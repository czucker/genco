<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class rhl_email_filters {
	function rhl_email_filters(){
		add_filter('retrieve_password_title',array(&$this,'retrieve_password_title'),10,1);
		add_filter('retrieve_password_message',array(&$this,'retrieve_password_message'),10,2);
		
		add_filter('register_email_title',array(&$this,'register_email_title'),10,2);
		add_filter('register_email_content',array(&$this,'register_email_content'),10,3);
	}
	
	function register_email_title($title,$blogname){
		global $rhl_plugin;
		$str = $rhl_plugin->get_option('email_register_title','',true);
		if(''!=trim($str)){
			$title = str_replace('{blogname}',$blogname,$str);		
		}
		return $title;
	}
	
	function register_email_content($message,$user_login,$plaintext_pass){
		global $rhl_plugin,$wpdb;
		$str = $rhl_plugin->get_option('email_register_content','',true);
		if(''!=trim($str)){
			if( '1' == $rhl_plugin->get_option('email_register_is_html','1',true) ){
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			}
			$message = $str;
			$message = str_replace('{user_login}',$user_login,$message);
			$message = str_replace('{user_pass}',$plaintext_pass,$message);
			$message = str_replace('{url}', wp_login_url(), $message);
			if ( is_multisite() ){
				$blogname = $GLOBALS['current_site']->site_name;
			}else{
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			}
			$message = str_replace('{blogname}', $blogname, $message);
			$upload_dir = wp_upload_dir();					
			$dcurl = $upload_dir['baseurl'].'/'.$rhl_plugin->resources_path.'/';
			$message = str_replace('{dcurl}', $dcurl, $message);			
		}
		return $message;
	}
	
	function retrieve_password_title($title){
		global $rhl_plugin;
		$str = $rhl_plugin->get_option('email_rp_title','',true);
		if(''!=trim($str)){
			if ( is_multisite() ){
				$blogname = $GLOBALS['current_site']->site_name;
			}else{
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			}
			$title = str_replace('{blogname}',$blogname,$str);		
		}
		return $title;
	}
	
	function retrieve_password_message($message,$key){
		global $rhl_plugin,$wpdb;
		$str = $rhl_plugin->get_option('email_rp_content','',true);
		if(''!=trim($str)){
			if( '1' == $rhl_plugin->get_option('email_rp_is_html','1',true) ){		
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			}
			$message = $str;
			$user_login =  $wpdb->get_var($wpdb->prepare("SELECT user_login FROM $wpdb->users WHERE user_activation_key = %s", $key));
			$message = str_replace('{user_login}',$user_login,$message);
			
			$message = str_replace('{home}', network_home_url( '/' ), $message);
	
			//$url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
			$url = wp_login_url();
			$url = $rhl_plugin->addURLParameter($url, 'action', 'rp');
			$url = $rhl_plugin->addURLParameter($url, 'key', $key);
			$url = $rhl_plugin->addURLParameter($url, 'login', $user_login);
			$message = str_replace('{url}', $url, $message);
			
			$upload_dir = wp_upload_dir();					
			$dcurl = $upload_dir['baseurl'].'/'.$rhl_plugin->resources_path.'/';
			$message = str_replace('{dcurl}', $dcurl, $message);
		}
		return $message;
	}
}
?>