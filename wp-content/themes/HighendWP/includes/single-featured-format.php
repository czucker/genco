<?php
	$post_format = get_post_format(); 

	switch ($post_format) {

		case 'audio':
			$mp3_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_mp3_link');
			$ogg_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_ogg_link');
			$soundcloud_link = vp_metabox('post_format_settings.hb_audio_post_format.0.hb_audio_soundcloud_link');

			if( $soundcloud_link ) { ?>
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
			<?php }

			break;

		case 'link':
		?>
		<div class="quote-post-wrapper">
			<a><blockquote><?php the_content(); ?>
			<span class="cite-author"><?php echo $link; ?></span></blockquote><i class="hb-moon-link-5"></i></a>
		</div>
		<?php 
			break;

		case 'status':
		?>
		<div class="quote-post-wrapper">
			<a>
				<blockquote><?php echo strip_tags(get_the_content()); ?></blockquote>
				<i class="hb-moon-pencil"></i>
			</a>
		</div>
		<?php
			break;

		case 'quote':
		?>
		<div class="quote-post-wrapper">
			<a>
				<blockquote>
					<?php the_content(); ?>
					<span class="cite-author"><?php echo vp_metabox('post_format_settings.hb_quote_post_format.0.hb_quote_format_author'); ?></span>
				</blockquote>
				<i class="hb-moon-quotes-right"></i>
			</a>
		</div>
		<?php
			break;

		case 'video':
		?>
		<?php if ( vp_metabox('post_format_settings.hb_video_post_format.0.hb_video_format_link') ) { ?>
			<!-- BEGIN .featured-image -->
			<div class="featured-image fitVidsAjax">
				<?php echo wp_oembed_get(vp_metabox('post_format_settings.hb_video_post_format.0.hb_video_format_link')); ?>
			</div>
			<!-- END .featured-image -->

			<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#post-<?php the_ID(); ?> .fitVidsAjax').fitVids();
			});
			</script>
		<?php } ?>
		<?php
			break;

		case 'image':
		?>
		<?php // get featured image
			$thumb = get_post_thumbnail_id(); 
			$image_height = hb_options('hb_blog_image_height');
			$image_width = 1140;
			$full_image = wp_get_attachment_image_src( $thumb, 'full', false );

			if ( vp_metabox('layout_settings.hb_page_layout_sidebar') )
				$image_width = 832;
			$image = hb_resize( $thumb, '', $image_width, $image_height, true );

			if ( $image ) { 
		?>
		<div class="featured-image">
			<a data-title="<?php the_title(); ?>" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto">
				<img src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				<div class="item-overlay"></div>
				<div class="item-overlay-text">
					<div class="item-overlay-text-wrap">
						<span class="plus-sign"></span>
					</div>
				</div>
			</a>
		</div>
		<?php } ?>
		<?php
			break;

		case 'gallery':
		
		$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
		$api_images = "";
		$api_titles = "";
		$api_descriptions = "";
		?>
		<!-- BEGIN .featured-image -->
		<div class="featured-image">
			<div class="hb-flexslider clearfix" id="flexslider_<?php the_ID(); ?>">
				<ul class="hb-flex-slides clearfix">
					<?php foreach ( $gallery_attachments as $id=>$gallery_image ) { 
						$image = hb_resize( $id, '', 900, 500, true );
						$api_images .= "'" . addslashes ($gallery_image['url']) . "',";
						$api_titles .= "'" . addslashes ($gallery_image['title']) . "',";
						$api_descriptions .= "'" . addslashes ($gallery_image['description']) . "',";
					?>
					<li><a href="#" class="prettyphoto"><img alt="<?php echo $gallery_image['title']; ?>" src="<?php echo $image['url']; ?>" /></a></li>
					<?php } 
					$api_images = trim($api_images, ",");
					$api_titles = trim($api_titles, ",");
					$api_descriptions = trim($api_descriptions,",");
					?>
				</ul>
			</div>
			<script type="text/javascript">

				// Flexslider
		        jQuery(document).ready(function() {
		                jQuery("#flexslider_<?php the_ID(); ?>").flexslider({
		                    selector: ".hb-flex-slides > li",
		                    slideshow: true,
		                    animation: "slide",              //String: Select your animation type, "fade" or "slide"
		                    smoothHeight: true,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
		                    slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
		                    animationSpeed: 500,            //Integer: Set the speed of animations, in milliseconds
		                    pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
		                    controlNav: true,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
		                    directionNav:true,
		                    prevText: "",           //String: Set the text for the "previous" directionNav item
		                    nextText: ""               //String: Set the text for the "next" directionNav item
		                });

						//PrettyPhoto
						jQuery("body").on("click", ".prettyphoto", function(){
							api_images = [<?php echo $api_images; ?>];
							api_titles = [<?php echo $api_titles; ?>];
							api_descriptions = [<?php echo $api_descriptions; ?>]
							jQuery.prettyPhoto.open(api_images,api_titles,api_descriptions);
						});

		        });
			</script>
		</div>
		<?php
			break;
		
		default:
			?>
		<?php // get featured image
			$thumb = get_post_thumbnail_id(); 
			$image_height = hb_options('hb_blog_image_height');
			$image_width = 1140;
			$full_image = wp_get_attachment_image_src( $thumb, 'full', false );

			if ( vp_metabox('layout_settings.hb_page_layout_sidebar') )
				$image_width = 832;
			$image = hb_resize( $thumb, '', $image_width, $image_height, true );
			if ( $image ) {
			?>
		<div class="featured-image">
			<a data-title="<?php the_title(); ?>" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto">
				<img src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
				<div class="item-overlay"></div>
				<div class="item-overlay-text">
					<div class="item-overlay-text-wrap">
						<span class="plus-sign"></span>
					</div>
				</div>
			</a>
		</div>
		<?php } ?>
		<?php
			break;
	}

?>