<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class modal_login_ajax {
	var $uploaded_files_queue_option_name = 'rhl_uploaded_files';
	var $upload_limit_per_index = 20;
	var $allowed_methods = array(
		'login',
		'logout',
		'lostpassword',
		'rp',
		'register'
	);

	var $admin_methods = array(
		'save_css',
		'remove_css',
		'saved_list',
		'backup_css',
		'restore_css'
	);
	
	function modal_login_ajax(){
		add_action('wp_ajax_rhl_save_css', array(&$this,'save_css'));
		add_action('wp_ajax_rhl_remove_css', array(&$this,'remove_css'));
		add_action('wp_ajax_rhl_saved_list', array(&$this,'saved_list'));
		add_action('wp_ajax_rhl_backup_css', array(&$this,'backup_css'));
		add_action('wp_ajax_rhl_restore_css', array(&$this,'restore_css'));
		add_action('wp_ajax_rhl_handle_upload', array(&$this,'handle_upload'));
		//--------
		add_action('wp',array(&$this,'wp'));
		//add_action('after_setup_theme',array(&$this,'init'));	
		$this->init();
	}

	function wp(){
		if(isset($_REQUEST['rhl_action'])){	
			$method = $_REQUEST['rhl_action'];
			if(in_array($method,$this->allowed_methods)){
				error_reporting(0);//avoid warning output as it breaks json
				$this->$method();
			}
		}
	}	
	
	function init(){
		if(isset($_REQUEST['rhl_action'])){	
			$method = $_REQUEST['rhl_action'];
			if(in_array($method,$this->admin_methods)){
				error_reporting(0);//avoid warning output as it breaks json
				$this->$method();
			}
		}
	}

	function send_response($ret){
		if(is_object($ret)&&property_exists($ret,'MSG')){
			$ret->MSG = translate( $ret->MSG );
		}else if(is_array($ret) && isset($ret['MSG'])){
			$ret['MSG'] = translate( $ret['MSG']);
		}	
		
		die(json_encode($ret));	
	}
	
	function login(){
		$this->setup_post_from_serialized_data();
		//------------------------------------------------------------------------------------------------------------
		$valid_nonce = $this->check_modal_login_nonce($_POST['rhl_nonce']);
		if( is_wp_error( $valid_nonce ) ){
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$valid_nonce->get_error_message()
			);
			$this->send_response($ret);					
		}
		//------------------------------------------------------------------------------------------------------------		
		extract($_POST);
		$creds = array();
		$creds['user_login'] 		= isset($log)?sanitize_user($log):'';
		$creds['user_password'] 	= isset($pwd)?$pwd:'';
		$creds['remember'] 			= isset($rememberme)?true:false;

		$secure_cookie = '';

		// If the user wants ssl but the session is not ssl, force a secure cookie.
		if ( !empty($_POST['log']) && !force_ssl_admin() ) {
			$user_name = sanitize_user($_POST['log']);
			if ( $user = get_user_by('login', $user_name) ) {
				if ( get_user_option('use_ssl', $user->ID) ) {
					$secure_cookie = true;
					force_ssl_admin(true);
				}
			}
		}
		
		if ( isset( $_POST['redirect_to'] ) && !empty($_POST['redirect_to']) ) {
			$redirect_to = $_POST['redirect_to'];
			// Redirect to https if user wants ssl
			if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
				$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
		} else {
			$redirect_to = '';
		}		
		
		if( ''==trim($redirect_to) && isset($_REQUEST['is_login_page'])){
			$redirect_to = admin_url();
		}
		
		// If the user was redirected to a secure login form from a non-secure admin page, and secure login is required but secure admin is not, then don't use a secure
		// cookie and redirect back to the referring non-secure admin page. This allows logins to always be POSTed over SSL while allowing the user to choose visiting
		// the admin via http or https.
		if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
			$secure_cookie = false;
		
		global $rhl_plugin;
		if('1'==$rhl_plugin->get_option('remove_wp_login_hooks','',true)){
			remove_all_actions('wp_login');
		}
		
		$user = wp_signon( $creds, $secure_cookie );
		
		$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : '', $user);
		
		if ( is_wp_error($user) ){
			$msg = $user->get_error_message();
			if(trim($msg)==''&&empty($_POST['user_login'])){
				$msg = __( '<strong>ERROR</strong>: Username is empty.' );
			}
			
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$msg
			);
		}else{
			$user_details = (object)array(
				'user_nicename'	=> $user->data->user_nicename,
				'user_login'	=> $user->data->user_login,
				'display_name'	=> $user->data->display_name
			);
		
			$ret = array(
				'R'=>'OK',
				'MSG'=>'',
				'USER'=>$user_details,
				'redirect_to'=>$redirect_to
			);
		}
		$this->send_response($ret);		
	}
	
	function logout(){
		global $userdata;
		$user_id = $userdata->ID;
		
		$redirect_to = isset($_REQUEST['redirect_to'])?rawurldecode($_REQUEST['redirect_to']):'';
		$redirect_to = ''==trim($redirect_to)?site_url('/'):$redirect_to;
		$redirect_to = apply_filters('logout_redirect_to',$redirect_to,$user_id);
		
		wp_logout();
		
		$ret = array(
			'R'=>'OK',
			'MSG'=>'',
			'redirect_to'=>$redirect_to
		);		
		$this->send_response($ret);		
	}
	
	function lostpassword(){
		$this->setup_post_from_serialized_data();
		//------------------------------------------------------------------------------------------------------------
		$valid_nonce = $this->check_modal_login_nonce($_POST['rhl_nonce']);
		if( is_wp_error( $valid_nonce ) ){
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$valid_nonce->get_error_message()
			);
			$this->send_response($ret);					
		}
		//------------------------------------------------------------------------------------------------------------
		$errors = $this->retrieve_password();
		$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
		if ( is_wp_error($errors) ) {
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$errors->get_error_message()
			);	
		}else{
			$ret = array(
				'R'=>'OK',
				'MSG'=>__('Check your e-mail for the confirmation link.','rhl'),
				'redirect_to'=>$redirect_to
			);		
		}		
		$this->send_response($ret);			
	}
	
	function rp(){
		$this->setup_post_from_serialized_data();
		//------------------------------------------------------------------------------------------------------------
		$valid_nonce = $this->check_modal_login_nonce($_POST['rhl_nonce']);
		if( is_wp_error( $valid_nonce ) ){
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$valid_nonce->get_error_message()
			);
			$this->send_response($ret);					
		}
		//------------------------------------------------------------------------------------------------------------
		//$action = 'resetpass';
		$user = $this->check_password_reset_key($_POST['key'], $_POST['user_login']);
		if ( is_wp_error($user) ) {
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$user->get_error_message()
			);	
		}else{
			if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] ) {
				$ret = array(
					'R'=>'ERR',
					'MSG'=>__('The passwords do not match.')
				);	
			} elseif ( isset($_POST['pass1']) && !empty($_POST['pass1']) ) {
				$this->reset_password($user, $_POST['pass1']);
				$ret = array(
					'R'=>'OK',
					'MSG'=> __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a>'
				);
			}else{
				$ret = array(
					'R'=>'ERR',
					'MSG'=>__('Please type password and confirmation password.','rhl')
				);			
			}	
		}
	
		$this->send_response($ret);
	}
	
	function register(){
		$this->setup_post_from_serialized_data();
		//------------------------------------------------------------------------------------------------------------
		$valid_nonce = $this->check_modal_login_nonce($_POST['rhl_nonce']);
		if( is_wp_error( $valid_nonce ) ){
			$ret = array(
				'R'=>'ERR',
				'MSG'=>$valid_nonce->get_error_message()
			);
			$this->send_response($ret);					
		}
		//------------------------------------------------------------------------------------------------------------

		if ( get_option( 'users_can_register' ) ){
			$user_login = $_POST['user_login'];
			$user_email = $_POST['user_email'];
			$errors = $this->register_new_user($user_login, $user_email);
			if ( !is_wp_error($errors) ) {
				global $rhl_plugin;
				$message = $rhl_plugin->get_option('rhl_label_register_complete', __('Registration complete. Please check your e-mail.','rhl'), true);
		
				$ret = array(
					'R'				=> 'OK',
					'MSG'			=> $message,
					'redirect_to'	=> !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered'
				);
			}else{
				$ret = array(
					'R'=>'ERR',
					'MSG'=>$errors->get_error_message()
				);
			}		
		}else{
			$ret = array(
				'R'=>'ERR',
				'MSG'=>__('User registration is currently not allowed.','rhl')
			);
		}
		
		$this->send_response($ret);
	}
	
	function retrieve_password() {
		//from wp-login.php
		global $wpdb, $current_site;
	
		$errors = new WP_Error();
	
		if ( empty( $_POST['user_login'] ) ) {
			$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
		} else if ( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
			if ( empty( $user_data ) )
				$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
		} else {
			$login = trim($_POST['user_login']);
			$user_data = get_user_by('login', $login);
		}
	
		do_action('lostpassword_post');
	
		if ( $errors->get_error_code() )
			return $errors;
	
		if ( !$user_data ) {
			$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
			return $errors;
		}
	
		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
	
		do_action('retreive_password', $user_login);  // Misspelled and deprecated
		do_action('retrieve_password', $user_login);
	
		$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	
		if ( ! $allow )
			return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
		else if ( is_wp_error($allow) )
			return $allow;
	
		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if ( empty($key) ) {
			// Generate something random for a key...
			$key = wp_generate_password(20, false);
			do_action('retrieve_password_key', $user_login, $key);
			// Now insert the new md5 key into the db
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
		}
		$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
	
		if ( is_multisite() )
			$blogname = $GLOBALS['current_site']->site_name;
		else
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	
		$title = sprintf( __('[%s] Password Reset'), $blogname );
	
		$title = apply_filters('retrieve_password_title', $title);
		$message = apply_filters('retrieve_password_message', $message, $key);
	
		if ( $message && !wp_mail($user_email, $title, $message) )
			return new WP_Error('wp_email_error', __('Possible reason: your host may have disabled the mail() function...'));
	
		return true;
	}	

	//from wp-login.php
	function register_new_user( $user_login, $user_email ) {
		$errors = new WP_Error();
	
		$sanitized_user_login = sanitize_user( $user_login );
		$user_email = apply_filters( 'user_registration_email', $user_email );
	
		// Check the username
		if ( $sanitized_user_login == '' ) {
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
		} elseif ( ! validate_username( $user_login ) ) {
			$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
			$sanitized_user_login = '';
		} elseif ( username_exists( $sanitized_user_login ) ) {
			$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.' ) );
		}
	
		// Check the e-mail address
		if ( $user_email == '' ) {
			$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
		} elseif ( ! is_email( $user_email ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
			$user_email = '';
		} elseif ( email_exists( $user_email ) ) {
			$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
		}
	
		do_action( 'register_post', $sanitized_user_login, $user_email, $errors );
	
		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
	
		if ( $errors->get_error_code() )
			return $errors;
	
		$user_pass = wp_generate_password( 12, false);
		$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
		if ( ! $user_id ) {
			$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
			return $errors;
		}
	
		update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.
	
		wp_new_user_notification( $user_id, $user_pass );
	
		return $user_id;
	}
	
	//from wp-login.php
	function check_password_reset_key($key, $login) {
		global $wpdb;
	
		$key = preg_replace('/[^a-z0-9]/i', '', $key);
	
		if ( empty( $key ) || !is_string( $key ) )
			return new WP_Error('invalid_key', __('Invalid key'));
	
		if ( empty($login) || !is_string($login) )
			return new WP_Error('invalid_key', __('Invalid key'));
	
		$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login));
	
		if ( empty( $user ) )
			return new WP_Error('invalid_key', __('Invalid key'));
	
		return $user;
	}
	
	//from wp-login.php
	function reset_password($user, $new_pass) {
		do_action('password_reset', $user, $new_pass);
	
		wp_set_password($new_pass, $user->ID);
	
		wp_password_change_notification($user);
	}
	
	function setup_post_from_serialized_data(){
		parse_str($_REQUEST['data'],$args);
		$fields = array_keys($args);
		extract($args);
		if(is_array($fields)&&count($fields)>0){
			foreach($fields as $field){
				$_POST[$field]=$$field;
				$_REQUEST[$field]=$$field;
			}
		}
	}
	
	function check_modal_login_nonce($nonce){
		global $rhl_plugin;
		if('1'==$rhl_plugin->get_option('disable_modal_login_nonce','0',true)){
			return true;
		}else if( wp_verify_nonce($nonce,'modal_login_nonce') ){
			return true;
		}else{
			return new WP_Error('invalid_rhl_nonce', __('Could not verify request origin, please reload and try again.'));
		}
	}
	
	//--- admin functions
	function handle_admin_access(){
		if(!current_user_can('modal_login_settings')){
			global $rhl_plugin;
			if( '1'==$rhl_plugin->get_option('demo_allow_edit_tool','0',true) ){
				$ret = array(
					'R'=>'ERR',
					'MSG'=> __('Please notice for demonstration purpose this action has been disabled.','rhl')
				);
			}else{
				$ret = array(
					'R'=>'ERR',
					'MSG'=> __('No access.  Open a diferent browser tab and login, then come back to this screen and try again.','rhl')
				);
			}
			$this->send_response($ret);
		}
	}
	
	function save_css(){
		$this->handle_admin_access();

		$data = isset($_REQUEST['data'])&&is_array($_REQUEST['data'])?$_REQUEST['data']:array();
		$default = isset($_REQUEST['default_values'])&&is_array($_REQUEST['default_values'])?$_REQUEST['default_values']:array();

		$output = '';
		if(!empty($data)){
			foreach($data as $fieldset){
				$selector = stripslashes($fieldset['sel']); 
				$items = array();
				foreach($fieldset['css'] as $values){
					if(!empty($values)){
						foreach($values as $property => $value){
							if(trim($value)=='')continue;
							$items[]=sprintf("\t%s:%s;\n",$property,$value);						
						}
					}
				}
				
				if(!empty($items)){
					$output.=sprintf("%s {\n%s}\n",$selector,implode('',$items));
				}
			}
		}

		global $rhl_plugin;
		$options = get_option($rhl_plugin->options_varname);
		$options = is_array($options)?$options:array();	
		$options['css_array'] 	= $data;
		$options['css_output']	= $output;
		$options['css_default']	= $default;
//-----
		$pop = isset($_REQUEST['pop'])&&is_array($_REQUEST['pop'])?$_REQUEST['pop']:array();
		if(is_array($pop)&&count($pop)>0){
			foreach($pop as $p){
				if( isset($p['name']) ){
					$options[ $p['name'] ] = $p['value'];
				}
			}
		}
				
		update_option($rhl_plugin->options_varname,$options);

		$ret = array(
			'R'=>'OK',
			'MSG'=>__('Custom settings saved','rhl')
		);	
		$this->send_response($ret);
	}
	
	function remove_css(){
		$this->handle_admin_access();

		global $rhl_plugin;
		$options = get_option($rhl_plugin->options_varname);
		$options = is_array($options)?$options:array();	
		$options['css_array'] 	= array();
		$options['css_output']	= '';
		$options['css_default']	= array();
		update_option($rhl_plugin->options_varname,$options);		
		
		$ret = array(
			'R'=>'OK',
			'MSG'=>__('Customization removed','rhl')
		);	
		$this->send_response($ret);		
	}

	function backup_css(){
		$this->handle_admin_access();

		if(!isset($_REQUEST['label']) || ''==trim($_REQUEST['label'])){
			$ret = array(
				'R'=>'ERR',
				'MSG'=>__('Please specify a short name for the backup.','rhl')
			);	
			$this->send_response($ret);		
		}
		
		global $rhl_plugin;
		$options = get_option($rhl_plugin->options_varname);
		$options = is_array($options)?$options:array();	

		$css_options = array();
		$css_options['css_array'] 	=	$options['css_array'];
		$css_options['css_output'] 	=	$options['css_output'];
		$css_options['css_default'] =	$options['css_default'];
		
		//-- append uploaded-list--------
		foreach($options as $field => $value){
			if(false!==strpos($field,'-upload-list')){
				$css_options[$field] = $value;
			}
		}
		//-------------------------------	
		$saved_options = get_option($rhl_plugin->options_varname.'_saved');
		$saved_options = is_array($saved_options)?$saved_options:array();	
		
		$label = $_REQUEST['label'];
		
		$done=false;
		if(count($saved_options)>0){
			foreach($saved_options as $i => $saved_option){
				if($label == $saved_option->name){
					$done=true;
					$saved_options[$i]=(object)array(
						'id'		=> md5($_REQUEST['label']),
						'name' 		=> $_REQUEST['label'],
						'groups' 	=> array('css'),
						'date' 		=> date('Y-m-d H:i:s'),
						'options' 	=> $css_options
					);		
					update_option($rhl_plugin->options_varname.'_saved',$saved_options);		
					
					$ret = array(
						'R'=>'OK',
						'MSG'=>__('Current settings saved, item replaced.','rhl')
					);	
					$this->send_response($ret);								
					break;
				}	
			}
		}
		
		if(!$done){
			$saved_options[]=(object)array(
				'id'		=> md5($_REQUEST['label']),
				'name' 		=> $_REQUEST['label'],
				'groups' 	=> array(),
				'date' 		=> date('Y-m-d H:i:s'),
				'options' 	=> $css_options
			);		
			update_option($rhl_plugin->options_varname.'_saved',$saved_options);	
		}
		
		$ret = array(
			'R'=>'OK',
			'MSG'=>__('Current settings saved.','rhl')
		);	
		$this->send_response($ret);		
	}
	
	function restore_css(){
		$this->handle_admin_access();
		global $rhl_plugin;
		$label = $_REQUEST['label'];
		
		$saved_options = get_option($rhl_plugin->options_varname.'_saved');
		$saved_options = is_array($saved_options)?$saved_options:array();	
		if( count($saved_options)>0 ){
			foreach($saved_options as $i => $saved_option){
				if($saved_option->name==$label){
					$options = get_option($rhl_plugin->options_varname);
					$options = is_array($options)?$options:array();
					foreach($saved_option->options as $field => $value){
						$options[$field]=$value;
					}
					
					update_option($rhl_plugin->options_varname,$options);
					
					$ret = array(
						'R'=>'OK',
						'MSG'=>__('Settings restored, reloading','rhl')
					);	
					$this->send_response($ret);				
				}
			}
		}
				
		$ret = array(
			'R'=>'ERR',
			'MSG'=>__('Setting not found','rhl')
		);	
		$this->send_response($ret);		
	}
	
	function saved_list(){
		$this->handle_admin_access();
		
		global $rhl_plugin;
		$varname = $rhl_plugin->options_varname.'_saved';
		$saved_options = get_option($varname);
		$saved_options = is_array($saved_options)?$saved_options:array();
//$saved_options=array();		
		//todo skip email templates
		if(count($saved_options)>0){
			$new_saved_options = array();
			foreach($saved_options as $i => $s){
				if($s->groups && is_array($s->groups) && array_intersect(array('rhl_email_template_list','rhl-email-rp','rhl-email-register'),$s->groups) /*&& in_array('rhl_email_template_list',$s->groups)*/ ){
					continue;
				}
				$new_saved_options[]=$s;
			}
			$saved_options = $new_saved_options;
		}
		
		$ret = array(
			'R'=>'OK',
			'MSG'=>__('Loaded','rhl'),
			'DATA'=> array_reverse($saved_options)
		);	
		$this->send_response($ret);		
	}
	
	function handle_upload(){
		$this->handle_admin_access();
		//--
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		check_ajax_referer('rhl-upload');
		$status = wp_handle_upload($_FILES['rhl-async-upload'], array('test_form'=>true, 'action' => 'rhl_handle_upload'));
		if(isset($status['url'])){			
			//-- handle queue
			global $rhl_plugin;
			$saved_options = get_option($rhl_plugin->options_varname);
			$saved_options = is_array($saved_options)?$saved_options:array();			
			$field = $id.'-upload-list';
			$saved_options[$field] = isset($saved_options[$field])&&is_string($saved_options[$field])?$saved_options[$field]:'';
			$arr = explode("\n",$saved_options[$field]);
			$arr = is_array($arr)?$arr:array();
			array_unshift($arr,$status['url']);
			$arr = array_slice($arr, 0, $this->upload_limit_per_index );
			$saved_options[$field] = implode("\n",$arr);
			update_option($rhl_plugin->options_varname,$saved_options);
			//--
			
			$ret = array(
				'R'			=> 'OK',
				'MSG'		=> '',
				'ID'		=> $id,
				'URL'		=> $status['url'],
				'UPLOADED'	=> $saved_options[$field]
			);			
		}else if(isset($status['error'])){
			$ret = array(
				'R'		=> 'ERR',
				'ID'	=> $id,
				'MSG'	=> $status['error']
			);			
		}else{
			$ret = array(
				'R'		=> 'ERR',
				'ID'	=> $id,
				'MSG'	=> __('Unknown error, reload and try again.','rhl')
			);		
		}
		//--	
		$this->send_response($ret);
	}
}
?>