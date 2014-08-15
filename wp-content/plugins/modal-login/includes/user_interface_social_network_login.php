<?php

/**
 * Include the Social Library
 */
function rh_social_login_add_javascripts ()
{
	//if(get_option('enable_social_network_login') == 1){

		if (!wp_script_is ('rh_social_library', 'registered'))
		{
			//Read settings
			$settings = get_option ('rhl_options');

			if (!empty ($settings ['api_subdomain']))
			{
				//Include in header, without having the version appended
				// wp_register_script ("rh_social_library", ((rh_social_login_https_on () ? 'https' : 'http') . '://' . $settings ['api_subdomain'] . '.api.oneall.com/socialize/library.js'), array (), null, false);
				// wp_register_script ("rh_social_library", 'https://' . $settings ['api_subdomain'] . '.api.oneall.com/socialize/library.js', array (), null, false);
				wp_register_script ("rh_social_library", '//' . $settings ['api_subdomain'] . '.api.oneall.com/socialize/library.js', array (), null, false);
			}
		}
		if(wp_script_is ('rh_social_library', 'registered'))wp_print_scripts ('rh_social_library');
	//}
}
add_action ('login_head', 'rh_social_login_add_javascripts');
add_action ('wp_head', 'rh_social_login_add_javascripts');


/**
 * Setup Shortcode handler
 */
function rh_social_login_shortcode_handler ($args)
{
	return (is_user_logged_in () ? '' : rh_social_login_render_login_form ('shortcode'));
}
add_shortcode ('rh_social_login', 'rh_social_login_shortcode_handler');


/**
 * Hook to display custom avatars (Buddypress specific)
 */
function rh_social_login_bp_custom_fetch_avatar($text, $args)
{
	//The social login settings
	static $rhl_options = null;
	if (is_null ($rhl_options))
	{
		$rhl_options = get_option ('rhl_options');
	}

	//Check if avatars are enabled
	if (isset ($rhl_options ['plugin_show_avatars_in_comments']) AND $rhl_options ['plugin_show_avatars_in_comments'] == '1')
	{
		//Check arguments
		if (is_array ($args))
		{
			//User Object
			if (! empty ($args['object']) AND strtolower ($args['object']) == 'user')
			{
				//User Identifier
				if (! empty ($args['item_id']) AND is_numeric ($args['item_id']))
				{
					//Retrieve user
					if (($user_data = get_userdata( $args['item_id'] )) !== false)
					{
						//Retrieve Avatar
						if (($user_thumbnail = get_user_meta ($args['item_id'], 'rh_social_login_user_thumbnail', true)) !== false)
						{
							//Thumbnail retrieved
							if (strlen (trim ($user_thumbnail)) > 0)
							{
								//Build Image tags
								$img_alt = (! empty ($args['alt']) ? 'alt="'.rh_social_login_esc_attr($args['alt']).'" ' : '');
								$img_alt = sprintf($img_alt, htmlspecialchars($user_data->user_login));

								$img_class = ('class="'.(! empty ($args['class']) ? ($args['class'].' ') : '').'avatar-social-login" ');
								$img_width = (! empty ($args['width']) ? 'width="'.$args['width'].'" ' : '');
								$img_height = (! empty ($args['height']) ? 'height="'.$args['height'].'" ' : '');

								//Replace
								$text = preg_replace('#<img[^>]+>#i', '<img data-social-login="bp-d1" src="'.$user_thumbnail.'" '.$img_alt.$img_class.$img_height.$img_width.'/>', $text);
							}
						}
					}
				}
			}
		}
	}
	return $text;
}
add_filter('bp_core_fetch_avatar', 'rh_social_login_bp_custom_fetch_avatar', 10, 2);


/**
 * Hook to display custom avatars
 */
