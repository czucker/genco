<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
?>
<?php
	$protocol = $_SERVER["SERVER_PROTOCOL"];
	if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
		$protocol = 'HTTP/1.0';
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Retry-After: 600' );
?>

<!DOCTYPE HTML>
<!--[if lt IE 7 ]<html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="hb-maintenance">

<head>

<!-- Basic page tags -->
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

<?php
	$favicon = hb_options('hb_favicon');
	$apple_icon = hb_options('hb_apple_icon');

	if ( $favicon ) { ?>
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
	<?php }

	if ($apple_icon) { ?>
	<link rel="apple-touch-icon" href="<?php echo $apple_icon; ?>" />
	<?php } ?>

<!--[if IE 7 ]>
<link href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" media="screen" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if IE 8 ]>
<link href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" media="screen" rel="stylesheet" type="text/css">
<![endif]-->

<!--[if lte IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/scripts/html5shiv.js" type="text/javascript"></script>
<![endif]-->

<title><?php _e('Under Construction | ', 'hbthemes'); ?><?php echo home_url(); ?></title>

<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />

<?php wp_head(); ?>

<?php 
	// Custom CSS Code from Theme Options
	$custom_css_code = hb_options('hb_custom_css');
	if ($custom_css_code){
		echo '<style type="text/css">' . $custom_css_code . '</style>';
	}
?>

</head>
<!-- END head -->

<?php
	$layout_position = hb_options('hb_maintenance_layout_position');
	if ( isset ($_GET['layout_position']) ){
		$layout_position = $_GET['layout_position'];
	}
?>

<body <?php
	if ( hb_options('hb_maintenance_bg_color') ){
		echo 'style="background-color: ' . hb_options('hb_maintenance_bg_color');
		if ( hb_options('hb_maintenance_bg_image') ){
			echo '; background-image: url('. hb_options('hb_maintenance_bg_image') .'); background-attachment: fixed; background-size: cover; background-position: 50% 50%; background-repeat: no-repeat no-repeat;' . '"';
		} else {
			echo '"';
		}
	} 
	echo ' class="hb-maintenance-page '. $layout_position .'"';
?>>

	<!-- BEGIN .active_textute -->
	<div class="active_texture"></div>
	<!-- END .active_texture -->

	<!-- BEGIN .small-container -->
	<div class="small-container" id="hb-maintenance">


		<?php if ( hb_options('hb_maintenance_logo') ) { ?>
		<div id="maintenance-logo">
			<img src="<?php echo hb_options('hb_maintenance_logo'); ?>" alt="Logo" />
		</div>
		<?php } ?>

		<?php if ( hb_options('hb_maintenance_content') ) { ?>
		<div class="maintenance-content">
			<?php echo do_shortcode(hb_options('hb_maintenance_content')); ?>
		</div>
		<?php } ?>

		<?php if ( hb_options('hb_maintenance_enable_countdown' ) ) { 
			$countdown_date = hb_options('hb_countdown_date');
			$countdown_hour = hb_options('hb_countdown_hours');
			$countdown_minute = hb_options('hb_countdown_minutes');
			$countdown_date = explode('-', $countdown_date);
			$countdown_date[1] = strtolower(date("F", mktime(0, 0, 0, $countdown_date[1], 10)));
			$countdown_style = hb_options('hb_countdown_style');
		?>

		<script>
			jQuery(document).ready(function(){
				jQuery("#hb-countdown").countdown({
					date: "<?php echo $countdown_date[2]; ?> <?php echo $countdown_date[1]; ?> <?php echo $countdown_date[0]; ?> <?php echo $countdown_hour; ?>:<?php echo $countdown_minute; ?>:00",
					format: "on"
				});
			});
		</script>

		<ul id="hb-countdown" class="<?php echo $countdown_style; ?>">
			<li>
				<span class="days timestamp">00</span>
				<span class="timeRef"><?php _e('days','hbthemes'); ?></span>
			</li>
			<li>
				<span class="hours timestamp">00</span>
				<span class="timeRef"><?php _e('hours', 'hbthemes'); ?></span>
			</li>
			<li>
				<span class="minutes timestamp">00</span>
				<span class="timeRef"><?php _e('minutes','hbthemes'); ?></span>
			</li>
			<li>
				<span class="seconds timestamp">00</span>
				<span class="timeRef"><?php _e('seconds','hbthemes'); ?></span>
			</li>
		</ul>

		<?php } ?>
		

	<div id="maintenance-footer">
		<p><?php echo do_shortcode(hb_options('hb_copyright_line_text')); ?></p>
		<?php
			if (hb_options('hb_enable_backlink')){
				echo ' <a href="http://www.mojomarketplace.com/store/hb-themes?r=hb-themes&utm_source=hb-themes&utm_medium=textlink&utm_campaign=themesinthewild">Theme by HB-Themes.</a>';
			}
		?>
		<ul class="social-list">
            <?php
                $hb_socials = hb_options('hb_top_header_socials');
                if ( !empty ( $hb_socials ) ) {
                    foreach ($hb_socials as $hb_social) {
                    ?>
                    <li>
                        <a href="<?php echo hb_options('hb_' . $hb_social . '_link'); ?>" original-title="<?php echo ucfirst($hb_social); ?>"><i class="hb-moon-<?php echo $hb_social; ?>"></i></a> 
                    </li>
                    <?php
                    }
			    }
			?>        
		</ul>
	</div>

	</div>
	<!-- END .small-container -->

	<!-- BEGIN wp_foot -->
	<?php
		// Google Analytics from Theme Options
		$google_analytics_code = hb_options('hb_analytics_code');
		if ($google_analytics_code){
			echo $google_analytics_code;
		}

		// Custom Script from Theme Options
		$custom_script_code = hb_options('hb_custom_script');
		if ($custom_script_code){
			echo '<script type="text/javascript">' . $custom_script_code . '</script>';
		}
	?>
<?php wp_footer(); ?>
</body>

</html>