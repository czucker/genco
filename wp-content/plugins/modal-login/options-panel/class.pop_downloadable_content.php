<?php
/*
* @Alberto Lau alberto@righthere.com alau@albertolau.com
*/
if(!defined('pop_downloadable_content')):

define('pop_downloadable_content','1.0.0');

class pop_downloadable_content {
	var $id;
	var $parent_id;
	var $page_title;
	var $menu_text;
	var $capability;
	var $api_url;
	var $license_keys;
	var $module_url;
	function pop_downloadable_content($args=array()){
		if(count($args)==0)return;
		$defaults = array(
			'id'					=> 'downloadable_content',
			'plugin_id'				=> 'downloadable_content',
			'resources_path'		=> 'downloadable_content',
			'parent_id'				=> 'rh-plugins',
			'page_title'			=> 'Downloadable content',
			'menu_text'				=> 'Downloads',
			'capability'			=> 'manage_options',
			'api_url'				=> 'http://plugins.righthere.com/',
			//'api_url'				=> 'http://plugins.albertolau.com/',
			'license_keys'			=> array(),
			'plugin_code'			=> '',
			'module_url'			=> plugin_dir_url(__FILE__),
			'product_name'			=> 'your plugin or theme',
			'tdom'					=> 'downloads',
			'options_varname'		=> 'pop_options',
			'bundle_id'				=> 'downloadable_content'
		);
		foreach($defaults as $property => $default){
			$this->$property = isset($args[$property])?$args[$property]:$default;
		}	

		add_action('admin_menu',array(&$this,'admin_menu'));
		
		add_action('wp_ajax_rh_get_bundles_'.$this->id, array(&$this,'get_bundles'));
		add_action('wp_ajax_rh_download_bundle_'.$this->id, array(&$this,'download_bundle'));
		add_action('wp_ajax_dlc_activate_addon_'.$this->id, array(&$this,'handle_activate_addon'));
		add_action('wp_ajax_handle_stripe_token_'.$this->id, array(&$this,'handle_stripe_token'));
		
		add_action('init',array(&$this,'init'));
	}
	
	function init(){
		wp_register_script('rh-dc', 	$this->module_url.'js/dc.js', array(), '2.4.1');
		wp_register_style('rh-dc', 		$this->module_url.'css/dc.css', array(), '2.4.1');
	}
	
	function get_license_keys(){
		$arr_of_keys=array();
		if(count($this->license_keys)>0){	
			foreach($this->license_keys as $k){
				$arr_of_keys[]=is_object($k)?$k->license_key:$k;
			}
		}	
		return $arr_of_keys;
	}
	
	function get_license_item_ids(){
		$arr_of_keys=array();
		if(count($this->license_keys)>0){	
			foreach($this->license_keys as $k){
				$arr_of_keys[]=is_object($k)?$k->item_id:$k;
			}
		}	
		return $arr_of_keys;
	}
	
	function send_error($msg,$error_code='MSG'){
		$this->send_response(array("R"=>"ERR","MSG"=>$msg,"ERRCODE"=>$error_code));
	}
	
	function send_response($response){
		die(json_encode($response));
	}
	
