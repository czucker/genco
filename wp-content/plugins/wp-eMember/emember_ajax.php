<?php

function emember_is_ajax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'));
}

function emember_ajax_login() {
    check_ajax_referer('emember-login-nonce');
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $msg = $emember_auth->getMsg();

    $url = $emember_auth->getLevelInfo('loginredirect_page');
    $own_url = $emember_auth->getUserInfo('home_page');
    echo json_encode(array('status' => $emember_auth->isLoggedIn(),
        'msg' => $msg,
        'redirect' => array('own' => $own_url, 'level' => $url)));
    exit(0);
}

function wp_emem_openid_login() {
    global $wpdb;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $query = "SELECT emember_id FROM " . WP_EMEMBER_OPENID_TABLE . " WHERE openuid= " .
            $_REQUEST['uid'] . ' AND type =\'' . $_REQUEST['type'] . '\'';
    $result = $wpdb->get_row($query);
    if ($emember_auth->isLoggedIn()) {
        if ($emember_auth->userInfo->member_id == $result->emember_id) {
            echo json_encode(array('status' => 2));
        } else {
            $emember_auth->logout();
            $emember_auth->login_with_user_id($result->emember_id);
            echo json_encode(array('status' => 3));
        }
    } else {
        $emember_auth->login_with_user_id($result->emember_id);
        echo json_encode(array('status' => 1));
    }

    exit(0);
}

function wp_emem_openid_logout() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    if ($emember_auth->isLoggedIn()) {
        $emember_auth->logout();
        echo json_encode(array('status' => 1));
    } else {
        echo json_encode(array('status' => 2));
    }
    exit(0);
}

function wp_emem_delete_image() {
    $emember_auth = Emember_Auth::getInstance();
    if (current_user_can('manage_options')) {
        wp_emem_process_delete_image(strip_tags($_GET['path']));
    } else {
        if (!$emember_auth->isLoggedIn())
            die("You are not logged in.");
        wp_emem_process_delete_image($emember_auth->getUserInfo('member_id'));
    }
}

function wp_emem_process_delete_image($id) {
    global $wpdb;
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $query = "SELECT profile_image from " . $member_table . " WHERE member_id = " . $id;
    $old_file = $wpdb->get_col($query);
    $wpdb->update($member_table, array('profile_image' => ''), array('member_id' => $id));
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'] . '/emember/';
    if (!empty($old_file[0]))
        @unlink($upload_path . $old_file[0]);
    echo json_encode(array('status' => "done", 'payload' => 'deleted.'));
    exit(0);
}

function wp_emem_get_post_preview() {
    $post_content = get_post($_POST['id'], OBJECT);
    echo '<h2>' . $post_content->post_title . '</h2>';
    echo $post_content->post_content;
    exit(0);
}

function wp_emem_upload_file() {
    $emember_auth = Emember_Auth::getInstance();
    if (current_user_can('manage_options'))
        wp_emem_process_fileupload(strip_tags($_GET['image_id']));
    else {
        if (!$emember_auth->isLoggedIn())
            die("You are not logged in");
        wp_emem_process_fileupload($emember_auth->getUserInfo('member_id'));
    }
}

function wp_emem_process_fileupload($id) {
    //check_ajax_referer('emember-upload-profile-image-nonce');
    global $wpdb;
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'] . '/emember/';
    $upload_url = $upload_dir['baseurl'] . '/emember/';
    $query = "SELECT profile_image from " . $member_table . " WHERE member_id = " . $id;
    $old_file = $wpdb->get_col($query);
    if (!file_exists($upload_path) || !is_dir($upload_path)) {
        mkdir($upload_path, 0755, true);
        file_put_contents($upload_path . 'index.html', " ");
    }
    if (!empty($old_file[0]))
        @unlink($upload_path . $old_file[0]);
    // list of valid extensions, ex. array("jpeg", "xml", "bmp")
    $allowedExtensions = array('jpg', 'png', 'gif', 'bmp');
    // max file size in bytes
    $sizeLimit = 10 * 1024 * 1024;
    $uploader = new EmemberFileUploader($allowedExtensions, $sizeLimit);
    $result = $uploader->handleUpload($upload_path, true, $id);
    if (isset($result['success'])) {
        $wpdb->update($member_table, array('profile_image' => $result['filename']), array('member_id' => $id));
        $result['id'] = $id;
    }
    // to pass data through iframe you will need to encode all html tags
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    exit(0);
}

