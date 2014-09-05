var $j = jQuery.noConflict();
var $masonry_container = $j('.masonry-holder');
var search_in_menu = 0;

var is_safari = false;
if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {is_safari = true;}
if ( $j('body').hasClass('page-id-323') ){ is_safari = true; }

var hb_js = function(){
	hb_is_mobile();
    hb_menu_init();
    hb_menu_search();
	hb_init_tooltip();
	hb_parallax_init();
    hb_max_height_fixes();
    hb_header_dropdown();
    hb_scroll_top_init();
    hb_fit_video();
    hb_anim_content();
    hb_masonry();
    hb_to_top_click();
    hb_nice_scroll_init();
    hb_placeholder_fixes();
    hb_fw_sections();
    hb_fancy_search();
    hb_click_forms();
    hb_flexslider_hover();
    hb_like_init();
    hb_mini_contact_form();
    hb_header_effect();
    hb_init_mejs();
    hb_validations();
    hb_fixed_footer_init();
    hb_ajax_search();
    hb_init_lightbox();
    hb_single_blog_scripts();
    hb_init_shortcodes();
    hb_counter();
    hb_charts();
    hb_progress_bar();
    hb_contact_forms();
    hb_contact_forms_spec();
    hb_onepage_nav();
    hb_animated_contents();
    hb_center_me();
    hb_woo_stuff();
    hb_count_gallery_filters();
    hb_faq_filter();
    hb_smooth_scroll();
};

$j(document).ready(function () {
	"use strict";
	window.hb_js();
});

$j(window).load(function() {
    hb_init_standard_gallery();
	hb_init_fw_gallery();
	hb_modal_on_load();
});

$j(window).scroll(function () {
	hb_animated_contents();
	hb_counter();
	hb_charts();
	hb_progress_bar();
});

$j(window).resize(function(){
	if ( is_responsive() ) {
		hb_fw_sections();
		hb_center_me();
		hb_fixed_footer_init();
		hb_max_height_fixes();
	}
});


/*************************** Functions ***************************/

/* Check if mobile device */
function hb_is_mobile(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$j('body').addClass('mobile mobile-device');
	}
}


/* Check if responsive is enabled */
function is_responsive(){
	
	if ( $j('#main-wrapper').hasClass('hb-responsive') ){
		return true;
	}

	return false;
}

/* Check if element exists */
jQuery.exists = function (selector) {
    return ($j(selector).length > 0);
};

/* Tooltip Init */
function hb_init_tooltip(){
	$j('body').tooltip({selector: '[rel=tooltip]'});
}

/* Animations when element is visible */
function hb_animated_contents() {
    if ($j.exists(".hb-animate-element") && $j.inviewport && !$j('body').hasClass('mobile')) {
        $j(".hb-animate-element:in-viewport").each(function (e) {
            var t = $j(this);
            var delay = t.attr('data-delay');

            if (typeof delay == 'undefined' || delay == ''){
				delay = 80;
            }

            if (!t.hasClass("hb-in-viewport")) {
                setTimeout(function () {
                    t.addClass("hb-in-viewport");
                }, delay);
            }
        });
    }
}

/* Check if is touch device */
function is_touch_device() {
	return !!('ontouchstart' in window) || !! ('onmsgesturechange' in window);
}

/* FitVids initialization */
function hb_fit_video() {
    $j(".fitVids, #pp_full_res").fitVids();
}

/* Placeholder Polyfill initialization */
function hb_placeholder_fixes() {
    $j('textarea').simplePlaceholder();
	$j('input[type=text],input[type=email]').simplePlaceholder();
}

/* SuperFish initialization */
function hb_menu_init(){
	$j(".sf-menu").superfish({
		delay: 50,
		speed: 200,
		speedOut: 100,
		autoArrows: true,
		disableHI: true,
		animation: {opacity:'show'},
		easing: 'easeOutQuad'
	});

	// Sub Indicators for the dropdown
	if ($j('#main-nav').length && !$j('#main-nav').hasClass('sf-subbed')){
		$j('#main-nav li').each(function(){
			$j(this).parent().addClass('sf-subbed');
			if($j(this).find('> ul').length > 0) {
				 $j(this).addClass('has-ul');
				 $j(this).find('> a').append('<i class="sf-sub-indicator icon-angle-right"></i>');
			}
		});
	}

	// Move current language to the top
	if ( $j('.language-selector').length ){
		var lang = $j('.language-selector').find('.active-language .icl_lang_sel_native').html();
		if (lang !== "") {
			$j('#hb-current-lang .lang-val').html(lang);
		}
	}

	// Mobile Menu
	function show_mobile_menu () {
		$j('body').addClass('mobile-menu-open');
		setTimeout(function () {
			$j('#main-wrapper').on('click', clear_mobile_menu);
		}, 500);
	}
	
	jQuery('#show-nav-menu, .mobile-menu-close').on('touchstart click', function (e) {
		e.preventDefault();
		if ($j('body').hasClass('mobile-menu-open')) {
			hide_mobile_menu();
		} else {
			show_mobile_menu();
		}
	});

	$j('#mobile-menu #menu-main li a').on('click', hide_mobile_menu);


	function hide_mobile_menu () {
		$j('body').removeClass('mobile-menu-open');
		$j('#main-wrapper').off('click', clear_mobile_menu);
	}
		
	function clear_mobile_menu () {
		$j('body').removeClass('mobile-menu-open');
		hide_mobile_menu();
	}

}

/* Make Elements to have equal heights */
function hb_max_height_fixes() {
	// Max Height MegaMenu
	var max;
	if ( $j('.megamenu').length && $j(window).width() > 767 ){
		var element;
		var first_ul;
		var $mega_lis;

		$j('.megamenu').each(function() {
			element = $j(this);
			first_ul = element.find(">ul").css("display", "block");
			$mega_lis = first_ul.find('>li');
			$mega_lis.css("height", "auto");
			max = Math.max.apply(Math, $mega_lis.map(function() { return $j(this).height(); }));
			$mega_lis.css("height", max);
			first_ul.css("display", "none");
		});
	}

	// Max Height Footer Columns
	if ($j('.widget-column') && $j(window).width() > 767){
		var $footer_cols = $j('#footer .widget-column');
		$footer_cols.css("height", "auto");
		max = Math.max.apply(Math, $footer_cols.map(function() { return $j(this).height(); }));
		$footer_cols.css("height", max);
	} else if ( $j(window).width() <  767) {
		$j('#footer .widget-column').css("height", "auto");
	}
}

/* Show dropdown menu on hover */
function hb_header_dropdown() {
	var $current;
	var $dropdown;
	
	$j('body').on("mouseenter", ".top-widget, .share-holder", function () {
	    $dropdown = $j(this).find('.hb-dropdown-box');
	    if ($dropdown.hasClass('dropdown-visible')) {
			$dropdown.removeClass('dropdown-visible');
		} else {
			$dropdown.addClass('dropdown-visible');
		}
			$current = $dropdown;
	}).on("mouseleave", ".top-widget, .share-holder", function () {
	   	$current.removeClass('dropdown-visible');
	});

	$j( ".top-widget #password, .top-widget #username" ).keypress(function(e) {
  		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$j('#hb-login-form').submit();
		}
	});

	$j( "#password-tmp, #username-tmp" ).keypress(function(e) {
  		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$j('#hb-login-form-tmp').submit();
		}
	});

}


