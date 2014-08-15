<?php

	class ShowBizOutput{
		
		private static $sliderSerial = 0;
		
		private $sliderHtmlID;
		private $slider;
		private $previewMode = false;	//admin preview mode
		private $previewTemplateMode = false;
		private $slidesNumIndex;
		private $template;
		private $initNavTemplateID;
		
		/**
		 * 
		 * check the put in string
		 * return true / false if the put in string match the current page.
		 */
		public static function isPutIn($putIn,$emptyIsFalse = false){
			
			$putIn = strtolower($putIn);
			$putIn = trim($putIn);
			
			if($emptyIsFalse && empty($putIn))
				return(false);
			
			if($putIn == "homepage"){		//filter by homepage
				if(is_front_page() == false)
					return(false);
			}				
			else		//case filter by pages	
			if(!empty($putIn)){
				$arrPutInPages = array();
				$arrPagesTemp = explode(",", $putIn);
				foreach($arrPagesTemp as $page){
					if(is_numeric($page) || $page == "homepage")
						$arrPutInPages[] = $page;
				}
				if(!empty($arrPutInPages)){
					
					//get current page id
					$currentPageID = "";
					if(is_front_page() == true)
						$currentPageID = "homepage";
					else{
						global $post;
						if(isset($post->ID))
							$currentPageID = $post->ID;
					}
						
					//do the filter by pages
					if(array_search($currentPageID, $arrPutInPages) === false) 
						return(false);
				}
			}
			
			return(true);
		}
		
		/**
		 * 
		 * put the slider on the html page.
		 * @param $data - mixed, can be ID ot Alias.
		 */
		public static function putSlider($sliderID,$putIn=""){
			$putIn = strtolower($putIn);
						
			if($putIn == "homepage"){		//filter by homepage
				if(is_front_page() == false)
					return(false);	
			}				
			else		//case filter by pages	
			if(!empty($putIn)){
				$arrPutInPages = array();
				$arrPagesTemp = explode(",", $putIn);
				foreach($arrPagesTemp as $page){
					if(is_numeric($page) || $page == "homepage")
						$arrPutInPages[] = $page;
				}
				if(!empty($arrPutInPages)){
					
					//get current page id
					$currentPageID = "";
					if(is_front_page() == true)
						$currentPageID = "homepage";
					else{
						global $post;
						if(isset($post->ID))
							$currentPageID = $post->ID;
					}
						
					//do the filter by pages
					if(array_search($currentPageID, $arrPutInPages) === false) 
						return(false);
				}
			}
			
			$output = new ShowBizOutput();
			
			$output->putSliderBase($sliderID);
			
			$slider = $output->getSlider();
			return($slider);
		}
		
		
		
		/**
		 * 
		 * set preview mode
		 */
		public function setPreviewMode($type = null,$navTemplateID = null){
			$this->previewMode = true;
			if($type == "template"){
				$this->previewTemplateMode = true;
				if(!empty($navTemplateID))
					$this->initNavTemplateID = $navTemplateID;
			}
		}
		
		
		/**
		 * 
		 * get the last slider after the output
		 */
		public function getSlider(){
			return($this->slider);
		}
		
		
		/**
		 * 
		 * put the slider slides
		 */
		private function putSlides(){
				
				$slides = $this->slider->getSlides(true);
				
				if(empty($slides))
					UniteFunctionsBiz::throwError("No Slides Found, Please add some slides");
				
				$templateHtml = $this->template->getContent();
				
				//$templateHtml = $this->getDemoTemplate();
				
				$this->slidesNumIndex = $this->slider->getSlidesNumbersByIDs(true);
				
				$hide_if_empty_img = $this->slider->getParam('hide_if_no_image', 'off');
				
                $image_source_type = $this->slider->getParam('img_source_type', 'full');
                $image_ratio = $this->slider->getParam('img_ratio', 'none');
                
				if(empty($slides)):
					?>
					<div class="no-slides-text">
						No items found, please add some items
					</div>
					<?php 
				endif;
				
				
				echo "<ul>";
				foreach($slides as $slide){
					
					$params = $slide->getParams();
					
					$text = $slide->getParam("slide_text","");
					
					$title = $slide->getParam("title","");
					$urlImage = $slide->getImageUrl();
					
					$urlImage = trim($urlImage);
					
					if(empty($urlImage) && $hide_if_empty_img == 'on') continue;
					
					$link = $slide->getParam("link","");
					
					//get the html from the local or global template
					$templateID = $slide->getParam("template_id","0");
					if(!empty($templateID) && $templateID != "0" && $templateID != 0){
						$template = new ShowBizTemplate();
						$template->initById($templateID);
						$html = $template->getContent();
					}else
						$html = $templateHtml;
					
                    $html = UniteFunctionsBiz::add_height_auto($html);
                    
					$html = $slide->processTemplateHtml($html);
					
                    //add height/width attribute
                    $html = UniteFunctionsBiz::add_height_width($html, $image_source_type, $image_ratio);
                    
					$customStyles = '';
					if($this->slider->getParam("custom_offset_control","false") == "true"){
						$customOffset = $this->slider->getParam("custom_offset","0");
						$customStyles = ' style="margin-right: '.$customOffset.'px;"';
					}
					
				?>
					<li<?php echo $customStyles; ?>>
						<?php 
							echo $html;
						?>
					</li>
					
				<?php 
				
				}
				echo "</ul>";
		}
		
		
		/**
		 * 
		 * put slider javascript
		 */
		private function putJS(){
			
			$params = $this->slider->getParams();			
			$noConflict = $this->slider->getParam("jquery_noconflict","on");
			
			// number of visible items array:
			$visible1 = $this->slider->getParam("visible_items_1","4",ShowBizSlider::VALIDATE_NUMERIC);
			$visible2 = $this->slider->getParam("visible_items_2","3",ShowBizSlider::VALIDATE_NUMERIC);
			$visible3 = $this->slider->getParam("visible_items_3","2",ShowBizSlider::VALIDATE_NUMERIC);
			$visible4 = $this->slider->getParam("visible_items_4","1",ShowBizSlider::VALIDATE_NUMERIC);
			
			$arrVisible = "[{$visible1},{$visible2},{$visible3},{$visible4}]";
			
			$rewindFromEnd = $this->slider->getParam("rewindFromEnd","off");
			
			//set several navigation mode params
			$carousel = "off";
			$drag = "off";
			$allEntry = "off";
			
			$navMode = $this->slider->getParam("navigation_mode","default");
			switch($navMode){
				case "drag":
					$drag = "on";
				break;
				case "all":
					$allEntry = "on";
				break;
				case "carousel":
					$carousel = "on";
					$rewindFromEnd = "off";
				break;
			}
			
			?>
			<script type="text/javascript">
			
			<?php if($noConflict == "on"):?>
				jQuery.noConflict();
			<?php endif;?>
				
				jQuery(document).ready(function() {
					
					if(jQuery('#<?php echo $this->sliderHtmlID?>').showbizpro == undefined)
						showbiz_showDoubleJqueryError('#<?php echo $this->sliderHtmlID?>');

					jQuery('#<?php echo $this->sliderHtmlID?>').showbizpro({
						dragAndScroll:"<?php echo $drag?>",
						carousel:"<?php echo $carousel?>",
						allEntryAtOnce:"<?php echo $allEntry?>",
						closeOtherOverlays:"<?php echo $this->slider->getParam("closeOtherOverlays","off"); ?>",
						entrySizeOffset:<?php echo $this->slider->getParam("entrySizeOffset","0",ShowBizSlider::FORCE_NUMERIC);?>,
						heightOffsetBottom:<?php echo $this->slider->getParam("heightOffsetBottom","0",ShowBizSlider::FORCE_NUMERIC);?>,
						conteainerOffsetRight:<?php echo $this->slider->getParam("conteainerOffsetRight","0",ShowBizSlider::FORCE_NUMERIC);?>,
						forceFullWidth:<?php echo ($this->slider->getParam("force_full_width","off") == 'on') ? 'true' : 'false';?>,
						visibleElementsArray:<?php echo $arrVisible?>,
						rewindFromEnd:"<?php echo $rewindFromEnd?>",
						autoPlay:"<?php echo $this->slider->getParam("autoPlay","off"); ?>",
						<?php if($this->slider->getParam("autoPlay","off") == "on"){ ?>scrollOrientation:"<?php echo $this->slider->getParam("scrollOrientation","left"); ?>",<?php } ?>
						
						delay:"<?php echo $this->slider->getParam("delay","3000",ShowBizSlider::FORCE_NUMERIC); ?>",
						speed:"<?php echo $this->slider->getParam("speed","300",ShowBizSlider::FORCE_NUMERIC); ?>",
						easing:"<?php echo $this->slider->getParam("easing","Power1.easeOut"); ?>"
					});
					
					<?php
					$operations = new BizOperations();
					$arrValues = $operations->getGeneralSettingsValues();
					$includeFancy = UniteFunctionsBiz::getVal($arrValues, "includes_globally_facybox","on");
					
					//include fancybox js
					if($includeFancy == "on"){
					?>
					
					jQuery(".fancybox").fancybox();
					
					<?php
					}
					?>
				});

			</script>
			
			<?php			
		}
		
		
		/**
		 * 
		 * put inline error message in a box.
		 */
		private function putErrorMessage($message, $trace){
			?>
			<div style="width:800px;height:300px;margin-bottom:10px;border:1px solid black;overflow:auto;">
				<div style="padding-top:40px;color:red;font-size:16px;text-align:center;">
					ShowBiz Error: <?php echo $message?>					
				</div>
				<br>
				<?php
					if(!empty($trace)) 
						dmp($trace);
				?> 
			</div>
			<?php 
		}
		
		
		/**
		 * 
		 * modify slider settings for preview mode
		 */
		private function modifyPreviewModeSettings(){
			$params = $this->slider->getParams();
			$params["js_to_body"] = "false";
			
			$this->slider->setParams($params);
		}
		

		
		/**
		 * 
		 * put html slider on the html page.
		 * @param $data - mixed, can be ID ot Alias.
		 */
		public function putSliderBase($sliderID){
						
			global $showbizVersion;
			
			try{
				self::$sliderSerial++;
				
				$this->slider = new ShowBizSlider();
				
				//if it's put template mode, the sliderID is the templateID
				if($this->previewMode == true && $this->previewTemplateMode == true){
					$this->slider->initByHardcodedDemo();
					$this->slider->setTemplateID($sliderID);
				}
				else{					
					$this->slider->initByMixed($sliderID);
				}
				
				//modify settings for admin preview mode
				if($this->previewMode == true)
					$this->modifyPreviewModeSettings();
				
				$this->sliderHtmlID = "showbiz_".$sliderID."_".self::$sliderSerial;
				
				//get template html:
				$templateID = $this->slider->getParam("template_id");
				UniteFunctionsBiz::validateNumeric($templateID,"Slider should have item template assigned");
				
				$this->template = new ShowBizTemplate();
				$this->template->initById($templateID);

				//get css template:
				$templateCSS = $this->template->getCss();
				
				//$templateCSS = $this->getDemoCss();
				
				//set navigation params (template, custom, none)
				$navigationType =  $this->slider->getParam("navigation_type","template");
				$navigationParams = "";
								
				if($navigationType == "template"){
					$navigationParams = " data-left=\"#showbiz_left_{$sliderID}\" data-right=\"#showbiz_right_{$sliderID}\" ";
					$navigationParams .= "data-play=\"#showbiz_play_{$sliderID}\" ";
					
					//get navigation template html:				
					$navTemplateID = $this->slider->getParam("nav_template_id");
					if(!empty($this->initNavTemplateID))
						$navTemplateID = $this->initNavTemplateID;
						
					UniteFunctionsBiz::validateNumeric($navTemplateID,"Slider should have navigation template assigned");
					
					$templateNavigation = new ShowBizTemplate();
					$templateNavigation->initById($navTemplateID);
					
					$navigationHtml = $templateNavigation->getContent();
					//$navigationHtml = $this->getDemoNavigationHtml();
					
					$navigationHtml = str_replace("[showbiz_left_button_id]", "showbiz_left_".$sliderID, $navigationHtml);
					$navigationHtml = str_replace("[showbiz_right_button_id]", "showbiz_right_".$sliderID, $navigationHtml);
					$navigationHtml = str_replace("[showbiz_play_button_id]", "showbiz_play_".$sliderID, $navigationHtml);
					
					$navigationCss = $templateNavigation->getCss();
					
					//$navigationCss = $this->getDemoNavigationCss();
					$templateCSS .= "\n".$navigationCss;
					
					$navPosition = $this->slider->getParam("nav_position","top");
					 
				}
				else if($navigationType == "custom"){
					$leftButtonID = $this->slider->getParam("left_buttonid");
					$rightButtonID = $this->slider->getParam("right_buttonid");
					$navigationParams = " data-left=\"#{$leftButtonID}\" data-right=\"#{$rightButtonID}\" ";	
				}
								
				$templateCSS = str_replace("[itemid]", "#".$this->sliderHtmlID, $templateCSS);
				
				$containerStyle = "";
				
				//set position:
				$sliderPosition = $this->slider->getParam("position","center");
				switch($sliderPosition){
					case "center":
					default:
						$containerStyle .= "margin:0px auto;";
					break;
					case "left":
						$containerStyle .= "float:left;";
					break;
					case "right":
						$containerStyle .= "float:right;";
					break;
				}
				
				//set margin:
				if($sliderPosition != "center"){
					$containerStyle .= "margin-left:".$this->slider->getParam("margin_left","0")."px;";
					$containerStyle .= "margin-right:".$this->slider->getParam("margin_right","0")."px;";
				}
				
				$containerStyle .= "margin-top:".$this->slider->getParam("margin_top","0")."px;";
				$containerStyle .= "margin-bottom:".$this->slider->getParam("margin_bottom","0")."px;";
				
				$clearBoth = $this->slider->getParam("clear_both","false");
				
				$htmlBeforeSlider = "";
				
				//put js to body handle
				if($this->slider->getParam("js_to_body","false") == "true"){
					$operations = new BizOperations();
					$arrValues = $operations->getGeneralSettingsValues();
					$use_hammer = UniteFunctionsBiz::getVal($arrValues, "use_hammer_js",'on');
					
					if($use_hammer == 'off'){
						$urlIncludeJS = UniteBaseClassBiz::$url_plugin."showbiz-plugin/js/jquery.themepunch.disablehammer.js?rev=". GlobalsShowBiz::SLIDER_REVISION;
						$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
					}
					
					
					//include showbiz js
					$urlIncludeJS = UniteBaseClassBiz::$url_plugin."showbiz-plugin/js/jquery.themepunch.tools.min.js?rev=". GlobalsShowBiz::SLIDER_REVISION;					
					$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
					$urlIncludeJS = UniteBaseClassBiz::$url_plugin."showbiz-plugin/js/jquery.themepunch.showbizpro.min.js?rev=". GlobalsShowBiz::SLIDER_REVISION;					
					$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeJS'></script>";
					
					
					$operations = new BizOperations();
					$arrValues = $operations->getGeneralSettingsValues();
					$includeFancy= UniteFunctionsBiz::getVal($arrValues, "includes_globally_facybox","on");
					
					
					//include fancybox js
					if($includeFancy == "on"){
						$urlIncludeFancybox = UniteBaseClassBiz::$url_plugin."showbiz-plugin/fancybox/jquery.fancybox.pack.js?rev=". GlobalsShowBiz::SLIDER_REVISION;					
						$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeFancybox'></script>";
						
						$urlIncludeFancybox = UniteBaseClassBiz::$url_plugin."showbiz-plugin/fancybox/helpers/jquery.fancybox-media.js?rev=". GlobalsShowBiz::SLIDER_REVISION;					
						$htmlBeforeSlider .= "<script type='text/javascript' src='$urlIncludeFancybox'></script>";
					}
				}
				
			
			ob_start();
						
				?>
				
			<!-- START SHOWBIZ <?php echo $showbizVersion?> -->	
			
			<?php echo $htmlBeforeSlider?>
			
			<?php if(!empty($templateCSS)): ?>
			<style type="text/css">
				<?php echo $templateCSS ?> 
			</style>
			<?php endif?>
			
			<div id="<?php echo $this->sliderHtmlID?>" class="showbiz-container" style="<?php echo $containerStyle?>">
				
				<?php if($navigationType == "template" && $navPosition == "top"): ?>
					<!-- start navigation -->
					<?php echo $navigationHtml?>
					<!--  end navigation -->
				<?php endif?>
				
				<div class="showbiz" <?php echo $navigationParams?>>
					<div class="overflowholder">
					
						<?php $this->putSlides() ?>
					
						<div class="sbclear"></div>
					</div> 
					<div class="sbclear"></div>
				</div>
				
				<?php if($navigationType == "template" && $navPosition == "bottom"): ?>
					<!-- start navigation -->
					<?php echo $navigationHtml?>
					<!--  end navigation -->
				<?php endif?>
				
			</div>
			
			<?php if($clearBoth == "true"):?>
				<div style="clear:both"></div>
			<?php endif?>
			
			<?php $this->putJS() ?>
				
			<!-- END SHOWBIZ -->
			
			<?php 

			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			echo $content;
			
			//check if option of refresh_images need to be set to false
			$refresh = $this->slider->getParam("refresh_images",'false');
			
			if($refresh == "true"){ //set param to false in DB
				$this->slider->updateParam(array("refresh_images" => "false"));
			}
			
			}catch(Exception $e){
				
				$debugMode = $this->slider->getParam("debug_mode","false");
				
				$content = ob_get_contents();
				
				$message = $e->getMessage();
				
				$trace = "";
				
				if($debugMode == "true"){
					ob_clean();ob_end_clean();	
					$trace = $e->getTraceAsString();
					$trace .= $content;
				}
								
				$this->putErrorMessage($message,$trace);
				
			}
		}


		/**
		 * 
		 * get demo template code
		 */
		private function getDemoTemplate(){
			ob_start();
			
			?>
			
				<div class="mediaholder">
					<div class="mediaholder_innerwrap">
						<img alt="" src="[showbiz_image]">

						<div class="hovercover">
							
							<a href="[showbiz_link]">
								<div class="linkicon notalone"><i class="icon-link"></i></div>
							</a>
							
							<a class="fancybox" rel="group" href="[showbiz_image]"><div class="lupeicon notalone"><i class="icon-search"></i></div></a>
						</div>	
					</div>
				</div>
				
				<div class="detailholder">
					<div class="showbiz-title"><a href="#">[showbiz_title]</a></div>
					<div class="showbiz-description">[showbiz_text]</div>
				</div>
				
			<?php

			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			return($content);
		}
		
		
		/**
		 * 
		 * get demo css
		 */
		private function getDemoCss(){
			ob_start();
			
			?>
			[itemid].showbiz-container{
				max-width:1210px; 
				min-width:300px;
			}
			
			[itemid] .showbiz-title{
				margin-top:10px;
				text-align:center;
			}
			
			[itemid] .showbiz-title,
			[itemid] .showbiz-title a,
			[itemid] .showbiz-title a:visited,
			[itemid] .showbiz-title a:hover	{
					color:#555; 
					font-family: 'Open Sans', sans-serif; 
					font-size:14px; 
					text-transform:uppercase;  
					text-decoration: none; 
					font-weight:700;
			}
			
			[itemid] .showbiz-description{
				margin-top:10px;
				text-align:center;
				font-size:13px; 
				line-height:22px; 
				color:#777; 
				font-family: 'Open Sans', sans-serif;	
			}
			
			<?php
			
			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();	
			return($content);
		}
		
		
		/**
		 * 
		 * get demo navigation html
		 */
		private function getDemoNavigationHtml(){
			ob_start();
			
			?>
			
			<div class="showbiz-navigation center sb-nav-grey">
				<div id="[showbiz_left_button_id]" class="sb-navigation-left"><i class="icon-left-open"></i></div>
				<div id="[showbiz_right_button_id]" class="sb-navigation-right"><i class="icon-right-open"></i></div>
				<div class="sbclear"></div>
			</div> 
				
			<?php

			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			return($content);
			
		}
		
		/**
		 * 
		 * get demo navigation html
		 */
		private function getDemoNavigationCss(){
			ob_start();
			
			?>
			
			[itemid] .showbiz-navigation{
				margin-bottom:10px;
			}
				
			<?php

			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			return($content);
			
		}
		
		
		
	}

?>