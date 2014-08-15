<?php

/**
 * Admin User List: Add header column
 **/
function rh_social_login_admin_user_column_add ($columns)
{
	//Read settings
	$settings = get_option ('rhl_options');

	//Add column if enabled
	if (!empty ($settings['plugin_add_column_user_list']))
	{
		$columns['rh_social_login_registration'] = __ ('Registration', 'rh_social_login');
	}
	return $columns;
}
add_filter ('manage_users_columns', 'rh_social_login_admin_user_column_add');


/**
 * Admin User List: Add column content
 **/
function rh_social_login_admin_user_colum_display ($value, $column_name, $user_id)
{
	//Check if it is our column
	if ($column_name <> 'rh_social_login_registration')
	{
		return $value;
	}

	//Read Identity Provider
	$identity_providers = get_user_meta ($user_id, 'rh_social_login_identity_provider');

	//Tradition Registration
	if (!is_array ($identity_providers) OR count ($identity_providers) < 1)
	{
		return __ ('Registration Form', 'rh_social_login');
	}
	else
	{
		return '<strong>Social Network</strong>: ' . implode (", ", $identity_providers);
	}
}

add_action ('manage_users_custom_column', 'rh_social_login_admin_user_colum_display', 10, 3);



/**
 * Add administration area links
 **/
function rh_social_login_admin_menu ()
{

	add_action ('admin_enqueue_scripts', 'rh_social_login_admin_js');
	add_action ('admin_init', 'rh_register_social_login_settings');
	add_action ('admin_notices', 'rh_social_login_admin_message');
}
add_action ('admin_menu', 'rh_social_login_admin_menu');


/**
 * Automatically approve comments if option enabled
 **/
function rh_social_login_admin_pre_comment_approved ($approved)
{
	// No need to do the check if the comment has already been approved
	if (empty ($approved))
	{
		//Read settings
		$settings = get_option ('rhl_options');

		//Check if enabled
		if (!empty ($settings['plugin_comment_auto_approve']))
		{
			$user_id = get_current_user_id ();
			if (is_numeric ($user_id))
			{
				if (get_user_meta ($user_id, 'rh_social_login_user_token', true) !== false)
				{
					$approved = 1;
				}
			}
		}
	}
	return $approved;
}
add_action ('pre_comment_approved', 'rh_social_login_admin_pre_comment_approved');


/**
 * Add an activation message to be displayed once
 */
function rh_social_login_admin_message ()
{
	if (get_option ('rh_social_login_activation_message') !== '1')
	{
		echo '<div class="updated"><p><strong>' . __ ('Thank you for using the RightHere Modal Login for WordPress.', 'rh_social_login') . '</strong> ' . sprintf (__ ('Please go to the <strong><a href="%s">Modal Login - Options</a></strong> page to setup the plugin.', 'rh_social_login'), 'admin.php?page=rhl') . '</p></div>';
		update_option ('rh_social_login_activation_message', '1');
	}
}


/**
 * Autodetect API Connection Handler
 */
function rh_social_login_admin_autodetect_api_connection_handler ()
{
	//Check AJAX Nonce
	check_ajax_referer ('rh_social_login_ajax_nonce');

	//Check CURL HTTPS - Port 443
	if (rh_social_login_check_curl (true) === true)
	{
		echo 'success_autodetect_api_curl_https';
		die ();
	}
	//Check CURL HTTP - Port 80
	elseif (rh_social_login_check_curl (false) === true)
	{
		echo 'success_autodetect_api_curl_http';
		die ();
	}
	//Check FSOCKOPEN HTTPS - Port 443
	elseif (rh_social_login_check_fsockopen (true) == true)
	{
		echo 'success_autodetect_api_fsockopen_https';
		die ();
	}
	//Check FSOCKOPEN HTTP - Port 80
	elseif (rh_social_login_check_fsockopen (false) == true)
	{
		echo 'success_autodetect_api_fsockopen_http';
		die ();
	}

	//No working handler found
	echo 'error_autodetect_api_no_handler';
	die ();
}
add_action ('wp_ajax_autodetect_api_connection_handler', 'rh_social_login_admin_autodetect_api_connection_handler');


