<?php
function hb_testimonial_box ( $post_id ) {
	$testimonial_post = get_post($post_id);
	if ( $testimonial_post ) {
		setup_postdata($testimonial_post);
	?>
	<div class="hb-testimonial">
		<?php the_content(); ?>
	</div>
						
	<?php
		$author_image = vp_metabox('testimonial_type_settings.hb_testimonial_author_image');
		$author_name = vp_metabox('testimonial_type_settings.hb_testimonial_author');
		$author_desc = vp_metabox('testimonial_type_settings.hb_testimonial_description');
		$author_desc_link = vp_metabox('testimonial_type_settings.hb_testimonial_description_link');

		if ( $author_image ) { 
			$author_image = hb_resize(null, $author_image, 60, 60, true ); ?>
			<img src="<?php echo $author_image['url']; ?>" width="60" height="60" class="testimonial-author-img"/>
		<?php } ?>

		<?php if ( $author_name || $author_desc ) { ?>
			<div class="testimonial-author">
				<?php if ( $author_name ) { ?>
					<h5 class="testimonial-author-name">
						<?php echo $author_name; ?>
					</h5>
				<?php } ?>

				<?php if ( $author_desc && $author_desc_link ) { ?>
					<a href="<?php echo $author_desc_link; ?>" class="testimonial-company"><?php echo $author_desc; ?></a>
				<?php } else if ( $author_desc ) { ?>
					<a class="testimonial-company"><?php echo $author_desc; ?></a>
				<?php } ?>
			</div>
		<?php } 
		wp_reset_postdata();
	}
}
?>