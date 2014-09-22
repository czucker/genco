<?php

function wp_eMember_admin_functions_menu() {
    $emember_config = Emember_Config::getInstance();
    echo '<div class="wrap">';
    echo '<h2>WP eMember - Admin Functions v' . WP_EMEMBER_VERSION . '</h2>';
    echo eMember_admin_submenu_css();
    $current = (isset($_GET['tab'])) ? $_GET['tab'] : 1;
    ?>
    <h3 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo ($current == 1) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_admin_functions_menu">General Admin Functions</a>
        <a class="nav-tab <?php echo ($current == 2) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_admin_functions_menu&tab=2">Download Folder Protection</a>
        <a class="nav-tab <?php echo ($current == 3) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_admin_functions_menu&tab=3">Bulk Operation</a>
    </h3>
    <div id="poststuff"><div id="post-body">
            <div class="eMember_grey_box"><p>
                    These helpful admin functions allow you to do various manual admin stuff from time to time like generating a registration completion link for any customer who just paid for a membership, sending the link to a customer via email etc.
                </p></div>
            <?php
            switch ($current) {
                case '1':
                    wp_eMember_admin_functions_general_menu();
                    break;
                case '2':
                    include_once('eMember_folder_protection_settings.php');
                    eMember_folder_protection_settings_menu();
                    break;
                case '3':
                    include_once('emember-admin-functions-users-menu.php');
                    emember_admin_functions_users_menu();
                    break;
                default:
                    wp_eMember_admin_functions_general_menu();
                    break;
            }

            echo '</div></div>';
            echo '</div>';
        }

        function wp_eMember_admin_functions_general_menu() {
            $emember_config = Emember_Config::getInstance();
            if (isset($_POST['generate_registration_link'])) {
                $errorMsg = "";
                $eMember_member_id = (string) $_POST["eMember_member_id"];

                $member_record = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=\'' . $eMember_member_id . '\'');
                if ($member_record) {
                    $md5_code = md5($member_record->reg_code);
                    $separator = '?';
                    $url = get_option('eMember_registration_page');
                    if (empty($url)) {
                        $errorMsg .= "Error! You need to specify the registration URL in the pages/forms settings menu of this plugin.";
                    } else {
                        if (strpos($url, '?') !== false) {
                            $separator = '&';
                        }
                        $reg_url = $url . $separator . 'member_id=' . $eMember_member_id . '&code=' . $md5_code;
                    }
                } else {
                    $errorMsg .= "Error! Could not find the member ID in the database. Please double check the member ID value.";
                }

                $message = "";
                if (!empty($errorMsg)) {
                    $message = $errorMsg;
                } else {
                    $message = 'Registration Link Generated! Your customer can complete his/her membership registration by going to the generated link.';
                }
                echo '<div id="message" class="updated fade"><p><strong>';
                echo $message;
                echo '</strong></p></div>';
            }
            if (isset($_POST['generate_and_send_registration_link'])) {
                $errorMsg = "";
                $eMember_member_id = (string) $_POST["eMember_member_id"];

                $member_record = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=\'' . $eMember_member_id . '\'');
                if ($member_record) {
                    $md5_code = md5($member_record->reg_code);
                    $separator = '?';
                    $url = get_option('eMember_registration_page');
                    if (empty($url)) {
                        $errorMsg .= "<br />You need to specify the registration URL in the pages settings menu of this plugin.";
                    } else {
                        if (strpos($url, '?') !== false) {
                            $separator = '&';
                        }
                        $reg_url = $url . $separator . 'member_id=' . $eMember_member_id . '&code=' . $md5_code;
                    }

                    $email = $member_record->email;
                    $subject = get_option('eMember_email_subject');
                    $body = get_option('eMember_email_body');
                    $from_address = get_option('senders_email_address');
                    $tags = array("{first_name}", "{last_name}", "{reg_link}");
                    $vals = array($member_record->first_name, $member_record->last_name, $reg_url);
                    $email_body = str_replace($tags, $vals, $body);
                    $headers = 'From: ' . $from_address . "\r\n";
                    wp_mail($email, $subject, $email_body, $headers);
                } else {
                    $errorMsg .= "<br />Could not find the member ID in the database";
                }



                $message = "";
                if (!empty($errorMsg)) {
                    $message = $errorMsg;
                } else {
                    $message = "Member registration completion email successfully sent to:" . $email;
                }
                echo '<div id="message" class="updated fade"><p><strong>';
                echo $message;
                echo '</strong></p></div>';
            }
            if (isset($_POST['generate_and_send_registration_link_bulk'])) {
                $errorMsg = "";
                global $wpdb;
                $query = "SELECT member_id,reg_code,first_name,last_name FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . " WHERE user_name = ''";
                $member_records = $wpdb->get_results($query);
                if ($member_records) {
                    foreach ($member_records as $member_record) {
                        $md5_code = md5($member_record->reg_code);
                        $separator = '?';
                        $url = get_option('eMember_registration_page');
                        if (empty($url)) {
                            $errorMsg .= "<br />You need to specify the registration URL in the pages settings menu of this plugin.";
                            break;
                        } else {
                            if (strpos($url, '?') !== false)
                                $separator = '&';
                            $reg_url = $url . $separator . 'member_id=' . $member_record->member_id . '&code=' . $md5_code;
                        }

                        $email = $member_record->email;
                        $subject = get_option('eMember_email_subject');
                        $body = get_option('eMember_email_body');
                        $from_address = get_option('senders_email_address');
                        $tags = array("{first_name}", "{last_name}", "{reg_link}");
                        $vals = array($member_record->first_name, $member_record->last_name, $reg_url);
                        $email_body = str_replace($tags, $vals, $body);
                        $headers = 'From: ' . $from_address . "\r\n";
                        wp_mail($email, $subject, $email_body, $headers);
                    }
                }
                $message = "";
                if (!empty($errorMsg)) {
                    $message = $errorMsg;
                } else {
                    $message = "Member registration completion email successfully sent.";
                }
                echo '<div id="message" class="updated fade"><p><strong>';
                echo $message;
                echo '</strong></p></div>';
            }
            if (isset($_POST['emem_to_wp'])) {
                global $wpdb;
                $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
                $ret_member_db = $wpdb->get_results("SELECT * FROM $member_table ", OBJECT);
                foreach ($ret_member_db as $emember) {
                    $emember->user_name = trim($emember->user_name);
                    if (empty($emember->user_name))
                        continue;
                    if (strtolower($emember->user_name) === "admin")
                        continue;
                    if (!username_exists($emember->user_name)) {
                        $role_names = array(1 => 'Administrator', 2 => 'Editor', 3 => 'Author', 4 => 'Contributor', 5 => 'Subscriber');
                        $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $emember->membership_level . "'");
                        $wp_user_info = array();
                        $wp_user_info['user_nicename'] = implode('-', explode(' ', $emember->user_name));
                        $wp_user_info['display_name'] = $emember->user_name;
                        $wp_user_info['nickname'] = $emember->user_name;
                        $wp_user_info['first_name'] = $emember->first_name;
                        $wp_user_info['last_name'] = $emember->last_name;
                        $wp_user_info['role'] = $role_names[$membership_level_resultset->role];
                        $wp_user_info['user_registered'] = date('Y-m-d H:i:s');
                        //$wp_user_id = wp_create_user($emember->user_name, 'changeme', $emember->email);
                        $wp_user_id = eMember_wp_create_user($emember->user_name, 'changeme', $emember->email);
                        $wp_user_info['ID'] = $wp_user_id;
                        wp_update_user($wp_user_info);
                        //$wpdb->query("UPDATE  $wpdb->users set user_pass = \'" . $emember->password . '\' WHERE ID = ' . $wp_user_id);
                        $user_info = get_userdata($wp_user_id);
                        $user_cap = is_array($user_info->wp_capabilities) ? array_keys($user_info->wp_capabilities) : array();
                        if (!in_array('administrator', $user_cap)) {
                            update_wp_user_Role($wp_user_id, $membership_level_resultset->role);
                        }
                    }
                }
                echo '<div id="message" class="updated fade"><p>WordPress user account creation complete!</p></div>';
            }
            if (isset($_POST['emem_when_wp'])) {
                $emember_config->setValue('eMember_enable_emem_when_wp', $_POST['eMember_enable_emem_when_wp']);
                $emember_config->setValue('eMember_emem_when_wp_default_level', $_POST['eMember_emem_when_wp_default_level']);
                $emember_config->setValue('eMember_emem_when_wp_default_acstatus', $_POST['eMember_emem_when_wp_default_acstatus']);
                $emember_config->saveConfig();
                echo '<div id="message" class="updated fade"><p>Auto Member Account Creation Settings Saved!</p></div>';
            }
            if (isset($_POST['emember_management_permission_update'])) {
                $emember_config->setValue('emember_management_permission', $_POST['emember_management_permission']);
                $emember_config->saveConfig();
                echo '<div id="message" class="updated fade"><p><strong>';
                echo 'Management permission setting updated!';
                echo '</strong></p></div>';
            }
            ?>

            <div class="postbox">
                <h3><label for="title">Generate a Registration Completion link</label></h3>
                <div class="inside">
                    You can manually generate a registration completion link here and give it to your customer if they have missed the email that was automatically sent out to them after the payment.<br />
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

                        <table width="100%" border="0" cellspacing="0" cellpadding="6">
                            <tr valign="top"><td width="25%" align="right">
                                    <strong>Member ID: </strong>
                                </td><td align="left">
                                    <input name="eMember_member_id" type="text" size="5" value="<?php echo isset($eMember_member_id) ? $eMember_member_id : ""; ?>" />
                                    <br /><i>(i) Enter the member ID (you can get the member ID from the members menu).</i><br /><br />
                                </td></tr>

                            <tr valign="top"><td width="25%" align="right">
                                </td><td align="left">
                                    <input type="submit" name="generate_registration_link" value="<?php _e('Generate Link'); ?> &raquo;" />
                                    <br /><i>(ii) Hit the "Generate Link" button.</i><br /><br />
                                </td></tr>
                            <tr valign="top"><td width="25%" align="right">
                                    <strong>Registration Link: </strong>
                                </td><td align="left">
                                    <textarea name="wp_eStore_rego_link" rows="3" cols="80"><?php echo isset($reg_url) ? $reg_url : ""; ?></textarea>
                                    <br /><i>This is the registration completion link.</i><br />
                                </td></tr>
                        </table>
                    </form>
                </div></div>

            <div class="postbox">
                <h3><label for="title">Generate and Email the Registration Completion link</label></h3>
                <div class="inside">
                    You can generate a registration completion link and email it to your customer in one go. This can be useful if they have missed the email that was automatically sent out to them after the payment.<br />
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

                        <table width="100%" border="0" cellspacing="0" cellpadding="6">
                            <tr valign="top"><td width="25%" align="right">
                                    <strong>Member ID: </strong>
                                </td><td align="left">
                                    <input name="eMember_member_id" type="text" size="5" value="<?php echo isset($eMember_member_id) ? $eMember_member_id : ""; ?>" />
                                    <br /><i>(i) Enter the member ID (you can get the member ID from the members menu).</i><br /><br />
                                </td></tr>

                            <tr valign="top"><td width="25%" align="right">
                                </td><td align="left">
                                    <input type="submit" name="generate_and_send_registration_link" value="<?php _e('Generate & Email Link'); ?> &raquo;" />
                                    <br /><i>(ii) Hit the "Generate & Email Link" button.</i><br /><br />
                                </td></tr>

                        </table>
                    </form>
                </div></div>

            <div class="postbox">
                <h3><label for="title">Generate and Email the Registration Completion link (Bulk Mode)</label></h3>
                <div class="inside">

                    You can generate registration completion link and email it to all your members that are still waiting to complete the registration. This can be useful if they have missed the email that was automatically sent out to them after the payment.<br />
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <input type="submit" name="generate_and_send_registration_link_bulk" value="<?php _e('Generate & Email Link in Bulk'); ?> &raquo;" />
                        <br /><i>Hit the "Generate & Email Link in Bulk" button.</i><br /><br />
                    </form>
                </div></div>



            <div class="postbox">
                <h3><label for="title">Create WordPress User Account for the members that do not have one</label></h3>
                <div class="inside">
                    <strong>If you have a lot of eMember members that do not have a corresponding WordPress user account and for some reason you wanted to create WordPress user account for them then use this option.</strong>
                    <br /><br />
                    &raquo; When you use this option the plugin will create wordpress user accounts for every eMember user that does not have a corresponding WordPress account already.
                    <br />
                    &raquo; The WordPress user accounts will be created with the same details from eMember but the password will be set to "changeme" (The user will have to change the password to their liking).
                    <br />
                    &raquo; Why? The password is kept in the database using an one way encryption so nobody except the member knows what the real password is.
                    <br /><br />
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <input type="submit" name="emem_to_wp" value="<?php _e('Create WP account for eMember users'); ?> &raquo;" />
                    </form>
                </div></div>
            <div class="postbox">
                <h3><label for="title">Automatically Create eMember Account When a WordPress User Account is Created.</label></h3>
                <div class="inside">

                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <table width="100%" border="0" cellspacing="0" cellpadding="6">

                            <tr valign="top"><td width="25%" align="right">
                                    <strong>Enable this Feature: </strong>
                                </td><td align="left">
                                    <input name="eMember_enable_emem_when_wp" type="checkbox" <?php echo $emember_config->getValue('eMember_enable_emem_when_wp'); ?> value="checked='checked'" />
                                    <br /><i>When this feature is enabled, an eMember account will be created for every WP User account that gets created on this site.</i><br />
                                </td></tr>

                            <tr valign="top"><td width="25%" align="right"><strong>Default Membership Level: </strong></td>
                                <td align="left">
                                    <select name="eMember_emem_when_wp_default_level">
                                        <?php
                                        $all_levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
                                        $selected_level = $emember_config->getValue('eMember_emem_when_wp_default_level');
                                        $selected_acstatus = $emember_config->getValue('eMember_emem_when_wp_default_acstatus');
                                        foreach ($all_levels as $level):
                                            ?>
                                            <option <?php echo ($selected_level == $level->id) ? "selected='selected'" : ""; ?> value="<?php echo $level->id ?>"><?php echo $level->alias; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br /><i>When automatically creating a member account in the background, the membership level will be set to the one you specify above.</i>
                                </td></tr>

                            <tr valign="top"><td width="25%" align="right"><strong>Default Account Status: </strong></td>
                                <td align="left">
                                    <select name="eMember_emem_when_wp_default_acstatus">
                                        <option <?php echo ($selected_acstatus == 'active') ? "selected='selected'" : ""; ?> value="active">Active</option>
                                        <option <?php echo ($selected_acstatus == 'inactive') ? "selected='selected'" : ""; ?> value="inactive">Inactive</option>
                                        <option <?php echo ($selected_acstatus == 'pending') ? "selected='selected'" : ""; ?> value="pending">Pending</option>
                                        <option <?php echo ($selected_acstatus == 'expired') ? "selected='selected'" : ""; ?> value="expired">Expired</option>
                                    </select>
                                    <br /><i>The account status will be set to the one specified above.</i>
                                </td></tr>
                        </table>
                        <input type="submit" name="emem_when_wp" value="Save Settings &raquo;" />
                    </form>
                </div></div>

            <div class="postbox">
                <h3><label for="title">eMember Admin Dashboard Access Permission</label></h3>
                <div class="inside">
                    <p>
                        eMember's admin dashboard is accessible to admin users only (just like any other plugin).
                        You can allow users with other WP role to access the eMember admin dashboard by selecting a value below.
                        <br /><br />
                        <strong>If don't know what this is for then don't change the following value.</strong>
                    </p>
                    <?php
                    $selected_permission = $emember_config->getValue('emember_management_permission');
                    ?>
                    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                        <select name="emember_management_permission">
                            <option <?php echo ($selected_permission == 'edit_themes') ? "selected='selected'" : ""; ?> value="edit_themes">Admin</option>
                            <option <?php echo ($selected_permission == 'edit_pages') ? "selected='selected'" : ""; ?> value="edit_pages">Editor</option>
                            <option <?php echo ($selected_permission == 'edit_published_posts') ? "selected='selected'" : ""; ?> value="edit_published_posts">Author</option>
                            <option <?php echo ($selected_permission == 'edit_posts') ? "selected='selected'" : ""; ?> value="edit_posts">Contributor</option>
                        </select>
                        <input type="submit" name="emember_management_permission_update" value="Save Permission &raquo" />
                    </form>
                </div></div>
            <?php
        }
