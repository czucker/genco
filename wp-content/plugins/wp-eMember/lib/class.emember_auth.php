<?php

class Emember_Auth {
    /* object: protected level.
     * @access public
     */

    public $protected;
    /* object: containing details of primary and secondary levels
     * of current user.
     * @access public
     */
    public $permitted;
    /* bool: login flag.
     * @access private
     */
    private $isLoggedIn;
    /*
     * string: login status messages
     * @access private
     */
    private $lastStatusMsg;
    /*
     * integer: numeric login status code
     * @access private
     */
    private $error_code;
    /*
     * object: static reference of instance of this class
     * @access private
     * @static
     */
    private static $_this;
    /*
     * object: detail information of current user
     * @access public
     */
    private $userInfo;
    private $credentials;
    private $isFeed;
    private function __construct() {
        $this->isLoggedIn = false;
        $this->isFeed = false;
        $this->userInfo = null;
        $this->credentials = array();
        $this->inactivity = 0;   //inactivity duration
        $this->protected = Emember_Protection::get_instance();
    }

    //its a tie-breaker. calling do_action inside a constructor can lead to dangerous recursion!!!!
    private function init() {
        if (!$this->validate()) {
            $this->authenticate();
        }
    }

    public static function getInstance() {
        if (empty(self::$_this)) {
            self::$_this = new Emember_Auth();
            self::$_this->init();
        }
        return self::$_this;
    }

    public function login_through_wp($username, $remember = '', $secure = '') {
        eMember_log_debug("login_through_wp called with username=" . $username, true);
        if ($this->isLoggedIn)
            return;
        global $wpdb;
        $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $query.= " WHERE user_name = '" . $username . "'";
        $this->userInfo = $wpdb->get_row($query);
        //skip password check
        if (!$this->userInfo) {
            $this->lastStatusMsg = EMEMBER_WRONG_USER_PASS;
            $this->errorCode = 1;
            return false;
        }
        $this->authenticate($remember, $secure);
        return $this->lastStatusMsg;
    }

    public function login_with_user_id($user_id, $remember = '', $secure = '') {
        eMember_log_debug("login_with_user_id called with user_id=" . $user_id, true);
        if ($this->isLoggedIn)
            return;
        global $wpdb;
        $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $query .= ' WHERE member_id=\'' . strip_tags($user_id) . '\' ';
        $this->userInfo = $wpdb->get_row($query);
        if (!$this->userInfo) {
            $this->lastStatusMsg = EMEMBER_WRONG_USER_PASS;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 1;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
            return false;
        }
        $this->authenticate($remember, $secure);
        return $this->lastStatusMsg;
    }

    /* authenticate for secure feed processing
     * doesn't set any auth cookie. doesn't fire any action/filter
     * authentication is valid for just one request.
     * @method login_with_feed_key
     * @param $key encrypted feed key
     * @access public
     */

    public function login_with_feed_key($key) {
        eMember_log_debug("login_with_feed_key called with feed key=" . $key, true);
        global $wpdb;
        $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $query .= ' WHERE md5(member_id)=\'' . strip_tags($key) . '\'';
        $this->userInfo = $wpdb->get_row($query);
        if (!$this->userInfo) {
            $this->lastStatusMsg = EMEMBER_WRONG_USER_PASS;
            $this->errorCode = 1;
            return false;
        }
        if ($this->check_constraints()) {
            $this->isLoggedIn = true;
            $this->isFeed = true;
            $this->lastStatusMsg = "";
            // for secure feed login, this is not required.
            self::setSavedMessage('eMember_login_status_msg', "");
            self::setSavedMessage('eMember_login_status_code', "");
            return true;
        }
        $this->isLoggedIn = false;
        $this->userInfo = null;
        $this->errorCode = 1;
        $this->lastStatusMsg = "";
    }

