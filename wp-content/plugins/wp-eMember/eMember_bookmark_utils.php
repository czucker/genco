<?php

function emember_bookmark_handler($content) {
    if (is_category())
        return $content;
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    global $post;
    $disabled_types = $emember_config->getValue('emember_disable_bookmark_by_type');
    $disable_for_loggedin = $emember_config->getValue('eMember_enable_bookmark_for_loggedin');
    $disabled_on_pages = (array) $emember_config->getValue('emember_disable_bookmark_by_page');
    if (!empty($disable_for_loggedin) && !$emember_auth->isLoggedIn())
        return $content;
    if (is_home() && in_array('home', $disabled_on_pages))
        return $content;
    if (is_category() && in_array('category', $disabled_on_pages))
        return $content;
    if (is_search() && in_array('search', $disabled_on_pages))
        return $content;

    if (empty($disabled_types))
        $disabled_types = array();
    if (in_array($post->post_type, $disabled_types))
        return $content;
    if (is_feed())
        return $content;
//    if(is_search()) return $content;

    if ($emember_auth->protected->is_bookmark_disabled($post->ID))
        return $content;
    if ($emember_auth->isLoggedIn()) {
        if ($emember_auth->permitted->primary_level->is_bookmark_disabled($post->ID))
            return $content;
        $extr = unserialize($emember_auth->getUserInfo('extra_info'));
        $bookmark = isset($extr['bookmarks']) ? $extr['bookmarks'] : array();
        $title = EMEMBER_ADD_FAV;
        $link = $post->ID;
        if (in_array($post->ID, $bookmark)) {
            $a1 = '<div title="Bookmarked"  class="count">
                        <span class="c">&radic;</span><br/>
                        <span class="t">' . EMEMBER_FAVORITE . '</span>
                    </div>';
            $a2 = '<div title="Bookmarked" class="emember">' . EMEMBER_ADDED . '</div>';
        } else {
            $a1 = '<a title="' . $title . '" target="_parent" href="' . $link . '" class="count">
                        <span class="c">+</span><br/>
                        <span class="t">' . EMEMBER_BOOKMARK . '</span>
                    </a>';
            $a2 = '<a href="' . $link . '" title="' . $title . '" target="_parent" class="emember">' . EMEMBER_ADD . '</a>';
        }
    } else {
        $title = EMEMBER_LOGIN_TO_BOOKMARK;
        $link = "";
        $a1 = '<div title="' . $title . '"  class="count">
                    <span class="c" style="color:red;">x</span><br/>
                    <span class="t">' . EMEMBER_BOOKMARK . '</span>
                </div>';
        $a2 = '<div  title="' . $title . '" class="emember">' . EMEMBER_LOGIN . '</div>';
    }
    $button = '<div class="emember_bookmark_button" style="float: right; margin-left: 10px;"><div class="ememberbookmarkbutton">' . $a1 . '</div></div>';
    return $button . $content;
}

function filter_eMember_bookmark_list($content) {
    $pattern = '#\[wp_eMember_bookmark_list:end]#';
    preg_match_all($pattern, $content, $matches);

    foreach ($matches[0] as $match) {
        $replacement = print_eMember_bookmark_list();
        $content = str_replace($match, $replacement, $content);
    }
    return $content;
}

function emember_del_bookmark() {
    if (isset($_POST['remove_bookmark'])) {
        $emember_auth = Emember_Auth::getInstance();
        if ($emember_auth->isLoggedIn()) {
            if (!empty($_POST['del_bookmark'])) {
                $emember_auth->remove_bookmark($_POST['del_bookmark']);
            }
        }
    }
}

function print_eMember_bookmark_list() {
    $emember_auth = Emember_Auth::getInstance();
    $emember_config = Emember_Config::getInstance();
    $enable_bookmark = $emember_config->getValue('eMember_enable_bookmark');
    if (!$enable_bookmark)
        return EMEMBER_BOOKMARK_DISABLED;
    if ($emember_auth->isLoggedIn()) {
        $bookmarks = $emember_auth->getUserInfo('extra_info');
        $bookmarks = unserialize($bookmarks);
        if (empty($bookmarks) || empty($bookmarks['bookmarks']))
            return EMEMBER_NO_BOOKMARK;
        else {
            $return = '<form method="post"><table>';
            $counter = 1;
            foreach ($bookmarks['bookmarks'] as $key) {
                //$c = ($counter%2)? 'style="background:#E8E8E8;"' : '';
                $c = ($counter % 2) ? 'class="emember_even_row"' : 'class="emember_odd_row"';
                $return .= '<tr ' . $c . ' ><td>' . $counter . '</td><td width=350px><a target= "_blank" href="' . get_permalink($key) . '">' . get_the_title($key) . '</a> </td>';
                $return .= '<td><input type="checkbox" name=del_bookmark[] value="' . $key . '" ></td><tr>';
                $counter++;
            }
            $return .= '<tr ><td colspan="3" align="left"><input type="submit" name="remove_bookmark" value="Remove" /></td></tr>';
            $return .= '</table>';
            $return .= '</form>';
            return $return;
        }
    } else
        return EMEMBER_BOOKMARK_NOT_LOGGED_IN;
}
