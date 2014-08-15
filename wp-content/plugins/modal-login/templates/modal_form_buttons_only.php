<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2003
 **/

?><div class="modal fade rhlogin <?php echo $content?>" id="rh-modal-login" >
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
			<div class="action-login action-section">
				<form name="loginform" id="loginform" action="" method="post">
					<div class="span2">
						<input type="hidden" name="rhl_nonce" value="<?php echo $modal_login_nonce?>" />

						<?php do_action('login_form'); ?>

						<?php	if ( $interim_login ) { ?>
							<input type="hidden" name="interim-login" value="1" />
						<?php	} else { ?>
							<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
						<?php 	} ?>
							<input type="hidden" name="testcookie" value="1" />
						</p>
					</div>
				</form>
			</div>

			<div class="action-logout action-section">
				<img src="<?php echo RHL_URL.'css/images/spinner_32x32.gif'?>" />
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
				<?php do_action('register_form'); ?>
					<p id="reg_passmail"><?php $this->form_label('register_message',__('A password will be e-mailed to you.','rhl'))?></p>
					<br class="clear" />
				</form>
				<?php else : ?>
				<div class="alert-error">
					<?php _e('User registration is currently not allowed.','rhl')?>
				</div>
				<?php endif;?>					
			</div>


		</div>
		<div class="modal-footer">
			<div class="rhl-spinner"></div>
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
			<?php endif;?>	
		</div>
	</div>
</div>
