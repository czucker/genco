<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2003
 **/

class plugin_modal_login {
	var $options = array();
	var $scripts_in_footer=false;
	function plugin_modal_login($args=array()){
		//------------
		$defaults = array(
			'id'					=> 'rhl',
			'plugin_code'			=> 'MLW',
			'options_varname'		=> 'rhl_options',
			'options_parameters'	=> array(),
			'options_capability'	=> 'manage_options',
			'options_panel_version'	=> '2.6.0',
			'development'			=> false,
			'modal_login_shortcode'	=>'modal_login_button',
			'page_title'			=> __('Modal Log In','rhl'),
			'menu_title'			=> __('Modal Log In','rhl'),
			'resources_path'		=> 'rhl',
			'own_jquery'			=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		add_action('plugins_loaded',array(&$this,'plugins_loaded'));
		//add_action('init',array(&$this,'init'));
		add_action('admin_enqueue_scripts',array(&$this,'init'),10);
		add_action('wp_enqueue_scripts',array(&$this,'init'),10);
		add_action('login_enqueue_scripts',array(&$this,'init'),10);
		add_action('init',array(&$this,'handle_social_login_init'),10);
		add_action('admin_menu',array(&$this,'admin_menu'));
		//-----------
		$this->options = get_option($this->options_varname);
		$this->options = is_array($this->options)?$this->options:array();	
		//--------
		require_once RHL_PATH.'options-panel/load.pop.php';
		rh_register_php('rh-functions', RHL_PATH.'options-panel/rh-functions.php', $this->options_panel_version);
		if(is_admin()){
			rh_register_php('options-panel',RHL_PATH.'options-panel/class.PluginOptionsPanelModule.php', $this->options_panel_version);
		}

		add_filter('login_redirect',array(&$this,'handle_login_redirection'),1,3);
		add_filter('logout_redirect_to',array(&$this,'handle_logout_redirection'),1,2);

		//require_once RHL_PATH.'includes/pluggable.php';
		//if ( !defined('ADMIN_COOKIE_PATH') )
		//	define( 'ADMIN_COOKIE_PATH', SITECOOKIEPATH . 'admin' );
		//if('1'==$this->get_option('admin_rewrite','',true)){
		//	add_filter('admin_url',array(&$this,'admin_url'),10,3);
		//}
		if( '1'==$this->get_option('enable_shortcode_in_widget') ){
			add_filter('widget_display_callback',array(&$this,'widget_display_callback'));
		}

		if( '1'==$this->get_option('scripts_in_footer','',true) ){
			$this->scripts_in_footer = true;
		}
		//$this->own_jquery = '1'==$this->get_option('own_jquery','',true)?true:false;
		$this->own_jquery = false;//this didnt work well.

		$this->debug_menu = '1'==$this->get_option('enable_debug','',true)?true:false;

		add_filter( 'wp_nav_menu_objects' , array(&$this,'wp_loginout_in_menu'), 10, 2);
		
		add_filter( 'style_loader_src', array(&$this,'remove_script_version'), 15, 2 );
	}
	
	function remove_script_version( $src, $handle ){
		if('rh-modal-login'==$handle){
			$parts = explode( '?', $src );
			return $parts[0];		
		}
		return $src;
	}

	function admin_menu(){
		add_menu_page( $this->page_title, $this->menu_title, $this->options_capability, $this->id/*'modal_login_options', array(&$this,'modal_login_start')*/ );
	}

	function modal_login_start(){

	}

	function get_rhl_options(){
		$r=array();
		$tmp = $this->get_option('unhandled_login_parameters','',true);
		$r['unhandled_login_parameters'] = explode(',', str_replace(' ','',$tmp));
		$r['unhandled_login_parameters'][]='loginTwitter';
		$r['unhandled_login_parameters'][]='loginGoogle';
		$r['unhandled_login_parameters'][]='loginFacebook';
		
		return $r;
	}
	
	function init(){
		global $rhl_plugin;
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'rh-modal-login', RHL_URL.'css/styles.min.css', array(), '');
		
		$bs = true;
		if(is_admin()){
			if('1'==$rhl_plugin->get_option('disable_bootstrap_admin','0',true)){
				$bs = false;
			}	
		}else{
			if('1'==$rhl_plugin->get_option('disable_bootstrap','0',true)){
				$bs = false;
			}				
		}

		if($bs){
			rh_enqueue_script( 'bootstrap', RHL_URL.'bootstrap/js/bootstrap.js', array(), '3.0.0', $this->scripts_in_footer);
			rh_enqueue_script( 'bootstrap-renamed', RHL_URL.'bootstrap/js/custom.js', array(), '3.0.0.1', $this->scripts_in_footer);		
		}
		

		wp_register_script( 'rhl-jquery', RHL_URL.'js/jquery-1.8.3.min.js', array(),'1.8.3', $this->scripts_in_footer);

		wp_enqueue_script( 'rhl-scripts', RHL_URL.'js/scripts.js', array(), '1.0.0', $this->scripts_in_footer);
		wp_localize_script( 'rhl-scripts', 'RHL', $this->get_rhl_options() );
		if(is_admin()):
			wp_register_style( 'extracss-'.$this->id, RHL_URL.'css/admin.css', array(),'1.0.0');
		endif;
	}

