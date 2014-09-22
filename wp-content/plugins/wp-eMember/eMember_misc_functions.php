<?php

function emember_wp_username_exists($username) {
    return username_exists($username);
}

function emember_wp_email_exists($email) {
    if (!eMember_is_multisite_install())
        return email_exists($email);
    //For WPMS install, check for the email existence wihin that blog (not the whole network).
    //A user should be allowed to have another account on a sub-site of a WPMS install
    if ($userid = email_exists($email)) {
        $blogs = get_blogs_of_user($userid);
        $current_blog_id = get_current_blog_id();
        foreach ($blogs as $blog) {
            if ($current_blog_id == $blog->userblog_id) {//return true if the email address assigned to current blog.
                return true;
            }
        }
    }
    return false;
}

function update_wp_user_Role($wp_user_id, $role) {
    $emember_config = Emember_Config::getInstance();
    $preserve_role = $emember_config->getValue('eMember_preserve_wp_user_role');
    if ($preserve_role) {
        eMember_log_debug("Preserve role settings is enabled. So the corresponding WP user role will not be updated.", true);
        return;
    }
    if (eMember_is_multisite_install()) {//MS install
        $not_blog_member = true;
        $blogs = get_blogs_of_user($wp_user_id);
        $current_blog_id = get_current_blog_id();
        foreach ($blogs as $blog) {
            if ($current_blog_id == $blog->userblog_id) {
                $not_blog_member = false;
            }
        }
        if ($not_blog_member)
            return; // not member of current blog. role update is not allowed.
    }

    $caps = get_user_meta($wp_user_id, 'wp_capabilities', true);
    if (is_array($caps) && in_array('administrator', array_keys((array) $caps)))
        return;
    do_action('set_user_role', $wp_user_id, $role); //Fire the action for other plugin(s)
    wp_update_user(array('ID' => $wp_user_id, 'role' => $role));
    $roles = new WP_Roles();
    $level = $roles->roles[$role]['capabilities'];
    if (isset($level['level_10']) && $level['level_10']) {
        update_user_meta($wp_user_id, 'wp_user_level', 10);
        return;
    }
    if (isset($level['level_9']) && $level['level_9']) {
        update_user_meta($wp_user_id, 'wp_user_level', 9);
        return;
    }
    if (isset($level['level_8']) && $level['level_8']) {
        update_user_meta($wp_user_id, 'wp_user_level', 8);
        return;
    }
    if (isset($level['level_7']) && $level['level_7']) {
        update_user_meta($wp_user_id, 'wp_user_level', 7);
        return;
    }
    if (isset($level['level_6']) && $level['level_6']) {
        update_user_meta($wp_user_id, 'wp_user_level', 6);
        return;
    }
    if (isset($level['level_5']) && $level['level_5']) {
        update_user_meta($wp_user_id, 'wp_user_level', 5);
        return;
    }
    if (isset($level['level_4']) && $level['level_4']) {
        update_user_meta($wp_user_id, 'wp_user_level', 4);
        return;
    }
    if (isset($level['level_3']) && $level['level_3']) {
        update_user_meta($wp_user_id, 'wp_user_level', 3);
        return;
    }
    if (isset($level['level_2']) && $level['level_2']) {
        update_user_meta($wp_user_id, 'wp_user_level', 2);
        return;
    }
    if (isset($level['level_1']) && $level['level_1']) {
        update_user_meta($wp_user_id, 'wp_user_level', 1);
        return;
    }
    if (isset($level['level_0']) && $level['level_0']) {
        update_user_meta($wp_user_id, 'wp_user_level', 0);
        return;
    }
}

function emember_registered_email_exists($email) {
    global $wpdb;
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $resultset = dbAccess::find($member_table, ' email=\'' . esc_sql($email) . '\' AND user_name != ""');
    if (empty($resultset))
        return false;
    return $resultset->member_id;
}

function emember_email_exists($email) {
    global $wpdb;
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $resultset = dbAccess::find($member_table, ' email=\'' . esc_sql($email) . '\'');
    if (empty($resultset))
        return false;
    return $resultset->member_id;
}

function emember_username_exists($user_name) {
    global $wpdb;
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $resultset = dbAccess::find($member_table, ' user_name=\'' . esc_sql($user_name) . '\'');
    if (empty($resultset))
        return false;
    return $resultset->member_id;
}

