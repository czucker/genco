<!-- BEGIN .post-content -->
<div class="post-content">
	<!-- BEGIN .post-header -->
	<div class="post-header">
		<h2 class="title"> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( hb_options('hb_blog_enable_date') ) { ?>
		<time class="date-container minor-meta updated" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time(get_option('date_format')); ?></time>
		<?php } ?>

		<?php
		if (is_sticky()) { ?>
			<div class="sticky-post-icon"><i class="hb-moon-pushpin"></i></div>
		<?php } ?>
	</div>
	<!-- END .post-header -->

	<p class="hb-post-excerpt clearfix">
		<?php 
		if ( has_excerpt() ) echo get_the_excerpt();
		else
		{
			echo wp_trim_words ( strip_shortcodes ( get_the_content() ) , hb_options('hb_blog_excerpt_length') , '...' );
		}
		?>
		<br/>
		<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More', 'hbthemes'); ?></a>					
	</p>

	<div class="post-meta-footer">
		<div class="inner-meta-footer clearfix">
			<div class="float-right">
				<?php if ( hb_options('hb_blog_enable_likes') ) echo hb_print_likes(get_the_ID()); ?>
			</div>
			<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
			<a href="<?php the_permalink(); ?>#comments" class="comments-holder float-right"><i class="hb-moon-bubbles-10"></i>
				<?php comments_number( __( '0' , 'hbthemes' ) , __( '1' , 'hbthemes' ), __( '%' , 'hbthemes' ) ); ?> 
			</a>
			<?php } ?>
		</div>
	</div>

</div>
<!-- END .post-content -->