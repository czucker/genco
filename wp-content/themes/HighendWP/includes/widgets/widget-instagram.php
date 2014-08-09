<?php
/*
 * Plugin Name: Instagram Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays instagram posts by the given username.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_instagram_widgets' );

/*
 * Register widget.
 */
function hb_instagram_widgets() {
	register_widget( 'HB_Instagram_Widget' );
}

/*
 * Widget class.
 */
class hb_instagram_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Instagram_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'instagram-widget', 'description' => __('A widget that displays your instagram posts.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_instagram_widget', __('[HB-Themes] Instagram Grid','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$number = $instance['number'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;


		$column_count = "2";
		if ($number == "3" || $number == "6" || $number == "9" || $number == "15" || $number == "18"){
			$column_count = "3";
		} else if ($number == "4" || $number == "8" || $number == "12" || $number == "16"){
			$column_count = "4";
		}
		
			$unique_id = "unique_id_".rand(1,50000);
		 ?>
		 
            	<div class="hb-stream columns-<?php echo $column_count; ?> clearfix" id="<?php echo $unique_id; ?>"> 
            	<script type="text/javascript">
                  jQuery(document).ready(function() { 
					var unique_id = '#<?php echo $unique_id; ?>';
                      jQuery(unique_id).hb_stream({
                          username: '<?php echo $username; ?>', 
                          limit:<?php echo (int) $number; ?>, 
                          social_network: 'instagram'
                      });                   
                  });
                </script>
				</div>
		<?php 

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['number'] = strip_tags( $new_instance['number'] );

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
		'title' => 'Instagram Widget',
		'username' => 'starbucks',
		'number' => '9',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php echo 'Instagram Username: '; ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<!-- Number: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo 'How many items to show?'; ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>

		
	<?php
	}
}
?>