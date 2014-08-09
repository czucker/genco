<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>
<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
	<div class="container">
	<?php 
		$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
		$sidebar_name = hb_options('hb_choose_sidebar');
	?>
		<div class="row <?php echo $sidebar_layout; ?> main-row">

		<?php if ( have_posts() ) : ?>
			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<!-- BEGIN .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
			<?php } else { ?>
				<div class="col-12 hb-main-content">
			<?php } ?>
			
			<!-- BEGIN .related-members -->
			<div class="row related-members" id="team-wrapper">

		
				<?php while ( have_posts() ) : the_post(); 
					$thumb = get_post_thumbnail_id(); 
					$image = hb_resize( $thumb, '', 270, 270, true );
					if ( $image ) { ?>
						<div class="col-4">
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
				

				<div class="col-12 no-b-margin">
					
					<!--
					<a class="load-more-posts" href="#">
						<span class="load-more-text" data-more="+ Load More Posts" data-less="No More Posts">+ Load More Posts</span>
						<span class="hb-spin non-visible"><i class="hb-moon-spinner-5"></i></span>
					</a>
					-->

					<?php hb_pagination_standard(); ?>

				</div>

			</div>
			<!-- END .related-members -->


			</div>
			<!-- END .hb-main-content -->

			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
			<!-- BEGIN .hb-sidebar -->
			<div class="col-3  hb-equal-col-height hb-sidebar">
				<?php 
				if ( $sidebar_name && function_exists('dynamic_sidebar') )
					dynamic_sidebar($sidebar_name);
				?>
			</div>
			<!-- END .hb-sidebar -->
			<?php } ?>

			</div>
		
		<?php endif; ?>
		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->


<?php get_footer(); ?>