<?php

add_action('admin_menu', 'wplfta_create_menu');
function wplfta_create_menu() {
  //create new top-level menu
  add_menu_page('wordpress login form to anywhere  Plugin Settings', ' (Login Form)', 'administrator', 'wp_wplfta_setting', 'wplfta_settings_page',plugins_url('wp-login-form-to-anywhere/images/icon.png'));
  
  //call register settings function
  add_action( 'admin_init', 'register_wfltfa_settings' );
    
}
  

function register_wfltfa_settings() { 

  //register our settings
  register_setting( 'wplfta-settings-group', 'wplfta_user_txt' );
  register_setting( 'wplfta-settings-group', 'wplfta_password_txt' );
  register_setting( 'wplfta-settings-group', 'wplfta_remember_me_text' );
  register_setting( 'wplfta-settings-group', 'wplfta_after_login_link' );
  register_setting( 'wplfta-settings-group', 'wplfta_submit_buton_text' );
}

function wplfta_settings_page() {?><div class="wrap">
<h2>Wordpress Login Form to AnyWhere Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wplfta-settings-group' ); ?>
    <?php do_settings_sections( 'wplfta_settings_page' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">User Name Text</th>
        <td><input type="text" name="wplfta_user_txt" value="<?php echo wplfta_get_options('wplfta_user_txt'); ?>" />
                
         Default: UserName</td>
        </tr>
		<tr valign="top">
        <th scope="row">Password Text</th>
        <td><input type="text" name="wplfta_password_txt" value="<?php echo wplfta_get_options('wplfta_password_txt'); ?>" />
                
         Default: Password</td>
        </tr>
		<tr valign="top">
        <th scope="row">Remember Me Text</th>
        <td><input type="text" name="wplfta_remember_me_text" value="<?php echo wplfta_get_options('wplfta_remember_me_text'); ?>" />
                
         Default: Remember Me</td>
        </tr>
		<tr valign="top">
        <th scope="row">Submit Button Text</th>
        <td><input type="text" name="wplfta_submit_buton_text" value="<?php echo wplfta_get_options('wplfta_submit_buton_text'); ?>" />
                
         Default: Submit</td>
        </tr>	

		<tr valign="top">
        <th scope="row">After Login Redirect To</th>
        <td><input type="text" name="wplfta_after_login_link" value="<?php echo wplfta_get_options('wplfta_after_login_link'); ?>" />
                
         Default:  <?php  echo admin_url(); ?></td>
		
        </tr>
        
    </table>
   
    <?php submit_button(); ?></form>
	
	<div > 
	<h3>To add login form to your website </h3>
	<ul>
 	<li> <h4> Method 1</h4>or use short code <code>[wplfta_login_form]</code> to your page or post or text widget</li>
	<li> <h4> Method 2</h4>to use in theme use <code>&lt;?php echo do_shortcode('[wplfta_login_form]'); ?&gt;</code> to your template</li>
	</div>
	
</div>
<?php

 } 