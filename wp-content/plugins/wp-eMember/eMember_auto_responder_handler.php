<?php

function eMember_aweber_new_signup_user($full_target_list_name, $fname, $lname, $email_to_subscribe) {
    eMember_log_debug("Attempting to signup the user via AWeber API", true);
    $emember_config = Emember_Config::getInstance();
    $eMember_aweber_access_keys = $emember_config->getValue('eMember_aweber_access_keys');
    if (empty($eMember_aweber_access_keys['consumer_key'])) {
        eMember_log_debug("Missing AWeber access keys! You need to first make a conntect before you can use this API", false);
        return;
    }
    if (!class_exists('AWeberAPI')) {//TODO - change the class name to "eMember_AWeberAPI" to avoid conflict with others
        include_once('lib/auto-responder/aweber_api/aweber_api.php');
        eMember_log_debug("AWeber API library inclusion succeeded.", true);
    } else {
        eMember_log_debug("AWeber API library is already included from another plugin.", true);
    }
    try {
        $aweber = new AWeberAPI($eMember_aweber_access_keys['consumer_key'], $eMember_aweber_access_keys['consumer_secret']);
        $account = $aweber->getAccount($eMember_aweber_access_keys['access_key'], $eMember_aweber_access_keys['access_secret']); //Get Aweber account
        $account_id = $account->id;
        $mylists = $account->lists;
    } catch (Exception $e) {
        eMember_log_debug($e->getMessage(), false);
        return;
    }
    eMember_log_debug("AWeber account retrieved. Account ID: " . $account_id, true);

    $target_list_name = str_replace("@aweber.com", "", $full_target_list_name);
    eMember_log_debug("Attempting to signup the user to the AWeber list: " . $target_list_name, true);
    $list_name_found = false;
    foreach ($mylists as $list) {
        if ($list->name == $target_list_name || $list->unique_list_id == $target_list_name) {
            $list_name_found = true;
            try {//Create a subscriber
                $params = array(
                    'email' => $email_to_subscribe,
                    'name' => $fname . ' ' . $lname,
                );
                $subscribers = $list->subscribers;
                $new_subscriber = $subscribers->create($params);
                eMember_log_debug("User with email address " . $email_to_subscribe . " was added to the AWeber list: " . $target_list_name, true);
            } catch (Exception $exc) {
                eMember_log_debug("Failed to complete the AWeber signup! Error Details Below.", false);
                eMember_log_debug_array($exc, true);
            }
        }
    }
    if (!$list_name_found) {
        eMember_log_debug("Error! Could not find the AWeber list (" . $full_target_list_name . ") in your AWeber Account! Please double check your list name value for typo.", false);
    }
}

function eMember_get_chimp_api() {
    include_once('lib/auto-responder/eMember_MCAPI.class.php');
    $emember_config = Emember_Config::getInstance();
    $api_key = $emember_config->getValue('eMember_chimp_api_key');
    if (!empty($api_key)) {
        eMember_log_debug("Creating a new API object using the API Key specified in the settings: " . $api_key, true);
        $api = new eMember_MCAPI($api_key);
    } else {
        $api = "";
        eMember_log_debug("Error! You did not specify your MailChimp API key in the autoresponder settings. MailChimp signup will fail.", false);
    }
    return $api;
}