function rh_social_login_custom_avatar ($avatar, $mixed, $size, $default, $alt = '')
{
	//The social login settings
	static $rhl_options = null;
	if (is_null ($rhl_options))
	{
		$rhl_options = get_option ('rhl_options');
	}

	//Check if we are in a comment
	if (isset ($rhl_options ['plugin_show_avatars_in_comments']) AND $rhl_options ['plugin_show_avatars_in_comments'] == '1')
	{
		//Current comment
		global $comment;

		//Chosen user
		$user_id = null;

		//Detection
		$detection = 0;

		//Check if we are in a comment
		if (is_object ($comment) AND property_exists ($comment, 'user_id') AND !empty ($comment->user_id))
		{
			$detection = 1;
			$user_id = $comment->user_id;
		}
		//Check if we have an user identifier
		elseif (is_numeric($mixed))
		{
			if ($mixed > 0)
			{
				$detection = 2;
				$user_id = $mixed;
			}
		}
		//Check if we have an email
		elseif (is_string($mixed) && ($user = get_user_by( 'email', $mixed)))
		{
			$detection = 3;
			$user_id = $user->ID;
		}
		//Check if we have an user object
		else if(is_object($mixed))
		{
			if (property_exists ($mixed, 'user_id') AND is_numeric ($mixed->user_id))
			{
				$detection = 4;
				$user_id = $mixed->user_id;
			}
		}

		//User found?
		if ( ! empty ($user_id))
		{
			if (($user_thumbnail = get_user_meta ($user_id, 'rh_social_login_user_thumbnail', true)) !== false)
			{
				if (strlen (trim ($user_thumbnail)) > 0)
				{
					return '<img alt="'. rh_social_login_esc_attr($alt) .'" src="'.$user_thumbnail.'" data-social-login="wp-d'.$detection.'" class="avatar avatar-social-login avatar-'.$size.' photo" height="'.$size.'" width="'.$size.'" />';
				}
			}
		}
	}

	//Default
	return $avatar;
}
add_filter ('get_avatar', 'rh_social_login_custom_avatar', 10, 5);


/**
 * Show Social Login below "you must be logged in ..."
 */
function rh_social_login_filter_comment_form_defaults($default_fields)
{
	//No need to go further if comments disabled or user loggedin
	if (is_array ($default_fields) AND comments_open () AND !is_user_logged_in ())
	{
		//Read settings
		$settings = get_option ('rhl_options');

		//Display buttons if option not set or disabled
		if ( ! empty($settings['plugin_comment_show_if_members_only']))
		{
			if ( ! isset ($default_fields['must_log_in']))
			{
				$default_fields['must_log_in'] = '';
			}
			$default_fields['must_log_in'] .=  rh_social_login_render_login_form ('comments');
		}
	}
	return $default_fields;
}
add_filter('comment_form_defaults', 'rh_social_login_filter_comment_form_defaults');


/**
 * Display the provider grid for comments
 */
function rh_social_login_render_login_form_comments ()
{
	//Comments are open and the user is not logged in
	if (comments_open () && !is_user_logged_in ())
	{
		//Read settings
		$settings = get_option ('rhl_options');

		//Display buttons if option not set or not disabled
		if (!isset ($settings ['plugin_comment_show']) OR ! empty ($settings ['plugin_comment_show']))
		{
			echo rh_social_login_render_login_form ('comments');
		}
	}
}
//WordPress Comments
add_action ('comment_form_top', 'rh_social_login_render_login_form_comments');

//Appthemes Thesis Theme Comments
add_action ('thesis_hook_comment_form_top', 'rh_social_login_render_login_form_comments');


/**
 * Display the provider grid for registration
 */
function rh_social_login_render_login_form_registration ()
{
	//Users may register
	if (get_option ('users_can_register') === '1')
	{
		//Read settings
		$settings = get_option ('rhl_options');

		//Display buttons if option not set or enabled
		if (!isset ($settings ['plugin_display_in_registration_form']) OR ! empty ($settings ['plugin_display_in_registration_form']))
		{
			echo rh_social_login_render_login_form ('registration');
		}
	}
}
//WordPress Registration
add_action ('register_form', 'rh_social_login_render_login_form_registration');

//BuddyPress Registration
add_action ('bp_before_account_details_fields', 'rh_social_login_render_login_form_registration');


/**
 * Display the provider grid for login
 */
function rh_social_login_render_login_form_login ()
{
	//Read settings
	$settings = get_option ('rhl_options');

	//Display buttons only if option not set or enabled
	// if (!isset ($settings ['plugin_display_in_login_form']) OR $settings ['plugin_display_in_login_form'] == '1')
	if (!isset ($settings ['enable_social_network_login']) OR $settings ['enable_social_network_login'] == '1')
	{
		echo rh_social_login_render_login_form ('login');
	}
}
//WordPress Registration
add_action ('login_form', 'rh_social_login_render_login_form_login');

//WordPress Profile Builder
add_action ('wppb_before_login', 'rh_social_login_render_login_form_login');

//BuddyPress Sidebar
add_action ('bp_before_sidebar_login_form', 'rh_social_login_render_login_form_login');

//Appthemes Vantage Theme
add_action ('va_after_admin_bar_login_form', 'rh_social_login_render_login_form_login');


/**
 * Display a custom grid for login
 */
function rh_social_login_render_custom_form_login ()
{
	if (!is_user_logged_in ())
	{
		echo rh_social_login_render_login_form ('custom');
	}
}
add_action ('rh_social_login', 'rh_social_login_render_custom_form_login');


/**
 * Alternative for custom forms, where the output is not necessarily required at the place of calling
 * $rh_social_login_form = apply_filters('rh_social_login_custom', '');
 */