function wp_emem_user_count_ajax() {
    global $wpdb;
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $condition = "";
    if (!empty($_GET['t'])) {
        $_GET['t'] = strip_tags($_GET['t']);
        $condition = 'user_name LIKE \'%' . $_GET['t'] . '%\' OR email LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR first_name LIKE \'%' . $_GET['t'] . '%\' OR last_name LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_street LIKE \'%' . $_GET['t'] . '%\' OR address_city LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_state LIKE \'%' . $_GET['t'] . '%\' OR country LIKE \'%' . $_GET['t'] . '%\'';
    }
    if (isset($_GET['ac']) && ($_GET['ac'] != -1)) {
        if (!empty($condition))
            $condition .= ' AND ';
        $condition .= ' account_state=\'' . $_GET['ac'] . '\'';
    }
    if (isset($_GET['mem']) && ($_GET['mem'] != -1)) {
        if (!empty($condition))
            $condition .= ' AND ';
        $condition .= ' membership_level=' . $_GET['mem'];
    }
    if (empty($condition))
        $q = "SELECT COUNT(*) as count FROM " . $member_table . ' ORDER BY member_id';
    else
        $q = "SELECT COUNT(*) as count FROM " . $member_table . " WHERE $condition ORDER BY member_id";
    $emember_user_count = $wpdb->get_row($q);
    echo json_encode($emember_user_count);
    exit(0);
}

function wp_emem_wp_user_count_ajax() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    global $wpdb;
    if (!empty($_GET['t'])) {
        $params = array('blog_id' => $GLOBALS['blog_id'], 'offset' => $_GET['start'], 'number' => $_GET['limit'], 'search' => $_GET['t']);
    } else {
        $params = array('blog_id' => $GLOBALS['blog_id'], 'offset' => $_GET['start'], 'number' => $_GET['limit']);
    }
    $wp_users = get_users($params);
    echo json_encode(array('count' => count($wp_users)));
    exit(0);
}

function wp_emem_user_list_ajax() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $membership_table = WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE;
    $table_name = " $member_table LEFT JOIN $membership_table ON " .
            " ($member_table.membership_level = $membership_table.id)";
    global $wpdb;
    $condition = "";
    if (!empty($_GET['t'])) {
        $_GET['t'] = strip_tags($_GET['t']);
        $condition = 'user_name LIKE \'%' . $_GET['t'] . '%\' OR email LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR first_name LIKE \'%' . $_GET['t'] . '%\' OR last_name LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_street LIKE \'%' . $_GET['t'] . '%\' OR address_city LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_state LIKE \'%' . $_GET['t'] . '%\' OR country LIKE \'%' . $_GET['t'] . '%\'';
    }
    if (isset($_GET['ac']) && ($_GET['ac'] != -1)) {
        if (!empty($condition))
            $condition .= ' AND ';
        $condition .= ' account_state=\'' . $_GET['ac'] . '\'';
    }
    if (isset($_GET['mem']) && ($_GET['mem'] != -1)) {
        if (!empty($condition))
            $condition .= ' AND ';
        $condition .= ' membership_level=' . $_GET['mem'];
    }

    $orderby = $_GET['orderby'];
    $order = $_GET['order'];
    if (empty($orderby)) {
        $orderby = "member_id";
        $order = "asc";
    }
    if (empty($condition))
        $q = "SELECT member_id, user_name, membership_level,first_name,last_name,email,alias,last_accessed_from_ip,
            subscription_starts,account_state,notes FROM $table_name ORDER BY $orderby $order LIMIT ";
    else
        $q = "SELECT member_id, user_name, membership_level,first_name,last_name,email,alias,last_accessed_from_ip,
           subscription_starts,account_state,notes FROM $table_name WHERE $condition ORDER BY $orderby $order LIMIT ";
    $wp_users = $wpdb->get_results($q . strip_tags($_GET['start']) . ',' . strip_tags($_GET['limit']));
    //echo json_encode($wp_users);
    ?><tbody><?php
        if (count($wp_users) > 0):
            $count = 0;
            foreach ($wp_users as $wp_user):
                ?>
                <tr valign="top" <?php echo ($count % 2) ? "class='alternate'" : ""; ?>>
                    <td><input type="checkbox" name="deleterecord[<?php echo $wp_user->member_id; ?>]" class="emember_blk_op" value="<?php echo $wp_user->member_id; ?>"></td>
                    <td><?php echo $wp_user->member_id; ?></td>
                    <td><a href="admin.php?page=wp_eMember_manage&members_action=add_edit&editrecord=<?php echo $wp_user->member_id; ?>" class="emember_user_name" ><?php echo $wp_user->user_name; ?></a></td>
                    <td><?php echo $wp_user->first_name; ?></td>
                    <td><?php echo $wp_user->last_name; ?></td>
                    <td><?php echo $wp_user->email; ?></td>
                    <td><?php echo stripslashes($wp_user->alias); ?><!--<a href="#" class="emember_membership_level"><?php echo stripslashes($wp_user->alias); ?></a>--></td>
                    <td><?php
                        $expires = emember_get_expiry_by_member_id($wp_user->member_id);
                        if ($expires == 'noexpire')
                            echo "Until Cancelled";
                        else
                            echo date(get_option('date_format'), strtotime($expires));
                        ?><!--<input type="text" size="12" readonly="readonly" value="<?php echo $wp_user->last_accessed_from_ip; ?>" onfocus="this.select();" onclick="this.select();">--></td>
                    <td><?php echo date(get_option('date_format'), strtotime($wp_user->subscription_starts)); ?></td>
                    <td><?php echo $wp_user->account_state; ?></td>
                    <td>
                        <?php if (empty($wp_user->notes)): ?>
            <?php else: ?>
                            <a href="javascript:void(0);" class="eMember_tooltip">Notes
                                <span><?php echo stripslashes($wp_user->notes); ?></span></a>
            <?php endif; ?>
                    </td>
                    <td><a href="admin.php?page=wp_eMember_manage&amp;members_action=edit_ip_lock&amp;editrecord=<?php echo $wp_user->member_id; ?>" class="edit_ip_lock">Unlock</a></td>
                    <td><a href="admin.php?page=wp_eMember_manage&amp;members_action=add_edit&amp;editrecord=<?php echo $wp_user->member_id; ?>" class="edit">Edit</a></td>
                    <td><a href="<?php echo $wp_user->member_id; ?>" class="del">Delete</a></td>
                </tr>
                <?php
                $count++;
            endforeach;
        else:
            ?>
            <tr valign="top">
                <td colspan="13"><?php echo EMEMBER_DATA_NOT_FOUND; ?></td>
            </tr>
        <?php
        endif;
        ?>
    </tbody>
    <script type="text/javascript">
        $j('#member_list').find('a.del').each(function(e) {
            $j(this).click(function() {
                var u = 'admin.php?page=wp_eMember_manage&members_action=delete&deleterecord=' + $j(this).attr('href');
                top.document.location = u;
                return false;
            });
            $j(this).confirm({msg: "", timeout: 5000});
        });
        //$j('.emember_user_name').tooltip();
    </script>
    <?php
    exit(0);
}

