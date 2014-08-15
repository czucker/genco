<?php

/**
Plugin Name: Modal Log In for WordPress
Plugin URI: http://plugins.righthere.com/modal-login/
Description: Modal Login for WordPress provides you with an alternative to the default WordPress Login based on Twitter Boostrap. Rewrite of .htaccess block wp-admin and wp-login.php and set alternative login URL.
Version: 1.3.9 rev49747
Author: Alberto Lau (RightHere LLC)
Author URI: http://plugins.righthere.com
 **/

define('RHL_VERSION','1.3.9');
define('RHL_ADMIN_ROLE','administrator');
define('RHL_PATH', plugin_dir_path(__FILE__) );
define("RHL_URL", plugin_dir_url(__FILE__) );
define("RHL_SLUG", plugin_basename( __FILE__ ) );
define ('RH_SOCIAL_LOGIN_BASE_PATH', dirname (plugin_basename (__FILE__)));
define ('RH_SOCIAL_LOGIN_VERSION', '3.7');

load_plugin_textdomain('rhl', null, dirname( plugin_basename( __FILE__ ) ).'/languages' );

if(!class_exists('plugin_modal_login')){
	require_once RHL_PATH.'includes/class.plugin_modal_login.php';
}

global $rhl_plugin;
$settings = array();
$settings['options_capability']='modal_login_settings';
//$settings['modal_login_shortcode']='modal_login_button';//default
$settings['development']=true;

$rhl_plugin = new plugin_modal_login($settings);

//-- plugin addon: rewrite module
if(!class_exists('rhl_rewrite_frontend')){
	require_once RHL_PATH.'includes/class.rhl_rewrite_frontend.php';
}
new rhl_rewrite_frontend();
//---------------

//--- support for email templates
if('1'!=$rhl_plugin->get_option('disable_wp_new_user_notification','',true)){
	require_once RHL_PATH.'includes/pluggable_wp_new_user_notification.php';
}


//-- Installation script:---------------------------------
function rhl_install(){
	$WP_Roles = new WP_Roles();
	foreach(array(
		'modal_login_settings'
		) as $cap){
		$WP_Roles->add_cap( RHL_ADMIN_ROLE, $cap );
	}
	//---
}
register_activation_hook(__FILE__, 'rhl_install');
//--------------------------------------------------------
function rhl_uninstall(){
	$WP_Roles = new WP_Roles();
	foreach(array(
		'modal_login_settings'
		) as $cap){
		$WP_Roles->remove_cap( RHL_ADMIN_ROLE, $cap );
	}
	//----- disable admin rewrite
	global $rhl_plugin;
	if( '1'==$rhl_plugin->get_option('enable_rhl_admin_rewrite','',true) ){
		update_option('rhl_rewrite_enabled','0');
		//--- remove from htaccess
		$filename = get_home_path() . '.htaccess';
		if(file_exists($filename)){
			insert_with_markers( $filename, 'RHL', array());
		}
	}
	//------ remove auto update notification
	delete_site_transient('update_plugins');
}
register_deactivation_hook( __FILE__, 'rhl_uninstall' );
//--------------------------------------------------------
?>
