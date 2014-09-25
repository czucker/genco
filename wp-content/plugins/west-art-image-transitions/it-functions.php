<?php
/*
Plugin Name: Image transitions
Plugin URI: http://www.westart.se
Description: Add transitions to images as soon as they appear in view
Version: 0.1
Author: West Art Communication AB
Author URI: http://www.westart.se
*/
function imgtrans_scripts() {
    wp_enqueue_style(
        'imgtrans-css', 
        plugins_url() . '/image-transitions/css/imgtrans.css' 
    );
    wp_enqueue_script(
		'inview',
		plugins_url() . '/image-transitions/js/jquery.inview.min.js',
		array( 'jquery' ),
		'0.1',
		true
	);
    wp_enqueue_script(
		'imgtrans-js',
		plugins_url() . '/image-transitions/js/imgtrans.js',
		array( 'jquery','inview' ),
		'0.1',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'imgtrans_scripts' );

function imgtrans_attachment_fields($form_fields, $post) {

    $form_fields["imgtransition"]["label"] = __("Transition");
    $form_fields["imgtransition"]["input"] = "html";
    $form_fields["imgtransition"]["show_in_modal"] = "true";
    $form_fields["imgtransition"]["show_in_edit"] = "true";
    $form_fields["imgtransition"]["html"] = "
    <select name='attachments[{$post->ID}][imgtransition]' id='attachments[{$post->ID}][imgtransition]'>
        <option value='none'>No transition</option>
        <option value='scale-in'>Scale in</option>
        <option value='fade-in'>Fade in</option>
        <option value='slide-up'>Slide from bottom</option>
    </select>";
     
    return $form_fields;
}
add_filter("attachment_fields_to_edit", "imgtrans_attachment_fields", null, 2);

function imgtrans_attachment_fields_save($post, $attachment) {
    if( isset($attachment['imgtransition']) ){
        update_post_meta($post['ID'], '_imgtransition', $attachment['imgtransition']);
    }
    return $post;
}
add_filter( 'attachment_fields_to_save','imgtrans_attachment_fields_save', null, 2);

function imgtrans_insert_image_transitions($html, $attachment_id) {
    
    if($imgTransType = get_post_meta($attachment_id, '_imgtransition', true)){
        $imgTransType = get_post_meta($attachment_id, '_imgtransition', true);
        if($imgTransType == 'none'){
            $imgTrans = 'false';
        }else{
            $imgTrans = 'true';
        }
        $html = str_replace('<img ', '<img data-transition="' . $imgTrans . '" data-transition-type="' . $imgTransType . '" ', $html);
    }
    return $html;
        
}
add_filter( 'image_send_to_editor', 'insert_image_transitions', null, 2 );