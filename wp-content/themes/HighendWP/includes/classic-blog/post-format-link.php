<?php
global $blog_grid_column_class; 
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?><!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class('link-post-format ' . $blog_grid_column_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<div class="quote-post-wrapper">
	<?php $link = vp_metabox('post_format_settings.hb_link_post_format.0.hb_link_format_link'); ?>
	<a href="<?php echo $link; ?>"><blockquote><?php the_content(); ?>
	<span class="cite-author"><?php echo $link; ?></span></blockquote><i class="hb-moon-link-5"></i></a>
</div>
</article>
<!-- END .hentry -->