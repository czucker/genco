<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2003
 **/
error_reporting(0);
?><div class="modal fade rhlogin <?php echo @$content?>" id="rh-modal-login">
	<div class="rhl-modal-bg2 modal-dialog">
		<div class="modal-header">
	    	<button type="button" class="close" data-dismiss="modal">x</button>
	    	<h3 class="action-login action-section"><?php $this->form_label('head_login',__('Login','rhl'))?></h3>
	    	<h3 class="action-logout action-section"><?php $this->form_label('head_logout',__('Logout','rhl'))?></h3>
	    	<h3 class="action-lostpassword action-section"><?php $this->form_label('head_lostpassword',__('Lost Password','rhl'))?></h3>
	    	<h3 class="action-rp action-section"><?php $this->form_label('head_rp',__('Reset Password','rhl'))?></h3>
			<h3 class="action-register action-section"><?php $this->form_label('head_register',__('Registration Form','rhl'))?></h3>
			<h3 class="action-maintenance action-section"><?php $this->form_label('head_maintenance',__('Under maintenance','rhl'))?></h3>
		</div>

		<div class="modal-body">
			<div class="action-maintenance action-section">
				<div class="rhl-maintenance-content">
					<?php $this->form_label('maintenance_body',__('Under maintenance','rhl'))?>
				</div>
			</div>
			<div class="action-login action-section">
				<form name="loginform" id="loginform" action="" method="post">
				<input type="hidden" name="rhl_nonce" value="<?php echo $modal_login_nonce?>" />
				<p>
					<label for="user_login"><?php $this->form_label('login_username',__('Username','rhl'))?><br />
					<input type="text" name="log" id="login-user_login" class="input" value="<?php echo @esc_attr($user_login); ?>" size="20" tabindex="990" /></label>
				</p>
				<p>
					<label for="user_pass"><?php $this->form_label('login_password',__('Password','rhl'))?><br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="991" /></label>
				</p>
			<?php do_action('login_form'); ?>
				<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="992"<?php checked( $rememberme ); ?> /> <?php $this->form_attr('login_rememberme',__('Remember Me','rhl'))?></label></p>
				<p class="submit">

			<?php	if ( $interim_login ) { ?>
					<input type="hidden" name="interim-login" value="1" />
			<?php	} else { ?>
					<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
			<?php 	} ?>
					<input type="hidden" name="testcookie" value="1" />
				</p>
				</form>
			</div>

			<div class="action-logout action-section">
				<img src="<?php echo RHL_URL.'css/images/spinner_32x32.gif'?>" />
			</div>

			<div class="action-lostpassword action-section">
				<form name="lostpasswordform" id="lostpasswordform" action="" method="post">
				<input type="hidden" name="rhl_nonce" value="<?php echo $modal_login_nonce?>" />
				<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">x</a>
					&nbsp;
				</div>
				<p>
					<label for="user_login" ><?php $this->form_label('lostpassword_user_login',__('Username or E-mail:','rhl'))?><br />
					<input type="text" name="user_login" id="lost_password_user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" tabindex="993" /></label>
				</p>
	<?php do_action('lostpassword_form'); ?>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
				</form>
			</div>

			<div class="action-rp action-section">
				<form name="resetpassform" id="resetpassform" action="" method="post">
					<input type="hidden" name="rhl_nonce" value="<?php echo $modal_login_nonce?>" />
					<input type="hidden" id="user_login" name="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />
					<input type="hidden" id="key" name="key" value="<?php echo esc_attr( $_GET['key'] ); ?>" autocomplete="off" />
					<p>
						<label for="pass1"><?php $this->form_label('rp_pass1',__('New password','rhl'))?><br />
						<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></label>
					</p>
					<p>
						<label for="pass2"><?php $this->form_label('rp_pass2',__('Confirm new password','rhl'))?><br />
						<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></label>
					</p>

					<div id="pass-strength-result" class="hide-if-no-js"><?php $this->form_label('rp_strength',__('Strength indicator','rhl'))?></div>
					<p class="description indicator-hint"><?php $this->form_label('rp_hint',__('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).','rhl'))?></p>

					<br class="clear" />
				</form>
			</div>

			<div class="action-register action-section">
				<?php if ( get_option( 'users_can_register' ) ):?>
				<form name="registerform" id="registerform" action="" method="post">
					<input type="hidden" name="rhl_nonce" value="<?php echo $modal_login_nonce?>" />
					<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $registration_redirect_to ); ?>" />
					<p>
						<label for="user_login"><?php $this->form_label('register_username',__('Username','rhl'))?><br />
						<input type="text" name="user_login" id="register-user_login" class="input" value="" size="20" tabindex="996" /></label>
					</p>
					<p>
						<label for="user_email"><?php $this->form_label('register_email',__('E-mail','rhl'))?><br />
						<input type="email" name="user_email" id="register-user_email" class="input" value="" size="25" tabindex="997" /></label>
					</p>
				<?php //do_action('register_form'); ?>
					<p id="reg_passmail"><?php $this->form_label('register_message',__('A password will be e-mailed to you.','rhl'))?></p>
					<br class="clear" />
				</form>
				<?php else : ?>
				<div class="alert-error">
					<?php _e('User registration is currently not allowed.','rhl')?>
				</div>
				<?php endif;?>
			</div>

			<div class="modal-login-links">
			<?php if(!$this->handle_custom_links($lost_password_redirect_to, $redirect_to)):?>
				<a class="btn btn-default action-login action-section" href="<?php echo wp_lostpassword_url( $lost_password_redirect_to );?>" ><?php $this->form_label('sec_lostpassword',__('Lost your password?','rhl'))?></a>
				<a class="btn btn-default action-maintenance action-rp action-register action-lostpassword action-section" href="<?php echo wp_login_url( $redirect_to );?>" ><?php $this->form_label('sec_login',__('Log in','rhl'))?></a>
				<?php if ( get_option( 'users_can_register' ) ) : ?>
				<a class="btn  btn-default action-login action-section" href="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login' ) ); ?>"><?php $this->form_label('sec_register',__('Register','rhl'))?></a>
				<?php endif; ?>
			<?php endif?>
			</div>
		</div>
		<div class="modal-footer">
			<div class="rhl-spinner"></div>
			<div class="action-login action-section">
				<input data-loading-text="<?php $this->form_attr('login_loading',__('Loading...','rhl'))?>" type="button" name="wp-submit" id="rhl_dologin" class="button-primary btn btn-primary" value="<?php $this->form_attr('btn_login',__('Log In','rhl'))?>" tabindex="1001" />
			</div>
			<div class="action-lostpassword action-section">
				<input data-loading-text="<?php $this->form_attr('lostpassword_loading',__('Loading...','rhl'))?>" type="button" name="wp-submit" id="rhl_lostpassword" class="button-primary btn btn-primary" value="<?php $this->form_attr('btn_lostpassword',__('Get New Password','rhl'))?>" tabindex="1002" />
			</div>
			<div class="action-rp action-section">
				<input data-loading-text="<?php $this->form_attr('rp_loading',__('Loading...','rhl'))?>" type="button" name="wp-submit" id="rhl_rp" class="button-primary btn btn-primary" value="<?php $this->form_attr('btn_rp',__('Reset Password','rhl'))?>" tabindex="1003" />
			</div>
			<?php if ( get_option( 'users_can_register' ) ) : ?>
			<div class="action-register action-section">
				<input data-loading-text="<?php $this->form_attr('register_loading',__('Loading...','rhl'))?>" type="button" name="wp-submit" id="rhl_register" class="button-primary btn btn-primary" value="<?php $this->form_attr('btn_register',__('Register','rhl'))?>" tabindex="1004" />
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
