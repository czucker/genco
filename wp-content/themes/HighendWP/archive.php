<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>

<?php get_header(); ?>

<div id="main-content">
	<div class="container">


	<?php 
		$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
		$sidebar_name = hb_options('hb_choose_sidebar');
	?>

		<div class="row <?php echo $sidebar_layout; ?> main-row">

				<!-- BEGIN .hb-main-content -->
				<?php if ( $sidebar_layout ) { ?>
					<div class="col-9 hb-equal-col-height hb-main-content">
				<?php } else { ?>
					<div class="col-12 hb-main-content">
				<?php } ?>


				<?php
					$show_separator = false;
					if ( is_author() ){
						get_template_part('includes/post','author-info');
						$show_separator = true;
					} else if ( is_category() ) {
						if ( category_description() ) {
							echo category_description();
							$show_separator = true;
						}
					} else if ( is_tag() ) {
						if ( tag_description() ) {
							echo tag_description();
							$show_separator = true;
						}
					}
				
				if ( $show_separator ) { ?>
				<div class="hb-separator extra-space"><div class="hb-fw-separator"></div></div>
				<?php } ?>

				<?php
				if (have_posts()) :
					if ( get_query_var('paged') ) {
					    $paged = get_query_var('paged');

					    if ($paged > 1){
					    	$search_counter = ($paged-1) * get_option('posts_per_page');
					    } else {
					    	$search_counter = 0;
					    }
					} elseif ( get_query_var('page') ) {
					    $paged = get_query_var('page');
					    if ($paged > 1){
					    	$search_counter = ($paged-1) * get_option('posts_per_page');
					    } else {
					    	$search_counter = 0;
					    }
					} else {
					    $paged = 1;
					    $search_counter = 0;
					}

					while (have_posts()) : the_post();
						$search_counter++;

						$format = get_post_format( get_the_ID() );
						$icon_to_use = 'hb-moon-file-3';

						if ($format == 'video'){
							$icon_to_use = 'hb-moon-play-2';
						} else if ($format == 'status' || $format == 'standard'){
							$icon_to_use = 'hb-moon-pencil';
						} else if ($format == 'gallery' || $format == 'image'){
							$icon_to_use = 'hb-moon-image-3';
						} else if ($format == 'audio'){
							$icon_to_use = 'hb-moon-music-2';
						} else if ($format == 'quote'){
							$icon_to_use = 'hb-moon-quotes-right';
						} else if ($format == 'link'){
							$icon_to_use = 'hb-moon-link-5';
						}


						$thumb = get_post_thumbnail_id(); 
						$full_thumb = wp_get_attachment_image_src( get_post_thumbnail_id ( get_the_ID() ), 'original') ;
							
						echo '<article class="search-entry clearfix">';
						echo '<span class="search-result-counter ">'. $search_counter .'</span>';

						if ( $thumb ) {
							$image = hb_resize( $thumb, '', 80, 80, true );
							echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="search-thumb"><img src="'.$image['url'].'" alt="'. get_the_title() .'" /></a>';
						} else {
							echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="search-thumb"><i class="'. $icon_to_use .'"></i></a>';
						}
						
						$echo_title = get_the_title();
						if ( $echo_title == "" ) $echo_title = __('No Title' , 'hbthemes' );
						echo '<h4 class="semi-bold"><a href="'.get_permalink().'" title="'.$echo_title.'">'.$echo_title.'</a></h4>';
						echo '<div class="minor-meta">'. get_the_time('M j, Y') .'</div>';
					
						echo '<div class="excerpt-wrap">';
						the_excerpt();
						echo '</div>';
						
						echo '</article>';
						
					endwhile;

					hb_pagination_standard();
				
				else : ?>
					<h4 class="title-class semi-bold"><?php _e('No results found.', 'hbthemes'); ?></h4>
				<?php endif;
				?>
			
			</div>
			<!-- END .hb-main-content -->
			<?php if ( $sidebar_layout ) { ?>
				<!-- BEGIN .hb-sidebar -->
				<div class="col-3  hb-equal-col-height hb-sidebar">
				<?php 
					if ( $sidebar_name && function_exists('dynamic_sidebar') )
						dynamic_sidebar($sidebar_name);
				?>
				</div>
				<!-- END .hb-sidebar -->
			<?php } ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>