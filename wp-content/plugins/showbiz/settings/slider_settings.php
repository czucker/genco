<?php
	
	//set "slider_main" settings
	$sliderMainSettings = new UniteSettingsAdvancedBiz();
	$sliderMainSettings->addTextBox("title", "","Slider Title",array("description"=>"The title of the slider. Example: Slider1","required"=>"true"));	
	$sliderMainSettings->addTextBox("alias", "","Slider Alias",array("description"=>"The alias that will be used for embedding the slider. Example: slider1","required"=>"true"));
	$sliderMainSettings->addTextBox("shortcode", "","Slider Short Code",array("readonly"=>true,"class"=>"code"));
	$sliderMainSettings->addHr();
	
	//source type
	$arrSourceTypes = array("posts"=>"Posts",
							  "specific_posts"=>"Specific Posts",
							  "gallery"=>"Gallery");
	
	if(UniteFunctionsWooCommerceBiz::isWooCommerceExists())
		$arrSourceTypes["woocommerce"] = "WooCommerce";
	
	$sliderMainSettings->addRadio("source_type",$arrSourceTypes,"Source Type", "posts"); 
						
	//post categories list
	$sliderMainSettings->startBulkControl("source_type", UniteSettingsBiz::CONTROL_TYPE_SHOW, "posts");

		//post types
		$arrPostTypes = UniteFunctionsWPBiz::getPostTypesAssoc();
		$arrParams = array("args"=>"multiple size='5'");
		$sliderMainSettings->addSelect("post_types", $arrPostTypes, "Post Types","post",$arrParams);
	
		//post categories
		$arrParams = array("args"=>"multiple size='7'");
		$sliderMainSettings->addSelect("post_category", array(), "Post Categories","",$arrParams);
				
		//sort by
		$arrSortBy = UniteFunctionsWPBiz::getArrSortBy();
		$sliderMainSettings->addSelect("post_sortby", $arrSortBy, "Sort Posts By",ShowBizSlider::DEFAULT_POST_SORTBY);
		
		//sort direction
		$arrSortDir = UniteFunctionsWPBiz::getArrSortDirection();
		$sliderMainSettings->addRadio("posts_sort_direction", $arrSortDir, "Sort Direction", ShowBizSlider::DEFAULT_POST_SORTDIR);
		
		//max posts for slider
		$arrParams = array("class"=>"small","unit"=>"posts");
		$sliderMainSettings->addTextBox("max_slider_posts", "30", "Max Posts Per Slider", $arrParams);
		
	$sliderMainSettings->endBulkControl();
	
	$sliderMainSettings->startBulkControl("source_type", UniteSettingsBiz::CONTROL_TYPE_SHOW, "gallery");
		
		$sliderMainSettings->addRadio("img_random_order", array("on"=>"On", "off"=>"Off"), "Random Order", 'off');
		
	$sliderMainSettings->endBulkControl();
	
	// -------------- Specific IDs ------------------
	
	$arrParams = array("description"=>"Type here the post IDs you want to use separated by coma. ex: 23,24,25");
	$sliderMainSettings->addTextBox("posts_list","","Specific Posts List",$arrParams);
	$sliderMainSettings->addControl("source_type", "posts_list", UniteSettingsBiz::CONTROL_TYPE_SHOW, "specific_posts");

	
	$arrParams = array("class"=>"small","unit"=>"words/characters");
	$sliderMainSettings->addTextBox("title_limit", "99", "Limit The Title To", $arrParams);

	$arrParams = array("class"=>"small","unit"=>"words/characters");		
	$sliderMainSettings->addTextBox("excerpt_limit", "55", "Limit The Excerpt To", $arrParams);
	
	$arrLimitTypes = array("words"=>"Words",
							  "character"=>"Characters");
	
	$sliderMainSettings->addSelect("limit_by_type", $arrLimitTypes, "Limit By", "words");
	
	//$arrParams = array("class"=>"normal","description"=>"Specifies the delimiter where word ends to limit title/excerpt. Default is a space.");
	//$sliderMainSettings->addTextBox("word_end", " ", "Delimiter Char", $arrParams);
	
	
	//source type
	$arrImgSourceTypes = array("full"=>"Original Size",
							  "thumbnail"=>"Thumbnail Size",
							  "medium"=>"Medium Size",
							  "large"=>"Large Size",
							  "custom"=>"Custom");
	
	$sliderMainSettings->addSelect("img_source_type", $arrImgSourceTypes, "Image Source Type", "medium");
	
	$sliderMainSettings->startBulkControl("img_source_type", UniteSettingsBiz::CONTROL_TYPE_SHOW, "custom");
	
	$arrParams = array("class"=>"small","unit"=>"px");
	$sliderMainSettings->addTextBox("img_source_type_width", "", "Image Width", $arrParams);

	$arrParams = array("class"=>"small","unit"=>"px");		
	$sliderMainSettings->addTextBox("img_source_type_height", "", "Image Height", $arrParams);
	
	$sliderMainSettings->endBulkControl();
	//image ratio
	$arrImgRatio = array("none"=>"None",
							  "1_1"=>"1:1",
							  "3_2"=>"3:2",
							  "4_3"=>"4:3",
							  "16_9"=>"16:9",
							  "16_10"=>"16:10",
							  "2_3"=>"2:3",
							  "3_4"=>"3:4",
							  "9_16"=>"9:16",
							  "10_16"=>"10:16"
							  );
	
	$sliderMainSettings->addSelect("img_ratio", $arrImgRatio, "Image Ratio", "none");
	
	// -------------- Woo Commerce ------------------
	if(UniteFunctionsWooCommerceBiz::isWooCommerceExists()):
	
	
		$wcPostTypes = UniteFunctionsWooCommerceBiz::getCustomPostTypes();
		$sliderMainSettings->startBulkControl("source_type", UniteSettingsBiz::CONTROL_TYPE_SHOW, "woocommerce");
		
			$arrParams = array("args"=>"multiple size='2'");
			$sliderMainSettings->addSelect("wc_post_types", $wcPostTypes, "Post Types","post",$arrParams);
			
			//post categories
			$arrParams = array("args"=>"multiple size='7'");
			$sliderMainSettings->addSelect("wc_post_category", array(), "Post Categories","",$arrParams);
			
			//sort by
			$arrSortBy = UniteFunctionsWooCommerceBiz::getArrSortBy();
			$sliderMainSettings->addSelect("wc_post_sortby", $arrSortBy, "Sort Posts By",ShowBizSlider::DEFAULT_POST_SORTBY);
			
			//sort direction
			$arrSortDir = UniteFunctionsWPBiz::getArrSortDirection();
			$sliderMainSettings->addRadio("wc_posts_sort_direction", $arrSortDir, "Sort Direction", ShowBizSlider::DEFAULT_POST_SORTDIR);
			
			//max posts for slider
			$arrParams = array("class"=>"small","unit"=>"posts");
			$sliderMainSettings->addTextBox("wc_max_slider_posts", "30", "Max Posts Per Slider", $arrParams);
			
			$sliderMainSettings->addStaticText("------ WooCommerce Filters ---------","text_filters");
			
			$arrParams = array("class"=>"small",
								UniteSettingsBiz::PARAM_ADDTEXT_BEFORE_ELEMENT=>"From:" );
				
			
			$sliderMainSettings->addTextBox("wc_regular_price_from", "", "Regular Price", $arrParams);
			$arrParams = array("class"=>"small",
							   UniteSettingsBiz::PARAM_OUTPUTWITH=>"wc_regular_price_from",
							   UniteSettingsBiz::PARAM_ADDTEXT_BEFORE_ELEMENT=>"&nbsp;&nbsp;&nbsp;&nbsp; To:"
							   );
							   
			
			$sliderMainSettings->addTextBox("wc_regular_price_to", "", "Regular Price To", $arrParams);
	
			$arrParams = array("class"=>"small",
								UniteSettingsBiz::PARAM_ADDTEXT_BEFORE_ELEMENT=>"From:"
								);
				
			$sliderMainSettings->addTextBox("wc_sale_price_from", "", "Sale Price", $arrParams);
			
			$arrParams = array("class"=>"small",
							   UniteSettingsBiz::PARAM_OUTPUTWITH=>"wc_sale_price_from",
							   UniteSettingsBiz::PARAM_ADDTEXT_BEFORE_ELEMENT=>"&nbsp;&nbsp;&nbsp;&nbsp; To:"
							   );
			
			$sliderMainSettings->addTextBox("wc_sale_price_to", "", "Sale Price To", $arrParams);
			$sliderMainSettings->addCheckbox("wc_instock_only",false,"In Stock Only");
			$sliderMainSettings->addCheckbox("wc_featured_only",false,"Featured Products Only");
			
			
		$sliderMainSettings->endBulkControl();
		
	endif;		//if woocommerce exists
	
	
	// -------------- End Filters ------------------
	
	$sliderMainSettings->addHr();
	
	//set select item template
	$templates = new ShowBizTemplate();
	$arrTemplates = $templates->getArrShortAssoc(GlobalsShowBiz::TEMPLATE_TYPE_ITEM);
	
	$addHtml = "<a href='javascript:void(0)' id='button_edit_item_template' class='button-primary revblue mleft_10'><i class='revicon-pencil-1'></i>Edit</a>";
	$params = array("description"=>"The template that set the look of the item",UniteSettingsBiz::PARAM_ADDTEXT => $addHtml);
	$sliderMainSettings->addSelect("template_id", $arrTemplates, "Item Template", "", $params);
	
	self::storeSettings("slider_main",$sliderMainSettings);
	
	//set "slider_params" settings. 
	$sliderParamsSettings = new UniteSettingsAdvancedBiz();	
	$sliderParamsSettings->loadXMLFile(self::$path_settings."/slider_settings.xml");
	
	//update navigation template
	$templates = new ShowBizTemplate();
	$arrTemplates = $templates->getArrShortAssoc(GlobalsShowBiz::TEMPLATE_TYPE_BUTTON);
	$addHtml = "<a href='javascript:void(0)' id='button_edit_item_template_nav' class='button-secondary mleft_10' style='margin-top:17px;'>Edit</a>";
	
	$sliderParamsSettings->updateSettingField("nav_template_id", "items", $arrTemplates);
	$sliderParamsSettings->updateSettingField("nav_template_id", UniteSettingsBiz::PARAM_ADDTEXT, $addHtml);
	
	
	//store params
	self::storeSettings("slider_params",$sliderParamsSettings); 
	
?>

