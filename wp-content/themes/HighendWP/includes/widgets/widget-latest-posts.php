<?php
/*
 * Plugin Name: Latest Posts Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays your latest posts.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_latest_posts_widget' );

/*
 * Register widget.
 */
function hb_latest_posts_widget() {
	register_widget( 'HB_Latest_Posts_Widget' );
}

/*
 * Widget class.
 */
class hb_latest_posts_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Latest_Posts_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_latest_posts_widget', 'description' => __('A widget that displays latest blog posts.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_latest_posts_widget', __('[HB-Themes] Post List - Lastest Posts Widget','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
		global $wp_query;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];
		$category = $instance['category'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; 

		if ( !$number ) $number = -1;

		$blog_posts = new WP_Query( array(
			'post_type' => 'post',
			'posts_per_page' => $number,
			'category__in' => $category,
			'orderby' => 'date',
			'order' => 'DESC',
			'ignore_sticky_posts' => true,
		));

		if ( $blog_posts->have_posts() ) : ?>
			<?php 
			while ( $blog_posts->have_posts() ) : $blog_posts->the_post();

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

			if ( $thumb ) {
				$image = hb_resize( $thumb, '', 80, 80, true );
				echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="search-thumb"><img src="'.$image['url'].'" alt="'. get_the_title() .'" /></a>';
			} else {
				echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="search-thumb"><i class="'. $icon_to_use .'"></i></a>';
			}

			$echo_title = get_the_title();
			if ( $echo_title == "" ) $echo_title = __('No Title' , 'hbthemes' );
			
			echo '<h4 class="semi-bold"><a href="'.get_permalink().'" title="'.$echo_title.'">'.$echo_title.'</a></h4>';
			echo '<div class="minor-meta">'. get_the_date() .'</div>';
			
			if ( has_excerpt() ) {
				echo '<p class="nbm">' . get_the_excerpt() . '</p>';
			} else {
				echo '<p class="nbm">' . hb_get_excerpt(get_the_excerpt(), 60) . '</p>';
			}

			echo '</article>';
			endwhile;
			?>
		<?php
		endif;

		echo $after_widget;
	}
	
	

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['category'] = strip_tags( $new_instance['category'] );

		/* No need to strip tags for.. */

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Latest Posts Widget',
		'number' => '',
		'category' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'From Category:','hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'category' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>">
				<option <?php if ( "" == $instance['category'] ) echo ' selected="selected"';?> value=''><?php _e('All','hbthemes'); ?></option>
				<?php
					$categories = get_categories('orderby=name&hide_empty=0');
					if ( !empty($categories) )
					{
						foreach ($categories as $category) {
							?>
							<option <?php if ( $category->term_id == $instance['category'] ) echo ' selected="selected"';?> value='<?php echo $category->term_id; ?>'><?php echo $category->name; ?></option>
							<?php
						}
					}
				?>
			</select>
		</p>
		
	<?php
	}
}
?>