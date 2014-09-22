<?php
/*
Plugin Name: WPF-Login
Plugin URI: http://wordpress.org/extend/plugins/wp-flogin/
Description: This is plugin will create a custom login, registration, and lost password page stand-alone or inserted into your current activated theme, logically overriding the 'wp-login.php' file.
Version: 1.08
Author: faina09
Author URI: http://profiles.wordpress.org/faina09
License: GPL
From wp-login plugin by: Eric Stolz - http://websitez.com
*/
global $fcl_default_options;
$fcl_default_options = Array(
    "general" => Array
        (
            "theme"         => "default",
            "login_type"    => "current",
            "login_page_id" => "",
        ),
    "style" => Array
        (
            "disable" => "Yes",
            "hide_back_to_link" => "No",
            "hide_pwd_recovery" => "No"
        ),
    "colors" => Array
        (
            "background"       => "#ffffff",
            "login_background" => "#ffffff",
            "label_font_color" => "#000000",
            "link_font_color"  => "#000000",
            "link_font_shadow_color" => "#84848"
        ),
    "images" => Array
        (
            "logo" => ""
        )
);

global $fcl_options;
$fcl_options = fcl_get_options();

global $fcl_require_authentication;
$fcl_require_authentication = false;

function fcl_get_options(){
	global $fcl_default_options;
	$user_options = get_option( 'fcl_custom_login_options' );
	if ( is_array( $user_options ) ):
		$options = array_merge($fcl_default_options, $user_options);
	else:
		$options = $fcl_default_options;
	endif;
	
	if ( strlen( $options['general']['theme'] ) == 0):
		$options['general']['theme'] = "default";
	endif;	
	return $options;
}

// Install plugin
if ( function_exists( 'register_activation_hook' ) ):
	register_activation_hook( __FILE__, 'fcl_install' );
endif;

//Install the options in the options table
if ( !function_exists('fcl_install') ):
	function fcl_install(){
		global $fcl_default_options;
		update_option( 'fcl_custom_login_options', $fcl_default_options );
	}
endif;

if ( !function_exists( 'fcl_check_configuration' ) ):
	function fcl_check_configuration(){
		global $fcl_options;
		if ( $fcl_options['general']['login_type']=="new" && $fcl_options['general']['login_page_id'] == "" ):
			fcl_show_admin_message("You must set the login page for the <a href='admin.php?page=wp_flogin'>WPF-Login</a> plugin before it will work properly.", true);
		endif;
	}
endif;

if ( !function_exists( 'fcl_show_admin_message' ) ):
	function fcl_show_admin_message($message, $error_message=false){
		if ( $error_message ):
			echo '<div id="message" class="error fade">';
		else:
			echo '<div id="message" class="updated fade">';
		endif;
	
		echo "<p><strong>$message</strong></p></div>";
	}
endif;

if ( !function_exists( 'fcl_login_class') ):
	function fcl_login_class($classes=''){
		$classes[] = 'login';
		return $classes;
	}
endif;

if ( !function_exists( 'fcl_login_head' ) ):
	function fcl_login_head(){
		global $fcl_options;
		do_action( 'login_enqueue_scripts' );
		do_action( 'login_head' );
		echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url(__FILE__) . 'themes/'.$fcl_options['general']['theme'].'/style.php" />';
	}
endif;

if ( !function_exists( 'fcl_login' ) ):
	function fcl_login($template){
		global $wp_query, $fcl_options;
		if ( is_page() ):
			$post_id = $wp_query->post->ID;
			if ( $post_id == $fcl_options['general']['login_page_id'] ):
				$template = dirname(__FILE__)."/wp-login_modified.php";
				add_action( 'wp_head', 'fcl_login_head' );
				add_filter( 'body_class','fcl_login_class' );
			endif;
		endif;
		return $template;
	}
endif;

if ( !function_exists( 'fcl_add_stylesheet' ) ):
	function fcl_add_stylesheet(){
		global $fcl_options;
		echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url(__FILE__) . 'themes/'.$fcl_options['general']['theme'].'/style.php" />';
	}
endif;

