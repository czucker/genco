<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Blog - Fullwidth
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
	<?php
		$background_image = vp_metabox('blog_fw_page_settings.hb_background_image');
	?>
	<!-- BEGIN .extra-wide-container -->
	<div class="row extra-wide-container"<?php if ( $background_image ) echo ' style="background-image:url(' . $background_image . '); padding-top:70px; margin-top:-70px !important;"'; ?>>
		<!-- BEGIN .extra-wide-inner -->
		<div class="extra-wide-inner clearfix">

		<?php 
			$pagination_style = vp_metabox('blog_fw_page_settings.hb_pagination_style');
			if ( !$pagination_style ) $pagination_style = hb_options('hb_pagination_style');
			$blog_grid_column_class = vp_metabox('blog_fw_page_settings.hb_grid_columns');
			$blog_grid_style = vp_metabox('blog_fw_page_settings.hb_grid_style');

			if ( !$blog_grid_column_class ) $blog_grid_column_class = 1;
			$blog_grid_column_class = 12 / $blog_grid_column_class;
			$blog_grid_column_class = "col-" . $blog_grid_column_class;
		?>

				
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php
			global $wp_query;
			
			if ( get_query_var('paged') ) {
			    $paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
			    $paged = get_query_var('page');
			} else {
			    $paged = 1;
			}

			$hb_blog_posts = new WP_Query( 
				array(
					'post_type' => 'post',
					'paged' => $paged,
					'posts_per_page' => get_option('posts_per_page'),
					'orderby' => vp_metabox('blog_fw_page_settings.hb_query_orderby'),
					'order' => vp_metabox('blog_fw_page_settings.hb_query_order'),
					'category__in' => vp_metabox('blog_fw_page_settings.hb_blog_category_include'),
					'ignore_sticky_posts' => true,
					'post_status' => 'publish'
			));
			$wp_query = $hb_blog_posts;
			?>

			<!-- BEGIN #hb-blog-posts -->
			<div id="hb-blog-posts" class="hb-blog-grid masonry-holder unboxed-blog-layoutXXXX clearfix" data-layout-mode="<?php echo $blog_grid_style; ?>" data-column-size="<?php echo $blog_grid_column_class; ?>" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">	
			<?php get_template_part('loop','blog-grid'); ?>
			</div>
			<!-- END #hb-blog-posts -->
			<?php 
			if ( $pagination_style == 'ajax' )
				hb_pagination_ajax('loop-blog-grid');
			else if ( $pagination_style == 'standard' )
				hb_pagination_standard();

			wp_reset_query();
			?>
			
		</div>

		</div>
		<!-- BEGIN .extra-wide-inner -->
	</div>
	<!-- END .extra-wide-container -->

	<?php if ( comments_open() && hb_options('hb_disable_page_comments') ) { ?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php comments_template(); ?>
				</div>
			</div>
		</div> 
	<?php	}
	?>

</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>