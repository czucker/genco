<?php 
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part('includes/classic-blog-small/post-format' , get_post_format() );
	endwhile; endif;
?>