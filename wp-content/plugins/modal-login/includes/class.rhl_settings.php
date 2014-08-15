<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhl_settings {
	var $added_rules;
	function rhl_settings($plugin_id='rhl'){
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);
		add_action('pop_body_'.$this->id,array(&$this,'flush_rewrite_rules'));
				
		add_action('admin_init',array(&$this,'admin_init'));
	}
	
	function admin_init(){
		$this->add_rhl_rules(false);
		//observe that this isnt flushing rules. just adding them to wp_rewrite in case some
	}
	
	function add_rhl_rules($flush_rules=true){
		return;
		global $wp_rewrite,$rhl_plugin;
		//-----
		$login_slug = $rhl_plugin->get_option('login-slug','login', true);
		//-----
		$regex = sprintf('(%s)/?$',$login_slug);
		$redirect = sprintf('wp-login.php?post_type=%s&%s=$matches[2]',$post_type,RHC_DISPLAY);
		add_rewrite_rule($regex, $redirect	, 'top');

		if($flush_rules){	
			flush_rewrite_rules(false);		
		}
	}
	
	function flush_rewrite_rules(){
		if( get_option('rhl_flush_rewrite_rules',false) ){
			delete_option('rhl_flush_rewrite_rules');
			$this->add_rhl_rules();
		}
	}
	
	function pop_handle_save($pop){
		global $rhl_plugin;
		if($rhl_plugin->options_varname!=$pop->options_varname)return;
		update_option('rhl_flush_rewrite_rules',true);
	}
	
	function options($t){
		global $rhl_plugin;
		$panic_key = $rhl_plugin->get_option('panic_key','',true);
		$panic_link = site_url('/wp-login.php?skip_modal_login='.$panic_key); 
		$edit_link = site_url('/wp-login.php?edit=1');
		//----
		$i = count($t);
		//-- General settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-general'; 
		$t[$i]->label 		= __('General settings','rhl');
		$t[$i]->right_label	= __('General settings','rhl');
		$t[$i]->page_title	= __('General settings','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Enable modal login','rhl')
			),
			(object)array(
				'id'		=> 'enable_modal_login',
				'label'		=> __('Enable modal login','rhl'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'hidegroup'	=> '#modal_login_group',
				'description'=> __('Choose yes to activate the modal login.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array('type'	=> 'clear'),
			(object)array(
				'id'	=> 'modal_login_group',
				'type'=>'div_start'
			),							
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('wp-login.php','rhl')
			),
			(object)array(
				'id'		=> 'modal_login',
				'label'		=> __('Enable modal login on wp-login.php','rhl'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description'=> __('Select yes, and the modal login will always replace wp-login.php','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_modal_bg',
				'label'		=> __('Disable modal background in frontend','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Only applicable when using a login link instead of wp-login.php.  Check yes if you what to show the website behing the modal login instead of the background image.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'		=> 'demo_allow_edit_tool',
				'label'		=> __('Demo allow showing edit tool','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> sprintf('<p>%s</p><p>%s</p>',
					__('This is only for demostration of the css editor tool, without allowing to save.  Always choose no, only choose yes if you wich to allow any logged user to play with the css editor. (saving is blocked)','rhl'),
					sprintf('%s <a class="not-modal" href="%s">%s</a>',
						__('Editor link'),
						$edit_link,
						$edit_link
					)
				) ,
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),				
			(object)array(
				'id'		=> 'panic_key',
				'label'		=> __('Panic key (optional)','rhl'),
				'type'		=> 'text',
				'description'=> sprintf(__('If there is an error and you are left out of the admin and unable to login, use this link to skip modal login.  Specify a key and click save, then copy the following link to access the default login page: <strong>%s</strong>','rhl'),$panic_link),
				'el_properties'	=>  array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'div_end'
			),
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'id'		=> 'block_right_click',
				'label'		=> __('Disable right click','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes to disable page right click.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'clear'
			),			
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)						
		);
		//-------------------------
		//-- Mant settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-general'; 
		$t[$i]->label 		= __('Maintenance mode','rhl');
		$t[$i]->right_label	= __('Maintenance mode','rhl');
		$t[$i]->page_title	= __('Maintenance mode','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Enable maintenance screen','rhl')
			),
			(object)array(
				'id'		=> 'enable_forced_login',
				'label'		=> __('Enable forced login','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes to force login.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'enable_maintenance',
				'label'		=> __('Enable maintenance mode','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'hidegroup'	=> '#modal_maintenance_group',
				'description'=> __('Choose yes to activate maintenance mode.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array('type'	=> 'clear'),
			(object)array(
				'id'	=> 'modal_maintenance_group',
				'type'=>'div_start'
			),	
			(object)array(
				'id'	=> 'rhl_label_head_maintenance',
				'type'	=> 'text',
				'label'	=> __('Title','rhl'),
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'	=> 'rhl_label_maintenance_body',
				'type'	=> 'textarea',
				'label'	=> __('Content','rhl'),
				'el_properties' => array('class'=>'text-width-full inp-maintenance-body'),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'type'=>'div_end'
			),
			(object)array(
				'type'=>'clear'
			),	
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)							
		);		
		//--  -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-labels'; 
		$t[$i]->label 		= __('Customize labels','rhl');
		$t[$i]->right_label	= __('Customize labels','rhl');
		$t[$i]->page_title	= __('Customize labels','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;	
		$t[$i]->options = array(

		);		
		//-- login form ---------------------------------------
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Login form','rhl')
		);	
		$labels = array(
			'head_login' 			=> __('Login form title','rhl'),
			'login_username'		=> __('Username','rhl'),
			'login_password'		=> __('Password','rhl'),
			'login_rememberme'		=> __('Remember me','rhl')
		);	
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}	
		//-- lostpassword form
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Lost password form','rhl')
		);	
		$labels = array(
			'head_lostpassword' 			=> __('Login form title','rhl'),
			'lostpassword_user_login'		=> __('Username or E-mail','rhl')
		);	
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}	
		//-- rp form
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Reset password form','rhl')
		);	
		$labels = array(
			'head_rp' 						=> __('Reset password form title','rhl'),
			'rp_pass1'						=> __('New password','rhl'),
			'rp_pass2'						=> __('Confirm new password','rhl'),
			'rp_strength'					=> __('Strength indicator','rhl'),
			'rp_hint'						=> __('Password hint text','rhl')
		);	
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}	
		//-- register form
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Register form','rhl')
		);	
		$labels = array(
			'head_register'					=> __('Register form title','rhl'),
			'register_username'				=> __('Username','rhl'),
			'register_email'				=> __('E-mail','rhl'),
			'register_message'				=> __('A password will be e-mailed to you.','rhl'),
			'register_complete'				=> __('Registration complete. Please check your e-mail.','rhl')
		);	
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}	
		//-- change form
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Change form buttons','rhl')
		);	
		$labels = array(
			'sec_lostpassword'		=> __('Lost your password?','rhl'),
			'sec_login'				=> __('Log in','rhl'),
			'sec_register'			=> __('Register','rhl')
		);	
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}		
		//-- action buttons labels
		$labels = array(
			'btn_login' 			=> __('Login button','rhl'),
			'login_loading' 		=> __('Login button loading text','rhl'),
			'btn_lostpassword'		=> __('Lost password button','rhl'),
			'lostpassword_loading'	=> __('Lost password button loading text','rhl'),
			'btn_rp'				=> __('Reset password button','rhl'),
			'rp_loading'			=> __('Reset password loading text','rhl'),
			'btn_register'			=> __('Register button','rhl'),
			'register_loading'		=> __('Register button loading text','rhl')
		);
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Main button labels','rhl')
			);		
		foreach($labels as $id => $label){
			$t[$i]->options[]=(object)array(
				'id'	=> 'rhl_label_'.$id,
				'type'	=> 'text',
				'label'	=> $label,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			);	
		//-------------------------		
		$WP_Roles = new WP_Roles();
		$role_names = $WP_Roles->get_names();		
		//-- Login redirect settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-redirect'; 
		$t[$i]->label 		= __('Login redirect','rhl');
		$t[$i]->right_label	= __('Login redirect','rhl');
		$t[$i]->page_title	= __('Login redirect','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Default redirect url','rhl')
			),	
			(object)array(
				'id'	=> 'login_redirect',
				'type'	=> 'text',
				'label'	=> 'Default redirect url',
				'description'	=> __('<strong>Default redirect url:</strong> Where to redirect users by default; this is used if a role redirection url is left blank.','rhl').'<br /><br />'
				.__('<strong>Default redirection by role:</strong> Redirect users based on their role.','rhl')			
				,
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),				
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Default redirection by role','rhl')
			)
		);
		
		foreach($role_names as $role_id => $role_name){
			$t[$i]->options[]=(object)array(
				'id'	=> 'login_'.$role_id,
				'type'	=> 'text',
				'label'	=> sprintf(__('%s redirect url','rhl'),$role_name),
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}
		
		$t[$i]->options[]=	(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('Logout redirect url','rhl')
			);
				
		foreach($role_names as $role_id => $role_name){
			$t[$i]->options[]=(object)array(
				'id'	=> 'logout_'.$role_id,
				'type'	=> 'text',
				'label'	=> sprintf(__('%s redirect url','rhl'),$role_name),
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			);
		}
			
		$t[$i]->options[]=(object)array(
				'type'=>'clear'
			);
		$t[$i]->options[]=(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			);	
		//-- Troubleshooting settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-troubleshooting'; 
		$t[$i]->label 		= __('Troubleshooting','rhl');
		$t[$i]->right_label	= __('Troubleshooting','rhl');
		$t[$i]->page_title	= __('Troubleshooting','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'only_on_wp_login',
				'label'		=> __('Only use modal on wp-login.php','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes to only use modal login on the wp-login.php page.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_on_site_login',
				'label'		=> __('Disable login link replacement','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('By default modal login will replace all login links so that modal login form is loaded on the same page.  Check yes to disable this.  Please observe that if you are rewring and block wp-login.php, this links may not work.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'enable_shortcode_in_widget',
				'label'		=> __('Enable shortcode rendering in widget area.','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('By WordPress default, shortcodes in the widget area are not rendered.  Some plugins and themes enable this, choose yes if the login shortcode is not rendered in a widget area.  Recommended setting is no, unless needed.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_bootstrap',
				'label'		=> __('Disable bootstrap javascript(frontend)','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes if other plugins or the theme is adding the bootstrap javascript and you dont want the modal login one to be loaded in the frontend.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_bootstrap_admin',
				'label'		=> __('Disable bootstrap javascript(in wp-admin)','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes if other plugins or the theme is adding the bootstrap javascript and you dont want the modal login one to be loaded in the backend, wp-admin.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'disable_wp_new_user_notification',
				'label'		=> __('Disable wp_new_user_notification','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes if you are having issues with the new user email and do not want this plugin to modify the registration email.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'		=> 'disable_jquery_check',
				'label'		=> __('Disable jQuery check','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Check yes to disable jQuery version check.  The plugin does not work on old jQuery versions.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'		=> 'scripts_in_footer',
				'label'		=> __('Scripts in footer.','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Print javascript scripts in the footer section.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),	
			(object)array(
				'id'		=> 'remove_wp_login_hooks',
				'label'		=> __('Remove wp_login hooks','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> sprintf('<p>%s</p><p>%s</p><p>%s</p>',
					__('<b>Syntom:</b> modal login form shows, but after pressing login nothing happens.  Also in the console the ajax is being called but the response contains a non-json reply or a 403 header.','rhl'),
					__('<b>Cause:</b>  Another script is trying to redirect the user on login','rhc'),
					__('Choose yes to remove al wp_login hooks prior to performing the ajax login','rhc')
				),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'		=> 'disable_modal_login_nonce',
				'label'		=> __('Disable modal login nonce','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Check yes if you are constantly getting the login error "Could not verify request origin".','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),			
			/* this didnt really work with bootstrap.*/				
			/*(object)array(
				'id'		=> 'own_jquery',
				'label'		=> __('Load own contained jQuery','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Recommended setting is no.  Some jquery plugins may conflict with some of the bootstrap common function names, choose yes to load this plugin scripts in a separate jQuery.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),		
			*/				
			(object)array(
				'id'		=> 'enable_debug',
				'label'		=> __('Enable debug mode','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Recommended setting is no.  Usually this is only for support to gather troubleshooting info.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'	=> 'ajax_url',
				'type'	=> 'text',
				'label'	=> 'Ajax url',
				'description'	=> __('For some special conditions where the site_url function does not point to the location of the root index.php. add ending slash, ie. http://domain.com/','rhl'),
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'	=> 'unhandled_login_parameters',
				'type'	=> 'text',
				'label'	=> 'Unhandled login parameters',
				'description'	=> __('Used to avoid skipping login replacement for other plugins by the arguments they use in the login url.','rhl'),
				'el_properties' => array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),				
			(object)array(
				'type'=>'clear'
			),			
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)	
		);		
		//-------------------------		
		return $t;
	}
	
	function htaccess(){
?>
<div class="pt-option pt-option-htaccess">
<span class="pt-label widefat">add to htaccess</span>
<textarea class="widefat" rows=14>
# BEGIN RHL
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^login/?.*$ wp-login.php?rewrittenlogin=1 [QSA,L]
RewriteCond %{QUERY_STRING} !^rewrittenlogin=(.*)$  
RewriteRule ^wp-login\.php$ login/ [NE,R=301,L]
RewriteRule ^admin[^/]*$ admin/ [R=301,L]
RewriteRule ^admin(.*)$ wp-admin$1?rewrittenadmin=1 [QSA,L,NE]
RewriteCond %{QUERY_STRING} !^(.*)rewrittenadmin=(.*)$
RewriteRule ^wp-admin/(.*)$ admin/$1 [QSA,R=301,L,NE]
</IfModule>
# END RHL
</textarea>
</div>
<?php	
	}
}
?>