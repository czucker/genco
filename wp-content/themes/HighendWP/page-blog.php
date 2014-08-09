<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Blog - Classic
*/
?>
<?php get_header(); ?>


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

			if ( $sidebar_layout == "default" || $sidebar_layout == "" ) {
				$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
				$sidebar_name = hb_options('hb_choose_sidebar');
			}
			
			$blog_style = vp_metabox('blog_page_settings.hb_blog_style');
			$pagination_style = vp_metabox('blog_page_settings.hb_pagination_style');
		
			$blog_class = "hb-blog-classic hb-blog-large";
			if ( $blog_style == "blog-small" ) $blog_class = "hb-blog-small"; 
			if ( !$pagination_style ) $pagination_style = hb_options('hb_pagination_style');
		?>

		<div class="row <?php echo $sidebar_layout; ?> main-row">
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
		<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<!-- BEGIN .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
			<?php } else { ?>
				<div class="col-12 hb-main-content">
			<?php } ?>

			<?php if ( get_the_content() ) { 
				the_content(); 
			?>
				<div class="hb-separator extra-space"><div class="hb-fw-separator"></div></div>
			<?php } ?>

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
						'orderby' => vp_metabox('blog_page_settings.hb_query_orderby'),
						'order' => vp_metabox('blog_page_settings.hb_query_order'),
						'category__in' => vp_metabox('blog_page_settings.hb_blog_category_include'),
						'ignore_sticky_posts' => true,
						'post_status' => 'publish'
				));
			$wp_query = $hb_blog_posts;
			?>

			<!-- BEGIN #hb-blog-posts -->
			<div id="hb-blog-posts" class="<?php echo $blog_class; ?> unboxed-blog-layoutXXXX clearfix<?php if ($pagination_style == 'ajax') echo ' masonry-holder'; ?>" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">	
			<?php 
				if ( $blog_style == "blog-small" )
					get_template_part('loop','blog-small');
				else
					get_template_part('loop','blog'); ?>
			</div>
			<!-- END #hb-blog-posts -->
			<?php 
			if ( $pagination_style == 'ajax' )
				if ( $blog_style == "blog-small")
					hb_pagination_ajax('loop-blog-small');
				else
					hb_pagination_ajax('loop-blog');
			else if ( $pagination_style == 'standard' )
				hb_pagination_standard();
			
			wp_reset_query();
			?>

				<?php if ( comments_open() && hb_options('hb_disable_page_comments') ) comments_template(); ?>

				</div>
				<!-- END .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth') { ?>
				<!-- BEGIN .hb-sidebar -->
				<div class="col-3 hb-equal-col-height hb-sidebar">
				<?php 
					if ( $sidebar_name && function_exists('dynamic_sidebar') )
						dynamic_sidebar($sidebar_name);
				?>
				</div>
				<!-- END .hb-sidebar -->
			<?php } ?>

		</div>
		<?php endwhile; endif; ?>	

		</div>
		
	</div>
</div>
<!-- END #main-content -->

<?php get_footer(); ?>