<?php 
$gallery_images = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
$api_images = "";
$api_titles = "";
$api_descriptions = "";

global $blog_grid_column_class;
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?>
<!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php if ( !empty($gallery_images) ) post_class('with-featured-image slider-post-type ' . $blog_grid_column_class ); else post_class('slider-post-type ' . $blog_grid_column_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<?php if ( !empty($gallery_images) ) { ?>
<!-- BEGIN .featured-image -->
<div class="featured-image">
	<div class="hb-flexslider clearfix" id="flexslider_<?php the_ID(); ?>">
		<ul class="hb-flex-slides clearfix">
			<?php foreach ( $gallery_images as $id=>$gallery_image ) { 
				$image = hb_resize( $id, '', 900, 500, true );
				$api_images .= "'" . addslashes ($gallery_image['url']) . "',";
				$api_titles .= "'" . addslashes ($gallery_image['title']) . "',";
				$api_descriptions .= "'" . addslashes ($gallery_image['description']) . "',";
			?>
			<li><a href="#" class="prettyphoto"><img alt="<?php echo $gallery_image['title']; ?>" src="<?php echo $image['url']; ?>" /></a></li>
			<?php } 
			$api_images = trim($api_images, ",");
			$api_titles = trim($api_titles, ",");
			$api_descriptions = trim($api_descriptions,",");
			?>
		</ul>
	</div>
	<script type="text/javascript">
        jQuery(document).ready(function() {
                jQuery("#flexslider_<?php the_ID(); ?>").flexslider({
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

				jQuery("#flexslider_<?php the_ID(); ?>").imagesLoaded(function(){
					if ( jQuery('.masonry-holder').length ){
						setTimeout(function(){
							jQuery('.masonry-holder').isotope();
						}, 1000);

						setTimeout(function(){
							jQuery('.masonry-holder').isotope();
						}, 2000)
					}
				});
				
				//PrettyPhoto
				jQuery("body").on("click", ".prettyphoto", function(){
					api_images = [<?php echo $api_images; ?>];
					api_titles = [<?php echo $api_titles; ?>];
					api_descriptions = [<?php echo $api_descriptions; ?>]
					jQuery.prettyPhoto.open(api_images,api_titles,api_descriptions);
				});
        });
	</script>
</div>
<?php 
} ?>
<?php get_template_part('includes/grid-blog/post', 'description'); ?>
</article>
<!-- END .hentry -->