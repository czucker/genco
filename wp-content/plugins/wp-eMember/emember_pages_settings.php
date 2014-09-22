<?php

function emember_pages_settings() {
    global $emember_config;
    $emember_config = Emember_Config::getInstance();
    if (isset($_POST['info_update'])) {
        $msg = '';
        $emember_config->setValue('login_page_url', trim((string) $_POST["login_page_url"]));
        $emember_config->setValue('after_login_page', trim((string) $_POST["after_login_page"]));
        $emember_config->setValue('after_logout_page', trim((string) $_POST["after_logout_page"]));
        $emember_config->setValue('eMember_registration_page', trim((string) $_POST["eMember_registration_page"]));
        update_option('eMember_registration_page', trim((string) $_POST["eMember_registration_page"])); //For backwards compatibility with eStore

        $emember_config->setValue('eMember_after_registration_page', trim((string) $_POST["eMember_after_registration_page"]));
        $emember_config->setValue('eMember_payments_page', trim((string) $_POST["eMember_payments_page"]));
        $emember_config->setValue('eMember_profile_edit_page', trim((string) $_POST["eMember_profile_edit_page"]));
        $emember_config->setValue('eMember_support_page', trim((string) $_POST["eMember_support_page"]));
        $emember_config->setValue('eMember_terms_conditions_page', trim((string) $_POST["eMember_terms_conditions_page"]));
        $emember_config->setValue('eMember_password_reset_page', trim((string) $_POST["eMember_password_reset_page"]));
        $emember_config->setValue('eMember_bookmark_listing_page', trim((string) $_POST["eMember_bookmark_listing_page"]));
        $emember_config->setValue('eMember_profile_thumbnail', isset($_POST["eMember_profile_thumbnail"]) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_title', isset($_POST['eMember_reg_title']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_firstname', isset($_POST['eMember_reg_firstname']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_lastname', isset($_POST['eMember_reg_lastname']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_company', isset($_POST['eMember_reg_company']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_email', isset($_POST['eMember_reg_email']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_phone', isset($_POST['eMember_reg_phone']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_street', isset($_POST['eMember_reg_street']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_city', isset($_POST['eMember_reg_city']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_state', isset($_POST['eMember_reg_state']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_zipcode', isset($_POST['eMember_reg_zipcode']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_country', isset($_POST['eMember_reg_country']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_gender', isset($_POST['eMember_reg_gender']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_title', isset($_POST['eMember_edit_title']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_firstname', isset($_POST['eMember_edit_firstname']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_lastname', isset($_POST['eMember_edit_lastname']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_company', isset($_POST['eMember_edit_company']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_email', isset($_POST['eMember_edit_email']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_phone', isset($_POST['eMember_edit_phone']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_street', isset($_POST['eMember_edit_street']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_city', isset($_POST['eMember_edit_city']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_state', isset($_POST['eMember_edit_state']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_zipcode', isset($_POST['eMember_edit_zipcode']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_country', isset($_POST['eMember_edit_country']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_gender', isset($_POST['eMember_edit_gender']) ? "checked='checked'" : '');

        $emember_config->setValue('eMember_reg_title_required', isset($_POST['eMember_reg_title_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_firstname_required', isset($_POST['eMember_reg_firstname_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_lastname_required', isset($_POST['eMember_reg_lastname_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_company_required', isset($_POST['eMember_reg_company_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_email_required', isset($_POST['eMember_reg_email_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_phone_required', isset($_POST['eMember_reg_phone_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_street_required', isset($_POST['eMember_reg_street_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_city_required', isset($_POST['eMember_reg_city_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_state_required', isset($_POST['eMember_reg_state_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_zipcode_required', isset($_POST['eMember_reg_zipcode_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_country_required', isset($_POST['eMember_reg_country_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_reg_gender_required', isset($_POST['eMember_reg_gender_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_show_terms_conditions', isset($_POST['eMember_show_terms_conditions']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_hide_membership_field', isset($_POST['eMember_hide_membership_field']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_show_confirm_pass_field', isset($_POST['eMember_show_confirm_pass_field']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_title_required', isset($_POST['eMember_edit_title_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_firstname_required', isset($_POST['eMember_edit_firstname_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_lastname_required', isset($_POST['eMember_edit_lastname_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_company_required', isset($_POST['eMember_edit_company_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_email_required', isset($_POST['eMember_edit_email_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_phone_required', isset($_POST['eMember_edit_phone_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_street_required', isset($_POST['eMember_edit_street_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_city_required', isset($_POST['eMember_edit_city_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_state_required', isset($_POST['eMember_edit_state_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_zipcode_required', isset($_POST['eMember_edit_zipcode_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_country_required', isset($_POST['eMember_edit_country_required']) ? "checked='checked'" : '');
        $emember_config->setValue('eMember_edit_gender_required', isset($_POST['eMember_edit_gender_required']) ? "checked='checked'" : '');

        $tmpmsg1 = htmlspecialchars($_POST['eMember_login_widget_message_for_logged_members'], ENT_COMPAT);
        $emember_config->setValue('eMember_login_widget_message_for_logged_members', $tmpmsg1);

        $emember_config->saveConfig();
        echo '<div id="message" class="updated fade"><p>';
        echo ($msg) ? '<strong style="color:red;">' . $msg : '<strong>Options Updated!';
        echo '</strong></p></div>';
    }
    ?>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <input type="hidden" name="info_update" id="info_update" value="true" />
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body">
                    <div class="eMember_grey_box">
                        <p>For detailed documentation, information and updates, please visit the <a href="http://www.tipsandtricks-hq.com/wordpress-membership" target="_blank">WP eMember Documentation Page</a></p>
                        <p>Like the plugin? Give us a <a href="http://www.tipsandtricks-hq.com/?p=1706#gfts_share" target="_blank">thumbs up here</a> by clicking on a share button or leave a comment to let us know.</p>
                    </div>

                    <!--  <div class="basic" style="float:left;"  id="list1a">-->
                    <!--  <div class="title"><label for="title">General Settings</label></div> -->
                    <div class="postbox">
                        <h3><label for="title">General Settings</label></h3> <!-- added -->
                        <div class="inside">

                            <div class="eMember_yellow_box">
                                <p style="color:blue;font-size:14px;font-weight:bold;margin-top:5px;">The plugin automatically created the mandatory configuration pages for you at install time. You can edit them however you like. You can also create your own pages if you like but make sure to update the URL values below if you do so.</p>

                                <p style="font-size:14px; line-height:22px;padding:5px 0px 0px 0px;">
                                    <strong>Note: </strong>The mandatory fields in this section must be completed for the plugin to function correctly.
                                </p>
                            </div>
                            <p style="margin-bottom:15px"></p>

                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left"><strong>Login Page (Mandatory):</strong></td>
                                    <td align="left">
                                        <input name="login_page_url" type="text" size="100" value="<?php echo $emember_config->getValue('login_page_url'); ?>"/><br />
                                        <i>This is the page where the members can go to log into the site. Create a page and put <strong>[wp_eMember_login]</strong> shortcode in the page that will display a form which will allow members to be able to log in. Enter the URL of this page in this field</i><br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Registration Page (Mandatory):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_registration_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_registration_page'); ?>"/><br />
                                        <i>Where members can fill out a registration form to complete a membership account creation. Create a page and put <strong>[wp_eMember_registration]</strong> shortcode in the page that will display a form which will allow users to be able to register. Enter the URL of this page in this field. <a href="http://www.tipsandtricks-hq.com/forum/topic/the-difference-between-registration-page-and-join-us-page" target="_blank">More explanation here</a></i><br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Membership Payment/Join Page (Mandatory):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_payments_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_payments_page'); ?>"/><br />
                                        <i>The URL of the page where you have a list of all types of membership that you offer (example: Free, Silver, Gold) and the necessary buttons that the visitors can use to purchase a membership. For the free membership signup (if you want to allow free membership) simply place a link pointing to the Registration page where anyone can go and signup for a free membership. <a href="http://www.tipsandtricks-hq.com/forum/topic/the-difference-between-registration-page-and-join-us-page" target="_blank">More explanation here</a></i><br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>After Login Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="after_login_page" type="text" size="100" value="<?php echo $emember_config->getValue('after_login_page'); ?>"/><br />
                                        <i>Members will be redirected to this page after a successful login. This option is only used if you have not specified a redirection page in the membership level configuration for a particular membership level</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>After Logout Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="after_logout_page" type="text" size="100" value="<?php echo $emember_config->getValue('after_logout_page'); ?>"/><br />
                                        <i>Members will be redirected to this page after logout.</i><br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>After Registration Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_after_registration_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_after_registration_page'); ?>"/><br />
                                        Members will be redirected to this page after completing the registration.
                                        <br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Member Profile Edit Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_profile_edit_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_profile_edit_page'); ?>"/><br />
                                        <i>The URL of the page where members can edit their profile (eg. their email address). To allow the members to be able to change their profile simply create a page and put <strong>[wp_eMember_edit_profile]</strong> trigger text in the page that will display a form which will allow members to update their profile. Enter the URL of this page in this settings field</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Support Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_support_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_support_page'); ?>"/><br />
                                        <i>URL of the Support/Member help page if you have any. Leave empty if it does not apply.</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Bookmarks Listing Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_bookmark_listing_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_bookmark_listing_page'); ?>"/><br />
                                        <i>Use this field if you have enabled the <a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=99" target="_blank">bookmarking feature</a>. Enter the URL of the page where you will display the member's bookmarks list (the page where you added the <code>[wp_eMember_user_bookmarks]</code> shortcode).</i><br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Password Reset Page (Optional):</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_password_reset_page" type="text" size="100" value="<?php echo $emember_config->getValue('eMember_password_reset_page'); ?>"/><br />
                                        <i>The default method for password reset is via an overlay popup. If you want to use a separete page for password reset instead of the default overlay popup then create a page and use the <strong>[wp_eMember_password_reset]</strong> shortcode in that page. Specify the URL of that page in the above field.</i><br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- <div class="title"><label for="title">Registration Form Fields</label></div> -->
                    <div class="postbox">
                        <h3><label for="title">Registration Form Fields</label></h3>	<!-- added -->
                        <div class="inside">
                            <strong><i>Fields to be shown on the Registation form (Username, Password and Email address are mandatory fields and will always be present on the form).</i></strong><br /><br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Title:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_title" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_title'); ?> value="1"/> Show title field on registration page<br />
                                        <input name="eMember_reg_title_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_title_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>First name:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_firstname" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_firstname'); ?> value="1"/> Show first name field on registration page<br />
                                        <input name="eMember_reg_firstname_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_firstname_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Last name:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_lastname" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_lastname'); ?> value="1"/> Show last name field on registration page<br />
                                        <input name="eMember_reg_lastname_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_lastname_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Phone:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_phone" type="checkbox"  <?php $eMember_reg_phone = $emember_config->getValue('eMember_reg_phone');
    echo ($eMember_reg_phone) ? 'checked="checked"' : ''
    ?> value="1"/> Show phone field on registration page<br />
                                        <input name="eMember_reg_phone_required" type="checkbox"  <?php $eMember_reg_phone = $emember_config->getValue('eMember_reg_phone_required');
                                           echo ($eMember_reg_phone) ? 'checked="checked"' : ''
                                           ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Company:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_company" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_company'); ?> value="1"/> Show company field on registration page<br />
                                        <input name="eMember_reg_company_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_company_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address Street:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_street" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_street'); ?> value="1"/> Show street address field on registration page<br />
                                        <input name="eMember_reg_street_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_street_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address City:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_city" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_city'); ?> value="1"/> Show address city field on registration page<br />
                                        <input name="eMember_reg_city_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_city_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address State:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_state" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_state'); ?> value="1"/> Show address state field on registration page<br />
                                        <input name="eMember_reg_state_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_state_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address Zipcode:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_zipcode" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_zipcode'); ?> value="1"/> Show address zipcode field on registration page<br />
                                        <input name="eMember_reg_zipcode_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_zipcode_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Country:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_country" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_country'); ?> value="1"/> Show country field on registration page<br />
                                        <input name="eMember_reg_country_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_country_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Gender:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_reg_gender" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_gender'); ?> value="1"/> Show gender field on registration page<br />
                                        <input name="eMember_reg_gender_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_reg_gender_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" align="left"><strong>Show Terms and Conditions Checkbox:</strong></td>
                                    <td align="left"><input name="eMember_show_terms_conditions" type="checkbox"  <?php echo $emember_config->getValue('eMember_show_terms_conditions'); ?> value="1"/>
                                        Terms & Conditions Page URL:
                                        <input name="eMember_terms_conditions_page" type="text" size="60" value="<?php echo $emember_config->getValue('eMember_terms_conditions_page'); ?>"/>
                                        <br /><i>If you want your members to agree to the terms and conditions before they can register then enable this option.</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" align="left"><strong>Hide Membership Level Field:</strong></td>
                                    <td align="left"><input name="eMember_hide_membership_field" type="checkbox"  <?php echo $emember_config->getValue('eMember_hide_membership_field'); ?> value="1"/>
                                        <br /><i>The membership level field is a mandatory field for the registration form. You can use this option to make the membership level field hidden if needed.</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" align="left"><strong>Show Confirm Password Field:</strong></td>
                                    <td align="left"><input name="eMember_show_confirm_pass_field" type="checkbox"  <?php echo $emember_config->getValue('eMember_show_confirm_pass_field'); ?> value="1"/>
                                        <br /><i>Adds a confirm password field in the registration form.</i>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="title"><label for="title">Edit Profile Form Fields</label></div> -->
                    <div class="postbox">
                        <h3><label for="title">Edit Profile Form Fields</label></h3> <!-- added -->
                        <div class="inside">
                            <strong><i>Fields to be shown on the Edit profile form (Username, Password and Email address are mandatory fields and will always be present on the form).</i></strong><br /><br />
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Title:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_title" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_title'); ?> value="1"/> Show title field on edit profile page<br />
                                        <input name="eMember_edit_title_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_title_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>First name:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_firstname" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_firstname'); ?> value="1"/> Show first name field on edit profile page<br />
                                        <input name="eMember_edit_firstname_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_firstname_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Last name:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_lastname" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_lastname'); ?> value="1"/> Show last name field on edit profile page<br />
                                        <input name="eMember_edit_lastname_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_lastname_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Company:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_company" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_company'); ?> value="1"/> Show company field on edit profile page<br />
                                        <input name="eMember_edit_company_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_company_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Email:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_email" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_email'); ?> value="1"/> Show email field on edit profile page<br />
                                        <input name="eMember_edit_email_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_email_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Phone:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_phone" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_phone'); ?> value="1"/> Show phone field on edit profile page<br />
                                        <input name="eMember_edit_phone_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_phone_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address Street:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_street" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_street'); ?> value="1"/> Show address street field on edit profile page<br />
                                        <input name="eMember_edit_street_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_street_required'); ?> value="1"/>Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address City:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_city" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_city'); ?> value="1"/> Show address city field on edit profile page<br />
                                        <input name="eMember_edit_city_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_city_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address State:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_state" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_state'); ?> value="1"/> Show address state field on edit profile page<br />
                                        <input name="eMember_edit_state_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_state_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Address Zipcode:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_zipcode" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_zipcode'); ?> value="1"/> Show address zipcode field on edit profile page<br />
                                        <input name="eMember_edit_zipcode_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_zipcode_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Country:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_country" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_country'); ?> value="1"/> Show country field on edit profile page<br />
                                        <input name="eMember_edit_country_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_country_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Gender:</strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_edit_gender" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_gender'); ?> value="1"/> Show gender field on edit profile page<br />
                                        <input name="eMember_edit_gender_required" type="checkbox"  <?php echo $emember_config->getValue('eMember_edit_gender_required'); ?> value="1"/> Make this field required
                                        <br /><br />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td width="25%" align="left">
                                        <strong>Enable Profile Thumbnail Image: </strong>
                                    </td>
                                    <td align="left">
                                        <input name="eMember_profile_thumbnail" type="checkbox"  <?php echo $emember_config->getValue('eMember_profile_thumbnail'); ?> value="1"/> Show profile thumbnail image on edit profile page
                                        <br /><br />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="postbox">
                        <h3><label for="title">Login Widget Message</label></h3>
                        <div class="inside">
                            <table width="100%" border="0" cellspacing="0" cellpadding="6">

                                <tr valign="top">
                                    <td width="25%" align="left"><strong>Additional Message for Logged in Members:</strong></td>
                                    <td align="left">
                                        <textarea name="eMember_login_widget_message_for_logged_members" cols="70" rows="5"><?php echo stripslashes($emember_config->getValue('eMember_login_widget_message_for_logged_members')); ?></textarea><br />
                                        <i>This message will be added to the default login widget content that is displayed to the members who are logged in. You can use HTML code in this field.</i><br /><br />
                                    </td>
                                </tr>

                            </table>
                        </div></div>

                    <div class="submit">
                        <input type="submit"  name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        //	   ;(function($){
        //			$(document).ready(function(){
        //				$('#list1a').accordion({autoHeight:false});
        //				$('#list1a a').click(function(e){ e.stopPropagation(); });
        //		    });
        //	    })(jQuery);
    </script>
    <?php
}
?>