	function handle_social_login_init(){
		rh_social_login_init();	
	}	
	
	function plugins_loaded(){
		if($this->get_option('enable_modal_login','1',true)){
			require_once RHL_PATH.'includes/class.modal_login_frontend.php';
			new modal_login_frontend(array('plugin_url'=>RHL_URL,'development'=>$this->development,'own_jquery'=>$this->own_jquery));
		}

		require_once RHL_PATH.'includes/class.rhl_email_filters.php';
		new rhl_email_filters();

		require_once RHL_PATH.'includes/class.modal_login_ajax.php';
		new modal_login_ajax();

		require_once RHL_PATH.'includes/class.login_button_shortcode.php';
		new login_button_shortcode($this->modal_login_shortcode);

		require_once RHL_PATH.'includes/class.righthere_css.php';
		new righthere_css();

		require_once RHL_PATH.'includes/admin_social_network_login.php';
		require_once RHL_PATH.'includes/settings_social_network_login.php';
		require_once RHL_PATH.'includes/communication_social_network_login.php';
		require_once RHL_PATH.'includes/toolbox_social_network_login.php';
		require_once RHL_PATH.'includes/user_interface_social_network_login.php';

		do_action('rh-php-commons');

		if(is_admin()){
			require_once RHL_PATH.'includes/class.rhl_settings.php';
			new rhl_settings($this->id);

			require_once RHL_PATH.'includes/class.rhl_settings_css.php';
			new rhl_settings_css($this->id);

			require_once RHL_PATH.'includes/class.rhl_settings_email.php';
			new rhl_settings_email($this->id);

			require_once RHL_PATH.'includes/class.rhl_rewrite.php';
			new rhl_rewrite($this->id);

			require_once RHL_PATH.'includes/class.rhl_settings_social_media.php';
			new  rhl_settings_social_media($this->id);

			$dc_options = array(
				'id'			=> $this->id.'-dc',
				'plugin_id'		=> $this->id,
				'capability'	=> $this->options_capability,
				'resources_path'=> $this->resources_path,
				'parent_id'		=> $this->id,
				'menu_text'		=> __('Downloads','rhl'),
				'page_title'	=> __('Downloadable content - Modal Login for WordPress','rhl'),
				'license_keys'	=> $this->get_option('license_keys',array()),
				'plugin_code'	=> $this->plugin_code,
				//'api_url'		=> 'http://dev.lawley.com/',
				'product_name'	=> __('Modal Login','rhl'),
				'options_varname' => $this->options_varname,
				'tdom'			=> 'rhl'
			);

			$settings = array(
				'id'					=> $this->id,
				'plugin_id'				=> $this->id,
				'capability'			=> $this->options_capability,
				'options_varname'		=> $this->options_varname,
				'menu_id'				=> 'rhl-options',
				'page_title'			=> __('Modal login options','rhl'),
				'menu_text'				=> __('Options','rhl'),
				//'option_menu_parent'	=> 'modal_login_options',
				//'option_menu_parent'	=> 'options-general.php',
				'option_menu_parent'	=> $this->id,
				'notification'			=> (object)array(
					'plugin_version'=> RHL_VERSION,
					'plugin_code' 	=> $this->plugin_code,
					'message'		=> __('Modal login plugin update %s is available! <a href="%s">Please update now</a>','rhl')
				),
				'theme'					=> false,
				'extracss'				=> 'extracss-'.$this->id,
				'fileuploader'			=> true,
				'stylesheet'			=> 'rhl-options',
				'option_show_in_metabox'=> true,
				'dc_options'			=> $dc_options,
				'pluginurl'				=> RHL_URL,
				'pluginslug'	=> RHL_SLUG,
				//'api_url' 		=> "http://localhost",
				'api_url' 		=> "http://plugins.righthere.com",
				'autoupdate'	=> false
			); //echo 'plugin code = ' . $settings['pluginurl'];

			$settings['id'] 		= $this->id;
			$settings['menu_id'] 	= $this->id;
			$settings['menu_text'] 	= __('Options','rhl');
			$settings['import_export'] = true;
			$settings['import_export_options'] =true;
			$settings['registration'] = true;
			new PluginOptionsPanelModule($settings);

			$settings['id'] 		= $this->id.'-css';
			$settings['menu_id'] 	= $this->id.'-css';
			$settings['menu_text'] 	= __('CSS Customization','rhl');
			$settings['import_export'] = false;
			$settings['import_export_options'] =false;
			$settings['registration'] = false;
			new PluginOptionsPanelModule($settings);

			$settings['id'] 		= $this->id.'-email';
			$settings['menu_id'] 	= $this->id.'-email';
			$settings['menu_text'] 	= __('Email templates','rhl');
			$settings['import_export'] = true;
			$settings['import_export_options'] = false;
			$settings['registration'] = false;
			$settings['downloadables'] = false;
			new PluginOptionsPanelModule($settings);

			$settings['id'] 		= $this->id.'-social-media-setup';
			$settings['menu_id'] 	= $this->id.'-social-media-setup';
			$settings['menu_text'] 	= __('Social Network Login','rhl');
			$settings['page_title']	= __('Social media options','rhl');
			$settings['import_export'] = true;
			$settings['import_export_options'] = false;
			//$settings['capability'] = 'wlb_login';
			$settings['registration'] = false;
			$settings['downloadables'] = true;
			$settings['autoupdate'] = true;
			new PluginOptionsPanelModule($settings);

			if($this->debug_menu){
				require_once RHL_PATH.'includes/class.debug_modal_login.php';
				new debug_modal_login($this->id);
			}
		}
	}

