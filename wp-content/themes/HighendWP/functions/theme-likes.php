<?php

function hb_like_this($post_id,$action = 'get') {

	if(!is_numeric($post_id)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	} //if

	switch($action) {
	
	case 'get':
		$data = get_post_meta($post_id, '_likes');
		
		if(!isset($data[0]) || !is_numeric($data[0])) {
			$data[0] = 0;
			add_post_meta($post_id, '_likes', '0', true);
		} //if
		
		return $data[0];
	break;
	
	
	case 'update':
		if(isset($_COOKIE["like_" + $post_id])) {
			return;
		} //if
		
		$currentValue = get_post_meta($post_id, '_likes');
		
		if(!is_numeric($currentValue[0])) {
			$currentValue[0] = 0;
			add_post_meta($post_id, '_likes', '1', true);
		} //if
		
		$currentValue[0]++;
		update_post_meta($post_id, '_likes', $currentValue[0]);
		
		setcookie("like_" + $post_id, $post_id,time()*20, '/');
	break;

	} //switch

}

function hb_print_likes($post_id) {
	global $data;
	$output = '';
	$likes = hb_like_this($post_id);
		
	$titl = get_the_title($post_id);

	if(isset($_COOKIE["like_" + $post_id])) {
		return '<div class="like-holder like-button like-active" id="like-'.$post_id.'" title="'. __('You like this.','hbthemes') . '" ><i class="hb-moon-heart"></i>'.$likes.'</div>';	  	
	}

		return '<div title="' . __('Like this post.','hbthemes') .' '.$titl.'" id="like-'.$post_id.'" class="like-holder like-button"><i class="hb-moon-heart"></i>'.$likes.'</div>';	  	
		
} //hb_printLikes


function hb_print_portfolio_likes($post_id) {
	global $data;
	$output = '';
	$likes = hb_like_this($post_id);
		
	$titl = get_the_title($post_id);

	if(isset($_COOKIE["like_" + $post_id])) {
		return '<div class="portfolio-like-holder"><div class="like-holder like-button like-active" id="like-'.$post_id.'" title="'. __('You like this.','hbthemes') . '" ><i class="hb-moon-heart"></i>'.$likes.'</div></div>';	  	
	}

		return '<div class="portfolio-like-holder"><div title="' . __('Like this post.','hbthemes') .' '.$titl.'" id="like-'.$post_id.'" class="like-holder like-button"><i class="hb-moon-heart"></i>'.$likes.'</div></div>';	  	
		
} //hb_printLikes


function setUpPostLikes($post_id) {
	if(!is_numeric($post_id)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	} //if
	
	
	add_post_meta($post_id, '_likes', '0', true);

} //setUpPost


function checkHeaders() {
	if(isset($_POST["likepost"])) {
		hb_like_this($_POST["likepost"],'update');
	} //if

} //checkHeaders


function jsIncludes() {
	wp_enqueue_script('jquery');

} //jsIncludes

add_action ('publish_post', 'setUpPostLikes');
add_action ('init', 'checkHeaders');
add_action ('get_header', 'jsIncludes');
?>