    public function login_with_user_pass($user, $pass, $remember = '', $secure = '') {
        eMember_log_debug("login_with_user_pass called with user=" . $user, true);
        if ($this->isLoggedIn)
            return;
        global $wpdb;
        $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $query.= " WHERE user_name = '" . $user . "'";
        $this->credentials = array("user" => $user, "pass" => $pass);
        $this->userInfo = $wpdb->get_row($query);
        if (!$this->userInfo) {
            $this->lastStatusMsg = EMEMBER_WRONG_USER_PASS;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 1;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
            return false;
        }
        $check = $this->check_password($pass, $this->userInfo->password);
        $this->authenticate($remember, $secure);
        return $this->lastStatusMsg;
    }

    /**
     * authenticate method will try to grab user/pass from $_POST/$_GET.
     * it will try to extract user data from userInfo member variable if
     * $_GET/$_POST doesn't have it.
     * @global type $wpdb
     * @param type $remember
     * @param type $secure
     * @return boolean
     */
    private function authenticate($remember = '', $secure = '') {
        //eMember_log_debug("authenticate called with userInfo=" . json_encode($this->userInfo), true);
        if ($this->isLoggedIn) {
            return true;
        }
        global $wpdb;
        $emember_config = Emember_Config::getInstance();
        $offset = time() - 604800;
        $wpdb->query("DELETE FROM " . WP_EMEMBER_AUTH_SESSION_TABLE . " WHERE login_impression<$offset");
        $check = true;
        $current_ip = get_real_ip_addr();
        $user = $this->track_user_name();
        $pass = $this->track_password();
        if (!empty($user) && !empty($pass)) {
            $user = sanitize_user($user);
            $pass = trim($pass);
            $this->credentials = array("user" => $user, "pass" => $pass);
            $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
            $query.= " WHERE user_name = '" . $user . "'";
            $this->userInfo = $wpdb->get_row($query);
            //eMember_log_debug(__LINE__ . json_encode($this->userInfo), true);
            if (!$this->userInfo) {
                $this->lastStatusMsg = EMEMBER_WRONG_USER_PASS;
                self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
                $this->errorCode = 1;
                self::setSavedMessage('eMember_login_status_code', $this->errorCode);
                return false;
            }
            $check = $this->check_password($pass, $this->userInfo->password);
        }

        if (!$check) {
            $this->isLoggedIn = false;
            $this->userInfo = null;
            $this->lastStatusMsg = "Password Empty or Invalid.";
            $this->error_code = 7;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
            return false;
        }
        if (!$this->userInfo) {
            $this->errorCode = 1;
            return false;
        }
        $login_limit = $emember_config->getValue('eMember_login_limit');
        if ($login_limit) {
            $query = "SELECT meta_value FROM " . WP_EMEMBER_MEMBERS_META_TABLE .
                    " WHERE user_id = " . $this->userInfo->member_id .
                    " AND meta_key = 'login_count'";
            $login_count = $wpdb->get_col($query);
            $login_count = isset($login_count[0]) ? unserialize($login_count[0]) : array();
            if (isset($login_count[date('y-m-d')])) {
                array_push($login_count[date('y-m-d')], $current_ip);
                $login_count[date('y-m-d')] = array_unique($login_count[date('y-m-d')]);
                if (count($login_count[date('y-m-d')]) > intval($login_limit)) {
                    $this->isLoggedIn = false;
                    $this->userInfo = null;
                    $this->lastStatusMsg = EMEMBER_LOGIN_LIMIT_ERROR;
                    $this->error_code = 10;
                    self::setSavedMessage('eMember_login_status_code', $this->errorCode);
                    self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
                    return false;
                }
                $query = "UPDATE " . WP_EMEMBER_MEMBERS_META_TABLE .
                        " SET meta_value = '" . serialize($login_count) . "'" .
                        " WHERE user_id= " . $this->userInfo->member_id .
                        " AND meta_key = 'login_count'";
                $wpdb->query($query);
            } else {
                $login_count = serialize(array(date('y-m-d') => array($current_ip)));
                $query = "INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
                        "(user_id,meta_key,meta_value)" .
                        "VALUES(" . $this->userInfo->member_id . ", 'login_count', '" . $login_count . "')";
                $wpdb->query($query);
            }
        }
        //eMember_log_debug("before check userInfo=" . json_encode($this->userInfo), true);
        if ($this->check_constraints()) {
            $remember = isset($_POST['rememberme']) ? true : false;
            $s = $this->set_cookie($remember);
            $this->isLoggedIn = true;
            $this->lastStatusMsg = EMEMBER_ALREADY_LOGGED_IN;
            $this->error_code = 13;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
            if (count($this->credentials) == 2)
                do_action('emember_login', $user, $pass, $remember);
            do_action('eMember_login_complete');
            return true;
        }
        $this->isLoggedIn = false;
        $this->userInfo = null;
        $this->errorCode = 1;
        return false;
    }

