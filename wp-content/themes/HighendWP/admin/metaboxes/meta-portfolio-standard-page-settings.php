<?php

$hb_portfolio_categories = array();
$all_portfolio_categories = get_terms( 'portfolio_categories', 'hide_empty=0' );
if ( !empty ( $all_portfolio_categories ) )
{
  foreach ( $all_portfolio_categories as $portfolio_cat ) {
    $hb_portfolio_categories[] = array(
        'value' => $portfolio_cat->term_id,
        'label' => $portfolio_cat->name,
      );
  }
}

return array(
  array(
    'type' => 'toggle',
    'name' => 'hb_gallery_filter',
    'label' => __('Filter','hbthemes'),
    'description' => __('Check this field to display portfolio filter.','hbthemes'),
    'default' => true,
  ),
  array(
    'type' => 'toggle',
    'name' => 'hb_gallery_sorter',
    'label' => __('Sorter','hbthemes'),
    'description' => __('Check this field to display portfolio sorter.','hbthemes'),
    'default' => true,
  ),

  array(
    'type' => 'textbox',
    'name' => 'hb_portfolio_posts_per_page',
    'label' => __('Portfolio Items Per Page','hbthemes'),
    'description' => __('Enter how many portfolio items will be shown per page. Enter -1 to display all items.','hbthemes'),
    'default' => '6',
  ),

  array(
            'type' => 'select',
            'name' => 'hb_query_orderby',
            'label' => __('Order By', 'hbthemes'),
            'default' => 'date',
            'items' => array(
              array(  
                'value' => 'date',
                'label' => __('Date', 'hbthemes'),
              ),
              array(
                'value' => 'title',
                'label' => __('Title', 'hbthemes'),
              ),
              array(
                'value' => 'comment_count',
                'label' => __('Comment Count', 'hbthemes'),
              ),
              array(
                'value' => 'menu_order',
                'label' => __('Menu Order', 'hbthemes'),
              ),
              array(
                'value' => 'rand',
                'label' => __('Random', 'hbthemes'),
              ),
            ),
            'description' => __('Choose order for your portfolio posts on this page.','hbthemes'),
        ),

        array(
            'type' => 'select',
            'name' => 'hb_query_order',
            'label' => __('Order', 'hbthemes'),
            'default' => 'DESC',
            'items' => array(
              array(  
                'value' => 'ASC',
                'label' => __('Ascending', 'hbthemes'),
              ),
              array(
                'value' => 'DESC',
                'label' => __('Descending', 'hbthemes'),
              ),
            ),
            'description' => __('Specify if the chosen order by will be displayed in ascending or descending order.','hbthemes'),
        ),
        
  array(
    'type' => 'radiobutton',
    'name' => 'hb_gallery_orientation',
    'label' => __('Thumbnail Orientation','hbthemes'),
    'description' => __('Choose thumbnail orientation.','hbthemes'),
    'default' => 'landscape',
    'items' => array(
      array(
        'label' => __('Landscape','hbthemes'),
        'value' => 'landscape',
      ),
      array(
        'label' => __('Portrait','hbthemes'),
        'value' => 'portrait',
      ),
    ),
  ),

  array(
    'type' => 'radiobutton',
    'name' => 'hb_gallery_ratio',
    'label' => __('Thumbnail Ratio','hbthemes'),
    'description' => __('Choose thumbnail ratio.','hbthemes'),
    'default' => 'ratio1',
    'items' => array(
      array(
        'label' => __('16:9','hbthemes'),
        'value' => 'ratio1',
      ),
      array(
        'label' => __('4:3','hbthemes'),
        'value' => 'ratio2',
      ),
      array(
        'label' => __('3:2','hbthemes'),
        'value' => 'ratio4',
      ),
      array(
        'label' => __('3:1','hbthemes'),
        'value' => 'ratio5',
      ),
      array(
        'label' => __('1:1','hbthemes'),
        'value' => 'ratio3',
      ),
    ),
  ),
  array(
    'type' => 'multiselect',
    'name' => 'hb_gallery_categories',
    'label' => __('Exclude Gallery Categories', 'hbthemes'),
    'max_selection' => 1000,
    'description' => "",
    'items' => $hb_portfolio_categories,
  ),

  array(
    'type' => 'slider',
    'name' => 'hb_gallery_columns',
    'label' => __('Portfolio Column Count', 'hbthemes'),
    'min' => 2,
    'max' => 4,
    'step' => 1,
    'description' => "",
    'default' => 3,
  ),
);

?>