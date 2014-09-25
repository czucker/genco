<?php
 
// On failure, notify the custom form through a redirect with a new query variable
add_action( 'wp_login_failed', 'wplfta_login_failed', 10, 2 );
// When a user leaves a field blank, return that as an error that will fire wp_login_failed
add_filter( 'authenticate', 'wflfta_authenticate_username_password', 30, 3);

function wplfta_login_failed( $username )
{
    $referrer = wp_get_referer();

    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )
    {
    wp_redirect( add_query_arg('login', 'failed', $referrer) );
       // wp_redirect($referrer);
        exit;
    }
}

function wflfta_authenticate_username_password( $user, $username, $password )
{
    if ( is_a($user, 'WP_User') ) { return $user; }

    if ( empty($username) || empty($password) )
    {
        $error = new WP_Error();
        $user  = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));

        return $error;
    }
}
/**
 * get options
 */
function wplfta_get_options($option)
{
$option_value=get_option($option);
$options= array(
   'wplfta_user_txt'=>'UserName', 
   'wplfta_password_txt'=> 'Password',
   'wplfta_remember_me_text'=> 'Remember Me',
   'wplfta_after_login_link'=> admin_url(),
   'wplfta_submit_buton_text'=> 'Submit'
   );
   
  if(empty($option_value))
  {
  $option_value=$options[$option];
  } 
  return $option_value; 
}
    add_filter('widget_text', 'do_shortcode'); //to enable shortcode in  text widget

