<?php

function eMember_my_more_link($more_link, $more_link_text = "More") {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    global $post;
    $id = $post->ID;
    if (empty($id))
        return $content;
    $emember_auth->hasmore[$id] = $id;
    //$post->post_content = apply_filters('the_content',$post->post_content);
    if ($emember_auth->is_protected_category($id) || $emember_auth->is_protected_parent_category($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return get_renewal_link();

            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_category($id))
                    return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', $more_link);
                else {
                    //return '<br/><b>'.EMEMBER_CONTENT_RESTRICTED .'</b>';
                    return wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                }
            } else
                return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', get_renewal_link());
        }
        else {
            $join_url = $emember_config->getValue('eMember_payments_page');
            if (empty($join_url)) {
                //return '<b>Membership Payment/Join Page</b> is not defined in the settings page.Please Contact <a href="mailto:'.get_option('admin_email').'">Admin</a>.';
                $msg = '<b>Membership Payment/Join Page</b> is not defined in the settings page.Please Contact <a href="mailto:' . get_option('admin_email') . '">Admin</a>.';
                return wp_emember_format_message($msg);
            } else
                $join_url = ' href ="' . $join_url . '" ';
            return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', '<a ' . $join_url . '>' . EMEMBER_MORE_LINK . ' ' . '</a>');
        }
    }
    else if ($emember_auth->is_protected_post($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return get_renewal_link();

            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_post($id))
                    return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', $more_link);
                else {
                    //return '<br/><b>'.EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
                    return wp_emember_format_message(EMEMBER_LEVEL_NOT_ALLOWED);
                }
            } else
                return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', get_renewal_link());
        }
        else {
            $join_url = $emember_config->getValue('eMember_payments_page');
            if (empty($join_url))
                return '<b>Membership Payment/Join Page</b> is not defined in the settings page.Please Contact <a href="mailto:' . get_option('admin_email') . '">Admin</a>.';
            else
                $join_url = ' href ="' . $join_url . '" ';
            return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', '<a ' . $join_url . '>' . EMEMBER_MORE_LINK . ' ' . '</a>');
        }
    } else
        return str_replace($more_link_text, EMEMBER_MORE_LINK . ' ', $more_link);
}

function auth_check_category($content) {
    global $post;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $id = $post->ID;
    if (empty($id))
        return $content;
    if (isset($emember_auth->hasmore[$id])) {
        unset($emember_auth->hasmore[$id]);
        return $content;
    } else {
        if ($emember_auth->is_protected_category($id) || $emember_auth->is_protected_parent_category($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                //return get_renewal_link();
                    return EMEMBER_CONTENT_RESTRICTED;
                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_category($id))
                        return $content;
                    else {
                        //return '<br/><b>' . EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
                        return wp_emember_format_message(EMEMBER_LEVEL_NOT_ALLOWED);
                    }
                } else
                //return get_renewal_link();
                    return EMEMBER_CONTENT_RESTRICTED;
            }
            else {
                return get_login_link();
                /* if(isset($_GET['event'])&&($_GET['event']=='login'))
                  //return get_login_link();
                  return EMEMBER_CONTENT_RESTRICTED; */
            }
        } else {
            if ($emember_auth->is_protected_post($id)) {
                if ($emember_auth->isLoggedIn()) {
                    $expires = $emember_auth->getUserInfo('account_state');
                    if ($expires == 'expired')
                    //return get_renewal_link();
                        return EMEMBER_CONTENT_RESTRICTED;

                    if (!$emember_auth->is_subscription_expired()) {
                        if ($emember_auth->is_permitted_post($id))
                            return $content;
                        else {
                            //return '<br/><b>' . EMEMBER_CONTENT_RESTRICTED . '</b>';
                            return wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                        }
                    } else
                    //return get_renewal_link();
                        return EMEMBER_CONTENT_RESTRICTED;
                } else
                    return get_login_link();
                //return EMEMBER_CONTENT_RESTRICTED;
            } else
                return $content;

            return $content;
        }
    }
}

