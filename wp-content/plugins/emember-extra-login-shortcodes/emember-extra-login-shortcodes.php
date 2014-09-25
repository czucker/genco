<?php
/*
Plugin Name: eMember Extra Login Shortcodes
Version: v1.3
Plugin URI: https://www.tipsandtricks-hq.com/wordpress-emember-easy-to-use-wordpress-membership-plugin-1706
Author: Tips and Tricks HQ
Author URI: https://www.tipsandtricks-hq.com/
Description: It has a few nice looking emember login form shortcodes that you can use on your site.
*/

//TODO - Fix language definitions

define('WP_EMEMBER_EXTRA_LOGIN_SHORTCODES_URL', plugins_url('', __FILE__));

add_action('wp_head', 'wp_eMember_extra_login_shortcodes_head_content');
function wp_eMember_extra_login_shortcodes_head_content()
{
    echo '<link type="text/css" rel="stylesheet" href="' . WP_EMEMBER_EXTRA_LOGIN_SHORTCODES_URL . '/css/eMember_extra_login_shortcodes_style.css" />' . "\n";
}

define('EMEMBER_LOGGED_IN_AS_COMPACT', 'Username: '); // EMEMBER_USERNAME
define('EMEMBER_LOGGED_IN_LEVEL_COMPACT', 'Membership Level: ');  // EMEMBER_LOGGED_IN_LEVEL or EMEMBER_MEMBERSHIP_LEVEL
define('EMEMBER_LOGGED_IN_LEVEL_PRIMARY', 'Primary Membership Level: ');
define('EMEMBER_LOGGED_IN_LEVEL_ADDITIONAL', 'Additional Membership Levels: ');
define('EMEMBER_ACCOUNT_STATUS_COMPACT', 'Account Status: '); //EMEMBER_ACCOUNT_STATUS
define('EMEMBER_ACCOUNT_EXPIRES_ON_COMPACT', 'Expires: '); //EMEMBER_ACCOUNT_EXPIRES_ON

add_shortcode('wp_eMember_fancy_login','wp_eMember_fancy_login_handler');

//$_POST['login_user_name'] = (isset($_POST['login_user_name']))?strip_tags($_POST['login_user_name']) : '';
//$_POST['login_pwd'] = (isset($_POST['login_pwd']))?strip_tags($_POST['login_pwd']) : '';

function wp_eMember_fancy_login_handler($atts){
    extract( shortcode_atts( array(
        'style' => '1',
        'display_account_details' => ''
    ), $atts ) );

    if ($style == '1'){
       return eMember_fancy_login_1($display_account_details);
    }
    else if ($style == '2'){
        return eMember_fancy_login_2($display_account_details);
    }
    else if ($style == '3'){
        return eMember_fancy_login_3($display_account_details);
    }
    else if ($style == '4'){
        return eMember_fancy_login_4($display_account_details);
    }
    else if ($style == '5'){
        return eMember_fancy_login_5($display_account_details);
    }
    else if ($style == '6'){
        return eMember_fancy_login_6($display_account_details);
    }
    else if ($style == '7'){
        return eMember_fancy_login_7($display_account_details);
    }
    else if ($style == '8'){
        return eMember_fancy_login_8($display_account_details);
    }

    // If no match, display the fancy compact login.
    return eMember_fancy_login_1($display_account_details);
}

function eMember_fancy_login_1($display_account_details = '') {
    global $emember_auth;
    global $emember_config;

    $emember_config = Emember_Config::getInstance();
    $emember_auth = Emember_Auth::getInstance();
    $output = '<div class="eMember_fancy_login_1">';
    $output .= '<ul>';

    if ($emember_auth->isLoggedIn()) {
        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }
    }
    else {
        if (is_search()) {
            return get_login_link();
        }

        $login_url = $emember_config->getValue('login_page_url');
        $output .= '<li><a href="' . $login_url . '">' . EMEMBER_LOGIN . '</a></li>';

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
    }

    $output .= "</ul></div>";

    return $output;
}

