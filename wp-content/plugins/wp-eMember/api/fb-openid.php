<?php

exit; //TODO - this feature is currently disabled as it is still being developed

include_once('../../../../wp-load.php');
include_once('../eMember_debug_handler.php');

global $emember_config;
$emember_config = Emember_Config::getInstance();
define('FACEBOOK_APP_ID', $emember_config->getValue('emember_fb_app_id'));
define('FACEBOOK_SECRET', $emember_config->getValue('emember_fb_app_secret'));

eMember_log_debug('Start Processing of membership creation request via Facebook Open ID...', true);

function parse_signed_request($signed_request, $secret) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2);

    // decode the data
    $sig = base64_url_decode($encoded_sig);
    $data = json_decode(base64_url_decode($payload), true);

    if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
        error_log('Unknown algorithm. Expected HMAC-SHA256');
        return null;
    }

    // check sig
    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
    if ($sig !== $expected_sig) {
        error_log('Bad Signed JSON signature!');
        return null;
    }

    return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

if ($_REQUEST) {

    $response = parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
    // 2011-05-17 by DKO
    $referrer_mail = $_REQUEST['referrer'];
    //POST the data to the eMember API
    $postURL = WP_EMEMBER_URL . "/api/create.php";
    $secretKey = $emember_config->getValue('wp_eMember_secret_word_for_post');
    $location = explode(',', $response['registration']['location']['name']);
    $data = array();
    $data['secret_key'] = $secretKey;
    $data['email'] = $response['registration']['email']; //$email;
    $data['password'] = $response['registration']['password'];
    $data['gender'] = $response['registration']['gender'];
    $data['first_name'] = $response['registration']['first_name']; //$first_name;
    $data['last_name'] = $response['registration']['last_name']; //$last_name;
    $data['username'] = $response['registration']['username']; //$username;
    $data['membership_level_id'] = $response['registration']['membership'];
    $data['city'] = $location[0];
    $data['country'] = $location[1];
    $data['openid_type'] = 'facebook';
    $data['openid_uid'] = $response['user_id'];

    $blacklisted_emails = $emember_config->getValue('blacklisted_emails');
    $blacklisted_emails = empty($blacklisted_emails) ? array() : explode(';', $blacklisted_emails);
    $isblacklistedemail = false;
    foreach ($blacklisted_emails as $email) {
        if ((!empty($email)) && stristr($data['email'], $email)) {
            $isblacklistedemail = true;
        }
    }
    if ($isblacklistedemail) {
        echo '<span class="emember_error"> ' . EMEMBER_EMAIL_BLACKLISTED . ' </span>';
    } else {
        // send data to post URL
        $ch = curl_init($postURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnValue = curl_exec($ch);
        curl_close($ch);
        list ($result, $msg, $additionalMsg) = explode("\n", $returnValue);

        if ($result == 'Success!') {
            $login_data = $additionalMsg;
            list($username, $password) = explode("|", $login_data);
            $redirect_page = $emember_config->getValue('login_page_url');
            $redirect_page = $redirect_page . "?doLogin=1&emember_u_name=" . $username . "&emember_pwd=" . $password;
            $redirect_page = wp_nonce_url($redirect_page, 'emember-login-nonce');
            header("Location: " . $redirect_page);
            exit;
            echo "<br />" . $msg;
            echo "<br />" . $additionalMsg;
        } else {
            //Something failed.. do not create.
            echo "<br />Error!";
            echo "<br />" . $msg;
        }
    }
} else {
    echo '$_REQUEST is empty';
}
?>