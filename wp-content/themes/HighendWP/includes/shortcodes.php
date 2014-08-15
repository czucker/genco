<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php

/* -----------------------------------------------
THEME SHORTCODES
-------------------------------------------------- */

/* FULLWIDTH PORTFOLIO
-------------------------------------------------- */
function hb_portfolio_fullwidth_shortcode($params = array()) {

	extract(shortcode_atts(array(
		'count' => '-1',
		'columns' => '4',
		'ratio' => 'ratio1',
		'orientation' => 'landscape',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'margin_top' => '',
		'margin_bottom' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}


	if ( is_numeric($margin_bottom)) $margin_bottom = $margin_bottom . 'px';
	if ( is_numeric($margin_top)) $margin_top = $margin_top .'px';
	$style = "";
	if ( $margin_bottom || $margin_top ) {
		$style = ' style="';
		if ( $margin_bottom ) $style .= 'margin-bottom:' . $margin_bottom . ';';
		if ( $margin_top ) $style .= 'margin-top:' . $margin_top . ';';
		$style .= '"';
	}

	$output = "";
	$image_dimensions = get_image_dimensions ( $orientation, $ratio, 1000 );


	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'portfolio',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $count,
				'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'portfolio',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $count,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-portfolio-fullwidth gallery-carousel-wrapper-2' . $class . $animation . '"' . $animation_delay . $style . '>';
	$output .= '<div class="fw-section without-border light-text">';
	$output .= '<div class="content-total-fw">';
	$output .= '<div class="hb-fw-elements columns-' . $columns . '">';

	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$thumb = get_post_thumbnail_id(); 
		$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );

		$output .= '<div class="hb-fw-element">';
		$output .= '<a href="' . get_permalink() . '">';

		if ( $image )
			$output .= '<img src="' . $image['url'] . '" width="'. $image['width'] .'" height="'. $image['height'] .'" alt="' . get_the_title() . '"/>';
		
		$output .= '<div class="item-overlay-text">';
		$output .= '<div class="item-overlay-text-wrap">';
		$output .= '<h4><span class="hb-gallery-item-name">' . get_the_title() . '</span></h4>';
		$output .= '<div class="hb-small-separator"></div>';
		$output .= '<span class="item-count-text">' . get_the_time('j M Y') . '</span>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</a>';
		$output .= '</div>';
	endwhile;

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	endif;

	wp_reset_query();
	
	return $output;  
}
add_shortcode('portfolio_fullwidth', 'hb_portfolio_fullwidth_shortcode');

/* FULLWIDTH GALLERY
-------------------------------------------------- */
function hb_gallery_fullwidth_shortcode($params = array()) {

	extract(shortcode_atts(array(
		'count' => '-1',
		'columns' => '4',
		'ratio' => 'ratio1',
		'orientation' => 'landscape',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";
	$image_dimensions = get_image_dimensions ( $orientation, $ratio, 1000 );


	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'gallery',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $count,
				'tax_query' => array(
						array(
							'taxonomy' => 'gallery_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'gallery',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $count,
				'status' => 'publish',
			));
	}

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-portfolio-fullwidth gallery-carousel-wrapper-2' . $class . $animation . '"' . $animation_delay . '>';
	$output .= '<div class="fw-section without-border light-text">';
	$output .= '<div class="content-total-fw">';
	$output .= '<div class="hb-fw-elements columns-' . $columns . '">';

	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$thumb = get_post_thumbnail_id(); 
		$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
		$full_image = wp_get_attachment_image_src($thumb,'full');
		$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
		$unique_id = rand(1,10000);

		if ( !$image && !empty($gallery_attachments))
		{
			reset($gallery_attachments);
			$thumb = key($gallery_attachments);
			$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
			$full_image = wp_get_attachment_image_src($thumb,'full');
		}

		$output .= '<div class="hb-fw-element">';
		$output .= '<a href="' . $full_image[0] . '" rel="prettyPhoto[gallery_' . $unique_id . ']">';

		if ( $image )
			$output .= '<img src="' . $image['url'] . '" width="'. $image['width'] .'" height="'. $image['height'] .'" alt="' . get_the_title() . '"/>';
		
		$output .= '<div class="item-overlay-text">';
		$output .= '<div class="item-overlay-text-wrap">';
		$output .= '<h4><span class="hb-gallery-item-name">' . get_the_title() . '</span></h4>';
		$output .= '<div class="hb-small-separator"></div>';
		$output .= '<span class="item-count-text">' . get_the_time('j M Y') . '</span>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</a>';
		$output .= '</div>';

		if ( !empty ( $gallery_attachments ) ) {
			$output .= '<div class="hb-reveal-gallery">';
			foreach ( $gallery_attachments as $gal_id => $gal_att ) {
				if( $gal_id != $thumb )
					$output .= '<a href="' . $gal_att['url'] . '" title="' . $gal_att['description'] . '" rel="prettyPhoto[gallery_' . $unique_id . ']"></a>';
			}
			$output .= '</div>';
		}

	endwhile;

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	endif;
	
	wp_reset_query();

	return $output;  
}
add_shortcode('gallery_fullwidth', 'hb_gallery_fullwidth_shortcode');


/* TOGGLE
-------------------------------------------------- */
function hb_toggle_group_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'initial_index' => '-1',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $class ) $class = ' ' . $class;
	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="hb-toggle' . $class . $animation . '" data-initialindex="' . $initial_index . '"' . $animation_delay . '>';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
add_shortcode('toggle_group', 'hb_toggle_group_shortcode');

function hb_toggle_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'icon' => '',
		'title' => 'Toggle',
	), $params));


	$output = '<div class="hb-accordion-single">';
	$output .= '<div class="hb-accordion-tab">';

	if ( $icon ) {
		$output .= '<i class="' . $icon . '"></i>';
	}

	if ( $title ) {
		$output .= $title . '<i class="icon-angle-right"></i>';
	}

	$output .= '</div>';
	$output .= '<div class="hb-accordion-pane">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('toggle_item', 'hb_toggle_shortcode');

/* ACCORDION
-------------------------------------------------- */
function hb_accordion_group_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'initial_index' => '-1',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $class ) $class = ' ' . $class;
	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="hb-accordion' . $class . $animation . '" data-initialindex="' . $initial_index . '"' . $animation_delay . '>';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
add_shortcode('accordion_group', 'hb_accordion_group_shortcode');

function hb_accordion_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'icon' => '',
		'title' => 'Accordion',
	), $params));


	$output = '<div class="hb-accordion-single">';
	$output .= '<div class="hb-accordion-tab">';

	if ( $icon ) {
		$output .= '<i class="' . $icon . '"></i>';
	}

	if ( $title ) {
		$output .= $title . '<i class="icon-angle-right"></i>';
	}

	$output .= '</div>';
	$output .= '<div class="hb-accordion-pane">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('accordion_item', 'hb_accordion_shortcode');

/* ICON
-------------------------------------------------- */
function hb_icon_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'name' => 'hb-moon-brain',
		'size' => '',
		'color' => '',
		'float' => '',
		'jump' => 'no',
		'link' => '',
		'new_tab' => 'no',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($new_tab == 'yes'){
		$new_tab = ' target="_blank"';
	} else {
		$new_tab = ' target="_self"';
	}

	if ( $class ) $class = ' ' . $class;
	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}


	if ( is_numeric($margin_bottom)) $margin_bottom = $margin_bottom . 'px';
	if ( is_numeric($margin_top)) $margin_top = $margin_top .'px';
	$style = "";
	if ( $margin_bottom || $margin_top ) {
		$style = ' style="';
		if ( $margin_bottom ) $style .= 'margin-bottom:' . $margin_bottom . ';';
		if ( $margin_top ) $style .= 'margin-top:' . $margin_top . ';';
		$style .= '"';
	}

	if ($float == 'none'){
		$float = ' hb-icon-float-none aligncenter';
	} else if ( $float == 'left' ){
		$float = ' hb-icon-float-left';
	} else if ( $float == 'right' ){
		$float = ' hb-icon-float-right';
	} else {
		$float = ' hb-icon-float-left';
	}

	if ($jump == 'yes'){
		$jump = ' hb-jumping';
	} else {
		$jump = '';
	}

	if ($size == 'large'){
		$size = ' hb-icon-large';
	} else if ($size == 'small'){
		$size = ' hb-icon-small';
	} else {
		$size = ' hb-icon-medium';
	}

	if ($color != ''){
		if ($color[0] == '#'){
			$color = ' style="color:'.$color.'"';
		} else {
			$color = ' style="color:#'.$color.'"';
		}
	}

	$output = "";
	if ($link != ''){
		$output .= '<a href="'.$link.'"'.$new_tab.'><i class="'.$name.$float.$jump.$size.' hb-icon"'.$color.'></i></a>';
	} else {
		$output .= '<i class="'.$name.$float.$jump.$size.' hb-icon"'.$color.'></i>';
	}

	return $output;
}
add_shortcode('icon', 'hb_icon_shortcode');

/* FAQ
-------------------------------------------------- */
function hb_faq_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'category' => '',
		'filter' => '',
		'animation' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $class ) $class = ' ' . $class;

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'faq',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => -1,
				'tax_query' => array(
						array(
							'taxonomy' => 'faq_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'faq',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => -1,
				'status' => 'publish',
			));
	}

	$output = "";

	$output .= '<div class="shortcode-wrapper shortcode-faq-module clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="faq-module-wrapper clearfix">';

	if ( $filter == 'yes' ) {
		$faq_categories = array();
		if ( $queried_items->have_posts() ) : while ( $queried_items->have_posts() ) : $queried_items->the_post(); 
			$faq_post_categories = wp_get_post_terms( get_the_ID(), 'faq_categories', array("fields" => "all"));
			if ( !empty ( $faq_post_categories) )
			{
				foreach($faq_post_categories as $faq_category)
				{
					$faq_categories[$faq_category->slug] = $faq_category->name;
				}
			}
		endwhile; endif;
		array_unique($faq_categories);

		$output .= '<div class="filter-tabs-wrapper clearfix">';
		$output .= '<ul class="filter-tabs faq-filter clearfix">';
		$output .= '<li class="selected"><a href="#" data-filter="*" data-filter-name="' . __('All','hbthemes'). '">' . __('All' , 'hbthemes') . ' <span class="hb-filter-count">(0)</span></a></li>';
		if ( !empty($faq_categories) ) { 
			foreach ( $faq_categories as $slug=>$name ) { 
				$output .= '<li><a href="#" data-filter="' . $slug . '" data-filter-name="' . $name . '">' . $name . ' <span class="hb-filter-count">(0)</span></a></li>';
			}
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="spacer" style="height:20px;"></div>';
	}

	if ( $queried_items->have_posts() ) : while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$unique_id = rand(1,10000);
		$faq_cats = wp_get_post_terms(get_the_ID() , 'faq_categories' , array("fields"=>"slugs"));
		$faq_cats_string = implode ( $faq_cats , " ");

		if ( $faq_cats_string ) $faq_cats_string = ' ' . $faq_cats_string;

		$output .= '<div id="hb-toggle-' . $unique_id . '" class="hb-toggle' . $faq_cats_string . '">';
		$output .= '<div class="hb-accordion-single">';
		$output .= '<div class="hb-accordion-tab"><i class="hb-moon-plus-circle"></i> ' . get_the_title() . '<i class="icon-angle-right"></i></div>';
		$output .= '<div class="hb-accordion-pane" style="display: none;">';
		$output .= do_shortcode(get_the_content());
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

	endwhile; endif;
	wp_reset_query();

	$output .= '</div>';
	$output .= '</div>';


	return $output;
}
add_shortcode('faq', 'hb_faq_shortcode');

/* ROW
-------------------------------------------------- */
function hb_row_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'margin_top' => '',
		'margin_bottom' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $class ) $class = ' ' . $class;
	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}


	if ( is_numeric($margin_bottom)) $margin_bottom = $margin_bottom . 'px';
	if ( is_numeric($margin_top)) $margin_top = $margin_top .'px';
	$style = "";
	if ( $margin_bottom || $margin_top ) {
		$style = ' style="';
		if ( $margin_bottom ) $style .= 'margin-bottom:' . $margin_bottom . ';';
		if ( $margin_top ) $style .= 'margin-top:' . $margin_top . ';';
		$style .= '"';
	}
	$output = '<div class="row clearfix' . $class . $animation . '"' . $style . $animation_delay . '>' . do_shortcode ( $content ) . '</div>';
	return $output;
}
add_shortcode('row', 'hb_row_shortcode');

/* ALIGNCENTER
-------------------------------------------------- */
function hb_aligncenter_shortcode($params = array(), $content = null) {	
	return '<div class="hb-aligncenter">' . do_shortcode($content) . '</div>';
}
add_shortcode('align_center', 'hb_aligncenter_shortcode');

/* COLUMN
-------------------------------------------------- */
function hb_column_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'size' => '',
		'class' => '',
		'margin_top' => '',
		'animation' => '',
		'animation_delay' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $margin_top != '' )
		return '<div class="' . $size . ' '. $class . $animation .'" style="margin-top:' . $margin_top . '"'. $animation_delay .'>' . do_shortcode($content) . '</div>';
	else
		return '<div class="' . $size . ' '. $class . $animation .'"'.$animation_delay.'>' . do_shortcode($content) . '</div>';
}
add_shortcode('column', 'hb_column_shortcode');

/* FULLWIDTH GOOGLE MAP
-------------------------------------------------- */
function hb_fw_map_embed_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'latitude' => '48.856614',
		'longitude' => '2.352222',
		'from_to' => 'no',
		'zoom' => '16',
		'custom_pin' => '',
		'height' => '350',
		'margin_bottom' => '',
		'margin_top' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$classes = "map-wrapper shadow";

	if ($margin_top != ''){
		$margin_top = 'margin-top: ' . $margin_top . ';';
	}

	if ($margin_bottom != ''){
		$margin_bottom = 'margin-bottom: ' . $margin_bottom . ';';
	}

	$margins = ' style="'.$margin_top.$margin_bottom . '"';

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $custom_pin == "" )
		$custom_pin = hb_options('hb_custom_marker_image'); 
	else if ( is_numeric($custom_pin)) {
		$custom_pin = wp_get_attachment_image_src ( $custom_pin, 'full');
		$custom_pin = $custom_pin[0];
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$style = "";
	if ( $height != "" ) 
		$style = ' style="height:' . $height . 'px;"';

	$output = "";

	$output .= '<div class="fw-section without-border"'.$margins.'>';
	$output .= '<div class="content-total-fw">';

	$output .= '<div class="shortcode-wrapper shortcode-map-embed clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="' . $classes . '">';
	$output .= '<div class="hb-gmap-map" data-show-location="0" data-map-level="' . $zoom . '" data-map-lat="' . $latitude . '" data-map-lng="' . $longitude . '" data-map-img="' . $custom_pin . '" data-overlay-color="';
	
		if ( hb_options('hb_enable_map_color') ) 
		{ 
			$output .= hb_options('hb_map_focus_color'); 
		} 
		else { $output .= 'none'; }

	$output .= '"' . $style . '></div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('fw_map_embed', 'hb_fw_map_embed_shortcode');

/* PROCESS STEPS 
-------------------------------------------------- */
function hb_process_steps_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$steps = substr_count($content, '/process_step');

	$output = '<div class="hb-process-steps clearfix steps-' . $steps . ' ' . $animation . $class . '"' . $animation_delay . '>';
	$output .= '<ul class="hb-process">';
	$output .= do_shortcode($content);
	$output .= '</ul>';
	$output .= '</div>';
	return $output;  
}
add_shortcode('process_steps', 'hb_process_steps_shortcode');

/* PROCESS STEP
-------------------------------------------------- */
function hb_process_step_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'title' => '',
		'icon' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));
	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}
	$output = '<li><div class="feature-box aligncenter">';

	if ( $icon ) {
		if ( is_numeric($icon) )
			$output .= '<i class="ic-holder-1">' . $icon . '</i>';
		else
			$output .= '<i class="' . $icon . ' ic-holder-1"></i>';
	}

	if ( $title ) {
		$output .= '<h4 class="bold">' . $title . '</h4>';
		$output .= '<div class="hb-small-break"></div>';
	}

	if ( $content )
		$output .= '<p>' . $content . '</p>';
	
	$output .= '</div></li>';
							

	return $output;  
}
add_shortcode('process_step', 'hb_process_step_shortcode');

/* PRICING TABLE 
-------------------------------------------------- */
function hb_pricing_table_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'pricing_item' => '',
		'style' => '',
		'columns' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( !$style ) $style = "standard";
	if ( !$columns ) $columns = 4;

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$query = new WP_Query( array( 'post_type' => 'hb_pricing_table', 'post__in' => array( $pricing_item ) ) );
	
	if ( $query->have_posts() ) : 
		$output = '<div class="hb-pricing-table-wrapper pricing-' . $style . ' columns-' . $columns . ' clearfix' . $class . $animation . '"' . $animation_delay . '>';
		while ( $query->have_posts() ) : $query->the_post();
			$items = vp_metabox('pricing_settings.hb_pricing_table_items');
			if (!empty($items)) {
				foreach ($items as $item) {

					$item_list = $item['hb_list_items'];

					if ( $item['hb_pricing_featured'] )
						$output .= '<div class="hb-pricing-item highlight-table">';
					else
						$output .= '<div class="hb-pricing-item">';

					if ( $item['hb_pricing_ribbon'] != 'none' && $item['hb_pricing_ribbon'] != "" ) {
						if ( $item['hb_pricing_ribbon'] == 'blue' )
							$output .= '<span class="hb-pricing-ribbon alt">' . $item['hb_pricing_featured_ribbon'] . '</span>';
						else
							$output .= '<span class="hb-pricing-ribbon">' . $item['hb_pricing_featured_ribbon'] . '</span>';
					} 

					if ( $item['hb_pricing_price'] ) {
						$bg_color = "";
						if ( $style == "colored" )
							$bg_color = ' style="background:' . $item['hb_pricing_color'] . ';"';
						$output .= '<div class="pricing-table-price"' . $bg_color . '>' . $item['hb_pricing_price'] ;
						if ( $item['hb_pricing_period'] ) $output .= '<span>/ ' . $item['hb_pricing_period'] . '</span>';
						$output .= '</div>';
					}
					if ( $item['hb_pricing_title'] ) {
						$bg_color = "";
						if ( $style == "colored" )
							$bg_color = ' style="background:' . $item['hb_pricing_color'] . ';"';
						$output .= '<div class="pricing-table-caption"' . $bg_color . '>' . $item['hb_pricing_title'] . '</div>';
					}

					$output .= '<div class="pricing-table-content">';
					if ( function_exists('wpb_js_remove_wpautop') )	
						$output .= wpb_js_remove_wpautop($item['hb_pricing_feature_list']);
					else
						$output .= do_shortcode($item['hb_pricing_feature_list']);	
					//$output .= do_shortcode($item['hb_pricing_feature_list']);
					//if ( $item['hb_pricing_button_text'] && $item['hb_pricing_button_link'] )
					//	$output .= '<div class="clear" style="margin-bottom:20px;"></div><a class="hb-button hb-small-button hb-second-dark" href="' . $item['hb_pricing_button_link'] . '" target="_self">' . $item['hb_pricing_button_text'] . '</a>';
					$output .= '</div>';


					$output .= '</div>';
				}
			}
		endwhile;
		$output .= '</div>';
	endif;
	wp_reset_query();

	return $output;  
}
add_shortcode('pricing_table', 'hb_pricing_table_shortcode');

/* BLOG CAROUSEL
-------------------------------------------------- */
function hb_blog_carousel_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'read_more' => '',
		'visible_items' => '4',
		'total_items' => '12',
		'category' => '',
		'excerpt_length' => hb_options('hb_blog_excerpt_length'),
		'orderby' => 'date',
		'order' => 'DESC',
		'carousel_speed' => '5000',
		'auto_rotate' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "true";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( !$excerpt_length ) $excerpt_length = hb_options('hb_blog_excerpt_length');

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'post',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $total_items,
				'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'post',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $total_items,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-blog-carousel blog-carousel-wrapper' . $class . $animation . '"' . $animation_delay . '>';

	// Carousel Nav
	$output .= '<div id="carousel-nav-' . $unique_id . '" class="crsl-nav">';
	$output .= '<a href="#" class="previous"><i class="icon-angle-left"></i></a>';
	$output .= '<a href="#" class="next"><i class="icon-angle-right"></i></a>';
	$output .= '</div>';

	// Carousel Items
	//$output .= '<div class="crsl-items init-carousel" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';

	$output .= '<div class="crsl-items init-carousel" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';
	$output .= '<div class="crsl-wrap">';
	while ( $queried_items->have_posts() ) : $queried_items->the_post();

		$output .= '<div class="blog-shortcode-1 crsl-item">';
		
		if ( hb_options('hb_blog_enable_date') )
			$output .= '<div class="blog-list-item-date">' . get_the_time('d') . '<span>' . get_the_time('M') . '</span></div>';

		$output .= '<div class="blog-list-content';
		if ( !hb_options('hb_blog_enable_date') )
			$output .= ' nlm';
		$output .= '">';
		$output .= '<h6 class="special"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h6>';

		if ( hb_options('hb_blog_enable_comments') && comments_open() ) {
			$comm_num = get_comments_number();
			if ( $comm_num != 1 )
				$output .= '<small>' . $comm_num . __(' Comments' , 'hbthemes') . '</small>';
			else 
				$output .= '<small>' . __('1 Comment' , 'hbthemes') . '</small>';
		}

		$output .= '<div class="blog-list-item-excerpt">';
		$output .= '<p>' . get_the_excerpt() . '</p>';
		//$output .= '<p>' . wp_trim_words( strip_shortcodes( get_the_content() ) , $excerpt_length , NULL) . '</p>';
		if ( $read_more == "yes" )
			$output .= '<a href="' . get_permalink() . '" class="simple-read-more">Read More</a>';
		$output .= '</div>';
		$output .= '</div>';
		
		$output .= '</div>';

	endwhile;

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	endif;
	wp_reset_query();
	
	return $output;  
}
add_shortcode('blog_carousel', 'hb_blog_carousel_shortcode');

