<?php

function emember_auto_responder_settings() {
    $emember_config = Emember_Config::getInstance();
    echo '<div class="wrap">';
    echo '<div id="poststuff"><div id="post-body">';
    if (isset($_POST['info_update'])) {
        $errors = "";
        if (isset($_POST['aweber_make_connection'])) {
            if ($emember_config->getValue('eMember_aweber_authorize_status') != 'authorized') {
                $authorization_code = trim($_POST['aweber_auth_code']);
                if (!class_exists('AWeberAPI')) {
                    include_once('lib/auto-responder/aweber_api/aweber_api.php');
                }
                $auth = AWeberAPI::getDataFromAweberID($authorization_code);
                list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;
                $eMember_aweber_access_keys = array(
                    'consumer_key' => $consumerKey,
                    'consumer_secret' => $consumerSecret,
                    'access_key' => $accessKey,
                    'access_secret' => $accessSecret,
                );
                $emember_config->setValue('eMember_aweber_access_keys', $eMember_aweber_access_keys);

                if ($eMember_aweber_access_keys['access_key']) {
                    try {
                        $aweber = new AWeberAPI($consumerKey, $consumerSecret);
                        $account = $aweber->getAccount($accessKey, $accessSecret);
                    } catch (AWeberException $e) {
                        $account = null;
                    }
                    if (!$account) {
                        //$this->deauthorize();//TODO - remove the keys
                        $errors = 'AWeber authentication failed! Please try connecting again.';
                    } else {
                        $emember_config->setValue('eMember_aweber_authorize_status', 'authorized');
                        $_POST['eMember_use_new_aweber_integration'] = '1'; //Set the eMember_use_new_aweber_integration flag to enabled
                        echo '<div id="message" class="updated fade"><p><strong>';
                        echo 'AWeber authorization success!';
                        echo '</strong></p></div>';
                    }
                } else {
                    $errors = 'You need to specify a valid authorization code to establish an AWeber API connection';
                }
            } else {//Remove existing connection
                $eMember_aweber_access_keys = array(
                    'consumer_key' => '',
                    'consumer_secret' => '',
                    'access_key' => '',
                    'access_secret' => '',
                );
                $emember_config->setValue('eMember_aweber_access_keys', $eMember_aweber_access_keys);
                $emember_config->setValue('eMember_aweber_authorize_status', '');
                $_POST['eMember_use_new_aweber_integration'] = ''; //Set the eMember_use_new_aweber_integration flag to disabled
                echo '<div id="message" class="updated fade"><p><strong>';
                echo 'AWeber connection removed!';
                echo '</strong></p></div>';
            }
        }

        $emember_config->setValue('eMember_enable_aweber_int', ($_POST['eMember_enable_aweber_int'] == '1') ? '1' : '');
        $emember_config->setValue('eMember_aweber_list_name', (string) $_POST["eMember_aweber_list_name"]);
        $emember_config->setValue('eMember_use_new_aweber_integration', ($_POST['eMember_use_new_aweber_integration'] == '1') ? '1' : '' );

        $emember_config->setValue('eMember_use_mailchimp', ($_POST['eMember_use_mailchimp'] == '1') ? '1' : '' );
        //$emember_config->setValue('eMember_enable_global_chimp_int', ($_POST['eMember_enable_global_chimp_int']=='1') ? '1':'' );
        $emember_config->setValue('eMember_chimp_list_name', trim($_POST["eMember_chimp_list_name"]));

        $emember_config->setValue('eMember_chimp_api_key', trim($_POST["eMember_chimp_api_key"]));
        $emember_config->setValue('eMember_mailchimp_disable_double_optin', ($_POST['eMember_mailchimp_disable_double_optin'] == '1') ? '1' : '' );
        $emember_config->setValue('eMember_mailchimp_disable_final_welcome_email', ($_POST['eMember_mailchimp_disable_final_welcome_email'] == '1') ? '1' : '' );
        $emember_config->setValue('eMember_mailchimp_signup_date_field_name', trim($_POST["eMember_mailchimp_signup_date_field_name"]));

        $emember_config->setValue('eMember_use_getresponse', ($_POST['eMember_use_getresponse'] == '1') ? '1' : '' );
        $emember_config->setValue('eMember_getResponse_campaign_name', (string) $_POST["eMember_getResponse_campaign_name"]);
        $emember_config->setValue('eMember_getResponse_api_key', (string) $_POST["eMember_getResponse_api_key"]);

        $emember_config->setValue('eMember_use_generic_autoresponder_integration', ($_POST['eMember_use_generic_autoresponder_integration'] == '1') ? '1' : '' );
        $emember_config->setValue('eMember_use_global_generic_autoresponder_integration', ($_POST['eMember_use_global_generic_autoresponder_integration'] == '1') ? '1' : '' );
        $emember_config->setValue('eMember_generic_autoresponder_target_list_email', trim($_POST["eMember_generic_autoresponder_target_list_email"]));

        $emember_config->saveConfig();

        if (!empty($errors)) {
            echo '<div id="message" class="error"><p>';
            echo $errors;
            echo '</p></div>';
        } else {
            echo '<div id="message" class="updated fade"><p><strong>';
            echo 'Autoresponder Options Updated!';
            echo '</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <input type="hidden" name="info_update" id="info_update" value="true" />

        <div class="postbox">
            <h3><label for="title">AWeber Settings (<a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=151" target="_blank">AWeber Integration Instructions</a>)</label></h3>
            <div class="inside">

                <table width="100%" border="0" cellspacing="0" cellpadding="6">

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Enable AWeber Signup:</strong>
                        </td><td align="left">
                            <input name="eMember_enable_aweber_int" type="checkbox"<?php if ($emember_config->getValue('eMember_enable_aweber_int') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><i>When checked the plugin will automatically sign up the members at registration time to your AWeber List specified below. For membership level specific signup see the "Autoresponder List/Campaign Name" section of the membership level.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>AWeber List Name:</strong>
                        </td><td align="left">
                            <input name="eMember_aweber_list_name" type="text" size="40" value="<?php echo $emember_config->getValue('eMember_aweber_list_name'); ?>"/>
                            <br /><i>The name of the AWeber list where the members will be signed up to (eg. listname@aweber.com)</i><br /><br />
                        </td></tr>
                </table>

                <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                <table class="form-table">

                    <tr valign="top"><td width="25%" align="left">
                            Use the New AWeber Integration Option:
                        </td><td align="left">
                            <input name="eMember_use_new_aweber_integration" type="checkbox"<?php if ($emember_config->getValue('eMember_use_new_aweber_integration') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><i>When checked the plugin will use the new AWeber integration method which uses the AWeber API (this method is recommended over the old method that uses the email parser).</i>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            Step 1: Get Your AWeber Authorization Code:
                        </td><td align="left">
                            <a href="https://auth.aweber.com/1.0/oauth/authorize_app/999d6172" target="_blank">Click here to get your authorization code</a>
                            <br /><i>Clicking on the above link will take you to the AWeber site where you will need to log in using your AWeber username and password. Then give access to the Tips and Tricks HQ AWeber app.</i>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            Step 2: Paste in Your Authorization Code:
                        </td><td align="left">
                            <input name="aweber_auth_code" type="text" size="140" value=""/>
                            <br /><i>Paste the long authorization code that you got from AWeber in the above field.</i>
                        </td></tr>

                    <tr valign="top"><td colspan="2" align="left">
                            <?php
                            if ($emember_config->getValue('eMember_aweber_authorize_status') == 'authorized') {
                                echo '<input type="submit" name="aweber_make_connection" value="Remove Connection" class= "button button" />';
                            } else {
                                echo '<input type="submit" name="aweber_make_connection" value="Make Connection" class= "button-primary" />';
                            }
                            ?>
                        </td></tr>

                </table>
            </div></div>

        <div class="postbox">
            <h3><label for="title">MailChimp Settings (<a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=236" target="_blank">MailChimp Integration Instructions</a>)</label></h3>
            <div class="inside">

                <table width="100%" border="0" cellspacing="0" cellpadding="6">

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Use MailChimp AutoResponder:</strong>
                        </td><td align="left">
                            <input name="eMember_use_mailchimp" type="checkbox"<?php if ($emember_config->getValue('eMember_use_mailchimp') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><i>Check this if you want to use MailChimp Autoresponder service. For membership level specific signup see the "Autoresponder List/Campaign Name" section of the membership level.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>MailChimp List Name:</strong>
                        </td><td align="left">
                            <input name="eMember_chimp_list_name" type="text" size="30" value="<?php echo $emember_config->getValue('eMember_chimp_list_name'); ?>"/>
                            <br /><i>The name of the MailChimp list where the customers will be signed up to (e.g. Customer List)</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>MailChimp API Key:</strong>
                        </td><td align="left">
                            <input name="eMember_chimp_api_key" type="text" size="50" value="<?php echo $emember_config->getValue('eMember_chimp_api_key'); ?>"/>
                            <br /><i>The API Key of your MailChimp account (can be found under the "Account" tab). By default the API Key is not active so make sure you activate it in your Mailchimp account. If you do not have the API Key then you can use the username and password option below but it is better to use the API key.</i>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Disable Double Opt-In:</strong>
                        </td><td align="left">
                            <input name="eMember_mailchimp_disable_double_optin" type="checkbox"<?php if ($emember_config->getValue('eMember_mailchimp_disable_double_optin') != '') echo ' checked="checked"'; ?> value="1"/>
                            Do not send double opt-in confirmation email
                            <br /><i>Use this checkbox if you do not wish to use the double opt-in option. Please note that abusing this option may cause your MailChimp account to be suspended.</i><br />

                            <input name="eMember_mailchimp_disable_final_welcome_email" type="checkbox"<?php if ($emember_config->getValue('eMember_mailchimp_disable_final_welcome_email') != '') echo ' checked="checked"'; ?> value="1"/>
                            Do not send welcome email
                            <br /><i>Use this checkbox if you do not wish to send the welcome email sent by MailChimp when a user subscribes to your list. This will only work if you disable the double opt-in option above.</i>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Signup Date Field Name (optional):</strong>
                        </td><td align="left">
                            <input name="eMember_mailchimp_signup_date_field_name" type="text" size="30" value="<?php echo $emember_config->getValue('eMember_mailchimp_signup_date_field_name'); ?>"/>
                            <br /><i>If you have configured a signup date field for your mailchimp list then specify the name of the field here (example: SIGNUPDATE). <a href="http://kb.mailchimp.com/article/how-do-i-create-a-date-field-in-my-signup-form" target="_blank">More Info</a></i><br /><br />
                        </td></tr>

                </table>
            </div></div>

        <div class="postbox">
            <h3><label for="title">GetResponse Settings (<a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=283" target="_blank">GetResponse Integration Instructions</a>)</label></h3>
            <div class="inside">

                <table width="100%" border="0" cellspacing="0" cellpadding="6">

                    <tr valign="top"><td width="25%" align="left">
                            <strong>Use GetResponse AutoResponder:</strong>
                        </td><td align="left">
                            <input name="eMember_use_getresponse" type="checkbox"<?php if ($emember_config->getValue('eMember_use_getresponse') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><i>Check this if you want to use GetResponse Autoresponder service.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>GetResponse Campaign Name:</strong>
                        </td><td align="left">
                            <input name="eMember_getResponse_campaign_name" type="text" size="30" value="<?php echo $emember_config->getValue('eMember_getResponse_campaign_name'); ?>"/>
                            <br /><i>The name of the GetResponse campaign where the customers will be signed up to (e.g. marketing)</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            <strong>GetResponse API Key:</strong>
                        </td><td align="left">
                            <input name="eMember_getResponse_api_key" type="text" size="50" value="<?php echo $emember_config->getValue('eMember_getResponse_api_key'); ?>"/>
                            <br /><i>The API Key of your GetResponse account (can be found inside your GetResponse Account).</i><br /><br />
                        </td></tr>

                </table>
            </div></div>

        <div class="postbox">
            <h3><label for="title">Generic Autoresponder Integration Settings</label></h3>
            <div class="inside">

                <br /><strong>&nbsp; &nbsp; If your autoresponder provider allows you to signup users just by sending an email to the list email address with the user's email as the from address then you can use this method of integration</strong>

                <table class="form-table" width="100%" border="0" cellspacing="0" cellpadding="6">

                    <tr valign="top"><td width="25%" align="left">
                            Enable Generic Autoresponder Integration:
                        </td><td align="left">
                            <input name="eMember_use_generic_autoresponder_integration" type="checkbox"<?php if ($emember_config->getValue('eMember_use_generic_autoresponder_integration') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><p class="description">Use this option if you want to use the generic auotoresponder integration option.</p>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            Enable Global Integration:
                        </td><td align="left">
                            <input name="eMember_use_global_generic_autoresponder_integration" type="checkbox"<?php if ($emember_config->getValue('eMember_use_global_generic_autoresponder_integration') != '') echo ' checked="checked"'; ?> value="1"/>
                            <br /><p class="description">When checked the plugin will automatically sign up every member to your list/campaign specified below. If you want to selectively signup members on a per membership level basis then use the Autoresponder settings of that level.</p>
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            Global List/Campaign Email Address:
                        </td><td align="left">
                            <input name="eMember_generic_autoresponder_target_list_email" type="text" size="40" value="<?php echo $emember_config->getValue('eMember_generic_autoresponder_target_list_email'); ?>"/>
                            <br /><p class="description">The email address of the list where the member will be signed up to. The plugin will send the autoresponder signup request email to this address.</p>
                        </td></tr>

                </table>
            </div></div>

        <div class="submit">
            <input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
        </div>
    </form>

    <?php
    echo '</div></div>';
    echo '</div>';
}
