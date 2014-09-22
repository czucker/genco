<?php

function filter_eMember_registration_form($content) {
    $pattern = '#\[wp_eMember_registration_form:end]#';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        $replacement = print_eMember_registration_form();
        $content = str_replace($match, $replacement, $content);
    }
    return $content;
}

function print_eMember_registration_form() {
    return show_registration_form();
}

function emember_process_free_rego_with_confirm_form() {
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $error_message = "";
    $enable_recaptcha = $emember_config->getValue('emember_enable_recaptcha');
    if (isset($_POST['eMember_Register_with_confirmation'])) {
        $_POST['wp_emember_aemail'] = strip_tags($_POST['wp_emember_aemail']);
        $valid = true;
        if (empty($_POST['wp_emember_aemail']))
            $valid = false;
        if ($emember_config->getValue('eMember_reg_firstname') && $emember_config->getValue('eMember_reg_firstname_required')) {
            if (empty($_POST['wp_emember_afirstname']))
                $valid = false;
            else
                $_POST['wp_emember_afirstname'] = strip_tags($_POST['wp_emember_afirstname']);
        }
        else if ($emember_config->getValue('eMember_reg_firstname'))
            $_POST['wp_emember_afirstname'] = strip_tags($_POST['wp_emember_afirstname']);
        else
            $_POST['wp_emember_afirstname'] = "";

        if ($emember_config->getValue('eMember_reg_lastname') && $emember_config->getValue('eMember_reg_lastname_required')) {
            if (empty($_POST['wp_emember_alastname']))
                $valid = false;
            else
                $_POST['wp_emember_alastname'] = strip_tags($_POST['wp_emember_alastname']);
        }
        else if ($emember_config->getValue('eMember_reg_lastname'))
            $_POST['wp_emember_alastname'] = strip_tags($_POST['wp_emember_alastname']);
        else
            $_POST['wp_emember_alastname'] = "";

        if ($valid) {
            eMember_log_debug("Processing signup request of free membership with email confirmation for: " . $_POST['wp_emember_aemail'], true);
            if ($enable_recaptcha) {
                if (isset($_POST["recaptcha_response_field"])) {
                    $_POST["recaptcha_challenge_field"] = strip_tags($_POST["recaptcha_challenge_field"]);
                    $_POST["recaptcha_response_field"] = strip_tags($_POST["recaptcha_response_field"]);
                    $recaptcha_private_key = $emember_config->getValue('emember_recaptcha_private');
                    $resp = recaptcha_check_answer($recaptcha_private_key, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                    if (!$resp->is_valid) {
                        $recaptcha_error = $resp->error;
                        $error_message = "<p class='emember_error'><strong>" . EMEMBER_CAPTCHA_VERIFICATION_FAILED . "</strong></p>";
                        $emember_config->set_stacked_message('emember_free_registration_confirm_captcha', $recaptcha_error);
                        $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'error', 'message' => $error_message));
                    }
                } else {
                    $output .= '<span class="emember_error">reCAPTCHA&trade; service encountered error. please Contact Admin. </span>';
                    $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'warning', 'message' => $output));
                }
            }
            if (!$enable_recaptcha || $resp->is_valid) {
                $valid_captcha = apply_filters('emember_captcha_varify', true);
                eMember_log_debug("reCAPTCH is valid... creating member account for: " . $_POST['wp_emember_aemail'], true);
                // create new member account and send the registration completion email
                if (emember_email_exists($_POST['wp_emember_aemail'])) {
                    $error_message = "<p class='emember_error'><strong>" . EMEMBER_EMAIL_TAKEN . "</strong></p>";
                    $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'error', 'message' => $error_message));
                } else if (!$valid_captcha) {
                    $error_message = "<p class='emember_error'><strong>" . EMEMBER_CAPTCHA_FAILED . "</strong></p>";
                    $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'error', 'message' => $error_message));
                } else {
                    $fields = array();
                    $fields['user_name'] = '';
                    $fields['password'] = '';
                    $fields['first_name'] = $_POST['wp_emember_afirstname'];
                    $fields['last_name'] = $_POST['wp_emember_alastname'];
                    $fields['email'] = $_POST['wp_emember_aemail'];
                    $fields['last_accessed_from_ip'] = get_real_ip_addr();
                    $fields['member_since'] = (date("Y-m-d"));
                    //$fields['subscription_starts'] = date("Y-m-d");
                    if (isset($_POST['wp_emember_membership_level']) && !empty($_POST['wp_emember_membership_level'])) {
                        $fields['membership_level'] = strip_tags($_POST['wp_emember_membership_level']);
                    } else {
                        $fields['membership_level'] = $emember_config->getValue('eMember_free_membership_level_id');
                    }
                    //$fields['initial_membership_level'] = $emember_config->getValue('eMember_free_membership_level_id');
                    $eMember_manually_approve_member_registration = $emember_config->getValue('eMember_manually_approve_member_registration');
                    if ($eMember_manually_approve_member_registration) {
                        $fields['account_state'] = 'pending';
                    } else {
                        $fields['account_state'] = 'active';
                    }

                    $reg_code = uniqid(); //rand(10, 1000);
                    $md5_code = md5($reg_code);
                    $fields['reg_code'] = $reg_code;
                    $data_formats = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s');
                    //				$ret = dbAccess::insert(WP_EMEMBER_MEMBERS_TABLE_NAME, $fields);
                    $wpdb->insert(WP_EMEMBER_MEMBERS_TABLE_NAME, $fields, $data_formats);

                    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' reg_code=\'' . $reg_code . '\'');
                    $id = $resultset->member_id;

                    $separator = '?';
                    $url = $emember_config->getValue('eMember_registration_page');
                    if (strpos($url, '?') !== false) {
                        $separator = '&';
                    }
                    $reg_url = $url . $separator . 'member_id=' . $id . '&code=' . $md5_code;

                    $subject = $emember_config->getValue('eMember_email_subject');
                    $body = $emember_config->getValue('eMember_email_body');
                    $from_address = $emember_config->getValue('senders_email_address');

                    $tags = array("{first_name}", "{last_name}", "{reg_link}");
                    $vals = array($_POST['wp_emember_afirstname'], $_POST['wp_emember_alastname'], $reg_url);
                    $email_body = str_replace($tags, $vals, $body);
                    $headers = 'From: ' . $from_address . "\r\n";
                    $to_email = strip_tags($_POST['wp_emember_aemail']);

                    eMember_log_debug("Sending registration completion email for free registration with confirmation to: " . $to_email, true);
                    wp_mail($to_email, $subject, $email_body, $headers);
                    
                    $chk_mail_msg = '<div class="emember_check_email_msg">' . EMEMBER_PLEASE_CHECK_YOUR_INBOX . '<br />'. EMEMBER_EMAIL . ': '.$to_email. '</div>';                    
                    $output = apply_filters('emember_registration_check_email_msg', $chk_mail_msg);
                    
                    eMember_log_debug("Free registration with confirmation complete.", true);
                    $_SESSION['emember_dsc_nonce'] = $_REQUEST['emember_dsc_nonce'];
                    $_SESSION['emember_frwc_msg'] = $output;
                    $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'success', 'message' => $output));
                }
            }
        } else {
            $error_message = "<p class='emember_error'><strong>" . EMEMBER_YOU_MUST_FILL_IN_ALL_THE_FIELDS . "</strong></p>";
            $emember_config->set_stacked_message('emember_free_registration_confirm', array('type' => 'error', 'message' => $error_message));
        }
        $_SESSION['emember_frwc_msg'] = $error_message;
    }
}

