<?php

//***** Installer *****
include_once('lib/class.emember_meta.php');

//***Installer***
function wp_emember_activate() {
    global $wpdb;
    if (function_exists('is_multisite') && is_multisite()) {
        // check if it is a network activation - if so, run the activation function for each blog id
        if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
            $old_blog = $wpdb->blogid;
            // Get all blog ids
            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
            foreach ($blogids as $blog_id) {
                switch_to_blog($blog_id);
                wp_emember_installer();
                wp_emember_upgrader();
                wp_emember_initialize_db();
            }
            switch_to_blog($old_blog);
            return;
        }
    }
    wp_emember_installer();
    wp_emember_upgrader();
    wp_emember_initialize_db();
}

function wp_emember_installer() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    global $wpdb;
    $wpememmeta = new WPEmemberMeta();
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('member') . "'") != $wpememmeta->get_table('member')) {
        $sql = "CREATE TABLE " . $wpememmeta->get_table('member') . " (
	          `member_id` int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	          `user_name` varchar(128) NOT NULL,
	          `first_name` varchar(32) DEFAULT '',
	          `last_name` varchar(32) DEFAULT '',
	          `password` varchar(64) NOT NULL,
	          `member_since` date NOT NULL DEFAULT '0000-00-00',
	          `membership_level` smallint(6) NOT NULL,
	          `more_membership_levels` VARCHAR(100) DEFAULT NULL,
	          `account_state` enum('active','inactive','expired','pending','unsubscribed') DEFAULT 'pending',
	          `last_accessed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	          `last_accessed_from_ip` varchar(64) NOT NULL,
	          `email` varchar(64) DEFAULT NULL,
	          `phone` varchar(64) DEFAULT NULL,
	          `address_street` varchar(255) DEFAULT NULL,
	          `address_city` varchar(255) DEFAULT NULL,
	          `address_state` varchar(255) DEFAULT NULL,
	          `address_zipcode` varchar(255) DEFAULT NULL,
              `home_page` varchar(255) DEFAULT NULL,
	          `country` varchar(255) DEFAULT NULL,
	          `gender` enum('male','female','not specified') DEFAULT 'not specified',
	          `referrer` varchar(255) DEFAULT NULL,
	          `extra_info` text,
	          `reg_code` varchar(255) DEFAULT NULL,
	          `subscription_starts` date DEFAULT NULL,
	          `initial_membership_level` smallint(6) DEFAULT NULL,
	          `txn_id` varchar(64) DEFAULT '',
	          `subscr_id` varchar(32) DEFAULT '',
	          `company_name` varchar(100) DEFAULT '',
              `notes` text DEFAULT NULL,
	          `flags` int(11) DEFAULT '0',
	          `profile_image` varchar(255) DEFAULT '',
	          `expiry_1st` date NOT NULL DEFAULT '0000-00-00',
	          `expiry_2nd` date NOT NULL DEFAULT '0000-00-00',
	          `title` enum('Mr','Mrs','Miss','Ms','Dr','not specified') DEFAULT 'not specified',
              `ip_to_country` varchar(255) DEFAULT NULL
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        dbDelta($sql);

        // Add default options
        include_once('emember_config.php');
        $emember_config = Emember_Config::getInstance();
        //$emember_config->loadConfig();
        $emember_config->setValue('eMember_reg_firstname', "checked='checked'");
        $emember_config->setValue('eMember_reg_lastname', "checked='checked'");
        $emember_config->setValue('eMember_edit_firstname', "checked='checked'");
        $emember_config->setValue('eMember_edit_lastname', "checked='checked'");
        $emember_config->setValue('eMember_edit_company', "checked='checked'");
        $emember_config->setValue('eMember_edit_email', "checked='checked'");
        $emember_config->setValue('eMember_edit_phone', "checked='checked'");
        $emember_config->setValue('eMember_edit_street', "checked='checked'");
        $emember_config->setValue('eMember_edit_city', "checked='checked'");
        $emember_config->setValue('eMember_edit_state', "checked='checked'");
        $emember_config->setValue('eMember_edit_zipcode', "checked='checked'");
        $emember_config->setValue('eMember_edit_country', "checked='checked'");
        $emember_config->saveConfig();
    }
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('member_meta') . "'") != $wpememmeta->get_table('member_meta')) {
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpememmeta->get_table('member_meta') . " (
	          umeta_id bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
	  		  user_id bigint(20) unsigned NOT NULL DEFAULT '0',
	          meta_key varchar(255) DEFAULT NULL,
	          meta_value longtext,
	          KEY user_id (user_id)
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        dbDelta($sql);
    }

    if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('session') . "'") != $wpememmeta->get_table('session')) {
        $sql = "CREATE TABLE " . $wpememmeta->get_table('session') . " (
	         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	         session_id VARCHAR( 100 ) NOT NULL ,
	         user_id INT NOT NULL ,
             login_impression TIMESTAMP NOT NULL ,
	         last_impression TIMESTAMP NOT NULL ,
	         logged_in_from_ip varchar(15) NOT NULL,
	         user_name VARCHAR( 128 ) NOT NULL ,
	         UNIQUE (session_id)
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        dbDelta($sql);
    }

    if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('membership_level') . "'") != $wpememmeta->get_table('membership_level')) {
        $sql = "CREATE TABLE " . $wpememmeta->get_table('membership_level') . " (
	         id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	         alias varchar(127) NOT NULL,
	         role varchar(255) NOT NULL DEFAULT 'subscriber',
	         permissions tinyint(4) NOT NULL DEFAULT '0',
	         subscription_period int(11) NOT NULL DEFAULT '-1',
	         subscription_unit   VARCHAR(20)        NULL,
	         loginredirect_page  text NULL,
	         category_list longtext,
	         page_list longtext,
	         post_list longtext,
	         comment_list longtext,
			 attachment_list longtext,
			 custom_post_list longtext,
	         disable_bookmark_list longtext,
	         options longtext,
	         campaign_name varchar(60) NOT NULL DEFAULT ''
	      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        dbDelta($sql);
        //file_put_contents(WP_PLUGIN_DIR .'/' . WP_EMEMBER_FOLDER .  '/temp1.txt', serialize($wpdb));
        $sql = "SELECT * FROM " . $wpememmeta->get_table('membership_level') . " WHERE id = 1";
        $results = $wpdb->get_row($sql);
        if (is_null($results)) {
            $sql = "INSERT INTO  " . $wpememmeta->get_table('membership_level') . "  (
	            id ,
	            alias ,
	            role ,
	            permissions ,
	            subscription_period ,
	            subscription_unit,
	            loginredirect_page,
	            category_list ,
	            page_list ,
	            post_list ,
	            comment_list,
				attachment_list,
				custom_post_list,
	            disable_bookmark_list,
	            options,
	            campaign_name
	         )VALUES (NULL , 'Content Protection', 'administrator', '63', '0',NULL,NULL, NULL,NULL,NULL , NULL , NULL , NULL,NULL,NULL,''
	         );";
            $wpdb->query($sql);
        }
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('openid') . "'") != $wpememmeta->get_table('openid')) {
            $sql = "CREATE TABLE " . $wpememmeta->get_table('openid') . " (
	              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	              `emember_id` INT NOT NULL ,
	              `openuid` INT NOT NULL ,
	              `type` VARCHAR( 20 ) NOT NULL
	               )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            dbDelta($sql);
        }
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpememmeta->get_table('uploads') . "'") != $wpememmeta->get_table('uploads')) {
            $sql = "CREATE TABLE " . $wpememmeta->get_table('uploads') . " (
                  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                  `filename` VARCHAR( 255 ) NOT NULL ,
                  `guid` VARCHAR( 255 ) NOT NULL,
                  `mime_type` VARCHAR( 100 ) NOT NULL DEFAULT '',
                  `upload_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `meta` text NULL,
                  `count` int DEFAULT 0
                  )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            dbDelta($sql);
        }

        // Add default options
        add_option("wp_eMember_db_version", $wpememmeta->get_db_version());
    }
    //Create emember upload directory
    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['basedir'] . '/emember/';
    if (!is_dir($dir))
        mkdir($dir, 0755, true);
}

