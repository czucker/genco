<?php
global $blog_grid_column_class; 
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?><!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class('status-post-format ' . $blog_grid_column_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<div class="quote-post-wrapper">
		<a href="<?php the_permalink(); ?>">
			<blockquote><?php echo strip_tags(get_the_content()); ?></blockquote>
			<i class="hb-moon-pencil"></i>
		</a>
	</div>
</article>
<!-- END .hentry -->