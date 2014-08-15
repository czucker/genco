<?php

	$generalSettings = new UniteSettingsBiz();
	
	$generalSettings->addRadio("includes_globally", 
							   array("on"=>__("On",SHOWBIZ_TEXTDOMAIN),"off"=>__("Off",SHOWBIZ_TEXTDOMAIN)),
							   __("Include Showbiz libraries globally",SHOWBIZ_TEXTDOMAIN),
							   "on",
							   array("description"=>"<br>".__("Add css and js includes only on all pages. Id turned to off they will added to pages where the showbiz shortcode exists only. This will work only when the slider added by a shortcode.",SHOWBIZ_TEXTDOMAIN)));
	
	$generalSettings->addRadio("includes_globally_facybox", 
							   array("on"=>__("On",SHOWBIZ_TEXTDOMAIN),"off"=>__("Off",SHOWBIZ_TEXTDOMAIN)),
							   __("Include Fancybox libraries",SHOWBIZ_TEXTDOMAIN),
							   "on",
							   array("description"=>"<br>".__("Add css and js includes from fanxybox. If off, fancybox will not work if your selected theme doe snot include fancybox",SHOWBIZ_TEXTDOMAIN)));
	
	$generalSettings->addRadio("includes_globally_facybox_be", 
							   array("on"=>__("On",SHOWBIZ_TEXTDOMAIN),"off"=>__("Off",SHOWBIZ_TEXTDOMAIN)),
							   __("Include Fancybox libraries in backend (for preview reasons)",SHOWBIZ_TEXTDOMAIN),
							   "on",
							   array("description"=>"<br>".__("Add css and js includes from fanxybox in backend. If off, fancybox will not work o preview mode",SHOWBIZ_TEXTDOMAIN)));
	
	
	$generalSettings->addTextBox("pages_for_includes", "",__("Pages to include ShowBiz libraries",SHOWBIZ_TEXTDOMAIN),
								  array("description"=>"<br>".__("Specify the page id's that the front end includes will be included in. Example: 2,3,5 also: homepage,3,4",SHOWBIZ_TEXTDOMAIN)));
									  
	$generalSettings->addRadio("js_to_footer", 
							   array("on"=>__("On",SHOWBIZ_TEXTDOMAIN),"off"=>__("Off",SHOWBIZ_TEXTDOMAIN)),
							   __("Put JS Includes To Footer",SHOWBIZ_TEXTDOMAIN),
							   "off",
							   array("description"=>"<br>".__("Putting the js to footer (instead of the head) is good for fixing some javascript conflicts.",SHOWBIZ_TEXTDOMAIN)));
	
	$generalSettings->addRadio("use_hammer_js", 
							   array("on"=>__("On",SHOWBIZ_TEXTDOMAIN),"off"=>__("Off",SHOWBIZ_TEXTDOMAIN)),
							   __("Use Own hammer.js",SHOWBIZ_TEXTDOMAIN),
							   "on",
							   array("description"=>__("Disable this only if hammer.js is already loaded.",SHOWBIZ_TEXTDOMAIN)));
	//get stored values
	$operations = new BizOperations();
	$arrValues = $operations->getGeneralSettingsValues();
	$generalSettings->setStoredValues($arrValues);
	
	self::storeSettings("general", $generalSettings);

?>