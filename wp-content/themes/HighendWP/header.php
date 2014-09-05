<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
 ?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>

	<!-- START head -->
	<head>

	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>">
	<?php if ( hb_options('hb_responsive') ) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php } ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


	<?php
	$favicon = hb_options('hb_favicon');

	if ( $favicon ) { ?>
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
	<?php } ?>

	<?php if (hb_options('hb_apple_icon_144')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo hb_options('hb_apple_icon_144'); ?>" />
	<?php } ?>
	<?php if (hb_options('hb_apple_icon_114')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo hb_options('hb_apple_icon_114') ?>" />
	<?php } ?>
	<?php if (hb_options('hb_apple_icon_72')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo hb_options('hb_apple_icon_72') ?>" />
	<?php } ?>
	<?php if (hb_options('hb_apple_icon')) { ?>
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo hb_options('hb_apple_icon'); ?>" />
	<?php } ?>

	<?php if ( hb_options('hb_ios_bookmark_title') && hb_options('hb_ios_bookmark_title') != "") { ?>
	<meta name="apple-mobile-web-app-title" content="<?php echo hb_options('hb_ios_bookmark_title'); ?>">
	<?php } ?>

	<!--[if IE 8 ]>
	<link href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" media="screen" rel="stylesheet" type="text/css">
	<![endif]-->

	<!--[if lte IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/scripts/html5shiv.js" type="text/javascript"></script>
	<![endif]-->

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen,print" />

	<?php wp_head(); ?>

	<!-- Theme Options Font Settings -->
	<style type="text/css">
	<?php
		
		$font_weight = "400";
		$font_style = "normal";
		$font_subsets = hb_options('hb_font_body_subsets');

		// Body Font
		if ( hb_options('hb_font_body') == 'hb_font_custom' ){
			$font_face = hb_options('hb_font_body_face');
			$font_weight = hb_options('hb_font_body_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'body, .team-position, .hb-single-next-prev .text-inside, .hb-dropdown-box.cart-dropdown .buttons a, input[type=text], textarea, input[type=email], input[type=password], input[type=tel], #fancy-search input[type=text], #fancy-search .ui-autocomplete li .search-title, .quote-post-format .quote-post-wrapper blockquote, table th, .hb-button, input[type=submit], a.read-more, blockquote.pullquote, blockquote, .hb-skill-meter .hb-skill-meter-title, .hb-tabs-wrapper .nav-tabs li a {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_body_size') .'px;
				line-height: '. hb_options('hb_font_body_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_body_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Navigation Font
		if ( hb_options('hb_font_navigation') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_nav_subsets');
			$font_face = hb_options('hb_font_navigation_face');
			$font_weight = hb_options('hb_font_nav_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo '#main-nav ul.sub-menu li a, #main-nav ul.sub-menu ul li a, #main-nav, #main-nav li a, .light-menu-dropdown #main-nav > li.megamenu > ul.sub-menu > li > a, #main-nav > li.megamenu > ul.sub-menu > li > a {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_navigation_size') .'px;
				letter-spacing: '. hb_options('hb_font_navigation_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Copyright Font
		if ( hb_options('hb_font_copyright') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_copyright_subsets');
			$font_face = hb_options('hb_font_copyright_face');
			$font_weight = hb_options('hb_font_copyright_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo '#copyright-wrapper, #copyright-wrapper a {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_copyright_size') .'px;
				line-height: '. hb_options('hb_font_copyright_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_copyright_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 1
		if ( hb_options('hb_font_h1') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h1_subsets');
			$font_face = hb_options('hb_font_h1_face');
			$font_weight = hb_options('hb_font_h1_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h1, article.single h1.title {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h1_size') .'px;
				line-height: '. hb_options('hb_font_h1_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h1_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 2
		if ( hb_options('hb_font_h2') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h2_subsets');
			$font_face = hb_options('hb_font_h2_face');
			$font_weight = hb_options('hb_font_h2_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h2, #hb-page-title h2, .post-content h2.title {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h2_size') .'px;
				line-height: '. hb_options('hb_font_h2_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h2_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 3
		if ( hb_options('hb_font_h3') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h3_subsets');
			$font_face = hb_options('hb_font_h3_face');
			$font_weight = hb_options('hb_font_h3_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h3, #respond h3, h3.title-class, .hb-callout-box h3, .hb-gal-standard-description h3 {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h3_size') .'px;
				line-height: '. hb_options('hb_font_h3_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h3_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 4
		if ( hb_options('hb_font_h4') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h4_subsets');
			$font_face = hb_options('hb_font_h4_face');
			$font_weight = hb_options('hb_font_h4_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h4, .widget-item h4, .content-box h4, .feature-box h4.bold {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h4_size') .'px;
				line-height: '. hb_options('hb_font_h4_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h4_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 5
		if ( hb_options('hb_font_h5') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h5_subsets');
			$font_face = hb_options('hb_font_h5_face');
			$font_weight = hb_options('hb_font_h5_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h5, #comments h5, #respond h5, .testimonial-author h5 {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h5_size') .'px;
				line-height: '. hb_options('hb_font_h5_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h5_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Heading 6
		if ( hb_options('hb_font_h6') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_h6_subsets');
			$font_face = hb_options('hb_font_h6_face');
			$font_weight = hb_options('hb_font_h6_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo 'h6, h6.special {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_font_h6_size') .'px;
				line-height: '. hb_options('hb_font_h6_line_height') .'px;
				letter-spacing: '. hb_options('hb_font_h6_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		// Pre-Footer Callout
		if ( hb_options('hb_pre_footer_font') == 'hb_font_custom' ){
			$font_subsets = hb_options('hb_font_pre_footer_subsets');
			$font_face = hb_options('hb_pre_footer_font_face');
			$font_weight = hb_options('hb_font_pre_footer_weight');
			VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
			echo '#pre-footer-area {
				font-family: "' . $font_face . '", sans-serif;
				font-size: '. hb_options('hb_pre_footer_font_size') .'px;
				line-height: '. hb_options('hb_pre_footer_line_height') .'px;
				letter-spacing: '. hb_options('hb_pre_footer_letter_spacing') .'px;
				font-weight: '.$font_weight.';
			}';
		}

		VP_Site_GoogleWebFont::instance()->register_and_enqueue();
	?>
	</style>

	</head>
	<!-- END head -->

	<?php
		$smooth_scroll = hb_options('hb_smooth_scrolling');
		$smooth_scroll_class = "";
		
		if ( $smooth_scroll ){
			$smooth_scroll_class = ' data-smooth-scroll="1"';
		} else {
			$smooth_scroll_class = ' data-smooth-scroll="0"';
		}

		$fixed_footer_data = hb_options('hb_fixed_footer_effect');
		$fixed_footer_class = ' data-fixed-footer="0"';

		if ( $fixed_footer_data ){
			$fixed_footer_class = ' data-fixed-footer="1"';
		}
		

		$bg_image_render = "";

		if ( hb_options('hb_global_layout') == 'hb-boxed-layout' || vp_metabox('misc_settings.hb_boxed_stretched_page') == 'hb-boxed-layout' || ( isset($_GET['layout']) && $_GET['layout'] == 'boxed') ){
			$bg_url = hb_options('hb_default_background_image');
			$bg_repeat = ' background-repeat: ' . hb_options('hb_background_repeat') . ';';
			$bg_attachment = ' background-attachment: ' . hb_options('hb_background_attachment') . ';';
			$bg_position = ' background-position: ' . hb_options('hb_background_position') . ';';
			$bg_size = ' background-size: auto auto;';

			if ( hb_options('hb_background_stretch') ){
				$bg_size = " background-size: cover;";
			}

			if( hb_options('hb_default_background_image') && hb_options('hb_upload_or_predefined_image') == 'upload-image' ) {
				$bg_url = hb_options('hb_default_background_image');
				$bg_image_render = ' style="background-image: url('. $bg_url .');' . $bg_repeat . $bg_attachment . $bg_position . $bg_size . '"';
			} 

			if ( hb_options('hb_upload_or_predefined_image') == 'predefined-texture' ) {
				$bg_image_render = ' style="background-image: url('. hb_options('hb_predefined_bg_texure') .'); background-repeat:repeat; background-position: center center; background-attachment:scroll; background-size:initial;"';
			}

			if ( vp_metabox('background_settings.hb_background_page_settings') == "image" && vp_metabox('background_settings.hb_page_background_image') ) {
				$bg_url = vp_metabox('background_settings.hb_page_background_image');
				$bg_image_render = ' style="background-image: url('. $bg_url .');' . $bg_repeat . $bg_attachment . $bg_position . $bg_size . '"';
			}

			if ( vp_metabox('background_settings.hb_background_page_settings') == "color" ) {
				$bg_image_render = ' style="background-color: ' . vp_metabox('background_settings.hb_page_background_color') . ';';
			}
		}

		$extra_body_class = vp_metabox('misc_settings.hb_page_extra_class');
		if ( hb_options('hb_queryloader') ){
			$extra_body_class .= ' hb-preloader';
		}

		if ( vp_metabox('misc_settings.hb_special_header_style') ){
			$extra_body_class .= ' hb-special-header-style';
		}
	?>

	<!-- START body -->
	<body <?php body_class($extra_body_class); echo $smooth_scroll_class; echo $fixed_footer_class; echo $bg_image_render; ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

	<?php
		$hb_layout_class = hb_options('hb_global_layout');

		$page_global_layout = vp_metabox('misc_settings.hb_boxed_stretched_page');
		if ( $page_global_layout != "default" && $page_global_layout ) {
			$hb_layout_class = $page_global_layout;
		}

		if ( isset($_GET['layout']) && $_GET['layout'] == 'boxed' ){
			$hb_layout_class = 'hb-boxed-layout';
		}

		$hb_shadow_class = "no-shadow";
		if ( hb_options('hb_boxed_shadow') ){
			$hb_shadow_class = "with-shadow";
		}

		$hb_content_width = "width-1140";
		if ( hb_options('hb_content_width') == '940px' ){
			$hb_content_width = "width-940";
		} else if ( hb_options('hb_content_width') == 'fw-100' ) {
			$hb_content_width = "fw-100";
		}

		$hb_logo_alignment = "";
		if ( hb_options('hb_header_layout_style') != "nav-type-2 centered-nav" )
			$hb_logo_alignment = hb_options('hb_logo_alignment');

		$sticky_shop_button = "";
		if ( hb_options('hb_enable_sticky_shop_button') && class_exists('Woocommerce') ){
			$sticky_shop_button = " with-sticky-shop-button";
		}

		$hb_resp = "";
		if ( hb_options('hb_responsive') ) {
			$hb_resp = " hb-responsive";
		}

		$hb_logo_alignment = hb_options('hb_logo_alignment');

		if ( isset($_GET['header']) ){
    		$header_val = $_GET['header'];

    		if ($header_val == '1-3' || $header_val == '1-4' || $header_val == '2-3' || $header_val == '2-4'){
				$hb_logo_alignment = ' align-logo-right';
			}

		}

	?>

	<?php
		if (hb_options('hb_responsive')){
			echo hb_mobile_menu();
		}
	?>

	<!-- BEGIN #main-wrapper -->
	<div id="main-wrapper" class="<?php if ( vp_metabox('misc_settings.hb_onepage') ) { echo 'hb-one-page '; } echo $hb_layout_class; echo ' ' . hb_options('hb_boxed_layout_type'); echo $hb_logo_alignment; echo ' ' . $hb_shadow_class; echo $hb_logo_alignment; echo ' ' . $hb_content_width; echo $sticky_shop_button . $hb_resp; echo ' ' . hb_options('hb_header_layout_style'); ?>">

		<?php
		$additional_class = "";
		if ( hb_options('hb_header_layout_style') == "nav-type-1 nav-type-4" ) {
	    	$additional_class .= "special-header";
		}
		if ( !hb_options('hb_top_header_bar') ) {
			$additional_class .= " without-top-bar";	
		}
		?>

		<?php if ( !is_page_template('page-blank.php') ) { ?>
		<!-- BEGIN #hb-header -->
		<header id="hb-header" class="<?php echo $additional_class; ?>">

			<?php get_template_part( 'includes/header' , 'top-bar' ); ?>
			<?php get_template_part( 'includes/header' , 'navigation' ); ?>

		</header>
		<!-- END #hb-header -->

		<?php get_template_part ( 'includes/header' , 'page-title' ); ?>
		<?php get_template_part( 'includes/header' , 'slider-section'); ?>
		<?php } ?>