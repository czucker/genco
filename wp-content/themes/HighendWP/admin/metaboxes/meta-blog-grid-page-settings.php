<?php

$hb_categories = array();
$all_categories = get_categories();
if ( !empty ( $all_categories ) ) {
  foreach ( $all_categories as $category ) {
    $hb_categories[] = array(
        'value' => $category->cat_ID,
        'label' => $category->name,
      );
  }
}

return array(

        array(
            'type' => 'select',
            'name' => 'hb_grid_style',
            'label' => __('Grid Style', 'hbthemes'),
            'default' => 'fitRows',
            'items' => array(
              array(
                'value' => 'fitRows',
                'label' => __('Standard', 'hbthemes'),
              ),
              array(
                'value' => 'masonry',
                'label' => __('Masonry', 'hbthemes'),
              ),
            ),
            'description' => __('Select the grid layout. Choose between Standard (fit rows) and Masonry styling.','hbthemes'),
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
            'description' => __('Choose order for your blog posts on this page.','hbthemes'),
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
        'type' => 'multiselect',
        'name' => 'hb_blog_category_include',
        'label' => __('Select Categories', 'vp_textdomain'),
        'description' => __('Specify which categories will be displayed in this blog page.', 'vp_textdomain'),
        'items' => $hb_categories,
		    ),

        array(
            'type' => 'select',
            'name' => 'hb_pagination_style',
            'label' => __('Pagination Style', 'hbthemes'),
            'default' => '',
            'items' => array(
              array(
                'value' => 'standard',
                'label' => __('Standard', 'hbthemes'),
              ),
              array(
                'value' => 'ajax',
                'label' => __('Load More', 'hbthemes'),
              ),
            ),
            'description' => __('Choose between standard pagination and fancy ajax page loading.','hbthemes'),
        ),

        
        array(
          'type' => 'slider',
          'name' => 'hb_grid_columns',
          'label' => __('Column Count', 'hbthemes'),
          'min' => 1,
          'max' => 4,
          'step' => 1,
          'description' => "",
          'default' => 3,
        ),
);
?>