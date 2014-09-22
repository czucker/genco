<?php

include_once('emember_scheduled_membership_upgrade.php');

function eMember_email_notifier_cronjob() {
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $s = $emember_config->getValue('eMember_email_notification');
    $alert_before = $emember_config->getValue('eMember_before_expiry_num_days');
    $alert_after  = $emember_config->getValue('eMember_after_expiry_num_days');
    $result_after = array();
    $result_before = array();
    if (empty($s)) {
        eMember_log_cronjob_debug('Auto expiry email notification feature is turned off. No auto expiry email will be sent.', true);
        return;
    }
    eMember_log_cronjob_debug('Auto expiry email notification feature is enabled. Checking user account expiry details...', true);
    $query = "SELECT id, subscription_period,subscription_unit FROM " .
            WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE . " WHERE id !=1 and subscription_unit !=''";
    $levels = $wpdb->get_results($query);
    if (is_array($levels)) {
        foreach ($levels as $level) {
            $alert_after = empty($alert_after)? 0 : intval($alert_after);
            $interval = 0;
            $subscript_period = $level->subscription_period;
            $subscript_unit = $level->subscription_unit;
            if (($subscript_period == 0) && !empty($subscript_unit)) { //will expire after a fixed date.
                eMember_log_cronjob_debug('Checking membership level: ' . $level->id . '. fixed date : ' . $subscript_unit, true);
                $query = "SELECT email FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME .
                        " WHERE DATE_ADD('" . $subscript_unit . "', INTERVAL " . $alert_after . " DAY) = CURDATE( )" .
                        " AND membership_level = " . $level->id;
                $result_after = $wpdb->get_results($query);

                if (!empty($alert_before) && (strtotime($subscript_unit) < time())) {
                    $query = "SELECT email FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME .
                            " WHERE date_sub( '" . $subscript_unit . "' , INTERVAL " .
                            $alert_before . " DAY ) = CURDATE( )" .
                            " AND membership_level = " . $level->id;
                    $result_before = $wpdb->get_results($query);
                }
            } else if ($subscript_period == '0') { // noexpire
                eMember_log_cronjob_debug('Checking membership level: ' . $level->id . '. No expiry.', true);
                continue;
            } else {
                switch ($subscript_unit) {
                    case 'Years':
                        $interval = $subscript_period * 365;
                        break;
                    case 'Months':
                        $interval = $subscript_period * 30;
                        break;
                    case 'weeks':
                        $interval = $subscript_period * 7;
                        break;
                    case 'Days':
                        $interval = $subscript_period;
                }
                if (!empty($interval)) {
                    eMember_log_cronjob_debug('Checking membership level: ' . $level->id . '. Interval value: ' . $interval, true);
                    $query = "SELECT email FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME .
                            " WHERE date_add( `subscription_starts` , INTERVAL " . ($interval + $alert_after) . " DAY ) = CURDATE( )" .
                            " AND membership_level = " . $level->id;
                    $result_after = $wpdb->get_results($query);
                    if (!empty($alert_before) && (($interval - $alert_before) > 0)) {
                        $query = "SELECT email FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME .
                                " WHERE date_add( `subscription_starts` , INTERVAL " .
                                ($interval - $alert_before) . " DAY ) = CURDATE( )" .
                                " AND membership_level = " . $level->id;
                        $result_before = $wpdb->get_results($query);
                    }
                }
            }
            if (!empty($result_after)) {
                eMember_log_cronjob_debug('The following users will receive the after expiry email notification', true);
                $email_list = array();
                foreach ($result_after as $row) {
                    $email_list[] = $row->email;
                    eMember_log_cronjob_debug($row->email, true);
                }
                $subject = $emember_config->getValue('eMember_after_expiry_email_subject');
                $body = $emember_config->getValue('eMember_after_expiry_email_body');
                $headers = 'From: ' . $emember_config->getValue('eMember_after_expiry_senders_email_address') . "\r\n";
                $headers .= 'bcc: ' . implode(',', $email_list) . "\r\n";
                wp_mail(array()/* $email_list */, $subject, $body, $headers);
            }

            if (!empty($result_before)) {
                eMember_log_cronjob_debug('The following users will receive the before expiry email notification', true);
                $email_list = array();
                foreach ($result_before as $row) {
                    $email_list[] = $row->email;
                    eMember_log_cronjob_debug($row->email, true);
                }
                $subject = $emember_config->getValue('eMember_before_expiry_email_subject');
                $body = $emember_config->getValue('eMember_before_expiry_email_body');
                $headers = 'From: ' . $emember_config->getValue('eMember_before_expiry_senders_email_address') . "\r\n";
                $headers .= 'bcc: ' . implode(',', $email_list) . "\r\n";
                wp_mail(array()/* $email_list */, $subject, $body, $headers);
            }
        }
    }
}