function free_rego_with_email_confirmation_handler($args = NULL) {
    if (!is_null($args)) {
        extract(shortcode_atts(array('level' => ''), $args));
    } else {
        $level = '';
    }
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $error_message = "";
    $enable_recaptcha = $emember_config->getValue('emember_enable_recaptcha');
    $publickey = $emember_config->getValue('emember_recaptcha_public');
    if (!function_exists('recaptcha_get_html')) {
        require_once(WP_EMEMBER_PATH . '/recaptchalib.php');
        //require_once(WP_PLUGIN_DIR.'/'.WP_EMEMBER_FOLDER.'/recaptchalib.php');
    }
    if ($emember_config->getValue('eMember_enable_free_membership') == '') {//Free membership is disabled
        $output = EMEMBER_FREE_MEMBER_DISABLED;
        $output .= "<br />Enable free membership in the settings if you want to use this functionality.";
        return $output;
    }
    $stacked_msg = $emember_config->get_stacked_message('emember_free_registration_confirm');
    $recaptcha_error = $emember_config->get_stacked_message('emember_free_registration_confirm_captcha');
    $output = '';
    if (!empty($stacked_msg)) {
        if (($stacked_msg['type'] == 'warning') || ($stacked_msg['type'] == 'success'))
            return $stacked_msg['message'];
    }
    if (!empty($stacked_msg) && ($stacked_msg['type'] == 'error'))
        $error_message .= $stacked_msg['message'];

    ob_start();
    echo $error_message;
    ?>
    <script type="text/javascript" src="<?php echo site_url(); ?>?emember_load_js=registration&id=wp_emember_regoFormWithConfirmation"></script>
    <form action="" method="post" name="wp_emember_regoFormWithConfirmation" id="wp_emember_regoFormWithConfirmation" >
        <input type="hidden" name="emember_dsc_nonce" value="<?php echo uniqid(); ?>">
        <?php
        if (!empty($level)) {
            echo "<input type=\"hidden\" name=\"wp_emember_membership_level\" value=\"$level\">";
        }
        ?>
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
            <tr>
                <td colspan="2">
                    <?php echo EMEMBER_VERIFY_EMAIL_ADDRESS_MESSAGE; ?>
                </td>
            </tr>
            <?php if ($emember_config->getValue('eMember_reg_firstname')): ?>
                <tr>
                    <td><label for="wp_emember_afirstname" class="eMember_label"><?php echo EMEMBER_FIRST_NAME; ?>: </label></td>
                    <td>
                        <input type="text" id="wp_emember_afirstname" name="wp_emember_afirstname" size="20" value="<?php echo isset($_POST['wp_emember_afirstname']) ? $_POST['wp_emember_afirstname'] : ""; ?>" class="<?php echo $emember_config->getValue('eMember_reg_firstname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" />
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_lastname')): ?>
                <tr>
                    <td><label for="wp_emember_alastname" class="eMember_label"><?php echo EMEMBER_LAST_NAME ?>: </label></td>
                    <td><input type="text" id="wp_emember_alastname" name="wp_emember_alastname" size="20" value="<?php echo isset($_POST['wp_emember_alastname']) ? $_POST['wp_emember_alastname'] : ""; ?>" class="<?php echo $emember_config->getValue('eMember_reg_lastname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><label for="wp_emember_aemail" class="eMember_label"><?php echo EMEMBER_EMAIL; ?>: </label></td>
                <td><input type="text" id="wp_emember_aemail" name="wp_emember_aemail" size="20" value="<?php echo isset($_POST['wp_emember_aemail']) ? $_POST['wp_emember_aemail'] : ""; ?>" class="validate[required] eMember_text_input" /></td>
            </tr>
            <tr>
                <td></td>
                <td align="left">
                    <?php
                    if ($enable_recaptcha) {
                        $recaptcha_error = isset($recaptcha_error) ? $recaptcha_error : "";
                        if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {
                            echo recaptcha_get_html($publickey, $recaptcha_error, true);
                        } else {
                            echo recaptcha_get_html($publickey, $recaptcha_error);
                        }
                    }
                    echo apply_filters('emember_captcha', "");
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="eMember_button" name="eMember_Register_with_confirmation" type="submit" id="eMember_Register_with_confirmation" value="<?php echo EMEMBER_REGISTRATION; ?>" /></td>
            </tr>
        </table>
    </form>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function emember_process_reg_form() {
    $emember_config = Emember_Config::getInstance();
    if (is_blocked_ip(get_real_ip_addr())) {
        $message = '<span class="emember_error">' . EMEMBER_IP_BLACKLISTED . ' </span>';
        $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $message));
        return;
    }

    if (!function_exists('recaptcha_check_answer'))
        require_once(WP_PLUGIN_DIR . '/' . WP_EMEMBER_FOLDER . '/recaptchalib.php');

    $output = '';
    $eMember_id = strip_tags(isset($_GET["member_id"]) ? $_GET["member_id"] : "");
    $code = strip_tags(isset($_GET["code"]) ? $_GET["code"] : "");
    $recaptcha_error = null;
    $resp = null;
    global $wpdb;
    $is_reg_successfull = false;
    if (isset($_POST['eMember_Register'])) {
        $nonce = $_REQUEST['_wpnonce'];
        if (!wp_verify_nonce($nonce, 'emember-plain-registration-nonce')) {
            eMember_log_debug("Registration nonce check failed ", true);
            die("Security check failed on registration");
        }
        $_POST['wp_emember_email'] = strip_tags($_POST['wp_emember_email']);
        $_POST['wp_emember_user_name'] = strip_tags($_POST['wp_emember_user_name']);
        $_POST['wp_emember_pwd'] = strip_tags($_POST['wp_emember_pwd']);
        if ($emember_config->getValue('eMember_show_terms_conditions')) {
            if (!isset($_POST['emember_terms_conditions'])) {
                $output .= '<span class="emember_error">' . EMEMBER_TERMS_WARNING . '</span>';
                $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
                return;
            }
        }
        eMember_log_debug("Processing signup request of membership for: " . $_POST['wp_emember_email'], true);

        if (is_blocked_email($_POST['wp_emember_email'])) {
            $output .= '<span class="emember_error"> ' . EMEMBER_EMAIL_BLACKLISTED . ' </span>';
            $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
            return;
        }

        $enable_recaptcha = $emember_config->getValue('emember_enable_recaptcha');
        if ($enable_recaptcha) {
            $_POST["recaptcha_challenge_field"] = strip_tags($_POST["recaptcha_challenge_field"]);
            $_POST["recaptcha_response_field"] = strip_tags($_POST["recaptcha_response_field"]);
            if (isset($_POST["recaptcha_response_field"])) {
                $recaptcha_private_key = $emember_config->getValue('emember_recaptcha_private');
                $resp = recaptcha_check_answer($recaptcha_private_key, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                if (!$resp->is_valid) {
                    $emember_config->set_stacked_message('emember_full_registration_captcha', $resp->error);
                    $output .= '<div class="emember_error">' . EMEMBER_CAPTCHA_VERIFICATION_FAILED . '</div>';
                    $emember_config->set_stacked_message('emember_full_registration', array('type' => 'error', 'message' => $output));
                }
            } else {
                $output .= '<span class="emember_error">reCAPTCHA&trade; service encountered error. please Contact Admin. </span>';
                $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
            }
        }
        if (!$enable_recaptcha || ($resp && $resp->is_valid)) {
            eMember_log_debug("reCAPTCHA is valid... creating membership account: " . $_POST['wp_emember_email'], true);
            include_once(ABSPATH . WPINC . '/class-phpass.php');
            $wp_hasher = new PasswordHash(8, TRUE);
            $password = $wp_hasher->HashPassword($_POST['wp_emember_pwd']);
            include_once ('emember_validator.php');
            $validator = new Emember_Validator();
            $validator->add(array('value' => $_POST['wp_emember_user_name'], 'label' => EMEMBER_USERNAME, 'rules' => array('user_required', 'user_minlength', 'user_name', 'user_unavail')));
            $validator->add(array('value' => $_POST['wp_emember_email'], 'label' => EMEMBER_EMAIL, 'rules' => array('email_required', 'email', 'email_unavail')));
            $validator->add(array('value' => $_POST['wp_emember_pwd'], 'label' => EMEMBER_PASSWORD, 'rules' => array('pass_required')));
            $messages = $validator->validate();
            $show_confirm_pass = $emember_config->getValue('eMember_show_confirm_pass_field');
            if ($show_confirm_pass) {
                if ($_POST['wp_emember_pwd'] != $_POST['wp_emember_pwd_re'])
                    $messages[] = EMEMBER_PASSWORD . ':' . EMEMBER_PASSWORD_MISMATCH;
            }
            $valid_captcha = apply_filters('emember_captcha_varify', true);
            // create new member account and send the registration completion email
            if (!$valid_captcha) {
                $output .= "<p class='emember_error'><strong>" . EMEMBER_CAPTCHA_FAILED . "</strong></p>";
                $emember_config->set_stacked_message('emember_full_registration', array('type' => 'error', 'message' => $output));
            } else if (count($messages) > 0) {
                $output .= '<span class="emember_error">' . implode('<br/>', $messages) . '</span>';
                $emember_config->set_stacked_message('emember_full_registration', array('type' => 'error', 'message' => $output));
            } else {
                $fields = array();
                $custom_fields = array();

                /* === Common registration fields value === */
                if (isset($_COOKIE['ap_id'])) {
                    $fields['referrer'] = $_COOKIE['ap_id'];
                } else {
                    $fields['referrer'] = '';
                }
                if (isset($_POST['emember_custom']) && is_array($_POST['emember_custom'])) {
                    $referrer_field_key = "Referrer";
                    if (array_key_exists($referrer_field_key, $_POST['emember_custom'])) {
                        $fields['referrer'] = strip_tags(trim($_POST['emember_custom'][$referrer_field_key]));
                    }
                }

                //if (!empty($_SESSION['eMember_id']) && !empty($_SESSION['reg_code']))
                if (isset($_POST['eMember_id']) && isset($_POST['eMember_reg_code'])) {
                    //Update the membership data with the registration complete details (this path is exercised when the unique link is clicked from the email to do the registration complete action)
                    eMember_log_debug("Completing the registration for premium membership account. Member Email: " . $_POST['wp_emember_email'] . " eMember ID: " . $eMember_id, true);
                    $mresultset = $wpdb->get_row("SELECT reg_code,membership_level FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . " where member_id='$eMember_id'", ARRAY_A);
                    /*                     * ********************** */
                    $fields['user_name'] = $_POST['wp_emember_user_name'];
                    $fields['password'] = $password;
                    $fields['membership_level'] = $mresultset['membership_level'];
                    $fields['reg_code'] = '';
                    if (isset($_POST['wp_emember_title']))
                        $fields['title'] = strip_tags($_POST['wp_emember_title']);
                    if (isset($_POST['wp_emember_firstname']))
                        $fields['first_name'] = strip_tags($_POST['wp_emember_firstname']);
                    if (isset($_POST['wp_emember_lastname']))
                        $fields['last_name'] = strip_tags($_POST['wp_emember_lastname']);
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

                    $fields['member_since'] = (date("Y-m-d"));
                    $fields['subscription_starts'] = date("Y-m-d");

                    //No need to update the membership level as it has already been set for this member when the unique rego complete link was sent out

                    $eMember_manually_approve_member_registration = $emember_config->getValue('eMember_manually_approve_member_registration');
                    if ($eMember_manually_approve_member_registration) {
                        $fields['account_state'] = 'pending';
                    } else {
                        $fields['account_state'] = 'active';
                    }
                    $fields['email'] = $_POST['wp_emember_email'];
                    $fields['last_accessed_from_ip'] = get_real_ip_addr();

                    $reg_code = strip_tags($_POST['eMember_reg_code']);
                    if (md5($mresultset['reg_code']) == $reg_code) {
                        $ret = dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . esc_sql($eMember_id), $fields);
                        eMember_log_debug("Updating premium member account data. eMember ID: " . $eMember_id, true);
                        /*                         * ********************** */
                        $lastid = $eMember_id;
                        if (isset($_POST['emember_custom'])) {
                            foreach ($_POST['emember_custom'] as $key => $value) {
                                $custom_fields[$key] = $value;
                            }
                            $wpdb->query("INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
                                    '( user_id, meta_key, meta_value ) VALUES(' . $lastid . ',\'custom_field\',' . '\'' . addslashes(serialize($_POST['emember_custom'])) . '\')');
                        }

                        if ($ret === false) {
                            $output .= '<br />' . ' DB Error.';
                            $emember_config->set_stacked_message('emember_full_registration', array('type' => 'error', 'message' => $output));
                            $is_reg_successfull = false;
                        } else {
                            $is_reg_successfull = true;
                            unset($_SESSION['eMember_id']);
                            unset($_SESSION['reg_code']);
                        }
                    } else {
                        $output .= '<span class="emember_error">Error! Unique registration code do not match!</span>';
                        $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
                    }
                } else {
                    //Create a new account for a free member or the level specified in the shortcode. This path is exercised when someone directly goes to the registration page and submits the details.
                    eMember_log_debug("Creating a new account for free membership or for the level specified in the shortcode. Member Email: " . $_POST['wp_emember_email'], true);
                    $fields['user_name'] = $_POST['wp_emember_user_name'];
                    $fields['password'] = $password;
                    if (isset($_POST['wp_emember_title']))
                        $fields['title'] = strip_tags($_POST['wp_emember_title']);
                    if (isset($_POST['wp_emember_firstname']))
                        $fields['first_name'] = strip_tags($_POST['wp_emember_firstname']);
                    if (isset($_POST['wp_emember_lastname']))
                        $fields['last_name'] = strip_tags($_POST['wp_emember_lastname']);
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

                    $fields['member_since'] = (date("Y-m-d"));
                    $fields['subscription_starts'] = date("Y-m-d");

                    if (isset($_POST['custom_member_level_shortcode'])) {
                        $fields['membership_level'] = $_POST['custom_member_level_shortcode'];
                        //$fields['initial_membership_level']    = $_POST['custom_member_level_shortcode'];
                    } else {
                        $fields['membership_level'] = $emember_config->getValue('eMember_free_membership_level_id');
                        //$fields['initial_membership_level']    = $emember_config->getValue('eMember_free_membership_level_id');
                    }
                    $eMember_manually_approve_member_registration = $emember_config->getValue('eMember_manually_approve_member_registration');
                    if ($eMember_manually_approve_member_registration) {
                        $fields['account_state'] = 'pending';
                    } else {
                        $fields['account_state'] = 'active';
                    }
                    $fields['email'] = $_POST['wp_emember_email'];
                    $fields['last_accessed_from_ip'] = get_real_ip_addr();

                    $ret = dbAccess::insert(WP_EMEMBER_MEMBERS_TABLE_NAME, $fields);
                    $lastid = $wpdb->insert_id;
                    $fields['member_id'] = $lastid;
                    if (isset($_POST['emember_custom'])) {
                        foreach ($_POST['emember_custom'] as $key => $value) {
                            $custom_fields[$key] = $value;
                        }
                        $wpdb->query("INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
                                '( user_id, meta_key, meta_value ) VALUES(' . $lastid . ',\'custom_field\',' . '\'' . addslashes(serialize($_POST['emember_custom'])) . '\')');
                    }
                    if ($ret === false) {
                        $output .= '<br />' . ' DB Error.';
                        $emember_config->set_stacked_message('emember_full_registration', array('type' => 'error', 'message' => $output));
                        $is_reg_successfull = false;
                    } else {
                        $is_reg_successfull = true;
                    }
                }
                if ($is_reg_successfull) {
                    eMember_log_debug("Processing registration submission...", true);

                    //Send notification to any other plugin listening for the eMember registration complete event.
                    do_action('eMember_registration_complete', $fields, $custom_fields);

                    //Query the membership level table to get a handle for the level
                    $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $fields['membership_level'] . "'");

                    // Create the corresponding wordpress user
                    $should_create_wp_user = $emember_config->getValue('eMember_create_wp_user');
                    if ($should_create_wp_user) {
                        $role_names = array(1 => 'Administrator', 2 => 'Editor', 3 => 'Author', 4 => 'Contributor', 5 => 'Subscriber');
                        $wp_user_info = array();
                        $wp_user_info['user_nicename'] = implode('-', explode(' ', $_POST['wp_emember_user_name']));
                        $wp_user_info['display_name'] = $_POST['wp_emember_user_name'];
                        $wp_user_info['nickname'] = $_POST['wp_emember_user_name'];
                        $wp_user_info['first_name'] = strip_tags($_POST['wp_emember_firstname']);
                        $wp_user_info['last_name'] = strip_tags($_POST['wp_emember_lastname']);
                        $wp_user_info['role'] = $membership_level_resultset->role;
                        $wp_user_info['user_registered'] = date('Y-m-d H:i:s');

                        //$wp_user_id = wp_create_user($_POST['wp_emember_user_name'], $_POST['wp_emember_pwd'], $_POST['wp_emember_email']);
                        $wp_user_id = eMember_wp_create_user($_POST['wp_emember_user_name'], $_POST['wp_emember_pwd'], $_POST['wp_emember_email'], $wp_user_info);
                        //do_action( 'set_user_role', $wp_user_id, $membership_level_resultset->role );
                    }
                    //-----------------
                    $subject_rego_complete = $emember_config->getValue('eMember_email_subject_rego_complete');
                    $body_rego_complete = $emember_config->getValue('eMember_email_body_rego_complete');
                    $from_address = $emember_config->getValue('senders_email_address');
                    $login_link = $emember_config->getValue('login_page_url');
                    //Do the full dynamic member details replacement
                    $curr_member_id = $lastid;
                    $additional_params = array('password' => $_POST['wp_emember_pwd'], 'login_link' => $login_link);
                    $email_body1 = emember_dynamically_replace_member_details_in_message($curr_member_id, $body_rego_complete, $additional_params);

                    //The filter for email notification body
                    $email_body1 = apply_filters('eMember_notification_email_body_filter', $email_body1, $curr_member_id);

                    $headers = 'From: ' . $from_address . "\r\n";
                    $member_email = $_POST['wp_emember_email'];
                    wp_mail($member_email, $subject_rego_complete, $email_body1, $headers);
                    eMember_log_debug("Member registration complete email successfully sent to: ".$member_email, true);
                    if ($emember_config->getValue('eMember_admin_notification_after_registration')) {
                        $admin_email = $emember_config->getValue('eMember_admin_notification_email_address'); 
                        $notify_emails_array = explode(",",$admin_email);
                        foreach ($notify_emails_array as $notify_email_address)//Send notification emails to all addresses
                        {
                            if(!empty($notify_email_address)){
                                $admin_notification_subject = EMEMBER_NEW_ACCOUNT_MAIL_HEAD;
                                $admin_email_body = EMEMBER_NEW_ACCOUNT_MAIL_BODY .
                                        "\n\n-------Member Email----------\n" .
                                        $email_body1 .
                                        "\n\n------End------\n";
                                wp_mail($notify_email_address, $admin_notification_subject, $admin_email_body, $headers);
                                eMember_log_debug("Admin notification email successfully sent to: ".$admin_email, true);
                            }
                        }
                    }
                    //Create the corresponding affliate account
                    if ($emember_config->getValue('eMember_auto_affiliate_account')) {
                        eMember_log_debug("Creating affiliate account for this member.", true);
                        eMember_handle_affiliate_signup($_POST['wp_emember_user_name'], $_POST['wp_emember_pwd'], $_POST['wp_emember_firstname'], $_POST['wp_emember_lastname'], $_POST['wp_emember_email'], eMember_get_aff_referrer());
                    }

                    /*                     * * Signup the member to Autoresponder List (Autoresponder integration) ** */
                    eMember_log_debug("===> Performing autoresponder signup if needed <===", true);
                    $membership_level_id = $fields['membership_level'];
                    $firstname = isset($_POST['wp_emember_firstname']) ? $_POST['wp_emember_firstname'] : "";
                    $lastname = isset($_POST['wp_emember_lastname']) ? $_POST['wp_emember_lastname'] : "";
                    $emailaddress = $_POST['wp_emember_email'];
                    eMember_level_specific_autoresponder_signup($membership_level_id, $firstname, $lastname, $emailaddress);
                    eMember_global_autoresponder_signup($firstname, $lastname, $emailaddress);
                    /*                     * * end of autoresponder integration ** */

                    /*                     * * check redirection options and redirect accordingly ** */
                    $after_rego_page = $emember_config->getValue('eMember_after_registration_page');
                    $redirect_page = $emember_config->getValue('login_page_url');
                    $auto_login_after_rego = $emember_config->getValue('eMember_enable_auto_login_after_rego');
                    if ($auto_login_after_rego) {
                        if (!empty($redirect_page)) {
                            $separator = wp_emember_get_query_separator_for_url($redirect_page);
                            $encoded_pass = base64_encode ($_POST['wp_emember_pwd']);
                            $redirect_page = $redirect_page . $separator . "doLogin=1&pwd_encoded=1&emember_u_name=" . urlencode($_POST['wp_emember_user_name']) . "&emember_pwd=" . urlencode($encoded_pass);
                            //$redirect_page = wp_nonce_url($redirect_page,'emember-login-nonce');
                            $login_nonce = wp_create_nonce('emember-login-nonce');
                            $redirect_page = $redirect_page . "&_wpnonce=" . $login_nonce;                            
                            wp_emember_redirect_to_url($redirect_page);
                        } else {
                            $output .= '<div class="emember_error">Error! The "Login Page URL" field value is missing! Go to the Pages/Forms settings menu and correct the mistake.</div>';
                            $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
                        }
                    } else if (!empty($after_rego_page)) {
                        wp_emember_redirect_to_url($after_rego_page);
                    } else {
                        if ($eMember_manually_approve_member_registration) {
                            $output .= '<p>' . EMEMBER_REG_COMPLETE_PENDING_APPROVAL . '</p>';
                        } else {
                            $output .= '<p>' . EMEMBER_REG_COMPLETE . EMEMBER_PLEASE . ' <a href="' . $redirect_page . '">' . EMEMBER_LOGIN . '</a></p>';
                        }
                        $emember_config->set_stacked_message('emember_full_registration', array('type' => 'success', 'message' => $output));
                    }
                    /*                     * * End of redirection stuff ** */
                } else {
                    $output .= "<b><br/>Something went wrong. Please Contact <a href='mailto:" . get_bloginfo('admin_email') . "'>Admin.</a></b>";
                    $emember_config->set_stacked_message('emember_full_registration', array('type' => 'warning', 'message' => $output));
                }
            }//End no error on submission
        }//End recaptcha valid block
    }//End POST register submission
    return;
}

