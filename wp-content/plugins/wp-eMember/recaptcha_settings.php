<?php

function recaptcha_settings() {
    $emember_config = Emember_Config::getInstance();
    $msg = null;
    echo '<div class="wrap">';
    echo '<div id="poststuff"><div id="post-body">';
    if (isset($_POST['info_update'])) {
        if (isset($_POST["emember_enable_recaptcha"])) {
            if (empty($_POST["emember_recaptcha_public"]) || empty($_POST["emember_recaptcha_private"])) {
                $emember_config->setValue('emember_enable_recaptcha', 0);
                $msg = 'reCAPTCHA&trade; can\'t be enabled without public and private keys.';
            } else {
                $emember_config->setValue('emember_enable_recaptcha', 1);
                $emember_config->setValue('emember_recaptcha_public', (string) $_POST["emember_recaptcha_public"]);
                $emember_config->setValue('emember_recaptcha_private', (string) $_POST["emember_recaptcha_private"]);
            }
        } else {
            $emember_config->setValue('emember_enable_recaptcha', 0);
            $msg = 'reCAPTCHA&trade; is strongly recommended for protection against spams.';
        }
        //facebook feature
        /*
          $emember_config->setValue('emember_fb_api_key', (string)$_POST["emember_fb_api_key"]);
          $emember_config->setValue('emember_fb_app_secret', (string)$_POST["emember_fb_app_secret"]);
          $emember_config->setValue('emember_fb_app_id', (string)$_POST["emember_fb_app_id"]);
         */
        //facebook feature
        echo '<div id="message" class="updated fade"><p>';
        echo ($msg) ? '<strong style="color:red;">' . $msg : '<strong>Options Updated!';
        echo '</strong></p></div>';
        $emember_config->saveConfig();
    }
    ?>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <input type="hidden" name="info_update" id="info_update" value="true" />
        <div class="postbox">
            <h3><label for="title">reCAPTCHA Settings (If you want to use <a href="http://www.google.com/recaptcha/learnmore" target="_blank">reCAPTCHA</a> then you need to get reCAPTCHA API keys from <a href="http://www.google.com/recaptcha/whyrecaptcha" target="_blank">here</a> and use in the settings below)</label></h3>
            <div class="inside">
                <table width="100%" border="0" cellspacing="0" cellpadding="6">
                    <tr valign="top"><td width="25%" align="left">
                            Enable reCAPTCHA&trade;:</td>
                        <td align="left">
                            <input name="emember_enable_recaptcha" type="checkbox"  <?php $enable_captcha = $emember_config->getValue('emember_enable_recaptcha');
    echo ($enable_captcha) ? 'checked="checked"' : ''
    ?> value="1"/>
                            <br /><i>Check this box if you want to use reCAPTCHA on the member sign up form.</i><br /><br />
                        </td></tr>

                    <tr valign="top"><td width="25%" align="left">
                            Public key:</td>
                        <td align="left">
                            <input name="emember_recaptcha_public" size=60 type="text"   value="<?php echo $emember_config->getValue('emember_recaptcha_public'); ?>"/>
                            <br /><i>The public key for the reCAPTCHA API</i><br /><br />
                        </td></tr>
                    <tr valign="top"><td width="25%" align="left">
                            Private key:</td>
                        <td align="left">
                            <input name="emember_recaptcha_private" type="text" size=60 value="<?php echo $emember_config->getValue('emember_recaptcha_private'); ?>"/>
                            <br /><i>The private key for the reCAPTCHA API</i><br /><br />
                        </td></tr>

                </table>
            </div>
        </div>
        <!--facebook feature -->
        <!--<div class="postbox">
        <h3><label for="title">Facebook Settings (If you want to use <a href="http://recaptcha.net/learnmore.html" target="_blank">reCAPTCHA</a> then you need to get reCAPTCHA API keys from <a href="http://recaptcha.net/whyrecaptcha.html" target="_blank">here</a> and use in the settings below)</label></h3>
        <div class="inside">
        <table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr valign="top"><td width="25%" align="left">
        Facebook API Key:</td>
        <td align="left">
        <input name="emember_fb_api_key" type="text" size=60   value="<?php echo $emember_config->getValue('emember_fb_api_key'); ?>"/>
        <br /><i>API key provided by Facebook.</i><br /><br />
        </td></tr>

        <tr valign="top"><td width="25%" align="left">
        Facebook Application Secret:</td>
        <td align="left">
        <input name="emember_fb_app_secret" size=60 type="text"   value="<?php echo $emember_config->getValue('emember_fb_app_secret'); ?>"/>
        <br /><i>Facebook Application Secret key.</i><br /><br />
        </td></tr>
        <tr valign="top"><td width="25%" align="left">
        Facebook Application ID:</td>
        <td align="left">
        <input name="emember_fb_app_id" type="text" size=60 value="<?php echo $emember_config->getValue('emember_fb_app_id'); ?>"/>
        <br /><i>Facebook Application ID.</i><br /><br />
        </td></tr>

        </table>
        </div>
        </div>-->
        <!--facebook feature -->
        <div class="submit">
            <input type="submit" name="info_update" class="button-primary" value="<?php _e('Update options'); ?> &raquo;" />
        </div>
    </form>

    <?php
    echo '</div></div>';
    echo '</div>';
}
?>
