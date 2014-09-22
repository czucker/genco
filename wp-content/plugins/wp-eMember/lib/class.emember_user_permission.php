<?php

class Emember_User_Permission {

    public function __construct($userInfo) {
        $level_info = array();
        $current_level = $userInfo->membership_level;
        $more_levels = $userInfo->more_membership_levels;
        $more_levels = is_array($more_levels) ? array_filter($more_levels) : $more_levels;
        $userInfo->more_membership_levels = explode(',', $more_levels);
        $this->primary_level = Emember_Permission::get_instance($userInfo->membership_level);
        $this->secondary_levels = array();
        $config = Emember_Config::getInstance();
        $options = $this->primary_level->get_options();
        if (isset($options['promoted_level_id']) && ($options['promoted_level_id'] != -1)) {
            $current_subscription_starts = strtotime($userInfo->subscription_starts);
            $sec_levels = $userInfo->more_membership_levels;
            $level_before = $userInfo->membership_level;
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
                if (!isset($options['promoted_level_id']) || ($options['promoted_level_id'] == -1))
                    break;
                //$current_subscription_starts = $expires;
                $sec_levels[] = $current_level;
                $current_level = $options['promoted_level_id'];
                $this->primary_level = Emember_Permission::get_instance($current_level);
                $options = $this->primary_level->get_options();
            }
            if (($current_level != -1)) {
                $level_info ['membership_level'] = $current_level;
                //$level_info ['current_subscription_starts'] = date('y-m-d', $current_subscription_starts);
                if ($config->getValue('eMember_enable_secondary_membership')) {
                    $sec_levels = array_unique($sec_levels);
                    $level_info['more_membership_levels'] = implode(',', $sec_levels);
                    $userInfo->more_membership_levels = $sec_levels;
                }
                $userInfo->membership_level = $current_level;
                dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, 'member_id=' . $userInfo->member_id, $level_info);
                if ($level_info['membership_level'] != $level_before)
                    do_action('emember_membership_changed', array('member_id' => $userInfo->member_id,
                        'from_level' => $level_before,
                        'to_level' => $level_info['membership_level']));
            }
        }

        if ($config->getValue('eMember_enable_secondary_membership')) {
            if (!empty($userInfo->more_membership_levels)) {
                foreach ($userInfo->more_membership_levels as $l) {
                    if (empty($l))
                        continue;
                    $this->secondary_levels[] = Emember_Permission::get_instance($l);
                }
            }
        }
        $my_subcript_period = $this->primary_level->get('subscription_period');
        $my_subscript_unit = $this->primary_level->get('subscription_unit');
        if (($my_subcript_period == 0) && empty($my_subscript_unit))
            $type = 'noexpire';
        else if (($my_subcript_period == 0) && !empty($my_subscript_unit)) {
            $type = 'fixeddate';
            $my_subcript_period = $my_subscript_unit;
        } else {
            $type = 'interval';
            switch ($my_subscript_unit) {
                case 'Days':
                    break;
                case 'Weeks':
                    $my_subcript_period = $my_subcript_period * 7;
                    break;
                case 'Months':
                    $my_subcript_period = $my_subcript_period * 30;
                    break;
                case 'Years':
                    $my_subcript_period = $my_subcript_period * 365;
                    break;
            }
        }
        $this->subscription_duration = array(
            'duration' => $my_subcript_period,
            'type' => $type);
    }

    public function is_permitted($id) {
        if ($this->primary_level->is_permitted($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted($id))
                return true;
        return false;
    }

    public function is_permitted_attachment($id) {
        if ($this->primary_level->is_permitted_attachment($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_attachment($id))
                return true;
        return false;
    }

    public function is_permitted_custom_post($id) {
        if ($this->primary_level->is_permitted_custom_post($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_custom_post($id))
                return true;
        return false;
    }

    public function is_permitted_category($id) {
        if ($this->primary_level->is_permitted_category($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_category($id))
                return true;
        return false;
    }

    public function is_post_in_permitted_category($post_id) {
        if ($this->primary_level->is_post_in_permitted_category($post_id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_post_in_permitted_category($post_id))
                return true;
        return false;
    }

    public function is_permitted_post($id) {
        if ($this->primary_level->is_permitted_post($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_post($id))
                return true;
        return false;
    }

    public function is_permitted_page($id) {
        if ($this->primary_level->is_permitted_page($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_page($id))
                return true;
        return false;
    }

    public function is_permitted_comment($id) {
        if ($this->primary_level->is_permitted_comment($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_comment($id))
                return true;
        return false;
    }

    public function is_permitted_parent_category($id) {
        if ($this->primary_level->is_permitted_parent_category($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_permitted_parent_category($id))
                return true;
        return false;
    }

    public function is_post_in_permitted_parent_category($id) {
        if ($this->primary_level->is_post_in_permitted_parent_category($id))
            return true;
        foreach ($this->secondary_levels as $level)
            if ($level->is_post_in_permitted_parent_category($id))
                return true;
        return false;
    }

    public function get($key) {
        return $this->primary_level->get($key);
    }

}
