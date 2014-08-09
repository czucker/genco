<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Login Page
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

<?php 
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
	$main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?> 
<!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
	<div class="container">
	<?php 
		$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
		$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

		if ( $sidebar_layout == "default" || $sidebar_layout == "" ) {
			$sidebar_layout = hb_options('hb_page_layout_sidebar'); 
			$sidebar_name = hb_options('hb_choose_sidebar');
		}
		
	?>
		<div class="row <?php echo $sidebar_layout; ?> main-row">

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<!-- BEGIN .hb-main-content -->
			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
				<div class="col-9 hb-equal-col-height hb-main-content">
			<?php } else { ?>
				<div class="col-12 hb-main-content">
			<?php } ?>

			<?php if ( get_the_content() ) {
				the_content(); ?>
				<div class="hb-separator extra-space"><div class="hb-fw-separator"></div></div>
			<?php } ?>

			<?php
			global $current_user;
		    get_currentuserinfo();
			if ( !is_user_logged_in() ) { ?>
				<div class="hb-login-box">
				
					<!-- START #login-form -->
				    <form action="<?php echo wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ; ?>" id="hb-login-form-tmp" name="hb-login-form-tmp" method="post" class="hb-login-form" >
				        <p><input type="text" id="username-tmp" name="log" placeholder="<?php _e('Username', 'hbthemes'); ?>" class="required requiredField text-input"/></p>
				        <p><input type="password" id="password-tmp" name="pwd" placeholder="<?php _e('Password', 'hbthemes'); ?>" class="required requiredField text-input"></p>
				        <p class="hb-checkbox clearfix">
				            <label><input name="rememberme" type="checkbox" id="rememberme-tmp" value="forever" class="hb-remember-checkbox" /><?php _e('Remember me?', 'hbthemes'); ?></label>
				            <?php 
				            if(get_option('users_can_register')) { ?>
				            	<a href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=register" id="quick-register-button"><?php _e('Register','hbthemes'); ?></a>
				            <?php } ?>
				        </p>
				        <a href="#" id="hb-submit-login-form-tmp" class="hb-button no-three-d hb-small-button"><?php _e('Login', 'hbthemes'); ?></a>
				    </form>

				</div>
			<?php } else {
				echo '<div class="hb-logout-box">';
				echo '<div class="avatar-image">' . get_avatar( $current_user -> ID, 64 ) . '</div>';
				echo '<h5>';
				printf ( __('You are logged in as ' , 'hbthemes')); echo '<strong>' . $current_user->display_name . '</strong>.';
				echo '</h5><a class="hb-button hb-small-button" href="' . admin_url() . '">' . __('View your dashboard','hbthemes') . '</a>';
				echo '<small><a href="' . wp_logout_url(get_permalink()) . '">' . __('Log out from this account.', 'hbthemes') . '</a></small>';
				echo '<div class="big-overlay"><i class="hb-moon-user"></i></div>';
				echo '</div>';
			}
			?>

			</div>
			<!-- END .hb-main-content -->

			<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
			<!-- BEGIN .hb-sidebar -->
			<div class="col-3  hb-equal-col-height hb-sidebar">
				<?php 
				if ( $sidebar_name && function_exists('dynamic_sidebar') )
					dynamic_sidebar($sidebar_name);
				?>
			</div>
			<!-- END .hb-sidebar -->
			<?php } ?>
		
		</div>
		<!-- END .row -->

	</div>
	<!-- END .container -->

</div>
<!-- END #main-content -->

</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>