function rh_social_login_filter_login_form_custom ($value = 'custom')
{
	return (is_user_logged_in () ? '' : rh_social_login_render_login_form ($value));
}
add_filter ('rh_social_login_custom', 'rh_social_login_filter_login_form_custom');


/**
 * Display the provider grid
 */
function rh_social_login_render_login_form ($source, $args = array())
{
	//Import providers
	GLOBAL $rh_social_login_providers;

	//Container for returned value
	$output = '';

	//Read settings
	$settings = get_option ('rhl_options');

	//API Subdomain
	$api_subdomain = (!empty ($settings ['api_subdomain']) ? $settings ['api_subdomain'] : '');

	//API Subdomain Required
	if (!empty ($api_subdomain))
	{
		//Build providers
		$providers = array ();
		if (is_array ($settings ['providers']))
		{
			foreach ($settings ['providers'] AS $settings_provider_key => $settings_provider_name)
			{
				//if (isset ($rh_social_login_providers [$settings_provider_key]))
				//{
					$providers [] = $settings_provider_name; //$settings_provider_key;
				//}
			}
		}

		//Themes are served from the CDN
		$theme_uri_prefix = (rh_social_login_https_on () ? 'https://secure.oneallcdn.com' : 'http://public.oneallcdn.com');

		//Themes
		$css_theme_uri_small = $theme_uri_prefix . '/css/api/socialize/themes/wordpress/small.css';
		$css_theme_uri_default = $theme_uri_prefix . '/css/api/socialize/themes/wordpress/default.css';

		//Widget
		if ($source == 'widget')
		{
			//Read widget settings
			$widget_settings = (is_array ($args) ? $args : array ());

			//Don't show the title - this is handled insided the widget
			$plugin_caption = '';

			//Buttons size
			$css_theme_uri = ((array_key_exists ('widget_use_small_buttons', $widget_settings) AND !empty ($widget_settings ['widget_use_small_buttons'])) ? $css_theme_uri_small : $css_theme_uri_default);

			//Custom CSS
			$css_theme_uri = apply_filters('rh_social_login_widget_css', $css_theme_uri);
		}
		//Other places
		else
		{
			//Show title if set
			$plugin_caption = (!empty ($settings ['plugin_caption']) ? $settings ['plugin_caption'] : '');

			//Buttons size
			$css_theme_uri = (!empty ($settings ['plugin_use_small_buttons']) ? $css_theme_uri_small : $css_theme_uri_default);
			//echo 'css theme uri before ';print_r($css_theme_uri);echo'<br/>';
			//Custom CSS
			$css_theme_uri = apply_filters('rh_social_login_default_css', $css_theme_uri);

			$pos = strrpos($settings['main_template'], 'modal_login');

			 if(!empty($settings['main_template']) && ($settings['main_template']) && ($pos === FALSE)){
				//if(('modal_form_buttons_left.php' == $settings['main_template']) || ('modal_form_buttons_right.php' == $settings['main_template'])){
			// 		$css_theme_uri = RHL_URL . 'css/buttons_left.css';
				//} else if('modal_form_buttons_only.php' == $settings['main_template']){
			// 		$css_theme_uri = RHL_URL . 'css/buttons_only.css';
			// 	}
			// }

				$icon_style = $settings['icon_styles'];
				if(0 == $icon_style){
					$css_file = 'css/style_1_large_buttons.css';
				} else if(1 == $icon_style){
					$css_file = 'css/style_1_med_buttons.css';
				} else if(2 == $icon_style){
					$css_file = 'css/style_1_small_buttons.css';
				} else if(3 == $icon_style){
					$css_file = 'css/style_2_buttons.css';
				} else if(4 == $icon_style){
					$css_file = 'css/style_3_buttons.css';
				}


				$css_theme_uri = RHL_URL . $css_file;
				//echo 'uri = ' . $css_theme_uri;
			//}
		 	}
		}

		$settings = get_option('rhl_options');
		//No providers selected
		if (count ($providers) == 0)
		{	//$settings = get_option('rhl_options');


			if($settings['enable_social_network_login'] == 1){
				$output = '<div style="color:white;background-color:red;">'.__ ('Please enable at least one social network!', 'rh_social_login').'</div>';
			}
		}
		//Providers selected
		else
		{
			if(!is_admin()){
				if($settings['enable_social_network_login'] == 1){
					//Random integer
					$rand = mt_rand (99999, 9999999);

					//Setup output
					$output = array ();
					$output [] = '<div class="oneall_social_login">';

					//Add the caption?
					if (!empty ($plugin_caption))
					{
						$output [] = ' <div class="oneall_social_login_label" style="margin-bottom: 3px;"><label>' . __ ($plugin_caption) . '</label></div>';
					}

					//Add the Plugin
					$output [] = ' <div class="oneall_social_login_providers" id="oneall_social_login_providers_' . $rand . '"></div>';
					$output [] = ' <script type="text/javascript">';
					$output [] = '  oneall.api.plugins.social_login.build("oneall_social_login_providers_' . $rand . '", {';
					$output [] = '   "providers": ["' . implode ('","', $providers) . '"], ';
					//$output [] = '   "same_window": true, ';
					$output [] = '   "callback_uri": (window.location.href + ((window.location.href.split(\'?\')[1] ? \'&amp;\':\'?\') + "oa_social_login_source=' . $source . '")), ';
					$output [] = '   "css_theme_uri": "' . $css_theme_uri . '" ';
					$output [] = '  });';
					$output [] = ' </script>';
					$output [] = ' <!-- OneAll.com / Social Login for WordPress / v'.constant('RH_SOCIAL_LOGIN_VERSION').' -->';
					$output [] = '</div>';

					//Done
					$output = implode ("\n", $output);
				}
			}
		}

		//Return a string and let the calling function do the actual outputting
		return $output;
	}
}



