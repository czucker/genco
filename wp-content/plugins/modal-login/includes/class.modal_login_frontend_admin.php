<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

class modal_login_frontend_admin {
	var $plugin_url = RHL_URL;
	var $development = false;
	var $input_renderer;
	var $uploaded_files_queue_option_name = 'rhl_uploaded_files';
	var $own_jquery = false;
	function modal_login_frontend_admin($own_jquery=false){
		$this->own_jquery = $own_jquery;
		add_action('login_head',array(&$this,'wp_head'));
		add_action('login_footer',array(&$this,'wp_footer'));
		
		wp_register_style( 'minicolors', RHL_URL.'css/jquery.miniColors.css', array(), '1.0.1');
		wp_register_style( 'rhl-css-edit', RHL_URL.'css/admin_style.css', array(), '1.0.0');
		wp_register_script( 'rhl-rangeinput', RHL_URL.'options-panel/js/rangeinput.js', array(),'1.2.5');	
		wp_register_script( 'tinycolor', RHL_URL.'js/tinycolor.js', array(), '1.0.1' );
		wp_register_script( 'minicolors', RHL_URL.'js/jquery.miniColors.js', array(), '1.0.0' );
		//wp_register_script( 'tinycolor', RHL_URL.'js/tinycolor-min.js', array(), '1.0.0' );
		wp_register_script( 'rhl-css-normalizers', RHL_URL.'js/rhl_css_normalizers.js', array(), '1.0.1' );
		wp_register_script( 'rhl-css-edit', RHL_URL.'js/rhl_css_edit.js', array('rhl-rangeinput','tinycolor','rhl-css-normalizers'), '1.0.2' );
		
		
		wp_register_script( 'farbtastic', admin_url('/js/farbtastic.js'), array(), '1.0.0' );
	}
	
	function less(){
?>
<link rel="stylesheet/less" type="text/css" href="<?php echo $this->plugin_url?>css/style_admin_login.less?ver=1.0.1">
<?php if($this->development):?>
<script type="text/javascript">if(!less){var less={};}less.env = 'development';</script>
<?php endif ?>
<script type='text/javascript' src='<?php echo $this->plugin_url?>js/less-1.3.0.min.js?ver=1.3.0'></script>
<script>try{var rhl_ajax_url = '<?php echo admin_url('/admin-ajax.php')?>';
var _unexpected_error='<?php _e('Unexpected error, reload and try again.','rhl')?>';}catch(e){}</script>
<?php	

	}
	
	function wp_head(){
		if($this->own_jquery){
?>
<script type="text/javascript">
var original_jQuery = jQuery.noConflict(true);
window.jQuery = jQuery = rhl_jQuery;
</script>
<?php		
		}
		wp_print_styles( 'rhl-css-edit' );
		
		wp_print_scripts( 'rhl-css-edit' );
		//wp_print_scripts('jquery-ui-accordion');
		
		wp_print_styles( 'farbtastic' );
		wp_print_scripts( 'farbtastic' );	
		
		wp_print_styles( 'minicolors' );
		wp_print_scripts( 'minicolors' );	
		
		wp_print_scripts('plupload-all');
		
		$this->less();	
		if($this->own_jquery){
?>
<script type="text/javascript">
rhl_jQuery = jQuery.noConflict(true);
jQuery=original_jQuery;
</script>
<?php	
		}		
	}
	
	function wp_footer(){
		$options = $this->options();
		if(count($options)==0)return;
		
		global $rhl_plugin;
		
		require_once RHL_PATH.'includes/class.rhlogin_admin_form_renderer.php';
		$this->input_renderer = new rhlogin_admin_form_renderer( array(&$rhl_plugin,'get_option') );
		
		if('1'==$rhl_plugin->get_option('enable_debug','',true)){
			$this->input_renderer->debug = true;	
		}
		$this->accordion_options($options);
	}
	
