<style>
input#inputExpansionLink { width:100%; }
textarea#inputHiddenContent { width:100%; max-height:250px; height:200px; resize:vertical; }
#TB_ajaxContent { height:690px !important; width:637px !important; overflow-y:scroll; overflow-x:hidden; }
#TB_window {width:667px !important; overflow:hidden; margin-top:-1em !important; height:725px !important; }
.expand-cnt-link { font-weight:bold; margin:.5em 0 .5em 0; display:inline; }
.hidden-content { display: none; margin-bottom: .5em; margin-top:.25em; }
.exp-col-content-holder { margin:.8em 0 .8em 0; display:block; }
.hidden-content img { float:left; }
#insertExpandContent_submit { margin-top:.8em; margin-bottom:.8em; z-index:999; position:relative; }
.ecf_warning { margin-top:0; margin-bottom:0; color:red; padding:0 !important; overflow:hidden; height:0px; opacity:0; }
#upload_box, #youTubeVideoBox {display:none;}
#imageCheckboxHolder { margin-top:.5em; margin-bottom:-.5em; display:block; }
#includeMediaCheckbox { margin-bottom:.5em; }
#media_box {height:0px; overflow:hidden;}
.expand-cnt-link:before { font-family: "ecf-icons"; content: "\e600  ";  font-size:16px; }
.ecf_opened:before { font-family: "ecf-icons"; content: "\e601  ";  font-size:16px; }
#youTube_video_URL, #upload_image { width: 350px; }
.bannerLink { display:block; width:100%; height:115px; margin:.25em 0 .25em 0; }
.bannerLink+h3 { margin-top: .25em; }
.bannerLink img { width:100%; }
#TB_ajaxContent h3 { margin-top:.3em; margin-bottom:.25em; }
#TB_ajaxContent input[type="text"], #TB_ajaxContent textarea {
  background:#eaeaea;
  background:-moz-linear-gradient(top,#eaeaea 0%,#f5f5f5 16%,#f5f5f5 100%);
  background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#eaeaea),color-stop(16%,#f5f5f5),color-stop(100%,#f5f5f5));
  background:-webkit-linear-gradient(top,#eaeaea 0%,#f5f5f5 16%,#f5f5f5 100%);
  background:-o-linear-gradient(top,#eaeaea 0%,#f5f5f5 16%,#f5f5f5 100%);
  background:-ms-linear-gradient(top,#eaeaea 0%,#f5f5f5 16%,#f5f5f5 100%);
  background:linear-gradient(to bottom,#eaeaea 0%,#f5f5f5 16%,#f5f5f5 100%);
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#eaeaea',endColorstr='#f5f5f5',GradientType=0);
}
.pluginByContent { float:right; display:block; margin-top:-2.5em; }
@font-face {
	font-family: "ecf-icons";
	src: url("fonts/ecf-icons.eot");
}
@font-face {
	font-family: "ecf-icons";
	src: url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMg6v8ysAAAC8AAAAYGNtYXDL8hqdAAABHAAAADxnYXNwAAAAEAAAAVgAAAAIZ2x5ZpFu6gUAAAFgAAABZGhlYWT+7sbiAAACxAAAADZoaGVhBigD3wAAAvwAAAAkaG10eAbbADMAAAMgAAAAEGxvY2EAvABeAAADMAAAAAptYXhwAAcAOAAAAzwAAAAgbmFtZUPPHeQAAANcAAABS3Bvc3QAAwAAAAAEqAAAACAAAwQAAZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAACDmAQPA/8D/wAPAAEAAAAAAAAAAAAAAAAAAAAAgAAAAAAACAAAAAwAAABQAAwABAAAAFAAEACgAAAAGAAQAAQACACDmAf//AAAAIOYA////4RoCAAEAAAAAAAAAAQAB//8ADwABAAAAAAAAAAAAAgAANzkBAAAAAAIABwC+Ai8C+QAaADUAAAEUBwEGIyIvASY1ND8BJyY1ND8BNjMyFwEWFTMUBwEGIyIvASY1ND8BJyY1ND8BNjMyFwEWFQFUBv72BgcIBR0GBuHhBgYdBQgHBgEKBtsF/vUFCAcGHAYG4OAGBhwGBwgFAQsFAdsHBv72BgYdBQgHBuDhBgcIBR0GBv72BggHBv72BgYdBQgHBuDhBgcIBR0GBv72BggAAAIALAD1AmYDHQAaADUAAAEUBwEGIyInASY1ND8BNjMyHwE3NjMyHwEWFTUUBwEGIyInASY1ND8BNjMyHwE3NjMyHwEWFQJmBf71BQgHBv72BgYcBgcIBuDhBQgHBh0FBf71BQgHBv72BgYcBgcIBuDhBQgHBh0FAhIHBv72BgYBCgYHCAUdBgbh4QYGHQUI3AgF/vUFBQELBQgHBhwGBuDgBgYcBgcAAAEAAAABAADFBlcuXw889QALBAAAAAAAzrVBZAAAAADOtUFkAAAAAAJmAx0AAAAIAAIAAAAAAAAAAQAAA8D/wAAABAAAAAAaAmYAAQAAAAAAAAAAAAAAAAAAAAQAAAAAAgAAAAJJAAcCkgAsAAAAAAAKAF4AsgAAAAEAAAAEADYAAgAAAAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAOAK4AAQAAAAAAAQASAAAAAQAAAAAAAgAOAFUAAQAAAAAAAwASACgAAQAAAAAABAASAGMAAQAAAAAABQAWABIAAQAAAAAABgAJADoAAQAAAAAACgAoAHUAAwABBAkAAQASAAAAAwABBAkAAgAOAFUAAwABBAkAAwASACgAAwABBAkABAASAGMAAwABBAkABQAWABIAAwABBAkABgASAEMAAwABBAkACgAoAHUAZQBjAGYALQBpAGMAbwBuAHMAVgBlAHIAcwBpAG8AbgAgADAALgAwAGUAYwBmAC0AaQBjAG8AbgBzZWNmLWljb25zAGUAYwBmAC0AaQBjAG8AbgBzAFIAZQBnAHUAbABhAHIAZQBjAGYALQBpAGMAbwBuAHMARwBlAG4AZQByAGEAdABlAGQAIABiAHkAIABJAGMAbwBNAG8AbwBuAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA) format("truetype"),
		 url(data:application/font-woff;charset=utf-8;base64,d09GRgABAAAAAAUUAAsAAAAABMgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABPUy8yAAABCAAAAGAAAABgDq/zK2NtYXAAAAFoAAAAPAAAADzL8hqdZ2FzcAAAAaQAAAAIAAAACAAAABBnbHlmAAABrAAAAWQAAAFkkW7qBWhlYWQAAAMQAAAANgAAADb+7sbiaGhlYQAAA0gAAAAkAAAAJAYoA99obXR4AAADbAAAABAAAAAQBtsAM2xvY2EAAAN8AAAACgAAAAoAvABebWF4cAAAA4gAAAAgAAAAIAAHADhuYW1lAAADqAAAAUsAAAFLQ88d5HBvc3QAAAT0AAAAIAAAACAAAwAAAAMEAAGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAAg5gEDwP/A/8ADwABAAAAAAAAAAAAAAAAAAAAAIAAAAAAAAgAAAAMAAAAUAAMAAQAAABQABAAoAAAABgAEAAEAAgAg5gH//wAAACDmAP///+EaAgABAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAACAAcAvgIvAvkAGgA1AAABFAcBBiMiLwEmNTQ/AScmNTQ/ATYzMhcBFhUzFAcBBiMiLwEmNTQ/AScmNTQ/ATYzMhcBFhUBVAb+9gYHCAUdBgbh4QYGHQUIBwYBCgbbBf71BQgHBhwGBuDgBgYcBgcIBQELBQHbBwb+9gYGHQUIBwbg4QYHCAUdBgb+9gYIBwb+9gYGHQUIBwbg4QYHCAUdBgb+9gYIAAACACwA9QJmAx0AGgA1AAABFAcBBiMiJwEmNTQ/ATYzMh8BNzYzMh8BFhU1FAcBBiMiJwEmNTQ/ATYzMh8BNzYzMh8BFhUCZgX+9QUIBwb+9gYGHAYHCAbg4QUIBwYdBQX+9QUIBwb+9gYGHAYHCAbg4QUIBwYdBQISBwb+9gYGAQoGBwgFHQYG4eEGBh0FCNwIBf71BQUBCwUIBwYcBgbg4AYGHAYHAAABAAAAAQAAxQZXLl8PPPUACwQAAAAAAM61QWQAAAAAzrVBZAAAAAACZgMdAAAACAACAAAAAAAAAAEAAAPA/8AAAAQAAAAAGgJmAAEAAAAAAAAAAAAAAAAAAAAEAAAAAAIAAAACSQAHApIALAAAAAAACgBeALIAAAABAAAABAA2AAIAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEAEgAAAAEAAAAAAAIADgBVAAEAAAAAAAMAEgAoAAEAAAAAAAQAEgBjAAEAAAAAAAUAFgASAAEAAAAAAAYACQA6AAEAAAAAAAoAKAB1AAMAAQQJAAEAEgAAAAMAAQQJAAIADgBVAAMAAQQJAAMAEgAoAAMAAQQJAAQAEgBjAAMAAQQJAAUAFgASAAMAAQQJAAYAEgBDAAMAAQQJAAoAKAB1AGUAYwBmAC0AaQBjAG8AbgBzAFYAZQByAHMAaQBvAG4AIAAwAC4AMABlAGMAZgAtAGkAYwBvAG4Ac2VjZi1pY29ucwBlAGMAZgAtAGkAYwBvAG4AcwBSAGUAZwB1AGwAYQByAGUAYwBmAC0AaQBjAG8AbgBzAEcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==) format("woff");
	font-weight: normal;
	font-style: normal;
}

[class^="ecf-icon-"], [class*=" ecf-icon-"] {
	font-family: "ecf-icons";
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
// }
</style>

<script>
jQuery(document).ready(function() {
	
	// set send to editor
	window.original_send_to_editor = window.send_to_editor;
	
	// Set Focus On Expansion Link Field on Load
	setTimeout(function(){
             jQuery("#inputExpansionLink").focus();
	}, 1);
	 
	//On Insert Button Click
	jQuery('#insertExpandContent_submit').click(function() {
			var inputExpansionLink = jQuery('#inputExpansionLink').val();
			var inputHiddenContent = jQuery('#inputHiddenContent').val(); 
			var inputUploadImage = jQuery("#upload_image").val();
			var inputHiddenContentImage = jQuery('#upload_image').val();
			var inputYouTubeVideoLink = jQuery('#youTube_video_URL').val();
			var imageCheckboxValue = jQuery('#includeMediaCheckbox').val();
			
				if ( inputExpansionLink == '' && inputHiddenContent == '' ) {
					 if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"0px",
									opacity:"0",
									overflow:"hidden"
								});
							}); 
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
					 } else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"0px",
									opacity:"0",
									overflow:"hidden"
								});
							});
					}	
						jQuery(".ecf_warning_expansionLink").stop().animate({
							height:"15px",
							opacity:"1",
							overflow:"visible"
						});
						jQuery(".ecf_warning_hiddenContent").stop().animate({
							height:"15px",
							opacity:"1",
							overflow:"visible"
						});
						return false;
				} else if ( inputExpansionLink == '' && inputHiddenContent != '' ) {
					 if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"0px",
									opacity:"0",
									overflow:"hidden"
								});
							});
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"15px",
									overflow:"visible",
									opacity:"1"
								});
							});
					 } else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"0px",
									overflow:"hidden",
									opacity:"0"
								});
							});
					}		
					jQuery(".ecf_warning_expansionLink").stop().animate({
							height:"15px",
							opacity:"1",
							overflow:"visible"
						});
					jQuery(".ecf_warning_hiddenContent").stop().animate({
							height:"0px",
							opacity:"0",
							overflow:"hidden"
						});	
					return false;
				} else if ( inputHiddenContent == '' && inputExpansionLink != '' ) {
					 if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true && inputUploadImage != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"0px",
									opacity:"0",
									overflow:"hidden"
								});
							});
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink == '' ) {
						jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
					 } else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true && inputYouTubeVideoLink != '' ) {
						jQuery('#media_box').animate({
								height: "108px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"0px",
									opacity:"0",
									overflow:"hidden"
								});
							});
					 }		
					jQuery(".ecf_warning_hiddenContent").stop().animate({
							height:"15px",
							opacity:"1",
							overflow:"visible"
						});
					jQuery(".ecf_warning_expansionLink").stop().animate({
							height:"0px",
							opacity:"0",
							overflow:"hidden"
						});
					return false;
				} else {
					jQuery(".ecf_warning").stop().animate({
							height:"0px",
							opacity:"0",
							overflow:"hidden"
					});
					if (jQuery('input#includeMediaCheckbox').prop('checked') == false ) {
						var expandCollapseContent = '<pre><div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">'+inputExpansionLink+'</a><div class="hidden-content"><p class="hiddenContentp">'+inputHiddenContent+'</p><br style="clear: both;"></div></div></pre><br />';
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="image"]').prop('checked') == true ) {
						var imageURLlength = jQuery('input[name="upload_image"]').val();
						if (imageURLlength == '') {
							jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_imageLinkURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});
							return false;
						} else {	
						var expandCollapseContent = '<pre><div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">'+inputExpansionLink+'</a><div class="hidden-content"><img src='+inputHiddenContentImage+' /><p class="hiddenContentp">'+inputHiddenContent+'</p><br style="clear: both;"></div></div></pre><br />';
						}
					} else if (jQuery('#includeMediaCheckbox').prop('checked') == true && jQuery('input[name="youtube_video"]').prop('checked') == true ) {
						var youtubeVideoURLlength = jQuery('input[name="youTube_video_URL"]').val();
						if (youtubeVideoURLlength == '') {
							jQuery('#media_box').animate({
								height: "120px"
							}, function() {
								jQuery(".ecf_warning_youtubeURL").stop().animate({
									height:"15px",
									opacity:"1",
									overflow:"visible"
								});
							});	
							return false;							
						} else {
							// str replace youtube url
							var fixedYouTubeURL = inputYouTubeVideoLink.replace("watch?v=","embed/");
							var expandCollapseContent = '<pre><div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">'+inputExpansionLink+'</a><div class="hidden-content"><code><div class="videoWrapper"><iframe src="'+fixedYouTubeURL+'" frameborder="0" allowfullscreen></iframe></div></code><br />'+inputHiddenContent+'</p><br style="clear: both;"></div></div></pre><br />';
						}
					}
					window.parent.original_send_to_editor(expandCollapseContent);
					window.parent.tb_remove();
					window.send_to_editor = window.original_send_to_editor;
				}	
	});
	
	// Expand/Collapse Demo Functionality
	jQuery(".expand-cnt-link").click(function() {
		jQuery(this).toggleClass("ecf_opened").parent(".exp-col-content-holder").find(".hidden-content").stop().slideToggle(400);
		return false;
	});		
	
	jQuery('#upload_image_button').click(function() {
		 formfield = jQuery('#upload_image').attr('name');
		 jQuery("#TB_ajaxContent").prev().fadeOut("fast");
		 jQuery("#TB_ajaxContent").fadeOut("fast");
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 jQuery("#TB_iframeContent").find(".savesend").remove();
		 return false;
	});
	
	window.send_to_editor = function(html) {
		jQuery("iframe").prev().fadeOut();
		jQuery("#TB_ajaxContent").prev().fadeIn("fast");
		jQuery("#TB_ajaxContent").fadeIn("fast");
		imgurl = jQuery('img',html).attr('src');
		jQuery('#upload_image').val(imgurl);
		return false;
	}
	
	// When open modal, focus on Expansion Link Title
	if (jQuery('#inputExpansionLink').is(":visible")) {
		jQuery(this).focus();
	}
	
	// Reset send to editor on Thicbox close and stop propogation
	jQuery('#TB_closeWindowButton > .tb-close-icon').click(function() {
		window.send_to_editor = window.original_send_to_editor;
	});
	jQuery('#TB_overlay').click(function() {
		window.send_to_editor = window.original_send_to_editor;
	});
	jQuery('#TB_window').click(function(e) {
		 e.stopPropagation();
	});
	jQuery(document).keyup(function(e) {
	  if (e.keyCode == 27) { 	window.send_to_editor = window.original_send_to_editor; }   // esc
	});

	jQuery('#includeMediaCheckbox').click(function() {	
		if(jQuery('#includeMediaCheckbox').attr('checked')) {
			jQuery("#media_box").stop().animate({
				height:"108px",
				opacity:"1"
			});
				jQuery("#media_box").removeAttr("display","block");	
			jQuery('input[name="image"]').prop("checked", true);	
			jQuery("#upload_box").fadeIn("slow").css("display","block");
		} else {
			jQuery(".ecf_warning_youtubeURL").stop().animate({
				height:"0px",
				opacity:"0",
				overflow:"hidden"
			});
			jQuery(".ecf_warning_imageLinkURL").stop().animate({
				height:"0px",
				opacity:"0",
				overflow:"hidden"
			});
			jQuery("#media_box").stop().animate({
				opacity: "0",
				height:"0px"
			});
			jQuery("#youTubeVideoBox").fadeOut();
			jQuery('input[name="image"]').prop("checked", false);
			jQuery('input[name="youtube_video"]').prop("checked", false);			
		}
	});

	jQuery('input[name="image"]').click(function() {
		jQuery('#media_box').animate({
			height: "108px"
		});
		jQuery(".ecf_warning_youtubeURL").stop().animate({
				height:"0px",
				opacity:"0",
				overflow:"hidden"
		});
		jQuery('input[name="youtube_video"]').prop("checked", false);
		jQuery("#youTubeVideoBox").fadeOut("fast");
		jQuery("#upload_box").fadeIn("slow").css("display","block");
		jQuery("#youTube_video_URL").val("");
	});	

	jQuery('input[name="youtube_video"]').click(function() {	
		jQuery('#media_box').animate({
			height: "108px"
		});
		jQuery(".ecf_warning_imageLinkURL").stop().animate({
				height:"0px",
				opacity:"0",
				overflow:"hidden"
		});
		jQuery('input[name="image"]').prop("checked", false);		
		jQuery("#upload_box").fadeOut("fast");
		jQuery("#youTubeVideoBox").fadeIn("slow").css("display","block");
		jQuery("#upload_image").val("");
	});	
	
});

