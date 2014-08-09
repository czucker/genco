<?php
/**
 * @package WordPress
 * @subpackage Notable
 */

//pagination function
if ( function_exists('hb_pagination_standard') ) return;
function hb_pagination_standard($pages = '', $range = 4, $query = null)
{
    global $wp_query;
    global $paged, $max_page;


    $big = 99999999;
    echo '<div class="clear"></div>';
    echo '<div class="pagination">';
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'total' => $wp_query->max_num_pages,
        'current' => max(1, get_query_var('paged')),
        'show_all' => false,
        'end_size' => 2,
        'mid_size' => 1,
        'prev_next' => true,
        'prev_text' => '<i class="icon-angle-left"></i>',
        'next_text' => '<i class="icon-angle-right"></i>',
        'type' => 'list'
    ));
    echo '</div>';
    echo '<div class="clear"></div>';
}
?>