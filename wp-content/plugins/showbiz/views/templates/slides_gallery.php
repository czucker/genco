	<div class="wrap settings_wrap">
	
	<div class="title_line">
		<div id="icon-options-general" class="icon32"></div>		
		<h2>Edit Slides: <?php echo $slider->getTitle()?></h2>
		<?php BizOperations::putGlobalSettingsHelp(); ?>	
		<?php BizOperations::putLinkHelp(GlobalsShowBiz::LINK_HELP_SLIDES); ?>
		
	</div>
	
		<div class="vert_sap"></div>
		<?php if($numSlides >= 5):?>
			<a id="button_new_slide_top" class='button-primary float_left' href='javascript:void(0)' >New Slide</a>
			<div id="loader_add_slide_top" class="loader_round loader_near_button" style="display:none;"></div>
			<div id="loader_add_slide_top_message" class="success_message float_left mleft_10 mtop_5" style="display:none;"></div>
			<div class="clear"></div>
		<?php endif?>
		
		<div class="vert_sap"></div>
		<div class="sliders_list_container">
			<?php require self::getPathTemplate("slides_list_gallery");?>
		</div>
		<div class="vert_sap_medium"></div>
		<a class='button-primary revgreen' id="button_new_slide" href='javascript:void(0)' ><i class="revicon-list-add"></i>New Slide</a>
		
		<div id="loader_add_slide_bottom" class="loader_round loader_near_button" style="display:none;"></div>
		<div id="loader_add_slide_bottom_message" class="success_message float_left mtop_5" style="display:none;"></div>
		
		<span class="hor_sap"></span>

		<a class='button_close_slide button-primary revyellow' id="button_close_slider_edit"  href='<?php echo self::getViewUrl(ShowBizAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php _e("Close",SHOWBIZ_TEXTDOMAIN)?></a>
		<span class="hor_sap"></span>
		
		<a href="<?php echo $linksSliderSettings?>" id="link_slider_settings" class="button-primary revblue"><i class="revicon-cog"></i>Slider Settings</a>
		
	</div>
	
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			ShowBizAdmin.initSlidesListViewGallery("<?php echo $sliderID?>");
			
		});
		
	</script>