function eMember_mailchimp_subscribe($api, $target_list_name, $fname, $lname, $email_to_subscribe) {
    eMember_log_debug("MailChimp target list name: " . $target_list_name, true);
    
	//Check if interest group data is present
	$pieces = explode("|", $target_list_name);
	if(count($pieces)>2){
		$target_list_name = trim($pieces[0]);
		$interest_group_name = trim($pieces[1]);
		$interest_groups = trim($pieces[2]);
		eMember_log_debug("MailChimp List Name: ".$target_list_name,true);
		eMember_log_debug("Interest Group Name: ".$interest_group_name,true);
		eMember_log_debug("Groups: ".$interest_groups,true);
	}
        
    $list_filter = array();
    $list_filter['list_name'] = $target_list_name;
    $all_lists = $api->lists($list_filter);
    $lists_data = $all_lists['data'];
    $found_match = false;
    foreach ($lists_data AS $list) {
        eMember_log_debug("Checking list name : " . $list['name'], true);
        if (strtolower($list['name']) == strtolower($target_list_name)) {
            $found_match = true;
            $list_id = $list['id'];
            eMember_log_debug("Found a match for the list name on MailChimp. List ID :" . $list_id, true);
        }
    }
    if (!$found_match) {
        eMember_log_debug("Could not find a list name in your MailChimp account that matches with the target list name: " . $target_list_name, false);
        return;
    }
    eMember_log_debug("List ID to subscribe to:" . $list_id, true);

    //Create the merge_vars data
    $merge_vars = array('FNAME' => $fname, 'LNAME' => $lname, 'INTERESTS' => '');
    
    $emember_config = Emember_Config::getInstance();
    $signup_date_field_name = $emember_config->getValue('eMember_mailchimp_signup_date_field_name');
    
    if(!empty($signup_date_field_name)){//Add the signup date
        eMember_log_debug("Signup date field name: " . $signup_date_field_name, true);
    	$todays_date = date ("Y-m-d");
    	$merge_vars[$signup_date_field_name] = $todays_date;
    }
    if(count($pieces)>2){//Add the interest groups data to the merge_vars
    	$group_data = array(array('name'=>$interest_group_name, 'groups'=>$interest_groups));
    	$merge_vars['GROUPINGS'] = $group_data;
    }
    
    if ($emember_config->getValue('eMember_mailchimp_disable_double_optin') != '') {
        eMember_log_debug("Subscribing to MailChimp without double opt-in... Name: " . $fname . " " . $lname . " Email: " . $email_to_subscribe, true);
        $send_welcome = true;
        if ($emember_config->getValue('eMember_mailchimp_disable_double_optin') != '') {
            $send_welcome = false;
            eMember_log_debug("Send welcome email option is disabled. Setting the send welcome flag to false.", true);
        }
        $retval = $api->listSubscribe($list_id, $email_to_subscribe, $merge_vars, "html", false, false, true, $send_welcome);
    } else {
        eMember_log_debug("Subscribing to MailChimp... Name: " . $fname . " " . $lname . " Email: " . $email_to_subscribe, true);
        $retval = $api->listSubscribe($list_id, $email_to_subscribe, $merge_vars);
    }

    if ($api->errorCode) {
        eMember_log_debug("Unable to load listSubscribe()!", false);
        eMember_log_debug("\tError Code=" . $api->errorCode, false);
        eMember_log_debug("\tError Msg=" . $api->errorMessage, false);
    } else {
        eMember_log_debug("MailChimp Signup was successful.", true);
    }
    return $retval;
}

function eMember_getResponse_subscribe($campaign_name, $fname, $lname, $email_to_subscribe) {
    eMember_log_debug('Attempting to call GetResponse API for list signup...', true);
    $emember_config = Emember_Config::getInstance();
    $api_key = $emember_config->getValue('eMember_getResponse_api_key');

    // API 2.x URL
    $api_url = 'http://api2.getresponse.com';
    $customer_name = $fname . " " . $lname;
    eMember_log_debug('API Key:' . $api_key . ', Customer name:' . $customer_name, true);
    // initialize JSON-RPC client
    include_once('lib/auto-responder/eMember_jsonRPCClient.php');
    $client = new eMember_jsonRPCClient($api_url);

    $result = NULL;

    eMember_log_debug('Attempting to retrieve campaigns for ' . $campaign_name, true);
    if (empty($campaign_name)) {
        eMember_log_debug('Getresponse campaign name is empty. This signup request will be ignored.', true);
        return;
    }
    $result = $client->get_campaigns(
            $api_key, array(
        # find by name literally
        'name' => array('EQUALS' => $campaign_name)
            )
    );

    # uncomment this line to preview data structure
    # print_r($result);
    # since there can be only one campaign of this name
    # first key is the CAMPAIGN_ID you need
    $CAMPAIGN_ID = array_pop(array_keys($result));
    eMember_log_debug("Attempting GetResponse add contact operation for campaign ID: " . $CAMPAIGN_ID . " Name: " . $customer_name . " Email: " . $email_to_subscribe, true);

    if (empty($CAMPAIGN_ID)) {
        eMember_log_debug("Could not retrieve campaign ID. Please double check your GetResponse Campaign Name:" . $campaign_name, false);
    } else {
        # add contact to the specified campaign
        try {
            $result = $client->add_contact(
                    $api_key, array(
                'campaign' => $CAMPAIGN_ID,
                'name' => $customer_name,
                'email' => $email_to_subscribe,
                'cycle_day' => '0'
                    )
            );
        } catch (Exception $e) {
            //eMember_log_debug_array($e,false);//Show this to see the details of the exception and failure
            eMember_log_debug("Getresponse add_contact operation failed for email: " . $email_to_subscribe, false);
            return false;
        }
    }
    # uncomment this line to preview data structure
    # print_r($result);
    eMember_log_debug("GetResponse contact added... result:" . $result, true);
    return true;
}

