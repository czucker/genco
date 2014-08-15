<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class modal_login_frontend {
	var $varname_trigger_modal = 'modal_login';
	var $plugin_url;
	var $development;
	var $wp_login_uri='';
	var $modal_login=false;
	var $is_login_page = false;
	function modal_login_frontend($args=array()){
		//------------
		$defaults = array(
			'varname_trigger_modal'	=> 'modal_login',
			'plugin_url'			=> '',
			'development'			=> false
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}
		//-----------
		global $rhl_plugin;	
		if( isset($_REQUEST['skip_modal_login']) && $_REQUEST['skip_modal_login']==$rhl_plugin->get_option('panic_key','',true)){
			add_action('login_form',array(&$this,'skip_modal_login'));
			return;
		}
		//-----------
		add_action('login_init',array(&$this,'login_init'));
		add_action('wp_head',array(&$this,'head'));
		add_action('admin_head',array(&$this,'head'));
		
		if('1'==$rhl_plugin->get_option('block_right_click','',true)){
			add_filter('body_class',array(&$this,'body_class'),10,1);
			add_action('wp_head',array(&$this,'wp_head'));
		}
		
		if('1'==$rhl_plugin->get_option('enable_maintenance','',true)){
			add_action('template_redirect',array(&$this,'maintenance_mode'),20);
		}
		
		if('1'==$rhl_plugin->get_option('enable_forced_login','',true)){
			add_action('template_redirect',array(&$this,'forced_login'),30);
		}
		
		if('1'!=$rhl_plugin->get_option('disable_jquery_check','',true)){
			add_action('init',array(&$this,'jquery_check'));
		}
		
		add_filter('filter_rh_css',array(&$this,'filter_rh_css'),10,1);
		
	}

	function jquery_check(){
		global $wp_scripts;
		if( $wp_scripts->registered && isset($wp_scripts->registered['jquery']) && $wp_scripts->registered['jquery']->ver < '1.7.2' ){
			//NOTE: if you want to avoid this, just go to Modal Log In -> Options -> Troubleshooting tab, and check Disable jQuery check
			wp_deregister_script('jquery');
			wp_enqueue_script( 'jquery', RHL_URL.'js/jquery-1.8.3.min.js', array(),'1.8.3');
		}		
	}
	
	function forced_login(){
		if( !is_user_logged_in() ){
			global $rhl_plugin;
			$url = wp_login_url();
			wp_safe_redirect( $url );
			die();
		}
	}
	
	function maintenance_mode(){
		if( !current_user_can('manage_options') ){
			global $rhl_plugin;
			$url = wp_login_url();
			$url = $rhl_plugin->addURLParameter($url, 'action', 'maintenance');
			wp_safe_redirect( $url );
			die();
		}
	}
	
	function wp_head(){
		echo "<script type=\"text/javascript\">jQuery('BODY').live('contextmenu',function(e){return false;});</script>";
	}
	
	function body_class($classes){
 		if(function_exists('debug_backtrace')){
			$arr = debug_backtrace();
			if('body_class'==@$arr[0]['function']){//assuming body_class is always called inside the body tag.
				echo 'oncontextmenu="return false;" ';			
			}		
		}
		return $classes;
	}
	
	function skip_modal_login(){
?>
<input type="hidden" name="skip_modal_login" value="<?php echo $_REQUEST['skip_modal_login']?>" />
<?php
	}
	
	function filter_rh_css($css){
		if(isset($_REQUEST['rhl_no_custom']))return $css;
		global $rhl_plugin;
		$css_output = $rhl_plugin->get_option('css_output','',true);
		
		$upload_dir = wp_upload_dir();					
		$dcurl = $upload_dir['baseurl'].'/'.$rhl_plugin->resources_path.'/';
		$css_output = str_replace('{dcurl}',$dcurl,$css_output);
		$css_output = str_replace('{pluginurl}',RHL_URL,$css_output);		
		
		return $css."\n/* START modal login custom css */\n".$css_output."\n/* END modal login custom css */\n";
	}
	
	function head_less(){
?>
<link rel="stylesheet" type="text/less" href="<?php echo $this->plugin_url?>css/style.less?ver=1.0.0">
<?php if($this->development):?>
<script type="text/javascript">if(!less){var less={};}less.env = 'development';</script>
<?php endif ?>
<script type='text/javascript' src='<?php echo $this->plugin_url?>js/less-1.3.0.min.js?ver=1.3.0'></script>
<?php	
	}
	
	function head(){			
		global $rhl_plugin;
		$rewrite_login = $rhl_plugin->get_option('rewrite_login','',true);
		$or_login = '';
		if(''!=$rewrite_login){
			$rewritten_login = sprintf('/%s',$rewrite_login);
			$or_login = "|| href.indexOf('$rewritten_login')>0";
		} 		
?>
<script type="text/javascript">
function replace_wp_login(){
	jQuery(document).ready(function($){
		$('a').each(function(i,inp){
			var href = $(inp).attr('href');
			if(href && (href.indexOf('wp-login.php')>0 <?php echo $or_login?>) ){
				if( $(inp).hasClass('not-modal') ){
					return;
				}
				$(inp)
					.addClass('rhl-modal-login')
					.attr('href','javascript:void(0);')
					.attr('rel',href)
					.live('click',function(e){				
						$('#rh-modal-login').data('rhl',$(e.target).attr('rel')).modal('show');
					})
				;			
			}
		});
	});
}

jQuery(document).ready(function($){
	var ajax_url = '<?php echo site_url('/')?>';
	var login_form = <?php echo json_encode($this->login_form())?>;
	$(login_form)
		.hide()
		.appendTo('body')
	;
	
	var options = {
		show:false
	};
	
	$('#rh-modal-login').modal(options);
	
	$('#rh-modal-login').on('hide',function(){
		$('.action-section').hide();		
	});
	
	$('#rh-modal-login').on('hidden',function(){
		$('.action-login' ).show();	
	});
	
	$('#rh-modal-login').on('show',function(){
		$('#rh-modal-login').find('.alert').remove();
		$('#user_login,#user_pass').val('');

		$('.action-section').hide();
		$('.action-login' ).show();
				
		var rel = $('#rh-modal-login').data('rhl');
		if(rel){
			var uri = parseUri( rel );
			if(uri && uri.queryKey){
				if(uri.queryKey.redirect_to ){
					$('#rh-modal-login').find('input[name=redirect_to]').val( unescape(uri.queryKey.redirect_to) );	
				}
				if(uri.queryKey.action){
					$('.action-section').hide();
					$('.action-' + uri.queryKey.action ).show();
					if('logout'==uri.queryKey.action){
						var args = {
							'rhl_action':'logout',
							'action':'logout',
							'_wpnonce':uri.queryKey._wpnonce||'',
							'redirect_to': uri.queryKey.redirect_to?unescape(uri.queryKey.redirect_to):ajax_url
						};					
						$.post(ajax_url,args,function(data){
							if(data.R=='OK'){
								window.location = data.redirect_to;
							}
						},'json');
					}
				}		
			}
		}
	});
	
	<?php if($this->wp_login_uri!=''):?>
	$('BODY').addClass('login');
	$('#rh-modal-login').data('rhl','<?php echo $this->wp_login_uri?>');
	<?php endif;?>
	
	<?php if($this->modal_login||isset($_REQUEST[$this->varname_trigger_modal])):?>
	$('#rh-modal-login').modal('show');
	/* what is this? when backdrop opacity is set to 0, modal shown is never triggered. problem in bootstrap.*/
	/*
	if( $('.modal-backdrop.fade.in').length && 0==$('.modal-backdrop.fade.in').css('opacity') ){
		$('.modal-backdrop.fade.in').css('opacity',0.00001);
	}
	*/
	<?php endif;?>
	
	//login action
	$('#rhl_dologin').live('click',function(e){
		var btn = this;
		$('#rh-modal-login').find('.alert').remove();	
		$('.rhl-spinner').fadeIn();
		$(btn).button('loading');
		var args = {
			'rhl_action':'login',
			'data':$('#loginform').serialize()
		};

		$.post(ajax_url,args,function(data){
			$(btn).button('reset');
			if(data.R=='OK'){
				$('#rh-modal-login').modal('hide');		
				if(data.redirect_to && data.redirect_to!=''){
					window.location = data.redirect_to;
				}
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);
				replace_wp_login();						
			}else{
				$('#rh-modal-login').find('.modal-body').prepend('<?php _e('Unknown error, please reload page and try again.','rhl')?>');		
			}
			$('.rhl-spinner').hide();
		},'json');
	});

	//lost password action	
	$('#rhl_lostpassword').live('click',function(e){
		var btn = this;
		$('#rh-modal-login').find('.alert').remove();	
		$('.rhl-spinner').fadeIn();
		$(btn).button('loading');
		var args = {
			'rhl_action':'lostpassword',
			'data':$('#lostpasswordform').serialize()
		};		
		$.post(ajax_url,args,function(data){
			$(btn).button('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);
				replace_wp_login();						
			}else{
				$('#rh-modal-login').find('.modal-body').prepend('<?php _e('Unknown error, please reload page and try again.','rhl')?>');		
			}
			$('.rhl-spinner').hide();
		},'json');		
	});
	
	//rp action
	$('#rhl_rp').live('click',function(e){
		var btn = this;
		$('#rh-modal-login').find('.alert').remove();	
		$('.rhl-spinner').fadeIn();
		$(btn).button('loading');
		var args = {
			'rhl_action':'rp',
			'data':$('#resetpassform').serialize()
		};		
		$.post(ajax_url,args,function(data){
			$(btn).button('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);
				$('#resetpassform,#rhl_rp').hide();
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);						
			}else{
				$('#rh-modal-login').find('.modal-body').prepend('<?php _e('Unknown error, please reload page and try again.','rhl')?>');		
			}
			replace_wp_login();
			$('.rhl-spinner').hide();
		},'json');		
	});	
	
	//register action	
	$('#rhl_register').live('click',function(e){
		var btn = this;
		$('#rh-modal-login').find('.alert').remove();	
		$('.rhl-spinner').fadeIn();
		$(btn).button('loading');
		var args = {
			'rhl_action':'register',
			'data':$('#registerform').serialize()
		};		
		$.post(ajax_url,args,function(data){
			$(btn).button('reset');
			if(data.R=='OK'){
				var _msg = '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);
			}else if(data.R=='ERR'){
				var _msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>'+data.MSG+'</div>';
				$('#rh-modal-login').find('.modal-body').prepend(_msg);						
			}else{
				$('#rh-modal-login').find('.modal-body').prepend('<?php _e('Unknown error, please reload page and try again.','rhl')?>');		
			}
			replace_wp_login();
			$('.rhl-spinner').hide();
		},'json');		
	});	
	
	//-- replace all links that contain wp-login.php
	replace_wp_login();	
	//-- lost password click
	
	<?php if(!$this->is_login_page && '0'==$rhl_plugin->get_option('disable_modal_bg','0',true)):?>
	//-- when used in frontend append the container for the image background
	try {
		var bg_html = <?php echo json_encode($this->bg_html())?>;
		var bg = $(bg_html);
		console.log(bg_html);
		$('BODY').prepend(bg.hide());
		
		$('#rh-modal-login').on('show',function(e){
			$('BODY').addClass('rhl-modal-opened');
			bg.fadeIn();
		});
		$('#rh-modal-login').on('hide',function(e){
			$('BODY').removeClass('rhl-modal-opened');
			bg.fadeOut();
		});
	}catch(e){}
	<?php endif;?>
	
	/* handle keypress enter */
	$(document).keypress(function(e) {
	    if (e.which == "13") { 	
	        var section = $(':focus').parents('.action-section');
			if( section.length>0 ){
				if( section.find('.input:last').is(':focus') ){
					if( section.hasClass('action-login') ){
						$('#rhl_dologin').trigger('click');	
						return false;
					}else if( section.hasClass('action-lostpassword') ){
						$('#rhl_lostpassword').trigger('click');	
						return false;
					}else if( section.hasClass('action-rp') ){
						$('#rhl_rp').trigger('click');	
						return false;
					}else if( section.hasClass('action-register') ){
						$('#rhl_register').trigger('click');	
						return false;
					}				
				}
			}
	    }       
	});	
});
</script>
<?php
	}
	
	function login_init(){
		global $rhl_plugin;
		$modal_login = $rhl_plugin->get_option('modal_login','1',true); 
		$this->modal_login = $modal_login=='1'?true:false;	
		//----
		if( isset($_REQUEST['edit']) ){
			if( current_user_can('modal_login_settings') ||  ( is_user_logged_in() && '1'==$rhl_plugin->get_option('demo_allow_edit_tool','0',true) ) ){
				require RHL_PATH.'includes/class.modal_login_frontend_admin.php';
				new modal_login_frontend_admin();			
			}
		}
		//----	
		if($this->modal_login||isset($_REQUEST[$this->varname_trigger_modal])){					
			//if($_SERVER['SCRIPT_NAME']=='/wp-login.php'){//does not supports subdirectory
			if( preg_match("/\/wp-login\.php/",$_SERVER['SCRIPT_NAME'],$matches) ){
				$this->is_login_page = true;
				
				add_action('wp_footer',array(&$this,'login_splash_footer'));
				//add_action('wp_head',array(&$this,'login_splash_head'));
				
				$this->wp_login_uri = $_SERVER['REQUEST_URI'];
				
				wp_enqueue_script('utils');
				wp_enqueue_script('user-profile');
				
				$this->login_splash();
			}
			
		}
	}
	
	function login_splash_head(){
		wp_admin_css( 'wp-admin', true );
		wp_admin_css( 'colors-fresh', true );	
	}
	
	function login_splash_footer($request_uri=false){
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	//$('#rh-modal-login').data('rhl',$(e.target).attr('rel')).modal('show');

	$('#rh-modal-login').on('hide',function(){
		window.location = '<?php echo site_url('/');?>';
	});
});
</script>
<?php	
	}
	
	function login_splash(){
		$title = __('Log In','rhl');
		if(isset($_REQUEST['action'])){
			switch( $_REQUEST['action'] ){
				case 'lostpassword':
					$title = __('Lost Password','rhl');
					break;
				case 'rp':
				case 'resetpass':
					$title = __('Reset Password','rhl');
					break;
				case 'register':
					$title = __('Registration Form','rhl');
					break;
			}
		}
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> &rsaquo; <?php echo $title; ?></title>
<?php
	if ( function_exists('wp_is_mobile') && wp_is_mobile() ) { ?>
		<meta name="viewport" content="width=320; initial-scale=0.9; maximum-scale=1.0; user-scalable=0;" /><?php
	}
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php @wp_head() ?>
</head>
<body <?php body_class(); ?>>
<?php echo $this->bg_html() ;?>
<?php @wp_footer() ?>
</body>
</html>
<?php
		die();
	}
	
	function bg_html(){
		global $rhl_plugin;
		ob_start();
?>
<div class="rhl-bg-container"><div class="rhl-bg-container2"><div class="rhl-bg-container3"></div></div></div>
<?php
		$html = ob_get_contents();
		ob_end_clean();
		return apply_filters('rhl_bg_html',$html);
	}
	
	function load_form(){
	
	}
	
	function login_form(){
		global $rhl_plugin;
		
		ob_start();
		$interim_login = false;
		$customize_login = false;
		
		$redirect_to = isset($_REQUEST['redirect_to'])&&!empty($_REQUEST['redirect_to'])?$_REQUEST['redirect_to']:'';//  site_url('')
		$lost_password_redirect_to = site_url('');
		
		$rememberme = false;
		
		$registration_redirect_to = apply_filters( 'registration_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );
		
		$modal_login_nonce = wp_create_nonce('modal_login_nonce');
		
		include $rhl_plugin->get_template_path().'modal_login_form.php';

		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	function form_label($id,$label,$echo=true){
		global $rhl_plugin;
		$label = $rhl_plugin->get_option('rhl_label_'.$id,$label,true);
		if($echo)echo $label;
		return $label;
	}
	
	function form_attr($id,$label){
		esc_attr_e( $this->form_label($id,$label,false) );
	}
}
?>