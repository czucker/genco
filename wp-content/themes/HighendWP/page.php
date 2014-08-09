<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php 
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
	$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?> 
<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>

	<div class="container">
	
		<?php 
			$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
			$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

			if ( $sidebar_layout == "default" || $sidebar_layout == "" ) 
			{
				$sidebar_layout = hb_options('hb_page_layout_sidebar');
				$sidebar_name = hb_options('hb_choose_sidebar');
			}

			if ( vp_metabox('misc_settings.hb_onepage') ){
				$sidebar_layout = 'fullwidth';
			}

			if ( class_exists('bbPress') ) {
			     if ( is_bbpress() ) {
					$sidebar_layout = 'fullwidth';
			     }
			}
		?>

		<div class="row <?php echo $sidebar_layout; ?> main-row">

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<!-- BEGIN .hb-main-content -->
				<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
				<?php } else { ?>
				<div class="col-12 hb-main-content">
				<?php } ?>

				<?php the_content();?>
				<?php wp_link_pages('before=<div id="hb-page-links">'.__('Pages:', 'hbthemes').'&after=</div>'); ?>
				<?php if ( comments_open() && hb_options('hb_disable_page_comments') ) comments_template(); ?>
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
			<!-- END #page-ID -->

		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->

<?php endwhile; endif;?>
<?php get_footer(); ?>