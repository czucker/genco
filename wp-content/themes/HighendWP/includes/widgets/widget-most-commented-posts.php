<?php
/*
 * Plugin Name: Most Commented Posts Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays your most commented posts.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_most_commented_posts_widget' );

/*
 * Register widget.
 */
function hb_most_commented_posts_widget() {
	register_widget( 'HB_Most_Commented_Posts_Widget' );
}

/*
 * Widget class.
 */
class hb_most_commented_posts_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Most_Commented_Posts_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_most_commented_posts_widget', 'description' => __('A widget that displays most commented blog posts.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_most_commented_posts_widget', __('[HB-Themes] Post List - Most Commented Widget','hbthemes'), $widget_ops, $control_ops );
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
			'orderby' => 'comment_count',
			'order' => 'DESC',
			'ignore_sticky_posts' => true,
		));

		if ( $blog_posts->have_posts() ) : ?>
		<ul class="most-liked-list most-commented">
			<?php 
			while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
				$comments_count = wp_count_comments(get_the_ID());
				$comments_approved = $comments_count->approved;
				$post_author = get_the_author_link();
				$post_date = get_the_date();
			?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php printf(__('By %1$s on %2$s', 'hbthemes'), $post_author, $post_date); ?></span>
					<span class="like-count"><i class="hb-moon-bubbles-7"></i></span>
					<a href="<?php the_permalink(); ?>" class="like-count-num"><?php echo number_format($comments_approved); ?></a>
				</li>
			<?php
			endwhile;
			?>
		</ul>
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
		'title' => 'Most Commented Posts Widget',
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