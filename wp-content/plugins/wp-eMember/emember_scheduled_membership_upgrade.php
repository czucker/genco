<?php

//include_once('class.emember_meta.php');
function wp_eMember_scheduled_membership_upgrade() {
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $wpememmeta = new WPEmemberMeta();
    $membership_tbl = $wpememmeta->get_table('membership_level');
    $members_tbl = $wpememmeta->get_table('member');
    $email_list = array();
    $emails_for_followup_notification = array();

    $query_start = 0;
    $query_limit = 500;
    $iterations = 0;
    $membership_levels = Emember_Level_Collection::get_instance();
    while (1) {
        $query = 'SELECT member_id,membership_level,email,subscription_starts,account_state, '
                . 'more_membership_levels, expiry_1st, expiry_2nd FROM '
                . $members_tbl . ' WHERE account_state="active"  LIMIT ' . $query_start . ', ' . $query_limit;
        $members = $wpdb->get_results($query, OBJECT);
        if (count($members) < 1)
            break;
        foreach ($members as $member) {
            if (empty($member->subscription_starts))
                continue;
            $should_update_db = false;
            $level_info = array();
            $my_level = $membership_levels->get_levels($member->membership_level);
            $options = unserialize($my_level->get('options'));
            $current_level = $member->membership_level;
            $more_levels = $member->more_membership_levels;
            $more_levels = is_array($more_levels) ? array_filter($more_levels) : $more_levels;
            $sec_levels = explode(',', $more_levels);
            $level_info['membership_level'] = $current_level;
            $level_info['account_state'] = $member->account_state;//Initialize the account state with the current data

            $level_data_modified = false;
            if (isset($options['promoted_level_id']) && (!empty($options['promoted_level_id'])) && ($options['promoted_level_id'] != -1)) {
                $current_subscription_starts = strtotime($member->subscription_starts);
                $current_time = time();
                while (1) {
                    if ($current_level === $options['promoted_level_id'])
                        break;
                    $promoted_after = trim($options['days_after']);
                    if (empty($promoted_after))
                        break;

                    $d = ($promoted_after == 1) ? ' day' : ' days';
                    $expires = strtotime(" + " . abs($promoted_after) . $d, $current_subscription_starts);
                    if ($expires > $current_time)
                        break;
                    if (!isset($options['promoted_level_id']) || empty($options['promoted_level_id']) || ($options['promoted_level_id'] == -1))
                        break;
                    $sec_levels[] = $current_level;
                    $current_level = $options['promoted_level_id'];
                    $my_level = $membership_levels->get_levels($current_level); //
                    $options = unserialize($my_level->get('options'));
                }
                if (($current_level != -1) && (!empty($current_level)) && ($member->membership_level != $current_level)) {
                    $level_info ['membership_level'] = $current_level;
                    $level_data_modified = true;
                    if ($emember_config->getValue('eMember_enable_secondary_membership')) {
                        $level_info['more_membership_levels'] = array_unique($sec_levels);
                    }
                }
            }

            if (wp_emember_is_subscription_expired($member, $my_level)) {
                $level_info['account_state'] = 'expired';
                $level_data_modified = true;
                $sec = $emember_config->getValue('eMember_enable_secondary_membership');
                $migrate = $emember_config->getValue('eMember_secondary_membership_migrate');
                if ($sec && $migrate) {
                    foreach ($sec_levels as $key => $level) {
                        if (empty($level))
                            continue;
                        if (wp_emember_is_subscription_expired($member, $membership_levels->get_levels($level)))
                            continue;
                        $sec_levels[$key] = $level_info ['membership_level'];
                        $level_info['membership_level'] = $level;
                        $level_info['account_state'] = 'active';
                        $level_info['more_membership_levels'] = array_unique($sec_levels);
                        break;
                    }
                }
            }

            /*** notification after x day of account expiry ***/
            if (isset($level_info['account_state']) && ($level_info['account_state'] == 'expired')) {
                $is_auto_email = $emember_config->getValue('eMember_email_notification');
                $notification_interval = $emember_config->getValue('eMember_after_expiry_num_days');
                //$is_recurring = $emember_config->getValue('eMember_after_expiry_num_days_recurring');
                if (!empty($is_auto_email) && !empty($notification_interval)) {
                    $current_mem_level = $membership_levels->get_levels($level_info['membership_level']);
                    $days_elapsed = wp_emember_num_days_since_expired($current_mem_level->get('subscription_period'), $current_mem_level->get('subscription_unit'), $member->get('subscription_starts'));
                    if (($days_elapsed == $notification_interval))
                        $emails_for_followup_notification[] = $member->email;
                }
            }

            /*** Auto upgrade ***/
            if ($level_data_modified) {
                eMember_log_cronjob_debug('Auto upgrading the member account with member ID: ' . $member->member_id . ' Level: ' . $level_info['membership_level'], true);
                eMember_log_cronjob_debug('Users account state: ' . $level_info['account_state'], true);
                $email_list[] = $member->email;
                if (isset($level_info['more_membership_levels'])) {
                    $level_info['more_membership_levels'] = implode(',', $level_info['more_membership_levels']);
                }
                if (!empty($level_info))
                    dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id=' . $member->member_id, $level_info);
                do_action('emember_membership_changed', array('member_id' => $member->member_id,
                    'from_level' => $member->membership_level,
                    'to_level' => $level_info['membership_level']));
            }
        }
        $query_start = $query_limit * ( ++$iterations) + 1;
    }
    //Handle auto upgrade notification if needed
    if ($emember_config->getValue('eMember_enable_autoupgrade_notification')) {
        eMember_log_cronjob_debug('Using auto upgrade notification email option.. need to check the email list.', true);
        if (!empty($email_list)) {
            $subject = $emember_config->getValue('eMember_autoupgrade_email_subject');
            eMember_log_cronjob_debug('Sending auto upgrade notification email with subject: ' . $subject, true);
            $body = $emember_config->getValue('eMember_autoupgrade_email_body');
            $headers = 'From: ' . $emember_config->getValue('eMember_autoupgrade_senders_email_address') . "\r\n";
            $headers .= 'bcc: ' . implode(',', $email_list) . "\r\n";
            eMember_log_cronjob_debug($headers, true);
            wp_mail(array()/* $email_list */, $subject, $body, $headers);
            eMember_log_cronjob_debug('Auto upgrade notification email sent.', true);
        }
    }

    // Handle notification email after X days if needed
    if (!empty($emails_for_followup_notification)) {
        $subject = $emember_config->getValue('eMember_after_expiry_email_subject_followup');
        eMember_log_cronjob_debug('Sending expiry notification email after X days with subject: ' . $subject, true);
        $body = $emember_config->getValue('eMember_after_expiry_email_body_followup');
        $headers = 'From: ' . $emember_config->getValue('eMember_after_expiry_senders_email_address_followup') . "\r\n";
        $headers .= 'bcc: ' . implode(',', $emails_for_followup_notification) . "\r\n";
        eMember_log_cronjob_debug($headers, true);
        wp_mail(array()/* $email_list */, $subject, $body, $headers);
        eMember_log_cronjob_debug('Expiry notification email sent.', true);
    }
    //mail
}