function eMember_generic_autoresponder_signup($firstname, $lastname, $emailaddress, $list_email_address) {
    eMember_log_debug('Preparing to send signup request email for generic autoresponder integration.', true);
    $from_address = $emailaddress; //Use customer email address as the from address for this email

    $subject = "Autoresponder Automatic Sign up email";
    $body = "\n\nThis is an automatic email that is sent to the autoresponder for user signup purpose\n" .
            "\nEmail: " . $emailaddress .
            "\nName: " . $firstname . " " . $lastname;


    $pos = strpos($from_address, "<");
    if ($pos !== false) {
        $from_address = eMember_get_string_between($from_address, "<", ">");
    }
    eMember_log_debug('Sending signup request email via WordPress mailing system. From email address value:' . $from_address, true);
    $headers = 'From: ' . $from_address . "\r\n";
    wp_mail($list_email_address, $subject, $body, $headers);
    eMember_log_debug('Signup email request successfully sent to:' . $list_email_address, true);
    return 1;
}

function eMember_level_specific_autoresponder_signup($membership_level_id, $firstname, $lastname, $emailaddress) {
    eMember_log_debug('Performing membership level specific autoresponder signup if specified.', true);
    $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $membership_level_id . "'");
    $list_name = trim($membership_level_resultset->campaign_name);
    // Autoresponder Sign up
    if (!empty($membership_level_resultset->campaign_name)) {
        $emember_config = Emember_Config::getInstance();
        eMember_log_debug('List name specified for this membership level is: ' . $list_name, true);
        if ($emember_config->getValue('eMember_enable_aweber_int') == 1) {
            $from_address = $emember_config->getValue('senders_email_address');
            $senders_email = eMember_get_string_between($from_address, "<", ">");
            if (empty($senders_email)) {
                $senders_email = $from_address;
            }
            $cust_name = $firstname . ' ' . $lastname;
            if ($emember_config->getValue('eMember_use_new_aweber_integration') == '1') {
                eMember_aweber_new_signup_user($list_name, $firstname, $lastname, $emailaddress);
            } else {
                eMember_log_debug('AWeber list to signup to:' . $list_name, true);
                eMember_send_aweber_mail($list_name, $senders_email, $cust_name, $emailaddress);
                eMember_log_debug('AWeber signup from email address used:' . $senders_email, true);
                eMember_log_debug('AWeber signup operation performed for:' . $emailaddress, true);
            }
        }
        if ($emember_config->getValue('eMember_use_mailchimp') == 1) {
            $api = eMember_get_chimp_api();
            eMember_log_debug('Mailchimp email address to signup:' . $emailaddress, true);
            eMember_log_debug('Mailchimp list to signup to:' . $list_name, true);
            $retval = eMember_mailchimp_subscribe($api, $list_name, $firstname, $lastname, $emailaddress);
            eMember_log_debug('Mailchimp signup operation performed. returned value:' . $retval, true);
        }
        if ($emember_config->getValue('eMember_use_getresponse') == 1) {
            eMember_log_debug('GetResponse email address to signup:' . $emailaddress, true);
            eMember_log_debug('GetResponse campaign to signup to:' . $list_name, true);
            $retval = eMember_getResponse_subscribe($list_name, $firstname, $lastname, $emailaddress);
            eMember_log_debug('GetResponse signup operation performed. returned value:' . $retval, true);
        }
        if ($emember_config->getValue('eMember_use_generic_autoresponder_integration') == '1') {
            eMember_log_debug('Generic autoresponder integration is being used.', true);
            $list_email_address = $list_name;
            $result = eMember_generic_autoresponder_signup($firstname, $lastname, $emailaddress, $list_email_address);
            eMember_log_debug('Generic autoresponder signup result: ' . $result, true);
        }
    }
    // API call for plugins extending the level specific autoresponder signup
    $signup_data = Array('firstname' => $firstname, 'lastname' => $lastname, 'email' => $emailaddress, 'list_name' => $list_name);
    do_action('emember_level_specific_autoresponder_signup', $signup_data);
    eMember_log_debug('End of membership level specific autoresponder signup.', true);
}

