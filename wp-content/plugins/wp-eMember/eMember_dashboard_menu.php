<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('admin_includes.php');

function wp_eMember_dashboard() {
    echo '<div class="wrap"><h2>WP eMembers - Dashboard v' . WP_EMEMBER_VERSION . '</h2>';
    echo check_php_version();
    echo eMember_admin_submenu_css();
    ?>
    <h3 class="nav-tab-wrapper">
        <a class="nav-tab nav-tab-active" href="#">Dashboard</a>
        <a class="nav-tab" href="admin.php?page=wp_eMember_manage">Members</a>
        <a class="nav-tab" href="admin.php?page=eMember_membership_level_menu">Membership Levels</a>
        <a class="nav-tab" href="admin.php?page=eMember_settings_menu">Settings</a>
    </h3>
    <?php
    wp_eMember_dashboard1();
    echo '</div>';
}

function wp_eMember_dashboard1() {
    global $wpdb;
    $wp_total_members = dbAccess::findCount(WP_EMEMBER_MEMBERS_TABLE_NAME);
    $fields = array('count(*)' => 'count', 'membership_level' => 'membership_level', 'alias' => 'alias');
    $table = WP_EMEMBER_MEMBERS_TABLE_NAME . ' LEFT JOIN ' . WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE . ' ON (membership_level=id) ';
    $last5members = dbAccess::findAll($table, '', ' member_id DESC LIMIT 0,5');
    $members = dbAccess::findCount($table, $fields, null, null, ' membership_level ');
    $query = "SELECT COUNT(member_id) AS active FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . " WHERE account_state = 'active'";
    $active_members = $wpdb->get_col($query);
    ?>
    <table>
        <tbody><tr valign="top">
                <td>
                    <table style="width: 800px;" class="widefat">
                        <thead>
                            <tr>
                                <th scope="col">Membership Stats</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <table cellspacing="5" cellpadding="3" width="100%">
                                        <tbody><tr valign="top">
                                                <td width="50%" style="border: 1px solid rgb(238, 238, 238); background: rgb(248, 248, 248) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; line-height: 1.5em;">
                                                    <h3 style="margin: 0pt 0pt 5px;">Membership level</h3>
                                                    <?php
                                                    if ($members) {
                                                        foreach ($members as $member) {
                                                            ?>
                                                            <div style="float: left; width: 130px;"><a href="#">· <?php echo stripslashes($member->alias); ?></a></div>
                                                            <div style="float: right; width: 35px; text-align: right;"><?php echo $member->count; ?></div>
                                                            <br clear="all"/>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo __('Nothing to show.', 'wp_eMember');
                                                    }
                                                    ?>
                                                    <br clear="all"/>
                                                    <hr>
                                                    <div style="float: left; width: 130px;">· Total Members</div>
                                                    <div style="float: right; width: 35px; text-align: right;"><?php echo $wp_total_members[0]->count; ?></div>
                                                    <br clear="all"/>
                                                    <div style="float: left; width: 130px;">· Active Members</div>
                                                    <div style="float: right; width: 35px; text-align: right;"><?php echo $active_members[0]; ?></div>
                                                </td>
                                                <td width="50%" style="border: 1px solid rgb(238, 238, 238); background: rgb(248, 248, 248) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; line-height: 1.5em;">
                                                    <h3 style="margin: 0pt 0pt 5px;">Recent 5 members</h3>
                                                    <table cellpadding="10px">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>User</th>
                                                                <th>Level</th>
                                                                <th>Since</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if ($last5members) {
                                                                foreach ($last5members as $member) {
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $member->member_id; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo stripslashes($member->user_name); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo stripslashes($member->alias); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo date(get_option('date_format'), strtotime($member->member_since)); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo '<tr> <td colspan="4">' . __('No Members found.', 'wp_eMember') . '</td> </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <br/>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody></table>
    <?php
}