// /**
//  * Check API Settings through an Ajax Call
//  */
function check_api_settings ()
{

	check_ajax_referer ('rh_social_login_ajax_nonce');

	//Check if all fields have been filled out
	if (empty ($_POST['api_subdomain']) OR empty ($_POST['api_key']) OR empty ($_POST['api_secret']))
	{
		echo 'error_not_all_fields_filled_out';
		delete_option ('rh_social_login_api_settings_verified');
		die ();
	}

	//Check the handler
	$api_connection_handler = 'curl'; //((!empty ($_POST['api_connection_handler']) AND $_POST['api_connection_handler'] == 'fsockopen') ? 'fsockopen' : 'curl');
	$api_connection_use_https = true; //((!isset ($_POST['api_connection_use_https']) OR $_POST['api_connection_use_https'] == '1') ? true : false);


	//FSOCKOPEN
	if ($api_connection_handler == 'fsockopen')
	{
		if (!rh_social_login_check_fsockopen ($api_connection_use_https))
		{
			echo 'error_selected_handler_faulty';
			delete_option ('rh_social_login_api_settings_verified');
			die ();
		}
	}
	//CURL
	else
	{
		if (!rh_social_login_check_curl ($api_connection_use_https))
		{
			echo 'error_selected_handler_faulty';
			delete_option ('rh_social_login_api_settings_verified');
			die ();
		}
	}

	$api_subdomain = trim (strtolower ($_POST['api_subdomain']));
	$api_key = trim ($_POST['api_key']);
	$api_secret = trim ($_POST['api_secret']);

	//Full domain entered
	if (preg_match ("/([a-z0-9\-]+)\.api\.oneall\.com/i", $api_subdomain, $matches))
	{
		$api_subdomain = $matches[1];
	}

	//Check subdomain format
	if (!preg_match ("/^[a-z0-9\-]+$/i", $api_subdomain))
	{
		echo 'error_subdomain_wrong_syntax';
		delete_option ('rh_social_login_api_settings_verified');
		die ();
	}

	//Domain
	$api_domain = $api_subdomain . '.api.oneall.com';

	//Connection to
	$api_resource_url = ($api_connection_use_https ? 'https' : 'http').'://' . $api_domain . '/tools/ping.json';

	//Get connection details
	$result = rh_social_login_do_api_request ($api_connection_handler, $api_resource_url, array ('api_key' => $api_key, 'api_secret' => $api_secret), 15);

	//Parse result
	if (is_object ($result) AND property_exists ($result, 'http_code') AND property_exists ($result, 'http_data'))
	{
		switch ($result->http_code)
		{
			//Success
			case 200:
				echo 'success';
				update_option ('rh_social_login_api_settings_verified', '1');
			break;

			//Authentication Error
			case 401:
				echo 'error_authentication_credentials_wrong';
				delete_option ('rh_social_login_api_settings_verified');
			break;

			//Wrong Subdomain
			case 404:
				echo 'error_subdomain_wrong';
				delete_option ('rh_social_login_api_settings_verified');
			break;

			//Other error
			default:
				echo 'error_communication';
				delete_option ('rh_social_login_api_settings_verified');
			break;
		}
	}
	else
	{
		echo 'error_communication';
		delete_option ('rh_social_login_api_settings_verified');
	}
	die ();
}
add_action ('wp_ajax_check_api_settings',  'check_api_settings');


