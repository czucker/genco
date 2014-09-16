<?php
function my_highend_child_theme_setup() {
   remove_shortcode( 'blog_carousel' );
   add_shortcode( 'blog_carousel', 'my_highend_blog_carousel' );
}
function my_highend_blog_carousel( $atts, $content = null ) {
    $output .= '<p>' . get_the_excerpt() . '</p>';
}
add_filter('show_admin_bar', '__return_true');
?>