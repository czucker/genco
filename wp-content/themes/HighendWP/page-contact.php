<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Contact Template
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

<?php
	$box_animation_class = "";
	if ( vp_metabox('contact_page_settings.hb_contact_box_enable_animation') )
		$box_animation_class = " hb-animate-element " . vp_metabox('contact_page_settings.hb_contact_box_animation');
	$box_title = vp_metabox('contact_page_settings.hb_contact_title');
	$box_content = vp_metabox('contact_page_settings.hb_contact_content');
	$box_details = vp_metabox('contact_page_settings.hb_contact_details');
	$form_title = vp_metabox('contact_page_settings.hb_contact_form_title');

	$box_details_empty = !empty($box_details);
	if ( sizeof( $box_details ) == 1 && $box_details[0]['hb_contact_detail_content'] == "" && $box_details[0]['hb_contact_detail_icon'] == "" )
		$box_details_empty = false;
?>

<?php 
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
	$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?> 
	<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>	
	<div class="fw-map-wrapper">

		<?php if ( vp_metabox('contact_page_settings.hb_contact_background') == 'map' ) { ?>
		<div class="fw-map">
			<div class="hb-gmap-map" data-show-location="-1" data-map-level="<?php echo hb_options('hb_map_zoom'); ?>" data-map-lat="<?php echo hb_options('hb_map_1_latitude'); ?>" data-pan-control="false" data-zoom-control="false" data-map-lng="<?php echo hb_options('hb_map_1_longitude'); ?>" data-map-img="<?php echo hb_options('hb_custom_marker_image'); ?>" data-overlay-color="<?php if ( hb_options('hb_enable_map_color') ) { echo hb_options('hb_map_focus_color'); } else { echo 'none'; } ?>"></div>
		</div>
		<?php } else if ( vp_metabox('contact_page_settings.hb_contact_background') == 'image' ) { ?>
		<div class="fw-map parallax" style="background-image: url('<?php echo vp_metabox('contact_page_settings.hb_contact_background_image'); ?>');"></div>
		<?php }?>

		<div class="container">
			
			<!-- BEGIN .map-info-section -->
			<div class="map-info-section clearfix<?php echo $box_animation_class; ?>">
				<a href="#" class="minimize-section"><i class="hb-moon-contract-3"></i></a>

				<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('.minimize-section').click(function(e){
						e.preventDefault();
						jQuery('.map-info-section').toggleClass('minimized');
					});
				});
				</script>

				<?php if ( $box_title ) { ?>
					<h5 class="hb-heading alt-color-1"><span><?php echo $box_title; ?></span></h5>
				<?php } ?>
				<div class="row nbm">


				<?php if ( $box_content && $box_details_empty ) { ?>
					<div class="col-6 nbm">
				<?php } else if ( $box_content ) { ?> 
					<div class="col-12 nbm">
				<?php } ?>
						<p><?php echo $box_content; ?></p>
				<?php if ( $box_content ) { ?>
					</div>
				<?php } ?>

				<?php if ( $box_content && $box_details_empty ) { ?>
					<div class="col-6 nbm">
				<?php } else if ( $box_details_empty ) { ?> 
					<div class="col-12 nbm">
				<?php } ?>
					<ul class="hb-ul-list">
						<?php foreach($box_details as $box_detail) { ?>
							<li>
								<?php if ( $box_detail['hb_contact_detail_icon'] ) { ?>
									<i class="<?php echo $box_detail['hb_contact_detail_icon']; ?>"></i>
								<?php } ?>
								<span><?php echo $box_detail['hb_contact_detail_content']; ?></span></li>
						<?php } ?>
					</ul>
				<?php if ( $box_details_empty ) { ?>
					</div>
				<?php } ?>

				</div>

				<?php if ( $form_title ) { ?>
				<h5 class="hb-heading alt-color-1"><span><?php echo $form_title; ?></span></h5>
				<?php } ?>

				<form class="special-contact-form clearfix" id="sp-contact-form">
					<p><input type="text" name="special-contact-name" id="sp-contact-name" placeholder="<?php _e('Name','hbthemes'); ?>" class="required requiredField" tabindex="65"/></p>
					<p><input type="email" class="required requiredField" name="special-contact-email" id="sp-contact-email" placeholder="<?php _e('Email','hbthemes'); ?>" tabindex="66"/></p>
					<p><input type="text" placeholder="<?php _e('Subject','hbthemes'); ?>" name="hb_contact_subject" id="hb_contact_subject_id"/></p>
					<p><textarea class="required requiredField" name="special-contact-message" id="sp-contact-message" tabindex="67" placeholder="<?php _e('Your message...','hbthemes'); ?>"></textarea></p>
					<a href="#" id="special-submit-form" class="hb-button hb-third-dark"><?php _e('Send','hbthemes'); ?></a>
					<input type="hidden" id="success_text_special" value="<?php _e('Message Sent', 'hbthemes'); ?>"/>
				</form>

			</div>
			<!-- END .map-info-section -->
				
		</div>
		<!-- END .container -->

	</div>
	
</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>
<?php get_footer(); ?>