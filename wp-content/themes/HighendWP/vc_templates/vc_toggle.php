<?php
$output = $title = $el_class = $open = $css_animation = '';
extract(shortcode_atts(array(
    'title' => __("Click to toggle", "js_composer"),
    'el_class' => '',
    'open' => 'false',
    'icon' => '',
    'css_animation' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);
$open = ( $open == 'true' ) ? ' wpb_toggle_title_active' : '';
$el_class .= ( $open == ' wpb_toggle_title_active' ) ? ' wpb_toggle_open' : '';

$css_class .= $this->getCSSAnimation($css_animation);
$unique_id = rand(1,10000);
$initial_index = "";

if ($open){
	$initial_index = ' data-initialindex="0"';
}

$output .= '<div id="hb-toggle-' . $unique_id . '" class="hb-toggle"'.$initial_index.'>';
//$output .= apply_filters('wpb_toggle_heading', '<h4 class="'.$css_class.'">'.$title.'</h4>', array('title'=>$title, 'open'=>$open));
//$output .= '<div class="'.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";
$output .= "<div class=\"hb-accordion-single " . $css_class . "\">";
$output .= "<div class=\"hb-accordion-tab\">";
if ( $icon != "" )
	$output .= "<i class=\"" . $icon . "\"></i>";
$output .= $title;
$output .= '<i class="icon-angle-right"></i>';
$output .= "</div>";
$output .= "\n\t\t\t\t" . '<div class="hb-accordion-pane">';
$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t\t" . '</div>';
$output .= '</div>';
$output .= '</div>';
echo $output;