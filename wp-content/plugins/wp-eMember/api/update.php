<?php

//This API is used for updating a members profile data
//Mandatory data - Secret key, member ID

if (!isset($_REQUEST['secret_key'])) {
    exit;
}
include_once('../../../../wp-load.php');
include_once('../eMember_debug_handler.php');
include_once(ABSPATH . WPINC . '/class-phpass.php');

global $wpdb;
$emember_config = Emember_Config::getInstance();
$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Remote POST is disabled";
    eMember_log_debug('Remote POST is disabled in the settings.', false);
    exit;
}

eMember_log_debug('Start Processing of member profile update request via API...', true);
$secret_key_received = $_REQUEST['secret_key'];
$right_secret_key = $emember_config->getValue('wp_eMember_secret_word_for_post');
if ($secret_key_received != $right_secret_key) {
    echo "Error!\n";
    echo "Secret key is invalid\n";
    eMember_log_debug('secret key invalid...', false);
    exit;
}

if (empty($_REQUEST['member_id'])) {
    echo "Error!\n";
    echo "Missing mandatory field. Member ID value must be present!\n";
    eMember_log_debug('Missing mandatory field. Member ID must be present...', false);
    exit;
}

//Mandatory data
$member_id = strip_tags($_REQUEST['member_id']);
eMember_log_debug("Profile Update API Called for member ID: " . $member_id, false);

//Optional data
$wp_hasher = new PasswordHash(8, TRUE);
$fields = array();
if (isset($_REQUEST['title']))
    $fields['title'] = strip_tags($_REQUEST['title']);
if (isset($_REQUEST['first_name']))
    $fields['first_name'] = strip_tags($_REQUEST['first_name']);
if (isset($_REQUEST['last_name']))
    $fields['last_name'] = strip_tags($_REQUEST['last_name']);
if (isset($_REQUEST['email']))
    $fields['email'] = strip_tags($_REQUEST['email']);
if (isset($_REQUEST['phone']))
    $fields['phone'] = strip_tags($_REQUEST['phone']);
if (isset($_REQUEST['address_street']))
    $fields['address_street'] = strip_tags($_REQUEST['address_street']);
if (isset($_REQUEST['address_city']))
    $fields['address_city'] = strip_tags($_REQUEST['address_city']);
if (isset($_REQUEST['address_state']))
    $fields['address_state'] = strip_tags($_REQUEST['address_state']);
if (isset($_REQUEST['address_zipcode']))
    $fields['address_zipcode'] = strip_tags($_REQUEST['address_zipcode']);
if (isset($_REQUEST['country']))
    $fields['country'] = strip_tags($_REQUEST['country']);
if (isset($_REQUEST['gender']))
    $fields['gender'] = strip_tags($_REQUEST['gender']);
if (isset($_REQUEST['company_name']))
    $fields['company_name'] = strip_tags($_REQUEST['company_name']);
if (!empty($_REQUEST['password'])) {
    $password = $wp_hasher->HashPassword(strip_tags($_REQUEST['password']));
    $fields['password'] = $password;
}

//Level ID to change (if any)
$membership_level_id = strip_tags(isset($_REQUEST['membership_level_id']) ? $_REQUEST['membership_level_id'] : "");

if (!empty($fields['email'])) {//Check to make sure the new email is not taken already or blocked
    if (emember_wp_email_exists($fields['email']) || emember_email_exists($fields['email'])) {
        echo "Error!\n";
        echo "Email address already exists.";
        eMember_log_debug('Email address already used...', false);
        exit;
    }
    if (is_blocked_email($fields['email'])) {
        echo "Error!\n";
        echo "Email address entered is blocked.";
        eMember_log_debug("Blocked email address used. This request will fail.", false);
        exit;
    }
}

//Update the corresponding WP User object if needed
$resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . $member_id);
$wp_user_id = username_exists($resultset->user_name);
if ($wp_user_id) {
    $wp_user_info = array();
    $wp_user_info['first_name'] = strip_tags(isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : "");
    $wp_user_info['last_name'] = strip_tags(isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : "");
    $wp_user_info['user_email'] = strip_tags(isset($_REQUEST['email']) ? $_REQUEST['email'] : "");
    $wp_user_info['ID'] = $wp_user_id;

    if (!empty($_REQUEST['password']))
        $wp_user_info['user_pass'] = $_REQUEST['password'];
    wp_update_user($wp_user_info);
}

//Update the emember user profile with the provided data
if (count($fields) > 0) {
    $ret = dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id =' . $member_id, $fields);
}

//Update the membership level ID
if (!empty($membership_level_id)) {
    emember_update_membership_level($member_id, $membership_level_id);
}

eMember_log_debug("Member profile updated.", true);
echo "Success!\n";
echo "Member profile updated.\n";