/* Show Scroll Top */
function hb_scroll_top_init() {
	
	var win = $j(window),
	timeo = false,
	scroll_top = $j('#to-top'),
	set_status = function() {
		
		var st = win.scrollTop();
     	if(st < 350) {
			scroll_top.removeClass('hb-pop-class');
		}
		
		else if(!scroll_top.is('.hb-pop-class')) {
			scroll_top.addClass('hb-pop-class');
		}
	};
	win.scroll(set_status);
	set_status();
}

/* Show Menu in Search */
function hb_menu_search() {
	
	var $main_nav = $j('#main-nav');
	var $search_in_header = $j('#header-inner').attr('data-search-header');

	if ( $main_nav.length && $search_in_header == 1 && search_in_menu == 0 ){
		$main_nav.append('<li id="nav-search" class="external"><a href="#" id="search-trigger" class="no-transition external"><i class="icon-search"></i></a></li>');
		search_in_menu = 1;
	}
}

/* Add hb-transform class to the body if animations are supported */
function hb_anim_content() {
	
	if (!is_touch_device()) {
		$j('body').addClass('hb-transform');
	}
}

/* Scroll to top on click */
function hb_to_top_click() {
	
	$j('#to-top,.go-to-top').click(function(e){
		e.preventDefault();
		$j('body,html').stop().animate({
			scrollTop:0
		},800,'easeOutCubic');
		return false;
	});

}

/* Init Nice Scroll */
function nice_scroll_me() {
	
	$j("html").niceScroll({
		scrollspeed: 60,
		mousescrollstep: 40,
		cursorwidth: 10,
		cursorborder: 0,
		cursorcolor: '#1f1f1f',
		cursorborderradius: 6,
		autohidemode: false,
		horizrailenabled: false
	});
}

/* Nice Scroll helper function */
function hb_nice_scroll_init() {
	
	var $niceScrollBool = $j('body').attr('data-smooth-scroll'); 
	if( $niceScrollBool == 1 && $j(window).width() >  690 && $j('body').outerHeight(true) > $j(window).height()){ nice_scroll_me(); }
	else if ( $niceScrollBool != 1 && navigator.userAgent.indexOf('Mac OS X') == -1 && window.chrome ) {
		
		if (window.addEventListener) window.addEventListener('DOMMouseScroll', wheel, false);
		window.onmousewheel = document.onmousewheel = wheel;

		var time = 200;
		var distance = 100;

		function wheel(event) {
			if (event.wheelDelta) delta = event.wheelDelta / 120;
			else if (event.detail) delta = -event.detail / 3;

			handle();
			if (event.preventDefault) event.preventDefault();
			event.returnValue = false;
		}

		function handle() {

			$j('html, body').stop(true,false).animate({
				scrollTop: $j(window).scrollTop() - (distance * delta)
			}, time);
		}


		$j(document).keydown(function (e) {
			switch (e.which) {
				//up
				case 38:
					$j('html, body').stop(true,false).animate({
						scrollTop: $j(window).scrollTop() - distance
					}, time);
					break;

					//down
				case 40:
					$('html, body').stop(true,false).animate({
						scrollTop: $j(window).scrollTop() + distance
					}, time);
					break;
			}
		});
	}
}

/* Init Masonry */
function hb_masonry() {
	
	var $container = $j('.masonry-holder');
	if ($container.length){
		var $layoutMode = $container.attr('data-layout-mode');
		$container.imagesLoaded( function(){
			if ($layoutMode == 'fitRows'){
				$container.isotope({
					itemSelector : 'article',
					animationEngine : 'best-available',
					layoutMode: 'fitRows'
				});
			} else if ($layoutMode == 'masonry') {
				$container.isotope({
					itemSelector : 'article',
					animationEngine : 'best-available',
					layoutMode: 'masonry'
				});
			} else if ($layoutMode == 'straightDown'){
				$container.isotope({
					itemSelector : 'article',
					animationEngine : 'best-available',
					layoutMode: 'straightDown'
				});
			} else {
				$container.isotope({
					itemSelector : 'article',
					animationEngine : 'best-available',
					layoutMode: 'masonry'
				});
			}
		});
	}
}

/* Init Parallax for each section */
function hb_parallax_init() {

	if ( $j('#hb-page-title.parallax').length && !$j('body').hasClass('mobile') && navigator.userAgent.match(/iPad/i) == null){
		var $scroll_val;
		var $scrollTop;
		var $opac;

		// Parallax Headers
		$j(window).scroll(function(){
			
			$scrollTop = $j(window).scrollTop();
			$scroll_val = $j(window).scrollTop()*.5;
			$scroll_val_img = $j(window).scrollTop()*.35;

			$opac = 1-($scrollTop/320);

			if ($scroll_val <= 0 ){
				$scroll_val = 0;
			}

			if ($scroll_val_img <= 0){
				$scroll_val_img = 0;
			}

			if ($opac <= 0){
				$opac = 0;
			}
			
			if(!$j('body').hasClass('mobile') && navigator.userAgent.match(/iPad/i) == null){
				$j('.hb-page-title, .breadcrumbs-wrapper').css({transform: 'translateY(' + $scroll_val + 'px)'}).css({'opacity' : $opac });
				$j('.hb-image-bg-wrap').css({transform: 'translateY(' + $scroll_val_img + 'px)'});
			}

		});
	}
	if (typeof revapi4 != 'undefined'){
		revapi4.bind("revolution.slide.onloaded",function (e) {
			$j('#slider-section .rev_slider_wrapper').addClass('parallax-slider');
			$j('#slider-section').addClass('parallax-slider-wrapper');
		});

		var $scroll_val;
		var $scrollTop;
		var $opac;

		// Parallax Headers
		$j(window).scroll(function(){
			
			$scrollTop = $j(window).scrollTop();
			$scroll_val = $j(window).scrollTop()*.65;
			$scroll_val_img = $j(window).scrollTop()*.45;

			$opac = 1-($scrollTop/560);

			if ($scroll_val <= 0 ){
				$scroll_val = 0;
			}

			if ($scroll_val_img <= 0){
				$scroll_val_img = 0;
			}

			if ($opac <= 0){
				$opac = 0;
			}

			$j('#slider-section .rev_slider_wrapper').css({transform: 'translateY(' + $scroll_val_img + 'px)'});
			$j('#slider-section .rev_slider_wrapper').css({'opacity' : $opac });
		});
	}

	// .tp-bgimg is for Revolution Slider Parallax
	$j('.hb-parallax-wrapper').each(function() {
		$j(this).parallax();
	});
}

/* Expand sections to full width */
function hb_fw_sections() {
	var $fwh;
	var $width = $j(window).width();
	var $pad_left = '0px';
	var $pad_right = '0px';
	var $mar_left = '-50px';

	if ( $j('#main-wrapper').hasClass('hb-boxed-layout') &&  $width > 767 ){
		$fwh = parseInt($j('.hb-main-content').width()) + 102;

		/*if ($width < 1260){
			var $pad_left = '25px';
			var $pad_right = '35px';
			var $mar_left = '-100px';
		}*/

		$j('.fw-section').each(function(){
			$j(this).css({
				'margin-left': $mar_left,
				'padding-left': $pad_left,
				'padding-right': $pad_right,
				'margin-right': '0px',
				'width': $fwh,
				'visibility': 'visible'
			});	
		});
	} else {
		$fwh = (($j(window).width() - parseInt($j('.hb-main-content').width())) / 2) + 1;

		$j('.fw-section').each(function(){
			$j(this).css({
				'margin-left': -$fwh,
				'padding-left': $fwh,
				'padding-right': $fwh,
				'visibility': 'visible',
				'width': '100%',
				'margin-right': '0px'
			});	
		});
	}

	if ( $j('.content-total-fw').length ){
		$j('.content-total-fw').each( function(){
			var $that = $j(this);
			$that.parent().css("height", $that.outerHeight());
			$that.imagesLoaded(function(){
				$that.parent().stop().animate({'height' : $that.outerHeight()},350,'easeOutCubic');
				$that.stop().animate({'opacity' : 1},350,'easeOutCubic');
			});

		} );
	}
}

