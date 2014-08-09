<?php
$output = $title = $icon = '';

extract(shortcode_atts(array(
    'title' => __("Section", "js_composer"),
    'icon' => 'hb-moon-plus-circle',
), $atts));

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base']);
//$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';
    $output .= "<div class=\"hb-accordion-single " . $css_class . "\">";
    $output .= "<div class=\"hb-accordion-tab\">";
    if ( $icon != "" )
        $output .= "<i class=\"" . $icon . "\"></i>";
    $output .= $title;
    $output .= '<i class="icon-angle-right"></i>';
    $output .= "</div>";
$output .= "\n\t\t\t\t" . '<div class="hb-accordion-pane vc_clearfix">';
        $output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
            $output .= "\n\t\t\t\t" . '</div>';
  //  $output .= "</div>";
    $output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_accordion_section') . "\n";

echo $output;