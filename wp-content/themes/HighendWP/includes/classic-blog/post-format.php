<!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
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
<?php get_template_part('includes/classic-blog/post', 'description'); ?>
</article>
<!-- END .hentry -->