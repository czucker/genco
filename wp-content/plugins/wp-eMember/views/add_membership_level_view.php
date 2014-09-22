<form id="emember_form" method="post">
    <h3 style="margin-bottom: 5pt;">Add/Edit Membership Level</h3>
    <input name="wpm_levels[new_level][id]" id="hidden_id" type="hidden" value="<?php echo $id; ?>" ></input>
    <table id="new_level" class="widefat wpm_nowrap">
        <tbody>
            <tr id="wpm_new_row" >
                <th  style="padding:5px 4px 8px;" scope="row">Membership Level Name</th>
                <td colspan="4"><input emember_required="1" class="validate[required,ajax[ajaxUserLevelCall]]" type="text" value="<?php echo stripslashes($name); ?>" size="25" id="level_name_new_level" name="wpm_levels[new_level][name]"/>
                    <br /><i> Name of the Membership Level (eg. Silver, Gold, Platinum)</i>
                </td>
            </tr>
            <tr  class="alternate">
                <th style="padding:5px 4px 8px;" scope="row">Default WordPress Role</th>
                <td colspan="4">
                    <select id="level_name_new_role" name="wpm_levels[new_level][role]">
                        <?php
                        $roles = new WP_Roles();
                        foreach ($roles->role_names as $key => $value):
                            ?>
                            <option <?php echo ($key == $role) ? "selected='selected'" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br /><i> This option is only used if you are using the WordPress user integration feature. When used, the members signing up to this membership level will have the specified WordPress role.</i>
                </td>
            </tr>
            <tr >
                <th style="padding:5px 4px 8px;" scope="row">Redirect After Login</th>
                <td colspan="4"><input id="level1_name_new_loginredirect" type="text" size="70" value="<?php echo $loginredirect; ?>" name="wpm_levels[new_level][loginredirect]"/>
                    <br /><i>The URL of the main page for this membership level. Members who belong to this level will be redirected to this page after they login. Leave empty if you do not have a main page for this level.</i>
                </td>
            </tr>
            <tr class="alternate">
                <th style="padding:5px 4px 8px;" scope="row" >Global Access To</th>
                <td colspan="4"><label><input id="level_name_new_allpages" <?php echo $allpages; ?> type="checkbox" name="wpm_levels[new_level][allpages]"/>Pages</label>
                    <label><input id="level_name_new_allcategories" <?php echo $allcategories; ?> type="checkbox" name="wpm_levels[new_level][allcategories]"/>Categories</label>
                    <label><input id="level_name_new_allposts" type="checkbox" <?php echo $allposts; ?> name="wpm_levels[new_level][allposts]"/>Posts</label>
                    <label><input id="level_name_new_allcomments" type="checkbox" <?php echo $allcomments; ?> name="wpm_levels[new_level][allcomments]"/>Comments</label>
                    <label><input id="level_name_new_allattachments" type="checkbox" <?php echo $allattachments; ?> name="wpm_levels[new_level][allattachments]"/>Attachments</label>
                    <label><input id="level_name_new_allcustomposts" type="checkbox" <?php echo $allcustomposts; ?> name="wpm_levels[new_level][allcustomposts]"/>Custom Posts</label>

                    <br /><i>Globally turn on or off access to content (eg. posts, pages, comments) for this membership level here. Checking these checkboxes do not give the member access to all content. It simply allows you to customize the content protection (eg. access to certain posts or pages) via the <a href="admin.php?page=eMember_membership_level_menu&level_action=2" target="_blank">Manage Content Protection</a> menu</i>
                </td>
            </tr>
            <tr >
                <th style="padding:5px 4px 8px;" scope="row">Subscription Duration</th>
                <td colspan="4">
                    <label>
                        <input class="emember_sub_duration" type="radio" <?php echo ($expire == "interval") ? "checked='checked'" : "" ?> id="noexpire_button_interval_new_level"  value="interval" name="wpm_levels[new_level][noexpire]"/>
                        Expire After an Interval
                    </label>
                    <input type="text" emember_required="1" size="3" <?php echo ($expire == "interval") ? "" : "disabled='disabled'" ?> id="level_name_new_expire" name="wpm_levels[new_level][expire]" value="<?php echo $subscription_period; ?>"/>
                    <select id="level_name_new_calendar" <?php echo ($expire == "interval") ? "" : "disabled='disabled'" ?> name="wpm_levels[new_level][calendar]">
                        <option <?php echo ($subscription_unit == 'Days') ? "selected='selected'" : ""; ?> value="Days">Days</option>
                        <option <?php echo ($subscription_unit == 'Weeks') ? "selected='selected'" : ""; ?> value="Weeks">Weeks</option>
                        <option <?php echo ($subscription_unit == 'Months') ? "selected='selected'" : ""; ?> value="Months">Months</option>
                        <option <?php echo ($subscription_unit == 'Years') ? "selected='selected'" : ""; ?> value="Years">Years</option>
                    </select>
                    <br/>
                    <label>
                        <input class="emember_sub_duration" type="radio" id="noexpire_button_new_level" <?php echo ($expire == "noexpire") ? "checked='checked'" : "" ?>  value="noexpire" name="wpm_levels[new_level][noexpire]"/>
                        No Expiry or Until Cancelled
                    </label>
                    <br/>
                    <label>
                        <input class="emember_sub_duration" type="radio" id="noexpire_button_fixed_date_new_level" <?php echo ($expire == "fixed_date") ? "checked='checked'" : "" ?> value="fixed_date" name="wpm_levels[new_level][noexpire]"/>
                        Expire After a Fixed Date
                    </label>
                    <input type="date" emember_required="1" <?php echo ($expire == "fixed_date") ? "" : "disabled='disabled'" ?> id="expire_on_fixed_date_new_level"  value="<?php echo isset($fixed_date) ? $fixed_date : date('Y-m-d'); ?>" name="wpm_levels[new_level][expire_date]"/>
                    <br /><i>When members sign up for this membership level their membership will be active for the duration of the subscription period unless they renew it (For example: by making another payment)</i>
                </td>
            </tr>

            <tr class="alternate">
                <th style="padding:5px 4px 8px;" scope="row">Autoresponder List/Campaign Name (optional)</th>
                <td colspan="4"><input id="level_name_new_campaign_name" type="text" size="70" value="<?php echo stripslashes($campaign_name); ?>" name="wpm_levels[new_level][campaign_name]" />
                    <br /><i>The name of the list/campaign where the members of this membership level will be signed up to (example: "listname@aweber.com" if you are using AWeber or "sample_marketing" if you are using GetResponse or "My Members" if you are using MailChimp). You can find the list/campaign name inside your autoresponder account. Only use this field if you want the members of this level to be signed up to a specific autoresponder list.</i>
                    <br /><i>Make sure you enable your preferred autoresponder from the <a href="admin.php?page=eMember_settings_menu&tab=5" target="_blank">Autoresponder Settings</a> menu if you want to use this field.</i>
                </td>
            </tr>
            <?php
            $level_name = isset($name) ? stripslashes($name) : "";
            $additional_addon_settings = "";
            $additional_addon_settings = apply_filters('eMember_addon_membership_level_settings_filter', $additional_addon_settings, $level_name);
            echo $additional_addon_settings;
            ?>
        </tbody>
    </table>
    <p class="submit">
        <?php if (empty($id)): ?>
            <input type="submit" id="add_update" name="add_new" class="button-primary" value="Submit"/>
        <?php else: ?>
            <input type="submit" id="add_update" name="update_info" class="button-primary" value="Submit"/>
        <?php endif; ?>
        <input type="button" value="Cancel" id="cancel_button" class="button" name="cancel" />
    </p>
</form>