//***Upgrader***
function wp_emember_upgrader() {
    global $wpdb;
    $wpememmeta = new WPEmemberMeta();
    $installed_ver = get_option("wp_eMember_db_version");

    if ($installed_ver != $wpememmeta->get_db_version()) {
        $sql = "CREATE TABLE " . $wpememmeta->get_table('member') . " (
	          `member_id` int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	          `user_name` varchar(128) NOT NULL,
	          `first_name` varchar(32) DEFAULT '',
	          `last_name` varchar(32) DEFAULT '',
	          `password` varchar(64) NOT NULL,
	          `member_since` date NOT NULL DEFAULT '0000-00-00',
	          `membership_level` smallint(6) NOT NULL,
	          `more_membership_levels` VARCHAR(100) DEFAULT NULL,
	          `account_state` enum('active','inactive','expired','pending','unsubscribed') DEFAULT 'pending',
	          `last_accessed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	          `last_accessed_from_ip` varchar(64) NOT NULL,
	          `email` varchar(64) DEFAULT NULL,
	          `phone` varchar(64) DEFAULT NULL,
	          `address_street` varchar(255) DEFAULT NULL,
	          `address_city` varchar(255) DEFAULT NULL,
	          `address_state` varchar(255) DEFAULT NULL,
	          `address_zipcode` varchar(255) DEFAULT NULL,
              `home_page` varchar(255) DEFAULT NULL,
	          `country` varchar(255) DEFAULT NULL,
	          `gender` enum('male','female','not specified') DEFAULT 'not specified',
	          `referrer` varchar(255) DEFAULT NULL,
	          `extra_info` text,
	          `reg_code` varchar(255) DEFAULT NULL,
	          `subscription_starts` date DEFAULT NULL,
	          `initial_membership_level` smallint(6) DEFAULT NULL,
	          `txn_id` varchar(64) DEFAULT '',
	          `subscr_id` varchar(32) DEFAULT '',
	          `company_name` varchar(100) DEFAULT '',
              `notes` text DEFAULT NULL,
	          `flags` int(11) DEFAULT '0',
	          `profile_image` varchar(255) DEFAULT '',
	          `expiry_1st` date NOT NULL DEFAULT '0000-00-00',
	          `expiry_2nd` date NOT NULL DEFAULT '0000-00-00',
	          `title` enum('Mr','Mrs','Miss','Ms','Dr','not specified') DEFAULT 'not specified',
              `ip_to_country` varchar(255) DEFAULT NULL
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('member'));
        //dbDelta($sql);
        $sql = "CREATE TABLE " . $wpememmeta->get_table('session') . " (
	         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	         session_id VARCHAR( 100 ) NOT NULL ,
	         user_id INT NOT NULL ,
	         logged_in_from_ip varchar(15) NOT NULL,
	         last_impression TIMESTAMP NOT NULL ,
             login_impression TIMESTAMP NOT NULL ,
             user_name VARCHAR( 128 ) NOT NULL ,
	         UNIQUE (session_id)
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('session'));
        //dbDelta($sql);
        $sql = "CREATE TABLE IF NOT EXISTS " . $wpememmeta->get_table('member_meta') . " (
	         umeta_id  bigint(20) unsigned NOT NULL  PRIMARY KEY AUTO_INCREMENT,
	  		 user_id  bigint(20) unsigned NOT NULL DEFAULT '0',
	         meta_key  varchar(255) DEFAULT NULL,
	         meta_value longtext,
	         KEY user_id (user_id),
	         KEY meta_key (meta_key)
	      )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('member_meta'));
        //dbDelta($sql);
        $sql = "CREATE TABLE " . $wpememmeta->get_table('membership_level') . " (
	         id int(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT,
	         alias varchar(127) NOT NULL,
	         role varchar(255) NOT NULL DEFAULT 'subscriber',
	         permissions tinyint(4) NOT NULL DEFAULT '0',
	         subscription_period int(11) NOT NULL DEFAULT '-1',
	         subscription_unit   VARCHAR(20)        NULL,
	         loginredirect_page  text NULL,
	         category_list longtext,
	         page_list longtext,
	         post_list longtext,
	         comment_list longtext,
			 attachment_list longtext,
			 custom_post_list longtext,
	         disable_bookmark_list longtext,
	         options longtext,
	         campaign_name varchar(60) NOT NULL DEFAULT ''
	      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('membership_level'));
        //dbDelta($sql);
        $sql = "CREATE TABLE " . $wpememmeta->get_table('openid') . " (
              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
              `emember_id` INT NOT NULL ,
              `openuid` INT NOT NULL ,
              `type` VARCHAR( 20 ) NOT NULL
              ) ;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('openid'));
        //dbDelta($sql);
        //file_put_contents(WP_PLUGIN_DIR .'/' . WP_EMEMBER_FOLDER .  '/temp.txt', serialize($wpdb));

        $sql = "SELECT * FROM " . $wpememmeta->get_table('membership_level') . " WHERE id = 1";
        $results = $wpdb->get_row($sql);
        if (is_null($results)) {
            $sql = "INSERT INTO  " . $wpememmeta->get_table('membership_level') . "  (
	            id ,
	            alias ,
	            role ,
	            permissions ,
	            subscription_period ,
	            subscription_unit,
	            category_list ,
	            page_list ,
	            post_list ,
	            comment_list,
				attachment_list,
				custom_post_list,
	            disable_bookmark_list,
	            options
	         )VALUES (NULL , 'Content Protection', 'administrator', '63', '0', NULL,NULL,NULL,NULL, NULL , NULL , NULL,NULL,NULL
	         );";
            $wpdb->query($sql);
        }
        $sql = "CREATE TABLE " . $wpememmeta->get_table('uploads') . " (
              `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
              `filename` VARCHAR( 255 ) NOT NULL ,
              `guid` VARCHAR( 255 ) NOT NULL,
              `mime_type` VARCHAR( 100 ) NOT NULL,
              `upload_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
              `meta` text NULL,
              `count` int DEFAULT 0
              )ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        eMember_custom_dbDelta($sql, true, $wpememmeta->get_table('uploads'));

        // Add default options
        update_option("wp_eMember_db_version", $wpememmeta->get_db_version());
    }
}

/* * *************************************************************** */
/* * * === Other upgrade/default value setting realated tasks === ** */
/* * *************************************************************** */

function wp_emember_initialize_db() {
    include_once('emember_config.php');
    $emember_config = Emember_Config::getInstance();
    $wp_eMember_rego_field_default_settings_ver = 1;
    $currently_installed_ver = get_option("wp_eMember_rego_field_default_settings_ver");
    if ($currently_installed_ver < $wp_eMember_rego_field_default_settings_ver) {//TODO - remove @v9
        //$emember_config->loadConfig();
        $emember_config->setValue('eMember_reg_firstname', "checked='checked'");
        $emember_config->setValue('eMember_reg_lastname', "checked='checked'");
        $emember_config->setValue('eMember_edit_firstname', "checked='checked'");
        $emember_config->setValue('eMember_edit_lastname', "checked='checked'");
        $emember_config->setValue('eMember_edit_company', "checked='checked'");
        $emember_config->setValue('eMember_edit_email', "checked='checked'");
        $emember_config->setValue('eMember_edit_phone', "checked='checked'");
        $emember_config->setValue('eMember_edit_street', "checked='checked'");
        $emember_config->setValue('eMember_edit_city', "checked='checked'");
        $emember_config->setValue('eMember_edit_state', "checked='checked'");
        $emember_config->setValue('eMember_edit_zipcode', "checked='checked'");
        $emember_config->setValue('eMember_edit_country', "checked='checked'");
        $emember_config->saveConfig();
        add_option("wp_eMember_rego_field_default_settings_ver", $wp_eMember_rego_field_default_settings_ver);
    }

    /*     * * Settings default values at activation time ** */
    $senders_email_address = get_bloginfo('name') . " <" . get_bloginfo('admin_email') . ">";
    $eMember_email_subject = "Complete your registration";
    $eMember_email_body = "Dear {first_name} {last_name}" .
            "\n\nThank you for joining us!" .
            "\n\nPlease complete your registration by visiting the following link:" .
            "\n\n{reg_link}" .
            "\n\nThank You";

    add_option('senders_email_address', stripslashes($senders_email_address));
    add_option('eMember_email_subject', stripslashes($eMember_email_subject));
    add_option('eMember_email_body', stripslashes($eMember_email_body));

    $admin_email = get_option('admin_email');
    $emember_config->addValue('eMember_admin_notification_email_address', $admin_email);

    $emember_config->addValue('eMember_account_upgrade_email_subject', "Member Account Upgraded");
    $emember_config->addValue('eMember_account_upgrade_email_body', "Hi, Your account profile has been updated according to your latest payment.\n\nPlease log into your member profile to view the details.\n\nThank You");

    $emember_config->addValue('eMember_autoupgrade_senders_email_address', $senders_email_address);
    $emember_config->addValue('eMember_autoupgrade_email_subject', "Your Membership Details");
    $eMember_autoupgrade_email_body = "Hi,\nYour membership account has been upgraded." .
            "\nPlease log into your member profile to view the details." .
            "\n\nThank You";
    $emember_config->addValue('eMember_autoupgrade_email_body', $eMember_autoupgrade_email_body);

    $emember_config->addValue('eMember_status_change_email_subject', "Account Status Updated!");
    $eMember_status_change_email_body = 'Hi, Your account status has been updated.\n\nPlease log into your member profile to view the details.\n\nThank You';
    $emember_config->addValue('eMember_status_change_email_body', $eMember_status_change_email_body);

    /*     * * Setting default values at upgrade time ** */
    $emember_config->addValue('eMember_profile_thumbnail', "checked='checked'");
    $secrete_code = uniqid();
    $emember_config->addValue('wp_eMember_secret_word_for_post', $secrete_code);
    $emember_config->addValue('emember_members_menu_pagination_value', 50);

    $emember_config->setValue('wp_eMember_plugin_activation_check_flag', '1');

    /*     * * Create the mandatory configuration pages ** */
    // Check and create the member login page
    $create_login_page = '';
    if (!array_key_exists('login_page_url', $emember_config->configs)) {
        $create_login_page = '1';
    } else if (array_key_exists('login_page_url', $emember_config->configs)) {
        if ($emember_config->getValue('login_page_url') == "") {
            $create_login_page = '1';
        }
    }
    if ($create_login_page == '1') {
        // Create a new page object for Collect-Details page
        $eMember_login_page = array(
            'post_type' => 'page',
            'post_title' => 'Member Login',
            'post_content' => '[wp_eMember_login]',
            'post_status' => 'publish'
        );
        $page_id = wp_insert_post($eMember_login_page);
        $eMember_login_page_permalink = get_permalink($page_id);
        $emember_config->setValue('login_page_url', $eMember_login_page_permalink);
    }
    // Check and create the member join us page
    $create_join_page = '';
    if (!array_key_exists('eMember_payments_page', $emember_config->configs)) {
        $create_join_page = '1';
    } else if (array_key_exists('eMember_payments_page', $emember_config->configs)) {
        if ($emember_config->getValue('eMember_payments_page') == "") {
            $create_join_page = '1';
        }
    }
    if ($create_join_page == '1') {
        // Create a new page object for Collect-Details page
        $eMember_join_page_content = '<p style="color:red;font-weight:bold;">This page and the content has been automatically generated for you to give you a basic idea of how a Join Us page should look like. You can customize this page however you like it by editing this page from your WordPress page editor.</p>';
        $eMember_join_page_content .= '<p style="font-weight:bold;">If you end up changing the URL of this page then make sure to update the URL value in the pages/forms settings menu of the plugin.</p>';
        $eMember_join_page_content .= '<p style="border-top:1px solid #ccc;padding-top:10px;margin-top:10px;"></p>
			<strong>Free Membership</strong>
			<br />
			You get unlimited access to free membership content
			<br />
			<em><strong>Price: Free!</strong></em>
			<br /><br />Link the following image to go to the Registration Page if you want your visitors to be able to create a free membership account<br /><br />
			<img title="Join Now" src="' . WP_EMEMBER_URL . '/images/join-now-button-image.gif" alt="Join Now Button" width="277" height="82" />
			<p style="border-bottom:1px solid #ccc;padding-bottom:10px;margin-bottom:10px;"></p>';
        $eMember_join_page_content .= '<p><strong>You can register for a Free Membership or pay for one of the following membership options</strong></p>';
        $eMember_join_page_content .= '<p style="border-top:1px solid #ccc;padding-top:10px;margin-top:10px;"></p>
			[ ==> Insert Payment Button For Your Paid Membership Levels Here <== ]
			<p style="border-bottom:1px solid #ccc;padding-bottom:10px;margin-bottom:10px;"></p>';

        $eMember_join_page = array(
            'post_type' => 'page',
            'post_title' => 'Join Us',
            'post_content' => $eMember_join_page_content,
            'post_status' => 'publish'
        );
        $join_page_id = wp_insert_post($eMember_join_page);
        $eMember_join_page_permalink = get_permalink($join_page_id);
        $emember_config->setValue('eMember_payments_page', $eMember_join_page_permalink);
        // Create registration page
        $eMember_rego_page = array(
            'post_type' => 'page',
            'post_title' => 'Registration',
            'post_content' => '[wp_eMember_registration]',
            'post_parent' => $join_page_id,
            'post_status' => 'publish'
        );
        $rego_page_id = wp_insert_post($eMember_rego_page);
        $eMember_rego_page_permalink = get_permalink($rego_page_id);
        $emember_config->setValue('eMember_registration_page', $eMember_rego_page_permalink);
        add_option('eMember_registration_page', $eMember_rego_page_permalink);
    }
    /*     * * end of mandatory configuration page creation ** */
    //Save the data
    $emember_config->saveConfig();
    wp_emember_migrate_protection_list();
    emember_update_profile_image_migration();
}

//***** End Installer *****
function wp_emember_migrate_protection_list() {//TODO - remove @v10
    $cpm_ran_once = get_option("wp_emmeber_cpm_ran_once");
    if ($cpm_ran_once == "1") {
        return; //This has already been done once in this install
    }
    global $wpdb;
    $wpememmeta = new WPEmemberMeta();
    $table = $wpememmeta->get_table('membership_level');
    $results = $wpdb->get_results("SELECT id, permissions, post_list, attachment_list, custom_post_list FROM " . $table);
    $builtin_types = get_post_types('', 'names');
    foreach ($results as $result) {
        $mixed = unserialize($result->post_list);
        $posts = array();
        $pages = array();
        $attachments = (array) unserialize($result->attachment_list);
        $custom_posts = (array) unserialize($result->custom_post_list);
        foreach ($mixed as $id) {
            $type = get_post_type($id);
            if ($type == 'post')
                $posts[] = $id;
            else if ($type == 'attachment')
                $attachments[] = $id;
            else if (in_array($type, $builtin_types))
                continue;
            else
                $custom_posts[] = $id;
        }
        $permssions = $result->permissions;
        if (!empty($attachments))
            $permissions += 16;
        if (!empty($custom_posts))
            $permissions += 32;
        $fields = array('post_list' => serialize($posts),
            'attachment_list' => serialize($attachments),
            'custom_post_list' => serialize($custom_posts),
            'permissions' => $permissions);
        $wpdb->update($table, $fields, array('id' => $result->id));
    }
    update_option("wp_emmeber_cpm_ran_once", "1");
}

function emember_update_profile_image_migration() {//TODO - remove @v10
    $profile_migration_ran_once = get_option("wp_emmeber_profile_migration_ran_once");
    if ($profile_migration_ran_once == "1") {
        return; //This has already been done once in this install
    }
    global $wpdb;
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'];
    $upload_path .= '/emember/';

    $ids = $wpdb->get_col("SELECT member_id FROM " . WP_EMEMBER_MEMBERS_TABLE_NAME);
    foreach ($ids as $member_id) {
        $image_url = '';
        $p = $upload_path . $member_id;
        if (file_exists($p . '.jpg'))
            $image_url = $member_id . '.jpg';
        else if (file_exists($p . '.jpeg'))
            $image_url = $member_id . '.jpeg';
        else if (file_exists($p . '.gif'))
            $image_url = $member_id . '.gif';
        else if (file_exists($p . '.png'))
            $image_url = $member_id . '.png';
        $wpdb->update(WP_EMEMBER_MEMBERS_TABLE_NAME, array('profile_image' => $image_url), array('member_id' => $member_id));
    }
    update_option("wp_emmeber_profile_migration_ran_once", "1");
}

/* * * Custom dbdelta fuction since the core WordPress one is messing something up ** */

function eMember_custom_dbDelta($queries = '', $execute = true, $table_name = '') {
    global $wpdb;
    if (in_array($queries, array('', 'all', 'blog', 'global', 'ms_global'), true))
        $queries = wp_get_db_schema($queries);
    // Separate individual queries into an array
    if (!is_array($queries)) {
        $queries = explode(';', $queries);
        if ('' == $queries[count($queries) - 1])
            array_pop($queries);
    }
    $queries = apply_filters('dbdelta_queries', $queries);

    $cqueries = array(); // Creation Queries
    $iqueries = array(); // Insertion Queries
    $for_update = array();

    // Create a tablename index for an array ($cqueries) of queries
    foreach ($queries as $qry) {
        if (preg_match("|CREATE TABLE ([^ ]*)|", $qry, $matches)) {
            $cqueries[trim(strtolower($matches[1]), '`')] = $qry;
            $for_update[$matches[1]] = 'Created table ' . $matches[1];
        } else if (preg_match("|CREATE DATABASE ([^ ]*)|", $qry, $matches)) {
            array_unshift($cqueries, $qry);
        } else if (preg_match("|INSERT INTO ([^ ]*)|", $qry, $matches)) {
            $iqueries[] = $qry;
        } else if (preg_match("|UPDATE ([^ ]*)|", $qry, $matches)) {
            $iqueries[] = $qry;
        } else {
            // Unrecognized query type
        }
    }

    $cqueries = apply_filters('dbdelta_create_queries', $cqueries);
    $iqueries = apply_filters('dbdelta_insert_queries', $iqueries);

    //TODO - remove this function when WordPress fixes the issue
    if (!empty($table_name)) {//Apply our custom massaging as this is a custom db upgrade for a specific table
        foreach ($cqueries as $k => $v) {
            unset($cqueries[$k]);
            $new_key = $table_name;
            $cqueries[$new_key] = $v;
        }
    }

    $global_tables = $wpdb->tables('global');
    foreach ($cqueries as $table => $qry) {
        // Upgrade global tables only for the main site. Don't upgrade at all if DO_NOT_UPGRADE_GLOBAL_TABLES is defined.
        if (in_array($table, $global_tables) && (!is_main_site() || defined('DO_NOT_UPGRADE_GLOBAL_TABLES') ))
            continue;

        // Fetch the table column structure from the database
        $wpdb->suppress_errors();
        $tablefields = $wpdb->get_results("DESCRIBE {$table};");
        $wpdb->suppress_errors(false);

        if (!$tablefields)
            continue;

        // Clear the field and index arrays
        $cfields = $indices = array();
        // Get all of the field names in the query from between the parens
        preg_match("|\((.*)\)|ms", $qry, $match2);
        $qryline = trim($match2[1]);

        // Separate field lines into an array
        $flds = explode("\n", $qryline);

        //echo "<hr/><pre>\n".print_r(strtolower($table), true).":\n".print_r($cqueries, true)."</pre><hr/>";
        // For every field line specified in the query
        foreach ($flds as $fld) {
            // Extract the field name
            preg_match("|^([^ ]*)|", trim($fld), $fvals);
            $fieldname = trim($fvals[1], '`');

            // Verify the found field name
            $validfield = true;
            switch (strtolower($fieldname)) {
                case '':
                case 'primary':
                case 'index':
                case 'fulltext':
                case 'unique':
                case 'key':
                    $validfield = false;
                    $indices[] = trim(trim($fld), ", \n");
                    break;
            }
            $fld = trim($fld);

            // If it's a valid field, add it to the field array
            if ($validfield) {
                $cfields[strtolower($fieldname)] = trim($fld, ", \n");
            }
        }

        // For every field in the table
        foreach ($tablefields as $tablefield) {
            // If the table field exists in the field array...
            if (array_key_exists(strtolower($tablefield->Field), $cfields)) {
                // Get the field type from the query
                preg_match("|" . $tablefield->Field . " ([^ ]*( unsigned)?)|i", $cfields[strtolower($tablefield->Field)], $matches);
                $fieldtype = $matches[1];

                // Is actual field type different from the field type in query?
                if ($tablefield->Type != $fieldtype) {
                    // Add a query to change the column type
                    $cqueries[] = "ALTER TABLE {$table} CHANGE COLUMN {$tablefield->Field} " . $cfields[strtolower($tablefield->Field)];
                    $for_update[$table . '.' . $tablefield->Field] = "Changed type of {$table}.{$tablefield->Field} from {$tablefield->Type} to {$fieldtype}";
                }

                // Get the default value from the array
                //echo "{$cfields[strtolower($tablefield->Field)]}<br>";
                if (preg_match("| DEFAULT '(.*)'|i", $cfields[strtolower($tablefield->Field)], $matches)) {
                    $default_value = $matches[1];
                    if ($tablefield->Default != $default_value) {
                        // Add a query to change the column's default value
                        $cqueries[] = "ALTER TABLE {$table} ALTER COLUMN {$tablefield->Field} SET DEFAULT '{$default_value}'";
                        $for_update[$table . '.' . $tablefield->Field] = "Changed default value of {$table}.{$tablefield->Field} from {$tablefield->Default} to {$default_value}";
                    }
                }

                // Remove the field from the array (so it's not added)
                unset($cfields[strtolower($tablefield->Field)]);
            } else {
                // This field exists in the table, but not in the creation queries?
            }
        }

        // For every remaining field specified for the table
        foreach ($cfields as $fieldname => $fielddef) {
            // Push a query line into $cqueries that adds the field to that table
            $cqueries[] = "ALTER TABLE {$table} ADD COLUMN $fielddef";
            $for_update[$table . '.' . $fieldname] = 'Added column ' . $table . '.' . $fieldname;
        }

        // Index stuff goes here
        // Fetch the table index structure from the database
        $tableindices = $wpdb->get_results("SHOW INDEX FROM {$table};");

        if ($tableindices) {
            // Clear the index array
            unset($index_ary);

            // For every index in the table
            foreach ($tableindices as $tableindex) {
                // Add the index to the index data array
                $keyname = $tableindex->Key_name;
                $index_ary[$keyname]['columns'][] = array('fieldname' => $tableindex->Column_name, 'subpart' => $tableindex->Sub_part);
                $index_ary[$keyname]['unique'] = ($tableindex->Non_unique == 0) ? true : false;
            }

            // For each actual index in the index array
            foreach ($index_ary as $index_name => $index_data) {
                // Build a create string to compare to the query
                $index_string = '';
                if ($index_name == 'PRIMARY') {
                    $index_string .= 'PRIMARY ';
                } else if ($index_data['unique']) {
                    $index_string .= 'UNIQUE ';
                }
                $index_string .= 'KEY ';
                if ($index_name != 'PRIMARY') {
                    $index_string .= $index_name;
                }
                $index_columns = '';
                // For each column in the index
                foreach ($index_data['columns'] as $column_data) {
                    if ($index_columns != '')
                        $index_columns .= ',';
                    // Add the field to the column list string
                    $index_columns .= $column_data['fieldname'];
                    if ($column_data['subpart'] != '') {
                        $index_columns .= '(' . $column_data['subpart'] . ')';
                    }
                }
                // Add the column list to the index create string
                $index_string .= ' (' . $index_columns . ')';
                if (!(($aindex = array_search($index_string, $indices)) === false)) {
                    unset($indices[$aindex]);
                    //echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br />Found index:".$index_string."</pre>\n";
                }
                //else echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">{$table}:<br /><b>Did not find index:</b>".$index_string."<br />".print_r($indices, true)."</pre>\n";
            }
        }

        // For every remaining index specified for the table
        foreach ((array) $indices as $index) {
            // Push a query line into $cqueries that adds the index to that table
            $cqueries[] = "ALTER TABLE {$table} ADD $index";
            $for_update[$table . '.' . $fieldname] = 'Added index ' . $table . ' ' . $index;
        }

        // Remove the original table creation query from processing
        unset($cqueries[$table], $for_update[$table]);
    }

    $allqueries = array_merge($cqueries, $iqueries);
    if ($execute) {
        foreach ($allqueries as $query) {
            //echo "<pre style=\"border:1px solid #ccc;margin-top:5px;\">".print_r($query, true)."</pre>\n";
            $wpdb->query($query);
        }
    }

    return $for_update;
}

?>
