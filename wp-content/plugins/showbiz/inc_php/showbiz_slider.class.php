<?php

	class ShowBizSlider extends UniteElementsBaseBiz{
		
		const DEFAULT_POST_SORTBY = "ID";
		const DEFAULT_POST_SORTDIR = "DESC";
		
		const VALIDATE_NUMERIC = "numeric";
		const VALIDATE_EMPTY = "empty";
		const FORCE_NUMERIC = "force_numeric";
		
		private $id;
		private $title;
		private $alias;
		private $arrParams;
		private $arrSlides = null;	
		private $demoMode = false;
		
		public function __construct(){
			parent::__construct();
		}
		
		/**
		 * 
		 * validate that the slider is inited. if not - throw error
		 */
		private function validateInited(){
			if(empty($this->id))
				UniteFunctionsBiz::throwError("The slider is not inited!");
		}
		
		/**
		 * 
		 * init slider by db data
		 * 
		 */
		public function initByDBData($arrData){
			
			$this->id = $arrData["id"];
			$this->title = $arrData["title"];
			$this->alias = $arrData["alias"];
			
			$params = $arrData["params"];
			$params = (array)json_decode($params);
			
			$this->arrParams = $params;
			
		}
		
		
		/**
		 * 
		 * init the slider object by database id
		 */
		public function initByID($sliderID){
			UniteFunctionsBiz::validateNumeric($sliderID,"Slider ID");
			$sliderID = $this->db->escape($sliderID);
			
			try{
				$sliderData = $this->db->fetchSingle(GlobalsShowBiz::$table_sliders,"id=$sliderID");								
			}catch(Exception $e){
				UniteFunctionsBiz::throwError("Slider with ID: $sliderID Not Found");
			}
			
			$this->initByDBData($sliderData);
		}

		/**
		 * 
		 * init slider by alias
		 */
		public function initByAlias($alias){
			$alias = $this->db->escape($alias);

			try{
				$where = "alias='$alias'";
				
				$sliderData = $this->db->fetchSingle(GlobalsShowBiz::$table_sliders,$where);
				
			}catch(Exception $e){
				$arrAliases = $this->getAllSliderAliases();
				$strAliases = "";
				if(!empty($arrAliases))
					$strAliases = "'".implode("' or '", $arrAliases)."'";
					
				$errorMessage = "Slider with alias <strong>$alias</strong> not found.";
				if(!empty($strAliases))
					$errorMessage .= " <br><br>Maybe you mean: ".$strAliases;
					
				UniteFunctionsBiz::throwError($errorMessage);
			}
			
			$this->initByDBData($sliderData);
		}
		
		
		/**
		 * 
		 * init by id or alias
		 */
		public function initByMixed($mixed){
			if(is_numeric($mixed))
				$this->initByID($mixed);
			else
				$this->initByAlias($mixed);
		}
		
		
		/**
		 * 
		 * init by hardcoded demo
		 */
		public function initByHardcodedDemo(){
			$this->demoMode = true;
			$this->id = 999;
			
			$operations = new BizOperations();
			$params = $operations->getSliderDemoParams();
						
			$this->arrParams = $params;
		}
		
		
		/**
		 * 
		 * set template ID
		 */
		public function setTemplateID($templateID){
			
			$this->arrParams["template_id"] = $templateID;
		}
		
		
		/**
		 * 
		 * get data functions
		 */
		public function getTitle(){
			return($this->title);
		}
		
		public function getID(){
			return($this->id);
		}
		
		public function getParams(){
			return($this->arrParams);
		}
		
		/**
		 * 
		 * set slider params
		 */
		public function setParams($arrParams){
			$this->arrParams = $arrParams;
		}
		
		
		/**
		 * 
		 * get parameter from params array. if no default, then the param is a must!
		 */
		function getParam($name,$default=null,$validateType = null,$title=""){
			
			if($default === null){
				if(!array_key_exists($name, $this->arrParams))
					UniteFunctionsBiz::throwError("The param <b>$name</b> not found in slider params.");
				
				$default = "";
			}
			
			$value = UniteFunctionsBiz::getVal($this->arrParams, $name,$default);
						
			//validation:
			switch($validateType){
				case self::VALIDATE_NUMERIC:
				case self::VALIDATE_EMPTY:
					$paramTitle = !empty($title)?$title:$name;
					if($value !== "0" && $value !== 0 && empty($value))
						UniteFunctionsBiz::throwError("The param <strong>$paramTitle</strong> should not be empty.");
				break;
				case self::VALIDATE_NUMERIC:
					$paramTitle = !empty($title)?$title:$name;
					if(!is_numeric($value))
						UniteFunctionsBiz::throwError("The param <strong>$paramTitle</strong> should be numeric. Now it's: $value");
				break;
				case self::FORCE_NUMERIC:
					if(!is_numeric($value)){
						$value = 0;
						if(!empty($default))
							$value = $default;
					}
				break; 
			}
			
			return $value;
		}
		
		public function getAlias(){
			return($this->alias);
		}
		
		/**
		 * get combination of title (alias)
		 */
		public function getShowTitle(){
			$showTitle = $this->title." ($this->alias)";
			return($showTitle);
		}
		
		/**
		 * 
		 * get slider shortcode
		 */
		public function getShortcode(){
			$shortCode = "[showbiz {$this->alias}]";
			return($shortCode);
		}
		
		
		/**
		 * 
		 * check if alias exists in DB
		 */
		private function isAliasExistsInDB($alias){
			$alias = $this->db->escape($alias);
			
			$where = "alias='$alias'";
			if(!empty($this->id))
				$where .= " and id != '{$this->id}'";
				
			$response = $this->db->fetch(GlobalsShowBiz::$table_sliders,$where);
			return(!empty($response));
			
		}
		
		
		/**
		 * 
		 * validate settings for add
		 */
		private function validateInputSettings($title,$alias,$params){
			UniteFunctionsBiz::validateNotEmpty($title,"title");
			UniteFunctionsBiz::validateNotEmpty($alias,"alias");
			
			if($this->isAliasExistsInDB($alias))
				UniteFunctionsBiz::throwError("Some other slider with alias '$alias' already exists");
		}
		
		
		/**
		 * 
		 * create / update slider from options
		 */
		private function createUpdateSliderFromOptions($options,$sliderID = null){
			
			$arrMain = UniteFunctionsBiz::getVal($options, "main");
			$params = UniteFunctionsBiz::getVal($options, "params");
			
			//trim all input data
			$arrMain = UniteFunctionsBiz::trimArrayItems($arrMain);
			$params = UniteFunctionsBiz::trimArrayItems($params);
			
			$params = array_merge($arrMain,$params);
			
			$title = UniteFunctionsBiz::getVal($arrMain, "title");
			$alias = UniteFunctionsBiz::getVal($arrMain, "alias");
			
			if(!empty($sliderID))
				$this->initByID($sliderID);
				
			$this->validateInputSettings($title, $alias, $params);
			
			$jsonParams = json_encode($params);
			
			//insert slider to database
			$arrData = array();
			$arrData["title"] = $title;
			$arrData["alias"] = $alias;
			$arrData["params"] = $jsonParams;
			
			if(empty($sliderID)){	//create slider	
				$sliderID = $this->db->insert(GlobalsShowBiz::$table_sliders,$arrData);
				return($sliderID);
				
			}else{	//update slider
				$this->initByID($sliderID);
				
				$sliderID = $this->db->update(GlobalsShowBiz::$table_sliders,$arrData,array("id"=>$sliderID));				
			}
		}
		
		
		/**
		 * 
		 * delete slider from datatase
		 */
		private function deleteSlider(){			
			
			$this->validateInited();
			
			//delete slider
			$this->db->delete(GlobalsShowBiz::$table_sliders,"id=".$this->id);
			
			//delete slides
			$this->deleteAllSlides();
		}

		/**
		 * 
		 * delete all slides
		 */
		private function deleteAllSlides(){
			$this->validateInited();
			
			$this->db->delete(GlobalsShowBiz::$table_slides,"slider_id=".$this->id);			
		}
		
		
		/**
		 * 
		 * duplicate slider in datatase
		 */
		private function duplicateSlider(){			
			
			$this->validateInited();
			
			//get slider number:
			$response = $this->db->fetch(GlobalsShowBiz::$table_sliders);
			$numSliders = count($response);
			$newSliderSerial = $numSliders+1;
			
			$newSliderTitle = "Slider".$newSliderSerial;
			$newSliderAlias = "slider".$newSliderSerial;
			
			//insert a new slider
			$sqlSelect = "select ".GlobalsShowBiz::FIELDS_SLIDER." from ".GlobalsShowBiz::$table_sliders." where id={$this->id}";
			$sqlInsert = "insert into ".GlobalsShowBiz::$table_sliders." (".GlobalsShowBiz::FIELDS_SLIDER.") ($sqlSelect)";
						
			$this->db->runSql($sqlInsert);
			$lastID = $this->db->getLastInsertID();
			UniteFunctionsBiz::validateNotEmpty($lastID);
			
			//update the new slider with the title and the alias values
			$arrUpdate = array();
			$arrUpdate["title"] = $newSliderTitle;
			$arrUpdate["alias"] = $newSliderAlias;
			$this->db->update(GlobalsShowBiz::$table_sliders, $arrUpdate, array("id"=>$lastID));
			
			//duplicate slides
			$fields_slide = GlobalsShowBiz::FIELDS_SLIDE;
			$fields_slide = str_replace("slider_id", $lastID, $fields_slide);
			
			$sqlSelect = "select ".$fields_slide." from ".GlobalsShowBiz::$table_slides." where slider_id={$this->id}";
			$sqlInsert = "insert into ".GlobalsShowBiz::$table_slides." (".GlobalsShowBiz::FIELDS_SLIDE.") ($sqlSelect)";
			
			$this->db->runSql($sqlInsert);
		}
		
		
		
		/**
		 * 
		 * duplicate slide
		 */
		private function duplicateSlide($slideID){
			$slide = new BizSlide();
			$slide->initByID($slideID);
			$order = $slide->getOrder();
			$slides = $this->getSlides();
			$newOrder = $order+1;
			$this->shiftOrder($newOrder);
			
			//do duplication
			$sqlSelect = "select ".GlobalsShowBiz::FIELDS_SLIDE." from ".GlobalsShowBiz::$table_slides." where id={$slideID}";
			$sqlInsert = "insert into ".GlobalsShowBiz::$table_slides." (".GlobalsShowBiz::FIELDS_SLIDE.") ($sqlSelect)";
			
			$this->db->runSql($sqlInsert);
			$lastID = $this->db->getLastInsertID();
			UniteFunctionsBiz::validateNotEmpty($lastID);
			
			//update order
			$arrUpdate = array("slide_order"=>$newOrder);
			
			$this->db->update(GlobalsShowBiz::$table_slides,$arrUpdate, array("id"=>$lastID));
		}
		
		
		/**
		 * 
		 * shift order of the slides from specific order
		 */
		private function shiftOrder($fromOrder){
			
			$where = " slider_id={$this->id} and slide_order >= $fromOrder";
			$sql = "update ".GlobalsShowBiz::$table_slides." set slide_order=(slide_order+1) where $where";
			$this->db->runSql($sql);
			
		}
		
		
		/**
		 * 
		 * create slider in database from options
		 */
		public function createSliderFromOptions($options){
			$sliderID = $this->createUpdateSliderFromOptions($options);
			return($sliderID);			
		}
		
		
		/**
		 * 
		 * export slider from data, output a file for download
		 */
		public function exportSlider(){
			$this->validateInited();
			
			$sliderParams = $this->getParamsForExport();
			$arrSlides = $this->getSlidesForExport();
			
			$arrSliderExport = array("params"=>$sliderParams,"slides"=>$arrSlides);
			
			$strExport = serialize($arrSliderExport);
			
			if(!empty($this->alias))
				$filename = $this->alias.".txt";
			else
				$filename = "slider_export.txt";
			
			UniteFunctionsBiz::downloadFile($strExport,$filename);
		}
		
		
		/**
		 * 
		 * import slider from multipart form
		 */
		public function importSliderFromPost(){
			
			try{
			
					$sliderID = UniteFunctionsBiz::getPostVariable("sliderid");
					$this->initByID($sliderID);
					$filepath = $_FILES["import_file"]["tmp_name"];
					
					if(file_exists($filepath) == false)
						UniteFunctionsBiz::throwError("Import file not found!!!");
						
					//get content array
					$content = @file_get_contents($filepath);			
					$arrSlider = @unserialize($content);
					if(empty($arrSlider))
						 UniteFunctionsBiz::throwError("Wrong export slider file format!");
					
					//update slider params
					
					$sliderParams = $arrSlider["params"];
					$sliderParams["title"] = $this->arrParams["title"];
					$sliderParams["alias"] = $this->arrParams["alias"];
					$sliderParams["shortcode"] = $this->arrParams["shortcode"];
					
					if(isset($sliderParams["background_image"]))
						$sliderParams["background_image"] = UniteFunctionsWPBiz::getImageUrlFromPath($sliderParams["background_image"]);
					
					$json_params = json_encode($sliderParams);
					$arrUpdate = array("params"=>$json_params);
					$this->db->update(GlobalsShowBiz::$table_sliders,$arrUpdate,array("id"=>$sliderID));
					
					//-------- Slides Handle -----------
					
					//delete current slides
					$this->deleteAllSlides();
					
					//create all slides
					$arrSlides = $arrSlider["slides"];
					foreach($arrSlides as $slide){
						
						$params = $slide["params"];
						
						//convert params images:
						if(isset($params["image"]))
							$params["image"] = UniteFunctionsWPBiz::getImageUrlFromPath($params["image"]);
						
						//create new slide
						$arrCreate = array();
						$arrCreate["slider_id"] = $sliderID;
						$arrCreate["slide_order"] = $slide["slide_order"];				
						$arrCreate["params"] = json_encode($params);
						
						$this->db->insert(GlobalsShowBiz::$table_slides,$arrCreate);									
					}

			}catch(Exception $e){
				$errorMessage = $e->getMessage();
				return(array("success"=>false,"error"=>$errorMessage,"sliderID"=>$sliderID));
			}
			
			return(array("success"=>true,"sliderID"=>$sliderID));
		}
		
		
		/**
		 * 
		 * update slider from options
		 */
		public function updateSliderFromOptions($options){
			
			$sliderID = UniteFunctionsBiz::getVal($options, "sliderid");
			UniteFunctionsBiz::validateNotEmpty($sliderID,"Slider ID");
			
			$this->createUpdateSliderFromOptions($options,$sliderID);
		}
		
		
		/**
		 * 
		 * delete slider from input data
		 */
		public function deleteSliderFromData($data){
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderid");
			UniteFunctionsBiz::validateNotEmpty($sliderID,"Slider ID");
			$this->initByID($sliderID);
			$this->deleteSlider();
		}

		
		/**
		 * 
		 * delete slider from input data
		 */
		public function duplicateSliderFromData($data){
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderid");
			UniteFunctionsBiz::validateNotEmpty($sliderID,"Slider ID");
			$this->initByID($sliderID);
			$this->duplicateSlider();
		}
		
		
		/**
		 * 
		 * duplicate slide from input data
		 */
		public function duplicateSlideFromData($data){
			
			//init the slider
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderID");
			UniteFunctionsBiz::validateNotEmpty($sliderID,"Slider ID");
			$this->initByID($sliderID);
			
			//get the slide id
			$slideID = UniteFunctionsBiz::getVal($data, "slideID");
			UniteFunctionsBiz::validateNotEmpty($slideID,"Slide ID");
			$this->duplicateSlide($slideID);
			
			return($sliderID);
		}
		
		
		/**
		 * 
		 * create a slide from input data
		 */
		public function createSlideFromData($data){
			
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderid");
			
			UniteFunctionsBiz::validateNotEmpty($sliderID,"Slider ID");
			$this->initByID($sliderID);
			
			$slide = new BizSlide();
			$slideID = $slide->createSlide($sliderID);
			return($slideID);
		}
		
		/**
		 * 
		 * update slides order from data
		 */
		public function updateSlidesOrderFromData($data){
			
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderID");
			$arrIDs = UniteFunctionsBiz::getVal($data, "arrIDs");
			UniteFunctionsBiz::validateNotEmpty($arrIDs,"slides");
			
			$this->initByID($sliderID);
			
			$isFromPosts = $this->isSourceFromPosts();
			
			foreach($arrIDs as $index=>$slideID){
				$order = $index+1;
				
				if($isFromPosts){	//from posts
					
					UniteFunctionsWPBiz::updatePostOrder($slideID, $order);
					
				}else{	//from gallery
					$arrUpdate = array("slide_order"=>$order);
					$where = array("id"=>$slideID);
					$this->db->update(GlobalsShowBiz::$table_slides,$arrUpdate,$where);
				}				
			}
			
			//update sortby
			$arrUpdate = array();
			$arrUpdate["post_sortby"] = UniteFunctionsWPBiz::SORTBY_MENU_ORDER;
			$this->updateParam($arrUpdate); 
		}
		
		
		/**
		 * 
		 * get the "main" and "settings" arrays, for dealing with the settings.
		 */
		public function getSettingsFields(){
			$this->validateInited();
			
			$arrMain = array();
			$arrMain["title"] = $this->title;
			$arrMain["alias"] = $this->alias;
			
			$arrRespose = array("main"=>$arrMain,
								"params"=>$this->arrParams);
			
			return($arrRespose);
		}
		
		/**
		 * 
		 * get the slides from gallery
		 */
		private function getSlidesFromGallery($publishedOnly = false){
			
			$arrSlides = array();
			$arrSlideRecords = $this->db->fetch(GlobalsShowBiz::$table_slides,"slider_id=".$this->id,"slide_order");
			
			foreach ($arrSlideRecords as $record){
				$slide = new BizSlide();
				$slide->initByData($record);
				
				if($publishedOnly == true){
					$state = $slide->getParam("state","published");
					if($state == "unpublished")
						continue;
				}
				
				$arrSlides[] = $slide;
			}
			
			//check if slides should be randomized
			if($this->getParam("img_random_order","off") == 'on'){
				shuffle($arrSlides);
			}
			
			return($arrSlides);
		}
		
		
		/**
		 * 
		 * get demo slides for slider demo
		 */
		private function getDemoSlides(){

			$arrSlides = array();
			
			for($i=0;$i<7;$i++){
				$demoType = $i%3 + 1;
				
				$slide = new BizSlide();
				$slide->initDemoData($demoType);
				$arrSlides[] = $slide;
			}
			
			return($arrSlides);
		}
		
		
		/**
		 * 
		 * update some params in the slider
		 */
		public function updateParam($arrUpdate){
			$this->validateInited();
			
			$this->arrParams = array_merge($this->arrParams,$arrUpdate);
			$jsonParams = json_encode($this->arrParams);
			$arrUpdateDB = array();
			$arrUpdateDB["params"] = $jsonParams;
			
			$sliderID = $this->db->update(GlobalsShowBiz::$table_sliders,$arrUpdateDB,array("id"=>$this->id));
		}
		
		/**
		 * 
		 * get cats and taxanomies data from the input
		 */
		private function getCatAndTaxData($catIDs){
			
			if(is_string($catIDs)){
				$catIDs = trim($catIDs);
				if(empty($catIDs))
					return(array("tax"=>"","cats"=>""));
				
				$catIDs = explode(",", $catIDs);
			}
			
			
			$strCats = "";
			$arrTax = array();
			foreach($catIDs as $cat){
				if(strpos($cat,"option_disabled") === 0)
					continue;
				
				$pos = strrpos($cat,"_");
				if($pos === false)
					UniteFunctionsBiz::throwError("The category is in wrong format");
				
				$taxName = substr($cat,0,$pos);
				$catID = substr($cat,$pos+1,strlen($cat)-$pos-1);
				
				//translate catID to current language if wpml exists
				$catID = UniteWpmlBiz::changeCatIdByLang($catID, $taxName);
			
				$arrTax[$taxName] = $taxName;
				if(!empty($strCats))
					$strCats .= ",";
					
				$strCats .= $catID;				
			}
			
			$strTax = "";
			foreach($arrTax as $taxName){
				if(!empty($strTax))
					$strTax .= ",";
					
				$strTax .= $taxName;
			} 
			
			$output = array("tax"=>$strTax,"cats"=>$strCats);
			
			return($output);
		}
		
		/**
		 * 
		 * get post category value. Can be multiple
		 */
		public function getPostCategory(){
			$catIDs = $this->getParam("post_category");
			$data = $this->getCatAndTaxData($catIDs);
			$catIDs = $data["cats"];
			
			return($catIDs);
		}
		
		/**
		 * 
		 * get posts from categories (by the slider params).
		 */
		private function getPostsFromCategoies(){
			$catIDs = $this->getParam("post_category");
			$data = $this->getCatAndTaxData($catIDs);
			
			$taxonomies = $data["tax"];
			$catIDs = $data["cats"];
			
			$sortBy = $this->getParam("post_sortby",self::DEFAULT_POST_SORTBY);
			$sortDir = $this->getParam("posts_sort_direction",self::DEFAULT_POST_SORTDIR);
			$maxPosts = $this->getParam("max_slider_posts","30");
			if(empty($maxPosts) || !is_numeric($maxPosts))
				$maxPosts = -1;
			
			$postTypes = $this->getParam("post_types","any");
				
			//set direction for custom order
			if($sortBy == UniteFunctionsWPBiz::SORTBY_MENU_ORDER)
				$sortDir = UniteFunctionsWPBiz::ORDER_DIRECTION_ASC;
			
			$arrPosts = UniteFunctionsWPBiz::getPostsByCategory($catIDs,$sortBy,$sortDir,$maxPosts,$postTypes,$taxonomies);
			
			return($arrPosts);
		}  

		/**
		 * 
		 * get posts from categories (by the slider params).
		 */
		private function getPostsFromWCCategories(){
						
			$catIDs = $this->getParam("wc_post_category",0);
						
			$data = $this->getCatAndTaxData($catIDs);
			
			$taxonomies = $data["tax"];
			$catIDs = $data["cats"];
			
			//dmp($catIDs);exit();
			
			$sortBy = $this->getParam("wc_post_sortby",self::DEFAULT_POST_SORTBY);
			$sortDir = $this->getParam("wc_posts_sort_direction",self::DEFAULT_POST_SORTDIR);
			$maxPosts = $this->getParam("wc_max_slider_posts","30");
			
			if(empty($maxPosts) || !is_numeric($maxPosts))
				$maxPosts = -1;
			
			$postTypes = $this->getParam("wc_post_types","any");
			
			//set direction for custom order
			if($sortBy == UniteFunctionsWPBiz::SORTBY_MENU_ORDER)
				$sortDir = UniteFunctionsWPBiz::ORDER_DIRECTION_ASC;
			
			//get meta filters
			
			$args = array();				
			$args[UniteFunctionsWooCommerceBiz::ARG_REGULAR_PRICE_FROM] = $this->getParam("wc_regular_price_from");
			$args[UniteFunctionsWooCommerceBiz::ARG_REGULAR_PRICE_TO] = $this->getParam("wc_regular_price_to");
			$args[UniteFunctionsWooCommerceBiz::ARG_SALE_PRICE_FROM] = $this->getParam("wc_sale_price_from");
			$args[UniteFunctionsWooCommerceBiz::ARG_SALE_PRICE_TO] = $this->getParam("wc_sale_price_to");
			$args[UniteFunctionsWooCommerceBiz::ARG_IN_STOCK_ONLY] = $this->getParam("wc_instock_only","false");
			$args[UniteFunctionsWooCommerceBiz::ARG_FEATURED_ONLY] = $this->getParam("wc_featured_only","false");
			
			$metaQuery = UniteFunctionsWooCommerceBiz::getMetaQuery($args);
			
			$arrPosts = UniteFunctionsWPBiz::getPostsByCategory($catIDs,$sortBy,$sortDir,$maxPosts,$postTypes,$taxonomies,$metaQuery);
			
			return($arrPosts);
		}  
		
		
		/**
		 * 
		 * get posts from specific posts list
		 */
		private function getPostsFromSpecificList(){
			
			$strPosts = $this->getParam("posts_list","");
			
			$arrPosts = UniteFunctionsWPBiz::getPostsByIDs($strPosts);
			
			return($arrPosts);
		}
		
		
		/**
		 * 
		 * get the slides from posts
		 */
		private function getSlidesFromPosts(){
			
			$sourceType = $this->getParam("source_type","posts");
			
			$imgSourceType = $this->getParam("img_source_type","full");
			
			if($imgSourceType == 'custom'){
				$img_size_height = $this->getParam("img_source_type_height",0,ShowBizSlider::VALIDATE_NUMERIC);
				$img_size_width = $this->getParam("img_source_type_width",0,ShowBizSlider::VALIDATE_NUMERIC);
				if($img_size_height > 0 && $img_size_width > 0){
					$imgSourceType = array($img_size_width,$img_size_height);
				}else{
					$imgSourceType = 'full';
				}
			}
			
			$ratio = $this->getParam("img_ratio",'none');
			$refresh = $this->getParam("refresh_images",'posts');
			
			
			switch($sourceType){
				case "posts":
					$arrPosts = $this->getPostsFromCategoies();
				break;
				case "woocommerce":
					$arrPosts = $this->getPostsFromWCCategories();
				break;
				default:		//specific
					$arrPosts = $this->getPostsFromSpecificList();
				break; 
			}
			
			
			$arrSlides = array();
			foreach($arrPosts as $postData){
				$slide = new BizSlide();
				$slide->initByPostData($postData, $this->id, $imgSourceType, $ratio, $refresh);				
				$arrSlides[] = $slide;
			}
			
			return($arrSlides);
		}
		
		
		/**
		 * 
		 * check if the source of the slider are from posts
		 */
		public function isSourceFromPosts(){
			$this->validateInited();
			$sourceType = $this->getParam("source_type","posts");
			
			switch($sourceType){
				case "posts":
				case "specific_posts":
				case "woocommerce":
					return(true);
				break;
			}
			
			return(false);
		}
		
		
		/**
		 * 
		 * get slides of the current slider
		 */
		public function getSlides($publishedOnly = false){
			
			//get demo mode slides
			if($this->demoMode == true){
				$this->arrSlides = $this->getDemoSlides();
				return($this->arrSlides);
			}
						
			if($this->isSourceFromPosts())
				$arrSlides = $this->getSlidesFromPosts();
			else
				$arrSlides = $this->getSlidesFromGallery($publishedOnly);
				
			$this->arrSlides = $arrSlides;
			
			return($arrSlides);
		}
		
		
		/**
		 * 
		 * get array of slide names
		 */
		public function getArrSlideNames(){
			if(empty($this->arrSlides))
				$this->getSlides();
			
			$arrSlideNames = array();
			
			foreach($this->arrSlides as $number=>$slide){
				$slideID = $slide->getID();
				$filename = $slide->getImageFilename();
				$arrSlideNames[$slideID] = "Slide ".($number+1)." ($filename)";				
			}
			return($arrSlideNames);
		}
		
		
		/**
		 * 
		 * get array of slides numbers by id's
		 */
		public function getSlidesNumbersByIDs($publishedOnly = false){
			
			if(empty($this->arrSlides))
				$this->getSlides($publishedOnly);
			
			$arrSlideNumbers = array();
			
			foreach($this->arrSlides as $number=>$slide){
				$slideID = $slide->getID();
				$arrSlideNumbers[$slideID] = ($number+1);				
			}
			return($arrSlideNumbers);
		}
		
		
		/**
		 * 
		 * get slider params for export slider
		 */
		private function getParamsForExport(){
			$exportParams = $this->arrParams;
			unset($exportParams["title"]);
			unset($exportParams["alias"]);
			unset($exportParams["shortcode"]);
			
			//modify background image
			$urlImage = UniteFunctionsBiz::getVal($exportParams, "background_image");
			if(!empty($urlImage))
				$exportParams["background_image"] = $urlImage;
			
			return($exportParams);
		}

		
		/**
		 * 
		 * get slides for export
		 */
		private function getSlidesForExport(){
			$arrSlides = $this->getSlides();
			$arrSlidesExport = array();
			foreach($arrSlides as $slide){
				$slideNew = array();
				$slideNew["params"] = $slide->getParamsForExport();
				$slideNew["slide_order"] = $slide->getOrder();
				$arrSlidesExport[] = $slideNew;
			}
			
			return($arrSlidesExport);
		}
		
		
		/**
		 * 
		 * get slides number
		 */
		public function getNumSlides($publishedOnly = false){
			if($this->arrSlides == null)
				$this->getSlides($publishedOnly);
			
			$numSlides = count($this->arrSlides);
			return($numSlides);
		}
		
		
		/**
		 * 
		 * get sliders array - function don't belong to the object!
		 */
		public function getArrSliders(){
			$where = "";
			
			$response = $this->db->fetch(GlobalsShowBiz::$table_sliders,$where,"id");
			
			$arrSliders = array();
			foreach($response as $arrData){
				$slider = new ShowBizSlider();
				$slider->initByDBData($arrData);
				$arrSliders[] = $slider;
			}
			
			return($arrSliders);
		}

		
		/**
		 * 
		 * get aliasees array
		 */
		public function getAllSliderAliases(){
			$where = "";
			
			$response = $this->db->fetch(GlobalsShowBiz::$table_sliders,$where,"id");
			
			$arrAliases = array();
			foreach($response as $arrSlider){
				$arrAliases[] = $arrSlider["alias"];
			}
			
			return($arrAliases);
		}		
		
		
		/**
		 * 
		 * get array of slider id -> title
		 */		
		public function getArrSlidersShort(){
			$arrSliders = $this->getArrSliders();
			$arrShort = array();
			foreach($arrSliders as $slider){
				$id = $slider->getID();
				$title = $slider->getTitle();
				$arrShort[$id] = $title;
			}
			return($arrShort);
		}
		
		/**
		 * 
		 * get max order
		 */
		public function getMaxOrder(){
			$this->validateInited();
			$maxOrder = 0;
			$arrSlideRecords = $this->db->fetch(GlobalsShowBiz::$table_slides,"slider_id=".$this->id,"slide_order desc","","limit 1");
			if(empty($arrSlideRecords))
				return($maxOrder);
			$maxOrder = $arrSlideRecords[0]["slide_order"];
			
			return($maxOrder);
		}
		
		/**
		 * update sortby option
		 */
		public function updatePostsSortbyFromData($data){
			
			$sliderID = UniteFunctionsBiz::getVal($data, "sliderID");
			$sortBy = UniteFunctionsBiz::getVal($data, "sortby");
			UniteFunctionsBiz::validateNotEmpty($sortBy,"sortby");
			
			$this->initByID($sliderID);
			$arrUpdate = array();
			$arrUpdate["post_sortby"] = $sortBy;
			
			$this->updateParam($arrUpdate); 
		}
		
		
	}

?>