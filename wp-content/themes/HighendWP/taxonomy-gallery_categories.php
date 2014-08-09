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
	?>
		<div class="row <?php echo $sidebar_layout; ?> main-row">

		<?php if ( have_posts() ) : ?>
			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<!-- BEGIN .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth') { ?>
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

			$gallery_filter = true;
			$gallery_sorter = true;
			$gallery_orientation = 'landscape';
			$gallery_ratio = 'ratio1';
			$gallery_columns_count = 3;

			$image_dimensions = get_image_dimensions ( $gallery_orientation, $gallery_ratio, 1000 );

			global $wp_query;

			if ( get_query_var('paged') ) {
			    $paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
			    $paged = get_query_var('page');
			} else {
			    $paged = 1;
			}?>
			
			<!-- BEGIN .row-special -->
			<div class="row row-special" id="standard-gallery-wrapper">

				<?php if ( $gallery_filter || $gallery_sorter ) { ?>
				<div class="clear"></div>
				<!-- BEGIN .standard-gallery-filter -->
				<div class="standard-gallery-filter col-12 clearfix">

					<?php if ( $gallery_filter ) { 

						$gallery_filters = array();
						if ( have_posts() ) : while ( have_posts() ) : the_post(); 
							$gallery_post_filters = wp_get_post_terms( get_the_ID(), 'gallery_categories', array("fields" => "all"));
							if ( !empty ( $gallery_post_filters) )
							{
								foreach($gallery_post_filters as $gallery_fil)
								{
									$gallery_filters[$gallery_fil->slug] = $gallery_fil->name;
								}
							}
						endwhile; endif;
						array_unique($gallery_filters);
					?>
					<!-- BEGIN .filter-tabs -->
					<ul class="filter-tabs filt-tabs clearfix">
						<li class="selected"><a href="#" title="<?php _e('View all All items','hbthemes'); ?>" class="all" data-filter="*"><span class="item-name"><?php _e('All','hbthemes'); ?></span><span class="item-count">0</span></a></li>
						<?php if ( !empty($gallery_filters) ) { 
							foreach ( $gallery_filters as $slug=>$name ) { ?>
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

					<?php if ( $gallery_sorter ) { ?>
					<!-- BEGIN .sort-tabs -->
					<ul class="filter-tabs sort-tabs clearfix">
						<li class="selected"><a href="#" title="<?php _e('Show Newest First','hbthemes'); ?>" class="all" data-sort="data"><span class="item-name"><?php _e('Date','hbthemes'); ?></span></a></li>
						<li><a href="#" title="<?php _e('Sort by Name','hbthemes'); ?>" data-sort="name"><span class="item-name"><?php _e('Name','hbthemes'); ?></span></a></li>
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
					$filters = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"slugs"));
					$filters_names = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"names"));
					$filters_string = implode ( $filters , " ");
					$filters_names_string = implode ($filters_names, ", ");
					$thumb = get_post_thumbnail_id(); 
					$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
					$full_image = wp_get_attachment_image_src($thumb,'full');
					$gallery_rel = rand (1,100000);
					$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());

				?>
					<!-- BEGIN .standard-gallery-item-wrap -->
					<div class="col-<?php echo 12 / $gallery_columns_count; ?> standard-gallery-item-wrap <?php echo $filters_string; ?>">

						<!-- BEGIN .standard-gallery-item -->
						<div class="standard-gallery-item" data-value="<?php the_time('c'); ?>">
							<div class="hb-gal-standard-img-wrapper">
								<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]">
									<img src="<?php echo $image['url']; ?>" />

									<div class="item-overlay"></div>
									<div class="item-overlay-text">
										<div class="item-overlay-text-wrap">
											<span class="plus-sign"></span>
										</div>
									</div>
								</a>

							</div>

							<?php if ( !empty ( $gallery_attachments ) ) { ?>
								<div class="hb-reveal-gallery">
								<?php foreach ( $gallery_attachments as $gal_att ) { ?>
									<a href="<?php echo $gal_att['url']; ?>" title="<?php echo $gal_att['description']; ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]"></a>
								<?php } ?>
								</div>
							<?php } ?>

							<div class="hb-gal-standard-description">
								<h3><a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]"><span class="hb-gallery-item-name"><?php the_title(); ?></span></a></h3>
								<?php if ( $filters_names_string ) { ?>
									<div class="hb-small-separator"></div>
									<div class="hb-gal-standard-count"><?php echo $filters_names_string; ?></div>
								<?php } ?>
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

			</div>
			<!-- END .hb-main-content -->

			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
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
		<?php endif; ?>
		
		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->


<?php get_footer(); ?>