function eMember_fancy_login_2($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_2">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_2_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_2_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_2_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_2_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_2_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_3($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_3">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_3_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_3_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_3_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_3_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_3_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_4($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_4">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_4_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_4_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_4_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_4_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_4_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_5($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_5">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_5_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_5_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_5_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_5_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_5_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_6($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_6">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_6_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_6_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_6_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_6_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_6_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_7($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_7">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_7_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        if (empty($_POST['login_user_name'])) {
            $default_username = EMEMBER_USER_NAME;
        } else {
            $default_username = $_POST['login_user_name'];
        }

        $output .= '<input type="text" name="login_user_name" size="17" value="' . $default_username . '" class="fancy_login_7_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        if (empty($_POST['login_pwd'])) {
            $default_password = "XXXXXXXX";
        } else {
            $default_password = $_POST['login_pwd'];
        }

        $output .= '<input type="password" name="login_pwd" size="17" value="' . $default_password . '" class="fancy_login_7_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';

        $output .= '<div class="eMember_fancy_login_7_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_7_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<div class="eMember_fancy_login_7_submit">';
        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</div>';
        $output .= '</form>';

        $output .= '<div class="eMember_fancy_login_7_msg">';
        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';
        $output .= '</div>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
    }

    $output .= "</div>";

    return $output;
}

function eMember_fancy_login_8($display_account_details = '') {
    global $emember_auth;
    global $emember_config;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $output = '<div class="eMember_fancy_login_8">';

    if ($emember_auth->isLoggedIn()) {
        $output .= '<div class="eMember_fancy_login_8_account_details">';

        $name = $emember_auth->getUserInfo('first_name') . " " . $emember_auth->getUserInfo('last_name');
        $output .= '<ul>';
        $output .= '<li class="eMember_fancy_login_bold">' . $name . '</li>';

        $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');

        if (!empty($edit_profile_page)) {
            $output .= '<li><a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_PROFILE . '</a></li>';
        }

        $logout = get_logout_url();
        $output .= '<li><a href="' . $logout . '">' . EMEMBER_LOGOUT . '</a></li>';

        $output .= '</ul>';

        if (!empty($display_account_details)) {
            $output .= eMember_display_account_details();
        }

        $output .= '</div>';
    }
    else {
        $output .= '<div class="eMember_fancy_login_8_inner">';

        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)){
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }

        $output .= '<h3>'.$widget_title.'</h3>';
        $output .= '<form action="" method="post">';
		$output .= wp_nonce_field('emember-login-nonce');
        $output .= '<div class="eMember_fancy_login_8_input_block">';
        $output .= '<label>' . EMEMBER_USER_NAME . '</label>';
        $output .= '<input type="text" name="login_user_name" size="17" value="' . $_POST['login_user_name'] . '" class="fancy_login_8_username" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';
        $output .= '</div>';

        $output .= '<div class="eMember_fancy_login_8_input_block">';
                $output .= '<label>' . EMEMBER_PASSWORD . '</label>';
        $output .= '<input type="password" name="login_pwd" size="17" value="' . $_POST['login_pwd'] . '" class="fancy_login_8_password" onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;">';
        $output .= '</div>';

        $output .= '<div class="eMember_fancy_login_8_rememberme">';
        $output .= '<input type="checkbox" value="forever" id="rememberme" name="rememberme" />';
        $output .= '<label class="eMember_fancy_login_8_rememberme_label">' . EMEMBER_REMEMBER_ME . '</label>';
        $output .= '</div>';

        $output .= '<input name="doLogin" type="submit" id="doLogin" value="'.EMEMBER_LOGIN.'">';
        $output .= '</form>';

        $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
        $output .= '<span class="emember_error">' . $msg . '</span>';

        $output .= '<ul>';

        $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
        if ($password_reset_url) {
            $output .= '<li><a href="' . $password_reset_url . '">' . EMEMBER_FORGOT_PASS . '</a></li>';
        }
        else {
            $output .= '<li><a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);">' . EMEMBER_FORGOT_PASS . '</li></a>';
        }

        $join_url = $emember_config->getValue('eMember_payments_page');
        $output .= '<li><a id="register" class="register_link" href="' . $join_url . '">' . EMEMBER_JOIN . '</a></li>';
        $output .= '</ul>';
        $output .= "</div>";
    }

    $output .= "</div>";

    return $output;
}

