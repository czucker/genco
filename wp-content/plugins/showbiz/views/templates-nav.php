<?php
	$templates = new ShowBizTemplate();
	
	$titleText = "ShowBiz Navigation Skin Editor";
	
	$templatesType = GlobalsShowBiz::TEMPLATE_TYPE_BUTTON;
	
	//new item prefix
	$templatesPrefix = "Navigation Template";
	
	$arrTemplates = $templates->getList($templatesType);
	
	//set buttons array
	$prefix = "showbiz_";
	$arrButtons = array();
	$arrButtons[$prefix."left_button_id"] = "Left Button ID";
	$arrButtons[$prefix."right_button_id"] = "Right Button ID";
	$arrButtons[$prefix."play_button_id"] = "Play Button ID";
	
	$arrOriginalTemplates = BizOperations::getArrInitNavigationTemplates(true);
	
	$linkShowAll = self::getPageUrl(ShowBizAdmin::VIEW_TEMPLATES_NAV);
	
	$filterID = UniteFunctionsBiz::getGetVar("id");
	
	$showCustomOptions = false;
	$showClasses = false;
	
	$standartOptionsName = "Navigation Options";
	
	$linkHelp = GlobalsShowBiz::LINK_HELP_TEMPLATES_NAVS;
	
	require self::getPathTemplate("templates");
?>


	