<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/

if('debug_modal_login'!=get_class($this))die('No access');

function debug_wrap_textarea($text,$properties='class="widefat" rows="10"'){
	return sprintf("<textarea %s>%s</textarea>",$properties,$text);
}

function debug_wordpress_version(){
	global $wp_version;
	return $wp_version;
}

function debug_rhl_version(){
	return RHL_VERSION;
}

function debug_template_path(){
	global $rhl_plugin;
	return $rhl_plugin->get_template_path();
}

function debug_saved_options(){
	global $rhl_plugin;
	$options = get_option($rhl_plugin->options_varname);
	return debug_wrap_textarea(print_r($options,true));
}

function debug_loaded_options(){
	global $rhl_plugin;
	return debug_wrap_textarea(print_r($rhl_plugin->options,true));
}

function debug_htaccess(){
	if( file_exists(ABSPATH.'.htaccess') ){
		$ht = file_get_contents(ABSPATH.'.htaccess');
		return debug_wrap_textarea($ht);
	}
	return '.htaccess not found';
}

function debug_phpversion(){
	echo phpversion();
}

$items = array(
	'debug_phpversion'			=> __('PHP Version','rhl'),
	'debug_wordpress_version' => __('WordPress version','rhl'),
	'debug_rhl_version'	=> __('Modal Login version','rhl'),
	'debug_template_path'  => __('Template path','rhl'),
	'debug_htaccess' => __('.htaccess content','rhl'),
	'debug_saved_options'	=> __('Saved options','rhl'),
	'debug_loaded_options'	=> __('Loaded options','rhl')
);


$items = apply_filters('rhl_debug_items',$items);
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Modal Login Debugging info</h2>
	<div class="debug-cont">
		<?php foreach($items as $method => $label):?>
		<div class="item">
			<h3><?php echo $label?></h3>
			<div class="widefat">
				<?php echo function_exists($method)?$method():sprintf(__('Unknown function %s','rhl'),$method)?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
