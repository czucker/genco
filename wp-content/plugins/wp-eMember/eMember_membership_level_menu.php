<?php
include_once('admin_includes.php');

function wp_eMember_membership_level() {
    echo '<div class="wrap"><h2>WP eMembers - Manage Access Levels v' . WP_EMEMBER_VERSION . '</h2>';
    echo check_php_version();
    echo eMember_admin_submenu_css();


    $current = (isset($_GET['level_action']) && $_GET['level_action'] > 0 && $_GET['level_action'] < 4) ? $_GET['level_action'] : 1;
    ?>
    <h3 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo ($current == 1) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_membership_level_menu&level_action=1">Manage Levels</a>
        <a class="nav-tab <?php echo ($current == 2) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_membership_level_menu&level_action=2">Manage Content Protection</a>
    </h3>
    <?php
    switch ($current) {
        case '2': content_protection();
            break;
        default: manage_access_levels();
            break;
    }
    echo '</div>';
}

function content_protection() {
    if (isset($_POST['submit'])) {
        $ids = array();
        $debookmarked = array();
        $fields = array();
        $page_ids = $_POST['item_id'];

        if (isset($_POST['checked']) && count($_POST['checked']))
            foreach ($_POST['checked'] as $id => $value)
                array_push($ids, $id);
        if (isset($_POST['bookmark']) && count($_POST['bookmark']))
            foreach ($_POST['bookmark'] as $id => $value)
                array_push($debookmarked, $id);
        $level = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id = ' . $_POST['wpm_content_level'], ' id DESC ');
        switch ($_POST['content_type']) {
            case 'posts':
                $old_ids = (array) unserialize($level->post_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('post_list' => $ids);
                $current_bookmarks = (array) unserialize($level->disable_bookmark_list);
                if (!is_bool($current_bookmarks)) {
                    $oldmarks = empty($current_bookmarks['posts']) ? array() : $current_bookmarks['posts'];
                    $debookmarked = emember_adjust_list($debookmarked, $page_ids, $oldmarks);
                }
                $current_bookmarks['posts'] = $debookmarked;
                $debookmarked = serialize($current_bookmarks);
                $fields['disable_bookmark_list'] = $debookmarked;
                break;
            case 'pages':
                $old_ids = (array) unserialize($level->page_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('page_list' => $ids);
                $current_bookmarks = (array) unserialize($level->disable_bookmark_list);
                if (!is_bool($current_bookmarks)) {
                    $oldmarks = empty($current_bookmarks['pages']) ? array() : $current_bookmarks['pages'];
                    $debookmarked = emember_adjust_list($debookmarked, $page_ids, $oldmarks);
                }
                $current_bookmarks['pages'] = $debookmarked;
                $debookmarked = serialize($current_bookmarks);
                $fields['disable_bookmark_list'] = $debookmarked;
                break;
            case 'comments':
                $old_ids = (array) unserialize($level->comment_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('comment_list' => $ids);
                break;
            case 'categories':
                $old_ids = (array) unserialize($level->category_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('category_list' => $ids);
                break;
            case 'attachments':
                $old_ids = (array) unserialize($level->attachment_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('attachment_list' => $ids);
                break;
            case 'custom-posts':
                $old_ids = (array) unserialize($level->custom_post_list);
                $ids = emember_adjust_list($ids, $page_ids, $old_ids);
                $ids = serialize($ids);
                $fields = array('custom_post_list' => $ids);
                break;
            default :
                break;
        }
        $ret = dbAccess::update(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id = ' . $_POST['wpm_content_level'], $fields);
        if ($ret === false)
            echo '<div id="message" style="color:red;" class="updated fade"><p>Failed to update.</p></div>';
        else if ($ret === 0)
            echo '<div id="message" style="color:red;" class="updated fade"><p>Nothing to update.</p></div>';
        else
            echo '<div id="message" class="updated fade"><p>Info Updated.</p></div>';
    }
    $levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
    include_once('views/content_protection_view.php');
}

function emember_adjust_list($added, $scope, $base) {
    if (!is_bool($base)) {
        $add = array_diff($added, $base);
        $sub = array_diff($scope, $added);
        $rest = array_diff($base, $sub);
        $added = array_merge($add, $rest);
        $added = array_unique($added);
    }
    return $added;
}

function manage_access_levels() {
    global $wpdb;
    if (isset($_POST['add_new'])) {
        $alias = esc_sql(stripslashes($_POST['wpm_levels']['new_level']['name']));
        if (empty($alias)) {
            echo '<div id="message" style="color:red;" class="updated fade"><p>Level Name Is Required.</p></div>';
            return;
        }
        $exists = $wpdb->get_col("SELECT id from " . WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE . " WHERE alias = '" . $alias . "'");
        if (count($exists) > 0) {
            echo '<div id="message" style="color:red;" class="updated fade"><p>Membership level name already used. Please use a different name.</p></div>';
            return;
        }
        $role = $_POST['wpm_levels']['new_level']['role'];
        $login_redirect = esc_sql($_POST['wpm_levels']['new_level']['loginredirect']);
        $campaign_name = esc_sql(stripslashes($_POST['wpm_levels']['new_level']['campaign_name']));
        if (isset($_POST['wpm_levels']['new_level']['noexpire']) && ($_POST['wpm_levels']['new_level']['noexpire'] == 'noexpire')) {
            $subscription_period = 0;
            $subscription_unit = null;
        } else if (isset($_POST['wpm_levels']['new_level']['noexpire']) && ($_POST['wpm_levels']['new_level']['noexpire'] == 'fixed_date')) {
            $subscription_period = 0;
            $subscription_unit = $_POST['wpm_levels']['new_level']['expire_date'];
        } else {
            $subscription_period = esc_sql($_POST['wpm_levels']['new_level']['expire']);
            $subscription_unit = esc_sql($_POST['wpm_levels']['new_level']['calendar']);
        }
        $permissions = 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allcustomposts']) ? 32 : 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allattachments']) ? 16 : 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allpages']) ? 8 : 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allposts']) ? 4 : 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allcomments']) ? 2 : 0;
        $permissions += isset($_POST['wpm_levels']['new_level']['allcategories']) ? 1 : 0;
        $fields['role'] = $role;
        $fields['alias'] = $alias;
        $fields['permissions'] = $permissions;
        $fields['loginredirect_page'] = trim($login_redirect);
        $fields['subscription_period'] = $subscription_period;
        $fields['subscription_unit'] = $subscription_unit;
        $fields['campaign_name '] = $campaign_name;
        $ret = dbAccess::insert(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, $fields);
        if ($ret === false)
            echo '<div id="message" style="color:red;" class="updated fade"><p>Membership Level &quot;' . $_POST['wpm_levels']['new_level']['name'] . '&quot; couldn\'t be created due to error.</p></div>';
        else {
            echo '<div id="message" class="updated fade"><p>Membership Level &quot;' . $_POST['wpm_levels']['new_level']['name'] . '&quot; created.</p></div>';
            do_action('eMember_new_membership_level_added', $_POST);
        }
    } else if (isset($_POST['update_info'])) {
        foreach ($_POST['wpm_levels'] as $id => $wp_level) {
            $alias = esc_sql(stripslashes($wp_level['name']));
            $role = $wp_level['role'];
            $login_redirect = esc_sql($wp_level['loginredirect']);
            $campaign_name = esc_sql(stripslashes($wp_level['campaign_name']));
            if (isset($wp_level['noexpire']) && ($wp_level['noexpire'] == 'noexpire')) {
                $subscription_period = 0;
                $subscription_unit = null;
            } else if (isset($wp_level['noexpire']) && ($wp_level['noexpire'] == 'fixed_date')) {
                $subscription_period = 0;
                $subscription_unit = $wp_level['expire_date'];
            } else if (isset($wp_level['noexpire']) && ($wp_level['noexpire'] == 'interval')) {
                $subscription_period = esc_sql($wp_level['expire']);
                $subscription_unit = esc_sql($wp_level['calendar']);
            }
            $permissions = 0;
            $permissions += isset($wp_level['allcustomposts']) ? 32 : 0;
            $permissions += isset($wp_level['allattachments']) ? 16 : 0;
            $permissions += isset($wp_level['allpages']) ? 8 : 0;
            $permissions += isset($wp_level['allposts']) ? 4 : 0;
            $permissions += isset($wp_level['allcomments']) ? 2 : 0;
            $permissions += isset($wp_level['allcategories']) ? 1 : 0;
            $fields['role'] = $role;
            $fields['alias'] = $alias;
            $fields['permissions'] = $permissions;
            $fields['loginredirect_page'] = trim($login_redirect);
            $fields['subscription_period'] = $subscription_period;
            $fields['subscription_unit'] = $subscription_unit;
            $fields['campaign_name'] = $campaign_name;
            /**
             * @todo update role based on flags.
             * */
            $ret = dbAccess::update(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id = ' . $wp_level['id'], $fields);

            if ($ret === false)
                echo '<div id="message" style="color:red;" class="updated fade"><p>Membership Level Update Failed..</p></div>';
            else {
                echo '<div id="message" class="updated fade"><p>Membership Level Updated.</p></div>';
                do_action('eMember_membership_level_updated', $_POST);
            }
        }
    } else if (isset($_GET['delete'])) {
        $ret = dbAccess::delete(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id=' . $_GET['delete']);
        if ($ret === false)
            echo '<div id="message" style="color:red;" class="updated fade"><p>Membership Level Couldn\'t be deleted due to error.</p></div>';
        else if ($ret === 0)
            echo '<div id="message" style="color:red;" class="updated fade"><p>Nothing to delete.</p></div>';
        else {
            echo '<div id="message" class="updated fade"><p>Membership Level Deleted.</p></div>';
            do_action('eMember_membership_level_deleted', $_POST);
        }
    }

    $all_levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
    include_once('views/manage_access_levels_view.php');
}
