<?php

function emember_admin_functions_users_menu() {
    global $wpdb;
    //$emember_config = Emember_Config::getInstance();
    if (isset($_POST['emember_bulk_user_subs_start_date_change_process'])) {
        $errorMsg = "";
        $level_id = $_POST["emember_bulk_user_subs_start_date_change_level"];
        $new_date = $_POST['emember_bulk_user_subs_start_date_change_date'];

        if ($level_id == 'please_select') {
            $errorMsg = 'Error! Please select a membership level first.';
        }

        if (empty($errorMsg)) {//No validation errors so go ahead
            $query = "SELECT * FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . " WHERE membership_level='$level_id'";
            $member_records = $wpdb->get_results($query);
            if ($member_records) {
                foreach ($member_records as $row) {
                    $member_id = $row->member_id;
                    $fields = array();
                    $fields['subscription_starts'] = $new_date;
                    $ret = dbAccess::update(WP_EMEMBER_MEMBERS_TABLE_NAME, ' member_id = ' . $member_id, $fields);
                    if ($ret === false) {
                        $errorMsg = 'Subscription start date change failed.';
                    }
                }
            }
        }

        $message = "";
        if (!empty($errorMsg)) {
            $message = $errorMsg;
        } else {
            $message = 'Subscription start date change operation successfully completed.';
        }
        echo '<div id="message" class="updated fade"><p><strong>';
        echo $message;
        echo '</strong></p></div>';
    }

    if (isset($_POST['emember_bulk_user_change_level_process'])) {
        $errorMsg = "";
        $from_level_id = $_POST["emember_bulk_user_change_level_from"];
        $to_level_id = $_POST['emember_bulk_user_change_level_to'];

        if ($from_level_id == 'please_select' || $to_level_id == 'please_select') {
            $errorMsg = 'Error! Please select a membership level first.';
        }

        if (empty($errorMsg)) {//No validation errors so go ahead
            $query = "SELECT * FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME . " WHERE membership_level='$from_level_id'";
            $member_records = $wpdb->get_results($query);
            if ($member_records) {
                foreach ($member_records as $row) {
                    $member_id = $row->member_id;
                    emember_update_membership_level($member_id, $to_level_id);
                }
            }
        }

        $message = "";
        if (!empty($errorMsg)) {
            $message = $errorMsg;
        } else {
            $message = 'Membership level change operation successfully completed.';
        }
        echo '<div id="message" class="updated fade"><p><strong>';
        echo $message;
        echo '</strong></p></div>';
    }
    ?>

    <div class="postbox">
        <h3><label for="title">Bulk Update Subscription Start Date of Members</label></h3>
        <div class="inside">

            <p>The subscription start date of a member is set to the day he/she registers. You can manually set a specific subscription start date of all members who belong to a particular level using the following option.</p>
            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

                <table width="100%" border="0" cellspacing="0" cellpadding="6">
                    <tr valign="top">
                        <td width="25%" align="left">
                            <strong>Membership Level: </strong>
                        </td><td align="left">
                            <select name="emember_bulk_user_subs_start_date_change_level">
                                <option value="please_select">Select Level</option>
                                <?php
                                $all_levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
                                foreach ($all_levels as $level) {
                                    ?>
                                    <option value="<?php echo $level->id ?>"><?php echo $level->alias; ?></option>
                                <?php } ?>
                            </select>
                            <br /><i>Select the Membership level (the subscription start date of all members who are in this level will be updated).</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Subscription Start Date: </strong>
                        </td><td align="left">
                            <input name="emember_bulk_user_subs_start_date_change_date" id="emember_bulk_user_subs_start_date_change_date" type="text" size="20" value="<?php echo (date("Y-m-d")); ?>" />
                            <br /><i>Specify the subscription start date.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <input type="submit" class="button" name="emember_bulk_user_subs_start_date_change_process" value="Bulk Change Subscription Start Date &raquo;" />
                        </td><td align="left"></td>
                    </tr>

                </table>
            </form>
        </div></div>

    <div class="postbox">
        <h3><label for="title">Bulk Update Membership Level of Members</label></h3>
        <div class="inside">

            <p>You can manually change the membership level of any member by editing the record from the members menu. You can use the following option to bulk update the membership level of users who belong to the level you select below.</p>
            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">

                <table width="100%" border="0" cellspacing="0" cellpadding="6">
                    <tr valign="top">
                        <td width="25%" align="left">
                            <strong>Membership Level: </strong>
                        </td><td align="left">
                            <select name="emember_bulk_user_change_level_from">
                                <option value="please_select">Select Current Level</option>
                                <?php
                                $all_levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
                                foreach ($all_levels as $level) {
                                    ?>
                                    <option value="<?php echo $level->id ?>"><?php echo $level->alias; ?></option>
                                <?php } ?>
                            </select>
                            <br /><i>Select the current membership level (the membership level of all members who are in this level will be updated).</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Level to Change to: </strong>
                        </td><td align="left">
                            <select name="emember_bulk_user_change_level_to">
                                <option value="please_select">Select Target Level</option>
                                <?php
                                $all_levels = dbAccess::findAll(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' id != 1 ', ' id DESC ');
                                foreach ($all_levels as $level) {
                                    ?>
                                    <option value="<?php echo $level->id ?>"><?php echo $level->alias; ?></option>
                                <?php } ?>
                            </select>

                            <br /><i>Select the new membership level</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <input type="submit" class="button" name="emember_bulk_user_change_level_process" value="Bulk Change Membership Level &raquo;" />
                        </td><td align="left"></td>
                    </tr>

                </table>
            </form>
        </div></div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#emember_bulk_user_subs_start_date_change_date").dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
        });
    </script>

    <?php
}