function wp_emem_public_user_list_ajax() {
    $member_table = WP_EMEMBER_MEMBERS_TABLE_NAME;
    $membership_table = WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE;
    $table_name = " $member_table LEFT JOIN $membership_table ON " .
            " ($member_table.membership_level = $membership_table.id)";
    $no_email = isset($_SESSION['emember_no_email_shortcode']) ? $_SESSION['emember_no_email_shortcode'] : "";
    global $wpdb;
    $condition = "";
    if (!empty($_GET['t'])) {
        $_GET['t'] = strip_tags($_GET['t']);
        $condition = 'user_name LIKE \'%' . $_GET['t'] . '%\' OR email LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR first_name LIKE \'%' . $_GET['t'] . '%\' OR last_name LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_street LIKE \'%' . $_GET['t'] . '%\' OR address_city LIKE \'%' . $_GET['t'] . '%\'' .
                ' OR address_state LIKE \'%' . $_GET['t'] . '%\' OR country LIKE \'%' . $_GET['t'] . '%\'';
    }
    $order = ' ORDER BY member_id ';
    if (isset($_GET['ord']) && isset($_GET['sort'])) {
        $order = ' ORDER BY ' . strip_tags($_GET['sort']) . ' ' . strip_tags($_GET['ord']);
    }
    $q = "SELECT member_id, user_name, first_name,last_name";
    if (!$no_email)
        $q .= ",email ";

    $q .= " FROM $table_name";
    if (empty($condition))
        $q .= " $order LIMIT ";
    else
        $q .= " WHERE $condition $order LIMIT ";

    $wp_users = $wpdb->get_results($q . strip_tags($_GET['start']) . ',' . strip_tags($_GET['limit']));
    if (count($wp_users)):
        $count = 0;
        ?><tbody><?php
            foreach ($wp_users as $wp_user):
                ?>
                <tr valign="top" <?php echo ($count % 2) ? "class='alternate'" : ""; ?>>
                    <td><a uid="<?php echo $wp_user->member_id; ?>" href="#" class="emember_post_preview"><?php echo $wp_user->user_name; ?></a></td>
                    <td><?php echo $wp_user->first_name; ?></td>
                    <td><?php echo $wp_user->last_name; ?></td>
                <?php if (!$no_email): ?>  <td><?php echo $wp_user->email; ?></td><?php endif; ?>
                </tr>
                <?php
                $count++;
            endforeach;
            ?>
        </tbody>
        <script type="text/javascript">
            /* <![CDATA[ */
            jQuery(".emember_post_preview").overlay({
                mask: '#E6E6E6',
                effect: 'apple',
                target: jQuery('#emember_post_preview_overlay'),
                onBeforeLoad: function() {
                    var wrap = this.getOverlay().find(".emember_contentWrap");
                    wrap.html('Loading ...');
                    var params = {'event': 'emember_public_user_profile_ajax',
                        'action': 'emember_public_user_profile_ajax',
                        'id': this.getTrigger().attr("uid")
                    };
                    jQuery.get('<?php echo admin_url("admin-ajax.php"); ?>', params, function(data) {
                        wrap.html(data.content);
                    }, 'json');
                }
            });
            /* ]]> */
        </script>
        <?php
    else:
        ?>
        <tbody><tr><td><?php echo EMEMBER_DATA_NOT_FOUND; ?></td></tr></tbody>
    <?php
    endif;
    exit(0);
}

