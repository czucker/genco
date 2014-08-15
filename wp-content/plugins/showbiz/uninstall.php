<?php 
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
	exit();

$currentFile = __FILE__;
$currentFolder = dirname($currentFile);
require_once $currentFolder . '/inc_php/showbiz_globals.class.php';
	
global $wpdb;
$tableSliders = $wpdb->prefix . GlobalsShowBiz::TABLE_SLIDERS_NAME;
$tableSlides = $wpdb->prefix . GlobalsShowBiz::TABLE_SLIDES_NAME;
$tableTemplates = $wpdb->prefix . GlobalsShowBiz::TABLE_TEMPLATES_NAME;
$tableSettings = $wpdb->prefix . GlobalsShowBiz::TABLE_SETTINGS_NAME;

$wpdb->query( "DROP TABLE $tableSliders" );
$wpdb->query( "DROP TABLE $tableSlides" );
$wpdb->query( "DROP TABLE $tableTemplates" );
$wpdb->query( "DROP TABLE $tableSettings" );


delete_option('showbiz-latest-version');
delete_option('showbiz-update-check-short');
delete_option('showbiz-update-check');
delete_option('showbiz_update_info');
delete_option('showbiz-api-key');
delete_option('showbiz-username');
delete_option('showbiz-code');
delete_option('showbiz-valid');
?>