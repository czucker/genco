<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>

<?php
$is_shop = false;

if ( function_exists('is_woocommerce') && is_woocommerce() ) {
	if ( function_exists('is_shop') && is_shop() ){
		if ( function_exists('woocommerce_get_page_id') ) {
			$post_id = woocommerce_get_page_id( 'shop' );
			$is_shop = true;
		}
	}
}
?>

<!-- BEGIN #slider-section -->
<div id="slider-section" class="clearfix">
	<?php if (is_singular('portfolio')) { 

		$header_layout = vp_metabox('portfolio_layout_settings.hb_portfolio_header_layout');
		if ( $header_layout == 'default' )
			$header_layout = hb_options('hb_portfolio_content_layout');

		if ( $header_layout == 'totalfullwidth' ) {
			get_template_part('includes/portfolio','featured-content');
		}

	} else if ( is_page() || is_singular('team') || $is_shop ) {

		if ( $is_shop ){
			$section_type = vp_metabox('featured_section.hb_featured_section_options', null, $post_id);
			$thumb = get_post_thumbnail_id($post_id); 
			$rev_slider = vp_metabox('featured_section.hb_rev_slider', null, $post_id);
			$layer_slider = vp_metabox('featured_section.hb_layer_slider', null, $post_id);
			$video_link = vp_metabox('featured_section.hb_page_video', null, $post_id);
		} else {
			$section_type = vp_metabox('featured_section.hb_featured_section_options');
			$thumb = get_post_thumbnail_id(); 
			$rev_slider = vp_metabox('featured_section.hb_rev_slider');
			$layer_slider = vp_metabox('featured_section.hb_layer_slider');
			$video_link = vp_metabox('featured_section.hb_page_video');
		}

		if ( $rev_slider != "" && $section_type == "revolution" )
			print do_shortcode('[rev_slider ' . $rev_slider . ']');
		else if ( $layer_slider != "" && $section_type == "layer" ) 
			print do_shortcode('[layerslider id="'.$layer_slider.'"]');	
		else if ( $video_link && $section_type == "video" ) {
			?>
				<div class="fitVids"><?php echo wp_oembed_get($video_link); ?></div>
			<?php 
		}
		else if ( $thumb && $section_type == "featured_image" ) { 
			$full_image = wp_get_attachment_image_src ( $thumb, 'full' );
			?>
			<img class="fw-image" src="<?php echo $full_image[0]; ?>"/>
			<?php 
		}
	}
	?>
</div>
<!-- END #slider-section -->