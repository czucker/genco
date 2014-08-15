
<div id="dialog_update_plugin" class="api_wrapper" title="Update Slider Plugin" style="display:none;">
		<div class="api-caption">Update ShowBiz Plugin:</div>
		<div class="api-desc">
			To update the slider please show the slider install package. The files will be overwriten. 
			<br> File example: showbiz.zip
		</div>
		
		<br>		
		
		<form action="<?php echo UniteBaseClassBiz::$url_ajax?>" enctype="multipart/form-data" method="post">
		    
		    <input type="hidden" name="action" value="showbiz_ajax_action">
		    <input type="hidden" name="client_action" value="update_plugin">
		    
		    Choose the update file:   
		    <br>
		    
			<input type="file" name="update_file" class="input_update_slider">
			
		    <br><br>
		    

		    <label for="update_base_templates">Update base templates: </label>
			<input type="checkbox" id="update_base_templates" name="update_base_templates" >
			<br><br>
			<div class="api-desc">
				 If this option is checked, all the default templates will be updated by the new content. 
			</div>
			
			<br>
			 
			<input type="submit" class='button-primary' value="Update Showbiz Plugin">
		</form>
				
</div>