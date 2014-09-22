<?php

class Emember_Level_Collection {

    private static $_this;
    private $ids;
    private $levels;

    private function __construct() {
        global $wpdb;
        $this->levels = array();
        $query = "SELECT id FROM " . $wpdb->prefix . "wp_eMember_membership_tbl WHERE id != 1";
        $this->ids = $wpdb->get_col($query);
        foreach ($this->ids as $id) {
            $this->levels[$id] = Emember_Permission::get_instance($id);
        }
    }

    public static function get_instance() {
        self::$_this = empty(self::$_this) ? new Emember_Level_Collection() : self::$_this;
        return self::$_this;
    }

    public function permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function post_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_post($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function page_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_page($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function comment_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_comment($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function attachment_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_attachment($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function category_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_category($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function custom_post_permitted_in($id) {
        $permitted = array();
        foreach ($this->levels as $key => $level) {
            if ($level->is_permitted_custom_post($id))
                $permitted[] = $key;
        }
        return $permitted;
    }

    public function get_levels($id = "") {
        if (!empty($id))
            return $this->levels[$id];
        return $this->levels;
    }

}
