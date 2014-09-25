<?php
	$register_url = get_option( 'cl_register_url', '');
	$restore_url  = get_option( 'cl_restore_url', '');
?>
<div class="cleanlogin-container">		

	<form class="cleanlogin-form" method="post" action="#">
			
		<fieldset>
			<div class="cleanlogin-field">
				<input class="cleanlogin-field-username" type="text" name="log" placeholder="<?php echo __( 'Username', 'cleanlogin' ); ?>">
			</div>
			
			<div class="cleanlogin-field">
				<input class="cleanlogin-field-password" type="password" name="pwd" placeholder="<?php echo __( 'Password', 'cleanlogin' ); ?>">
			</div>
		</fieldset>
		
		<fieldset>
			<input class="hb-button no-three-d hb-small-button" type="submit" value="<?php echo __( 'Login', 'cleanlogin' ); ?>" name="submit">
			<input type="hidden" name="action" value="login">
			
			<div class="cleanlogin-field cleanlogin-field-remember">
				<input type="checkbox" name="rememberme" value="forever">
				<label><?php echo __( 'Remember?', 'cleanlogin' ); ?></label>
			</div>
		</fieldset>
		
		<div class="cleanlogin-form-bottom">
			
			<?php if ( $restore_url != '' )
				echo "<a href='$restore_url' class='cleanlogin-form-pwd-link'>". __( 'Lost password?', 'cleanlogin' ) ."</a>";
			?>

			<?php if ( $register_url != '' )
				echo "<a href='$register_url' class='cleanlogin-form-register-link'>". __( 'Register', 'cleanlogin' ) ."</a>";
			?>
						
		</div>
		
	</form>

</div>