function show_registration_form($level = 0) {
    $result = apply_filters('emember_registration_override', $level);
    if ($result != $level)
        return $result;

    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $recaptcha_error = $emember_config->get_stacked_message('emember_full_registration_captcha');
    $eMember_id = strip_tags(isset($_GET["member_id"]) ? $_GET["member_id"] : "");
    $code = strip_tags(isset($_GET["code"]) ? $_GET["code"] : "");
    $stacked_msg = $emember_config->get_stacked_message('emember_full_registration');
    $output = '';
    if (!empty($stacked_msg)) {
        if (($stacked_msg['type'] == 'warning') || ($stacked_msg['type'] == 'success'))
            return $stacked_msg['message'];
    }
    if (!empty($stacked_msg) && ($stacked_msg['type'] == 'error'))
        $output .= $stacked_msg['message'];


    if (!empty($eMember_id) && !empty($code)) {
        $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . esc_sql($eMember_id));

        if(empty($resultset->reg_code)){//Error condition
            $output = '<span class="emember_error">Error! The unique registration code you used in the URL has already been used or it is invalid!</span>';
            return $output;
        }

        $md5code = md5($resultset->reg_code);
        if ($code == $md5code) {
            $free_member_level = $resultset->membership_level;
            $level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id=' . esc_sql($free_member_level));
            $_POST['wp_emember_member_level'] = $level_resultset->alias;
            $_POST['wp_emember_firstname'] = $resultset->first_name;
            $_POST['wp_emember_lastname'] = $resultset->last_name;
            $_POST['wp_emember_email'] = $resultset->email;
            $_SESSION['eMember_id'] = $eMember_id;
            $_SESSION['reg_code'] = $code;
            $_POST['eMember_id'] = $eMember_id;
            $_POST['eMember_reg_code'] = $code;
            $output .= "<br />" . EMEMBER_USER_PASS_MSG;
            $output .= eMember_reg_form($recaptcha_error);
        }
    } else if ($emember_config->getValue('eMember_enable_free_membership') || !empty($level)) {
        if (isset($_POST['custom_member_level_shortcode'])) {
            $level = $_POST['custom_member_level_shortcode'];
        }
        if (!empty($level)) {
            $level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id=' . esc_sql($level));
            if (!$level_resultset) {
                $output .= '<p style="color:red;">You seem to have specified a membership level ID that does not exist. Please correct the membership level ID in the shortcode.</p>';
                return $output;
            }
            $_POST['wp_emember_member_level'] = $level_resultset->alias;
            $output .= eMember_reg_form($recaptcha_error, $level);
        } else {
            $free_member_level = $emember_config->getValue('eMember_free_membership_level_id');
            if (empty($free_member_level))
                return "<b>Free Membership Level ID has not been specified. Site Admin needs to correct the settings in the settings menu of eMember.</b>";
            if (!is_numeric($free_member_level))
                return "<b>Free Membership Level should be numeric. Site Admin needs to correct the settings in the settings menu of eMember.</b>";
            $level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id=' . esc_sql($free_member_level));
            $_POST['wp_emember_member_level'] = $level_resultset->alias;
            $eMember_free_members_must_confirm_email = $emember_config->getValue('eMember_free_members_must_confirm_email');
            if ($eMember_free_members_must_confirm_email) {
                $output .= free_rego_with_email_confirmation_handler();
            } else {
                $output .= eMember_reg_form($recaptcha_error, $level);
            }
        }
    } else {
        //Free membership is disabled
        $output .= EMEMBER_FREE_MEMBER_DISABLED;
        $payment_page = $emember_config->getValue('eMember_payments_page');
        if (!empty($payment_page)) {
            $output .= '<br />' . EMEMBER_VISIT_PAYMENT_PAGE . '.' . EMEMBER_CLICK . ' <a href="' . $payment_page . '">' . EMEMBER_HERE . '</a>';
        }
    }
    return $output;
}

