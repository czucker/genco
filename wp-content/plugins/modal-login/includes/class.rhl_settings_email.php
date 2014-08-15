<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhl_settings_email {
	function rhl_settings_email($plugin_id='rhl'){
		$this->id = $plugin_id.'-email';
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
	}
		
	function options($t){
		global $rhl_plugin;
		//-- Reset password email -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-email-register'; 
		$t[$i]->label 		= __('Registration email','rhl');
		$t[$i]->right_label	= __('Registration email','rhl');
		$t[$i]->page_title	= __('Registration email','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'email_register_title',
				'label'		=> __('Email title','rhl'),
				'type'		=> 'text',
				'description'=> sprintf("<h3>%s</h3><p><strong>%s</strong> %s</p><p>%s</p>",
					__('Email title usable tags','rhl'),
					'{blogname}',
					__('Will be replaced with the blog name.','rhl'),
					__('Leave blank for no customization','rhl')
				),					
				'el_properties'	=>  array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'email_register_is_html',
				'label'		=> __('Html content','rhl'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description'=> __('Choose yes if the content of the email is to be sent as html.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),			
			(object)array(
				'id'		=> 'email_register_content',
				'label'		=> __('Email content','rhl'),
				'type'		=> 'textarea',
				'description'=> sprintf("<h3>%s</h3><p><strong>%s</strong> %s</p><p><strong>%s</strong> %s</p><p><strong>%s</strong> %s</p><p><strong>%s</strong> %s</p><p>%s</p>",
					__('Email content usable tags','rhl'),
					'{user_login}',
					__('The login username.','rhl'),
					'{user_pass}',
					__('The login password.','rhl'),
					'{url}',
					__('The login link','rhl'),		
					'{blogname}',
					__('The blog name','rhl'),			
					__('Leave blank for no customization','rhl')
				),				
				'el_properties'	=>  array('class'=>'text-width-full','rows'=>'10'),
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

		//-- Reset password email -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-email-rp'; 
		$t[$i]->label 		= __('Reset password email','rhl');
		$t[$i]->right_label	= __('Reset password email','rhl');
		$t[$i]->page_title	= __('Reset password email','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'email_rp_title',
				'label'		=> __('Email title','rhl'),
				'type'		=> 'text',
				'description'=> sprintf("<h3>%s</h3><p><strong>%s</strong> %s</p><p>%s</p>",
					__('Email title usable tags','rhl'),
					'{blogname}',
					__('Will be replaced with the blog name.','rhl'),
					__('Leave blank for no customization','rhl')
				),				
				'el_properties'	=>  array('class'=>'text-width-full'),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'email_rp_is_html',
				'label'		=> __('Html content','rhl'),
				'type'		=> 'yesno',
				'default'	=> '1',
				'description'=> __('Choose yes if the content of the email is to be sent as html.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),		
			(object)array(
				'id'		=> 'email_rp_content',
				'label'		=> __('Email content','rhl'),
				'type'		=> 'textarea',
				'description'=> sprintf("<h3>%s</h3><p><strong>%s</strong> %s</p><p><strong>%s</strong> %s</p><p><strong>%s</strong> %s</p><p>%s</p>",
					__('Email content usable tags','rhl'),
					'{home}',
					__('The blogs home page.','rhl'),
					'{user_login}',
					__('The accounts username.','rhl'),
					'{url}',
					__('The link to reset the password.','rhl'),
					__('Leave blank for no customization','rhl')
				),
				'el_properties'	=>  array('class'=>'text-width-full','rows'=>'10'),
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
		//-------------------------------------------
		$i++;
		@$t[$i]->id 			= 'rhl_email_template_list'; 
		$t[$i]->label 		= __('Saved and downloaded email templates','rhl');//title on tab
		$t[$i]->right_label = __('Restore saved or downloaded settings','rhl');
		$t[$i]->page_title	= __('Saved and downloaded email templates','rhl');//title on content
		//$t[$i]->open = true;		
		$t[$i]->options = array(
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Backup email templates','rhl')	
			),
			(object)array(
				'id'			=> 'rhl-et-save-btn',
				'type'			=>'save_settings',
				'label'			=>__('Brief description','rhl'),
				'export_fields'	=> array('email_register_title', 'email_register_content', 'email_rp_title', 'email_rp_content' ),
				'description'	=> __('This will save a copy of the email template settings.','rhl'),
				'button_label'	=> __('Backup current settings','rhl')	
			),
			(object)array(
				'type'=>'clear'
			),
			(object)array(
				'type'=>'subtitle',
				'label'=>__('Stored Settings','rhl')	
			),
			(object)array(
				'id'		=> 'popex-list-rhl-et',
				'type'		=> 'saved_settings_list',
				'anygroup'	=> true
			),
			(object)array(
				'type'=>'clear'
			)
		);
		//----		
		
		return $t;
	}
}
?>