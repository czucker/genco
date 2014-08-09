<?php
/*
 * Plugin Name: Contact Info Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays embedded video.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_contact_info_widget' );

/*
 * Register widget.
 */
function hb_contact_info_widget() {
	register_widget( 'HB_Contact_Info_Widget' );
}

/*
 * Widget class.
 */
class hb_contact_info_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function HB_Contact_Info_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'hb_contact_info_widget', 'description' => __('A widget that displays your contact info.', 'hbthemes') );
		$control_ops = array ();
		/* Create the widget. */
		$this->WP_Widget( 'hb_contact_info_widget', __('[HB-Themes] Contact Info Widget','hbthemes'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
		global $wp_query;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$company = $instance['company'];
		$person = $instance['person'];
		$phone = $instance['phone'];
		$fax = $instance['fax'];
		$email = $instance['email'];
		$address = $instance['address'];
		$website = $instance['website'];
		$skype = $instance['skype'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title; ?>

		<ul>
			<?php if ( !empty( $person ) ):?><li><i class="hb-moon-user-7"></i><span><?php echo $person;?></span></li><?php endif;?>	
			<?php if ( !empty( $company ) ):?><li><i class="hb-moon-office"></i><span><?php echo $company;?></span></li><?php endif;?>
			<?php if ( !empty( $address ) ):?><li><i class="hb-moon-location-4"></i><span><?php echo $address;?></span></li><?php endif;?>
			<?php if ( !empty( $phone ) ):?><li><i class="hb-moon-phone-2"></i><span><?php echo $phone;?></span></li><?php endif;?>
			<?php if ( !empty( $fax ) ):?><li><i class="icon-print"></i><span><?php echo $fax;?></span></li><?php endif;?>
			<?php if ( !empty( $email ) ):?><li><i class="icon-envelope-alt"></i><span><a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email);?></a></span></li><?php endif;?>
			<?php if ( !empty( $website ) ):?><li><i class="hb-moon-earth"></i><span><a href="<?php echo $website; ?>" target="_blank"><?php echo str_replace('http://', '', $website); ?></a></span></li><?php endif;?>
			<?php if ( !empty( $skype ) ):?><li><i class="hb-moon-skype"></i><span><a href="skype:<?php echo $skype; ?>?call"><?php echo $skype;?></a></span></li><?php endif;?>
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
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['fax'] = strip_tags( $new_instance['fax'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['website'] = strip_tags( $new_instance['website'] );
		$instance['person'] = strip_tags( $new_instance['person'] );
		$instance['company'] = strip_tags( $new_instance['company'] );
		$instance['skype'] = strip_tags( $new_instance['skype'] );

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
		'title' => 'Contact Info Widget',
		'phone' => '',
		'fax' => '',
		'email' => '',
		'address' => '',
		'website' => '',
		'person' => '',
		'company' => '',
		'skype' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','hbthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'person' ); ?>"><?php _e('Person:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'person' ); ?>" name="<?php echo $this->get_field_name( 'person' ); ?>" type="text" value="<?php echo $instance['person']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'company' ); ?>"><?php _e('Company:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'company' ); ?>" name="<?php echo $this->get_field_name( 'company' ); ?>" type="text" value="<?php echo $instance['company']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Address:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $instance['address']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e('Phone:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $instance['phone']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e('Fax:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" type="text" value="<?php echo $instance['fax']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $instance['email']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'website' ); ?>"><?php _e('Website:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'website' ); ?>" name="<?php echo $this->get_field_name( 'website' ); ?>" type="text" value="<?php echo $instance['website']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Skype Username:', 'hbthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" type="text" value="<?php echo $instance['skype']; ?>" /></p>

		
	<?php
	}
}
?>