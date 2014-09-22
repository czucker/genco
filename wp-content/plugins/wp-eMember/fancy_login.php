<?php if ($emember_config->getValue('eMember_enable_fancy_login') == '1'): ?>
    <fieldset id="emember_signin_menu">
        <span id="emem_ui_close" class="emember_ui_close">X</span>
        <form action="<?php echo $login_url; ?>" id="emember_fancy_login_form" class="wp_emember_loginForm" name="loginForm" method="post">
            <input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce('emember-login-nonce'); ?>" />
            <input type="hidden" name="action" value="emember_ajax_login" />
            <p class="textbox">
                <label for="login_user_name" class="eMember_label"><?php echo EMEMBER_USER_NAME; ?></label>
                <input type="text" tabindex="4" title="username" value="" name="login_user_name" id="login_user_name">
            </p>
            <p class="textbox">
                <label for="login_pwd" class="eMember_label"><?php echo EMEMBER_PASSWORD; ?></label>
                <input type="password" tabindex="5" title="password" value="" name="login_pwd" id="login_pwd">
            </p>

            <p class="rememberme">
                <input type="submit" tabindex="7" value="<?php echo EMEMBER_SIGNIN; ?>" class="emember_button" name="doLogin" id="doLogin">
                <input type="hidden" value="1" name="testcookie" />
                <?php if ($emember_config->getValue('eMember_multiple_logins') != '1'): ?>
                    <input type="checkbox" tabindex="6" value="forever" name="rememberme" id="rememberme">
                    <label for="remember"><?php echo EMEMBER_REMEMBER_ME; ?></label>
                <?php endif; ?>
            </p>
            <span id="emember_fancy_log_msg"></span>
            <p class="forgot">
                <?php
                $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
                if ($password_reset_url):
                    ?>
                    <a id="forgot_pass" href="<?php echo $password_reset_url; ?>"><?php echo EMEMBER_FORGOT_PASS; ?></a>
                <?php else : ?>
                    <a id="forgot_pass" rel="#emember_forgot_pass_prompt" class="forgot_pass_link" href="javascript:void(0);"><?php echo EMEMBER_FORGOT_PASS; ?></a>
                <?php endif; ?>
            </p>
            <p class="forgot-username">
                <a title="Join us" id="join_us" href="<?php echo $join_url; ?>"><?php echo EMEMBER_JOIN_US; ?></a>
            </p>
        </form>
        <div id="marker" style="display: none;"></div>
    </fieldset>
<?php endif; ?>
<?php if ($emember_config->getValue('eMember_enable_fancy_login') == '2'): ?>
    <div id="emember_fancy_login_v2" class="emember_modal">
        <?php
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title))
            $widget_title = EMEMBER_MEMBER_LOGIN;
        ?>
        <h2><?php echo $widget_title; ?></h2>
        <div class="emember_fancy_login_v2_content">
            <form action="" id="emember-fancy-loginForm" class="wp_emember_loginForm" name="emember-loginForm" method="post">
                <input type="hidden" name="action" value="emember_ajax_login" />
                <input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce('emember-login-nonce'); ?>" />
                <p class="textbox">
                    <label for="login_user_name" class="eMember_label"><?php echo EMEMBER_USER_NAME; ?></label>
                    <input type="text" tabindex="4" title="username" value="" name="login_user_name" id="login_user_name" />
                </p>
                <p class="textbox">
                    <label for="login_pwd" class="eMember_label"><?php echo EMEMBER_PASSWORD; ?></label>
                    <input type="password" tabindex="5" title="password" value="" name="login_pwd" id="login_pwd" />
                </p>
                <p class="rememberme">
                    <input type="submit" tabindex="7" value="<?php echo EMEMBER_SIGNIN; ?>" name="doLogin" class="emember_button" id="doLogin" />
                    <input type="hidden" value="1" name="testcookie" />
                    <?php if ($emember_config->getValue('eMember_multiple_logins') != '1'): ?>
                        <input type="checkbox" tabindex="6" value="forever" name="remember_me" id="rememberme" />
                        <label for="rememberme"><?php echo EMEMBER_REMEMBER_ME; ?></label>
                    <?php endif; ?>
                </p>
                <span id="emember_fancy_log_msg"></span>
                <p class="forgot">
                    <?php
                    $password_reset_url = $emember_config->getValue('eMember_password_reset_page');
                    if ($password_reset_url):
                        ?>
                        <a id="forgot_pass" href="<?php echo $password_reset_url; ?>"><?php echo EMEMBER_FORGOT_PASS; ?></a>
                    <?php else : ?>
                        <a id="emember_forgot_pass"  href="javascript:void(0);"><?php echo EMEMBER_FORGOT_PASS; ?></a>
                    <?php endif; ?>
                </p>
                <p class="forgot-username">
                    <a title="Join us" id="join_us" href="<?php echo $join_url; ?>"><?php echo EMEMBER_JOIN_US; ?></a>
                </p>

            </form>
        </div>
    </div>
<?php endif; ?>
