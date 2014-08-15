<?php


//redirect to current url, without parameters
$redirect_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$redirect_url_array=explode("?",$redirect_url);
$redirect_url=$redirect_url_array[0];
if (isset($_GET['cat'])) $redirect_url.="?cat=".$_GET['cat'];
if (isset($_GET['p'])) $redirect_url.="?p=".$_GET['p'];
if (isset($_GET['page_id'])) $redirect_url.="?page_id=".$_GET['page_id'];
wp_redirect($redirect_url);


exit;
