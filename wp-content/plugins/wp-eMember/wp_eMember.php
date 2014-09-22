<?php

/*
  Plugin Name: WP eMember
  Version: v8.9.1
  Plugin URI: http://www.tipsandtricks-hq.com/?p=1706
  Author: Tips and Tricks HQ
  Author URI: http://www.tipsandtricks-hq.com/
  Description: Simple WordPress Membership plugin to add Membership functionality to your wordpress blog.
 */
//Direct access to this file is not permitted
if (realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"])) {
    exit("Do not access this file directly.");
}

define('WP_EMEMBER_VERSION', "8.9.1");
define('WP_EMEMBER_DB_VERSION', "3.2.1"); //Holds the current db schema version. Only change this when schema changes.
global $wpdb;

include_once('wp_eMember1.php');

//Installer
require_once(dirname(__FILE__) . '/eMember_installer.php');

function wp_eMember_install() {
    wp_emember_activate();
    wp_schedule_event(time(), 'daily', 'wp_eMember_email_notifier_event');
    wp_schedule_event(time(), 'daily', 'wp_eMember_scheduled_membership_upgrade_event');
}

register_activation_hook(__FILE__, 'wp_eMember_install');

function wp_eMember_uninstall() {
    wp_clear_scheduled_hook('wp_eMember_email_notifier_event');
    wp_clear_scheduled_hook('wp_eMember_scheduled_membership_upgrade_event');
}

register_deactivation_hook(__FILE__, 'wp_eMember_uninstall');

function emember_handle_new_blog_creation($blog_id, $user_id, $domain, $path, $site_id, $meta) {
    global $wpdb;
    if (is_plugin_active_for_network(WP_EMEMBER_FOLDER . '/wp_eMember.php')) {
        $old_blog = $wpdb->blogid;
        switch_to_blog($blog_id);
        wp_emember_installer();
        wp_emember_upgrader();
        wp_emember_initialize_db();
        switch_to_blog($old_blog);
    }
}

add_action('wpmu_new_blog', 'emember_handle_new_blog_creation', 10, 6);

function wp_emember_add_settings_link($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $settings_link = '<a href="admin.php?page=eMember_settings_menu">Settings</a>';
        array_unshift($links, $settings_link);
    }
    return $links;
}

add_filter('plugin_action_links', 'wp_emember_add_settings_link', 10, 2);
