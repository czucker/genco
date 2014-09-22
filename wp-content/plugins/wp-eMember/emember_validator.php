<?php

/**
 * Description of emember_validator
 *
 * @author nur
 */
class Emember_Validator {

    var $fields;
    var $user_required;
    var $pass_required;
    var $email_required;
    var $email;
    var $phone;

    function __construct() {
        $this->fields = array();
        $this->addRule('user_required', array('rule' => 'required', 'message' => EMEMBER_USERNAME_NOT_EMPTY));
        $this->addRule('email_required', array('rule' => 'required', 'message' => EMEMBER_EMAIL_NOT_EMPTY));
        $this->addRule('email', array('rule' => 'email', 'message' => EMEMBER_INVALID_EMAIL));
        $this->addRule('user_minlength', array('rule' => 'minlength', 'length' => 4, 'message' => EMEMBER_USERNAME_4_CHARS));
        $this->addRule('user_unavail', array('rule' => 'user_unavail', 'message' => EMEMBER_USER_NAME_TAKEN));
        $this->addRule('email_unavail', array('rule' => 'email_unavail', 'message' => EMEMBER_EMAIL_TAKEN));
        $this->addRule('pass_required', array('rule' => 'required', 'message' => EMEMBER_PASSWORD_EMPTY));
        $this->addRule('pass_mismatch', array('rule' => 'mismatch', 'message' => 'Password does\'t match!'));
        $this->addRule('alphanumericunderscore', array('rule' => 'alphanumericunderscore', 'message' => EMEMBER_ALPHA_NUMERIC_UNDERSCORE));
        $this->addRule('user_name', array('rule' => 'user_name', 'message' => EMEMBER_USER_NAME_VALIDATION_MESSAGE));
    }

    function addRule($name, $def) {
        $this->{$name} = $def;
    }

    function add($field = array()) {
        $this->fields[] = $field;
    }

    function validate() {
        $errors = array();
        foreach ($this->fields as $field) {
            $message = '';
            foreach ($field['rules'] as $rule) {

                $ruleset = $this->{$rule};
                $error = false;
                switch ($ruleset['rule']) {
                    case 'required':
                        $error = $this->required($field['value']);
                        break;
                    case 'minlength':
                        $error = $this->minlength($field['value'], $ruleset['length']);
                        break;
                    case 'email':
                        $error = $this->email($field['value']);
                        break;
                    case 'user_unavail':
                        $error = $this->user_unavail($field['value']);
                        break;
                    case 'email_unavail':
                        $error = $this->email_unavail($field['value']);
                        break;
                    case 'mismatch':
                        $error = $this->mismatch($field['value'], $field['repeat']);
                        break;
                    case 'alphanumericunderscore':
                        $error = $this->alphanumericunderscore($field['value']);
                        break;
                }
                if ($error) {
                    $message = $message . $ruleset['message'] . '.';
                }
            }
            if ($message)
                $errors[] = $field['label'] . ':' . $message;
        }
        return $errors;
    }

    function required($value) {
        return empty($value);
    }

    /**
     * adapted from Linux Journal(linuxjournal)
     * courtesy Douglas Lovell
     */
    function email($email) {
        $regex = '/^([A-Za-z0-9_\-\.\'\+])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/';
        if (!preg_match($regex, $email))
            return true;
        return false;
    }

    function minlength($value, $len) {
        return (strlen($value) < $len) ? true : false;
    }

    function email_unavail($email) {
        return ((emember_wp_email_exists($email) || emember_registered_email_exists($email))) ? true : false;
    }

    function user_unavail($user) {
        return(emember_wp_username_exists($user) || emember_username_exists($user)) ? true : false;
    }

    function mismatch($src, $dest) {
        return ($src != $dest);
    }

    function user_name($value) {
        if (preg_match("/^[a-zA-Z0-9!@#$%&\'*+\/=?^_`{|}~\.-]+$/", $value) === 0) {
            return true;
        }
        return false;
    }

    function alphanumericunderscore($value) {
        if (preg_match("/^[0-9a-zA-Z_]{4,}$/", $value) === 0) {
            return true;
        }
        return false;
    }

}
