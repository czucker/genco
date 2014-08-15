	<div class="wrap settings_wrap">
	
		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>		
			<h2>Edit Slides: <?php echo $slider->getTitle()?></h2>
			<?php BizOperations::putGlobalSettingsHelp(); ?>	
			<?php BizOperations::putLinkHelp(GlobalsShowBiz::LINK_HELP_SLIDES); ?>
			
		</div>
	
		
		<div class="vert_sap"></div>
			The slides are posts that taken from
			<?php if($isMultiple == true):?>
				multiple sources. &nbsp;
			<?php else:?>
				<?php echo $linkCatPosts?> category. &nbsp;
			<?php endif?>
			
			<?php if($showSortBy == true): ?> 
				Sort by: <?php echo $selectSortBy?> &nbsp; <span class="hor_sap"></span>
			<?php endif?>
			
			<?php echo $linkNewPost?>
			<span id="slides_top_loader" class="slides_posts_loader" style="display:none;">Updating Sorting...</span>
			
		<div class="vert_sap"></div>
		<div class="sliders_list_container">
			<?php require self::getPathTemplate("slides_list_posts");?>
		</div>
		<div class="vert_sap_medium"></div>
		
		<div class="list_slides_bottom">
			<?php echo $linkNewPost?>
			<span class="hor_sap"></span>
			<a class="button_close_slide button-primary" href='<?php echo self::getViewUrl(ShowBizAdmin::VIEW_SLIDERS);?>' >Close</a>
			<span class="hor_sap"></span>
			<a href="<?php echo $linksSliderSettings?>" id="link_slider_settings">To Slider Settings</a>
		
		</div>
		
	</div>

	
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
			ShowBizAdmin.initSlidesListViewPosts("<?php echo $sliderID?>");
			
		});
		
	</script>
