<!-- BEGIN .post-content -->
<div class="post-content">

	<?php if ( hb_options('hb_blog_enable_date') ) { ?>
		<div class="hb-post-date float-left" itemprop="datePublished" datetime="<?php the_time('c'); ?>">
				<span class="day"><?php echo the_time('d'); ?></span>
				<span class="month"><?php echo the_time('M'); ?></span>
				<?php if ( hb_options('hb_blog_enable_likes') ) echo hb_print_likes(get_the_ID()); ?>
		</div>
	<?php } ?>
	<div class="post-inner">
		<!-- BEGIN .post-header -->
		<div class="post-header">
			<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									
			<!-- BEGIN .post-meta-info -->
			<div class="post-meta-info">
				
				<?php if ( hb_options('hb_blog_enable_by_author') ) { ?>
				<span class="blog-author minor-meta">
					<?php _e('Posted by' , 'hbthemes'); ?>
					<span class="entry-author-link" itemprop="name">
						<span class="vcard author">
							<span class="fn">
								<a href="<?php echo get_author_posts_url ( get_the_author_meta ('ID') ); ?>" title="<?php _e('Posts by ' , 'hbthemes'); the_author_meta('display_name');?>" rel="author"><?php the_author_meta('display_name'); ?></a>
							</span>
						</span>
					</span>
				</span>
				<span class="text-sep">|</span>
				<?php } ?>

				<?php 
				$categories = get_the_category();
				if ( $categories && hb_options('hb_blog_enable_categories') ) {
					?>
					<!-- Category info -->
					<span class="blog-categories minor-meta"> 
					<?php
					$cat_count = count($categories);
					foreach($categories as $category) { 
						$cat_count--;
					?>
						<a href="<?php echo get_category_link( $category->term_id ); ?>" title="<?php echo esc_attr( sprintf( __( "View all posts in %s", "hbthemes" ), $category->name ) ); ?>"><?php echo $category->cat_name; ?></a><?php if ( $cat_count > 0 ) echo ', '; ?>			
					<?php } ?>
					<span class="text-sep">|</span>
				<?php } ?>

				<?php if ( comments_open() && hb_options('hb_blog_enable_comments') ) { ?>
				<span class="comment-container minor-meta">
					<a href="<?php the_permalink (); ?>#comments" class="comments-link" title="<?php printf ( __("Comment on %s" , "hbthemes" ) , get_the_title()); ?>">
						<?php comments_number( __( '0 comments' , 'hbthemes' ) , __( '1 comment' , 'hbthemes' ), __( '% comments' , 'hbthemes' ) ); ?> 
					</a>
				</span>
				<span class="text-sep">|</span>
				<?php } ?>
			</div>
			<!-- END .post-meta-info -->

		</div>
		<p class="hb-post-excerpt clearfix">
			<?php 
			if ( has_excerpt() ) echo get_the_excerpt();
			else
			{
				echo wp_trim_words ( strip_shortcodes ( get_the_content() ) , hb_options('hb_blog_excerpt_length') , '...' );
			}
			?>
			<br/>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More' , 'hbthemes'); ?></a>				
		</p>
	</div>
	<!-- END .post-inner -->

</div>
<!-- END .post-content -->