<?php

function emember_bootstrap() {
    $emember_config = Emember_Config::getInstance();
    $lang = $emember_config->getValue('eMember_language');
    if (!empty($lang))
        $eMember_language_file = WP_EMEMBER_PATH . "lang/" . $lang . ".php";
    else
        $eMember_language_file = WP_EMEMBER_PATH . "lang/eng.php";
    $eMember_language_file = apply_filters('emember_get_language_path', $eMember_language_file, $lang);
    include_once($eMember_language_file);
}

function emember_initialize() {
    //Both front end and admin side init time tasks
    load_library();
    
    //Front end only init time tasks
    if (!is_admin()) {
        if (isset($_REQUEST['emember_feed_key'])) {
            $emember_auth = Emember_Auth::getInstance();
            $emember_auth->login_with_feed_key($_REQUEST['emember_feed_key']);
        }
        emember_init_frontend();
        emember_menu();
        $emember_allow_comment = Emember_Config::getInstance()->getValue('eMember_member_can_comment_only');
        if ($emember_allow_comment){
            emember_check_comment();
        }
        emember_del_bookmark();
        emember_do_caching_plugin_compatibility();
    }

    //Admin side only init time tasks
    if (is_admin()) {
        emember_init_admin_side();
    }
}

function emember_init_frontend() {
    emember_dynamic_js_load();
    emember_process_reg_form();
    emember_process_free_rego_with_confirm_form();
    if (isset($_REQUEST['doLogin'])) {
        $valid_captcha = apply_filters('emember_captcha_varify_login', true);
        if (!$valid_captcha) {
            wp_die('Security check: failed captcha. Please try again!', '', array('back_link' => true));
        }
        $nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($nonce, 'emember-login-nonce')) {
            eMember_log_debug("Login nonce check failed ", true);
            die("Security check failed on login");
        }
        if (isset($_REQUEST['emember_u_name']) && isset($_REQUEST['emember_pwd'])) {
            $_POST['login_user_name'] = $_REQUEST['emember_u_name'];
            $_POST['login_pwd'] = $_REQUEST['emember_pwd'];
        }
        emember_login_init();
    } else {
        emember_logout_init();
    }
    emember_update_profile_init();
    emember_general_init_code();
}

function emember_init_admin_side() {
    $page = filter_input(INPUT_GET, 'page');
    $action = filter_input(INPUT_GET, 'members_action');
    if ($page == 'wp_eMember_manage' && empty($action)) {
        if (!empty($_REQUEST['_wp_http_referer'])) {
            wp_redirect(remove_query_arg(array('_wp_http_referer', '_wpnonce'), wp_unslash($_SERVER['REQUEST_URI'])));
            exit;
        }
    }
}

function emember_login_init($redirect = true) {
    do_action('eMember_user_login_init');
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $user = strip_tags($_POST['login_user_name']);
    $clientip = $_SERVER['REMOTE_ADDR'];
    if ($emember_config->getValue('eMember_multiple_logins') == '1')
        unset($_POST['rememberme']);
    eMember_log_debug("Authenticating login request for username: " . $user . ". Request came from IP Address: " . $clientip, true);
    if ($emember_auth->isLoggedIn()) {
        eMember_log_debug("Authentication completed for username: " . $user . ". IP Address: " . $clientip, true);
        $_SESSION['membership_level_name'] = $emember_auth->permitted->primary_level->get('alias');
        
        do_action('eMember_login_authentication_completed');
        
        if(isset($_REQUEST['no-redirect']) && $_REQUEST['no-redirect'] == '1'){
            //No redirect argument is set in this request. Do not do any after login redirect
        }else{
            //Do after login redirection according to the settings
            $enable_after_login_redirect = $emember_config->getValue('eMember_enable_redirection');
            if ($redirect && $enable_after_login_redirect) {
                eMember_log_debug("Redirecting member to the after login redirection page.", true);
                $separate_home_page = emember_get_after_login_page_url_of_current_user();
                if (!empty($separate_home_page)) {
                    wp_emember_redirect_to_url($separate_home_page);
                    exit;
                }
            }
        }
    }
}

function emember_logout_init() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    if (!$emember_auth->isLoggedIn())
        return;
    $sign_in_wp = $emember_config->getValue('eMember_signin_wp_user');
    if ($sign_in_wp && !is_user_logged_in()) {//If Not logged into WP while emember is logged in
        if (username_exists($emember_auth->getUserInfo('user_name'))) {
            eMember_log_debug("User Exists in WP but not logged in. ", true);
            $emember_auth->silent_logout();
            eMember_log_debug("Logging out of emember because wp cookie for this user expired ", true);
        } else {
            eMember_log_debug("You have auto login to WP enabled but WP User doesn't exist for this user! WP User login won't execute.", true);
        }
    }
}

function emember_general_init_code() {
    if (isset($_REQUEST['emember_paypal_ipn'])) {
        include_once('ipn/eMember_handle_paypal_ipn.php');
        exit;
    }

    if (isset($_REQUEST['emember_aweber_success'])) {
        include_once('api/aweber-success.php');
        exit;
    }
}

function emember_do_caching_plugin_compatibility()
{
    if(wp_emember_is_member_logged_in()){//Do not cache page for logged in members
       define('DONOTCACHEPAGE', TRUE); 
    }
}
