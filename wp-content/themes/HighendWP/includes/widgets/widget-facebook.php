<?php
/*
 * Plugin Name: Facebook Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays your facebook like box.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_facebook_widget' );

/*
 * Register widget.
 */
function hb_facebook_widget() {
	register_widget( 'HB_Facebook_Widget' );
}

/*
 * Widget class.
 */
class hb_facebook_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Facebook_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_facebook_widget', 'description' => __('A widget that displays a Facebook like box.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_facebook_widget', __('[HB-Themes] Facebook Like Box','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$page_url = $instance['page_url'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		?>

		<div class="facebook-box">
			<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $page_url ?>&amp;width=247&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;show_border=false&amp;header=true&amp;height=270" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:270px;" allowTransparency="true"></iframe>
		</div>

		<?php
		
		/* Display widget */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['page_url'] = $new_instance['page_url'];

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
		'title' => 'Facebook Widget',
		'page_url' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','hbthemes'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		

		<p>
			<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e( 'Facebook page URL: <br/><small>Example: http://facebook.com/hbthemes</small>','hbthemes'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>

		
	<?php
	}
}
?>