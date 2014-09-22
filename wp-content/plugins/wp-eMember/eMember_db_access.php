<?php

//Database

global $wpdb;
define('WP_EMEMBER_MEMBERS_TABLE_NAME', $wpdb->prefix . "wp_eMember_members_tbl");
define('WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE', $wpdb->prefix . "wp_eMember_membership_tbl");
define('WP_EMEMBER_AUTH_SESSION_TABLE', $wpdb->prefix . "wp_auth_session_tbl");
define('WP_EMEMBER_MEMBERS_META_TABLE', $wpdb->prefix . "wp_members_meta_tbl");
define('WP_EMEMBER_OPENID_TABLE', $wpdb->prefix . "emember_openid_lookup");

/**
 * @@name dbAccess
 * @description Database Access API for eMember plugin.
 * @@access public
 * @@author nur hasan <nur858@gmail.com>
 */
class dbAccess {

    function __construct() {
        die();
    }

    function dbAccess() {
        die();
    }

    static function find($inTable, $condition) {
        global $wpdb;

        if (empty($condition))
            return null;
        $resultset = $wpdb->get_row("SELECT *  FROM $inTable WHERE $condition ", OBJECT);
        return $resultset;
    }

    static function findAll($inTable, $condition = null, $orderby = null) {
        global $wpdb;
        $condition = empty($condition) ? '' : ' WHERE ' . $condition;
        $condition .= empty($orderby) ? '' : ' ORDER BY ' . $orderby;
        $resultSet = $wpdb->get_results("SELECT * FROM $inTable $condition ", OBJECT);
        return $resultSet;
    }

    static function delete($fromTable, $condition) {
        global $wpdb;
        $resultSet = $wpdb->query("DELETE FROM $fromTable WHERE $condition ");
        return $resultSet;
    }

    static function update($inTable, $condition, $fields) {
        global $wpdb;
        $query = " UPDATE $inTable SET ";
        $first = true;
        foreach ($fields as $field => $value) {
            if ($first)
                $first = false;
            else
                $query .= ' , ';
            $query .= " $field = '" . esc_sql($value) . "' ";
        }

        $query .= empty($condition) ? '' : " WHERE $condition ";
        $results = $wpdb->query($query);
        return $results;
    }

    static function insert($inTable, $fields) {
        global $wpdb;
        $fieldss = '';
        $valuess = '';
        $first = true;
        foreach ($fields as $field => $value) {
            if ($first)
                $first = false;
            else {
                $fieldss .= ' , ';
                $valuess .= ' , ';
            }
            $fieldss .= " $field ";
            $valuess .= " '" . esc_sql($value) . "' ";
        }

        $query = " INSERT INTO $inTable ($fieldss) VALUES ($valuess)";

        $results = $wpdb->query($query);
        return $results;
    }

    static function findCount($inTable, $fields = null, $condition = null, $orderby = null, $groupby = null) {
        global $wpdb;
        $fieldss = '';
        $first = true;

        if (empty($fields)) {
            $fieldss = 'count(*) as count';
        } else {
            foreach ($fields as $key => $value) {
                if ($first)
                    $first = false;
                else {
                    $fieldss .= ' , ';
                }
                $fieldss .= " $key AS $value";
            }
        }
        $condition = $condition ? " WHERE $condition " : null;
        $condition.= empty($orderby) ? '' : ' ORDER BY ' . $orderby;
        $condition.= empty($groupby) ? '' : ' GROUP BY ' . $groupby;

        $resultset = $wpdb->get_results("SELECT $fieldss FROM $inTable $condition ", OBJECT);
        return $resultset;
    }

}

function check_php_version() {
    $version = explode('.', phpversion());

    if (($version[0] < 5) || ($version[1] < 2))
        return "<span style='color:white;background-color:red'><b>This
        plugin works better with phpv5.2.x or above. You are using " . phpversion() . '</b></span>';
}
