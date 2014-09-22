<?php

//Mandatory data - Secret key and referrer email address

if (!isset($_REQUEST['secret_key'])) {
    exit;
}

include_once('../../../../wp-load.php');
include_once('eMember_misc_functions.php');
include_once('../eMember_debug_handler.php');

global $wpdb, $emember_config;
$emember_config = Emember_Config::getInstance();
eMember_log_debug('Start Processing - modify.php', true);

$eMember_allow_remote_post = $emember_config->getValue('wp_eMember_enable_remote_post');
if (!$eMember_allow_remote_post) {
    echo "Remote POST is disabled";
    eMember_log_debug('Remote POST is disabled in the settings.', false);
    exit;
}

$secret_key_received = $_REQUEST['secret_key'];
$right_secret_key = $emember_config->getValue('wp_eMember_secret_word_for_post');
if ($secret_key_received != $right_secret_key) {
    echo "Error!\n";
    echo "Secret key is invalid\n";
    eMember_log_debug('secret key invalid...', false);
    exit;
}

if (empty($_REQUEST['email']) || empty($_REQUEST['email'])) {
    echo "Error!\n";
    echo "Missing mandatory field. Referee email and Referrer email must be present!\n";
    eMember_log_debug('Missing mandatory field. Referee email and Referrer email must be present...', false);
    exit;
}

//Account check for members or the level specified in the shortcode
$referrer_email = $_REQUEST['ref_email'];
$referrer_id = emember_email_exists($referrer_email);

if (!$referrer_id || !emember_registered_email_exists($referrer_email)) {

    echo "Error!\n";
    echo "Referrer email does not exist or must be registered!\n";
    eMember_log_debug('Referrer email does not exist or must be registered...', false);
    exit;
}


$referee_email = $_REQUEST['email'];
$referee_id = emember_email_exists($referee_email);

if (!$referee_id || !emember_registered_email_exists($referee_email)) {

    echo "Error!\n";
    echo "Referee email does not exist or must be registered!\n";
    eMember_log_debug('Referee email does not exist or must be registered...', false);
    exit;
}

// Update the Referee Member
$referee_custom_fields = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, ' user_id=\'' . $referee_id . '\' AND meta_key=\'custom_field\'');

$referee_data = array();

if ($referee_custom_fields) {
    $referee_data = unserialize($referee_custom_fields->meta_value);
    $referee_data['Good_Karma_Referrer'] = $referrer_email; //reference to Good Karma Referrer

    $wpdb->query('UPDATE ' . WP_EMEMBER_MEMBERS_META_TABLE .
            ' SET meta_value =' . '\'' . serialize($referee_data) . '\' WHERE meta_key = \'custom_field\' AND  user_id=' . $referee_id);

    eMember_log_debug('Referee Member data has been updated', true);
} else {
    $referee_data['Good_Karma_Referrer'] = $referrer_email; //reference to Good Karma Referrer
    $referee_data['Good_Karma_Referrals'] = '';

    $wpdb->query("INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
            '( user_id, meta_key, meta_value ) VALUES(' . $referee_id . ',"custom_field",' . '\'' . serialize($referee_data) . '\')');

    eMember_log_debug('Referee Member data has been inserted', true);
}


// Update the Referrer Member
$referrer_custom_fields = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, ' user_id=\'' . $referrer_id . '\' AND meta_key=\'custom_field\'');

$referrer_data = array();

if ($referrer_custom_fields) {
    $referrer_data = unserialize($referrer_custom_fields->meta_value);
    $referrer_data['Good_Karma_Referrals'] .= (($referrer_data['Good_Karma_Referrals'] != '') ? ', ' : '') . $referee_email; //reference to Good Karma Referee

    $wpdb->query('UPDATE ' . WP_EMEMBER_MEMBERS_META_TABLE .
            ' SET meta_value =' . '\'' . serialize($referrer_data) . '\' WHERE meta_key = \'custom_field\' AND  user_id=' . $referrer_id);

    eMember_log_debug('Referrer Member data has been updated', true);
} else {
    $referrer_data['Good_Karma_Referrer'] = '';
    $referrer_data['Good_Karma_Referrals'] = $referee_email; //reference to Good Karma Referee;

    $wpdb->query("INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
            '( user_id, meta_key, meta_value ) VALUES(' . $referrer_id . ',"custom_field",' . '\'' . serialize($referrer_data) . '\')');

    eMember_log_debug('Referrer Member data has been inserted', true);
}

echo "Success!\n";
echo "Membership referrer update succeeded.\n";
