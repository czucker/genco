<?php

/* * * Thesis theme override ** */
if (function_exists('wp_get_theme')) {
    if (wp_get_theme()->name == "Thesis") {
        add_filter('comments_template', 'remove_comments_template_on_pages', 10);
    }
}

/* * * Handle jigoshop "shop" page protection ** */
add_filter('loop-shop-posts-in', 'hide_jigoshop_product');

function hide_jigoshop_product($ids) {
    global $emember_auth;
    $post = get_page_by_title('shop');
    if ($emember_auth->is_post_accessible($post->ID))
        return $ids;
    return array(0);
}

//*** Handle BBPress topic protections ***/
add_action('bbp_loaded', 'bbp_handle_content_protection', 10);

function bbp_handle_content_protection() {
    add_filter('bbp_get_reply_content', 'wp_emember_enhance_forum_protection');
    //add_filter('bbp_get_topic_content','wp_emember_enhance_forum_protection');
    add_action('save_post', 'wp_emember_update_membership_level_reply');
    add_filter('bbp_user_can_view_forum', 'wp_emember_forum_viewing', 10, 3);
}

function wp_emember_forum_viewing($retval, $forum_id, $user_id) {
    global $post;
    if (wp_emember_is_forum_post_visible($post)) {
        return $retval;
    } else {
        //eMember can also output *protected* message here
        bbp_get_template_part('feedback', 'no-access');
        $retval = false;
        return $retval;
    }
}

function wp_emember_enhance_forum_protection($content) {
    global $post;
    if (wp_emember_is_forum_post_visible($post))
        return $content;
    return wp_emember_format_message(EMEMBER_CONTENT_RESTRICTED);
}

function wp_emember_is_forum_post_visible($post) {
    $id = $post->ID;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    if ($emember_auth->is_protected_custom_post($id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return false;
            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_custom_post($id)) {
                    return true;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }
    $topic_id = bbp_get_reply_topic_id($id);
    if (!empty($topic_id) && $emember_auth->is_protected_custom_post($topic_id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return false;
            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_custom_post($topic_id)) {
                    return true;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }
    $forum_id = bbp_get_topic_forum_id($id);
    if (!empty($forum_id) && $emember_auth->is_protected_custom_post($forum_id)) {
        if ($emember_auth->isLoggedIn()) {
            $expires = $emember_auth->getUserInfo('account_state');
            if ($expires == 'expired')
                return false;
            if (!$emember_auth->is_subscription_expired()) {
                if ($emember_auth->is_permitted_custom_post($forum_id)) {
                    return true;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    } else
        return true;

    return false;
}

function wp_emember_update_membership_level_reply($post_id) {
    if (!wp_is_post_revision($post_id)) {
        $post = get_post($post_id);
        if ($post->post_type == "reply") {
            $parent = $post->post_parent;
            global $wpdb;
            $auth = Emember_Auth::getInstance();
            $tbl = WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE;
            if ($auth->protected->is_protected_custom_post($parent)) {
                if (!$auth->protected->is_protected_custom_post($post_id)) {
                    $auth->protected->add_custom_posts(array($post_id))->save();
                }

                $levels = Emember_Level_Collection::get_instance()->get_levels();
                foreach ($levels as $level) {
                    if ($level->is_permitted_custom_post($post_id))
                        continue;
                    if ($level->is_permitted_custom_post($parent)) {
                        $level->add_custom_posts(array($post_id))->save();
                    }
                }
            } else if ($auth->protected->is_protected_page($parent)) {
                if (!$auth->protected->is_protected_page($post_id)) {
                    $auth->protected->add_pages(array($post_id))->save();
                }

                $levels = Emember_Level_Collection::get_instance()->get_levels();
                foreach ($levels as $level) {
                    if ($level->is_permitted_page($post_id))
                        continue;
                    if ($level->is_permitted_page($parent)) {
                        $level->add_pages(array($post_id))->save();
                    }
                }
            }
        }
    }
}