</script>


<!-- content of the thickbox modal -->

<?php
	echo '<a class="bannerLink" href="http://www.evan-herman.com" target="_blank"><img class="bannerImage" src="../wp-content/plugins/expandcollapse-funk/Expand-Collapse-Banner.jpg" alt="Expand/Collapse Funk Banner" /></a>';

	//Expansion Link Title + Input Box
	echo '<h3>Expansion Link</h3><input id="inputExpansionLink" name="inputExpansionLink" type="text" placeholder="Expansion Link"><p class="ecf_warning ecf_warning_expansionLink">* this field is required</p><p class="description">this is the link you will click to reveal the hidden content</p>';
	//Hidden Content Title + Input Box
	echo '<h3>Hidden Content</h3><textarea id="inputHiddenContent" type="text" placeholder="Hidden Content"></textarea><p class="ecf_warning ecf_warning_hiddenContent">* this field is required</p><p class="description">this is all of your hidden content. clicking the link set above will reveal this section. HTML markup accepted.</p>';
	
	

	//Hidden Content Image + Upload Box
	// Include Image Checkbox
	echo '<h3>Hidden Content Media</h3>
				<span id="mediaCheckboxHolder">
					<input type="checkbox" id="includeMediaCheckbox" name="includeMediaCheckbox" value="includeMediaCheckbox"> Include Media</span> <br>
						<div id="media_box">
						<input type="radio" name="image" value="image">Image <input type="radio" name="youtube_video" value="youtube_video">YouTube Video
							<p class="description media_box_description">Select which type of media you would like to upload</p>
							<span id="upload_box"><input id="upload_image" type="text" placeholder="Direct URL to image or upload a new one"  size="36" name="upload_image" /><input id="upload_image_button" type="button" value="Upload Image" /><br />
								<p class="ecf_warning ecf_warning_imageLinkURL">* this field is required</p>
								<p class="description">once inserted you can then position your image using floats. you may also input a direct URL to an image.</p></span>
							<span id="youTubeVideoBox"><input id="youTube_video_URL" placeholder="http://www.youtube.com/videoid" type="text" size="36" name="youTube_video_URL" /> <br />
								<p class="ecf_warning ecf_warning_youtubeURL">* this field is required</p>
								<p class="description">include a direct URL link to a <a href="http://www.yotube.com" target="_blank">YouTube</a> video.</p></span>
						</div>';
	echo '<input type="submit" name="submit" id="insertExpandContent_submit" class="button button-primary" value="Insert Expand/Collapse Content"  />';
	
	echo '<h3>Rate & Donate</h3><p class="description">Developing plugins is hard work and very time consuming. If you benefit from the use of this plugin, a small contribution is very much appreciated. If you are unable to make a donation, a 5 star review in the <a href="http://wordpress.org/plugins/expandcollapse-funk/" target="_blank">plugin repository</a> is just as rewarding to me.</p>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="evan.m.herman@gmail.com">
						<input type="hidden" name="lc" value="US">
						<input type="hidden" name="item_name" value="Expand+Collapse Funk Plugin Donation">
						<input type="hidden" name="no_note" value="0">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>';
	
	/* Expand/Collapse Demo Section */
	
	/* Plain Text 
	echo '<h3>Expand/Collapse Demo</h3>';
	echo '<div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">Expand/Collapse Plain Text</a><div class="hidden-content">This is all of your hidden content. Anything in this section will be hidden by default. Clicking the expansion link will display all of the hidden content.</div></div>';

	echo '<div class="exp-col-content-holder"><a class="expand-cnt-link" href="#">Expand/Collapse Text+Images</a><div class="hidden-content"><img src="../wp-content/plugins/expand-collapse-funk/toggle_expand.png" alt="Expand/Collapse Demo Image" /> This is all of your hidden content. Anything in this section will be hidden by default. Clicking the expansion link will display all of the hidden content.</div></div>';
	*/
	echo '<span class="pluginByContent"><p class="description">Plugin Created By <a target="_blank" href="http://www.evan-herman.com">Evan Herman</a></p></span>';
?>