	function get_bundles(){
		//-- allow listing dlc without a license.
		return $this->get_bundles_from_plugin_code();
		//-- 
		if(count($this->license_keys)==0){
			$this->send_error( sprintf( __('There is no downloadable content at this time.  You must register %s before you can actually see available downloadable content. For more information on how to register %s, please go the Options menu and the License tab.','pop'),$this->product_name,$this->product_name));
		}

		$url = sprintf('%s?content_service=get_bundles&site_url=%s',$this->api_url,urlencode(site_url('/')));
		foreach($this->get_license_keys() as $key){
			$url.=sprintf("&key[]=%s",urlencode($key));
		}	

		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
		
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			return $this->send_response($response);
		}		
		die();	
	}
	
	function get_bundles_from_plugin_code(){
		$plugin_codes = apply_filters('dlc_plugin_code', array($this->plugin_code));
		if(!is_array($plugin_codes) || empty($plugin_codes)){
			return $this->send_error( sprintf( __('Plugin settings error.  Missing plugin code.','pop'),$this->product_name,$this->product_name));
		}
	
		$url = sprintf('%s?content_service=get_bundles_from_codes&site_url=%s',$this->api_url,urlencode(site_url('/')));
		foreach($plugin_codes as $code){
			$url.=sprintf("&code[]=%s",urlencode($code));
		}	

		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
		
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			if($response->R=='OK'){
				if(property_exists($response,'BUNDLES') && is_array($response->BUNDLES) && count($response->BUNDLES)>0){
					foreach($response->BUNDLES as $i => $bundle){
						$currency = property_exists($bundle,'currency') ? $bundle->currency : 'USD';
						//This is only for information purpose. it is not considered on payment procedures. Just like prices.
						$response->BUNDLES[$i]->currency = $currency;
						
						if($bundle->price==0){
							$response->BUNDLES[$i]->price_str = __('Free','pop');
						}else{
							$response->BUNDLES[$i]->price_str = sprintf('%s %s', $bundle->price, $currency);
						}
					}				
				}
			}
			return $this->send_response($response);
		}		
		die();	
	}
	
	function download_bundle(){
		if( !is_super_admin() && current_user_can('rh_demo') ){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
			
		if(count($this->license_keys)==0){
			$this->send_error( __('Please register the product before downloading content.','pop') );
		}
		
		$url = sprintf('%s?content_service=get_bundle&id=%s&site_url=%s',$this->api_url,intval($_REQUEST['id']),urlencode(site_url('/')));
		foreach($this->get_license_keys() as $key){
			$url.=sprintf("&key[]=%s",$key);
		}
		
		if(!class_exists('righthere_service'))require_once 'class.righthere_service.php';
		$rh = new righthere_service();
		$response = $rh->rh_service($url);
		if(false===$response){
			$this->send_error( __('Service is unavailable, please try again later.','pop') );
		}else{
			//handle import of content.
			if($response->R=='OK'){
				if($response->DC->type=='bundle'){
					global $userdata;
					
					require_once 'class.al_importer.php';
					$dc = base64_decode($response->DC->content);
					
					$e = new al_importer(array('post_author'=>$userdata->ID,'post_author_rewrite'=>true));
					$bundle = $e->decode_bundle($dc);
					
					$result = $e->import_bundle($bundle);
					if(false===$result){
						$this->send_error("Import error:".$e->last_error);
					}else{
						$this->add_downloaded_id(intval($_REQUEST['id']));			
						$r = (object)array(
							"R"=>"OK",
							"MSG"=> __("Content downloaded and installed.",'pop')
						);
						$this->send_response($r);
					}				
				}elseif($response->DC->type=='pop'){
					require_once 'class.pop_importer.php';
					$e = new pop_importer(array('plugin_id'=>$this->plugin_id,'options_varname'=>$this->options_varname,'resources_path'=>$this->resources_path,'tdom'=>'pop'));
					$result = $e->import_options_from_code($response);
					if(false===$result){
						$this->send_error("Import error:".$e->last_error);
					}else{
						$this->add_downloaded_id(intval($_REQUEST['id']));			
						$r = (object)array(
							"R"=>"OK",
							"MSG"=> __("Content downloaded and installed.",'pop')
						);
						$this->send_response($r);
					}	
				}else{
					$this->send_error( __('Unhandled content type, update plugin or theme to latest version.','pop') );
				}
			}else{
				$this->send_error($response->MSG,$response->ERRCODE);
			}
		}
	}

	function handle_activate_addon(){
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}

		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}
		$plugins = $this->get_plugins();	
		$valid_plugins = array_keys($plugins);
		$plugin = isset($_REQUEST['plugin']) && array_key_exists($_REQUEST['plugin'], $plugins) ? $_REQUEST['plugin'] : false;
		if(false===$plugin){
			die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin is no longer available.','pop') )));
		}
		$redirect_url='';
		$current = get_option($this->options_varname, array());
		$current = is_array($current) ? $current : array();
		$current['addons'] = is_array($current['addons']) ? $current['addons'] : array() ;	
		$activate = isset($_REQUEST['activate']) && 1==intval($_REQUEST['activate']) ? true : false;
		if($activate){
			if(!in_array($plugin,$current['addons'])){
				$upload_dir = wp_upload_dir();
				$addons_path = $upload_dir['basedir'].'/'.$this->resources_path.'/';				
				try {
					$addon = $plugin;
					@include_once $addons_path.$plugin;
					//----
					//$current['addons'][] = $plugin;
					array_unshift($current['addons'],$plugin);
					$current['addons'] = array_intersect($current['addons'],$valid_plugins);
					update_option($this->options_varname, $current);
					
					do_action('activate_'.$plugin,$addons_path,$plugin);
					$redirect_url = apply_filters('activate_url_'.$plugin,$redirect_url);
				}catch(Exception $e){	
					die(json_encode(array('R'=>'ERR','MSG'=> $e->getMessage() )));			
				}			
			}
		}else{
			if(in_array($plugin,$current['addons'])){
				$current['addons'] = array_diff($current['addons'], array($plugin))  ;
				$current['addons'] = array_intersect($valid_plugins,$current['addons']);
				update_option($this->options_varname, $current);			
			}
		}

		die(json_encode(array('R'=>'OK','MSG'=>'','URL'=>$redirect_url)));
	}
	
	function add_downloaded_id($dc_id){
		$rh_bundles = get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
		//--
		if($dc_id>0 && !in_array($dc_id,$rh_downloaded_bundles)){
			$rh_downloaded_bundles[]=$dc_id;
		}
		//--
		$rh_bundles->downloaded = $rh_downloaded_bundles;
		update_option('rh_bundles',$rh_bundles);	
	}

	function admin_menu(){
		$page_id = add_submenu_page( $this->parent_id,$this->page_title ,$this->menu_text,$this->capability,$this->id,array(&$this,'body'));
		add_action( 'admin_head-'. $page_id, array(&$this,'head') );
	}
	
	function head(){
		wp_register_style('rhpop-bootstrap', 	$this->module_url.'bootstrap/css/bootstrap.namespaced.rhpop.css', array(), '2.3.1');
		wp_print_styles('rhpop-bootstrap');
		
		rh_enqueue_script( 'bootstrap', 		$this->module_url.'bootstrap/js/bootstrap.js', array(),'2.3.1');
		rh_enqueue_script( 'jquery-isotope', 	$this->module_url.'js/jquery.isotope.min.js', array(),'1.5.14');
		wp_print_scripts('bootstrap');
		wp_print_scripts('jquery-isotope');
		
		wp_print_styles('rh-dc');
		wp_print_scripts('rh-dc');
		$rh_bundles = get_option('rh_bundles',(object)array());
		$rh_downloaded_bundles = property_exists($rh_bundles,'downloaded')?$rh_bundles->downloaded:array();
		$rh_downloaded_bundles = is_array($rh_downloaded_bundles)?$rh_downloaded_bundles:array();
		
		$current = get_option($this->options_varname, array());
		$current = is_array($current) ? $current : array();
		$addons = isset($current['addons']) && is_array($current['addons']) ? $current['addons'] : array() ;		
		if(count($addons)>0){
			$tmp = array();
			foreach($addons as $a){
				$tmp[]=$a;
			}
			$addons=$tmp;
		}
	
		$arr = $this->get_plugins();
		$installed_addons = array_keys($arr);
		$installed_addons = is_array($installed_addons)?$installed_addons:array();		
		$arr = is_array($arr)?$arr:array();
		if( count($arr)>0 ){
			foreach($arr as $i => $a){
				$brr = explode(' ',$a['Version']);
				$arr[$i]['Version'] = $brr[0];	
			}
		}
?>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script>
var rh_download_panel_id = '<?php echo $this->id?>';
var apiurl = '<?php echo $this->api_url?>';
var rh_license_keys = <?php echo json_encode($this->license_keys)?>;
var rh_item_ids = <?php echo json_encode($this->get_license_item_ids())?>;
var rh_downloaded = <?PHP echo json_encode($rh_downloaded_bundles)?>;
var rh_filter = '';
var rh_bundles = [];
var rh_active_addons = <?php echo json_encode((array)$addons)?>;
var rh_installed_addons = <?php echo json_encode((array)$installed_addons)?>;
var stripe_public_key = '';
var stripe_item_id = '';
var rh_addon_details = <?php echo json_encode($arr)?>;
jQuery('document').ready(function($){
	get_bundles();
	
	$('#bundles').isotope({
		itemSelector : '.pop-dlc-item',
  		layoutMode : 'fitRows'
		/*,filter : '.letter-a'*/
	});
	
	$('.isotope-filter').on('click',function(e){
		$('.isotope-filter').removeClass('current-cat');
		$(this).addClass('current-cat');
		var filter = $(this).attr('rel');
		$('#bundles').isotope({filter:filter});
	});	
});
</script>
<style>
.dc-col-name {
min-width:200px;
}
</style>
<?php	
	}
	
	function body(){
		$license_keys = $this->get_license_keys();

		if(!is_array($license_keys) || count($license_keys)==0){
			$message = __('Please enter your License Key in the Options Panel to get access to the free add-ons and premium paid add-ons.','pop');
			$message_class='updated';
		}else{
			$message = '';
			$message_class='';		
		}
		
?>
<div class="wrap">
	<div class="icon32" id="icon-plugins"><br /></div>
	<h2><?php echo $this->page_title?></h2>
	<div id="messages" class="<?php echo $message_class?>"><?php echo $message?></div>
	
	<div id="installing">
		<div id="install-image" class="dc-loading"></div>
		<div id="install-message" class="install-message"></div>
		<div class="clear"></div>
	</div>
	<div class="dc-content">
		<ul class="subsubsub">
			<li><a class="isotope-filter" rel="" href="javascript:void(0);"><?php _e("Downloads",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-recent" href="javascript:void(0);"><?php _e("New",'pop')?></a>|</li>
			<li><a class="isotope-filter filter-dlc-addon" rel=".dlc-addon" href="javascript:void(0);"><?php _e("Add-ons",'pop')?></a>|</li>
			<li><a class="isotope-filter" rel=".dlc-downloaded" href="javascript:void(0);"><?php _e("Downloaded",'pop')?></a></li>
		</ul>
		<div class="clear"></div>
			
		<div id="bundles" class="rhpop"></div>		

		<div class="clear"></div>	
	</div>
</div>

<div style="display:none;" id="pop-dlc-item-template">
	<div class="pop-dlc-item">
		<h4 class="pop-dlc-name">{name}</h4>
		
		<div class="pop-dlc-details">
			<a class="pop-dlc-image" target="_blank"><img width="135"></a>
			<div class="pop-version-cont">
				<div class="pop-dlc-version-label"><?php _e('Version','pop') ?></div>
				<div class="pop-dlc-version">{version}</div>
			</div>

			<div class="pop-iversion-cont">
				<div class="pop-dlc-iversion-label"><?php _e('Installed','pop') ?></div>
				<div class="pop-dlc-iversion">{version}</div>
			</div>
			
			<div class="pop-filesize-cont">
				<div class="pop-dlc-filesize-label"><?php _e('Size','pop') ?></div>
				<div class="pop-dlc-filesize">{filesize}</div>
			</div>
			
			<div class="pop-price-cont">
				<div class="pop-dlc-price-label"><?php _e('Price','pop') ?></div>
				<div class="pop-dlc-price">{price}</div>
			</div>
			
			<div class="pop-purchase-cont">
				<button class="btn btn-success btn-purchased disabled" style="display:none;"><?php _e('Purchased','pop')?></button>
				<button class="btn btn-success btn-buynow" data-panel_label="<?php _e('Checkout','pop')?>" style="display:none;"><?php _e('Buy now','pop')?></button>
			</div>
			
			<div class="alert alert-error main-license-message" style="display:none;">
				<?php _e('Enter your license key before you can purchase add-ons or download free add-ons.','pop')?>
			</div>
			<div class="alert alert-error addon-license-message" style="display:none;">
				
			</div>
		</div>		
		
		<div class="pop-dlc-description">{description}</div>
		<div class="pop-clear"></div>
		<div class="dlc-controls">	
			<a class="btn btn-visit-site" href="#" target="_BLANK"><?php _e('Visit site','pop')?></a>	
			<div class="btn-group dlc-addon-control" data-toggle="buttons-radio">
			  <button type="button" data-toggle="button" class="btn enable-addon"><?php _e('On','pop')?></button>
			  <button type="button" data-toggle="button" class="btn disable-addon"><?php _e('Off','pop')?></button>
			</div>	
			<button class="btn btn-primary btn-download"><?php _e('Download','pop')?></button>
		</div>
	</div>		
</div>	
<?php	
		/*
		echo "debug<br>";
		$arr = $this->get_plugins();
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		*/
	}	
	
	function get_plugins() {
		$upload_dir = wp_upload_dir();
		$plugin_root = $upload_dir['basedir'].'/'.$this->resources_path;	
		// rewritten version of the one in plugin.php core wordpress 
		$wp_plugins = array ();		
		// Files in wp-content/plugins directory
		$plugins_dir = @ opendir( $plugin_root);
		$plugin_files = array();
		if ( $plugins_dir ) {
			while (($file = readdir( $plugins_dir ) ) !== false ) {
				if ( substr($file, 0, 1) == '.' )
					continue;
				if ( is_dir( $plugin_root.'/'.$file ) ) {
					$plugins_subdir = @ opendir( $plugin_root.'/'.$file );
					if ( $plugins_subdir ) {
						while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
							if ( substr($subfile, 0, 1) == '.' )
								continue;
							if ( substr($subfile, -4) == '.php' )
								$plugin_files[] = "$file/$subfile";
						}
						closedir( $plugins_subdir );
					}
				} else {
					if ( substr($file, -4) == '.php' )
						$plugin_files[] = $file;
				}
			}
			closedir( $plugins_dir );
		}
	
		if ( empty($plugin_files) )
			return $wp_plugins;
	
		foreach ( $plugin_files as $plugin_file ) {
			if ( !is_readable( "$plugin_root/$plugin_file" ) )
				continue;
	
			$plugin_data = get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.
	
			if ( empty ( $plugin_data['Name'] ) )
				continue;
	
			$wp_plugins[plugin_basename( $plugin_file )] = $plugin_data;
		}
	
		uasort( $wp_plugins, '_sort_uname_callback' );
		
		return $wp_plugins;
	}	
	
	function handle_stripe_token(){
		global $userdata;
		
		if( !is_super_admin() && current_user_can('rh_demo')){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access.  You dont have permission to perform this action.','pop'))));		
		}
				
		if(!current_user_can($this->capability)){
			die(json_encode(array('R'=>'ERR','MSG'=>__('No access','pop'))));
		}

		foreach(array('token','item_id') as $field){
			$$field = isset($_REQUEST[$field])?$_REQUEST[$field]:false;
			if(false===$$field){
				die(json_encode(array('R'=>'ERR','MSG'=>__('Plugin error.  Missing argument.','pop')."($field)")));
			}
		}		
	
		$license_keys = $this->get_license_keys();
				
		//-------------------------
		$key = array();
		foreach($this->get_license_keys() as $k){
			$key[]=$k;
		}	

		$site = site_url('/');
		$parts = parse_url($site);
		$host = isset($parts['host'])?$parts['host']:$site;
		
		$args = array(
			'timeout'	=> 60,
			'body'		=> array(
				'content_service'	=> 'stripe_checkout',
				'token'				=> $token,
				'item_id'			=> $item_id,
				'site_url'			=> site_url('/'),
				'email'				=> $userdata->user_email,
				'buyer'				=> sprintf('%s@%s',$userdata->user_login, $host ),
				'key'				=> $key
			)
		);
	
		$request = wp_remote_post( $this->api_url , $args );
		if ( is_wp_error($request) ){
			$message = sprintf( __('There was a communication error with the RightHere server. Contact support at support.righthere.com about payment %s.  Error message: %s','pop'),
				$token,
				$request->get_error_message()	
			);
			$this->send_error( $message );
		}else{
			$response = json_decode($request['body']);
			if(is_object($response)&&property_exists($response,'R')){
				if($response->R=='OK'){
					$options = get_option($this->options_varname);
					$options['license_keys'] = isset($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'] = is_array($options['license_keys'])?$options['license_keys']:array();
					$options['license_keys'][]=$response->LICENSE;
					update_option($this->options_varname,$options);
				}
			
				return $this->send_response($response);
			}else{
				$message = sprintf( __('There was a communication error with the RightHere server. Contact support at support.righthere.com about payment %s.  Error message: %s','pop'),
					$token,
					__('API Server returned an unrecognized format.','pop')
				);
				$this->send_error( $message );
			}		
		}
		//-------------------------
		$this->send_error( __('Service is unavailable, please try again later.','pop') );	
		die();	
	}	
}

endif;
?>