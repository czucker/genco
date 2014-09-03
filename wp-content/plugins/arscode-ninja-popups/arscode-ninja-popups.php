<?php
/*
  Plugin Name: Ninja Popups
  Plugin URI: http://codecanyon.net/item/ninja-popups-for-wordpress/3476479?ref=arscode
  Description: Awesome Popups for Your WordPress!
  Version: 3.3.4
  Author: ArsCode
  Author URI: http://www.arscode.pro/
 */

require_once( plugin_dir_path(__FILE__) . '/admin/options.php' );
require_once( plugin_dir_path(__FILE__) . '/include/functions.inc.php' );
require_once( plugin_dir_path(__FILE__) . '/include/snp_links.inc.php' );
require_once( plugin_dir_path(__FILE__) . '/include/fonts.inc.php' );

if (!defined('ABSPATH'))
{
	die('-1');
}
define('SNP_OPTIONS', 'snp');
define('SNP_DB_VER', '1.2');
define('SNP_URL', plugins_url('/', __FILE__));
//define('SNP_DIR_PATH', plugin_dir_path(__FILE__));
define('SNP_DIR_PATH', plugin_dir_path(__FILE__));
//echo SNP_DIR_PATH;
define('SNP_PROMO_LINK', 'http://codecanyon.net/item/ninja-popups-for-wordpress/3476479?ref=');
global $snp_ignore_cookies;
$SNP_THEMES = array();

//$SNP_THEMES_DIR = plugin_dir_path(__FILE__) . '/themes/';
$SNP_THEMES_DIR_2 = apply_filters( 'snp_themes_dir_2', '' );
$SNP_THEMES_DIR = apply_filters( 'snp_themes_dir', array(plugin_dir_path(__FILE__) . '/themes/', $SNP_THEMES_DIR_2));
function snp_popup_submit()
{
	global $wpdb;
	$result = array();
	$errors = array();
	$_POST['email'] = trim($_POST['email']);
	if (isset($_POST['name']))
	{
		$_POST['name'] = trim($_POST['name']);
	}
	if (!snp_is_valid_email($_POST['email']))
	{
		$errors['email'] = 1;
	}
	if (isset($_POST['name']) && !$_POST['name'])
	{
		$errors['name'] = 1;
	}
	$post_id = intval($_POST['popup_ID']);
	if($post_id)
	{
	    $POPUP_META = get_post_meta($post_id);
	}
	if (count($errors) > 0)
	{
		$result['Errors'] = $errors;
		$result['Ok'] = false;
	}
	else
	{
		$Done = 0;
		if(!empty($_POST['name']))
		{
		    $names=snp_detect_names($_POST['name']);
		}
		else
		{
		    $names=array('first' => '','last' => '');
		}
		if(isset($POPUP_META['snp_cf']))
		{
		    $cf=unserialize($POPUP_META['snp_cf'][0]);		
		}
		$cf_data=array();
		$api_error_msg='';
		if(isset($cf) && is_array($cf))
		{
		    foreach($cf as $f)
		    {
			if(isset($f['name']))
			{
			    if(strpos($f['name'],'['))
			    {
				$f['name'] = substr($f['name'], 0, strpos($f['name'], '['));
			    }
			    if(!empty($_POST[$f['name']]))
			    {
				$cf_data[$f['name']]=$_POST[$f['name']];
			    }
			}
		    }
		}
		if ( snp_get_option('ml_manager') == 'directmail' ) 
		{
			require_once SNP_DIR_PATH . '/include/directmail/class.directmail.php';
			$form_id = snp_get_option('ml_dm_form_id');
			
			if($form_id)
			{
				$api = new DMSubscribe();
				$retval = $api->submitSubscribeForm($form_id, $_POST['email'], $error_message);
				
				if ($retval) {
					$Done = 1;
				}
				else {
					// Error... Send by email?
					$api_error_msg=$error_message;
				}
			}
		}
		elseif ( snp_get_option('ml_manager') == 'sendy' ) 
		{
			$list_id=$POPUP_META['snp_ml_sendy_list'][0];
			if(!$list_id)
			{
			   $list_id=snp_get_option('ml_sendy_list');
			}		
			if($list_id)
			{
			    $options = array(
				'list' => $list_id,
				'boolean' => 'true'
			    );
			    $args['email'] = $_POST['email'];
			    if (!empty($_POST['name']))
			    {
				    $args['name'] = $_POST['name'];
			    }
			    if(count($cf_data)>0)
			    {
				$args=array_merge($args, (array) $cf_data);
			    }
			    $content = array_merge($args, $options);
			    $postdata = http_build_query($content);
			    $ch = curl_init(snp_get_option('ml_sendy_url') .'/subscribe');
			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_POST, 1);
			    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			    $api_result = curl_exec($ch);
			    curl_close($ch);
			    if (strval($api_result)=='true' || strval($api_result)=='1' || strval($api_result)=='Already subscribed.') 
			    {
			        $Done = 1;
			    }
			    else 
			    {
			        $api_error_msg=$api_result;
			    }
			}
		}
		elseif (snp_get_option('ml_manager') == 'mailchimp')
		{
			require_once SNP_DIR_PATH . '/include/mailchimp/Mailchimp.php';
			$ml_mc_list=$POPUP_META['snp_ml_mc_list'][0];
			if(!$ml_mc_list)
			{
			   $ml_mc_list=snp_get_option('ml_mc_list');
			}
			if (snp_get_option('ml_mc_apikey') && $ml_mc_list)
			{
				$api = new Mailchimp(snp_get_option('ml_mc_apikey'));
				$args = array();
				if (!empty($_POST['name']))
				{
					$args = array('FNAME' => $names['first'], 'LNAME' => $names['last'] );
				}
				if(count($cf_data)>0)
				{
				    $args=array_merge($args, (array) $cf_data);
				}
				try
				{
				    $double_optin=snp_get_option('ml_mc_double_optin');
				    if($double_optin==1)
				    {
					$double_optin=true;
				    }
				    else
				    {
					$double_optin=false;
				    }
				    $retval = $api->lists->subscribe($ml_mc_list, array('email'=>$_POST['email']), $args, 'html', $double_optin);
				    $Done = 1;
				}
				catch (Exception $e)
				{
				    if($e->getCode()==214)
				    {
					 $Done = 1;
				    }
				    else
				    {
					$api_error_msg=$e->getMessage();
				    }
				}
			}
		}
		elseif (snp_get_option('ml_manager') == 'getresponse')
		{
			$ml_gr_apikey = snp_get_option('ml_gr_apikey');
			require_once SNP_DIR_PATH . '/include/getresponse/jsonRPCClient.php';
			$api = new jsonRPCClient('http://api2.getresponse.com');
			try
			{
			    $ml_gr_list=$POPUP_META['snp_ml_gr_list'][0];
			    if(!$ml_gr_list)
			    {
			       $ml_gr_list=snp_get_option('ml_gr_list');
			    }
			    $args = array(
				    'campaign' => $ml_gr_list,
				    'email' => $_POST['email'],
			    );
			    if (!empty($_POST['name']))
			    {
				    $args['name'] = $_POST['name'];
			    }
			    if(count($cf_data)>0)
			    {
				$CustomFields=array();
				foreach($cf_data as $k => $v)
				{
				    $CustomFields[]=array(
					'name' => $k,
					'content' => $v
				    );
				}
				$args['customs']=$CustomFields;
			    }
			    $res = $api->add_contact($ml_gr_apikey, $args);
			    $Done = 1;
			}
			catch (Exception $e)
			{
				// Error...
				// We'll send this by email.
				$api_error_msg=$e->getMessage();
			}
		}
		elseif (snp_get_option('ml_manager') == 'campaignmonitor')
		{
			require_once SNP_DIR_PATH . '/include/campaignmonitor/csrest_subscribers.php';
			$ml_cm_list=$POPUP_META['snp_ml_cm_list'][0];
			if(!$ml_cm_list)
			{
			   $ml_cm_list=snp_get_option('ml_cm_list');
			}
			$wrap = new CS_REST_Subscribers($ml_cm_list, snp_get_option('ml_cm_apikey'));
			$args = array(
				'EmailAddress' => $_POST['email'],
				'Resubscribe' => true
			);
			if (!empty($_POST['name']))
			{
				$args['Name'] = $_POST['name'];
			}
			if(count($cf_data)>0)
			{
			    $CustomFields=array();
			    foreach($cf_data as $k => $v)
			    {
				$CustomFields[]=array(
				    'Key' => $k,
		                    'Value' => $v
				);
			    }
			    $args['CustomFields']=$CustomFields;
			}
			$res = $wrap->add($args);
			if ($res->was_successful())
			{
				$Done = 1;
			}
			else
			{
				// Error...
				// We'll send this by email.
				$api_error_msg='Failed with code ' . $res->http_status_code;
			}
		}
		elseif (snp_get_option('ml_manager') == 'icontact')
		{
			require_once SNP_DIR_PATH . '/include/icontact/iContactApi.php';
			iContactApi::getInstance()->setConfig(array(
				'appId' => snp_get_option('ml_ic_addid'),
				'apiPassword' => snp_get_option('ml_ic_apppass'),
				'apiUsername' => snp_get_option('ml_ic_username')
			));
			$oiContact = iContactApi::getInstance();
			$res1 = $oiContact->addContact($_POST['email'], null, null, (isset($names['first']) ? $names['first'] : ''), (isset($names['last']) ? $names['last'] : ''), null, null, null, null, null, null, null, null, null);
			if ($res1->contactId)
			{
			    $ml_ic_list=$POPUP_META['snp_ml_ic_list'][0];
			    if(!$ml_ic_list)
			    {
			       $ml_ic_list=snp_get_option('ml_ic_list');
			    }
			    if ($oiContact->subscribeContactToList($res1->contactId, $ml_ic_list, 'normal'))
			    {
				    $Done = 1;
			    }
			}
			else
			{
				// Error...
				// We'll send this by email.
				$api_error_msg='iContact Problem!';
			}
		}
		elseif (snp_get_option('ml_manager') == 'constantcontact')
		{
			require_once SNP_DIR_PATH . '/include/constantcontact/class.cc.php';
			$cc = new cc(snp_get_option('ml_cc_username'), snp_get_option('ml_cc_pass'));
			$email = $_POST['email'];
			$contact_list=$POPUP_META['snp_ml_cc_list'][0];
			if(!$contact_list)
			{
			   $contact_list=snp_get_option('ml_cc_list');
			}
			$extra_fields = array(
			);
			if (!empty($names['first']))
			{
				$extra_fields['FirstName'] = $names['first'];
			}
			if (!empty($names['last']))
			{
				$extra_fields['LastName'] = $names['last'];
			}
			if(count($cf_data)>0)
			{
			    $extra_fields=array_merge($extra_fields, (array) $cf_data);
			}
			$contact = $cc->query_contacts($email);
			if ($contact)
			{
				$status = $cc->update_contact($contact['id'], $email, $contact_list, $extra_fields);
				if ($status)
				{
					$Done = 1;
				}
				else
				{
					// Error...
					// We'll send this by email.
					$api_error_msg="Contact Operation failed: " . $cc->http_get_response_code_error($cc->http_response_code);
				}
			}
			else
			{
				$new_id = $cc->create_contact($email, $contact_list, $extra_fields);
				if ($new_id)
				{
					$Done = 1;
				}
				else
				{
					// Error...
					// We'll send this by email.
					$api_error_msg="Contact Operation failed: " . $cc->http_get_response_code_error($cc->http_response_code);
				}
			}
		}
		elseif (snp_get_option('ml_manager') == 'madmimi')
		{
		    require_once SNP_DIR_PATH . '/include/madmimi/MadMimi.class.php';
		    if (snp_get_option('ml_madm_username') && snp_get_option('ml_madm_apikey'))
		    {
			    $mailer	 = new MadMimi(snp_get_option('ml_madm_username'), snp_get_option('ml_madm_apikey'));
			    $user = array('email' => $_POST['email']);
			    if (!empty($names['first']))
			    {
				    $user['FirstName'] = $names['first'];
			    }
			    if (!empty($names['last']))
			    {
				    $user['LastName'] = $names['last'];
			    }
			    if(count($cf_data)>0)
			    {
				$user=array_merge($user, (array) $cf_data);
			    }
			    $ml_madm_list=$POPUP_META['snp_ml_madm_list'][0];
			    if(!$ml_madm_list)
			    {
			       $ml_madm_list=snp_get_option('ml_madm_list');
			    }
			    $user['add_list']=$ml_madm_list;
			    $res=$mailer->AddUser($user); 
			    $Done = 1;
		    }
		}
		elseif (snp_get_option('ml_manager') == 'infusionsoft')
		{
		    require_once SNP_DIR_PATH . '/include/infusionsoft/infusionsoft.php';
		    if (snp_get_option('ml_inf_subdomain') && snp_get_option('ml_inf_apikey'))
		    {
			    $infusionsoft	 = new Infusionsoft(snp_get_option('ml_inf_subdomain'), snp_get_option('ml_inf_apikey'));
			    $user = array('Email' => $_POST['email']);
			    if (!empty($names['first']))
			    {
				    $user['FirstName'] = $names['first'];
			    }
			    if (!empty($names['last']))
			    {
				    $user['LastName'] = $names['last'];
			    }
			    if(count($cf_data)>0)
			    {
				$user=array_merge($user, (array) $cf_data);
			    }
			    $ml_inf_list=$POPUP_META['snp_ml_inf_list'][0];
			    if(!$ml_inf_list)
			    {
			       $ml_inf_list=snp_get_option('ml_inf_list');
			    }
			    $contact_id = $infusionsoft->contact( 'add', $user );
			    if($contact_id && $ml_inf_list)
			    {
				$infusionsoft->contact( 'addToGroup', $contact_id, $ml_inf_list);
			    }
			    if($contact_id)
			    {
				$Done = 1;
			    }
		    }
		}		
		elseif (snp_get_option('ml_manager') == 'aweber')
		{
			require_once SNP_DIR_PATH . '/include/aweber/aweber_api.php';
			if (get_option('snp_ml_aw_auth_info'))
			{
				$aw = get_option('snp_ml_aw_auth_info');
				try
				{
					$aweber = new AWeberAPI($aw['consumer_key'], $aw['consumer_secret']);
					$account = $aweber->getAccount($aw['access_key'], $aw['access_secret']);
					$aw_list=$POPUP_META['snp_ml_aw_lists'][0];
					if(!$aw_list)
					{
					   $aw_list=snp_get_option('ml_aw_lists');
					}
					$list = $account->loadFromUrl('/accounts/' . $account->id . '/lists/' . $aw_list);
					$subscriber = array(
						'email' => $_POST['email'],
						'ip' => $_SERVER['REMOTE_ADDR']
					);
					if (!empty($_POST['name']))
					{
						$subscriber['name'] = $_POST['name'];
					}
					if(count($cf_data)>0)
					{
					    $subscriber['custom_fields'] = $cf_data;
					}
					$r=$list->subscribers->create($subscriber);
					$Done = 1;
				}
				catch (AWeberException $e)
				{
					$api_error_msg=$e->getMessage();
				}
			}
		}
		elseif (snp_get_option('ml_manager') == 'wysija' && class_exists('WYSIJA'))
		{
			$ml_wy_list=$POPUP_META['snp_ml_wy_list'][0];
			if(!$ml_wy_list)
			{
			   $ml_wy_list=snp_get_option('ml_wy_list');
			}
			$userData = array(
				'email' => $_POST['email'],
				'firstname' => $names['first'],
				'lastname' => $names['last']);
			$data = array(
				'user' => $userData,
				'user_list' => array('list_ids' => array($ml_wy_list))
			);
			$userHelper = &WYSIJA::get('user', 'helper');
			if($userHelper->addSubscriber($data))
			{
				$Done = 1;
			}
			else
			{
			    $api_error_msg='MailPoet Problem!';
			}
		}
		elseif (snp_get_option('ml_manager') == 'mymail' && function_exists('mymail_subscribe'))
		{
			$userdata = array(
				'firstname' => $names['first'],
				'lastname' => $names['last']
			    );
			$ml_mm_list=$POPUP_META['snp_ml_mm_list'][0];
			if(!$ml_mm_list)
			{
			   $ml_mm_list=snp_get_option('ml_mm_list');
			}
			$lists  = array($ml_mm_list);
			$return = mymail_subscribe( $_POST['email'], $userdata, $lists);
			if ( !is_wp_error($return) )
			{
				$Done = 1;
			}
			else
			{
			    $api_error_msg='MyMail Problem!';
			}
		}
		elseif (snp_get_option('ml_manager') == 'csv' && snp_get_option('ml_csv_file') && is_writable(SNP_DIR_PATH . 'csv/'))
		{
			if(!isset($_POST['name']))
			{
				$_POST['name']='';
			}
			if(count($cf_data)>0)
			{
			    $CustomFields='';
			    foreach($cf_data as $k => $v)
			    {
				$CustomFields.= $k.' = '.$v.';';
			    }
			}
			$data = $_POST['email'] . ";" . $_POST['name'] . ";" . $CustomFields . get_the_title($_POST['popup_ID']) . " (" . $_POST['popup_ID'] . ");" . date('Y-m-d H:i') . ";" . $_SERVER['REMOTE_ADDR'] . ";\n";
			if (file_put_contents(SNP_DIR_PATH . 'csv/' . snp_get_option('ml_csv_file'), $data, FILE_APPEND | LOCK_EX) !== FALSE)
			{
				$Done = 1;
			}
			else
			{
			    $api_error_msg='CSV Problem!';
			}
		}
		if (snp_get_option('ml_manager') == 'email' || !$Done)
		{
			$Email = snp_get_option('ml_email');
			if (!$Email)
			{
				$Email = get_bloginfo('admin_email');
			}
			if(!isset($_POST['name']))
			{
				$_POST['name']='--';
			}
			$error_mgs = '';
			if($api_error_msg!='')
			{
			    $error_mgs.="IMPORTANT! You have received this message because connection to your e-mail marketing software failed. Please check connection setting in the plugin configuration.\n";
			    $error_mgs.=$api_error_msg."\n";
			}
			$cf_msg = '';
			if(count($cf_data)>0)
			{
			    foreach($cf_data as $k => $v)
			    {
				$cf_msg .= $k.": " . $v . "\n";
			    }
			}
			$msg = 
			"New subscription on " . get_bloginfo() . "\n".
			$error_mgs.	
			"\n".
			"E-mail: " . $_POST['email'] . "\n".
			"Name: " . $_POST['name'] . "\n".
			$cf_msg.
			"\n".
			"Form: " . get_the_title($_POST['popup_ID']) . " (" . $_POST['popup_ID'] . ")\n".
			"\n".
			"Date: " . date('Y-m-d H:i') . "\n".
			"IP: " . $_SERVER['REMOTE_ADDR'] . "";
			wp_mail($Email, "New subscription on " . get_bloginfo(), $msg);
		}
		$result['Ok'] = true;
	}
	echo json_encode($result);
	die('');
}

