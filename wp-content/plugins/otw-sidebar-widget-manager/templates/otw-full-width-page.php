<?php

/* Template Name: OTW Full width page*/

/* 
If your theme's content area is not fixed width, you can add the width in the first div bellow.
Replace 
max-width: 100%;margin: 0 auto; 
with 
max-width: 100%;width:960px;margin: 0 auto;
if you want the content area to be 960px wide
*/

get_header();
?>

<div style="max-width: 100%;margin: 0 auto;">

	<div style="width: 100%;min-height: 1px;padding: 0 10px;">
        <div class="entry-content">

          	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
          		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          			<?php the_content(); ?>
          			<?php comments_template( '', true ); // Remove if you don't want comments ?>
          			<?php edit_post_link(); ?>
          		</article>
          	<?php endwhile; ?>

          	<?php else: ?>
          		<article>
          			<h1><?php _e( 'Sorry, nothing to display.', 'otw-sbm' ); ?></h1>
          		</article>
          	<?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>