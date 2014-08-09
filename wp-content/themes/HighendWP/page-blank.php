<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Blank Template
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
<?php 
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
	$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?> 
	<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
	<div class="container">
		<div class="row main-row">
			<div id="page-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
				<?php the_content(); ?>
			</div>
		</div>
		<!-- END .row -->
	</div>
	<!-- END .container -->
</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>
<?php get_footer(); ?>