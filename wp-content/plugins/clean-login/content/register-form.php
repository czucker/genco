<div class="cleanlogin-container cleanlogin-full-width">
	<form class="cleanlogin-form" method="post" action="#">

		<fieldset>

			<div class="cleanlogin-field">
				<input class="cleanlogin-field-username" type="text" name="username" value="" placeholder="<?php echo __( 'Username', 'cleanlogin' ); ?>">
			</div>
			
			<div class="cleanlogin-field">
				<input class="cleanlogin-field-email" type="email" name="email" value="" placeholder="<?php echo __( 'E-mail', 'cleanlogin' ); ?>">
			</div>

			<div class="cleanlogin-field-website">
				<label for='website'>Website</label>
				<input type='text' name='website' value=" ">
			</div>
			
			<div class="cleanlogin-field">
				<input class="cleanlogin-field-password" type="password" name="pass1" value="" autocomplete="off" placeholder="<?php echo __( 'New password', 'cleanlogin' ); ?>">
			</div>
			
			<div class="cleanlogin-field">
				<input class="cleanlogin-field-password" type="password" name="pass2" value="" autocomplete="off" placeholder="<?php echo __( 'Confirm password', 'cleanlogin' ); ?>">
			</div>

			<?php /*check if captcha is checked */ if ( get_option( 'cl_antispam' ) == 'on' ) : ?>
				<div class="cleanlogin-field">
					<img src="<?php echo plugins_url( 'captcha', __FILE__ ); ?>"/>
					<input class="cleanlogin-field-spam" type="text" name="captcha" value="" autocomplete="off" placeholder="<?php echo __( 'Type the text above', 'cleanlogin' ); ?>">
				</div>
			<?php endif; ?>


		</fieldset>

		<div>	
			<input type="submit" value="<?php echo __( 'Register', 'cleanlogin' ); ?>" name="submit" onclick="this.form.submit(); this.disabled = true;">
			<input type="hidden" name="action" value="register">		
		</div>

	</form>
</div>