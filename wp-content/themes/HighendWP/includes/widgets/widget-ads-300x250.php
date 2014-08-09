<?php
/*
 * Plugin Name: Advertisement - 300x250
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays 300x250px advertisement.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_ad_twofifty_widget' );

/*
 * Register widget.
 */
function hb_ad_twofifty_widget() {
	register_widget( 'HB_Ad_TwoFifty_Widget' );
}

/*
 * Widget class.
 */
class hb_ad_twofifty_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Ad_TwoFifty_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_ad_twofifty_widget', 'description' => __('A widget that displays 300px wide advertisement.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_ad_twofifty_widget', __('[HB-Themes] Advertisement Image','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
		global $wp_query;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		//$image_uri = $instance['image_uri'];
		$new_tab = $instance['new_tab'];
		//$ad_link = $instance['ad_link'];
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		$open_link="";
		if ($new_tab == 'y')
			$open_link = " target=\"blank\"";

		?>

		<?php for ( $i=1; $i < 6; $i++) { ?>
		
			<?php
				if ( $instance [ 'ads' . $i . '_img'] ) { ?>
				<div class="ad-cell">
					<?php if ( $instance ['ads' . $i . '_url'] ) { ?>
						<a class="hb-custom-ad-image hb-300" href="<?php echo $instance['ads' . $i . '_url']; ?>"<?php echo $open_link; ?>>
					<?php } ?>

					<img src="<?php echo $instance['ads' . $i . '_img']; ?>" alt="Advertisment" />

					<?php if ( $instance ['ads' . $i . '_url'] ) { ?>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		<?php } ?>

		<?php

//		echo "<a class=\"hb-custom-ad-image hb-250\" " . $link_url . $open_link . ">
//		<img src=\"$image_uri\" rel=\"Advertisement\" />
//		</a>";
		
		/*
		$query = get_most_viewed_post_query($count);
		hb_post_list ( $query , false , true );
		wp_reset_query();
		*/
		
		echo $after_widget;
	}
	
	

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['new_tab'] = $new_instance['new_tab'];

		for($i=1 ; $i<6 ; $i++ ){ 
			$instance['ads'.$i.'_img'] = $new_instance['ads'.$i.'_img'];
			$instance['ads'.$i.'_url'] = $new_instance['ads'.$i.'_url'];
		}
		
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
		'title' => 'Advertisement',
		'new_tab' => 'n',
		'ads1_img' => '',
		'ads1_url' =>'',
		'ads2_img' => '',
		'ads2_url' =>'',
		'ads3_img' => '',
		'ads3_url' =>'',
		'ads4_img' => '',
		'ads4_url' =>'',
		'ads5_img' => '',
		'ads5_url' =>'',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	    
	    

	    <p>
			<label for="<?php echo $this->get_field_id( 'new_tab' ); ?>"><?php _e( 'Open in new tab? ','hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'new_tab' ); ?>" name="<?php echo $this->get_field_name( 'new_tab' ); ?>">
				<option value="y" <?php if ( "y"==$instance['new_tab'] ) echo ' selected="selected"'; ?>><?php _e('Yes','hbthemes'); ?></option>
				<option value="n" <?php if ( "n"==$instance['new_tab'] ) echo ' selected="selected"'; ?>><?php _e('No','hbthemes'); ?></option>
			</select>
		</p>

		<?php 
		for($i=1 ; $i<6 ; $i++ ){ ?>
		<em style="display:block; border-bottom:1px solid #CCC; margin:20px 0 5px; font-weight:bold">ADS <?php echo $i; ?> :</em>

		<p>
	      <label for="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>">Upload Image. You can use any size. Image will fit the widget area.</label><br />
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_img' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_img' ); ?>" value="<?php echo $instance['ads'.$i.'_img']; ?>" class="img widefat" type="text" />
			<input type="button" style="margin-top:4px; margin-left:2px;" class="button select-image" value="Select Image" />
	    </p>

		<p>
			<label for="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>"><?php _e('Enter link. <small>Example: http://hb-themes.com</small>','hbthemes'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ads'.$i.'_url' ); ?>" name="<?php echo $this->get_field_name( 'ads'.$i.'_url' ); ?>" value="<?php echo $instance['ads'.$i.'_url']; ?>" class="widefat" type="text" />
		</p>
		<?php } ?>

	<?php
	}
}

?>