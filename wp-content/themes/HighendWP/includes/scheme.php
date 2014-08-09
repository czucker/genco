<?php

/* SCHEME STYLES
 ================================================== */
 if (!function_exists('hb_scheme_styles')) { 
	function hb_scheme_styles() {

		$focus_hex_color = "#00aeef";
		$color_value = hb_options('hb_scheme_chooser');

		if ( isset($_GET['focus_color']) ){
			$color_value = $_GET['focus_color'];
		}

		if ( hb_options('hb_color_manager_type') == 'hb_color_manager_schemes' ){
			if ( $color_value == 'minimal_red' ){
				$focus_hex_color = "#c0392b";
			} else if ( $color_value == 'minimal_green' ){
				$focus_hex_color = "#27ae60";
			} else if ( $color_value == 'minimal_pink' ){
				$focus_hex_color = "#F07FB2";
			} else if ( $color_value == 'minimal_yellow' ){
				$focus_hex_color = "#f1c40f";
			} else if ( $color_value == 'minimal_orange' ){
				$focus_hex_color = "#e67e22";
			} else if ( $color_value == 'minimal_purple' ){
				$focus_hex_color = "#8e44ad";
			} else if ( $color_value == 'minimal_grey' ){
				$focus_hex_color = "#7f8c8d";
			} else if ( $color_value == 'minimal_blue_alt' || $color_value == 'business_blue' ){
				$focus_hex_color = "#2980b9";
			} else if ( $color_value == 'dark_elegance' ){
				$focus_hex_color = "#1BCBD1";
			} else if ( $color_value == 'minimal_green_alt' ){
				$focus_hex_color = "#a0ce4e";
			} else if ( $color_value == 'orchyd' ){
				$focus_hex_color = "#E8BF56";
			} else {
				$focus_hex_color = "#00aeef";
			}

			set_focus_color($focus_hex_color);

		} else if ( hb_options('hb_color_manager_type') == 'hb_color_manager_color_customizer' ) {
			if ( get_theme_mod( 'hb_focus_color_setting') ) {
				$focus_hex_color = get_theme_mod( 'hb_focus_color_setting' ); 
			} else {
				$focus_hex_color = "00aeef";
			}
			set_focus_color($focus_hex_color);
		}

		?>
		<style type="text/css">
		<?php
		echo '
		::selection { background:'.$focus_hex_color.'; color:#FFF; }
		::-moz-selection { background:'.$focus_hex_color.'; color:#FFF; }

		a:hover, .user-entry a, 
		.widget_calendar tbody a,
		#header-bar a:hover,
		.minimal-skin #main-nav > li a:hover,
		#header-inner.stuck .second-skin #main-nav > li > a:hover,
		.minimal-skin #main-nav li.current-menu-item > a,
		.minimal-skin #main-nav li.sfHover > a, 
		.minimal-skin #main-nav > li.current-menu-ancestor > a,
		#close-fancy-search,
		article.search-entry a.search-thumb:hover,
		.map-info-section .minimize-section:hover,
		.hb-blog-small h3.title a:hover,
		.post-header .post-meta-info a:hover,
		.post-content h2.title a,
		.like-holder:hover i,
		.comments-holder:hover i,
		.share-holder:hover i,
		.comments-holder a:hover,
		.hb-blog-grid .comments-holder:hover, 
		.hb-blog-grid .like-holder:hover,
		.most-liked-list li:hover .like-count,
		.simple-read-more:hover,
		.team-member-box:hover .team-member-name,
		.testimonial-author .testimonial-company:hover,
		.close-modal:hover,
		.hb-tabs-wrapper .nav-tabs li.active a,
		.hb-icon,
		.hb-logout-box small a:hover,
		.hb-gallery-sort li.hb-dd-header:hover strong,
		.filter-tabs li a:hover,
		ul.social-list li a:hover,
		div.pp_default .pp_close:hover,
		#main-wrapper .hb-woo-product.sale .price,
		.woocommerce .star-rating span, .woocommerce-page .star-rating span,
		.woocommerce-page div.product p.price, .hb-focus-color { color:'.$focus_hex_color.'; }

		.hb-focus-color, 
		.light-text a:hover, 
		#header-bar.style-1 .top-widget .active,
		#header-bar.style-2 .top-widget .active, 
		.top-widget:hover > a,
		#header-bar.style-2 .top-widget:hover > a,
		.top-widget.social-list a:hover,
		#main-wrapper .hb-dropdown-box a:hover,
		.social-list ul li a:hover,
		light-menu-dropdown #main-nav ul.sub-menu li a:hover,
		.light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a,
		.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-item > a,
		.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-ancestor > a,
		#fancy-search .ui-autocomplete li a:hover,
		#fancy-search .ui-autocomplete li:hover span.search-title,
		#fancy-search .ui-autocomplete li a,
		#nav-search > a:hover,
		.share-holder .hb-dropdown-box ul li a:hover,
		.share-holder .hb-dropdown-box ul li a:hover i,
		.share-holder.active,
		.share-holder.active i,
		.author-box .social-list li a:hover,
		#respond small a:hover,
		.commentmetadata a:hover time,
		.comments-list .reply a,
		#footer.dark-style a:hover,
		.feature-box i.ic-holder-1,
		.feature-box.alternative i.ic-holder-1,
		.portfolio-simple-wrap .standard-gallery-item:hover .portfolio-description h3 a,
		#copyright-wrapper a:hover,
		.hb-effect-1 #main-nav > li > a::before, 
		.hb-effect-1 a::after,
		.third-skin.hb-effect-1 #main-nav > li > a:hover, 
		.third-skin.hb-effect-1 #main-nav > li.current-menu-item > a, 
		.third-skin.hb-effect-1 #main-nav > li.sfHover > a,
		.second-skin.hb-effect-9 #main-nav #nav-search > a:hover,
		.hb-effect-10 #main-nav > li > a:hover, 
		.hb-effect-10 #main-nav > li #nav-search a:hover, 
		.hb-effect-10 #main-nav > li.current-menu-item > a,
		.like-holder:hover,
		.comments-holder:hover,
		.share-holder:hover,
		#main-nav ul.sub-menu li a:hover { color: '.$focus_hex_color.'!important; }

		.light-style .feature-box i.ic-holder-1,
		.light-style .feature-box.alternative i.ic-holder-1,
		.light-style .feature-box h4.bold {
			color: #f9f9f9 !important;
		}

		.light-style .feature-box-content p {
			color: #ccc;
		}

		.like-holder.like-active i, .like-holder.like-active { color: #da4c26 !important; }

		.hb-icon-container,
		.feature-box i.ic-holder-1 {
			border-color: '.$focus_hex_color.';
		}

		.main-navigation.default-skin #main-nav > li > a:hover > span, 
		.main-navigation.default-skin #main-nav > li.current-menu-item > a > span, 
		.main-navigation.default-skin #main-nav > li.sfHover > a > span,
		.simple-read-more,
		.team-member-box.tmb-2:hover .team-member-description,
		.hb-logout-box small a:hover,
		#pre-footer-area,
		span[rel="tooltip"] { border-bottom-color: '.$focus_hex_color.'; }

		.hb-pricing-item:hover,
		.hb-process-steps ul:before,
		.pace .pace-activity,
		.wpb_tabs .nav-tabs li.active a {
			border-top-color: '.$focus_hex_color.';
		}

		blockquote.pullquote,
		.author-box,
		#main-wrapper .widget_nav_menu ul.menu li.current-menu-item > a,
		.hb-callout-box h3,
		.pace .pace-activity,
		.hb-tabs-wrapper.tour-style.left-tabs > .nav-tabs > li.active a,
		.light-menu-dropdown #main-nav ul.sub-menu li a:hover,.light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a,.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-item > a, .light-menu-dropdown #main-nav ul.sub-menu li.current-menu-ancestor > a, .light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a {
			border-left-color: '.$focus_hex_color.';
		}

		#main-wrapper .right-sidebar .widget_nav_menu ul.menu li.current-menu-item > a,
		.hb-tabs-wrapper.tour-style.right-tabs > .nav-tabs > li.active a {
			border-right-color: '.$focus_hex_color.';
		}

		#to-top:hover,
		#contact-button:hover, 
		#contact-button.active-c-button,
		.pagination ul li span, 
		.single .pagination span,
		.single-post-tags a:hover,
		div.overlay,
		.portfolio-simple-wrap .standard-gallery-item:hover .hb-gallery-item-name:before,
		.progress-inner,
		.woocommerce .wc-new-badge,
		#main-wrapper .coupon-code input.button:hover,
		.woocommerce-page #main-wrapper button.button:hover,
		#main-wrapper input.checkout-button { background-color:'.$focus_hex_color.'; }

		#header-dropdown .close-map:hover,
		#sticky-shop-button:hover,
		#sticky-shop-button span,
		.quote-post-format .quote-post-wrapper a,
		.link-post-format .quote-post-wrapper a,
		.status-post-format .quote-post-wrapper a,
		span.highlight,
		mark,
		.feature-box:hover:not(.standard-icon-box) .hb-small-break,
		.content-box i.box-icon,
		.hb-button, input[type=submit], a.read-more,
		.hb-effect-2 #main-nav > li > a > span::after,
		.hb-effect-3 #main-nav > li > a::before,
		.hb-effect-4 #main-nav > li > a::before,
		.hb-effect-6 #main-nav > li > a::before,
		.hb-effect-7 #main-nav > li > a span::after,
		.hb-effect-8 #main-nav > li > a:hover span::before,
		.hb-effect-9 #main-nav > li > a > span::before,
		.hb-effect-9 #main-nav > li > a > span::after,
		.hb-effect-10 #main-nav > li > a:hover span::before, 
		.hb-effect-10 #main-nav > li.current-menu-item > a span::before, 
		#main-nav > li.sfHover > a span::before, 
		#main-nav > li.current-menu-ancestor > a span::before,
		.pace .pace-progress,
		#main-wrapper .hb-bag-buttons a.checkout-button {background: '.$focus_hex_color.';}

		.filter-tabs li.selected a, #main-wrapper .single_add_to_cart_button:hover {
			background: '.$focus_hex_color.' !important;
		}

		table.focus-header th,
		.second-skin #main-nav > li a:hover,
		.second-skin #main-nav > li.current-menu-item > a,
		.second-skin #main-nav > li.sfHover > a,
		#header-inner.stuck .second-skin #main-nav > li > a:hover,
		.second-skin #main-nav > li.current-menu-item > a,
		.crsl-nav a:hover,
		.feature-box:hover i.ic-holder-1 {
			background: '.$focus_hex_color.';
			color: #FFF;
		}


		.load-more-posts:hover,
		.dropcap.fancy,
		.tagcloud > a:hover,
		.hb-icon.hb-icon-medium.hb-icon-container:hover {
			background-color: '.$focus_hex_color.';
			color: #FFF;
		}

		.filter-tabs li.selected a {
			border-color: '.$focus_hex_color.' !important;
		}

		.hb-second-light:hover {background:#FFF!important;color:'.$focus_hex_color.'!important;}

		.hb-effect-11 #main-nav > li > a:hover::before,
		.hb-effect-11 #main-nav > li.sfHover > a::before,
		.hb-effect-11 #main-nav > li.current-menu-item > a::before,
		.hb-effect-11 #main-nav > li.current-menu-ancestor > a::before  {
			color: '.$focus_hex_color.';
			text-shadow: 7px 0 '.$focus_hex_color.', -7px 0 '.$focus_hex_color.';
		}

		#main-wrapper .product-loading-icon {
			background: '. hb_color($focus_hex_color, 0.85).';
		}

		.item-overlay-text {
			background: #323436;
			background: rgba(0,0,0,0.85);
		}

		.hb-button, input[type=submit]{
			box-shadow: 0 3px 0 0 '. hb_darken_color($focus_hex_color, -50) .';
		}

		.hb-button.special-icon i,
		.hb-button.special-icon i::after {
			background:' . hb_darken_color($focus_hex_color, -50) . ';
		}

		#main-wrapper a.active-language, #main-wrapper a.active-language:hover {color: #aaa !important; }
		.feature-box:hover:not(.standard-icon-box):not(.alternative) i, #main-wrapper .hb-bag-buttons a:hover, #main-wrapper .hb-dropdown-box .hb-bag-buttons a:hover,
		#main-wrapper .social-icons.dark li a:hover i, #main-wrapper #footer .social-icons.dark li a i, 
		#footer.dark-style ul.social-icons.light li a:hover,
		#main-wrapper .hb-single-next-prev a:hover {color: #FFF !important;}';

		if ( hb_options('hb_color_manager_type') == 'hb_color_manager_color_customizer' ){
			if (get_theme_mod('hb_top_bar_bg_setting')){
				echo '#header-bar { background-color:' . get_theme_mod('hb_top_bar_bg_setting') . '}';
			}

			if (get_theme_mod('hb_top_bar_text_color_setting')){
				echo '#header-bar, #fancy-search input[type=text], #fancy-search ::-webkit-input-placeholder { color:' . get_theme_mod('hb_top_bar_text_color_setting') . '}';
			}

			if (get_theme_mod('hb_top_bar_link_color_setting')){
				echo '#header-bar a { color:' . get_theme_mod('hb_top_bar_link_color_setting') . '}';
			}

			if (get_theme_mod('hb_top_bar_border_setting')){
				echo '#header-bar { border-bottom-color:' . get_theme_mod('hb_top_bar_border_setting') . '}';
				echo '#header-bar .top-widget { border-right-color: '. get_theme_mod('hb_top_bar_border_setting') .'!important; border-left-color: '.get_theme_mod('hb_top_bar_border_setting').'; }';
			}

			if (get_theme_mod('hb_nav_bar_bg_setting')){
				echo '#header-inner-bg {background-color: '.get_theme_mod('hb_nav_bar_bg_setting').';}';
			}

			if (get_theme_mod('hb_nav_bar_stuck_bg_setting')){
				echo '#header-inner.stuck #header-inner-bg { background-color: '.get_theme_mod('hb_nav_bar_stuck_bg_setting').'; }';
			}

			if (get_theme_mod('hb_nav_bar_border_setting')){
				echo '#header-inner.nav-type-2 .main-navigation { border-top-color: '.get_theme_mod('hb_nav_bar_border_setting').'; }';
				echo '#header-inner-bg {border-bottom-color: '.get_theme_mod('hb_nav_bar_border_setting').'}';
				echo '#main-nav li#nav-search::before {background:'.get_theme_mod('hb_nav_bar_border_setting').'}';
				echo '#header-inner.nav-type-2 #main-nav > li:first-child > a, #header-inner.nav-type-2 li#nav-search > a { border-left-color: '.get_theme_mod('hb_nav_bar_border_setting').'; }';
				echo '#header-inner.nav-type-2 #main-nav > li > a { border-right-color: '.get_theme_mod('hb_nav_bar_border_setting').'; }';
			}

			if (get_theme_mod('hb_nav_bar_stuck_border_setting')){
				echo '#header-inner.stuck #header-inner-bg { border-bottom-color:'.get_theme_mod('hb_nav_bar_stuck_border_setting').' !important; }';
				echo '#header-inner.stuck #main-nav li#nav-search::before {background: '.get_theme_mod('hb_nav_bar_stuck_border_setting').'}';
			}

			if (get_theme_mod('hb_nav_bar_text_setting')){
				echo '#main-wrapper #main-nav > li > a, #main-wrapper #header-inner-bg { color:'.get_theme_mod('hb_nav_bar_text_setting').' !important; }';
			}

			if (get_theme_mod('hb_nav_bar_stuck_text_setting')){
				echo '#main-wrapper #header-inner.stuck #main-nav > li > a, #main-wrapper #header-inner.stuck #header-inner-bg { color:'.get_theme_mod('hb_nav_bar_stuck_text_setting').' !important; }';
			}

			if (get_theme_mod('hb_pfooter_bg_setting')){
				echo '#pre-footer-area {background-color: '.get_theme_mod('hb_pfooter_bg_setting').';}';
			}

			if (get_theme_mod('hb_pfooter_text_setting')){
				echo '#pre-footer-area {color: '.get_theme_mod('hb_pfooter_text_setting').';}';
			}

			if (get_theme_mod('hb_footer_bg_setting')){
				echo '#footer { background-color: '.get_theme_mod('hb_footer_bg_setting').'; }';
			}

			if (get_theme_mod('hb_footer_text_setting')){
				echo '#footer { color: '.get_theme_mod('hb_footer_text_setting').'; }';
			}

			if (get_theme_mod('hb_footer_text_setting')){
				echo '#main-wrapper #footer {color: '.get_theme_mod('hb_footer_text_setting').';}';
			}

			if (get_theme_mod('hb_footer_link_setting')){
				echo '#main-wrapper #footer a { color: '.get_theme_mod('hb_footer_link_setting').'; }';
			}

			if (get_theme_mod('hb_copyright_bg_setting')){
				echo '#copyright-wrapper {background: '.get_theme_mod('hb_copyright_bg_setting').';}';
			}

			if (get_theme_mod('hb_copyright_text_setting')){
				echo '#copyright-wrapper {color: '.get_theme_mod('hb_copyright_text_setting').';}';
			}

			if (get_theme_mod('hb_copyright_link_setting')){
				echo '#copyright-wrapper a {color: '.get_theme_mod('hb_copyright_link_setting').';}';
			}

			if (get_theme_mod('hb_content_bg_setting')){
				echo 'body {background-color: '.get_theme_mod('hb_content_bg_setting').';}';
			}

			if (get_theme_mod('hb_content_c_bg_setting')){
				echo '#main-wrapper, #main-wrapper.hb-stretched-layout, #main-wrapper.hb-boxed-layout {background-color: '.get_theme_mod('hb_content_c_bg_setting').';}';
				echo '#main-wrapper #pre-footer-area:after {border-top-color: '.get_theme_mod('hb_content_c_bg_setting').';}';
			}

			if (get_theme_mod('hb_content_text_color_setting')){
				echo '#main-wrapper .hb-main-content, #main-wrapper .hb-sidebar, .hb-testimonial-quote p {color: '.get_theme_mod('hb_content_text_color_setting').';}';
			}

			if (get_theme_mod('hb_content_link_color_setting')){
				echo '#main-wrapper .hb-main-content a, select { color: '.get_theme_mod('hb_content_link_color_setting').' }';
				echo '#main-wrapper .hb-main-content a:hover {color: '.$focus_hex_color.';}';
			}

			if (get_theme_mod('hb_content_border_setting')){
				echo '
					.portfolio-single-meta ul, .content-box, #main-wrapper .hb-accordion-pane, .hb-accordion-tab, .hb-box-cont, .hb-tabs-wrapper.tour-style .tab-content, .hb-tabs-wrapper .nav-tabs li a, .hb-callout-box, .hb-teaser-column .teaser-content. .hb-pricing-item, .hb-testimonial:after, .hb-testimonial, .tmb-2 .team-member-description, .recent-comments-content, .recent-comments-content:after, .hb-tweet-list.light li, .hb-tweet-list.light li:after, fieldset,table,.wp-caption-text, .gallery-caption, .author-box, .comments-list .children > li::before, .widget_nav_menu ul.menu, .comments-list li.comment > div.comment-body, .hb-dropdown-box, #contact-panel, .filter-tabs li a, #contact-panel::after, .hb-flexslider-wrapper.bordered-wrapper,.bordered-wrapper, iframe.fw {border-color:'.get_theme_mod('hb_content_border_setting').';}

				#main-content .left-sidebar .hb-main-content.col-9, table th, table th, table td, #main-content .hb-sidebar, .comments-list .children, .tmb-2 .team-member-img, .hb-tabs-wrapper .tab-content, div.pp_default .pp_close {border-left-color:'.get_theme_mod('hb_content_border_setting').';}

				table td, .hb-blog-small .meta-info, #main-wrapper .widget_nav_menu ul.menu ul li:first-child, #main-wrapper .bottom-meta-section, .comments-list .children > li::after, .tmb-2 .team-member-img, h5.hb-heading span:not(.special-amp):before, h4.hb-heading span:not(.special-amp):before,h4.hb-heading span:not(.special-amp):after,h5.hb-heading span:not(.special-amp):after,h3.hb-heading span:not(.special-amp):before,h3.hb-heading span:not(.special-amp):after,h4.lined-heading span:not(.special-amp):before,h4.lined-heading span:not(.special-amp):after, .hb-fw-separator, .hb-separator-s-1, .hb-separator-extra, .hb-separator-25, .hb-gal-standard-description .hb-small-separator {border-top-color:'.get_theme_mod('hb_content_border_setting').';}

				.pricing-table-caption, .pricing-table-price, #hb-page-title, .share-holder .hb-dropdown-box ul li, .hb-blog-small .meta-info, .hb_latest_posts_widget article, .most-liked-list li, ul.hb-ul-list.line-list li, ol.line-list li, ul.line-list li, #hb-blog-posts.unboxed-blog-layout article, .hb-tabs-wrapper .nav-tabs, #main-wrapper .wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a, .hb-tabs-wrapper .tab-content, .hb-tabs-wrapper.tour-style .nav-tabs li.active a, .hb-box-cont-header, .hb-separator.double-border, .portfolio-single-meta ul.meta-list li {border-bottom-color:'.get_theme_mod('hb_content_border_setting').';}

				#main-content .col-9.hb-main-content, #main-content .left-sidebar .hb-sidebar.col-3, .tmb-2 .team-member-img, .hb-tabs-wrapper .tab-content, .hb-tabs-wrapper.tour-style.right-tabs .nav-tabs > li.active a, div.pp_default .pp_nav {border-right-color:'.get_theme_mod('hb_content_border_setting').';}

				.pagination ul li a, .pagination ul li span.page-numbers.dots, .single .pagination a, .page-links a, .hb-skill-meter .hb-progress-bar, .hb-counter .count-separator span, .hb-small-break, hr {background-color: '.get_theme_mod('hb_content_border_setting').';}

				#main-wrapper .hb-tabs-wrapper:not(.wpb_tabs) ul li:last-child a, .darker-border .hb-separator {border-bottom-color: "+newval+" !important;}
				.darker-border .hb-separator {border-top-color: '.get_theme_mod('hb_content_border_setting').' !important;}';
			}

			if (get_theme_mod('hb_content_h1_setting')){
				echo 'h1, h1.extra-large, h1 a, article.single h1.title { color: '.get_theme_mod('hb_content_h1_setting').'; }';
				echo '.hb-page-title.dark-text h1, .hb-page-title.light-text h1, p.hb-text-large { color: '.get_theme_mod('hb_content_h1_setting').'!important; }';
				echo '#main-wrapper h1.hb-bordered-heading {color: '.get_theme_mod('hb_content_h1_setting').'; border-color: '.get_theme_mod('hb_content_h1_setting').';}';
			}

			if (get_theme_mod('hb_content_h2_setting')){
				echo 'h2, #hb-page-title h2 { color: '.get_theme_mod('hb_content_h2_setting').'; }';
				echo '#main-wrapper h2.hb-bordered-heading {color: '.get_theme_mod('hb_content_h2_setting').'; border-color: '.get_theme_mod('hb_content_h2_setting').';}';
			}

			if (get_theme_mod('hb_content_h3_setting')){
				echo 'h3, #respond h3, h3.title-class, .hb-callout-box h3, .hb-gal-standard-description h3 { color: '.get_theme_mod('hb_content_h3_setting').'; }';
				echo '#main-wrapper h3.hb-bordered-heading {color: '.get_theme_mod('hb_content_h3_setting').'; border-color: '.get_theme_mod('hb_content_h3_setting').';}';
			}

			if (get_theme_mod('hb_content_h4_setting')){
				echo 'h4, .widget-item h4, .content-box h4, .feature-box h4.bold { color: '.get_theme_mod('hb_content_h4_setting').'; }';
				echo '#main-wrapper h4.hb-bordered-heading {color: '.get_theme_mod('hb_content_h4_setting').'; border-color: '.get_theme_mod('hb_content_h4_setting').';}';
			}

			if (get_theme_mod('hb_content_h5_setting')){
				echo 'h5, #comments h5, #respond h5, .testimonial-author h5 { color: '.get_theme_mod('hb_content_h5_setting').'; }';
			}

			if (get_theme_mod('hb_content_h6_setting')){
				echo 'h6, .single-post-tags span, h6.special, .blog-shortcode-1 h6 { color: '.get_theme_mod('hb_content_h6_setting').'; }';
			}
		}

		if ( hb_options('hb_color_manager_type') == 'hb_color_manager_schemes' ){
			if ( $color_value == 'business_blue' ){
				echo '
					#header-bar { background: #34495e; color: #FFF; color: rgba(255,255,255,0.7); border-bottom: 0 !important;  }
					#header-bar a { color: #FFF; color: rgba(255,255,255,0.7); }
					#header-bar a:hover, #header-bar.style-1 .top-widget .active { color: #FFF !important; }
					#header-bar.style-1 .top-widget .active { color: #FFF !important; }
					#main-wrapper #header-bar .top-widget {border-left-color: rgba(255,255,255,0.15) !important; border-right-color: rgba(255,255,255,0.15) !important; }
					#footer {background: #2c3e50;}
					#copyright-wrapper {background: #34495e;}
					#main-wrapper.hb-boxed-layout,
					#main-wrapper.hb-stretched-layout {background: #FFF;}
					#main-wrapper.hb-boxed-layout #pre-footer-area:after {border-top-color: #FFF;}

					#footer {color: rgba(255,255,255,0.6) !important;}
					#main-wrapper #footer a:hover, #main-wrapper #copyright-wrapper a:hover {color: #FFF !important;}

					#footer .widget_pages ul > li,
					#footer .widget_categories ul > li,
					#footer .widget_archive ul > li, 
					#footer .widget_nav_menu ul > li, 
					#footer .widget_recent_comments ul > li, 
					#footer .widget_meta ul > li, 
					#footer .widget_recent_entries ul > li, 
					#footer .widget_product_categories ul > li, 
					#footer .widget_layered_nav ul li {
						border-top-color: rgba(255,255,255,0.1);
					}

					#footer.dark-style .widget-item h4 {color: #FFF !important;}

				';
			} else if ( $color_value == 'dark_elegance' ){
				echo '
					#header-bar { background: #292929; color: #FFF; color: rgba(255,255,255,0.7); border-bottom: solid 1px #333; border-bottom-color: rgba(255,255,255,0.15)  }
					#header-bar a { color: #FFF; color: rgba(255,255,255,0.7); }
					#main-wrapper #header-bar .top-widget {border-left:none !important; border-right: none !important; }

					#header-inner-bg {background: #222; color:#FFF;}
					#main-nav>li>a {color: #FFF !important;}
					#header-inner.stuck #header-inner-bg {background: #222; border-bottom: solid 1px #333;}
					#fancy-search input[type=text] {color: #FFF;}
					#fancy-search ::-webkit-input-placeholder{color:rgba(255,255,255,0.5);}
					#hb-header h1, #hb-header h2, #hb-header h3, #hb-header h4, #hb-header h5, #hb-header h6 {color: #FFF;}
					#header-inner.nav-type-2 #main-nav > li > a { border-left-color: rgba(255,255,255,0.1) !important; border-right-color: rgba(255,255,255,0.1) !important; }
					#header-inner.nav-type-2 .main-navigation { border-top-color: rgba(255,255,255,0.1) !important; }

					.third-skin #main-nav > li > a:hover, #header-inner.stuck .second-skin #main-nav > li > a:hover, .third-skin #main-nav > li.current-menu-item > a, .third-skin #main-nav > li.sfHover > a, .third-skin #main-nav > li.current-menu-ancestor > a {color: '.$focus_hex_color.' !important;}
					#main-wrapper #header-inner-bg {border-bottom-color:#333 !important}
				';
			}
			else if ( $color_value == 'orchyd' ){
				echo '
					#header-bar { background: #6B3078; color: #FFF; color: rgba(255,255,255,0.7); border-bottom: solid 1px #333; border-bottom-color: rgba(255,255,255,0.15)  }
					#header-bar a { color: #FFF; color: rgba(255,255,255,0.7); }
					#main-wrapper #header-bar .top-widget {border-left-color:rgba(255,255,255,0.15) !important; border-right-color: rgba(255,255,255,0.15) !important; }

					#header-inner-bg {background: #6B3078; color:#FFF;}
					#main-nav>li>a {color: #FFF !important;}
					#header-inner.stuck #header-inner-bg {background: #6B3078; border-bottom: solid 1px #6B3078;}
					#fancy-search input[type=text] {color: #FFF;}
					#fancy-search ::-webkit-input-placeholder{color:rgba(255,255,255,0.5);}
					#hb-header h1, #hb-header h2, #hb-header h3, #hb-header h4, #hb-header h5, #hb-header h6 {color: #FFF;}
					#header-inner.nav-type-2 #main-nav > li > a { border-left-color: rgba(255,255,255,0.1) !important; border-right-color: rgba(255,255,255,0.1) !important; }
					#header-inner.nav-type-2 .main-navigation { border-top-color: rgba(255,255,255,0.1) !important; }

					.third-skin #main-nav > li > a:hover, #header-inner.stuck .second-skin #main-nav > li > a:hover, .third-skin #main-nav > li.current-menu-item > a, .third-skin #main-nav > li.sfHover > a, .third-skin #main-nav > li.current-menu-ancestor > a {color: '.$focus_hex_color.' !important;}
					#main-wrapper #header-inner-bg {border-bottom-color:#333 !important}
					body #ascrail2000 div {background-color: #A84A78 !important;}
					#main-wrapper { background-color: #f0f0f0 !important; }
					#pre-footer-area:after { border-top-color: #f0f0f0; }
					#hb-page-title.hb-color-background {background-color: #202020 !important;}
				';
			}
		}

		if ( !is_archive() && !is_404() && !is_search() && vp_metabox('misc_settings.hb_special_header_style') ){
			?>
			#slider-section {
			    margin-top:-81px;
			}

			#header-inner:not(.stuck) #header-inner-bg{
			    background: transparent !important;
			}

			#main-wrapper #header-inner #main-nav > li > a {
			    color: #FFF;
			    font-weight: bold;
			}

			#header-inner:not(.stuck) { border-bottom:none; }
			#header-inner #header-inner-bg { border-bottom-color: rgba(255,255,255,0.15) !important; }

			#main-wrapper #header-inner #fancy-search input[type=text] {
			color: #FFF !important;
			}

			#main-wrapper #header-inner.stuck #header-inner-bg {
				background: #000;
				background: rgba(0,0,0,0.7)!important;
			}

			#main-wrapper #header-inner #fancy-search ::-webkit-input-placeholder { color: rgba(255,255,255,0.5); }

			#close-fancy-search:hover { color: #FFF !important; }

			#main-content .col-12.hb-main-content {
			    margin: 0;
			    padding: 0;
			}
			#slider-section { margin-bottom:-1px; }
			#main-wrapper { margin-bottom: 0px; }
			#main-content { padding-top: 0px !important; }

			#header-inner {
			border-bottom: 0;
			}
			<?php
		}

		// Custom CSS Code from Theme Options
		$custom_css_code = hb_options('hb_custom_css');
		if ($custom_css_code){
			echo $custom_css_code;
		}
		?>
		</style>
		<?php
	}
}

add_action('wp_head', 'hb_scheme_styles');

?>