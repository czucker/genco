<?php

if (!defined('ABSPATH')) {
    include_once('../../../../wp-load.php');
    include_once('../eMember_debug_handler.php');
}

eMember_log_debug('Post AWeber form submission request received. Processing...', true);

$emember_config = Emember_Config::getInstance();
$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Error! Remote POST is disabled";
    eMember_log_debug('Error! Remote POST is disabled in the settings. So this request will not be processed.', false);
    exit;
}

$secretKey = $emember_config->getValue('wp_eMember_secret_word_for_post');
//TODO - add a secret key check and make this script do the whole user creation tasks?

//Massage the data
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
list($first_name, $last_name) = explode(' ', $name);
$listname = $_REQUEST['unit'];
$username = $email;
$referrer_mail = $_REQUEST['referrer'];

if (empty($email) || empty($name) || empty($listname)) {
    echo "Error!\n";
    echo "Missing mandatory field. Email, first name and last name must be present!\n";
    eMember_log_debug('Error! Missing mandatory field. Email, first name and last name must be present...', false);
    exit;
}

//POST the data to the eMember API
$postURL = WP_EMEMBER_URL . "/api/create.php";

$data = array();
$data['secret_key'] = $secretKey;
//$data['requested_domain'] = $domainURL;
$data['email'] = $email;
$data['first_name'] = $first_name;
$data['last_name'] = $last_name;
$data['username'] = $username;
$data['membership_level_name'] = $listname;

// send data to post URL
$ch = curl_init($postURL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$returnValue = curl_exec($ch);
curl_close($ch);

//print_r($returnValue);

list ($result, $msg, $additionalMsg) = explode("\n", $returnValue);

if ($result == 'Success!') {
    $login_data = $additionalMsg;

//		POST data to the eMember API to modify membership
//		$modify_postURL = WP_EMEMBER_URL."/api/modify.php";
//
//    		$data['ref_email'] = $referrer_mail;
//
//    		// send data to post URL
//    		$m_ch = curl_init ($modify_postURL);
//    		curl_setopt ($m_ch, CURLOPT_POST, true);
//    		curl_setopt ($m_ch, CURLOPT_POSTFIELDS, $data);
//    		curl_setopt ($m_ch, CURLOPT_RETURNTRANSFER, false);
//    		$m_returnValue = curl_exec ($m_ch);
//    		curl_close($m_ch);
//
//    		// print_r($m_returnValue);
//
//    		list ($result, $msg, $additionalMsg) = explode ("\n", $m_returnValue);
//   		// End DKO

    //Redirect to login page
    list($username, $password) = explode("|", $login_data);
    $redirect_page = $emember_config->getValue('login_page_url');
    $redirect_page = $redirect_page . "?doLogin=1&emember_u_name=" . $username . "&emember_pwd=" . $password;
    $redirect_page = wp_nonce_url($redirect_page, 'emember-login-nonce');
    header("Location: " . $redirect_page);
    exit;

    echo "<br />" . $msg;
    echo "<br />" . $additionalMsg;
} else {
    //Something failed.. do not create user account.
    echo "<br />Error!";
    echo "<br />" . $msg;
}
