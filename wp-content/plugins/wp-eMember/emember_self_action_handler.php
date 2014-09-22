<?php

/* Hanldes do_action and filter hooks that eMember uses itself */

add_action('emember_membership_changed','emember_handle_membership_level_upgraded_action');
add_action('emember_membership_cancelled','emember_handle_level_cancelled_action');

function emember_handle_membership_level_upgraded_action($args)
{
    $member_id = $args['member_id'];
    $old_level = $args['from_level'];
    $new_level = $args['to_level'];
    
    //Find record for this user
    eMember_log_debug('emember_membership_changed action hook handler. Retrieving user record for member ID: '.$member_id, true);
    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . $member_id);
    if($resultset){
        $firstname = $resultset->first_name;
        $lastname = $resultset->last_name;
        $emailaddress  = $resultset->email;
        eMember_log_debug('emember_membership_changed action hook handler. Found a member record... invoking level specific autoresponder signup functionality.', true);
        eMember_level_specific_autoresponder_signup($new_level, $firstname, $lastname, $emailaddress);
    }
}

function emember_handle_level_cancelled_action($args)
{
    $member_id = $args['member_id'];
    $level = $args['level'];

    //Find record for this user
    eMember_log_debug('emember_membership_cancelled action hook handler. Retrieving membership level record for member ID: '.$member_id, true);
    $ml_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $level . "'");
    $list_name = trim($ml_resultset->campaign_name);
    eMember_log_debug('List name for this membership level: '.$list_name, true);
    if(!empty($list_name)){
        //This level has a list name associated so need to do autoresponder cancellation.
        //TODO
    } 
}