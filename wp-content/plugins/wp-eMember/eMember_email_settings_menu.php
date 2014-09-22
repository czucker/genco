<?php

//include_once('eMember_db_access.php');
function wp_eMember_email_settings() {
    $emember_config = Emember_Config::getInstance();
    if (isset($_POST['info_update'])) {
        //update_option('senders_name', (string)$_POST["senders_name"]);
        $emember_config->setValue('senders_email_address', stripslashes((string) $_POST["senders_email_address"]));
        $emember_config->setValue('eMember_email_subject', stripslashes((string) $_POST["eMember_email_subject"]));
        $emember_config->setValue('eMember_email_body', stripslashes((string) $_POST["eMember_email_body"]));

        // For backwards compatibilty with eStore
        update_option('senders_email_address', stripslashes((string) $_POST["senders_email_address"]));
        update_option('eMember_email_subject', stripslashes((string) $_POST["eMember_email_subject"]));
        update_option('eMember_email_body', stripslashes((string) $_POST["eMember_email_body"]));

        $emember_config->setValue('eMember_email_subject_rego_complete', stripslashes((string) $_POST["eMember_email_subject_rego_complete"]));
        $emember_config->setValue('eMember_email_body_rego_complete', stripslashes((string) $_POST["eMember_email_body_rego_complete"]));
        $emember_config->setValue('eMember_admin_notification_after_registration', ($_POST['eMember_admin_notification_after_registration'] != '') ? 'checked="checked"' : '');
        $emember_config->setValue('eMember_admin_notification_email_address', trim((string) $_POST["eMember_admin_notification_email_address"]));
        $emember_config->setValue('eMember_email_notification_for_manual_member_add', ($_POST['eMember_email_notification_for_manual_member_add'] != '') ? 'checked="checked"' : '');
        //$emember_config->setValue('eMember_account_upgrade_senders_email_address',stripslashes((string)$_POST["eMember_account_upgrade_senders_email_address"]));
        $emember_config->setValue('eMember_account_upgrade_email_subject', stripslashes((string) $_POST["eMember_account_upgrade_email_subject"]));
        $emember_config->setValue('eMember_account_upgrade_email_body', stripslashes((string) $_POST["eMember_account_upgrade_email_body"]));

        $emember_config->setValue('eMember_fogot_pass_senders_email_address', stripslashes((string) $_POST["eMember_fogot_pass_senders_email_address"]));
        $emember_config->setValue('eMember_fogot_pass_email_subject', stripslashes((string) $_POST["eMember_fogot_pass_email_subject"]));
        $emember_config->setValue('eMember_fogot_pass_email_body', stripslashes((string) $_POST["eMember_fogot_pass_email_body"]));

        $emember_config->setValue('eMember_before_expiry_senders_email_address', stripslashes((string) $_POST["eMember_before_expiry_senders_email_address"]));
        $emember_config->setValue('eMember_before_expiry_email_subject', stripslashes((string) $_POST["eMember_before_expiry_email_subject"]));
        $emember_config->setValue('eMember_before_expiry_email_body', stripslashes((string) $_POST["eMember_before_expiry_email_body"]));

        $emember_num_days = $_POST["eMember_before_expiry_num_days"];
        $emember_num_days = (is_numeric($emember_num_days)) ? stripslashes((string) $_POST["eMember_before_expiry_num_days"]) : 10;
        $emember_config->setValue('eMember_before_expiry_num_days', $emember_num_days);

        $emember_config->setValue('eMember_after_expiry_senders_email_address', stripslashes((string) $_POST["eMember_after_expiry_senders_email_address"]));
        $emember_config->setValue('eMember_after_expiry_email_subject', stripslashes((string) $_POST["eMember_after_expiry_email_subject"]));
        $emember_config->setValue('eMember_after_expiry_email_body', stripslashes((string) $_POST["eMember_after_expiry_email_body"]));

        $emember_config->setValue('eMember_after_expiry_senders_email_address_followup', stripslashes((string) $_POST["eMember_after_expiry_senders_email_address_followup"]));
        $emember_config->setValue('eMember_after_expiry_email_subject_followup', stripslashes((string) $_POST["eMember_after_expiry_email_subject_followup"]));
        $emember_config->setValue('eMember_after_expiry_email_body_followup', stripslashes((string) $_POST["eMember_after_expiry_email_body_followup"]));
        $emember_num_days = (is_numeric($emember_num_days)) ? stripslashes((string) $_POST["eMember_after_expiry_num_days"]) : 30;
        $emember_config->setValue('eMember_after_expiry_num_days', $emember_num_days);
        //$emember_config->setValue('eMember_after_expiry_num_days_recurring',($_POST['eMember_after_expiry_num_days_recurring']!='') ? 'checked="checked"':'');

        $emember_config->setValue('eMember_autoupgrade_senders_email_address', stripslashes((string) $_POST["eMember_autoupgrade_senders_email_address"]));
        $emember_config->setValue('eMember_autoupgrade_email_subject', stripslashes((string) $_POST["eMember_autoupgrade_email_subject"]));
        $emember_config->setValue('eMember_autoupgrade_email_body', stripslashes((string) $_POST["eMember_autoupgrade_email_body"]));


        echo '<div id="message" class="updated fade"><p><strong>';
        echo 'Options Updated!';
        echo '</strong></p></div>';
        $emember_config->saveConfig();
    }
    //
    $eMember_fogot_pass_senders_email_address = $emember_config->getValue('eMember_fogot_pass_senders_email_address');
    if (empty($eMember_fogot_pass_senders_email_address)) {
        $eMember_fogot_pass_senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    }

    $eMember_fogot_pass_email_subject = $emember_config->getValue('eMember_fogot_pass_email_subject');

    if (empty($eMember_fogot_pass_email_subject)) {
        $eMember_fogot_pass_email_subject = EMEMBER_MEMBERSHIP_DETAILS_MAIL;
        $emember_config->setValue('eMember_fogot_pass_email_subject', $eMember_fogot_pass_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_fogot_pass_email_body = $emember_config->getValue('eMember_fogot_pass_email_body');
    if (empty($eMember_fogot_pass_email_body)) {
        $eMember_fogot_pass_email_body = "Dear {first_name} {last_name}" .
                "\n\nYou have reset your password." .
                "\n\nMembership details:" .
                "\nUsername: {user_name}" .
                "\nPassword: {password}" .
                "\n\nThank You";
        $emember_config->setValue('eMember_fogot_pass_email_body', $eMember_fogot_pass_email_body);
        $emember_config->saveConfig();
    }

    //
    $eMember_account_upgrade_email_subject = $emember_config->getValue('eMember_account_upgrade_email_subject');
    if (empty($eMember_account_upgrade_email_subject)) {
        $eMember_account_upgrade_email_subject = "Member Account Upgraded";
        $emember_config->setValue('eMember_account_upgrade_email_subject', $eMember_account_upgrade_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_account_upgrade_email_body = $emember_config->getValue('eMember_account_upgrade_email_body');
    if (empty($eMember_account_upgrade_email_body)) {
        $eMember_account_upgrade_email_body = "Your account has been upgraded successfully";
        $emember_config->setValue('eMember_account_upgrade_email_body', $eMember_account_upgrade_email_body);
        $emember_config->saveConfig();
    }

    //
    $senders_email_address = $emember_config->getValue('senders_email_address');
    if (empty($senders_email_address)) {
        $senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    }

    $eMember_email_subject = $emember_config->getValue('eMember_email_subject');

    if (empty($eMember_email_subject)) {
        $eMember_email_subject = "Complete your registration";
        $emember_config->setValue('eMember_email_subject', $eMember_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_email_body = $emember_config->getValue('eMember_email_body');
    if (empty($eMember_email_body)) {
        $eMember_email_body = "Dear {first_name} {last_name}" .
                "\n\nThank you for joining us!" .
                "\n\nPlease complete your registration by visiting the following link:" .
                "\n\n{reg_link}" .
                "\n\nThank You";
        $emember_config->setValue('eMember_email_body', $eMember_email_body);
        $emember_config->saveConfig();
    }
    $eMember_email_subject_rego_complete = $emember_config->getValue('eMember_email_subject_rego_complete');

    if (empty($eMember_email_subject_rego_complete)) {
        $eMember_email_subject_rego_complete = "Your registration is complete";
        $emember_config->setValue('eMember_email_subject_rego_complete', $eMember_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_email_body_rego_complete = $emember_config->getValue('eMember_email_body_rego_complete');

    if (empty($eMember_email_body_rego_complete)) {
        $eMember_email_body_rego_complete = "Dear {first_name} {last_name}" .
                "\n\nYour registration is now complete!" .
                "\n\nRegistration details:" .
                "\nUsername: {user_name}" .
                "\nPassword: {password}" .
                "\n\nPlease login to the member area at the following URL:" .
                "\n\n{login_link}" .
                "\n\nThank You";
        $emember_config->setValue('eMember_email_body_rego_complete', $eMember_email_body_rego_complete);
        $emember_config->saveConfig();
    }
    if ($emember_config->getValue('eMember_admin_notification_after_registration'))
        $eMember_admin_notification = 'checked="checked"';
    else
        $eMember_admin_notification = '';

    $eMember_admin_notification_email_address = $emember_config->getValue('eMember_admin_notification_email_address');

    if ($emember_config->getValue('eMember_email_notification_for_manual_member_add'))
        $eMember_email_notification_for_manual_member_add = 'checked="checked"';
    else
        $eMember_email_notification_for_manual_member_add = '';
    /*     * *** */
    //
    $eMember_after_expiry_senders_email_address = $emember_config->getValue('eMember_after_expiry_senders_email_address');
    if (empty($eMember_after_expiry_senders_email_address)) {
        $eMember_after_expiry_senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    }

    $eMember_after_expiry_email_subject = $emember_config->getValue('eMember_after_expiry_email_subject');

    if (empty($eMember_after_expiry_email_subject)) {
        $eMember_after_expiry_email_subject = EMEMBER_MEMBERSHIP_DETAILS_MAIL;
        $emember_config->setValue('eMember_fogot_pass_email_subject', $eMember_after_expiry_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_after_expiry_email_body = $emember_config->getValue('eMember_after_expiry_email_body');
    if (empty($eMember_after_expiry_email_body)) {
        $eMember_after_expiry_email_body = "Hi, Your membership account has expired." .
                "\n\nPlease renew your membership here:\n[Place a link to the page where your members can renew their membership]" .
                "\n\nThank You";
        $emember_config->setValue('eMember_after_expiry_email_body', $eMember_after_expiry_email_body);
        $emember_config->saveConfig();
    }

    $eMember_after_expiry_num_days = $emember_config->getValue('eMember_after_expiry_num_days');
    //$eMember_after_expiry_num_days_recurring = $emember_config->getValue('eMember_after_expiry_num_days_recurring');
    $eMember_after_expiry_senders_email_address_followup = $emember_config->getValue('eMember_after_expiry_senders_email_address_followup');
    $eMember_after_expiry_email_subject_followup = $emember_config->getValue('eMember_after_expiry_email_subject_followup');
    $eMember_after_expiry_email_body_followup = $emember_config->getValue('eMember_after_expiry_email_body_followup');

    $eMember_before_expiry_num_days = $emember_config->getValue('eMember_before_expiry_num_days');
    if (!is_numeric($eMember_before_expiry_num_days)) {
        $eMember_before_expiry_num_days = 10;
    }

    $eMember_before_expiry_senders_email_address = $emember_config->getValue('eMember_before_expiry_senders_email_address');
    if (empty($eMember_before_expiry_senders_email_address)) {
        $eMember_before_expiry_senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    }

    $eMember_before_expiry_email_subject = $emember_config->getValue('eMember_before_expiry_email_subject');

    if (empty($eMember_before_expiry_email_subject)) {
        $eMember_before_expiry_email_subject = EMEMBER_MEMBERSHIP_DETAILS_MAIL;
        $emember_config->setValue('eMember_before_expiry_email_subject', $eMember_before_expiry_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_before_expiry_email_body = $emember_config->getValue('eMember_before_expiry_email_body');
    if (empty($eMember_before_expiry_email_body)) {
        $eMember_before_expiry_email_body = "Hi, Your account will expire in 10 days." .
                "\n\nPlease renew your membership here:\n[Place a link to the page where your members can renew their membership]" .
                "\n\nThank You";
        $emember_config->setValue('eMember_before_expiry_email_body', $eMember_before_expiry_email_body);
        $emember_config->saveConfig();
    }

    //
    //
    $eMember_autoupgrade_senders_email_address = $emember_config->getValue('eMember_autoupgrade_senders_email_address');
    if (empty($eMember_autoupgrade_senders_email_address)) {
        $eMember_autoupgrade_senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    }

    $eMember_autoupgrade_email_subject = $emember_config->getValue('eMember_autoupgrade_email_subject');

    if (empty($eMember_autoupgrade_email_subject)) {
        $eMember_autoupgrade_email_subject = EMEMBER_MEMBERSHIP_DETAILS_MAIL;
        $emember_config->setValue('eMember_autoupgrade_email_subject', $eMember_autoupgrade_email_subject);
        $emember_config->saveConfig();
    }
    $eMember_autoupgrade_email_body = $emember_config->getValue('eMember_autoupgrade_email_body');
    if (empty($eMember_autoupgrade_email_body)) {
        $eMember_autoupgrade_email_body = "Hi, \nYour membership account has been upgraded.
                                                    \nPlease log into your member profile to view the details." .
                "\n\nThank You";
        $emember_config->setValue('eMember_autoupgrade_email_body', $eMember_autoupgrade_email_body);
        $emember_config->saveConfig();
    }

    //
    ?>
    <div class="eMember_grey_box">
        <p>For detailed documentation, information and updates, please visit the<a href="http://www.tipsandtricks-hq.com/wordpress-membership" target="_blank">WP eMember Documentation Page</a></p>
        <p>Like the plugin? Give us a <a href="http://www.tipsandtricks-hq.com/?p=1706#gfts_share" target="_blank">thumbs up here</a> by clicking on a share button or leave a comment to let us know.</p>
    </div>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <input type="hidden" name="info_update" id="info_update" value="true" />
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body">
                    <!-- <div class="basic" style="float:left;"  id="list1a"> -->
                    <!-- <div class="title"><label for="title">Email Settings (Prompt to Complete Registration)</label></div> -->
                    <div class="postbox">
                        <h3><label for="title">Email Settings (Prompt to Complete Registration)</label></h3>
                        <div class="inside">
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="senders_email_address" type="text" size="60" value="<?php echo $senders_email_address; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_email_subject" type="text" size="60" value="<?php echo $eMember_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_email_body" cols="60" rows="6"><?php echo $eMember_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the customer after they pay for a membership. Do not change the text within the braces {}</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="title"><label for="title">Email Settings (Registration Complete)</label></div> -->
                    <div class="postbox">
                        <h3><label for="title">Email Settings (Registration Complete)</label></h3>
                        <div class="inside">
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_email_subject_rego_complete" type="text" size="60" value="<?php echo $eMember_email_subject_rego_complete; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_email_body_rego_complete" cols="60" rows="6"><?php echo $eMember_email_body_rego_complete; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the customer after they complete the registration. Do not change the text within the braces {}</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Send Notification to Admin</td>
                                    <td align="left">
                                        <input type="checkbox" name="eMember_admin_notification_after_registration" value="1" <?php echo $eMember_admin_notification; ?> />
                                        Notification Email Address <input name="eMember_admin_notification_email_address" type="text" size="40" value="<?php echo $eMember_admin_notification_email_address; ?>"/>
                                        <br /><i>Check this box if you want to get notified via email when a new member registers.</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Send Email to Member When Added via Admin Dashboard</td>
                                    <td align="left">
                                        <input type="checkbox" name="eMember_email_notification_for_manual_member_add" value="1" <?php echo $eMember_email_notification_for_manual_member_add; ?> />
                                        <br /><i>Check this box if you want the newly created member to get notified via email when the member is added via the admin dashboard (Add Members Menu).</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="postbox">
                        <h3><label for="title">Email Settings ("Account Upgrade" notification)</label></h3>
                        <div class="inside">
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_account_upgrade_email_subject" type="text" size="60" value="<?php echo $eMember_account_upgrade_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_account_upgrade_email_body" cols="60" rows="6"><?php echo $eMember_account_upgrade_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the member after they upgrade their membership account.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="postbox">
                        <h3><label for="title">Email Settings ("Forgot Password" notification)</label></h3>
                        <div class="inside">
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="eMember_fogot_pass_senders_email_address" type="text" size="60" value="<?php echo $eMember_fogot_pass_senders_email_address; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_fogot_pass_email_subject" type="text" size="60" value="<?php echo $eMember_fogot_pass_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_fogot_pass_email_body" cols="60" rows="6"><?php echo $eMember_fogot_pass_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the customer after they reset their password.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="postbox">
                        <h3><label for="title">Email After the Account Gets Expired</label></h3>
                        <div class="inside">
                            <br /><strong>Enable the Auto Expiry Email Notification feature from the <a href="admin.php?page=eMember_settings_menu" target="_blank">Settings Page</a> if you want to use this feature</strong><br /><br />

                            <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                            <br /><strong>A member will get this email after the day his/her account is expired</strong>
                            <br /><br />

                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="eMember_after_expiry_senders_email_address" type="text" size="60" value="<?php echo $eMember_after_expiry_senders_email_address; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_after_expiry_email_subject" type="text" size="60" value="<?php echo $eMember_after_expiry_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_after_expiry_email_body" cols="60" rows="6"><?php echo $eMember_after_expiry_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the members after their account gets expired.</i><br /><br />
                                    </td>
                                </tr>
                            </table>

                            <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                            <br /><strong>A member will get this email X number of days after the account is expired (leave empty if you don't want to use it)</strong>
                            <br /><br />

                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">Send a Reminder After X Days of Account Expiry</td>
                                    <td align="left">
                                        <input name="eMember_after_expiry_num_days" type="text" size="60" value="<?php echo $eMember_after_expiry_num_days; ?>"/>
                                        <br /><i>Number of days after the account expiry when the reminder notification will be sent. Leave this field empty if you don't want to send this notification.</i>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="eMember_after_expiry_senders_email_address_followup" type="text" size="60" value="<?php echo $eMember_after_expiry_senders_email_address_followup; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_after_expiry_email_subject_followup" type="text" size="60" value="<?php echo $eMember_after_expiry_email_subject_followup; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_after_expiry_email_body_followup" cols="60" rows="6"><?php echo $eMember_after_expiry_email_body_followup; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the members after their account gets expired.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!--  -->
                    <!--  -->
                    <div class="postbox">
                        <h3><label for="title">Email Before the Account Expires (A member will get this email before the configurable amount of days)</label></h3>
                        <div class="inside">
                            <br /><strong>Enable the Auto Expiry Email Notification feature from the <a href="admin.php?page=eMember_settings_menu" target="_blank">Settings Page</a> if you want to use this feature</strong><br /><br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">Number of days before the account expiry when the reminder notification is sent (default: 10 days) </td>
                                    <td align="left">
                                        <input name="eMember_before_expiry_num_days" type="text" size="4" value="<?php echo $eMember_before_expiry_num_days; ?>"/> Days
                                        <br /><i>This notification will be disabled if you enter a value of 0.</i>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="eMember_before_expiry_senders_email_address" type="text" size="60" value="<?php echo $eMember_before_expiry_senders_email_address; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_before_expiry_email_subject" type="text" size="60" value="<?php echo $eMember_before_expiry_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_before_expiry_email_body" cols="60" rows="6"><?php echo $eMember_before_expiry_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the members before their account gets expired.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!--  -->
                    <div class="postbox">
                        <h3><label for="title">Email When User Account Gets Auto Upgraded</label></h3>
                        <div class="inside">
                            <br /><strong>This email will be sent to your members if you have the auto upgrade email notification enabled from the Auto Upgrade setup menu</strong><br /><br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">From Email Address</td>
                                    <td align="left">
                                        <input name="eMember_autoupgrade_senders_email_address" type="text" size="60" value="<?php echo $eMember_autoupgrade_senders_email_address; ?>"/>
                                        <br /><i>Sender's address (eg. admin@your-domain.com). You can enter the email in the following format to set the from name and from email in one go: <strong>Your Name &lt;youremail@example.com&gt;</strong></i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">Email Subject</td>
                                    <td align="left">
                                        <input name="eMember_autoupgrade_email_subject" type="text" size="60" value="<?php echo $eMember_autoupgrade_email_subject; ?>"/>
                                        <br /><i>The Email Subject</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">The Email Body</td>
                                    <td align="left">
                                        <textarea name="eMember_autoupgrade_email_body" cols="60" rows="6"><?php echo $eMember_autoupgrade_email_body; ?></textarea>
                                        <br /><i>This is the body of the email that will be sent to the members when their account gets upgraded.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="submit">
                        <input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        //jQuery(document).ready(function(){
        //	jQuery('#list1a').accordion({autoHeight:false});
        //});
    </script>
    <?php
}
?>