if (!function_exists('json_decode')) {

    function json_decode($content, $assoc = false) {
        require_once WP_PLUGIN_DIR . '/' . WP_EMEMBER_FOLDER . '/JSON.php';
        if ($assoc)
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        else
            $json = new Services_JSON;
        return $json->decode($content);
    }

}

if (!function_exists('json_encode')) {

    function json_encode($content) {
        require_once WP_PLUGIN_DIR . '/' . WP_EMEMBER_FOLDER . '/JSON.php';
        $json = new Services_JSON;
        return $json->encode($content);
    }

}

function eMember_send_aweber_mail($list_name, $from_address, $cust_name, $cust_email) {
    $subject = "Aweber Automatic Sign up email";
    $body = "\n\nThis is an automatic email that is sent to AWeber for member signup purpose\n" .
            "\nEmail: " . $cust_email .
            "\nName: " . $cust_name;

    $headers = 'From: ' . $from_address . "\r\n";
    wp_mail($list_name, $subject, $body, $headers);
}

function get_real_ip_addr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];

    return $ip;
}

function eMember_get_string_between($string, $start, $end) {
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
        return "";
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function print_password_reset_form() {
    ob_start();
    if (isset($_POST['wp_emember_email_password_doSend'])) {
        $status = wp_emember_generate_and_mail_password($_POST['wp_emember_reset_password_email']);
        if ($status['status_code'])
            echo '<span style="color:green;">' . $status['msg'] . '</span>';
        else
            echo '<span style="color:red;">' . $status['msg'] . '</span>';
    }
    ?>
    <script type="text/javascript">
        /* <![CDATA[ */
        jQuery(document).ready(function($) {
    <?php include_once(WP_EMEMBER_PATH . '/js/emember_js_form_validation_rules.php'); ?>
            $("#wp_emember_mailSendForm").validationEngine('attach');
        });
        /*]]>*/
    </script>
    <div id="wp_emember_email_mailForm">
        <?php echo EMEMBER_PASS_RESET_MSG; ?>
        <form action="" name="wp_emember_mailSendForm" id="wp_emember_mailSendForm1" method="post"  >
            <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
                <tr>
                    <td><label for="wp_emember_reset_password_email" class="eMember_label"><?php echo EMEMBER_EMAIL; ?>: </label></td>
                    <td><input class="validate[required,custom[email]] eMember_text_input" type="text" id="wp_emember_reset_password_email" name="wp_emember_reset_password_email" size="20" value="" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input name="wp_emember_email_password_doSend" type="submit" id="wp_emember_email_password_doSend" class="emember_button"  value="<?php echo EMEMBER_RESET; ?>" /></td>
                </tr>
            </table>
        </form>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function wp_emember_generate_and_mail_password($email) {
    global $wpdb;
    if (empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
        if (empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
            return array('status_code' => false, 'msg' => EMEMBER_EMAIL_NOT_EXIST);
    $emember_config = Emember_Config::getInstance();
    $emailId = esc_sql(trim($email));
    $user = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, 'email=\'' . $emailId . '\'');
    if ($user) {
        require_once('rand_pass.php');
        include_once(ABSPATH . WPINC . '/class-phpass.php');
        $wp_hasher = new PasswordHash(8, TRUE);

        $reset_pass = utility::generate_password();
        //send mail from here with user name & password
        $wp_user_id = username_exists($user->user_name);
        if ($wp_user_id) {
            $wp_user_info = array();
            $wp_user_info['user_pass'] = $reset_pass;
            $wp_user_info['ID'] = $wp_user_id;
            wp_update_user($wp_user_info);
        }
        $fields = array();
        $password = $wp_hasher->HashPassword($reset_pass);
        $fields['password'] = esc_sql($password);
        dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id = ' . $user->member_id, $fields);
        $email_body = $emember_config->getValue('eMember_fogot_pass_email_body');
        $email_subject = $emember_config->getValue('eMember_fogot_pass_email_subject');
        $tags1 = array("{first_name}", "{last_name}", "{user_name}", "{password}");
        $vals1 = array($user->first_name, $user->last_name, $user->user_name, $reset_pass);
        $email_body = str_replace($tags1, $vals1, $email_body);
        $from_address = $emember_config->getValue('eMember_fogot_pass_senders_email_address');
        $headers = 'From: ' . $from_address . "\r\n";
        wp_mail($emailId, $email_subject, $email_body, $headers);
        eMember_log_debug("Member password reset email sent to : " . $emailId, true);

        //Update the affiliate profile password if applicable
        eMember_handle_affiliate_password_reset($emailId, $password);

        return array('status_code' => true, 'msg' => EMEMBER_PASS_EMAILED_MSG);
    } else
        return array('status_code' => false, 'msg' => EMEMBER_EMAIL_NOT_EXIST);
}

function wp_emember_get_profile_image_url_by_id($id) {
    $emember_config = Emember_Config::getInstance();
    $image_url = null;
    $image_path = null;
    $upload_dir = wp_upload_dir();
    $upload_url = $upload_dir['baseurl'];
    $upload_path = $upload_dir['basedir'];
    $upload_url .= '/emember/';
    $upload_path .= '/emember/';
    $upload_url .= $id;
    $upload_path .= $id;
    if (file_exists($upload_path . '.jpg')) {
        $image_url = $upload_url . '.jpg?' . time();
        $image_path = $upload_path . '.jpg';
    } else if (file_exists($upload_path . '.jpeg')) {
        $image_url = $upload_url . '.jpeg?' . time();
        $image_path = $upload_path . '.jpeg';
    } else if (file_exists($upload_path . '.gif')) {
        $image_url = $upload_url . '.gif?' . time();
        $image_path = $upload_path . '.gif';
    } else if (file_exists($upload_path . '.png')) {
        $image_url = $upload_url . '.png?' . time();
        $image_path = $upload_path . '.png';
    } else {
        $use_gravatar = $emember_config->getValue('eMember_use_gravatar');
        if ($use_gravatar)
            $image_url = WP_EMEMBER_GRAVATAR_URL . "/" . md5(strtolower($email)) . "?d=" . urlencode(404) . "&s=" . 96;
        else
            $image_url = WP_EMEMBER_URL . '/images/default_image.gif';
    }
    return $image_url;
}

function wp_emember_get_profile_image_url_by_id_no_gravatar($id) {
    $emember_config = Emember_Config::getInstance();
    $image_url = "";
    $image_path = null;
    $upload_dir = wp_upload_dir();
    $upload_url = $upload_dir['baseurl'];
    $upload_path = $upload_dir['basedir'];
    $upload_url .= '/emember/';
    $upload_path .= '/emember/';
    $upload_url .= $id;
    $upload_path .= $id;
    if (file_exists($upload_path . '.jpg')) {
        $image_url = $upload_url . '.jpg?' . time();
        $image_path = $upload_path . '.jpg';
    } else if (file_exists($upload_path . '.jpeg')) {
        $image_url = $upload_url . '.jpeg?' . time();
        $image_path = $upload_path . '.jpeg';
    } else if (file_exists($upload_path . '.gif')) {
        $image_url = $upload_url . '.gif?' . time();
        $image_path = $upload_path . '.gif';
    } else if (file_exists($upload_path . '.png')) {
        $image_url = $upload_url . '.png?' . time();
        $image_path = $upload_path . '.png';
    }
    return $image_url;
}

function wp_emember_format_message($msg) {
    $emember_config = Emember_Config::getInstance();
    if ($emember_config->getValue('eMember_turn_off_protected_msg_formatting') == '1') {//do not apply formatting
        return $msg;
    }
    $output = '<span class="wp-emember-warning-msgbox">';
    $output .= '<span class="wp-emember-warning-msgbox-image"><img width="40" height="40" src="' . WP_EMEMBER_URL . '/images/warn_msg.png" alt=""/></span>';
    $output .= '<span class="wp-emember-warning-msgbox-text">' . $msg . '</span>';
    $output .= '</span>';
    $output .= '<span class="eMember-clear-float"></span>';
    return $output;
}

function wp_emember_redirect_to_url($url) {
    if (empty($url))
        return;
    if (!headers_sent()) {
        header('Location: ' . $url);
        //wp_safe_redirect($url);
    } else {
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    }
    exit;
}

function wp_emember_add_name_value_pair_to_url($url, $nvp_string) {
    $separator = '?';
    if (strpos($url, '?') !== false) {
        $separator = '&';
    }
    return $url . $separator . $nvp_string;
}

function wp_emember_printd($ar) {
    echo '<pre>';
    print_r($ar);
    echo '</pre>';
}

function wp_eMember_registration_form_handler($atts) {
    extract(shortcode_atts(array(
        'level' => '',
                    ), $atts));
    return show_registration_form($level);
}

function emember_total_members_handler($attrs, $contents, $codes = '') {
    return emember_get_total_members($attrs);
}

function emember_first_name_handler() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $first_name = "";
    if ($emember_auth->isLoggedIn()) {
        $first_name = $emember_auth->getUserInfo('first_name');
    }
    return $first_name;
}

function emember_last_name_handler() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $last_name = "";
    if ($emember_auth->isLoggedIn()) {
        $last_name = $emember_auth->getUserInfo('last_name');
    }
    return $last_name;
}

function wp_eMember_user_details_handler($atts) {
    extract(shortcode_atts(array(
        'user_info' => '',
        'member_id' => '',
                    ), $atts));

    if (!empty($member_id)) {//Details of a specific member
        return wp_emember_get_user_details_by_id($user_info, $member_id);
    } else {//Details of the logged in member
        return wp_eMember_get_user_details($user_info);
    }
}

function wp_emember_get_user_details_by_id($key, $member_id) {
    if (empty($key)) {
        return '<p style="emember_error">You need to specify a user info field to use this function.</p>';
    }

    global $wpdb;
    $membership_lvl_tbl = WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE;
    $profile = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . $member_id);

    if ($key === "user_membership_level_name") {//Membership level name
        //TODO - need to work it out //return $profile->user_membership_level_name;
    }
    if ($key === "user_additional_membership_level_names") {
        if ($profile->more_membership_levels) {
            $names = $wpdb->get_col("SELECT alias FROM $membership_lvl_tbl WHERE id IN (" . $profile->more_membership_levels . ")");
            return implode(', ', $names);
        }
        return "";
    }
    if ($key === "profile_picture") {//member's profile pic embedded with class eMember_custom_profile_picture
        //TODO - return $this->getProfilePictureEmbeded();
    }
    if ($key === "profile_picture_src") {//member's profile picture raw image URL
        return $profile->profile_image;
    }
    if ($key === "member_expiry_date") {
        return emember_get_expiry_by_member_id($member_id);
    }
    if (isset($profile->$key) && !empty($profile->$key)) {
        return $profile->$key;
    }
    $key = stripslashes($key);
    $key = str_replace(array('\\', '\'', '(', ')', '[', ']', ' ', '"', '%', '<', '>'), "_", $key);
    $customUserInfo = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, 'user_id=' . $member_id . ' AND meta_key=\'custom_field\'');
    $customUserInfo = unserialize($customUserInfo->meta_value);
    if (isset($customUserInfo[$key]) && !empty($customUserInfo[$key])) {
        return $customUserInfo[$key];
    }
}

