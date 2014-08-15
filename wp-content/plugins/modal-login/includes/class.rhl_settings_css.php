<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2003
 **/
class rhl_settings_css {
	var $added_rules;
	function rhl_settings_css($plugin_id='rhl'){
		$this->id = $plugin_id.'-css';
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);
		add_action("pop_admin_head_{$this->id}",array(&$this,'admin_head'));
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),50,1);
	}

	function options($t){
		global $rhl_plugin;
		//-- Template settings -----------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-templates';
		$t[$i]->label 		= __('Template settings','rhl');
		$t[$i]->right_label	= __('Template settings','rhl');
		$t[$i]->page_title	= __('Template settings','rhl');
		$t[$i]->open = true;
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'main_template',
				'label'		=> __('Main template','rhl'),
				'type'		=> 'select',
				'options'	=> array(
					'modal_login_form.php' => __('Default','rhl'),
					'modal_login_form_swapped.php' => __('Default swapped','rhl'),
					'modal_login_form_same.php' => __('Buttons in footer (action buttons on the right)','rhl'),
					'modal_login_form_same_swapped.php' => __('Buttons in footer (action buttons on the left)','rhl'),
					'modal_form_buttons_left.php' => __('Banner style social media buttons on left', 'rhl'),
					'modal_form_buttons_right.php' => __('Banner style social media buttons on right', 'rhl'),
					'modal_form_buttons_only.php' => __('Banner style buttons only', 'rhl'),
				),
				'default'	=> 'modal_login_form.php',
				'description'=> sprintf('<p><b>%s</b>: %s</p><p><b>%s</b>: %s</p><p><b>%s</b>: %s</p>',
					__('Default','rhl'),
					__('This is the original login layout','rhl'),
					__('Default swapped','rhl'),
					__('Similar to the default but the form controls and the form links are swapped.','rhl'),
					__('Buttons in footer','rhl'),
					__('All buttons are placed in the footer','rhl')
				),
				//'hidegroup' => '#icon_style_group',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'type'=>'clear'
			),
			(object)array(
				'id' => 'icon_style_group',
				'type' => 'div_start'
			),
			// (object)array(
			// 	'id' => 'icon_styles',
			// 	'type' => 'radio',
			// 	'options' => array(
			// 		'0' => __('Default buttons 32 x 32px','rhl'),
			// 	),
			// 	'description' => __('Button sizes','rhl'),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			// (object)array(
			// 	'id' => 'icon_styles',
			// 	'type' => 'radio',
			// 	'options' => array(
			// 		'1' => __('Small buttons 16 x 16px','rhl'),
			// 	),
			// 	'description' => __('Button sizes','rhl'),
			// 	'el_properties' => array(),
			// 	'save_option' =>true,
			// 	'load_option' =>true
			// ),
			(object)array(
				'id' => 'icon_styles',
				'type' => 'radio',
				'options' => array(
					'0' => __('<span class="icon-preview" id="large-icon-preview" ></span>','rhl'),
				),
				//'description' => __('<img class="icon-preview" id="large-icon-preview" ></img>','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'icon_styles',
				'type' => 'radio',
				'options' => array(
					'1' =>__('<span class="icon-preview" id="med-icon-preview" ></span>','rhl')
				),
				//'description' => __('<img class="icon-preview" id="med-icon-preview" ></img>','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'icon_styles',
				'type' => 'radio',
				'options' => array(
					'2' =>__('<span class="icon-preview" id="small-icon-preview" ></span>','rhl')
				),
				//'description' => __('<img class="icon-preview" id="small-icon-preview" ></img>','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'icon_styles',
				'type' => 'radio',
				'options' => array(
					'3' =>__('<span class="icon-preview" id="style2-icon-preview" ></span>','rhl')
				),
				//'description' => __('<img class="icon-preview" id="style2-icon-preview" ></img>','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'id' => 'icon_styles',
				'type' => 'radio',
				'options' => array(
					'4' =>__('<span class="icon-preview" id="style3-icon-preview" ></span>','rhl')
				),
				//'description' => __('<img class="icon-preview" id="style2-icon-preview" ></img>','rhl'),
				'el_properties' => array(),
				'save_option' =>true,
				'load_option' =>true
			),
			(object)array(
				'type' => 'div_end'
			),
			(object)array(
				'type' => 'clear'
			),
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			)

		);

		//-- CSS Customization settings -----------------------
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-css-customization';
		$t[$i]->label 		= __('CSS Customization','rhl');
		$t[$i]->right_label	= __('CSS Customization','rhl');
		$t[$i]->page_title	= __('CSS Customization','rhl');
		$t[$i]->open = true;
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'css_customization',
				'label'		=> __('Customize modal login css','rhl'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'css_customization'),
				'default'	=> '0',
				'description'=> __('Click on the link to open the login screen in edit mode.  Please observe that IE9(or lower version) is not supported.  For more information visit the plugin website.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			(object)array(
				'id'		=> 'css_custom',
				'label'		=> __('Custom css','rhl'),
				'type'		=> 'textarea',
				'default'	=> '/* valid css only */',
				'description'=> __('Add custom css here, will be appended to customizations done with the css editor.','rhl'),
				'el_properties'	=> array('rows'=>10),
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
		//-- Link settings -----------------------

		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-custom-links';
		$t[$i]->label 		= __('Link settings','rhl');
		$t[$i]->right_label	= __('Link settings','rhl');
		$t[$i]->page_title	= __('Link settings','rhl');
		$t[$i]->open = true;
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(
			(object)array(
				'id'		=> 'enable_link_customization',
				'label'		=> __('Enable link customization','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'hidegroup'	=> '#modal_link_cust',
				'description'=> __('Choose yes to customize the links in the form.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),

			(object)array(
				'id'	=> 'modal_link_cust',
				'type'=>'div_start'
			),
			(object)array(
				'id'		=> 'css_custom_links',
				'label'		=> __('Customize links','rhl'),
				'type'		=> 'callback',
				'callback'	=> array(&$this,'links_customization'),
				'default'	=> '0',
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),

			(object)array(
				'id'	=> 'rhl_reset_custom_links',
				'type'	=> 'checkbox',
				'label'	=> __('Reset customization','rhl'),
				'description' => __('Check this and press save to reset the settings on this panel.  Any customizations will be lost.','rhl'),
				'save_option'=>false,
				'load_option'=>false
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

		return $t;
	}
	
	function pop_handle_save($pop){
		global $rhl_plugin;
		if($rhl_plugin->options_varname!=$pop->options_varname)return;

		if( isset($_REQUEST['custom_links']) ){
			$value = isset($_REQUEST['custom_links'])?$_REQUEST['custom_links']:'';
			$value = isset($_REQUEST['rhl_reset_custom_links'])?'':$value;
			
			$existing_options = get_option($pop->options_varname);
			$existing_options = is_array($existing_options)?$existing_options:array();
			$existing_options['custom_links'] = $value;
			update_option($pop->options_varname,$existing_options);		
		}
	}
	
	function admin_head(){
		wp_print_scripts('jquery-ui-sortable');
?>
<script>
jQuery(document).ready(function($){
	$('#extra-links-holder').sortable();

	$('.chk_showon').bind('change',function(e){
		console.log( 'length',$(this).parent().find(':checked').length );
			if( $(this).parent().parent().find('.chk_showon:checked').length>0 ){
				$(this).parents('.extra-link-item').find('h3 .pop-right').addClass('notshown');
			}else{
				$(this).parents('.extra-link-item').find('h3 .pop-right').removeClass('notshown');
			}
	}).trigger('change');
});
</script>
<?php
	}

	function links_customization($tab,$i,$o,&$save_fields){
		global $rhl_plugin;

		$forms = array(
			'login'	=> __('Login','rhl'),
			'maintenance' 	=> __('Maintenance','rhl'),
			'register'	=> __('Register','rhl'),
			'lostpassword'	=> __('Lost password','rhl'),
			'rp'	=> __('Reset password','rhl')
		);

		ob_start();
		$custom = $rhl_plugin->get_option('custom_links','',true);
		if(''==$custom){
			$custom = array(
				(object)array(
					'id'		=> 'lostpassword',
					'name' 		=> __('Lost your password?','rhl'),
					'label'		=> '',
					'url'		=> '',
					'target'	=> '_self',
					'showon'	=> array('login')
				),
				(object)array(
					'id'		=> 'login',
					'name' 		=> __('Log in','rhl'),
					'label'		=> '',
					'url'		=> '',
					'target'	=> '_self',
					'showon'	=> array('maintenance','rp','register','lostpassword')
				),
				(object)array(
					'id'		=> 'register',
					'name' 		=> __('Register','rhl'),
					'label'		=> '',
					'url'		=> '',
					'target'	=> '_self',
					'showon'	=> array('login')
				)
			);

			for($a=1;$a<6;$a++){
				$custom[]=array(
					'id'		=> 'custom'.$a,
					'name' 		=> sprintf(__('Custom %s','rhl'),$a),
					'label'		=> '',
					'url'		=> '',
					'target'	=> '_self',
					'showon'	=> array()
				);
			}
		}

?>
<div class="pt-option pt-option-extra-links">
	<ul id="extra-links-holder">
		<?php foreach($custom as $c):$c=(object)$c;?>
		<li class="extra-link-item">
			<input type="hidden" name="custom_links[<?php echo $c->id?>][id]" value="<?php echo $c->id ?>" />
			<input type="hidden" name="custom_links[<?php echo $c->id?>][name]" value="<?php echo $c->name ?>" />
			<h3 class="option-title sidebar-name open">
				<span class="pop-option-title"><?php echo $c->name?></span>
				<span class="pop-right notshown"><?php _e('Not shown','rhl')?></span>
			</h3>
			<div class="inside option-content open form-<?php echo $c->id?>">
				<div class="rhl-inp-link-label not-show-on-non-custom">
					<label><?php _e('Label','rhl')?></label>
					<input type="text" name="custom_links[<?php echo $c->id?>][label]" value="<?php echo esc_attr(stripslashes($c->label)) ?>" />
				</div>
				<div class="rhl-inp-link-url not-show-on-non-custom">
					<label><?php _e('Url:','rhl')?></label>
					<input type="text" name="custom_links[<?php echo $c->id?>][url]"  value="<?php echo $c->url ?>" />
				</div>
				<div class="rhl-inp-link-target not-show-on-non-custom">
					<label><?php _e('Target:','rhl')?></label>
					<select name="custom_links[<?php echo $c->id?>][target]">
						<?php foreach(array('_self','_blank') as $target):?>
						<option <?php echo $target==$c->target?'selected="selected"':''?> value="<?php echo $target?>"><?php echo $target?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="rhl-inp-showon">
					<label><?php _e('Shown on:','rhl')?></label>
					<div class="rhl-inp-showon-options">
						<?php foreach($forms as $value => $label): ?>
						<div class="rhl-inp-showon-options-item">
							<input class="chk_showon" type="checkbox" <?php echo is_array($c->showon)&&in_array($value,$c->showon)?'checked="checked"':''?> name="custom_links[<?php echo $c->id?>][showon][]" value="<?php echo $value?>"/> <?php echo $label ?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
</div>

<?php
		$output=ob_get_contents();
		ob_end_clean();

		return $output;
	}

	function css_customization($tab,$i,$o,&$save_fields){
		global $rhl_plugin;
		$url = wp_login_url();
		$url = $rhl_plugin->addURLParameter($url, 'edit', '');
		return '<a class="not-modal" href="'.$url.'" target="_blank">Edit modal login css</a><br />';
	}

}
?>