function eMember_reg_form($error = null, $level = 0) {
    global $wpdb;

    $emember_config = Emember_Config::getInstance();
    //Check if the email field should be read only
    $readonlyemail = '';
    $eMember_free_members_must_confirm_email = $emember_config->getValue('eMember_free_members_must_confirm_email');
    if ($eMember_free_members_must_confirm_email && !empty($_POST['wp_emember_email'])) {
        //Check and see if this is a rego complete for free level
        $membership_level_name = $_POST['wp_emember_member_level'];
        $level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " alias='" . $membership_level_name . "'");
        $free_member_level = $emember_config->getValue('eMember_free_membership_level_id');
        if ($level_resultset->id == $free_member_level) {
            $readonlyemail = 'readonly="readonly"';
        }
    }

    //Recaptcha
    $publickey = $emember_config->getValue('emember_recaptcha_public');
    $emember_enable_recaptcha = $emember_config->getValue('emember_enable_recaptcha');
    if (!function_exists('recaptcha_get_html')) {
        require_once(WP_PLUGIN_DIR . '/' . WP_EMEMBER_FOLDER . '/recaptchalib.php');
    }
    ob_start();
    $letter_number_underscore = $emember_config->getValue('eMember_auto_affiliate_account') ?
            ',custom[onlyLetterNumberUnderscore]' : ',custom[ememberUserName]';
    ?>
    <script type="text/javascript" src="<?php echo site_url(); ?>?emember_load_js=registration&id=wp_emember_regoForm"></script>
    <form action="" method="post" name="wp_emember_regoForm" id="wp_emember_regoForm" >
        <?php wp_nonce_field('emember-plain-registration-nonce'); ?>
        <input type="hidden" name="emember_dsc_nonce" value="<?php echo uniqid(); ?>">
        <?php if ($level != 0) { ?>
            <input type="hidden" name="custom_member_level_shortcode" value="<?php echo $level; ?>" />
        <?php } ?>
        <?php if (isset($_POST['eMember_id']) && isset($_POST['eMember_reg_code'])) { ?>
            <input type="hidden" name="eMember_id" value="<?php echo strip_tags($_POST['eMember_id']); ?>" />
            <input type="hidden" name="eMember_reg_code" value="<?php echo strip_tags($_POST['eMember_reg_code']); ?>" />
        <?php } ?>
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
            <tr>
                <td><label for="wp_emember_user_name"  class="eMember_label"><?php echo EMEMBER_USERNAME; ?>: </label></td>
                <td><input type="text" id="wp_emember_user_name" name="wp_emember_user_name" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_user_name']) ? $_POST['wp_emember_user_name'] : ""); ?>" class="validate[required,minSize[4]<?php echo $letter_number_underscore ?>,ajax[ajaxUserCall]] eMember_text_input" /></td>
            </tr>
            <tr>
                <td><label for="wp_emember_pwd" class="eMember_label"><?php echo EMEMBER_PASSWORD; ?>: </label></td>
                <td><input type="password" id="wp_emember_pwd" name="wp_emember_pwd" size="20" value="" class="validate[required,minSize[4]] eMember_text_input" /></td>
            </tr>
            <?php if ($emember_config->getValue('eMember_show_confirm_pass_field')): ?>
                <tr>
                    <td><label for="wp_emember_pwd_re" class="eMember_label"><?php echo EMEMBER_PASSWORD_REPEAT; ?>: </label></td>
                    <td><input type="password" id="wp_emember_pwd_re" name="wp_emember_pwd_re" size="20" value="" class="validate[required,minSize[4],equals[wp_emember_pwd]] eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><label for="wp_emember_email" class="eMember_label"><?php echo EMEMBER_EMAIL; ?>: </label></td>
                <td><input type="text" id="wp_emember_email" name="wp_emember_email" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_email']) ? $_POST['wp_emember_email'] : ""); ?>" class="validate[required,custom[email]] eMember_text_input" <?php echo $readonlyemail; ?> /></td>
            </tr>
            <tr <?php echo $emember_config->getValue('eMember_hide_membership_field') ? "class='emember_hidden'" : ""; ?>>
                <td><label for="wp_emember_member_level" class="eMember_label"> <?php echo EMEMBER_MEMBERSHIP_LEVEL; ?>: </label></td>
                <td><input type="text" id="wp_emember_member_level" name="wp_emember_member_level" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_member_level']) ? $_POST['wp_emember_member_level'] : ""); ?>" class="validate[required] eMember_text_input" readonly /></td>
            </tr>
            <?php if ($emember_config->getValue('eMember_reg_title')): ?>
                <tr>
                    <td width="30%"><label for="atitle" class="eMember_label"><?php echo EMEMBER_TITLE; ?>: </label></td>
                    <td>
                        <select name="wp_emember_title">
                            <option  <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'not specified')) ? 'selected=\'selected\'' : '' ) ?> value="not specified"><?php echo EMEMBER_GENDER_UNSPECIFIED ?></option>
                            <option <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'Mr')) ? 'selected=\'selected\'' : '' ) ?> value="Mr"><?php echo EMEMBER_MR; ?></option>
                            <option <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'Mrs')) ? 'selected=\'selected\'' : '' ) ?> value="Mrs"><?php echo EMEMBER_MRS; ?></option>
                            <option <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'Miss')) ? 'selected=\'selected\'' : '' ) ?> value="Miss"><?php echo EMEMBER_MISS; ?></option>
                            <option <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'Ms')) ? 'selected=\'selected\'' : '' ) ?> value="Ms"><?php echo EMEMBER_MS; ?></option>
                            <option <?php echo ((isset($_POST['wp_emember_title']) && ($_POST['wp_emember_title'] === 'Dr')) ? 'selected=\'selected\'' : '' ) ?> value="Dr"><?php echo EMEMBER_DR; ?></option>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_firstname')): ?>
                <tr>
                    <td><label for="wp_emember_firstname" class="eMember_label"><?php echo EMEMBER_FIRST_NAME; ?>: </label></td>
                    <td>
                        <input type="text" id="wp_emember_firstname" name="wp_emember_firstname" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_firstname']) ? $_POST['wp_emember_firstname'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_firstname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" />
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_lastname')): ?>
                <tr>
                    <td><label for="wp_emember_lastname" class="eMember_label"><?php echo EMEMBER_LAST_NAME ?>: </label></td>
                    <td><input type="text" id="wp_emember_lastname" name="wp_emember_lastname" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_lastname']) ? $_POST['wp_emember_lastname'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_lastname_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_phone')): ?>
                <tr>
                    <td><label for="wp_emember_email" class="eMember_label"><?php echo EMEMBER_PHONE ?>: </label></td>
                    <td><input type="text" id="wp_emember_phone" name="wp_emember_phone" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_phone']) ? $_POST['wp_emember_phone'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_phone_required') ? 'validate[required,custom[phone]] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_company')): ?>
                <tr>
                    <td><label for="wp_emember_company_name" class="eMember_label"><?php echo EMEMBER_COMPANY ?>: </label></td>
                    <td><input type="text" id="wp_emember_company_name" name="wp_emember_company_name" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_company_name']) ? $_POST['wp_emember_company_name'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_company_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_street')): ?>
                <tr>
                    <td><label for="emember_street" class="eMember_label"><?php echo EMEMBER_ADDRESS_STREET ?>: </label></td>
                    <td><input type="text" id="wp_emember_street" name="wp_emember_street" size="20" value="<?php echo strip_tags($_POST['wp_emember_street']); ?>" class="<?php echo $emember_config->getValue('eMember_reg_street_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_city')): ?>
                <tr>
                    <td><label for="wp_emember_city" class="eMember_label"><?php echo EMEMBER_ADDRESS_CITY ?>: </label></td>
                    <td><input type="text" id="wp_emember_city" name="wp_emember_city" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_city']) ? $_POST['wp_emember_city'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_city_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_state')): ?>
                <tr>
                    <td><label for="wp_emember_state" class="eMember_label"><?php echo EMEMBER_ADDRESS_STATE ?>: </label></td>
                    <td><input type="text" id="wp_emember_state" name="wp_emember_state" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_state']) ? $_POST['wp_emember_state'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_state_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_zipcode')): ?>
                <tr>
                    <td><label for="wp_emember_zipcode" class="eMember_label"><?php echo EMEMBER_ADDRESS_ZIP ?>: </label></td>
                    <td><input type="text" id="wp_emember_zipcode" name="wp_emember_zipcode" size="20" value="<?php echo strip_tags(isset($_POST['wp_emember_zipcode']) ? $_POST['wp_emember_zipcode'] : ""); ?>" class="<?php echo $emember_config->getValue('eMember_reg_zipcode_required') ? 'validate[required] ' : ""; ?>eMember_text_input" /></td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_country')): ?>

                <tr>
                    <td><label for="wp_emember_country" class="eMember_label"><?php echo EMEMBER_ADDRESS_COUNTRY ?>: </label></td>
                    <td>
                        <select name="wp_emember_country" id="wp_emember_country" class="<?php echo $emember_config->getValue('eMember_reg_country_required') ? 'validate[required] ' : ""; ?>eMember_text_input" >
                            <?php
                            strip_tags(isset($_POST['wp_emember_country']) ? $selected_country = $_POST['wp_emember_country'] : "");
                            echo emember_country_list_dropdown($selected_country);
                            ?>
                        </select>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_reg_gender')): ?>
                <tr >
                    <td > <label for="wp_emember_gender" class="eMember_label"><?php echo EMEMBER_GENDER ?>: </label></td>
                    <td>
                        <select name="wp_emember_gender" id="wp_emember_gender">
                            <option  <?php echo ((isset($_POST['wp_emember_gender']) && ($_POST['wp_emember_gender'] === 'male')) ? 'selected=\'selected\'' : '' ) ?> value="male"><?php echo EMEMBER_GENDER_MALE ?></option>
                            <option  <?php echo ((isset($_POST['wp_emember_gender']) && ($_POST['wp_emember_gender'] === 'female')) ? 'selected=\'selected\'' : '' ) ?> value="female"><?php echo EMEMBER_GENDER_FEMALE ?></option>
                            <option  <?php echo ((isset($_POST['wp_emember_gender']) && ($_POST['wp_emember_gender'] === 'not specified')) ? 'selected=\'selected\'' : '' ) ?> value="not specified"><?php echo EMEMBER_GENDER_UNSPECIFIED ?></option>
                        </select>
                    </td>
                </tr>
                <?php
            endif;
            include ('custom_field_template.php');
            $use_ssl = false;
            if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {
                $use_ssl = true;
            }
            ?>
            <tr>
                <td></td>
                <td align="left">
                    <?php
                    echo (($emember_enable_recaptcha) ? recaptcha_get_html($publickey, $error, $use_ssl) : '' );
                    echo apply_filters('emember_captcha', "");
                    ?>  </td></tr>
            <?php if ($emember_config->getValue('eMember_show_terms_conditions')): ?>
                <tr>
                    <td colspan="2" align="center"><?php echo EMEMBER_ACCEPT; ?> <a href="<?php echo $emember_config->getValue('eMember_terms_conditions_page'); ?>" target="_blank"> <?php echo EMEMBER_TERMS_CONDITIONS; ?></a>
                        &nbsp;<input type="checkbox" class="validate[required]" id="emember_terms_conditions" name="emember_terms_conditions" value="1"></input>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td></td>
                <td><input class="eMember_button submit" name="eMember_Register" type="submit" id="eMember_Register" value="<?php echo EMEMBER_REGISTRATION; ?>" /></td>
            </tr>
        </table>
    </form><br />
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function create_new_emember_user($data) {
    global $wpdb;
    $wpdb->insert(WP_EMEMBER_MEMBERS_TABLE_NAME, $data);
}

function is_blocked_email($user_email) {
    $user_email = trim($user_email);
    $emember_config = Emember_Config::getInstance();
    $blacklisted_emails = $emember_config->getValue('blacklisted_emails');
    $blacklisted_emails = empty($blacklisted_emails) ? array() : explode(';', $blacklisted_emails);
    foreach ($blacklisted_emails as $email) {
        $email = trim($email);
        if ((!empty($email)) && stristr($user_email, $email))
            return true;
    }
    return false;
}

function is_blocked_ip($user_ip) {
    $user_ip = trim($user_ip);
    $emember_config = Emember_Config::getInstance();
    $blacklisted_ips = $emember_config->getValue('blacklisted_ips');
    $blacklisted_ips = empty($blacklisted_ips) ? array() : explode(';', $blacklisted_ips);
    $current_ip = get_real_ip_addr();
    foreach ($blacklisted_ips as $ip) {
        $ip_port = explode(':', $ip);
        $ip = trim($ip_port[0]);

        if (!empty($ip) && (preg_match('/^(' . $ip . ')/', $user_ip) === 1))
            return true;
    }
    return false;
}