function wp_eMember_get_user_details($user_info) {
    if (empty($user_info)) {
        return '<p style="emember_error">You need to specify a user info field to use this function.</p>';
    }
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $info_value = "";
    if ($emember_auth->isLoggedIn()) {
        $info_value = $emember_auth->getUserInfo($user_info);
    } else {
        $info_value = EMEMBER_NOT_LOGGED_IN;
    }
    return $info_value;
}

function emember_dynamically_replace_member_details_in_message($member_id, $message_body, $additional_params = '') {
    global $wpdb;
    $emember_config = Emember_Config::getInstance();
    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . $member_id);
    $password = "";
    $login_link = "";
    if (!empty($additional_params)) {
        $password = $additional_params['password'];
        $login_link = $additional_params['login_link'];
    }
    $level_name = emember_get_membership_level_by_id($resultset->membership_level);

    $tags = array("{member_id}", "{user_name}", "{first_name}", "{last_name}", "{member_since}", "{membership_level}",
        "{more_membership_levels}", "{account_state}", "{email}", "{phone}", "{address_street}", "{address_city}", "{address_state}",
        "{address_zipcode}", "{home_page}", "{country}", "{gender}", "{referrer}", "{extra_info}", "{subscription_starts}",
        "{txn_id}", "{subscr_id}", "{company_name}", "{password}", "{login_link}", "{membership_level_name}"
    );

    $vals = array($member_id, $resultset->user_name, $resultset->first_name, $resultset->last_name, $resultset->member_since, $resultset->membership_level,
        $resultset->more_membership_levels, $resultset->account_state, $resultset->email, $resultset->phone, $resultset->address_street,
        $resultset->address_city, $resultset->address_state, $resultset->address_zipcode, $resultset->home_page, $resultset->country,
        $resultset->gender, $resultset->referrer, $resultset->extra_info, $resultset->subscription_starts, $resultset->txn_id,
        $resultset->subscr_id, $resultset->company_name, $password, $login_link, $level_name
    );
    if ($emember_config->getValue('eMember_custom_field')) {
        $wpememmeta = new WPEmemberMeta();
        $member_meta_tbl = $wpememmeta->get_table('member_meta');
        $custom_fields = get_option('emember_custom_field_type');
        $custom_names = (array) $custom_fields['emember_field_name'];
        $custom_types = (array) $custom_fields['emember_field_type'];
        $custom_extras = (array) $custom_fields['emember_field_extra'];
        $custom_values = $wpdb->get_col("select meta_value from " . $member_meta_tbl
                . ' WHERE  user_id=' . $member_id . ' AND meta_key="custom_field"');
        $custom_values = unserialize(isset($custom_values[0]) ? $custom_values[0] : "");
        if (empty($custom_values))
            $custom_values = array();
        foreach ($custom_names as $i => $name) {
            $name = stripslashes($name);
            $index = emember_escape_custom_field($name);
            $tags[] = "{" . $index . "}";
            $v = isset($custom_values[$index]) ? $custom_values[$index] : "";
            if ($custom_types[$i] == 'dropdown') {
                $m = explode(",", stripslashes($custom_extras[$i]));
                $e = array();
                foreach ($m as $k) {
                    $k = explode("=>", $k);
                    $e[$k[0]] = $k[1];
                }
                $v = isset($e[$v]) ? $e[$v] : "";
            }
            $vals[] = stripslashes($v);
        }
    }
    $message_body = str_replace($tags, $vals, $message_body);
    return $message_body;
}

