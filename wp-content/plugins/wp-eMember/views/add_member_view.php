<style type="text/css">
    .emember_upload { padding: 0 20px; float: left; width: 230px; }
    .emember_upload_wrapper { width: 133px;  }
    .emember_upload_div {height: 24px;width: 133px;left:0%;background: #FFF 0 0;
                         font-size: 14px; color: #000; text-align: center; padding-top: 0px;
    }
    /*
    We can't use ":hover" preudo-class because we have
    invisible file input above, so we have to simulate
    hover effect with JavaScript.
    */
    .emember_upload_div.hover {
        background: #6D6D6D 0 56px;
        color: #FFF;
    }
    .emember_upload_div a.hover{
        color:#fff;
    }
</style>
<script type="text/javascript">
    /* <![CDATA[ */
    jQuery(document).ready(function($) {
<?php include_once(WP_EMEMBER_PATH . '/js/emember_js_form_validation_rules.php'); ?>
        $.validationEngineLanguage.allRules['ajaxUserCall']['url'] = '<?php echo admin_url('admin-ajax.php'); ?>';
        $("#wp_emember_admin_regform").validationEngine('attach');
    });
    /* ]]> */
</script>
<div id="poststuff"><div id="post-body">
        <form method="post" id="wp_emember_admin_regform" action="admin.php?page=wp_eMember_manage&members_action=add_edit">
            <!--<form method="post" action="javascript:void(0);">-->

            <div class="postbox">
                <h3><label for="title">Member Details</label></h3>
                <div class="inside">

                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php _e('Username', 'wp_eMember'); ?></th>
                            <td>
                                <?php
                                if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')) {
                                    if (empty($editingrecord['user_name'])) {//This is a record with incomplete registration
                                        ?>
                                        <div class="eMember_yellow_box" style="max-width:450px;">
                                            <p>This account registration is not complete yet. It is waiting for the user to click on the unique registration completion link and complete the registration by choosing a username and password.</p>
                                            <p>You can go to the <a href="admin.php?page=eMember_admin_functions_menu" target="_blank">Admin Functions Menu</a> and generate another unique "Registration Completion" link then send the link to the user. Alternatively, you can use that link yourself and complete the registration on behalf of the user.</p>
                                            <p>If you suspect that this user has lost interest in becoming a member then you can delete this member record.</p>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <input name="editedrecord" id="editedrecord"  type="hidden" value="<?php echo $_GET['editrecord']; ?>" />
                                    <input name="user_name" id="user_name"  type="hidden" value="<?php echo stripslashes($editingrecord['user_name']); ?>" />
                                    <b><?php echo stripslashes($editingrecord['user_name']); ?></b>
                                    <?php
                                } else {
                                    ?>
                                    <input name="user_name" class="validate[required,custom[ememberUserName],minSize[4],ajax[ajaxUserCall]]" type="text" id="user_name" value="<?php echo stripslashes(isset($editingrecord['user_name']) ? $editingrecord['user_name'] : ""); ?>" size="53" />
                                    <br/><?php _e('Username of the Member', 'wp_eMember'); ?>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')):
                            ?>
                            <?php
                            $emember_config = Emember_Config::getInstance();
                            if ($emember_config->getValue('eMember_profile_thumbnail')):
                                ?>
                                <tr>
                                    <th><?php echo EMEMBER_PROFILE_IMAGE; ?>:</th>
                                    <td>
                                        <div>
                                            <div>
                                                <img id="emem_profile_image" src="<?php echo $image_url; ?>"  width="100px" height="100px"/>
                                            </div>
                                            <?php if (empty($use_gravatar)): ?>
                                                <div id="emember-file-uploader-admin">
                                                    <noscript>
                                                    <p>Please enable JavaScript to use file uploader.</p>
                                                    <!-- or put a simple form for upload here -->
                                                    </noscript>
                                                </div>
                                                <div id="emember-profile-remove-cont" class="qq-remove-file" style="display:none;">
                                                    <a id="remove_button" href="<?php echo $image_path; ?>">Remove</a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="clear"></div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endif;
                        ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('First Name', 'wp_eMember'); ?></th>
                            <td><input name="first_name" type="text" id="first_name" value="<?php echo stripslashes(isset($editingrecord['first_name']) ? $editingrecord['first_name'] : ""); ?>" size="53" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Last Name', 'wp_eMember'); ?></th>
                            <td><input name="last_name" type="text" id="last_name" value="<?php echo stripslashes(isset($editingrecord['last_name']) ? $editingrecord['last_name'] : ""); ?>" size="53" /></td>
                        </tr>
                        <?php if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')): ?>
                            <tr valign="top">
                                <th scope="row"><?php _e('Password', 'wp_eMember'); ?></th>
                                <td><input name="password" type="password" id="password"  value=""  size="53" /> <!--class="validate[equals[retype_password]]"-->
                                    Leave empty to keep current password.</td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Retype Password', 'wp_eMember'); ?></th>
                                <td><input name="retype_password" type="password" id="retype_password" class="validate[equals[password]]" value="" size="53" /></td>
                            </tr>
                        <?php else: ?>
                            <tr valign="top">
                                <th scope="row"><?php _e('Password', 'wp_eMember'); ?></th>
                                <td><input name="password" type="password" id="password" value=""  size="53" /><!--class="validate[required,equals[retype_password]]"-->
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Retype Password', 'wp_eMember'); ?></th>
                                <td><input name="retype_password" type="password" id="retype_password" class="validate[required,equals[password]]" value="" size="53" /></td>
                            </tr>
                        <?php endif; ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('Company', 'wp_eMember'); ?></th>
                            <td><input name="company_name" type="text" id="company_name" value="<?php echo stripslashes(isset($editingrecord['company_name']) ? $editingrecord['company_name'] : ""); ?>" size="53" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Member Since', 'wp_eMember'); ?></th>
                            <td><input name="member_since" type="date" id="member_since" value="<?php echo (!isset($editingrecord['member_since']) || empty($editingrecord['member_since'])) ? date('Y-m-d') : $editingrecord['member_since']; ?>" size="20" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?php _e('Membership Level', 'wp_eMember'); ?></th>
                            <td>
                                <select name="membership_level"  id="membership_level">
                                    <?php
                                    $editingrecord['membership_level'] = isset($editingrecord['membership_level']) ? $editingrecord['membership_level'] : "";
                                    foreach ($all_levels as $level) {
                                        ?>
                                        <option <?php echo ($editingrecord['membership_level'] === $level->id) ? "selected='selected'" : null; ?> value="<?php echo $level->id ?>"><?php echo stripslashes($level->alias); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php if ($emember_config->getValue('eMember_enable_secondary_membership')): ?>
                            <tr valign="top">
                                <th scope="row"><?php _e('Additional Membership Levels', 'wp_eMember'); ?></th>
                                <td>
                                    <table id="eMembership_level_container">
                                        <?php
                                        $editingrecord['more_membership_levels'] = isset($editingrecord['more_membership_levels']) ? $editingrecord['more_membership_levels'] : array();
                                        foreach ($all_levels as $level) {
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="eMembership_level" id="membership_level_<?php echo $level->id; ?>" name=more_membership_levels[] value="<?php echo $level->id; ?>" <?php echo in_array($level->id, $editingrecord['more_membership_levels']) ? "checked='checked'" : "" ?>  ></input></td>
                                                <td><?php echo stripslashes($level->alias); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr valign="top">
                            <th scope="row"><?php
                                _e('Account State', 'wp_eMember');
                                $editingrecord['account_state'] = isset($editingrecord['account_state']) ? $editingrecord['account_state'] : "";
                                ?></th>
                            <td>
                                <select name="account_state"  id="account_state">
                                    <option <?php echo ($editingrecord['account_state'] === 'active') ? "selected='selected'" : null; ?> value="active">Active</option>
                                    <option <?php echo ($editingrecord['account_state'] === 'inactive') ? "selected='selected'" : null; ?> value="inactive">Inactive</option>
                                    <option <?php echo ($editingrecord['account_state'] === 'expired') ? "selected='selected'" : null; ?> value="expired">Expired</option>
                                    <option <?php echo ($editingrecord['account_state'] === 'pending') ? "selected='selected'" : null; ?> value="pending">Pending</option>
                                </select>
                            </td>
                        </tr>

                        <?php if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')) { ?>
                            <tr valign="top">
                                <th scope="row"><?php _e('Send a Notification to the User', 'wp_eMember'); ?></th>
                                <td><input type="checkbox" id="account_status_change" name="account_status_change"></input>
                                    <br /><i>You can use this option to send a quick notification email to this member (the email will be sent when you hit the save button below).</i>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr valign="top">
                            <th scope="row"><?php _e('Email Address', 'wp_eMember'); ?></th>
                            <td><input name="email" type="text" class="validate[required,custom[email]]" id="email" value="<?php echo stripslashes(isset($editingrecord['email']) ? $editingrecord['email'] : ""); ?>" size="53" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Phone No.', 'wp_eMember'); ?></th>
                            <td><input name="phone" type="text" id="phone" class="validate[custom[phone]]" value="<?php echo stripslashes(isset($editingrecord['phone']) ? $editingrecord['phone'] : ""); ?>" size="53" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Address Street', 'wp_eMember'); ?></th>
                            <td><input name="address_street" type="text" id="address_street" value="<?php echo stripslashes(isset($editingrecord['address_street']) ? $editingrecord['address_street'] : ""); ?>" size="53" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?php _e('Address City', 'wp_eMember'); ?></th>
                            <td><input name="address_city" type="text" id="address_city" value="<?php echo stripslashes(isset($editingrecord['address_city']) ? $editingrecord['address_city'] : ""); ?>" size="53" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?php _e('Address State', 'wp_eMember'); ?></th>
                            <td><input name="address_state" type="text" id="address_state" value="<?php echo stripslashes(isset($editingrecord['address_state']) ? $editingrecord['address_state'] : ""); ?>" size="53" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><?php _e('Address Zipcode', 'wp_eMember'); ?></th>
                            <td><input name="address_zipcode" type="text" id="address_zipcode" value="<?php echo stripslashes(isset($editingrecord['address_zipcode']) ? $editingrecord['address_zipcode'] : ""); ?>" size="53" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Country', 'wp_eMember'); ?></th>
                            <td>
                                <select name="country" id="country">
                                    <?php echo emember_country_list_dropdown(stripslashes(isset($editingrecord['country']) ? $editingrecord['country'] : "")); ?>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('After Login Page URL', 'wp_eMember'); ?></th>
                            <td><input name="home_page" type="text" id="home_page" value="<?php echo stripslashes(isset($editingrecord['home_page']) ? $editingrecord['home_page'] : ""); ?>" size="53" />
                                <br /><i>The member will be sent to this URL after login if you spcify one here. You will need to keep the "Enable After login Redirection" feature checked from the settings menu.</i>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php
                                _e('Gender', 'wp_eMember');
                                $editingrecord['gender'] = isset($editingrecord['gender']) ? $editingrecord['gender'] : "";
                                ?></th>
                            <td>
                                <select name="gender" id="gender">
                                    <option <?php echo ($editingrecord['gender'] === 'male') ? "selected='selected'" : null; ?> value="male">Male</option>
                                    <option <?php echo ($editingrecord['gender'] === 'female') ? "selected='selected'" : null; ?> value="female">Female</option>
                                    <option <?php echo ($editingrecord['gender'] === 'not specified') ? "selected='selected'" : null; ?> value="not specified">Not Specified</option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Referrer', 'wp_eMember'); ?></th>
                            <td><input name="referrer" type="text" id="referrer" value="<?php echo stripslashes(isset($editingrecord['referrer']) ? $editingrecord['referrer'] : ""); ?>" size="53" /></td>

                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php _e('Subscription Starts', 'wp_eMember'); ?></th>
                            <td><input name="subscription_starts" type="date" id="subscription_starts" value="<?php echo (!isset($editingrecord['subscription_starts']) || empty($editingrecord['subscription_starts'])) ? date('Y-m-d') : $editingrecord['subscription_starts']; ?>" size="20" /></td>
                        </tr>

                        <?php
                        if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')) {//show additional info
                            ?>
                            <tr valign="top"><td colspan="2">
                                    <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                                </td></tr>
                            <tr valign="top"><td colspan="2"><strong>Additional Info</strong></td></tr>

                            <tr valign="top">
                                <th scope="row"><?php _e('Unique Reference/Subscriber ID', 'wp_eMember'); ?></th>
                                <td><input name="subscr_id" type="text" id="subscr_id" value="<?php echo stripslashes(isset($editingrecord['subscr_id']) ? $editingrecord['subscr_id'] : ""); ?>" size="53" />
                                    <br /><i>This reference value is used to recognize future membership payments from this user. You do not need to change the value of this field.</i>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Last Accessed From IP', 'wp_eMember'); ?></th>
                                <td><b><?php echo stripslashes(isset($editingrecord['last_accessed_from_ip']) ? $editingrecord['last_accessed_from_ip'] : ""); ?></b></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Last Access Time', 'wp_eMember'); ?></th>
                                <td><b><?php echo stripslashes(isset($editingrecord['last_accessed']) ? $editingrecord['last_accessed'] : ""); ?></b></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Expiry Date', 'wp_eMember'); ?></th>
                                <td><b><?php
                                        $member_id = $_GET['editrecord']; //TODO
                                        $expiry_dt = emember_get_expiry_by_member_id($member_id);
                                        if ($expiry_dt != "noexpire") {
                                            echo $expiry_dt;
                                        } else {
                                            echo "No expiry or until cancelled";
                                        }
                                        ?></b></td>
                            </tr>

                            <?php
                        }//End of additional info
                        ?>

                        <?php
//Custom fields
                        if ($emember_config->getValue('eMember_custom_field')):
                            ?>
                            <tr valign="top"><td colspan="2">
                                    <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                                </td></tr>
                            <tr valign="top"><td colspan="2"><strong>Custom Fields</strong></td></tr>
                            <?php
                            $custom_fields = get_option('emember_custom_field_type');
                            if (!isset($custom_fields['emember_field_flag']))
                                for ($i = 0; isset($custom_fields['emember_field_name'][$i]); $i++) {
                                    $emember_field_name = $custom_fields['emember_field_name'][$i];
                                    $emember_field_name = stripslashes($emember_field_name);
                                    $emember_field_name_index = emember_escape_custom_field($emember_field_name);
                                    ?>
                                    <tr>
                                        <th><label for="<?php echo $emember_field_name_index ?>" class=""><?php echo $emember_field_name ?>: </label></th>
                                        <td>
                                            <?php
                                            $field_value = isset($edit_custom_fields[$emember_field_name_index]) ? $edit_custom_fields[$emember_field_name_index] : "";
                                            $field_value = isset($_POST['emember_custom'][$emember_field_name_index]) ? $_POST['emember_custom'][$emember_field_name_index] : $field_value;
                                            $field_value = stripslashes($field_value);
                                            switch ($custom_fields['emember_field_type'][$i]) {
                                                case 'text':
                                                    ?>
                                                    <input type="text" size="53" id="wp_emember_<?php echo $emember_field_name_index; ?>" value="<?php echo $field_value; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" size="20"  class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? ' validate[required] ' : ""; ?>" />
                                                    <?php
                                                    break;
                                                case 'dropdown':
                                                    ?>
                                                    <select name="emember_custom[<?php echo $emember_field_name_index; ?>]" id="wp_emember_<?php echo $emember_field_name_index; ?>" class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? ' validate[required] ' : ""; ?>">
                                                        <option value=""><?php echo EMEMBER_SELECT_ONE; ?></option>
                                                        <?php
                                                        $options = stripslashes($custom_fields['emember_field_extra'][$i]);
                                                        $options = explode(',', $options);

                                                        foreach ($options as $option) {
                                                            $option = explode("=>", $option);
                                                            ?>
                                                            <option <?php echo ($field_value === $option[0]) ? "selected='selected'" : ""; ?> value="<?php echo $option[0]; ?>"><?php echo $option[1]; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    break;
                                                case 'checkbox':
                                                    ?>
                                                    <input <?php echo $field_value ? "checked='checked'" : ""; ?> type="checkbox" value="checked" id="wp_emember_<?php echo $emember_field_name_index; ?>" name="emember_custom[<?php echo $emember_field_name_index; ?>]" class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? ' validate[required] ' : ""; ?>" />
                                                    <?php
                                                    break;
                                                case 'textarea':
                                                    ?>
                                                    <textarea name="emember_custom[<?php echo $emember_field_name_index; ?>]" id="wp_emember_<?php echo $emember_field_name_index; ?>" class="<?php echo in_array($i, $custom_fields['emember_field_requred']) ? 'validate[required] ' : ""; ?>" ><?php echo $field_value; ?></textarea>
                                                    <?php
                                                    break;
                                                    ?>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                        endif;
                        ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('Admin Notes', 'wp_eMember'); ?></th>
                            <td><textarea name="notes" id="notes" cols="50" rows="3"><?php echo stripslashes(isset($editingrecord['notes']) ? $editingrecord['notes'] : "") ?></textarea>
                                <br /><i>Use this field to save/add any notes about this user. This will only be visible to the admin.</i>
                            </td>
                        </tr>
                    </table>
                    <?php if (isset($member_id)): ?>
                        <?php $param = array('member_id' => $member_id, 'membership_level' => $editingrecord['membership_level']) ?>
                        <?php echo apply_filters('emember_form_builder_edit_custom_fields', '', $param) ?>
                    <?php endif; ?>
                    <p class="submit">
                        <input type="submit" class="button-primary" name="Submit" value="<?php _e('Save Member Info', 'wp_eMember'); ?>" /> &nbsp; <?php if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '')) { ?>
                            <input type="button" class="button" secret="<?php echo $_GET['editrecord']; ?>" name="deleterecord" id="deleterecord" value="<?php _e('Delete Member', 'wp_eMember'); ?>" /><?php } ?>
                    </p>

                </div></div>

        </form>
    </div></div>
<script type="text/javascript">
    /* <![CDATA[ */
<?php
$emember_config = Emember_Config::getInstance();
$emember_auth = Emember_Auth::getInstance();
?>
    jQuery(document).ready(function($) {
        $('#emember-profile-remove-cont').on('emember_profile', function() {
            var button = $('#remove_button');
            var id = button.attr('href');
            if (id)
                $(this).show();
            else
                $(this).hide();
        }).trigger('emember_profile');

        var upload_button = $("#upload_button");
        $('#membership_level').change(function() {
            $('.eMembership_level').removeAttr('disabled');
            $('#membership_level_' + $(this).val()).
                    attr('disabled', 'disabled').attr('checked', 'checked');
        }).change();
<?php
if (isset($_GET['editrecord']) && ($_GET['editrecord'] != '') && empty($use_gravatar)) {
    if ($emember_config->getValue('eMember_profile_thumbnail')):
        ?>
                $('#remove_button').click(function(e) {
                    var imagepath = $(this).attr('href');
                    if (imagepath) {
                        $.get('<?php echo admin_url('admin-ajax.php'); ?>',
                                {"action": "delete_profile_picture", "path": imagepath},
                        function(data) {
                            $("#emem_profile_image").attr("src",
                                    "<?php echo WP_EMEMBER_URL; ?>/images/default_image.gif?" + (new Date()).getTime());
                            $('#remove_button').attr('href', '');
                            $('#emember-profile-remove-cont').trigger('emember_profile');
                        },
                                "json");
                    }
                    e.preventDefault();
                });
                var uploader = new qq.FileUploader({
                    button_label: 'Upload a file',
                    element: document.getElementById('emember-file-uploader-admin'),
                    action: '<?php echo admin_url("admin-ajax.php"); ?>',
                    params: {'action': 'emember_upload_ajax', 'image_id': '<?php echo $_GET['editrecord']; ?>'},
                    onComplete: function(id, fileName, responseJSON) {
                        if (responseJSON.success) {
        <?php $upload_dir = wp_upload_dir(); ?>
                            var $url = "<?php echo $upload_dir['baseurl']; ?>/emember/" + responseJSON.filename + "?" + (new Date()).getTime();
                            var $dir = responseJSON.id;
                            jQuery("#emem_profile_image").attr("src", $url);
                            jQuery('#remove_button').attr('href', $dir);
                            $('#emember-profile-remove-cont').trigger('emember_profile');
                        }
                    }});
    <?php endif;
}
?>
        $('#deleterecord').click(function() {
            var u = 'admin.php?page=wp_eMember_manage&members_action=delete&deleterecord=' +
                    $(this).attr('secret') + '&confirm=1';
            top.document.location = u;
            return false;
        });
        $('#deleterecord').confirm({timeout: 5000});
        $("#subscription_starts").dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
        $("#member_since").dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
        $('#account_status_change').change(function() {
            var target = $(this).closest('tr');
<?php
$mail = $emember_config->getValue('eMember_status_change_email_body');
$head = $emember_config->getValue('eMember_status_change_email_subject');
?>
            var mail = <?php echo json_encode(array('b' => $mail, 'h' => $head)); ?>;
            var $body = '<textarea rows="5" cols="60" id="notificationmailbody" name="notificationmailbody">' + mail.b + '</textarea>';
            var $head = '<input type="text" size="60" id="notificationmailhead" name="notificationmailhead" value="' + mail.h + '" />';
            var content = '<tr><th scope="row">Mail Subject</th><td>' + $head + '</td></tr>';
            content += '<tr><th scope="row">Mail Body</th><td>' + $body + '</td></tr>';
            if (this.checked) {
                target.after(content);
            }
            else {
                if (target.next('tr').find('#notificationmailhead').length > 0) {
                    target.next('tr').remove();
                    target.next('tr').remove();
                }
            }
        }).change();
    });
    /*]]>*/
</script>
