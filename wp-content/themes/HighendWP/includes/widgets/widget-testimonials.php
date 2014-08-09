<?php
/*
 * Plugin Name: Testimonials Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays testimonials.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_testimonials_widget' );

/*
 * Register widget.
 */
function hb_testimonials_widget() {
	register_widget( 'HB_Testimonials_Widget' );
}

/*
 * Widget class.
 */
class hb_testimonials_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Testimonials_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_testimonials_widget', 'description' => __('A widget that displays testimonial slider.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_testimonials_widget', __('[HB-Themes] Testimonials Widget','hbthemes'), $widget_ops, $control_ops );
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
		$order = $instance['order'];
		$orderby = $instance['orderby'];


		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; ?>

		<?php
		if ( !$number ) $number = -1;

		$testimonials = new WP_Query(
			array ( 
				'post_type' => 'hb_testimonials',
				'posts_per_page' => $number,
				'orderby' => $orderby, 
				'order' => $order, 
			)
		);

		$rand_num = rand(1,100000);
		if ( $testimonials->have_posts() ) : 
		?>
			<div id="hb-testimonial-<?php echo $rand_num; ?>" class="ts-1">
				<ul class="testimonial-slider">
				<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
					<li class="hb-testimonial-box">
						<div class="hb-testimonial">
							<?php the_content(); ?>
						</div>
						
						<?php
						$author_image = vp_metabox('testimonial_type_settings.hb_testimonial_author_image');
						$author_name = vp_metabox('testimonial_type_settings.hb_testimonial_author');
						$author_desc = vp_metabox('testimonial_type_settings.hb_testimonial_description');
						$author_desc_link = vp_metabox('testimonial_type_settings.hb_testimonial_description_link');

						if ( $author_image ) { 
							$author_image = hb_resize(null, $author_image, 60, 60, true ); ?>
							<img src="<?php echo $author_image['url']; ?>" width="60" height="60" class="testimonial-author-img"/>
						<?php } ?>

						<?php if ( $author_name || $author_desc ) { ?>
						<div class="testimonial-author">
							<?php if ( $author_name ) { ?>
							<h5 class="testimonial-author-name">
							<?php echo $author_name; ?>
							</h5>
							<?php } ?>

							<?php if ( $author_desc && $author_desc_link ) { ?>
								<a href="<?php echo $author_desc_link; ?>" class="testimonial-company"><?php echo $author_desc; ?></a>
							<?php } else if ( $author_desc ) { ?>
								<a class="testimonial-company"><?php echo $author_desc; ?></a>
							<?php } ?>
						</div>
						<?php } ?>
					</li>
				<?php endwhile; ?>
				</ul>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(window).on("load",function () {
						jQuery("#hb-testimonial-<?php echo $rand_num; ?>").flexslider({
							selector: ".testimonial-slider > li",
							slideshow: true,
							animation: "fade",
							smoothHeight: false,
							slideshowSpeed: 5000,
							animationSpeed: 350,
							directionNavArrowsLeft : '<i class="icon-chevron-left"></i>',
							directionNavArrowsRight : '<i class="icon-chevron-right"></i>',
							pauseOnHover: false,
							controlNav: true,
							directionNav:false,
							prevText: "",
							nextText: ""
						});
					});
				});
			</script>
		<?php
		endif;
		wp_reset_query();
		?>

		<?php echo $after_widget;
	}
	
	

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['order'] = strip_tags( $new_instance['order'] );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );

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
		'title' => 'Testimonials Widget',
		'number' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of testimonials:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order testimonials by:','hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
				<option <?php if ( 'date' == $instance['orderby'] ) echo ' selected="selected"';?> value='date'><?php _e('Date','hbthemes'); ?></option>
				<option <?php if ( 'rand' == $instance['orderby'] ) echo ' selected="selected"';?> value='rand'><?php _e('Random', 'hbthemes'); ?></option>
				<option <?php if ( 'menu_order' == $instance['orderby'] ) echo ' selected="selected"';?> value='menu_order'><?php _e('Menu Order', 'hbthemes'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order in:','hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>">
				<option <?php if ( 'ASC' == $instance['order'] ) echo ' selected="selected"';?> value='ASC'><?php _e('Ascending','hbthemes'); ?></option>
				<option <?php if ( 'DESC' == $instance['order'] ) echo ' selected="selected"';?> value='DESC'><?php _e('Descending', 'hbthemes'); ?></option>
			</select>
		</p>
	<?php
	}
}
?>