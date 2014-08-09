<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Gallery - Fullwidth
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

<?php 
global $wp_query;
$old_query = $wp_query;
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
	$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';

$col_count = vp_metabox('gallery_fw_page_settings.hb_gallery_columns');
?> 
	<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
	
	<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- BEGIN #fw-gallery-grid -->
	<div id="fw-gallery-grid" class="clearfix">

		<?php  
			$gallery_filter = vp_metabox('gallery_fw_page_settings.hb_gallery_filter');
			$gallery_sorter = vp_metabox('gallery_fw_page_settings.hb_gallery_sorter');
			$gallery_title = vp_metabox('gallery_fw_page_settings.hb_gallery_title');
			$gallery_categories = vp_metabox('gallery_fw_page_settings.hb_gallery_categories');
			$gallery_orientation = vp_metabox('gallery_fw_page_settings.hb_gallery_orientation');
			$gallery_ratio = vp_metabox('gallery_fw_page_settings.hb_gallery_ratio');
			
			$posts_per_page = vp_metabox('gallery_fw_page_settings.hb_gallery_posts_per_page');
			if ( !$posts_per_page ) $posts_per_page = -1;
			$orderby = vp_metabox('gallery_fw_page_settings.hb_query_orderby');
			$order = vp_metabox('gallery_fw_page_settings.hb_query_order');

			$image_dimensions = get_image_dimensions ( $gallery_orientation, $gallery_ratio );

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
					'posts_per_page' => $paged,
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
					'posts_per_page' => $paged,
					'orderby' => $orderby,
					'order' => $order,
					'paged' => $paged,
					'posts_per_page' => $posts_per_page,
					'ignore_sticky_posts' => true,
					'post_status' => 'publish',
				));
			}

			$wp_query = $gallery_posts;
 		?>

		<?php if ( $gallery_filter || $gallery_sorter || $gallery_title ) { ?>
			<!-- Gallery Filter -->		
			<div class="hb-gallery-sort">
				<div class="container clearfix">

					<?php if ( $gallery_title ) { ?>
						<h3 class="hb-gallery-caption"><?php echo $gallery_title; ?></h3>
					<?php } ?>

					<?php if ( $gallery_sorter ) { ?>
					<ul class="hb-sort-filter">
						<li class="hb-dd-header"><?php _e('Sort by' , 'hbthemes'); ?>: <strong><?php _e('Date','hbthemes'); ?></strong>
							<ul class="hb-gallery-dropdown">
								<li><a href="#sortBy=date" data-sort-value="date"><?php _e('Date','hbthemes'); ?></a></li>
								<li><a href="#sortBy=name" data-sort-value="name"><?php _e('Name','hbthemes'); ?></a></li>
								<li><a href="#sortBy=count" data-sort-value="count"><?php _e('Count','hbthemes'); ?></a></li>
								<li><a href="#sortBy=random" data-sort-value="random"><?php _e('Random','hbthemes'); ?></a></li>
							</ul>
						</li>
					</ul>
					<?php } ?>

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

						$wp_query = $gallery_posts;
						array_unique($gallery_filters);
					?>
					<ul class="hb-grid-filter">
						<li class="hb-dd-header"><?php _e('Filter by:' , 'hbthemes'); ?> <strong><?php _e('ALL','hbthemes'); ?></strong>
							<ul class="hb-gallery-dropdown">
								<li><a href="#" data-filter="*" data-filter-name="<?php _e('All','hbthemes'); ?>"><?php _e('All' , 'hbthemes'); ?> <span class="hb-filter-count">(0)</span></a></li>
								<?php if ( !empty($gallery_filters) ) { 
									foreach ( $gallery_filters as $slug=>$name ) { 
									?>
										<li><a href="#" data-filter="<?php echo $slug; ?>" data-filter-name="<?php echo $name; ?>"><?php echo $name; ?> <span class="hb-filter-count">(0)</span></a></li>
									<?php
									} 
								}?>
							</ul>
						</li>
					</ul>
					<?php } ?>
				</div>
			</div>
			<!-- END Gallery Filter -->
		<?php } ?>


		<?php if ( have_posts() ) : ?>
			<!-- START .fw-gallery-wrap -->
				<div class="fw-gallery-wrap loading columns-<?php echo $col_count; ?>">

			<?php while ( have_posts() ) : the_post(); 
				$filters = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"slugs"));
				$filters_string = implode ( $filters , " ");
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
				<!-- BEGIN .elastic-item -->
				<div class="col elastic-item <?php echo $filters_string; ?>">
					<div class="gallery-item">
						<?php if ( $image ) { ?>
						<a href="<?php echo $full_image[0]; ?>" data-title="<?php echo get_post_field('post_content', $thumb); ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]">				
							<img width="<?php echo $image_dimensions['width']; ?>" height="<?php echo $image_dimensions['height']; ?>" src="<?php echo $image['url']; ?>" />

							<div class="item-overlay"></div>

							<div class="item-overlay-text">

								<div class="item-overlay-text-wrap">
									<h4><span class="hb-gallery-item-name"><?php the_title(); ?></span></h4>
									<div class="hb-small-separator"></div>
									<span class="item-count-text"><span class="photo-count"><?php echo ( count($gallery_attachments) + ( get_post_thumbnail_id() ? 1 : 0 ) ); ?></span> <?php if ( count($gallery_attachments) + 1 == 1 ) _e('Photo','hbthemes'); else _e('Photos','hbthemes'); ?></span>
								</div>

								<div class="item-date" data-value="<?php the_time('c'); ?>"><?php the_time('d M Y'); ?></div>
								
							</div>
						</a>
						<?php } ?>
					</div>												
				</div>
				<!-- END .elastic-item -->

				<?php if ( !empty ( $gallery_attachments ) ) { ?>
					<div class="hb-reveal-gallery">
					<?php foreach ( $gallery_attachments as $gall_key => $gal_att ) { 
						if ( $gall_key != $thumb) { ?>
						<a href="<?php echo $gal_att['url']; ?>" title="<?php echo $gal_att['description']; ?>" rel="prettyPhoto[gallery_<?php echo $gallery_rel; ?>]"></a>
					<?php } } ?>
					</div>
				<?php } ?>
			<?php 
			endwhile; 
			?>
			</div>
			<!-- END .fw-gallery-wrap -->
			<div class="col-12 no-b-margin">
					
				<?php 
					hb_pagination_standard();
				?>

			</div>
			<?php $wp_query = $old_query;
			wp_reset_query(); ?>
		<?php endif; ?>

	</div>
	<!-- END #fw-gallery-grid -->
	</div>

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