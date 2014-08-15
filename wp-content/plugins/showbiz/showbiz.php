<?php
/*
Plugin Name: ShowBiz
Plugin URI: http://www.themepunch.com/codecanyon/showbiz_wp/
Description: ShowBiz - Premium responsive slider
Author: ThemePunch
Version: 1.7.0
Author URI: http://themepunch.com
*/

$showbizVersion = "1.7.0";
$currentFile = __FILE__;
$currentFolder = dirname($currentFile);

//include frameword files
require_once $currentFolder . '/inc_php/framework/include_framework.php';

$folderIncludes = $currentFolder."/inc_php/framework/";

//include bases
require_once $folderIncludes . 'aq_resizer.php';
require_once $folderIncludes . 'base.class.php';
require_once $folderIncludes . 'wpml.class.php';
require_once $folderIncludes . 'elements_base.class.php';
require_once $folderIncludes . 'base_admin.class.php';
require_once $folderIncludes . 'base_front.class.php';

//include product files
require_once $currentFolder . '/inc_php/showbiz_settings_product.class.php';
require_once $currentFolder . '/inc_php/showbiz_globals.class.php';
require_once $currentFolder . '/inc_php/showbiz_operations.class.php';
require_once $currentFolder . '/inc_php/showbiz_slider.class.php';
require_once $currentFolder . '/inc_php/showbiz_output.class.php';
require_once $currentFolder . '/inc_php/showbiz_params.class.php';
require_once $currentFolder . '/inc_php/showbiz_slide.class.php';
require_once $currentFolder . '/inc_php/showbiz_template.class.php';
require_once $currentFolder . '/inc_php/showbiz_widget.class.php';
require_once $currentFolder . '/inc_php/showbiz_wildcards.class.php';


try{

	//register the kb slider widget
	UniteFunctionsWPBiz::registerWidget("ShowBiz_Widget");

	//add shortcode
	function showbiz_shortcode($args){

		$sliderAlias = UniteFunctionsBiz::getVal($args,0);
		ob_start();
		$slider = ShowBizOutput::putSlider($sliderAlias);
		$content = ob_get_contents();
		ob_clean();
		ob_end_clean();

		//handle slider output types
		if(!empty($slider)){
			$outputType = $slider->getParam("output_type","");
			switch($outputType){
				case "compress":
					$content = str_replace("\n", "", $content);
					$content = str_replace("\r", "", $content);
					return($content);
				break;
				case "echo":
					echo $content;		//bypass the filters
				break;
				default:
					return($content);
				break;
			}
		}else
			return($content);		//normal output

	}

	add_shortcode( 'showbiz', 'showbiz_shortcode' );

	if(is_admin()){		//load admin part
		require_once $currentFolder . '/inc_php/framework/update.class.php';
		
		require_once $currentFolder."/showbiz_admin.php";
		
		$productAdmin = new ShowBizAdmin($currentFile);


	}else{		//load front part

		/**
		 *
		 * put kb slider on the page.
		 * the data can be slider ID or slider alias.
		 */
		function putShowBiz($data,$putIn = ""){
			$operations = new BizOperations();
			$arrValues = $operations->getGeneralSettingsValues();
			$includesGlobally = UniteFunctionsBiz::getVal($arrValues, "includes_globally","on");
			$strPutIn = UniteFunctionsBiz::getVal($arrValues, "pages_for_includes");
			$isPutIn = ShowBizOutput::isPutIn($strPutIn,true);

			if($isPutIn == false && $includesGlobally == "off"){
				$output = new ShowBizOutput();
				$option1Name = "Include ShowBiz libraries globally (all pages/posts)";
				$option2Name = "Pages to include ShowBiz libraries";
				$output->putErrorMessage(__("If you want to use the PHP function \"putShowBiz\" in your code please make sure to check \" ",SHOWBIZ_TEXTDOMAIN).$option1Name.__(" \" in the backend's \"General Settings\" (top right panel). <br> <br> Or add the current page to the \"",SHOWBIZ_TEXTDOMAIN).$option2Name.__("\" option box."));
				return(false);
			}

			ShowBizOutput::putSlider($data,$putIn);
		}

		require_once $currentFolder."/showbiz_front.php";
		$productFront = new ShowBizFront($currentFile);
	}


}catch(Exception $e){
	$message = $e->getMessage();
	$trace = $e->getTraceAsString();
	echo "Showbiz Error: <b>".$message."</b>";
}



