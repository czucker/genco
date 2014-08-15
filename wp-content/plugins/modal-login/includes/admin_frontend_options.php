<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

if( 'modal_login_frontend_admin'==get_class($this) ):
		//-- Modal settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-modal'; 
		$t[$i]->label 		= __('Modal','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl-modal-width',
				'type'				=> 'css',
				'label'				=> __('Width','rhl'),
				'input_type'		=> 'text',
				//'input_type'		=> 'element_size',
				'unit'				=> 'px',
				'class'				=> 'input-mini',
				//'class'				=> 'input-mini pop_rangeinput',
				'min'				=> '300',
				'max'				=> '1024',
				'step'				=> '1',
				'selector'			=> '#rh-modal-login',
				'property'			=> 'width',
				'real_time'			=> true
			),

			(object)array(
				'id'				=> 'rhl-modal-color',
				'type'				=> 'css',
				'label'				=> __('Font color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'btn_clear'			=> true,
				'selector'			=> '#rh-modal-login',
				'property'			=> 'color',
				'real_time'			=> true
			),
			
			//-- Border radius
			(object)array(
				'input_type'		=> 'grid_start'
			),							
			(object)array(
				'id'				=> 'rhl-modal-border-tl',
				'type'				=> 'css',
				//'label'				=> __('Top left','rhl'),
				'label'				=> __('Border radius','rhl'),
				//'input_type'		=> 'slider',
				'input_type'		=> 'text',
				'unit'				=> 'px',
				//'class'				=> 'input-mini pop_rangeinput',
				'class'				=> 'input-mini-45',
				'holder_class'		=> 'span6',
				'selector'			=> '#rh-modal-login,#rh-modal-login .rhl-modal-bg2,#rh-modal-login .modal-header',
				'property'			=> 'border-top-left-radius',
				'real_time'			=> true
			),
			(object)array(
				'id'				=> 'rhl-modal-border-tr',
				'type'				=> 'css',
				'label'				=> __('Top right','rhl'),
				'input_type'		=> 'text',
				'unit'				=> 'px',
				'class'				=> 'input-mini-45',
				'holder_class'		=> 'span6',		
				'selector'			=> '#rh-modal-login,#rh-modal-login .rhl-modal-bg2,#rh-modal-login .modal-header',
				'property'			=> 'border-top-right-radius',
				'real_time'			=> true
			),
			(object)array(
				'input_type'		=> 'grid_end'
			),
			(object)array(
				'input_type'		=> 'grid_start'
			),				
			(object)array(
				'id'				=> 'rhl-modal-border-bl',
				'type'				=> 'css',
				'label'				=> __('Bottom left','rhl'),
				'input_type'		=> 'text',
				'unit'				=> 'px',
				'class'				=> 'input-mini-45',
				'holder_class'		=> 'span6',		
				'selector'			=> '#rh-modal-login,#rh-modal-login .rhl-modal-bg2,#rh-modal-login .modal-footer',
				'property'			=> 'border-bottom-left-radius',
				'real_time'			=> true
			),
			(object)array(
				'id'				=> 'rhl-modal-border-br',
				'type'				=> 'css',
				'label'				=> __('Bottom right','rhl'),
				'input_type'		=> 'text',
				'unit'				=> 'px',
				'class'				=> 'input-mini-45',
				'holder_class'		=> 'span6',		
				'selector'			=> '#rh-modal-login,#rh-modal-login .rhl-modal-bg2,#rh-modal-login .modal-footer',
				'property'			=> 'border-bottom-right-radius',
				'real_time'			=> true
			),
			(object)array(
				'input_type'		=> 'grid_end'
			),	
			//-- end border radius					
			
			//-- primary background
			(object)array(
				'id'				=> 'rhl-modal-bg-gradient',
				'type'				=> 'css',
				'label'				=> __('Bottom layer background','rhl'),
				'input_type'		=> 'background_image',
				'opacity'			=> true,
				'selector'			=> '#rh-modal-login',
				'property'			=> 'background-image',
				'blank_value'		=> 'transparent',
				'real_time'			=> true,
				'btn_clear'			=> true,
				'holder_class'		=> 'rhl-section-separator'
			),	
			(object)array(
				'id'				=> 'rhl-modal-bg-color',
				'type'				=> 'css',
				'label'				=> __('Background color','rhl'),
				'input_type'		=> 'color_or_something_else',
				'other_options'		=> array(
					'transparent'	=> 'transparent'
				),	
				'opacity'			=> true,
				'btn_clear'			=> true,
				'selector'			=> '#rh-modal-login',
				'property'			=> 'background-color',
				'real_time'			=> true
			),	
			
			//--- other background			
			(object)array(
				'input_type'		=> 'grid_start'
			),							
			(object)array(
				'id'				=> 'rhl-modal-bg1-repeat',
				'type'				=> 'css',
				'label'				=> __('Repeat','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',
				'selector'			=> '#rh-modal-login',
				'options'			=> array(
					'repeat'		=> __('repeat','rhl'),
					'repeat-x'		=> __('repeat-x','rhl'),
					'repeat-y'		=> __('repeat-y','rhl'),
					'no-repeat'		=> __('no-repeat','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-repeat',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-modal-bg1-attachment',
				'type'				=> 'css',
				'label'				=> __('Attachment','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login',
				'options'			=> array(
					'scroll'		=> __('scroll','rhl'),
					'fixed'			=> __('fixed','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-attachment',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-modal-bg1-position',
				'type'				=> 'css',
				'label'				=> __('Position','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login',
				'options'			=> array(
					'left top'			=> __('left top','rhl'),
					'left center'		=> __('left center','rhl'),
					'left bottom'		=> __('left bottom','rhl'),
					'right top'			=> __('right top','rhl'),
					'right center'		=> __('right center','rhl'),
					'right bottom'		=> __('right bottom','rhl'),
					'center top'		=> __('center top','rhl'),
					'center center'		=> __('center center','rhl'),
					'center bottom'		=> __('center bottom','rhl'),
					//'x% y%'				=> __('x% y%','rhl'),
					//'xpos ypos'			=> __('xpos ypos','rhl'),
					'inherit'			=> __('inherit','rhl')
				),
				'property'			=> 'background-position',
				'real_time'			=> true
			),
			(object)array(
				'input_type'		=> 'grid_end'
			),
			//-- secondary background
			(object)array(
				'id'				=> 'rhl-modal-bg2-gradient',
				'type'				=> 'css',
				'label'				=> __('Top layer background','rhl'),
				'input_type'		=> 'background_image',
				'opacity'			=> true,
				'selector'			=> '#rh-modal-login .rhl-modal-bg2',
				'property'			=> 'background-image',
				'blank_value'		=> 'transparent',
				'real_time'			=> true,
				'btn_clear'			=> true,
				'holder_class'		=> 'rhl-section-separator'
			),	
			(object)array(
				'id'				=> 'rhl-modal-bg2-color',
				'type'				=> 'css',
				'label'				=> __('Background color','rhl'),
				'input_type'		=> 'color_or_something_else',
				'other_options'		=> array(
					'transparent'	=> 'transparent'
				),	
				'opacity'			=> true,
				'btn_clear'			=> true,
				'selector'			=> '#rh-modal-login .rhl-modal-bg2',
				'property'			=> 'background-color',
				'real_time'			=> true
			),	
			
			//--- secondary background other background			
			(object)array(
				'input_type'		=> 'grid_start'
			),							
			(object)array(
				'id'				=> 'rhl-modal-bg2-repeat',
				'type'				=> 'css',
				'label'				=> __('Repeat','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',
				'selector'			=> '#rh-modal-login .rhl-modal-bg2',
				'options'			=> array(
					'repeat'		=> __('repeat','rhl'),
					'repeat-x'		=> __('repeat-x','rhl'),
					'repeat-y'		=> __('repeat-y','rhl'),
					'no-repeat'		=> __('no-repeat','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-repeat',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-modal-bg2-attachment',
				'type'				=> 'css',
				'label'				=> __('Attachment','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login .rhl-modal-bg2',
				'options'			=> array(
					'scroll'		=> __('scroll','rhl'),
					'fixed'			=> __('fixed','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-attachment',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-modal-bg2-position',
				'type'				=> 'css',
				'label'				=> __('Position','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login .rhl-modal-bg2',
				'options'			=> array(
					'left top'			=> __('left top','rhl'),
					'left center'		=> __('left center','rhl'),
					'left bottom'		=> __('left bottom','rhl'),
					'right top'			=> __('right top','rhl'),
					'right center'		=> __('right center','rhl'),
					'right bottom'		=> __('right bottom','rhl'),
					'center top'		=> __('center top','rhl'),
					'center center'		=> __('center center','rhl'),
					'center bottom'		=> __('center bottom','rhl'),
					//'x% y%'				=> __('x% y%','rhl'),
					//'xpos ypos'			=> __('xpos ypos','rhl'),
					'inherit'			=> __('inherit','rhl')
				),
				'property'			=> 'background-position',
				'real_time'			=> true
			),
			(object)array(
				'input_type'		=> 'grid_end'
			)			

		);
		//-- Modal settings -----------------------		
/*
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-modal'; 
		$t[$i]->label 		= __('Modal background','rhl');
*/		
		//-- Header settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-header'; 
		$t[$i]->label 		= __('Header','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl-header-border-color',
				'type'				=> 'css',
				'label'				=> __('Border color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'selector'			=> '.modal.rhlogin .modal-header',
				'property'			=> 'border-bottom-color',
				'real_time'			=> true,
				'btn_clear'			=> true
			),
			(object)array(
				'id'				=> 'rhl-header-color',
				'type'				=> 'css',
				'label'				=> __('Font color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'selector'			=> '.modal.rhlogin .modal-header',
				'property'			=> 'color',
				'real_time'			=> true,
				'btn_clear'			=> true
			),
			(object)array(
				'id'				=> 'rhl-header-margin-top',
				'type'				=> 'css',
				//'label'				=> __('Top left','rhl'),
				'label'				=> __('Title top margin','rhl'),
				//'input_type'		=> 'slider',
				'input_type'		=> 'text',
				'unit'				=> 'px',
				//'class'				=> 'input-mini pop_rangeinput',
				'class'				=> 'input-mini-45',
				'selector'			=> '.modal.rhlogin .modal-header h3',
				'property'			=> 'margin-top',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-header-height',
				'type'				=> 'css',
				//'label'				=> __('Top left','rhl'),
				'label'				=> __('Height','rhl'),
				//'input_type'		=> 'slider',
				'input_type'		=> 'text',
				'unit'				=> 'px',
				//'class'				=> 'input-mini pop_rangeinput',
				'class'				=> 'input-mini-45',
				'min'				=> '0',
				'max'				=> '30',
				'step'				=> '1',
				'selector'			=> '#rh-modal-login .modal-header',
				'property'			=> 'height',
				'real_time'			=> true
			),			
			//-- header background
			(object)array(
				'id'				=> 'rhl-header-bg-gradient',
				'type'				=> 'css',
				'label'				=> __('Header background','rhl'),
				'input_type'		=> 'background_image',
				'opacity'			=> true,
				'selector'			=> '#rh-modal-login .modal-header',
				'property'			=> 'background-image',
				'blank_value'		=> 'transparent',
				'real_time'			=> true,
				'btn_clear'			=> true,
				'holder_class'		=> 'rhl-section-separator'
			),	
			(object)array(
				'id'				=> 'rhl-header-bg-color',
				'type'				=> 'css',
				'label'				=> __('Background color','rhl'),
				'input_type'		=> 'color_or_something_else',
				'other_options'		=> array(
					'transparent'	=> 'transparent'
				),	
				'opacity'			=> true,
				'btn_clear'			=> true,
				'selector'			=> '#rh-modal-login .modal-header',
				'property'			=> 'background-color',
				'real_time'			=> true
			),	
			
			//--- header background other background			
			(object)array(
				'input_type'		=> 'grid_start'
			),							
			(object)array(
				'id'				=> 'rhl-header-bg-repeat',
				'type'				=> 'css',
				'label'				=> __('Repeat','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',
				'selector'			=> '#rh-modal-login .modal-header',
				'options'			=> array(
					'repeat'		=> __('repeat','rhl'),
					'repeat-x'		=> __('repeat-x','rhl'),
					'repeat-y'		=> __('repeat-y','rhl'),
					'no-repeat'		=> __('no-repeat','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-repeat',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-header-bg-attachment',
				'type'				=> 'css',
				'label'				=> __('Attachment','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login .modal-header',
				'options'			=> array(
					'scroll'		=> __('scroll','rhl'),
					'fixed'			=> __('fixed','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-attachment',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-header-bg-position',
				'type'				=> 'css',
				'label'				=> __('Position','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '#rh-modal-login .modal-header',
				'options'			=> array(
					'left top'			=> __('left top','rhl'),
					'left center'		=> __('left center','rhl'),
					'left bottom'		=> __('left bottom','rhl'),
					'right top'			=> __('right top','rhl'),
					'right center'		=> __('right center','rhl'),
					'right bottom'		=> __('right bottom','rhl'),
					'center top'		=> __('center top','rhl'),
					'center center'		=> __('center center','rhl'),
					'center bottom'		=> __('center bottom','rhl'),
					//'x% y%'				=> __('x% y%','rhl'),
					//'xpos ypos'			=> __('xpos ypos','rhl'),
					'inherit'			=> __('inherit','rhl')
				),
				'property'			=> 'background-position',
				'real_time'			=> true
			),
			(object)array(
				'input_type'		=> 'grid_end'
			)						
		);
		//-- Footer settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-footer'; 
		$t[$i]->label 		= __('Footer','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl-footer-bg-color',
				'type'				=> 'css',
				'label'				=> __('Background color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'selector'			=> '.modal.rhlogin .modal-footer',
				'property'			=> 'background-color',
				'blank_value'		=> 'transparent',
				'real_time'			=> true,
				'btn_clear'			=> true
			),
			(object)array(
				'id'				=> 'rhl-footer-border-color',
				'type'				=> 'css',
				'label'				=> __('Border color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'selector'			=> '.modal.rhlogin .modal-footer',
				'property'			=> 'border-top-color',
				'real_time'			=> true,
				'btn_clear'			=> true
			)						
		);		
		//-- Text fields settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-form'; 
		$t[$i]->label 		= __('Text fields','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl-input-text-height',
				'type'				=> 'css',
				'label'				=> __('Height','rhl'),
				'input_type'		=> 'text',
				'class'				=> 'input-mini',
				'min'				=> '5',
				'max'				=> '50',
				'step'				=> '1',				
				'selector'			=> ".modal.rhlogin input[type='text'],.modal.rhlogin input[type='password'],.modal.rhlogin input[type='email']",
				'property'			=> 'height',
				'unit'				=> 'px',
				'real_time'			=> true,
				'btn_clear'			=> true
								
			),	
			(object)array(
				'id'				=> 'rhl-input-text-font-size',
				'type'				=> 'css',
				'label'				=> __('Font size','rhl'),
				'input_type'		=> 'text',
				'class'				=> 'input-mini',
				'min'				=> '5',
				'max'				=> '50',
				'step'				=> '1',				
				'selector'			=> ".modal.rhlogin input[type='text'],.modal.rhlogin input[type='password'],.modal.rhlogin input[type='email']",
				'property'			=> 'font-size',
				'unit'				=> 'px',
				'real_time'			=> true,
				'btn_clear'			=> true
								
			),	
			(object)array(
				'id'				=> 'rhl-input-text-font-color',
				'type'				=> 'css',
				'label'				=> __('Font color','rhl'),
				'input_type'		=> 'colorpicker',
				'class'				=> 'input-mini',
				'selector'			=> ".modal.rhlogin input[type='text'],.modal.rhlogin input[type='password'],.modal.rhlogin input[type='email']",
				'property'			=> 'color',
				'real_time'			=> true,
				'btn_clear'			=> true
								
			),	
			(object)array(
				'id'				=> 'rhl-input-text-bg-color',
				'type'				=> 'css',
				'label'				=> __('Background color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'class'				=> 'input-mini',	
				'selector'			=> ".modal.rhlogin input[type='text'],.modal.rhlogin input[type='password'],.modal.rhlogin input[type='email']",
				'property'			=> 'background-color',
				'real_time'			=> true,
				'btn_clear'			=> true
								
			),	
			(object)array(
				'id'				=> 'rhl-input-text-border-color',
				'type'				=> 'css',
				'label'				=> __('Border color','rhl'),
				'input_type'		=> 'colorpicker',
				'opacity'			=> true,
				'class'				=> 'input-mini',	
				'selector'			=> ".modal.rhlogin input[type='text'],.modal.rhlogin input[type='password'],.modal.rhlogin input[type='email']",
				'property'			=> 'border-color',
				'real_time'			=> true,
				'btn_clear'			=> true
			)
		);
		
		$buttons = array(
			(object)array(
				'id'		=> 'rhl-btn-default',
				'label'		=> __('Default button','rhl'),
				'selector'	=> '.modal.rhlogin .btn-default',
				'btn_class'	=> '.btn'
			),
			(object)array(
				'id'		=> 'rhl-btn-primary',
				'label'		=> __('Primary button','rhl'),
				'selector'	=> '.modal.rhlogin .btn-primary',
				'btn_class'	=> '.btn-primary'
			)
		);
		
		foreach($buttons as $button){
			//-- btn-primary settings -----------------------		
			$i++;
			$t[$i]=(object)array();
			$t[$i]->id 			= $button->id; 
			$t[$i]->label 		= $button->label;
			$t[$i]->options = array(
				(object)array(
					'id'				=> $button->id.'-bg-gradient',
					'type'				=> 'css',
					'label'				=> __('Background color gradient','rhl'),
					'input_type'		=> 'color_gradient',
					'opacity'			=> true,
					'selector'			=> $button->selector,
					'property'			=> 'background-image',
					'blank_value'		=> 'transparent',
					'real_time'			=> true,
					'btn_clear'			=> false,
					'derived'			=> array(
						array(
							'type'	=> 'gradient_darken',
							'val'	=> '.1',
							'sel'	=> ".modal.rhlogin {$button->btn_class},.modal.rhlogin {$button->btn_class}:hover,.modal.rhlogin {$button->btn_class}:active,.modal.rhlogin {$button->btn_class}.active,.modal.rhlogin {$button->btn_class}.disabled,.modal.rhlogin {$button->btn_class}[disabled]",
							'arg'	=> array(
								(object)array(
									'name' => 'background-color',
									'tpl'	=>'__value__'
								),
								(object)array(
									'name' => '*background-color',
									'tpl'	=>'__value__'
								)
							)
						),
						array(
							'type'	=> 'gradient_darken',
							'val'	=> '1',
							'sel'	=> ".modal.rhlogin input{$button->btn_class}[disabled]",
							'arg'	=> array(
								(object)array(
									'name' => 'border-color',
									'tpl'	=>'__value__'
								)
							)
						) 
					)
				),
				(object)array(
					'id'				=> $button->id.'-height',
					'type'				=> 'css',
					'label'				=> __('Line height','rhl'),
					'input_type'		=> 'text',
					'class'				=> 'input-mini',
					'min'				=> '5',
					'max'				=> '50',
					'step'				=> '1',				
					'selector'			=> $button->selector,
					'property'			=> 'line-height',
					'unit'				=> 'px',
					'real_time'			=> true,
					'btn_clear'			=> true
									
				),	
				(object)array(
					'id'				=> $button->id.'-font-size',
					'type'				=> 'css',
					'label'				=> __('Font size','rhl'),
					'input_type'		=> 'font',
					'class'				=> 'input-mini',
					'min'				=> '5',
					'max'				=> '50',
					'step'				=> '1',				
					'selector'			=> $button->selector,
					'property'			=> 'font-size',
					'unit'				=> 'px',
					'real_time'			=> true,
					'btn_clear'			=> true
									
				),			
				
				(object)array(
					'id'				=> $button->id.'-font-color',
					'type'				=> 'css',
					'label'				=> __('Font color','rhl'),
					'input_type'		=> 'colorpicker',
					'class'				=> 'input-mini',
					'selector'			=> $button->selector,
					'property'			=> 'color',
					'real_time'			=> true,
					'btn_clear'			=> true
									
				),	
				(object)array(
					'id'				=> $button->id.'-text-shadow',
					'type'				=> 'css',
					'label'				=> __('Font shadow color','rhl'),
					'input_type'		=> 'textshadow',
					//'class'				=> 'input-mini',
					'selector'			=> $button->selector,
					'property'			=> 'text-shadow',
					'real_time'			=> true,
					'btn_clear'			=> true
									
				)			
				/*
				,(object)array(
					'id'				=> 'rhl-btn-primary-bg-color',
					'type'				=> 'css',
					'label'				=> __('Background color','rhl'),
					'input_type'		=> 'colorpicker',
					'class'				=> 'input-mini',	
					'selector'			=> ".modal.rhlogin .btn-primary",
					'property'			=> 'background-color',
					'real_time'			=> true,
					'btn_clear'			=> true
				)
				*/
			);		
		}
		
		//-- Logout settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-logout'; 
		$t[$i]->label 		= __('Logout','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl-logout-spinner-bg',
				'type'				=> 'css',
				'label'				=> __('Loading image','rhl'),
				'input_type'		=> 'background_image',
				'opacity'			=> true,
				'selector'			=> '.rhlogin div.action-section.action-logout',
				'property'			=> 'background-image',
				'blank_value'		=> 'transparent',
				'real_time'			=> true,
				'btn_clear'			=> true,
				'holder_class'		=> 'rhl-section-separator rhl-admin-custom-logout-spinner'
			),
			(object)array(
				'id'				=> 'rhl-logout-spinner-position',
				'type'				=> 'css',
				'label'				=> __('Position','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				//'holder_class'		=> 'span4',				
				'selector'			=> '.rhlogin div.action-section.action-logout',
				'options'			=> array(
					'left top'			=> __('left top','rhl'),
					'left center'		=> __('left center','rhl'),
					'left bottom'		=> __('left bottom','rhl'),
					'right top'			=> __('right top','rhl'),
					'right center'		=> __('right center','rhl'),
					'right bottom'		=> __('right bottom','rhl'),
					'center top'		=> __('center top','rhl'),
					'center center'		=> __('center center','rhl'),
					'center bottom'		=> __('center bottom','rhl'),
					//'x% y%'				=> __('x% y%','rhl'),
					//'xpos ypos'			=> __('xpos ypos','rhl'),
					'inherit'			=> __('inherit','rhl')
				),
				'property'			=> 'background-position',
				'real_time'			=> true
			),
			(object)array(
				'id'				=> 'rhl-logout-spinner-size',
				'type'				=> 'css',
				'label'				=> __('Size','rhl'),
				'input_type'		=> 'background_size',
				'class'				=> '',
				'holder_class'		=> '',				
				'selector'			=> '.rhlogin div.action-section.action-logout',
				'other_options'		=> array(
					'length'			=> __('Length','rhl'),
					'percentage'		=> __('Percentage','rhl'),
					'cover'				=> __('Cover','rhl'),
					'contain'			=> __('Contain','rhl')
				),
				'property'			=> 'background-size',
				'real_time'			=> true
			)				
		);
		
		//-- Overlay settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-overlay'; 
		$t[$i]->label 		= __('Overlay','rhl');
		$t[$i]->options = array(
			/*
			(object)array(
				'id'				=> 'rhl-overlay-opacity',
				'type'				=> 'css',
				'label'				=> __('Opacity','rhl'),
				'input_type'		=> 'slider',
				'class'				=> 'input-mini pop_rangeinput',
				'min'				=> '0',
				'max'				=> '1',
				'step'				=> '0.01',				
				'selector'			=> '.modal-backdrop.fade.in',
				'property'			=> 'opacity',
				'real_time'			=> true
			),
			*/
			(object)array(
				'id'				=> 'rhl-overlay-background-color',
				'type'				=> 'css',
				'label'				=> __('Overlay color','rhl'),
				'input_type'		=> 'color_or_something_else',
				'other_options'		=> array(
					'transparent'	=> 'transparent'
				),	
				'opacity'			=> true,
				'selector'			=> '.modal-backdrop',
				'property'			=> 'background-color',
				'real_time'			=> true
			),
			(object)array(
				'id'				=> 'rhl-overlay-z-index',
				'type'				=> 'css',
				'label'				=> __('z-index','rhl'),
				'input_type'		=> 'text',
				'selector'			=> '.modal-backdrop',
				'property'			=> 'z-index',
				'real_time'			=> true
			)
		);
		//-------------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-bg1'; 
		$t[$i]->label 		= __('Overlay back Background','rhl');
		$t[$i]->options = array(
/*
			(object)array(
				'id'				=> 'rhl-overlay-bg1-color-ref',
				'type'				=> 'css',
				'label'				=> __('Reference-Color','rhl'),
				'input_type'		=> 'colorpicker',
				'selector'			=> '.rhl-bg-container-ref',
				'property'			=> 'background-color',
				'opacity'			=> true,
				'real_time'			=> true
			),	
*/

			(object)array(
				'id'				=> 'rhl-overlay-bg1-image',
				'type'				=> 'css',
				'label'				=> __('Image','rhl'),
				//'input_type'		=> 'image_url',
				'input_type'		=> 'background_image',
				'selector'			=> '.rhl-bg-container',
				'property'			=> 'background-image',
				'opacity'			=> true,
				'btn_clear'			=> true,
				'real_time'			=> true
			),	
			(object)array(
				'id'				=> 'rhl-overlay-bg1-color',
				'type'				=> 'css',
				'label'				=> __('Color','rhl'),
			//	'input_type'		=> 'colorpicker',
				'input_type'		=> 'color_or_something_else',
				'selector'			=> '.rhl-bg-container',
				'property'			=> 'background-color',
				'other_options'		=> array(
					'transparent'	=> 'transparent'
				),
				'btn_clear'			=> true,
				'opacity'			=> true,
				'real_time'			=> true
			),	
			//--- other background			
			(object)array(
				'input_type'		=> 'grid_start'
			),							
			(object)array(
				'id'				=> 'rhl-overlay-bg1-repeat',
				'type'				=> 'css',
				'label'				=> __('Repeat','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',
				'selector'			=> '.rhl-bg-container',
				'options'			=> array(
					'repeat'		=> __('repeat','rhl'),
					'repeat-x'		=> __('repeat-x','rhl'),
					'repeat-y'		=> __('repeat-y','rhl'),
					'no-repeat'		=> __('no-repeat','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-repeat',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-overlay-bg1-attachment',
				'type'				=> 'css',
				'label'				=> __('Attachment','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '.rhl-bg-container',
				'options'			=> array(
					'scroll'		=> __('scroll','rhl'),
					'fixed'			=> __('fixed','rhl'),
					'inherit'		=> __('inherit','rhl')
				),
				'property'			=> 'background-attachment',
				'real_time'			=> true
			),		
			(object)array(
				'id'				=> 'rhl-overlay-bg1-position',
				'type'				=> 'css',
				'label'				=> __('Position','rhl'),
				'input_type'		=> 'select',
				'class'				=> 'input-wide',
				'holder_class'		=> 'span4',				
				'selector'			=> '.rhl-bg-container',
				'options'			=> array(
					'left top'			=> __('left top','rhl'),
					'left center'		=> __('left center','rhl'),
					'left bottom'		=> __('left bottom','rhl'),
					'right top'			=> __('right top','rhl'),
					'right center'		=> __('right center','rhl'),
					'right bottom'		=> __('right bottom','rhl'),
					'center top'		=> __('center top','rhl'),
					'center center'		=> __('center center','rhl'),
					'center bottom'		=> __('center bottom','rhl'),
					//'x% y%'				=> __('x% y%','rhl'),
					//'xpos ypos'			=> __('xpos ypos','rhl'),
					'inherit'			=> __('inherit','rhl')
				),
				'property'			=> 'background-position',
				'real_time'			=> true
			),		
			(object)array(
				'input_type'		=> 'grid_end'
			),
			(object)array(
				'id'				=> 'rhl-overlay-bg1-size',
				'type'				=> 'css',
				'label'				=> __('Size','rhl'),
				'input_type'		=> 'background_size',
				'class'				=> '',
				'holder_class'		=> '',				
				'selector'			=> '.rhl-bg-container',
				'other_options'		=> array(
					'length'			=> __('Length','rhl'),
					'percentage'		=> __('Percentage','rhl'),
					'cover'				=> __('Cover','rhl'),
					'contain'			=> __('Contain','rhl')
				),
				'property'			=> 'background-size',
				'real_time'			=> true
			)				
			//--- end other background fields		
		);
		
		//-- Saved and DC  -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-saved-list'; 
		$t[$i]->label 		= __('Templates','rhl');
		$t[$i]->options = array(
			(object)array(
				'id'				=> 'rhl_saved_settings',
				'input_type'		=> 'callback',
				'callback'			=> array(&$this,'tab_saved_list')
			)			
		);		
endif;
?>