<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Portfolio - Standard
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
			
			if ( $sidebar_layout == "default" || $sidebar_layout == "" ) {
				$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
				$sidebar_name = hb_options('hb_choose_sidebar');
			}

			$posts_per_page = vp_metabox('portfolio_standard_page_settings.hb_portfolio_posts_per_page');
			if ( !$posts_per_page ) $posts_per_page = -1;

			$orderby = vp_metabox('portfolio_standard_page_settings.hb_query_orderby');
			$order = vp_metabox('portfolio_standard_page_settings.hb_query_order');

		?>
		
		<div class="row <?php echo $sidebar_layout; ?> main-row">

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

			$portfolio_filter = vp_metabox('portfolio_standard_page_settings.hb_gallery_filter');
			$portfolio_sorter = vp_metabox('portfolio_standard_page_settings.hb_gallery_sorter');
			$portfolio_categories = vp_metabox('portfolio_standard_page_settings.hb_gallery_categories');
			$portfolio_orientation = vp_metabox('portfolio_standard_page_settings.hb_gallery_orientation');
			$portfolio_ratio = vp_metabox('portfolio_standard_page_settings.hb_gallery_ratio');
			$portfolio_columns_count = vp_metabox('portfolio_standard_page_settings.hb_gallery_columns');

			if ( !$portfolio_columns_count ) $portfolio_columns_count = 1;
			$image_dimensions = get_image_dimensions ( $portfolio_orientation, $portfolio_ratio, 1000 );

			global $wp_query;

			if ( get_query_var('paged') ) {
			    $paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
			    $paged = get_query_var('page');
			} else {
			    $paged = 1;
			}

			if ( !empty($portfolio_categories) ) {
				$portfolio_posts = new WP_Query( array(
					'post_type' => 'portfolio',
					'orderby' => $orderby,
					'order' => $order,
					'paged' => $paged,
					'posts_per_page' => $posts_per_page,
					'ignore_sticky_posts' => true,
					'post_status' => 'publish',
					'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_categories',
							'field' => 'id',
							'terms' => $portfolio_categories,
							'operator' => 'NOT IN',
						)
					)
				));
			} 
			else
			{
				$portfolio_posts = new WP_Query( array(
					'post_type' => 'portfolio',
					'orderby' => $orderby,
					'paged' => $paged,
					'order' => $order,
					'posts_per_page' => $posts_per_page,
					'ignore_sticky_posts' => true,
					'post_status' => 'publish',
				));
			}
			$wp_query = $portfolio_posts;

			?>
			
			<!-- BEGIN .row-special -->
			<div class="row row-special" id="standard-gallery-wrapper" data-enable-filter="<?php if ( $portfolio_filter ) echo '1'; else echo '0'; ?>" data-enable-sort="<?php if ( $portfolio_sorter ) echo '1'; else echo '0'; ?>">

				<?php if ( $portfolio_filter || $portfolio_sorter ) { ?>

				<div class="clear"></div>
				<!-- BEGIN .standard-gallery-filter -->
				<div class="standard-gallery-filter col-12 clearfix">

					<?php if ( $portfolio_filter ) { 

						$portfolio_filters = array();
						if ( have_posts() ) : while ( have_posts() ) : the_post(); 
							$portfolio_post_filters = wp_get_post_terms( get_the_ID(), 'portfolio_categories', array("fields" => "all"));
							if ( !empty ( $portfolio_post_filters) )
							{
								foreach($portfolio_post_filters as $portfolio_fil)
								{
									$portfolio_filters[$portfolio_fil->slug] = $portfolio_fil->name;
								}
							}
						endwhile; endif;
						array_unique($portfolio_filters);
						?>

						<!-- BEGIN .filter-tabs -->
						<ul class="filter-tabs filt-tabs clearfix">
							<li class="selected"><a href="#" title="<?php _e('View all All items','hbthemes'); ?>" class="all" data-filter="*"><span class="item-name"><?php _e('All','hbthemes'); ?></span><span class="item-count">0</span></a></li>
							<?php if ( !empty($portfolio_filters) ) { 
								foreach ( $portfolio_filters as $slug=>$name ) { ?>
									<li>
										<a href="#" data-filter=".<?php echo $slug; ?>" title="<?php _e('View all ','hbthemes'); echo $name; _e(' items','hbthemes'); ?>">
											<span class="item-name"><?php echo $name; ?><span class="item-count">0</span></span>
										</a>
									</li>
							<?php
								} 
							}
							?>
						</ul>
					<!-- END .filter-tabs -->
					<?php } ?>

					<?php if ( $portfolio_sorter ) { ?>
					<!-- BEGIN .sort-tabs -->
					<ul class="filter-tabs sort-tabs clearfix">
						<li class="selected"><a href="#" title="<?php _e('Show Newest First','hbthemes'); ?>" class="all" data-sort="data"><span class="item-name"><?php _e('Date', 'hbthemes'); ?></span></a></li>
						<li><a href="#" title="<?php _e('Sort by Name', 'hbthemes'); ?>" data-sort="name"><span class="item-name"><?php _e('Name', 'hbthemes'); ?></span></a></li>
					</ul>
					<!-- END .sort-tabs -->
					<?php } ?>

				</div>
				<!-- END .standard-gallery-filter -->
				<div class="clear"></div>
				<?php } ?>


				<?php if ( have_posts() ) : ?>
				<!-- BEGIN #standard-gallery-masonry -->
				<div id="standard-gallery-masonry" class="clearfix">

				<?php while ( have_posts() ) : the_post(); 
					$filters = wp_get_post_terms(get_the_ID() , 'portfolio_categories' , array("fields"=>"slugs"));
					$filters_string = implode ( $filters , " ");

					$filters_names = wp_get_post_terms(get_the_ID() , 'portfolio_categories' , array("fields"=>"names"));
					$filters_names_string = implode ($filters_names, ", ");

					$thumb = get_post_thumbnail_id(); 
					$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
					
				?>

					<!-- BEGIN .standard-gallery-item-wrap -->
					<div class="col-<?php echo 12/$portfolio_columns_count; ?> standard-gallery-item-wrap <?php echo $filters_string; ?>">

						<!-- BEGIN .standard-gallery-item -->
						<div class="standard-gallery-item" data-value="<?php the_time('c'); ?>">
							<div class="hb-gal-standard-img-wrapper">
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo $image['url']; ?>" />

									<div class="item-overlay"></div>
									<div class="item-overlay-text">
										<div class="item-overlay-text-wrap">
											<span class="plus-sign"></span>
										</div>
									</div>
								</a>

							</div>

							<div class="hb-gal-standard-description portfolio-description">
								<h3><a href="<?php the_permalink(); ?>"><span class="hb-gallery-item-name"><?php the_title(); ?></span></a></h3>
								<div class="hb-gal-standard-count"><?php echo $filters_names_string; ?></div>

								<?php if ( hb_options('hb_portfolio_enable_likes') ) echo hb_print_portfolio_likes(get_the_ID()); ?>

								<?php 
								if ( has_excerpt() ) {
									echo '<p>' . get_the_excerpt() . '</p>';
								} else {
								?>
								<p><?php echo wp_trim_words( strip_shortcodes( get_the_content() ) , 20 , NULL); ?></p>
								<?php } ?>

								<div class="portfolio-small-meta clearfix">
									<span class="float-left project-date"><?php the_time('F j, Y'); ?></span>
									<a href="<?php the_permalink(); ?>" class="float-right details-link"><?php _e('Details <i class="icon-angle-right"></i>' , 'hbthemes'); ?></a>
								</div>

							</div>

						</div>
						<!-- END .standard-gallery-item -->

					</div>
					<!-- END .standard-gallery-item-wrap -->

					<?php endwhile; ?>

				</div>
				<!-- END #standard-gallery-masonry -->

				<div class="col-12 no-b-margin">
					
					<!--
					<a class="load-more-posts" href="#">
						<span class="load-more-text" data-more="+ Load More Posts" data-less="No More Posts">+ Load More Posts</span>
						<span class="hb-spin non-visible"><i class="hb-moon-spinner-5"></i></span>
					</a>
					-->

					<?php hb_pagination_standard(); ?>

				</div>
				<?php endif; 

				wp_reset_query(); ?>

			</div>
			<!-- END .row-special -->

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
		
		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>