// Add wp-login hooker
add_action( 'init', 'fcl_check_login' );
if ( !function_exists( 'fcl_check_login' ) ):
	function fcl_check_login(){
		global $fcl_options;
		if ( endsWith( $_SERVER['SCRIPT_NAME'], "wp-login.php") ): 
			if ( $fcl_options['general']['login_type'] == "new" ):
				if ( array_key_exists( 'general', $fcl_options) && array_key_exists( 'login_page_id', $fcl_options['general'] ) ):
					if ( strlen($_SERVER['QUERY_STRING']) > 0 ):
						$diff = ( stripos( get_permalink( $fcl_options['general']['login_page_id'] ),"?" ) === false ) ? '?' : '&';
						header("Location: ".get_permalink( $fcl_options['general']['login_page_id'] ).$diff.$_SERVER['QUERY_STRING']);
					else:
						header("Location: ".get_permalink( $fcl_options['general']['login_page_id'] ));
					endif;
				endif;
			elseif ( $fcl_options['general']['login_type'] == "current") :
				add_action( 'login_head', 'fcl_add_stylesheet', 10, 0 );
			endif;
		elseif( $fcl_options['general']['login_type'] == "new" ):
			add_action( 'page_template', 'fcl_login' );
		endif;
	}
endif;

if ( !function_exists( 'fcl_get_themes' ) ):
	function fcl_get_themes(){
		$template_files = array();
		$template_directory = dirname(__FILE__)."/themes/";
		$template_dir = @ dir("$template_directory");
		if ( $template_dir ) {
			while ( ($file = $template_dir->read()) !== false ) {
				if($file != "." && $file != ".."):
					$template_files[] = $file;
				endif;
			}
			@ $template_dir->close();
		}
		return $template_files;
	}
endif;

if ( !function_exists( 'fcl_get_files' ) ):
	function fcl_get_files($theme="default"){
		global $fcl_options;
		$files = array();
		$dir = dirname(__FILE__)."/themes/".$fcl_options['general']['theme']."/";
		if ( is_dir( $dir ) ):
			if ( $dh = opendir($dir) ):
			while ( ( $file = readdir($dh) ) !== false ):
				if ( filetype( $dir . $file) == "file" ):
				$files[] = $file;
			  endif;
			endwhile;
			closedir( $dh );
			endif;
		endif;
		return $files;
	}
endif;

if ( !function_exists( 'fcl_admin_head_scripts' ) ):
	function fcl_admin_head_scripts(){
		wp_enqueue_script( 'jpicker', plugin_dir_url(__FILE__)."jpicker-1.1.6.min.js", array('jquery','jquery-ui-core'), '0.1' );
	}
endif;

