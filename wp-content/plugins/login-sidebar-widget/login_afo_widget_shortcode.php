<?php
function login_widget_afo_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$wid = new login_wid;
	if($title){
		echo '<h2>'.$title.'</h2>';
	}
	$wid->loginForm();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}
add_shortcode( 'login_widget', 'login_widget_afo_shortcode' );

?>