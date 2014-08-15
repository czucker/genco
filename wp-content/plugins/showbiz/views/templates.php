<?php
	$operations = new BizOperations();
	$templates = new ShowBizTemplate();
	
	$titleText = "ShowBiz Skin Editor";
	
	//new item prefix
	$templatesPrefix = "Item Template";
	
	$templatesType = GlobalsShowBiz::TEMPLATE_TYPE_ITEM;
	
	$arrTemplates = $templates->getList($templatesType);

	$arrButtons = $operations->getArrEditorButtons();
	
	//set buttons array
	
	//$arrButtons["break"] = "";

	$arrOriginalTemplates = BizOperations::getArrInitItemTemplates(true);
	
	//merge with wildcards
	$objWildcards = new ShowBizWildcards();
	
	$arrWildcards = $objWildcards->getWildcardsSettingNames();
	
	$linkShowAll = self::getPageUrl(ShowBizAdmin::VIEW_TEMPLATES);

	$filterID = UniteFunctionsBiz::getGetVar("id");
	
	$showCustomOptions = true;
	
	$arrCustomOptions = $objWildcards->getArrCustomOptions();
	
	$showClasses = true;
	
	$arrClasses = $operations->getArrEditorClasses();
	
	$standartOptionsName = "Post Options";
	
	$linkHelp = GlobalsShowBiz::LINK_HELP_TEMPLATES_ITEMS;
	
	require self::getPathTemplate("templates");
?>


	