/* Fancy Search in header */
function hb_fancy_search() {
	
	var $open_flag = false;
	var $header_inner = $j('#header-inner');
	$j('#nav-search, #close-fancy-search').click(function(e) {
		e.preventDefault();

		if (!$open_flag) {
			$j('#fancy-search #s').val('');
			if ( $header_inner.hasClass('nav-type-2') ){
				$j('#main-nav, #sticky-shop-button').stop(true,false).animate({opacity: 0}, 300);
			} else {
				$j('#logo, #main-nav, #sticky-shop-button').stop(true,false).animate({opacity: 0}, 300);
			}
			$j('#fancy-search').fadeIn(300);
			$j('#fancy-search-form #s').focus();
			$j('body').addClass('fancy-s-open');
			$open_flag = true;
		} else {
			$j('#fancy-search').fadeOut(300);
			$j('#fancy-search #s').blur();
			$j('#logo, #main-nav, #sticky-shop-button').stop(true,false).animate({opacity: 1}, 300);
			$j('body').removeClass('fancy-s-open');
			$open_flag = false;
		}
	});  

	$j(document).mouseup(function (e){
	    var $container = $j("#fancy-search");
	    if (!$container.is(e.target) && $container.has(e.target).length === 0 && $open_flag){
	    	$j("#close-fancy-search").trigger('click');
	    }
	});

	$j(document).keyup(function(e) {
  		if ( $j('#fancy-search').is(':visible') && e.keyCode == 27) {
  			$j("#close-fancy-search").trigger('click');
  		}
	});
}

/* Mask the clicks for forms */
function hb_click_forms() {
	
	$j('#hb-submit-login-form').click(function(e) {
		e.preventDefault();
		if ( $j('#hb-login-form').validate().form() ){
			$j('#hb-login-form').submit();
		}
	});

	$j('#hb-submit-login-form-tmp').click(function(e) {
		e.preventDefault();
		if ( $j('#hb-login-form-tmp').validate().form() ) {
			$j('#hb-login-form-tmp').submit();
		}
	});
}

/* Animate arrows in flexslider, but support AJAX */
function hb_flexslider_hover() {
	
	$j('body').on("mouseenter", ".hb-flexslider, .laptop-mockup", function () {
	    	$j(this).find('.flex-prev').stop(false, false).animate({left: 0}, 100, 'easeInOutQuad');
			$j(this).find('.flex-next').stop(false, false).animate({right: 0}, 100, 'easeInOutQuad');
	    }).on("mouseleave", ".hb-flexslider, .laptop-mockup", function () {
	    	$j(this).find('.flex-prev').stop(false, false).animate({left: -40}, 100, 'easeInOutQuad');
			$j(this).find('.flex-next').stop(false, false).animate({right: -40}, 100, 'easeInOutQuad');
	});
}

/*  Reload Likes */
function hb_reload_likes(who) {
	
	var text = $j("#" + who).html();
	var patt = /(\d)+/;
	var num = patt.exec(text);
	num[0]++;
	text = text.replace(patt, num[0]);
	$j("#" + who).html(text);
}

/* Init Likes */
function hb_like_init() {
	
	$j("body").on("click touchstart", ".like-holder", function () {
		var classes = $j(this).attr("class");
		classes = classes.split(" ");

		if (classes[2] == "like-active"){
			return false;
		}

		$j(this).addClass("like-active");
		var id = $j(this).attr("id");
		id = id.split("like-");
			$j.ajax({
				type: "POST",
				url: ajaxurl,
				data: "likepost=" + id[1],	
				success: hb_reload_likes("like-" + id[1])
			});

		return false;
	});
}

/* Mini Contact Form */
function hb_mini_contact_form() {
	
	$j('#contact-button').click(function(e) {
		
		e.preventDefault();
		e.stopPropagation();
		$j(this).toggleClass('active-c-button');
		$j('#contact-panel').toggleClass('hb-pop-class');
	});

	$j('#contact-panel').click(function(e){
		
		e.stopPropagation();
	});
	
	$j(document).click(function (e) {
		
		if ($j("#contact-panel").hasClass("hb-pop-class") ) {
			$j('#contact-panel').toggleClass('hb-pop-class');
			$j('#contact-button').toggleClass('active-c-button');
			return false;
		}
			
	});
}

/* HB Header Effect */
function hb_header_effect() {
	var $header = $j("#header-inner");
	var $body = $j('body');

	if ( $header.hasClass('centered-nav') && $header.hasClass('sticky-nav') ){
		$header.sticky();
	}

	if ( $header.hasClass('sticky-nav') && $header.hasClass('nav-type-1') ){
		$header.sticky();

		// Disable CSS Transition
		$j('.image-logo, .plain-logo, #main-nav li a').addClass('no-transition');

		/* Main Navigation */
		var header_height = parseInt($j('#header-inner').attr('data-height'));
		var header_height_sticky = parseInt($j('#header-inner').attr('data-sticky-height'));

		/* Check on Page Load */
		var hb_window_y = $j(window).scrollTop();
		var new_height = 0;
		var offset = 0;
		var header_els = $j('#header-inner, #header-inner #logo, .main-navigation, .plain-logo');

		if ($j('#main-wrapper').hasClass('hb-boxed-layout')){
			offset += 40;
		}
		

		// Header Fancy Effect
		if ( !$j('body').hasClass('hb-special-header-style') ){
			if ( hb_window_y > $j("#header-bar").height() + offset ) {
				if(hb_window_y < (header_height - header_height_sticky  + $j("#header-bar").height() + offset )) {
					new_height = header_height - hb_window_y + $j("#header-bar").height() + offset;
				} else {
					new_height = header_height_sticky;
				}
			} else if ( hb_window_y < 0 && is_safari == false ) {
					new_height = header_height - hb_window_y;
			} else {
				new_height = header_height;
			}
			header_els.css({height: new_height + 'px', lineHeight: new_height + 'px'});
			if (new_height > header_height){
				$j('#header-inner-sticky-wrapper').css({height: new_height + 'px', lineHeight: new_height + 'px'});
			}
			/* End */

			$j(window).scroll(function () {
				var hb_window_y = $j(window).scrollTop();
				var new_height = 0;
				var offset = 0;
				var header_els = $j('#header-inner, #header-inner #logo, .main-navigation, .plain-logo');

				if ($j('#main-wrapper').hasClass('hb-boxed-layout')){
					offset += 40;
				}

				if ( hb_window_y > $j("#header-bar").height() + offset ) {
					if(hb_window_y < (header_height - header_height_sticky  + $j("#header-bar").height() + offset )) {
						new_height = header_height - hb_window_y + $j("#header-bar").height() + offset;
					} else {
						new_height = header_height_sticky;
					}
				} else if ( hb_window_y < 0 && is_safari == false ) {
						new_height = header_height - hb_window_y;
				} else {
					new_height = header_height;
				}

				header_els.css({height: new_height + 'px', lineHeight: new_height + 'px'});

				if (new_height > header_height){
					$j('#header-inner-sticky-wrapper').css({height: new_height + 'px', lineHeight: new_height + 'px'});
				}
			});
		}


	}
}

