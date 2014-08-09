<?php
function hb_testimonial_quote ( $post_id ) {
    $testimonial_post = get_post($post_id);
    if ( $testimonial_post ) {
        setup_postdata($testimonial_post);

    $author_name = vp_metabox('testimonial_type_settings.hb_testimonial_author');
    $author_desc = vp_metabox('testimonial_type_settings.hb_testimonial_description');
    $author_desc_link = vp_metabox('testimonial_type_settings.hb_testimonial_description_link');

    ?>

    <p><?php the_content(); ?></p>
    <div class="testimonial-quote-meta">
        <span><?php if ( $author_name ) echo $author_name; ?><?php if ( $author_desc ) {if ( $author_desc_link )echo ', <a href="' . $author_desc_link . '">' . $author_desc . '</a>';  else echo ', ' . $author_desc; }?>
        </span>
    </div>
         
    <?php 
        wp_reset_postdata();
    }
}
?>