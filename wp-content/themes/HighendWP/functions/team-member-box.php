<?php
function hb_team_member_box( $post_id , $style = "", $excerpt_length = 20 ) {
	$testimonial_post = get_post($post_id);
	if ( $testimonial_post ) {
		setup_postdata($testimonial_post);
		$thumb = get_post_thumbnail_id();

	if ( $style != "" ) $style = " tmb-2";
	?>

	<!-- BEGIN .team-member-box -->
	<div class="team-member-box<?php echo $style; ?>">
								
		<div class="team-member-img">
			<?php if ( $thumb ) { 
				$image = hb_resize ( $thumb, '', 350, 350, true);
				if ( $image ) { ?>
				<img src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>"/>
			<?php } ?>
				<ul class="social-icons dark">
			<?php
				$social_links = array("envelop" => "Mail", "dribbble" => "Dribbble" , "facebook" => "Facebook", "flickr" => "Flickr", "forrst"=>"Forrst", "google-plus" => "Google Plus", "html5"=> "HTML 5", "cloud" => "iCloud", "lastfm"=> "LastFM", "linkedin"=> "LinkedIn", "paypal"=> "PayPal", "pinterest"=> "Pinterest", "reddit"=>"Reddit", "feed2"=>"RSS", "skype"=>"Skype", "stumbleupon"=> "StumbleUpon", "tumblr"=>"Tumblr", "twitter"=>"Twitter", "vimeo"=>"Vimeo", "wordpress"=>"WordPress", "yahoo"=>"Yahoo", "youtube"=>"YouTube", "github"=>"Github", "yelp"=>"Yelp", "mail"=>"Mail", "instagram"=>"Instagram", "foursquare"=>"Foursquare", "xing"=>"Xing");
				foreach ($social_links as $soc_id => $soc_name) {
					if ( vp_metabox('team_member_settings.hb_employee_social_' . $soc_id) ) {
						?>
						<li class="<?php echo $soc_id; ?>"><a href="<?php echo vp_metabox('team_member_settings.hb_employee_social_' . $soc_id); ?>" target="_blank"><i class="hb-moon-<?php echo $soc_id; ?>"></i><i class="hb-moon-<?php echo $soc_id; ?>"></i></a></li>
						<?php
					}
				}
			?>
				</ul>
			<?php
			}
			?>

		</div>
									
		<!-- START .team-member-description -->
		<div class="team-member-description">
										
			<!-- START .team-header-info -->
			<div class="team-header-info clearfix">
											
				<!-- START .team-header-name -->
				<div class="team-name">
					<h4 class="team-member-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<?php if ( vp_metabox('team_member_settings.hb_employee_position') ) { ?>
					<p class="team-position"><?php echo vp_metabox('team_member_settings.hb_employee_position'); ?></p>
					<?php } ?>
				</div>
				<!-- END .team-name -->
											
											
			</div>
			<!-- END .team-header-info -->

			<div class="spacer" style="height:10px;"></div>

			<!-- START .team-member-content -->
			<div class="team-member-content">
				<?php 
				if ( has_excerpt() ) {
					echo '<p class="nbm">' . get_the_excerpt() . '</p>';
				?> <div class="spacer" style="height:15px;"></div> <?php } 
				else {
				?>
				<div class="spacer" style="height:15px;"></div>
				<p class="nbm"><?php echo wp_trim_words( strip_shortcodes( get_the_content() ) , $excerpt_length , NULL); ?></p>
				<?php } ?>
			</div>
		

			<!-- END .team-member-content -->
			<a class="simple-read-more" href="<?php the_permalink(); ?>" target="_self"><?php _e('View Profile','hbthemes'); ?></a>
										
		</div>
		<!-- END .team-member-description -->
		
	</div>
	<!-- END .team-member-box -->

	<?php 
	wp_reset_postdata();
	}
}
?>