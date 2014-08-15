<?php

	class BizSlide extends UniteElementsBaseBiz{
		
		const TYPE_GALLERY = "gallery";
		const TYPE_POST = "post";
		
		private $slideType;
		private $id;
		private $sliderID;
		private $slideOrder = 0;
		
		private $thumbID;
		private $imageUrl;
		private $imageUrlOrig;
		private $imageFilepath;
		private $imageFilename;		
		
		private $params;
		private $slider;
		
		
		public function __construct(){
			parent::__construct();
		}
		
		/**
		 * 
		 * init image parameters from url
		 */
		private function initImageParams($urlImage, $size = UniteFunctionsWPBiz::THUMB_MEDIUM, $ratio = 'none', $refresh = 'false'){
			
			if(is_numeric($urlImage)){
				$this->thumbID = $urlImage;
				$this->imageUrl = UniteFunctionsWPBiz::getUrlAttachmentImage($this->thumbID,$size);
				$this->imageUrlOrig = UniteFunctionsWPBiz::getUrlAttachmentImage($this->thumbID,'full');
				
			}
			else{
				$this->imageUrl = $urlImage;
				$this->imageUrlOrig = $urlImage;
			}
			
			//set image path, file and url			
			if(!empty($this->imageUrl)){
				$this->imageFilepath = UniteFunctionsWPBiz::getImagePathFromURL($this->imageUrl);

		    	$realPath = UniteFunctionsWPBiz::getPathUploads().$this->imageFilepath;

				//scale img if needed
				if($ratio !== 'none'){
					$ratio = explode('_', $ratio);
					if(count($ratio) == 2){
						$image = wp_get_image_editor($realPath);
						if(!is_wp_error($image)){
							$origSize = $image->get_size();
							if(isset($origSize['width']) && $origSize['width'] > 0 && isset($origSize['height']) && $origSize['height'] > 0){
								$doCreate = true;
								//get new dimensions based on the scale ratio
								$newSize = UniteFunctionsBiz::getImageSizeByRatio($origSize['width'], $origSize['height'], $ratio['0'], $ratio['1']);

								//check if file exists with dimensions
								$suffix = $image->get_suffix();
								$fnCheck = $image->generate_filename();
								$fnCheck = str_replace($suffix, $newSize['0'].'x'.$newSize['1'], $fnCheck);
								//check if file exists
								if(file_exists($fnCheck) != false){
									if($refresh == 'false') $doCreate = false;
								}
									
								//refresh
								if($doCreate){
									$image->resize($newSize['0'], $newSize['1'], true);
									$newImage = $image->generate_filename();
									$image->save($newImage);
								}else{
									$newImage = $fnCheck;
								}
												
								if(trim($newImage) !== ''){
									$this->imageUrl = str_replace( ABSPATH, '', $newImage);
									$this->imageFilepath = UniteFunctionsWPBiz::getImagePathFromURL($this->imageUrl);			
									$realPath = UniteFunctionsWPBiz::getPathUploads().$this->imageFilepath;
									$this->imageUrl = get_bloginfo('wpurl').'/'.$this->imageUrl;

								}
							}
						}
					}
				}
				
			    if(file_exists($realPath) == false || is_file($realPath) == false)
			    	$this->imageFilepath = "";
				$this->imageFilename = basename($this->imageUrl);
			}
		}
		
		
		/**
		 * 
		 * get slider param
		 */
		private function getSliderParam($sliderID,$name,$default,$validate=null){
			
			if(empty($this->slider)){
				$this->slider = new ShowBizSlider();
				$this->slider->initByID($sliderID);
			}
			
			$param = $this->slider->getParam($name,$default,$validate);
			
			return($param);
		}
		
		
		/**
		 * 
		 * init slide by db record
		 */
		public function initByData($record){
			
			$this->slideType = self::TYPE_GALLERY;
			$this->id = $record["id"];
			$this->sliderID = $record["slider_id"];
			$this->slideOrder = $record["slide_order"];
			
			$params = $record["params"];
						
			$params = (array)json_decode($params);
			
			//make the excerpt
			$title = UniteFunctionsBiz::getVal($params, "title");
			$text = UniteFunctionsBiz::getVal($params, "slide_text");
			$intro = UniteFunctionsWPBiz::getIntroFromContent($text);
			
			$slider = new ShowBizSlider();
			$slider->initByID($this->sliderID);
			
			$delimiter = $slider->getParam("word_end",' ');
			if($delimiter == '') $delimiter = ' ';
			
			$limit_type = $slider->getParam("limit_by_type",'words');
			
			if(strlen($intro) == strlen($text)){
				
				$customLimit = UniteFunctionsBiz::getVal($params, "showbiz_excerpt_limit");
				$customLimit = (int)$customLimit;
				if(!empty($customLimit))
					$excerpt_limit = $customLimit;
				else{
					$excerpt_limit = $slider->getParam("excerpt_limit",55,ShowBizSlider::VALIDATE_NUMERIC);
					$excerpt_limit = (int)$excerpt_limit;
				}
				
				$textForExcerpt = strip_tags($text,"<b><br><br/><i><small>");
				if($limit_type == 'words')
					$intro = UniteFunctionsBiz::getTextIntro($textForExcerpt, $excerpt_limit, $delimiter);
				else
					$intro = UniteFunctionsBiz::getTextIntroChar($textForExcerpt, $excerpt_limit);
			}
			
			$title_limit = $slider->getParam("title_limit",99,ShowBizSlider::VALIDATE_NUMERIC);
			$titleForExcerpt = strip_tags($title,"<b><br><br/><i><small>");
			
			if($limit_type == 'words')
				$params["title"] = UniteFunctionsBiz::getTextIntro($titleForExcerpt, $title_limit, $delimiter);
			else
				$params["title"] = UniteFunctionsBiz::getTextIntroChar($titleForExcerpt, $title_limit);
				
			$params["orig_title"] = $title;
			
			$params["excerpt"] = $intro;
			
			//Lazy Load Settings
			$params["lazy_load"] = $slider->getParam("enable_lazy_load",'off');
			$params["lazy_load_height"] = $slider->getParam("lazy_load_height",100,ShowBizSlider::VALIDATE_NUMERIC);
			$params["lazy_load_image"] = $slider->getParam("lazy_load_image",'');
			
			
			$urlImage = UniteFunctionsBiz::getVal($params, "slide_image");
			
			$img_size = $slider->getParam("img_source_type",'full');
			
			if($img_size == 'custom'){
				$img_size_height = $slider->getParam("img_source_type_height",0,ShowBizSlider::VALIDATE_NUMERIC);
				$img_size_width = $slider->getParam("img_source_type_width",0,ShowBizSlider::VALIDATE_NUMERIC);
				if($img_size_height > 0 && $img_size_width > 0){
					$img_size = array($img_size_width,$img_size_height);
				}else{
					$img_size = 'full';
				}
			}
			
			$ratio = $slider->getParam("img_ratio",'none');
			$refresh = $slider->getParam("refresh_images",'false');
			
		    $this->initImageParams($urlImage, $img_size, $ratio, $refresh);
			
			$this->params = $params;
			
			//dmp($this->params);exit();
		}
		
		
		/**
		 * 
		 * init slide as a demo
		 */
		public function initDemoData($demoType){
			
			$operations = new BizOperations();
			$params = $operations->getSlideDemoData($demoType);
			
			$this->params = $params;
			
			$this->imageUrl = $params["slide_image"];
			$this->imageUrlOrig = $params["slide_image"];
			$this->slideType = "gallery";
			$this->id = 999;
		}
		
		
		
		/**
		 * 
		 * init the slider by id
		 */
		public function initByID($slideid){
			UniteFunctionsBiz::validateNumeric($slideid,"Slide ID");
			$slideid = $this->db->escape($slideid);
			$record = $this->db->fetchSingle(GlobalsShowBiz::$table_slides,"id=$slideid");
			
			$this->initByData($record);
		}
		
		
		/**
		 * 
		 * init by post id
		 */
		public function initByPostID($postID,$sliderID,$slider=null){
			
			$arrPostData = UniteFunctionsWPBiz::getPost($postID);
						
			$this->initByPostData($arrPostData, $sliderID);
		}
		
		
		/**
		 * 
		 * init by post data
		 */
		public function initByPostData($postData,$sliderID,$imgSourceType = UniteFunctionsWPBiz::THUMB_MEDIUM,$ratio='none',$refresh='false'){
		
			$postID = $postData["ID"];
			
			$this->slideType = self::TYPE_POST;
			
			$this->id = $postID;
			$this->sliderID = $sliderID;
						
			$this->slideOrder = $postData["menu_order"];
			
			$params = array();
			$params["title"] = UniteFunctionsBiz::getVal($postData, "post_title");
			$params["alias"] = UniteFunctionsBiz::getVal($postData, "post_name");
			$params["slide_text"] = UniteFunctionsBiz::getVal($postData, "post_content");
			$params["link"] = get_permalink($postID);
			
			$postDate = UniteFunctionsBiz::getVal($postData, "post_date_gmt");
			$dateModified = UniteFunctionsBiz::getVal($postData, "post_modified");
			
			$params["date"] = UniteFunctionsWPBiz::convertPostDate($postDate);
			$params["date_modified"] = UniteFunctionsWPBiz::convertPostDate($dateModified);
			
			//add author name
			$authorID = UniteFunctionsBiz::getVal($postData, "post_author");			
			$params["author_id"] = $authorID;
			$params["author_name"] = UniteFunctionsWPBiz::getUserDisplayName($authorID);
			$params["num_comments"] = UniteFunctionsBiz::getVal($postData, "comment_count");

			//get categories and tags
			$postCatsIDs = $postData["post_category"];
			$params["catlist"] =  UniteFunctionsWPBiz::getCategoriesHtmlList($postCatsIDs);
			$params["taglist"] = UniteFunctionsWPBiz::getTagsHtmlList($postID);
			
			$status = $postData["post_status"];
			
			if($status == "publish")
				$params["state"] = "published";
			else
				$params["state"] = "unpublished";
				
			//get wildcards settings
			$objWildcards = new ShowBizWildcards();
			$settings = $objWildcards->getWildcardsSettings(true);
			$settings->updateValuesFromPostMeta($postID);
						
			$arrWildcardsValues = $settings->getArrValues();
			
			$params = array_merge($params,$arrWildcardsValues);
			
			//get the excerpt:
			$customLimit = UniteFunctionsBiz::getVal($params, "showbiz_excerpt_limit");
			$customLimit = (int)$customLimit;
			if(!empty($customLimit))
				$excerpt_limit = $customLimit;
			else{
				
				$excerpt_limit = $this->getSliderParam($sliderID,"excerpt_limit",55,ShowBizSlider::VALIDATE_NUMERIC);
				$excerpt_limit = (int)$excerpt_limit;				
			}
			$delimiter = $this->getSliderParam($sliderID,"word_end",' ');
			if($delimiter == '') $delimiter = ' ';
			
			$limit_type = $this->getSliderParam($sliderID,"limit_by_type",'words');
			
			$params["excerpt"] = UniteFunctionsWPBiz::getExcerptById($postID, $excerpt_limit, $delimiter, $limit_type);
			
			
			$title_limit = $this->getSliderParam($sliderID,"title_limit",99,ShowBizSlider::VALIDATE_NUMERIC);
			
			if($limit_type == 'words')
				$params["title"] = UniteFunctionsBiz::getTextIntro($params["title"], $title_limit, $delimiter);
			else
				$params["title"] = UniteFunctionsBiz::getTextIntroChar($params["title"], $title_limit);
			
			
			//Lazy Load Settings
			$params["lazy_load"] = $this->getSliderParam($sliderID,"enable_lazy_load",'off');
			$params["lazy_load_height"] = $this->getSliderParam($sliderID,"lazy_load_height",100,ShowBizSlider::VALIDATE_NUMERIC);
			$params["lazy_load_image"] = $this->getSliderParam($sliderID,"lazy_load_image",'');
			
			
			//init image url
			$thumbID = UniteFunctionsWPBiz::getPostThumbID($postID);
			 
			$this->initImageParams($thumbID, $imgSourceType, $ratio, $refresh);
			
			$this->params = $params;
			
			//dmp($this->params);exit();
		}
		
		
		/**
		 * 
		 * get slide ID
		 */
		public function getID(){
			return($this->id);
		}
		
		
		/**
		 * 
		 * get slide order
		 */
		public function getOrder(){
			$this->validateInited();
			return($this->slideOrder);
		}
		
		/**
		 * 
		 * get title
		 */
		public function getValue($name){
			$this->validateInited();
			$value = UniteFunctionsBiz::getVal($this->params, $name);
			return($value);
		}
		
		
		
		/**
		 * 
		 * get params for export
		 */
		public function getParamsForExport(){
			$arrParams = $this->getParams();
			$urlImage = UniteFunctionsBiz::getVal($arrParams, "slide_image");
			if(!empty($urlImage))
				$arrParams["slide_image"] = UniteFunctionsWPBiz::getImagePathFromURL($urlImage);
			
			return($arrParams);
		}
		
		

		/**
		 * 
		 * get slide params
		 */
		public function getParams(){
			$this->validateInited();
			return($this->params);
		}

		
		/**
		 * 
		 * get parameter from params array. if no default, then the param is a must!
		 */
		function getParam($name,$default=null){
			
			if($default === null){
				if(!array_key_exists($name, $this->params))
					UniteFunctionsBiz::throwError("The param <b>$name</b> not found in slide params.");
				$default = "";
			}
				
			return UniteFunctionsBiz::getVal($this->params, $name,$default);
		}
		
		
		/**
		 * 
		 * get image filename
		 */
		public function getImageFilename(){
			return($this->imageFilename);
		}
		
		
		/**
		 * 
		 * get image filepath
		 */
		public function getImageFilepath(){
			return($this->imageFilepath);
		}
		
		/**
		 * 
		 * get image url
		 */
		public function getImageUrl(){
			return($this->imageUrl);
		}
		
		
		/**
		 * 
		 * get thumb url
		 */
		public function getUrlImageThumb(){
			
			//get image url by thumb
			if(!empty($this->thumbID)){
				$urlImage = UniteFunctionsWPBiz::getUrlAttachmentImage($this->thumbID, UniteFunctionsWPBiz::THUMB_MEDIUM);
			}else{
				//get from cache
				if(!empty($this->imageFilepath)){
					$urlImage = UniteBaseClassBiz::getImageUrl($this->imageFilepath,200,100,true);
				}
				else {
					$urlImage = $this->imageUrl;
				}
			}
			
			if(empty($urlImage)){
				$urlImage = $this->imageUrl;
			}
			return($urlImage);
		}
		
		
		/**
		 * 
		 * get the slider id
		 */
		public function getSliderID(){
			return($this->sliderID);
		}
		
		/**
		 * 
		 * validate that the slider exists
		 */
		private function validateSliderExists($sliderID){
			$slider = new ShowBizSlider();
			$slider->initByID($sliderID);
		}
		
		/**
		 * 
		 * validate that the slide is inited and the id exists.
		 */
		private function validateInited(){
			if(empty($this->id))
				UniteFunctionsBiz::throwError("The slide is not inited!!!");
		}
		
		
		/**
		 * 
		 * create the slide (from image)
		 */
		public function createSlide($sliderID,$urlImage = ""){
			//get max order
			$slider = new ShowBizSlider();
			$slider->initByID($sliderID);
			$maxOrder = $slider->getMaxOrder();
			$order = $maxOrder+1;
			
			$jsonParams = "";
			if(!empty($urlImage)){
				$params = array();
				$params["slide_image"] = $urlImage;
				$jsonParams = json_encode($params);
			}
			
			$arrInsert = array("params"=>$jsonParams,
			           		   "slider_id"=>$sliderID,
								"slide_order"=>$order
						);
			
			$slideID = $this->db->insert(GlobalsShowBiz::$table_slides, $arrInsert);
			
			return($slideID);
		}
		
		/**
		 * 
		 * update slide image from data
		 */
		public function updateSlideImageFromData($data){
						
			$urlImage = UniteFunctionsBiz::getVal($data, "url_image");
			
			$imageID = UniteFunctionsBiz::getVal($data, "image_id");
			$slideID = UniteFunctionsBiz::getVal($data, "slide_id");			
			
			if(!empty($imageID))
				$urlImage = $imageID;	//replace the image url by attachment id if exists
			
			$sliderID = UniteFunctionsBiz::getVal($data, "slider_id");
			$slider = new ShowBizSlider();
			$slider->initByID($sliderID);
			
			if($slider->isSourceFromPosts()){	//from posts
				
				if(!empty($imageID))
					UniteFunctionsWPBiz::updatePostThumbnail($slideID, $imageID);
				
			}else{	//from gallery
				$this->initByID($slideID);					
				$arrUpdate = array();
				$arrUpdate["slide_image"] = $urlImage;
				$this->updateParamsInDB($arrUpdate);
			}
						
			return($urlImage);
		}
		
		/**
		 * 
		 * update slide parameters in db
		 */
		private function updateParamsInDB($arrUpdate){
						
			$this->params = array_merge($this->params,$arrUpdate);
			$jsonParams = json_encode($this->params);
			
			$arrDBUpdate = array("params"=>$jsonParams);
			
			$this->db->update(GlobalsShowBiz::$table_slides,$arrDBUpdate,array("id"=>$this->id));
		}

		
		/**
		 * 
		 * update slide from data
		 * @param $data
		 */
		public function updateSlideFromData($data){
			
			$slideID = UniteFunctionsBiz::getVal($data, "slideid");
			$this->initByID($slideID);
			
			//treat params
			$params = UniteFunctionsBiz::getVal($data, "params");
			$params = $this->normalizeParams($params);
						
			$arrUpdate = array();
			$arrUpdate["params"] = json_encode($params);
			
			$this->db->update(GlobalsShowBiz::$table_slides,$arrUpdate,array("id"=>$this->id));
		}
		
		
		/**
		 * 
		 * delete slide from data
		 */
		public function deleteSlideFromData($data){
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderID");
			
			$slider = new ShowBizSlider();
			$slider->initByID($sliderID);
			
			$slideID = UniteFunctionsBiz::getVal($data, "slideID");
			
			if($slider->isSourceFromPosts()){
				UniteFunctionsWPBiz::deletePost($slideID);
			}else{
				$this->initByID($slideID);
				$this->db->delete(GlobalsShowBiz::$table_slides,"id='$slideID'");
			}
			
		}
		
		/**
		 * 
		 * normalize params
		 */
		private function normalizeParams($params){
			
			if(isset($params["slide_text"])){
				$params["slide_text"] = UniteFunctionsBiz::normalizeTextareaContent($params["slide_text"]);
			}
			
			return($params);
		}
		
		
		/**
		 * 
		 * set params from client
		 */
		public function setParams($params){
			$params = $this->normalizeParams($params);
			$this->params = $params;
		}
		
		
		/**
		/* toggle slide state from data
		 */
		public function toggleSlideStatFromData($data){
			
			$sliderID = UniteFunctionsBiz::getVal($data, "slider_id");
			$slideID = UniteFunctionsBiz::getVal($data, "slide_id");
			
			//init slider
			$slider = new ShowBizSlider();
			$slider->initByID($sliderID);
			
			if($slider->isSourceFromPosts()){
				$this->initByPostID($slideID,$sliderID);
				$state = $this->getParam("state","published");
				$newState = ($state == "published")?"unpublished":"published";
				
				$wpStatus = ($newState == "published")?UniteFunctionsWPBiz::STATE_PUBLISHED:UniteFunctionsWPBiz::STATE_DRAFT;
				
				//update the state in wp
				UniteFunctionsWPBiz::updatePostState($slideID, $wpStatus);
				
			}else{
				$this->initByID($slideID);
				
				$state = $this->getParam("state","published");
				
				$newState = ($state == "published")?"unpublished":"published";
				$arrUpdate = array();
				$arrUpdate["state"] = $newState;
				
				$this->updateParamsInDB($arrUpdate);
			}
			
			$this->params["state"] = $newState;
			
			return($newState);
		}
		
		
		/**
		 * 
		 * replace template placeholder
		 */
		private function replacePlaceholder($holderName,$text,$html,$addPrefix = true){
			$prefix = "showbiz_";
			if($addPrefix == true)
				$name = $prefix.$holderName;
			else
				$name = $holderName;
			
			$html = str_replace("[$name]",$text,$html);
			return($html);
		}
		
		
		/**
		 * 
		 * process template html
		 * get item html and process it by the template
		 */
		public function processTemplateHtml($html){
			
			$title = $this->getValue("title");
			$alias = $this->getValue("alias");
			$urlImage = $this->imageUrl;
			$urlImageOrig = $this->imageUrlOrig;
			$text = $this->getValue("slide_text");
			$link = $this->getValue("link");
			if(empty($link))
				$link = "#";
				
			$date = $this->getValue("date");
									
			$dateModified = $this->getValue("date_modified");
			$excerpt = $this->getValue("excerpt");
			
			$youtubeID = $this->getValue("youtube_id");
			$vimeoID = $this->getValue("vimeo_id");
			$authorName = $this->getValue("author_name");
			$authorID = $this->getValue("author_id");
			$numComments = $this->getValue("num_comments");
			$catList = $this->getValue("catlist");
			$tagList = $this->getValue("taglist");
			$postID = $this->id;
			
			if($this->getValue('lazy_load') == 'on'){
				$html = UniteFunctionsBiz::add_lazy_loading($html, $this->getValue('lazy_load_image'), $this->getValue('lazy_load_height'));
			}
			
			//replace the items in the html
			$html = $this->replacePlaceholder("title", $title, $html);
			$html = $this->replacePlaceholder("id", $postID, $html);
			$html = $this->replacePlaceholder("alias", $alias, $html);
			$html = $this->replacePlaceholder("name", $alias, $html);
			$html = $this->replacePlaceholder("empty_image", UniteBaseClassBiz::$url_plugin.'images/transparent.png', $html);
			$html = $this->replacePlaceholder("image", $urlImage, $html);
			$html = $this->replacePlaceholder("image_orig", $urlImageOrig, $html);
			$html = $this->replacePlaceholder("content", $text, $html);
			$html = $this->replacePlaceholder("link", $link, $html);
			$html = $this->replacePlaceholder("date", $date, $html);
			$html = $this->replacePlaceholder("modified_date", $dateModified, $html);
			$html = $this->replacePlaceholder("excerpt", $excerpt, $html);
			$html = $this->replacePlaceholder("youtube_id", $youtubeID, $html);
			$html = $this->replacePlaceholder("vimeo_id", $vimeoID, $html);
			$html = $this->replacePlaceholder("author_id", $authorID, $html);
			$html = $this->replacePlaceholder("author", $authorName, $html);
			$html = $this->replacePlaceholder("numcomments", $numComments, $html);
			$html = $this->replacePlaceholder("catlist", $catList, $html);
			$html = $this->replacePlaceholder("taglist", $tagList, $html);
			
			//replace custom options:
			$wildcards = new ShowBizWildcards();
			$arrCustomOptionsNames = $wildcards->getWildcardsSettingNames();
			
			foreach($arrCustomOptionsNames as $name=>$title){
				$html = $this->replacePlaceholder($name, $this->getValue($name), $html, false);
			}
			
			//replace woocommerce options:
			$enableWC = $this->getParam("enable_wc","on");
			
			if($enableWC == "on" && UniteFunctionsWooCommerceBiz::isWooCommerceExists() && $this->slideType == self::TYPE_POST){
				
				$WCRegularPrice = get_post_meta($this->id, "_regular_price",true);
				$WCSalePrice = get_post_meta($this->id, "_sale_price",true);
				$WCStock = get_post_meta($this->id, "_stock",true);
				
				$WCProduct = get_product($this->id);
				$WCRating = $WCProduct->get_average_rating();
				if(empty($WCRating))
					$WCRating = 0;
					
				$WCCategories = $WCProduct->get_categories(",");
				
				$html = $this->replacePlaceholder("wc_regular_price", $WCRegularPrice, $html);
				$html = $this->replacePlaceholder("wc_sale_price", $WCSalePrice, $html);
				$html = $this->replacePlaceholder("wc_stock", $WCStock, $html);
				$html = $this->replacePlaceholder("wc_rating", $WCRating, $html);
				$html = $this->replacePlaceholder("wc_categories", $WCCategories, $html);
			}
			
			//process meta tags:
			$arrMatches = array();
			
			//preg_match('/\[showbiz_meta:\w+\]/', $html, $arrMatches);
			preg_match_all('/\[showbiz_meta:\w+\]/', $html, $arrMatches);
			
			foreach($arrMatches as $matches){
				if(is_array($matches))
					foreach($matches as $match){
						$meta = str_replace("[showbiz_meta:", "", $match);
						$meta = str_replace("]","",$meta);
						$metaValue = get_post_meta($postID,$meta,true);
						
						$html = str_replace($match,$metaValue,$html);
					}
			}
			
			//$meta = get_post_meta($this->id);dmp($meta);exit();
			
			//replace all the normal shortcodes
			$html = do_shortcode($html);
			
			
			//check for shortcodes
			
			
			return($html);
		}
		
		
	}
	
?>