/* Function Init mejs */
function hb_init_mejs() {
	if ( jQuery().mediaelementplayer ){
		(function ($) {
		mejs.plugins.silverlight[0].types.push('video/x-ms-wmv');
		mejs.plugins.silverlight[0].types.push('audio/x-ms-wma');

		jQuery(function () {
			var settings = {};
			if ( typeof _wpmejsSettings !== 'undefined' )
				settings.pluginPath = _wpmejsSettings.pluginPath;
			settings.enableKeyboard = false;
			settings.pauseOtherPlayers = false;
			$j('.hb-video-element, .wp-audio-shortcode, .wp-video-shortcode').mediaelementplayer( settings );
		});
		}(jQuery));
	}
}

/* Function Validations */
function hb_validations() {
	
	if (jQuery().validate){
		$j("#commentform").validate();
	}

}

function hb_fixed_footer_init() {

	var $fixedFooterBool = $j('body').attr('data-fixed-footer'); 
	if( $fixedFooterBool == 1 && $j(window).width() > 690 ){ hb_fixed_footer(); }
}

/* Fixed Footer */
function hb_fixed_footer() {
	
	var $footer_height = 0;
	var $copyright_height = 0;
	var $total_height = 0;
	
	if ( $j('#footer').length ) {
		$footer_height = $j('#footer').outerHeight( true );
	}

	if ( $j('#copyright-wrapper').length ) {
		$copyright_height = $j('#copyright-wrapper').outerHeight( true );
	}

	$total_height = $footer_height + $copyright_height;

	$j('#main-wrapper').css({
		'margin-bottom': $total_height,
		'box-shadow': '0 4px 8px rgba(0,0,0,0.2)'
	});	
	
	$j('#footer').css({
		'position': 'fixed',
		'bottom': 0,
		'margin-bottom': $copyright_height + 'px',
		'left': 0,
		'width': '100%',
		'z-index': -1
	});	

	$j('#copyright-wrapper').css({
		'position': 'fixed',
		'bottom': 0,
		'left': 0,
		'width': '100%',
		'z-index': -2
	});	
}

function hb_init_fw_gallery(){
	

	var $fw_gallery_container = $j('#fw-gallery-grid');
	var $isotope_gallery = $j('.fw-gallery-wrap');
	var $enableFilter = $fw_gallery_container.attr('data-enable-filter');
	var $enableSort = $fw_gallery_container.attr('data-enable-sort');

	$j("body").on('mouseenter', '.gallery-item, .hb-fw-element', function() {
		var $that = $j(this);
		$that.find('.item-overlay-text-wrap').stop().animate({
			'padding-top' : 15
		},420,'easeOutCubic');
			$that.find('.item-overlay-text').stop().animate({
			'opacity' : 1
		},220,'easeOutCubic');
	}).on('mouseleave', '.gallery-item, .hb-fw-element', function() {
    	var $that = $j(this);
		$that.find('.item-overlay-text-wrap').stop().animate({
			'padding-top' : 0
		},420,'easeOutCubic');
		$that.find('.item-overlay-text').stop().animate({
			'opacity' : 0
		},220,'easeOutCubic');
	});

	
	if ( $fw_gallery_container.length ){
		$fw_gallery_container.imagesLoaded(function(){
			$isotope_gallery.removeClass('loading');
				
			$j('#fw-gallery-grid .col').each(function(i){
				var $that = $j(this);
				var $counter = i;

				setTimeout(function(){
					$that.addClass('animate');
					setTimeout(function(){
						$that.removeClass('animate').addClass('visible');
					}, 800);
				},$counter*110 + 300);

			});

			$isotope_gallery.isotope({
				itemSelector : '.elastic-item',
				getSortData : {
				    name: '.hb-gallery-item-name',
				    date: '[data-value]',
				    count: '.photo-count parseInt',
				}
			});

			$j(window).resize(function(){
				$isotope_gallery.isotope();
			});
		
		});


		$j('li.hb-dd-header').hover(function() {
			var $dropdown = $j(this).find('.hb-gallery-dropdown');
			$dropdown.addClass('dropdown-visible');

		}, function() {
			var $dropdown = $j(this).find('.hb-gallery-dropdown');
			$dropdown.removeClass('dropdown-visible');
		});

		$j('ul.hb-sort-filter > li.hb-dd-header > ul > li > a').click(function() {
			$j(this).addClass('hb-current-item');
			var $new_sort_value = $j(this).html();
			var $sort_value = $j(this).parent().parent().parent().find('strong');
			var $sort_ascending = false;
			var selector = $j(this).attr('data-sort-value');

			$sort_value.html( $new_sort_value );
			$sort_value.siblings('.hb-gallery-dropdown').trigger('mouseout');

			if (selector == 'name' || selector == 'date'){
				$sort_ascending = true;
			}

			if (selector == 'random'){
				$isotope_gallery.isotope({ sortBy : 'random' });
			} else {
				$isotope_gallery.isotope({ 
					sortBy : selector,
					sortAscending : $sort_ascending 
				});
			}

			return false;
		});

		$j('ul.hb-grid-filter > li.hb-dd-header > ul > li > a').click(function() {
			$j(this).addClass('hb-current-item');
			var selector = $j(this).attr('data-filter');
			if (selector != '*' ){
				selector = '.' + selector;
			}
			$isotope_gallery.isotope({ filter: selector });

			var $new_sort_value = $j(this).attr('data-filter-name');
			var $sort_value = $j(this).parent().parent().parent().find('strong');

			$sort_value.html( $new_sort_value );
			$sort_value.siblings('.hb-gallery-dropdown').trigger('mouseout');

			return false;
		});

	}
}


/* Standard Gallery Initialization */
function hb_init_standard_gallery(){
	
	var $standard_gallery_masonry = $j('#standard-gallery-masonry');

	var $enableFilter = $standard_gallery_masonry.attr('data-enable-filter');
	var $enableSort = $standard_gallery_masonry.attr('data-enable-sort');

	if ( $standard_gallery_masonry.length ){

		$standard_gallery_masonry.imagesLoaded(function(){
			$j('#gallery-loading').stop(true,true).fadeOut(200);
				
			$j('.standard-gallery-item').each(function(i){
				var $that = $j(this);
				var $counter = i;

				setTimeout(function(){
					$that.addClass('animate');
					setTimeout(function(){
						$that.removeClass('animate').css("opacity", 1);
					}, 800);
				},$counter*110 + 300);

			});

			$standard_gallery_masonry.isotope({
				itemSelector : '.standard-gallery-item-wrap',
				animationEngine : 'best-available',
				layoutMode: 'fitRows',
				getSortData : {
				    name : '.hb-gallery-item-name',
				    date : '[data-value]'
				}
			});

		});


		$j('ul.filt-tabs > li > a').click(function() {
			$j('ul.filt-tabs').find('.selected').removeClass('selected');
			$j(this).parent().addClass('selected');

			var selector = $j(this).attr('data-filter');
			$standard_gallery_masonry.isotope({ filter: selector });

			return false;
		});


		$j('ul.sort-tabs > li > a').click(function() {
			$j('ul.sort-tabs').find('.selected').removeClass('selected');
			$j(this).parent().addClass('selected');
			var $sort_ascending = false;

			var selector = $j(this).attr('data-sort');

			if (selector == 'name' || selector == 'date'){
				$sort_ascending = true;
			}

			$standard_gallery_masonry.isotope({ 	
				sortBy : selector,
				sortAscending : $sort_ascending 
			});

			return false;
		});

	}

	/* Hover Functions */
		$j('.hb-gal-standard-img-wrapper').hover(function(){
			var $that = $j(this);
			$that.find('.item-overlay-text-wrap').stop().animate({
				'padding-top' : 15
			},420,'easeOutCubic');
				$that.find('.item-overlay-text').stop().animate({
				'opacity' : 1
			},220,'easeOutCubic');
			$that.find('.item-overlay').stop().animate({
				'opacity' : 0.85
			},220,'easeOutCubic');
		},function(){
			var $that = $j(this);
			$that.find('.item-overlay-text-wrap').stop().animate({
				'padding-top' : 0
			},420,'easeOutCubic');
			$that.find('.item-overlay-text').stop().animate({
				'opacity' : 0
			},220,'easeOutCubic');
			$that.find('.item-overlay').stop().animate({
				'opacity' : 0
			},220,'easeOutCubic');
		});
}


