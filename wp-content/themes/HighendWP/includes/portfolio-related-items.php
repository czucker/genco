<?php
if ( !hb_options('hb_portfolio_enable_related_posts') ) return;
$current_item_cats = wp_get_object_terms( get_the_ID(), 'portfolio_categories', array('fields' => 'slugs') );
$related_items = new WP_Query(
	array(
		'posts_per_page' => 4,
		'post_type' => 'portfolio',
		'orderby' => 'rand',
		'post__not_in' => array(get_the_ID()),
		'tax_query' => array(
			array(
				'taxonomy' => 'portfolio_categories',
				'field' => 'slug',
				'terms' => $current_item_cats
			),
		),
	)
);

if ( $related_items-> have_posts() ) :
?>
<!-- BEGIN .portfolio-related-fw -->
<div class="fw-section with-border portfolio-related-fw">
	<div class="row">
		<div class="col-12">
			<h4 class="hb-heading hb-center-heading alt-color-1"><span><?php _e('Related Projects','hbthemes'); ?></span></h4>
		</div>
	</div>

	<!-- BEGIN .related-portfolio-items -->
	<div class="row related-portfolio-items columns-4">
	<?php while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
		<?php
		$thumb = get_post_thumbnail_id(); 
		$image = hb_resize( $thumb, '', 289, 216, true );
		if ( $image ) {
		?>
			<!-- BEGIN .portfolio-related-item -->
			<div class="portfolio-related-item">
				<div class="standard-gallery-item">
					<div class="hb-gal-standard-img-wrapper">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo $image['url']; ?>">
							<div class="item-overlay"></div>
							<div class="item-overlay-text">
								<div class="item-overlay-text-wrap">
									<h4><span class="hb-gallery-item-name"><?php the_title(); ?></span></h4>
									<div class="hb-small-separator"></div>
								</div>
							</div>
						</a>

					</div>
			
				</div>
			</div>
			<!-- END .portfolio-related-item -->
		<?php } ?>
	<?php endwhile; ?>
	</div>
	<!-- END .related-portfolio-items -->
</div>
<!-- END .portfolio-related-fw -->
<?php
endif;
wp_reset_query();
?>