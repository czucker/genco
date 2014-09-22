<?php

//Mandatory data - Secret key, first name, last name and email address

if (!isset($_REQUEST['secret_key'])) {
    exit;
}
include_once('../../../../wp-load.php');
include_once('../eMember_debug_handler.php');

global $wpdb, $emember_config;
$emember_config = Emember_Config::getInstance();
$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Remote POST is disabled";
    eMember_log_debug('Remote POST is disabled in the settings.', false);
    exit;
}

eMember_log_debug('Start Processing of membership creation request via API...', true);
$secret_key_received = $_REQUEST['secret_key'];
$right_secret_key = $emember_config->getValue('wp_eMember_secret_word_for_post');
if ($secret_key_received != $right_secret_key) {
    echo "Error!\n";
    echo "Secret key is invalid\n";
    eMember_log_debug('secret key invalid...', false);
    exit;
}

if (empty($_REQUEST['email']) || empty($_REQUEST['first_name']) || empty($_REQUEST['last_name'])) {
    echo "Error!\n";
    echo "Missing mandatory field. Email, first name and last name must be present!\n";
    eMember_log_debug('Missing mandatory field. Email, first name and last name must be present...', false);
    exit;
}
//mandatory data
$email = strip_tags($_REQUEST['email']);
$first_name = strip_tags($_REQUEST['first_name']);
$last_name = strip_tags($_REQUEST['last_name']);

//optional data
$username = strip_tags($_REQUEST['username']);
$password = strip_tags($_REQUEST['password']);
$membership_level_name = strip_tags($_REQUEST['membership_level_name']);
$membership_level_id = strip_tags($_REQUEST['membership_level_id']);
eMember_log_debug('Received data:' . $email . '|' . $first_name . '|' . $last_name . '|' . $membership_level_name . '|' . $membership_level_id . '|' . $username . '|' . $password, true);

if (emember_wp_username_exists($username) || emember_username_exists($username)) {
    echo "Error!\n";
    echo "Username already in use.";
    eMember_log_debug('That username is already in use', false);
    exit;
}

if (emember_wp_email_exists($email) || emember_email_exists($email)) {
    echo "Error!\n";
    echo "Email address already exists.";
    eMember_log_debug('Email address already used...', false);
    exit;
}

if (is_blocked_email($email)) {
    echo "Error!\n";
    echo "Email address entered is forbidden..";
    eMember_log_debug("Forbidden email address used...", false);
    exit;
}

if (empty($membership_level_id)) {
    if (empty($membership_level_name)) {
        $membership_level_id = $emember_config->getValue('eMember_free_membership_level_id');
    } else {
        $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " alias='" . $membership_level_name . "'");
        $membership_level_id = $membership_level_resultset->id;
    }
}

if (empty($username)) {
    $username = substr(uniqid(), 0, 6);
}
if (empty($password)) {
    $password = substr(uniqid(), 0, 8);
}

include_once(ABSPATH . WPINC . '/class-phpass.php');
$wp_hasher = new PasswordHash(8, TRUE);
$hashed_password = $wp_hasher->HashPassword($password);

//Create a new account for a free member or the level specified in the shortcode
$fields = array();
$fields['user_name'] = $username;
$fields['password'] = $hashed_password;
$fields['first_name'] = $first_name;
$fields['last_name'] = $last_name;
$fields['email'] = $email;
$fields['member_since'] = (date("Y-m-d"));
$fields['subscription_starts'] = date("Y-m-d");

$fields['membership_level'] = $membership_level_id;
$manually_approve = $emember_config->getValue('eMember_manually_approve_member_registration');
if ($manually_approve)
    $fields['account_state'] = 'pending';
else
    $fields['account_state'] = 'active';

$fields['last_accessed_from_ip'] = get_real_ip_addr();

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

