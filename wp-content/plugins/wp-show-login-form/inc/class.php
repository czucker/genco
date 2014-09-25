<?php
 
   class wp_login_form_to_anywhere
   {
     
   public function login_form()
   
   { 
   
   
  if($_REQUEST['login']=='failed')
  {
  echo " <strong>ERROR</strong>: Invalid username or incorrect password.";
 }
if ( ! is_user_logged_in() ) { // Display WordPress login form:
    $args = array(
        'redirect' => wplfta_get_options('wplfta_after_login_link'), 
        'form_id' => 'loginform-wplfta',
        'label_username' => __(  wplfta_get_options('wplfta_user_txt') ),
        'label_password' => __( wplfta_get_options('wplfta_password_txt') ),
        'label_remember' => __( wplfta_get_options('wplfta_remember_me_text') ),
        'label_log_in' => __( wplfta_get_options('wplfta_submit_buton_text') ),
        'remember' => true
    );
    wp_login_form( $args );
} else { // If logged in:
    wp_loginout( home_url() ); // Display "Log Out" link.
    echo " | ";
    wp_register('', ''); // Display "Site Admin" link.
}
   
   }
   }
  
function wplfta_shortcode_catcher() {
 
    ob_start(); 
	 add_filter('widget_text', 'do_shortcode'); //to enable shortcode in  text widget

	
$auth = new wp_login_form_to_anywhere();
        
   $auth->login_form();



   return ob_get_clean();
	 

     }
add_shortcode( 'wplfta_login_form', 'wplfta_shortcode_catcher' );


 
 function wplfta_logout_ui()
{
 ob_start(); 
 wp_loginout(); // Display "Log Out" link.
 return ob_get_clean(); 
}
add_shortcode( 'wplfta_logout', 'wplfta_logout_ui' ); //logout short code
   