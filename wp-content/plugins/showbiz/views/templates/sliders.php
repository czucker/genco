<?php
	$exampleID = '"slider1"';
	$dir = plugin_dir_path(__FILE__).'../../';
	if(!empty($arrSliders))
		$exampleID = '"'.$arrSliders[0]->getAlias().'"';
	$latest_version = get_option('showbiz-latest-version', GlobalsShowBiz::SLIDER_REVISION);
   if(version_compare($latest_version, GlobalsShowBiz::SLIDER_REVISION, '>')){
    //neue version existiert
   }else{
    //up to date
   }
?>

	<div class='wrap'>
	
	<div class="title_line">
		<h2>
			ShowBiz Sliders
		</h2>
		
		<?php BizOperations::putGlobalSettingsHelp(); ?>
		<?php BizOperations::putLinkHelp(GlobalsShowBiz::LINK_HELP_SLIDERS); ?>
		
	</div>
	
	<br>
	<?php if(empty($arrSliders)): ?>
		No Sliders Found
		<br>
	<?php else:
		try{
		 
			require self::getPathTemplate("sliders_list");
		 
		}catch(Exception $e){
			$message = $e->getMessage();
			$trace = $e->getTraceAsString();
			echo "Showbiz Error: <b>".$message." , <br> Please turn to the developer to solve this error!</b>";
		}
		 		 	 		
	endif?>
	
	
	<br>
	<p>			
		<a class='button-primary revblue' href='<?php echo $addNewLink?>'>Create New Slider</a>
	</p>
	 
	 <br>
	
	
	
	<!-- 
		THE INFO ABOUT EMBEDING OF THE SLIDER 			
		-->
		<div class="title_line"><div class="view_title"><?php _e("How To Use ShowBiz")?></div></div>		
		
		<div style="border:1px solid #e5e5e5; padding:15px 15px 15px 80px; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;position:relative;overflow:hidden;background:#f1f1f1">		
			<div class="revyellow" style="left:0px;top:0px;position:absolute;height:100%;padding:27px 10px;"><i style="color:#fff;font-size:25px" class="revicon-arrows-ccw"></i></div>
		
			<?php _e("From the")?> <b><?php _e("page and/or post editor")?></b> <?php _e("insert the shortcode from the sliders table")?><br>				
			<br>
			<?php _e("From the")?> <b><?php _e("theme html")?></b> <?php _e("use")?>: <code>&lt?php putShowBiz( "alias" ) ?&gt</code> <?php _e("example")?>: <code>&lt?php putShowBiz(<?echo $exampleID?>) ?&gt</code><br>
			<span style="margin-left:20px"><?php _e("For show only on homepage use")?>: <code>&lt?php putShowBiz(<?echo $exampleID?>,"homepage") ?&gt</code></span><br>
			<span style="margin-left:20px"><?php _e("For show on certain pages use")?>: <code>&lt?php putShowBiz(<?echo $exampleID?>,"2,10") ?&gt</code></span><br> 
			<br>
			<?php _e("From the")?> <b><?php _e("widgets panel")?></b> <?php _e("drag the \"ShowBiz\" widget to the desired sidebar")?><br>
		</div>
		
		<div style="width:100%;height:50px"></div>
		<!-- 
		THE CURRENT AND NEXT VERSION		
		-->
		<div class="title_line"><div class="view_title"><?php _e("Version Information")?></div></div>		
		
		<div style="border:1px solid #e5e5e5; padding:15px 15px 15px 80px; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;position:relative;overflow:hidden;background:#f1f1f1">		
			<div class="revgray" style="left:0px;top:0px;position:absolute;height:100%;padding:27px 10px;"><i style="color:#fff;font-size:25px" class="revicon-info-circled"></i></div>
			<p style="margin-top:5px; margin-bottom:5px;">
				<?php _e("Installed Version")?>: <span  class="slidercurrentversion"><?php echo GlobalsShowBiz::SLIDER_REVISION; ?></span><br>
				<?php _e("Available Version")?>: <span class="slideravailableversion"><?php echo $latest_version; ?></span>
			</p>
		</div>
		
				
		<!--
		ACTIVATE THIS PRODUCT 
		-->
		<a name="activateplugin"></a>
		<div style="width:100%;height:50px"></div>

		<div class="title_line">
			<div class="view_title"><span style="margin-right:10px"><?php _e("Need Premium Support and Auto Updates ?") ?></span><a style="vertical-align:middle" class='button-primary revblue' href='#' id="benefitsbutton"><?php _e("Why is this Important ?")?> </a></div>
		</div>
		
		<div id="benefitscontent" style="margin-top:10px;margin-bottom:10px;display:none;border:1px solid #e5e5e5; padding:15px 15px 15px 80px; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;position:relative;overflow:hidden;background-color:#fff;">		
			<div class="revblue" style="left:0px;top:0px;position:absolute;height:100%;padding:27px 10px;"><i style="color:#fff;font-size:25px" class="revicon-doc"></i></div>
			<h3> <?php _e("Benefits")?>:</h3>
			<p>
			<strong><?php _e("Get Premium Support"); ?></strong><?php _e(" - We help you in case of Bugs, installation problems, and Conflicts with other plugins and Themes "); ?><br>
			<strong><?php _e("Auto Updates"); ?></strong><?php _e(" - Get the latest version of our Plugin.  New Features and Bug Fixes are available regularly !"); ?>
			</p>
		</div>
		
		<!-- 
		VALIDATION
		-->
		<div id="tp-validation-box"  style="cursor:pointer;border:1px solid #e5e5e5; margin-top:10px;padding:15px 15px 15px 80px; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;position:relative;overflow:hidden;background:#f1f1f1">		
			<?php self::requireView("system/validation")?>																					
		</div>
		
		<!-- THE UPDATE HISTORY OF SLIDER REVOLUTION -->
		<div style="width:100%;height:50px"></div>	
		
		<div class="title_line">
			<div class="view_title"><span style="margin-right:10px"><?php _e("Update History") ?></span></div>
		</div>
				
		<div style="border:1px solid #e5e5e5;  height:500px;padding:25px 15px 15px 80px; border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;position:relative;overflow:hidden;background:#f1f1f1">		
			<div class="revpurple" style="left:0px;top:0px;position:absolute;height:100%;padding:27px 10px;"><i style="color:#fff;font-size:27px" class="eg-icon-back-in-time"></i></div>
			<div style="height:485px;overflow:scroll;width:100%;"><?php echo file_get_contents($dir."release_log.html"); ?></div>							
		</div>
	</div>
	
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
		
			jQuery('#benefitsbutton').hover(function() {
				jQuery('#benefitscontent').slideDown(200);
			}, function() {
				jQuery('#benefitscontent').slideUp(200);				
			})
			
			jQuery('#tp-validation-box').click(function() {
				jQuery(this).css({cursor:"default"});
				if (jQuery('#rs-validation-wrapper').css('display')=="none") {
					jQuery('#tp-before-validation').hide();
					jQuery('#rs-validation-wrapper').slideDown(200);
				}
			})
		});
	</script>