/* Ajax Search - Only for header menu search */
function hb_ajax_search(){
	

	if ( $j('#nav-search').length && $j('#header-inner').hasClass('hb-ajax-search') ){

		$j("#fancy-search #s").autocomplete({ 
			delay: 50,
			minLength: 2,
			appendTo: $j("#fancy-search"), 
			search: function( event, ui ) {
				$j('#fancy-search').addClass('ajax-searching'); 
			},
			source: function(req, response){  
				$j.getJSON(ajaxurl+'?callback=?&action=hb_ajax_search', req, response);  
			},  
			select: function(event, ui) {  
				if (typeof ui.item != 'undefined'){
					window.location.href=ui.item.link;
				} else {
					$j('#fancy-search-form').submit();
				} 
			},
			response: function( event, ui ) {
				$j('#fancy-search').removeClass('ajax-searching');
			},
			open: function(event, ui) {
				var len = $j('#fancy-search .ui-autocomplete > li').length;
            	if (len == 5) {
            		$j('#fancy-search .ui-autocomplete').append('<li class="ui-menu-item" role="presentation"><a id="ui-view-all-results" href="#" class="ui-corner-all" tabindex="-1"><i class="hb-moon-search-3"></i><span class="search-title all-results">View all results</span></a></li>'); //See all results);
				}
        	}
                
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $j( "<li>" ).append( "<a>" + item.image + "<span class='search-title'>" + item.label + "</span><span class='search-date'>"+item.date+"</span></a>" ).appendTo( ul );
		};


	} else {
		return false;
	}
}


/* Function Lighbox Init */
function hb_init_lightbox() {
	
	$j("a[rel^='prettyPhoto'], a[rel^='prettyPhoto[gallery]'], .gallery-icon a").prettyPhoto({
		animation_speed: 'fast',
		opacity: 0.85,
		overlay_gallery: true,
		slideshow: false,
		allow_resize: true,
		show_title: true,
		changepicturecallback: function(){

			if (viewportWidth < 1025) {
				var viewportWidth = $j('html').innerWidth();
				$j(".pp_pic_holder.pp_default").css("top",window.pageYOffset+"px");
			}
		},
		default_width: 970,
		default_height: 643,
		social_tools: ''
	});

	$j('.gallery-item-init').click(function(e) {
		e.preventDefault();
		var $api_images = $j(this).attr('data-gallery-images');
		$j.prettyPhoto.open($api_images);
	});

}

/* Window Popup */
function popWindow(url,winName,w,h) {
    if (window.open) {
        if (poppedWindow) { poppedWindow = ''; }
        windowW = w;
        windowH = h;
        var windowX = (screen.width/2)-(windowW/2);
        var windowY = (screen.height/2)-(windowH/2);
        var myExtra = "status=no,menubar=no,resizable=yes,toolbar=no,scrollbars=yes,addressbar=no";
        var poppedWindow = window.open(url,winName,'width='+w+',height='+h+',top='+windowY+',left=' + windowX + ',' + myExtra + '');
    }
    else {
        alert('Your security settings are not allowing our popup windows to function. Please make sure your security software allows popup windows to be opened by this web application.');
    }
    return false;
}

/* Single Blog Scripts */
function hb_single_blog_scripts(){
	

	/* Hover Functions */
	$j(document).on('mouseenter', '.featured-image', function() {
		var $that = $j(this);
		$that.find('.item-overlay-text-wrap').stop().animate({
			'padding-top' : 15
		},420,'easeOutCubic');
			$that.find('.item-overlay-text').stop().animate({
			'opacity' : 1
		},220,'easeOutCubic');
	}).on('mouseleave', '.featured-image', function() {
		var $that = $j(this);
		$that.find('.item-overlay-text-wrap').stop().animate({
			'padding-top' : 0
		},420,'easeOutCubic');
		$that.find('.item-overlay-text').stop().animate({
			'opacity' : 0
		},220,'easeOutCubic');
	});

	/* Scroll To #comments when clicked */
	$j('.scroll-to-comments').click(function (e) {
		e.preventDefault();
		if ($j('#comments').length){
			$j("html, body").animate({
				scrollTop: $j('#comments').offset().top - 120
			}, 800, 'easeOutCubic');
		} else {
			$j("html, body").animate({
				scrollTop: $j('#respond').offset().top - 120
			}, 800, 'easeOutCubic');
		}
	});

	/* Scroll to #respond when clicked */
	$j('.leave-your-reply').click(function (e) {
		e.preventDefault();
		if ($j('#respond').length){
			$j("html, body").animate({
				scrollTop: $j('#respond').offset().top - 120
			}, 800, 'easeOutCubic');
		}
	});
}

/* Various Shortcode Inits */
function hb_init_shortcodes(){

	/* Wrap Select elements */
	$j( "select" ).not("#rating").wrap( "<div class='hb-custom-select'></div>" );

	/* Testimonial Slider */
	if ( $j('.init-testimonial-slider').length ){
		$j('.init-testimonial-slider').each(function(){
			var $that = $j(this);
			var $speed = $j(this).attr('data-slideshow-speed');

			if ($speed < 1000){
				$speed = 1000;
			}

			$that.flexslider({
				selector: ".testimonial-slider > li",
				slideshow: true,
				animation: "fade",
				smoothHeight: false,
				slideshowSpeed: $speed,
				animationSpeed: 350,
				directionNavArrowsLeft : '<i class="icon-chevron-left"></i>',
				directionNavArrowsRight : '<i class="icon-chevron-right"></i>',
				pauseOnHover: false,
				controlNav: true,
				directionNav:false,
				prevText: "",
				nextText: ""
			});
		});
	}

	/* Flexslider */
	if ( $j('.init-flexslider').length ) {
		$j('.init-flexslider').each(function(){
			var $that = $j(this);
			var speed = $that.attr('data-speed');
			var pause = $that.attr('data-pause-on-hover');
			var control = $that.attr('data-control-nav');
			var nav = $that.attr('data-direction-nav');

			pause = ( pause == "true" );
			control = ( control == "true" );
			nav = ( nav == "true" );

			$j($that).fitVids().flexslider({
				selector: ".hb-flex-slides > li",
				slideshow: true,
				animation: "slide",
				smoothHeight: true,
				slideshowSpeed: speed,
				animationSpeed: 500,
				pauseOnHover: pause,
				controlNav: control,
				directionNav: nav,
				prevText: "",
				nextText: "",
				start: function(){
					$that.removeClass('loading');
				}
			});
		});
	}

	/* Carousel */
	if ( $j('.init-carousel').length ) {
		$j('.init-carousel').each(function() {
			var $that = $j(this);
			var visible_var = parseInt($that.attr('data-visible'), 10);
			var speed_var = parseInt($that.attr('data-speed'), 10);
			var autorotate = $that.attr('data-auto-rotate');

			if (autorotate == 'false'){
				speed_var = false;
			}

			$that.carousel({
				visible: visible_var,
				speed: 400,
				itemMargin: 20,
				carousel: true,
				autoRotate: speed_var,
				itemMinWidth: 200
			});
		});
	}

	/* Carousel */
	if ( $j('.init-team-carousel').length ) {
		$j('.init-team-carousel').each(function() {
			var $that = $j(this);
			var visible_var = parseInt($that.attr('data-visible'), 10);
			var speed_var = parseInt($that.attr('data-speed'), 10);
			var autorotate = $that.attr('data-auto-rotate');

			if (autorotate == 'false'){
				speed_var = false;
			}

			$that.carousel({
				visible: visible_var,
				speed: 400,
				itemMargin: 30,
				carousel: true,
				autoRotate: speed_var,
				itemMinWidth: 100
			});
		});
	}

	/* Countdowns */
	if ( $j('.hb-countdown-unit').length ){
		var date_value;
		
		$j('.hb-countdown-unit').each(function() {
			date_value = $j(this).attr('data-date');
			$j(this).countdown({
				date: date_value,
				format: "on"
			});
		});
	}

	/* Accordions */
	if ($j('.hb-accordion').length) {
		$j('.hb-accordion').each(function(){
			var $index = $j(this).attr('data-initialindex');
			if ($index != '-1'){
				var $tog = $j(this).find('.hb-accordion-single').eq($index).find('.hb-accordion-tab');
				$tog.addClass('active-toggle');
				$tog.siblings('.hb-accordion-pane').slideDown(200);
				hb_animated_contents();
				hb_counter();
				hb_charts();
				hb_progress_bar();
			}
		});

		$j('.hb-accordion .hb-accordion-tab').click(function(e) {
			
			e.preventDefault();

			var $that = $j(this);

			$that.parent().parent().find(".hb-accordion-tab").removeClass("active-toggle");
			$that.parent().parent().find(".hb-accordion-pane").slideUp(200);

			if( $that.next().is(':hidden') == true) {
				$that.next().slideDown(200);
				$that.addClass("active-toggle");
				hb_animated_contents();
				hb_counter();
				hb_charts();
				hb_progress_bar();
			} 
			
		 });
	}

	/* Toggles */
	if ($j('.hb-toggle').length) {
		$j('.hb-toggle').each(function(){
			var $index = $j(this).attr('data-initialindex');
			if ($index != '-1'){
				var $tog = $j(this).find('.hb-accordion-single').eq($index).find('.hb-accordion-tab');
				$tog.addClass('active-toggle');
				$tog.siblings('.hb-accordion-pane').slideDown(200);
				hb_animated_contents();
				hb_counter();
				hb_charts();
				hb_progress_bar();
			}
		});
		$j(".hb-toggle .hb-accordion-tab").toggle(
			function () {
				if ( !$j(this).hasClass('active-toggle') ){
					$j(this).addClass('active-toggle');
					$j(this).siblings('.hb-accordion-pane').slideDown(200);
					hb_animated_contents();
					hb_counter();
					hb_charts();
					hb_progress_bar();
				} else {
					$j(this).removeClass('active-toggle');
					$j(this).siblings('.hb-accordion-pane').slideUp(200);
				}
			}, function () {
				if ( $j(this).hasClass('active-toggle') ){
					$j(this).removeClass('active-toggle');
					$j(this).siblings('.hb-accordion-pane').slideUp(200);
				} else {
					$j(this).addClass('active-toggle');
					$j(this).siblings('.hb-accordion-pane').slideDown(200);
					hb_animated_contents();
					hb_counter();
					hb_charts();
					hb_progress_bar();
				}
		});
	}
	// End Toggle

	/* Team Member Hover */
	var hover_timer;
	$j('.team-member-box').hover(function(){
		var $that = $j(this);
		if ($that.parent().hasClass('team-meta-sidebar') || $that.parent().parent().hasClass('related-members')) { return false; }
		$j($that).find('.team-member-img').find('img').stop().animate({
			opacity: 0.2
		}, 220, 'easeOutCubic');
		var t = $j($that).find('.team-member-img').find('ul');
		window.clearTimeout(hover_timer);
		hover_timer = setTimeout(function () {
			if (t.length){
				t.addClass("animate-me");
			}
		}, 100);

	}, function() {
		window.clearTimeout(hover_timer);
		var $that = $j(this);
		var t = $j($that).find('.team-member-img').find('ul');
		t.removeClass('animate-me');
		$j($that).find('.team-member-img').find('img').stop().animate({
			opacity: 1
		}, 420, 'easeOutCubic');
	});


	// Overlay hover
	if ( $j('.overlay').length ){
		$j('.hb-circle-frame a, .hb-box-frame a').hover(function(){
			var $that = $j(this);
			
			$that.find('.overlay').stop().animate({
				'opacity' : 0.85
			},220,'easeOutCubic');

			$that.find('.plus-sign').stop().animate({
				'top' : 50 + '%'
			},420,'easeOutCubic');

		},function(){
			var $that = $j(this);
			$that.find('.overlay').stop().animate({
				'opacity' : 0
			},220,'easeOutCubic');

			$that.find('.plus-sign').stop().animate({
				'top' : 40 + '%'
			},420,'easeOutCubic');
		});
	}

	// Show Arrows in Accordion
	$j('body').on("mouseenter", ".hb-crsl-wrapper, .client-carousel-wrapper, .gallery-carousel-wrapper, .gallery-carousel-wrapper-2, .blog-carousel-wrapper", function () {
		$j(this).find('.crsl-nav').stop(false, false).animate({opacity: 1}, 100, 'easeInOutQuad');
	}).on("mouseleave", ".hb-crsl-wrapper, .client-carousel-wrapper, .gallery-carousel-wrapper, .gallery-carousel-wrapper-2, .blog-carousel-wrapper", function () {
	    	$j(this).find('.crsl-nav').stop(false, false).animate({opacity: 0}, 100, 'easeInOutQuad');
	});


	// Tabs
	if ( $j('.hb-tabs-wrapper').length ){
		$j(".hb-tabs-wrapper ul.nav-tabs").find("li:first").addClass("active");
		//$j(".hb-tabs-wrapper").find(".tab-pane:first").addClass('active');

		$j('.nav-tabs > li > a').click(function(e) {
			e.preventDefault();
			/*
			var $that = $j(this);
			var tabs_contents = tabs_container.children(".tab-content");
			
			var $anchor = $that.attr('href');
			$anchor = $anchor.substr(1);

			var tab_content = tabs_contents.find('#'+$anchor);
			
			tabs_contents.children(".tab-pane").removeClass('active');
			$j(tab_content).addClass('active');

			*/
			var tabs_container = $j(this).parent().parent().parent();
			var tabs = tabs_container.children(".nav-tabs");
			tabs.children("li").removeClass("active");
			$j(this).parent().addClass("active");

			hb_animated_contents();
			hb_counter();
			hb_charts();
			hb_progress_bar();
		});
	}
	

	// Modal
	if ( $j('.hb-modal-window').length ){
		$j('.modal-open').click(function(e) {
			e.preventDefault();
			var $modal_id = $j(this).attr('data-modal-id');

			if ( $j('#'+$modal_id).hasClass('rendered') ){
				setTimeout(function () {
					$j('#'+$modal_id).addClass('animate-modal');
				}, 220);
				$j('body').addClass('no-scroll');
			} else {
				 setTimeout(function () {
                    $j('#'+$modal_id).addClass('rendered animate-modal');
                }, 220);
				$j('body').addClass('no-scroll');
				$the_modal = $j('#'+$modal_id).parent().html();
				$j('#'+$modal_id).parent().remove();
				$j('#hb-modal-overlay').append($the_modal);
			}

			hb_toggle_modal_overlay();
		});

		$j('.close-modal').live("click touchstart", function (e) {
			e.preventDefault();
			var $close_id = $j(this).attr('data-close-id');
			$j('#'+$close_id).removeClass('animate-modal');
			$j('body').removeClass('no-scroll');
			hb_toggle_modal_overlay();
		});
	}

}


/* Counter Function */
function hb_counter() {
	

	if ( $j.exists('.hb-counter') && $j.inviewport ){

		/* Counters */
		$j('.hb-counter:in-viewport').each(function () {
			if (!$j(this).hasClass('activated')){
				var countAsset = $j(this),
					countNumber = countAsset.find('.count-number'),
					countDivider = countAsset.find('.count-separator').find('span'),
					countSubject = countAsset.find('.count-subject'),
					countTo = countAsset.find('.count-number').attr('data-to'),
					countFrom = countAsset.find('.count-number').attr('data-from'),
					countSpeed = parseInt(countAsset.find('.count-number').attr('data-speed'));

				countAsset.addClass('activated');

					$j({countNum: countFrom}).animate({countNum: countTo}, {
						duration: countSpeed,
						easing:'linear',
						step: function() {
							countAsset.find('.count-number').text(Math.floor(this.countNum));
						},
						complete: function() {
							countAsset.find('.count-number').text(this.countNum);
							countDivider.animate({'width': 50}, 650, 'easeOutCubic');
							countSubject.delay(100).animate({'opacity': 1,'bottom': '0px'}, 650, 'easeOutCubic');
						}
					});
			}
		});

	}
}

/* Charts */
function hb_charts() {
	
	if ( $j.exists('.hb-chart') && $j.inviewport ) {
		if (!$j(this).hasClass('activated')){
			$j(this).addClass('activated');
			$j('.hb-chart:in-viewport').each(function() {
				var $that = $j(this);
				var $animation_speed = $that.attr('data-animation-speed');
				var $size = $that.attr('data-barSize');
				$that.easyPieChart({
					animate: $animation_speed,
					lineCap: 'round',
					lineWidth: $that.attr('data-lineWidth'),
					size: $size,
					barColor: $that.attr('data-barColor'),
					trackColor: $that.attr('data-trackColor'),
					scaleColor: 'transparent',
					onStep: function (value) {
						this.$el.find('.chart-percent span').text(Math.ceil(value));
					},
					onStop: function (value) {
						this.$el.siblings('.hb-chart-desc').animate({'opacity': 1,'bottom': '0px'}, 650, 'easeOutCubic');
					}
				});
			});
		}
	}
}

/* Progress Bar */
function hb_progress_bar() {
	
	if ($j.exists('.hb-progress-bar') && $j.inviewport) {
			$j(".hb-progress-bar .progress-outer:in-viewport").each(function () {
				if (!$j(this).hasClass('activated')){
					$j(this).addClass('activated');
					var $that = $j(this);
					$that.animate({
						width: $j(this).attr("data-width") + '%'
					}, 1400, 'easeOutCubic');
				}
			});
	}
}

/* Contact Forms */
function onSuccessSend(results){
	var success_text = $j('#success_text').val();
	$j('#hb-submit-contact-panel-form i').attr('class','hb-moon-checkmark');
	$j('#hb-submit-contact-panel-form').removeClass('hb-asbestos').addClass('hb-nephritis disabled');
	$j('#hb-submit-contact-panel-form span').html(success_text);

	$j('#hb_contact_name_id').attr("disabled", "disabled");
	$j('#hb_contact_email_id').attr("disabled", "disabled");
	$j('#hb_contact_message_id').attr("disabled", "disabled");
}
function hb_contact_forms(){
	var sent = false;
	var nameValidate = false;
	var emailValidate = false;
	var commentsValidate = false;
		
	$j("#hb_contact_name_id").blur(function () {
		nameValidate = $j("#contact-panel-form").validate().element("#hb_contact_name_id");
	});
	$j("#hb_contact_email_id").blur(function () {
		emailValidate = $j("#contact-panel-form").validate().element("#hb_contact_email_id");
	});
	$j("#hb_contact_message_id").blur(function () {
		commentsValidate = $j("#contact-panel-form").validate().element("#hb_contact_message_id");
	});
	
	$j('#hb-submit-contact-panel-form').click(function(e) {
		e.preventDefault();
		if (!sent){

			if ($j('#hb_contact_subject_id').val()){
				alert("Sorry - bots are not allowed!");
				return false;
			}
				
			if( nameValidate && emailValidate && commentsValidate ) {
				$j('#contact-name #contact-email, #contact-message').attr("disabled", true);
				
				var data = {};
				data.contact_email = $j("#hb_contact_email_id").val();
				data.contact_name = $j("#hb_contact_name_id").val();
				data.contact_comments = $j("#hb_contact_message_id").val();
				data.action = "mail_action";
				
				$j.post(ajaxurl, data, onSuccessSend);
				$j('#hb-submit-contact-panel-form i').attr('class','hb-moon-spinner-8');

				sent = true;
				return;
			}
			else { $j("#contact-panel-form").validate().form(); }
		}
	});
}

function hb_onepage_nav(){
	if ( $j('#main-wrapper').hasClass('hb-one-page') ){
		var offs = 0;
		var $page_title = '';
		var $bullets = $j('#hb-one-page-bullets');

		if ( $j('#header-inner').hasClass('sticky-nav') ){
			offs = $j('#header-inner').attr('data-sticky-height');
		}

		$j('#main-nav').onePageNav({
		    currentClass: 'current-menu-item',
		    changeHash: false,
		    scrollSpeed: 500,
		    scrollOffset: offs,
		    scrollThreshold: 0.5,
		    filter: ':not(.external)',
		    easing: 'swing'
		});

		var $page_title = "";
		var $section_id = "";

		$j('.hb-one-page-section').each(function() {
			var $that = $j(this);
			if ($that.attr('data-title') !== undefined) {
				$page_title = " title=\"" + $that.attr('data-title') + "\"";
			}
			$section_id = $that.attr('id');
			$bullets.append('<li class="hb-animate-element top-to-bottom"'+ $page_title +' rel="tooltip" data-placement="right"><a href="#' + $section_id +'"><i class="hb-moon-circle-small"></i></a></li>');
		});

		var good_height = ($j(window).height() - $bullets.height())/2;
		$bullets.css('top', good_height);

		$j(window).resize(function(){
			var good_height = ($j(window).height() - $bullets.height())/2;
			$bullets.css('top', good_height);
		});

		$j('#hb-one-page-bullets li a').click(function(e) {
			e.preventDefault();
			var anch = $j(this).attr('href');
			$j.scrollTo( anch, 500, {easing:'swing', offset:-offs} );
		});

	}
}

function hb_smooth_scroll(){
	var offs = 0;
	
	if ( $j('#header-inner').hasClass('sticky-nav') ){
		offs = $j('#header-inner').attr('data-sticky-height');
	}

	$j('.smooth-scroll').click(function(e) {
		e.preventDefault();

		if ( $j(this).is("a") ) {
			var anch = $j(this).attr('href');
			$j.scrollTo( anch, 800, {easing:'easeInOutQuad', offset:-offs} );
		} else {
			var $that = $j(this).find('a');
			var anch = $that.attr('href');
			$j.scrollTo( anch, 800, {easing:'easeInOutQuad', offset:-offs} );
		}
	});
}

/* Other Contact Forms */
function hb_contact_forms_spec(){
	var sent_spec = false;
	var sNameValidate = false;
	var sEmailValidate = false;
	var sCommentsValidate = false;
		
	$j("#sp-contact-name").blur(function () {
		sNameValidate = $j("#sp-contact-form").validate().element("#sp-contact-name");
	});
	$j("#sp-contact-email").blur(function () {
		sEmailValidate = $j("#sp-contact-form").validate().element("#sp-contact-email");
	});
	$j("#sp-contact-message").blur(function () {
		sCommentsValidate = $j("#sp-contact-form").validate().element("#sp-contact-message");
	});
	
	$j('#special-submit-form').click(function(e) {
		e.preventDefault();
		if (!sent_spec){

			if ($j('#hb_contact_subject_id').val()){
				alert("Sorry - bots are not allowed!");
				return false;
			}
				
			if( sNameValidate && sEmailValidate && sCommentsValidate ) {
				$j('#sp-contact-name, #sp-contact-email, #sp-contact-message').attr("disabled", true);
				
				var data_s = {};
				data_s.contact_email = $j("#sp-contact-email").val();
				data_s.contact_name = $j("#sp-contact-name").val();
				data_s.contact_comments = $j("#sp-contact-message").val();
				data_s.action = "mail_action";
				
				$j.post(ajaxurl, data_s, onSuccessSendSpec);

				sent_spec = true;
				return;
			}
			else { $j("#sp-contact-form").validate().form(); }
		}
	});
}

/* Contact Forms */
function onSuccessSendSpec(results){
	var success_text = $j('#success_text_special').val();
	$j('#special-submit-form i').attr('class','hb-moon-checkmark');
	$j('#special-submit-form').html(success_text).addClass('disabled-button');

	$j('#sp-contact-name').attr("disabled", "disabled");
	$j('#sp-contact-email').attr("disabled", "disabled");
	$j('#sp-contact-message').attr("disabled", "disabled");
}

/* Toggle the overlay */
function hb_toggle_modal_overlay(){
	
	var $overlay = $j('#hb-modal-overlay');

	if ( $overlay.length ){
		if ($overlay.hasClass('visible')){
			$j('#hb-modal-overlay').fadeOut(220);
			$overlay.removeClass('visible');
		} else {
			$j('#hb-modal-overlay').fadeIn(220);
			$overlay.addClass('visible');
		}
	}
}

function hb_woo_stuff(){
	var $sticky_count = 0;
	$j('body').bind('added_to_cart', function() {
		$j('.product-loading-icon').removeClass('preloading hb-spin').addClass('hb-added-to-cart');
		if ( $j('#sticky-shop-button').length ){
			$sticky_count = parseInt($j('#sticky-shop-button').find('span').html()) + 1;
			$j('#sticky-shop-button').find('span').html($sticky_count);
		}
	});

	$j("body").on("click touchstart", ".hb-buy-button", function () {
		if ( !$j(this).hasClass('no-action-mark') ){
			$j(this).parent().find('.product-loading-icon').addClass('preloading hb-spin').removeClass('hb-added-to-cart').css('opacity', '1');
		}
	});

	var $current_hovered;
	$j('body').on("mouseenter", ".hb-woo-image-wrap", function () {
	    $j(this).find('.product-hover-image').css('opacity', '1');
	    $current_hovered = $j(this);
	}).on("mouseleave", ".hb-woo-image-wrap", function () {
	    $current_hovered.find('.product-hover-image').css('opacity', '0');
	});
}


function hb_center_me(){
	if ( $j('.hb-center-me').length ) {
		$j('.hb-center-me').each(function() {

			var $hght = $j(this).outerHeight()/2;
			$j(this).css("margin-top", -$hght + "px");
		});
	}
}


function hb_count_gallery_filters(){
	if ( $j('.hb-grid-filter').length ){
		var $that = null;
		var $filter = null;
		var $filter_count = null;
		var count = 0;

		$j('.hb-grid-filter .hb-gallery-dropdown li').each(function(){
			$that = $j(this);
			$filter = $that.find('a').attr('data-filter');
			$filter_count = $that.find('a').find('.hb-filter-count');

			if ($filter == '*'){
				// Count all gallery items
				count = $j('.fw-gallery-wrap .elastic-item').length;
			} else {
				// Count for each category
				count = $j('.fw-gallery-wrap .' + $filter).length;
			}
			$filter_count.html('(' + count + ')');
		});
	} else if ( $j('.standard-gallery-filter').length ){
		var $that = null;
		var $filter = null;
		var $filter_count = null;
		var count = 0;

		$j('.filt-tabs li').each(function(){
			$that = $j(this);
			$filter = $that.find('a').attr('data-filter');
			$filter_count = $that.find('a').find('.item-count');

			if ($filter == '*'){
				// Count all gallery items
				count = $j('#standard-gallery-masonry .standard-gallery-item-wrap').length;
			} else {
				// Count for each category
				count = $j('#standard-gallery-masonry ' + $filter).length;
			}
			$filter_count.html(count);
		});
	}
}

function hb_faq_filter(){
	if ( $j('.faq-filter').length ){
		var $elems = $j('.faq-filter li a');
		var $data_filter = null;

		if ( $j('.faq-filter').length ){
			$elems.each(function(){
				$that = $j(this);
	            $data_filter = $that.attr('data-filter');

	            if ($data_filter == '*'){
	            	$that.find('.hb-filter-count').html( $j('.faq-module-wrapper').find('.hb-toggle').length );
	            } else {
	            	$that.find('.hb-filter-count').html( $j('.faq-module-wrapper').find('.' + $data_filter).length );
	            }
			});
		}

		$j(document).on('touchstart click', '.faq-filter li a', function(event){
	        event.stopPropagation();
	        event.preventDefault();
	        if(event.handled !== true) {
	        	$that = $j(this);
	            $data_filter = $that.attr('data-filter');

	            $j('.faq-module-wrapper').find('.selected').removeClass('selected');
	            $that.parent().addClass('selected');

	            if ($data_filter == '*'){
	            	$j('.faq-module-wrapper').find('.hb-toggle').slideDown(0);
	            } else {
	            	$j('.faq-module-wrapper').find('.hb-toggle').slideUp(0);
	            	$j('.faq-module-wrapper').find('.' + $data_filter).slideDown(0);
	            }

	            event.handled = true;
	        } else {
	            return false;
	        }
		});
	}
}

function hb_modal_on_load(){
	if ( $j('.modal-show-on-load').length ){
		$j('.modal-show-on-load').each(function(){
			var $that = $j(this);

			var $modal_id = $that.attr('id');

			if ( $j('#'+$modal_id).hasClass('rendered') ){
				setTimeout(function () {
					$j('#'+$modal_id).addClass('animate-modal');
				}, 220);
				$j('body').addClass('no-scroll');
			} else {
				 setTimeout(function () {
                    $j('#'+$modal_id).addClass('rendered animate-modal');
                }, 220);
				$j('body').addClass('no-scroll');
				$the_modal = $j('#'+$modal_id).parent().html();
				$j('#'+$modal_id).parent().remove();
				$j('#hb-modal-overlay').append($the_modal);
			}

			hb_toggle_modal_overlay();
		});

		/* Countdowns */
		if ( $j('.hb-countdown-unit').length ){
			var date_value;
				
			$j('.hb-countdown-unit').each(function() {
				date_value = $j(this).attr('data-date');
				$j(this).countdown({
					date: date_value,
					format: "on"
				});
			});
		}
	}
}