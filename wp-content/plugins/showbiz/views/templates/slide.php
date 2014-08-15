	
	<div class="wrap settings_wrap">

		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>				
			<h2>Edit Slider</h2>
			<?php BizOperations::putGlobalSettingsHelp(); ?>			
			<?php BizOperations::putLinkHelp(GlobalsShowBiz::LINK_HELP_SLIDER); ?>			
		</div>	
		
		
		<div id="main_dlier_settings_wrapper" class="postbox unite-postbox ">
		  <h3 class="box-closed"><span>Main Slider Settings</span></h3>
		  <div class="p10 specialtable_gallery">
		
					<div id="slide_params_holder">
						<form name="form_slide_params" id="form_slide_params">		
						<?php
							$settingsSlideOutput->draw("form_slide_params",false);
						?>
							<input type="hidden" id="image_url" name="image_url" value="<?php echo $imageUrl?>" />
						</form>
					</div>
					
					<div class="vert_sap_medium"></div>
					
					<a class='button-primary revgreen' href="javascript:void(0)" id="button_save_slide" ><i class="revicon-cog"></i><?php _e("Save Settings",SHOWBIZ_TEXTDOMAIN)?></a>
					<span id="loader_update" class="loader_round" style="display:none;"><?php _e("updating...",SHOWBIZ_TEXTDOMAIN)?> </span>
					<span id="update_slider_success" class="success_message"></span>							
					<a id="button_close_slide" class='button-primary revyellow'   href="<?php echo $closeUrl?>" ><i class="revicon-cancel"></i><?php _e("Close",SHOWBIZ_TEXTDOMAIN)?></a>												
				<div class="clear"></div>

				<div class="divide20"></div>
		  </div>
		</div>
		
	</div>
	
	<div class="vert_sap"></div>
		
	<script type="text/javascript">
		jQuery(document).ready(function(){
			ShowBizAdmin.initEditSlideView(<?php echo $slideID?>);
		});
	</script>
	
	
