<?php
$tags = wp_get_post_tags(get_the_ID());
if ( !$tags ) return;

$related_tags = array();
foreach ($tags as $tag) {
	$related_tags[] = $tag->term_id;
}
$args=array(
	'tag__in' => $related_tags,
	'post__not_in' => array(get_the_ID()),
	'posts_per_page'=>3,
	'ignore_sticky_posts'=>1,
	'orderby' => 'rand',
	'post_status' => 'publish'
);
$related_posts = new WP_Query($args);
$related_title = __('You also might be interested in','hbthemes');

if ( $related_posts->have_posts() ) : ?>
<section class="hb-related-posts clearfix">

	<?php if ( $related_title ) { ?>
	<h4 class="semi-bold aligncenter"><?php echo $related_title; ?></h4>
	<?php } ?>
					
	<div class="row">
	<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

		<!-- BEGIN .related-item -->
		<div class="col-4 related-item">
		<?php
			$thumb = get_post_thumbnail_id(); 
			$image = hb_resize( $thumb, '', 300, 200, true );
			if ( $image ) { ?>
				<div class="featured-image">
					<a href="<?php the_permalink(); ?>">
						<img alt="<?php the_title(); ?>" title="<?php the_title(); ?>" src="<?php echo $image['url']; ?>">
						<div class="item-overlay"></div>
						<div class="item-overlay-text">
						<div class="item-overlay-text-wrap">
								<span class="plus-sign"></span>
							</div>
						</div>
					</a>
				</div>
		<?php }
		?>

		<!-- BEGIN .post-content -->
		<div class="post-content">

			<!-- BEGIN .post-header -->
			<div class="post-header clearfix">
				<h2 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="post-meta-info">
					<time class="date-container minor-meta updated float-left" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time('M j, Y'); ?></time>
				</div>
			</div>
			<!-- END .post-header -->

			<p class="hb-post-excerpt clearfix">
				<?php 
					if ( has_excerpt() ) echo get_the_excerpt();
					else{
						echo wp_trim_words ( strip_shortcodes(get_the_content()) , 10 , '[...]' );
					}
				?>
			</p>

		</div>
		<!-- END .post-content -->
		
		</div>
		<!-- END .related-item -->

	<?php endwhile; ?>
	</div>
</section>
<div class="hb-separator-extra"></div>
<?php 
endif;
wp_reset_query();
?>