//TODO add a check to make sure an account with this username already doesn't exist
$ret = dbAccess::insert(WP_EMEMBER_MEMBERS_TABLE_NAME, $fields);
if ($ret === false) {
    echo "Error!\n";
    echo "Membership creation failed. Insert to db failed.\n";
    eMember_log_debug('Membership creation failed', false);
    exit;
} else {
    if (isset($_REQUEST['openid_type'])) {
        $fields = array();
        global $wpdb;
        $fields['type'] = strip_tags($_REQUEST['openid_type']);
        $fields['openuid'] = strip_tags($_REQUEST['openid_uid']);
        $fields['emember_id'] = strip_tags($wpdb->insert_id);
        $wpdb->insert(WP_EMEMBER_OPENID_TABLE, $fields);
    }
    eMember_log_debug('Membership creation succeeded for:' . $email, true);
}

//Query the membership level table to get a handle for the level
$membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $membership_level_id . "'");

// Create the corresponding wordpress user
$should_create_wp_user = $emember_config->getValue('eMember_create_wp_user');
if ($should_create_wp_user) {
    $role_names = array(1 => 'Administrator', 2 => 'Editor', 3 => 'Author', 4 => 'Contributor', 5 => 'Subscriber');
    $wp_user_info = array();
    $wp_user_info['user_nicename'] = implode('-', explode(' ', $username));
    $wp_user_info['display_name'] = $username;
    $wp_user_info['nickname'] = $username;
    $wp_user_info['first_name'] = $first_name;
    $wp_user_info['last_name'] = $last_name;
    $wp_user_info['role'] = $membership_level_resultset->role;
    $wp_user_info['user_registered'] = date('Y-m-d H:i:s');

    //$wp_user_id = wp_create_user($username, $password, $email);  //Need to use the non hashed password
    $wp_user_id = eMember_wp_create_user($username, $password, $email);
    $wp_user_info['ID'] = $wp_user_id;
    wp_update_user($wp_user_info);
    eMember_log_debug('Updating WP user role to : ' . $membership_level_resultset->role, true);
    update_wp_user_Role($wp_user_id, $membership_level_resultset->role);
    //do_action( 'set_user_role', $wp_user_id, $membership_level_resultset->role );
}

$subject_rego_complete = $emember_config->getValue('eMember_email_subject_rego_complete');
$body_rego_complete = $emember_config->getValue('eMember_email_body_rego_complete');
$from_address = $emember_config->getValue('senders_email_address');
$login_link = $emember_config->getValue('login_page_url');
$tags1 = array("{first_name}", "{last_name}", "{user_name}", "{password}", "{login_link}");
$vals1 = array($first_name, $last_name, $username, $password, $login_link);
$email_body1 = str_replace($tags1, $vals1, $body_rego_complete);
$headers = 'From: ' . $from_address . "\r\n";
wp_mail($email, $subject_rego_complete, $email_body1, $headers);
if ($emember_config->getValue('eMember_admin_notification_after_registration')) {
    $admin_email = get_option('admin_email');
    $admin_notification_subject = EMEMBER_NEW_ACCOUNT_MAIL_HEAD;
    $admin_email_body = EMEMBER_NEW_ACCOUNT_MAIL_BODY .
            "\n\n-------Member Email----------\n" .
            $email_body1 .
            "\n\n------End------\n";
    wp_mail($admin_email, $admin_notification_subject, $admin_email_body, $headers);
}
//Create the corresponding affliate account
if ($emember_config->getValue('eMember_auto_affiliate_account')) {
    eMember_handle_affiliate_signup($username, $password, $first_name, $last_name, $email, eMember_get_aff_referrer());
}

//Do autoresponsder signup if needed
if (!empty($membership_level_id)) {
    eMember_level_specific_autoresponder_signup($membership_level_id, $first_name, $last_name, $email);
}
eMember_global_autoresponder_signup($first_name, $last_name, $email);

echo "Success!\n";
echo "Membership creation succeeded.\n";
echo $username . "|" . $password;