function wp_emem_wp_user_list_ajax() {
    global $wpdb;
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    if (!empty($_GET['t'])) {
        $params = array('blog_id' => $GLOBALS['blog_id'], 'offset' => $_GET['start'], 'number' => $_GET['limit'], 'search' => $_GET['t']);
    } else {
        $params = array('blog_id' => $GLOBALS['blog_id'], 'offset' => $_GET['start'], 'number' => $_GET['limit']);
    }
    $wp_users = get_users($params);
    //echo json_encode($wp_users);
    $all_levels = Emember_Level_Collection::get_instance()->get_levels();
    if (count($wp_users) > 0):
        ?>
        <tbody>
            <?php
            $count = 0;
            foreach ($wp_users as $wp_user):
                ?>
                <tr valign="top" <?php echo ($count % 2) ? "class='alternate'" : ""; ?>>
                    <td class="check-column" scope="row"><input type="checkbox" value="<?php echo $wp_user->ID; ?>" name="selected_wp_users[<?php echo $count ?>][ID]"></td>
                    <td><?php echo $wp_user->user_login; ?></td>
                    <td><?php echo $wp_user->user_email; ?></td>
                    <td><select name="selected_wp_users[<?php echo $count ?>][membership_level]">
                            <?php
                            foreach ($all_levels as $l):
                                ?>
                                <option value="<?php echo $l->get('id'); ?>"><?php echo $l->get('alias'); ?></option>
            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" value="<?php echo date('Y-m-d'); ?>" name="selected_wp_users[<?php echo $count ?>][subscription_starts]" />
                    </td>
                    <td><select name="selected_wp_users[<?php echo $count ?>][account_state]">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </td>
                    <td><input type="checkbox" value="1" name="selected_wp_users[<?php echo $count ?>][preserve_wp_role]" checked="checked"></td>
                </tr>
                <?php
                $count++;
            endforeach;
        else:
            ?>
            <tr valign="top">
                <td colspan="7"><?php echo EMEMBER_DATA_NOT_FOUND; ?></td>
            </tr>
        <?php
        endif;
        ?>
    </tbody>
    <script type="text/javascript">
        /* <![CDATA[ */
        jQuery('#wp_member_list').find('input[type^="date"]').each(function(e) {
            jQuery(this).dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
        });
        /* ]]> */
    </script>
    <?php
    exit(0);
}

