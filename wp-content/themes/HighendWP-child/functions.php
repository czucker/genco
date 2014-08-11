<?php
// Post title shortcode
function myshortcode_title( ){
   return get_the_title();
}
add_shortcode( 'page_title', 'myshortcode_title' );
?>


