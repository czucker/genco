<?php

	//$tax = get_taxonomies();dmp($tax);exit();

	$settingsMain = self::getSettings("slider_main");
	$settingsParams = self::getSettings("slider_params");

	$settingsSliderMain = new ShowBizSettingsProduct();
	$settingsSliderParams = new UniteSettingsProductSidebarBiz();
	
	//check existing slider data:
	$sliderID = self::getGetVar("id");

	//get taxonomies with cats
	$postTypesWithCats = BizOperations::getPostTypesWithCatsForClient();
	$jsonTaxWithCats = UniteFunctionsBiz::jsonEncodeForClientSide($postTypesWithCats);
	
	$viewTemplates = self::getPageUrl(ShowBizAdmin::VIEW_TEMPLATES,"id=");
	$viewTemplatesNav = self::getPageUrl(ShowBizAdmin::VIEW_TEMPLATES_NAV,"id=");
	
	if(!empty($sliderID)){
		$slider = new ShowBizSlider();
		$slider->initByID($sliderID);
		
		//get setting fields
		$settingsFields = $slider->getSettingsFields();
		$arrFieldsMain = $settingsFields["main"];
		$arrFieldsParams = $settingsFields["params"];		

		//modify arrows type for backword compatability
		$arrowsType = UniteFunctionsBiz::getVal($arrFieldsParams, "navigation_arrows");
		switch($arrowsType){
			case "verticalcentered":
				$arrFieldsParams["navigation_arrows"] = "solo";
			break;
		}
		
		//set custom type params values:
		$settingsMain = ShowBizSettingsProduct::setSettingsCustomValues($settingsMain, $arrFieldsParams, $postTypesWithCats);
				
		//set setting values from the slider
		$settingsMain->setStoredValues($arrFieldsParams);
		
		$settingsParams->setStoredValues($arrFieldsParams);
		
		//update short code setting
		$shortcode = $slider->getShortcode();
		$settingsMain->updateSettingValue("shortcode",$shortcode);
		
		$linksEditSlides = self::getViewUrl(ShowBizAdmin::VIEW_SLIDES,"id=$sliderID");
		
		$settingsSliderParams->init($settingsParams);	
		$settingsSliderMain->init($settingsMain);
		
		$settingsSliderParams->isAccordion(true);
				
		require self::getPathTemplate("slider_edit");
	}
	
	else{
		$settingsMain = ShowBizSettingsProduct::setSettingsCustomValues($settingsMain, array(), $postTypesWithCats);
		
		$settingsSliderParams->init($settingsParams);	
		$settingsSliderMain->init($settingsMain);
		
		$settingsSliderParams->isAccordion(true);
		
		require self::getPathTemplate("slider_new");		
	}
		
?>
	