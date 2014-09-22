<?php

include_once('../../../../wp-load.php');
include_once('eMember_handle_subsc_ipn_stand_alone.php');

$debug_enabled = false;
global $emember_config;
$emember_config = Emember_Config::getInstance();
if ($emember_config->getValue('eMember_enable_debug') == 1) {
    $debug_enabled = true;
}

if ($debug_enabled) {
    echo 'Debug is enabled.';
    if (empty($_POST)) {
        eMember_log_debug('This debug line was generated because you entered the URL of the ipn handling script in the browser.', true, true);
        exit;
    }
}
eMember_log_debug("Clickbank IPN received! Processing IPN ...", true);
eMember_log_debug_array($_POST, true);

//Verify the authenticity fo the payment
$clickbank_secretKey = $emember_config->getValue('eMember_cb_secret_key'); //YOURSECRETKEY //Get this secret key from your clickbank account info (Account Settings -> My Sites)
$cb_validate_retVal = eMember_clickbank_ipnVerification($clickbank_secretKey);
eMember_log_debug("IPN validation return value: " . $cb_validate_retVal, true);
if ($cb_validate_retVal != '1') {
    eMember_log_debug("Clickbank IPN authenticity failed! This payment notification will not be processed!", false);
    exit;
}

$cb_ipn_data = array();
$cb_ipn_data['txn_type'] = $_POST['ctransaction'];
$cb_ipn_data['payer_email'] = $_POST['ccustemail'];
$cb_ipn_data['first_name'] = $_POST['ccustfirstname'];
$cb_ipn_data['last_name'] = $_POST['ccustlastname'];
$cb_ipn_data['address_street'] = $_POST['ccustaddr1'] . " " . $_POST['ccustaddr2'];
$cb_ipn_data['address_city'] = $_POST['ccustcity'];
$cb_ipn_data['address_state'] = $_POST['ccuststate'];
$cb_ipn_data['address_zip'] = $_POST['ccustzip'];
$cb_ipn_data['address_country'] = $_POST['ccustshippingcountry'];
$cb_ipn_data['txn_id'] = $_POST['ctransreceipt'];
$cb_ipn_data['custom'] = $_POST['cvendthru'];
eMember_log_debug_array($cb_ipn_data, true);

//------------ key value pair for the custom data --------------
$custom = $cb_ipn_data['custom'];
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
$cb_ipn_data['membership_level_id'] = $customvariables['membership_level_id'];
eMember_log_debug("Payment received for membership level ID:" . $cb_ipn_data['membership_level_id'], true);

//handle the membership payment data
eMember_handle_subsc_signup_stand_alone($cb_ipn_data, $cb_ipn_data['membership_level_id'], $cb_ipn_data['txn_id']);

eMember_log_debug("End of clickbank membership payment processing!", true, true);

//Return value 1=passed, 0=fail
function eMember_clickbank_ipnVerification($clickbank_secretKey = "") {
    eMember_log_debug("Validating IPN authenticity. Secret Key:" . $clickbank_secretKey, true);
    $secretKey = $clickbank_secretKey;
    $pop = "";
    $ipnFields = array();
    foreach ($_POST as $key => $value) {
        if ($key == "cverify") {
            continue;
        }
        $ipnFields[] = $key;
    }
    sort($ipnFields);
    foreach ($ipnFields as $field) {
        // if Magic Quotes are enabled $_POST[$field] will need to be
        // un-escaped before being appended to $pop
        $pop = $pop . $_POST[$field] . "|";
    }
    $pop = $pop . $secretKey;
    $calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
    $calcedVerify = strtoupper(substr($calcedVerify, 0, 8));
    return $calcedVerify == $_POST["cverify"];
}

?>