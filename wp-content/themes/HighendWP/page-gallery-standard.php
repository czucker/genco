	<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Gallery - Standard
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
		$pagination_style = vp_metabox('gallery_standard_page_settings.hb_pagination_style');
		if ( !$pagination_style ) $pagination_style = hb_options('hb_pagination_style');
		$posts_per_page = vp_metabox('gallery_standard_page_settings.hb_gallery_posts_per_page');
		if ( !$posts_per_page ) $posts_per_page = -1;

		$orderby = vp_metabox('gallery_standard_page_settings.hb_query_orderby');
		$order = vp_metabox('gallery_standard_page_settings.hb_query_order');

	?>
		<div class="row <?php echo $sidebar_layout; ?> main-row">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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

			$gallery_filter = vp_metabox('gallery_standard_page_settings.hb_gallery_filter');
			$gallery_sorter = vp_metabox('gallery_standard_page_settings.hb_gallery_sorter');
			$gallery_categories = vp_metabox('gallery_standard_page_settings.hb_gallery_categories');
			$gallery_orientation = vp_metabox('gallery_standard_page_settings.hb_gallery_orientation');
			$gallery_ratio = vp_metabox('gallery_standard_page_settings.hb_gallery_ratio');
			$gallery_columns_count = vp_metabox('gallery_standard_page_settings.hb_gallery_columns');

			if ( !$gallery_columns_count ) $gallery_columns_count = 1;
			$image_dimensions = get_image_dimensions ( $gallery_orientation, $gallery_ratio, 1000 );

			global $wp_query;

			if ( get_query_var('paged') ) {
			    $paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
			    $paged = get_query_var('page');
			} else {
			    $paged = 1;
			}

			if ( !empty($gallery_categories) ) {
				$gallery_posts = new WP_Query( array(
					'post_type' => 'gallery',
					'orderby' => $orderby,
					'order' => $order,
					'paged' => $paged,
					'posts_per_page' => $posts_per_page,
					'ignore_sticky_posts' => true,
					'post_status' => 'publish',
					'tax_query' => array(
						array(
							'taxonomy' => 'gallery_categories',
							'field' => 'id',
							'terms' => $gallery_categories,
							'operator' => 'NOT IN',
						)
					)
				));
			} 
			else
			{
				$gallery_posts = new WP_Query( array(
					'post_type' => 'gallery',
					'orderby' => $orderby,
					'paged' => $paged,
					'order' => $order,
					'posts_per_page' => $posts_per_page,
					'ignore_sticky_posts' => true,
					'post_status' => 'publish',
				));
			}
			$wp_query = $gallery_posts;
 			?>
			
			<!-- BEGIN .row-special -->
			<div class="row row-special" id="standard-gallery-wrapper">

				<?php if ( $gallery_filter || $gallery_sorter ) { ?>
				<div class="clear"></div>
				<!-- BEGIN .standard-gallery-filter -->
				<div class="standard-gallery-filter col-12 clearfix">

					<?php if ( $gallery_filter ) { 

						$gallery_filters = array();
						if ( $gallery_posts->have_posts() ) : while ( $gallery_posts->have_posts() ) : $gallery_posts->the_post(); 
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
						<li><a href="#" title="<?php _e('Sort by Name','hbtbemes'); ?>" data-sort="name"><span class="item-name"><?php _e('Name','hbthemes'); ?></span></a></li>
					</ul>
					<!-- END .sort-tabs -->
					<?php } ?>

				</div>
				<!-- END .standard-gallery-filter -->
				<div class="clear"></div>
				<?php } ?>


				<?php if ( have_posts() ) : ?>
				<!-- BEGIN #standard-gallery-masonry -->
				<div id="standard-gallery-masonry" class="clearfix" data-column-size="col-<?php echo 12/$gallery_columns_count; ?>">

				<?php 
				while ( have_posts() ) : the_post(); 
					$filters = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"slugs"));
					$filters_names = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"names"));
					$filters_string = implode ( $filters , " ");
					$filters_names_string = implode ($filters_names, ", ");
					$thumb = get_post_thumbnail_id();
					$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
					$full_image = wp_get_attachment_image_src($thumb,'full');
					$gallery_rel = rand (1,100000);
					$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
					if ( !$image && !empty($gallery_attachments))
					{
						reset($gallery_attachments);
						$thumb = key($gallery_attachments);
						$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
						$full_image = wp_get_attachment_image_src($thumb,'full');
					}
					?>
					<!-- BEGIN .standard-gallery-item-wrap -->
					<div class="col-<?php echo 12/$gallery_columns_count; ?> standard-gallery-item-wrap <?php echo $filters_string; ?>">

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
									<?php foreach ( $gallery_attachments as $gall_key => $gal_att ) { 
										if ( $gall_key != $thumb) { ?>
										<a href="<?php echo $gal_att['url']; ?>" title="<?php echo $gal_att['description']; ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]"></a>
									<?php } } ?>
								</div>
							<?php } ?>

							<div class="hb-gal-standard-description">
								<h3><a><span class="hb-gallery-item-name"><?php the_title(); ?></span></a></h3>
								<?php if ( $filters_names_string ) { ?>
									<div class="hb-small-separator"></div>
									<div class="hb-gal-standard-count"><?php echo $filters_names_string; ?></div>
								<?php } ?>
							</div>

						</div>
						<!-- END .standard-gallery-item -->

					</div>
					<!-- END .standard-gallery-item-wrap -->
				<?php endwhile;
				?>

				</div>
				<!-- END #standard-gallery-masonry -->
				<div class="col-12 no-b-margin">
					
				<?php 
					hb_pagination_standard();
				?>

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
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->


<?php get_footer(); ?>