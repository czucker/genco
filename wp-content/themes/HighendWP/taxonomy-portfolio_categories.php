<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php get_header(); ?>
<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
	<div class="container">
	<?php 
		$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
		$sidebar_name = hb_options('hb_choose_sidebar');
	?>
		<div class="row <?php echo $sidebar_layout; ?> main-row">

		<?php if ( have_posts() ) : ?>
			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<!-- BEGIN .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
			<?php } else { ?>
				<div class="col-12 hb-main-content">
			<?php } ?>

			<?php

			$portfolio_filter = hb_options('hb_portfolio_taxonomy_filter');
			$portfolio_sorter = hb_options('hb_portfolio_taxonomy_sorter');
			$portfolio_orientation = hb_options('hb_portfolio_taxonomy_orientation');
			$portfolio_ratio = hb_options('hb_portfolio_taxonomy_ratio');
			$portfolio_columns_count = hb_options('hb_portfolio_taxonomy_columns');

			if ( !$portfolio_columns_count ) $portfolio_columns_count = 3;
			$image_dimensions = get_image_dimensions ( $portfolio_orientation, $portfolio_ratio, 1000 );

			?>
			
			<!-- BEGIN .row-special -->
			<div class="row row-special" id="standard-gallery-wrapper" data-enable-filter="<?php if ( $portfolio_filter ) echo '1'; else echo '0'; ?>" data-enable-sort="<?php if ( $portfolio_sorter ) echo '1'; else echo '0'; ?>">

				<?php if ( $portfolio_filter || $portfolio_sorter ) { ?>
				<div class="clear"></div>
				<!-- BEGIN .standard-gallery-filter -->
				<div class="standard-gallery-filter col-12 clearfix">

					<?php if ( $portfolio_filter ) { 

						$portfolio_filters = array();
						while ( have_posts() ) : the_post(); 
							$portfolio_post_filters = wp_get_post_terms( get_the_ID(), 'portfolio_categories', array("fields" => "all"));
							if ( !empty ( $portfolio_post_filters) )
							{
								foreach($portfolio_post_filters as $portfolio_fil)
								{
									$portfolio_filters[$portfolio_fil->slug] = $portfolio_fil->name;
								}
							}
						endwhile;
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
						<li class="selected"><a href="#" title="Show Newest First" class="all" data-sort="data"><span class="item-name">Date</span></a></li>
						<li><a href="#" title="Sort by Name" data-sort="name"><span class="item-name">Name</span></a></li>
					</ul>
					<!-- END .sort-tabs -->
					<?php } ?>

				</div>
				<!-- END .standard-gallery-filter -->
				<div class="clear"></div>
				<?php } ?>


				<!-- BEGIN #standard-gallery-masonry -->
				<div id="standard-gallery-masonry" class="portfolio-simple-wrap clearfix">

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

			</div>
			<!-- END .row-special -->


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
		
		<?php endif; ?>
		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->


<?php get_footer(); ?>