/* LIST
-------------------------------------------------- */
function hb_list_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'type' => 'unordered',
		'lined' => 'no',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}
		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}
		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($lined == 'yes'){
		$lined = ' line-list';
	} else {
		$lined = '';
	}

	$output = '';

	if ( $type == 'ordered' ){
		$output = '<div class="shortcode-wrapper shortcode-list clearfix'.$class.$animation.'"'.$animation_delay.'>';
		$output .= '<ol class="hb-ordered-list'.$lined.'">';
		$output .= shortcode_empty_paragraph_fix(do_shortcode($content));
		$output .= '</ol>';
		$output .= '</div>';
	} else if ( $type == 'unordered' ){
		$output = '<div class="shortcode-wrapper shortcode-list clearfix'.$class.$animation.'"'.$animation_delay.'>';
		$output .= '<ul class="hb-unordered-list'.$lined.'">';
		$output .= shortcode_empty_paragraph_fix(do_shortcode($content));
		$output .= '</ul>';
		$output .= '</div>';
	} else {
		$output = '<div class="shortcode-wrapper shortcode-list clearfix'.$class.$animation.'"'.$animation_delay.'>';
		$output .= '<ul class="hb-ul-list'.$lined.'">';
		$output .= shortcode_empty_paragraph_fix(do_shortcode($content));
		$output .= '</ul>';
		$output .= '</div>';
	}

	wpautop( $output, false );
	
	return $output;  
}
add_shortcode('list', 'hb_list_shortcode');

/* LIST ITEM
-------------------------------------------------- */
function hb_list_item_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'icon' => '',
		'color' => ''
	), $params));

	$output = '';

	if ($icon != ''){
		if ($color != ''){
			if ($color[0] == '#'){
				$color = ' style="color:'.$color.'"';
			} else {
				$color = ' style="color:#'.$color.'"';
			}
		}

		$icon = '<i class="'.$icon.'"'.$color.'></i>';
	}

	$output .= '<li>';
	$output .= $icon . do_shortcode($content);
	$output .= '</li>';
	
	return $output;  
}
add_shortcode('list_item', 'hb_list_item_shortcode');

/* ICON COLUMN
-------------------------------------------------- */
function hb_icon_column_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'icon' => 'hb-moon-brain',
		'title' => 'Enter your title here',
		'align' => 'left',
		'link' => '',
		'new_tab' => 'no',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}
		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}
		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($align == 'left'){
		$align = ' alignleft';
	} else if ($align == 'center'){
		$align = ' aligncenter';
	} else {
		$align = ' alignright';
	}

	if ($icon != ''){
		if ( strlen($icon) < 3 ){
			$icon = '<i class="title-icon">'.$icon.'</i>';
		} else {
			$icon = '<i class="'.$icon.' title-icon"></i>';
		}
	}

	if ($new_tab == 'yes'){
		$new_tab = ' target="_blank"';
	} else {
		$new_tab = ' target="_self"';
	}

	$output = '<div class="shortcode-wrapper shortcode-icon-column clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="feature-box standard-icon-box'.$align.'">';

	$output .= '<div class="feature-box-content">';
	if ($link != ''){
		$output .= '<h4 class="bold"><a href="'.$link.'"'.$new_tab.'>'.$icon.$title.'</a></h4>';
	} else {
		$output .= '<h4 class="bold">'.$icon.$title.'</h4>';
	}
	$output .= do_shortcode($content);
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;  
}
add_shortcode('icon_column', 'hb_icon_column_shortcode');

