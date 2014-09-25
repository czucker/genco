<?php
function my_highend_child_theme_setup() {
   remove_shortcode( 'blog_carousel' );
   add_shortcode( 'blog_carousel', 'my_highend_blog_carousel' );
}
function my_highend_blog_carousel( $atts, $content = null ) {
    $output .= '<p>' . get_the_excerpt() . '</p>';

}
function wpse_google_webfonts() {
    wp_enqueue_style( 'google-webfonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' );
}
add_action( 'wp_enqueue_scripts', 'wpse_google_webfonts' );
/* add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
   $referrer = "javascript:void(0)";  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
} */

