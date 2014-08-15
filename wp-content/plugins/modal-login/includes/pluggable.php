<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
if ( !function_exists('wp_set_auth_cookie') ) :
/**
 * Sets the authentication cookies based User ID.
 *
 * The $remember parameter increases the time that the cookie will be kept. The
 * default the cookie is kept without remembering is two days. When $remember is
 * set, the cookies will be kept for 14 days or two weeks.
 *
 * @since 2.5
 *
 * @param int $user_id User ID
 * @param bool $remember Whether to remember the user
 */
function wp_set_auth_cookie($user_id, $remember = false, $secure = '') {
	if ( $remember ) {
		$expiration = $expire = time() + apply_filters('auth_cookie_expiration', 1209600, $user_id, $remember);
	} else {
		$expiration = time() + apply_filters('auth_cookie_expiration', 172800, $user_id, $remember);
		$expire = 0;
	}

	if ( '' === $secure )
		$secure = is_ssl();

	$secure = apply_filters('secure_auth_cookie', $secure, $user_id);
	$secure_logged_in_cookie = apply_filters('secure_logged_in_cookie', false, $user_id, $secure);

	if ( $secure ) {
		$auth_cookie_name = SECURE_AUTH_COOKIE;
		$scheme = 'secure_auth';
	} else {
		$auth_cookie_name = AUTH_COOKIE;
		$scheme = 'auth';
	}

	$auth_cookie = wp_generate_auth_cookie($user_id, $expiration, $scheme);
	$logged_in_cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');

	do_action('set_auth_cookie', $auth_cookie, $expire, $expiration, $user_id, $scheme);
	do_action('set_logged_in_cookie', $logged_in_cookie, $expire, $expiration, $user_id, 'logged_in');

	setcookie($auth_cookie_name, $auth_cookie, $expire, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN, $secure, true);
	setcookie($auth_cookie_name, $auth_cookie, $expire, ADMIN_COOKIE_PATH, COOKIE_DOMAIN, $secure, true);

//RHL MOD: added for support of the rewritten admin url:	
global $rhl_plugin;
$rewritten_admin = $rhl_plugin->get_option('rewrite_admin','wp-admin',true);
setcookie($auth_cookie_name, $auth_cookie, $expire, SITECOOKIEPATH.$rewritten_admin, COOKIE_DOMAIN, $secure, true);
//---------
	setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure_logged_in_cookie, true);
	if ( COOKIEPATH != SITECOOKIEPATH )
		setcookie(LOGGED_IN_COOKIE, $logged_in_cookie, $expire, SITECOOKIEPATH, COOKIE_DOMAIN, $secure_logged_in_cookie, true);
}
endif;


if ( !function_exists('wp_clear_auth_cookie') ) :
/**
 * Removes all of the cookies associated with authentication.
 *
 * @since 2.5
 */
function wp_clear_auth_cookie() {
	do_action('clear_auth_cookie');

	setcookie(AUTH_COOKIE, ' ', time() - 31536000, ADMIN_COOKIE_PATH, COOKIE_DOMAIN);
	setcookie(SECURE_AUTH_COOKIE, ' ', time() - 31536000, ADMIN_COOKIE_PATH, COOKIE_DOMAIN);
	setcookie(AUTH_COOKIE, ' ', time() - 31536000, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN);
	setcookie(SECURE_AUTH_COOKIE, ' ', time() - 31536000, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN);
	setcookie(LOGGED_IN_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
	setcookie(LOGGED_IN_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);

//RHL
global $rhl_plugin;
$rewritten_admin = $rhl_plugin->get_option('rewrite_admin','wp-admin',true);
setcookie(AUTH_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH.$rewritten_admin, COOKIE_DOMAIN);
setcookie(SECURE_AUTH_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH.$rewritten_admin, COOKIE_DOMAIN);	
//------------
	
	// Old cookies
	setcookie(AUTH_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
	setcookie(AUTH_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);
	setcookie(SECURE_AUTH_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
	setcookie(SECURE_AUTH_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);

	// Even older cookies
	setcookie(USER_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
	setcookie(PASS_COOKIE, ' ', time() - 31536000, COOKIEPATH, COOKIE_DOMAIN);
	setcookie(USER_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);
	setcookie(PASS_COOKIE, ' ', time() - 31536000, SITECOOKIEPATH, COOKIE_DOMAIN);
}
endif;
?>