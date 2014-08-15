<?php

	class ShowBizWildcards extends UniteElementsBaseBiz{

		private $objParams;
		const PLACEHOLDER_PREFIX = "showbiz_";
		
		
		/**
		 * 
		 * the constructor
		 */
		public function __construct(){
			parent::__construct();
			$this->objParams = new ShowbizParams();
		}
		
		
		/**
		 * 
		 * update custom options in db
		 */
		private function updateCustomOptionsInDB($arrOptions){
			
			$text = serialize($arrOptions);
			
			$this->objParams->updateFieldInDB("wildcards",$text);
		}
		
		
		/**
		 * 
		 * add custom option to db
		 * @param $title
		 * @param $name
		 */
		public function addCustomOption($title,$name){
			
			UniteFunctionsBiz::validateNotEmpty($title,"Title");
			UniteFunctionsBiz::validateNotEmpty($name,"Name");
			
			$arrOptions = $this->getArrCustomOptions();
			$arrOptions[] = array("title"=>$title,"name"=>$name);
			
			$this->updateCustomOptionsInDB($arrOptions);
		}

		
		/**
		 * 
		 * remove custom option
		 */
		private function removeCustomOption($name){
			
			$arrOptions = $this->getArrCustomOptions();
			$arrOptionsNew = array();
			foreach($arrOptions as $option){
				if($option["name"] != $name)
					$arrOptionsNew[] = $option;
			}
			
			$this->updateCustomOptionsInDB($arrOptionsNew);
		}
		
		
		/**
		 * 
		 * get custom options array
		 */
		public function getArrCustomOptions(){
			
			$wildcards = $this->objParams->getFieldFromDB("wildcards");
						
			$wildcards = unserialize($wildcards);
			
			if(empty($wildcards))
				$wildcards = array();
				
			return($wildcards);
		}
		
		
		/**
		 * 
		 * add custom wildcard
		 */
		public function addFromData($data){
			
			$title = UniteFunctionsBiz::getVal($data, "title");
			$name = UniteFunctionsBiz::getVal($data, "name");
			
			$this->addCustomOption($title,$name);
			
			$response = $data;
			$response["placeholder"] = self::PLACEHOLDER_PREFIX.$name;
			
			return($response);
		}
		
	
		
		/**
		 * 
		 * remove the custom wildcard from data
		 */
		public function removeFromData($data){
			
			$name = UniteFunctionsBiz::getVal($data, "name");
			UniteFunctionsBiz::validateNotEmpty($name);
			$this->removeCustomOption($name);
			
			$response = $data;
			return($response);
		}
		
		
		/**
		 *
		 * get wildcards settings object
		 * $isInsidePost it means that it's used inside the post and not template page.
		 */
		public function getWildcardsSettings($isInsidePost = false){

			$settings = new UniteSettingsAdvancedBiz();

			//add youtube, excerpt and vimeo id
			if($isInsidePost == true){
				$templates = new ShowBizTemplate();
				$arrTemplates = $templates->getArrShortAssoc(GlobalsShowBiz::TEMPLATE_TYPE_ITEM,true);
				$settings->addSelect("template_id", $arrTemplates, "Item Template", "");

				$params = array("class"=>"textbox_small","description"=>"Overwrite the global excerpt words limit option for this post");
				$settings->addTextBox("showbiz_excerpt_limit", "", "Excerpt Words Limit",$params);
				$params = array("description"=>"The youtube ID, example: 9bZkp7q19f0");
				$settings->addTextBox("youtube_id", "", "Youtube ID", $params);
				$params = array("description"=>"The youtube ID, example: 18554749");
				$settings->addTextBox("vimeo_id", "", "Vimeo ID",$params);
			}
			
			//get custom settings:
			$arrCustomOptions = $this->getArrCustomOptions();
			
			if(!empty($arrCustomOptions)){
				$params = array(
					 "custom_type"=>"user",
					 "text_class"=>"text_short",
					 "description"=>"Custom option. Can be used in variaty of needs in the template"
				);
				
				foreach($arrCustomOptions as $option){
					$title = $option["title"];
					$name = self::PLACEHOLDER_PREFIX.$option["name"];					
					$settings->addTextBox($name, "", $title, $params);
				}
			}
			
			return($settings);
		}

		
		/**
		 *
		 * get names and titles of the wildcards
		 */
		public function getWildcardsSettingNames(){
			$settings = $this->getWildcardsSettings();
			$arrNames = $settings->getArrSettingNamesAndTitles();
			return($arrNames);
		}
		
		
		
	}

?>