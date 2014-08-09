<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

$section_type = vp_metabox('portfolio_settings.hb_featured_section_type');
$video_link = vp_metabox ('portfolio_settings.hb_portfolio_video');
$rev_slider = vp_metabox ('portfolio_settings.hb_portfolio_rev_sliders');
$alternative_image = vp_metabox('portfolio_settings.hb_portfolio_alternative_image');
$full_image = "";
$thumb = get_post_thumbnail_id(); 
if ( $thumb ) { 
  $full_image = wp_get_attachment_image_src ( $thumb, 'full' );
}

if ( $section_type == "featured_image" && $full_image ) {
?>
  <img class='fw-image' src="<?php echo $full_image[0]; ?>" alt="Featured Image"/>
<?php
} else if ( $section_type == "alternative_image" && $alternative_image ) {
  echo "<img class='fw-image' src=\"" . $alternative_image . "\" alt='Featured Image'/>";
} else if ( $section_type == "video" && $video_link ) {
  echo '<div class="fitVids">' . wp_oembed_get( $video_link ) . '</div>';
} else if ( $section_type == "revslider" && $rev_slider ) {
  print do_shortcode('[rev_slider ' . $rev_slider . ']');
} else if ( $section_type == "flexslider" ) {
  $gallery_attachments = rwmb_meta('hb_portfolio_flexslider_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
  if ( !empty($gallery_attachments) ) {
    $unique_id = rand(1,10000);
?>
  <!-- BEGIN .flex-slider --> 
  <div class="hb-flexslider-wrapper fw-flex-slider">
    <div class="hb-flexslider clearfix loading" id="flexslider_<?php echo $unique_id; ?>">
      <ul class="hb-flex-slides clearfix">
        <?php foreach ($gallery_attachments as $gal_att ) { ?>
          <li><a data-title="<?php echo $gal_att['description']; ?>"><img alt="<?php echo $gal_att['description']; ?>" src="<?php echo $gal_att['url']; ?>" /></a></li>
        <?php } ?>
      </ul>
    </div>

    <script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery("#flexslider_<?php echo $unique_id; ?>").fitVids().flexslider({
          selector: ".hb-flex-slides > li",
          slideshow: true,
          animation: "slide",              //String: Select your animation type, "fade" or "slide"
          smoothHeight: true,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
          slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
          animationSpeed: 500,            //Integer: Set the speed of animations, in milliseconds
          pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
          controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
          directionNav:true,
          prevText: "",           //String: Set the text for the "previous" directionNav item
          nextText: ""               //String: Set the text for the "next" directionNav item
          });
        });
    </script>
  </div>
<?php
  }
}
?>