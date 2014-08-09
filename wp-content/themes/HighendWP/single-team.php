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
	?> 
	<!-- BEGIN #main-content -->
	<div id="main-content"<?php echo $main_content_style; ?>>	

		<!-- BEGIN .container -->
		<div class="container">

			<?php 
				$sidebar_layout = vp_metabox('team_layout_settings.hb_portfolio_content_layout'); 
				$sidebar_position = "";

				if ( $sidebar_layout == "default" ) {
					$sidebar_layout = hb_options('hb_staff_layout'); 
					if ( $sidebar_layout != 'fullwidth')
						$sidebar_position = hb_options('hb_staff_sidebar_side');
				} else if ( $sidebar_layout != 'fullwidth' ) {
					$sidebar_position = vp_metabox('team_layout_settings.hb_portfolio_sidebar_position');
					if ( $sidebar_position == "default" )
						$sidebar_position = hb_options('hb_staff_sidebar_side');
				}

				if ( isset($_GET['sidebar_layout']) && $_GET['sidebar_layout'] == 'right' ){
					$sidebar_position = 'right-sidebar';
				}

			?>
			<!-- BEGIN .row -->
			<div class="row main-row <?php echo $sidebar_position; ?>">

			<?php if ( $sidebar_layout == "wpsidebar" ) { ?>
				<!-- BEGIN .hb-main-content -->
				<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
				<?php } else { ?>
				<div class="col-12 hb-main-content">
				<?php } ?>
			<?php } else if ( $sidebar_layout == "metasidebar") { ?>
				<div class="hb-main-content">

				<?php if ( $sidebar_position == "left-sidebar" ) { ?>
				<div class="row team-meta-left">
					<div class="team-single-content col-9 float-right">
				<?php } else if ( $sidebar_position == "right-sidebar")  { ?>
				<div class="row team-meta-right">
					<div class="team-single-content col-9">
				<?php } else { ?>
				<div class="row">
					<div class="team-single-content col-12">
				<?php } ?>

			<?php } else { ?>
				<div class="hb-main-content">
			<?php } ?>

					<?php 
						$thumb = get_post_thumbnail_id(); 
						$image = hb_resize( $thumb, '', 250, 250, true );
						if ( $image && $sidebar_layout != "metasidebar" ) { 
					?>
					<div class="float-left hb-team-member-img">
						<img src="<?php echo $image['url']; ?>">
					</div>
					<?php } ?>

						<?php the_content(); ?>

					</div>
					<!-- END .portfolio-single-entry -->


					<?php if ( $sidebar_position != "") { ?>
					<?php if ( $sidebar_layout == "wpsidebar" ) { ?>
					<div class="col-3 hb-equal-col-height hb-sidebar">
					<?php } else if ( $sidebar_layout == "metasidebar" && ($sidebar_position == "left-sidebar" || $sidebar_position == "right-sidebar" ) ) { ?>
					<!-- BEGIN .team-meta-sidebar -->
					<div class="col-3 team-meta-sidebar">
					<?php } ?>

						<?php 
							if ( $sidebar_layout == 'wpsidebar' ) {
								$sidebar_name = vp_metabox('team_layout_settings.hb_choose_sidebar');
								if ( $sidebar_name && function_exists('dynamic_sidebar') )
									dynamic_sidebar($sidebar_name);
							} else if ( $sidebar_layout == 'metasidebar' && ($sidebar_position == "left-sidebar" || $sidebar_position == "right-sidebar" ) ) { ?>

								<div class="team-member-img float-left">
									<img src="<?php echo $image['url']; ?>">
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
								</div>
								<!-- END .team-member-description -->

								<?php if ( vp_metabox('team_layout_settings.hb_meta_sidebar_title') ) { ?>
									<h5 class="hb-heading alt-color-1"><span><?php echo vp_metabox('team_layout_settings.hb_meta_sidebar_title'); ?></span></h5>
								<?php } ?>

								<?php 
								$sidebar_meta_details = vp_metabox('team_layout_settings.hb_meta_details');
								if ( sizeof($sidebar_meta_details) > 1 || ( sizeof($sidebar_meta_details) == 1 && $sidebar_meta_details[0]['hb_meta_sidebar_detail']!= "" && $sidebar_meta_details[0]['hb_meta_sidebar_detail_content'] != "" )) { 
									$unique_id = rand(1,10000);
								?>
								<div data-initialindex="-1" id="hb-toggle-<?php echo $unique_id; ?>" class="hb-toggle">
									<?php foreach ($sidebar_meta_details as $detail) { ?>
									<div class="hb-accordion-single">
										<div class="hb-accordion-tab"><i class="hb-moon-plus-circle"></i><?php echo $detail['hb_meta_sidebar_detail']; ?><i class="icon-angle-right"></i></div>
										<div class="hb-accordion-pane"><?php echo $detail['hb_meta_sidebar_detail_content']; ?></div>
									</div>
									<?php } ?>
								</div>
								<?php } ?>

								<?php 
								$social_links = array("envelop" => "Mail", "dribbble" => "Dribbble" , "facebook" => "Facebook", "flickr" => "Flickr", "forrst"=>"Forrst", "google-plus" => "Google Plus", "html5"=> "HTML 5", "cloud" => "iCloud", "lastfm"=> "LastFM", "linkedin"=> "LinkedIn", "paypal"=> "PayPal", "pinterest"=> "Pinterest", "reddit"=>"Reddit", "feed2"=>"RSS", "skype"=>"Skype", "stumbleupon"=> "StumbleUpon", "tumblr"=>"Tumblr", "twitter"=>"Twitter", "vimeo"=>"Vimeo", "wordpress"=>"WordPress", "yahoo"=>"Yahoo", "youtube"=>"YouTube", "github"=>"Github", "yelp"=>"Yelp", "mail"=>"Mail", "instagram"=>"Instagram", "foursquare"=>"Foursquare", "xing"=>"Xing");
								$has_social_link = false;
								$title_displayed = false;
								foreach ($social_links as $soc_id => $soc_name) {
									if ( vp_metabox('team_member_settings.hb_employee_social_' . $soc_id) ) {
										if ( !$has_social_link ) $has_social_link = true;
										if ( !$title_displayed && $has_social_link ) {
											$title_displayed = true;
											?>
											<h5 class="hb-heading alt-color-1"><span><?php _e('Connect','hbthemes'); ?></span></h5>
											<ul class="social-icons dark">
											<?php 
										}
									?>
										<li class="<?php echo $soc_id; ?>"><a href="<?php echo vp_metabox('team_member_settings.hb_employee_social_' . $soc_id); ?>" target="_blank"><i class="hb-moon-<?php echo $soc_id; ?>"></i><i class="hb-moon-<?php echo $soc_id; ?>"></i></a></li>
									<?php
									}
									
								}
								if ( $has_social_link ) { 
									?>
									</ul>
									<?php
								}
							}
						?>

					</div>
					<?php } ?>
					<!-- END .team-meta-sidebar -->

				</div>
				<!-- END .row -->

				<div class="spacer"></div>
				<?php if ( hb_options('hb_staff_enable_related_posts') ) { get_template_part('includes/team','related-items'); } ?>
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