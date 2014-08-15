<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhl_rewrite {
	
	function rhl_rewrite($plugin_id='rhl'){
		$this->id = $plugin_id;
		add_filter("pop-options_{$this->id}",array(&$this,'options'),10,1);			
		add_action('pop_handle_save',array(&$this,'pop_handle_save'),500,1);
	}
	
	function pop_handle_save(){
		if(isset($_REQUEST['enable_rhl_admin_rewrite'])){
			add_action('admin_init',array(&$this,'_pop_handle_save'));
		}
	}
	
	function _pop_handle_save(){
		global $rhl_plugin;
		//--reload plugin options so rules are written with the new settings.
		$rhl_plugin->options = get_option($rhl_plugin->options_varname);
		$rhl_plugin->options = is_array($rhl_plugin->options)?$rhl_plugin->options:array();			
		
		$iis7_permalinks = iis7_supports_permalinks();
		if($iis7_permalinks){
		
		}else{
			if( !$this->is_same_login_and_admin() ){
				$this->save_mod_rewrite();
			}
		}
	}
	
	function is_same_login_and_admin(){
		//this is a critical unhandled condition
		global $rhl_plugin;
		$rewrite_login = $rhl_plugin->get_option('rewrite_login','',true);
		if( ''!= trim($rewrite_login) && trim($rewrite_login)==trim($rhl_plugin->get_option('rewrite_admin','',true)) )	{
			//disable url rewrite.
			update_option('rhl_rewrite_enabled','0');
			//---------------
			$options = get_option($rhl_plugin->options_varname);
			$options = is_array($options)?$options:array();				
			$options['enable_rhl_admin_rewrite']='0';
			update_option($rhl_plugin->options_varname,$options);
			//---------------
			return true;
		}
		return false;
	}
	
	function save_mod_rewrite(){
		$filename = get_home_path() . '.htaccess';
		$rules = $this->get_rewrite_rules();		
		
		//-- RHL rules MOST happen before wordpress rules.
		if (file_exists( $filename ) && is_writeable( $filename ) ) {
			$str = file_get_contents($filename);
			if(false===strpos($str,'BEGIN RHL')){
				$prepend = "# BEGIN RHL\n";
				$prepend.= "# END RHL\n";
				$str = $prepend.$str;
				file_put_contents($filename,$str);
			}
		}
		
		delete_option('rhl_rewrite_enabled');
		$rules_arr = explode( "\n", $rules );
		if( insert_with_markers( $filename, 'RHL', $rules_arr) ){
			global $rhl_plugin;
			if( '1'==$rhl_plugin->get_option('enable_rhl_admin_rewrite','',true) ){
				update_option('rhl_rewrite_enabled','1');
			}
		}
	}
	
	function get_rewrite_rules(){
		global $wp_rewrite;
		
		if ( ! $wp_rewrite->using_permalinks() )
			return '';
					
		if( iis7_supports_permalinks() ){
			return '';
		}else{
			return $this->get_htaccess();
		}
	}
	
	function get_htaccess(){
		global $rhl_plugin;
		$options = array(
			'enable_rhl_admin_rewrite' => '',
			'rewrite_login' 	=> '',
			'block_wp_login' 	=> '',
			'rewrite_admin' 	=> '',
			'block_wp_admin' 	=> ''
		);

		foreach($options as $field => $default){
			$$field = $rhl_plugin->get_option($field,$default,true);
		}

		if( '1'!=$enable_rhl_admin_rewrite){
			return '';
		}
		
		if( ''==$rewrite_login && ''==$rewrite_admin)
			return '';
		
		
		$home_root = parse_url(home_url());
		if ( isset( $home_root['path'] ) )
			$home_root = trailingslashit($home_root['path']);
		else
			$home_root = '/';
			
		
		$output = "<IfModule mod_rewrite.c>\n";
		$output.= "RewriteEngine On\n";
		$output.= "RewriteBase $home_root\n";
		
		if(''!=$rewrite_login){
			$rewrite_login = str_replace('.+?', '.+', $rewrite_login);
			
			$output.= "RewriteCond %{QUERY_STRING} !^(.*)rewrittenlogin=(.*)$\n";
			$output.= "RewriteRule ^{$rewrite_login}(.*)$ wp-login.php\$1?rewrittenlogin=1 [QSA,L]\n";
			
			$output.= "RewriteCond %{QUERY_STRING} !^(.*)rewrittenlogin=(.*)$\n";
  			if('1'==$block_wp_login){
				$output.= "RewriteRule ^wp-login\.php$ / [NE,R=404,L]\n";
			}else{
				$output.= "RewriteRule ^wp-login\.php$ {$rewrite_login}/ [NE,R=301,L]\n";
			}
		}

		if(''!=$rewrite_admin){
			$rewrite_admin = str_replace('.+?', '.+', $rewrite_admin);

			$output.="RewriteRule ^{$rewrite_admin}[^/]*$ {$rewrite_admin}/ [R=301,L]\n";
			$output.="RewriteCond %{QUERY_STRING} !^(.*)rewrittenadmin=(.*)$\n";
			$output.="RewriteRule ^{$rewrite_admin}(.*)$ wp-admin$1?rewrittenadmin=1 [QSA,L,NE]\n";
			if('1'==$block_wp_admin){
				$output.="RewriteCond %{QUERY_STRING} !^(.*)rewrittenadmin=(.*)$\n";
				$output.="RewriteRule ^wp-admin/?$ / [R=404,L]\n";			
			}
			$output.="RewriteCond %{QUERY_STRING} !^(.*)rewrittenadmin=(.*)$\n";
			$output.="RewriteRule ^wp-admin/(.*)$ {$rewrite_admin}/\$1 [QSA,R=301,L,NE]\n";
		}
		
		$output.= "</IfModule>\n";
		
		return $output;
	}
	
	function options($t){
		$iis7_permalinks = iis7_supports_permalinks();
		if($iis7_permalinks){
			return $this->iis7_options($t);
		}else{
			return $this->mod_rewrite_options($t);
		}		
		return $t;
	}
	
	function iis7_options($t){
		return $t;
	}
	
	function mod_rewrite_options($t){
		global $rhl_plugin;
		//----
		$i = count($t);
		//-- Login redirect settings -----------------------		
		$i++;
		$t[$i]=(object)array();
		$t[$i]->id 			= 'rhl-rewrite'; 
		$t[$i]->label 		= __('Admin and login rewrite','rhl');
		$t[$i]->right_label	= __('Admin and login rewrite','rhl');
		$t[$i]->page_title	= __('Admin and login rewrite','rhl');
		$t[$i]->theme_option = true;
		$t[$i]->plugin_option = true;
		$t[$i]->options = array(

			(object)array(
				'id'		=> 'enable_rhl_admin_rewrite',
				'label'		=> __('Enable URL Rewrite options','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'hidegroup'	=> '#rewrite_group',
				'description'=> __('Choose yes to enable wp-login.php and wp-admin url rewrite options.  If you disable it, and have manually added rewrite rules to .htaccess/web.config please observe that you will also need to manually remove the code from .htaccess/web.config.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),			
			
			(object)array(
				'id'	=> 'rewrite_group',
				'type'=>'div_start'
			),	
			
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('wp-login.php url rewrite','rhl')
			),
			
			(object)array(
				'id'		=> 'rewrite_login',
				'label'		=> __('Change wp-login.php to','rhl'),
				'type'		=> 'text',
				'default'	=> 'login',
				'description'=> __('Leave empty for no wp-login.php rewrite, or specify the permalink without the domain.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			
			(object)array(
				'id'		=> 'block_wp_login',
				'label'		=> __('Block wp-login.php','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes if you wish to return a 404 when a visitor tries to directly access wp-login.php.  This will also attempt to filter and replace any wp-login.php references.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			
			(object)array(
				'type' 			=> 'subtitle',
				'label'			=> __('wp-admin url rewrite','rhl')
			),
						
			(object)array(
				'id'		=> 'rewrite_admin',
				'label'		=> __('Change wp-admin to','rhl'),
				'type'		=> 'text',
				'default'	=> 'admin',
				'description'=> sprintf('<p>%s</p><p><b>%s</b> %s</p>',
					__('Leave empty for no wp-admin rewrite, or specify the permalink without the domain.','rhl'),
					__('Important','rhl'),
					__('This most be diferent from the wp-login.php, if choosing the same, it will automatically be disabled to prevent locking the admin.','rhl')
				),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			
			(object)array(
				'id'		=> 'block_wp_admin',
				'label'		=> __('Block wp-admin','rhl'),
				'type'		=> 'yesno',
				'default'	=> '0',
				'description'=> __('Choose yes if you wish to return a 404 when a visitor tries to directly access wp-admin.  This will also attempt to filter and replace any wp-admin references.','rhl'),
				'el_properties'	=> array(),
				'save_option'=>true,
				'load_option'=>true
			),
			
			(object)array(
				'type'=>'clear'
			),
			(object)array(
				'type'		=> 'callback',
				'callback'	=> array(&$this,'manual_rewrite_rules')
			),

			
			(object)array(
				'type'=>'clear'
			),
			
			(object)array(
				'type'=>'div_end'
			),	
			
			(object)array(
				'type'	=> 'submit',
				'label'	=> __('Save','rhl'),
				'class' => 'button-primary'
			),

			(object)array(
				'type'=>'clear'
			)
		);	
		
		global $wp_rewrite;
		if ( ! $wp_rewrite->using_permalinks() ){
			delete_option('rhl_rewrite_enabled');
			$t[$i]->options = array(
				(object)array(
					'type' 			=> 'subtitle',
					'label'			=> __('Permalinks are not active.','rhl'),
					'description'	=> __('wp-login.php and wp-admin rewrite requires that permalinks are enabled.','rhl')
				),			
				(object)array(
					'type'=>'clear'
				)
			);
		}
		
		
		return $t;
	}
	
	function manual_rewrite_rules(){
		$iis7_permalinks = iis7_supports_permalinks();
		if($iis7_permalinks){
			return '';
		}else{
			return $this->manual_htaccess();
		}
	}
	
	function manual_htaccess(){		
		global $rhl_plugin;
		
		if('1'!=$rhl_plugin->get_option('enable_rhl_admin_rewrite','',true)){
			return '';
		}
		
		$home_path = get_home_path();
		$htaccess_file = $home_path.'.htaccess';
		
		if(is_writable($htaccess_file)){
			return '';
		}
		
		$current = extract_from_markers($htaccess_file,'RHL');
		if(!empty($current)){
			update_option('rhl_rewrite_enabled','1');
		}
		
		ob_start();
?>
<div class="pt-option pt-option-htaccess">
<span class="pt-label">.htaccess is not writable, you will need to manually add this code at the beginning of the .htaccess file and return to this screen.  Refresh this screen after manually adding the code.</span>
<textarea class="widefat" rows=14>
# BEGIN RHL
<?php echo $this->get_rewrite_rules();?>
# END RHL
</textarea>
<p><?php _e('Rules added:','rhl')?>&nbsp;<?php echo '1'==get_option('rhl_rewrite_enabled')?__('Yes','rhl'):__('No','rhl') ?></p>
</div>
<?php	
		$content = ob_get_contents();	
		ob_end_clean();
		return $content;
	}
}
?>