function emember_get_total_members($args) {
    global $wpdb;
    if (isset($args['level'])) {
        $level = $args['level'];
        $emember_user_count = $wpdb->get_row("SELECT COUNT(*) as count FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . ' WHERE membership_level=' . $level . ' ORDER BY member_id');
    } else {
        $emember_user_count = $wpdb->get_row("SELECT COUNT(*) as count FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . ' ORDER BY member_id');
    }
    return $emember_user_count->count;
}

function emember_preloader($colspan) {
    $imgpath = WP_EMEMBER_URL . '/images/loading.gif';
    $preloader = '<img src="' . $imgpath . '" />';
    $preloader = '<tr valign="top"><td align="center" colspan="' . $colspan . '">' . $preloader . '</td></tr>';
    return $preloader;
}

function emember_is_first_click() {
    $emember_config = Emember_Config::getInstance();
    $enabled = $emember_config->getValue('eMember_google_first_click_free');
    if (!$enabled)
        return false;
    $agent = false;
    $_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
    $_SERVER['HTTP_USER_AGENT'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
    if (stripos($_SERVER['HTTP_USER_AGENT'], "Googlebot") != false) {
        $agent = 'Googlebot';
        $ip = $_SERVER['REMOTE_ADDR'];
        $name = gethostbyaddr($ip);
        if (stripos($name, $agent) != false) {
            //list of IP's
            $hosts = gethostbynamel($name);
            foreach ($hosts as $host) {
                if ($host == $ip)
                    return true;
            }
        }
    }
    else {
        $google = '{^[a-z]+://[^.]*\.google\.}i';
        $found_google = stripos($_SERVER['HTTP_REFERER'], '.google.');
        if (($found_google != false) && preg_match($google, $_SERVER['HTTP_REFERER'])) {
            $agent = 'google';
            $name = $_SERVER['HTTP_REFERER'];
            return true;
        }
    }
    return false;
}

function wp_emember_redirect_to_non_logout_url() {
    //redirect to the URL without the "member_logout" GET Parameter
    $parsed_url = explode('?', wp_emember_get_current_url());
    $url = $parsed_url[0];
    if (isset($parsed_url[1])) {
        $parsed_query = array();
        parse_str($parsed_url[1], $parsed_query);
        unset($parsed_query['member_logout']);
        $parsed_url = http_build_query($parsed_query);
        if ($parsed_url)
            $url .= '?' . $parsed_url;
    }
    wp_emember_redirect_to_url($url);
}

function wp_get_url_subdomain($url) {
    $url_components = parse_url($url);
    $path = (isset($url_components['path']) ? $url_components['path'] : "");
    $query = (isset($url_components['query']) ? '?' . $url_components['query'] : "");
    $uri = $path . $query;
    return empty($uri) ? '#' : $uri;
}

function wp_emember_get_current_url() {
    $pageURL = 'http';
    if (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI']))
        return $_SERVER['SCRIPT_URI'];
    if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if (isset($_SERVER["SERVER_PORT"]) && ($_SERVER["SERVER_PORT"] != "80")) {
        $pageURL .= ltrim($_SERVER["SERVER_NAME"], ".*")/* ":".$_SERVER["SERVER_PORT"] */ . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= ltrim($_SERVER["SERVER_NAME"], ".*") . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function wp_emember_get_query_separator_for_url($url) {
    $separator = '?';
    if (strpos($url, '?') !== false) {
        $separator = '&';
    }
    return $separator;
}

function emember_get_after_login_page_url_of_current_user() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();

    $after_login_page = $emember_auth->getUserInfo('home_page');
    if (!empty($after_login_page)) {
        return $after_login_page;
    }//This member has a member specific welcome page

    $after_login_page = $emember_auth->getLevelInfo('loginredirect_page');
    if (!empty($after_login_page)) {
        return $after_login_page;
    }//This member has a membership level specific welcome page

    $after_login_page = $emember_config->getValue('after_login_page');
    if (!empty($after_login_page)) {
        return $after_login_page;
    }//Global member welcome page

    return ""; //No welcome page specified
}

function emember_date_locale($timestamp) {
    $emember_config = Emember_Config::getInstance();
    $lang = $emember_config->getValue('eMember_language');
    $locales = array('fr' => 'fr_FR.UTF-8',
        'ger' => 'de_DE.UTF-8',
        'heb' => 'he_IL.utf8',
        'ita' => 'it_IT.UTF-8',
        'nld' => 'nl_NL.UTF-8',
        'pl' => 'pl.UTF-8',
        'spa' => 'es_ES.UTF-8'
    );
    if (isset($locales[$lang])) {

    }
    if ($lang != 'eng')
        return date('d-m-Y', $timestamp);
    return date(get_option('date_format'), $timestamp);
}

function eMember_is_multisite_install() {
    if (function_exists('is_multisite') && is_multisite()) {
        return true;
    } else {
        return false;
    }
}

function eMember_wp_create_user($user_name, $password, $email, $more = array()) {
    $more['role'] = isset($more['role']) ? $more['role'] : 'subscriber';
    if (eMember_is_multisite_install()) {//MS install
        global $blog_id;
        if ($wp_user_id = email_exists($email)) {// if user exists then just add him to current blog.
            add_existing_user_to_blog(array('user_id' => $wp_user_id, 'role' => 'subscriber'));
            return $wp_user_id;
        }
        $wp_user_id = wpmu_create_user($user_name, $password, $email);
        if (is_wp_error($wp_user_id)) {
            eMember_log_debug("Error:  " . $wp_user_id->get_error_message(), true);
            return $wp_user_id;
        }
        eMember_log_debug("Creating WP User using Multi site API. User ID: " . $wp_user_id . " Blog ID: " . $blog_id, true);
        $more['ID'] = $wp_user_id;
        wp_update_user($more);
        update_wp_user_Role($wp_user_id, $more['role']);
        $role = $more['role'];
        if (add_user_to_blog($blog_id, $wp_user_id, $role)) {//Add user to the current blog
            eMember_log_debug("WP MS user successfully added to blog ID: " . $blog_id, true);
        } else {
            eMember_log_debug("WP MS user addition to blog failed!", false);
        }
        return $wp_user_id;
    } else {//Single site install
        $wp_user_id = wp_create_user($user_name, $password, $email);
        if (is_wp_error($wp_user_id)) {
            eMember_log_debug("Error:  " . $wp_user_id->get_error_message(), true);
            return $wp_user_id;
        }
        $more['ID'] = $wp_user_id;
        wp_update_user($more);
        update_wp_user_Role($wp_user_id, $more['role']);
        eMember_log_debug("Creating WP User using single site API. User ID: " . $wp_user_id, true);
        return $wp_user_id;
    }
}

function emember_replace_avatar($avatar, $id_or_email = '', $size = 96, $default = null, $alt = '') {
    $emember_email = '';
    global $wpdb;

    if (empty($id_or_email))
        return $avatar; //not a user. so dont modify it.
    if (is_numeric($id_or_email)) {
        $user_details = get_userdata($id_or_email);
        if ($user_details)
            $emember_email = $user_details->user_email;
    }
    else if (is_object($id_or_email)) {
        $allowed_comment_types = apply_filters('get_avatar_comment_types', array('comment'));
        if (!empty($id_or_email->comment_type) && !in_array($id_or_email->comment_type, (array) $allowed_comment_types))
            return false;
        if (!empty($id_or_email->user_id)) {
            $id = $id_or_email->user_id;
            $user = get_userdata($id);
            if ($user)
                $emember_email = $user->user_email;
        }else if (!empty($id_or_email->comment_author_email)) {
            $emember_email = $id_or_email->comment_author_email;
        }
    } else {
        $emember_email = $id_or_email;
    }
    $emember_userid = $wpdb->get_col("SELECT member_id from " . WP_EMEMBER_MEMBERS_TABLE_NAME . " WHERE email ='{$emember_email}'");
    if (empty($emember_userid))
        return $avatar;
    $image_url = wp_emember_get_profile_image_url_by_id_no_gravatar($emember_userid[0]);
    if (empty($image_url))
        return $avatar;
    //Override the avatar image with eMember's one
    $avatar = "<img alt='{$alt}' src='{$image_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    return $avatar;
}

function emember_update_membership_level($member_id, $target_membership_level) {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    global $wpdb;
    $resultset = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id=' . esc_sql($member_id));
    $target_level_info = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id=' . esc_sql($target_membership_level));
    if ($resultset->membership_level != $target_membership_level) {
        if ($emember_config->getValue('eMember_enable_secondary_membership')) {
            $additional_levels = $resultset->more_membership_levels;
            $active_membership_level = $resultset->membership_level;
            $additional_levels = array_filter(explode(',', $additional_levels));
            $additional_levels[] = $active_membership_level;
            $additional_levels = array_unique($additional_levels);
            $additional_levels = implode(',', $additional_levels);
            $level_info['membership_level'] = trim($target_membership_level);
            $level_info['more_membership_levels'] = $additional_levels;
        } else
            $level_info['membership_level'] = trim($target_membership_level);
        dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id=' . $member_id, $level_info);
    }
    emember_update_wp_role_for_member($resultset->user_name, $target_level_info->role);
}

function emember_update_subsc_start_date($member_id, $new_start_date = '')
{
    global $wpdb;
    $members_table_name = $wpdb->prefix . "wp_eMember_members_tbl";
    if(empty($new_start_date)){
        $new_start_date = date("Y-m-d");//Set current date by default
    }
    eMember_log_debug("Updating the subscripiton start date of member. Member ID: ".$member_id.", To Date: " . $new_start_date, true);
    $updatedb = "UPDATE $members_table_name SET subscription_starts='$new_start_date' WHERE member_id='$member_id'";
    $results = $wpdb->query($updatedb);
}

function emember_update_wp_role_for_member($eMember_username, $role_name) {
    $emember_config = Emember_Config::getInstance();
    $user_wp_integration = $emember_config->getValue('eMember_create_wp_user');
    if ($user_wp_integration) {
        $user_info = get_user_by('login', $eMember_username);
        eMember_log_debug("The username of the member :" . $eMember_username . " ,WP User ID is: " . $user_info->ID . " , Target role name: " . $role_name, true);
        update_wp_user_Role($user_info->ID, $role_name);
    }
}

function emember_multi_submit_check($salt_string = '') {//Returns true if not a duplicate submission
    if (empty($salt_string)) {
        $string = $_REQUEST['emember_form_time_value'];
    } else {
        $string = $salt_string;
    }
    if (isset($_SESSION['emember_multi_submission_check'])) {
        if ($_SESSION['emember_multi_submission_check'] === md5($string)) {
            return false;
        } else {
            $_SESSION['emember_multi_submission_check'] = md5($string);
            return true;
        }
    } else {
        $_SESSION['emember_multi_submission_check'] = md5($string);
        return true;
    }
}

function emember_add_uploaded_file_to_inventory($filename, $guid, $date) {
    global $wpdb;
    $query = "INSERT INTO " . $wpdb->prefix .
            "emember_uploads (filename, guid, mime_type,upload_date) VALUES('" .
            $filename . "','" . $guid . "','','" . $date . "')";
    $wpdb->query($query);
}

function emember_get_membership_level_by_id($id) {
    global $wpdb;
    $table = WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE;
    $query = "SELECT alias FROM " . $table . " WHERE id= %s";
    return $wpdb->get_var($wpdb->prepare($query, $id));
}

function eMember_is_duplicate_submission() {
    //echo "<br />Session: ".$_SESSION['emember_dsc_nonce']." |Nonce: ".$_REQUEST['emember_dsc_nonce'];
    if (isset($_SESSION['emember_dsc_nonce']) && $_SESSION['emember_dsc_nonce'] == $_REQUEST['emember_dsc_nonce']) {
        return true;
    }
    return false;
}

function get_wp_emember_custom_field_val($args) {
    if (!isset($args['level_id'])) {
        echo "Error! You must specify a level ID with this shortcode";
        return;
    }
    $custom_val = 'subsc_ref=' . $args['level_id'];

    if (isset($_SESSION['ap_id'])) {
        $referrer = $_SESSION['ap_id'];
    } else if (isset($_COOKIE['ap_id'])) {
        $referrer = $_COOKIE['ap_id'];
    }
    if (!empty($referrer)) {
        $custom_val .= '&ap_id=' . $referrer;
    }

    $emember_auth = Emember_Auth::getInstance();
    $user_id = $emember_auth->getUserInfo('member_id');
    if (!empty($user_id)) {
        $custom_val .= '&eMember_id=' . $user_id;
    }
    return $custom_val;
}

function emember_escape_custom_field($name) {
    return str_replace(array('\\', '\'', '(', ')', '[', ']', ' ', '"', '%', '<', '>', '?'), "_", $name);
}

function emember_add_no_redirect_param_if_applicable($url)
{
    if(isset($_REQUEST['no-redirect']) && $_REQUEST['no-redirect'] == '1'){//Append the no-redirect query param to the URL
        $arr_params = array('no-redirect' => '1');
        $url = add_query_arg($arr_params, $url);
    }
    return $url;
}

function emember_country_list_dropdown($select = "") {
    $countries = array("", "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia",
        "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia",
        "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde",
        "Central African Republic", "Chad", "Chile", "China", "Colombi", "Comoros", "Congo (Brazzaville)", "Congo", "Costa Rica", "Cote d\'Ivoire",
        "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor (Timor Timur)", "Ecuador",
        "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia, The", "Georgia",
        "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Hong Kong","Haiti", "Honduras", "Hungary", "Iceland", "India",
        "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North",
        "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg","Macao",
        "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia",
        "Moldova", "Monaco", "Mongolia", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepa", "Netherlands", "New Zealand", "Nicaragua", "Niger",
        "Nigeria", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar",
        "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent", "Samoa", "San Marino", "Sao Tome and Principe",
        "Saudi Arabia", "Senegal", "Serbia and Montenegro", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands",
        "Somalia", "South Africa", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan",
        "Tanzania", "Thailand", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine",
        "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela",
        "Vietnam", "Yemen", "Zambia", "Zimbabwe");
    $options = '';
    foreach ($countries as $country) {
        $selected = (strtolower($country) == strtolower($select)) ? "selected='selected'" : "";
        $options .= "<option $selected value='" . $country . "' > $country </option>";
    }
    return $options;
}
