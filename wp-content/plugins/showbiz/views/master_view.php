<?php
	global $showbizVersion;
	
	$wrapperClass = "";
	if(GlobalsShowBiz::$isNewVersion == false)
		 $wrapperClass = " oldwp";
?>

<script type="text/javascript">
	var g_uniteDirPlagin = "<?php echo self::$dir_plugin?>";
	var g_urlContent = "<?php echo UniteFunctionsWPBiz::getUrlUploads()?>";
	var g_urlAjaxShowImage = "<?php echo UniteBaseClassBiz::$url_ajax_showimage?>";
	var g_urlAjaxActions = "<?php echo UniteBaseClassBiz::$url_ajax_actions?>";
	var g_settingsObj = {};
	
</script>

<div id="div_debug"></div>

<div class='unite_error_message' id="error_message" style="display:none;"></div>

<div class='unite_success_message' id="success_message" style="display:none;"></div>

<div id="viewWrapper" class="view_wrapper<?php echo $wrapperClass?>">

<?php
	self::requireView($view);
	
?>

</div>

<div id="divColorPicker" style="display:none;"></div>

<?php self::requireView("system/video_dialog")?>
<?php self::requireView("system/update_dialog")?>
<?php self::requireView("system/general_settings_dialog")?>

<div class="clear"></div>

<div class="tp-plugin-version">&copy; All rights reserved, <a href="http://themepunch.com" target="_blank">Themepunch</a>  ver. <?php echo $showbizVersion?>

	<?php if(self::$view == ShowBizAdmin::VIEW_SLIDERS): ?>
		<a id="button_upload_plugin" class="button-primary revpurple" href="javascript:void(0)">Update Plugin</a>
	<?php endif?>		 
		
</div>