// /**
//  * Add Settings JS
//  **/
function rh_social_login_admin_js ($hook)
{
	// if (stripos ($hook, 'rh_social_login') !== false)
	if (stripos ($hook, 'rhl-social-media-setup') !== false)
	{

		// if (!wp_script_is ('rh_social_login_admin_js', 'registered'))
		// {
		// 	wp_register_script ('rhl-social-login-script', RHL_URL . "js/social_login_script.js");
		// }

		$rh_social_login_ajax_nonce = wp_create_nonce ('rh_social_login_ajax_nonce');

		// wp_enqueue_script ('rhl-social-login-script');
		// wp_enqueue_script ('jquery');
		wp_enqueue_script ('rhl-scrpts');
		//wp_enqueue_script ('jquery');

	 	wp_localize_script ('rhl-scripts', 'objectL10n',
		array (
			'rh_social_login_ajax_nonce' => $rh_social_login_ajax_nonce,
			'rh_admin_js_1' => __ ('Contacting API - please wait this may take a few minutes ...', 'rh_social_login'),
			'rh_admin_js_101' => __ ('The settings are correct - do not forget to save your changes!', 'rh_social_login'),
			'rh_admin_js_111' => __ ('Please fill out each of the fields above.', 'rh_social_login'),
			'rh_admin_js_112' => __ ('The subdomain does not exist. Have you filled it out correctly?', 'rh_social_login'),
			'rh_admin_js_113' => __ ('The subdomain has a wrong syntax!', 'rh_social_login'),
			'rh_admin_js_114' => __ ('Could not contact API. Are outbound requests on port 443 allowed?', 'rh_social_login'),
			'rh_admin_js_115' => __ ('The API subdomain is correct, but one or both keys are invalid', 'rh_social_login'),
			'rh_admin_js_116' => __ ('Connection handler does not work, try using the Autodetection', 'rh_social_login'),
			'rh_admin_js_201a' => __ ('Detected CURL on Port 443 - do not forget to save your changes!', 'rh_social_login'),
			'rh_admin_js_201b' => __ ('Detected CURL on Port 80 - do not forget to save your changes!', 'rh_social_login'),
			'rh_admin_js_202a' => __ ('Detected FSOCKOPEN on Port 443 - do not forget to save your changes!', 'rh_social_login'),
			'rh_admin_js_202b' => __ ('Detected FSOCKOPEN on Port 80 - do not forget to save your changes!', 'rh_social_login'),
			'rh_admin_js_211' => sprintf (__ ('Autodetection Error - our <a href="%s" target="_blank">documentation</a> helps you fix this issue.', 'rh_social_login'), 'http://docs.oneall.com/plugins/guide/social-login-wordpress/#help')
		));
	}
}
add_action ('admin_enqueue_scripts', 'rh_social_login_admin_js');

/**
 * Add Settings CSS
 **/
function rh_social_login_admin_css ($hook = '')
{
	if (!wp_style_is ('rh_social_login_admin_css', 'registered'))
	{
		wp_register_style ('rh_social_login_admin_css', RHL_URL . "/css/social_login_admin.css");
	}

	if (did_action ('wp_print_styles'))
	{
		wp_print_styles ('rh_social_login_admin_css');
	}
	else
	{
		wp_enqueue_style ('rh_social_login_admin_css');
	}
}


/**
 * Register plugin settings and their sanitization callback
 */
function rh_register_social_login_settings ()
{
	register_setting ('rh_social_login_settings_group', 'rh_social_login_settings', 'rh_social_login_settings_validate');
}


/**
 *  Plugin settings sanitization callback
 */