function eMember_display_account_details()
{
    global $emember_auth;
    global $emember_config;

    $emember_config = Emember_Config::getInstance();
    $emember_auth = Emember_Auth::getInstance();

    if (!$emember_auth->isLoggedIn()) {
        return;
    }

    $username = $emember_auth->getUserInfo('user_name');

    $output = '<div class="eMember_fancy_login_account_details">';

    $custom_login_msg = $emember_config->getValue('eMember_login_widget_message_for_logged_members');

    if (!empty($custom_login_msg)) {
        $output .= '<p>' . html_entity_decode($custom_login_msg, ENT_COMPAT) . '</p>';
    }

    $output .= '<ul>';
    $output .= '<li>' . EMEMBER_LOGGED_IN_AS_COMPACT;
    $output .= '<label">' . $username . '</label></li>';

    $more_membership_level_ids = wp_eMember_get_user_details("more_membership_levels");

    if (empty($more_membership_level_ids)) {
        $output .= '<li>' . EMEMBER_LOGGED_IN_LEVEL_COMPACT;
        $output .= '<label class="eMember_fancy_login_capitalize">' . $emember_auth->user_membership_level_name . '</label></li>';
    } else {
        $output .= '<li>' . EMEMBER_LOGGED_IN_LEVEL_PRIMARY;
        $output .= '<label class="eMember_fancy_login_capitalize">' . $emember_auth->user_membership_level_name . '</label></li>';

        $output .= '<li>' . EMEMBER_LOGGED_IN_LEVEL_ADDITIONAL;
        $more_membership_level_ids_array = explode(',', $more_membership_level_ids);
        $more_membership_level_total = count($more_membership_level_ids_array);

        $n = 0;
        foreach ($more_membership_level_ids_array as $membership_level_id) {
            $resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $membership_level_id . "'");
            $output .= '<label class="eMember_fancy_login_capitalize">' . $resultset->alias;

            if (++$n < $more_membership_level_total) {
                $output .= ', ';
            } else {
                $output .= '</label>';
            }
        }

        $output .= '</li>';
    }

    $states = array('active'=>EMEMBER_ACTIVE,
                'inactive'=>EMEMBER_INACTIVE,
                'expired'=>EMEMBER_EXPIRED,
                'pending'=>EMEMBER_PENDING,
                'unsubscribed'=>EMEMBER_UNSUBSCRIBED);

    $output .= '<li>' . EMEMBER_ACCOUNT_STATUS_COMPACT;
    $output .= '<label class="eMember_fancy_login_capitalize">' . $states[$emember_auth->getUserInfo('account_state')] . '</label></li>';


    if ($emember_auth->subscription_duration['type'] =='noexpire') {
        $sub_expires = EMEMBER_NEVER;
    } else if ($emember_auth->subscription_duration['type'] =='fixeddate') {
        $sub_expires = ' ' . $emember_auth->subscription_duration['duration'];
    } else {
        $sub_start = strtotime($emember_auth->getUserInfo('subscription_starts'));
        $sub_expires = date('F j, Y',strtotime("+" . $emember_auth->subscription_duration['duration'] . " days ", $sub_start));
    }

    $expires = $emember_auth->getUserInfo('account_state');

    if ($expires != 'expired') {
        $output .= '<li>' . EMEMBER_ACCOUNT_EXPIRES_ON_COMPACT;
        $output .= '<label class="eMember_fancy_login_capitalize">' . $sub_expires . '</label></li>';
    } else {
        $renew_url = $emember_config->getValue('eMember_account_upgrade_url');
        $output .= '<li><a href="' . $renew_url . '">' . EMEMBER_RENEW_OR_UPGRADE . '</a></li>';
    }

    $eMember_secure_rss = $emember_config->getValue('eMember_secure_rss');
    $feed_url = get_bloginfo('rss2_url');

    global $wp_rewrite;

    if ($wp_rewrite->using_permalinks()) {
        $feed_url .= '?emember_feed_key=' . md5($emember_auth->getUserInfo('member_id'));
    } else {
        $feed_url .= '&emember_feed_key=' . md5($emember_auth->getUserInfo('member_id'));
    }

    if ($eMember_secure_rss) {
        $output .= '<li><a href="' . $feed_url . '">' . EMEMBER_MY_FEED . '</a></li>';
    }

    $support_page = $emember_config->getValue('eMember_support_page');

    if (!empty($support_page)) {
        $output .= '<li><a href="' . $support_page . '">' . EMEMBER_SUPPORT_PAGE . '</a></li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}
function emember_customizable_login_widget_after_login(){
    $emember_config = Emember_Config::getInstance();    
    $auth = Emember_Auth::getInstance();
    if(!$auth->isLoggedIn()) return;
    $username = $auth->getUserInfo('user_name'); 
    $output = '';    
    $expires = $auth->getUserInfo('account_state');
    if($auth->subscription_duration['type'] =='noexpire')
        $sub_expires = EMEMBER_NEVER;
    else if ($auth->subscription_duration['type'] =='fixeddate')
        $sub_expires = emember_date_locale(strtotime($auth->subscription_duration['duration']));
    else{             
        $sub_start = strtotime($auth->getUserInfo('subscription_starts'));
        $sub_expires = emember_date_locale(strtotime("+" . $auth->subscription_duration['duration'] . " days ", $sub_start));
    }
    $states = array('active'=>EMEMBER_ACTIVE,
                     'inactive'=>EMEMBER_INACTIVE,
                     'expired'=>EMEMBER_EXPIRED,
                     'pending'=>EMEMBER_PENDING,
                     'unsubscribed'=>EMEMBER_UNSUBSCRIBED);
    $eMember_secure_rss = $emember_config->getValue('eMember_secure_rss');
    $eMember_show_welcome_page_link = $emember_config->getValue('eMember_show_link_to_after_login_page');
    $feed_url = get_bloginfo('rss2_url');
    //$feed_url = get_bloginfo('url') . '?feed=ememberfeed&key=' . md5($auth->getUserInfo('member_id'));
    global $wp_rewrite;
    $nonce = wp_create_nonce('emember-secure-feed-nonce');        
    if($wp_rewrite->using_permalinks()){
    	$feed_url .= '?emember_feed_key=' . md5($auth->getUserInfo('member_id')) . "&_wpnonce=$nonce";
    }
    else{
    	$feed_url .= '&emember_feed_key=' . md5($auth->getUserInfo('member_id')) . "&_wpnonce=$nonce";
    }
    $logout = get_logout_url();
    $renew_url = $emember_config->getValue('eMember_account_upgrade_url');    
    $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');
    $support_page = $emember_config->getValue('eMember_support_page');
    $welcome_page_url = emember_get_after_login_page_url_of_current_user();
    $bookmark_feature = $emember_config->getValue('eMember_enable_bookmark');        
    $bookmark_page_url = $emember_config->getValue('eMember_bookmark_listing_page');
    $custom_login_msg = $emember_config->getValue('eMember_login_widget_message_for_logged_members');
    $custom_login_msg = do_shortcode($custom_login_msg);
    ob_start();
    ?>
    <div id="emember-elfd-container" >
        <div id="emember-elfd-wrapper">
            <div id="emember-elfd-block" class="emember-elf-animate emember-elf-form">
                <div class="emember-elfd-logged-in-as-block">
                    <span class="emember-elfd-logged-in-as-label"> <?php echo EMEMBER_LOGGED_IN_AS;?></span>
                    <span class="emember-elfd-logged-in-as-name"> <?php echo $username;?></span>
                </div>
                <div class="emember-elfd-logged-in-membershiplevel-block">
                    <span class="emember-elfd-logged-in-membershiplevel-label"> <?php echo EMEMBER_LOGGED_IN_LEVEL;?></span>
                    <span class="emember-elfd-logged-in-membershiplevel-name"> <?php echo $auth->user_membership_level_name;?></span>
                </div>
                <div class="emember-elfd-logged-in-status-block">
                    <span class="emember-elfd-logged-in-status-label"> <?php echo EMEMBER_ACCOUNT_STATUS;?></span>
                    <span class="emember-elfd-logged-in-status-name"> <?php echo $states[$auth->getUserInfo('account_state')];?></span>
                </div>
                <?php if($expires != 'expired'):?>
                <div class="emember-elfd-logged-in-expiry-block">
                    <span class="emember-elfd-logged-in-expiry-label"> <?php echo EMEMBER_ACCOUNT_EXPIRES_ON;?></span>
                    <span class="emember-elfd-logged-in-expiry-name"> <?php echo $sub_expires;?></span>                    
                </div>
                <?php endif;?>
                <div class="emember-elfd-logged-in-links-block">
                <?php if($expires == 'expired'):?>
                    <a class="emember-elfd-renew-link" href="<?php echo $renew_url;?>"><?php echo EMEMBER_RENEW_OR_UPGRADE;?></a>
                <?php endif;?>
                <?php if($eMember_secure_rss):?>            
                    <a class="emember-elfd-feed-link" href="<?php echo $feed_url;?>"><?php echo EMEMBER_MY_FEED;?></a>                
                <?endif?>
                <?php if($edit_profile_page):?>            
                    <a class="emember-elfd-editprofile-link" href="<?php echo $edit_profile_page;?>"><?php echo EMEMBER_EDIT_PROFILE;?></a>                
                <?endif?>
                <?php if($support_page):?>            
                    <a class="emember-elfd-supportpage-link" href="<?php echo $support_page;?>"><?php echo EMEMBER_SUPPORT_PAGE;?></a>                
                <?endif?>
                <?php if($eMember_show_welcome_page_link):?>            
                    <a class="emember-elfd-welcome-link" href="<?php echo $welcome_page_url;?>"><?php echo EMEMBER_WELCOME_PAGE;?></a>                
                <?endif?>
                <?php if($bookmark_feature&&$bookmark_page_url):?>            
                    <a class="emember-elfd-bookmark-link" href="<?php echo $bookmark_page_url;?>"><?php echo EMEMBER_BOOKMARK_PAGE;?></a>                
                <?endif?>
                    <a class="emember-elfd-logout-link" href="<?php echo $logout;?>"><?php echo EMEMBER_LOGOUT;?></a>
                </div>
                <?php if($custom_login_msg):?>            
                 <div class="emember-elfd-custom-login-msg-block">
                    <?php echo html_entity_decode($custom_login_msg, ENT_COMPAT);?>
                 </div>                       
                <?endif?>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
function emember_customizable_login_widget_before_login(){
   $emember_auth = Emember_Auth::getInstance();
   if($emember_auth->isLoggedIn()) return; 
   $emember_config = Emember_Config::getInstance();
   $msg = $emember_auth->getSavedMessage('eMember_login_status_msg');
   $state_code = $emember_auth->getSavedMessage('eMember_login_status_code');
   $join_url = $emember_config->getValue('eMember_payments_page');   
   ob_start();    
    ?>
    <div id="emember-elf-container" >
        <div id="emember-elf-wrapper">
            <div id="emember-elf-login" class="emember-elf-animate emember-elf-form">
                <form action="" method="post" class="loginForm wp_emember_loginForm" name="wp_emember_loginForm" id="wp_emember_loginForm" autocomplete="on"> 
                     <?php wp_nonce_field('emember-login-nonce'); ?>
                    <h1>Member Login</h1> 
                    <div class="emember-elf-username-para"> 
                        <label for="emember-elf-username" class="emember-elf-uname"  > <?php echo EMEMBER_USER_NAME; ?> </label>
                        <input id="emember-elf-username" name="login_user_name" required="required" type="text" placeholder="Username" value="<?php echo isset($_POST['login_user_name'])?strip_tags($_POST['login_user_name']):"";?>"/>
                    </div>
                    <div class="emember-elf-username-para"> 
                        <label for="emember-elf-password" class="emember-elf-passwd" > <?php echo EMEMBER_PASSWORD; ?> </label>
                        <input id="emember-elf-password" name="login_pwd" required="required" type="password" placeholder="Password" value="<?php echo isset($_POST['login_pwd'])?strip_tags($_POST['login_pwd']):"";?>"/> 
                    </div>
                    <div class="emember-elf-keeplogin"> 
						<input type="checkbox" name="rememberme" id="emember-elf-loginkeeping" value="loginkeeping" /> 
						<label for="emember-elf-loginkeeping"><?php echo EMEMBER_REMEMBER_ME; ?></label>
					</div>
                    <div class="emember-elf-login emember-elf-button"> 
                        <input type="hidden" value="1" name="testcookie" />
                        <input name="doLogin" type="submit" id="doLogin" value="<?php echo EMEMBER_LOGIN;?>" /> 
					</div>
                    <span class="<?php echo ($state_code == 6)? 'emember_ok':'emember_error';?>"> <?php echo $msg;?> </span>
                    <div class="emember-elf-change_link">
	                    <?php
	                    $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
	                    if($password_reset_url): 
	                    ?>
						<a href="#toregister" href="<?php echo $password_reset_url;?>"  class="emember-elf-to-register"><?php echo EMEMBER_FORGOT_PASS;?></a>
                        <?php else :?>
						<a href="#toregister" rel="#emember_forgot_pass_prompt"  href="javascript:void(0);" class="emember-elf-to-register forgot_pass_link"><?php echo EMEMBER_FORGOT_PASS;?></a>
                        <?php endif;?>	        
						<a href="<?php echo $join_url; ?>" class="emember-elf-to-register"><?php echo EMEMBER_JOIN_US;?></a>
					</div>    
                </form>
            </div>						
        </div>
    </div>  
    <?php
    $output = ob_get_contents();
    ob_end_clean();
	return $output;
}