function auth_check_attachment($content) {
    global $post;
    $id = $post->ID;
    if (empty($id))
        return $content;
    $default_image = WP_EMEMBER_URL . '/images/emember-restrict.png';
    $emember_config = Emember_Config::getInstance();
    $emember_auth = Emember_Auth::getInstance();
    /* if($emember_auth->is_protected_category($id)||$emember_auth->is_protected_parent_category($id)){
      if($emember_auth->isLoggedIn()){
      $expires = $emember_auth->getUserInfo('account_state');
      if($expires == 'expired')
      return get_renewal_link();
      if(!$emember_auth->is_subscription_expired()){
      if($emember_auth->is_permitted_category($id)){
      $emember_auth->is_post_visible = true;
      return $content;
      }
      else{
      //return '<br/><b>'. EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
      return $default_image;
      }
      }
      else
      return get_renewal_link();
      }
      else
      return $default_image;
      }
      else{ */
    if ($emember_auth->is_protected_attachment($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return $default_image;

            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_attachment($id)) {
                    $emember_auth->is_post_visible = true;
                    return $content;
                } else {
                    //return '<br/><b>' . EMEMBER_CONTENT_RESTRICTED .'</b>';
                    return $default_image;
                }
            } else
                return $default_image;
        }
        else {
            return $default_image;
        }
    } else {
        if (isset($emember_auth->hasmore[$id])) {
            unset($emember_auth->hasmore);
        }
        $emember_auth->is_post_visible = true;
        return $content;
    }
    //}
}

function auth_check_custom_post($content) {
    global $post;
    $before_more = "";
    $emember_config = Emember_Config::getInstance();
    $emember_auth = Emember_Auth::getInstance();
    $id = $post->ID;
    if (empty($id))
        return $content;
    if ($emember_auth->is_protected_category($id) || $emember_auth->is_protected_parent_category($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return $before_more . get_renewal_link();
            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_category($id)) {
                    $emember_auth->is_post_visible = true;
                    return $content;
                } else {
                    //return '<br/><b>'. EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
                    return $before_more . wp_emember_format_message(EMEMBER_LEVEL_NOT_ALLOWED);
                }
            } else
                return $before_more . get_renewal_link();
        }
        else {
            if (isset($_GET['event']) && ($_GET['event'] == 'login')) {
                return $before_more . print_eMember_login_form();
            } else
                return $before_more . get_login_link();
        }
    }
    else {
        if ($emember_auth->is_protected_custom_post($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                    return $before_more . get_renewal_link();

                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_custom_post($id)) {
                        $emember_auth->is_post_visible = true;
                        return $content;
                    } else {
                        //return '<br/><b>' . EMEMBER_CONTENT_RESTRICTED .'</b>';
                        return $before_more . wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                    }
                } else
                    return $before_more . get_renewal_link();
            }
            else {
                if (isset($_GET['event']) && ($_GET['event'] == 'login'))
                    return $before_more . print_eMember_login_form();
                else {
                    if (isset($emember_auth->hasmore[$id])) {
                        unset($emember_auth->hasmore);
                        return $content;
                    }
                    return $before_more . get_login_link();
                }
            }
        } else {
            if (isset($emember_auth->hasmore[$id])) {
                unset($emember_auth->hasmore);
            }
            $emember_auth->is_post_visible = true;
            return $content;
        }
    }
}

function auth_check_post($content) {
    global $post;
    $id = $post->ID;
    if (empty($id))
        return $content;
    $id = apply_filters('emember_auth_check_post_id', $id);
    return check_post_content($id, $content);
}

function auth_check_page($content) {
    global $post;
    $id = $post->ID;
    if (empty($id))
        return $content;
    return check_page_content($id, $content);
}

function check_page_content($id, $content) {
    $emember_auth = Emember_Auth::getInstance();
    if ($emember_auth->is_my_page_post($id))
        return $content;
    $emember_config = Emember_Config::getInstance();
    global $post;
//    $id = $post->ID;
    global $more;
    $before_more = '';
    if (isset($emember_auth->hasmore[$id])) {
        $before_more = explode('<span id="more-' . $id . '"></span>', $content);
        if (count($before_more) == 1)
            $before_more = '';
        else
            $before_more = $before_more[0] . '<br/>';
    }
    if ($emember_auth->is_protected_category($id) || $emember_auth->is_protected_parent_category($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return $before_more . get_renewal_link();
            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_category($id)) {
                    $emember_auth->is_post_visible = true;
                    return $content;
                } else {
                    //return '<br/><b>'. EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
                    return $before_more . wp_emember_format_message(EMEMBER_LEVEL_NOT_ALLOWED);
                }
            } else
                return $before_more . get_renewal_link();
        }
        else {
            if (isset($_GET['event']) && ($_GET['event'] == 'login')) {
                return $before_more . print_eMember_login_form();
            } else
                return $before_more . get_login_link();
        }
    }
    else {
        if ($emember_auth->is_protected_page($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                    return $before_more . get_renewal_link();

                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_page($id)) {
                        $emember_auth->is_post_visible = true;
                        return $content;
                    } else {
                        //return '<br/><b>' . EMEMBER_CONTENT_RESTRICTED .'</b>';
                        return $before_more . wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                    }
                } else
                    return $before_more . get_renewal_link();
            }
            else {
                if (isset($_GET['event']) && ($_GET['event'] == 'login'))
                    return $before_more . print_eMember_login_form();
                else {
                    if (isset($emember_auth->hasmore[$id])) {
                        unset($emember_auth->hasmore);
                        return $content;
                    }
                    return $before_more . get_login_link();
                }
            }
        } else {
            if (isset($emember_auth->hasmore[$id])) {
                unset($emember_auth->hasmore);
            }
            $emember_auth->is_post_visible = true;
            return $content;
        }
    }
}