/* SKILLS BAR
-------------------------------------------------- */
function hb_skill_shortcode($params = array()) {

	extract(shortcode_atts(array(   
		'number' => '75',
		'char' => '',
		'caption' => 'Enter Title',
		'color' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	$bg_color = '';

	if ($color != ''){
		if ($color[0] == '#'){
			$bg_color = ' style="background-color:'.$color.';"';
			$color = ' style="color:'.$color.'"';
		} else {
			$bg_color = ' style="background-color:#'.$color.';"';
			$color = ' style="color:#'.$color.'"';
		}
	}

	$output = '<div class="hb-skill-meter clearfix'.$class.'">';
	
	$output .= '<div class="hb-skill-meter-title clearfix">';
	$output .= '<span class="bar-title">'.$caption.'</span>';
	$output .= '<span class="progress-value"'.$color.'"><span class="value">'.$number.'</span>'.$char.'</span>';
	$output .= '</div>';

	$output .= '<div class="hb-progress-bar">';
	$output .= '<span class="progress-outer" data-width="'.$number.'"><span class="progress-inner"'.$bg_color.'></span></span>';
	$output .= '</div>';

	$output .= '</div>';

	
	return $output;  
}
add_shortcode('skill', 'hb_skill_shortcode');

/* ICON FEATURE
-------------------------------------------------- */
function hb_icon_feature_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'icon' => '',
		'icon_position' => 'left',
		'border' => '',
		'title' => '',
		'align' => 'left',
		'image' => '',
		'link' => '',
		'new_tab' => 'no',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($new_tab == 'yes'){
		$new_tab = ' target="_blank"';
	} else {
		$new_tab = ' target="_self"';
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}
		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}
		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($icon != ''){
		if ( strlen($icon) < 3 ){
			$icon = '<i class="ic-holder-1">'.$icon.'</i>';
		} else {
			$icon = '<i class="'.$icon.' ic-holder-1"></i>';
		}
	}

	if ($image != ''){
		$icon = '';
		
		if( strpos($image, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$image = wp_get_attachment_image_src($image, 'full');
			$image = $image[0];
		}

		$image = '<img class="icon-box-img" src="'.$image.'" alt="Feature Image">';
	}

	if ( $border ){
		if ( $border == 'yes' ){
			$border = '';
		} else {
			$border = ' alternative';
		}
	} else {
		$border = ' alternative';
	}

	if ($icon_position == 'left'){
		$icon_position = ' left-icon-box';
	} else if ($icon_position == 'center'){
		$icon_position = '';
	} else {
		$icon_position = ' right-icon-box';
	}

	if ($align == 'left'){
		$align = 'alignleft';
	} else if ($align == 'center'){
		$align = 'aligncenter';
	} else {
		$align = 'alignright';
	}

	if ( $title != '' ){
		if ($link != ''){
			$title = '<h4 class="bold"><a href="'.$link.'"'.$new_tab.'>'.$title.'</a></h4>';
		} else {
			$title = '<h4 class="bold">'.$title.'</h4>';
		}
	}

	$output = '<div class="shortcode-wrapper shortcode-icon-box clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="feature-box'.$border.$icon_position.' aligncenter">';
	
	if ($link != '' && $icon != ''){
		$output .= '<a href="'.$link.'"'.$new_tab.'>' . $icon . '</a>';
	} else if ( $link != '' && $image != '' ){
		$output .= '<a href="'.$link.'"'.$new_tab.'>' . $image . '</a>';
	} else if ( $link == '' ){
		$output .= $icon;
		$output .= $image;
	}

	$output .= '<div class="feature-box-content">';
	$output .= $title;
	if ($icon_position == ''){
		$output .= '<div class="hb-small-break"></div>';
	}
	$output .= '<p>' . do_shortcode($content) . '</p>';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';
	
	return $output;  
}
add_shortcode('icon_feature', 'hb_icon_feature_shortcode');

/* TESTIMONIAL BOX
-------------------------------------------------- */
function hb_testimonial_box_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'type' => 'normal',
		'count' => '4',
		'columns' => '4',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( !$columns ) $columns = 2;

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'hb_testimonials',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $count,
				'tax_query' => array(
						array(
							'taxonomy' => 'testimonial_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'hb_testimonials',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $count,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-testimonial-box testimonial-box-wrapper' . $class . $animation . '"' . $animation_delay . '>';

	$item_count = 0;

	while ( $queried_items->have_posts() ) : $queried_items->the_post();

		if ( $item_count % $columns == 0 )
			$output .= '<div class="row">';
	
		$output .= '<div class="col-' . 12/$columns . '">';
			
		if ( $type == "normal")  {
			$output .= '<div class="hb-testimonial-box">';
			ob_start();
			hb_testimonial_box (get_the_ID());
			$output .= ob_get_clean();
			$output .= '</div>';	
		} else if ( $type == "large" ) {
			$output .= '<div class="hb-testimonial-quote">';
			ob_start();
			hb_testimonial_quote (get_the_ID());
			$output .= ob_get_clean();
			$output .= '</div>';	
		}
		$output .= '</div>';

		if ( $item_count % $columns == $columns - 1 || $item_count == ($queried_items->found_posts) - 1 )
			$output .= '</div>';
	
		$item_count++;

	endwhile;

	$output .= '</div>';
	
	endif;
	wp_reset_query();
	
	return $output;  
}
add_shortcode('testimonial_box', 'hb_testimonial_box_shortcode');

/* TEAM MEMBER BOX
-------------------------------------------------- */
function hb_team_member_box_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'count' => '1',
		'columns' => '1',
		'excerpt_length' => '20',
		'category' => '',
		'style' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "true";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'team',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $count,
				'tax_query' => array(
						array(
							'taxonomy' => 'team_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'team',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $count,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$item_count = 0;
	$output .= '<div class="shortcode-wrapper shortcode-team-member-box ' . $class . $animation . '"' . $animation_delay . '>';
	while ( $queried_items->have_posts() ) : $queried_items->the_post();

		if ( $item_count % $columns == 0 )
			$output .= '<div class="row">';
	
		$output .= '<div class="col-' . 12/$columns . '">';
		ob_start();
		hb_team_member_box (get_the_ID(), $style, $excerpt_length);
		$output .= ob_get_clean();
		$output .= '</div>';

		if ( $item_count % $columns == $columns - 1 || $item_count == ($queried_items->found_posts) - 1 )
			$output .= '</div>';
	
		$item_count++;
	endwhile;
	$output .= '</div>';

	endif;
	wp_reset_query();
	return $output;  
}
add_shortcode('team_member_box', 'hb_team_member_box_shortcode');

/* TEAM MEMBER CAROUSEL
-------------------------------------------------- */
function hb_team_carousel_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'visible_items' => '4',
		'style' => '',
		'total_items' => '12',
		'excerpt_length' => '20',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'carousel_speed' => '5000',
		'auto_rotate' => 'yes',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "true";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'team',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $total_items,
				'tax_query' => array(
						array(
							'taxonomy' => 'team_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'team',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $total_items,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="hb-crsl-wrapper clearfix shortcode-wrapper shortcode-team-carousel ' . $class . $animation . '"' . $animation_delay . '>';

	// Carousel Nav
	$output .= '<div id="carousel-nav-' . $unique_id . '" class="crsl-nav">';
	$output .= '<a href="#" class="previous"><i class="icon-angle-left"></i></a>';
	$output .= '<a href="#" class="next"><i class="icon-angle-right"></i></a>';
	$output .= '</div>';

	// Carousel Items

	$output .= '<div class="crsl-items init-team-carousel" id="carousel-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'" data-navigation="carousel-nav-' . $unique_id . '">';
	$output .= '<div class="crsl-wrap">';
	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$output .= '<figure class="crsl-item">';
		ob_start();
		hb_team_member_box (get_the_ID(), $style, $excerpt_length);
		$output .= ob_get_clean();
		$output .= '</figure>';
	endwhile;
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	
	endif;
	wp_reset_query();

	return $output;  
}
add_shortcode('team_carousel', 'hb_team_carousel_shortcode');

/* TESTIMONIAL SLIDER
-------------------------------------------------- */
function hb_testimonial_slider_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'type' => '',
		'count' => '-1',
		'orderby' => 'date',
		'order' => 'DESC',
		'category' => '',
		'animation_speed' => '',
		'slideshow_speed' => '5000',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}

	$special_class = "ts-1";
	if ( $type == "large" ) {
		$special_class = "ts-2";
	}
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'hb_testimonials',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $count,
				'tax_query' => array(
						array(
							'taxonomy' => 'testimonial_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'hb_testimonials',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $count,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-testimonial-slider testimonial-slider-wrapper' . $class . $animation . '"' . $animation_delay . '>';

	$output .= '<div id="hb-testimonial-' . $unique_id . '" class="'.$special_class.' init-testimonial-slider" data-slideshow-speed="'.$slideshow_speed.'">';
	$output .= '<ul class="testimonial-slider">';
	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		if ( $type == "normal")  {
			$output .= '<li class="hb-testimonial-box">';
			ob_start();
			hb_testimonial_box (get_the_ID());
			$output .= ob_get_clean();
			$output .= '</li>';	
		} else if ( $type == "large" ) {
			$output .= '<li class="hb-testimonial-quote">';
			ob_start();
			hb_testimonial_quote (get_the_ID());
			$output .= ob_get_clean();
			$output .= '</li>';	
		}
	endwhile;

	$output .= '</ul>';
	$output .= '</div>';
	$output .= '</div>';
	
	endif;

	wp_reset_query();
	
	return $output;  
}
add_shortcode('testimonial_slider', 'hb_testimonial_slider_shortcode');

/* CLIENT CAROUSEL
-------------------------------------------------- */
function hb_client_carousel_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'style' => 'simple',
		'visible_items' => '4',
		'total_items' => '12',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'carousel_speed' => '5000',
		'auto_rotate' => 'yes',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( !$style ) $style = 'simple';

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "true";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'clients',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $total_items,
				'tax_query' => array(
						array(
							'taxonomy' => 'client_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'clients',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $total_items,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-client-carousel client-carousel-wrapper' . $class . $animation . '"' . $animation_delay . '>';

	// Carousel Nav
	$output .= '<div id="carousel-nav-' . $unique_id . '" class="crsl-nav">';
	$output .= '<a href="#" class="previous"><i class="icon-angle-left"></i></a>';
	$output .= '<a href="#" class="next"><i class="icon-angle-right"></i></a>';
	$output .= '</div>';

	// Carousel Items
	//$output .= '<div class="crsl-items init-carousel" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';

	$output .= '<ul class="hb-client-list crsl-items init-carousel columns-' . $visible_items . ' ' . $style . ' clearfix" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';
	$output .= '<div class="crsl-wrap">';
	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$thumb = get_post_thumbnail_id();
		$output .= '<li class="crsl-item">';
		if ( vp_metabox('clients_settings.hb_client_url') )
			$output .= '<a href="' . vp_metabox('clients_settings.hb_client_url') . '">';
		else 
			$output .= '<a href="#">';
		$output .= '<img src="' . vp_metabox('clients_settings.hb_client_logo') . '" alt="' . get_the_title() . '" data-title="Optional Caption Here"/></a></li>';
	endwhile;

	$output .= '</div>';
	$output .= '</ul>';
	$output .= '</div>';

	endif;

	wp_reset_query();
	return $output;  
}
add_shortcode('client_carousel', 'hb_client_carousel_shortcode');

/* TEASER
-------------------------------------------------- */
function hb_teaser_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'new_tab' => '',
		'button_link' => '',
		'button_title' => '',
		'style' => '',
		'align' => '',
		'image' => '',
		'title' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($image != ''){
		if( strpos($image, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$image = wp_get_attachment_image_src($image, 'full');
			$image = $image[0];
		}

		$resized_img = hb_resize('',$image, 526, 350, true);
		if ( $resized_img )
			$image = '<img src="'.$resized_img['url'] .'" alt="Teaser Image" />';
	}

	if ($style == 'alternative'){
		$style = ' alternative';
	} else {
		$style = '';
	}

	if ($align == 'alignright'){
		$align = ' alignright';
	} else if ($align == 'alignleft'){
		$align = ' alignleft';
	} else if ($align == 'aligncenter'){
		$align = ' aligncenter';
	} else {
		$align = '';
	}

	if ($title != ''){
		$title = '<h6 class="special">'.$title.'</h6>';
	}

	if ($new_tab == 'yes'){
		$new_tab = ' target="_blank"';
	} else {
		$new_tab = ' target="_self"';
	}

	if ($button_title != ''){
		$button_title = '<div class="clear"></div><a href="'.$button_link.'" class="simple-read-more"'.$new_tab.'>'.$button_title.'</a>';
	}


	$output = '<div class="shortcode-wrapper shortcode-teaser clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="hb-teaser-column'.$style.'">';
	$output .= $image;
	$output .='<div class="teaser-content'.$align.'">';
	$output .= $title;
	$output .= do_shortcode($content);
	$output .= $button_title;
	$output .='</div>';
	$output .= '</div>';
	$output .= '</div>';
	
	return $output;  
}
add_shortcode('teaser', 'hb_teaser_shortcode');

/* ICON BOX
-------------------------------------------------- */
function hb_icon_box_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'icon' => '',
		'icon_color' => '',
		'icon_position' => 'top',
		'title' => '',
		'align' => 'left',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}
		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}
		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($icon_position == 'left'){
		$icon_position = ' left-icon';
	} else {
		$icon_position = ' top-icon';
	}

	if ($icon != ''){

		if ($icon_color != ''){
			if ( substr($icon_color, 0,1) == '#' ){
				$icon_color = substr($icon_color, 1);
			}
			$icon_color = ' style="background-color:#'.$icon_color.';"';
		}

		$icon = '<i class="'.$icon.' box-icon"'.$icon_color.'></i>';
	}

	if ($align == 'left'){
		$align = 'alignleft';
	} else if ($align == 'center'){
		$align = 'aligncenter';
	} else {
		$align = 'alignright';
	}


	$output = '<div class="shortcode-wrapper shortcode-icon-box clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="content-box'.$icon_position.'">';
	$output .= $icon;
	$output .= '<div class="'.$align.'">';
	if ( $title )
		$output .= '<h4 class="semi-bold">' . $title . '</h4>';
	if ( function_exists('wpb_js_remove_wpautop') )	
		$output .= wpb_js_remove_wpautop($content);
	else
		$output .= do_shortcode($content);	
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	return $output;  
}
add_shortcode('icon_box', 'hb_icon_box_shortcode');

/* TITLE
-------------------------------------------------- */
function hb_title_shortcode($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'type' => 'h1',
		'color' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($color != ''){
		if ($color[0] == '#'){
			$color = ' style="color:'.$color.';border-color:'. $color . '"';
		} else {
			$color = ' style="color:#'.$color.';border-color:#'. $color . '"';
		}
	}

	$ret_title = '';

	if ($type == 'extra-large'){
		$ret_title = '<p class="hb-text-large">' . do_shortcode($content) . '</p>';
	} else if ($type == 'h1'){
		$ret_title = '<h1'.$color.'>' . do_shortcode($content) . '</h1>';
	} else if ($type == 'h2'){
		$ret_title = '<h2'.$color.'>' . do_shortcode($content) . '</h2>';
	} else if ($type == 'h3'){
		$ret_title = '<h3'.$color.'>' . do_shortcode($content) . '</h3>';
	} else if ($type == 'h4'){
		$ret_title = '<h4'.$color.'>' . do_shortcode($content) . '</h4>';
	} else if ($type == 'h5'){
		$ret_title = '<h5'.$color.'>' . do_shortcode($content) . '</h5>';
	} else if ($type == 'h6'){
		$ret_title = '<h6'.$color.'>' . do_shortcode($content) . '</h6>';
	} else if ($type == 'special-h3'){
		$ret_title = '<h3'.$color.' class="hb-heading hb-center-heading"><span>' . do_shortcode($content) . '</span></h3>';
	} else if ($type == 'special-h3-left'){
		$ret_title = '<h3'.$color.' class="hb-heading"><span>' . do_shortcode($content) . '</span></h3>';
	} else if ($type == 'special-h3-right'){
		$ret_title = '<h3'.$color.' class="hb-heading hb-right-heading"><span>' . do_shortcode($content) . '</span></h3>';
	} else if($type == 'special-h4'){
		$ret_title = '<h4'.$color.' class="hb-heading hb-center-heading"><span>' . do_shortcode($content) . '</span></h4>';
	} else if ($type == 'special-h4-left'){
		$ret_title = '<h4'.$color.' class="hb-heading"><span>' . do_shortcode($content) . '</span></h4>';
	} else if ($type == 'special-h4-right'){
		$ret_title = '<h4'.$color.' class="hb-heading hb-right-heading"><span>' . do_shortcode($content) . '</span></h4>';
	} else if ($type == 'fancy-h1'){
		$ret_title = '<h1'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h1>';
	} else if ($type == 'fancy-h2'){
		$ret_title = '<h2'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h2>';
	} else if ($type == 'fancy-h3'){
		$ret_title = '<h3'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h3>';
	} else if ($type == 'fancy-h4'){
		$ret_title = '<h4'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h4>';
	} else if ($type == 'fancy-h5'){
		$ret_title = '<h5'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h5>';
	} else if ($type == 'fancy-h6'){
		$ret_title = '<h6'.$color.' class="hb-bordered-heading">' . do_shortcode($content) . '</h6>';
	} else if ($type == 'subtitle-h3'){
		$ret_title = '<h3'.$color.' class="hb-subtitle">' . do_shortcode($content) . '</h3>';
	} else if ($type == 'subtitle-h6'){
		$ret_title = '<h6'.$color.' class="hb-subtitle-small">' . do_shortcode($content) . '</h6>';
	} else if ($type == 'special-h6' || $type == 'h6-special'){
		$ret_title = '<h6 class="special">'. do_shortcode($content) .'</h6>';
	} else {
		$ret_title = '<h1'.$color.'>' . do_shortcode($content) . '</h1>';
	}

	$output = '<div class="shortcode-wrapper shortcode-title clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= $ret_title;
	$output .= '</div>';
	
	return $output;  
}
add_shortcode('title', 'hb_title_shortcode');

/* IMAGE BANNER
-------------------------------------------------- */
function hb_image_banner($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'url' => '',
		'text_color' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($text_color == 'light'){
		$text_color = ' light-style light-text';
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($url != ''){
		if( strpos($url, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$url = wp_get_attachment_image_src($url, 'full');
			$url = $url[0];
		}
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="shortcode-wrapper shortcode-image-banner clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="hb-image-banner-content hb-center-me clearfix '.$text_color.'">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= '<img src="'.$url.'" alt="Banner Image" class="banner-image">';
	$output .= '</div>';

	return $output;  
}
add_shortcode('image_banner', 'hb_image_banner');

/* GALLERY CAROUSEL
-------------------------------------------------- */
function hb_gallery_carousel_shortcode($params = array()) {

	extract(shortcode_atts(array(
		'style' => 'standard',
		'visible_items' => '4',
		'total_items' => '12',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'carousel_speed' => '5000',
		'auto_rotate' => 'yes',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ( $style != 'modern' ) $style = 'standard';
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "true";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'gallery',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $total_items,
				'tax_query' => array(
						array(
							'taxonomy' => 'gallery_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'gallery',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $total_items,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	if ( $style == "standard" )
		$output .= '<div class="shortcode-wrapper shortcode-gallery-carousel gallery-carousel-wrapper-2' . $class . $animation . '"' . $animation_delay . '>';
	else 
		$output .= '<div class="shortcode-wrapper shortcode-gallery-carousel gallery-carousel-wrapper' . $class . $animation . '"' . $animation_delay . '>';

	// Carousel Nav
	$output .= '<div id="carousel-nav-' . $unique_id . '" class="crsl-nav">';
	$output .= '<a href="#" class="previous"><i class="icon-angle-left"></i></a>';
	$output .= '<a href="#" class="next"><i class="icon-angle-right"></i></a>';
	$output .= '</div>';

	// Carousel Items
	$output .= '<div class="crsl-items init-carousel" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';
	$output .= '<div class="crsl-wrap">';

	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$thumb = get_post_thumbnail_id();
		$filters_names = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"names"));
		$filters_names_string = implode ($filters_names, ", ");
		$gallery_rel = "gal_rel_" . rand(1,10000);

		if ( $style == "standard" )
			$output .= '<div class="standard-gallery-item crsl-item" data-value="' . get_the_time('c') . '">';
		else
			$output .= '<div class="gallery-item crsl-item" data-value="' . get_the_time('c') . '">';

		$image = hb_resize($thumb,'',586,349,true);
		$full_image = wp_get_attachment_image_src($thumb, 'full');
		$gallery_attachments = rwmb_meta('hb_gallery_images', array('type' => 'plupload_image', 'size' => 'full') , get_the_ID());
		$filters_names = wp_get_post_terms(get_the_ID() , 'gallery_categories' , array("fields"=>"names"));
		$filters_names_string = implode ($filters_names, ", ");
			
		if ( !$image && !empty($gallery_attachments))
		{
			reset($gallery_attachments);
			$thumb = key($gallery_attachments);
			$image = hb_resize( $thumb, '', $image_dimensions['width'], $image_dimensions['height'], true );
			$full_image = wp_get_attachment_image_src($thumb,'full');
		}
		$gallery_count = count ($gallery_attachments ) + ( get_post_thumbnail_id() ? 1 : 0 );


		if ( $style == "standard" )
			$output .= '<div class="hb-gal-standard-img-wrapper">';

		$output .= '<a href="' . $full_image[0] . '" data-title="' . get_the_title() . '" rel="prettyPhoto[' . $gallery_rel . ']">';
		$output .= '<img src="' . $image['url'] . '" width="'. $image['width'] .'" height="'. $image['height'] .'" alt="Gallery Image" />';
		$output .= '<div class="item-overlay"></div>';
		$output .= '<div class="item-overlay-text">';
		$output .= '<div class="item-overlay-text-wrap">';

		if ( $style == "modern" ) {
			$output .= '<h4><span class="hb-gallery-item-name">' . get_the_title() . '</span></h4>';
			$output .= '<div class="hb-small-separator"></div>';
			$output .= '<span class="item-count-text"><span class="photo-count">' . $gallery_count . '</span>';
			if ( $gallery_count != 1) $output .= __(' Photos' ,'hbthemes');
			else $output .= __(' Photo','hbthemes');
			$output .= '</span>';
		} else {
			$output .= '<span class="plus-sign"></span>';
		}
			
		$output .= '</div>';

		if ( $style == "modern")
			$output .= '<div class="item-date" data-value="' . get_the_time('d F Y') . '">' . get_the_time('d M Y') . '</div>';

		$output .= '</div>';
		$output .= '</a>';

		if ( $style == "standard" )
			$output .= '</div>';
		

		if ( $style == "standard" ) {
			$output .= '<div class="hb-gal-standard-description">';
			$output .= '<h3><a href="' . $full_image[0] . '" data-title="' . get_the_title() . '" rel="prettyPhoto[' . $gallery_rel . ']"><span class="hb-gallery-item-name">' . get_the_title() . '</span></a></h3>';
			$output .= '<div class="hb-small-separator"></div>';
			if ( $filters_names_string ) $output .= '<div class="hb-gal-standard-count">' . $filters_names_string . '</div>';			
			$output .= '</div>';
		}


		if ( !empty ( $gallery_attachments ) ) {
			$output .= '<div class="hb-reveal-gallery">';
			foreach ( $gallery_attachments as $gal_id => $gal_att ) {
				if ( $gal_id != $thumb )
					$output .= '<a href="' . $gal_att['url'] . '" title="' . $gal_att['description'] . '" rel="prettyPhoto[' . $gallery_rel . ']"></a>';
			}
			$output .= '</div>';
		}
		$output .= '</div>';



	endwhile;

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	endif;

	wp_reset_query();
	
	return $output;  
}
add_shortcode('gallery_carousel', 'hb_gallery_carousel_shortcode');

/* PORTFOLIO CAROUSEL
-------------------------------------------------- */
function hb_portfolio_carousel_shortcode($params = array()) {

	extract(shortcode_atts(array(
		'style' => '',
		'visible_items' => '4',
		'total_items' => '12',
		'category' => '',
		'orderby' => 'date',
		'order' => 'DESC',
		'carousel_speed' => '3000',
		'auto_rotate' => 'yes',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));


	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ( $style != 'descriptive' ) $style = 'standard';
	
	if ( $auto_rotate == "no" ) 
		$auto_rotate = "false";
	else 
		$auto_rotate = "5000";
	
	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = "";

	if ( $category ) {
		$category = str_replace(" ", "", $category);
		$category = explode(",", $category);

		$queried_items = new WP_Query( array( 
				'post_type' => 'portfolio',
				'orderby' => $orderby,
				'order' => $order,
				'status' => 'publish',
				'posts_per_page' => $total_items,
				'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_categories',
							'field' => 'slug',
							'terms' => $category
						)
					)			
		));
	} else {
		$queried_items = new WP_Query( array( 
				'post_type' => 'portfolio',
				'orderby' => $orderby,
				'order' => $order,
				'posts_per_page' => $total_items,
				'status' => 'publish',
			));
	}
	$unique_id = rand(1,10000);

	if ( $queried_items->have_posts() ) :

	$output .= '<div class="shortcode-wrapper shortcode-portfolio-carousel gallery-carousel-wrapper-2' . $class . $animation . '"' . $animation_delay . '>';

	// Carousel Nav
	$output .= '<div id="carousel-nav-' . $unique_id . '" class="crsl-nav">';
	$output .= '<a href="#" class="previous"><i class="icon-angle-left"></i></a>';
	$output .= '<a href="#" class="next"><i class="icon-angle-right"></i></a>';
	$output .= '</div>';

	// Carousel Items
	$output .= '<div class="crsl-items init-carousel" id="carousel-' . $unique_id . '" data-navigation="carousel-nav-' . $unique_id . '" data-visible="'.$visible_items.'" data-speed="'.$carousel_speed.'" data-auto-rotate="'.$auto_rotate.'">';
	$output .= '<div class="crsl-wrap">';

	while ( $queried_items->have_posts() ) : $queried_items->the_post();
		$thumb = get_post_thumbnail_id();
		$filters_names = wp_get_post_terms(get_the_ID() , 'portfolio_categories' , array("fields"=>"names"));
		$filters_names_string = implode ($filters_names, ", ");

		$output .= '<div class="standard-gallery-item crsl-item" data-value="' . get_the_time('c') . '">';

		if ( $thumb ) {
			$image = hb_resize($thumb,'',586,349,true);
			$output .= '<div class="hb-gal-standard-img-wrapper">';
			$output .= '<a href="' . get_permalink() . '">';
			$output .= '<img src="' . $image['url'] . '" width="'. $image['width'] .'" height="'. $image['height'] .'" alt="Portfolio Image" />';
			$output .= '<div class="item-overlay"></div>';
			$output .= '<div class="item-overlay-text">';
			$output .= '<div class="item-overlay-text-wrap">';
			$output .= '<span class="plus-sign"></span>';
			$output .= '</div>';
			$output .= '</div>';
			$output .= '</a>';
			$output .= '</div>';
		}

		$output .= '<div class="hb-gal-standard-description portfolio-description">';
		$output .= '<h3><a href="' . get_permalink() . '"><span class="hb-gallery-item-name">' . get_the_title() . '</span></a></h3>';
		
		if ( $filters_names_string ) $output .= '<div class="hb-gal-standard-count">' . $filters_names_string . '</div>';
		if ( hb_options('hb_portfolio_enable_likes') ) $output .= hb_print_portfolio_likes(get_the_ID()); 

		if ( $style == "descriptive" ) {
			if ( has_excerpt() )
				$output .= '<p>' . get_the_excerpt() . '</p>';
			else 
				$output .= wp_trim_words( strip_shortcodes( get_the_content() ) , 10 , NULL);
			$output .= '<div class="portfolio-small-meta clearfix">';
			$output .= '<span class="float-left project-date">' . get_the_time('F d, Y') . '</span>';
			$output .= '<a href="' . get_permalink() . '" class="float-right details-link">' . __('Details' , 'hbthemes') . ' <i class="icon-angle-right"></i></a>';
			$output .= '</div>';
		}

		$output .= '</div>';

		$output .= '</div>';
	endwhile;

	$output .= '</div>';
	$output .= '</div>';

	$output .= '</div>';

	endif;

	wp_reset_query();
	
	return $output;  
}
add_shortcode('portfolio_carousel', 'hb_portfolio_carousel_shortcode');

/* IMAGE FRAME
-------------------------------------------------- */
function hb_image_frame($params = array()) {

	extract(shortcode_atts(array(
		'url' => '',
		'border_style' => '',
		'action' => '',
		'link' => '',
		'rel' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$overlay='';
	$img_url='';

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($url != ''){
		if( strpos($url, "http" ) !== false){
			// Image URL
			$img_url = $url;
		} else {
			// Image ID
			$url = wp_get_attachment_image_src($url, 'full');
			$url = $url[0];
			$img_url = $url;
		}

		$url = '<img src="'.$url.'" alt="Image"/>';
	}

	if ($border_style != 'circle-frame' && $border_style != 'boxed-frame' && $border_style != 'boxed-frame-hover' && $border_style != 'no-frame'){
		$border_style = 'no-frame';
	}

	if ($border_style == 'boxed-frame-hover'){
		$overlay = '<div class="overlay"><div class="plus-sign"></div></div>';
	}

	if ($rel != ''){
		$rel = '&#91;' . $rel . '&#93;';
	}

	$output = "";

	if ($border_style == 'boxed-frame' || $border_style == 'boxed-frame-hover'){
		$border_style = "box-frame";
	}

	$output .= '<div class="hb-'.$border_style.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<span>';

	if ( $action == 'open-url' ){
		$output .= '<a href="'.$link.'">';
		$output .= $url;
		$output .= $overlay;
		$output .= '</a>';
	} else if ($action == 'open-lightbox'){
		$output .= '<a href="'.$img_url.'" rel="prettyPhoto'.$rel.'">';
		$output .= $url;
		$output .= $overlay;
		$output .= '</a>';
	} else {
		$output .= '<a>';
		$output .= $url;
		$output .= $overlay;
		$output .= '</a>';
	}

	$output .= '</span>';
	$output .= '</div>';
	
	return $output;  
}
add_shortcode('image_frame', 'hb_image_frame');

/* COUNTER SHORTCODE
-------------------------------------------------- */
function hb_counter_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'from' => '0',
		'to' => '150',
		'color' => '',
		'icon' => '',
		'subtitle' => '',
		'speed' => '700',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($color == 'default'){
		$color = '';
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $class != "" ) 
		$class  = " " . $class;

	if ($color != ''){
		if ($color[0] == '#'){
			$color = ' style="color:'.$color.'"';
		} else {
			$color = ' style="color:#'.$color.'"';
		}
	}

	if ($subtitle != ''){
		$subtitle = '<div class="count-separator"><span></span></div><h3 class="count-subject">'.$subtitle.'</h3>';
	}

	if ($icon != ''){
		$icon = '<p class="aligncenter"><i class="'.$icon.' hb-icon hb-icon-float-none"'.$color.'></i></p>';
	}

	$output = '';
	$output = '<div class="shortcode-wrapper shortcode-milestone-counter clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= $icon;
	$output .= '<div class="hb-counter">';
	$output .= '<div class="count-number" data-from="'.$from.'" data-to="'.$to.'" data-speed="'.$speed.'"'.$color.'></div>';
	$output .= $subtitle;
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('counter', 'hb_counter_shortcode');

/* LAPTOP SLIDER
-------------------------------------------------- */
function hb_laptop_slider_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'speed' => '7000',
		'bullets' => 'yes',
		'images' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $class != "" ) 
		$class  = " " . $class;

	$unique_id = 'flexslider_' . rand ( 1, 100000 );
	
	if ( $bullets == "yes" ) 
		$bullets = "true";
	else
		$bullets = "false";

	$laptop_url = get_template_directory_uri() . '/images/laptop-mockup.png';

	$output = '<div class="col-12">';
	$output .= '<div class="shortcode-wrapper shortcode-laptop-slider laptop-slider-wrapper' . $class . $animation . '"' . $animation_delay . '>';
	$output .= '<div class="laptop-mockup"><img src="'.$laptop_url.'" alt="Laptop Mockup" width="1240" height="500"/>';
	$output .= '<div class="hb-flexslider-wrapper">';

	$output .= '<div class="hb-flexslider clearfix loading init-flexslider" id="' . $unique_id . '" data-speed="'.$speed.'" data-control-nav="'.$bullets.'">';
	$output .= '<ul class="hb-flex-slides clearfix">';

	if ( !empty($images) ) {
		$all_images = "";
		$images = explode ( ',' , $images ) ;
		foreach ($images as $image_id ) {
			$image_link = wp_get_attachment_image_src($image_id, 'full');
			$att_post = get_post($image_id);
			$all_images .= '[slider_item img="' . $image_link[0] . '" title="' . $att_post->post_title . '" rel="prettyPhoto&#91;' . $unique_id . '&#93;"]';
		}
		$output .= do_shortcode( $all_images );
	} else if ( $content ) {
		$output .= do_shortcode ( $content );
	}

	$output .= '</ul>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('laptop_slider', 'hb_laptop_slider_shortcode');

function hb_slider_item_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'img' => '',
		'title' => '',
		'rel' => '',
	), $params));

	if ( $rel != "" )
		$rel = ' rel="' . $rel . '"';
	else 
		$rel = ' rel="prettyPhoto&#91;' . rand(1,100000) . '&#93;"'; 

	$image = hb_resize(null, $img, 900, 565, true);
	if ( $image )
	return '<li><a href="' . $img . '"' . $rel . ' data-title="' . $title . '" alt="Slider Image"><img src="' . $image['url'] . '"/></a></li>';
}
add_shortcode('slider_item', 'hb_slider_item_shortcode');

/* SIMPLE SLIDER
-------------------------------------------------- */
function hb_simple_slider_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'speed' => '7000',
		'pause_on_hover' => 'yes',
		'bullets' => 'yes',
		'border' => 'yes',
		'arrows' => 'yes',
		'images' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $class != "" ) 
		$class  = " " . $class;

	$unique_id = 'flexslider_' . rand ( 1, 100000 );
	if ( $pause_on_hover == "yes" )
		$pause_on_hover = "true";
	else
		$pause_on_hover = "false";

	if ( $bullets == "yes" ) 
		$bullets = "true";
	else
		$bullets = "false";

	if ( $arrows == "yes" )
		$arrows = "true";
	else
		$arrows = "false";

	if ( $border == "yes" )
		$class .= ' bordered-wrapper';


	$output .= '<div class="shortcode-wrapper shortcode-simple-slider hb-flexslider-wrapper' . $class . $animation . '"' . $animation_delay . '>';
	$output .= '<div class="hb-flexslider init-flexslider clearfix loading" id="' . $unique_id . '" data-speed="'.$speed.'" data-pause-on-hover="'.$pause_on_hover.'" data-control-nav="'.$bullets.'" data-direction-nav="'.$arrows.'">';
	$output .= '<ul class="hb-flex-slides clearfix">';

	$all_images = "";
	if ( $images != '' ) {
		$images = explode ( ',' , $images ) ;
		foreach ($images as $image_id ) {
			$image_link = wp_get_attachment_image_src($image_id, 'full');
			$att_post = get_post($image_id);
			$all_images .= '[simple_slide img="' . $image_link[0] . '" title="' . $att_post->post_excerpt . '" subtitle="' . $att_post->post_content . '" rel="prettyPhoto&#91;' . $unique_id . '&#93;"]';
		}
		$output .= do_shortcode( $all_images );
	} else if ( $content ) {
		$output .= do_shortcode ( $content );
	}

	$output .= '</ul>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('simple_slider', 'hb_simple_slider_shortcode');

function hb_slider_simple_item_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'img' => '',
		'title' => '',
		'subtitle' => '',
		'lightbox' => 'yes',
		'rel' => '',
	), $params));

	if ( $rel != "")
		$rel = ' rel="' . $rel . '"';
	else 
		$rel = ' rel="prettyPhoto&#91;' . rand(1,100000) . '&#93;"'; 

	if ( $lightbox == 'yes' ) 
		$output = '<li><a href="' . $img . '"' . $rel . ' data-title="' . $title . '" alt="Slider Image"><img src="' . $img . '"/></a>';
	else
		$output = '<li><a data-title="' . $title . '" alt="Slider Image"><img src="' . $img . '"/></a>';	
	
	if ( $title ) 
		$output .= '<p class="flex-caption">' . $title . '</p>';
	if ( $subtitle )
		$output .= '<p class="flex-subtitle">' . $subtitle . '</p>';
	$output .= '</li>';

	return $output;
}
add_shortcode('simple_slide', 'hb_slider_simple_item_shortcode');

/* FULLWIDTH SECTION
-------------------------------------------------- */
function hb_fw_section($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'background_type' => 'color',
		'border' => '',
		'text_color' => 'dark',
		'bg_color' => '',
		'image' => '',
		'parallax' => '',
		'scissors_icon' => '',
		'bg_video_mp4' => '',
		'bg_video_ogv' => '',
		'bg_video_poster' => '',
		'overlay' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'padding_top' => '',
		'padding_bottom' => '',
		'class' => '',
		'id' => ''
	), $params));
	
	$output = "";
	$img_to_print = "";

	$background_texture = "";

	if ($border == 'yes'){
		$border = ' with-border';
	} else {
		$border = ' without-border';
	}

	if ($text_color == 'light'){
		$text_color = ' light-style';
	} else {
		$text_color = ' dark-text-color';
	}

	if ($bg_color != ''){
		if ( substr($bg_color, 1) == '#' ){
			$bg_color = substr($bg_color, 0, 1);
		}
		$bg_color = 'background-color:'.$bg_color.';';
	}

	if ($image != ''){
		if( strpos($image, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$image = wp_get_attachment_image_src($image, 'full');
			$image = $image[0];
		}
		$image = 'background-image:url('.$image.');';
		$img_to_print = $image;
	}

	if ($parallax == 'yes'){
		$parallax = " parallax";
		$img_to_print = "";
	} else {
		$parallax = "";
	}

	if ($scissors_icon == 'yes'){
		$scissors_icon = '<i class="hb-scissors icon-scissors"></i>';
	} else {
		$scissors_icon = "";
	}

	if ($bg_video_poster != ''){
		if( strpos($bg_video_poster, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$bg_video_poster = wp_get_attachment_image_src($image, 'full');
			$bg_video_poster = $bg_video_poster[0];
		}
		$bg_video_poster = ' poster="'.$bg_video_poster.'"';
	}

	if ($bg_video_ogv != ''){
		if( strpos($bg_video_ogv, "http" ) !== false){
			// Video URL
		} else {
			// Video ID
			$bg_video_ogv = wp_get_attachment_url( $bg_video_ogv );
		}
		$bg_video_ogv = '<source src="' . $bg_video_ogv . '" type="video/ogg">';
	}

	if ($overlay != 'yes'){
		$overlay = ' no-overlay';
	} else {
		$overlay = '';
	}

	if ($bg_video_mp4 != ''){

		if( strpos($bg_video_mp4, "http" ) !== false){
			// Video URL
		} else {
			// Video ID
			$bg_video_mp4 = wp_get_attachment_url( $bg_video_mp4 );
		}

		$bg_video_mp4 = '
		<div class="video-wrap">
			<video class="hb-video-element"'.$bg_video_poster.' autoplay loop="loop" muted="muted">
				<source src="'.$bg_video_mp4.'" type="video/mp4">
				'.$bg_video_ogv.'
			</video>
			<div class="video-overlay'.$overlay.'"></div>
		</div>';
	}

	if ( $margin_top != '' )
	{
		if ( is_numeric ( $margin_top ) ) $margin_top .= 'px';
		$margin_top = 'margin-top:' . $margin_top . ';';
	}

	if ( $margin_bottom != '' ) {
		if ( is_numeric ( $margin_bottom ) ) $margin_bottom .= 'px';
		$margin_bottom = 'margin-bottom:' . $margin_bottom . ';';
	}

	if ( $padding_top != '' ) {
		if ( is_numeric ( $padding_top ) ) $padding_top .= 'px';
		$padding_top = 'padding-top:' . $padding_top . ';';
	}

	if ( $padding_bottom != '' ) {
		if ( is_numeric ( $padding_bottom ) ) $padding_bottom .= 'px';
		$padding_bottom = 'padding-bottom:' . $padding_bottom . ';';
	}


	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($id != ''){
		$id = ' id="'.$id.'"';
	}

	// OUTPUT BUILD
	if ($background_type == 'video'){
		$output .= '<div class="fw-section video-fw-section'.$border.$text_color.$class.'" style="'.$bg_color.$margin_top.$margin_bottom.$padding_top.$padding_bottom.'"'.$id.'>';
		$output .= $scissors_icon;
		$output .= '<div class="row video-content">';
		$output .= '<div class="col-12 nbm">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';
		$output .= $bg_video_mp4;
		$output .= '</div>';
	} else {
		if ($background_type == 'texture'){
			$background_texture = " background-texture";
		}

		if ($background_type == 'color'){
			$image="";
		}
		$output .= '<div class="fw-section'.$border.$background_texture.$overlay.$text_color.$class.'" style="'.$bg_color.$img_to_print.$margin_top.$margin_bottom.$padding_top.$padding_bottom.'"'.$id.'>';
		$output .= $scissors_icon;
		$output .= '<div class="row fw-content-wrap">';
		$output .= '<div class="col-12 nbm">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';
		$output .='<div class="video-overlay'.$overlay.'"></div>';

		if ( $parallax != '' && $image != '' ){
			$output .= '<div class="hb-parallax-wrapper" style="'.$image.'"></div>';
		}

		$output .= '</div>';
	}

	return $output;
}
add_shortcode('fullwidth_section', 'hb_fw_section');

/* ONE PAGE SECTION
-------------------------------------------------- */
function hb_onepage_section($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'background_type' => 'color',
		'border' => '',
		'text_color' => 'dark',
		'bg_color' => '',
		'image' => '',
		'parallax' => '',
		'scissors_icon' => '',
		'bg_video_mp4' => '',
		'bg_video_ogv' => '',
		'bg_video_poster' => '',
		'overlay' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'padding_top' => '',
		'padding_bottom' => '',
		'class' => '',
		'id' => '',
		'name' => ''
	), $params));
	
	$output = "";
	$img_to_print = "";

	$background_texture = "";

	if ($border == 'yes'){
		$border = ' with-border';
	} else {
		$border = ' without-border';
	}

	if ($text_color == 'light'){
		$text_color = ' light-style';
	} else {
		$text_color = ' dark-text-color';
	}

	if ($bg_color != ''){
		if ( substr($bg_color, 1) == '#' ){
			$bg_color = substr($bg_color, 0, 1);
		}
		$bg_color = 'background-color:'.$bg_color.';';
	}

	if ($image != ''){
		if( strpos($image, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$image = wp_get_attachment_image_src($image, 'full');
			$image = $image[0];
		}
		$image = 'background-image:url('.$image.');';
		$img_to_print = $image;
	}

	if ($parallax == 'yes'){
		$parallax = " parallax";
		$img_to_print = "";
	} else {
		$parallax = "";
	}

	if ($scissors_icon == 'yes'){
		$scissors_icon = '<i class="hb-scissors icon-scissors"></i>';
	} else {
		$scissors_icon = "";
	}

	if ($bg_video_poster != ''){
		if( strpos($bg_video_poster, "http" ) !== false){
			// Image URL
		} else {
			// Image ID
			$bg_video_poster = wp_get_attachment_image_src($image, 'full');
			$bg_video_poster = $bg_video_poster[0];
		}
		$bg_video_poster = ' poster="'.$bg_video_poster.'"';
	}

	if ($bg_video_ogv != ''){
		if( strpos($bg_video_ogv, "http" ) !== false){
			// Video URL
		} else {
			// Video ID
			$bg_video_ogv = wp_get_attachment_url( $bg_video_ogv );
		}
		$bg_video_ogv = '<source src="' . $bg_video_ogv . '" type="video/ogg">';
	}

	if ($overlay != 'yes'){
		$overlay = ' no-overlay';
	} else {
		$overlay = '';
	}

	if ($bg_video_mp4 != ''){

		if( strpos($bg_video_mp4, "http" ) !== false){
			// Video URL
		} else {
			// Video ID
			$bg_video_mp4 = wp_get_attachment_url( $bg_video_mp4 );
		}

		$bg_video_mp4 = '
		<div class="video-wrap">
			<video class="hb-video-element"'.$bg_video_poster.' autoplay loop="loop" muted="muted">
				<source src="'.$bg_video_mp4.'" type="video/mp4">
				'.$bg_video_ogv.'
			</video>
			<div class="video-overlay'.$overlay.'"></div>
		</div>';
	}

	if ( $margin_top != '' )
	{
		if ( is_numeric ( $margin_top ) ) $margin_top .= 'px';
		$margin_top = 'margin-top:' . $margin_top . ';';
	}

	if ( $margin_bottom != '' ) {
		if ( is_numeric ( $margin_bottom ) ) $margin_bottom .= 'px';
		$margin_bottom = 'margin-bottom:' . $margin_bottom . ';';
	}

	if ( $padding_top != '' ) {
		if ( is_numeric ( $padding_top ) ) $padding_top .= 'px';
		$padding_top = 'padding-top:' . $padding_top . ';';
	}

	if ( $padding_bottom != '' ) {
		if ( is_numeric ( $padding_bottom ) ) $padding_bottom .= 'px';
		$padding_bottom = 'padding-bottom:' . $padding_bottom . ';';
	}

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($id != ''){
		$id = ' id="'.$id.'"';
	}

	if ($name != ''){
		$name = ' data-title="'.$name.'"';
	}

	// OUTPUT BUILD
	if ($background_type == 'video'){
		$output .= '<div class="fw-section hb-one-page-section video-fw-section'.$border.$text_color.$class.'" style="'.$bg_color.$margin_top.$margin_bottom.$padding_top.$padding_bottom.'"'.$id.'>';
		$output .= $scissors_icon;
		$output .= '<div class="row video-content">';
		$output .= '<div class="col-12 nbm">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';
		$output .= $bg_video_mp4;
		$output .= '</div>';
	} else {
		if ($background_type == 'texture'){
			$background_texture = " background-texture";
		}

		if ($background_type == 'color'){
			$image="";
		}
		$output .= '<div class="fw-section hb-one-page-section'.$border.$background_texture.$overlay.$text_color.$class.'" style="'.$bg_color.$img_to_print.$margin_top.$margin_bottom.$padding_top.$padding_bottom.'"'.$name.$id.'>';
		$output .= $scissors_icon;
		$output .= '<div class="row fw-content-wrap">';
		$output .= '<div class="col-12 nbm">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '</div>';
		$output .='<div class="video-overlay'.$overlay.'"></div>';

		if ( $parallax != '' && $image != '' ){
			$output .= '<div class="hb-parallax-wrapper" style="'.$image.'"></div>';
		}

		$output .= '</div>';
	}

	return $output;
}
add_shortcode('onepage_section', 'hb_onepage_section');

