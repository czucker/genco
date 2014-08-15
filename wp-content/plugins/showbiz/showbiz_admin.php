<?php

	class ShowBizAdmin extends UniteBaseAdminClassBiz{
		
		const DEFAULT_VIEW = "sliders";
		
		const VIEW_SLIDER = "slider";
		const VIEW_SLIDERS = "sliders";
		
		const VIEW_SLIDES = "slides";
		const VIEW_SLIDE = "slide";
		const VIEW_TEMPLATES = "templates";
		const VIEW_TEMPLATES_NAV = "templates-nav";
		
		
		/**
		 * 
		 * the constructor
		 */
		public function __construct($mainFilepath){
			
			parent::__construct($mainFilepath,$this,self::DEFAULT_VIEW);
			
			//set table names
			GlobalsShowBiz::initGlobals();
			
			$this->init();
		}
		
		
		/**
		 * 
		 * init all actions
		 */
		private function init(){
						
			//self::setDebugMode();
			
			self::addMenuPage('ShowBiz', "adminPages");
			self::addSubMenuPage("sliders", 'Sliders', "adminPages");
			self::addSubMenuPage("templates", 'Skin Editor', "adminPages");			
			self::addSubMenuPage("templates-nav", 'Navigation Skin Editor', "adminPages");			
			
			$this->addWildCards();
			
			self::requireSettings("general_settings");
			//add common scripts there
			//self::addAction(self::ACTION_ADMIN_INIT, "onAdminInit");
			
			//ajax response to save slider options.
			self::addActionAjax("ajax_action", "onAjaxAction");
			
			$validated = get_option('showbiz-valid', 'false');
			$notice = get_option('showbiz-valid-notice', 'true');
			
			if($validated === 'false' && $notice === 'true'){
				self::addAction('admin_notices', 'addActivateNotification');
			}
			
			$upgrade = new UniteUpdateClassBiz( GlobalsShowBiz::SLIDER_REVISION );
			
			$upgrade->_retrieve_version_info();
			
			if($validated == 'true') {
				$upgrade->add_update_checks();
			}
		}
		
		
		public function addActivateNotification(){
			$nonce = wp_create_nonce("showbiz_actions");
			?>
			<div class="updated below-h2 sb-update-notice-wrap" id="message"><a href="javascript:void(0);" style="float: right;padding-top: 9px;" id="sb-dismiss-notice"><?php _e('(never show this message again)&nbsp;&nbsp;<b>X</b>'); ?></a><p><?php _e('Hi! Would you like to activate your version of ShowBiz to recieve automatic updates & get premium support? This is optional and not needed if the slider came bundled with a theme. '); ?></p></div>
			<script type="text/javascript">
				jQuery('#sb-dismiss-notice').click(function(){
					var objData = {
									action:"<?php echo self::$dir_plugin; ?>_ajax_action",
									client_action: 'dismiss_notice',
									nonce:'<?php echo $nonce; ?>',
									data:''
									};
					
					jQuery.ajax({
						type:"post",
						url:ajaxurl,
						dataType: 'json',
						data:objData
					});
					
					jQuery('.sb-update-notice-wrap').hide();
				});
			</script>
			<?php
		}
		
		/**
		 * 
		 * add wildcards metabox variables to psots
		 */
		private function addWildCards(){
			try{
				$objWildcards = new ShowBizWildcards();
				$settings = $objWildcards->getWildcardsSettings(true);
				
				$postTypes = BizOperations::getAllSlidersPostTypes();
				self::addMetaBox("ShowBiz Options",$settings,array("ShowBizAdmin","customPostFieldsOutput"),$postTypes);
			}catch(Exception $e){
				
			}
		}
		
		
		/**
		 * 
		 * TODO: remove me
		 */
		public static function customPostFieldsOutput(UniteSettingsProductSidebarBiz $output){
			
			//$settings = $output->getArrSettingNames();
			
			?>
				<table>
					<tr>
						<td valign="top" width="350px;">
							<ul class="showbiz_settings">
							<?php
								$output->drawSettingsByNames("template_id,showbiz_excerpt_limit,youtube_id,vimeo_id");
							?>
							</ul>
						</td>
						<td valign="top">
							<ul class="showbiz_settings">							
							<?php $output->drawSettingsByParam("custom_type", "user"); ?>
							</ul>
						</td>
				</table>
			<?php 
		}
		
		/**
		 * a must function. please don't remove it.
		 * process activate event - install the db (with delta).
		 */
		public static function onActivate(){
			self::createDBTables();
		}
		
		
		/**
		 * 
		 * create db tables 
		 */
		public static function createDBTables(){
			
			self::createTable(GlobalsShowBiz::TABLE_SLIDERS_NAME);
			self::createTable(GlobalsShowBiz::TABLE_SLIDES_NAME);
			self::createTable(GlobalsShowBiz::TABLE_SETTINGS_NAME);
						
			$tableTemplates = self::$table_prefix.GlobalsShowBiz::TABLE_TEMPLATES_NAME;
			if(UniteFunctionsWPBiz::isDBTableExists($tableTemplates) == false){
				self::createTable(GlobalsShowBiz::TABLE_TEMPLATES_NAME);
				self::initTemplatesData();
				
				//add 2 custom options to wildcards
				$wildcards = new ShowBizWildcards();
				$wildcards->addCustomOption("Color", "color");
				$wildcards->addCustomOption("Price", "price");
			}
		}
		
		/**
		 * 
		 * insert template to templates table
		 */
		private static function insertTemplate($title, $filenameHtml, $filenameCss, $type){
			
			$filepathHtml = self::$path_init_data."templates/".$filenameHtml;
			$filepathCss = self::$path_init_data."templates/".$filenameCss;
			
			if(file_exists($filepathHtml) == false)
				UniteFunctionsBiz::throwError("File $filepathHtml not found. Can't init the plugin");

			if(file_exists($filepathCss) == false)
				UniteFunctionsBiz::throwError("File $filepathCss not found. Can't init the plugin");
				
			$contentHtml = file_get_contents($filepathHtml);
			$contentCss = file_get_contents($filepathCss);
			
			$tempaltes = new ShowBizTemplate();
			$response = $tempaltes->add($contentHtml, $title, $contentCss, $type,true);
			
			return($response);
		}
		
		
		/**
		 * 
		 * init templates data
		 */
		private static function initTemplatesData(){
			
			$arrItemTemplates = BizOperations::getArrInitItemTemplates();
			$arrNavigationTemplates = BizOperations::getArrInitNavigationTemplates();
			
			$arrTemplates = array_merge($arrItemTemplates,$arrNavigationTemplates);
			$responses = "";
			foreach($arrTemplates as $template){
				$response = self::insertTemplate($template["name"], 
									 $template["filenameHtml"], 
									 $template["filenameCss"],
									 $template["type"]);
				$responses .= $response."<br>";				
			}
			
			return($responses);
		}
		
		
		/**
		 * 
		 * a must function. adds scripts on the page
		 * add all page scripts and styles here.
		 * pelase don't remove this function
		 * common scripts even if the plugin not load, use this function only if no choise.
		 */
		public static function onAddScripts(){
			
			//add google font
			//$urlGoogleFont = "http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700";					
			//self::addStyleAbsoluteUrl($urlGoogleFont,"google-font-pt-sans-narrow");
			
			self::addScript("showbiz_admin");
			
			self::addScript("jquery.themepunch.tools.min","showbiz-plugin/js",'tp-tools');
			
			//include all media upload scripts
			self::addMediaUploadIncludes();
			
			//add rs css:
			self::addStyle("settings","showbiz-plugin-settings","showbiz-plugin/css");
		}
		
		
		/**
		 * 
		 * add scripts that 
		 */
		public static function addOutsideScripts(){
			self::addStyle("post_settings","showbiz-post-settings","css");
		}
		
		/**
		 * 
		 * admin main page function.
		 */
		public static function adminPages(){
			
			self::createDBTables();
			
			parent::adminPages();
			
			//require styles by view
			switch(self::$view){
				case self::VIEW_SLIDERS:
				case self::VIEW_SLIDER:
					self::requireSettings("slider_settings");
				break;
				case self::VIEW_SLIDES:					
				break;
				case self::VIEW_SLIDE:
				break;
			}
			
			self::setMasterView("master_view");
			self::requireView(self::$view);
		}

		
		
		/**
		 * 
		 * craete tables
		 */
		public static function createTable($tableName){
			global $wpdb;
			
			//if table exists - don't create it.
			$tableRealName = self::$table_prefix.$tableName;
			if(UniteFunctionsWPBiz::isDBTableExists($tableRealName)){
				//check if we need to update the settings table
				if($tableName == GlobalsShowBiz::TABLE_SETTINGS_NAME){
					$result = $wpdb->query("SHOW COLUMNS FROM `".self::$table_prefix.$tableName."` LIKE 'general'");
					
					if($result == 0){
						$wpdb->query("ALTER TABLE `".self::$table_prefix.$tableName."` ADD general TEXT NOT NULL");
					}
				}
				
				return(false);
			}
			$charset_collate = '';
					
			if(method_exists($wpdb, "get_charset_collate"))
				$charset_collate = $wpdb->get_charset_collate();
			else{
				if ( ! empty($wpdb->charset) )
					$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
				if ( ! empty($wpdb->collate) )
					$charset_collate .= " COLLATE $wpdb->collate";
			}
				
			switch($tableName){
				case GlobalsShowBiz::TABLE_SLIDERS_NAME:					
				$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
							  id int(9) NOT NULL AUTO_INCREMENT,
							  title tinytext NOT NULL,
							  alias tinytext,
							  params text NOT NULL,
							  PRIMARY KEY (id)
							)$charset_collate;";
				break;
				case GlobalsShowBiz::TABLE_SLIDES_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  slider_id int(9) NOT NULL,
								  slide_order int not NULL,		  
								  params text NOT NULL,
								  PRIMARY KEY (id)
								)$charset_collate;";
				break;
				case GlobalsShowBiz::TABLE_TEMPLATES_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  title tinytext NOT NULL,
								  type tinytext NOT NULL,
								  content TEXT NOT NULL,
								  css TEXT NOT NULL,
								  ordering int not NULL,
								  params TEXT NOT NULL,
								  PRIMARY KEY (id)
								)$charset_collate;";
				break;
				
				case GlobalsShowBiz::TABLE_SETTINGS_NAME:
					$sql = "CREATE TABLE " .self::$table_prefix.$tableName ." (
								  id int(9) NOT NULL AUTO_INCREMENT,
								  wildcards TEXT NOT NULL,
								  general TEXT NOT NULL,
								  params TEXT NOT NULL,
								  PRIMARY KEY (id)
								)$charset_collate;";
				break;
				
				
				default:
					UniteFunctionsBiz::throwError("table: $tableName not found");
				break;
			}
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}

		
		/**
		 * 
		 * import slideer handle (not ajax response)
		 */
		private static function importSliderHandle(){
			
			dmp("importing slider setings and data...");
			
			$slider = new ShowBizSlider();
			$response = $slider->importSliderFromPost();
			$sliderID = $response["sliderID"];
			
			$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);
			if(empty($sliderID))
				$viewBack = self::getViewUrl(self::VIEW_SLIDERS);
			
			//handle error
			if($response["success"] == false){
				$message = $response["error"];
				dmp("<b>Error: ".$message."</b>");
				echo UniteFunctionsBiz::getHtmlLink($viewBack, "Go Back");
			}
			else{	//handle success, js redirect.
				dmp("Slider Import Success, redirecting...");
				echo "<script>location.href='$viewBack'</script>"; 
			}
			exit();
		}
		
		
		/**
		 * 
		 * update showbiz plugin, init the templates if option selected.
		 */
		public static function updateShowbizPlugin(){
			$updateBase = UniteFunctionsBiz::getPostVariable("update_base_templates","off");
			
			$viewBack = self::DEFAULT_VIEW;
			
			self::updatePlugin(self::DEFAULT_VIEW, false);
			
			if($updateBase == "on"){
				$response = self::initTemplatesData();
				dmp($response);
			}
			
			dmp("Updated Successfully, redirecting...");
			
			$linkBack = self::getViewUrl($viewBack);
			
			echo "<script>location.href='$linkBack'</script>";
						
		}
		
		
		/**
		 * 
		 * onAjax action handler
		 */
		public static function onAjaxAction(){
			
			$slider = new ShowBizSlider();
			$slide = new BizSlide();
			$templates = new ShowBizTemplate();
			$operations = new BizOperations();
			$wildcards = new ShowBizWildcards();
			
			$action = self::getPostGetVar("client_action");
			$data = self::getPostGetVar("data");
			
			
			try{
				
				switch($action){
					case "update_general_settings":
						$operations->updateGeneralSettings($data);
						self::ajaxResponseSuccess(__("General settings updated",SHOWBIZ_TEXTDOMAIN));
					break;
					case "export_slider":
						$sliderID = self::getGetVar("sliderid");
						$slider->initByID($sliderID);
						$slider->exportSlider();
					break;
					case "import_slider":
						self::importSliderHandle();
					break;
					case "create_slider":
						$newSliderID = $slider->createSliderFromOptions($data);
						
						self::ajaxResponseSuccessRedirect(
						            "The slider successfully created", 
									self::getViewUrl("sliders"));
						
					break;
					case "update_slider":
						$slider->updateSliderFromOptions($data);
						self::ajaxResponseSuccess("Slider updated");
					break;
					
					case "delete_slider":
						
						$slider->deleteSliderFromData($data);
						
						self::ajaxResponseSuccessRedirect(
						            "The slider deleted", 
									self::getViewUrl(self::VIEW_SLIDERS));
					break;
					case "duplicate_slider":
						
						$slider->duplicateSliderFromData($data);
						
						self::ajaxResponseSuccessRedirect(
						            "The duplicate successfully, refreshing page...", 
									self::getViewUrl(self::VIEW_SLIDERS));
					break;
					
					case "add_slide":
						$slider->createSlideFromData($data);
						$sliderID = $data["sliderid"];
						
						self::ajaxResponseSuccessRedirect(
						            "Slide Created, refreshing...", 
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "update_slide":
						$slide->updateSlideFromData($data);
						self::ajaxResponseSuccess("Slide updated");
					break;
					case "delete_slide":
						$slide->deleteSlideFromData($data);
						$sliderID = UniteFunctionsBiz::getVal($data, "sliderID");
						self::ajaxResponseSuccessRedirect(
						            "Slide Deleted Successfully", 
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));					
					break;
					case "duplicate_slide":
						$sliderID = $slider->duplicateSlideFromData($data);
						self::ajaxResponseSuccessRedirect(
						            "Slide Duplicated Successfully", 
									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));
					break;
					case "update_slides_order":
						$slider->updateSlidesOrderFromData($data);
						self::ajaxResponseSuccess("Order updated successfully");
					break;
					case "preview_slide":
						$operations->putSlidePreviewByData($data);
					break;
					case "preview_slider":
						$sliderID = UniteFunctionsBiz::getPostVariable("sliderid");
						$operations->previewOutput($sliderID);
					break;
					case "preview_template":
						$templateID = UniteFunctionsBiz::getPostGetVariable("templateid");
						$operations->previewTemplateOutput($templateID);
					break;
					case "toggle_slide_state":
						$currentState = $slide->toggleSlideStatFromData($data);
						self::ajaxResponseData(array("state"=>$currentState));
					break;
					case "update_plugin":
						self::updateShowbizPlugin();
					break;
					case "create_template":	
						$templates->addFromData($data);
						self::ajaxResponseSuccess("Template Added Successfully");
					break;
					case "delete_template":
						$templates->deleteFromData($data);
						self::ajaxResponseSuccess("Template Deleted Successfully");
					break;
					case "duplicate_template":
						$templates->duplicateFromData($data);
						self::ajaxResponseSuccess("Template Duplicated Successfully");
					break;					
					case "get_template_content":
						$content = $templates->getContentFromData($data);
						$arrData = array("content"=>$content);
						self::ajaxResponseData($arrData);
					break;
					case "get_template_css":
						$css = $templates->getCssFromData($data);
						$arrData = array("css"=>$css);
						self::ajaxResponseData($arrData);
					break;
					case "update_template_content":
						$templates->updateContentFromData($data);
						self::ajaxResponseSuccess("Content Updated Successfully");
					break;
					case "update_template_title":
						$templates->updateTitleFromData($data);
						self::ajaxResponseSuccess("Title Updated Successfully");
					break;
					case "update_template_css":
						$templates->updateCssFromData($data);
						self::ajaxResponseSuccess("Css Updated Successfully");
					break;
					case "restore_original_template":
						$templates->restoreOriginalFromData($data);
						self::ajaxResponseSuccess("Template Restored");
					break;
					case "update_posts_sortby":
						$slider->updatePostsSortbyFromData($data);
						self::ajaxResponseSuccess("Sortby updated");
					break;
					case "change_slide_image":
						$slide->updateSlideImageFromData($data);
						self::ajaxResponseSuccess("Image Changed");
					break;
					case "add_wildcard":
						$response = $wildcards->addFromData($data);
						self::ajaxResponseSuccess("Added successfully",$response);
					break;
					case "remove_wildcard":
						$response = $wildcards->removeFromData($data);
						self::ajaxResponseSuccess("Removed successfully",$response);
					break;
					case "activate_purchase_code":
						
						$result = false;
						
						if(!empty($data['username']) && !empty($data['api_key']) && !empty($data['code'])){
							
							$result = $operations->checkPurchaseVerification($data);
							
						}else{
							UniteFunctionsBiz::throwError(__('The API key, the Purchase Code and the Username need to be set!'));
							exit();
						}
						
						if($result){
							self::ajaxResponseSuccessRedirect(
						            __("Purchase Code Successfully Activated"), 
									self::getViewUrl(self::VIEW_SLIDERS));
						}else{
							UniteFunctionsBiz::throwError(__('Purchase Code is invalid'));
						}
					break; 
					case "deactivate_purchase_code":
						$result = $operations->doPurchaseDeactivation($data);
						
						if($result){
							self::ajaxResponseSuccessRedirect(
						            __("Successfully removed validation"), 
									self::getViewUrl(self::VIEW_SLIDERS));
						}else{
							UniteFunctionsBiz::throwError(__('Could not remove Validation!'));
						}			
					break; 
					case "dismiss_notice":
						update_option('showbiz-valid-notice', 'false');
						self::ajaxResponseSuccess(__("."));
					break; 
					default:
						self::ajaxResponseError("wrong ajax action: $action ");
					break;
				}
				
			}
			catch(Exception $e){
				$message = $e->getMessage();
				
				self::ajaxResponseError($message);
			}
			
			//it's an ajax action, so exit
			self::ajaxResponseError("No response output on <b> $action </b> action. please check with the developer.");
			exit();
		}
		
	}
	
	
?>