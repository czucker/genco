<?php
global $blog_grid_column_class;
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?>
<!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php if ( has_post_thumbnail() ) post_class('image-post-type with-featured-image ' . $blog_grid_column_class ); else post_class('image-post-type ' . $blog_grid_column_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<?php // get featured image
	$thumb = get_post_thumbnail_id(); 
	
	if ( $thumb ) { 
		$image = hb_resize( $thumb, '', 900, 500, true );
		if ( $image ) { 
	?>	
	<div class="featured-image">
		<a href="<?php the_permalink(); ?>">
			<img src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>" />
			<div class="featured-overlay"></div>
			<div class="item-overlay-text" style="opacity: 0;">
				<div class="item-overlay-text-wrap">
					<span class="plus-sign"></span>
				</div>
			</div>
		</a>
	</div>
	<?php } 
	}
	?>
	<?php get_template_part('includes/grid-blog/post', 'description'); ?>
</article>
<!-- END .hentry -->