	function get_option($name,$default='',$default_if_empty=false){
		$value = isset($this->options[$name])?$this->options[$name]:$default;
		if($default_if_empty){
			$value = ''==$value?$default:$value;
		}
		return $value;
	}

	function get_template_path(){
		return apply_filters('rhl_template_path',RHL_PATH.'templates/');
	}

	function handle_login_redirection($redirect_to,$posted_redirect_to,$user){
		$redir_url = '';
		if( is_array($user->roles) && isset($user->roles[0]) ){
			$redir_url = $this->get_option('login_'.$user->roles[0],'',true);
		}
		if(empty($redir_url)){
			$redir_url = $this->get_option('login_redirect','',true);
		}
		return empty($redir_url)?$redirect_to:$redir_url;
	}

	function handle_logout_redirection($redirect_to,$user_id){
		$redir_url = '';
		$user = get_userdata( $user_id );
		if( is_array($user->roles) && isset($user->roles[0]) ){
			$redir_url = $this->get_option('logout_'.$user->roles[0],'',true);	
		}
		/*
		if(empty($redir_url)){
			$redir_url = $this->get_option('logout_redirect','',true);
		}
		*/
		return empty($redir_url)?$redirect_to:$redir_url;
	}

	function widget_display_callback($str){
		if(is_array($str)&&count($str)>0){
			foreach($str as $i => $v){
				if(is_string($v)){
					$str[$i]=do_shortcode($v);
				}
			}
			return $str;
		}else if(is_string($str)){
			return do_shortcode($str);
		}
		return $str;
	}

	function wp_loginout_in_menu($sorted_menu_items, $args) {
		foreach($sorted_menu_items as $i => $item){
			$title = trim($item->title);
			if(false===strpos($title,'[log'))continue;
			$tagnames = array('login','logout','loginout');
			$tagregexp = join( '|', array_map('preg_quote', $tagnames) );
			if( false!==preg_match('/(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/i',$title,$m) ){
				$attr = shortcode_parse_atts( $m[3] );
				$attr = is_array($attr)?$attr:array();
				if(is_user_logged_in()){
					switch( $m[2] ){
						case 'logout':
						case 'loginout':
							$sorted_menu_items[$i]->title = isset($attr['logout'])&&trim($attr['logout'])!=''?$attr['logout']:__("Logout",'rhl');
							$sorted_menu_items[$i]->url = wp_logout_url( $item->url );
							break;
						default:
							unset($sorted_menu_items[$i]);
					}

				}else{
					switch( $m[2] ){
						case 'login':
						case 'loginout':
							$sorted_menu_items[$i]->title = isset($attr['login'])&&trim($attr['login'])!=''?$attr['login']:__("Login",'rhl');
							$sorted_menu_items[$i]->url = wp_login_url( $item->url );
							break;
						default:
							unset($sorted_menu_items[$i]);
					}
				}
			}
		}

		return $sorted_menu_items;
	}

	function addURLParameter($url, $paramName, $paramValue) {
	     $url_data = parse_url($url);
	     if(!isset($url_data["query"])){
		 	$url_data["query"]="";
		 }
	     $params = array();
	     parse_str($url_data['query'], $params);
	     $params[$paramName] = $paramValue;
	     $url_data['query'] = http_build_query($params);
	     return $this->build_url($url_data);
	}

	function build_url($url_data) {
	    $url="";
	    if(isset($url_data['host']))
	    {
	        $url .= $url_data['scheme'] . '://';
	        if (isset($url_data['user'])) {
	            $url .= $url_data['user'];
	                if (isset($url_data['pass'])) {
	                    $url .= ':' . $url_data['pass'];
	                }
	            $url .= '@';
	        }
	        $url .= $url_data['host'];
	        if (isset($url_data['port'])) {
	            $url .= ':' . $url_data['port'];
	        }
	    }
	    $url .= $url_data['path'];
	    if (isset($url_data['query'])) {
	        $url .= '?' . $url_data['query'];
	    }
	    if (isset($url_data['fragment'])) {
	        $url .= '#' . $url_data['fragment'];
	    }
	    return $url;
	}
}





?>
