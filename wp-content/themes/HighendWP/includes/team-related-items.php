<?php
if ( !hb_options('hb_staff_enable_related_posts') ) return;
$current_item_cats = wp_get_object_terms( get_the_ID(), 'team_categories', array('fields' => 'slugs') );
$related_items = new WP_Query(
	array(
		'posts_per_page' => 4,
		'post_type' => 'team',
		'orderby' => 'rand',
		'post__not_in' => array(get_the_ID()),
		'tax_query' => array(
			array(
				'taxonomy' => 'team_categories',
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
			<h4 class="hb-heading hb-center-heading alt-color-1"><span><?php _e('Meet More Team Members','hbthemes'); ?></span></h4>
		</div>
	</div>

	<!-- BEGIN .related-portfolio-items -->
	<div class="row related-members">
	<?php while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
		<?php
		$thumb = get_post_thumbnail_id(); 
		$image = hb_resize( $thumb, '', 270, 270, true );
		if ( $image ) { ?>
			<div class="col-3">
				<div class="team-member-box">
			
					<div class="team-member-img">
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>"></a>
					</div>
							
					<!-- START .team-member-description -->
					<div class="team-member-description">
								
						<!-- START .team-header-info -->
						<div class="team-header-info clearfix">
									
							<!-- START .team-header-name -->
							<div class="team-name">
								<h4 class="team-member-name"><?php the_title(); ?></h4>
								<?php if ( vp_metabox('team_member_settings.hb_employee_position') ) { ?>
								<p class="team-position"><?php echo vp_metabox('team_member_settings.hb_employee_position'); ?></p>
								<?php } ?>
							</div>
							<!-- END .team-name -->
									
									
						</div>
						<!-- END .team-header-info -->
								

						<a href="<?php the_permalink(); ?>" class="simple-read-more"><?php _e('View Profile','hbthemes'); ?></a>
								
					</div>
					<!-- END .team-member-description -->
							
				</div>
				<!-- END .team-member-box -->
			</div>
			<!-- END .col-3 -->

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