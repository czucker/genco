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
add_action( 'widgets_init', 'hb_latest_posts_simple_widget' );

/*
 * Register widget.
 */
function hb_latest_posts_simple_widget() {
	register_widget( 'HB_Latest_Posts_Simple_Widget' );
}

/*
 * Widget class.
 */
class hb_latest_posts_simple_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Latest_Posts_Simple_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_latest_posts_simple_widget', 'description' => __('A widget that displays list of posts.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_latest_posts_simple_widget', __('[HB-Themes] Simple Post List','hbthemes'), $widget_ops, $control_ops );
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
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$show_excerpt = !empty( $instance['show_excerpt'] )?$instance['show_excerpt']:false;
		$show_thumb = !empty( $instance['show_thumb'] )?$instance['show_thumb']:false;

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
			'orderby' => $orderby,
			'order' => $order,
			'ignore_sticky_posts' => true,
		));

		if ( $blog_posts->have_posts() ) : ?>
			<ul>
			<?php 
			while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
				$excerpt = wp_trim_words( get_the_excerpt(), 10, '...<br/><a class="hb-focus-color" href="'. get_permalink() .'">' . __("Read More", "hbthemes") . '</a>' );
				$thumb = get_post_thumbnail_id(); 
				$full_thumb = wp_get_attachment_image_src( get_post_thumbnail_id ( get_the_ID() ), 'original') ;
				
				$image_thumb = '';
				$simple_class = '';

				if ( (!$thumb && !$show_thumb) || ( !$show_excerpt && !$show_thumb )  ){
					$simple_class = ' simple';
				}

				if ( $thumb && $show_thumb) {
					$image = hb_resize( $thumb, '', 80, 80, true );
					$image_thumb = '<div class="hb-spl-thumb"><a href="'.get_the_permalink().'"><img src="'.$image['url'].'" alt="'. get_the_title() .'" /></a></div>';
				} ?>


					<li class="clearfix<?php echo $simple_class ?>">
						
						<?php echo $image_thumb; ?>
						<div class="hb-spl-inner">
							<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							<?php if ($show_excerpt){ ?>
								<span class="hb-spl-excerpt"><?php echo $excerpt; ?></span>
							<?php } ?>
						</div>
					</li>
			<?php endwhile; ?>
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
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		$instance['show_excerpt'] = !empty( $new_instance['show_excerpt']) ? true : false;
		$instance['show_thumb'] = !empty( $new_instance['show_thumb']) ? true : false;

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

		$show_excerpt = isset( $instance['show_excerpt'] ) ? (bool)$instance['show_excerpt']  : false;
		$show_thumb = isset( $instance['show_thumb'] ) ? (bool)$instance['show_thumb']  : false;
	
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => 'Latest Posts Widget',
			'number' => '',
			'category' => '',
			'order' => 'DESC',
			'orderby' => 'date',
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

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<option <?php if ( 'date' == $instance['orderby'] ) echo ' selected="selected"';?> value='date'><?php _e('Date','hbthemes'); ?></option>
				<option <?php if ( 'ID' == $instance['orderby'] ) echo ' selected="selected"';?> value='ID'><?php _e('ID','hbthemes'); ?></option>
				<option <?php if ( 'title' == $instance['orderby'] ) echo ' selected="selected"';?> value='title'><?php _e('Title','hbthemes'); ?></option>
				<option <?php if ( 'author' == $instance['orderby'] ) echo ' selected="selected"';?> value='author'><?php _e('Author','hbthemes'); ?></option>
				<option <?php if ( 'modified' == $instance['orderby'] ) echo ' selected="selected"';?> value='modified'><?php _e('Modified','hbthemes'); ?></option>
				<option <?php if ( 'rand' == $instance['orderby'] ) echo ' selected="selected"';?> value='rand'><?php _e('Random','hbthemes'); ?></option>
				<option <?php if ( 'comment_count' == $instance['orderby'] ) echo ' selected="selected"';?> value='comment_count'><?php _e('Comment Count','hbthemes'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option <?php if ( 'ASC' == $instance['order'] ) echo ' selected="selected"';?> value='ASC'><?php _e('Ascending','hbthemes'); ?></option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo ' selected="selected"';?> value='DESC'><?php _e('Descending','hbthemes'); ?></option>
			</select>
		</p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>"<?php checked( $show_excerpt ); ?> />
		<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show Excerpt?', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>"<?php checked( $show_thumb ); ?> />
		<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php _e( 'Show Thumb?', 'hbthemes' ); ?></label></p>
		
	<?php
	}
}
?>