<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>

<!-- BEGIN #main-content -->
<div id="main-content">
	<div class="container">
	
		<?php 
			$sidebar_layout = hb_options('hb_page_layout_sidebar');
			$sidebar_name = hb_options('hb_choose_sidebar');
			$pagination_style = hb_options('hb_pagination_style');
		?>

		<div class="row <?php echo $sidebar_layout; ?> main-row">

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<!-- BEGIN .hb-main-content -->
				<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
				<?php } else { ?>
				<div class="col-12 hb-main-content">
				<?php } ?>

				<!-- BEGIN #hb-blog-posts -->
				<div id="hb-blog-posts" class="hb-blog-classic hb-blog-large unboxed-blog-layoutXXXX clearfix<?php if ($pagination_style == 'ajax') echo ' masonry-holder'; ?>" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">	
			
				<?php get_template_part('loop','blog');?>

				</div>
				<!-- END #hb-blog-posts -->

				<?php 
				if ( $pagination_style == 'ajax' )
					hb_pagination_ajax('loop-blog');
				else if ( $pagination_style == 'standard' )
					hb_pagination_standard();
				?>

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

<?php get_footer(); ?>