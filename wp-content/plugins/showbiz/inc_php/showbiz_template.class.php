<?php

	class ShowBizTemplate extends UniteElementsBaseBiz{
		
		private $titlePrefix = "Template";
		
		private $id;
		private $title;
		private $content;
		private $css;
		private $params;
		private $type;
		
		
		/**
		 * 
		 * constructor
		 */
		public function __construct(){
			parent::__construct();
		}

		/**
		 * 
		 * set the template prefix
		 */
		public function setTitlePrefix($newPrefix){
			$this->titlePrefix = $newPrefix;
		}
		
		
		/**
		 * 
		 * validate that category exists
		 */
		public function validateTemplateExist($templateID){
			$template = new ShowBizTemplate(); 
			$template->initById($templateID);
		}
		
		
		/**
		 * 
		 * validate that the template is inited. if not - throw error
		 */
		private function validateInited(){
			if(empty($this->id))
				UniteFunctionsBiz::throwError("The template is not inited!");
		}
		
		
		/**
		 * 
		 * init template by id
		 */
		public function initById($templateID){
			
			$arrData = $this->db->fetchSingle(GlobalsShowBiz::$table_templates,"id=$templateID");
			if(empty($arrData))
				UniteFunctionsMeg::throwError("Tempalte with id: $templateID not found");
			
			$this->initByData($arrData);
		}
		
		
		
		/**
		 * 
		 * init template by data
		 */
		public function initByData($arrData){
			$this->id = $arrData["id"];
			$this->title = $arrData["title"];
			$this->content = $arrData["content"];
			$this->css = $arrData["css"];
			$this->type = $arrData["type"];
			
			$params = $arrData["params"];
			$params = (array)json_decode($params);
			
			$this->params = $params;
		}
		
		
		
		/**
		 * 
		 * add empty template with default content data
		 */
		public function add($html = "",$title = null,$css = null, $type=null,$updateIfNameExists = false){
			
			UniteFunctionsBiz::validateNotEmpty($type,"Template Type");
			
			
			//set the title
			if(empty($title)){
				$counter = 1;			
				$title = $this->titlePrefix.$counter;
			}
			
			$arrTitles = $this->getArrTitlesAssoc();
			$titleExists = array_key_exists($title, $arrTitles);
									
			$arrInsert = array();
			$arrInsert["content"] = $html;
			$arrInsert["css"] = $css;
			
			if($updateIfNameExists == false || ($updateIfNameExists == true && $titleExists == false) ){	//add only
				
				$maxOrder = $this->getMaxOrder();
				
				//set new title
				if($titleExists == true){				
					do{
						$counter++;	
						$title = $this->titlePrefix.$counter;
						$titleExists = array_key_exists($title, $arrTitles);
					}while($titleExists == true);
				}
				
				$arrInsert["title"] = $title;				
				$arrInsert["ordering"] = $maxOrder+1;
				$arrInsert["type"] = $type;
				$arrInsert["params"] = "";
				
				$id = $this->db->insert(GlobalsShowBiz::$table_templates,$arrInsert);
				return($id);
			}else{	//update if that name exists
				$this->db->update(GlobalsShowBiz::$table_templates,$arrInsert,array("title"=>$title));
				$strResponse = "Updated \"{$title}\" template";
				return($strResponse);
			}
		}
		
		
		/**
		 * 
		 * remove the template
		 */
		public function remove(){
			$this->validateInited();
			$this->db->delete(GlobalsShowBiz::$table_templates,"id=".$this->id);
		}

		
		/**
		 * 
		 * duplicate the template
		 */
		public function duplicate(){
			$this->validateInited();
			
			$maxOrder = $this->getMaxOrder();
			
			$addText = " (copy)";			
			$newTitle = $this->title.$addText;
			
			//insert a new template
			$sqlSelect = "select ".GlobalsShowBiz::FIELDS_TEMPLATE." from ".GlobalsShowBiz::$table_templates." where id={$this->id}";
			$sqlInsert = "insert into ".GlobalsShowBiz::$table_templates." (".GlobalsShowBiz::FIELDS_TEMPLATE.") ($sqlSelect)";
			
			$this->db->runSql($sqlInsert);
			$lastID = $this->db->getLastInsertID();
			UniteFunctionsBiz::validateNotEmpty($lastID);
			
			//update the new title and the new order
			$arrUpdate = array();
			$arrUpdate["title"] = $newTitle;
			$arrUpdate["ordering"] = $maxOrder+1;
			$this->db->update(GlobalsShowBiz::$table_templates, $arrUpdate, array("id"=>$lastID));
		}
		
		
		/**
		 * 
		 * update the template with array of items
		 */
		private function update($arrUpdate){			
			$this->validateInited();
			
			//normalize content
			if(array_key_exists("content",$arrUpdate)){
				$content = UniteFunctionsBiz::getVal($arrUpdate, "content");
				$content = UniteFunctionsBiz::normalizeTextareaContent($content);
				$arrUpdate["content"] = $content;
			}

			//normalize css
			if(array_key_exists("css",$arrUpdate)){
				$css = UniteFunctionsBiz::getVal($arrUpdate, "css");
				$css = UniteFunctionsBiz::normalizeTextareaContent($css);
				$arrUpdate["css"] = $css;
			}
			
			$this->db->update(GlobalsShowBiz::$table_templates,$arrUpdate,array("id"=>$this->id));			
		}
		
		
		/**
		 * 
		 * update the title
		 */
		private function updateTitle($newTitle){
			
			$arrUpdate = array();
			$arrUpdate["title"] = $newTitle;
			$this->update($arrUpdate);
		}
		
		
		/**
		 * 
		 * update the content
		 */
		public function updateContent($newContent){
			$arrUpdate = array();
			$arrUpdate["content"] = $newContent;
			$this->update($arrUpdate);
		}

		/**
		 * 
		 * update the content
		 */
		public function updateCss($newCSS){
			$arrUpdate = array();
			$arrUpdate["css"] = $newCSS;
			$this->update($arrUpdate);
		}		
		
		/**
		 * 
		 * get assoc value of category name
		 */
		private function getArrTitlesAssoc($type=null){
			$arrTemplates = $this->getList($type);
			$arrAssoc = array();
			foreach($arrTemplates as $template){
				$title = $template->getTitle();
				$arrAssoc[$title] = true;
			}
			return($arrAssoc);
		}
		
		
		/**
		 * 
		 * get the title
		 */
		public function getTitle(){
			$this->validateInited();
			return($this->title);
		}
		
		
		/**
		 * 
		 * get template type
		 */
		public function getType(){
			$this->validateInited();
			return($this->type);
		}
		
		
		/**
		 * 
		 * get id
		 */
		public function getID(){
			$this->validateInited();
			return($this->id);
		}
		
		/**
		 * 
		 * get tempalte content
		 */
		public function getContent(){
			$this->validateInited();
			return($this->content);
		}
		
		/**
		 * 
		 * get tempalte content
		 */
		public function getCss(){
			$this->validateInited();
			return($this->css);
		}
		
		
		/**
		 * 
		 * get max order of the templates
		 */
		private function getMaxOrder(){
			
			$query = "select MAX(ordering) as maxorder from ".GlobalsShowBiz::$table_templates;
			
			///$query = "select * from ".self::TABLE_CATEGORIES;
			$rows = $this->db->fetchSql($query);
					
			$maxOrder = 0;
			if(count($rows)>0) $maxOrder = $rows[0]["maxorder"];
			
			if(!is_numeric($maxOrder))
				$maxOrder = 0;
			
			return($maxOrder);
		}

		/**
		 * 
		 * get raw templates list
		 */
		private function getListRaw($type = null){
			$where = "";
			if(!empty($type))
				$where = "type='$type'";
			
			$arrTemplates = $this->db->fetch(GlobalsShowBiz::$table_templates,$where,"ordering");
			
			return($arrTemplates);
		}
		
		/**
		 * 
		 * get tempaltes array
		 */
		public function getList($type = null){
			
			$arrTemplates = $this->getListRaw($type);
			
			foreach($arrTemplates as $key=>$templateData){
				$objTemplate = new ShowBizTemplate();
				$objTemplate->initByData($templateData);
				$arrTemplates[$key] = $objTemplate;
			}
				
			return($arrTemplates);
		}
		
		
		/**
		 * 
		 * get first template id
		 */
		public function getFirstTemplateID($type = null){
			$arrTemplates = $this->getList($type);
			
			$templateID = 0;
			
			if(!empty($arrTemplates)){
				$template = $arrTemplates[0];
				$templateID = $template->getID();
			}
			
			return($templateID);
		}
				
		
		/***
		 * get short array of templates (id -> title)
		 */
		public function getArrShortAssoc($type = null, $addNothing = false){	
			
			$arrTemplates = $this->getListRaw($type);
			
			$arrOutput = array();
			if($addNothing == true)
				$arrOutput[0] = "[Not Selected, use global]";
			
			foreach($arrTemplates as $template){
				$id = $template["id"];
				$title = $template["title"];
				
				$arrOutput[$id] = $title;
			}
			
			return($arrOutput);
		}
		
		
		/**
		 * 
		 * must be templateID in the data
		 */
		private function getTemplateFromData($data){
			$templateID = UniteFunctionsBiz::getVal($data, "templateID");
			UniteFunctionsBiz::validateNotEmpty($templateID,"tempalte id");
			$template = new ShowBizTemplate();
			$template->initById($templateID);
			
			return($template);
		}
		
		/**
		 * 
		 * delete template from data
		 */
		public function deleteFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$template->remove();
		}
		
		/**
		 * 
		 * duplicate template from data
		 */
		public function duplicateFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$template->duplicate();
			
		}
		
		
		/**
		 * 
		 * get content from data
		 */
		public function getContentFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$content = $template->getContent();
			
			return($content);
		}

		/**
		 * 
		 * get content from data
		 */
		public function updateTitleFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$newTitle = UniteFunctionsBiz::getVal($data, "title");
			$arrUpdate = array();
			$arrUpdate["title"] = $newTitle;
			
			$template->update($arrUpdate);
		}
				
		
		/**
		 * 
		 * get content from data
		 */
		public function getCssFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$css = $template->getCss();
			
			return($css);
		}
		
		
		/**
		 * 
		 * update the content from data
		 */
		public function updateContentFromData($data){
			$template = $this->getTemplateFromData($data);
			$newContent = UniteFunctionsBiz::getVal($data, "content");
			
			$template->updateContent($newContent);
		}
		
		/**
		 * 
		 * update the content from data
		 */
		public function updateCssFromData($data){
			
			$template = $this->getTemplateFromData($data);
			$newCss = UniteFunctionsBiz::getVal($data, "css");
			
			$template->updateCss($newCss);
		}
		
		
		/**
		 * 
		 * add template from data
		 */
		public function addFromData($data){
			
			$prefix = UniteFunctionsBiz::getVal($data, "prefix");
			if(!empty($prefix))
				$this->setTitlePrefix($prefix);
			
			$type = UniteFunctionsBiz::getVal($data, "type");
			$this->add("",null,"",$type);
			
		}

		/**
		 * 
		 * restore original template from data
		 */
		public function restoreOriginalFromData($data){
			$operations = new BizOperations();
			$template = $this->getTemplateFromData($data);
			$templateName = $data["original_name"];
			
			$arrTemplate = $operations->getTemplateByName($templateName,true);
			$html = $arrTemplate["html"];
			$css = $arrTemplate["css"];
			
			$template->updateContent($html);
			$template->updateCss($css);
		}
		
		
		
	}

?>