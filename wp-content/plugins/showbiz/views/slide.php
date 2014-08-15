<?php

	//get input
	$slideID = UniteFunctionsBiz::getGetVar("id");
			
	//init slide object
	$slide = new BizSlide();
	$slide->initByID($slideID);
	$slideParams = $slide->getParams();
	
	$operations = new BizOperations();
	
	//init slider object
	$sliderID = $slide->getSliderID();
	$slider = new ShowBizSlider();
	$slider->initByID($sliderID);
	$sliderParams = $slider->getParams();
	
	require self::getSettingsFilePath("slide_settings");	
	
	$settingsSlideOutput = new UniteSettingsBizProductBiz();
		
	$settingsSlide = self::getSettings("slide_settings");
	
	//set stored values from "slide params"
	$settingsSlide->setStoredValues($slideParams);
		
	$settingsSlideOutput->init($settingsSlide);
	
	//set various parameters needed for the page
	$imageUrl = $slide->getImageUrl();
	
	$slideTitle = $slide->getParam("title","Slide");
	$slideOrder = $slide->getOrder();
	
	$closeUrl = self::getViewUrl(ShowBizAdmin::VIEW_SLIDES,"id={$sliderID}");
	
	require self::getPathTemplate("slide");
?>
	
