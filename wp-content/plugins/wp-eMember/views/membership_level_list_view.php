
<div id="emember_membership_list">
    <br/>
    <table id="e_membership_levels"  class="widefat wpm_nowrap">
        <thead>
            <tr>
                <th style="padding:5px 4px 8px;" scope="col">Level ID</th>
                <th style="padding:5px 4px 8px;" scope="col">Level Name</th>
                <th style="padding:5px 4px 8px;" scope="col">Role</th>
                <th style="padding:5px 4px 8px;" scope="col">Redirect After Login</th>
                <th style="padding:5px 4px 8px;" scope="col" colspan="4">Global Access To</th>
                <th style="padding:5px 4px 8px;" class="num" scope="col">Subscription Valid for</th>
                <th style="padding:5px 4px 8px;" colspan="2" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            if ($all_levels) {
                foreach ($all_levels as $level) {
                    $expiry = $level->subscription_period . ' ' . $level->subscription_unit;
                    $type = 'interval';
                    if (($level->subscription_period === '0') && empty($level->subscription_unit)) {
                        $type = 'noexpire';
                        $expiry = 'No Expiry or Until Cancelled';
                    } else if (($level->subscription_period === '0') && !empty($level->subscription_unit)) {
                        $type = 'fixeddate';
                        $expiry = $level->subscription_unit;
                    }
                    ?>
                    <tr id="wpm_level_row_<?php echo $level->id; ?>" class="<?php echo ($counter % 2) ? 'alternate' : ''; ?>" >
                        <td ><?php echo $level->id; ?></td>
                        <td id="alias_<?php echo $level->id; ?>"><?php echo stripslashes($level->alias); ?></td>
                        <td id="role_<?php echo $level->id; ?>"><?php
                            $roles = new WP_Roles();
                            $roles = $roles->role_names;
                            echo $roles[$level->role];
                            ?></td>
                        <td><span id="redirect_<?php echo $level->id; ?>"><?php echo $level->loginredirect_page; ?></span>
                            <span style="display:none;" id="campaign_name_<?php echo $level->id; ?>"><?php echo stripslashes($level->campaign_name); ?></span></td>
                        <td width="50px"><span id="page_<?php echo $level->id; ?>"><?php echo (($level->permissions & 8) === 8) ? '&radic;' : 'X'; ?></span>&nbsp;Pages</td>
                        <td width="70px"><span id="cat_<?php echo $level->id; ?>"><?php echo (($level->permissions & 1) === 1) ? '&radic;' : 'X'; ?></span>&nbsp;Categories</td>
                        <td width="50px"><span id="post_<?php echo $level->id; ?>"><?php echo (($level->permissions & 4) === 4) ? '&radic;' : 'X'; ?></span>&nbsp;Posts</td>
                        <td width="70px"><span id="comment_<?php echo $level->id; ?>"><?php echo (($level->permissions & 2) === 2) ? '&radic;' : 'X'; ?></span>&nbsp;Comments</td>
                        <!--<td width="70px"><span id="attachment_<?php echo $level->id; ?>"><?php echo (($level->permissions & 16) === 16) ? '&radic;' : 'X'; ?></span>&nbsp;Attachments</td>
                        <td width="70px"><span id="custom_post_<?php echo $level->id; ?>"><?php echo (($level->permissions & 32) === 32) ? '&radic;' : 'X'; ?></span>&nbsp;Custom Posts</td>-->
                        <td id="expiry_<?php echo $level->id; ?>"  etype="<?php echo $type; ?>"  class="num"><?php echo $expiry; ?></td>
                        <td><a class="emember_edit" id="<?php echo $level->id; ?>" href="javascript:void(0);">Edit</a></td>
                        <td><a class="emember_delete" id="<?php echo $level->id; ?>" href="javascript:void(0);">Delete</a></td>
                    </tr>
                    <?php
                    $counter++;
                }
            } else {
                echo '<tr> <td colspan="11">' . __('No Membership level defined.', 'wp_eMember') . '</td> </tr>';
            }
            ?>
        </tbody>
    </table>
    <p class="submit">
        <input type="button" value="Add New" id="add_new" class="button-primary" name="add_new" />
    </p>
</div>
<div id="emember_membership_form" style="display:none;">
</div>