    private function check_constraints() {
        $config = Emember_Config::getInstance();
        if (empty($this->userInfo)) {
            return false;
        }
        //store last access location and time in members table
        dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id=' . $this->userInfo->member_id, array('last_accessed_from_ip' => get_real_ip_addr(),
            'last_accessed' => current_time('mysql', 1)));
        $valid = true;

        if ($this->userInfo->account_state == 'inactive') {
            do_action("emember_account_login_status_inactive", $this->userInfo->member_id);
            $this->lastStatusMsg = EMEMBER_ACCOUNT_INACTIVE;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 3;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
            $valid = false;
        }
        if ($this->userInfo->account_state == 'pending') {
            do_action("emember_account_login_status_pending", $this->userInfo->member_id);
            $this->lastStatusMsg = EMEMBER_ACCOUNT_PENDING;
            $valid = false;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 3;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }

        if (!$valid) {
            //set_transient( 'eMember_login_status_msg', "", 3600 );
            //$this->lastStatusMsg = EMEMBER_NOT_LOGGED_IN;
            $this->isLoggedIn = false;
            $this->userInfo = null;
            return false;
        }
        //@todo: check if account expired and update db if it did.
        //@todo: update ip last access time
        $customUserInfo = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, 'user_id=' .
                        $this->userInfo->member_id . ' AND meta_key=\'custom_field\'');
        $customUserInfo = isset($customUserInfo->meta_value) ? $customUserInfo->meta_value : "";
        $this->customUserInfo = unserialize($customUserInfo);
        $this->permitted = new Emember_User_Permission($this->userInfo);
        if (wp_emember_is_subscription_expired($this->userInfo, $this->permitted->primary_level)) {
            $status = 'expired';
            dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id=' .
                    $this->userInfo->member_id, array('account_state' => $status));
            $this->userInfo->account_state = 'expired';
            //do_action("emember_account_$status", $this->userInfo->member_id);//TODO - remove this
        }
        $allow_expired_account = $config->getValue('eMember_allow_expired_account');
        if ($this->userInfo->account_state == 'expired') {
            do_action("emember_account_login_status_expired", $this->userInfo->member_id);
            if (!$allow_expired_account) {
                $this->errorCode = 8;
                $valid = false;
                $this->lastStatusMsg = EMEMBER_SUBSCRIPTION_EXPIRED_MESSAGE;
                self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
                self::setSavedMessage('eMember_login_status_code', $this->errorCode);
                $this->isLoggedIn = false;
                return false;
            }
        }
        $this->lastStatusMsg = EMEMBER_LOGGED_IN_AS . $this->userInfo->user_name;
        self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
        $this->errorCode = 4;
        self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        $this->isLoggedIn = true;
        return true;
    }

    private function check_password($password, $hash) {
        global $wp_hasher;
        if (empty($password)) {
            return false;
        }
        if (empty($wp_hasher)) {
            require_once( ABSPATH . 'wp-includes/class-phpass.php');
            $wp_hasher = new PasswordHash(8, TRUE);
        }
        $check = $wp_hasher->CheckPassword($password, $hash);
        if (!$check) {
            $this->isLoggedIn = false;
            $this->userInfo = null;
            $this->errorCode = 7;
            $this->lastStatusMsg = EMEMBER_WRONG_PASS;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }
        return $check;
    }

    /**
     * logout can be called if 3rd party plugins needs notification of logout.
     * setting isLoggedIn = true will make sure silent_logout is called..
     * @return type
     */
    public function logout() {
        if (!$this->isLoggedIn)
            return;
        if ($this->silent_logout())
            do_action('emember_logout');
    }

    /**
     * real logout but no action is triggered.
     * @return boolean true iff successful.
     */
    public function silent_logout() {
        if($this->isFeed) {return false;}
        $this->lastStatusMsg = EMEMBER_LOGOUT_SUCCESS;
        $this->errorCode = 6;
        self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
        self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        $auth_cookie_name = is_ssl() ? WP_EMEMBER_SEC_AUTH : WP_EMEMBER_AUTH;
        eMember_log_debug("silent_logout reset=" . json_encode($this->userInfo), true);
        $secure = is_ssl();
        $auth_cookie_name = $secure ? WP_EMEMBER_SEC_AUTH : WP_EMEMBER_AUTH;
        if (!isset($_COOKIE[$auth_cookie_name])) {return false;}
        $cookie_elements = explode('|', $_COOKIE[$auth_cookie_name]);
        if (count($cookie_elements) == 3){
            list($username, $expiration, $hmac) = $cookie_elements;
            global $wpdb;
            $wpdb->query(
                    $wpdb->prepare("DELETE FROM " . WP_EMEMBER_AUTH_SESSION_TABLE . " WHERE session_id = %s",
                            $hmac));
        }
        $this->userInfo = null;
        $this->isLoggedIn = false;
        if (isset($_COOKIE[$auth_cookie_name])) {
            setcookie($auth_cookie_name, ' ', time() - YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
            return true;
        }
        return false;
    }

    /**
     * real stuff
     * @param type $remember
     * @param type $secure
     * @return boolean
     */
    private function set_cookie($remember = '', $secure = '') {
        if (!$secure)
            $secure = is_ssl();
        $auth_cookie_name = $secure ? WP_EMEMBER_SEC_AUTH : WP_EMEMBER_AUTH;
        if ($remember)
            $expire = time() + 1209600;
        else
            $expire = time() + 172800;

        $disable_multiple_logins = Emember_Config::getInstance()->getValue('eMember_multiple_logins');
        $disable_multiple_logins_type = Emember_Config::getInstance()->getValue('eMember_multiple_logins_type');
        if(empty($disable_multiple_logins_type)){$disable_multiple_logins_type= 'last';}
        if ($disable_multiple_logins) {
            global $wpdb;
            if ($disable_multiple_logins_type == 'current'){
                $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . WP_EMEMBER_AUTH_SESSION_TABLE .
                        " WHERE user_name = %s", $this->userInfo->user_name));
                if (!empty($row)) {return false;}
            }
            $wpdb->query(
                    $wpdb->prepare("DELETE FROM " . WP_EMEMBER_AUTH_SESSION_TABLE . " WHERE user_name = %s",
                            $this->userInfo->user_name));
        }

        $pass_frag = substr($this->userInfo->password, 8, 4);
        $scheme = 'auth';
        $key = Emember_Auth::b_hash($this->userInfo->user_name . $pass_frag . '|' . $expire, $scheme);
        $hash = hash_hmac('md5', $this->userInfo->user_name . '|' . $expire, $key);
        $auth_cookie = $this->userInfo->user_name . '|' . $expire . '|' . $hash;
        //setcookie($auth_cookie_name, $auth_cookie, $expire, PLUGINS_COOKIE_PATH, COOKIE_DOMAIN, $secure, true);
        setcookie($auth_cookie_name, $auth_cookie, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure, true);
        //@todo: set some more cookies to address compatibility with other plugins.
        do_action('emember_cookie_dropped');
        setcookie("eMember_in_use", "eMember", time() + 604800, COOKIEPATH, COOKIE_DOMAIN);
        //WP Super cache workaround
        if (function_exists('wp_cache_serve_cache_file'))
            setcookie("comment_author_", "eMember", time() + 21600, COOKIEPATH, COOKIE_DOMAIN);
        $sessionInfo = array('session_id' => $hash,
            'user_id' => $this->userInfo->member_id,
            'user_name' => $this->userInfo->user_name,
            'logged_in_from_ip' => get_real_ip_addr(),
            'login_impression' => current_time('mysql', 1),
            'last_impression' => current_time('mysql', 1));
        dbAccess::insert(WP_EMEMBER_AUTH_SESSION_TABLE, $sessionInfo);
        return true;
    }

    private function validate() {
        global $wpdb;
        $emember_config = Emember_Config::getInstance();
        $sign_in_with_wp = $emember_config->getValue('eMember_signin_emem_user');
        $auth_cookie_name = is_ssl() ? WP_EMEMBER_SEC_AUTH : WP_EMEMBER_AUTH;
        $logout = filter_input(INPUT_GET, 'emember_logout');
        $logout_alt = filter_input(INPUT_GET, 'member_logout');
        $logout_alt2 = filter_input(INPUT_GET, 'event');
        if (!empty($logout) || ($logout_alt == 1) || ($logout_alt2 == 'logout')) {
            $this->isLoggedIn = true; // trick to forcefully logout.
            $this->logout();
            return false;
        } else {
            if (!isset($_COOKIE[$auth_cookie_name]) || empty($_COOKIE[$auth_cookie_name])) {
                //$this->lastStatusMsg = EMEMBER_NOT_LOGGED_IN;
                $this->errorCode = 1;
                //set_transient( 'eMember_login_status_msg', "", 3600 );
                $this->loggedIn = false;
                $this->userInfo = null;
                return false;
            }
            //@todo check if login is for rss

            $cookie_elements = explode('|', $_COOKIE[$auth_cookie_name]);
            if (count($cookie_elements) != 3)
                return false;
            list($username, $expiration, $hmac) = $cookie_elements;
            $expired = $expiration;
            // Allow a grace period for POST and AJAX requests
            if (defined('DOING_AJAX') || 'POST' == $_SERVER['REQUEST_METHOD'])
                $expired += HOUR_IN_SECONDS;
            // Quick check to see if an honest cookie has expired
            if ($expired < time()) {
                $this->lastStatusMsg = EMEMBER_SESSION_EXPIRED; //do_action('auth_cookie_expired', $cookie_elements);
                return false;
            }
            $query = " SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
            $query.= " WHERE user_name = '" . $username . "'";
            $user = $wpdb->get_row($query);
            if (!$user) {
                $this->errorCode = 1;
                return false;
            }
            $pass_frag = substr($user->password, 8, 4);
            $key = Emember_Auth::b_hash($username . $pass_frag . '|' . $expiration);
            $hash = hash_hmac('md5', $username . '|' . $expiration, $key);
            if ($hmac != $hash) {
                $this->lastStatusMsg = EMEMBER_LOGIN_AGAIN;
                $this->error_code = 20;
                self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
                self::setSavedMessage('eMember_login_status_code', $this->errorCode);
                return false;
            }
        }

        if ($expiration < time())
            $GLOBALS['login_grace_period'] = 1;
        $disable_multiple_logins = $emember_config->getValue('eMember_multiple_logins');
        if ($disable_multiple_logins) {
            $query = "SELECT * FROM " . WP_EMEMBER_AUTH_SESSION_TABLE . " WHERE " .
                    "user_name = '" . $username . "' ORDER BY login_impression DESC";
            $session = $wpdb->get_row($query);
            if (!empty($session) && (( $session->logged_in_from_ip != get_real_ip_addr()) || ($session->session_id != $hmac) )) {
                $this->userInfo = null;
                $this->isLoggedIn = true; // trick to forcefully logout.
                $this->lastStatusMsg = EMEMBER_ALREADY_LOGGED_IN;
                $this->errorCode = 13;
                $this->logout();
                self::setSavedMessage('eMember_login_status_code', $this->errorCode);
                self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
                return false;
            }
        }
        $query = "select last_impression FROM " . WP_EMEMBER_AUTH_SESSION_TABLE . " WHERE session_id = '" . $hmac . "'";
        $last_impression = $wpdb->get_col($query);
        $current_time = current_time('mysql', 1);
        $last_impression = isset($last_impression[0]) ? strtotime($last_impression[0]) : strtotime($current_time);
        $this->inactivity = empty($last_impression) ? 0 : (strtotime($current_time) - $last_impression);
        $query = "UPDATE " . WP_EMEMBER_AUTH_SESSION_TABLE . " SET last_impression = '" . $current_time . "' WHERE session_id = '" . $hmac . "'";
        $wpdb->query($query);
        $autologout = $emember_config->getValue('wp_eMember_auto_logout');
        if ($autologout && ($this->inactivity > ($autologout * 60))) {
            eMember_log_debug("Auto logout triggered. Logging out the member!", true);
            $this->isLoggedIn = true; // trick to forcefully logout.
            $this->logout();
            return false;
        }
        /**
         * looks to be valid user. so save user info to member variable.
         */
        $this->userInfo = $user;
        return $this->check_constraints();
    }

    public static function b_hash($data, $scheme = 'auth') {
        $salt = wp_salt($scheme) . 'j4H!B3TA,J4nIn4.';
        return hash_hmac('md5', $data, $salt);
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function get($key, $default = "") {
        if (isset($this->userInfo->$key))
            return $this->userInfo->$key;
        $value = $this->permitted->primary_level->get($key);
        if (!empty($value))
            return $value;
        return $default;
    }

    public function get_message() {
        return $this->lastStatusMsg;
    }

    public function getUserInfo($key, $default = "") {
        if (!$this->isLoggedIn)
            return false;
        if ($key === "user_membership_level_name")//Membership level name
            return $this->permitted->primary_level->get('alias');
        if ($key === "user_additional_membership_level_names") {
            $names = array();
            foreach ($this->permitted->secondary_levels as $level)
                $names[] = $level->get('alias');
            return implode(',', $names);
        }
        if ($key === "profile_picture")//member's profile pic embedded with class eMember_custom_profile_picture
            return $this->getProfilePictureEmbeded();
        if ($key === "profile_picture_src")//member's profile picture raw image URL
            return $this->getProfilePictureSrc();
        if ($key === "member_expiry_date")
            return emember_get_exipiry_date();
        if (isset($this->userInfo->$key) && !empty($this->userInfo->$key)) {
            return $this->userInfo->$key;
        }
        $key = stripslashes($key);
        $key = emember_escape_custom_field($key);
        if (isset($this->customUserInfo[$key]) && !empty($this->customUserInfo[$key]))
            return $this->customUserInfo[$key];
        return $default;
    }

    public function getLevelInfo($key, $default = "") {
        if (!$this->isLoggedIn)
            return $default;
        return $this->permitted->get($key);
    }

    public function getProfilePictureSrc($member_id = "") {
        if (!$this->isLoggedIn)
            return "";
        if (empty($member_id)) {
            $member_id = $this->userInfo->member_id;
        }
        $emember_config = Emember_Config::getInstance();
        $use_gravatar = $emember_config->getValue('eMember_use_gravatar');
        $d = WP_EMEMBER_URL . '/images/default_image.gif';
        if ($use_gravatar)
            return WP_EMEMBER_GRAVATAR_URL . "/" . md5(strtolower($this->userInfo->email)) . "?d=" . urlencode($d) . "&s=" . 96;
        $image = $this->userInfo->profile_image;
        $upload_dir = wp_upload_dir();
        if (!empty($image))
            return $upload_dir['baseurl'] . '/emember/' . $image;
        return $d;
    }

    public function getProfilePictureEmbeded() {
        $image_url = $this->getProfilePictureSrc();
        $output .= '<img src="' . $image_url . '" alt="" class="eMember_custom_profile_picture" />';
        return $output;
    }

    function getMsg() {
        return $this->lastStatusMsg;
    }

    function getCode() {
        return $this->errorCode;
    }

    function is_subscription_expired() {
        return wp_emember_is_subscription_expired(
                $this->userInfo, $this->permitted->primary_level);
        die('Something is wrong:expire');
    }

    function is_protected_post($id) {
        return $this->protected->is_protected_post($id);
    }

    function is_protected_page($id) {
        return $this->protected->is_protected_page($id);
    }

    function is_protected_attachment($id) {
        return $this->protected->is_protected_attachment($id);
    }

    function is_protected_custom_post($id) {
        return $this->protected->is_protected_custom_post($id);
    }

    function is_protected_comment($id) {
        return $this->protected->is_protected_comment($id);
    }

    function is_protected_category($post_id) {
        return $this->protected->is_post_in_protected_category($post_id);
    }

    function is_protected_parent_category($post_id) {
        return $this->protected->is_post_in_protected_parent_category($post_id);
    }

    function is_permitted_attachment($id) {
        if (!$this->is_protected_attachment($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_attachment($id);
    }

    function is_permitted_custom_post($id) {
        if (!$this->is_protected_custom_post($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_custom_post($id);
    }

    function is_permitted_category($post_id) {
        if (!$this->is_protected_category($post_id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_post_in_permitted_category($post_id);
    }

    function is_permitted_post($id) {
        if (!$this->is_protected_post($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_post($id);
    }

    function is_permitted_page($id) {
        if (!$this->is_protected_page($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_page($id);
    }

    function is_permitted_comment($id) {
        if (!$this->is_protected_comment($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_comment($id);
    }

    function is_page_accessible($id) {
        return $this->is_post_accessible($id);
    }

    function is_post_accessible($id) {
        if (!$this->protected->is_protected($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted($id);
    }

    function is_comment_accessible($id) {
        if (!$this->protected->is_protected_comment($id))
            return true;
        if (!$this->isLoggedIn)
            return false;
        return $this->permitted->is_permitted_comment($id);
    }

    function my_pages_posts() {
        if (!$this->isLoggedIn())
            return false;
        global $wpdb;
        $query = "SELECT meta_value from " . WP_EMEMBER_MEMBERS_META_TABLE .
                " WHERE meta_key ='emember_single_page_post' AND user_id = " .
                $this->userInfo->member_id;
        $result = $wpdb->get_col($query);
        return empty($result) ? array() : unserialize($result);
    }

    static function buy_page_post($user_id, $post_info = array()) {
        if (!isset($post_info['post_id']))
            return;
        if (isset($post_info['valid_till'])) {
            global $wpdb;
            $query = "SELECT meta_value from " . WP_EMEMBER_MEMBERS_META_TABLE .
                    " WHERE meta_key ='emember_single_page_post' AND user_id = " . $user_id;
            $result = $wpdb->get_col($query);
            $result = empty($result) ? array() : unserialize($result);
            $result[$post_info['post_id']] = $post_info;
            $query = "INSERT INTO " . WP_EMEMBER_MEMBERS_META_TABLE .
                    '( user_id, meta_key, meta_value ) VALUES(' .
                    $user_id . ',\'emember_single_page_post\',' .
                    '\'' . addslashes(serialize($result)) . '\')';
            $wpdb->query($query);
        }
    }

    function is_my_page_post($post_id) {
        if (!$this->isLoggedIn())
            return false;
        global $wpdb;
        $query = "SELECT meta_value from " . WP_EMEMBER_MEMBERS_META_TABLE .
                " WHERE meta_key ='emember_single_page_post' AND user_id = " .
                $this->userInfo->member_id;
        $result = $wpdb->get_col($query);
        $result = empty($result) ? array() : unserialize($result);
        if (isset($result[$post_id]) && (strtotime($result['valid_till']) > time()))
            return true;
        return false;
    }

    function getSavedMessage($key) {  //should be static
        $msgs = get_transient(WP_EMEMBER_CLIENTHASH);
        $msgs = ($msgs === false) ? array() : $msgs;
        if (isset($msgs[$key])) {
            $m = $msgs[$key];
            unset($msgs[$key]);
            set_transient(WP_EMEMBER_CLIENTHASH, $msgs, 3600);
            return $m;
        }
        return "";
    }

    public static function setSavedMessage($key, $value, $duration = 3600) { //@todo: duration should be handled individually.
        $msgs = get_transient(WP_EMEMBER_CLIENTHASH);
        $msgs = ($msgs === false) ? array() : $msgs;
        $msgs[$key] = $value;
        set_transient(WP_EMEMBER_CLIENTHASH, $msgs, $duration);
    }

    public function add_bookmark($b) {
        if (!$this->isLoggedIn)
            return;
        $bookmarks = unserialize($this->userInfo->extra_info);
        $bookmarks = isset($bookmarks['bookmarks']) ? $bookmarks['bookmarks'] : array();
        $bookmarks = array_merge($bookmarks, $b);
        $bookmarks = array_unique($bookmarks);
        $extr['bookmarks'] = $bookmarks;
        $bookmarks = serialize($extr);
        $fields['extra_info'] = $bookmarks;
        $this->userInfo->extra_info = $bookmarks;
        dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id = ' . $this->userInfo->member_id, $fields);
    }

    public function remove_bookmark($b) {
        if (!$this->isLoggedIn)
            return;
        $bookmarks = unserialize($this->userInfo->extra_info);
        if (!empty($bookmarks['bookmarks'])) {
            $bookmarks['bookmarks'] = array_diff($bookmarks['bookmarks'], $b);
            $bookmarks = serialize($bookmarks);
            $this->userInfo->extra_info = $bookmarks;
            $extr = array('extra_info' => $bookmarks);
            dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id = ' . $this->userInfo->member_id, $extr);
        }
    }

    public function save() {

    }

    private function track_user_name() {
        $user = filter_input(INPUT_POST, 'emember_u_name');
        if (empty($user)){
            $user = filter_input(INPUT_GET, 'emember_u_name');
        }
        if (empty($user)){
            $user = filter_input(INPUT_POST, 'login_user_name');
        }
        if (empty($user)){
            $user = filter_input(INPUT_GET, 'login_user_name');
        }
        $user = apply_filters('emember_username_override', $user );
        if (!empty($user)){
            return $user;
        }

        if (isset($_REQUEST['emember_u_name']) && empty($_REQUEST['emember_u_name'])) {
            $this->lastStatusMsg = EMEMBER_USER_PASS_EMPTY;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 12;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }
        if (isset($_REQUEST['login_user_name']) && empty($_REQUEST['login_user_name'])) {
            $this->lastStatusMsg = EMEMBER_USER_PASS_EMPTY;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 12;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }
        return "";
    }

    public function track_password() {
        $pass = filter_input(INPUT_POST, 'emember_pwd');
        if (!empty($pass)){
            return $pass;
        }
        $pass = filter_input(INPUT_GET, 'emember_pwd');
        if (!empty($pass)){
            $pwd_encoded = filter_input(INPUT_GET, 'pwd_encoded');
            if ($pwd_encoded == '1'){
                //Encoded password from auto login after rego feature so decode it
                $pass = base64_decode($pass);
            }
            return $pass;
        }
        $pass = filter_input(INPUT_POST, 'login_pwd');
        if (!empty($pass)){
            return $pass;
        }
        $pass = filter_input(INPUT_GET, 'login_pwd');
        if (!empty($pass)){
            return $pass;
        }

        if (isset($_REQUEST['emember_pwd']) && empty($_REQUEST['emember_pwd'])) {
            $this->lastStatusMsg = EMEMBER_USER_PASS_EMPTY;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 12;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }
        if (isset($_REQUEST['login_pwd']) && empty($_REQUEST['login_pwd'])) {
            $this->lastStatusMsg = EMEMBER_USER_PASS_EMPTY;
            self::setSavedMessage('eMember_login_status_msg', $this->lastStatusMsg);
            $this->errorCode = 12;
            self::setSavedMessage('eMember_login_status_code', $this->errorCode);
        }

        return "";
    }

}