function auth_check_comment($content) {
    global $comment;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    if ($emember_config->getValue('eMember_protect_comments_separately')) {
        $id = $comment->comment_ID;
        if ($emember_auth->is_protected_comment($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                    return get_renewal_link();

                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_comment($id))
                        return $content;
                    else {
                        //return '<br/><b>' . EMEMBER_CONTENT_RESTRICTED .'</b>';
                        return wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                    }
                } else
                    return get_renewal_link();
            }
            else {
                if (isset($_GET['event']) && ($_GET['event'] == 'login'))
                    return get_login_link();
                else
                if (isset($emember_auth->hasmore[$id])) {
                    unset($emember_auth->hasmore[$id]);
                    return $content;
                }
                return get_login_link();
            }
        } else {
            if (isset($emember_auth->hasmore[$id])) {
                unset($emember_auth->hasmore[$id]);
            }
            return $content;
        }
    }  //
    else {
        $post = get_post($comment->comment_post_ID);
        if ($post->post_type == 'page')
            return check_page_content($comment->comment_post_ID, $content);
        else
            return check_post_content($comment->comment_post_ID, $content);
    }
}

function check_post_content($id, $content) {
    $emember_auth = Emember_Auth::getInstance();
    if ($emember_auth->is_my_page_post($id))
        return $content;
    if (isset($emember_auth->hasmore[$id])) {
        unset($emember_auth->hasmore[$id]);
        $emember_auth->is_post_visible = true;
        return $content;
    } else {
        global $more;
        $before_more = '';
        $emember_config = Emember_Config::getInstance();
        $enable_more_tag = $emember_config->getValue('eMember_enable_more_tag');
        if ($more && $enable_more_tag) {
            $before_more = explode('<span id="more-' . $id . '"></span>', $content);
            if (count($before_more) == 1)
                $before_more = '';
            else
                $before_more = $before_more[0] . '<br/>';
        }
        if ($emember_auth->is_protected_category($id) || $emember_auth->is_protected_parent_category($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                    return $before_more . get_renewal_link();

                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_category($id)) {
                        $emember_auth->is_post_visible = true;
                        return $content;
                    } else {
                        //return '<br/><b>'. EMEMBER_LEVEL_NOT_ALLOWED .'</b>';
                        return $before_more . wp_emember_format_message(EMEMBER_LEVEL_NOT_ALLOWED);
                    }
                } else
                    return $before_more . get_renewal_link();
            }
            else {
                if (isset($_GET['event']) && ($_GET['event'] == 'login')) {
                    if (is_single())
                        return $before_more . print_eMember_login_form();
                    else
                        return $before_more . get_login_link();
                } else
                    return $before_more . get_login_link();
            }
        }
        else if ($emember_auth->is_protected_post($id)) {
            if ($emember_auth->isLoggedIn()) {
                $expires = $emember_auth->getUserInfo('account_state');
                if ($expires == 'expired')
                    return $before_more . get_renewal_link();
                if (!$emember_auth->is_subscription_expired()) {
                    if ($emember_auth->is_permitted_post($id)) {
                        $emember_auth->is_post_visible = true;
                        return $content;
                    } else {
                        //return  '<br/><b>' . EMEMBER_CONTENT_RESTRICTED . '</b>';
                        return $before_more . wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
                    }
                } else
                    return $before_more . get_renewal_link();
            }
            else {
                if (isset($_GET['event']) && ($_GET['event'] == 'login')) {
                    if (is_single())
                        return $before_more . print_eMember_login_form();
                    else
                        return $before_more . get_login_link();
                } else
                    return $before_more . get_login_link();
            }
        }
        else {
            $emember_auth->is_post_visible = true;
            return $content;
        }
    }
}

/* * *******************protected tag#start********************************* */

