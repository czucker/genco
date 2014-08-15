<?php

	class BizOperations extends UniteElementsBaseBiz{


		/**
		 *
		 * preview slider output
		 * if output object is null - create object
		 */
		public function previewOutput($sliderID,$output = null){

			if($sliderID == "empty_output"){
				$this->loadingMessageOutput();
				exit();
			}

			if($output == null)
				$output = new ShowBizOutput();

			$output->setPreviewMode();

			//put the output html
			$urlPlugin = ShowBizAdmin::$url_plugin."showbiz-plugin/";
			
			$operations = new BizOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			$includeFancyBackend= UniteFunctionsBiz::getVal($arrValues, "includes_globally_facybox_be","on");
			
			?>
				<html>
					<head>
						<link rel='stylesheet' href='<?php echo $urlPlugin?>css/settings.css?rev=<?php echo GlobalsShowBiz::SLIDER_REVISION; ?>' type='text/css' media='all' />
						<?php if($includeFancyBackend == "on"){ ?>
						<link rel='stylesheet' href='<?php echo $urlPlugin?>fancybox/jquery.fancybox.css?rev=<?php echo GlobalsShowBiz::SLIDER_REVISION; ?>' type='text/css' media='all' />
						<?php } ?>
						
						<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
						<?php if($includeFancyBackend == "on"){ ?>
						<script type='text/javascript' src='<?php echo $urlPlugin?>fancybox/jquery.fancybox.pack.js?rev=<?php echo GlobalsShowBiz::SLIDER_REVISION; ?>'></script>
						<?php } ?>
						<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.tools.min.js?rev=<?php echo GlobalsShowBiz::SLIDER_REVISION; ?>'></script>
						<script type='text/javascript' src='<?php echo $urlPlugin?>js/jquery.themepunch.showbizpro.min.js?rev=<?php echo  GlobalsShowBiz::SLIDER_REVISION; ?>'></script>
					</head>
					<body style="padding:0px;margin:20px;">
						<?php
							$output->putSliderBase($sliderID);
						?>
					</body>
				</html>
			<?php
			exit();
		}



		/**
		 *
		 * output loading message
		 */
		public function loadingMessageOutput(){
			?>
			<div class="message_loading_preview">Loading Preview...</div>
			<?php
		}

		/**
		 *
		 * preview template output
		 * @param int $templateID
		 */
		public function previewTemplateOutput($templateID){

			if($templateID == "empty_output"){
				$this->loadingMessageOutput();
				exit();
			}

			$output = new ShowBizOutput();

			//if it's a navigation template, load firs template
			$template = new ShowBizTemplate();
			$template->initById($templateID);
			$templateType = $template->getType();
			if($templateType == GlobalsShowBiz::TEMPLATE_TYPE_BUTTON){
				$navigationTempalateID = $templateID;
				$templateID = $template->getFirstTemplateID(GlobalsShowBiz::TEMPLATE_TYPE_ITEM);

				//navigation template mode
				$output->setPreviewMode("template",$navigationTempalateID);
			}else{
				//item template mode
				$output->setPreviewMode("template");
			}

			$this->previewOutput($templateID,$output);
		}


		/**
		 *
		 * get one item of init template
		 */
		private static function getInitTemplate($name,$filenameHtml,$filenameCss, $type){
			$arr = array();
			$arr["name"] = $name;
			$arr["filenameHtml"] = $filenameHtml;
			$arr["filenameCss"] = $filenameCss;
			$arr["type"] = $type;
			return($arr);
		}

		/**
		 *
		 * get array of init item templates
		 */
		public static function getArrInitItemTemplates($namesOnly = false){
			$arrTemplates = array();
			$arrTemplates[] =  self::getInitTemplate("Grey Skin", "skin_grey.html", "skin_grey.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Light Skin", "skin_light.html", "skin_light.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Caption Skin", "skin_caption.html", "skin_caption.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("ShowCase Skin", "skin_showcase.html", "skin_showcase.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Vimeo Skin", "skin_vimeo.html", "skin_vimeo.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Mixed Video Skin", "skin_mixedvideo.html", "skin_mixedvideo.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);	
			$arrTemplates[] =  self::getInitTemplate("YouTube Skin", "skin_youtube.html", "skin_youtube.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Retro Light Skin", "skin_r_light.html", "skin_r_light.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Retro Dark Skin", "skin_r_dark.html", "skin_r_dark.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Modern Skin", "skin_modern.html", "skin_modern.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("WooCommerce Skin", "skin_woo_grey.html", "skin_woo_grey.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("WooCommerce ShowCase Skin", "skin_woo_showcase.html", "skin_woo_showcase.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Velocity Blog Skin", "skin_velocity_blog.html", "skin_velocity_blog.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("Velocity Portfolio Skin", "skin_velocity_portfolio.html", "skin_velocity_portfolio.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("WooCommerce Velocity Skin", "skin_velocity_woocommerce.html", "skin_velocity_woocommerce.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			$arrTemplates[] =  self::getInitTemplate("WooCommerce Velocity Skin 2", "skin_velocity_woocommerce_2.html", "skin_velocity_woocommerce_2.css", GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
			if($namesOnly == true)
				foreach($arrTemplates as $index=>$arr)
						$arrTemplates[$index] = $arr["name"];

			return($arrTemplates);
		}

		/**
		 *
		 * get array of init item templates
		 */
		public static function getArrInitNavigationTemplates($namesOnly = false){
			$arrTemplates = array();
			$arrTemplates[] =  self::getInitTemplate("Light Navigation", "navigation_light.html", "navigation_light.css", GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
			$arrTemplates[] =  self::getInitTemplate("Grey Navigation", "navigation_grey.html", "navigation_grey.css", GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
			$arrTemplates[] =  self::getInitTemplate("Dark Navigation", "navigation_dark.html", "navigation_dark.css", GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
			$arrTemplates[] =  self::getInitTemplate("Retro Light Navigation", "navigation_retro_light.html", "navigation_retro_light.css", GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
			$arrTemplates[] =  self::getInitTemplate("Retro Dark Navigation", "navigation_retro_dark.html", "navigation_retro_dark.css", GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);

			if($namesOnly == true)
				foreach($arrTemplates as $index=>$arr)
						$arrTemplates[$index] = $arr["name"];

			return($arrTemplates);
		}

		/**
		 *
		 * get array of all init templates
		 */
		private function getArrInitTemplates(){
			$arrItems = self::getArrInitItemTemplates();
			$arrNavs = self::getArrInitNavigationTemplates();
			$arrCommon = array_merge($arrItems,$arrNavs);
			return($arrCommon);
		}

		/**
		 *
		 * get template html and css file data
		 *
		 */
		public function getTemplateFileData($arrTemplate){

			$filenameHtml = $arrTemplate["filenameHtml"];
			$filenameCss = $arrTemplate["filenameCss"];

			$filepathHtml = UniteBaseAdminClassBiz::$path_init_data."templates/".$filenameHtml;
			$filepathCss = UniteBaseAdminClassBiz::$path_init_data."templates/".$filenameCss;

			if(file_exists($filepathHtml) == false)
				UniteFunctionsBiz::throwError("File $filepathHtml not found. Can't init the plugin");

			if(file_exists($filepathCss) == false)
				UniteFunctionsBiz::throwError("File $filepathCss not found. Can't init the plugin");

			$contentHtml = file_get_contents($filepathHtml);
			$contentCss = file_get_contents($filepathCss);

			$arrOutput = array("html"=>$contentHtml,"css"=>$contentCss);

			return($arrOutput);
		}


		/**
		 * get template array by it's name
		 */
		public function getTemplateByName($name,$addData = false){
			$arrTemplates = $this->getArrInitTemplates();
			foreach($arrTemplates as $template){
				if($template["name"] == $name){
					if($addData == true){
						$response = $this->getTemplateFileData($template);
						$template = array_merge($template,$response);
					}
					return($template);
				}
			}

			UniteFunctionsBiz::throwError("Template with name: $name not found");
		}


		/**
		 *
		 * get params of slider demo
		 */
		public function getSliderDemoParams(){

			$params = array();
			$params["title"] = "Slider Demo";
			$params["alias"] = "slider_demo";
			$params["source_type"] = "gallery";

			//set template ID
			$template = new ShowBizTemplate();
			$params["template_id"] = $template->getFirstTemplateID(GlobalsShowBiz::TEMPLATE_TYPE_ITEM);

			$navTemplateID = $template->getFirstTemplateID(GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
			$params["nav_template_id"] = $navTemplateID;

			return($params);
		}



		/**
		 *
		 * get slide demo data
		 */
		public function getSlideDemoData($numDemo = 1){

			$params = array();
			$params["title"] = "Slide Demo ".$numDemo;
			$params["state"] = "published";
			$params["template_id"] = 0;
			$params["enable_link"] = true;
			$params["link"] = "http://www.google.com";
			$params["slide_text"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
			$params["showbiz_excerpt_limit"] = "";
			$params["youtube_id"] = "9bZkp7q19f0";
			$params["vimeo_id"] = "18554749";
			$params["excerpt"] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
			$params["numcomments"] = "10";
			$params["author"] = "Joh Doe";
			$params["showbiz_price"] = "10$";
			$params["showbiz_color"] = "red";

			//set slide image
			$urlImages = UniteBaseClassBiz::$url_plugin."images/";
			switch($numDemo){
				default:
				case 1:
					$urlImage = $urlImages."slide_demo1.jpg";
				break;
				case 2:
					$urlImage = $urlImages."slide_demo2.jpg";
				break;
				case 3:
					$urlImage = $urlImages."slide_demo3.jpg";
				break;
			}

			$params["slide_image"] = $urlImage;

			//TODO: check the demo with the custom options

			return($params);
		}


		/**
		 *
		 * get the template markup editor hard coded buttons.
		 */
		public function getArrEditorButtons(){
			$prefix = "showbiz_";
			$arrButtons = array();
			$arrButtons[$prefix."id"] = "ID";
			$arrButtons[$prefix."title"] = "Title";
			$arrButtons[$prefix."author"] = "Author";
			$arrButtons[$prefix."author_id"] = "Author ID";
			$arrButtons[$prefix."alias"] = "Alias";
			//$arrButtons[$prefix."empty_image"] = "Empty Image";
			$arrButtons[$prefix."image"] = "Image Url";
			$arrButtons[$prefix."image_orig"] = "Orig. Image Url";
			$arrButtons[$prefix."content"] = "Content";
			$arrButtons[$prefix."excerpt"] = "Excerpt (text intro)";
			$arrButtons[$prefix."numcomments"] = "Num. of Comments";
			$arrButtons[$prefix."link"] = "Link";
			$arrButtons[$prefix."date"] = "Date";
			$arrButtons[$prefix."catlist"] = "Categoires";
			$arrButtons[$prefix."taglist"] = "Tags";
			$arrButtons[$prefix."modified_date"] = "Modified Date";
			$arrButtons[$prefix."youtube_id"] = "Youtube ID";
			$arrButtons[$prefix."vimeo_id"] = "Vimeo ID";

			if(UniteFunctionsWooCommerceBiz::isWooCommerceExists()){
				$arrButtons[$prefix."wc_regular_price"] = "WC Regular Price";
				$arrButtons[$prefix."wc_sale_price"] = "WC Sale Price";
				$arrButtons[$prefix."wc_stock"] = "WC Stock";
				$arrButtons[$prefix."wc_rating"] = "WC Rating";
				$arrButtons[$prefix."wc_categories"] = "WC Cats";
			}

			return($arrButtons);
		}


		/**
		 *
		 * get class array
		 */
		private function getClassArray($name,$desc,$html){
			$class = array(
				"name"=>$name,
				"description"=>$desc,
				"html"=>$html);

			return($class);
		}


		/**
		 *
		 * get the tempalte markup editor hard coded classes
		 */
		public function getArrEditorClasses(){

			$arrClasses = array();

			$arrClasses[] = $this->getClassArray("Media Holder Simple", "A Markup to show Media (Featured Image)",
'
<!-- THE MEDIA HOLDER PART -->
<div class="mediaholder">
	<div class="mediaholder_innerwrap">
		<img alt="" src="[showbiz_image]">
     </div>
</div><!-- END OF MEDIA HOLDER PART -->
');

			$arrClasses[] = $this->getClassArray("Media Holder & Link", "A Markup to show Media (Featured Image) with a Link Button",
'
<!-- THE MEDIA HOLDER PART -->
<div class="mediaholder">
	<div class="mediaholder_innerwrap">
		<img alt="" src="[showbiz_image]">

		<!-- THE HOVER EFFECT (SPECIAL CLASS  - hovercover) -->
        <div class="hovercover">

			<!-- LINK TO THE POST -->
			<a href="[showbiz_link]">
				<div class="linkicon"><i class="sb-icon-link"></i></div>
			</a>
		</div>	<!-- END OF THE HOVER EFFECT -->
    </div>
</div><!-- END OF MEDIA HOLDER PART -->
');

			$arrClasses[] = $this->getClassArray("Media Holder & Zoom", "A Markup to show Media (Featured Image) with a Zoom Button and FancyBox Function",
'
<!-- THE MEDIA HOLDER PART -->
<div class="mediaholder">
	<div class="mediaholder_innerwrap">
		<img alt="" src="[showbiz_image]">

		<!-- THE HOVER EFFECT (SPECIAL CLASS  - hovercover) -->
        <div class="hovercover">

			<!-- LIGHTBOX LINK -->
			<a class="fancybox" rel="group" href="[showbiz_image]"><div class="lupeicon"><i class="sb-icon-search"></i></div></a>
		</div>	<!-- END OF THE HOVER EFFECT -->
      </div>
</div><!-- END OF MEDIA HOLDER PART -->
');



			$arrClasses[] = $this->getClassArray("Media Holder All", "The Media Holder with Link and Zoom Icon to link to the Post and to show image in LightBox",
'
<!-- THE MEDIA HOLDER PART -->
<div class="mediaholder">
	<div class="mediaholder_innerwrap">
		<img alt="" src="[showbiz_image]">

		<!-- THE HOVER EFFECT (SPECIAL CLASS  - hovercover) -->
        <div class="hovercover">

			<!-- LINK TO THE POST -->
			<a href="[showbiz_link]">
				<div class="linkicon notalone"><i class="sb-icon-link"></i></div>
			</a>
			<!-- LIGHTBOX LINK -->
			<a class="fancybox" rel="group" href="[showbiz_image]"><div class="lupeicon notalone"><i class="sb-icon-search"></i></div></a>
		</div>	<!-- END OF THE HOVER EFFECT -->
     </div>
</div><!-- END OF MEDIA HOLDER PART -->
');



			$arrClasses[] = $this->getClassArray("Detail Holder", "Some Content Holder under the Media Holder. i.e. Title and Excerpt",
'
<!-- VISIBLE TEXTS ON THE TEASER - TITLE AND EXCERPT -->
<div class="detailholder">
	<div class="showbiz-title"><a href="#">[showbiz_title]</a></div>
	<div class="showbiz-description">[showbiz_excerpt]</div>
</div>

');

			$arrClasses[] = $this->getClassArray("Reveal Inplace", "Show some Hidden Content in Place if Reveal Opener has been clicked.",
'
	<!-- REVEAL CONTAINER (SINGLE MODE) -->
	<div class="reveal_container">

		<!-- THE REVEAL CONTENT, ONLY IN DETAIL MODE VISIBLE -->
		<div class="reveal_wrapper">
			<p class="pt40">[showbiz_excerpt]</p>
		</div>

	</div><!-- END OF REVEAL CONTAINER -->


	<!-- THE REVEAL OPEN/CLOSE BUTTON - ONLY VISIBLE ON HOVER, DEFAULT STYLE -->
	<div class="reveal_opener show_on_hover">
		<span class="openme">+</span>
		<span class="closeme">-</span>
	</div>

');

			$arrClasses[] = $this->getClassArray("Animated Title", "A Title which moves to the Top if Reveal has been opened. (Works with Reveal Inplace at best)",
'
	<!-- ANIMATED HEADING INFORMATION, ALWAYS VISIBLE -->
	<div class="showbiz-title go-to-top"><div class="[showbiz_option1]"><a href="#">[showbiz_title]</a></div></div>


');

			$arrClasses[] = $this->getClassArray("Reveal Fullwidth", "Hidden Container, which is only visible if \"reveal opener\" has been clicked.  Hidden container opens up in FullWidth",
'
	<!-- THE REVEAL CONTAINER - OPENING IN FULLWIDTH -->
	<div class="reveal_container tofullwidth">

		<!-- THE REVEL HIDDEN / VISIBLE CONTAINER -->
		<div class="reveal_wrapper">
			<div class="heightadjuster">
				PUT YOUR CONTENT HERE
			</div>
		</div><!-- END OF HIDDEN / VISIBLE CONTAINER -->

		<!-- THE REVEAL OPENER -->
		<div class="reveal_opener">
			<span class="openme">+</span>
			<span class="closeme">-</span>
		</div><!-- END OF REVEAL OPENER -->
	</div>
');

			$arrClasses[] = $this->getClassArray("Reveal Opener With Hover", "Reveal Opener (replace existing one please !) with show/hide function if mouse is hovering",
'
	<!-- THE REVEAL OPEN/CLOSE BUTTON - ONLY VISIBLE ON HOVER, DEFAULT STYLE -->
	<div class="reveal_opener show_on_hover sb-centered sb-controll-button">
		<span class="openme"><i class="sb-icon-play"></i></span>
		<span class="closeme"><i class="sb-icon-cancel"></i></span>
	</div>
');


			$arrClasses[] = $this->getClassArray("Rating Stars", "Add Ratings with Stars. use data-value='3,5' i.e. for 3 and half star",
'
	<!-- THE RATINGS WITH STARS  USE RATING VALUE IN data-rates="2,5" i.e.  or for WC data-rates="[showbiz_wc_rating]" FOR CREATING STARS-->
	  <div class="txt-center"><span class="rating-star" data-rates="[showbiz_wc_rating]"></span></div>
');


			/*$arrClasses[] = $this->getClassArray("Image Lazy Loading", "Add an image tag with lazy loading functionality",
'
	<!-- IMAGE LAZY LOADING -->
	  <img alt="image" src="[showbiz_empty_image]" data-lazyloadsrc="[showbiz_image]" data-lazyloadheight="60">
');*/



			return($arrClasses);
		}


		/**
		 * put link help
		 */
		public static function putLinkHelp($link){
			?>
				<a href="<?php echo $link?>" target="_blank" style="margin-top:15px;" class="button-secondary float_right link_documentation" >Help</a>
			<?php
		}
		
		/**
		 * put global settings button
		 */
		public static function putGlobalSettingsHelp(){
			?>
				<a href="javascript:void(0);" style="margin-top:15px; margin-left: 10px;" class="button-secondary float_right" id="button_general_settings" >Global Settings</a>
			<?php
		}

		/**
		 *
		 * get post types with categories for client side.
		 */
		public static function getPostTypesWithCatsForClient(){
			$arrPostTypes = UniteFunctionsWPBiz::getPostTypesWithCats();

			$globalCounter = 0;

			$arrOutput = array();
			foreach($arrPostTypes as $postType => $arrTaxWithCats){

				$arrCats = array();
				foreach($arrTaxWithCats as $tax){
					$taxName = $tax["name"];
					$taxTitle = $tax["title"];
					$globalCounter++;
					$arrCats["option_disabled_".$globalCounter] = "---- {$taxTitle} ----";
					foreach($tax["cats"] as $catID=>$catTitle){
						$arrCats["{$taxName}_{$catID}"] = $catTitle;
					}
				}//loop tax

				$arrOutput[$postType] = $arrCats;

			}//loop types

			return($arrOutput);
		}


		/**
		 *
		 * scan and get all sliders post types
		 */
		public static function getAllSlidersPostTypes(){
			$sliders = new ShowBizSlider();
			$arrSliders = $sliders->getArrSliders();
			$arrAssoc = array();

			//the post shoudl be always in
			$arrAssoc["post"] = "post";
			foreach($arrSliders as $slider){
				$postTypes = $slider->getParam("post_types","post");
				$arrPostTypes = explode(",", $postTypes);
				$assoc = UniteFunctionsBiz::arrayToAssoc($arrPostTypes);
				$arrAssoc = array_merge($arrAssoc,$assoc);
			}

			$arr = UniteFunctionsBiz::assocToArray($arrAssoc);

			return($arr);
		}
		
		
		/**
		 * update general settings
		 */
		public function updateGeneralSettings($data){

			$strSettings = serialize($data);
			$params = new ShowBizParams();
			$params->updateFieldInDB("general", $strSettings);
		}
		
		
		/**
		 * 
		 * get general settigns values.
		 */
		static function getGeneralSettingsValues(){
			
			$params = new ShowBizParams();
			$strSettings = $params->getFieldFromDB("general");
			
			$arrValues = array();
			if(!empty($strSettings))
				$arrValues = unserialize($strSettings);
			
			return($arrValues);
		}
		
		
		
		
		public function checkPurchaseVerification($data){
			global $wp_version;
			
			$response = wp_remote_post('http://updates.themepunch.com/activate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => array(
					'name' => urlencode($data['username']),
					'api' => urlencode($data['api_key']),
					'code' => urlencode($data['code']),
					'product' => urlencode('showbiz')
				)
			));
			
			$response_code = wp_remote_retrieve_response_code( $response );
			$version_info = wp_remote_retrieve_body( $response );
			
			if ( $response_code != 200 || is_wp_error( $version_info ) ) {
				return false;
			}
			
			if($version_info == 'valid'){
				update_option('showbiz-valid', 'true');
				update_option('showbiz-api-key', $data['api_key']);
				update_option('showbiz-username', $data['username']);
				update_option('showbiz-code', $data['code']);
				
				return true;
			}elseif($version_info == 'exist'){
				UniteFunctionsBiz::throwError(__('Purchase Code already registered!'));
			}else{
				return false;
			}
			
		}
		
		public function doPurchaseDeactivation($data){
			global $wp_version;
		
			$key = get_option('showbiz-api-key', '');
			$name = get_option('showbiz-username', '');
			$code = get_option('showbiz-code', '');
			
			$response = wp_remote_post('http://updates.themepunch.com/deactivate.php', array(
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body' => array(
					'name' => urlencode($name),
					'api' => urlencode($key),
					'code' => urlencode($code),
					'product' => urlencode('showbiz')
				)
			));
			
			$response_code = wp_remote_retrieve_response_code( $response );
			$version_info = wp_remote_retrieve_body( $response );
			
			if ( $response_code != 200 || is_wp_error( $version_info ) ) {
				return false;
			}
			
			if($version_info == 'valid'){
				//update_option('showbiz-api-key', '');
				//update_option('showbiz-username', '');
				//update_option('showbiz-code', '');
				update_option('showbiz-valid', 'false');
				
				return true;
			}else{
				return false;
			}
			
		}

	}//end class

?>