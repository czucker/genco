<?php
/**
 * Plugin Name: ClearCode Shortcode Library
 * Plugin URI: http://wordpress.org/plugins/cngann-shortcodes/
 * Description: Shortcodes used by ClearCode in their WordPress sites.
 * Version: 4.0
 * Author: mflynn, cngann, Clear_Code, bmcswee
 * Author URI: http://clearcode.info
 * License: GPL2
 */
	// Get Correct File Location

	$___FILE___ = __FILE__;
	if ( isset( $plugin ) ) $___FILE___ = $plugin;
	else if ( isset( $mu_plugin ) ) $___FILE___ = $mu_plugin;
	else if ( isset( $network_plugin ) ) $___FILE___ = $network_plugin;
	define( '___FILE___', $___FILE___ );
	$___DIR___ = dirname(___FILE___);
	define( '___DIR___', $___DIR___);

	require "CNGann.class.php";

	$cngann = new CNGann;

	global $cng_db_version;
	$cng_db_version = "1.2";

	function cng_install() {
		global $wpdb;
		global $cng_db_version;
		$installed_ver = get_option( "cng_db_version" );
		if( $installed_ver != $cng_db_version ) {
			$table_name = $wpdb->prefix . "cngann_email_form";

			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
				name text NOT NULL,
				company text NOT NULL,
				email text NOT NULL,
				phone text NOT NULL,
				comments longtext NOT NULL,
				subscribe tinyint(1),
				PRIMARY KEY id (id)
			 );";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			add_option( "cng_db_version", $cng_db_version );
		}
	}

	function cng_forwarder(){
		if(!isset($_GET["redirect"])) return false;
		$r = str_replace('|',"#",$_GET["redirect"]);
		if(!headers_sent()) {
			header("Location:" . $r, true, 301);
			exit;
		}
		else{
			echo "<script>window.location={$r};</script>";
			exit;
		}
	}

	add_action( 'plugins_loaded', 'cng_forwarder' );

	function cng_install_data() {
		global $wpdb;
		$table_name = $wpdb->prefix . "cngann_email_form";
		$rows_affected = $wpdb->insert( $table_name, array( 'name' => "Test User", 'company' => "ABC I.N.C.", 'email' => "test@abcinc.com", 'phone' => '5555551234',  'comments' => "This is but a test of what is to come.", 'subscribe' => 0 ) );
	}

	register_activation_hook( __FILE__, 'cng_install' );
	register_activation_hook( __FILE__, 'cng_install_data' );

	function cng_update_db_check() {
	    global $cng_db_version;
	    if (get_site_option( 'cng_db_version' ) != $cng_db_version) {
		cng_install();
	    }
	}
	add_action( 'plugins_loaded', 'cng_update_db_check' );