function snp_popup_stats()
{
	global $wpdb;
	$table_name	 = $wpdb->prefix . "snp_stats";;
	$ab_id	 = intval($_POST['ab_ID']);
	$post_id = intval($_POST['popup_ID']);
	if (current_user_can( 'manage_options' )) {
		die('');
	}
	if ($post_id > 0)
	{
		if ($_POST['type'] == 'view')
		{
			$count = get_post_meta($post_id, 'snp_views');
			if (!$count || !$count[0])
				$count[0] = 0;
			update_post_meta($post_id, 'snp_views', $count[0] + 1);
			if($ab_id)
			{
			    $count		 = get_post_meta($ab_id, 'snp_views');
			    if (!$count || !$count[0])
				$count[0]	 = 0;
			    update_post_meta($ab_id, 'snp_views', $count[0] + 1);
			}
			$wpdb->query("insert into $table_name (`date`,`ID`,`AB_ID`,imps) values (CURDATE(),$post_id,$ab_id,1) on duplicate key update imps = imps + 1;"); 
			echo 'ok: view';
		}
		else
		{
			$count = get_post_meta($post_id, 'snp_conversions');
			if (!$count || !$count[0])
				$count[0] = 0;
			update_post_meta($post_id, 'snp_conversions', $count[0] + 1);
			if($ab_id)
			{
			    $count		 = get_post_meta($ab_id, 'snp_conversions');
			    if (!$count || !$count[0])
				$count[0]	 = 0;
			    update_post_meta($ab_id, 'snp_conversions', $count[0] + 1);
			}
			$wpdb->query("insert into $table_name (`date`,`ID`,`AB_ID`,convs) values (CURDATE(),$post_id,$ab_id,1) on duplicate key update convs = convs + 1;"); 
			echo 'ok: conversion';
		}
	}
	die('');
}

function snp_get_theme($theme)
{
	global $SNP_THEMES, $SNP_THEMES_DIR;
	if (!$theme)
	{
		return false;
	}
	foreach($SNP_THEMES_DIR as $DIR)
	{
	    if (is_dir($DIR . '/' . $theme . '') && is_file($DIR . '/' . $theme . '/theme.php'))
	    {
		require_once( $DIR . '/' . $theme . '/theme.php' );
		$SNP_THEMES[$theme]['DIR']=$DIR . '/' . $theme . '/';
		return $SNP_THEMES[$theme];
	    }  
	}
	return false;
}

function snp_get_themes_list()
{
	global $SNP_THEMES, $SNP_THEMES_DIR;
	if (count($SNP_THEMES) == 0)
	{
		$files = array();
		foreach($SNP_THEMES_DIR as $DIR)
		{
		    if (is_dir($DIR))
		    {
			    if ($dh = opendir($DIR))
			    {
				    while (($file = readdir($dh)) !== false)
				    {
					    if (is_dir($DIR . '/' . $file) && $file != '.' && $file != '..')
					    {
						    $files[] = $file;
					    }
				    }
				    closedir($dh);
			    }
		    }
		}
		sort($files);
		foreach ($files as $file)
		{
			snp_get_theme($file);
		}
	}
	//print_r($SNP_THEMES);

	return $SNP_THEMES;
}

function snp_popup_fields_list($popup)
{
	global $SNP_THEMES;
	$popup = trim($popup);
	if (is_array($SNP_THEMES) && is_array($SNP_THEMES[$popup]))
	{
		return $SNP_THEMES[$popup]['FIELDS'];
	}
	else
	{
		return array();
	}
}

function snp_popup_fields()
{
	global $SNP_THEMES, $SNP_NHP_Options, $post;
	if(!$post)
	{
		$post = (object)array();
	}
	$post->ID = intval($_POST['snp_post_ID']);
	snp_get_themes_list();
	if ($SNP_THEMES[$_POST['popup']])
	{
		$SNP_NHP_Options->_custom_fields_html('snp_popup_fields', $_POST['popup']);
	}
	else
	{
		echo 'Error...';
	}
	die();
}

