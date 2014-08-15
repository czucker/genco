<?php
$validated = get_option('showbiz-valid', 'false');
$username = get_option('showbiz-username', '');
$api_key = get_option('showbiz-api-key', '');
$code = get_option('showbiz-code', '');
$latest_version = get_option('showbiz-latest-version', GlobalsShowBiz::SLIDER_REVISION);
   if(version_compare($latest_version, GlobalsShowBiz::SLIDER_REVISION, '>')){
    //neue version existiert
   }else{
    //up to date
   }

?>

<!-- 
  CONTENT BEFORE ACTIVATION, BASED OF VALIDATION 
-->
<?php if($validated === 'true') {
		$displ = "block";
	?> 
	<div class="revgreen" style="left:0px;top:0px;position:absolute;height:100%;padding:30px 10px;"><i style="color:#fff;font-size:25px" class="eg-icon-check"></i></div>
	<?php 	
} else {
	$displ = "none";
	?> 
	<div class="revcarrot"   style="left:0px;top:0px;position:absolute;height:100%;padding:22px 10px;"><i style="color:#fff;font-size:25px" class="revicon-cancel"></i></div>
	<?php 
}
?>

<div id="rs-validation-wrapper" style="display:<?php echo $displ; ?>">
	
	<div class="validation-label"><?php _e('Username:'); ?></div> 
	<div class="validation-input"> 
		<input type="text" name="sb-validation-username" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> value="<?php echo $username; ?>" />
		<p class="validation-description"><?php _e('Your Envato username.'); ?></p>
	</div>
	<div class="clear"></div>
	
	
	<div class="validation-label"><?php _e('Envato API Key:'); ?> </div> 
	<div class="validation-input">
		<input type="text" name="sb-validation-api-key" value="<?php echo $api_key; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px;" />
		<p class="validation-description"><?php _e('You can find API key by visiting your Envato Account page, then clicking the My Settings tab. At the bottom of he page you will find your accounts API key.'); ?></p>
	</div>
	<div class="clear"></div>
	
	<div class="validation-label"><?php _e('Purchase code:'); ?></div> 
	<div class="validation-input">
		<input type="text" name="sb-validation-token" value="<?php echo $code; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> placeholder="45afeb91-0e4c-a1d9-2a4a-04ce3b5a3b30" style="width: 350px;" />
		<p class="validation-description"><?php _e('Please enter your '); ?><strong style="color:#000"><?php _e('CodeCanyon Showbiz Pro purchase code / license key'); ?></strong><?php _e('. You can find your key by following the instructions on'); ?><a target="_blank" href="http://www.themepunch.com/home/plugins/wordpress-plugins/revolution-slider-wordpress/where-to-find-the-purchase-code/"><?php _e(' this page.'); ?></a></p>
	</div>
	<div style="height:15px" class="clear"></div>
	
	<span style="display:none" id="rs_purchase_validation" class="loader_round"><?php _e('Please Wait...'); ?></span>

	<a href="javascript:void(0);" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?> id="sb-validation-activate" class="button-primary revgreen"><?php _e('Activate'); ?></a>
	
	<a href="javascript:void(0);" <?php echo ($validated === 'true') ? '' : 'style="display: none;"'; ?> id="sb-validation-deactivate" class="button-primary revred"><?php _e('Deactivate'); ?></a>
	

	<?php
	if($validated === 'true'){
		?>
		<a href="update-core.php" id="sb-check-updates" class="button-primary revpurple"><?php _e('Search for Updates'); ?></a>
		<?php
	}
	?>
	
</div>

<!-- 
  CONTENT AFTER ACTIVATION, BASED OF VALIDATION 
-->
<?php if($validated === 'true') {
	?> 
	<h3> <?php _e("How to get Support ?")?>:</h3>				
	<p>
	<?php _e("Please feel free to contact us via our ")?><a href='http://themepunch.ticksy.com'><?php _e("Support Forum ")?></a><?php _e("and/or via the ")?><a href='http://codecanyon.net/item/showbiz-pro-responsive-teaser-wordpress-plugin/4720988'><?php _e("Item Disscussion Forum")?></a><br />
	</p> 	
	<?php 	
} else {
	?> 
	<p style="margin-top:10px; margin-bottom:10px;" id="tp-before-validation">

	<?php _e("Click Here to get "); ?><strong><?php _e("Premium Support and Auto Updates"); ?></strong><br />

	</p> 
	<?php 
}
?>
	
