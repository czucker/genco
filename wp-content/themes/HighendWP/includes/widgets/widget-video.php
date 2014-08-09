<?php
/*
 * Plugin Name: Video Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays embedded video from Youtube, Vimeo or similar.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_video_widgets' );

/*
 * Register widget.
 */
function hb_video_widgets() {
	register_widget( 'HB_Video_Widget' );
}

/*
 * Widget class.
 */
class hb_video_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Video_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'video-widget', 'description' => __('A widget that shows embedded video from Youtube, Vimeo or similar.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_video_widget', __('[HB-Themes] Video Widget','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$content = $instance['content'];
		$link = $instance['link'];
		$include_border = $instance['include_border'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		echo '<p>'.do_shortcode($content).'</p>';
		$embed_code = wp_oembed_get($link, array('width'=>247,'height'=>139));

		$inc_border = "";
		if( $include_border == 'yes' ) {
     		$inc_border = " hb-box-frame";
		}


		if ($embed_code) {
			echo '<div class="fitVids'. $inc_border .'"><span>';
			echo $embed_code;
			echo '</span></div>';
		} else {
			echo "[Video Widget Error] Sorry, but the URL you entered is not supported. Check <a href=\"http://codex.wordpress.org/Embeds\">http://codex.wordpress.org/Embeds</a> for more info.";
		}
		
		
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
		$instance['content'] = strip_tags( $new_instance['content'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['include_border'] = strip_tags($new_instance['include_border']);

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
		'title' => 'Video Widget',
		'content' => '',
		'link' => '',
		'include_border' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php echo 'Additional Text<br/><small>Enter any additional text for your video. Shown above the video</small> '; ?></label>
			<textarea class="widefat" rows="7" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo $instance['content']; ?>" ><?php echo $instance['content']; ?></textarea>
		</p>

		<!-- Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php echo ' Enter URL to your video<br/><small>Paste the whole URL with http:// prefix.<br/>Example: http://vimeo.com/22884674</small> '; ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'include_border' ); ?>"><?php _e( 'Show a border around video?','hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'include_border' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'include_border' ); ?>">
				<option <?php if ( 'yes' == $instance['include_border'] ) echo ' selected="selected"';?> value='yes'><?php _e('Yes','hbthemes'); ?></option>
				<option <?php if ( 'no' == $instance['include_border'] ) echo ' selected="selected"';?> value='no'><?php _e('No', 'hbthemes'); ?></option>
			</select>
		</p>

	<?php
	}
}
?>