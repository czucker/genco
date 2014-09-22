<?php

class Emember_Config {

    var $configs;
    var $message_stack;
    static $_this;
    var $pages = array('eMember_admin_functions_menu',
        'eMember_membership_level_menu',
        'wp_eMember_manage',
        'eMember_settings_menu',
        'eMember_social_menu'
    );

    function __construct() {
        $this->message_stack = new stdClass();
    }

    function loadConfig() {
        $this->configs = get_option('eMember_configs_v2');
        if (empty($this->configs)) {
            $eMember_raw_configs = get_option('eMember_configs');
            if (is_string($eMember_raw_configs))
                $this->configs = unserialize($eMember_raw_configs);
            else
                $this->configs = unserialize((string) $eMember_raw_configs);
        }

        if (empty($this->configs)) {
            $this->configs = array();
        }//This is a brand new install site with no config data so initilize with a new array
    }

    function getValue($key) {
        return isset($this->configs[$key]) ? $this->configs[$key] : '';
    }

    function setValue($key, $value) {
        $this->configs[$key] = $value;
    }

    function addValue($key, $value) {
        if (array_key_exists($key, $this->configs)) {
            //Don't update the value for this key
        } else {
            //It is save to update the value for this key
            $this->configs[$key] = $value;
        }
    }

    function saveConfig() {
        update_option('eMember_configs', serialize($this->configs));
        update_option('eMember_configs_v2', $this->configs);
    }

    function get_stacked_message($key) {
        if (isset($this->message_stack->{$key}))
            return $this->message_stack->{$key};
        return "";
    }

    function set_stacked_message($key, $value) {
        $this->message_stack->{$key} = $value;
    }

    static function getInstance() {
        if (empty(self::$_this)) {
            self::$_this = new Emember_Config();
            self::$_this->loadConfig();
            return self::$_this;
        }
        return self::$_this;
    }

}
