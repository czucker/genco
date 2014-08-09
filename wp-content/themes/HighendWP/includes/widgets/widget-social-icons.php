<?php
/*
 * Plugin Name: Social Network Icons Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays social networks specified in Highend Options panel.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_soc_net_widgets' );

/*
 * Register widget.
 */
function hb_soc_net_widgets() {
	register_widget( 'HB_SocNet_Widget' );
}

/*
 * Widget class.
 */
class hb_socnet_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_SocNet_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb-socials-widget', 'description' => __('A widget that displays social networks specified in Highend Options panel.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_soc_net_widget', __('[HB-Themes] Social Network Icons','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
		global $wp_query;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$large_icons = $instance['large_icons'];
		$icon_style = $instance['icon_style'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; ?>

		<ul class="social-icons <?php echo $icon_style; ?> <?php echo $large_icons; ?> clearfix">
            <?php
                $hb_socials = hb_options('hb_top_header_socials');
                if ( !empty ( $hb_socials ) ) {
                    foreach ($hb_socials as $hb_social) {
                    	if ( $hb_social == 'custom-url' ){
                            $hb_social_n = 'link-5';
                        } else {
                        	$hb_social_n = $hb_social;
                        }
                    ?>
                    <?php if ( $hb_social_n != 'behance' ) { ?>
                    <li class="<?php echo $hb_social; ?>">
                        <a href="<?php echo hb_options('hb_' . $hb_social . '_link'); ?>" original-title="<?php echo ucfirst($hb_social); ?>">
                        	<i class="hb-moon-<?php echo $hb_social_n; ?>"></i>
                        	<i class="hb-moon-<?php echo $hb_social_n; ?>"></i>
                        </a> 
                    </li>
                    <?php } else { ?>
                    		<li class="<?php echo $hb_social; ?>">
		                        <a href="<?php echo hb_options('hb_' . $hb_social . '_link'); ?>" original-title="<?php echo ucfirst($hb_social); ?>">
		                        	<i class="icon-<?php echo $hb_social_n; ?>"></i>
		                        	<i class="icon-<?php echo $hb_social_n; ?>"></i>
		                        </a> 
		                    </li>
                    	<?php }
                    }
                }
            ?>        
		</ul>

		<?php echo $after_widget;
	}
	
	

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['large_icons'] = strip_tags($new_instance['large_icons']);
		$instance['icon_style'] = strip_tags($new_instance['icon_style']);

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
		'title' => 'Social Icons Widget',
		'large_icons' => 'normal',
		'icon_style' => 'dark',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'large_icons' ); ?>"><?php _e( 'Icon Size:', 'hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'large_icons' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'large_icons' ); ?>">
				<option <?php if ( 'large' == $instance['large_icons'] ) echo ' selected="selected"';?> value='large'><?php _e('Large','hbthemes'); ?></option>
				<option <?php if ( 'normal' == $instance['large_icons'] ) echo ' selected="selected"';?> value='normal'><?php _e('Normal','hbthemes'); ?></option>
				<option <?php if ( 'small' == $instance['large_icons'] ) echo ' selected="selected"';?> value='small'><?php _e('Small', 'hbthemes'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'icon_style' ); ?>"><?php _e( 'Icon Style:', 'hbthemes'); ?></label>
			<select id="<?php echo $this->get_field_id( 'icon_style' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'icon_style' ); ?>">
				<option <?php if ( 'dark' == $instance['icon_style'] ) echo ' selected="selected"';?> value='dark'><?php _e('Dark','hbthemes'); ?></option>
				<option <?php if ( 'light' == $instance['icon_style'] ) echo ' selected="selected"';?> value='light'><?php _e('Light', 'hbthemes'); ?></option>
			</select>
		</p>

		
	<?php
	}
}
?>