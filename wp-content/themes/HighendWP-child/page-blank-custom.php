<?php
/*
Template Name: No Sidebar
Template By : Techbymak
Tempalte designed By : Akshay Makadiya
URL : http://techbymak.com
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div style=Ówidth:850px !important;Ó>
<?php the_content(Ô
Read More È</p>Õ); ?>
<?php edit_post_link(ÔUpdate this postÕ, Ô<p>Õ, Ô</p>Õ); ?>
<?php endwhile; else: ?>
<p><?php _e(Ôooops!! , No match foundÕ); ?></p>
<?php endif; ?>
</div>
<?php get_footer(); ?>