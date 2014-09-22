<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class EmemberMemberList extends WP_List_Table {

    function __construct() {
        parent::__construct(array(
            'singular' => 'Member',
            'plural' => 'Members',
            'ajax' => false
        ));
        $this->count = array();
        $this->selected = 'all';
    }

    function get_columns() {
        return array(
            'cb' => '<input type="checkbox" />'
            , 'member_id' => 'Member ID'
            , 'user_name' => 'User Name'
            , 'first_name' => 'First Name'
            , 'last_name' => 'Last Name'
            , 'email' => 'Email'
            , 'alias' => 'Membership Level'
            , 'last_accessed' => 'Last Login'
            , 'last_accessed_from_ip' => 'Last Login IP'
            , 'subscription_starts' => 'Subscription Starts'
            , 'expiry_date' => 'Expiry Date'
            , 'account_state' => 'Account State'
            , 'notes' => 'Notes'
            , 'actions' => 'Actions'
        );
    }

    function get_sortable_columns() {
        return array(
            'member_id' => array('member_id', true),
            'user_name' => array('user_name', true),
            'email' => array('email', true),
            'first_name' => array('first_name', true),
            'last_name' => array('last_name', true),
            'alias' => array('alias', true),
            'subscription_starts' => array('subscription_starts', true),
            'account_state' => array('account_state', true)
        );
    }

    function get_bulk_actions() {
        $actions = array(
            'bulk_delete' => 'Delete',
            'bulk_active' => 'Set Status to Active',
            'bulk_active_notify' => 'Set Status to Active and Notify',
            'bulk_inactive' => 'Set Status to Inactive',
            'bulk_pending' => 'Set Status to Pending',
            'bulk_expired' => 'Set Status to Expired',
        );
        return $actions;
    }

    function column_default($item, $column_name) {
        $date_format = get_option('date_format');
        if(empty($date_format)){
            $date_format = 'Y-m-d';
        }        
        if ($column_name == 'expiry_date') {
            $expires = emember_get_expiry_by_member_id($item['member_id']);
            if ($expires == 'noexpire')
                return "Until Cancelled";
            return date($date_format, strtotime($expires));
        }
        if ($column_name == 'subscription_starts')
            return date($date_format, strtotime($item[$column_name]));
        if ($column_name == 'notes') {
            if (empty($item[$column_name]))
                return "";
            return '<a href="javascript:void(0);" class="eMember_tooltip">Notes
                <span>' . stripslashes($item['notes']) . '</span></a>';
        }
        if ($column_name == 'last_accessed') {
            if ('0000-00-00 00:00:00' == $item[$column_name])
                return 'Never';
            return date($date_format, strtotime($item[$column_name]));
        }
        return stripslashes($item[$column_name]);
    }

    function column_member_id($item) {
        $actions = array(
            'edit' => sprintf('<a href="admin.php?page=%s&members_action=add_edit&editrecord=%s">Edit</a>', $_REQUEST['page'], $item['member_id']),
            'unlock' => sprintf('<a href="admin.php?page=%s&members_action=edit_ip_lock&editrecord=%s">Unlock</a>', $_REQUEST['page'], $item['member_id']),
            'delete' => sprintf('<a href="?page=%s&members_action=delete&deleterecord=%s"
                                    onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>', $_REQUEST['page'], $item['member_id']),
        );
        $id_column_value = $item['member_id'] . $this->row_actions($actions);
        return $id_column_value;
    }

    function column_actions($item){
        $edit_action = sprintf('<a href="admin.php?page=%s&members_action=add_edit&editrecord=%s">Edit</a>', $_REQUEST['page'], $item['member_id']);
        $delete_action = sprintf('<a href="?page=%s&members_action=delete&deleterecord=%s" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>', $_REQUEST['page'], $item['member_id']);
        $actions_column_value = $edit_action . ' | ' . $delete_action;
        return $actions_column_value;
    }
    
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="members[]" value="%s" />', $item['member_id']
        );
    }

    function prepare_items() {
        $ret = $this->delete();
        if (!empty($ret)) {
            echo $ret;
            return;
        }
        $this->set_status();
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $query .= " LEFT JOIN " . $wpdb->prefix . "wp_eMember_membership_tbl";
        $query .= " ON ( membership_level = id ) ";
        $query .= " LEFT JOIN " . $wpdb->prefix . "wp_members_meta_tbl ";
        $query .= " ON ( member_id = user_id AND meta_key='custom_field' ) ";
        $cond = array();
        $s = filter_input(INPUT_GET, 's');
        if (!empty($s)) {
            $cond[] = " ( user_name LIKE  '%" . strip_tags($s) . "%' "
                    . " OR email LIKE '%" . strip_tags($s) . "%' "
                    . " OR first_name LIKE '%" . strip_tags($s) . "%' "
                    . " OR last_name LIKE '%" . strip_tags($s) . "%'  "
                    . " OR alias LIKE '%" . strip_tags($s) . "%'  "
                    . " OR address_state LIKE '%" . strip_tags($s) . "%'  "
                    . " OR meta_value LIKE '%" . strip_tags($s) . "%'  "
                    . " OR subscr_id LIKE '%" . strip_tags($s) . "%' ) ";
        }
        $account_state = filter_input(INPUT_GET, 'account_state');
        if (!empty($account_state) && ($account_state != -1)) {
            $this->selected = $account_state;
            if ($account_state == 'incomplete') {
                $cond[] = " user_name = '' ";
            } else
                $cond[] = " account_state = '" . strip_tags($account_state) . "' ";
        }
        $q = "SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl WHERE account_state = 'active'";
        $this->count['active'] = $wpdb->query($q);
        $q = "SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl WHERE user_name = ''";
        $this->count['incomplete'] = $wpdb->query($q);
        $q = "SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl";
        $this->count['all'] = $wpdb->query($q);
        $q = "SELECT * FROM " . $wpdb->prefix . "wp_eMember_members_tbl WHERE account_state = 'pending'";
        $this->count['pending'] = $wpdb->query($q);

        $membership_level = filter_input(INPUT_GET, 'membership_level');
        if (!empty($membership_level) && ($membership_level != -1))
            $cond[] = " membership_level = '" . strip_tags($membership_level) . "' ";
        $cond = implode(" AND ", $cond);
        if (!empty($cond))
            $query .= ' WHERE ' . $cond;
        $orderby = filter_input(INPUT_GET, 'orderby');
        $orderby = !empty($orderby) ? mysql_real_escape_string($orderby) : 'ASC';
        $order = filter_input(INPUT_GET, 'order');
        $order = !empty($order) ? mysql_real_escape_string($order) : '';
        if (!empty($orderby) & !empty($order)) {
            $query.=' ORDER BY ' . $orderby . ' ' . $order;
        }

        $totalitems = $wpdb->query($query); //return the total number of affected rows
        $perpage = 50;
        $emember_config = Emember_Config::getInstance();
        $pagination_value_in_settings = $emember_config->getValue('emember_members_menu_pagination_value');
        if (is_numeric($pagination_value_in_settings)) {
            $perpage = $pagination_value_in_settings; //use the value in the settings for it.
        }
        $paged = filter_input(INPUT_GET, 'paged');
        $paged = !empty($paged) ? mysql_real_escape_string($paged) : '';
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        $totalpages = ceil($totalitems / $perpage);
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query.=' LIMIT ' . (int) $offset . ',' . (int) $perpage;
        }
        $this->set_pagination_args(array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage,
        ));

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $wpdb->get_results($query, ARRAY_A);
    }

    function no_items() {
        _e('No Members found.');
    }

    function delete() {
        if ((isset($_REQUEST['action2']) && ($_REQUEST['action2'] == 'bulk_delete') ) ||
                (isset($_REQUEST['members_action']) && ($_REQUEST['members_action'] == 'delete')) ||
                (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'bulk_delete'))) {
            return wp_eMember_delete_member();
        }
        return 0;
    }

    function set_status() {
        if (!isset($_REQUEST['action2']) || empty($_REQUEST['action2']))
            return;
        if (!isset($_REQUEST['members']) || empty($_REQUEST['members']))
            return;
        $action = ($_REQUEST['action2'] == -1) ? $_REQUEST['action'] : $_REQUEST['action2'];
        $status = '';
        $notify = false;
        switch ($action) {
            case 'bulk_active_notify':
                $notify = true;
            case 'bulk_active':
                $status = 'active';
                break;
            case 'bulk_inactive':
                $status = 'inactive';
                break;
            case 'bulk_pending':
                $status = 'pending';
                break;
            case 'bulk_expired':
                $status = 'expired';
                break;
        }
        if (empty($status))
            return;
        $ids = implode(',', array_map('absint', $_REQUEST['members']));
        if (empty($ids))
            return;
        global $wpdb;
        $query = "UPDATE " . $wpdb->prefix . "wp_eMember_members_tbl " .
                " SET account_state = '" . $status . "' WHERE member_id in (" . $ids . ")";
        $wpdb->query($query);

        if ($notify) {
            $emember_config = Emember_Config::getInstance();
            $login_url = $emember_config->getValue('login_page_url');

            $emails = $wpdb->get_col("SELECT email FROM " . $wpdb->prefix . "wp_eMember_members_tbl " .
                    " WHERE member_id IN ( $ids  ) ");
            $subject = EMEMBER_BULK_ACTIVATION_EMAIL_SUBJECT;
            $body = EMEMBER_BULK_ACTIVATION_EMAIL_BODY;

            $headers = 'From: ' . get_option('admin_email') . "\r\n";
            $headers .= 'bcc: ' . implode(',', $emails) . "\r\n";
            wp_mail(array()/* $email_list */, $subject, $body, $headers);
            eMember_log_debug("Bulk activation email notification sent.", true);
        }
    }

}