function rh_social_login_settings_validate ($settings)
{ //echo ' in rh_social_login_settings_validate line 342 admin.php ';
	//Import providers
	GLOBAL $rh_social_login_providers;

	//Settings page?
	$page = (!empty ($_POST['page']) ? strtolower ($_POST['page']) : '');

	//Store the sanitzed settings
	$sanitzed_settings = get_option ('rhl_options');

	//Check format
	if (!is_array ($sanitzed_settings))
	{
		$sanitzed_settings = array ();
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Setup
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//if ($page == 'setup')
	//{

		//Extract fields
		foreach (array ('api_connection_handler', 'api_connection_use_https', 'api_subdomain', 'api_key', 'api_secret', 'providers') AS $key)
		{
			//Value is given
			if (isset ($settings[$key]))
			{
				//Provider tickboxes
				if ($key == 'providers')
				{
					//Resest providers
					$sanitzed_settings['providers'] = array ();

					//Loop through new values
					if (is_array ($settings['providers']))
					{
						//Loop through valid values
						foreach ($rh_social_login_providers AS $key => $name)
						{
							if (isset ($settings['providers'][$key]) AND $settings['providers'][$key] == '1')
							{
								$sanitzed_settings['providers'][$key] = 1;
							}
						}
					}
				}
				//Other field
				else
				{
					$sanitzed_settings[$key] = trim ($settings[$key]);
				}
			}
		}
		//Sanitize API Use HTTPS
		$sanitzed_settings['api_connection_use_https'] = (empty ($sanitzed_settings['api_connection_use_https']) ? 0 : 1);

		//Sanitize API Connection handler
		if (isset ($sanitzed_settings['api_connection_handler']) AND in_array (strtolower ($sanitzed_settings['api_connection_handler']), array ('curl', 'fsockopen')))
		{
			$sanitzed_settings['api_connection_handler'] = strtolower ($sanitzed_settings['api_connection_handler']);
		}
		else
		{
			$sanitzed_settings['api_connection_handler'] = 'curl';
		}

		//Sanitize API Subdomain
		if (isset ($sanitzed_settings['api_subdomain']))
		{
			//Subdomain is always in lowercase
			$api_subdomain = strtolower ($sanitzed_settings['api_subdomain']);

			//Full domain entered
			if (preg_match ("/([a-z0-9\-]+)\.api\.oneall\.com/i", $api_subdomain, $matches))
			{
				$api_subdomain = $matches[1];
			}

			$sanitzed_settings['api_subdomain'] = $api_subdomain;
		}

		//Done
		return $sanitzed_settings;
	//}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//Setup
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//elseif ($page == 'settings')
	//{
		//Extract fields
		foreach (array (
			'plugin_add_column_user_list',
			'plugin_require_email',
			'plugin_require_email_text',
			'plugin_caption',
			'plugin_link_verified_accounts',
			'plugin_show_avatars_in_comments',
			'plugin_use_small_buttons',
			'plugin_display_in_login_form',
			'plugin_login_form_redirect',
			'plugin_login_form_redirect_custom_url',
			'plugin_display_in_registration_form',
			'plugin_registration_form_redirect',
			'plugin_registration_form_redirect_custom_url',
			'plugin_comment_show_if_members_only',
			'plugin_comment_auto_approve',
			'plugin_comment_show',
			'plugin_shortcode_login_redirect',
			'plugin_shortcode_login_redirect_url',
			'plugin_shortcode_register_redirect',
			'plugin_shortcode_register_redirect_url',
			'plugin_notify_admin'
		) AS $key)
		{
			if (isset ($settings[$key]))
			{
				$sanitzed_settings[$key] = trim ($settings[$key]);
			}
		}

		//Flag settings
		$sanitzed_settings['plugin_add_column_user_list'] == ((isset ($sanitzed_settings['plugin_add_column_user_list']) AND $sanitzed_settings['plugin_add_column_user_list'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_notify_admin'] == ((isset ($sanitzed_settings['plugin_notify_admin']) AND $sanitzed_settings['plugin_notify_admin'] == '0') ? 0 : 1);
		$sanitzed_settings['plugin_require_email'] == ((isset ($sanitzed_settings['plugin_require_email']) AND $sanitzed_settings['plugin_require_email'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_comment_show'] == ((isset ($sanitzed_settings['plugin_comment_show']) AND $sanitzed_settings['plugin_comment_show'] == '0') ? 0 : 1);
		$sanitzed_settings['plugin_use_small_buttons'] == ((isset ($sanitzed_settings['plugin_use_small_buttons']) AND $sanitzed_settings['plugin_use_small_buttons'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_show_avatars_in_comments'] == ((isset ($sanitzed_settings['plugin_show_avatars_in_comments']) AND $sanitzed_settings['plugin_show_avatars_in_comments'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_link_verified_accounts'] == ((isset ($sanitzed_settings['plugin_link_verified_accounts']) AND $sanitzed_settings['plugin_link_verified_accounts'] == '0') ? 0 : 1);
		$sanitzed_settings['plugin_login_form_redirect'] = ((isset ($sanitzed_settings['plugin_login_form_redirect']) AND in_array ($sanitzed_settings['plugin_login_form_redirect'], array ('dashboard', 'homepage', 'custom'))) ? $sanitzed_settings['plugin_login_form_redirect'] : 'homepage');
		$sanitzed_settings['plugin_registration_form_redirect'] = ((isset ($sanitzed_settings['plugin_registration_form_redirect']) AND in_array ($sanitzed_settings['plugin_registration_form_redirect'], array ('dashboard', 'homepage','custom'))) ? $sanitzed_settings['plugin_registration_form_redirect'] : 'dashboard');
		$sanitzed_settings['plugin_display_in_login_form'] == ((isset ($sanitzed_settings['plugin_display_in_login_form']) AND $sanitzed_settings['plugin_display_in_login_form'] == '0') ? 0 : 1);
		$sanitzed_settings['plugin_comment_show_if_members_only'] == ((isset ($sanitzed_settings['plugin_comment_show_if_members_only']) AND $sanitzed_settings['plugin_comment_show_if_members_only'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_comment_auto_approve'] == ((isset ($sanitzed_settings['plugin_comment_auto_approve']) AND $sanitzed_settings['plugin_comment_auto_approve'] == '1') ? 1 : 0);
		$sanitzed_settings['plugin_shortcode_login_redirect'] = ((isset ($sanitzed_settings['plugin_shortcode_login_redirect']) AND in_array ($sanitzed_settings['plugin_shortcode_login_redirect'], array ('current', 'dashboard', 'homepage', 'custom'))) ? $sanitzed_settings['plugin_shortcode_login_redirect'] : 'current');
		$sanitzed_settings['plugin_shortcode_register_redirect'] = ((isset ($sanitzed_settings['plugin_shortcode_register_redirect']) AND in_array ($sanitzed_settings['plugin_shortcode_register_redirect'], array ('current', 'dashboard', 'homepage', 'custom'))) ? $sanitzed_settings['plugin_shortcode_register_redirect'] : 'current');

		//Check Widget & Shortcode Login Redirection Settings
		if ($sanitzed_settings['plugin_shortcode_login_redirect'] == 'custom')
		{
			if (empty ($sanitzed_settings['plugin_shortcode_login_redirect_url']))
			{
				$sanitzed_settings['plugin_shortcode_login_redirect'] = 'current';
			}
		}
		else
		{
			$sanitzed_settings['plugin_shortcode_login_redirect_url'] = '';
		}

		//Check Widget & Shortcode Registration Redirection Settings
		if ($sanitzed_settings['plugin_shortcode_register_redirect'] == 'custom')
		{
			if (empty ($sanitzed_settings['plugin_shortcode_register_redirect_url']))
			{
				$sanitzed_settings['plugin_shortcode_register_redirect'] = 'current';
			}
		}
		else
		{
			$sanitzed_settings['plugin_shortcode_register_redirect_url'] = '';
		}

		//Check Login Redirection Settings
		if ($sanitzed_settings['plugin_login_form_redirect'] == 'custom')
		{
			if (empty ($sanitzed_settings['plugin_login_form_redirect_custom_url']))
			{
				$sanitzed_settings['plugin_login_form_redirect'] = 'homepage';
			}
		}
		else
		{
			$sanitzed_settings['plugin_login_form_redirect_custom_url'] = '';
		}


		//Check Registration Redirection Settings
		if ($sanitzed_settings['plugin_registration_form_redirect'] == 'custom')
		{
			if (empty ($sanitzed_settings['plugin_registration_form_redirect_custom_url']))
			{
				$sanitzed_settings['plugin_registration_form_redirect'] = 'dashboard';
			}
		}
		else
		{
			$sanitzed_settings['plugin_registration_form_redirect_custom_url'] = '';
		}

		//Done
		return $sanitzed_settings;
	//}

	//Error
	return array ();
}




