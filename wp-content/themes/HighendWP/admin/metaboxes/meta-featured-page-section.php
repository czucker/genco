<?php
$rev_sliders = get_all_revolution_sliders();
$rev_sliders_items = array();
if ( !empty ($rev_sliders) ) {
  foreach ($rev_sliders as $alias => $name) {
    $rev_sliders_items[] = array(
        'label' => $name,
        'value' => $alias,
      );
  }
}

$layer_sliders = get_all_layer_sliders();
$layer_sliders_items = array();
if ( !empty ($layer_sliders) ) {
  foreach ($layer_sliders as $alias => $name) {
    $layer_sliders_items[] = array(
        'label' => $name,
        'value' => $alias,
      );
  }
}

return array(

  array(
      'type' => 'select',
      'name' => 'hb_featured_section_options',
      'label' => __('Featured Section Type','hbthemes'),
      'description' => __('Choose which element to display in the featured section of the page.','hbthemes'),
      'items' => array(
        array(
          'value' => '',
          'label' => 'Hide',
        ),
        array(
          'value' => 'featured_image',
          'label' => 'Featured Image',
        ),
        array(
          'value' => 'revolution',
          'label' => 'Revolution Slider',
        ),
        array(
          'value' => 'layer',
          'label' => 'Layer Slider',
        ),
        array(
          'value' => 'video',
          'label' => 'Video',
        ),
      ),
    ),
  array(
    'type' => 'select',
    'name' => 'hb_rev_slider',
    'label' => __('Revolution Slider','hbthemes'),
    'description' => __('Choose a Revolution Slider to display in the Featured Section of the page.','hbthemes'),
    'items' => $rev_sliders_items,
    'dependency' => array(
          'field' => 'hb_featured_section_options',
          'function' => 'hb_page_featured_revslider',
        ),
  ),
  array(
    'type' => 'select',
    'name' => 'hb_layer_slider',
    'label' => __('Layer Slider','hbthemes'),
    'description' => __('Choose a Layer Slider to display in the Featured Section of the page.','hbthemes'),
    'items' => $layer_sliders_items,
    'dependency' => array(
          'field' => 'hb_featured_section_options',
          'function' => 'hb_page_featured_layer',
        ),
  ),
  array(
    'type' => 'textbox',
    'name' => 'hb_page_video',
    'label' => __('Video Link', 'hbthemes'),
    'default' => '',
    'dependency' => array(
          'field' => 'hb_featured_section_options',
          'function' => 'hb_page_featured_video',
        ),
    'description' => __('Enter link to the video. Example: http://www.youtube.com/watch?v=Q_7cVyM8Efg', 'hbthemes'),
  ),
);

?>