/* SOCIAL LIST
-------------------------------------------------- */
function hb_social_list($params = array(), $content = null) {
	
	extract(shortcode_atts(array(   
		'size' => '',
		'style' => 'dark',
		'new_tab' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => '',
		'twitter' => '',
		'facebook' => '',
		'skype' => '',
		'instagram' => '',
		'pinterest' => '',
		'google_plus' => '',
		'dribbble' => '',
		'soundcloud' => '',
		'youtube' => '',
		'vimeo' => '',
		'flickr' => '',
		'tumblr' => '',
		'yahoo' => '',
		'foursquare' => '',
		'blogger' => '',
		'wordpress' => '',
		'lastfm' => '',
		'github' => '',
		'linkedin' => '',
		'yelp' => '',
		'forrst' => '',
		'deviantart' => '',
		'stumbleupon' => '',
		'delicious' => '',
		'reddit' => '',
		'xing' => '',
		'behance' => '',
		'envelop' => '',
		'feed_2' => '',
		'custom_url' => '',
	), $params));

	$all_socials = array(
		'twitter',
		'facebook',
		'skype',
		'instagram',
		'pinterest',
		'google_plus',
		'dribbble',
		'soundcloud',
		'youtube',
		'vimeo',
		'flickr',
		'tumblr',
		'yahoo',
		'foursquare',
		'blogger',
		'wordpress',
		'lastfm',
		'github',
		'linkedin',
		'yelp',
		'forrst',
		'deviantart',
		'stumbleupon',
		'delicious',
		'reddit',
		'xing',
		'behance',
		'envelop',
		'feed_2',
		'custom_url'
	);

	if ( !$style ) $style = "dark";

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $new_tab == "yes" )
		$new_tab = "_blank";
	else
		$new_tab = "_self";

	if ( $size != "" ) 
		$size = " " . $size;

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output .= '<div class="shortcode-wrapper shortcode-social-icons">';
	$output .= '<ul class="social-icons ' . $style . $size . $animation . $class . '"' . $animation_delay . '>';

	foreach ($all_socials as $social_network) {
		if ( $$social_network ) {
			if ($social_network == 'google_plus') {
				$new_soc_net = 'google-plus';
			} elseif ($social_network == 'custom_url' || $social_network == 'custom-url') {
				$new_soc_net = 'link-5';
			} elseif ($social_network == 'feed_2') {
				$new_soc_net = 'feed-2';
			} else {
				$new_soc_net = $social_network;
			}
			
			if ( $new_soc_net != 'behance' ){
				$output .= '<li class="' . $new_soc_net . '"><a href="' . $$social_network . '" target="' . $new_tab . '"><i class="hb-moon-' . $new_soc_net . '"></i><i class="hb-moon-' . $new_soc_net . '"></i></a></li>';
			} else {
				$output .= '<li class="' . $new_soc_net . '"><a href="' . $$social_network . '" target="' . $new_tab . '"><i class="icon-' . $new_soc_net . '"></i><i class="icon-' . $new_soc_net . '"></i></a></li>';
			}
		}
	}
	$output .= '</ul>';
	$output .= '</div>';
	return $output;
}
add_shortcode('social_icons', 'hb_social_list');

/* CIRCLE CHART
-------------------------------------------------- */
function hb_circle_chart($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'type' => '',
		'color' => '#336699',
		'percent' => '100',
		'icon' => '',
		'text' => '',
		'caption' => '',
		'size' => '220',
		'weight' => '6',
		'track_color' => '#e1e1e1',
		'animation_speed' => '1000',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$to_return = "";

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($size != ''){
		if ( substr($size, -2) == 'px' ){
			$size = substr($size, 0, -2);
		}
	} else {
		$size = '220';
	}


	if ($percent != ''){
		if ( substr($percent, -1) == '%' ){
			$percent = substr($percent, 0, -1);
		}
	} else {
		$percent = 60;
	}

	// If with-percent or unknown
	if ($type != 'with-text' && $type != 'with-icon'){
		$to_return = '<div class="chart-percent"><span>'.$percent.'</span>%</div>';
	}

	if ($type == 'with-text'){
		$to_return = '<span class="chart-custom-text">'.$text.'</span>';
	}

	if ($type == 'with-icon'){
		if ($icon != ''){
			$to_return = '<i style="line-height:'.$size.'px; font-size:43px" class="'.$icon.'"></i>';
		} else {
			$to_return = '<i style="line-height:'.$size.'px; font-size:43px" class="hb-moon-brain"></i>';
		}
	}

	if ($caption != ''){
		$caption = '<div class="hb-chart-desc">'.$caption.'</div>';
	}

	$output = '<div class="shortcode-wrapper shortcode-circle-chart clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="hb-chart" data-percent="'.$percent.'" data-barColor="'.$color.'" data-trackColor="'.$track_color.'" data-lineWidth="'.$weight.'" data-barSize="'.$size.'" data-animation-speed="'.$animation_speed.'">';

	$output .= $to_return;	

	$output .= '</div>';
	$output .= $caption;
	$output .= '</div>';

	return $output;
}
add_shortcode('circle_chart', 'hb_circle_chart');

