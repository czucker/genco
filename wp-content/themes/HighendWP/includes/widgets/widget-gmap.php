<?php
/*
 * Plugin Name: GMap Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays Google Map.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_gmap_widgets' );

/*
 * Register widget.
 */
function hb_gmap_widgets() {
	register_widget( 'HB_Gmap_Widget' );
}

class hb_gmap_widget extends WP_Widget {

	function HB_Gmap_Widget() {
		$widget_ops = array( 'classname' => 'widget_gmap', 'description' => __( 'A widget that displays Google Map.', 'hbthemes' ) );
		$this->WP_Widget( 'gmap','[HB-Themes] Google Maps', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$latitude = !empty( $instance['latitude'] )?$instance['latitude']:0;
		$longitude = !empty( $instance['longitude'] )?$instance['longitude']:0;
		$panControl = !empty( $instance['panControl'] )?$instance['panControl']:false;
		$scrollwheel = !empty( $instance['scrollwheel'] )?$instance['scrollwheel']:false;
		$zoomControl = !empty( $instance['zoomControl'] )?$instance['zoomControl']:false;
		$mapTypeControl = !empty( $instance['mapTypeControl'] )?$instance['mapTypeControl']:false;
		$scaleControl = !empty( $instance['scaleControl'] )?$instance['scaleControl']:false;
		$draggable = !empty( $instance['draggable'] )?$instance['draggable']:false;
		$enable_border = !empty( $instance['enable_border'] )?$instance['enable_border']:false;

		$zoom = (int)$instance['zoom'];
		$height = (int)$instance['height'];

		if ( $zoom < 1 ) {
			$zoom = 1;
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$id = mt_rand( 100, 3000 );
?>
		
		<?php if ( $enable_border ) { ?>
		<div class="hb-box-frame clearfix"><span><?php } ?>
			<div id="gmap_widget_<?php echo $id;?>" class="google-map" style="height:<?php echo $height;?>px; width:100%;"></div>
		<?php if ( $enable_border ) { ?>
		</span></div>
		<?php } ?>
			<script type="text/javascript">
			jQuery(window).load(function($) {
				google.load("maps", "3", {other_params:'sensor=false', callback: function(){
	  				var map;
					var gmap_marker = true;

					function initialize() {
						var myLatlng = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>)
						var mapOptions = {
							zoom: <?php echo $zoom;?>,
							center: myLatlng,
							panControl: <?php echo $panControl ? 'true' : 'false';?>,
							scrollwheel: <?php echo $scrollwheel ? 'true' : 'false';?>,
							zoomControl: <?php echo $zoomControl ? 'true' : 'false';?>,
							mapTypeControl: <?php echo $mapTypeControl ? 'true' : 'false';?>,
							scaleControl: <?php echo $scaleControl ? 'true' : 'false';?>,
							draggable: <?php echo $draggable ? 'true' : 'false';?>,
						    mapTypeId: google.maps.MapTypeId.ROADMAP,
						};
						map = new google.maps.Map(document.getElementById('gmap_widget_<?php echo $id;?>'), mapOptions);

						if(gmap_marker == true) {
							var marker = new google.maps.Marker({
								position: myLatlng,
								map: map
							});
						}
      				}
 					initialize();
 				}});
			});
			</script>

			<div class="clearboth"></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['latitude'] = strip_tags( $new_instance['latitude'] );
		$instance['longitude'] = strip_tags( $new_instance['longitude'] );
		$instance['zoom'] = (int) $new_instance['zoom'];
		$instance['height'] = (int) $new_instance['height'];

		$instance['draggable'] = !empty( $new_instance['draggable']) ? true : false;
		$instance['scaleControl'] = !empty( $new_instance['scaleControl']) ? true : false;
		$instance['mapTypeControl'] = !empty( $new_instance['mapTypeControl']) ? true : false;
		$instance['zoomControl'] = !empty( $new_instance['zoomControl']) ? true : false;
		$instance['scrollwheel'] = !empty( $new_instance['scrollwheel']) ? true : false;
		$instance['panControl'] = !empty( $new_instance['panControl']) ? true : false;
		$instance['enable_border'] = !empty( $new_instance['enable_border']) ? true : false;



		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$latitude = isset( $instance['latitude'] ) ? esc_attr( $instance['latitude'] ) : '';
		$longitude = isset( $instance['longitude'] ) ? esc_attr( $instance['longitude'] ) : '';
		$zoom = isset( $instance['zoom'] ) ? absint( $instance['zoom'] ) : 14;
		$height = isset( $instance['height'] ) ? absint( $instance['height'] ) : 250;


		$panControl = isset( $instance['panControl'] ) ? (bool)$instance['panControl'] : false;
		$scrollwheel = isset( $instance['scrollwheel'] ) ? (bool)$instance['scrollwheel'] : false;
		$zoomControl = isset( $instance['zoomControl'] ) ? (bool)$instance['zoomControl'] : false;
		$mapTypeControl = isset( $instance['mapTypeControl'] ) ?  (bool)$instance['mapTypeControl'] : false;
		$scaleControl = isset( $instance['scaleControl'] ) ? (bool)$instance['scaleControl'] : false;
		$draggable = isset( $instance['draggable'] ) ? (bool)$instance['draggable']  : false;
		$enable_border = isset( $instance['enable_border'] ) ? (bool)$instance['enable_border']  : false;


?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'hbthemes' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'latitude' ); ?>"><?php _e( 'Latitude:', 'hbthemes' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'latitude' ); ?>" name="<?php echo $this->get_field_name( 'latitude' ); ?>" type="text" value="<?php echo $latitude; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'longitude' ); ?>"><?php _e( 'Longitude:', 'hbthemes' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'longitude' ); ?>" name="<?php echo $this->get_field_name( 'longitude' ); ?>" type="text" value="<?php echo $longitude; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'zoom' ); ?>"><?php _e( 'Zoom Level', 'hbthemes' ); ?></label>
		<input class="widefat"  id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>" type="text" value="<?php echo $zoom; ?>" size="3" />
		<em>From 1 to 19, default : 14</em>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height of the map:', 'hbthemes' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo $height; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'scrollwheel' ); ?>" name="<?php echo $this->get_field_name( 'scrollwheel' ); ?>"<?php checked( $scrollwheel ); ?> />
		<label for="<?php echo $this->get_field_id( 'scrollwheel' ); ?>"><?php _e( 'Enable Scroll Wheel', 'hbthemes' ); ?></label></p>


		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'panControl' ); ?>" name="<?php echo $this->get_field_name( 'panControl' ); ?>"<?php checked( $panControl ); ?> />
		<label for="<?php echo $this->get_field_id( 'panControl' ); ?>"><?php _e( 'Enable Pan Control', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'zoomControl' ); ?>" name="<?php echo $this->get_field_name( 'zoomControl' ); ?>"<?php checked( $zoomControl ); ?> />
		<label for="<?php echo $this->get_field_id( 'zoomControl' ); ?>"><?php _e( 'Enable Zoom Control', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'mapTypeControl' ); ?>" name="<?php echo $this->get_field_name( 'mapTypeControl' ); ?>"<?php checked( $mapTypeControl ); ?> />
		<label for="<?php echo $this->get_field_id( 'mapTypeControl' ); ?>"><?php _e( 'Enable Map Type Control', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'scaleControl' ); ?>" name="<?php echo $this->get_field_name( 'scaleControl' ); ?>"<?php checked( $scaleControl ); ?> />
		<label for="<?php echo $this->get_field_id( 'scaleControl' ); ?>"><?php _e( 'Enable Scale Control', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'draggable' ); ?>" name="<?php echo $this->get_field_name( 'draggable' ); ?>"<?php checked( $draggable ); ?> />
		<label for="<?php echo $this->get_field_id( 'draggable' ); ?>"><?php _e( 'Enable Draggable', 'hbthemes' ); ?></label></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'enable_border' ); ?>" name="<?php echo $this->get_field_name( 'enable_border' ); ?>"<?php checked( $enable_border ); ?> />
		<label for="<?php echo $this->get_field_id( 'enable_border' ); ?>"><?php _e( 'Enable Border', 'hbthemes' ); ?></label></p>

<?php
	}
}
/***************************************************/