function wp_emem_public_user_profile_ajax() {
    global $wpdb;
    $_GET['id'] = strip_tags($_GET['id']);
    $emember_config = Emember_Config::getInstance();
    $p = $emember_config->getValue('eMember_enable_public_profile');
    if (!$p) {
        echo json_encode(array('content' => 'Public profile Listing is disabled', 'status' => 0));
        exit(0);
    }
    $image_url = wp_emember_get_profile_image_url_by_id($_GET['id']);
    $no_email = isset($_SESSION['emember_no_email_shortcode']) ? $_SESSION['emember_no_email_shortcode'] : "";
    ob_start();
    ?>
    <h2 class="emember_profile_head"><?php echo EMEMBER_USER_PROFILE; ?></h2>
    <table align="center" class="emember_profile">
        <tbody align="center">
    <?php if ($emember_config->getValue('eMember_profile_thumbnail')): ?>
                <tr>
                    <td colspan="2" align="center">
                        <img alt="" width="100px" height="100px" src="<?php echo $image_url; ?>"/>
                    </td>
                </tr>
    <?php endif; ?>
            <tr class="emember_profile_cell">
                <td colspan="2" align="center" class="emember_profile_user_name">
    <?php echo $resultset->user_name; ?>
                </td>
            </tr>
    <?php if ($emember_config->getValue('eMember_edit_firstname')): ?>
                <tr class="emember_profile_cell alternate">
                    <td>
                        <label><?php echo EMEMBER_FIRST_NAME; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->first_name; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_lastname')): ?>
                <tr class="emember_profile_cell">
                    <td>
                        <label><?php echo EMEMBER_LAST_NAME ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->last_name; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($emember_config->getValue('eMember_edit_email')): ?>
        <?php if (!$no_email): ?>
                    <tr class="emember_profile_cell alternate">
                        <td>
                            <label><?php echo EMEMBER_EMAIL; ?>:</label>
                        </td>
                        <td>
            <?php echo $resultset->email; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_phone')): ?>
                <tr class="emember_profile_cell">
                    <td>
                        <label><?php echo EMEMBER_PHONE; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->phone; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_company')): ?>
                <tr class="emember_profile_cell alternate">
                    <td>
                        <label><?php echo EMEMBER_COMPANY; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->company_name; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_street')): ?>
                <tr class="emember_profile_cell">
                    <td>
                        <label><?php echo EMEMBER_ADDRESS_STREET; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->address_street; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_city')): ?>
                <tr class="emember_profile_cell alternate">
                    <td>
                        <label><?php echo EMEMBER_ADDRESS_CITY; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->address_city; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_state')): ?>
                <tr class="emember_profile_cell">
                    <td>
                        <label><?php echo EMEMBER_ADDRESS_STATE; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->address_state; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_zipcode')): ?>
                <tr class="emember_profile_cell alternate">
                    <td>
                        <label><?php echo EMEMBER_ADDRESS_ZIP; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->address_zipcode; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_country')): ?>
                <tr class="emember_profile_cell">
                    <td>
                        <label><?php echo EMEMBER_ADDRESS_COUNTRY ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->country; ?>
                    </td>
                </tr>
            <?php endif; ?>
    <?php if ($emember_config->getValue('eMember_edit_gender')): ?>
                <tr class="emember_profile_cell alternate">
                    <td>
                        <label><?php echo EMEMBER_GENDER; ?>:</label>
                    </td>
                    <td>
        <?php echo $resultset->gender; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php
            if ($emember_config->getValue('eMember_custom_field')):
                $edit_custom_fields = dbAccess::find(WP_EMEMBER_MEMBERS_META_TABLE, ' user_id=' . esc_sql($_GET['id']) . ' AND meta_key=\'custom_field\'');
                $edit_custom_fields = unserialize($edit_custom_fields->meta_value);
                $custom_fields = get_option('emember_custom_field_type');
                $inversed_order = array();
                $revised_order = array();
                $num_field = count($custom_fields['emember_field_name']);
                for ($i = 1; $i <= $num_field; $i++) {
                    $inversed_order[$i] = $i;
                }

                if (is_array($custom_fields['emember_field_order'])) {
                    foreach ($custom_fields['emember_field_order'] as $key => $value) {
                        $inversed_order[$value] = $key;
                    }
                    $order_values = array_values($custom_fields['emember_field_order']);
                    sort($order_values);

                    foreach ($order_values as $key => $value) {
                        $revised_order[] = $inversed_order[$value];
                    }
                } else {
                    $num_field = count($custom_fields['emember_field_name']);
                    for ($i = 0; $i <= $num_field; $i++) {
                        $revised_order[] = $i;
                    }
                }

                for ($i = 0; isset($custom_fields['emember_field_name'][$revised_order[$i]]); $i++) {
                    $emember_field_name = stripslashes($custom_fields['emember_field_name'][$revised_order[$i]]);
                    $emember_field_name_index = str_replace(array('\\', '\'', '(', ')', '[', ']', ' ', '"', '%', '<', '>'), "_", $emember_field_name);
                    ?>
                    <tr <?php echo (($i % 2) == 0 ) ? 'class="emember_profile_cell"' : 'class="emember_profile_cell alternate"' ?>>
                        <td><label><?php echo $emember_field_name; ?>: </label></td>
                        <td>
                            <?php
                            $field_value = isset($edit_custom_fields[$emember_field_name_index]) ? $edit_custom_fields[$emember_field_name_index] : "";
                            $field_value = isset($_POST['emember_custom'][$emember_field_name_index]) ? $_POST['emember_custom'][$emember_field_name_index] : $field_value;
                            $field_value = stripslashes($field_value);
                            switch ($custom_fields['emember_field_type'][$revised_order[$i]]) {
                                case 'text':
                                    echo $field_value;
                                    break;
                                case 'dropdown':
                                    $options = stripslashes($custom_fields['emember_field_extra'][$revised_order[$i]]);
                                    $options = explode(',', $options);
                                    foreach ($options as $option) {
                                        $option = explode("=>", $option);
                                        if (($field_value === $option[0]))
                                            echo $option[1];
                                    }
                                    break;
                                case 'checkbox':
                                    ?>
                                    <?php echo $field_value ? "&radic;" : "&Chi;"; ?>
                                    <?php
                                    break;
                                case 'textarea':
                                    echo $field_value;
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            endif;
            ?>
        </tbody>
    </table>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    echo json_encode(array('content' => $content, 'status' => 1));
    exit(0);
}

function wp_emem_add_bookmark() {
    check_ajax_referer('emember-add-bookmark-nonce');
    if (emember_is_ajax()) {
        global $wpdb;
        $emember_auth = Emember_Auth::getInstance();
        $emember_config = Emember_Config::getInstance();
        $emember_auth->add_bookmark(array($_GET['id']));
        $a1 = '<span title="Bookmarked" class="count">
              <span class="c">&radic;</span><br/>
              <span class="t">' . EMEMBER_FAVORITE . '</span></span>
              <span title="Bookmarked" class="emember">' . EMEMBER_ADDED . '</span>';
        echo json_encode(array('status' => 1, 'msg' => $a1));
        exit(0);
    }
}

function item_list_ajax() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    global $wpdb;
    $levelId = $_REQUEST['level'];
    $tab = $_REQUEST['tab'];
    if (emember_is_ajax()) {
        $level = ($levelId == 1 ) ? Emember_Protection::get_instance() :
                Emember_Permission::get_instance($levelId);
        switch ($tab) {
            case 'pages':
                $args = array(
                    'child_of' => 0,
                    'sort_order' => 'ASC',
                    'sort_column' => 'post_title',
                    'hierarchical' => 0,
                    'parent' => -1,
                    'number' => $_GET['limit'],
                    'offset' => $_GET['start']);
                $all_pages = get_pages($args);
                $filtered_pages = array();
                foreach ($all_pages as $page) {
                    $page_summary = array();
                    $user_info = get_userdata($page->post_author);
                    $page_summary['protected'] = $level->in_pages($page->ID) ? "checked='checked'" : "";
                    $page_summary['bookmark'] = $level->is_bookmark_disabled($page->ID) ? "checked='checked'" : "";
                    $page_summary['ID'] = $page->ID;
                    $page_summary['date'] = $page->post_date;
                    $page_summary['title'] = $page->post_title;
                    $page_summary['author'] = isset($user_info->user_nicename) ? $user_info->user_nicename : "";
                    $page_summary['status'] = $page->post_status;
                    $filtered_pages[] = $page_summary;
                }
                ob_start();
                include ('views/emember_page_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
            case 'posts':
                $sql = "SELECT ID,post_date,post_title,post_author, post_type, post_status FROM $wpdb->posts ";
                $sql .= " WHERE post_type = 'post' AND post_status = 'publish' LIMIT " . $_REQUEST['start'] . " , " . $_REQUEST['limit'];
                $all_posts = $wpdb->get_results($sql);
                $filtered_posts = array();
                foreach ($all_posts as $post) {
                    //if($post->post_type=='page')continue;
                    $post_summary = array();
                    $user_info = get_userdata($post->post_author);
                    $categories = get_the_category($post->ID);
                    $cat = array();
                    foreach ($categories as $category)
                        $cat[] = $category->category_nicename;
                    $post_summary['protected'] = $level->in_posts($post->ID) ? "checked='checked'" : "";
                    $post_summary['bookmark'] = $level->is_bookmark_disabled($post->ID) ? "checked='checked'" : "";
                    $post_summary['ID'] = $post->ID;
                    $post_summary['date'] = $post->post_date;
                    $post_summary['title'] = isset($post->post_title) ? $post->post_title : "";
                    $post_summary['author'] = isset($user_info->user_nicename) ? $user_info->user_nicename : "";
                    $post_summary['categories'] = rawurldecode(implode(' ', $cat));
                    $post_summary['type'] = $post->post_type;
                    $post_summary['status'] = $post->post_status;
                    $filtered_posts[] = $post_summary;
                }
                ob_start();
                include ('views/emember_post_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
            case 'comments':
                $all_comments = get_comments(array('number' => $_GET['limit'], 'offset' => $_GET['start'], 'status' => 'approve'));
                $filtered_comments = array();
                foreach ($all_comments as $comment) {
                    $comment_summary = array();
                    $comment_summary['protected'] = $level->in_comments($comment->comment_ID) ? "checked='checked'" : "";
                    $comment_summary['ID'] = $comment->comment_ID;
                    $comment_summary['date'] = $comment->comment_date;
                    $comment_summary['author'] = $comment->comment_author;
                    $comment_summary['content'] = $comment->comment_content;
                    $filtered_comments[] = $comment_summary;
                }
                ob_start();
                include ('views/emember_comment_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
            case 'categories':
                $all_categories = array();
                $all_cat_ids = get_all_category_ids();
                for ($i = $_GET['start']; $i < ($_GET['start'] + $_GET['limit']) && !empty($all_cat_ids[$i]); $i++)
                    $all_categories[] = get_category($all_cat_ids[$i]);
                foreach ($all_categories as $category) {
                    $category_summary = array();
                    $category_summary['protected'] = $level->in_categories($category->term_id) ? "checked='checked'" : "";
                    $category_summary['ID'] = $category->term_id;
                    $category_summary['name'] = $category->name;
                    $category_summary['description'] = $category->description;
                    $category_summary['count'] = $category->count;
                    $filtered_categories[] = $category_summary;
                }
                ob_start();
                include ('views/emember_category_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
            case 'attachments':
                $sql = "SELECT ID,post_date,post_title,post_author, post_type, post_status FROM $wpdb->posts ";
                $sql .= " WHERE post_type = 'attachment' AND post_status = 'inherit' LIMIT " . $_REQUEST['start'] . " , " . $_REQUEST['limit'];
                $all_posts = $wpdb->get_results($sql);
                $filtered_posts = array();
                foreach ($all_posts as $post) {
                    $post_summary = array();
                    $user_info = get_userdata($post->post_author);
                    $post_summary['protected'] = $level->in_attachments($post->ID) ? "checked='checked'" : "";
                    $post_summary['ID'] = $post->ID;
                    $post_summary['date'] = $post->post_date;
                    $post_summary['title'] = isset($post->post_title) ? $post->post_title : "";
                    $post_summary['author'] = isset($user_info->user_nicename) ? $user_info->user_nicename : "";
                    $post_summary['type'] = $post->post_type;
                    $post_summary['status'] = $post->post_status;
                    $filtered_posts[] = $post_summary;
                }

                ob_start();
                include ('views/emember_attachment_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
            case 'custom-posts':
                $filtered_posts = array();
                $args = array('public' => true, '_builtin' => false);
                $post_types = get_post_types($args);
                $arg = "'" . implode('\',\'', $post_types) . "'";
                if (!empty($arg)) {
                    $sql = "SELECT ID,post_date,post_title,post_author, post_type, post_status FROM $wpdb->posts ";
                    $sql .= " WHERE post_type IN (" . $arg . ") AND (post_status='inherit' OR post_status='publish') LIMIT " . $_REQUEST['start'] . " , " . $_REQUEST['limit'];
                    $all_posts = $wpdb->get_results($sql);
                    $filtered_posts = array();
                    foreach ($all_posts as $post) {
                        $post_summary = array();
                        $user_info = get_userdata($post->post_author);
                        $post_summary['protected'] = $level->in_custom_posts($post->ID) ? "checked='checked'" : "";
                        $post_summary['ID'] = $post->ID;
                        $post_summary['date'] = $post->post_date;
                        $post_summary['title'] = isset($post->post_title) ? $post->post_title : "";
                        $post_summary['author'] = isset($user_info->user_nicename) ? $user_info->user_nicename : "";
                        $post_summary['type'] = $post->post_type;
                        $post_summary['status'] = $post->post_status;
                        $filtered_posts[] = $post_summary;
                    }
                }
                ob_start();
                include ('views/emember_custom_protection_view.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
                break;
        }
    }
    exit(0);
}

function wp_emem_send_mail() {
    check_ajax_referer('emember-login-nonce');
    if (emember_is_ajax())
        echo json_encode(wp_emember_generate_and_mail_password($_GET['email']));
    exit(0);
}

function wp_emem_check_level_name() {
    if (emember_is_ajax()) {
        global $wpdb;
        $alias = strip_tags(trim($_GET['fieldValue']));
        $user = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, ' alias=\'' . $alias . '\'');
        if ($user)
            echo '[ "' . $_GET['fieldId'] . '",false, "&chi;&nbsp;' . EMEMBER_ALREADY_TAKEN . '"]';
        else
            echo '[ "' . $_GET['fieldId'] . '",true, "&radic;&nbsp;' . EMEMBER_STILL_AVAIL . '"]';
    }
    exit(0);
}

function wp_emem_check_user_name() {
    if (emember_is_ajax()) {
        if (emember_wp_username_exists($_GET['fieldValue'])) {
            echo '[ "' . $_GET['fieldId'] . '",false, "&chi;&nbsp;' . EMEMBER_ALREADY_TAKEN . '"]';
        } else {
            global $wpdb;
            $user_name = esc_sql(trim($_GET['fieldValue']));
            $user = dbAccess::find(WP_EMEMBER_MEMBERS_TABLE_NAME, ' user_name=\'' . esc_sql($user_name) . '\'');
            if ($user) {
                echo '[ "' . $_GET['fieldId'] . '",false, "&chi;&nbsp;' . EMEMBER_ALREADY_TAKEN . '"]';
            } else {
                echo '[ "' . $_GET['fieldId'] . '",true, "&radic;&nbsp;' . EMEMBER_STILL_AVAIL . '"]';
            }
        }
    }
    exit(0);
}

function access_list_ajax() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    $emember_config = Emember_Config::getInstance();
    $items_per_page = $emember_config->getValue('eMember_rows_per_page');
    $items_per_page = trim($items_per_page);
    $items_per_page = (!empty($items_per_page) && is_numeric($items_per_page)) ? $items_per_page : 30;
    $count = 0;
    $tab = $_REQUEST['tab'];
    $levelId = $_REQUEST['level'];
    if (emember_is_ajax()) {
        global $wpdb;
        switch ($_REQUEST['tab']) {
            case 'comments':
                $num_comm = get_comment_count();
                $count = $num_comm['approved'];
                break;
            case 'posts':
                $query = "SELECT count(*) from $wpdb->posts WHERE post_status='publish' AND post_type='post'";
                $count = $wpdb->get_var($query);
                break;
            case 'pages':
                $count = wp_count_posts('page');
                $count = $count->publish;
                break;
            case 'categories':
                $count = wp_count_terms('category');
                break;
            case 'attachments':
                $query = "SELECT count(*) from $wpdb->posts WHERE post_status='inherit' AND post_type='attachment'";
                $count = $wpdb->get_var($query);
                break;
            case 'custom-posts':
                $args = array('public' => true, '_builtin' => false);
                $post_types = get_post_types($args);
                $arg = "'" . implode('\',\'', $post_types) . "'";
                if (empty($arg)) {
                    $count = 0;
                } else {
                    $query = "SELECT count(*) from $wpdb->posts WHERE (post_status='inherit' OR post_status='publish') AND post_type IN (" . $arg . ")";
                    $count = $wpdb->get_var($query);
                }
                break;
        }
        ob_start();
        include ('js/membership_level.php');
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
    exit(0);
}

function emember_fileuploader() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['basedir'] . '/emember/downloads/';

    // list of valid extensions, ex. array("jpeg", "xml", "bmp")
    $allowedExtensions = array();
    // max file size in bytes
    $sizeLimit = 10 * 1024 * 1024;

    $uploader = new EmemberFileUploader($allowedExtensions, $sizeLimit);
    $result = $uploader->handleUpload($dir);
    if (isset($result['success'])) {
        global $wpdb;
        $guid = $upload_dir['baseurl'] . '/emember/downloads/' . $result['filename'];
        $date = date('Y-m-d H:i:s');
        $filename = $uploader->getFilename();
        emember_add_uploaded_file_to_inventory($filename, $guid, $date);
    }
    // to pass data through iframe you will need to encode all html tags
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    exit(0);
}

function emember_load_membership_form() {
    if (!current_user_can('manage_options'))
        die("Access Forbidden");
    global $wpdb;
    $id = strip_tags($_POST['id']);
    $subscription_period = "";
    $subscription_unit = "";
    $fixed_date = "";
    if (empty($id)) {
        $role = "subscriber";
        $name = "";
        $loginredirect = "";
        $campaign_name = "";
        $expire = 'noexpire';
        $allpages = 'checked="checked"';
        $allcategories = 'checked="checked"';
        $allposts = 'checked="checked"';
        $allcomments = 'checked="checked"';
        $allattachments = 'checked="checked"';
        $allcustomposts = 'checked="checked"';
    } else {
        $level = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id = '" . esc_sql($id) . " ' ");
        $role = $level->role;
        $name = htmlspecialchars($level->alias);
        $loginredirect = $level->loginredirect_page;
        $campaign_name = $level->campaign_name;
        if (empty($level->subscription_period) && empty($level->subscription_unit))
            $expire = 'noexpire';
        else if (empty($level->subscription_period)) {
            $expire = 'fixed_date';
            $fixed_date = $level->subscription_unit;
        } else {
            $expire = 'interval';
            $subscription_period = $level->subscription_period;
            $subscription_unit = $level->subscription_unit;
        }
        $allpages = (($level->permissions & 8) === 8) ? 'checked="checked"' : "";
        $allcategories = (($level->permissions & 1) === 1) ? 'checked="checked"' : "";
        $allposts = (($level->permissions & 4) === 4) ? 'checked="checked"' : "";
        $allcomments = (($level->permissions & 2) === 2) ? 'checked="checked"' : "";
        $allattachments = (($level->permissions & 16) === 16) ? 'checked="checked"' : "";
        $allcustomposts = (($level->permissions & 32) === 32) ? 'checked="checked"' : "";
    }

    require_once('views/add_membership_level_view.php');
    exit(0);
}
