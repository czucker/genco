<?php

if (class_exists('thesis_comments')) {

} else {
    echo EMEMBER_COMMENT_PROTECTED;
    //echo get_login_link();
    comment_form();
}

