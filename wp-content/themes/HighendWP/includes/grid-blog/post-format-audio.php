<?php
$mp3_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_mp3_link');
$ogg_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_ogg_link');
$soundcloud_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_soundcloud_link');

global $blog_grid_column_class;
if ( isset($_POST['col_count']) ) {
	if ( $_POST['col_count'] != "-1" ) $blog_grid_column_class = $_POST['col_count'];
}
?>
<!-- BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php if( $mp3_link && $ogg_link ) post_class('audio-post-format self-hosted-audio ' . $blog_grid_column_class); else if ( $soundcloud_link ) post_class('with-featured-image audio-post-format ' . $blog_grid_column_class ); else post_class('audio-post-format ' . $blog_grid_column_class );?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<?php if ( $soundcloud_link ) { ?>
<!-- BEGIN .featured-image -->
<div class="featured-image">
	<?php echo wp_oembed_get($soundcloud_link); ?>
</div>
<!-- END .featured-image -->
<?php } else if ( $mp3_link && $ogg_link ) { ?>
<!-- BEGIN .featured-image -->
<div class="featured-image">

	<div class="audio-wrap">		
		<!--[if lt IE 9]><script>document.createElement('audio');</script><![endif]-->
							
		<audio class="hb-audio-element" id="audio-<?php the_ID(); ?>" preload="none" style="width: 100%" controls="controls">
			<source type="audio/mp3" src="<?php echo $mp3_link; ?>" />
			<source type="audio/ogg" src="<?php echo $ogg_link; ?>" />
			<a href="<?php echo $mp3_link; ?>"><?php echo $mp3_link; ?></a>
		</audio>

		<script type="text/javascript">
		jQuery(document).ready(function() {
			var settings = {};

			if ( typeof _wpmejsSettings !== 'undefined' )
				settings.pluginPath = _wpmejsSettings.pluginPath;

			jQuery('#audio-<?php the_ID(); ?>').mediaelementplayer( settings );
		});
		</script>

	</div><!--/audio-wrap-->

</div>
<!-- END .featured-image -->
<?php } ?>
<?php get_template_part('includes/grid-blog/post', 'description'); ?>
</article>
<!-- END .hentry -->