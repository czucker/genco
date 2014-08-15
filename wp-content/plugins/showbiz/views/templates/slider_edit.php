
	<input type="hidden" id="sliderid" value="<?php echo $sliderID?>"></input>
	
	<div class="wrap settings_wrap">

		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>				
			<h2>Edit Slider</h2>
			<?php BizOperations::putGlobalSettingsHelp(); ?>			
			<?php BizOperations::putLinkHelp(GlobalsShowBiz::LINK_HELP_SLIDER); ?>			
		</div>		
		
			<div class="settings_panel">
			
				<div class="settings_panel_left">
					
					<div id="main_dlier_settings_wrapper" class="postbox unite-postbox ">
					  <h3 class="box-closed"><span>Main Slider Settings</span></h3>
					  <div class="p10">
					
							<?php $settingsSliderMain->draw("form_slider_main",true)?>
							
							<div class="vert_sap_medium"></div>
							
							<a class='button-primary revgreen' href='javascript:void(0)' id="button_save_slider" ><i class="revicon-cog"></i><?php _e("Save Settings",SHOWBIZ_TEXTDOMAIN)?></a>
							<a href='javascript:void(0)' id='button_refresh_images' class='button-primary revgreen'><i class="revicon-cog"></i><?php _e("Save & Refresh Images",SHOWBIZ_TEXTDOMAIN)?></a>
							<span id="loader_update" class="loader_round" style="display:none;"><?php _e("updating...",SHOWBIZ_TEXTDOMAIN)?> </span>
							<span id="update_slider_success" class="success_message"></span>
							<a class="button-primary revblue" href="<?php echo $linksEditSlides?>"  id="link_edit_slides"><i class="revicon-pencil-1"></i><?php _e("Edit Slides",SHOWBIZ_TEXTDOMAIN)?></a>												
							<a class='button-primary revred' id="button_delete_slider"  href='javascript:void(0)' id="button_delete_slider" title="<?php _e("Delete Slider",SHOWBIZ_TEXTDOMAIN)?>" ><i class="revicon-trash"></i></a>
							<a class='button-primary revyellow' id="button_close_slider_edit"  href='<?php echo self::getViewUrl("sliders") ?>' title="<?php _e("Close",SHOWBIZ_TEXTDOMAIN)?>" ><i class="revicon-cancel"></i></a>							
							<a class="button-primary revgray" href="javascript:void(0)"  id="button_preview_slider" title="<?php _e("Preview Slider",SHOWBIZ_TEXTDOMAIN)?>"><i class="revicon-search-1"></i></a>							
							
														
							
							<!--
							 
							<div class="clear"></div>
							<div class="advanced_links_wrapper">
								<a href="javascript:void(0);" id="link_show_api">Show API Functions</a>
								<a href="javascript:void(0);" id="link_show_toolbox">Show Export / Import</a>	
							</div>
							
							 -->
							 
							<?php /*
								require self::getPathTemplate("slider_api");
								require self::getPathTemplate("slider_toolbox");
								*/  
							?>
							<div class="clear"></div>

							<div class="divide20"></div>
					  </div>
					</div>
					
				</div>
				<div class="settings_panel_right">
					<?php $settingsSliderParams->draw("form_slider_params",true); ?>
				</div>
				
				<div class="clear"></div>
				
			</div>

	</div>

	<?php require self::getPathTemplate("dialog_preview_slider");?>

	<script type="text/javascript">
		var g_viewTemplates = '<?php echo $viewTemplates?>';
		var g_viewTemplatesNav = '<?php echo $viewTemplatesNav?>';
		var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;
		
		jQuery(document).ready(function(){
			ShowBizAdmin.initEditSliderView();
		});
		
	</script>
	