//icontact
function snp_ml_get_ic_lists($ml_ic_username='', $ml_ic_addid='', $ml_ic_apppass='')
{
	require_once SNP_DIR_PATH . '/include/icontact/iContactApi.php';
	$list = array();
	if (
			(snp_get_option('ml_ic_username') && snp_get_option('ml_ic_addid') && snp_get_option('ml_ic_apppass')) ||
			($ml_ic_username && $ml_ic_addid && $ml_ic_apppass)
	)
	{
		if (!$ml_ic_username || !$ml_ic_addid || !$ml_ic_apppass)
		{
			$ml_ic_username = snp_get_option('ml_ic_username');
			$ml_ic_addid = snp_get_option('ml_ic_addid');
			$ml_ic_apppass = snp_get_option('ml_ic_apppass');
		}
		iContactApi::getInstance()->setConfig(array(
			'appId' => $ml_ic_addid,
			'apiPassword' => $ml_ic_apppass,
			'apiUsername' => $ml_ic_username
		));
		$oiContact = iContactApi::getInstance();
		try
		{
			$res = $oiContact->getLists();
			foreach ((array) $res as $v)
			{
				$list[$v->listId] = array('name' => $v->name);
			}
			//var_dump($oiContact->getLists());
		}
		catch (Exception $oException)
		{
			// Error
			// Catch any exceptions
			// Dump errors
			//var_dump($oiContact->getErrors());
			// Grab the last raw request data
			//var_dump($oiContact->getLastRequest());
			// Grab the last raw response data
			//var_dump($oiContact->getLastResponse());
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}
function snp_ml_get_aw_remove_auth()
{
	$return = array();
	delete_option('snp_ml_aw_auth_info');
	$return['Ok'] = true;
	return $return;
}
function snp_ml_get_aw_auth($ml_aw_auth_code)
{
	$return = array();
	require_once SNP_DIR_PATH . '/include/aweber/aweber_api.php';
	$descr = '';
	try
	{
		list($consumer_key, $consumer_secret, $access_key, $access_secret) = AWeberAPI::getDataFromAweberID($ml_aw_auth_code);
	}
	catch (AWeberAPIException $exc)
	{
		list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
		if(isset($exc->message))
		{
			$descr = $exc->message;
			$descr = preg_replace('/http.*$/i', '', $descr);	 # strip labs.aweber.com documentation url from error message
			$descr = preg_replace('/[\.\!:]+.*$/i', '', $descr); # strip anything following a . : or ! character
			$descr = '('.$descr.')';
		}
	}
	catch (AWeberOAuthDataMissing $exc)
	{
		list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
	}
	catch (AWeberException $exc)
	{
		list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
	}
	if (!$access_secret) 
	{
		$return['Error'] = 'Unable to connect to your AWeber Account ' .$descr;
		$return['Ok'] = false;
	}
	else
	{
		$ml_aw_auth_info = array(
			'consumer_key' => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'access_key' => $access_key,
			'access_secret' => $access_secret,
		);
		update_option('snp_ml_aw_auth_info',$ml_aw_auth_info);
		$return['Ok'] = true;
	}
	return $return;
}
// aweber
function snp_ml_get_aw_lists()
{
	require_once SNP_DIR_PATH . '/include/aweber/aweber_api.php';
	$list = array();
	if (get_option('snp_ml_aw_auth_info'))
	{
		$aw = get_option('snp_ml_aw_auth_info');
		try {
			$aweber = new AWeberAPI($aw['consumer_key'], $aw['consumer_secret']);
			$account = $aweber->getAccount($aw['access_key'], $aw['access_secret']);
			$res = $account->lists;
			if($res)
			{
				foreach ((array) $res->data['entries'] as $v)
				{
					$list[$v['id']] = array('name' => $v['name']);
				}
			}
		}
		catch (AWeberException $e) 
		{
		    //echo $e;
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}

// mailchimp
function snp_ml_get_mc_lists($ml_mc_apikey='')
{
	require_once SNP_DIR_PATH . '/include/mailchimp/Mailchimp.php';
	$list = array();
	if (snp_get_option('ml_mc_apikey') || $ml_mc_apikey)
	{
		try
	    {
			if ($ml_mc_apikey)
			{
				$api = new Mailchimp($ml_mc_apikey);
			}
			else
			{
				$api = new Mailchimp(snp_get_option('ml_mc_apikey'));
			}
			$retval = $api->lists->getList();
			if (!isset($api->errorCode))
			{
				foreach ((array) $retval['data'] as $v)
				{
					$list[$v['id']] = array('name' => $v['name']);
				}
			}
		}
	    catch (Exception $exc)
	    {

	    }
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}

// campaing monitor
function snp_ml_get_cm_lists($ml_cm_clientid='', $ml_cm_apikey='')
{
	require_once SNP_DIR_PATH . '/include/campaignmonitor/csrest_clients.php';
	$list = array();
	if (
			(snp_get_option('ml_cm_clientid') && snp_get_option('ml_cm_apikey')) ||
			($ml_cm_clientid && $ml_cm_apikey)
	)
	{
		if ($ml_cm_clientid && $ml_cm_apikey)
		{
			$wrap = new CS_REST_Clients($ml_cm_clientid, $ml_cm_apikey);
		}
		else
		{
			$wrap = new CS_REST_Clients(snp_get_option('ml_cm_clientid'), snp_get_option('ml_cm_apikey'));
		}
		$res = $wrap->get_lists();
		if ($res->was_successful())
		{
			foreach ((array) $res->response as $v)
			{
				$list[$v->ListID] = array('name' => $v->Name);
			}
		}
		else
		{
			// Error
			//echo 'Failed with code ' . $res->http_status_code . "\n<br /><pre>";
			//var_dump($res->response);
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}
// mymail
function snp_ml_get_mm_lists()
{
	$list = array();
	$args = array(
		'orderby'       => 'name', 
		'order'         => 'ASC',
		'hide_empty'    => false, 
		'exclude'       => array(), 
		'exclude_tree'  => array(), 
		'include'       => array(),
		'fields'        => 'all', 
		'hierarchical'  => true, 
		'child_of'      => 0, 
		'pad_counts'    => false, 
		'cache_domain'  => 'core'
	); 
	$lists=get_terms( 'newsletter_lists', $args );
	foreach($lists as $v)
	{
	    if($v->slug && $v->name)
	    {
		$list[$v->slug] = array('name' => $v->name);
	    }
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}
// wysija
function snp_ml_get_wy_lists()
{
	$list = array();
	if(class_exists('WYSIJA'))
	{
		$modelList = &WYSIJA::get('list','model');
		$wysijaLists = $modelList->get(array('name','list_id'),array('is_enabled'=>1));
		foreach($wysijaLists as $v)
		{
			$list[$v['list_id']] = array('name' => $v['name']);
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}
// getresponse
function snp_ml_get_gr_lists($ml_gr_apikey='')
{
	require_once SNP_DIR_PATH . '/include/getresponse/jsonRPCClient.php';
	$list = array();
	if (snp_get_option('ml_gr_apikey') || $ml_gr_apikey)
	{
		if (!$ml_gr_apikey)
		{
			$ml_gr_apikey = snp_get_option('ml_gr_apikey');
		}
		$api = new jsonRPCClient('http://api2.getresponse.com');
		try
		{
			$result = $api->get_campaigns($ml_gr_apikey);
			foreach ((array) $result as $k => $v)
			{
				$list[$k] = array('name' => $v['name']);
			}
		}
		catch (Exception $e)
		{
			//die($e->getMessage());
			// Error
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}

// Constant Contact
function snp_ml_get_cc_lists($ml_cc_username='', $ml_cc_pass='')
{
	require_once SNP_DIR_PATH . '/include/constantcontact/class.cc.php';

	$list = array();
	if (
			(snp_get_option('ml_cc_username') && snp_get_option('ml_cc_pass')) ||
			($ml_cc_username && $ml_cc_pass)
	)
	{
		if ($ml_cc_username && $ml_cc_pass)
		{
			$cc = new cc($ml_cc_username, $ml_cc_pass);
		}
		else
		{
			$cc = new cc(snp_get_option('ml_cc_username'), snp_get_option('ml_cc_pass'));
		}
		$res = $cc->get_lists('lists');
		if ($res)
		{
			foreach ((array) $res as $v)
			{
				$list[$v['id']] = array('name' => $v['Name']);
			}
		}
		else
		{
			// Error
		}
	}
	if (count($list) == 0)
	{
		$list[0] = array('name' => 'Nothing Found...');
	}
	return $list;
}

// madmimi
function snp_ml_get_madm_lists($ml_madm_username = '', $ml_madm_apikey = '')
{
    require_once SNP_DIR_PATH . '/include/madmimi/MadMimi.class.php';
    $list = array();
    if (
	    (snp_get_option('ml_madm_username') && snp_get_option('ml_madm_apikey')) ||
	    ($ml_madm_username && $ml_madm_apikey)
    )
    {
	try
	{
	    if ($ml_madm_username && $ml_madm_apikey)
	    {
		$mailer = new MadMimi($ml_madm_username, $ml_madm_apikey);
	    }
	    else
	    {
		$mailer	 = new MadMimi(snp_get_option('ml_madm_username'), snp_get_option('ml_madm_apikey'));
	    }
	    $lists	 = new SimpleXMLElement($mailer->Lists());
	    if ($lists->list)
	    {
		foreach ($lists->list as $l)
		{
		    $list[(string) $l->attributes()->{'name'}->{0}] = array('name' => (string) $l->attributes()->{'name'}->{0});
		}
	    }
	}
	catch (Exception $exc)
	{
	    
	}
    }
    if (count($list) == 0)
    {
	$list[0] = array('name' => 'Nothing Found...');
    }
    return $list;
}

// infusionsoft
function snp_ml_get_infusionsoft_lists($ml_inf_subdomain = '', $ml_inf_apikey = '')
{
    require_once SNP_DIR_PATH . '/include/infusionsoft/infusionsoft.php';

    $list = array();
    if (
	    (snp_get_option('ml_inf_subdomain') && snp_get_option('ml_inf_apikey')) ||
	    ($ml_inf_subdomain && $ml_inf_apikey)
    )
    {
	try
	{
	    if ($ml_inf_subdomain && $ml_inf_apikey)
	    {
		$infusionsoft	 = new Infusionsoft($ml_inf_subdomain, $ml_inf_apikey);
	    }
	    else
	    {
		$infusionsoft	 = new Infusionsoft(snp_get_option('ml_inf_subdomain'), snp_get_option('ml_inf_apikey'));
	    }
	    $fields = array('Id','GroupName');
	    $query = array('Id' => '%');
	    $result = $infusionsoft->data('query','ContactGroup',1000,0,$query,$fields);
	    if (is_array($result))
	    {
		foreach ($result as $l)
		{
		    $list[$l['Id']] = array('name' => $l['GroupName']);
		}
	    }
	}
	catch (Exception $exc)
	{
	    
	}
    }
    if (count($list) == 0)
    {
	$list[0] = array('name' => 'Nothing Found...');
    }
    return $list;
}

function snp_ml_list()
{
	if ($_POST['ml_manager'] == 'mailchimp')
	{
		echo json_encode(snp_ml_get_mc_lists($_POST['ml_mc_apikey']));
	}
	elseif ($_POST['ml_manager'] == 'getresponse')
	{
		echo json_encode(snp_ml_get_gr_lists($_POST['ml_gr_apikey']));
	}
	elseif ($_POST['ml_manager'] == 'campaignmonitor')
	{
		echo json_encode(snp_ml_get_cm_lists($_POST['ml_cm_clientid'], $_POST['ml_cm_apikey']));
	}
	elseif ($_POST['ml_manager'] == 'icontact')
	{
		echo json_encode(snp_ml_get_ic_lists($_POST['ml_ic_username'], $_POST['ml_ic_addid'], $_POST['ml_ic_apppass']));
	}
	elseif ($_POST['ml_manager'] == 'constantcontact')
	{
		echo json_encode(snp_ml_get_cc_lists($_POST['ml_cc_username'], $_POST['ml_cc_pass']));
	}
	elseif ($_POST['ml_manager'] == 'aweber_auth')
	{
		echo json_encode(snp_ml_get_aw_auth($_POST['ml_aw_auth_code']));
	}
	elseif ($_POST['ml_manager'] == 'aweber_remove_auth')
	{
		echo json_encode(snp_ml_get_aw_remove_auth());
	}
	elseif ($_POST['ml_manager'] == 'aweber')
	{
		echo json_encode(snp_ml_get_aw_lists());
	}
	elseif ($_POST['ml_manager'] == 'wysija')
	{
		echo json_encode(snp_ml_get_wy_lists());
	}
	elseif ($_POST['ml_manager'] == 'madmimi')
	{
		echo json_encode(snp_ml_get_madm_lists($_POST['ml_madm_username'], $_POST['ml_madm_apikey']));
	}
	elseif ($_POST['ml_manager'] == 'infusionsoft')
	{
		echo json_encode(snp_ml_get_infusionsoft_lists($_POST['ml_inf_subdomain'], $_POST['ml_inf_apikey']));
	}
	elseif ($_POST['ml_manager'] == 'mymail')
	{
		echo json_encode(snp_ml_get_mm_lists());
	}
	else
	{
		echo json_encode(array());
	}
	die();
}

function snp_popup_colors()
{
	global $SNP_THEMES, $SNP_NHP_Options, $post;
	snp_get_themes_list();
	echo json_encode($SNP_THEMES[$_POST['popup']]['COLORS']);
	die();
}

function snp_popup_types()
{
	global $SNP_THEMES, $SNP_NHP_Options, $post;
	snp_get_themes_list();
	echo json_encode($SNP_THEMES[$_POST['popup']]['TYPES']);
	die();
}

function snp_init()
{
	if (!snp_get_option('js_disable_jq_cookie') || is_admin())
	{
		// jQuery Cookie
		wp_enqueue_script(
				'jquery-np-cookie', plugins_url('/js/jquery.ck.min.js', __FILE__), array('jquery'), false, true
		);
	}
	if (!snp_get_option('js_disable_fancybox') || is_admin())
	{
		// Fancybox 2
		wp_register_style('fancybox2', plugins_url('/fancybox2/jquery.fancybox.min.css', __FILE__));
		wp_enqueue_style('fancybox2');
		wp_enqueue_script(
				'fancybox2', plugins_url('/fancybox2/jquery.fancybox.min.js', __FILE__), array('jquery'), false, true
		);
	}
	if (!snp_get_option('js_disable_jq_placeholder') || is_admin())
	{
		// jquery.placeholder.js
		wp_enqueue_script(
			'jquery-np-placeholder', plugins_url('/js/jquery.placeholder.js', __FILE__), array('jquery'), false, true
		);
	}	
	wp_enqueue_script(
		'js-ninjapopups', plugins_url('/js/ninjapopups.min.js', __FILE__), array('jquery'), false, true
	);
}

$snp_options = array();
$snp_popups = array();

function snp_get_option($opt_name, $default = null)
{
	global $snp_options;
	if (!$snp_options)
	{
		$snp_options = get_option(SNP_OPTIONS);
	}
	return (!empty($snp_options[$opt_name])) ? $snp_options[$opt_name] : $default;
}


function snp_run_popup($ID, $type)
{
	global $snp_popups, $PREVIEW_POPUP_META;
	if (!$ID && $ID != -1)
	{
		return;
	}
	snp_init();
	if ($ID == -1)
	{
		$POPUP_META = $PREVIEW_POPUP_META;
		// gm
		foreach ($POPUP_META as $k => $v)
		{
		    if (is_array($v))
		    {
			$v = serialize($v);
		    }
		    else
		    {
			$v		 = stripslashes($v);
		    }
		    $POPUP_META[$k]	 = $v;
		    $PREVIEW_POPUP_META[$k]	 = $v;
		}
	}
	else
	{
		if(strpos($ID,'ab_')===0) 
		{
		    $AB_ID = str_replace('ab_', '', $ID);
		    $AB_META = get_post_meta($AB_ID);
		    if(!isset($AB_META['snp_forms']))
		    {
			return;
		    }
		    $AB_META['snp_forms'] = array_keys(unserialize($AB_META['snp_forms'][0]));
		    if(!is_array($AB_META['snp_forms']) || count($AB_META['snp_forms'])==0)
		    {
			return;
		    }
		    $ID=$AB_META['snp_forms'][array_rand($AB_META['snp_forms'])];
		}
		$POPUP_META = get_post_meta($ID);
		foreach ((array) $POPUP_META as $k => $v)
		{
			$POPUP_META[$k] = $v[0];
		}
	}
	$POPUP_META['snp_theme'] = isset($POPUP_META['snp_theme']) ? unserialize($POPUP_META['snp_theme']) : '';
	$POPUP_START_DATE = strtotime(isset($POPUP_META['snp_start_date']) ? $POPUP_META['snp_start_date'] : '');
	$POPUP_END_DATE = strtotime(isset($POPUP_META['snp_end_date']) ? $POPUP_META['snp_end_date'] : '');
	if ($POPUP_START_DATE)
	{
		if ($POPUP_START_DATE <= time())
		{
			
		}
		else
		{
			return;
		}
	}
	if ($POPUP_END_DATE)
	{
		if ($POPUP_END_DATE >= time())
		{
			
		}
		else
		{
			return;
		}
	}

	if ($type == 'exit')
	{
		$use_in = snp_get_option('use_in');
		if ($use_in['the_content'] == 1)
		{
			add_filter('the_content', array('snp_links', 'search'), 100);
		}
		if ($use_in['the_excerpt'] == 1)
		{
			add_filter('the_excerpt', array('snp_links', 'search'), 100);
		}
		if ($use_in['widget_text'] == 1)
		{
			add_filter('widget_text', array('snp_links', 'search'), 100);
		}
		if ($use_in['comment_text'] == 1)
		{
			add_filter('comment_text', array('snp_links', 'search'), 100);
		}
	}
	add_action('wp_footer', 'snp_footer', 10, array());
	wp_register_style('snp_styles_reset', plugins_url('/themes/reset.min.css', __FILE__));
	wp_enqueue_style('snp_styles_reset');
	if (isset($POPUP_META['snp_theme']['theme']) && $POPUP_META['snp_theme']['theme'])
	{
		$THEME_INFO = snp_get_theme($POPUP_META['snp_theme']['theme']);
	}
	if (isset($THEME_INFO['STYLES']) && $THEME_INFO['STYLES'])
	{
		//wp_register_style('snp_styles_' . $POPUP_META['snp_theme']['theme'], plugins_url('/themes/' . $POPUP_META['snp_theme']['theme'] . '/' . $THEME_INFO['STYLES'] . '', __FILE__));
		wp_register_style('snp_styles_' . $POPUP_META['snp_theme']['theme'], plugins_url($POPUP_META['snp_theme']['theme'] . '/' .$THEME_INFO['STYLES'], realpath($THEME_INFO['DIR'])));
		wp_enqueue_style('snp_styles_' . $POPUP_META['snp_theme']['theme']);
	}
	if (isset($POPUP_META['snp_theme']['theme']) && function_exists('snp_enqueue_' . $POPUP_META['snp_theme']['theme']))
	{
	    call_user_func('snp_enqueue_' .$POPUP_META['snp_theme']['theme'], $POPUP_META);
	}
	if($type=='inline')
	{
	}
	elseif($type=='content')
	{
		$snp_popups[$type][] = array('ID' => $ID, 'AB_ID' => isset($AB_ID) ? $AB_ID : false);
	}
	else
	{
		$snp_popups[$type] = array('ID' => $ID, 'AB_ID' => isset($AB_ID) ? $AB_ID : false);
	}
}

function snp_create_popup($ID, $AB_ID, $type)
{
	global $PREVIEW_POPUP_META;
	$return = '';
	if ($ID == -1)
	{
		$POPUP_META = $PREVIEW_POPUP_META;
		/*foreach ($POPUP_META as $k => $v)
		{
			if (is_array($v))
			{
				$v = serialize($v);
			}
			else
			{
				$v = stripslashes($v);
			}
			$POPUP_META[$k] = $v;
		}*/
	}
	else
	{
		$POPUP = get_post($ID);
		$POPUP_META = get_post_meta($ID);
		foreach ($POPUP_META as $k => $v)
		{
			$POPUP_META[$k] = $v[0];
		}
	}
	if(!is_array($POPUP_META['snp_theme']))
	{
	    $POPUP_META['snp_theme'] = unserialize($POPUP_META['snp_theme']);
	}
	if (!$POPUP_META['snp_theme']['theme'])
	{
		return;
	}
	$CURRENT_URL = snp_get_current_url();

	$return .='	<div id="'.snp_get_option('class_popup','snppopup') . '-' . $type . ($type=='content' || $type=='inline' ? '-'.$ID : '').'" class="snp-pop-'.$ID.' '.snp_get_option('class_popup','snppopup').($type=='inline' ? ' snp-pop-inline' : '').'">';
	if (isset($POPUP_META['snp_cb_close_after']) && $POPUP_META['snp_cb_close_after'])
	{
		$return .= '<input type="hidden" class="snp_autoclose" value="' . $POPUP_META['snp_cb_close_after'] . '" />';
	}
	if (isset($POPUP_META['snp_open']) && $POPUP_META['snp_open'])
	{
		$return .= '<input type="hidden" class="snp_open" value="' . $POPUP_META['snp_open'] . '" />';
	}
	else
	{
		$return .= '<input type="hidden" class="snp_open" value="load" />';
	}
	if (isset($POPUP_META['snp_open_after']) && $POPUP_META['snp_open_after'])
	{
		$return .= '<input type="hidden" class="snp_open_after" value="' . $POPUP_META['snp_open_after'] . '" />';
	}
	if (isset($POPUP_META['snp_open_inactivity']) && $POPUP_META['snp_open_inactivity'])
	{
		$return .= '<input type="hidden" class="snp_open_inactivity" value="' . $POPUP_META['snp_open_inactivity'] . '" />';
	}
	if (isset($POPUP_META['snp_open_scroll']) && $POPUP_META['snp_open_scroll'])
	{
		$return .= '<input type="hidden" class="snp_open_scroll" value="' . $POPUP_META['snp_open_scroll'] . '" />';
	}
	if (isset($POPUP_META['snp_optin_redirect']) && $POPUP_META['snp_optin_redirect']=='yes' && !empty($POPUP_META['snp_optin_redirect_url']))
	{
		$return .= '<input type="hidden" class="snp_optin_redirect_url" value="' . $POPUP_META['snp_optin_redirect_url'] . '" />';
	}
	else
	{
		$return .= '<input type="hidden" class="snp_optin_redirect_url" value="" />';
	}
	if (!isset($POPUP_META['snp_popup_overlay']))
	{
		$POPUP_META['snp_popup_overlay'] = '';
	}
	$return .= '<input type="hidden" class="snp_show_cb_button" value="' . $POPUP_META['snp_show_cb_button'] . '" />';
	$return .= '<input type="hidden" class="snp_popup_id" value="' . $ID . '" />';
	if($AB_ID!=false)
	{
	    $return .= '<input type="hidden" class="snp_popup_ab_id" value="' . $AB_ID . '" />';
	}   
	$return .= '<input type="hidden" class="snp_popup_theme" value="' . $POPUP_META['snp_theme']['theme'] . '" />';
	$return .= '<input type="hidden" class="snp_overlay" value="' . $POPUP_META['snp_popup_overlay'] . '" />';
	$return .= '<input type="hidden" class="snp_cookie_conversion" value="' . (!empty($POPUP_META['snp_cookie_conversion']) ? $POPUP_META['snp_cookie_conversion'] : '30') . '" />';
	$return .= '<input type="hidden" class="snp_cookie_close" value="' . (!empty($POPUP_META['snp_cookie_close']) && $POPUP_META['snp_cookie_close'] ? $POPUP_META['snp_cookie_close'] : '-1') . '" />';
	$THEME_INFO = snp_get_theme($POPUP_META['snp_theme']['theme']);
	ob_start();
	include($THEME_INFO['DIR'] . '/template.php');
	$return .= ob_get_clean();
	if (!isset($POPUP_META['snp_cb_img']))
	{
		$POPUP_META['snp_cb_img'] = '';
	}
	if (!isset($POPUP_META['snp_custom_css']))
	{
		$POPUP_META['snp_custom_css'] = '';
	}
	if (!isset($POPUP_META['snp_custom_js']))
	{
		$POPUP_META['snp_custom_js'] = '';
	}
	//if ($POPUP_META['snp_overlay'] == 'disabled')
	//{
	//	$return .= '<style>.snp-pop-' . $ID . '-overlay { background: none !important;}</style>';
	//}
	if ($POPUP_META['snp_popup_overlay'] == 'image' && $POPUP_META['snp_overlay_image'])
	{
		$return .= '<style>.snp-pop-' . $ID . '-overlay { background: url(\'' . $POPUP_META['snp_overlay_image'] . '\');}</style>';
	}
	if ($POPUP_META['snp_cb_img'] != 'close_default' && $POPUP_META['snp_cb_img'] != '')
	{
		$return .= '<style>';
		switch ($POPUP_META['snp_cb_img'])
		{
			case 'close_1':
				$return .= '.snp-pop-' . $ID . '-wrap .fancybox-close { width: 31px; height: 31px; top: -15px; right: -15px; background: url(\'' . SNP_URL . 'img/' . $POPUP_META['snp_cb_img'] . '.png\');}';
				break;
			case 'close_2':
				$return .= '.snp-pop-' . $ID . '-wrap .fancybox-close { width: 19px; height: 19px; top: -8px; right: -8px; background: url(\'' . SNP_URL . 'img/' . $POPUP_META['snp_cb_img'] . '.png\');}';
				break;
			case 'close_3':
				$return .= '.snp-pop-' . $ID . '-wrap .fancybox-close { width: 33px; height: 33px; top: -16px; right: -16px; background: url(\'' . SNP_URL . 'img/' . $POPUP_META['snp_cb_img'] . '.png\');}';
				break;
			case 'close_4':
			case 'close_5':
				$return .= '.snp-pop-' . $ID . '-wrap .fancybox-close { width: 20px; height: 20px; top: -10px; right: -10px; background: url(\'' . SNP_URL . 'img/' . $POPUP_META['snp_cb_img'] . '.png\');}';
				break;
			case 'close_6':
				$return .= '.snp-pop-' . $ID . '-wrap .fancybox-close { width: 24px; height: 24px; top: -12px; right: -12px; background: url(\'' . SNP_URL . 'img/' . $POPUP_META['snp_cb_img'] . '.png\');}';
				break;
		}
		$return .= '</style>';
	}
	if ($POPUP_META['snp_custom_css'] != '')
	{
		$return .= '<style>';
		$return .= $POPUP_META['snp_custom_css'];
		$return .= '</style>';
	}
	if ($POPUP_META['snp_custom_js'] != '')
	{
		$return .= '<script>';
		$return .= $POPUP_META['snp_custom_js'];
		$return .= '</script>';
	}
	if(isset($THEME_INFO['OPEN_FUNCTION']) || isset($THEME_INFO['CLOSE_FUNCION']))
	{
		$return .= '<script>';
		$return .= 'snp_f[\''.snp_get_option('class_popup','snppopup') . '-' . $type . ($type=='content' || $type=='inline' ? '-'.$ID : '').'-open\'] ='.$THEME_INFO['OPEN_FUNCTION'].';';
		$return .= 'snp_f[\''.snp_get_option('class_popup','snppopup') . '-' . $type . ($type=='content' || $type=='inline' ? '-'.$ID : '').'-close\'] ='.$THEME_INFO['CLOSE_FUNCION'].';';
		$return .= '</script>';
	}
	$return .= '</div>';
	return $return;
}

function snp_footer()
{
	global $snp_popups, $snp_ignore_cookies, $post;
	?>
		<script>
		    var snp_f = [];
		</script>
		<div class="snp-root">
			<input type="hidden" id="snp_popup" value="" />
			<input type="hidden" id="snp_popup_id" value="" />
			<input type="hidden" id="snp_popup_theme" value="" />
			<input type="hidden" id="snp_exithref" value="" />
			<input type="hidden" id="snp_exittarget" value="" />
			<?php
			// exit popup
			if (!empty($snp_popups['exit']['ID']) && intval($snp_popups['exit']['ID']))
			{
				echo snp_create_popup($snp_popups['exit']['ID'], $snp_popups['exit']['AB_ID'], 'exit');
			}
			// welcome popup
			if (!empty($snp_popups['welcome']['ID']) && intval($snp_popups['welcome']['ID']))
			{
				echo snp_create_popup($snp_popups['welcome']['ID'], $snp_popups['welcome']['AB_ID'], 'welcome');
			}
			// popups from content
			if (isset($snp_popups['content']) && is_array($snp_popups['content']))
			{
				foreach($snp_popups['content'] as $popup_id)
				{
					echo snp_create_popup($popup_id['ID'], $popup_id['AB_ID'], 'content');
				}
			}
			?>
		</div>
		<script>
			var snp_timer;
			var snp_timer_o;
			var snp_ajax_url= '<?php echo admin_url('admin-ajax.php') ?>';
			var snp_ignore_cookies = <?php if (!$snp_ignore_cookies) { echo 'false'; } else { echo 'true'; } ?>;
			var snp_is_interal_link;
			<?php
			if (snp_get_option('enable_analytics_events')=='yes' && !is_admin())
			{
			    echo 'var snp_enable_analytics_events = true;';
			}
			else
			{
			    echo 'var snp_enable_analytics_events = false;';
			}
			?>
			jQuery(document).ready(function(){
				<?php
				if (!snp_get_option('js_disable_jq_placeholder') || is_admin())
				{
					echo "jQuery('[placeholder]').placeholder();";
				}
				?>
				jQuery(".snp_nothanks, .snp_closelink, .snp-close-link").click(function(){
					snp_close();
					return false;
				});
				jQuery(".snp_subscribeform").submit(function(){
					return snp_onsubmit(jQuery(this));
				});
				<?php
				if (!empty($snp_popups['welcome']['ID']) && intval($snp_popups['welcome']['ID']))
				{
					?>
								var snp_open=jQuery('#<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?> .snp_open').val();
								var snp_open_after=jQuery('#<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?> .snp_open_after').val();
								var snp_open_inactivity=jQuery('#<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?> .snp_open_inactivity').val();
								var snp_open_scroll=jQuery('#<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?> .snp_open_scroll').val();
								var snp_op_welcome = false;
								if(snp_open=='inactivity')
								{
								    var snp_idletime=0;
								    function snp_timerIncrement()
								    {
									snp_idletime++;
									if (snp_idletime > snp_open_inactivity)
									{
									    window.clearTimeout(snp_idleInterval);
									    snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?>','welcome');
									}
								    }
								    var snp_idleInterval = setInterval(snp_timerIncrement, 1000);
								    jQuery(this).mousemove(function (e) {
									snp_idletime = 0;
								    });
								    jQuery(this).keypress(function (e) {
									snp_idletime = 0;
								    });
								}
								else if(snp_open=='scroll')
								{
								    jQuery(window).scroll(function() {
									var h = jQuery(document).height()-jQuery(window).height();
									var sp = jQuery(window).scrollTop();
									var p = parseInt(sp/h*100);
									if(p>=snp_open_scroll &&  snp_op_welcome == false){
									    snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?>','welcome'); snp_op_welcome = true;
									}
								     });
								}
								else
								{
								    if(snp_open_after)
								    {
									    snp_timer_o=setTimeout("snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?>','welcome');",snp_open_after*1000);	
								    }
								    else
								    {
									    snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-welcome'; ?>','welcome');
								    }
								}
					<?php
				}
				?>
			});	
			<?php
			if (isset($snp_popups['exit']['ID']) && intval($snp_popups['exit']['ID']))
			{
				?>
				var snp_hostname = new RegExp(location.host);
				var snp_http = new RegExp("^(http|https)://", "i");
				var snp_excluded_urls = [];
				<?php
				$exit_excluded_urls=snp_get_option('exit_excluded_urls');
				if(is_array($exit_excluded_urls))
				{
					foreach($exit_excluded_urls as $url)
					{
						echo "snp_excluded_urls.push('".$url."');";
					}
				}
			
				$EXIT_POPUP_META = get_post_meta($snp_popups['exit']['ID']);
				if ($EXIT_POPUP_META['snp_show_on_exit'][0] == 2)
				{
					?>
					jQuery("a").click(function(){
						if(jQuery(this).hasClass('<?php echo snp_get_option('class_popup','snppopup'); ?>'))
						{
							return snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
						}
						else
						{
							var url = jQuery(this).attr("href");
							if(url.slice(0, 1) == "#")
							{   
							    return;
							}
							if(url.length>0 && !snp_hostname.test(url) && snp_http.test(url))
							{
								if(jQuery.inArray(url, snp_excluded_urls)==-1)
								{
									snp_is_interal_link=false;
								}
								else
								{
									// is excluded
									snp_is_interal_link=true;
								}
							}
							else
							{
								snp_is_interal_link=true;
							}
						}
					});
								jQuery(window).bind('beforeunload', function(e){
					<?php
					if (!$snp_ignore_cookies)
					{
						echo "if(jQuery.cookie('snp_" . snp_get_option('class_popup','snppopup') . "-exit')==1){return;}";
					}
					?>
									if(jQuery.fancybox2!==undefined && jQuery.fancybox2.isOpen)
									{
										return;
									}
									if(snp_is_interal_link==true)
									{
										return;
									}
									setTimeout("snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');",1000);
									//snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
									var e = e || window.event;
									if (e) {
										e.returnValue = '<?php echo str_replace("\r\n", '\n', addslashes($EXIT_POPUP_META['snp_exit_js_alert_text'][0])); ?>';
									}
									return '<?php echo str_replace("\r\n", '\n', addslashes($EXIT_POPUP_META['snp_exit_js_alert_text'][0])); ?>';
								});	
					<?php
				}
				elseif ($EXIT_POPUP_META['snp_show_on_exit'][0] == 3)
				{
				    ?>
				    var snp_op_exit=false;
				    jQuery(document).ready(function(){
					   jQuery(document).bind('mouseleave',function(e){
					      if(snp_op_exit == false){
					        snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
						snp_op_exit = true;
					    }
					});
				    });	
				    <?php
				}
				else
				{
				    ?>
				    jQuery(document).ready(function(){
					<?php
					$use_in = snp_get_option('use_in');
					if ($use_in['all'] == 1)
					{
					    ?>
					    jQuery("a:not(.<?php echo snp_get_option('class_popup','snppopup'); ?>)").click(function(){
						    if(jQuery(this).hasClass('<?php echo snp_get_option('class_popup','snppopup'); ?>'))
						    {
							    return snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
						    }
						    else
						    {
							    var url = jQuery(this).attr("href");
							    if(!snp_hostname.test(url) && url.slice(0, 1) != "#" && snp_http.test(url))
							    {
								    if(jQuery.inArray(url, snp_excluded_urls)==-1)
								    {
									    return snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
								    }
							    }
						    }
					    });    
					    <?php
					}
					?>
						jQuery("a.<?php echo snp_get_option('class_popup','snppopup'); ?>").click(function(){
							return snp_open_popup(jQuery(this).attr('href'),jQuery(this).attr('target'),'<?php echo snp_get_option('class_popup','snppopup') . '-exit'; ?>','exit');
						});
					});	
					<?php
				}
			}
			if (isset($snp_popups['content']) && is_array($snp_popups['content']))
			{
			?>
			jQuery(document).ready(function(){
				jQuery("a.<?php echo snp_get_option('class_popup','snppopup'); ?>-content, a[href^='#ninja-popup-']").click(function(){
				    var id = jQuery(this).attr('rel');
				    if(!id)
				    {
					id = jQuery(this).attr('href').replace('#ninja-popup-','');
				    }
				    if(id)
				    {
					return snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup'); ?>-content-'+id,'content');
				    }
				});
			});	
			<?php
			}
			?>
		</script>
		<?php
	}

	function snp_enqueue_social_script()
	{
		if (!snp_get_option('js_disable_fb') || is_admin())
		{
			// Facebook
			wp_enqueue_script('fbsdk', 'https://connect.facebook.net/'.snp_get_option('fb_locale','en_GB').'/all.js#xfbml=1', array());
			wp_localize_script('fbsdk', 'fbsdku', array(
				'xfbml' => 1,
			));
		}
		if (!snp_get_option('js_disable_gp') || is_admin())
		{
			// Google Plus
			wp_enqueue_script('plusone', 'https://apis.google.com/js/plusone.js', array());
		}
		if (!snp_get_option('js_disable_tw') || is_admin())
		{
			// Twitter
			wp_enqueue_script('twitter', 'https://platform.twitter.com/widgets.js', array());
		}
		if (!snp_get_option('js_disable_li') || is_admin())
		{
			// Linkedin
			wp_enqueue_script('linkedin', 'http://platform.linkedin.com/in.js', array());
		}
		//if (!snp_get_option('js_disable_pi') || is_admin())
		//{
		// Pinterest
		//wp_enqueue_script('pinterest', 'https://assets.pinterest.com/js/pinit.js', array());
		//}
	}
	function snp_ninja_popup_shortcode($attr, $content = null)
	{
		extract(shortcode_atts(array('id' => '', 'autoopen' => false), $attr));
		snp_run_popup($id, 'content');
		if(isset($autoopen) && $autoopen==true)
		{
			?>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				var snp_open_after=jQuery('#<?php echo snp_get_option('class_popup','snppopup') . '-content-'.$id; ?> .snp_open_after').val();
				if(snp_open_after)
				{
					snp_timer_o=setTimeout("snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-content-'.$id; ?>','content');",snp_open_after*1000);	
				}
				else
				{
					snp_open_popup('','','<?php echo snp_get_option('class_popup','snppopup') . '-content-'.$id; ?>','content');
				}		
			});
			</script>
			<?php
		}
		if($content)
		{
			return '<a href="#ninja-popup-'.$id.'" class="'.snp_get_option('class_popup','snppopup').'-content" rel="'.$id.'">'.  $content.' </a>';
		}
		return '';
	}
	add_shortcode( 'ninja-popup', 'snp_ninja_popup_shortcode' );
	
	function snp_detect_shortcode($shortcode)
	{
		global $post;
		$pattern = get_shortcode_regex();
		preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches );
		if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( $shortcode, $matches[2] ) )
		{
			$IDs=array();
			foreach($matches[2] as $k => $v)
			{
				if($v==$shortcode)
				{
					$t_atts=shortcode_parse_atts( $matches[3][$k] );
					$IDs[]=$t_atts['id'];
				}
			}
			return $IDs;
		}
		else
		{
			return array();
		}
	}
	function snp_run()
	{
		global $post;
		// disabled for 404
		if (is_404())
		{
			return;
		}
		// enabled?
		if (snp_get_option('enable') == 'disabled')
		{
			return;
		}
		// mobile device?
		if (snp_get_option('enable_mobile') == 'disabled' && snp_detect_mobile($_SERVER['HTTP_USER_AGENT']))
		{
			return;
		}
		if((isset($_REQUEST['nphide']) && $_REQUEST['nphide']==1) || isset($_COOKIE['nphide']) && $_COOKIE['nphide']==1)
		{
		    setcookie('nphide',1,0,COOKIEPATH, COOKIE_DOMAIN, false);
		    return;
		}
		$WELCOME_ID = false;
		$EXIT_ID = false;
		$P_WELCOME_ID = false;
		$P_EXIT_ID = false;
		
		if (isset($post->ID) && (is_page() || is_single()))
		{
			$WELCOME_ID = get_post_meta($post->ID, 'snp_p_welcome_popup', true);
			$EXIT_ID = get_post_meta($post->ID, 'snp_p_exit_popup', true);
		}

		// WELCOME
		if (snp_get_option('welcome_disable_for_logged')==1 && is_user_logged_in())
		{
		}
		else
		{
		    if ($WELCOME_ID == 'global' || !$WELCOME_ID)
		    {
			$WELCOME_ID = snp_get_option('welcome_popup');
		    }
		    else
		    {
			$P_WELCOME_ID = true;
		    }
		    if ($P_WELCOME_ID)
		    {
			if ($WELCOME_ID != 'disabled')
			{
			    snp_run_popup($WELCOME_ID, 'welcome');
			}
		    }
		    else
		    {
			$welcome_display_in = snp_get_option('welcome_display_in');
			if (is_front_page() && isset($welcome_display_in['home']) &&  $welcome_display_in['home'] == 1)//home
			{
			    snp_run_popup($WELCOME_ID, 'welcome');
			}
			elseif (is_page() && isset($welcome_display_in['pages']) && $welcome_display_in['pages'] == 1) //page
			{
			    snp_run_popup($WELCOME_ID, 'welcome');
			}
			elseif (is_single() && isset($welcome_display_in['posts']) && $welcome_display_in['posts'] == 1) //post
			{
			    snp_run_popup($WELCOME_ID, 'welcome');
			}
			elseif (isset($welcome_display_in['others']) &&$welcome_display_in['others'] == 1 && !is_front_page() && !is_page() && !is_single())// other
			{
			    snp_run_popup($WELCOME_ID, 'welcome');
			}
		    }
		}
		// EXIT
		if (snp_get_option('exit_disable_for_logged')==1 && is_user_logged_in())
		{
		}
		else
		{
		    if ($EXIT_ID == 'global' || !$EXIT_ID)
		    {
			    $EXIT_ID = snp_get_option('exit_popup');
		    }
		    else
		    {
			    $P_EXIT_ID = true;
		    }
		    if ($P_EXIT_ID)
		    {
			    if ($EXIT_ID != 'disabled')
			    {
				    snp_run_popup($EXIT_ID, 'exit');
			    }
		    }
		    else
		    {
			    $exit_display_in = snp_get_option('exit_display_in');
			    if (is_front_page() && isset($exit_display_in['home']) && $exit_display_in['home'] == 1)//home
			    {
				    snp_run_popup($EXIT_ID, 'exit');
			    }
			    elseif (is_page() && isset($exit_display_in['pages']) && $exit_display_in['pages'] == 1) //page
			    {
				    snp_run_popup($EXIT_ID, 'exit');
			    }
			    elseif (is_single() && isset($exit_display_in['posts']) && $exit_display_in['posts'] == 1) //post
			    {
				    snp_run_popup($EXIT_ID, 'exit');
			    }
			    elseif (isset($exit_display_in['others']) && $exit_display_in['others'] == 1 && !is_front_page() && !is_page() && !is_single())// other
			    {
				    snp_run_popup($EXIT_ID, 'exit');
			    }
		    }
		}
		$INLINE_IDs=array();
		$CONTENT_IDs=array();
		add_filter( 'wp_nav_menu_objects', 'snp_wp_nav_menu_objects' );
		$IDs=array_merge((array)$CONTENT_IDs,(array)$INLINE_IDs,array($EXIT_ID,$WELCOME_ID));
		foreach((array)$IDs as $ID)
		{	
			if ($ID != 'disabled')
			{
				$ID_snp_theme = get_post_meta($ID, 'snp_theme');
				if(!empty($ID_snp_theme) &&
					(
						$ID_snp_theme[0]['type'] == 'social' ||
						$ID_snp_theme[0]['type'] == 'likebox'		
					)
				)
				{
					add_action('wp_enqueue_scripts', 'snp_enqueue_social_script');
					break;
				}
			}
		}
	}
	function snp_wp_nav_menu_objects( $items ) 
	{
	    $parents = array();
	    foreach ( $items as $item ) 
	    {
		    if(strpos($item->url,'#ninja-popup-')!==FALSE)
		    {
			$ID=str_replace('#ninja-popup-', '', $item->url);
			if(intval($ID))
			{
			    snp_run_popup(intval($ID), 'content');
			}
		    }
	    }
	    return $items;    
	}

	function snp_posttype_admin_css()
	{
		global $post_type;
		$post_types = array(
			'snp_popups', 'snp_campaign', 'snp_ab'
		);
		if (in_array($post_type, $post_types))
		{
			echo '<style type="text/css">#the-list .inline, #post-preview, #minor-publishing, #titlediv .inside, #message.updated a{display: none;}</style>';
			echo '<script>jQuery(document).ready(function(){
			jQuery("#the-list .view a").each(function(){
				jQuery(this).attr("href",jQuery(this).parents("tr").find("a.snp_preview").attr("href")).attr("target","_blank");
			});
		 });</script>';
		 ?>
		 <style type="text/css" media="screen">
		@media only screen and (min-width: 1150px) {	
		    #side-sortables.fixed { position: fixed; top: 55px; right: 17px; width: 280px; }
		}	
		</style>
		<script>
		jQuery(document).ready(function($) {
		    var snpprevPosition = $('#side-sortables').offset();
		    $(window).scroll(function(){
			    if($(window).scrollTop() > snpprevPosition.top)
			    {
				$('#side-sortables').addClass('fixed');
			    } 
			    else 
			    {
				$('#side-sortables').removeClass('fixed');
			    }    
		    });
		});
		</script>
		 <?php
		}
	}

	function snp_add_columns($columns)
	{
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = 'Name';
		$new_columns['snp_theme'] = 'Theme';
		$new_columns['snp_views'] = 'Impressions';
		$new_columns['snp_conversions'] = 'Conversions';
		$new_columns['snp_rate'] = 'Rate';
		$new_columns['snp_stats'] = 'Analytics‎';		
		$new_columns['snp_ID'] = 'ID';
		$new_columns['snp_preview'] = 'Preview';
		return $new_columns;
	}
	function snp_ab_add_columns($columns)
	{
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = 'Name';
		$new_columns['snp_views'] = 'Impressions';
		$new_columns['snp_conversions'] = 'Conversions';
		$new_columns['snp_rate'] = 'Rate';
		$new_columns['snp_stats'] = 'Analytics‎';		
		$new_columns['snp_ID'] = 'ID';
		return $new_columns;
	}

	function snp_manage_columns($column_name, $id)
	{
		global $SNP_THEMES;
		if ($column_name == 'snp_views')
		{
			$count = get_post_meta($id, 'snp_views');
			if (!isset($count[0]))
				$count[0] = 0;
			echo $count[0];
		}
		elseif ($column_name == 'snp_conversions')
		{
			$count = get_post_meta($id, 'snp_conversions');
			if (!isset($count[0]))
				$count[0] = 0;
			echo $count[0];
		}
		elseif ($column_name == 'snp_rate')
		{
			$snp_views = get_post_meta($id, 'snp_views');
			if (!isset($snp_views[0]))
				$snp_views[0] = 0;
			$snp_conversions = get_post_meta($id, 'snp_conversions');
			if (!isset($snp_conversions[0]))
				$snp_conversions[0] = 0;
			if ($snp_views[0] > 0)
			{
				echo round(($snp_conversions[0] / $snp_views[0]) * 100, 2) . '%';
			}
			else
			{
				echo '--';
			}
		}
		elseif ($column_name == 'snp_theme')
		{
			$POPUP_THEME = get_post_meta($id, 'snp_theme');
			if (!empty($POPUP_THEME[0]['theme']))
			{
				echo $SNP_THEMES[$POPUP_THEME[0]['theme']]['NAME'];
			}
			else
			{
				echo '--';
			}
		}
		elseif ($column_name == 'snp_ID')
		{
			echo $id;
		}
		elseif ($column_name == 'snp_preview')
		{
			echo '<a class="snp_preview" target="_blank" href="admin-ajax.php?action=snp_preview_popup&amp;popup_ID=' . $id . '">Open Preview</a>';
		}
		elseif ($column_name == 'snp_stats')
		{
		    if(get_post_type( $id )=='snp_ab')
		    {
			echo '<a href="edit.php?post_type=snp_popups&page=snp_stats&amp;popup_ID=ab_' . $id . '">Analytics‎</a>';
		    }
		    else
		    {
			echo '<a href="edit.php?post_type=snp_popups&page=snp_stats&amp;popup_ID=' . $id . '">Analytics‎</a>';
		    }
		}
	}
	
	function snp_add_columns_posts($columns)
	{
		$new_columns=$columns;
		$new_columns['snp_popup'] = 'Ninja Popups';
		return $new_columns;
	}
	function snp_manage_columns_posts($column_name, $id)
	{
		global $SNP_THEMES;
		if ($column_name == 'snp_popup')
		{
			$POST_META_WELCOME_G=0;
			$POST_META_EXIT_G=0;
			$POST_META_WELCOME_TITLE='';
			$POST_META_EXIT_TITLE='';
			$POST_META_WELCOME = get_post_meta($id, 'snp_p_welcome_popup');
			if(!isset($POST_META_WELCOME) || !isset($POST_META_WELCOME[0]))
			{
				$POST_META_WELCOME=array();
				$POST_META_WELCOME[0]='global';
			}
			$POST_META_EXIT = get_post_meta($id, 'snp_p_exit_popup');
			if(!isset($POST_META_EXIT) || !isset($POST_META_EXIT[0]))
			{
				$POST_META_EXIT=array();
				$POST_META_EXIT[0]='global';
			}
			//print_r($POST_META_WELCOME);
			//print_r($POST_META_EXIT);
			if($POST_META_WELCOME[0]=='disabled')
			{
				$POST_META_WELCOME_TITLE='Disabled';
			}
			elseif($POST_META_WELCOME[0]=='global')
			{
				$POST_META_WELCOME_G=1;
				$POST_META_WELCOME_ID=snp_get_option('welcome_popup');
				if($POST_META_WELCOME_ID=='disabled')
				{
					$POST_META_WELCOME_TITLE='Disabled';
				}
				else
				{
					$POST_META_WELCOME_TITLE=get_the_title(str_replace('ab_','',$POST_META_WELCOME_ID));
				}
			}
			else
			{
				$POST_META_WELCOME_ID=$POST_META_WELCOME[0];
				$POST_META_WELCOME_TITLE=get_the_title(str_replace('ab_','',$POST_META_WELCOME[0]));
			}
			if($POST_META_EXIT[0]=='disabled')
			{
				$POST_META_EXIT_TITLE='Disabled';
			}
			elseif($POST_META_EXIT[0]=='global')
			{
				$POST_META_EXIT_G=1;
				$POST_META_EXIT_ID=snp_get_option('exit_popup');
				if($POST_META_EXIT_ID=='disabled')
				{
					$POST_META_EXIT_TITLE='Disabled';
				}
				else
				{
					$POST_META_EXIT_TITLE=get_the_title(str_replace('ab_','',$POST_META_EXIT_ID));
				}
			}
			else
			{
				$POST_META_EXIT_ID=$POST_META_EXIT[0];
				$POST_META_EXIT_TITLE=get_the_title(str_replace('ab_','',$POST_META_EXIT[0]));
			}
			echo '<img style="width: 16px; height: 16px;" src="'. SNP_NHP_OPTIONS_URL . 'img/ico_welcome_settings.png" />';
			if($POST_META_WELCOME_G==1)
			{				
				echo 'Global ('.$POST_META_WELCOME_TITLE.')';
			}
			else
			{
				echo ''.$POST_META_WELCOME_TITLE.'';
			}
			echo '<br />';
			echo '<img style="width: 16px; height: 16px;" src="'. SNP_NHP_OPTIONS_URL . 'img/ico_exit_settings.png" />';
			if($POST_META_EXIT_G==1)
			{				
				echo 'Global ('.$POST_META_EXIT_TITLE.')';
			}
			else
			{
				echo ''.$POST_META_EXIT_TITLE.'';
			}
			//echo $SNP_THEMES[$POPUP_THEME[0]['theme']]['NAME'];
		}
	}
	    
	function snp_register_tinymce_plugin($plugin_array)
	{
	    $plugin_array['snp_button'] = SNP_NHP_OPTIONS_URL. 'js/snp_button.js';
	    return $plugin_array;
	}

	function snp_add_tinymce_button($buttons)
	{
	    $buttons[] = "snp_button";
	    return $buttons;
	}
	
	function snp_ajax_insert_shortcode()
	{
	    require_once SNP_DIR_PATH . '/include/snp_insert_shortcode.php';
	    die('');
	}
	
	function snp_ajax_disable_affiliate_message()
	{
	    global $SNP_NHP_Options;
	    $SNP_NHP_Options->set('disable_affiliate_message', 1);
	    echo '1';
	    die('');
	}
	
	function snp_setup_framework_options()
	{
		register_post_type('snp_popups', array(
			'label' => 'Ninja Popups',
			'labels' => array(
				'name' => 'Ninja Popups',
				'menu_name' => 'Ninja Popups',
				'singular_name' => 'Popup',
				'add_new' => 'Add New Popup',
				'all_items' => 'Popups',
				'add_new_item' => 'Add New Popup',
				'edit_item' => 'Edit Popup',
				'new_item' => 'New Popup',
				'view_item' => 'View Popup',
				'search_items' => 'Search Popups',
				'not_found' => 'No popups found',
				'not_found_in_trash' => 'No popups found in Trash'
			),
			'hierarchical' => false,
			'public' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'show_in_menu' => true,
			'capability_type' => 'page',
			'supports' => array('title', 'editor'),
			'menu_position' => 207,
		    	'menu_icon'=> ''
		));
		register_post_type('snp_ab', array(
			'label' => 'A/B Testing',
			'labels' => array(
				'name' => 'A/B Testing',
				'menu_name' => 'A/B Testing',
				'singular_name' => 'A/B Testing',
				'add_new' => 'Add New',
				'all_items' => 'A/B Testing',
				'add_new_item' => 'Add New',
				'edit_item' => 'Edit',
				'new_item' => 'New',
				'view_item' => 'View',
				'search_items' => 'Search',
				'not_found' => 'Not found',
				'not_found_in_trash' => 'Not found in Trash'
			),
			'hierarchical' => false,
			'public' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'show_in_menu' => 'edit.php?post_type=snp_popups',
			'capability_type' => 'page',
			'supports' => array('title')
		));
		$args = array();
		$args['dev_mode'] = false;
		$args['intro_text'] = __('<p></p>', 'nhp-opts');
		$args['share_icons']['facebook'] = array(
			'link' => 'https://www.facebook.com/arscode',
			'title' => 'Find us on Facebook',
			'img' => SNP_NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_320_facebook.png'
		);
		$args['show_import_export'] = false;
		$args['opt_name'] = SNP_OPTIONS;
		$args['page_type'] = 'submenu';
		$args['page_parent'] = 'edit.php?post_type=snp_popups';
		$args['menu_title'] = __('Settings', 'nhp-opts');
		$args['page_title'] = __('Ninja Popups', 'nhp-opts');
		$args['page_slug'] = 'snp_opt';
		add_action('wp_ajax_nopriv_snp_popup_stats', 'snp_popup_stats');
		add_action('wp_ajax_snp_popup_stats', 'snp_popup_stats');
		add_action('wp_ajax_nopriv_snp_popup_submit', 'snp_popup_submit');
		add_action('wp_ajax_snp_popup_submit', 'snp_popup_submit');
		wp_enqueue_script('jquery');
		if (is_admin())
		{
			snp_init();
			//add_submenu_page( 'admin.php?page=snp_opt', 'Preview', 'Preview', 'manage_options', 'snp_preview', 'snp_page_preview' );
			add_filter("mce_external_plugins", "snp_register_tinymce_plugin"); 
			add_filter('mce_buttons', 'snp_add_tinymce_button');
			add_filter('manage_edit-snp_popups_columns', 'snp_add_columns');
			add_filter('manage_edit-snp_ab_columns', 'snp_ab_add_columns');
			add_action('manage_snp_popups_posts_custom_column', 'snp_manage_columns', 10, 2);
			add_action('manage_snp_ab_posts_custom_column', 'snp_manage_columns', 10, 2);
			if (!snp_get_option('disable_np_columns'))
			{
				add_filter('manage_edit-post_columns', 'snp_add_columns_posts');
				add_filter('manage_edit-page_columns', 'snp_add_columns_posts');
				add_action('manage_posts_custom_column', 'snp_manage_columns_posts', 10, 2);
				add_action('manage_page_posts_custom_column', 'snp_manage_columns_posts', 10, 2);
			}
			add_action('wp_ajax_snp_preview_popup', 'snp_preview_popup');
			add_action('wp_ajax_snp_insert_shortcode', 'snp_ajax_insert_shortcode');
			add_action('wp_ajax_snp_ml_list', 'snp_ml_list');
			add_action('wp_ajax_snp_popup_fields', 'snp_popup_fields');
			add_action('wp_ajax_snp_popup_colors', 'snp_popup_colors');
			add_action('wp_ajax_snp_popup_types', 'snp_popup_types');
			add_action('wp_ajax_snp_disable_affiliate_message', 'snp_ajax_disable_affiliate_message');
			add_action('admin_head-post-new.php', 'snp_posttype_admin_css');
			add_action('admin_head-post.php', 'snp_posttype_admin_css');
			add_action('admin_head-edit.php', 'snp_posttype_admin_css');
			$Popups = snp_get_popups();
			$ABTesting = snp_get_ab();
			$customfields[] = array(
				'id' => 'snp-cf-gsp',
				'post_type' => array('snp_ab'),
				'title' => __('Popups', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'forms',
						'type' => 'multi_checkbox',
						'title' => __('Select', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'options' => $Popups
					),
				)
			);
			$Popups['disabled'] = 'Disabled';
			$Popups=(array)$Popups + (array)$ABTesting;		
			$sections = array();
			global $FB_Locales;
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_gen_settings.png',
				'title' => __('General Settings', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'enable',
						'type' => 'select',
						'title' => __('Enable Plugin', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'enabled',
						'options' => array(
							'enabled' => 'Enabled',
							'disabled' => 'Disabled',
						)
					),
					array(
						'id' => 'enable_mobile',
						'type' => 'select',
						'title' => __('Enable Plugin on Mobile Devices', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'enabled',
						'options' => array(
							'enabled' => 'Enabled',
							'disabled' => 'Disabled',
						)
					),
					array(
						'id' => 'enable_analytics_events',
						'type' => 'select',
						'title' => __('Enable Google Analytics Event Tracking', 'nhp-opts'),
						'desc' => __('<b>Google Universal Analytics</b> should be installed on the site.', 'nhp-opts'),
						'std' => 'no',
						'options' => array(
							'no' => 'No',
							'yes' => 'Yes',
						)	
					),
				)
			);
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_welcome_settings.png',
				'title' => __('Welcome', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'welcome_popup',
						'type' => 'select',
						'title' => __('Default Welcome Popup', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'disabled',
						'options' => $Popups,
					),
					array(
						'id' => 'welcome_display_in',
						'type' => 'multi_checkbox',
						'title' => __('Display in:', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => array('home' => 1, 'pages' => 1, 'posts' => 1, 'others' => 1),
						'options' => array(
							'home' => 'Home',
							'pages' => 'Pages',
							'posts' => 'Posts',
							'others' => 'Categories, Archive and other'
						)
					),
					array(
						'id' => 'welcome_disable_for_logged',
						'type' => 'checkbox',
						'title' => __('Disable for logged users', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
				)
			);
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_exit_settings.png',
				'title' => __('Exit', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'exit_popup',
						'type' => 'select',
						'title' => __('Default Exit Popup', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'disabled',
						'options' => $Popups,
					),
					array(
						'id' => 'exit_display_in',
						'type' => 'multi_checkbox',
						'title' => __('Display in:', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => array('home' => 1, 'pages' => 1, 'posts' => 1, 'others' => 1),
						'options' => array(
							'home' => 'Home',
							'pages' => 'Pages',
							'posts' => 'Posts',
							'others' => 'Categories, Archive and other'
						)
					),
					array(
						'id' => 'use_in',
						'type' => 'multi_checkbox',
						'title' => __('Use popup external for links in:', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => array('the_content' => 1, 'the_excerpt' => 1, 'widget_text' => 1, 'comment_text' => 1),
						'options' => array(
							'the_content' => 'Content',
							'the_excerpt' => 'Excerpts',
							'widget_text' => 'Widgets Text',
							'comment_text' => 'Comments',
							'all' => 'All links (Menu, sidebars, footer, etc.)'
						)
					),
					array(
						'id' => 'exit_excluded_urls',
						'type' => 'multi_text',
						'title' => __('Excluded URLs', 'nhp-opts'),
						'desc' => __('Add external URLs for which you want to disable/skip exit popup.', 'nhp-opts'),
					),
					array(
						'id' => 'exit_disable_for_logged',
						'type' => 'checkbox',
						'title' => __('Disable for logged users', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
				)
			);
			$ml_managers = array(
				'0' => array('name' => '--'),
				'email' => array('name' => 'Send Optins to E-mail', 'fieldsgroup' => 'fg_email'),
				'aweber' => array('name' => 'AWeber', 'fieldsgroup' => 'fg_aweber'),
				'mailchimp' => array('name' => 'MailChimp', 'fieldsgroup' => 'fg_mailchimp'),
				'getresponse' => array('name' => 'GetResponse', 'fieldsgroup' => 'fg_getresponse'),
				'campaignmonitor' => array('name' => 'CampaignMonitor', 'fieldsgroup' => 'fg_campaignmonitor'),
				'icontact' => array('name' => 'iContact', 'fieldsgroup' => 'fg_icontact'),
				'constantcontact' => array('name' => 'Constant Contact', 'fieldsgroup' => 'fg_constantcontact'),
				'madmimi' => array('name' => 'Mad Mimi', 'fieldsgroup' => 'fg_madmimi'),
				'infusionsoft' => array('name' => 'Infusionsoft', 'fieldsgroup' => 'fg_inf'),
				'directmail' => array('name' => 'Direct Mail for OS X', 'fieldsgroup' => 'fg_directmail'),
				'sendy' => array('name' => 'Sendy', 'fieldsgroup' => 'fg_sendy'),
				'csv' => array('name' => 'Store in CSV File', 'fieldsgroup' => 'fg_csv'),
				'html' => array('name' => 'HTML Form', 'fieldsgroup' => 'fg_html'),
			);
			if(class_exists('WYSIJA'))
			{
				$ml_managers['wysija'] = array('name' => 'Wysija', 'fieldsgroup' => 'fg_wysija');
			}
			if (defined('MYMAIL_VERSION') && version_compare(MYMAIL_VERSION, '1.3.1.2') >= 0)
			{
				$ml_managers['mymail'] = array('name' => 'MyMail', 'fieldsgroup' => 'fg_mymail');
			}
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_ml_settings.png',
				'title' => __('Mailing List Manager', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'ml_manager',
						'type' => 'select_show_fieldsgroup',
						'title' => __('Mailing List Manager', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'email',
						'options' => $ml_managers
					),
					array(
						'id' => 'ml_aw_auth',
						'type' => 'aweber_auth',
						'class' => 'fg_ml_manager fg_aweber large-text',
						'title' => __('AWeber Connection', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_aw_lists',
						'type' => 'aweber_lists',
						'class' => 'fg_ml_manager fg_aweber',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_htmlform_exp',
						'type' => 'htmlform_exp',
						'class' => 'fg_ml_manager fg_html',
						'title' => __('HTML Opt-in Code:', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('Enter your html opt-in code.', 'nhp-opts'),
						'std' => '',
					),
				    
					array(
						'id' => 'ml_html_url',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_html regular-text',
						'title' => __('From URL', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_html_blank',
						'type' => 'checkbox',
						'class' => 'fg_ml_manager fg_html',
						'title' => __('Submit From to New Window', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_html_name',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_html regular-text',
						'title' => __('Name Input Name', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => 'name'
					),
					array(
						'id' => 'ml_html_email',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_html regular-text',
						'title' => __('E-mail Input Name', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => 'email'
					),
					array(
						'id' => 'ml_html_hidden',
						'type' => 'textarea',
						'class' => 'fg_ml_manager fg_html regular-text',
						'title' => __('Additional HTML Code:', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('Enter additional form HTML, like hidden inputs etc.', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_csv_file',
						'type' => 'csv_file',
						'class' => 'fg_ml_manager fg_csv regular-text',
						'title' => __('CSV File Name', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '',
					),
					array(
						'id' => 'ml_mc_apikey',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_mailchimp regular-text',
						'title' => __('MailChimp API Key', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('<a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key" target="_blank">Where can I find my API Key?</a>', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_mc_list',
						'type' => 'mailchimp_lists',
						'class' => 'fg_ml_manager fg_mailchimp regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_mc_double_optin',
						'type' => 'select',
						'class' => 'fg_ml_manager fg_mailchimp regular-text',
						'title' => __('Double Opt-in?', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => 0,
						'options'   =>	array(
						    0	=>  'No',
						    1	=>  'Yes'
						)
					),			    
					array(
						'id' => 'ml_gr_apikey',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_getresponse regular-text',
						'title' => __('GetResponse API Key', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('<a href="http://www.getresponse.com/learning-center/glossary/api-key.html" target="_blank">Where can I find my API Key?</a>', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_gr_list',
						'type' => 'getresponse_lists',
						'class' => 'fg_ml_manager fg_getresponse regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
					    'id'		 => 'ml_sendy_url',
					    'type'		 => 'text',
					    'class'		 => 'fg_ml_manager fg_sendy regular-text',
					    'title'		 => __('Sendy Url', 'nhp-opts'),
					    'sub_desc'	 => __('', 'nhp-opts'),
					    'desc'		 => '',
					    'std'		 => ''
					),
					array(
					    'id'		 => 'ml_sendy_list',
					    'type'		 => 'text',
					    'class'		 => 'fg_ml_manager fg_sendy regular-text',
					    'title'		 => __('Sendy List ID', 'nhp-opts'),
					    'sub_desc'	 => __('', 'nhp-opts'),
					    'desc'		 => __('This encrypted & hashed id can be found under View all lists section named ID', 'nhp-opts'),
					    'std'		 => ''
					),
					array(
					    'id'		 => 'ml_dm_form_id',
					    'type'		 => 'text',
					    'class'		 => 'fg_ml_manager fg_directmail regular-text',
					    'title'		 => __('Direct Mail Subscribe Form ID', 'nhp-opts'),
					    'sub_desc'	 => __('', 'nhp-opts'),
					    'desc'		 => __('<a href="http://directmailmac.com/support/article/327" target="_blank">Where do I find my form ID?</a>', 'nhp-opts'),
					    'std'		 => ''
					),
					array(
						'id' => 'ml_cm_clientid',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_campaignmonitor regular-text',
						'title' => __('CampaignMonitor Client ID', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('<a href="http://www.campaignmonitor.com/api/getting-started/#clientid" target="_blank">Where can I find my Client ID?</a>', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_cm_apikey',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_campaignmonitor regular-text',
						'title' => __('CampaignMonitor API Key', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('<a href="http://www.campaignmonitor.com/api/getting-started/#apikey" target="_blank">Where can I find my API Key?</a>', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_cm_list',
						'type' => 'campaignmonitor_lists',
						'class' => 'fg_ml_manager fg_campaignmonitor regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_ic_username',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_icontact regular-text',
						'title' => __('iContact Username', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_ic_addid',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_icontact regular-text',
						'title' => __('iContact App ID', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('<a href="http://developer.icontact.com/documentation/register-your-app/" target="_blank">Where can I get my App ID?</a>', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_ic_apppass',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_icontact regular-text',
						'title' => __('iContact App Password', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_ic_list',
						'type' => 'icontact_lists',
						'class' => 'fg_ml_manager fg_icontact regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_cc_username',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_constantcontact regular-text',
						'title' => __('Constant Contact Username', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_cc_pass',
						'type' => 'text',
						'input_type' => 'password',
						'class' => 'fg_ml_manager fg_constantcontact regular-text',
						'title' => __('Constant Contact Password', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_cc_list',
						'type' => 'constantcontact_lists',
						'class' => 'fg_ml_manager fg_constantcontact regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_email',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_email regular-text',
						'title' => __('E-mail Address', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_wy_list',
						'type' => 'wysija_lists',
						'class' => 'fg_ml_manager fg_wysija regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_mm_list',
						'type' => 'mymail_lists',
						'class' => 'fg_ml_manager fg_mymail regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
				    array(
						'id' => 'ml_madm_username',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_madmimi regular-text',
						'title' => __('Mad Mimi Username', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_madm_apikey',
						'type' => 'text',
						'input_type' => 'text',
						'class' => 'fg_ml_manager fg_madmimi regular-text',
						'title' => __('Mad Mimi API Key', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_madm_list',
						'type' => 'madmimi_lists',
						'class' => 'fg_ml_manager fg_madmimi regular-text',
						'title' => __('Default Mailing List', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_inf_subdomain',
						'type' => 'text',
						'class' => 'fg_ml_manager fg_inf regular-text',
						'title' => __('Infusionsoft subdomain', 'nhp-opts'),
						'desc' => __('.infusionsoft.com', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_inf_apikey',
						'type' => 'text',
						'input_type' => 'text',
						'class' => 'fg_ml_manager fg_inf regular-text',
						'title' => __('Infusionsoft API Key', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'ml_inf_list',
						'type' => 'infusionsoft_lists',
						'class' => 'fg_ml_manager fg_inf regular-text',
						'title' => __('Default Group', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
				)
			);
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_promote.png',
				'title' => __('Promote', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'promo_header',
						'type' => 'info',
						'title' => __('Earn with Envato Affiliate Program!', 'nhp-opts'),
						'desc' => __('<a href="http://codecanyon.net/make_money/affiliate_program" target="_blank">Click here for more info</a>', 'nhp-opts'),
					),
					array(
						'id' => 'PROMO_ON',
						'type' => 'checkbox',
						'title' => __('Promote Ninja Popups with Your Affiliate link?', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'PROMO_REF',
						'type' => 'text',
						'title' => __('Your Envato Username', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => ''
					),
					array(
						'id' => 'promo_img',
						'type' => 'info2',
						'desc' => __('<p style="text-align: center;"><img src="' . SNP_URL . '/admin/img/promote.png" /></p>', 'nhp-opts'),
						'std' => ''
					),
				)
			);
			$sections[] = array(
				'icon' => SNP_NHP_OPTIONS_URL . 'img/ico_adv_settings.png',
				'title' => __('Advanced Settings', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'class_popup',
						'type' => 'text',
						'title' => __('CSS class used in links', 'nhp-opts'),
						'desc' => __('(default: snppopup)', 'nhp-opts'),
						'std' => 'snppopup'
					),
					array(
						'id' => 'class_no_popup',
						'type' => 'text',
						'title' => __('CSS class used in links for disable popup', 'nhp-opts'),
						'desc' => __('(default: nosnppopup)', 'nhp-opts'),
						'std' => 'nosnppopup'
					),
					array(
						'id' => 'fb_locale',
						'type' => 'select',
						'title' => __('Facebook Locale', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'en_GB',
						'options' => $FB_Locales
					),
					array(
						'id' => 'disable_selftest',
						'type' => 'checkbox',
						'title' => __('Disable Self Test Warning', 'nhp-opts'),
					),
					array(
						'id' => 'disable_affiliate_message',
						'type' => 'checkbox',
						'title' => __('Disable Afilliate Program Notice', 'nhp-opts'),
					),
					array(
						'id' => 'disable_np_columns',
						'type' => 'checkbox',
						'title' => __('Don\'t show Ninja Popups column in Posts/Pages Lists', 'nhp-opts'),
					),
					array(
						'id' => 'run_hook',
						'type' => 'select',
						'title' => __('Plugin Run Hook', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'get_header',
						'options' => array(
							'wp' => 'wp',
							'get_header' => 'get_header',
						)
					),
					array(
						'id' => 'conflict_header',
						'type' => 'info',
						'title' => 'JavaScripts',
						'desc' => __('If Theme or another Plugin is loading any of these scripts, you can turn it off to avoid conflict.
					', 'nhp-opts'),
					),
					array(
						'id' => 'js_disable_fancybox',
						'type' => 'checkbox',
						'title' => __('Disable Fancybox 2 Loading', 'nhp-opts'),
						'sub_desc' => 'jquery.fancybox.pack.js',
					),
					array(
						'id' => 'js_disable_jq_cookie',
						'type' => 'checkbox',
						'title' => __('Disable jQuery Cookie', 'nhp-opts'),
						'sub_desc' => 'jquery.ck.js<br />(<a href="https://github.com/carhartl/jquery-cookie" target="_blank">https://github.com/carhartl/jquery-cookie</a>)',
					),
					array(
						'id' => 'js_disable_jq_placeholder',
						'type' => 'checkbox',
						'title' => __('Disable jQuery PlaceHolder', 'nhp-opts'),
						'sub_desc' => 'jquery.placeholder.js',
					),
					array(
						'id' => 'js_disable_fb',
						'type' => 'checkbox',
						'title' => __('Disable Facebook JS Loading', 'nhp-opts'),
						'sub_desc' => 'https://connect.facebook.net/en_GB/all.js#xfbml=1',
					),
					array(
						'id' => 'js_disable_gp',
						'type' => 'checkbox',
						'title' => __('Disable Google Plus JS Loading', 'nhp-opts'),
						'sub_desc' => 'https://apis.google.com/js/plusone.js',
					),
					array(
						'id' => 'js_disable_tw',
						'type' => 'checkbox',
						'title' => __('Disable Twitter JS Loading', 'nhp-opts'),
						'sub_desc' => 'https://platform.twitter.com/widgets.js',
					),
					array(
						'id' => 'js_disable_pi',
						'type' => 'checkbox',
						'title' => __('Disable Pinterest JS Loading', 'nhp-opts'),
						'sub_desc' => 'https://assets.pinterest.com/js/pinit.js',
					),
					array(
						'id' => 'js_disable_li',
						'type' => 'checkbox',
						'title' => __('Disable LinkedIn JS Loading', 'nhp-opts'),
						'sub_desc' => 'https://platform.linkedin.com/in.js',
					),
				)
			);
			$Popups['global'] = 'Use global settings';
			$Popups['disabled'] = 'Disabled';
			$all_post_type=snp_get_post_types();
			$customfields[] = array(
				'id' => 'snp-cf-gsp',
				'post_type' => $all_post_type,
				'title' => __('Ninja Popups', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'p_welcome_popup',
						'type' => 'select',
						'title' => __('Welcome', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'global',
						'options' => $Popups
					),
					array(
						'id' => 'p_exit_popup',
						'type' => 'select',
						'title' => __('Exit', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'global',
						'options' => $Popups
					),
				)
			);

			// POPUP FILEDS
			$customfields[] = array(
				'id' => 'snp-cf-lf',
				'post_type' => array('snp_popups'),
				'title' => __('Look & Feel', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'theme',
						'type' => 'select_theme',
						'title' => __('Theme', 'nhp-opts'),
						'desc' => __('Please save content data before change.', 'nhp-opts'),
						'std' => 'theme1',
						'options' => snp_get_themes_list()
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-cnt',
				'post_type' => array('snp_popups'),
				'title' => __('Content', 'nhp-opts'),
				'fields' => array(
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-preview',
				'context' => 'side',
				'post_type' => array('snp_popups'),
				'title' => __('Preview', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'popup_preview_popup',
						'type' => 'preview_popup',
						'title' => __('Preview', 'nhp-opts'),
						'disable_title' => 1,
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-overlay',
				'post_type' => array('snp_popups'),
				'title' => __('Overlay', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'popup_overlay',
						'type' => 'select_show_fieldsgroup',
						'title' => __('Overlay', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'default',
						'options' => array(
							'default' => array('name' => 'Default (60% opacity)', 'fieldsgroup' => 'fg_overlay_default'),
							'disabled' => array('name' => 'Disabled', 'fieldsgroup' => 'fg_overlay_disabled'),
							'image' => array('name' => 'Image', 'fieldsgroup' => 'fg_overlay_image'),
						)
					),
					array(
						'id' => 'overlay_image',
						'type' => 'upload',
						'class' => 'fg_overlay fg_overlay_image regular-text',
						'title' => __('Overlay Image', 'nhp-opts')
					)
				)
			);


			$customfields[] = array(
				'id' => 'snp-cf-gs',
				'post_type' => array('snp_popups'),
				'title' => __('Display Settings', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'start_date',
						'type' => 'date',
						'title' => __('Start Date', 'nhp-opts'),
						'sub_desc' => __('Leave empty to enable popup all the time.', 'nhp-opts')
					),
					array(
						'id' => 'end_date',
						'type' => 'date',
						'title' => __('End Date', 'nhp-opts'),
						'sub_desc' => __('Leave empty to enable popup all the time.', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-op',
				'post_type' => array('snp_popups'),
				'title' => __('Welcome Settings', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'open',
						'type' => 'select_show_fieldsgroup',
						'title' => __('When Popup should appear?', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'default',
						'options' => array(
							'load' => array('name' => 'On page load', 'fieldsgroup' => 'open_load'),
							'inactivity' => array('name' => 'After X seconds of inactivity', 'fieldsgroup' => 'open_inactivity'),
							'scroll' => array('name' => 'When user scroll page', 'fieldsgroup' => 'open_scroll')
						)
					),
					array(
						'id' => 'open_inactivity',
						'type' => 'text',
						'class' => 'fg_open open_inactivity',
						'title' => __('Open after X seconds of inactivity', 'nhp-opts'),
						'desc' => __('', 'nhp-opts')
					),
					array(
						'id' => 'open_after',
						'type' => 'text',
						'class' => 'fg_open open_load',
						'title' => __('Open Delay', 'nhp-opts'),
						'desc' => __('(in seconds)', 'nhp-opts')
					),
					array(
						'id' => 'open_scroll',
						'type' => 'slider',
						'class' => 'fg_open open_scroll mini',
						'title' => __('Open when user scroll % of page', 'nhp-opts'),
						'desc' => __('% (100% - end of page)', 'nhp-opts'),
						'std' => '10',
						'min' => '0',
						'max' => '100',
						'step' => '1'  
					),		
					/*array(
						'id' => 'show_welcome',
						'type' => 'select_hide_below',
						'title' => __('Show Exit Popup', 'nhp-opts'),
						'sub_desc' => __('Only for exit popups.', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 2,
						'options' => array(
							2 => array('name' => 'When user try to leave page (need JS Alert)', 'allow' => 'true'),
							3 => array('name' => 'When mouse leaves the browser viewport (Exit Intent)', 'allow' => 'false'),	
							1 => array('name' => 'When user click external link', 'allow' => 'false'),
						)
					),
					array(
						'id' => 'open_after',
						'type' => 'text',
						'class' => 'mini',
						'title' => __('Open Popup Delay', 'nhp-opts'),
						'desc' => __('(in seconds)', 'nhp-opts')
					),*/
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-ex',
				'post_type' => array('snp_popups'),
				'title' => __('Exit Settings', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_on_exit',
						'type' => 'select_hide_below',
						'title' => __('Show Exit Popup', 'nhp-opts'),
						'sub_desc' => __('Only for exit popups.', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 2,
						'options' => array(
							2 => array('name' => 'When user try to leave page (need JS Alert)', 'allow' => 'true'),
							3 => array('name' => 'When mouse leaves the browser viewport (Exit Intent)', 'allow' => 'false'),	
							1 => array('name' => 'When user click external link', 'allow' => 'false'),
						)
					),
					array(
						'id' => 'exit_js_alert_text',
						'type' => 'textarea',
						'title' => __('JavaScript Alert Box Text', 'nhp-opts'),
						'sub_desc' => __('Only for exit popups.', 'nhp-opts'),
						'desc' => __('<p style="text-align: center;"><img src="' . SNP_URL . '/admin/img/js_alert.png" /></p>', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-cb',
				'post_type' => array('snp_popups'),
				'title' => __('Close Button & Delay', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'cb_close_after',
						'type' => 'text',
						'class' => 'mini',
						'title' => __('Auto Close Popup', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('(in seconds)', 'nhp-opts')
					),
					array(
						'id' => 'show_cb_button',
						'type' => 'select',
						'title' => __('Show Close Link and Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'cb_text',
						'type' => 'text',
						'title' => __('Close Link Text', 'nhp-opts'),
						'std' => __('Close this popup', 'nhp-opts'),
						'desc' => __('', 'nhp-opts')
					),
					array(
						'id' => 'cb_img',
						'type' => 'radio_img',
						'title' => __('Close Button', 'nhp-opts'),
						'sub_desc' => '',
						'desc' => '',
						'options' => array(
							'close_default' => array('title' => '', 'img' => SNP_URL . 'img/close_default.png'),
							'close_1' => array('title' => '', 'img' => SNP_URL . 'img/close_1.png'),
							'close_2' => array('title' => '', 'img' => SNP_URL . 'img/close_2.png'),
							'close_3' => array('title' => '', 'img' => SNP_URL . 'img/close_3.png'),
							'close_4' => array('title' => '', 'img' => SNP_URL . 'img/close_4.png'),
							'close_5' => array('title' => '', 'img' => SNP_URL . 'img/close_5.png'),
							'close_6' => array('title' => '', 'img' => SNP_URL . 'img/close_6.png'),
						),
						'std' => 'close_default'
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-cookies',
				'post_type' => array('snp_popups'),
				'title' => __('Cookies', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'cookie_conversion',
						'type' => 'text',
						'class' => 'mini',
						'title' => __('Cookie Time on Conversion (Opt-in/Share)', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'std' => '30',
						'desc' => __('days (0 for cookie just for current session, -2 to disable cookie and open popup every time)<br />When user opt-in/share, how long should it be before the popup is shown again?', 'nhp-opts')
					),
					array(
						'id' => 'cookie_close',
						'type' => 'text',
						'class' => 'mini',
						'title' => __('Cookie Time on Close', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'), 
						'std' => '0',
						'desc' => __('days (0 for cookie just for current session, -2 to disable cookie and open popup every time)<br />When user click close button, how long should it be before the popup is shown again?', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-redirect',
				'post_type' => array('snp_popups'),
				'title' => __('Redirect', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'optin_redirect',
						'type' => 'select',
						'title' => __('Redirect after opt-in/like', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'no',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'optin_redirect_url',
						'type' => 'text',
						'title' => __('Redirect URL', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-fb',
				'post_type' => array('snp_popups'),
				'title' => __('Facebook', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_like_button',
						'type' => 'select',
						'title' => __('Show Like Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'fb_url',
						'type' => 'text',
						'title' => __('URL to Like', 'nhp-opts'),
						'sub_desc' => __('Leave empty to use current URL.', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-tw',
				'post_type' => array('snp_popups'),
				'title' => __('Twitter', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_tweet_button',
						'type' => 'select',
						'title' => __('Show Tweet Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'tweet_url',
						'type' => 'text',
						'title' => __('URL to Tweet', 'nhp-opts'),
						'sub_desc' => __('Leave empty to use current URL.', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
					array(
						'id' => 'tweet_text',
						'type' => 'textarea',
						'title' => __('Tweet Text', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('', 'nhp-opts')
					),
					array(
						'id' => 'show_follow_button',
						'type' => 'select',
						'title' => __('Show Follow Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'no',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'twitter_username',
						'type' => 'text',
						'title' => __('Twitter Username', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-gp',
				'post_type' => array('snp_popups'),
				'title' => __('Google Plus', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_gp_button',
						'type' => 'select',
						'title' => __('Show +1 Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'gp_url',
						'type' => 'text',
						'title' => __('URL to +1', 'nhp-opts'),
						'sub_desc' => __('Leave empty to use current URL.', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-li',
				'post_type' => array('snp_popups'),
				'title' => __('LinkedIn', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_li_button',
						'type' => 'select',
						'title' => __('Show InShare Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'li_url',
						'type' => 'text',
						'title' => __('URL to share', 'nhp-opts'),
						'sub_desc' => __('Leave empty to use current URL.', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-pi',
				'post_type' => array('snp_popups'),
				'title' => __('Pinterest', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'show_pi_button',
						'type' => 'select',
						'title' => __('Show Pin It Button', 'nhp-opts'),
						'desc' => __('', 'nhp-opts'),
						'std' => 'yes',
						'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
						)
					),
					array(
						'id' => 'pi_url',
						'type' => 'text',
						'title' => __('URL of the page to pin', 'nhp-opts'),
						'sub_desc' => __('Leave empty to use current URL.', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
					array(
						'id' => 'pi_image_url',
						'type' => 'upload',
						'title' => __('URL of the image to pin', 'nhp-opts'),
						'desc' => __('(start with http://)', 'nhp-opts')
					),
					array(
						'id' => 'pi_description',
						'type' => 'textarea',
						'title' => __('Description ', 'nhp-opts'),
						'sub_desc' => __('', 'nhp-opts'),
						'desc' => __('', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-customcss',
				'post_type' => array('snp_popups'),
				'title' => __('Custom CSS', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'nhp-opts')
					),
				)
			);
			$customfields[] = array(
				'id' => 'snp-cf-customjs',
				'post_type' => array('snp_popups'),
				'title' => __('Custom JS', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'custom_js',
						'type' => 'textarea',
						'title' => __('Custom JS', 'nhp-opts')
					),
				)
			);
			/*==*/
			$ml_fields=array();
			if (snp_get_option('ml_manager') == 'email')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_email',
				    'type' => 'text',
				    'class' => 'fg_ml_manager fg_email regular-text',
				    'title' => __('E-mail Address', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'aweber')
			{
			    $ml_fields[]=array(	
				    'id' => 'ml_aw_lists',
				    'type' => 'aweber_lists',
				    'class' => 'fg_ml_manager fg_aweber',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );	
			}
			elseif (snp_get_option('ml_manager') == 'mailchimp')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_mc_list',
				    'type' => 'mailchimp_lists',
				    'class' => 'fg_ml_manager fg_mailchimp regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'getresponse')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_gr_list',
				    'type' => 'getresponse_lists',
				    'class' => 'fg_ml_manager fg_getresponse regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'campaignmonitor')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_cm_list',
				    'type' => 'campaignmonitor_lists',
				    'class' => 'fg_ml_manager fg_campaignmonitor regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'icontact')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_ic_list',
				    'type' => 'icontact_lists',
				    'class' => 'fg_ml_manager fg_icontact regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'constantcontact')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_cc_list',
				    'type' => 'constantcontact_lists',
				    'class' => 'fg_ml_manager fg_constantcontact regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'wysija')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_wy_list',
				    'type' => 'wysija_lists',
				    'class' => 'fg_ml_manager fg_wysija regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'mymail')
			{
			    $ml_fields[]=array(
				    'id' => 'ml_mm_list',
				    'type' => 'mymail_lists',
				    'class' => 'fg_ml_manager fg_mymail regular-text',
				    'title' => __('Select Mailing List', 'nhp-opts'),
				    'sub_desc' => __('', 'nhp-opts'),
				    'std' => '',
				    'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'madmimi')
			{
			    $ml_fields[]=array(
				'id' => 'ml_madm_list',
				'type' => 'madmimi_lists',
				'class' => 'fg_ml_manager fg_madmimi regular-text',
				'title' => __('Select Mailing List', 'nhp-opts'),
				'sub_desc' => __('', 'nhp-opts'),
				'std' => '',
				'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'infusionsoft')
			{
			    $ml_fields[]=array(
				'id' => 'ml_inf_list',
				'type' => 'infusionsoft_lists',
				'class' => 'fg_ml_manager fg_inf regular-text',
				'title' => __('Select Group', 'nhp-opts'),
				'sub_desc' => __('', 'nhp-opts'),
				'std' => '',
				'meta'  => 1
			    );
			}
			elseif (snp_get_option('ml_manager') == 'sendy')
			{
			    $ml_fields[]=array(
				'id'		 => 'ml_sendy_list',
				'type'		 => 'text',
				'class'		 => 'fg_ml_manager fg_sendy regular-text',
				'title'		 => __('Sendy List ID', 'nhp-opts'),
				'sub_desc'	 => __('', 'nhp-opts'),
				'desc'		 => __('This encrypted & hashed id can be found under View all lists section named ID', 'nhp-opts'),
				'std'		 => '',
				'meta'  => 1
			    );
			}
			if(count($ml_fields)>0)
			{
			    $customfields[] = array(
				    'id' => 'snp-cf-ml',
				    'post_type' => array('snp_popups'),
				    'title' => __('Mailing List', 'nhp-opts'),
				    'fields' => $ml_fields
			    );
			}
			 
			 /*==*/
			global $SNP_NHP_Options;
			$tabs = array();
			$SNP_NHP_Options = new SNP_NHP_Options($sections, $args, $tabs, $customfields, array(), array());
		}
	}

	function snp_selftest()
	{
	    if(snp_get_option('disable_selftest')==1)
	    {
		return;
	    }
	    $error='';
	    if(WP_DEBUG==true)
	    {
		$error.='<b>WP_DEBUG is Enabled!</b><br />Should be Disabled on live website.<br />';
	    }
	    if(!function_exists('curl_init'))
	    {
		$error.='<b>Missing CURL extension!</b><br />You\'ll need to contact your hosting provider and ask them to enable CURL for PHP.<br />';
	    }
	    if(ini_get('safe_mode'))
	    {
		$error.='<b>Safe Mode is ON!</b><br />It can have effects on integrations with autoresponders.<br />';
	    }
	    global $wp_version;
	    if (version_compare($wp_version, '3.5', '<=')) 
	    {
		$error.='<b>Old WordPress version!</b><br />We highly recommend upgrade to the latest version.<br />';
	    }
	    if($error)
	    {
		echo "<div style=\"padding: 20px; background-color: #ef9999; margin: 40px; border: 1px solid #cc0000; \"><b>Ninja Popups WARNING!</b><br/>".$error."<br />You can disable this message in advanced section in plugin settings.</div>";
	    }
	}
	
	add_action('admin_notices', 'snp_selftest');

	function snp_affiliate_message()
	{
	    if(snp_get_option('disable_affiliate_message')==1)
	    {
		return;
	    }
	    echo "<div id=\"snp_afm\" style=\"padding: 5px 20px 20px 20px; background-color: #c0f796; margin: 40px; border: 1px solid #7AD03A; \">";
	    echo "<h2>Earn with Ninja Popups and Envato Affiliate Program!</h2><br/>";
	    echo '<a class="button button-primary" href="edit.php?post_type=snp_popups&page=snp_opt&tab=4">Tell me more</a> ';
	    echo '<a class="button" id="snp_afm_d" href="#">Dismiss this notice</a>';
	    echo "</div>";
	    echo "<script>jQuery(document).ready(function($){ $('#snp_afm_d').click(function(){ jQuery.ajax({type: 'POST',  url: 'admin-ajax.php', data: {  action: 'snp_disable_affiliate_message'}}); $('#snp_afm').hide(); return false;});});</script>";
	    
	}
	add_action('admin_notices', 'snp_affiliate_message');


	function snp_run_camp($POST_META)
	{
		global $snp_ignore_cookies, $wp_scripts;
		$snp_ignore_cookies = true;
		foreach ( $wp_scripts->registered as $k => $v )
		{
		    //print_r($v);
		    if(!in_array($v->handle,array('jquery','jquery-core','jquery-ui-core','jquery-migrate','js-getmoreoptins','jquery-np-cookie','jquery-np-placeholder')))
		    {
			wp_deregister_script($v->handle);
		    }
		}
		snp_run_popup($POST_META['snp_camp_popup'], $POST_META['snp_camp_use']);
		echo '<!DOCTYPE html>';
		echo '<html><head>';
		echo '<style> body, html { height: 100%; width: 100%;} ';
		echo 'body { display: block;margin: 0;padding: 0;} </style>';
		snp_init();
		//wp_head();
		wp_enqueue_scripts();
		wp_print_styles();
		print_admin_styles();
		wp_print_head_scripts();
		echo '</head><body>';
		echo '<iframe src="' . $POST_META['snp_camp_dest_url'] . '" style="width: 100%; height: 100%; border: 0; padding: 0; margin: 0; line-height: 0; display: block;"></iframe>';
		snp_footer();
		wp_print_footer_scripts();
		echo '</body></html>';
		die('');
	}
	function snp_page_preview()
	{
	    global $snp_ignore_cookies, $PREVIEW_POPUP_META;
	    global $snp_ignore_cookies;
	    $snp_ignore_cookies = true;
	    snp_run_popup($POST_META['snp_camp_popup'], $POST_META['snp_camp_use']);
	    snp_init();
	    if (!empty($_GET['action']) && $_GET['action']=='snp_preview_popup'	&& !$_GET['popup_ID'])
	    {
		    die('-1');
	    }
	    elseif (isset($_GET['popup_ID']))
	    {
		    $POST_META['snp_camp_popup'] = $_GET['popup_ID'];
	    }
	    if (count($_POST))
	    {
		    $PREVIEW_POPUP_META = array();
		    foreach ((array) $_POST['snp'] as $k => $v)
		    {
			if (strpos($k, 'cf') !== FALSE)
			{
			    $elements = array();
			    foreach ($v['fields'] as $k2 => $v2)
			    {
				if ($v2 != 'RAND')
				{
				    $elements[]	 = $v[$v2];
				}
			    }
			    $PREVIEW_POPUP_META['snp_' . $k] = $elements;
			}
			else
			{
			    $PREVIEW_POPUP_META['snp_' . $k] = $v;
			}
		    }
		    $POST_META['snp_camp_popup'] = -1;
	    }
	    $POST_META['snp_camp_dest_url'] = site_url() . '/wp-admin/index.php';
	    $POST_META['snp_camp_use'] = 'welcome';
	    add_action('wp_enqueue_scripts', 'snp_enqueue_social_script');
	}
	function snp_preview_popup()
	{
		global $snp_ignore_cookies, $PREVIEW_POPUP_META;
		$snp_ignore_cookies = true;
		if (!empty($_GET['action']) && $_GET['action']=='snp_preview_popup'	&& !$_GET['popup_ID'])
		{
			die('-1');
		}
		elseif (isset($_GET['popup_ID']))
		{
			$POST_META['snp_camp_popup'] = $_GET['popup_ID'];
		}
		if (count($_POST))
		{
			$PREVIEW_POPUP_META = array();
			foreach ((array) $_POST['snp'] as $k => $v)
			{
			    if (strpos($k, 'cf') !== FALSE)
			    {
				$elements = array();
				foreach ($v['fields'] as $k2 => $v2)
				{
				    if ($v2 != 'RAND')
				    {
					$elements[]	 = $v[$v2];
				    }
				}
				$PREVIEW_POPUP_META['snp_' . $k] = $elements;
			    }
			    else
			    {
				$PREVIEW_POPUP_META['snp_' . $k] = $v;
			    }
			}
			$POST_META['snp_camp_popup'] = -1;
		}
		$POST_META['snp_camp_dest_url'] = site_url() . '/wp-admin/index.php';
		$POST_META['snp_camp_use'] = 'welcome';
		add_action('wp_enqueue_scripts', 'snp_enqueue_social_script');
		snp_run_camp($POST_META);
	}

	
	/* END PREVIEW */
	function snp_activate()
	{
	    global $wpdb;
	    if (!get_option( "SNP_DB_VER" ) || version_compare(get_option( "SNP_DB_VER" ), SNP_DB_VER, '<'))
	    {
		$table_name = $wpdb->prefix . "snp_stats";
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			`date` date NOT NULL,
			`ID` bigint(20) NOT NULL,
			`AB_ID` bigint(20) NOT NULL,
			`imps` int(11) NOT NULL,
			`convs` int(11) NOT NULL,
			UNIQUE KEY `date_ID` (`date`,`ID`,`AB_ID`),
			KEY `ID` (`ID`),
			KEY `date` (`date`),
			KEY `AB_ID` (`AB_ID`)
		       );";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);
		add_option("SNP_DB_VER", SNP_DB_VER);
	    }
	}
	add_action ("plugins_loaded" ,'snp_activate');
	add_action("init", "snp_setup_framework_options");
	if (!is_admin())
	{
		if(snp_get_option('run_hook')=='wp')
		{
		    add_action('wp', 'snp_run');
		}
		else
		{
			add_action('get_header', 'snp_run');    
		}
	}

	function snp_icons()
	{
		?>
		<style type="text/css" media="screen">
			#menu-posts-snp_popups .wp-menu-image, #toplevel_page_snp_opt .wp-menu-image {
				background: url(<?php echo SNP_NHP_OPTIONS_URL; ?>img/star_menu.png) no-repeat 12px -32px !important;
			}
			#menu-posts-snp_popups:hover .wp-menu-image, #menu-posts-snp_popups.wp-has-current-submenu .wp-menu-image,
			#toplevel_page_snp_opt:hover .wp-menu-image, #toplevel_page_snp_opt.wp-has-current-submenu .wp-menu-image
			{
				background-position: 12px 0px !important;
			}
			#icon-edit.icon32-posts-snp_popups {background: url(<?php echo SNP_NHP_OPTIONS_URL; ?>img/star_32x32.png) no-repeat;}
		</style>
	<?php
}
add_action('admin_head', 'snp_icons');
function snp_stats()
{
    global $wpdb;
    echo '<div class="wrap">';
    $popup_ID = htmlspecialchars(addslashes($_REQUEST['popup_ID']));
    $Popups = snp_get_popups();
    $ABTesting = snp_get_ab();
    $Bars=(array)$Popups + (array)$ABTesting;
    if (isset($_REQUEST['start']) && snp_is_valid_date($_REQUEST['start']))
    {
	$start=date('Y-m-d', strtotime($_REQUEST['start']));
    }
    if (isset($_REQUEST['end']) && snp_is_valid_date($_REQUEST['end']))
    {
	$end=date('Y-m-d', strtotime($_REQUEST['end']));
    }
    if (isset($popup_ID))
    {
	$table_name = $wpdb->prefix . "snp_stats";
	$where = '';
	$where2 = '';
	if(strpos($popup_ID, 'ab_')!==FALSE)
	{
	   $AB = true;
	   $where = "AB_ID = '".str_replace('ab_', '', $popup_ID)."'"; 
	}
	else
	{
	    $where = "ID = '$popup_ID'";
	}
	if(isset($start))
	{
	    $where2 .= ' AND `date`>="'.$start.'" ';
	}
	if(isset($end))
	{
	    $where2 .= ' AND `date`<="'.$end.'" ';
	}
	$stats_sum = $wpdb->get_results
	(
	"
	SELECT SUM(imps) as imps, SUM(convs) as convs, FORMAT((SUM(convs)/SUM(imps))*100,2) as rate
	FROM $table_name
	WHERE $where $where2
	"
	);
	$stats = $wpdb->get_results(
	"
	SELECT date,SUM(imps) as imps, SUM(convs) as convs,FORMAT((SUM(convs)/SUM(imps))*100,2) as rate
	FROM $table_name
	WHERE $where $where2
	GROUP BY date
	ORDER BY date ASC
	"
	);
    }
    echo '<h2>'.__('Analytics', 'nhp-opts').'</h2>';
    echo '<form method="post">';
    echo '<strong>Form:</strong> <select name="popup_ID">';
    echo '<option '.($popup_ID=='' ? 'selected' : '').' value="">-- select --</option>';
    foreach($Bars as $ID => $Name)
    {
	echo '<option '.($popup_ID==$ID ? 'selected' : '').' value="'.$ID.'">'.$Name.'</option>';
    }
    echo '</select>';
    echo '<strong>Start:</strong> <input type="text" name="start" value="'.(isset($start) ? $start : '').'" style="text-align: center;" class="snp-datepicker" />
	<strong>End:</strong> <input type="text" name="end" value="'.(isset($end) ? $end : '').'"style="text-align: center;" class="snp-datepicker" />
	<input class="button button-primary button-large" type="submit" value="Show" />
    </form>
    <script type="text/javascript">
	  jQuery(document).ready(function(){	
		jQuery(".snp-datepicker").datepicker({dateFormat: "yy-mm-dd"});
	  });
    </script>';
    if ($stats)
    {
	echo '<h3>'.__('Impressions:', 'nhp-opts').' '.$stats_sum[0]->imps.' / '.__('Conversions:', 'nhp-opts').' '.$stats_sum[0]->convs.' / '.__('Rate:', 'nhp-opts').' '.$stats_sum[0]->rate.'%</h3>';
	?>
	<br />
	<div id="chart_div_main" style="width: 100%; height: 600px;"></div>
	<?php
	if($AB)
	{
	    echo '<h3>'.__('Impressions', 'nhp-opts').'';
	    echo '<div id="chart_div_i" style="width: 100%; height: 600px;"></div>';
	    echo '<h3>'.__('Conversions', 'nhp-opts').'';
	    echo '<div id="chart_div_c" style="width: 100%; height: 600px;"></div>';
	}
	?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() 
	  {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Date');
	    data.addColumn('number', 'Impressions');
	    data.addColumn('number', 'Conversions');
	    data.addRows([
	    <?php
	    $i=1;
	    foreach ($stats as $data)
	    {
		if ($i!=1) echo ',';
		echo "['".$data->date."', {v: ".$data->imps."}, {v: ".$data->convs.", f: '".$data->convs." (".$data->rate."%)'}]"; 
		$i++;
	    }
	    ?>
	    ]);
	    var options = {
	      title: '',
	      hAxis: {title: '', titleTextStyle: {color: '#333'}},
	      vAxis: {minValue: 0, gridlines:{count: -1}}
	    };
	    var chart = new google.visualization.AreaChart(document.getElementById('chart_div_main'));
	    chart.draw(data, options);
	    <?php
	    if($AB)
	    {
		?>
		var data_i = new google.visualization.DataTable();
		data_i.addColumn('string', 'Date');
		var data_c = new google.visualization.DataTable();
		data_c.addColumn('string', 'Date');
		<?php
		$AB_META = get_post_meta(str_replace('ab_', '', $popup_ID));
		$stat_arr = array();
		if(isset($AB_META['snp_forms']))
		{
		    $snp_forms = array_keys(unserialize($AB_META['snp_forms'][0]));
		    $IDs=array();
		    foreach($snp_forms as $ID)
		    {
			echo "data_i.addColumn('number', '".get_the_title($ID)."');";
			echo "data_c.addColumn('number', '".get_the_title($ID)."');";
			$IDs[]=$ID;
			$where1 = " AND ID = '$ID' ";
			$stats2 = $wpdb->get_results(
			"
			SELECT date,SUM(imps) as imps, SUM(convs) as convs,FORMAT(SUM(convs)/SUM(imps),2) as rate
			FROM $table_name
			WHERE $where $where1 $where2
			GROUP BY date
			ORDER BY date ASC
			"
			);
			if ($stats2)
			{
			    foreach ($stats2 as $data)
			    {
				$stat_arr['imps'][$data->date][$ID]=$data->imps;
				$stat_arr['convs'][$data->date][$ID]=$data->convs;
				$stat_arr['rate'][$data->date][$ID]=$data->rate;
			    }
			}
		    }
		    ?>
		    data_i.addRows([
		    <?php
		    $i=1;
		    foreach ($stat_arr['imps'] as $date => $data)
		    {
			if ($i!=1) echo ',';
			echo "['".$date."'";
			foreach ($IDs as $ID)
			{
			    echo ", {v: ". ($stat_arr['imps'][$date][$ID] ? $stat_arr['imps'][$date][$ID] : '0') ."}";
			}
			echo "]"; 
			$i++;
		    }
		    ?>
		    ]);
		    data_c.addRows([
		    <?php
		    $i=1;
		    foreach ($stat_arr['convs'] as $date => $data)
		    {
			if ($i!=1) echo ',';
			echo "['".$date."'";
			foreach ($IDs as $ID)
			{
			    echo ", {v: ". ($stat_arr['convs'][$date][$ID] ? $stat_arr['convs'][$date][$ID].", f: '".$stat_arr['convs'][$date][$ID]." (".$stat_arr['rate'][$date][$ID]."%)'" : '0') ."}";
			}
			echo "]"; 
			$i++;
		    }
		    ?>
		    ]);
		    <?php
		}
		?>
		var chart_i = new google.visualization.AreaChart(document.getElementById('chart_div_i'));
		chart_i.draw(data_i, options);
		var chart_c = new google.visualization.AreaChart(document.getElementById('chart_div_c'));
		chart_c.draw(data_c, options);
		<?php
	    }
	    ?>
	  }
	</script>
	<?php
    }
    else
    {
	echo '<div class="error"><p><strong>'.__('Nothing to show.', 'nhp-opts').'</strong></p></div>';
    }
    echo '</div>';
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    global $wp_scripts;
    $ui = $wp_scripts->query('jquery-ui-core');
    // tell WordPress to load the Smoothness theme from Google CDN
    $protocol = is_ssl() ? 'https' : 'http';
    $url = "$protocol://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.css";
    wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
}
function snp_plugin_menu()
{
    add_submenu_page ('edit.php?post_type=snp_popups','Analytics', 'Analytics', 'manage_options', 'snp_stats', 'snp_stats');
}
add_action('admin_menu', 'snp_plugin_menu');
?>