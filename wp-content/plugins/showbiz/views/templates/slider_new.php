

	<div class="wrap settings_wrap">
		
			<div class="title_line">
				<div id="icon-options-general" class="icon32"></div>				
				<h2>New Slider</h2>
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
														
							<a class='button-primary revgreen' href='javascript:void(0)' id="button_save_slider" ><i class="revicon-cog"></i><?php _e("Create Slider",SHOWBIZ_TEXTDOMAIN)?></a>
							<a class='button-primary revyellow' id="button_close_slider_edit"  href='<?php echo self::getViewUrl("sliders") ?>' ><i class="revicon-cancel"></i><?php _e("Close",SHOWBIZ_TEXTDOMAIN)?></a>
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

	<script type="text/javascript">
		var g_viewTemplates = '<?php echo $viewTemplates?>';
		var g_viewTemplatesNav = '<?php echo $viewTemplatesNav?>';	
		var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;
	
		jQuery(document).ready(function(){
			
			ShowBizAdmin.initAddSliderView();
		});
	</script>
	
