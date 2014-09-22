<?php

//This API is used for deactivating a member's profile data
//Mandatory data - Secret key, member ID or email

if (!isset($_REQUEST['secret_key'])) {
    exit;
}
include_once('../../../../wp-load.php');
include_once('../eMember_debug_handler.php');

$emember_config = Emember_Config::getInstance();
$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Remote POST is disabled";
    eMember_log_debug('Remote POST is disabled in the settings.', false);
    exit;
}

eMember_log_debug('Start Processing of member profile deactivation request via API...', true);
$secret_key_received = strip_tags($_REQUEST['secret_key']);
$right_secret_key = $emember_config->getValue('wp_eMember_secret_word_for_post');
if ($secret_key_received != $right_secret_key) {
    echo "Error!\n";
    echo "Secret key is invalid\n";
    eMember_log_debug('secret key invalid...', false);
    exit;
}

if (empty($_REQUEST['member_id']) && empty($_REQUEST['email'])) {
    echo "Error!\n";
    echo "Missing mandatory field. Member ID or Email value must be present!\n";
    eMember_log_debug('Missing mandatory field. Member ID or Email must be present...', false);
    exit;
}

//Mandatory data
$email = esc_sql(strip_tags($_REQUEST['email']));
$member_id = strip_tags($_REQUEST['member_id']);
eMember_log_debug("Profile deactivation API Called for member ID: " . $member_id . " or Email: " . $email, false);
if (empty($member_id)) {
    //Retrieve member ID using email
    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, " email = '$email'");
    if (!$resultset) {
        echo "Error!\n";
        echo "Could not find an eMember user with the provided email address!\n";
        exit;
    }
    $member_id = $resultset->member_id;
    eMember_log_debug("Retrieving member ID from email address. Retrieved ID: " . $member_id, false);
}

//Optional data
$fields = array();
$fields['account_state'] = 'inactive';
if (isset($_REQUEST['account_state']))
    $fields['account_state'] = strip_tags($_REQUEST['account_state']);

//Update the emember user profile with the provided data
if (count($fields) > 0) {
    $ret = dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id =' . $member_id, $fields);
}

eMember_log_debug("Member profile deactivated.", true);
echo "Success!\n";
echo "Member profile deactivated.\n";
exit;
