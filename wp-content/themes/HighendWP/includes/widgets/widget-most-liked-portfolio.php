<?php
/*
 * Plugin Name: Most Liked Portfolio Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays your most liked portfolio items.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_liked_portfolio_widgets' );

/*
 * Register widget.
 */
function hb_liked_portfolio_widgets() {
	register_widget( 'HB_Liked_Portfolio_Widget' );
}

/*
 * Widget class.
 */
class hb_liked_portfolio_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Liked_Portfolio_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_liked_portfolio_widget', 'description' => __('A widget that displays your most like portfolio items.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_liked_portfolio_widget', __('[HB-Themes] Most Liked Portfolio Widget','hbthemes'), $widget_ops, $control_ops );
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
		$column_class = 'columns-3';

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; 

		if ( !$number ) $number = -1;
		$unique_id = "unique_id_".rand(1,50000);

		if ( $category )
		{
			$portfolio_items = new WP_Query(
				array(
					'post_type' => 'portfolio',
					'meta_key' => '_likes',
					'orderby' => 'meta_value_num',
					'order' => 'DESC',
					'posts_per_page' => $number,
					'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_categories',
							'field' => 'id',
							'terms' => $category
						)
					)
				)
			);
		}
		else 
		{
			$portfolio_items = new WP_Query(
				array(
					'post_type' => 'portfolio',
					'meta_key' => '_likes',
					'orderby' => 'meta_value_num',
					'order' => 'DESC',
					'posts_per_page' => $number,
				)
			);
		}

		if ( !$number ) $number = 1;
		if ($number == 1){$column_class = 'columns-1';}
		if ($number == 2){$column_class = 'columns-2';}
		if ($number == 3 || $number == 6 || $number == 9 || $number == 15 || $number == 18){$column_class = 'columns-3';}
		if ($number == 4 || $number == 8 || $number == 12 || $number == 16 || $number == 24){$column_class = 'columns-4';}

		

		echo '<div class="hb-stream '. $column_class .' clearfix" id="'.$unique_id.'"><ul>';
		$counter = (int) $number;
		if ( $portfolio_items->have_posts() ) : while ( $portfolio_items->have_posts() ) : $portfolio_items->the_post();
			$perma = get_the_permalink();
			$custom_url = vp_metabox('portfolio_settings.hb_portfolio_custom_url');
					
			if ($custom_url){
				$perma = $custom_url;
			}
			$thumb = get_post_thumbnail_id(); 
			$image = hb_resize( $thumb, '', 250, 250, true );
			$likes = hb_like_this( get_the_ID() );
			if ( $thumb ) {
				$counter--;
				if ($counter>=0) {
					echo '<li><a href="'.$perma.'" title="'.get_the_title().'" rel="tooltip">';
					echo '<img src="'.$image['url'].'" />';
					echo '<span class="widget-like-count"><i class="hb-moon-heart"></i>'. number_format($likes) .'</span>';
					echo '</a></li>';			
				}
			}
			endwhile; endif;
			wp_reset_query();
			echo '</ul></div>';

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
		'title' => 'Most Liked Portfolio Widget',
		'number' => '3',
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
					$portfolio_categories = get_terms('portfolio_categories', 'orderby=name&hide_empty=0');
					if ( !empty($portfolio_categories) )
					{
						foreach ($portfolio_categories as $portfolio_category) {
							?>
							<option <?php if ( $portfolio_category->term_id == $instance['category'] ) echo ' selected="selected"';?> value='<?php echo $portfolio_category->term_id; ?>'><?php echo $portfolio_category->name; ?></option>
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