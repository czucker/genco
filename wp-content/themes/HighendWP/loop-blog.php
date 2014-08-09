<?php 
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part('includes/classic-blog/post-format' , get_post_format() );
	endwhile; endif;
?>