if ( !function_exists( 'fcl_wp_flogin_page' ) ):
	function fcl_wp_flogin_page(){
		global $wpdb, $table_prefix, $fcl_options;
		$themes = fcl_get_themes();
		$pages = get_pages( array( 'post_status'=>'publish', 'sort_column'=>'post_title' ) );
		
		wp_register_style( 'wpf-login', plugins_url( '/css/wpf-login.css', __FILE__ ) );
		wp_enqueue_style( 'wpf-login' );
		wp_register_script( 'wpf-loginjs', plugins_url( '/js/wpf-login.js', __FILE__ ) );
		wp_enqueue_script( 'wpf-loginjs' );
		wp_register_style( 'jpickermin', plugins_url( '/css/jPicker-1.1.6.min.css', __FILE__ ) );
		wp_enqueue_style( 'jpickermin' );
		wp_register_style( 'jpicker', plugins_url( '/css/jPicker.css', __FILE__ ) );
		wp_enqueue_style( 'jpicker' );
		wp_register_script( 'jpickerjs', plugins_url( '/js/jPicker.js', __FILE__ ) );
		wp_enqueue_script( 'jpickerjs' );
		?>
		<div class="wrap">
			<?php
			if ( isset( $_POST['data'] ) ):
				if ( isset( $_FILES['logo'] ) ):
					$overrides = array( 'test_form' => false );
					$file = wp_handle_upload( $_FILES['logo'], $overrides );
					if ( array_key_exists( 'url', $file ) ):
						$_POST['data']['images']['logo'] = $file['url'];
					endif;
				endif;
				$c = get_option( 'fcl_custom_login_options' );

				if ( is_array( $c ) ):
					$d = array_merge( $c, $_POST['data'] );
				else:
					$d = $_POST['data'];
				endif;
				$u = update_option( 'fcl_custom_login_options', $d );
				if ( $u ):
					echo "<div class='alert-message success'>Your settings were successfully saved.</div>";
					//Now update options
					$fcl_options = fcl_get_options();
					fcl_check_configuration();
				else:
					echo "<div class='alert-message error'><p>Your settings could not be saved or are not changed. Please try again.</p></div>";
				endif;
			elseif ( isset( $_POST['newcontent'] ) ):
				$newcontent = stripslashes( $_POST['newcontent'] );
				$dir = dirname(__FILE__)."/themes/".$fcl_options['general']['theme']."/";
				$file = $dir.$_GET['file'];
				if ( is_writeable( $file ) ):
					//is_writable() not always reliable, check return value. see comments @ http://uk.php.net/is_writable
					$f = fopen( $file, 'w+' );
					if ($f !== FALSE):
						fwrite( $f, $newcontent );
						fclose( $f );
						echo "<div class='alert-message success'>Your changes were successfully saved.</div>";
					else:
						echo "<div class='alert-message error'><p>Your changes could not be saved. Please try again.</p></div>";
					endif;
				endif;
			endif;
			?>
			<div class="name"><h1>WPF-Login</h1></div>
			<div class="intro"><p>Configure the look and feel of your login form.</p></div>
			<div class="login_link">
				<a href="<?php echo home_url ( '/' ); ?>wp-login.php" target="_blank" class="btn">View Your Login Page</a>
			</div>
			<div style="clear: both;"></div>
			<ul class="pills">
				<li<?php if ( !isset( $_GET['act'] ) ) echo ' class="active"'; ?>><a href="" onClick="jQuery('.pills').find('li').removeClass('active'); jQuery('#settings').show('slow');jQuery('#editor').hide('slow');jQuery('#default_editor').hide('slow');jQuery(this).parent().addClass('active'); return false;">Settings</a></li>
				<li<?php if ( isset( $_GET['act'] ) ) { if ( $_GET['act'] == "editor" ) echo ' class="active"';} ?>><a href="" onClick="jQuery('.pills').find('li').removeClass('active'); jQuery('#settings').hide('slow');jQuery('#default_editor').hide('slow');jQuery('#editor').show('slow');jQuery(this).parent().addClass('active'); return false;">File Editor</a></li>
				<li<?php if ( isset( $_GET['act'] ) ) { if ( $_GET['act'] == "default_editor" ) echo ' class="active"';} ?>><a href="" onClick="jQuery('.pills').find('li').removeClass('active'); jQuery('#settings').hide('slow');jQuery('#editor').hide('slow');jQuery('#default_editor').show('slow');jQuery(this).parent().addClass('active'); return false;">Style Editor</a></li>
			</ul>
			<div id="settings"<?php if ( isset( $_GET['act'] ) ) echo ' style="display: none;"'; ?>>
				<form action="admin.php?page=wp_flogin" method="POST">
					<div class="field_name">
						Set Login Theme:
					</div>
					<div class="field_value">
						<select name="data[general][theme]">
						<option value="">Please select one...</option>
						<?php foreach($themes as $theme): ?>
							<option value="<?php echo $theme; ?>"<?php if ( $fcl_options['general']['theme'] == $theme ) echo " selected='selected'"; ?>><?php echo $theme; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="field_description_demo">
						The theme selected will be shown to users.<br/>
						Theme files are located here: <?php echo plugin_dir_url(__FILE__); ?>themes/<?php echo $fcl_options['general']['theme']; ?>/
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Set Login Type:
					</div>
					<div class="field_value_short">
						<p><input type="radio" name="data[general][login_type]" value="current" <?php if ( $fcl_options['general']['login_type'] == "current" ) echo " checked"; ?>/></p>
						<p><input type="radio" name="data[general][login_type]" value="new" <?php if ( $fcl_options['general']['login_type'] == "new" ) echo " checked"; ?>/></p>
					</div>
					<div class="field_description_demo">
						<p>Would you like to use the default WordPress page and have the ability to change the logo and colors?</p>
						<p>Would you like to place the WordPress login page inside of your current activated theme <strong><?php echo get_option( 'current_theme' ); ?></strong>?</p>
					</div>
					<div class="clearer"></div>

					<div id="login-page"<?php if ( $fcl_options['general']['login_type'] != "new" ) echo ' style="display: none;"'; ?>>
						<div class="field_name">
							Set Login Page:
						</div>
						<div class="field_value">
							<select name="data[general][login_page_id]">
							<option value="">Please select one...</option>
							<?php foreach($pages as $page): ?>
								<option value="<?php echo $page->ID; ?>"<?php if ( $fcl_options['general']['login_page_id'] == $page->ID) echo " selected='selected'"; ?>><?php echo $page->post_title; ?></option>
							<?php endforeach; ?>
							</select>
						</div>
						<div class="field_description_demo">
							The page selected will be used to display the login form. It is recommended that you create a new page called "Login" and select this page in the drop down.
						</div>
						<div class="clearer"></div>
					</div>
					<div class="buttons">
						<input type="submit" value="Save Settings" class="btn primary"/>
					</div>
				</form>
			</div>
			<div id="editor"<?php if ( !isset( $_GET['act'] ) ) echo ' style="display: none;"'; else if ( $_GET['act'] != "editor" ) echo ' style="display: none;"'; ?>>
				<?php
				$files = fcl_get_files( $fcl_options['general']['theme'] );

				if( isset ( $_GET['file']) ):
					$target = $_GET['file'];
				else:
					$target = $files[0];
				endif;
				
				$editable = false;
				$dir = dirname(__FILE__)."/themes/".$fcl_options['general']['theme']."/";
				$file = $dir.$target;
				if ( filesize( $file ) > 0 ):
					$f = fopen($file, 'r');
					$content = esc_textarea( fread( $f, filesize( $file ) ) );
				endif;
				
				if ( is_writable( $file ) ) :
					$editable = true;
				endif;
				?>
				<form action="" method="POST">
				<div class="content">
					<textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1"><?php echo $content ?></textarea>
				</div>
				<div class="action">
					<p><strong><span style="color: #999;">Files from the</span> <?php echo $fcl_options['general']['theme']; ?> <span style="color: #999;">theme:</span></strong></p>
					<?php if(count($files) > 0): ?>
						<ul>
						<?php foreach ( $files as $file ): ?>
							<li<?php if ( $target == $file ) echo ' class="active"'; ?>><a href="admin.php?page=wp_flogin&file=<?php echo $file; ?>&act=editor"><?php echo $file; ?></a></li>
						<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<p><input type="submit" class="btn<?php if ( $editable ) echo " primary"; ?>" value="Save Changes"<?php if ( !$editable ) echo " disabled"; ?>></p>
					<?php if(!$editable): ?>
						<p><em><?php _e('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.'); ?></em></p>
					<?php endif; ?>
				</div>
				</form>
			</div><!-- #editor -->
			<?php
			if ( isset( $fcl_options['images'] ) )
			{
				$fcl_options_images = strlen( $fcl_options['images']['logo'] ) > 0 ? 1 : 0;
				$fcl_options_logo = $fcl_options['images']['logo'];
				}
			else
			{
				$fcl_options_images = 0;
				$fcl_options_logo = "";
				}
			?>
			<div id="default_editor"<?php if ( !isset( $_GET['act'] ) ) echo ' style="display: none;"'; else if ( $_GET['act']!="default_editor" ) echo ' style="display: none;"'; ?>>
				<form action="admin.php?page=wp_flogin&act=default_editor" method="POST" <?php if ( $fcl_options_images == 0 ) echo ' enctype="multipart/form-data"'; ?> id="default_editor_form">
					<div class="field_name">
						Disable all styles on this page?
					</div>
					<div class="field_value">
						<select name="data[style][disable]">
							<option value="">Please select one…</option>
							<option value="No"<?php if ( $fcl_options['style']['disable'] == "No" ) echo ' selected'; ?>>No</option>
							<option value="Yes"<?php if ( $fcl_options['style']['disable'] == "Yes" ) echo ' selected'; ?>>Yes</option>
						</select>
					</div>
					<div class="field_description_demo">
						This allows you to disable all custom styles if you would like to use the default WordPress styles.
					</div>
					<div class="clearer"></div>
					<div <?php if ( $fcl_options['general']['login_type'] == "new" ) echo ' style="display: none;"'; ?>>
						<div class="field_name">
							Set Image:
						</div>
						<div class="field_value">
							<?php if ( $fcl_options_images > 0 ): ?>
								An image has been uploaded. <a href="" onClick="jQuery('#images_t').val(''); jQuery('#default_editor_form').submit(); return false;">Delete image</a>?
								<input id="images_t" type="hidden" name="data[images][logo]" value="<?php echo $fcl_options['images']['logo']; ?>" />
							<?php else: ?>
								<input type="file" name="logo" value="" />
							<?php endif; ?>
						</div>
						<div class="field_description_demo">
							<?php if ( $fcl_options_images > 0 ): ?>
								<img src="<?php echo $fcl_options['images']['logo']; ?>" />
							<?php else: ?>
								Here you can upload an image to change the default image for the login form.
							<?php endif; ?>
						</div>
						<div class="clearer"></div>
					</div>
					<div <?php if ( $fcl_options['general']['login_type'] == "new" ) echo ' style="display: none;"'; ?>>
						<div class="field_name">
							Set Background Color:
						</div>
						<div class="field_value">
							<input type="text" name="data[colors][background]" value="<?php echo $fcl_options['colors']['background']; ?>" class="Multiple" />
						</div>
						<div class="field_description">
							Here you can select the background color for the login page.
						</div>
						<div class="field_demo">
							
						</div>
						<div class="clearer"></div>
					</div>
					<div class="field_name">
						Set Login Background Color:
					</div>
					<div class="field_value">
						<input type="text" name="data[colors][login_background]" value="<?php echo $fcl_options['colors']['login_background']; ?>" class="Multiple" />
					</div>
					<div class="field_description">
						Here you can select the background color for the login form.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Set Label Font Color:
					</div>
					<div class="field_value">
						<input type="text" name="data[colors][label_font_color]" value="<?php echo $fcl_options['colors']['label_font_color']; ?>" class="Multiple" />
					</div>
					<div class="field_description">
						Here you can select the color of the font for the username and password fields.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Set Link Font Color:
					</div>
					<div class="field_value">
						<input type="text" name="data[colors][link_font_color]" value="<?php echo $fcl_options['colors']['link_font_color']; ?>" class="Multiple" />
					</div>
					<div class="field_description">
						Here you can select the color of the font for the links just below the login form.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Set Link Font Shadow Color:
					</div>
					<div class="field_value">
						<input type="text" name="data[colors][link_font_shadow_color]" value="<?php echo $fcl_options['colors']['link_font_shadow_color']; ?>" class="Multiple" />
					</div>
					<div class="field_description">
						Here you can select the color of the text shadow used for the links just below the login form.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Hide the 'back to blog' link?
					</div>
					<div class="field_value">
						<select name="data[style][hide_back_to_link]">
							<option value="">Please select one…</option>
							<option value="No"<?php if ( $fcl_options['style']['hide_back_to_link'] == "No" ) echo ' selected'; ?>>No</option>
							<option value="Yes"<?php if ( $fcl_options['style']['hide_back_to_link'] == "Yes" ) echo ' selected'; ?>>Yes</option>
						</select>
					</div>
					<div class="field_description">
						Here you can select if display or not the 'back to blog' link just below the login form.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="field_name">
						Hide the 'Lost your password?' link?
					</div>
					<div class="field_value">
						<select name="data[style][hide_pwd_recovery]">
							<option value="">Please select one…</option>
							<option value="No"<?php if ( $fcl_options['style']['hide_pwd_recovery'] == "No" ) echo ' selected'; ?>>No</option>
							<option value="Yes"<?php if ( $fcl_options['style']['hide_pwd_recovery'] == "Yes" ) echo ' selected'; ?>>Yes</option>
						</select>
					</div>
					<div class="field_description">
						Here you can select if display or not the 'Lost your password?' link just below the login form.
					</div>
					<div class="field_demo">
						
					</div>
					<div class="clearer"></div>
					<div class="buttons">
						<input type="submit" value="Save Settings" class="btn primary"/>
					</div>
				</form>
			</div>
			<div class="clear"></div>
			<div class="footer"></div>
		</div>
		<?php
	}
endif;

// Add options page in the admin menu
add_action( 'admin_menu', 'wp_flogin_menu' );
function wp_flogin_menu() {
	add_options_page( 'WPF-Login settings', 'WPF-Login', 'manage_options', 'wp_flogin', 'fcl_wp_flogin_page' );
}

if(is_admin()):
	add_action( 'admin_notices', 'fcl_check_configuration' );
	if ( isset( $_GET['page'] ) ):
		if ( $_GET['page'] == "wp_flogin" ):
			add_action( 'init', 'fcl_admin_head_scripts' );
		endif;
	endif;
endif;

if ( !function_exists('startsWith') ):
function startsWith($haystack, $needle) {
   return ( strpos( $haystack, $needle) === 0);
}
endif;

if ( !function_exists('endsWith') ):
function endsWith($haystack, $needle) {
   return ( strpos( strrev($haystack), strrev($needle) ) === 0);
}
endif;
?>