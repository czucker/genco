<?php

function emember_payment_gateway_settings_menu() {
    echo '<div class="wrap">';
    echo '<div id="poststuff"><div id="post-body">';

    $emember_config = Emember_Config::getInstance();
    $paypal_ipn_url = WP_EMEMBER_URL . "/ipn/eMember_handle_paypal_ipn.php";

    if (isset($_POST['info_update_emem_cb'])) {
        $emember_config->setValue('eMember_cb_secret_key', trim($_POST["eMember_cb_secret_key"]));
        $emember_config->saveConfig();

        echo '<div id="message" class="updated fade"><p><strong>';
        echo 'Clickbank Options Updated!';
        echo '</strong></p></div>';
    }

    if (isset($_POST['emem_generate_av_code'])) {
        $mem_level = trim($_POST['emember_paypal_av_member_level']);
        $membership_level_resultset = dbAccess::find(WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE, " id='" . $mem_level . "'");
        if ($membership_level_resultset) {
            $pp_av_code = 'notify_url=' . $paypal_ipn_url . '<br />' . 'custom=subsc_ref=' . $mem_level;
            echo '<div id="message" class="updated fade"><p>';
            echo '<strong>Paste the code below in the "Add advanced variables" field of your PayPal button for membership level ' . $mem_level . '</strong>';
            echo '<br /><code>' . $pp_av_code . '</code>';
            echo '</p></div>';
        } else {
            echo '<div id="message" class="updated fade"><p><strong>';
            echo 'Error! The membership level ID (' . $mem_level . ') you specified is incorrect. Please check this value again.';
            echo '</strong></p></div>';
        }
    }
    ?>
    <div class="postbox">
        <h3><label for="title">WP eStore Integration Settings</label></h3>
        <div class="inside">

            <p><strong>
                    Please read the <a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=60" target="_blank">WP eStore Integration Instruction</a> to integrate eMember with WP eStore's purchase button.
                </strong></p>

        </div></div>

    <div class="postbox">
        <h3><label for="title">Direct PayPal Integration Settings</label></h3>
        <div class="inside">

            <p><strong>
                    Please read the <a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=146" target="_blank">Direct PayPal Button Integration Instruction</a> to integrate eMember directly with a PayPal button.
                </strong></p>

            <table width="100%" border="0" cellspacing="0" cellpadding="6">
                <tr valign="top"><td width="25%" align="left">
                        PayPal IPN (Instant Payment Notification) URL Value:
                    </td><td align="left">
                        <code><?php echo $paypal_ipn_url; ?></code>
                        <br /><br /><i>You will need to use the above URL as the "IPN handling script URL" value in your your PayPal button.</i><br /><br />
                    </td></tr>
            </table>

            <strong>Generate the "Advanced Variables" Code for your PayPal button</strong>
            <br />
            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                Enter the Membership Level ID
                <input name="emember_paypal_av_member_level" type="text" size="4" value="" />
                <input type="submit" name="emem_generate_av_code" class="button-primary" value="Generate Code" />
            </form>

        </div></div>

    <div class="postbox">
        <h3><label for="title">ClickBank Integration Settings</label></h3>
        <div class="inside">

            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <input type="hidden" name="info_update_emem_cb" id="info_update_emem_cb" value="true" />

                <p><strong>
                        Please read the <a href="http://www.tipsandtricks-hq.com/wordpress-membership/?p=470" target="_blank">ClickBank Integration Instruction</a> to integrate eMember with a ClickBank button.
                    </strong></p>

                <table width="100%" border="0" cellspacing="0" cellpadding="6">
                    <tr valign="top"><td width="25%" align="left">
                            ClickBank Secret Key:
                        </td><td align="left">
                            <input name="eMember_cb_secret_key" type="text" size="50" value="<?php echo $emember_config->getValue('eMember_cb_secret_key'); ?>"/>
                            <br /><i>Enter your ClickBank secret key. You can configure your secret key from the <code>"Account Settings -> My Site -> Advanced Tools"</code> section of your ClickBank account.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            ClickBank Instant Notification URL Value:
                        </td><td align="left">
                            <code><?php echo WP_EMEMBER_URL . "/ipn/eMember_handle_clickbank_ipn.php"; ?></code>
                            <br /><br /><i>Enter the above URL in your your ClickBank account's "Instant Notification URL" field (just below the secret key). You can find it in the <code>"Account Settings -> My Site -> Advanced Tools"</code> section of your ClickBank account.</i><br /><br />
                        </td></tr>
                </table>

                <div class="submit">
                    <input type="submit" name="info_update_emem_cb" class="button-primary" value="<?php _e('Save Clickbank options'); ?> &raquo;" />
                </div>
            </form>
        </div></div>

    <?php
    echo '</div></div>';
    echo '</div>';
}
