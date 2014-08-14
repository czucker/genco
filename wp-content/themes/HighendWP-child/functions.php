<?php
add_filter('get_the_excerpt', 'do_my_shortcode_in_excerpt');
function do_my_shortcode_in_excerpt($excerpt) {
    return do_shortcode(wp_trim_words(get_the_content(), 55));
}