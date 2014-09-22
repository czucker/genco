<?php

function filter_eMember_edit_profile_form($content) {
    $auth = Emember_Auth::getInstance();
    $pattern = '#\[wp_eMember_profile_edit_form:end]#';
    preg_match_all($pattern, $content, $matches);
    if ((count($matches[0]) > 0) && !$auth->isLoggedIn()) {
        return EMEMBER_PROFILE_MESSAGE;
    }

    foreach ($matches[0] as $match) {
        $replacement = print_eMember_edit_profile_form();
        $content = str_replace($match, $replacement, $content);
    }

    return $content;
}

function print_eMember_edit_profile_form() {
    return show_edit_profile_form();
}

function show_edit_profile_form() {
    $result = apply_filters('emember_profile_form_override', '');
    if (!empty($result))
        return $result;
    $emember_auth = Emember_Auth::getInstance();
    if (!$emember_auth->isLoggedIn())
        return EMEMBER_PROFILE_MESSAGE;
    if (isset($_POST['eMember_update_profile']) && isset($_POST['eMember_profile_update_result'])) {
        $output = $_POST['eMember_profile_update_result'];
        if (!empty($_POST['wp_emember_pwd'])) {//Password has been changed
            $output .= '<div class="emember_warning">' . EMEMBER_PASSWORD_CHANGED_RELOG_RECOMMENDED . '</div>';
        }
        return $output;
    }
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $d = WP_EMEMBER_URL . '/images/default_image.gif';
    $member_id = $emember_auth->getUserInfo('member_id');
    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . esc_sql($member_id));
    $edit_custom_fields = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, ' user_id=' . esc_sql($member_id) . ' AND meta_key=\'custom_field\'');
    $edit_custom_fields = unserialize($edit_custom_fields->meta_value);
    $title = $resultset->title;
    $username = $resultset->user_name;
    $first_name = $resultset->first_name;
    $last_name = $resultset->last_name;
    $phone = $resultset->phone;
    $email = $resultset->email;
    $password = $resultset->password;
    $address_street = $resultset->address_street;
    $address_city = $resultset->address_city;
    $address_state = $resultset->address_state;
    $address_zipcode = $resultset->address_zipcode;
    $country = $resultset->country;
    $gender = $resultset->gender;
    $company = $resultset->company_name;
    $image_url = null;
    $image_path = null;
    $upload_dir = wp_upload_dir();
    $upload_url = $upload_dir['baseurl'] . '/emember/';
    $pro_pic = $emember_auth->getUserInfo('profile_image');
    $use_gravatar = $emember_config->getValue('eMember_use_gravatar');
    if ($use_gravatar)
        $image_url = WP_EMEMBER_GRAVATAR_URL . "/" . md5(strtolower($email)) . "?d=" . urlencode($d) . "&s=" . 96;
    else if (!empty($pro_pic)) {
        $image_url = $upload_url . $pro_pic . '?' . time();
        $pro_pic = $member_id;
    } else
        $image_url = WP_EMEMBER_URL . '/images/default_image.gif';

    $f = $emember_config->getValue('eMember_allow_account_removal');
    $delete_button = empty($f) ? '' : '<a id="delete_account_btn" href="' . get_bloginfo('wpurl') .
            '?event=delete_account" >' . EMEMBER_DELETE_ACC . '</a> ';
    ob_start();
    echo isset($msg) ? '<span class="emember_error">' . $msg . '</span>' : '';
    ?>
    <script type="text/javascript" src="<?php echo site_url(); ?>?emember_load_js=profile&id=wp_emember_profileUpdateForm"></script>
    <form action="" method="post" name="wp_emember_profileUpdateForm" id="wp_emember_profileUpdateForm" >
        <input type="hidden" name="member_id" id="member_id" value ="<?php echo $member_id; ?>" />
        <?php wp_nonce_field('emember-update-profile-nonce'); ?>
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
            <?php if ($emember_config->getValue('eMember_edit_title')): ?>
                <tr>
                    <td width="30%"><label for="atitle" class="eMember_label"><?php echo EMEMBER_TITLE; ?>: </label></td>
                    <td>
                        <select name="wp_emember_title">
                            <option  <?php echo $title === 'not specified' ? 'selected=\'selected\'' : '' ?> value="not specified"><?php echo EMEMBER_GENDER_UNSPECIFIED ?></option>
                            <option <?php echo $title === 'Mr' ? 'selected=\'selected\'' : '' ?> value="Mr"><?php echo EMEMBER_MR; ?></option>
                            <option <?php echo $title === 'Mrs' ? 'selected=\'selected\'' : '' ?> value="Mrs"><?php echo EMEMBER_MRS; ?></option>
                            <option <?php echo $title === 'Miss' ? 'selected=\'selected\'' : '' ?> value="Miss"><?php echo EMEMBER_MISS; ?></option>
                            <option <?php echo $title === 'Ms' ? 'selected=\'selected\'' : '' ?> value="Ms"><?php echo EMEMBER_MS; ?></option>
                            <option <?php echo $title === 'Dr' ? 'selected=\'selected\'' : '' ?> value="Dr"><?php echo EMEMBER_DR; ?></option>
                        </select>

                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <td><label class="eMember_label"> <?php echo EMEMBER_USERNAME; ?>: </label></td>
                <td><label class="eMember_highlight"><?php echo $username; ?></label></td>
            </tr>
            <?php if ($emember_config->getValue('eMember_profile_thumbnail')): ?>
                <tr>
                    <td><label class="eMember_label"><?php echo EMEMBER_PROFILE_IMAGE; ?>: </label></td>
                    <td>
                        <div>
                            <div>
                                <img id="emem_profile_image" src="<?php echo $image_url; ?>"  width="100px" height="100px"/>
                            </div>
                            <?php if (empty($use_gravatar)): ?>
                                <div id="emember-file-uploader">
                                    <noscript>
                                    <p>Please enable JavaScript to use file uploader.</p>
                                    <!-- or put a simple form for upload here -->
                                    </noscript>
                                </div>
                                <div id="emember-profile-remove-cont"  class="qq-remove-file" style="display:none;">
                                    <a id="remove_button" href="<?php echo $pro_pic; ?>"><?php echo EMEMBER_REMOVE; ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_firstname')): ?>
                <tr>
                    <td><label for="wp_emember_firstname" class="eMember_label"><?php echo EMEMBER_FIRST_NAME; ?>: </label></td>
                    <td><input type="text" id="wp_emember_firstname" name="wp_emember_firstname" size="20" value="<?php echo $first_name; ?>" class="<?php echo $emember_config->getValue('eMember_edit_firstname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_lastname')): ?>
                <tr>
                    <td><label for="wp_emember_lastname" class="eMember_label"><?php echo EMEMBER_LAST_NAME; ?>: </label></td>
                    <td><input type="text" id="wp_emember_lastname"  name="wp_emember_lastname" size="20" value="<?php echo $last_name; ?>" class="<?php echo $emember_config->getValue('eMember_edit_lastname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_company')): ?>
                <tr>
                    <td><label for="wp_emember_company_name" class="eMember_label"><?php echo EMEMBER_COMPANY ?>: </label></td>
                    <td><input type="text" id="wp_emember_company_name"  name="wp_emember_company_name" size="20" value="<?php echo $company ?>" class="<?php echo $emember_config->getValue('eMember_edit_company_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_email')): ?>
                <tr>
                    <td><label for="wp_emember_email" class="eMember_label"><?php echo EMEMBER_EMAIL; ?>: </label></td>
                    <td><input type="text" id="wp_emember_email" name="wp_emember_email" size="20" value="<?php echo $email; ?>" class="validate[<?php echo $emember_config->getValue('eMember_edit_email_required') ? 'required,' : ""; ?>custom[email]] eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_phone')): ?>
                <tr>
                    <td><label for="wp_emember_phone" class="eMember_label"><?php echo EMEMBER_PHONE ?>: </label></td>
                    <td><input type="text" id="wp_emember_phone" name="wp_emember_phone" size="20" value="<?php echo $phone ?>" class="<?php echo $emember_config->getValue('eMember_edit_phone_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <tr class="emember_pwd_row">
                <td><label for="wp_emember_pwd" class="eMember_label"><?php echo EMEMBER_PASSWORD ?>: </label></td>
                <td><input type="password" id="wp_emember_pwd" name="wp_emember_pwd" size="20" value="" class="eMember_text_input" /><br/></td>
            </tr>
            <tr class="emember_retype_pwd_row">
                <td><label for="wp_emember_pwd_r" class="eMember_label"><?php echo EMEMBER_PASSWORD_REPEAT ?>: </label></td>
                <td><input type="password" id="wp_emember_pwd_r" name="wp_emember_pwd_r" size="20" value="" class="validate[equals[wp_emember_pwd]] eMember_text_input" /><br/></td>
            </tr>
            <?php if ($emember_config->getValue('eMember_edit_street')): ?>
                <tr>
                    <td><label for="wp_emember_street" class="eMember_label"><?php echo EMEMBER_ADDRESS_STREET ?>: </label></td>
                    <td><input type="text" id="wp_emember_street" name="wp_emember_street" size="20" value="<?php echo $address_street ?>" class="<?php echo $emember_config->getValue('eMember_edit_street_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_city')): ?>
                <tr>
                    <td><label for="wp_emember_city" class="eMember_label"><?php echo EMEMBER_ADDRESS_CITY ?>: </label></td>
                    <td><input type="text" id="wp_emember_city" name="wp_emember_city" size="20" value="<?php echo $address_city ?>" class="<?php echo $emember_config->getValue('eMember_edit_city_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_state')): ?>
                <tr>
                    <td><label for="wp_emember_state" class="eMember_label"><?php echo EMEMBER_ADDRESS_STATE ?>: </label></td>
                    <td><input type="text"  id="wp_emember_status" name="wp_emember_state" size="20" value="<?php echo $address_state ?>" class="<?php echo $emember_config->getValue('eMember_edit_state_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_zipcode')): ?>
                <tr>
                    <td><label for="wp_emember_zipcode" class="eMember_label"><?php echo EMEMBER_ADDRESS_ZIP ?>: </label></td>
                    <td><input type="text"  id="wp_emember_zipcode" name="wp_emember_zipcode" size="20" value="<?php echo $address_zipcode ?>" class="<?php echo $emember_config->getValue('eMember_edit_zipcode_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_country')): ?>

                <tr>
                    <td><label for="wp_emember_country" class="eMember_label"><?php echo EMEMBER_ADDRESS_COUNTRY ?>: </label></td>
                    <td>

                        <select name="wp_emember_country" id="wp_emember_country" class="<?php echo $emember_config->getValue('eMember_edit_country_required') ? 'validate[required] ' : ""; ?>eMember_text_input" >
                            <?php echo emember_country_list_dropdown(stripslashes($country)); ?>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_gender')): ?>
                <tr >
                    <td > <label for="wp_emember_gender" class="eMember_label"><?php echo EMEMBER_GENDER ?>: </label></td>
                    <td>
                        <select name="wp_emember_gender" id="wp_emember_gender">
                            <option  <?php echo (($gender === 'male') ? 'selected=\'selected\'' : '' ) ?> value="male"><?php echo EMEMBER_GENDER_MALE ?></option>
                            <option  <?php echo (($gender === 'female') ? 'selected=\'selected\'' : '' ) ?> value="female"><?php echo EMEMBER_GENDER_FEMALE ?></option>
                            <option  <?php echo (($gender === 'not specified') ? 'selected=\'selected\'' : '' ) ?> value="not specified"><?php echo EMEMBER_GENDER_UNSPECIFIED ?></option>
                        </select>
                    </td>
                </tr>
                <?php
            endif;
            include ('custom_field_template.php');
            ?>
            <tr>
                <td >
                    <?php echo $delete_button ?>
                </td>
                <td>
                    <input class="eMember_button" name="eMember_update_profile" type="submit" id="eMember_update_profile" value="<?php echo EMEMBER_UPDATE ?>" />
                </td>
            </tr>
        </table>
    </form><br />
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function emember_update_profile_init() {
    if (isset($_POST['eMember_update_profile'])) {
        $nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($nonce, 'emember-update-profile-nonce')) {
            eMember_log_debug("Profile update nonce check failed ", true);
            die("Security check failed on profile update");
        }
        global $wpdb;
        $emember_config = Emember_Config::getInstance();
        include_once(ABSPATH . WPINC . '/class-phpass.php');

        $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' .
                        esc_sql($_POST['member_id']));
        $wp_user_id = username_exists($resultset->user_name);
        $updatable = true;
        if (isset($_POST['wp_emember_email'])) {
            $emmber_email_owner = emember_email_exists($_POST['wp_emember_email']);
            $wp_email_owner = email_exists($_POST['wp_emember_email']);
            if (!is_email($_POST['wp_emember_email'])) {
                $_POST['eMember_profile_update_result'] = EMEMBER_EMAIL_INVALID;
                $updatable = false;
            } else if (($wp_email_owner && ($wp_email_owner != $wp_user_id)) || ($emmber_email_owner && ($emmber_email_owner != $_POST['member_id']))) {
                $_POST['eMember_profile_update_result'] = '<span class="emember_error">' . EMEMBER_EMAIL_UNAVAIL . ' </span>';
                $updatable = false;
            }
        }
        if (($_POST['wp_emember_pwd'] != $_POST['wp_emember_pwd_r'])) {
            $_POST['eMember_profile_update_result'] = '<span class="emember_error">' . EMEMBER_PASSWORD_MISMATCH . '</span>';
            $updatable = false;
        }

        if ($updatable) {
            $wp_hasher = new PasswordHash(8, TRUE);
            $fields = array();
            if (isset($_POST['wp_emember_title']))
                $fields['title'] = strip_tags($_POST['wp_emember_title']);
            if (isset($_POST['wp_emember_firstname']))
                $fields['first_name'] = strip_tags($_POST['wp_emember_firstname']);
            if (isset($_POST['wp_emember_lastname']))
                $fields['last_name'] = strip_tags($_POST['wp_emember_lastname']);
            if (isset($_POST['wp_emember_email']))
                $fields['email'] = strip_tags($_POST['wp_emember_email']);
            if (isset($_POST['wp_emember_phone']))
                $fields['phone'] = strip_tags($_POST['wp_emember_phone']);
            if (isset($_POST['wp_emember_street']))
                $fields['address_street'] = strip_tags($_POST['wp_emember_street']);
            if (isset($_POST['wp_emember_city']))
                $fields['address_city'] = strip_tags($_POST['wp_emember_city']);
            if (isset($_POST['wp_emember_state']))
                $fields['address_state'] = strip_tags($_POST['wp_emember_state']);
            if (isset($_POST['wp_emember_zipcode']))
                $fields['address_zipcode'] = strip_tags($_POST['wp_emember_zipcode']);
            if (isset($_POST['wp_emember_country']))
                $fields['country'] = strip_tags($_POST['wp_emember_country']);
            if (isset($_POST['wp_emember_gender']))
                $fields['gender'] = strip_tags($_POST['wp_emember_gender']);
            if (isset($_POST['wp_emember_company_name']))
                $fields['company_name'] = strip_tags($_POST['wp_emember_company_name']);
            if (!empty($_POST['wp_emember_pwd'])) {
                $password = $wp_hasher->HashPassword(strip_tags($_POST['wp_emember_pwd']));
                $fields['password'] = $password;
            }

            if ($wp_user_id) {
                $wp_user_info = array();
                $wp_user_info['first_name'] = strip_tags(isset($_POST['wp_emember_firstname']) ? $_POST['wp_emember_firstname'] : "");
                $wp_user_info['last_name'] = strip_tags(isset($_POST['wp_emember_lastname']) ? $_POST['wp_emember_lastname'] : "");
                $wp_user_info['user_email'] = strip_tags(isset($_POST['wp_emember_email']) ? $_POST['wp_emember_email'] : "");
                $wp_user_info['ID'] = $wp_user_id;

                if (!empty($_POST['wp_emember_pwd']))
                    $wp_user_info['user_pass'] = $_POST['wp_emember_pwd'];
                wp_update_user($wp_user_info);
            }
            $_POST['member_id'] = strip_tags($_POST['member_id']);
            if (count($fields) > 0) {
                $ret = dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id =' . esc_sql($_POST['member_id']), $fields);
            }
            if (isset($_POST['emember_custom'])) {
                $custom_fields = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, ' user_id=' . esc_sql($_POST['member_id']) . ' AND meta_key=\'custom_field\'');
                if ($custom_fields)
                    $ret = $wpdb->query('UPDATE ' . WP_EMEMBER_MEMBERS_META_TABLE .
                            ' SET meta_value =' . '\'' . addslashes(serialize($_POST['emember_custom'])) . '\' WHERE meta_key = \'custom_field\' AND  user_id=' . $_POST['member_id']);
                else
                    $ret = $wpdb->query("INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
                            '( user_id, meta_key, meta_value ) VALUES(' . $_POST['member_id'] . ',"custom_field",' . '\'' . addslashes(serialize($_POST['emember_custom'])) . '\')');
            }
            else {
                $ret = $wpdb->query('DELETE FROM ' . WP_EMEMBER_MEMBERS_META_TABLE .
                        '  WHERE meta_key = \'custom_field\' AND  user_id=' . esc_sql($_POST['member_id']));
            }
            if ($ret === false) {
                $_POST['eMember_profile_update_result'] = 'Failed';
            } else {
                $edit_profile_page = $emember_config->getValue('eMember_profile_edit_page');
                $profile_updated_msg = '<div class="emember_profile_updated_msg">';
                $profile_updated_msg .= EMEMBER_PROFILE_UPDATED;
                if (!empty($edit_profile_page)) {
                    $profile_updated_msg .= ' <a href="' . $edit_profile_page . '">' . EMEMBER_EDIT_YOUR_PROFILE_AGAIN . '</a>';
                }
                $profile_updated_msg .= '</div>';

                $_POST['eMember_profile_update_result'] = $profile_updated_msg;
                do_action('eMember_profile_updated', $fields, $custom_fields);
                //Update the affiliate end if using the auto affiliate feature
                eMember_handle_affiliate_profile_update();
            }
        }
    }
}
