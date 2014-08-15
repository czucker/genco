<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2003
 **/
class rhl_settings_social_media {
	var $added_rules;
	function rhl_settings_social_media($plugin_id='rhl'){
		$this->id = $plugin_id.'-social-media-setup';
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);
	}


	function options($t){
		global $rhl_plugin;
		//-- Social Media settings -----------------------
		$i = count($t);

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-enable-social-media';
		$t[$i]->label 		= __('Enable Social Network Login','rhl');
		$t[$i]->right_label	= __('Enable Social Network Login','rhl');
		$t[$i]->page_title	= __('Enable Social Network Login','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'enable_social_network_login',
				'label'		=> __('Enable social network login','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'hidegroup'	=> '#social_network_login_group',
				'description'=> __('Choose yes to activate the social network login feature.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'	=> 'clear'
			),

			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)
		);

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-social-media-setup';
		$t[$i]->label 		= __('Social Login Setup','rhl');
		$t[$i]->right_label	= __('Social Login Setup','rhl');
		$t[$i]->page_title	= __('Social Login Setup','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'social_login_setup',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'social_login_setup')
			),
		);

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-social-media-connection';
		$t[$i]->label 		= __('API Connection','rhl');
		$t[$i]->right_label	= __('API Connection','rhl');
		$t[$i]->page_title	= __('API Connection','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('API Connection','rhl')
			),
			(object)array(
				'id'		=> 'api_subdomain',
				'label'		=> __('API Subdomain','rhl'),
				'type'		=> 'text',
				'description'	=> __('This is your domain name.','rhl'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'		=> 'api_key',
				'label'		=> __('API Public Key','rhl'),
				'type'		=> 'text',
				'description'	=> __('This is your public key privided by OneAll when you signed up.','rhl'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'		=> 'api_secret',
				'label'		=> __('API Private Key','rhl'),
				'type'		=> 'text',
				'description'	=> __('This is your private key provided by OneAll when you signed up.','rhl'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'		=> 'verify_settings',
				'type'		=> 'callback',
				'callback'	=> array(&$this,'rhl_verify_settings')
			),
			(object)array(
				'id'	=> 'api_check_result',
				'type'	=> 'label',
				'label' =>__(''),
				'description' => __('')
			),
			(object)array(
				'type'	=>'clear'
			),
			(object)array(
				'type'	=>'clear'
			),
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary',
			)


		);

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-social-media-social-networks';
		$t[$i]->label 		= __('Enable Social Networks','rhl');
		$t[$i]->right_label	= __('Enable Social Networks','rhl');
		$t[$i]->page_title	= __('Enable Social Networks','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Select the social networks you would like to use','rhl')
			),
			(object)array(
				'id'		=> 'social_medias',
				'label'		=> __('Social Medias','rhl'),
				'type'		=> 'label',
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'type'	=>'clear'
			),

			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'id'			=> 'social_medias_facebook',
				'name'			=> 'providers[]',
				'option_value'	=> 'facebook',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-facebook" title="Facebook">Facebook</span>',//__('Facebook','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Facebook account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'type'	=>'clear'
			),

			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'id'			=> 'social_medias_twitter',
				'name'			=> 'providers[]',
				'option_value'	=> 'twitter',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-twitter" title="Twitter">Twitter</span>',//__('Twitter','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Twitter account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'type'	=>'clear'
			),

			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'id'			=> 'social_medias_linkedin',
				'name'			=> 'providers[]',
				'option_value'	=> 'linkedin',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-linkedin" title="LinkedIn">LinkedIn</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their LinkedIn account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'type'	=>'clear'
			),

			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'id'			=> 'social_medias_google',
				'name'			=> 'providers[]',
				'option_value'	=> 'google',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-google" title="Google">Google</span>',//__('Google','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Google account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_github',
				'name'			=> 'providers[]',
				'option_value'	=> 'github',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-github" title="Github">Github</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Github account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_wordpress',
				'name'			=> 'providers[]',
				'option_value'	=> 'WordPress',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-wordpress" title="WordPress">WordPress</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their WordPress account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_stackexchange',
				'name'			=> 'providers[]',
				'option_value'	=> 'Stackexchange',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-stackexchange" title="tsackexchange">Stackexchange</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Stackexchange account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_yahoo',
				'name'			=> 'providers[]',
				'option_value'	=> 'yahoo',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-yahoo" title="Yahoo">Yahoo</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Yahoo account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_paypal',
				'name'			=> 'providers[]',
				'option_value'	=> 'paypal',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-paypal" title="PayPal">PayPal</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their PayPal account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_windowslive',
				'name'			=> 'providers[]',
				'option_value'	=> 'windowslive',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-windowslive" title="WindowsLive">WindowsLive</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their WindowsLive account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_blogger',
				'name'			=> 'providers[]',
				'option_value'	=> 'blogger',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-blogger" title="Blogger">Blogger</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Blogger account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_steam',
				'name'			=> 'providers[]',
				'option_value'	=> 'steam',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-steam" title="Steam">Steam</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their Steam account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_livejournal',
				'name'			=> 'providers[]',
				'option_value'	=> 'livejournal',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-livejournal" title="LiveJournal">LiveJournal</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their LiveJournal account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'id'			=> 'social_medias_foursquare',
				'name'			=> 'providers[]',
				'option_value'	=> 'foursquare',
				'label'			=> '<span class="rhlogin rh-social-login-provider rh-social-login-provider-foursquare" title="FourSquare">FourSquare</span>', //__('LinkedIn','rhl'),
				'type'			=> 'checkbox',
				'description'	=> __('Allow your users to sign in with their FourSquare account.'),
				'el_properties'	=> array('class'=>'text-width-full'),
				'save_option'	=>true,
				'load_option'	=>true
			),
			(object)array(
				'type'	=>'clear'
			),

			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)
				// (object)array(
				// 	'id'		=> 'social_medias',
				// 	'type'		=> 'callback',
				// 	'callback'	=> array(&$this,'rhl_social_medias')
				// )
		);

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-social-media-general-settings';
		$t[$i]->label 		= __('General Settings','rhl');
		$t[$i]->right_label	= __('General Settings','rhl');
		$t[$i]->page_title	= __('General Settings','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Do you want to use the default or the small social network buttons?','rhl')
			),
			(object)array(
				'id' => 'plugin_use_small_buttons',
				'type' => 'radio',
				'default' => '0',
				'options' => array(
					'0' => __('Use the default social network buttons (32x32 px) <b>(Default)</b>','rhl'),
				),
				'description' => __('Which size buttons would you like to use? <a class="rhlogin" rel="popover" data-img="//placehold.it/300x150">Image 1</a>','rhl'),
				'el_properties' => array(),
				'save_option' => true,
				'load_option' => true
			),
			(object)array(
				'id' => 'plugin_use_small_buttons',
				'type' => 'radio',
				'options' => array(
					'1' => __('Use the small social network buttons (16x16 px)','rhl'),
				),
				'el_properties' => array(),
				'save_option' => true,
				'load_option' => true
			),

			(object)array(
				'type'	=>'clear'
			),
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Do you want to display the social networks used to connect in the user list of the administration area?','rhl')
			),
			(object)array(
				'id' => 'plugin_add_column_user_list',
				'type' => 'radio',
				'options' => array(
					'1' => __('Yes, add a new column to the user list and display the social network that the user connected with ','rhl'),
				),
				'description' => __('Display social networks','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'plugin_add_column_user_list',
				'type' => 'radio',
				'default' => '0',
				'options' => array(
					'0' =>__('No, do not display the social networks in the user list <b>(Default)</b>','rhl')
				),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'type'	=>'clear'
			),
			// (object)array(
			// 	'type' 			=> 'subtitle',
			// 	'label'			=> __('Do you want to receive an email whenever a new user registers with a social network login?','rhl')
			// ),
			// (object)array(
			// 	'id' => 'plugin_notify_admin',
			// 	'type' => 'radio',
			// 	'default' => '1',
			// 	'options' => array(
			// 		'1' => __('Yes, send me an email whenever a new user registers with a social network login <b>(Default)</b>','rhl'),
			// 	),
			// 	'description' => __('Receive an email when new user registers','rhl'),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			// (object)array(
			// 	'id' => 'plugin_notify_admin',
			// 	'type' => 'radio',
			// 	'options' => array(
			// 		'0' =>__('No, do not send me any emails','rhl')
			// 	),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			(object)array(
				'type'	=>'clear'
			),
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)
		);

		// $i++;
		// $t[$i]=(object)array();
		// $t[$i]->id 		= 'rhl-social-media-icon-settings';
		// $t[$i]->label 		= __('Icon Settings','rhl');
		// $t[$i]->right_label	= __('Icon Settings','rhl');
		// $t[$i]->page_title	= __('Icon Settings','rhl');
		// $t[$i]->theme_option 	= true;
		// $t[$i]->plugin_option 	= true;
		// $t[$i]->options = array(
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('Enable custom icons','rhl')
		// 	),
		// 	(object)array(
		// 		'id'		=> 'enable_custom_icon',
		// 		'label'		=> __('Enable custom icon','rhl'),
		// 		'type'		=> 'yesno',
		// 		'default'	=> '1',
		// 		'hidegroup'	=> '#custom_icon_group',
		// 		'description'=> __('Choose yes to activate custom icons.','rhl'),
		// 		'el_properties'	=> array(),
		// 		'save_option'=>true,
		// 		'load_option'=>true
		// 	),
		// 	(object)array('type'	=> 'clear'),
		// 	(object)array(
		// 		'id'	=> 'custom_icon_group',
		// 		'type'=>'div_start'
		// 	),
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('Do you want to use the default or the small social network buttons?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_facebook_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Facebook Icon', 'rhl'),
		// 		'description' => __('Upload your own Facebook icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_twitter_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Twitter Icon', 'rhl'),
		// 		'description' => __('Upload your own Twitter icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_linkedin_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom LinkedIn Icon', 'rhl'),
		// 		'description' => __('Upload your own LinkedIn icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_google_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Google Icon', 'rhl'),
		// 		'description' => __('Upload your own Google icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_github_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Github Icon', 'rhl'),
		// 		'description' => __('Upload your own Github icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_wordpress_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom WordPress Icon', 'rhl'),
		// 		'description' => __('Upload your own WordPress icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_stackexchange_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom StackExchange Icon', 'rhl'),
		// 		'description' => __('Upload your own StackExchange icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_yahoo_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Yahoo Icon', 'rhl'),
		// 		'description' => __('Upload your own Yahoo icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_paypal_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom PayPal Icon', 'rhl'),
		// 		'description' => __('Upload your own PayPal icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_windowslive_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom WindowsLive Icon', 'rhl'),
		// 		'description' => __('Upload your own WindowsLive icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_blogger_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Blogger Icon', 'rhl'),
		// 		'description' => __('Upload your own Blogger icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_steam_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom Steam Icon', 'rhl'),
		// 		'description' => __('Upload your own Steam icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_livejournal_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom LiveJournal Icon', 'rhl'),
		// 		'description' => __('Upload your own LiveJournal icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'id' => 'custom_foursquare_icon',
		// 		'type' => 'fileuploader',
		// 		'label' => __('Custom FourSquare Icon', 'rhl'),
		// 		'description' => __('Upload your own FourSquare icon'),
		// 		'save_option' => true,
		// 		'load_option' => true
		// 	),
		// 	(object)array(
		// 		'type'=>'div_end'
		// 	),
		// 	(object)array(
		// 		'type'=>'clear'
		// 	)
		// );

		// $i++;
		// $t[$i]=(object)array();
		// $t[$i]->id 		= 'rhl-social-media-user-settings';
		// $t[$i]->label 		= __('User Settings','rhl');
		// $t[$i]->right_label	= __('User Settings','rhl');
		// $t[$i]->page_title	= __('User Settings','rhl');
		// $t[$i]->theme_option 	= true;
		// $t[$i]->plugin_option 	= true;
		// $t[$i]->options = array(
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('If the user\'s social network profile has no email address, should we ask the user to enter it manually?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_require_email',
		// 		'type' => 'radio',
		// 		'default' => '0',
		// 		'options' => array(
		// 			'0' => __('No, simplify the registration by automatically creating a placeholder email <b>(Default)</b>', 'rhl'),
		// 		),
		// 		'description' => __('Ask for email address','rhl'),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_require_email',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'1' => __('Yes, require the user to enter his email address manually and display this message: ', 'rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id'	=> 'plugin_require_email_text',
		// 		'type'	=> 'textarea',
		// 		'el_properties' => array('class'=>'text-width-full inp-maintenance-body', 'placeholder' => __('Put your message here','rhl')),
		// 		'save_option'=>true,
		// 		'load_option'=>true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('If the user\'s social network profile has a verified email, should we try to link it to an existing account?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_link_verified_accounts',
		// 		'type' => 'radio',
		// 		'default' => '0',
		// 		'options' => array(
		// 			'0' => __('Yes, try to link verified social network profiles to existing blog accounts <b>(Default)</b>', 'rhl'),
		// 		),
		// 		'description' => __('Link to existing social network account?','rhl'),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_link_verified_accounts',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'1' => __(' No, disable account linking ', 'rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('If the user\'s social network profile has an avatar, should we show it as the default avatar for the user?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_show_avatars_in_comments',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'0' => __('Yes, show user avatars from social networks if available', 'rhl'),
		// 		),
		// 		'description' => __('Use user\'s avatar?','rhl'),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_show_avatars_in_comments',
		// 		'type' => 'radio',
		// 		'default' => '1',
		// 		'options' => array(
		// 			'1' => __('No, display the default avatars <b>(Default)</b>', 'rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'type'	=> 'submit',
		// 		'label'	=> __('Save','rhl'),
		// 		'class' => 'button-primary'
		// 	),
		// );

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 		= 'rhl-social-media-comment-settings';
		$t[$i]->label 		= __('Comment Settings','rhl');
		$t[$i]->right_label	= __('Comment Settings','rhl');
		$t[$i]->page_title	= __('Comment Settings','rhl');
		$t[$i]->theme_option 	= true;
		$t[$i]->plugin_option 	= true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Show the social network login buttons in the comment area?','rhl')
			),
			(object)array(
				'id' => 'plugin_comment_show',
				'type' => 'radio',
				'default' => '0',
				'options' => array(
					'1' => __('Yes, show the social network login buttons <b>(Default)</b>','rhl'),
				),
				'description' => __('Show login buttons', 'rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'plugin_comment_show',
				'type' => 'radio',
				'options' => array(
					'0' => __('No, do not show the social network login buttons','rhl')
				),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Show the social network login buttons in the comment area if comments are disabled for guests?','rhl')
			),
			(object)array(
				'id' => 'plugin_comment_show_if_members_only',
				'type' => 'radio',
				'default' => '0',
				'options' => array(
					'0' => __('Yes, show the social network login buttons <b>(Default)</b>','rhl')
				),
				'description' => __('Show social login button for guests','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'plugin_comment_show_if_members_only',
				'type' => 'radio',
				'options' => array(
					'1' => __('No, do not show the social network login buttons ','rhl')
				),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('If the user\'s social network profile has an avatar, should we show it as the default avatar for the user?','rhl')
			),
			(object)array(
				'id' => 'plugin_show_avatars_in_comments',
				'type' => 'radio',
				'options' => array(
					'1' => __('Yes, show user avatars from social networks if available', 'rhl'),
				),
				'description' => __('Use user\'s avatar?','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'plugin_show_avatars_in_comments',
				'type' => 'radio',
				'default' => '0',
				'options' => array(
					'0' => __('No, display the default avatars <b>(Default)</b>', 'rhl')
				),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			// (object)array(
			// 	'type' 			=> 'subtitle',
			// 	'label'			=> __('Automatically approve comments left by users that connected by using social network login?','rhl')
			// ),
			// (object)array(
			// 	'id' => 'plugin_comment_auto_approve',
			// 	'type' => 'radio',
			// 	'default' => '0',
			// 	'options' => array(
			// 		'0' => __('Yes, automatically approve comments made by users that connected with social network login','rhl'),
			// 	),
			// 	'description' => __('Approve comments','rhl'),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			// (object)array(
			// 	'id' => 'plugin_comment_auto_approve',
			// 	'type' => 'radio',
			// 	'options' => array(
			// 		'1' =>__('No, do not automatically approve <b>(Default) </b>','rhl')
			// 	),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			(object)array(
				'type' 	=> 'clear'
			),
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)
		);

		// $i++;
		// $t[$i]=(object)array();
		// $t[$i]->id 		= 'rhl-social-media-login-page-settings';
		// $t[$i]->label 		= __('Login Page Settings','rhl');
		// $t[$i]->right_label	= __('Login Page Settings','rhl');
		// $t[$i]->page_title	= __('Login Page Settings','rhl');
		// $t[$i]->theme_option 	= true;
		// $t[$i]->plugin_option 	= true;
		// $t[$i]->options = array(
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('Do you want to display the social network login buttons on the modal login form?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_display_in_login_form',
		// 		'type' => 'radio',
		// 		'default' => '0',
		// 		'options' => array(
		// 			'0' => __('Yes, display the social network buttons below the modal login form <b>(Default)</b>','rhl')
		// 		),
		// 		'description' => __('Show buttons on modal login form?','rhl'),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_display_in_login_form',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'1' => __('No, disable social network buttons in the modal login form ','rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'type' 			=> 'subtitle',
		// 		'label'			=> __('Where should users be redirected to after having logged in?','rhl')
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_login_form_redirect',
		// 		'type' => 'radio',
		// 		'default' => '0',
		// 		'options' => array(
		// 			'0' => __('Redirect users to the homepage of my blog <b>(Default)</b>','rhl'),
		// 		),
		// 		'description' => __('Redirection','rhl'),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_login_form_redirect',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'1' =>__('Redirect users to their account dashboard','rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),
		// 	(object)array(
		// 		'id' => 'plugin_login_form_redirect',
		// 		'type' => 'radio',
		// 		'options' => array(
		// 			'2' =>__('Redirect users to the following url:','rhl')
		// 		),
		// 		'el_properties' => array(),
		// 		'save_option' =>true,
		// 		'load_option' =>true
		// 	),

		// 	(object)array(
		// 		'id' => 'plugin_login_form_redirect_custom_url',
		// 		'type'		=> 'text',
		// 		'el_properties'	=> array('class'=>'text-width-full'),
		// 		'save_option'	=>true,
		// 		'load_option'	=>true
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'type' 	=> 'clear'
		// 	),
		// 	(object)array(
		// 		'type'	=> 'submit',
		// 		'label'	=> __('Save','rhl'),
		// 		'class' => 'button-primary'
		// 	)
		// );






		//-------------------------
		return $t;
	}

	function rhl_social_medias_general_settings(){  ?>
		<div class="option-content inside" style="display: block;">
			<table>
				<tr class="row_odd">
					<td>
						<strong><?php _e ('Enter the description to be displayed above the Social Login buttons (leave empty for none):', 'rh_social_login'); ?></strong>
					</td>
				</tr>
				<tr class="row_even">
					<td>
						<input type="text" name="rh_social_login_settings[plugin_caption]" size="90" value="<?php echo (isset ($settings['plugin_caption']) ? htmlspecialchars ($settings['plugin_caption']) : _e ('Connect with:', 'rh_social_login')); ?>" />
					</td>
				</tr>
				<tr class="row_odd">
					<td>
						<strong><?php _e ("Do you want to use the default or the small social network buttons?", 'rh_social_login'); ?></strong>
					</td>
				</tr>
				<tr class="row_even">
					<td>
					<?php $plugin_use_small_buttons = (isset ($settings['plugin_use_small_buttons']) AND $settings['plugin_use_small_buttons'] == '1'); ?>
					<input type="radio" name="rh_social_login_settings[plugin_use_small_buttons]" value="0" <?php echo (!$plugin_use_small_buttons ? 'checked="checked"' : ''); ?> /> <?php printf (__ ('Use the default social network buttons (%s)', 'rh_social_login'), '32x32 px'); ?> <strong>(<?php _e ('Default', 'rh_social_login') ?>)</strong><br />
					<input type="radio" name="rh_social_login_settings[plugin_use_small_buttons]" value="1" <?php echo ($plugin_use_small_buttons ? 'checked="checked"' : ''); ?> /> <?php printf (__ ('Use the small social network buttons (%s)', 'rh_social_login'), '16x16 px'); ?>
					</td>
				</tr>
				<tr class="row_odd">
					<td>
						<strong><?php _e ('Do you want to display the social networks used to connect in the user list of the administration area ?', 'rh_social_login'); ?></strong>
					</td>
				</tr>
				<tr class="row_even">
					<td>
						<?php $plugin_add_column_user_list = (isset ($settings['plugin_add_column_user_list']) AND $settings['plugin_add_column_user_list'] == '1'); ?>
						<input type="radio" name="rh_social_login_settings[plugin_add_column_user_list]" value="1" <?php echo ($plugin_add_column_user_list ? 'checked="checked"' : ''); ?> /> <?php _e ('Yes, add a new column to the user list and display the social network that the user connected with', 'rh_social_login'); ?> <br />
						<input type="radio" name="rh_social_login_settings[plugin_add_column_user_list]" value="0" <?php echo (!$plugin_add_column_user_list ? 'checked="checked"' : ''); ?> /> <?php _e ('No, no not display the social networks in the user list', 'rh_social_login'); ?> <strong>(<?php _e ('Default', 'rh_social_login') ?>)</strong>
					</td>
				</tr>
				<tr class="row_odd">
					<td>
						<strong><?php _e ('Do you want to receive an email whenever a new user registers with Social Login ?', 'rh_social_login'); ?></strong>
					</td>
				</tr>
				<tr class="row_even">
					<td>
						<?php $plugin_notify_admin = (!isset ($settings['plugin_notify_admin']) OR $settings['plugin_notify_admin'] == '1'); ?>
						<input type="radio" name="rh_social_login_settings[plugin_notify_admin]" value="1" <?php echo ($plugin_notify_admin ? 'checked="checked"' : ''); ?> /> <?php _e ('Yes, send me an email whenever a new user registers with Social Login', 'rh_social_login'); ?> <strong>(<?php _e ('Default', 'rh_social_login') ?>)</strong><br />
						<input type="radio" name="rh_social_login_settings[plugin_notify_admin]" value="0" <?php echo (!$plugin_notify_admin ? 'checked="checked"' : ''); ?> /> <?php _e ('No, do not send me any emails', 'rh_social_login'); ?>
					</td>
				</tr>
			</table>
		</div>
	<?php
	}

	function rhl_verify_settings(){
	?>
		<a href="#" class="button-primary" id="rh_social_login_test_api_settings"><?php echo __('Verify Settings'); ?></a>
		<div id="rh_test_result_container"><div id="rh_social_login_api_test_result" class="rhlogin rh-verification-message"></div></div>
	<?php
	}

	function rhl_social_medias(){
?>
		<div class="rh-social-media-options">
			<!--<form class="form-horizontal">-->
				<div class="control-group">
					<div class="controls">
						<span class="rh-social-login-provider rh-social-login-provider-facebook" title="facebook">Facebook</span>
					    	<div class="controls">
					      		<input type="checkbox" id="rh-social-login-facebook" name="rh-social-login[]" >
					    	</div>
					 </div>
				 </div>
				 <div class="control-group">
					<div class="controls">
						<span class="rh-social-login-provider rh-social-login-provider-twitter" title="twitter">Twitter</span>
					    	<div class="controls">
					      		<input type="checkbox" id="rh-social-login-twitter" name="rh-social-login[]">
					    	</div>
					 </div>
				 </div>
				 <div class="control-group">
					<div class="controls">
						<span class="rh-social-login-provider rh-social-login-provider-linkedin" title="LinkedIn">LinkedIn</span>
					    	<div class="controls">
					      		<input type="checkbox" id="rh-social-login-linkedin" name="rh-social-login[]" >
					    	</div>
					 </div>
				 </div>

				 <div class="control-group">
					<div class="controls">
						<span class="rh-social-login-provider rh-social-login-provider-google" title="Google">Google</span>
					    	<div class="controls">
					      		<input type="checkbox" id="rh-social-login-google" name="rh-social-login[]">
					    	</div>
					 </div>
				 </div>
			<!--</form>-->
		</div>
<?php
	}

	function social_login_setup ()
	{
	//Import providers
	GLOBAL $rh_social_login_providers;
	?>
		<div class="wrap">
			<div id="rh_social_login_page" class="rh_social_login_setup">
				<h2>
					OneAll Social Login <?php _e ('Setup', 'rh_social_login'); ?>
				</h2>
				<?php
					if (get_option ('rh_social_login_api_settings_verified') !== '1')
					{
						?>
							<p>
								<?php _e ('Allow your visitors to comment, login and register with 20+ Social Networks like for example Twitter, Facebook, LinkedIn, Google.', 'rh_social_login'); ?>
								<strong><?php _e ('Draw a larger audience and increase your user engagement in a  few simple steps.', 'rh_social_login'); ?> </strong>
							</p>
							<div class="rh_social_login_box" id="rh_social_login_box_status">
								<div class="rh_social_login_box_title">
									<?php _e ('Get Started!', 'rh_social_login'); ?>
								</div>
								<p>
									<?php printf (__ ('To be able to use this plugin you first of all need to create a free account at %s and setup a Site.', 'rh_social_login'), '<a href="https://app.oneall.com/signup/" target="_blank">http://www.oneall.com</a>'); ?>
									<?php _e ('After having created your account and setup your Site, please enter the Site settings in the form below.', 'rh_social_login'); ?>
									<?php _e ("Don't worry the setup takes only a couple of minutes!", 'rh_social_login'); ?>
								</p>
								<p>
									<a class="button-secondary" href="https://app.oneall.com/signup/" target="_blank"><strong><?php _e ('Click here to setup your free account', 'rh_social_login'); ?></strong></a>
								</p>
							</div>
						<?php
					}
					else
					{
						?>
						<div class="rh_social_login_box" id="rh_social_login_box_status">
							<div class="rh_social_login_box_title">
								<?php _e ('Your API Account is setup correctly', 'rh_social_login'); ?>
							</div>
							<p>
								<?php _e ('Login to your account to manage your providers and access your Social Insights.', 'rh_social_login'); ?>
								<?php _e ("Determine which social networks are popular amongst your users and tailor your registration experience to increase your users' engagement.", 'rh_social_login'); ?>
							</p>
							<p>
								<!--<a class="button-secondary" href="https://app.oneall.com/signin/" target="_blank"><strong><?php //_e ('Click here to login to your account', 'rh_social_login'); ?></strong> </a>-->
								<a class="button-secondary" href="https://app.oneall.com/signin/?atag=QoWBc" target="_blank"><strong><?php _e ('Click here to login to your account', 'rh_social_login'); ?></strong> </a>
							</p>
						</div>
						<?php
					}
				?>
				<?php
				//echo 'is set ' . empty ($_REQUEST['settings-updated']);
				if (!empty ($_REQUEST['settings-updated']) AND strtolower ($_REQUEST['settings-updated']) == 'true')
				{
					?>
						<div class="rh_social_login_box" id="rh_social_login_box_updated">
							<?php _e ('Your modifications have been saved successfully!'); ?>
						</div>
					<?php
				}
				?>
			</div>
		</div>
	<?php
}

/**
 * Check API Settings through an Ajax Call
 */
//add_action ('wp_ajax_check_api_settings', 'rh_social_login_admin_check_api_settings');
}
?>
