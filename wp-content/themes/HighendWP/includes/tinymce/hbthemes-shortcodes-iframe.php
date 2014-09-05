<?php
/* FindWPConfig - searching for a root of wp */
function FindWPConfig($directory){
	global $confroot;
	foreach(glob($directory."/*") as $f){
		if (basename($f) == 'wp-config.php' ){
			$confroot = str_replace("\\", "/", dirname($f));
			return true;
		}
		if (is_dir($f)){
		$newdir = dirname(dirname($f));
		}
	}
	if (isset($newdir) && $newdir != $directory){
		if (FindWPConfig($newdir)){
			return false;
		}	
	}
	return false;
}
if (!isset($table_prefix)){
	global $confroot;
	FindWPConfig(dirname(dirname(__FILE__)));
	include_once $confroot."/wp-load.php";

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php _e('Highend Shortcode Generator' , 'hbthemes'); ?></title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo get_site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<style type="text/css" src="<?php echo get_site_url(); ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css"></style>
<link rel="stylesheet" href="css/shortcode_tinymce.css" />

<script>
 jQuery(document).ready(function($){
	 
	//select shortcode
	$("#shortcode-select").change(function () {
		  var shortcodeSelectVal = "";
		  var shortcodeSelectText = "";
		  $("#shortcode-select option:selected").each(function () {
				shortcodeSelectVal += $(this).val();
				shortcodeSelectText += $(this).text();
			  });
			  if( shortcodeSelectVal != 'default') {
				$('#selected-shortcode').load('shortcodes/'+shortcodeSelectVal+'.php', function(){
					$('.shortcode-editor-title').text(shortcodeSelectText);
				});
			  } else {
			  	$('#selected-shortcode').text("<?php _e('Select a shortcode from the list above and the options will appear here. Shortcodes are sorted alphabetically. Shortcodes has to be in columns, except some specific. For more info check out Highend Documentation section regarding Shortcodes.', 'hbthemes'); ?> ").addClass('padding-bottom aligncenter');
				$('.shortcode-editor-title').text('Shortcode Details');
			  }
		})
		.trigger('change');
	
 });
</script>
    
</head>
<body>

<div id="hbthemes-shortcodes-popup">

	<h2 id="shortcode-selector-title"><?php _e('Select a Shortcode', 'hbthemes'); ?></h2>

	<div id="select-shortcode">
    	<div id="select-shortcode-inner">
    
		<form action="/" method="get" accept-charset="utf-8">
			<div>
				<select name="shortcode-select" id="shortcode-select" size="1">
               		<option value="default" selected="selected">Shortcodes</option>
					<option value="accordion">Accordion</option>
					<option value="align-center">Align Center</option>
					<option value="blog-carousel">Blog Carousel</option>
					<option value="button">Button</option>
					<option value="callout-box">Callout Box</option>
					<option value="circle-chart">Circle Chart</option>
					<option value="client-logo-carousel">Client Logo Carousel</option>
					<option value="clear">Clear</option>
					<option value="columns">Columns</option>
					<option value="content-box">Content Box</option>
					<option value="countdown">Countdown</option>
					<option value="dropcap">Dropcap</option>
					<option value="faq-module">FAQ Module</option>
					<option value="fullwidth-section">Full Width Section</option>
					<option value="fullwidth-google-map">Fullwidth Google Map</option>
					<option value="gallery-carousel">Gallery Carousel</option>
					<option value="gallery-module">Gallery Module</option>
					<option value="google-map">Google Map</option>
					<option value="icon-box">Icon Box</option>
					<option value="icon-feature">Icon Feature</option>
					<option value="icon-column">Icon Column</option>
					<option value="icon">Icon</option>
					<option value="image-banner">Image Banner</option>
					<option value="image-frame">Image Frame</option>
					<option value="info-message">Info Message</option>
					<option value="laptop-slider">Laptop Slider</option>
					<option value="list">List</option>
					<option value="milestone-counter">Milestone Counter</option>
					<option value="modal-window">Modal Window</option>
					<option value="one-page-section">One Page Section</option>
					<option value="portfolio-carousel">Portfolio Carousel</option>
					<option value="portfolio-module">Portfolio Module</option>
					<option value="pricing-table">Pricing Table</option>
					<option value="process-steps">Process Steps</option>
					<option value="skill-bar">Skill Bar</option>
					<option value="separator">Separator</option>
					<option value="spacer">Spacer</option>
					<option value="simple-slider">Simple Slider</option>
					<option value="sitemap">Sitemap</option>
					<option value="social-icons">Social Icons</option>
					<option value="team-member-box">Team Member Box</option>
					<option value="team-members-carousel">Team Members Carousel</option>
					<option value="teaser-box">Teaser Box</option>
					<option value="testimonial-box">Testimonial Box</option>
					<option value="testimonial-slider">Testimonial Slider</option>
					<option value="text-highlight">Text Highlight</option>
					<option value="title">Title</option>
					<option value="toggle">Toggle</option>
					<option value="tooltip">Tooltip</option>
					<option value="video-embed">Video Embed</option>
				</select>
			</div>
		</form>
        </div>
        <!-- /select-shortcode-inner -->
	</div>
    <!-- /select-shortcode-wrap -->
    
    <h2 class="shortcode-editor-title"></h2>
	<div id="shortcode-editor">
    	<div id="shortcode-editor-inner" class="clearfix">
			<div id="selected-shortcode"></div>
		</div>
        <!-- /shortcode-dialog-inner -->
	</div>
    <!-- /shortcode-dialog -->
    
    
</div>
<!-- /hbthemes-shortcodes-popup -->

</body>
</html>