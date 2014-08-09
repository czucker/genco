<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<!-- START #login-form -->
    <form action="<?php echo wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ; ?>" id="hb-login-form" name="hb-login-form" method="post" class="hb-login-form" >
        <p><input type="text" id="username" name="log" placeholder="<?php _e('Username', 'hbthemes'); ?>" class="required requiredField text-input"/></p>
        <p><input type="password" id="password" name="pwd" placeholder="<?php _e('Password', 'hbthemes'); ?>" class="required requiredField text-input"></p>
        <p class="hb-checkbox clearfix">
            <label><input name="rememberme" type="checkbox" id="rememberme" value="forever" class="hb-remember-checkbox" /><?php _e('Remember me?', 'hbthemes'); ?></label>
            <?php 
            if(get_option('users_can_register')) { ?>
            	<a href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=register" id="quick-register-button"><?php _e('Register','hbthemes'); ?></a>
            <?php } ?>
        </p>

        <a href="#" id="hb-submit-login-form" class="hb-button no-three-d hb-small-button"><?php _e('Login', 'hbthemes'); ?></a>

    </form>