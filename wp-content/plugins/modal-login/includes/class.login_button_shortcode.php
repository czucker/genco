<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class login_button_shortcode {
	function login_button_shortcode($shortcode='modal_login_button'){
		add_shortcode($shortcode, array(&$this,'handle_shortcode'));
	}
	
	function handle_shortcode($atts,$template='',$code=""){
		extract(shortcode_atts(array(
			'href'			=> '#rh-modal-login',
			'label'				=> __('Log in','rhl'),
			'description'		=> __('Click to log in','rhl'),
			'class'				=> '',
			'type'				=> 'btn-primary',//also takes, '', 'btn-primary', 'btn-info', 'btn-success', 'btn-warning', 'btn-danger', 'btn-inverse', 'btn-link'
			'align'				=> 'rhl-inline',//rhl-left rhl-right rhl-center rhl-float-left rhl-float-right rhl-inline
			'size'				=> '',// also takes: 'btn-large', 'btn-small', 'btn-mini'
			'logged'			=> 'logout',//also takes: 'hide', 
			'registration'		=> '0',
			'logout_label'		=> __('Logout','rhl'),
			'logout_type'		=> 'btn-danger',//also takes the same as the type arg
			'logout_description'=> __('Click to log out','rhl')
		), $atts));
		
		$output = '';
		if(is_user_logged_in()){
			if('logout'==$logged){
				$output = sprintf('<div class="rhlogin %s"><a class="btn %s %s %s" href="%s" title="%s">%s</a></div>',
					$align,
					$class,
					$logout_type,
					$size,
					wp_logout_url(),
					$logout_description,
					$logout_label
				);
			}
		}else{
			$output = sprintf('<div class="rhlogin %s"><a class="btn %s %s %s" data-toggle="modal" href="%s" title="%s">%s</a></div>',
				$align,
				$class,
				$type,
				$size,
				$href,
				$description,
				$label
			);
		}
		
		return $output;
	}	
}
?>