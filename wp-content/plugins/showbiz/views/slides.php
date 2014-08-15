<?php
	
	$sliderID = self::getGetVar("id");
	
	if(empty($sliderID))
		UniteFunctionsBiz::throwError("Slider ID not found"); 
	
	$slider = new ShowBizSlider();
	$slider->initByID($sliderID);
	
	$sliderParams = $slider->getParams();
	
	$arrSlides = $slider->getSlides();
	
	$numSlides = count($arrSlides);
	
	$linksSliderSettings = self::getViewUrl(ShowBizAdmin::VIEW_SLIDER,"id=$sliderID");
	
	$templateName = "slides_gallery";
	
	//set posts params
	if($slider->isSourceFromPosts()){
		$templateName = "slides_posts";
		
		$params = $slider->getParams();
		
		$postCatID = $slider->getPostCategory();
		
		$isMultiple = (strpos($postCatID, ",") !== false);
		
		//get category name
		$isMultiple = true;
		
		/*
		if($isMultiple == false){
			$catData = UniteFunctionsWPBiz::getCategoryData($postCatID);
			if(empty($catData))
				UniteFunctionsBiz::throwError("Category with id: $postCatID not found");
			
			$catName = $catData["cat_name"];
			
			$urlCatPosts = UniteFunctionsWPBiz::getUrlSlidesEditByCatID($postCatID);		
			$linkCatPosts = UniteFunctionsBiz::getHtmlLink($urlCatPosts, $catName,"","",true);
		}
		*/
		
		$sourceType = $slider->getParam("source_type","posts");
		$showSortBy = ($sourceType == "posts")?true:false;
		
		//get button links
		$urlNewPost = UniteFunctionsWPBiz::getUrlNewPost();
		$linkNewPost = UniteFunctionsBiz::getHtmlLink($urlNewPost, "New Post","button_new_post","button-primary",true);
		
		//get ordering
		$arrSortBy = UniteFunctionsWPBiz::getArrSortBy();
		$sortBy = $slider->getParam("post_sortby",ShowBizSlider::DEFAULT_POST_SORTBY);
		$selectSortBy = UniteFunctionsBiz::getHTMLSelect($arrSortBy,$sortBy,"id='select_sortby'",true);
		
	}
	
	require self::getPathTemplate($templateName);
	
?>


