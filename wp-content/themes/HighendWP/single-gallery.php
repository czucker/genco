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
		$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
		$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

		if ( $sidebar_layout == "default" || $sidebar_layout == "" ) {
			$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
			$sidebar_name = hb_options('hb_choose_sidebar');
		}

		$pagination_style = vp_metabox('page_settings.hb_pagination_settings.0.hb_pagination_style');
		$blog_grid_column_class = vp_metabox('page_settings.hb_blog_grid_settings.0.hb_grid_columns');
	?>

	<div class="row <?php echo $sidebar_layout; ?> main-row">
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
		<!-- BEGIN .hb-main-content -->
		<?php if ( $sidebar_layout != "fullwidth") { ?>
			<div class="col-9 hb-equal-col-height hb-main-content">
		<?php } else { ?>
			<div class="col-12 hb-main-content">
		<?php } ?>
			<!-- BEGIN #single-blog-wrapper -->
			<div class="single-blog-wrapper clearfix" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
				<!-- BEGIN .hentry -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( get_post_format() . '-post-format single' ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
					<!-- BEGIN .single-post-content -->
					<div class="single-post-content">
					
						<?php if ( !has_post_format('quote') && !has_post_format('link') && !has_post_format('status') ) {?>
						<!-- BEGIN .entry-content -->
						<div class="entry-content ntm clearfix" itemprop="text">

							<?php
							$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
							$gallery_ids = "";
							if ( !empty ( $gallery_attachments ) ) {
								foreach ($gallery_attachments as $key => $value) {
									$gallery_ids .= $key . ',';
								}
							}
							$gallery_ids = substr ( $gallery_ids, 0, -1);
							$gallery_shortcode = "[gallery ids=\"" . $gallery_ids . "\" columns=\"4\" link=\"file\"]";
							?>
							<div class="hb-gallery-single-wrap">
								<?php echo do_shortcode ( $gallery_shortcode ); ?>
							</div>
							<?php the_content(); ?>
							<div class="page-links"><?php wp_link_pages(array('next_or_number'=>'next', 'previouspagelink' => ' <i class="icon-angle-left"></i> ', 'nextpagelink'=>' <i class="icon-angle-right"></i>')); ?></div>
						</div>
						<!-- END .entry-content -->
						<?php } ?>

						<div class="single-post-tags">
						<?php 
							$term_list = wp_get_post_terms($post->ID, 'faq_categories', array("fields" => "all"));
							if ( $term_list ) { ?>
								<?php foreach ($term_list as $term) {?>
									<a href="<?php echo get_term_link( $term, 'faq_categories' ); ?>"><?php echo $term->name; ?></a>
								<?php }
							} ?>
						</div>
					</div>
					<!-- END .single-post-content -->
				</article>

				<?php if (! is_attachment() ) { ?>
				<section class="bottom-meta-section clearfix">
					<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
					<div class="float-left comments-holder"><a href="<?php the_permalink(); ?>#comments" class="comments-link scroll-to-comments" title="<?php _e('View comments on ', 'hbthemes'); the_title(); ?>"><?php comments_number( __( '0 Comments' , 'hbthemes' ) , __( '1 Comment' , 'hbthemes' ), __( '% Comments' , 'hbthemes' ) ); ?></a></div>
					<?php } ?>

					<?php if ( hb_options('hb_blog_enable_likes') ) { ?>
					<div class="float-right">
					<?php echo hb_print_likes(get_the_ID()); ?>
					</div>
					<?php } ?>

					<?php if ( hb_options('hb_blog_enable_share') ) { ?>
					<div class="float-right">
						<?php get_template_part ( 'includes/hb' , 'share' ); ?>
					</div>
					<!-- END .float-right -->
					<?php } ?>
				</section>
				<?php } ?>

			</div>
			<!-- END #single-blog-wrapper -->
			<?php if (! is_attachment() ) {
				if ( comments_open() ) comments_template();
			} ?>

		</div>
		<!-- END .hb-main-content -->
		<?php if ( $sidebar_layout != "fullwidth" ){ ?>
			<!-- BEGIN .hb-sidebar -->
			<div class="col-3  hb-equal-col-height hb-sidebar">
			<?php 		
				if ( $sidebar_name && function_exists('dynamic_sidebar') )
					dynamic_sidebar($sidebar_name);
			?>
			</div>
			<!-- END .hb-sidebar -->
		<?php } ?>


		<?php endwhile; endif; ?>	

	</div>
		
	</div>
</div>
<!-- END #main-content -->
<?php get_footer(); ?>