/* GOOGLE MAP
-------------------------------------------------- */
function hb_map_embed_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'latitude' => '48.856614',
		'longitude' => '2.352222',
		'zoom' => '16',
		'custom_pin' => '',
		'height' => '350',
		'styled' => 'yes',
		'border' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$classes = "map-wrapper shadow";

	if ( $border == "yes" ) 
		$classes .= " bordered-wrapper";

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ( $custom_pin == "" )
		$custom_pin = hb_options('hb_custom_marker_image'); 
	else if ( is_numeric($custom_pin)) {
		$custom_pin = wp_get_attachment_image_src ( $custom_pin, 'full');
		$custom_pin = $custom_pin[0];
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$style = "";
	if ( $height != "" ) 
		$style = ' style="height:' . $height . 'px;"';

	$output = '<div class="shortcode-wrapper shortcode-map-embed clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="' . $classes . '">';
	$output .= '<div class="hb-gmap-map" data-show-location="0" data-map-level="' . $zoom . '" data-map-lat="' . $latitude . '" data-map-lng="' . $longitude . '" data-map-img="' . $custom_pin . '" data-overlay-color="';
	
		if ( hb_options('hb_enable_map_color') && $styled != 'no' ) 
		{ 
			$output .= '#ff6838'; 
		} 
		else { $output .= 'none'; }

	$output .= '"' . $style . '></div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('map_embed', 'hb_map_embed_shortcode');

/* BUTTON
-------------------------------------------------- */
function hb_button_shortcode($params = array()) {
	extract(shortcode_atts(array(   
		'icon' => '',
		'special_style' => '',
		'color' => '',
		'size' => '',
		'three_d' => '',
		'title' => '',
		'link' => '',
		'new_tab' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$classes = "hb-button";
	if ( $special_style == "yes" && $icon != "" ) {
		$classes .= " special-icon";
	}
	if ( $color != "" ) {
		$classes .= " hb-" . $color; 
	}
	if ( $size != "" ) {
		$classes .= " hb-" . $size . "-button";
	}
	if ( $three_d == "no" ) {
		$classes .= " no-three-d";
	}
	if ($animation != ''){
		$classes .= ' hb-animate-element ' . $animation;
	}


	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $new_tab == "yes" ) 
		$new_tab = "_blank";
	else
		$new_tab = "_self";

	$output = "";

	if ($class != ''){
		$output .= '<div class="'.$class.'">';
	}

	$output .= '<a href="' . $link . '" class="' . $classes . '" target="' . $new_tab . '"' . $animation_delay . '>';
	if ($icon != ''){
		$output .= '<i class="' . $icon . '"></i>';
	}
	$output .=  $title . '</a>';

	if ($class != ''){
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('button', 'hb_button_shortcode');

/* READ MORE BUTTON
-------------------------------------------------- */
function hb_read_more_shortcode($params = array()) {
	extract(shortcode_atts(array(   
		'title' => '',
		'link' => '',
		'new_tab' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$classes = "simple-read-more";

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ( $new_tab == "yes" ) 
		$new_tab = "_blank";
	else
		$new_tab = "_self";

	$output = "";

	if ($class != ''){
		$output .= '<div class="'.$class.'">';
	}

	$output .= '<a href="' . $link . '" class="' . $classes . '" target="' . $new_tab . '"' . $animation_delay . '>';
	if ($icon != ''){
		$output .= '<i class="' . $icon . '"></i>';
	}
	$output .=  $title . '</a>';

	if ($class != ''){
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('read_more', 'hb_read_more_shortcode');

/* MODAL WINDOW
-------------------------------------------------- */
function hb_modal_window($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'title' => '',
		'invoke_title' => '',
		'id' => '',
		'show_on_load' => 'no'
	), $params));

	$id_flag = false;

	if ($id != ''){
		$id_flag = true;
	} else {
		$digits = 4;
		$unique_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$id = 'hb-modal-' . $unique_id;
		$id_flag = false;
	}

	if ($show_on_load == 'yes'){
		$show_on_load = ' modal-show-on-load';
	} else {
		$show_on_load = '';
	}

	if ($title != ''){
		$title = '<div class="hb-box-cont-header">'.$title.'<a href="#" class="close-modal" data-close-id="'.$id.'"><i class="hb-moon-close-2"></i></a></div>';
	} else {
		$title = '<div class="hb-box-cont-header">&nbsp;<a href="#" class="close-modal" data-close-id="'.$id.'"><i class="hb-moon-close-2"></i></a></div>';
	}

	$output = "";

	// Modal Invoker
	if ($invoke_title != ''){
		$output .= '<a href="#" class="modal-open hb-button" data-modal-id="'.$id.'">'.$invoke_title.'</a>';
	}

	// Modal
	$output .= '<div class="crop-here"><div class="hb-modal-window'. $show_on_load .'" id="'.$id.'">';

	$output .= '<div class="hb-box-cont clearfix">';
	$output .= $title;
	
	$output .= '<div class="hb-box-cont-body">';
	$output .= do_shortcode($content);
	$output .= '</div>'; // END body
	
	$output .= '</div>'; // END cont
	$output .= '</div>'; // END crop
	$output .= '</div>'; // END


	return $output;
}
add_shortcode('modal_window', 'hb_modal_window');

/* CALLOUT
-------------------------------------------------- */
function hb_callout($params = array(), $content = null) {
	extract(shortcode_atts(array(   
		'title' => '',
		'link' => '#',
		'new_tab' => '',
		'icon' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$with_button="clear-r-margin";

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($icon != ''){
		$icon = '<i class="' . $icon . '"></i>';
	}

	if ($new_tab == 'yes'){
		$new_tab = ' target="_blank"';
	}

	if ($title != '' || $icon != ''){
		$title = '<a href="'.$link.'" class="hb-button"'.$target.'>'.$icon.$title.'</a>';
		$with_button="";
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="shortcode-wrapper shortcode-callout clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="hb-callout-box"><h3 class="'.$with_button.'">'.do_shortcode($content).'</h3>'.$title.'</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('callout', 'hb_callout');

/* CONTENT BOX
-------------------------------------------------- */
function hb_content_box($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'type' => '',
		'title' => '',
		'icon' => '',
		'color' => '',
		'text_color' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));
	    
	if ( $class != '' ){
		$class = ' ' . $class;
	}

	$hex_color='';

	if ($color != 'default' && $color != ''){
		if ( $color[0] == '#' ){
			$hex_color = ' style="background-color: '.$color.'"'; // hex color specified, hidden feature
			$color = "";
		} else {
			$color = ' ' . $color; // alt-color class
		}
	} else {
		$color = "";
	}

	if ($icon != ''){
		$icon = '<i class="' . $icon . '"></i>';
	}

	if ($title != ''){
		$title = $icon . $title;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($text_color == 'light'){
		$text_color = ' light-style';
	} else {
		$text_color = "";
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="shortcode-wrapper shortcode-content-box clearfix'.$class.$animation.'"'.$animation_delay.'>';
	$output .= '<div class="hb-box-cont'.$color.$text_color.'"'.$hex_color.'>';

	// BEGIN CONTENT HEADER
	if ($type != 'without-header'){
		$output .= '<div class="hb-box-cont-header">';
		$output .= $title;
		$output .= '</div>';
	}
	// END CONTENT HEADER

	// BEGIN CONTENT BODY
	$output .= '<div class="hb-box-cont-body">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	// END CONTENT BODY

	$output .= '</div>'; // END .hb-box-cont
	$output .= '</div>'; // END .shortcode-wrapper

	return $output;
}  
add_shortcode('content_box', 'hb_content_box');

/* SITEMAP
-------------------------------------------------- */
function hb_sitemap($params = array()) {  

	extract(shortcode_atts(array(   
		'depth' => 2,
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}
	    
	$output = '<div class="shortcode-wrapper shortcode-sitemap clearfix'.$class.'">';
	$output .= '<div class="row">';

	$output .= '<div class="col-4">';
		$output .= '<h3>'.__("Pages", "hbthemes").'</h3>';
		$page_list = wp_list_pages("title_li=&depth=$depth&sort_column=menu_order&echo=0");  
		
		if ($page_list != '') {  
			$output .= '<ul class="hb-ul-list special-list">'.$page_list.'</ul>';  
		}
	$output .= '</div>';
	        
	$output .= '<div class="col-4">';	
		$output .= '<h3>'.__("Posts", "hbthemes").'</h3>';
		        	  
		$post_list = wp_get_archives('type=postbypost&limit=20&echo=0');
		if ($post_list != '') {  
			$output .= '<ul class="hb-ul-list special-list">'.$post_list.'</ul>';  
		}	  		
	$output .= '</div>';
	        	
	$output .= '<div class="col-4">';      	
		$output .= '<h3>'.__("Categories", "hbthemes").'</h3>';
		        	  
		$category_list = wp_list_categories('sort_column=name&title_li=&depth=1&number=10&echo=0');
		if ($category_list != '') {  
			$output .= '<ul class="hb-ul-list special-list">'.$category_list.'</ul>';  
		}
	$output .= '</div>';	
	        

	$output .= '<div class="col-4">';
		$output .= '<h3>'.__("Archives", "hbthemes").'</h3>';
		        	  
		$archive_list =  wp_get_archives('type=monthly&limit=12&echo=0');
		if ($archive_list != '') {  
			$output .= '<ul class="hb-ul-list special-list">'.$archive_list.'</ul>';  
		} 	
	$output .= '</div>';
	    	
	$output .= '</div>'; // end row
	$output .= '</div>'; // end sitemap-wrap
	    
	return $output;      
}  
add_shortcode('sitemap', 'hb_sitemap');

/* SPACER
-------------------------------------------------- */
function hb_spacer($params = array()) {

	extract(shortcode_atts(array(   
		'height' => '',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($height != ''){
		// Remove px, if entered in the attribute
		if ( substr($height, -2) == 'px' ){
			$height = substr($height, 0, -2);
		}

		$height = ' style="height:'. $height .'px;"';
	}

	$output = '<div class="shortcode-wrapper shortcode-spacer clearfix' . $class . '">';
	$output .= '<div class="spacer"'.$height.'></div>';
	$output .= '</div>';
	
	return $output;  
}
add_shortcode('spacer', 'hb_spacer');

/* TOOLTIP
-------------------------------------------------- */
function hb_tooltip($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'text' => '',
		'position' => 'top',
		'class' => ''
	), $params));

	if ( $class != '' ){
		$class = ' class="' . $class . '"';
	}

	if ($text == ''){
		$text = "Tooltip Title";
	}

	$output = '<span rel="tooltip" data-original-title="'.$text.'" data-placement="'.$position.'"'.$class.'>';
	$output .= do_shortcode($content);
	$output .= '</span>';

	return $output;
}
add_shortcode('tooltip', 'hb_tooltip');

/* DROPCAP
-------------------------------------------------- */
function hb_dropcap($params = array(), $content = null) {

	extract(shortcode_atts(array(
		'style' => '',
		'class' => ''
	), $params));

	if ( $style ) $style = ' ' . $style;

	$output = '<span class="dropcap' . $style . '">' . do_shortcode($content) . '</span>';
	
	return $output;  
}
add_shortcode('dropcap', 'hb_dropcap');

/* CLEAR
-------------------------------------------------- */
function hb_clear($params = array()) {

	extract(shortcode_atts(array(
	), $params));

	$output = '<div class="clear"></div>';
	
	return $output;  
}
add_shortcode('clear', 'hb_clear');

/* HIGHLIGHT
-------------------------------------------------- */
function hb_highlight($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'style' => 'highlight',
		'class' => ''
	), $params));

	if ($style == 'alt'){
		$style = 'highlight alt';
	} else {
		$style = 'highlight';
	}

	$output = '<span class="' .$style. ' ' .$class. '">';
	$output .= do_shortcode($content);
	$output .= '</span>';

	return $output;
}
add_shortcode('highlight', 'hb_highlight');

/* INFO MESSAGE
-------------------------------------------------- */
function hb_infomessage($params = array(), $content = null) {

	extract(shortcode_atts(array(   
		'style' => 'info',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$icon_html = "";

	if ($style != 'info' && $style != 'warning' && $style != 'success' && $style != 'error') {
		$style = 'info';
		$icon_html = "<i class='icon-lightbulb'></i>";
	}

	if ($style == 'info'){
		$icon_html = "<i class='icon-lightbulb'></i>";
	} else if ($style == 'error'){
		$icon_html = "<i class='hb-moon-blocked'></i>";
	} else if ($style == 'warning'){
		$icon_html = "<i class='hb-moon-warning-2'></i>";
	} else if ($style == 'success'){
		$icon_html = "<i class='hb-moon-thumbs-up-3'></i>";
	}

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = 'data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="shortcode-wrapper shortcode-infomessage clearfix' . $class . '">';

	$output .= '<div class="hb-notif-box ' . $style . $animation .'" '. $animation_delay .'>';
	$output .= '<div class="message-text">';
	
	$output .= '<p>' . $icon_html . do_shortcode($content) . '</p>';

	$output .= '</div>';
	$output .= '</div>';

	$output .= '</div>';

	return $output;
}
add_shortcode('info_message', 'hb_infomessage');

/* COUNTDOWN
-------------------------------------------------- */
function hb_countdown($params = array()) {

	extract(shortcode_atts(array(   
		'date' => '',
		'animation' => '',
		'animation_delay' => '',
		'aligncenter' => '',
		'class' => ''
	), $params));

	if ($date == '') {
		$date = '31 december 2020 12:00:00';
	}

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ( $aligncenter == 'yes' ){
		$aligncenter = ' aligncenter';
	} else {
		$aligncenter = '';
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = 'data-delay="' . $animation_delay . '"';
	}

	$output = '<div class="shortcode-wrapper shortcode-countdown clearfix' . $aligncenter . $class . $animation .'" '. $animation_delay .'>';

	$digits = 4;
	$unique_id = rand(pow(10, $digits-1), pow(10, $digits)-1);

	$output .= '<ul id="hb-countdown-'.$unique_id.'" class="hb-countdown-unit clearfix" data-date="'.$date.'">
					<li>
						<span class="days timestamp">0</span>
						<span class="timeRef">' . __('days','hbthemes') . '</span>
					</li>
					<li>
						<span class="hours timestamp">0</span>
						<span class="timeRef">' . __('hours','hbthemes') . '</span>
					</li>
					<li>
						<span class="minutes timestamp">0</span>
						<span class="timeRef">' . __('minutes','hbthemes') . '</span>
					</li>
					<li>
						<span class="seconds timestamp">0</span>
						<span class="timeRef">' . __('seconds','hbthemes') . '</span>
					</li>
				</ul>';

	$output .= '</div>';

	return $output;
}
add_shortcode('countdown', 'hb_countdown');

/* SEPARATOR
-------------------------------------------------- */
function hb_separator($params = array()) {

	extract(shortcode_atts(array(   
		'type' => 'default',
		'scissors_icon' => 'no',
		'go_to_top' => 'no',
		'margin_top' => '',
		'margin_bottom' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$separator_icon = "";
	$gototop = "";
	$style_html = "";

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ( $type == 'default' ){
		$type = "hb-separator";
	} else if ( $type == 'default-double' ){
		$type = "hb-separator double-border";
	} else if ( $type == 'dashed' ){
		$type = "hb-separator dashed-border";
	} else if ( $type == 'dashed-double' ) {
		$type = "hb-separator double-border dashed-border";
	} else if ( $type == 'small' ){
		$type = "hb-separator-25";
	} else if ( $type == 'small-break') {
		$type = "hb-small-break";
	} else if ($type == 'hb-fw-separator'){
		$type = "hb-fw-separator";
	} else if ($type == 'hb-fw-dashed'){
		$type = "hb-fw-separator dashed-border";
	}
	 else {
		$type = 'hb-separator';
	}

	if ($scissors_icon == 'yes'){
		$separator_icon = '<i class="hb-scissors icon-scissors"></i>';
	}

	if ($go_to_top == 'yes'){
		$gototop = '<a href="#" class="go-to-top">' . __("Go to top","hbthemes") . '</a>';
	}

	if ( $margin_top != '' )
	{
		if ( is_numeric ( $margin_top ) ) $margin_top .= 'px';
		$margin_top = 'margin-top:' . $margin_top . ';';
	}

	if ( $margin_bottom != '' ) {
		if ( is_numeric ( $margin_bottom ) ) $margin_bottom .= 'px';
		$margin_bottom = 'margin-bottom:' . $margin_bottom . ';';
	}

	if ($margin_top != '' || $margin_bottom != ''){
		$style_html = ' style="' . $margin_top . $margin_bottom . '"';
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = 'data-delay="' . $animation_delay . '"';
	}

	if ($type != 'hb-fw-separator' && $type != 'hb-fw-separator dashed-border'){

		$output = '<div class="shortcode-wrapper shortcode-separator clearfix' . $class . $animation .'" '. $animation_delay .'>';
		$output .= '<div class="' .$type. '" '. $style_html .'>'; 
		$output .= $separator_icon . $gototop;
		$output .= '</div>';
		$output .= '</div>';

	} else if ($type == 'hb-fw-separator') {
		$output = '<div class="shortcode-wrapper shortcode-separator clearfix' . $class . $animation .'" '. $animation_delay .'>';
		$output .= '<div class="hb-separator extra-space"'. $style_html .'>'. $separator_icon . $gototop . '<div class="hb-fw-separator"></div></div>';
		$output .= '</div>';

	} else if ($type == 'hb-fw-separator dashed-border'){
		$output = '<div class="shortcode-wrapper shortcode-separator clearfix' . $class . $animation .'" '. $animation_delay .'>';
		$output .= '<div class="hb-separator extra-space"'. $style_html .'>'. $separator_icon . $gototop . '<div class="hb-fw-separator dashed-border"></div></div>';
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('separator', 'hb_separator');

/* VIDEO EMBED
-------------------------------------------------- */
function hb_video_embed($params = array()) {

	extract(shortcode_atts(array(  
		'embed_style' => '',	
		'url' => '',
		'border' => '',
		'width' => '',
		'animation' => '',
		'animation_delay' => '',
		'class' => ''
	), $params));

	$border_html = "";

	if ( $class != '' ){
		$class = ' ' . $class;
	}

	if ($width != ''){
		// Remove px, if entered in the attribute
		if ( substr($width, -2) == 'px' ){
			$width = substr($height, 0, -2);
		}

		$width = ' style="width:'. $width .'px;"';
	}

	if ($width != ''){
		$embed_code = wp_oembed_get($url, array('width'=>$width));
	} else {
		$embed_code = wp_oembed_get($url);
	}
	if (!$embed_code){
		$embed_code = __('Failed to load media. URL not valid. Please check <a href="http://codex.wordpress.org/Embeds">WordPress Codex</a>.');
	}
	if ($border == 'yes'){
		$border_html = " hb-box-frame";
	}

	if ($animation != ''){
		$animation = ' hb-animate-element ' . $animation;
	}

	if ($animation_delay != ''){
		// Remove ms or s, if entered in the attribute
		if ( substr($height, -2) == 'ms' ){
			$animation_delay = substr($height, 0, -2);
		}

		if ( substr($height, -1) == 's' ){
			$animation_delay = substr($height, 0, -1);
		}

		$animation_delay = ' data-delay="' . $animation_delay . '"';
	}

	if ($embed_style == 'in_lightbox'){
		$output = "<a href='" . $url . "' rel='prettyPhoto'><i class='hb-moon-play-2 hb-icon hb-icon-float-none hb-icon-medium hb-icon-container'></i></a>";
	} else {
		$output = '<div class="shortcode-wrapper shortcode-video fitVids clearfix' . $border_html . $class . $animation .'"'.$width. $animation_delay .'>';
		$output .= '<span>' . $embed_code . '</span>';
		$output .= '</div>';
	}
	
	return $output;  
}
add_shortcode('video_embed', 'hb_video_embed');

/*	VC MAPPING
	========================================== */
	if (function_exists('wpb_map')){

		// Useful
		$script_path = get_template_directory_uri() . '/scripts/';
		
		$target_arr = array(__("Same window", "js_composer") => "_self", __("New window", "js_composer") => "_blank");
		
		$alt_colors_arr = array(
			__('None / Default', 'js_composer') => "default",
			__('Alt Color 1', 'js_composer') => "alt-color-1",
			__('Alt Color 2', 'js_composer') => "alt-color-2",
			__('Alt Color 3', 'js_composer') => "alt-color-3",
			__('Alt Color 4', 'js_composer') => "alt-color-4",
			__('Alt Color 5', 'js_composer') => "alt-color-5",
			__('Alt Color 6', 'js_composer') => "alt-color-6",
		);

		$alt_bgcolors_arr = array(
			__('None / Default', 'js_composer') => "default",
			__('Alt Color 1', 'js_composer') => "alt-color-1-bg",
			__('Alt Color 2', 'js_composer') => "alt-color-2-bg",
			__('Alt Color 3', 'js_composer') => "alt-color-3-bg",
			__('Alt Color 4', 'js_composer') => "alt-color-4-bg",
			__('Alt Color 5', 'js_composer') => "alt-color-5-bg",
			__('Alt Color 6', 'js_composer') => "alt-color-6-bg",
		);

		$add_icon = array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"admin_label" => true,
			"description" => __("Enter a name of the icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href='http://documentation.hb-themes.com/icons/' target='_blank'>Icon List</a>.
Example: hb-moon-apple-fruit", "js_composer")
		);

		$add_icon_or_char = array(
			"type" => "textfield",
			"heading" => __("Icon or Character", "js_composer"),
			"param_name" => "icon",
			"value" => "hb-moon-brain",
			"admin_label" => true,
			"description" => __("Enter a name of icon you would like to use or enter just a single character. Leave empty to exclude. You can find list of icons here: <a href='http://documentation.hb-themes.com/icons/' target='_blank'>Icon List</a>
Example: hb-moon-apple-fruit. Example for character: $", "js_composer")
		);

		$add_class = array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"admin_label" => true,
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
		);

		$add_css_animation = array(
			"type" => "dropdown",
		  	"heading" => __("Entrance Animation", "js_composer"),
		  	"param_name" => "animation",
		  	"admin_label" => true,
		  	"value" => array(__("None", "js_composer") => '', __("Fade In", "js_composer") => "fade-in", __("Scale Up", "js_composer") => "scale-up", __("Right to Left", "js_composer") => "right-to-left", __("Left to Right", "js_composer") => "left-to-right", __("Top to Bottom", "js_composer") => "top-to-bottom", __("Bottom to Top", "js_composer") => "bottom-to-top", __("Helix", "js_composer") => "helix", __("Flip-X", "js_composer") => "flip-x",  __("Flip-Y", "js_composer") => "flip-y",  __("Spin", "js_composer") => "spin"),
		  	"description" => __("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		);

		$add_animation_delay = array(
			"type" => "textfield",
			"heading" => __("Entrance Delay", "js_composer"),
			"param_name" => "animation_delay",
			"value" => "",
			"description" => __("Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)", "js_composer")
		);

		$all_socials = array(
			'twitter' => '',
			'facebook' => '',
			'skype' => '',
			'instagram' => '',
			'pinterest' => '',
			'google_plus' => '',
			'dribbble' => '',
			'soundcloud' => '',
			'youtube' => '',
			'vimeo' => '',
			'flickr' => '',
			'tumblr' => '',
			'yahoo' => '',
			'foursquare' => '',
			'blogger' => '',
			'wordpress' => '',
			'lastfm' => '',
			'github' => '',
			'linkedin' => '',
			'yelp' => '',
			'forrst' => '',
			'deviantart' => '',
			'stumbleupon' => '',
			'delicious' => '',
			'reddit' => '',
			'envelop' => '',
			'feed_2' => '',
			'custom_url' => ''
		);

		$pricing_table_items = array();
		$pricing_query = get_posts('post_type=hb_pricing_table&status=publis&posts_per_page=-1');
		if ( !empty ($pricing_query ) ) {
			foreach ($pricing_query as $pricing_item) {
				$pricing_table_items[$pricing_item->post_title] = $pricing_item->ID;
			}
		}

		// FAQ ---------------------------------
		wpb_map( array(
			"name" => __("FAQ Module", "js_composer"),
			"base" => "faq",
		  	"icon" => "icon-faq",
		  	"wrapper_class" => "hb-wrapper-faq",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('FAQ Module.', 'js_composer'),
		    "params"	=> array(
		        array(
					"type" => "dropdown",
					"heading" => __("Show Filter", "js_composer"),
					"param_name" => "filter",
					"value" => array(
		               	__("No", "js_composer") => 'no',
						__("Yes", "js_composer") => 'yes',
					),
					"default" => "yes",
					"description" => __("Choose in which order to show testimonials.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which faq categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show testimonials.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TESTIMONIAL SLIDER ------------------------

		// PRICING TABLE --------------------------------
		wpb_map( array(
			"name" => __("Pricing Table", "js_composer"),
			"base" => "pricing_table",
		  	"icon" => "icon-pricing-table",
		  	"wrapper_class" => "hb-wrapper-pricing-table",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Display your pricing tables.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Pricing Item", "js_composer"),
					"param_name" => "pricing_item",
					"value" => $pricing_table_items,
					"admin_label" => true,
					"description" => __("Choose the style of your pricing table.", "js_composer")
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Style", "js_composer"),
					"param_name" => "style",
					"value" => array(
						__("Standard", "js_composer") => 'standard',
						__("Colored", "js_composer") => 'colored',
					),
					"admin_label" => true,
					"description" => __("Choose the style of your pricing table.", "js_composer"),
					"default" => 'standard'
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Columns", "js_composer"),
					"param_name" => "columns",
					"value" => array(
						__("1", "js_composer") => '1',
						__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
					),
					"admin_label" => true,
					"description" => __("Choose in how many columns to display your pricing table.", "js_composer"),
					"default" => "3",
		        ),
				$add_css_animation,
				$add_animation_delay,
				$add_class,
		    ),
		));
		// END ICON COLUMN -----------------------------

		// ICON COLUMN --------------------------------
		wpb_map( array(
			"name" => __("Icon Column", "js_composer"),
			"base" => "icon_column",
		  	"icon" => "icon-icon-column",
		  	"wrapper_class" => "hb-wrapper-icon-column",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('A simple content column with icon.', 'js_composer'),
		    "params"	=> array(
		    	$add_icon_or_char,
		    	array(
					"type" => "textfield",
					"heading" => __("Link", "js_composer"),
					"param_name" => "link",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter a link for this icon. Leave empty if you do not want to use a link. Please use http:// prefix. Example: http://hb-themes.com", "js_composer")
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Open link in new tab?", "js_composer"),
					"param_name" => "new_tab",
					"value" => array(
						__("Yes", "js_composer") => 'yes',
						__("No", "js_composer") => 'no',
					),
					"admin_label" => true
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Alignment", "js_composer"),
					"param_name" => "align",
					"value" => array(
						__("Left", "js_composer") => 'left',
						__("Center", "js_composer") => 'center',
						__("Right", "js_composer") => 'right',
					),
					"admin_label" => true,
					"description" => __("Choose the alignment of the content.", "js_composer")
		        ),
			    array(
					"type" => "textfield",
					"heading" => __("Title", "js_composer"),
					"param_name" => "title",
					"admin_label" => true,
					"value" => "My column title",
					"description" => __("Enter your icon column title. Leave empty to exclude. Example: My Feature", "js_composer")
		        ),
		        array(
			      "type" => "textarea_html",
			      "heading" => __("Content", "js_composer"),
			      "param_name" => "content",
			      "value" => __("<p>Mauris rhoncus pretium porttitor. Cras scelerisque commodo odio. Phasellus dolor enim, faucibus egestas scelerisque hendrerit, aliquet sed lorem.</p>", "js_composer")
			    ),
				$add_css_animation,
				$add_animation_delay,
				$add_class,
		    ),
		));
		// END ICON COLUMN -----------------------------

		// ICON FEATURE --------------------------------
		wpb_map( array(
			"name" => __("Icon Feature", "js_composer"),
			"base" => "icon_feature",
		  	"icon" => "icon-icon-feature",
		  	"wrapper_class" => "hb-wrapper-icon-feature",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Fancy icon feature.', 'js_composer'),
		    "params"	=> array(
		    	$add_icon_or_char,
		    	array(
					"type" => "textfield",
					"heading" => __("Link", "js_composer"),
					"param_name" => "link",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter a link for this icon. Leave empty if you do not want to use a link. Please use http:// prefix. Example: http://hb-themes.com", "js_composer")
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Open link in new tab?", "js_composer"),
					"param_name" => "new_tab",
					"value" => array(
						__("Yes", "js_composer") => 'yes',
						__("No", "js_composer") => 'no',
					),
					"admin_label" => true
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Icon Position", "js_composer"),
					"param_name" => "icon_position",
					"value" => array(
						__("Center", "js_composer") => 'center',
						__("Left", "js_composer") => 'left',
						__("Right", "js_composer") => 'right',
					),
					"admin_label" => true,
					"description" => __("Choose where will be icon positioned.", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Border around icon?", "js_composer"),
			      "param_name" => "border",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),

			    array(
					"type" => "dropdown",
					"heading" => __("Border around icon?", "js_composer"),
					"param_name" => "border",
					"value" => array(
						__("Yes", "js_composer") => 'yes',
						__("No", "js_composer") => 'no',
					),
					"admin_label" => true,
					"description" => __("Display border around icon with effect on hover", "js_composer")
		        ),

			    array(
					"type" => "textfield",
					"heading" => __("Title", "js_composer"),
					"param_name" => "title",
					"admin_label" => true,
					"description" => __("Enter your icon box title. Leave empty to exclude. Example: My Feature", "js_composer")
		        ),
		        array(
			      "type" => "textarea_html",
			      "heading" => __("Box Content", "js_composer"),
			      "param_name" => "content",
			      "value" => __("<p>Mauris rhoncus pretium porttitor. Cras scelerisque commodo odio. Phasellus dolor enim, faucibus egestas scelerisque hendrerit, aliquet sed lorem.</p>", "js_composer")
			    ),
			    array(
			      	"type" => "attach_image",
					"heading" => __("Custom Image", "js_composer"),
					"param_name" => "image",
					"value" => "",
					"description" => __("Upload custom image for this element. If this field is used, the icon will be discarded. We suggest using 64x64 pixels images.", "js_composer")
			    ),
				$add_css_animation,
				$add_animation_delay,
				$add_class,
		    ),
		));
		// END ICON FEATURE --------------------------------

		// BOX ICON ---------------------------------
		wpb_map( array(
			"name" => __("Icon Box", "js_composer"),
			"base" => "icon_box",
		  	"icon" => "icon-icon-box",
		  	"wrapper_class" => "hb-wrapper-icon-box",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('A styled content box with icon.', 'js_composer'),
		    "params"	=> array(
		    	$add_icon,
		    	array(
			      "type" => "colorpicker",
			      "heading" => __("Icon Background", "js_composer"),
			      "param_name" => "icon_color",
			      "description" => __("Choose a background color for the icon. Leave empty for default color.", "js_composer")
			    ),
			    array(
					"type" => "dropdown",
					"heading" => __("Icon Position", "js_composer"),
					"param_name" => "icon_position",
					"value" => array(
						__("Top", "js_composer") => 'top',
						__("Left", "js_composer") => 'left',
					),
					"admin_label" => true,
					"description" => __("Choose where will be icon positioned.", "js_composer")
		        ),
		        array(
			      "type" => "textarea_html",
			      "heading" => __("Box Content", "js_composer"),
			      "param_name" => "content",
			      "value" => __("<p>I am message box. Click edit button to change this text.</p>", "js_composer")
			    ),
		        array(
					"type" => "dropdown",
					"heading" => __("Content Alignment", "js_composer"),
					"param_name" => "align",
					"value" => array(
						__("Left", "js_composer") => 'left',
						__("Center", "js_composer") => 'center',
						__("Right", "js_composer") => 'right',
					),
					"admin_label" => true,
					"description" => __("Choose a content alignment.", "js_composer")
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END BOX ICON -----------------------------

		// BLOG CAROUSEL ---------------------------------
		wpb_map( array(
			"name" => __("Blog Carousel", "js_composer"),
			"base" => "blog_carousel",
		  	"icon" => "icon-blog-carousel",
		  	"wrapper_class" => "hb-wrapper-blog-carousel",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with blog posts.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Visible items", "js_composer"),
					"param_name" => "visible_items",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
						__("7", "js_composer") => '7',
						__("8", "js_composer") => '8',
					),
					"description" => __("Choose how many posts are visible at a time.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "total_items",
					"admin_label" => true,
					"value" => "10",
					"description" => __("Choose how many client logos to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Excerpt Length", "js_composer"),
					"param_name" => "excerpt_length",
					"admin_label" => true,
					"value" => "",
					"description" => __("Specify how many words will show in the post excerpt, enter just a number. Example: 15.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Speed", "js_composer"),
					"param_name" => "carousel_speed",
					"admin_label" => true,
					"value" => "3000",
					"description" => __("Specify the carousel speed in miliseconds, enter just a number. Example: 2000.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Auto Rotate?", "js_composer"),
					"param_name" => "auto_rotate",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Read More Link?", "js_composer"),
					"param_name" => "read_more",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which client categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show client logos.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END CLIENT CAROUSEL ------------------------
	
		// TEAM MEMBER BOX ---------------------------------
		wpb_map( array(
			"name" => __("Team Members Box", "js_composer"),
			"base" => "team_member_box",
		  	"icon" => "icon-team-member-box",
		  	"wrapper_class" => "hb-wrapper-team-member-box",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with team members.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Columns", "js_composer"),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(
		               	__("1", "js_composer") => '1',
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
					),
					"description" => __("Choose how many team members are visible at a time.", "js_composer"),
		        ),
		        array(
			      "type" => "dropdown",
			      "heading" => __("Box style", "js_composer"),
			      "param_name" => "style",
			      "value" => array(__('Normal', "js_composer") => "", __('Boxed', "js_composer") => "boxed" ),
			      "description" => __("Choose a style for this message.", "js_composer")
			    ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "count",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose how many team members items to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which team member categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Excerpt Length", "js_composer"),
					"param_name" => "excerpt_length",
					"admin_label" => false,
					"value" => "",
					"description" => __("Specify how many words will show in the excerpt, enter just a number. Example: 15.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show team members.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TEAM MEMBER BOX ------------------------

		// TESTIMONIAL BOX ---------------------------------
		wpb_map( array(
			"name" => __("Testimonial Box", "js_composer"),
			"base" => "testimonial_box",
		  	"icon" => "icon-testimonial-box",
		  	"wrapper_class" => "hb-wrapper-testimonial-box",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Testimonial Items.', 'js_composer'),
		    "params"	=> array(
		    	array(
		            "type" => "dropdown",
		            "heading" => __("Testimonial Style", "js_composer"),
		            "param_name" => "type",
		            "admin_label" => true,
		            "value" => array(
		               	__("Normal", "js_composer") => 'normal',
						__("Large", "js_composer") => 'large',
					),
					"description" => __("Choose between a Large or Normal Testimonial Style.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Columns", "js_composer"),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(
		               	__("1", "js_composer") => '1',
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
					),
					"description" => __("Choose how in many columns are team members displayed.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "count",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose how many team members items to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which team member categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show team members.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TEAM MEMBER BOX ------------------------

		// TESTIMONIAL SLIDER ---------------------------------
		wpb_map( array(
			"name" => __("Testimonial Slider", "js_composer"),
			"base" => "testimonial_slider",
		  	"icon" => "icon-testimonial-slider",
		  	"wrapper_class" => "hb-wrapper-testimonial-slider",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Testimonial Slider.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "dropdown",
		            "heading" => __("Slider Type", "js_composer"),
		            "param_name" => "type",
		            "admin_label" => true,
		            "value" => array(
		               	__("Normal", "js_composer") => 'normal',
						__("Large", "js_composer") => 'large',
					),
					"description" => __("Choose between a Large or Normal Testimonial Slider.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "count",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter how many testimonials to show in the slider. Leave empty to display all testimonials. Example: 5.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which client categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Slideshow Speed", "js_composer"),
					"param_name" => "slideshow_speed",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter time in ms. This is the time an item will be visible before switching to another testimonial. Example: 5000.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Animation Speed", "js_composer"),
					"param_name" => "animation_speed",
					"admin_label" => true,
					"value" => "",
					"description" => __("Enter time in ms. This is the transition time between two testimonials. Example: 350.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show testimonials.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TESTIMONIAL SLIDER ------------------------

		// CLIENT CAROUSEL ---------------------------------
		wpb_map( array(
			"name" => __("Client Carousel", "js_composer"),
			"base" => "client_carousel",
		  	"icon" => "icon-client-carousel",
		  	"wrapper_class" => "hb-wrapper-client-carousel",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with client logos.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "dropdown",
		            "heading" => __("Style", "js_composer"),
		            "param_name" => "style",
		            "admin_label" => true,
		            "value" => array(
		               	__("Simple", "js_composer") => 'simple',
						__("Focus", "js_composer") => 'focus',
						__("Greyscale", "js_composer") => 'greyscale',
						__("White Boxed", "js_composer") => 'simple-white',
					),
					"description" => __("Choose how the client logos are styled.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Visible items", "js_composer"),
					"param_name" => "visible_items",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
						__("7", "js_composer") => '7',
						__("8", "js_composer") => '8',
					),
					"description" => __("Choose how many posts are visible at a time.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "total_items",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose how many client logos to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Speed", "js_composer"),
					"param_name" => "carousel_speed",
					"admin_label" => true,
					"value" => "",
					"description" => __("Specify the carousel speed in miliseconds, enter just a number. Example: 2000.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Auto Rotate?", "js_composer"),
					"param_name" => "auto_rotate",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which client categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show client logos.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END CLIENT CAROUSEL ------------------------

		// TEAM MEMBER CAROUSEL ---------------------------------
		wpb_map( array(
			"name" => __("Team Members Carousel", "js_composer"),
			"base" => "team_carousel",
		  	"icon" => "icon-team-carousel",
		  	"wrapper_class" => "hb-wrapper-team-carousel",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with team members.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Visible items", "js_composer"),
					"param_name" => "visible_items",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
						__("7", "js_composer") => '7',
						__("8", "js_composer") => '8',
					),
					"description" => __("Choose how many team members are visible at a time.", "js_composer"),
		        ),

		        array(
			      "type" => "dropdown",
			      "heading" => __("Member Box style", "js_composer"),
			      "param_name" => "style",
			      "value" => array(__('Normal', "js_composer") => "", __('Boxed', "js_composer") => "boxed" ),
			      "description" => __("Choose a style for this message.", "js_composer")
			    ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "total_items",
					"admin_label" => true,
					"value" => "4",
					"description" => __("Choose how many team members items to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Excerpt Length", "js_composer"),
					"param_name" => "excerpt_length",
					"admin_label" => false,
					"value" => "",
					"description" => __("Specify how many words will show in the excerpt, enter just a number. Example: 15.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Speed", "js_composer"),
					"param_name" => "carousel_speed",
					"admin_label" => true,
					"value" => "5000",
					"description" => __("Specify the carousel speed in miliseconds, enter just a number. Example: 2000.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Auto Rotate?", "js_composer"),
					"param_name" => "auto_rotate",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which team member categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show team members.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TEAM MEMBER CAROUSEL ------------------------

		// PORTFOLIO CAROUSEL ---------------------------------
		wpb_map( array(
			"name" => __("Portfolio Carousel", "js_composer"),
			"base" => "portfolio_carousel",
		  	"icon" => "icon-portfolio-carousel",
		  	"wrapper_class" => "hb-wrapper-portfolio-carousel",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with portfolio items.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "dropdown",
		            "heading" => __("Style", "js_composer"),
		            "param_name" => "style",
		            "admin_label" => true,
		            "value" => array(
		               	__("Standard", "js_composer") => 'standard',
						__("Descriptive", "js_composer") => 'descriptive',
					),
					"description" => __("Choose how the portfolio items are styled.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Visible items", "js_composer"),
					"param_name" => "visible_items",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
						__("7", "js_composer") => '7',
						__("8", "js_composer") => '8',
					),
					"description" => __("Choose how many posts are visible at a time.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "total_items",
					"admin_label" => true,
					"value" => "8",
					"description" => __("Choose how many portfolio items to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Speed", "js_composer"),
					"param_name" => "carousel_speed",
					"admin_label" => true,
					"value" => "5000",
					"description" => __("Specify the carousel speed in miliseconds, enter just a number. Example: 2000.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Auto Rotate?", "js_composer"),
					"param_name" => "auto_rotate",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which portfolio categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show portfolio items.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END PORTFOLIO CAROUSEL ------------------------

		// GALLERY FULLWIDTH ---------------------------------
		wpb_map( array(
			"name" => __("Gallery Fullwidth", "js_composer"),
			"base" => "gallery_fullwidth",
		  	"icon" => "icon-gallery-fullwidth",
		  	"wrapper_class" => "hb-wrapper-gallery-fullwidth",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Fullwidth Gallery Section.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Columns", "js_composer"),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
					),
					"description" => __("Choose how many in how many columns to show your gallery items.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "count",
					"admin_label" => true,
					"value" => "8",
					"description" => __("Choose how many gallery items to include in the section. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which gallery categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Image Orientation", "js_composer"),
					"param_name" => "orientation",
					"admin_label" => true,
					"value" => array(
		               	__("Landscape", "js_composer") => 'landscape',
						__("Portrait", "js_composer") => 'portrait',
					),
					"description" => __("Choose orientation of the gallery thumbnails.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Image Ratio", "js_composer"),
					"param_name" => "ratio",
					"admin_label" => true,
					"value" => array(
		               	__("16:9", "js_composer") => 'ratio1',
						__("4:3", "js_composer") => 'ratio2',
						__("3:2", "js_composer") => 'ratio4',
						__("3:1", "js_composer") => 'ratio5',
						__("1:1", "js_composer") => 'ratio3',
					),
					"description" => __("Choose ratio of the gallery thumbnails.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show gallery items.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END GALLERY FULLWIDTH ------------------------

		// PORTFOLIO FULLWIDTH ---------------------------------
		wpb_map( array(
			"name" => __("Portfolio Fullwidth", "js_composer"),
			"base" => "portfolio_fullwidth",
		  	"icon" => "icon-portfolio-fullwidth",
		  	"wrapper_class" => "hb-wrapper-portfolio-fullwidth",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Fullwidth Portfolio Section.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Columns", "js_composer"),
					"param_name" => "columns",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
					),
					"description" => __("Choose how many in how many columns to show your portfolio items.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "count",
					"admin_label" => true,
					"value" => "8",
					"description" => __("Choose how many portfolio items to include in the section. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which portfolio categories will be shown in the section. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Image Orientation", "js_composer"),
					"param_name" => "orientation",
					"admin_label" => true,
					"value" => array(
		               	__("Landscape", "js_composer") => 'landscape',
						__("Portrait", "js_composer") => 'portrait',
					),
					"description" => __("Choose orientation of the portfolio thumbnails.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Image Ratio", "js_composer"),
					"param_name" => "ratio",
					"admin_label" => true,
					"value" => array(
		               	__("16:9", "js_composer") => 'ratio1',
						__("4:3", "js_composer") => 'ratio2',
						__("3:2", "js_composer") => 'ratio4',
						__("3:1", "js_composer") => 'ratio5',
						__("1:1", "js_composer") => 'ratio3',
					),
					"description" => __("Choose ratio of the portfolio thumbnails.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show portfolio items.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Top", "js_composer"),
		                "param_name" => "margin_top",
		                "value" => "",
		                "description" => __("Enter top margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Bottom", "js_composer"),
		                "param_name" => "margin_bottom",
		                "value" => "",
		                "description" => __("Enter bottom margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END PORTFOLIO FULLWIDTH ------------------------

		// GALLERY CAROUSEL ---------------------------------
		wpb_map( array(
			"name" => __("Gallery Carousel", "js_composer"),
			"base" => "gallery_carousel",
		  	"icon" => "icon-gallery-carousel",
		  	"wrapper_class" => "hb-wrapper-gallery-carousel",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Carousel with gallery items.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "dropdown",
		            "heading" => __("Style", "js_composer"),
		            "param_name" => "style",
		            "admin_label" => true,
		            "value" => array(
		               	__("Standard", "js_composer") => 'standard',
						__("Modern", "js_composer") => 'modern',
					),
					"description" => __("Choose how the gallery items are styled.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Visible items", "js_composer"),
					"param_name" => "visible_items",
					"admin_label" => true,
					"value" => array(
		               	__("2", "js_composer") => '2',
						__("3", "js_composer") => '3',
						__("4", "js_composer") => '4',
						__("5", "js_composer") => '5',
						__("6", "js_composer") => '6',
						__("7", "js_composer") => '7',
						__("8", "js_composer") => '8',
					),
					"description" => __("Choose how many posts are visible at a time.", "js_composer"),
		        ),
		    	array(
					"type" => "textfield",
					"heading" => __("Total Items", "js_composer"),
					"param_name" => "total_items",
					"admin_label" => true,
					"value" => "10",
					"description" => __("Choose how many gallery items to include in the carousel. To get all items enter -1.", "js_composer"),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Speed", "js_composer"),
					"param_name" => "carousel_speed",
					"admin_label" => true,
					"value" => "3000",
					"description" => __("Specify the carousel speed in miliseconds, enter just a number. Example: 2000.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Auto Rotate?", "js_composer"),
					"param_name" => "auto_rotate",
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Category", "js_composer"),
					"param_name" => "category",
					"admin_label" => true,
					"value" => "",
					"description" => __("Choose which gallery categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small>.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order By", "js_composer"),
					"param_name" => "orderby",
					"value" => array(
		               	__("Date", "js_composer") => 'date',
						__("Title", "js_composer") => 'title',
						__("Random", "js_composer") => 'rand',
						__("Comment Count", "js_composer") => 'comment_count',
						__("Menu Order", "js_composer") => 'menu_order',
					),
					"description" => __("Choose in which order to show gallery items.<br/><small>Select an order from the list of possible orders.</small>.", "js_composer"),

		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Order", "js_composer"),
					"param_name" => "order",
					"value" => array(
		               	__("Descending", "js_composer") => 'DESC',
						__("Ascending", "js_composer") => 'ASC',
					),
					"description" => __("Descending or Ascending order.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END GALLERY CAROUSEL ------------------------

		// LAPTOP SLIDER ---------------------------------
		wpb_map( array(
			"name" => __("Laptop Slider", "js_composer"),
			"base" => "laptop_slider",
		  	"icon" => "icon-laptop-slider",
		  	"wrapper_class" => "hb-wrapper-laptop-slider",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Slider withing a laptop mockup image.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "textfield",
		            "heading" => __("Speed", "js_composer"),
		            "param_name" => "speed",
		            "admin_label" => true,
		            "value" => "",
					"description" => __("Speed in miliseconds before slides are changed. Do not enter ms, just a number.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Bullets", "js_composer"),
					"param_name" => "bullets",
					"admin_label" => true,
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
					"description" => __("Choose whether to display the bullet navigation on the slider.", "js_composer"),
		        ),
			    array(
			      "type" => "attach_images",
			      "heading" => __("Slider Images", "js_composer"),
			      "param_name" => "images",
			      "value" => "",
			      "description" => __("Select images from media library.", "js_composer")
			    ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END LAPTOP SLIDER ------------------------

		// SIMPLE SLIDER ---------------------------------
		wpb_map( array(
			"name" => __("Simple Slider", "js_composer"),
			"base" => "simple_slider",
		  	"icon" => "icon-simple-slider",
		  	"wrapper_class" => "hb-wrapper-simple-slider",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Simple Flexslider.', 'js_composer'),
		    "params"	=> array(
		        array(
		            "type" => "textfield",
		            "heading" => __("Speed", "js_composer"),
		            "param_name" => "speed",
		            "admin_label" => true,
		            "value" => "",
					"description" => __("Speed in miliseconds before slides are changed. Do not enter ms, just a number.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Pause on Hover", "js_composer"),
					"param_name" => "pause_on_hover",
					"admin_label" => true,
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
					"description" => __("Choose whether to pause the slider when hovering.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Bordered Style", "js_composer"),
					"param_name" => "border",
					"admin_label" => true,
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
					"description" => __("Choose whether to display a white border around the slider.", "js_composer"),
		        ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Bullets", "js_composer"),
					"param_name" => "bullets",
					"admin_label" => true,
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
					"description" => __("Choose whether to display the bullet navigation on the slider.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Arrows", "js_composer"),
					"param_name" => "arrows",
					"admin_label" => true,
					"value" => array(
		               	__("Enable", "js_composer") => 'yes',
						__("Disable", "js_composer") => 'no',
					),
					"description" => __("Choose whether to display the arrow navigation on the slider.", "js_composer"),
		        ),
			    array(
			      "type" => "attach_images",
			      "heading" => __("Slider Images", "js_composer"),
			      "param_name" => "images",
			      "value" => "",
			      "description" => __("Select images from media library.", "js_composer")
			    ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END SIMPLE SLIDER ------------------------

		// SOCIAL ICONS ------------------------------
		wpb_map( array(
			"name" => __("Social Icons", "js_composer"),
			"base" => "social_icons",
		  	"icon" => "icon-social-icons",
		  	"wrapper_class" => "hb-wrapper-social-icons",
		  	"category" => __('Social', 'js_composer'),
		  	"description" => __('Generates Social Icons.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Style", "js_composer"),
					"param_name" => "style",
					"admin_label" => true,
					"value" => array(
						__("Dark", "js_composer") => 'dark',
		               	__("Light", "js_composer") => 'light',
					),
					"description" => __("Select a style for these social icons.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Size", "js_composer"),
					"param_name" => "size",
					"admin_label" => true,
					"value" => array(
						__("Small", "js_composer") => 'small',
		               	__("Large", "js_composer") => 'large',
					),
					"description" => __("Select size of these social icons.", "js_composer"),
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Open links in", "js_composer"),
		                "param_name" => "new_tab",
		                "value" => array(
		                	__("Same tab", "js_composer") => 'no',
		                	__("New tab", "js_composer") => 'yes',
		                ),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Twitter URL", "js_composer"),
		                "param_name" => "twitter",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Facebook URL", "js_composer"),
		                "param_name" => "facebook",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Skype URL", "js_composer"),
		                "param_name" => "skype",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Instagram URL", "js_composer"),
		                "param_name" => "instagram",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Pinterest URL", "js_composer"),
		                "param_name" => "pinterest",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Google Plus URL", "js_composer"),
		                "param_name" => "google_plus",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Dribbble URL", "js_composer"),
		                "param_name" => "dribbble",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("SoundCloud URL", "js_composer"),
		                "param_name" => "soundcloud",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("YouTube URL", "js_composer"),
		                "param_name" => "youtube",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Vimeo URL", "js_composer"),
		                "param_name" => "vimeo",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Flickr URL", "js_composer"),
		                "param_name" => "flickr",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Tumblr URL", "js_composer"),
		                "param_name" => "tumblr",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Yahoo URL", "js_composer"),
		                "param_name" => "yahoo",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Foursquare URL", "js_composer"),
		                "param_name" => "foursquare",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Blogger URL", "js_composer"),
		                "param_name" => "blogger",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("WordPress URL", "js_composer"),
		                "param_name" => "wordpress",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("LastFM URL", "js_composer"),
		                "param_name" => "lastfm",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("GitHub URL", "js_composer"),
		                "param_name" => "github",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("LinkedIn URL", "js_composer"),
		                "param_name" => "linkedin",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Yelp URL", "js_composer"),
		                "param_name" => "yelp",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Forrst URL", "js_composer"),
		                "param_name" => "forrst",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Deviantart URL", "js_composer"),
		                "param_name" => "deviantart",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("StumbleUpon URL", "js_composer"),
		                "param_name" => "stumbleupon",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Delicious URL", "js_composer"),
		                "param_name" => "delicious",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Reddit URL", "js_composer"),
		                "param_name" => "reddit",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Xing URL", "js_composer"),
		                "param_name" => "xing",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Behance URL", "js_composer"),
		                "param_name" => "behance",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Email URL", "js_composer"),
		                "param_name" => "envelop",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("RSS URL", "js_composer"),
		                "param_name" => "feed_2",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Custom URL", "js_composer"),
		                "param_name" => "custom_url",
		                "admin_label" => true,
		                "value" => "",
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END SOCIAL ICONS -------------------------

		// CIRCLE CHART ------------------------------
		wpb_map( array(
			"name" => __("Circle Chart", "js_composer"),
			"base" => "circle_chart",
		  	"icon" => "icon-circle-chart",
		  	"wrapper_class" => "hb-wrapper-circle-chart",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Highly customisable circle chart.', 'js_composer'),
		    "params"	=> array(
		    	array(
					"type" => "dropdown",
					"heading" => __("Chart Type", "js_composer"),
					"param_name" => "type",
					"admin_label" => true,
					"value" => array(
						__("Chart with Icon", "js_composer") => 'with-icon',
		               	__("Chart with Percent", "js_composer") => 'with-percent',
		               	__("Chart with Text", "js_composer") => 'with-text',
					),
					"description" => __("Select a type for this element.", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Chart Percent", "js_composer"),
		                "param_name" => "percent",
		                "admin_label" => true,
		                "value" => "60",
		                "description" => __("Enter a percent number here. Do not enter % character, just number! Example: 60", "js_composer")
		        ),
		        $add_icon,
		        array(
		                "type" => "textfield",
		                "heading" => __("Chart Text", "js_composer"),
		                "param_name" => "text",
		                "admin_label" => true,
		                "value" => "",
		                "description" => __("If you have selected 'Chart with Text' enter your text here. Example: Photoshop", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Chart Caption", "js_composer"),
		                "param_name" => "caption",
		                "admin_label" => true,
		                "value" => "",
		                "description" => __("Optional chart caption. Showed below the chart.", "js_composer")
		        ),
		        array(
			      "type" => "colorpicker",
			      "heading" => __("Line Color", "js_composer"),
			      "param_name" => "color",
			      "description" => __("Enter color in hex format for this element.", "js_composer")
			    ),
			    array(
			      "type" => "colorpicker",
			      "heading" => __("Circle Color", "js_composer"),
			      "param_name" => "track_color",
			      "description" => __("Enter color in hex format for the circle track bar.", "js_composer")
			    ),
			    array(
		                "type" => "textfield",
		                "heading" => __("Chart Size", "js_composer"),
		                "param_name" => "size",
		                "admin_label" => true,
		                "value" => "220",
		                "description" => __("Enter chart size value. Example: 220.", "js_composer")
		        ),
			     array(
		                "type" => "textfield",
		                "heading" => __("Chart Weight", "js_composer"),
		                "param_name" => "weight",
		                "admin_label" => true,
		                "value" => "3",
		                "description" => __("Enter chart weight value. Example: 4.", "js_composer")
		        ),

			     array(
		                "type" => "textfield",
		                "heading" => __("Animation Speed", "js_composer"),
		                "param_name" => "animation_speed",
		                "value" => "1000",
		                "description" => __("Enter chart animation speed. Useful for creating timed animations. No need to enter ms. Eg: 1000 (1000 stands for 1 second)", "js_composer")
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END CIRCLE CHART -------------------------

		// GOOGLE MAP ----------------------------------
		wpb_map( array(
			"name" => __("Map", "js_composer"),
			"base" => "map_embed",
		  	"icon" => "icon-map-embed",
		  	"wrapper_class" => "hb-wrapper-map-embed",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Embed a Google Map.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Latitude", "js_composer"),
		                "param_name" => "latitude",
		                "value" => "48.856614",
		                "description" => __("Enter latitude coordinate where the map will be centered. You can use <a href=\"http://latlong.net\" target=\"_blank\">LatLong</a> to find out coordinates.", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Longitude", "js_composer"),
		                "param_name" => "longitude",
		                "value" => "2.352222",
		                "description" => __("Enter longitude coordinate where the map will be centered. You can use <a href=\"http://latlong.net\" target=\"_blank\">LatLong</a> to find out coordinates.", "js_composer"),
		                "admin_label" => true
		        ),
		    	array(
		                "type" => "textfield",
		                "heading" => __("Zoom", "js_composer"),
		                "param_name" => "zoom",
		                "value" => "16",
		                "description" => __("Enter zoom level for the map. A numeric value from 1 to 18, where 1 is whole earth and 18 is street level zoom.", "js_composer"),
		                "admin_label" => true
		        ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Custom Pin Image", "js_composer"),
					    "param_name" => "custom_pin",
					    "value" => "",
					    "description" => __("Select image from media library.", "js_composer")
			    ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Map Height", "js_composer"),
		                "param_name" => "height",
		                "description" => __("Enter map height in pixels for the map. You can use px, em, %, etc. or enter just number and it will use pixels.", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Border Around Map", "js_composer"),
		                "param_name" => "border",
		                "value" => array(
		                	__("Show", "js_composer") => 'yes',
		                	__("Hide", "js_composer") => 'no',
		                ),
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Styled Map", "js_composer"),
		                "param_name" => "styled",
		                "value" => array(
		                	__("Yes", "js_composer") => 'yes',
		                	__("No", "js_composer") => 'no',
		                ),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END GOOGLE MAP ------------------------------


		// GOOGLE MAP ----------------------------------
		wpb_map( array(
			"name" => __("Fullwidth Map", "js_composer"),
			"base" => "fw_map_embed",
		  	"icon" => "icon-map-embed",
		  	"wrapper_class" => "hb-wrapper-map-embed",
		  	"category" => __('Special', 'js_composer'),
		  	"description" => __('Embed a Fullwidth Google Map.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Use values from Highend Options > Map Settings", "js_composer"),
		                "param_name" => "from_to",
		                "value" => array(
		                	__("No", "js_composer") => 'no',
		                	__("Yes", "js_composer") => 'yes',
		                ),
		        ),
		    	array(
		                "type" => "textfield",
		                "heading" => __("Latitude", "js_composer"),
		                "param_name" => "latitude",
		                "value" => "48.856614",
		                "description" => __("Enter latitude coordinate where the map will be centered. You can use <a href=\"http://latlong.net\" target=\"_blank\">LatLong</a> to find out coordinates.", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Longitude", "js_composer"),
		                "param_name" => "longitude",
		                "value" => "2.352222",
		                "description" => __("Enter longitude coordinate where the map will be centered. You can use <a href=\"http://latlong.net\" target=\"_blank\">LatLong</a> to find out coordinates.", "js_composer"),
		                "admin_label" => true
		        ),
		    	array(
		                "type" => "textfield",
		                "heading" => __("Zoom", "js_composer"),
		                "param_name" => "zoom",
		                "value" => "16",
		                "description" => __("Enter zoom level for the map. A numeric value from 1 to 18, where 1 is whole earth and 18 is street level zoom.", "js_composer"),
		                "admin_label" => true
		        ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Custom Pin Image", "js_composer"),
					    "param_name" => "custom_pin",
					    "value" => "",
					    "description" => __("Select image from media library.", "js_composer")
			    ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Map Height", "js_composer"),
		                "param_name" => "height",
		                "description" => __("Enter map height in pixels for the map.", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Top", "js_composer"),
		                "param_name" => "margin_top",
		                "description" => __("Enter top margin. You can use px, em, %, etc. or enter just number and it will use pixels.", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Bottom", "js_composer"),
		                "param_name" => "margin_bottom",
		                "description" => __("Enter bottom margin. You can use px, em, %, etc. or enter just number and it will use pixels.", "js_composer"),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END GOOGLE MAP ------------------------------

		// BUTTON ----------------------------------
		wpb_map( array(
			"name" => __("Button", "js_composer"),
			"base" => "button",
		  	"icon" => "icon-button",
		  	"wrapper_class" => "hb-wrapper-button",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Generates a button.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Button Title", "js_composer"),
		                "param_name" => "title",
		                "description" => __("Enter the title/caption for this button. Example: Click Me", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Button Link", "js_composer"),
		                "param_name" => "link",
		                "description" => __("Choose URL of the link for the button. <br/>Enter with http:// prefix. You can also enter section id with # prefix to scroll to the section within your page. Example #home", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Open link in", "js_composer"),
		                "param_name" => "new_tab",
		                "value" => array(
		                	__("Same tab", "js_composer") => 'no',
		                	__("New tab", "js_composer") => 'yes',
		                ),
		        ),
		        $add_icon,
		        array(
		                "type" => "dropdown",
		                "heading" => __("Styling", "js_composer"),
		                "param_name" => "special_style",
		                "value" => array(
		                	__("Standard", "js_composer") => 'no',
		                	__("Special", "js_composer") => 'yes',
		                ),
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("3D Effect", "js_composer"),
		                "param_name" => "three_d",
		                "value" => array(
		                	__("No", "js_composer") => 'no',
		                	__("Yes", "js_composer") => 'yes',
		                ),
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Size", "js_composer"),
		                "param_name" => "size",
		                "description" => __("Choose size for this button.", "js_composer"),
		                "value" => array(
		                	__("Standard", "js_composer") => 'default',
		                	__("Small", "js_composer") => 'small',
		                	__("Large", "js_composer") => 'large',
		                ),
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Color", "js_composer"),
		                "param_name" => "color",
		                "description" => __("Choose color for this button.", "js_composer"),
		                "value" => array(
		                	__("Standard", "js_composer") => 'default',
		                	__("Turqoise", "js_composer") => 'turqoise',
		                	__("Green Sea", "js_composer") => 'green-sea',
		                	__("Sunflower", "js_composer") => 'sunflower',
		                	__("Orange", "js_composer") => 'orange',
		                	__("Emerald", "js_composer") => 'emerald',
		                	__("Nephritis", "js_composer") => 'nephritis',
		                	__("Carrot", "js_composer") => 'carrot',
		                	__("Pumpkin", "js_composer") => 'pumpkin',
		                	__("Peter River", "js_composer") => 'peter-river',
		                	__("Belize", "js_composer") => 'belize',
		                	__("Alizarin", "js_composer") => 'alizarin',
		                	__("Pomegranate", "js_composer") => 'pomegranate',
		                	__("Amethyst", "js_composer") => 'amethyst',
		                	__("Wisteria", "js_composer") => 'wisteria',
		                	__("Wet Asphalt", "js_composer") => 'wet-asphalt',
		                	__("Midnight Blue", "js_composer") => 'midnight-blue',
		                	__("Concrete", "js_composer") => 'concrete',
		                	__("Asbestos", "js_composer") => 'asbestos',
		                	__("Darkly", "js_composer") => 'darkly',
		                	__("Light", "js_composer") => 'second-light',
		                	__("Light III", "js_composer") => 'hb-third-light',
		                	__("Dark II", "js_composer") => 'second-dark',
		                	__("Dark III", "js_composer") => 'third-dark',
		                	__("Yellow", "js_composer") => 'yellow',
		                ),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END BUTTON ------------------------------

		// MODAL ----------------------------------
		wpb_map( array(
			"name" => __("Modal Window", "js_composer"),
			"base" => "modal_window",
		  	"icon" => "icon-modal",
		  	"wrapper_class" => "hb-wrapper-modal",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Show content in modal window.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Window Title", "js_composer"),
		                "param_name" => "title",
		                "description" => __("Enter a title for this modal window. Example: My Window Title", "js_composer"),
		                "admin_label" => true
		        ),
		    	array(
				      "type" => "textarea_html",
				      "class" => "callout-box-holder",
				      "heading" => __("Callout Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
			    array(
		                "type" => "textfield",
		                "heading" => __("Invoke Button Title", "js_composer"),
		                "param_name" => "invoke_title",
		                "description" => __("Enter a title for the invoke button for this modal window. Example: Show Modal", "js_composer"),
		                "admin_label" => true
		        ),
			    array(
		                "type" => "dropdown",
		                "heading" => __("Show On Load", "js_composer"),
		                "param_name" => "show_on_load",
		                "value" => array(
		                	__("Yes", "js_composer") => 'yes',
		                	__("No", "js_composer") => 'no',
		                ),
		                "description" => __("Choose if you want to show this modal window automatically when the page loads.", "js_composer"),
		                "admin_label" => true
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Optional Unique ID", "js_composer"),
		                "param_name" => "id",
		                "description" => __("Enter a UNIQUE id word, without spaces, that will be assigned to this modal window. You can use this id to invoke the window with javascript if you don't want to show the invoke button.", "js_composer"),
		                "admin_label" => true
		        ),
		    ),
		));
		// END MODAL ------------------------------

		// BOX CONTENT ----------------------------
		wpb_map( array(
			"name" => __("Content Box", "js_composer"),
			"base" => "content_box",
		  	"icon" => "icon-content-box",
		  	"wrapper_class" => "hb-wrapper-content-box",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Shows any content in styled box.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Box Style", "js_composer"),
		                "param_name" => "type",
		                "value" => array(
		                	__("With Header", "js_composer") => 'with-header',
		                	__("Without Header", "js_composer") => 'without-header',
		                ),
		                "description" => __("Choose your box style.", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Box Title", "js_composer"),
		                "param_name" => "title",
		                "holder" => "div",
		                "class" => "box-title-holder",
		                "description" => __("Enter box title here if you have selected 'With Header' box style.<br/>Example: My box title.", "js_composer")
		        ),
		        array(
				      "type" => "textarea_html",
				      "holder" => "div",
				      "class" => "box-content-holder",
				      "heading" => __("Text", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
			    $add_icon,
			    array(
			    	"type" => "colorpicker",
			    	"heading" => __("Background Color", "js_composer"),
			    	"param_name" => "color",
			    	"admin_label" => true,
			    	"description" => __("Choose background color for this box.", "js_composer")
			    ),
			    array(
					"type" => "dropdown",
					"heading" => __("Content Color", "js_composer"),
					"param_name" => "text_color",
					"admin_label" => true,
					"value" => array(
						__("Dark", "js_composer") => 'dark',
						__("Light", "js_composer") => 'light',
						),
					"description" => __("Choose your text color style.", "js_composer")
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END BOX CONTENT ------------------------

		// CALLOUT --------------------------------
		wpb_map( array(
			"name" => __("Callout Box", "js_composer"),
			"base" => "callout",
		  	"icon" => "icon-callout-box",
		  	"wrapper_class" => "hb-wrapper-callout-box",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Shows a styled callout box with optional button.', 'js_composer'),
		    "params"	=> array(
		    	array(
				      "type" => "textarea_html",
				      "holder" => "div",
				      "class" => "callout-box-holder",
				      "heading" => __("Callout Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
		    	array(
		                "type" => "textfield",
		                "heading" => __("Button Title", "js_composer"),
		                "param_name" => "title",
		                "holder" => "button",
		                "class" => "callout-button-holder",
		                "description" => __("Enter the title/caption for this button. Leave empty if you don't need a button.", "js_composer")
		        ),
		        $add_icon,
		        array(
		                "type" => "textfield",
		                "heading" => __("Button Link URL", "js_composer"),
		                "param_name" => "link",
		                "class" => "callout-button-holder",
		                "description" => __("Choose URL of the link for the button. Enter with http:// prefix.<br/>You can also enter section id with # prefix to scroll to the section within your page. Example #home", "js_composer")
		        ),
		        array(
		                "type" => "dropdown",
		                "heading" => __("Open link in", "js_composer"),
		                "param_name" => "type",
		                "value" => array(
		                	__("Same tab", "js_composer") => 'no',
		                	__("New tab", "js_composer") => 'yes',
		                ),
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END CALLOUT ----------------------------

		// SITEMAP --------------------------------
		wpb_map( array(
			"name" => __("Sitemap", "js_composer"),
			"base" => "sitemap",
		  	"icon" => "icon-sitemap-image",
		  	"wrapper_class" => "hb-wrapper-sitemap",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Shows sitemap of your website.', 'js_composer'),
		  	"show_settings_on_create" => false,
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Sitemap Depth", "js_composer"),
		                "param_name" => "depth",
		                "value" => "2",
		                "admin_label" => true,
		                "description" => __("Specify how many child levels to show. Leave empty for default value. Default: 2.", "js_composer")
		        ),
		        $add_class,
		    ),
		));
		// END SITEMAP ---------------------------

		// SPACER --------------------------------
		wpb_map( array(
			"name" => __("Spacer", "js_composer"),
			"base" => "spacer",
		  	"icon" => "icon-spacer",
		  	"wrapper_class" => "hb-wrapper-spacer",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('A blank spacer with specified height.', 'js_composer'),
		  	"show_settings_on_create" => false,
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Spacer Height", "js_composer"),
		                "param_name" => "height",
		                "value" => "",
		                "description" => __("Enter the height of this spacer. You can use px, em, %, etc. or enter just number and it will use pixels. Example: 40", "js_composer"),
		        ),
		        $add_class,
		    ),
		));
		// END SPACER --------------------------------

		// SKILL BAR ---------------------------------
		wpb_map( array(
			"name" => __("Skill Bar", "js_composer"),
			"base" => "skill",
		  	"icon" => "icon-skill-bar",
		  	"wrapper_class" => "hb-wrapper-skill-bar",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('A single skill bar.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Skill Value", "js_composer"),
		                "param_name" => "number",
		                "value" => "75",
		                "description" => __("Enter the number this skill is filled. Maximum 100. Do not write % or any other character. Example: 80", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Character", "js_composer"),
		                "param_name" => "char",
		                "value" => "%",
		                "description" => __("Enter a character which stands next to the number. Example: %", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Skill Caption", "js_composer"),
		                "param_name" => "caption",
		                "value" => "Enter Caption",
		                "description" => __("A word, or short text to display above the skill meter. Example: Photoshop", "js_composer"),
		        ),
		        array(
			      "type" => "colorpicker",
			      "heading" => __("Color", "js_composer"),
			      "param_name" => "color",
			      "description" => __("Choose a focus color in hex format for this skill bar. Leave empty for default value.", "js_composer")
			    ),
		        $add_class,
		    ),
		));
		// END SKILL BAR -----------------------------


		// SEPARATOR ---------------------------------
		wpb_map( array(
			"name" => __("Separator", "js_composer"),
			"base" => "separator",
		  	"icon" => "icon-separator",
		  	"wrapper_class" => "hb-wrapper-separator",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Line separator with extra options.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Separator Type", "js_composer"),
		                "param_name" => "type",
		                "value" => array(
		                	__("Default", "js_composer") => 'default',
		                	__("Small Break", "js_composer") => 'small-break',
		                	__("Default Double", "js_composer") => 'default-double',
		                	__("Dashed", "js_composer") => 'dashed',
		                	__("Dashed Double", "js_composer") => 'dashed-double',
		                	__("Small", "js_composer") => 'small',
		                	__("* Fullwidth", "js_composer") => 'hb-fw-separator',
		                	__("* Fullwidth Dashed", "js_composer") => 'hb-fw-dashed',
		                ),
		                "admin_label" => true,
		                "description" => __("Choose your separator style. * Fullwidth Separator does not support all of the options and it has to be used in fullwidth layout.", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Optional scissors icon?", "js_composer"),
			      "param_name" => "scissors_icon",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Go to top button?", "js_composer"),
			      "param_name" => "go_to_top",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
					"type" => "textfield",
					"heading" => __("Margin Top", "js_composer"),
					"param_name" => "margin_top",
					"value" => "",
					"description" => __("Enter the top margin in pixels. You can use px, em, %, etc. or enter just number and it will use pixels. Leave empty for default value. Example: 40", "js_composer")
		        ),
		        array(
					"type" => "textfield",
					"heading" => __("Margin Bottom", "js_composer"),
					"param_name" => "margin_bottom",
					"value" => "",
					"description" => __("Enter the bottom margin in pixels. You can use px, em, %, etc. or enter just number and it will use pixels. Leave empty for default value. Example: 40", "js_composer")
		        ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END SEPARATOR ------------------------


		// CLEAR --------------------------------
		wpb_map( array(
			"name" => __("Clear", "js_composer"),
			"base" => "clear",
		  	"icon" => "icon-clear",
		  	"controls" => "popup_delete",
		  	"wrapper_class" => "hb-wrapper-clear",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Clear floated elements.', 'js_composer'),
		  	"show_settings_on_create" => false,
		));
		// END CLEAR --------------------------------


		// INFO MESSAGE -----------------------------
		wpb_map( array(
			"name" => __("Info Message", "js_composer"),
			"base" => "info_message",
		  	"icon" => "icon-message",
			"wrapper_class" => "hb-notification-box",
			"category" => __('Content', 'js_composer'),
			"description" => __('Notification box', 'js_composer'),
			"params" => array(
				array(
			      "type" => "dropdown",
			      "heading" => __("Message style", "js_composer"),
			      "param_name" => "style",
			      "value" => array(__('Info', "js_composer") => "info", __('Warning', "js_composer") => "warning", __('Success', "js_composer") => "success", __('Error', "js_composer") => "error"),
			      "description" => __("Choose a style for this message.", "js_composer")
			    ),
			    array(
			      "type" => "textarea_html",
			      "holder" => "div",
			      "class" => "messagebox_text",
			      "heading" => __("Message text", "js_composer"),
			      "param_name" => "content",
			      "value" => __("<p>I am message box. Click edit button to change this text.</p>", "js_composer")
			    ),
			    $add_css_animation,
			    $add_animation_delay,
			    $add_class,
			)
		));
		// END INFO MESSAGE -------------------------

		
		// COUNTDOWN --------------------------------
		wpb_map( array(
			"name" => __("Countdown", "js_composer"),
			"base" => "countdown",
		  	"icon" => "icon-countdown",
		  	"wrapper_class" => "hb-wrapper-countdown",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Countdown timer for specified date and time in future. Time is in 24h format.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Date & Time", "js_composer"),
		                "param_name" => "date",
		                "value" => "24 april 2016 16:00:00",
		                "admin_label" => true,
		                "description" => __("Enter date and time for which countdown will count.<br/>Must enter in this format: <strong>27 february 2014 12:00:00</strong>", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Align center?", "js_composer"),
			      "param_name" => "aligncenter",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes', __("No", "js_composer") => 'no')
			    ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));

		// VIDEO EMBED ---------------------------
		wpb_map( array(
			"name" => __("Video Embed", "js_composer"),
			"base" => "video_embed",
		  	"icon" => "icon-video-embed",
		  	"wrapper_class" => "hb-wrapper-video-embed",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Embed video from Youtube/Vimeo or similar.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Embed Style", "js_composer"),
		                "param_name" => "embed_style",
		                "value" => array(
		                	__("Default", "js_composer") => 'default',
		                	__("In Lightbox", "js_composer") => 'in_lightbox',
		                ),
		                "admin_label" => true,
		                "description" => __("Choose between standard embed and embed in lightbox. Lightbox embed will generate a button invoker.", "js_composer")
		        ),
		    	array(
		                "type" => "textfield",
		                "heading" => __("Video URL", "js_composer"),
		                "param_name" => "url",
		                "admin_label" => true,
		                "value" => "",
		                "description" => __("URL to the video which needs to be embedded.<br/>Youtube example: <strong>http://www.youtube.com/watch?v=NxfK4LANqww</strong>", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Video Width", "js_composer"),
		                "param_name" => "width",
		                "admin_label" => true,
		                "value" => "",
		                "description" => __("Width of the Video in pixels. Height will be calculated automatically. You can use px, em, %, etc. or enter just number and it will use pixels. Leave empty for fullwidth.<br/>Example: <strong>550</strong>", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Border around video?", "js_composer"),
			      "param_name" => "border",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
		        $add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END VIDEO EMBED --------------------------------

		// FW SECTION -------------------------------------
		wpb_map( array(
			"name" => __("Fullwidth Section", "js_composer"),
			"base" => "fullwidth_section",
		  	"icon" => "icon-fw-section",
		  	"wrapper_class" => "hb-wrapper-fw-section",
		  	"category" => __('Special', 'js_composer'),
		  	"description" => __('Place fullwidth section with image, video or simply color.', 'js_composer'),
		    "params"	=> array(
		    	array(
				      "type" => "textarea_html",
				      "class" => "callout-box-holder",
				      "heading" => __("Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Background Type", "js_composer"),
		                "param_name" => "background_type",
		                "value" => array(
		                	__("Background Color", "js_composer") => 'color',
		                	__("Background Image", "js_composer") => 'image',
		                	__("Background Texture", "js_composer") => 'texture',
		                	__("Background Video", "js_composer") => 'video',
		                ),
		                "admin_label" => true,
		                "description" => __("Select a background type for this element.", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Enable Border?", "js_composer"),
			      "param_name" => "border",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
		                "type" => "dropdown",
		                "heading" => __("Text Color", "js_composer"),
		                "param_name" => "text_color",
		                "value" => array(
		                	__("Dark", "js_composer") => 'dark',
		                	__("Light", "js_composer") => 'light',
		                ),
		                "description" => __("Select a text color style for this element. Use light when your background is dark and opposite.", "js_composer")
		        ),
		        array(
			      "type" => "colorpicker",
			      "heading" => __("Background Color", "js_composer"),
			      "param_name" => "bg_color",
			      "description" => __("Choose background color in hex format.", "js_composer")
			    ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Background Image or Texture", "js_composer"),
					    "param_name" => "image",
					    "value" => "",
					    "admin_label" => true,
					    "description" => __("Select an image from media library that will be used as your background image or texture depending on value in Background Type.", "js_composer")
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Enable Parallax effect for image?", "js_composer"),
			      "param_name" => "parallax",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Optional Scissors Icon?", "js_composer"),
			      "param_name" => "scissors_icon",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
			      		"type" => "textfield",
					    "heading" => __("Background Video MP4", "js_composer"),
					    "param_name" => "bg_video_mp4",
					    "admin_label" => true,
					    "value" => "",
					    "description" => __("If you have chosen \"Background Video\" for the Background Type, then upload your video in MP4 format here. ", "js_composer")
			    ),
			    array(
			      		"type" => "textfield",
					    "heading" => __("Background Video OGV", "js_composer"),
					    "param_name" => "bg_video_ogv",
					    "admin_label" => true,
					    "value" => "",
					    "description" => __("If you have chosen \"Background Video\" for the Background Type, then upload your video in OGG format here. ", "js_composer")
			    ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Background Video Poster", "js_composer"),
					    "param_name" => "bg_video_poster",
					    "value" => "",
					    "description" => __("Select an image that will be used as a placeholder until video is loaded (or cannot be loaded). ", "js_composer")
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Video Texture Overlay?", "js_composer"),
			      "param_name" => "overlay",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
		                "type" => "textfield",
		                "heading" => __("Margin Top", "js_composer"),
		                "param_name" => "margin_top",
		                "value" => "",
		                "description" => __("Enter top margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Bottom", "js_composer"),
		                "param_name" => "margin_bottom",
		                "value" => "",
		                "description" => __("Enter bottom margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Inside Padding Top", "js_composer"),
		                "param_name" => "padding_top",
		                "value" => "30",
		                "description" => __("Enter top padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Inside Padding Bottom", "js_composer"),
		                "param_name" => "padding_bottom",
		                "value" => "30",
		                "description" => __("Enter bottom padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50", "js_composer")
		        ),
		        $add_class,
		        array(
		                "type" => "textfield",
		                "heading" => __("Unique Section ID", "js_composer"),
		                "param_name" => "id",
		                "value" => "",
		                "admin_label" => true,
		                "description" => __("If needed, enter a UNIQUE section id, without whitespaces. You can use that id to make links to this section. Example: about-us", "js_composer")
		        ),
		    ),
		));
		// END FW SECTION --------------------------------

		// FW SECTION -------------------------------------
		wpb_map( array(
			"name" => __("One Page Section", "js_composer"),
			"base" => "onepage_section",
		  	"icon" => "icon-onepage-section",
		  	"wrapper_class" => "hb-wrapper-onepage-section",
		  	"category" => __('Special', 'js_composer'),
		  	"description" => __('Place One Page section for your One Page website.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Unique Section ID", "js_composer"),
		                "param_name" => "id",
		                "value" => "",
		                "admin_label" => true,
		                "description" => __("Enter a UNIQUE section id, without whitespaces. This is very important for One Page websites, as this will be used for a navigation. For example, if you have entered <strong>first-page</strong> in this field, in your menu, you would enter <strong>#first-page</strong> to link to this page.", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Section Title", "js_composer"),
		                "param_name" => "name",
		                "value" => "My Page",
		                "admin_label" => true,
		                "description" => __("Enter title for this section. It will be used in left circle navigation on one page websites.", "js_composer")
		        ),
		    	array(
				      "type" => "textarea_html",
				      "class" => "callout-box-holder",
				      "heading" => __("Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
		    	array(
		                "type" => "dropdown",
		                "heading" => __("Background Type", "js_composer"),
		                "param_name" => "background_type",
		                "value" => array(
		                	__("Background Color", "js_composer") => 'color',
		                	__("Background Image", "js_composer") => 'image',
		                	__("Background Texture", "js_composer") => 'texture',
		                	__("Background Video", "js_composer") => 'video',
		                ),
		                "admin_label" => true,
		                "description" => __("Select a background type for this element.", "js_composer")
		        ),
		        array(
			      "type" => 'checkbox',
			      "heading" => __("Enable Border?", "js_composer"),
			      "param_name" => "border",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
		                "type" => "dropdown",
		                "heading" => __("Text Color", "js_composer"),
		                "param_name" => "text_color",
		                "value" => array(
		                	__("Dark", "js_composer") => 'dark',
		                	__("Light", "js_composer") => 'light',
		                ),
		                "description" => __("Select a text color style for this element. Use light when your background is dark and opposite.", "js_composer")
		        ),
		        array(
			      "type" => "colorpicker",
			      "heading" => __("Background Color", "js_composer"),
			      "param_name" => "bg_color",
			      "description" => __("Choose background color in hex format.", "js_composer")
			    ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Background Image or Texture", "js_composer"),
					    "param_name" => "image",
					    "value" => "",
					    "admin_label" => true,
					    "description" => __("Select an image from media library that will be used as your background image or texture depending on value in Background Type.", "js_composer")
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Enable Parallax effect for image?", "js_composer"),
			      "param_name" => "parallax",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Optional Scissors Icon?", "js_composer"),
			      "param_name" => "scissors_icon",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
			      		"type" => "textfield",
					    "heading" => __("Background Video MP4", "js_composer"),
					    "param_name" => "bg_video_mp4",
					    "value" => "",
					    "description" => __("If you have chosen \"Background Video\" for the Background Type, then upload your video in MP4 format here. ", "js_composer")
			    ),
			    array(
			      		"type" => "textfield",
					    "heading" => __("Background Video OGV", "js_composer"),
					    "param_name" => "bg_video_ogv",
					    "value" => "",
					    "description" => __("If you have chosen \"Background Video\" for the Background Type, then upload your video in OGG format here. ", "js_composer")
			    ),
			    array(
			      		"type" => "attach_image",
					    "heading" => __("Background Video Poster", "js_composer"),
					    "param_name" => "poster",
					    "value" => "",
					    "description" => __("Select an image that will be used as a placeholder until video is loaded (or cannot be loaded). ", "js_composer")
			    ),
			    array(
			      "type" => 'checkbox',
			      "heading" => __("Video Texture Overlay?", "js_composer"),
			      "param_name" => "overlay",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
			    array(
		                "type" => "textfield",
		                "heading" => __("Margin Top", "js_composer"),
		                "param_name" => "margin_top",
		                "value" => "",
		                "description" => __("Enter top margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Margin Bottom", "js_composer"),
		                "param_name" => "margin_bottom",
		                "value" => "",
		                "description" => __("Enter bottom margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Inside Padding Top", "js_composer"),
		                "param_name" => "padding_top",
		                "value" => "30",
		                "description" => __("Enter top padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Inside Padding Bottom", "js_composer"),
		                "param_name" => "padding_bottom",
		                "value" => "30",
		                "description" => __("Enter bottom padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50", "js_composer")
		        ),
		        $add_class,
		    ),
		));
		// END FW SECTION --------------------------------

		// MILESTONE COUNTER -----------------------------
		wpb_map( array(
			"name" => __("Milestone Counter", "js_composer"),
			"base" => "counter",
		  	"icon" => "icon-counter",
		  	"wrapper_class" => "hb-wrapper-counter",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Place lovely customisable number counter.', 'js_composer'),
		    "params"	=> array(
		    	array(
		                "type" => "textfield",
		                "heading" => __("Start Number", "js_composer"),
		                "param_name" => "from",
		                "admin_label" => true,
		                "value" => "0",
		                "description" => __("Enter a start number for the counter. Counting will begin from this number. This value has to be numerical. Example: 0", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("End Number", "js_composer"),
		                "param_name" => "to",
		                "admin_label" => true,
		                "value" => "1250",
		                "description" => __("Enter an end number for the counter. Counting will end on this number. This value has to be a numerical. Example: 1250", "js_composer")
		        ),
		        $add_icon,
		        array(
		                "type" => "textfield",
		                "heading" => __("Subtitle", "js_composer"),
		                "param_name" => "subtitle",
		                "admin_label" => true,
		                "value" => "My Subtitle",
		                "description" => __("A word, or short text to display below the counter. Example: Apples Eaten", "js_composer")
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("Counter Speed", "js_composer"),
		                "param_name" => "speed",
		                "value" => "700",
		                "description" => __("Enter counter speed value in miliseconds. Example: 700", "js_composer")
		        ),
		        array(
			      "type" => "colorpicker",
			      "heading" => __("Focus Color", "js_composer"),
			      "param_name" => "color",
			      "description" => __("Choose a color in hex format for this element.", "js_composer")
			    ),
				$add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END MILESTONE COUNTER -------------------------
		
		// IMAGE FRAME -----------------------------------
		wpb_map( array(
			"name" => __("Image Frame", "js_composer"),
			"base" => "image_frame",
		  	"icon" => "icon-image-frame",
		  	"wrapper_class" => "hb-wrapper-image-frame",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Insert a regular image with additional options.', 'js_composer'),
		    "params"	=> array(
		    	array(
			      		"type" => "attach_image",
					    "heading" => __("Image", "js_composer"),
					    "param_name" => "url",
					    "value" => "",
					    "description" => __("Upload your image here. Make sure to choose size also... ", "js_composer")
			    ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Image Border Style", "js_composer"),
					"param_name" => "border_style",
					"admin_label" => true,
					"value" => array(
		               	__("Without frame", "js_composer") => 'no-frame',
		               	__("Circle frame", "js_composer") => 'circle-frame',
						__("Boxed frame", "js_composer") => 'boxed-frame',
						__("Boxed frame with hover", "js_composer") => 'boxed-frame-hover',
					),
					"description" => __("Choose an image border style.", "js_composer"),
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("On Click Action", "js_composer"),
					"param_name" => "action",
					"admin_label" => true,
					"value" => array(
		               	__("Do nothing", "js_composer") => 'none',
						__("Open lightbox", "js_composer") => 'open-url',
						__("Open url in same tab", "js_composer") => 'open-lightbox',
					),
					"description" => __("Choose what to do when clicked on image.", "js_composer"),
		        ),
		        array(
		                "type" => "textfield",
		                "heading" => __("URL Link", "js_composer"),
		                "param_name" => "link",
		                "value" => "",
		                "description" => __("Enter URL where it will lead when clicked on the image. On Click Action has to be \"Open URL\". You need to enter full website address with http:// prefix.", "js_composer")
		        ),
		         array(
		                "type" => "textfield",
		                "heading" => __("Gallery REL attribute", "js_composer"),
		                "param_name" => "rel",
		                "value" => "",
		                "description" => __("If you want to open this image in lightbox gallery along with other images, then enter the same Gallery REL for all those images. Example: my-gal", "js_composer")
		        ),
				$add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END IMAGE FRAME --------------------------------

		// IMAGE BANNER -----------------------------------
		wpb_map( array(
			"name" => __("Image Banner", "js_composer"),
			"base" => "image_banner",
		  	"icon" => "icon-image-frame",
		  	"wrapper_class" => "hb-wrapper-image-frame",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Insert an image banner.', 'js_composer'),
		    "params"	=> array(
		    	array(
			      		"type" => "attach_image",
					    "heading" => __("Image", "js_composer"),
					    "param_name" => "url",
					    "value" => "",
					    "description" => __("Upload your image here. Make sure to choose size also... The dimensions of a banner depends on your image size.", "js_composer")
			    ),
			    array(
				      "type" => "textarea_html",
				      "heading" => __("Banner Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Text Color", "js_composer"),
					"param_name" => "text_color",
					"admin_label" => true,
					"value" => array(
						__("Dark", "js_composer") => 'dark',
						__("Light", "js_composer") => 'light',
						),
					"description" => __("Choose your text color style.", "js_composer")
		        ),
				$add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END IMAGE BANNER ------------------------

		// TITLE -----------------------------------
		wpb_map( array(
			"name" => __("Title", "js_composer"),
			"base" => "title",
		  	"icon" => "icon-title",
		  	"wrapper_class" => "hb-wrapper-title",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Place a title.', 'js_composer'),
		    "params"	=> array(
			    array(
				      "type" => "textfield",
				      "heading" => __("Title Content", "js_composer"),
				      "param_name" => "content",
				      "admin_label" => true,
				      "value" => __("Enter your title here", "js_composer")
			    ),
			    array(
			      "type" => "colorpicker",
			      "heading" => __("Text Color", "js_composer"),
			      "param_name" => "color",
			      "admin_label" => true,
			      "description" => __("Choose a color in hex format for this element.", "js_composer")
			    ),
		    	array(
					"type" => "dropdown",
					"heading" => __("Title Type", "js_composer"),
					"param_name" => "type",
					"admin_label" => true,
					"value" => array(
						__("Extra Large", "js_composer") => 'extra-large',
						__("H1", "js_composer") => 'h1',
						__("H2", "js_composer") => 'h2',
						__("H3", "js_composer") => 'h3',
						__("H4", "js_composer") => 'h4',
						__("H5", "js_composer") => 'h5',
						__("H6", "js_composer") => 'h6',
						__("Special H3", "js_composer") => 'special-h3',
						__("Special H3 Left", "js_composer") => 'special-h3-left',
						__("Special H3 Right", "js_composer") => 'special-h3-right',
						__("Special H4", "js_composer") => 'special-h4',
						__("Special H4 Left", "js_composer") => 'special-h4-left',
						__("Special H4 Right", "js_composer") => 'special-h4-right',
						__("Fancy H1", "js_composer") => 'fancy-h1',
						__("Fancy H2", "js_composer") => 'fancy-h2',
						__("Fancy H3", "js_composer") => 'fancy-h3',
						__("Fancy H4", "js_composer") => 'fancy-h4',
						__("Fancy H5", "js_composer") => 'fancy-h5',
						__("Fancy H6", "js_composer") => 'fancy-h6',
						__("Subtitle H3", "js_composer") => 'subtitle-h3',
						__("Subtitle H6", "js_composer") => 'subtitle-h6',
						__("Special H6", "js_composer") => 'special-h6',
						),
					"description" => __("Choose your title heading style.", "js_composer")
		        ),
				$add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TITLE -------------------------------------


		// TEASER ----------------------------------------
		wpb_map( array(
			"name" => __("Teaser Box", "js_composer"),
			"base" => "teaser",
		  	"icon" => "icon-teaser",
		  	"wrapper_class" => "hb-wrapper-teaser",
		  	"category" => __('Content', 'js_composer'),
		  	"description" => __('Insert a teaser box.', 'js_composer'),
		    "params"	=> array(
		    	array(
			      	"type" => "attach_image",
					"heading" => __("Teaser Image", "js_composer"),
					"param_name" => "image",
					"value" => "",
					"description" => __("Upload a teaser image. Leave empty to hide the image section of the teaser.", "js_composer")
			    ),
			    array(
					"type" => "dropdown",
					"heading" => __("Content Alignment", "js_composer"),
					"param_name" => "align",
					"value" => array(
						__("Left", "js_composer") => 'alignleft',
						__("Center", "js_composer") => 'aligncenter',
						__("Right", "js_composer") => 'alignright'
						),
					"description" => __("Choose teaser content alignment.", "js_composer")
		        ),
		        array(
					"type" => "dropdown",
					"heading" => __("Teaser Box Style", "js_composer"),
					"param_name" => "style",
					"admin_label" => true,
					"value" => array(
						__("Boxed", "js_composer") => 'boxed',
						__("Unboxed", "js_composer") => 'alternative',
						),
					"description" => __("Choose teaser style. Choose between a boxed or unboxed alternative.", "js_composer")
		        ),
			    array(
				      "type" => "textfield",
				      "heading" => __("Teaser Title", "js_composer"),
				      "param_name" => "title",
				      "admin_label" => true,
				      "value" => 'My teaser box',
				      "value" => __("Enter your title here", "js_composer")
			    ),
			    array(
				      "type" => "textarea_html",
				      "heading" => __("Teaser Content", "js_composer"),
				      "param_name" => "content",
				      "value" => __("<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
			    ),
			    array(
				      "type" => "textfield",
				      "heading" => __("Button Title", "js_composer"),
				      "param_name" => "button_title",
				      "value" => "Button Title",
				      "description" => __("Enter the title/caption for the title button. Leave empty if you don't need one", "js_composer")
			    ),
			    array(
				      "type" => "textfield",
				      "heading" => __("Button Link", "js_composer"),
				      "param_name" => "button_link",
				      "value" => "http://hb-themes.com",
				      "description" => __("Choose URL of the link for the button. Enter with http:// prefix. You can also enter section id with # prefix to scroll to the section within your page. Example #home", "js_composer")
			    ),
			     array(
			      "type" => 'checkbox',
			      "heading" => __("Open link in new tab?", "js_composer"),
			      "param_name" => "new_tab",
			      "value" => Array(__("Yes, please", "js_composer") => 'yes')
			    ),
				$add_css_animation,
			    $add_animation_delay,
			    $add_class,
		    ),
		));
		// END TEASER ------------------------------------

	}


	// VC ADD PARAM
    if ( function_exists('vc_add_param') ) {
        vc_add_param ( 'vc_accordion_tab' ,
                array(
                    "type" => "textfield",
                    "heading" => __("Icon", "js_composer"),
                    "param_name" => "icon",
                    "admin_label" => true,
                    "value" => "hb-moon-plus-circle",
                    "description" => __("Enter a name of the icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href='http://documentation.hb-themes.com/icons/' target='_blank'>Icon List</a>.
        Example: hb-moon-apple-fruit", "js_composer")
                )
            );

        vc_add_param ( 'vc_tab' ,
                array(
                    "type" => "textfield",
                    "heading" => __("Icon", "js_composer"),
                    "param_name" => "icon",
                    "value" => "hb-moon-plus-circle",
                    "admin_label" => true,
                    "description" => __("Enter a name of the icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href='http://documentation.hb-themes.com/icons/' target='_blank'>Icon List</a>.
        Example: hb-moon-apple-fruit", "js_composer")
                )
            );

       vc_add_param ( 'vc_toggle' ,
                array(
                    "type" => "textfield",
                    "value" => "hb-moon-plus-circle",
                    "heading" => __("Icon", "js_composer"),
                    "param_name" => "icon",
                    "admin_label" => true,
                    "description" => __("Enter a name of the icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href='http://documentation.hb-themes.com/icons/' target='_blank'>Icon List</a>.
        Example: hb-moon-apple-fruit", "js_composer")
                )
            );

        vc_add_param ( 'vc_tour' ,
                array(
                    "type" => "dropdown",
                    "heading" => __("Tour Position", "js_composer"),
                    "param_name" => "position",
                    "value" => "hb-moon-plus-circle",
                    "admin_label" => true,
                    "value" => array(
						__("Left", "js_composer") => 'left-tabs',
						__("Right", "js_composer") => 'right-tabs',
						),
                    "description" => __("Choose where the navigation of the tour is positioned.", "js_composer")
                )
            );
    }
?>