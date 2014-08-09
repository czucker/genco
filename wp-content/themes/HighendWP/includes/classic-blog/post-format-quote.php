<?php
global $blog_grid_column_class; 
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?><!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class('quote-post-format ' . $blog_grid_column_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<div class="quote-post-wrapper">
		<a href="<?php the_permalink(); ?>">
			<blockquote>
				<?php the_content(); ?>
				<span class="cite-author"><?php echo vp_metabox('post_format_settings.hb_quote_post_format.0.hb_quote_format_author'); ?></span>
			</blockquote>
			<i class="hb-moon-quotes-right"></i>
		</a>
	</div>
</article>
<!-- END .hentry -->