/**
 * Request email from user
 */
function rh_social_login_request_email()
{
	//Get the current user
	$current_user = wp_get_current_user();

	//Check if logged in
	if ( ! empty ($current_user->ID) AND is_numeric ($current_user->ID))
	{
		//Current user
		$user_id = $current_user->ID;

		//Check if email has to be requested
		$rh_social_login_request_email = get_user_meta($user_id, 'rh_social_login_request_email', true);
		if ( ! empty ($rh_social_login_request_email))
		{
			//Display modal dialog?
			$display_modal = true;

			//Messaging
			$message = '';

			//Form submitted
			if ( isset ($_POST) AND ! empty ($_POST['rh_social_login_action']) AND $_POST['rh_social_login_action'] == 'confirm_email')
			{
				$user_email = (empty ($_POST['rh_social_login_email']) ? '' : trim ($_POST['rh_social_login_email']));
				if (empty ($user_email))
				{
					$message = __('Please enter your email address','rh_social_login');
				}
				else
				{
					if (!is_email ($user_email))
					{
						$message = __('This email is not valid','rh_social_login');
					}
					elseif (email_exists ($user_email))
					{

						$message = __('This email is already used by another account','rh_social_login');
					}
					else
					{
						wp_update_user(array ('ID' => $user_id, 'user_email' => $user_email));
						delete_user_meta($user_id, 'rh_social_login_request_email');
						$display_modal = false;
					}
				}
			}

			//Display modal dialog?
			if ($display_modal === true)
			{
				//Read Settings
				$rhl_options = get_option ('rhl_options');

				//Read the social network
				$rh_social_login_identity_provider = get_user_meta($user_id, 'rh_social_login_identity_provider', true);

				//Caption
				$caption = (isset ($rhl_options['plugin_require_email_text']) ? $rhl_options['plugin_require_email_text'] : __('<strong>We unfortunately could not retrieve your email address from %s.</strong> Please enter your email address in the form below in order to continue.', 'rh_social_login'));

				//Add CSS
				rh_social_login_add_site_css();

				//Show email request form
				?>
					<div id="rh_social_login_overlay"></div>
					<div id="rh_social_login_modal">
						<div class="rh_social_login_modal_outer">
							<div class="rh_social_login_modal_inner">
			 					<div class="rh_social_login_modal_title">
			 						<?php printf (__ ('You have successfully connected with %s!', 'rh_social_login'), '<strong>'.$rh_social_login_identity_provider.'</strong>'); ?>
			 					</div>
			 					<?php
			 						if (strlen (trim ($caption)) > 0)
			 						{
			 							?>
			 								<div class="rh_social_login_modal_notice"><?php echo str_replace ('%s', $rh_social_login_identity_provider, $caption); ?></div>
			 							<?php
			 						}
			 					?>
			 					<div class="rh_social_login_modal_body">
				 					<div class="rh_social_login_modal_subtitle">
				 						<?php _e ('Your email address', 'rh_social_login'); ?>:
				 					</div>
									<form method="post" action="">
										<fieldset>
											<div>
												<input type="text" name="rh_social_login_email" class="inputtxt" value="<?php echo ( ! empty ($_POST['rh_social_login_email']) ? rh_social_login_esc_attr($_POST['rh_social_login_email']) : '');  ?>" />
												<input type="hidden" name="rh_social_login_action" value="confirm_email" size="30" />
											</div>
											<div class="rh_social_login_modal_error">
												<?php  echo $message; ?>
											</div>
											<div class="rh_social_login_modal_button">
												<input type="submit" value="<?php _e ('Confirm my email address', 'rh_social_login'); ?>" class="inputbutton" />
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php
			}
		}
	}
}
add_action('wp_footer', 'rh_social_login_request_email');
add_action('admin_footer', 'rh_social_login_request_email');