	function accordion_options($options){
		global $rhl_plugin;
		$maintenance_url = wp_login_url();
		$maintenance_url = $rhl_plugin->addURLParameter($maintenance_url, 'action', 'maintenance');
		
		$logout_url = $rhl_plugin->addURLParameter( wp_logout_url(), 'showonly', '1');	
?>
<div class="rhl-css-edit-form">
	<form id="rhl-css-form" class="rhl-css-form" name="rhl-css-form" method="post" action="">
	<div class="rhlogin-controls rhlogin-edit rhl-vertical">
		<div class="login-forms-group btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
		    <?php _e('Forms','rhl') ?>
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <li><a href="<?php echo wp_login_url( $redirect_to );?>" ><?php _e( 'Log in', 'rhl' );?></a></li>
			<li><a href="<?php echo wp_lostpassword_url( $lost_password_redirect_to );?>" ><?php _e( 'Lost your password?', 'rhl' );?></a></li>
			<?php if ( get_option( 'users_can_register' ) ) : ?>
			<li>
				<a href="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login' ) ); ?>"><?php _e( 'Register','rhl' ); ?></a>
			</li>
			<?php endif; ?>		
			<li><a href="<?php echo $maintenance_url;?>" ><?php _e( 'Maintenance', 'rhl' );?></a></li>
			<li><a href="<?php echo $logout_url;?>" ><?php _e( 'Log out', 'rhl' );?></a></li>
		  </ul>
		</div>	
		
		<div class="btn-group reset-control-group">
		  <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
		    Reset
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <li><a id="btn-reset-css" href="javascript:void(0);" class=""><?php _e('Reset current settings','rhl')?></a></li>
		    <li><a id="btn-remove-css" href="javascript:void(0);" class=""><?php _e('Remove all customization','rhl')?></a></li>
		  </ul>
		</div>		
		
		<div class="rhl_loading"><img src="<?php echo RHL_URL?>css/images/spinner_32x32.gif" /></div>
		
		<a id="btn-save" href="javascript:void(0);" class="btn btn-primary btn-save-settings" data-loading-text="<?php _e('Saving','rhl')?>"><?php _e('Save','rhl')?></a>
	</div>
	<div class="rhlogin-slides rhlogin-edit rhl-vertical">
		<div class="ajax-result-messages"></div>
		<?php //$this->jquery_ui_accordion_html($options);?>
		<?php $this->bootstrap_accordion_html($options);?>
	</div>
	<div class="rhlogin-controls-bottom rhlogin-edit rhl-vertical">
		
	</div>
	</form>
</div>
<div class="rhlogin-edit">
	<a href="javascript:void(0);" class="btn btn-primary btn-collapse" data-loading-text="<?php _e('Open','rhl')?>" ><?php _e('Collapse','rhl')?></a>		
</div>
	
<?php		
	}
	
	function jquery_ui_accordion_html($options){
?>
		<div id="ui-accordion" class="accordion">
			<?php foreach($options as $i => $tab): ?>
			<h3><a href="#"><?php echo $tab->label?></a></h3>
			<div><?php $this->render_slide( $tab, $options, $i, 'accordion' ) ?></div>
			<?php endforeach; ?>
		</div>
<?php	
	}
	
	function bootstrap_accordion_html($options){
?>
		<div id="accordion2" class="accordion">
			<?php foreach($options as $i => $tab): ?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $tab->id?>"><?php echo $tab->label?></a>
				</div>
				<div id="<?php echo $tab->id?>" class="accordion-body collapse">
					<div class="accordion-inner">
						<?php $this->render_slide( $tab, $options, $i, 'accordion' ) ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
<?php	
	}
	
	function options($t=array()){
		$i = count($t);
		require RHL_PATH.'includes/admin_frontend_options.php';
		return $t;
	}
	
	function render_slide($tab,$options,$options_i,$type="tab"){
		if(count($tab->options)==0){
			_e('No options available on this section.','rhl');
			return;
		}
		
		foreach($tab->options as $i => $option){
			if(@$option->input_type && 'callback'==$option->input_type && is_callable($option->callback)){
				call_user_func($option->callback,$option,$i,$options,$options_i);
			}else{
				$this->input_renderer->render($option,$i,$options,$options_i);
			}
		}
	}
	
	function tab_saved_list($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="rhl-backup-cont">
	<div id="add_backup_msg"></div>
	<div class="rhl-add-backup-cont">
		<span class="field-label label-for-text"><?php _e('Backup description','rhl')?></span>
		<input id="rhl_backup_name" type="text" value="" class="input-medium" /><a id="btn-add-backup" data-loading-text="<?php _e('Adding...','rhl')?>" class="btn btn-primary"><?php _e('Add','rhl')?></a>
	</div>
	<span class="field-label label-for-text"><?php _e('Saved and downloaded','rhl')?></span>
	<p><?php _e('Choose a template and click load.  Current settings will be overwritten.','rhl')?></p>
	<div id="<?php echo $option->id?>" class="saved_settings_list_cont"></div>
	<div class="empty_saved_settings" style="display:none;"><?php _e('No saved settings.','rhl')?></div>
	<a id="btn-restore-backup" class="btn btn-primary" data-loading-text="<?php _e('Loading','rhl')?>"><?php _e('Load','rhl')?></a>
</div>
<?php	
	}
}


?>