function emember_protected_handler($attrs, $contents, $codes = '') {
    global $post;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $emember_auth->hasmore[$post->ID] = $post->ID;
    //$first_click_enabled = $emember_config->getValue('eMember_google_first_click_free');
    $contents = do_shortcode($contents);
    if (emember_is_first_click())
        return $contents; //google first click free enabled.
    $do_not_show_restricted_msg = isset($attrs['do_not_show_restricted_msg']) ? $attrs['do_not_show_restricted_msg'] : "";

    if (!$emember_auth->isLoggedIn()) {
        // Show the content to anyone who is not logged in
        if (isset($attrs['scope']) && ($attrs['scope'] == "not_logged_in_users_only"))
            return $contents;
    }

    if ($emember_auth->isLoggedIn()) {
        // Do not show the content to anyone who is logged in
        if (isset($attrs['scope']) && ($attrs['scope'] == "not_logged_in_users_only"))
            return "";

        // Show content to anyone who is logged in
        if (isset($attrs['scope']) && ($attrs['scope'] == "verified_users_only"))
            return $contents;

        $expires = $emember_auth->getUserInfo('account_state');
        if ($expires == 'expired') {//Show the renewal message as this account is expired
            return get_renewal_link();
        }

        if (isset($attrs['member_id'])) {
            $member_id = $emember_auth->getUserInfo('member_id');
            $permitted_member_ids = explode('-', $attrs['member_id']);
            if (in_array($member_id, $permitted_member_ids))
                return $contents;
            else {
                if (!empty($do_not_show_restricted_msg)) {
                    return ""; //do not show the restrcted content message
                }
                return wp_emember_format_message(EMEMBER_ACCOUNT_PROFILE_NOT_ALLOWED);
            }
        }
        if (isset($attrs['for'])) {
            $level = $emember_auth->getUserInfo('membership_level');
            $permitted_levels = explode('-', $attrs['for']);
            if (in_array($level, $permitted_levels))
                return $contents;

            if ($emember_config->getValue('eMember_enable_secondary_membership')) {
                $sec_levels = $emember_auth->getUserInfo('more_membership_levels');
                if ($sec_levels) {
                    if (is_string($sec_levels))
                        $sec_levels = explode(',', $sec_levels);
                    foreach ($sec_levels as $sec_level)
                        if (in_array($sec_level, $permitted_levels))
                            return $contents;
                }
            }

            if (!empty($do_not_show_restricted_msg)) {
                return ""; //do not show the restrcted content message
            }

            if (isset($attrs['custom_msg'])) {//Show the custom message
                $replacement = $attrs['custom_msg'];
                return wp_emember_format_message($replacement);
            } else {//Show the standard hidden content
                $account_upgrade_url = $emember_config->getValue('eMember_account_upgrade_url');
                return wp_emember_format_message(EMEMBER_HIDDEN_CONTENT_MESSAGE . '<br/>' . EMEMBER_PLEASE . ' <a href=" ' . $account_upgrade_url . '" target=_blank>' . EMEMBER_RENEW_OR_UPGRADE . '</a> ' . EMEMBER_YOUR_ACCOUNT);
            }
        }
        if (isset($attrs['not_for'])) {
            $level = $emember_auth->getUserInfo('membership_level');
            $ban_levels = explode('-', $attrs['not_for']);
            $banned = false;
            if (in_array($level, $ban_levels))
                $banned = true;
            else if ($emember_config->getValue('eMember_enable_secondary_membership')) {
                $sec_levels = $emember_auth->getUserInfo('more_membership_levels');
                if (!empty($sec_levels)) {
                    if (is_string($sec_levels))
                        $sec_levels = explode(',', $sec_levels);
                    foreach ($sec_levels as $sec_level)
                        if (in_array($sec_level, $ban_levels))
                            $banned = true;
                }
            }
            if ($banned) {
                if (!empty($do_not_show_restricted_msg)) {
                    return ""; //do not show the restrcted content message
                }
                return wp_emember_format_message(EMEMBER_HIDDEN_CONTENT_MESSAGE);
            }
        }
        return $contents;
    }

    $join_url = $emember_config->getValue('eMember_payments_page');
    if (empty($join_url)) {
        return wp_emember_format_message('<b>Membership Payment/Join Page</b>value is not set in eMember settings. Site admin needs to complete the settings in the pages/forms settings menu of eMember before the plugin can work.');
    } else
        $join_url = ' href ="' . $join_url . '" ';

    if (!empty($do_not_show_restricted_msg)) {
        return ""; //do not show the restrcted content message
    }

    if (isset($attrs['custom_msg'])) {
        $replacement = $attrs['custom_msg'];
    } else {
        $replacement = '<a ' . $join_url . ' ><b>' . EMEMBER_MEMBERS_ONLY_MESSAGE . '</b></a>';
    }
    return wp_emember_format_message($replacement);
}

/*********************protected tag#end************************************/
