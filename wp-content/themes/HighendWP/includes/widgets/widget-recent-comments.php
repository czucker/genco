<?php
/*
 * Plugin Name: Recent Comments Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays recent comments on your website.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_recent_comments_widgets' );

/*
 * Register widget.
 */
function hb_recent_comments_widgets() {
	register_widget( 'HB_Recent_Comments_Widget' );
}

/*
 * Widget class.
 */
class hb_recent_comments_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Recent_Comments_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_recent_comments_widget', 'description' => __('A widget that displays recent comments on your website.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_recent_comments_widget', __('[HB-Themes] Recent Comments','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
		global $wp_query;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		if ( $count ) 
			$all_comments = get_comments ( array('status' => 'approve','number' => $count ));
			
		else $all_comments = get_comments(array('status' => 'approve','number' => 6));
		
		if ( !empty ( $all_comments ) ) {
			?>
			<ul class="recent-comments-list">
				<?php foreach ( $all_comments as $comment ) { ?>
				<li>
					<a class="recent-comment-author-img float-left" href="<?php echo get_permalink( $comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">		
						<?php echo get_avatar( $comment->comment_author_email , 54); ?>
					</a>
					
					<div class="recent-comments-content">
							<a class="recent-comments-title" href="<?php echo get_permalink( $comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
								<?php echo $comment->comment_author; ?>
								<?php _e(' on ' , 'hbthemes'); ?>
								<?php echo get_the_title ( $comment->comment_post_ID ); ?>
							</a>
						<span class="entry-meta">
							<?php echo hb_get_comment_excerpt( $comment->comment_ID , 10 ); ?>
						</span>
					</div>
					
				</li>
				<?php }	?>
			</ul>
			<?php
		}
		
		

		echo $after_widget;
	}
	
	

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		
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
		'title' => 'Recent Comments',
		'count' => '5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	  
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Comment Count','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

	<?php
	}
}

?>