<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$main_content_style = "";
	if ( vp_metabox('background_settings.hb_content_background_color') )
		$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';

	$header_layout = vp_metabox('portfolio_layout_settings.hb_portfolio_header_layout');
	if ( $header_layout == 'default' )
		$header_layout = hb_options('hb_portfolio_content_layout');

	?> 
	<!-- BEGIN #main-content -->
	<div id="main-content"<?php echo $main_content_style; ?>>
		
		<!-- BEGIN .container -->
		<div class="container">

			<?php 
				$sidebar_layout = vp_metabox('portfolio_layout_settings.hb_portfolio_content_layout'); 
				$sidebar_position = "";

				if ( $sidebar_layout == "default" ) {
					$sidebar_layout = hb_options('hb_portfolio_layout'); 
					if ( $sidebar_layout != 'fullwidth')
						$sidebar_position = hb_options('hb_portfolio_sidebar_side');
				} else if ( $sidebar_layout != 'fullwidth' ) {
					$sidebar_position = vp_metabox('portfolio_layout_settings.hb_portfolio_sidebar_position');
					if ( $sidebar_position == "default" )
						$sidebar_position = hb_options('hb_portfolio_sidebar_side');
				}

			?>
			<!-- BEGIN .row -->
			<div class="row main-row <?php echo $sidebar_position; ?>">

				<!-- BEGIN Fullwidth Main-content -->
				<div class="col-12 hb-main-content">
					
					<?php
					if ( $header_layout == "fullwidth" )  {
						?>
						<div class="row">
							<div class="col-12 fw-portfolio-head">
								<?php get_template_part('includes/portfolio','featured-content'); ?>
							</div>
						</div>
						<?php
					}
					?>
					<div class="row">

					<?php
					$sidebar_class = "portfolio-single-entry ";
					if ( $sidebar_position != "" && $sidebar_layout == "wpsidebar" )
						$sidebar_class = "hb-main-content ";
					?>
					<!-- BEGIN .portfolio-single-entry -->
					<?php if ( $sidebar_position == "left-sidebar") { ?>
					<div class="<?php echo $sidebar_class; ?>col-9 float-right">
					<?php } else if ( $sidebar_position == "right-sidebar" ) { ?>
					<div class="<?php echo $sidebar_class; ?>col-9">
					<?php } else { ?>
					<div class="<?php echo $sidebar_class; ?>col-12">
					<?php } ?>

						<?php
						if ( $header_layout == "split" ) {
						?>
						<div class="row">
						<div class="col-9">
						<?php get_template_part('includes/portfolio','featured-content'); ?>
						</div>
						<div class="col-3">
						<?php the_content(); ?>
						</div>
						</div>
						<?php } else { ?>
						<?php the_content(); ?>
						<?php } ?>
						<?php if ( comments_open() ) comments_template(); ?>

					</div>
					<!-- END .portfolio-single-entry -->

					<?php if ( $sidebar_position != "") { ?>
						<?php 
							if ( $sidebar_layout == 'wpsidebar' ) {
								$sidebar_name = vp_metabox('portfolio_layout_settings.hb_choose_sidebar');
								if ( $sidebar_name && function_exists('dynamic_sidebar') )
								{
									?>
									<div class="col-3 hb-equal-col-height hb-sidebar">
									<?php dynamic_sidebar($sidebar_name); ?>
									</div>
									<?php
								}
							} else if ( $sidebar_layout == 'metasidebar' ) {
								?>
								<div class="portfolio-single-meta col-3">
								<?php
								$sidebar_meta_details = vp_metabox('portfolio_layout_settings.hb_meta_details');
								if ( sizeof($sidebar_meta_details) > 1 || ( sizeof($sidebar_meta_details) == 1 && $sidebar_meta_details[0]['hb_meta_sidebar_detail']!= "" && $sidebar_meta_details[0]['hb_meta_sidebar_detail_content'] != "" )) { 
								?>
								<ul class="meta-list">
								<?php foreach ($sidebar_meta_details as $detail) { ?>
									<li><?php echo $detail['hb_meta_sidebar_detail']; ?>: <?php echo $detail['hb_meta_sidebar_detail_content']; ?></li>
								<?php	}
								?>
								</ul>
								<?php } ?>

								<?php if ( vp_metabox('portfolio_settings.hb_portfolio_button') ) { ?>
									<a href="<?php echo vp_metabox('portfolio_settings.hb_portfolio_button_link'); ?>" class="hb-button hb-small-button" <?php if ( vp_metabox('portfolio_settings.hb_portfolio_button_target') ) echo ' target="_blank"'; ?>>
										<?php echo vp_metabox('portfolio_settings.hb_portfolio_button_title'); ?>
									</a>
								<?php } ?>

								<?php if ( hb_options('hb_portfolio_enable_share') || hb_options('hb_portfolio_enable_likes') ) { ?>
								<div class="portfolio-single-shares clearfix">

									<?php if ( hb_options('hb_portfolio_enable_likes') ) { ?>
										<!-- BEGIN .float-left -->
										<div class="float-left">
										<?php echo hb_print_likes ( get_the_ID() ); ?>
										<!--<div class="like-holder like-button" id="like-60" title="Like this project!" >
											<i class="hb-moon-heart"></i>1,235</div><!-->
										</div>
										<!-- END .float-left -->
									<?php } ?>


									<?php if ( hb_options('hb_portfolio_enable_share') ) { ?>
									<!-- BEGIN .float-right -->	
									<div class="float-right">
										<?php get_template_part ( 'includes/hb' , 'share' ); ?>
									</div>
									<!-- END .float-right -->
									<?php } ?>

								</div>
								<!-- END .single-shares -->
								<?php
								}
								?>
								</div>
								<?php 								
							}
						?>
					<?php } ?>
				</div>
				<!-- END .row -->
				<?php if ( $sidebar_layout != "wpsidebar" ) { ?>
				<div class="spacer"></div>
				<?php } ?>
				<?php get_template_part('includes/portfolio','related-items'); ?>

				</div>
				<!-- END .hb-main-content -->
			
			</div>
			<!-- END .row -->

		</div>
		<!-- END .container -->

	</div>
	<!-- END #main-content -->

<?php endwhile; endif; ?>
<?php get_footer(); ?>