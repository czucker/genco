<?php

if (!isset($_REQUEST['secret_key'])) {
    exit;
}
include_once('../../../../wp-load.php');
include_once('../eMember_debug_handler.php');
include_once('../ipn/eMember_handle_subsc_ipn_stand_alone.php');

global $wpdb;
$emember_config = Emember_Config::getInstance();
$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Remote POST is disabled";
    eMember_log_debug('Remote POST is disabled in the settings.', false);
    exit;
}

eMember_log_debug('Start Processing of membership registration request via API...', true);
$secret_key_received = $_REQUEST['secret_key'];
$right_secret_key = $emember_config->getValue('wp_eMember_secret_word_for_post');
if ($secret_key_received != $right_secret_key) {
    echo "Error!\n";
    echo "Secret key is invalid\n";
    eMember_log_debug('secret key invalid...', false);
    exit;
}

$custom = strip_tags($_REQUEST['custom']);
$delimiter = "&";
$customvariables = array();

$namevaluecombos = explode($delimiter, $custom);
foreach ($namevaluecombos as $keyval_unparsed) {
    $equalsignposition = strpos($keyval_unparsed, '=');
    if ($equalsignposition === false) {
        $customvariables[$keyval_unparsed] = '';
        continue;
    }
    $key = substr($keyval_unparsed, 0, $equalsignposition);
    $value = substr($keyval_unparsed, $equalsignposition + 1);
    $customvariables[$key] = $value;
}

$subscr_id = strip_tags($_REQUEST['subscr_id']);
$subsc_ref = $customvariables['subsc_ref'];
$eMember_id = $customvariables['eMember_id'];

foreach ($_REQUEST as $field => $value) {
    $ipn_data["$field"] = $value;
}

eMember_log_debug('API - registering member account... see the "subscription_handle_debug.log" file for details', true);
eMember_handle_subsc_signup_stand_alone($ipn_data, $subsc_ref, $subscr_id, $eMember_id);
