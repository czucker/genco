<?php
	
	//set Slide settings
	$arrSlideNames = $slider->getArrSlideNames();
	
	$slideSettings = new UniteSettingsAdvancedBiz();

	//title
	$params = array("description"=>"The title of the slide, will be shown in the slides list.","class"=>"medium");
	$slideSettings->addTextBox("title","Slide","Slide Title", $params);

	//state
	$params = array("description"=>"The state of the slide. The unpublished slide will be excluded from the slider.");
	$slideSettings->addSelect("state",array("published"=>"Published","unpublished"=>"Unpublished"),"State","published",$params);
	
	//-----------------------
	//select item template
	
	$templates = new ShowBizTemplate();
	$arrTemplates = $templates->getArrShortAssoc(GlobalsShowBiz::TEMPLATE_TYPE_ITEM,true);
	$params = array("description"=>"The template that set the look of the item (if not selected it will be taken from the slider global template)");
	$slideSettings->addSelect("template_id", $arrTemplates, "Item Template", "", $params);
	
	$slideSettings->addHr();
	
	//-----------------------
	
	//enable link
	$slideSettings->addSelect_boolean("enable_link", "Enable Link", false, "Enable","Disable");
	
	$slideSettings->startBulkControl("enable_link", UniteSettingsBiz::CONTROL_TYPE_SHOW, "true");
		
		//link	
		$params = array("description"=>"A link on the whole slide pic");
		$slideSettings->addTextBox("link","","Slide Link", $params);
		
		$slideSettings->addHr();
		
	$slideSettings->endBulkControl();
	
	$params = array("description"=>"","width"=>300,"height"=>200);
	$slideSettings->addImage("slide_image", "","Slide Image" , $params);

	//editor
	$params = array("description"=>"");
	$slideSettings->addEditor("slide_text", "", "Slide Text", $params);
	
	$params = array("description"=>"Overwrite the global excerpt words limit option for this slide","class"=>"small");
	$slideSettings->addTextBox("showbiz_excerpt_limit", "", "Excerpt Words Limit",$params);
	
	$slideSettings->addHr();
	
	$params = array("description"=>"The youtube ID, example: 9bZkp7q19f0","class"=>"medium");
	$slideSettings->addTextBox("youtube_id", "", "Youtube ID", $params);
	$params = array("description"=>"The youtube ID, example: 18554749","class"=>"medium");				
	$slideSettings->addTextBox("vimeo_id", "", "Vimeo ID",$params);
	
	$slideSettings->addHr();
	
	//add the wildcards
	$slideSettings->addStaticText("Those custom options can be used for variety of purposes in the templates section.");
	
	$objWildcards = new ShowBizWildcards();
	$settingsWildcards = $objWildcards->getWildcardsSettings(true);
	
	$slideSettings->addFromSettingsObject($settingsWildcards);
	
	//store settings
	self::storeSettings("slide_settings",$slideSettings);

?>
