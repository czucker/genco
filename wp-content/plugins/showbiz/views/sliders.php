<?php
	$slider = new ShowBizSlider();
	$arrSliders = $slider->getArrSliders();
		
	$addNewLink = self::getViewUrl(ShowBizAdmin::VIEW_SLIDER);
	
	require self::getPathTemplate("sliders");
?>


	