function eMember_global_autoresponder_signup($firstname, $lastname, $emailaddress) {
    eMember_log_debug('Performing global autoresponder signup if specified.', true);
    $emember_config = Emember_Config::getInstance();
    if ($emember_config->getValue('eMember_enable_aweber_int') == 1) {
        $list_name = trim($emember_config->getValue('eMember_aweber_list_name'));
        $from_address = $emember_config->getValue('senders_email_address');
        $senders_email = eMember_get_string_between($from_address, "<", ">");
        if (empty($senders_email)) {
            $senders_email = $from_address;
        }
        $cust_name = $firstname . ' ' . $lastname;
        if ($emember_config->getValue('eMember_use_new_aweber_integration') == '1') {
            eMember_aweber_new_signup_user($list_name, $firstname, $lastname, $emailaddress);
        } else {
            eMember_log_debug('AWeber list to signup to:' . $list_name, true);
            eMember_send_aweber_mail($list_name, $senders_email, $cust_name, $emailaddress);
            eMember_log_debug('AWeber signup from email address:' . $senders_email, true);
        }
        eMember_log_debug('AWeber signup operation performed for:' . $emailaddress, true);
    }
    if ($emember_config->getValue('eMember_use_mailchimp') == 1) {
        $api = eMember_get_chimp_api();
        $target_list_name = trim($emember_config->getValue('eMember_chimp_list_name'));
        eMember_log_debug('Mailchimp email address to signup:' . $emailaddress, true);
        eMember_log_debug('Mailchimp list to signup to:' . $target_list_name, true);
        $retval = eMember_mailchimp_subscribe($api, $target_list_name, $firstname, $lastname, $emailaddress);
        eMember_log_debug('Mailchimp signup operation performed. returned value:' . $retval, true);
    }
    if ($emember_config->getValue('eMember_use_getresponse') == 1) {
        $campaign_name = trim($emember_config->getValue('eMember_getResponse_campaign_name'));
        eMember_log_debug('GetResponse email address to signup:' . $emailaddress, true);
        eMember_log_debug('GetResponse campaign to signup to:' . $campaign_name, true);
        $retval = eMember_getResponse_subscribe($campaign_name, $firstname, $lastname, $emailaddress);
        eMember_log_debug('GetResponse signup operation performed. returned value:' . $retval, true);
    }
    if ($emember_config->getValue('eMember_use_global_generic_autoresponder_integration') == '1') {
        eMember_log_debug('Generic autoresponder integration is being used.', true);
        $list_email_address = trim($emember_config->getValue('eMember_generic_autoresponder_target_list_email'));
        $result = eMember_generic_autoresponder_signup($firstname, $lastname, $emailaddress, $list_email_address);
        eMember_log_debug('Generic autoresponder signup result: ' . $result, true);
    }

    // API call for plugins extending the global specific autoresponder signup
    $signup_data = Array('firstname' => $firstname, 'lastname' => $lastname, 'email' => $emailaddress);
    do_action('emember_global_autoresponder_signup', $signup_data);

    eMember_log_debug('End of global autoresponder signup.', true);
}
