<?php
function hbthemes_breadcrumbs() {
  global $post;
  if ( is_404() ) return;

  if (vp_metabox('general_settings.hb_breadcrumbs') == "hide" ) return;
  if (vp_metabox('general_settings.hb_breadcrumbs') == "default" && !hb_options('hb_enable_breadcrumbs') ) return;
  if (!is_singular() && !hb_options('hb_enable_breadcrumbs') ) return;
	
  $delimiter = '<span class="sep-icon"><i class="icon-angle-right"></i></span>';
  $before = '<span>';
  $after = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
	?>
  	<!-- BEGIN BREADCRUMBS -->
  	<div class="breadcrumbs-wrapper">
      <div class="breadcrumbs-inside">
  	<?php   
      $homeLink = home_url();
      echo ' <a href="' . $homeLink . '">' . __('Home','hbthemes') . '</a> ' . $delimiter . ' ';
      
      if ( class_exists('bbPress') && bbp_is_forum_archive() ) {
          echo $before . __('Forums','hbthemes') .$after;
      } else if ( class_exists('bbPress') && bbp_is_single_forum() ){
           echo '<a href="'. get_post_type_archive_link( 'forum' ) .'">'. __('Forums', 'hbthemes') .'</a>' . $delimiter . $before . get_the_title() . $after;
      } else if ( is_category() ) {
          global $wp_query;
          $cat_obj = $wp_query->get_queried_object();
          $thisCat = $cat_obj->term_id;
          $thisCat = get_category($thisCat);
          $parentCat = get_category($thisCat->parent);
          if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
          echo $before . __('Blog','hbthemes') .$after .$delimiter . $before . single_cat_title('', false) . '' . $after;
   
      } elseif (is_tax()) {
        echo $before . '' . single_cat_title('', false) . '' . $after;
      } elseif ( is_day() ) {
        echo $before . __('Blog','hbthemes') .$after . $delimiter;
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
        echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
   
      } elseif ( is_month() ) {
        echo $before . 'Blog' .$after . $delimiter;
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
   
      } elseif ( is_year() ) {
        echo $before . __('Blog','hbthemes') .$after . $delimiter;
        echo $before . get_the_time('Y') . $after;
   
      } elseif ( is_single() && !is_attachment() ) {
        if ( get_post_type() != 'post' ) {
          //$post_type = get_post_type_object(get_post_type());
          //$slug = $post_type->rewrite;
          //echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';

          if ( function_exists('is_product') && is_product() ){
            $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
            $shop_page_url = '<a href="'.$shop_page_url.'">Shop</a>';
            
            global $post;
            $terms = get_the_terms( $post->ID, 'product_cat' );
            $product_cat_id = '';
            $product_cat_name = '';
            $product_fin = '';
            $product_cat_link = '';
            foreach ($terms as $term) {
                $product_cat_id = $term->term_id;
                $product_cat_name = $term->name;
                break;
            }
            if ($product_cat_id != ''){
              $product_cat_link = get_term_link( $product_cat_id, 'product_cat' );
              $product_fin = $before . '<a href="'.$product_cat_link.'">' . $product_cat_name . '</a>' . $after . $delimiter;
            }

            echo $before . $shop_page_url . $after . $delimiter . $product_fin . $before . get_the_title() . $after;

          } else if ( class_exists('bbPress') && get_post_type() == 'topic' ) {
            echo '<a href="'. get_post_type_archive_link( 'forum' ) .'">'. __('Forums', 'hbthemes') .'</a>' . $delimiter . '<a href="' . bbp_get_forum_permalink() . '" class="parent-forum">' . bbp_get_forum_title() . '</a>' . $delimiter . $before . get_the_title() . $after;
          } else {
            echo $before . get_the_title() . $after;
          }
        } else {
          $cat = get_the_category(); $cat = $cat[0];
          echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
          echo $before . get_the_title() . $after;
        }
   
      } elseif ( is_attachment() ) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID); $cat = $cat[0];
       // echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
   
      } elseif ( is_page() && !$post->post_parent ) {
        echo $before . get_the_title() . $after;
   
      } elseif ( is_page() && $post->post_parent ) {
        $parent_id  = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
          $parent_id  = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
   
      } elseif ( is_tag() ) {
  	  echo $before ;
  	  printf( __( 'Tag <span class="sep-icon"><i class="icon-angle-right"></i></span> %s', 'hbthemes' ), single_tag_title( '', false ) );
  	  echo  $after;
   
      } elseif ( is_author() ) {
         global $author;
        $userdata = get_userdata($author);
        echo $before ;
  	  printf( __( 'Author <span class="sep-icon"><i class="icon-angle-right"></i></span> %s', 'hbthemes' ),  $userdata->display_name );
  	  echo  $after;
   
      } elseif ( is_404() ) {
        echo $before;
  	  _e( 'Not found', 'hbthemes' );
  	  echo  $after;
      } elseif ( is_search() ) {
        echo $before;
        echo __( 'Search Results', 'hbthemes');
        echo $after;
        echo $delimiter;
        echo $before;
        echo get_search_query();
        echo  $after;
      } else if ( function_exists('is_shop') && is_shop() ) {
        echo $before;
        _e('Shop','woocommerce');
        echo $after;
      } 
   
      if ( get_query_var('paged') ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo $before.' (';
        echo $delimiter . $before . __('Page ' , 'hbthemes') . ' ' . get_query_var('paged') .$after;
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')'.$after;
      }
   
      ?>
    </div>
  	</div>
  	<!-- END BREADCRUMBS -->
  	
  	<div class="clear"></div>
  	<?php
 
  }
}
?>