/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {


	/* FOCUS COLOR SECTION
    ================================================== */
	wp.customize( 'hb_focus_color_setting', function( value ) {
		value.bind( function( newval ) {
			jQuery("#hb-toremove").remove();
			jQuery("<style id='hb-toremove'>\
				::selection { background:"+newval+"; color:#FFF; }\
				::-moz-selection { background:"+newval+"; color:#FFF; }\
				a:hover, .user-entry a,\
				.widget_calendar tbody a,\
				#header-bar a:hover,\
				.minimal-skin #main-nav > li a:hover,\
				#header-inner.stuck .second-skin #main-nav > li > a:hover,\
				.minimal-skin #main-nav li.current-menu-item > a,\
				.minimal-skin #main-nav li.sfHover > a,\
				.minimal-skin #main-nav > li.current-menu-ancestor > a,\
				#close-fancy-search,\
				article.search-entry a.search-thumb:hover,\
				.map-info-section .minimize-section:hover,\
				.hb-blog-small h3.title a:hover,\
				.post-header .post-meta-info a:hover,\
				.post-content h2.title a,\
				.like-holder:hover i,\
				.comments-holder:hover i,\
				.share-holder:hover i,\
				.comments-holder a:hover,\
				.hb-blog-grid .comments-holder:hover,\
				.hb-blog-grid .like-holder:hover,\
				.most-liked-list li:hover .like-count,\
				.simple-read-more:hover,\
				.team-member-box:hover .team-member-name,\
				.testimonial-author .testimonial-company:hover,\
				.close-modal:hover,\
				.hb-tabs-wrapper .nav-tabs li.active a,\
				.hb-icon,\
				.hb-logout-box small a:hover,\
				.hb-gallery-sort li.hb-dd-header:hover strong,\
				.filter-tabs li a:hover,\
				ul.social-list li a:hover,\
				div.pp_default .pp_close:hover,\
				#main-wrapper .hb-woo-product.sale .price,\
				.woocommerce .star-rating span, .woocommerce-page .star-rating span,\
				.woocommerce-page div.product p.price, .hb-focus-color { color:"+newval+"; }\
				.hb-focus-color,\
				.light-text a:hover,\
				#header-bar.style-1 .top-widget .active,\
				#header-bar.style-2 .top-widget .active,\
				.top-widget:hover > a,\
				#header-bar.style-2 .top-widget:hover > a,\
				.top-widget.social-list a:hover,\
				#main-wrapper .hb-dropdown-box a:hover,\
				.social-list ul li a:hover,\
				light-menu-dropdown #main-nav ul.sub-menu li a:hover,\
				.light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a,\
				.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-item > a,\
				.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-ancestor > a,\
				#fancy-search .ui-autocomplete li a:hover,\
				#fancy-search .ui-autocomplete li:hover span.search-title,\
				#fancy-search .ui-autocomplete li a,\
				#nav-search > a:hover,\
				.share-holder .hb-dropdown-box ul li a:hover,\
				.share-holder .hb-dropdown-box ul li a:hover i,\
				.share-holder.active,\
				.share-holder.active i,\
				.author-box .social-list li a:hover,\
				#respond small a:hover,\
				.commentmetadata a:hover time,\
				.comments-list .reply a,\
				#footer.dark-style a:hover,\
				.feature-box i.ic-holder-1,\
				.feature-box.alternative i.ic-holder-1,\
				.portfolio-simple-wrap .standard-gallery-item:hover .portfolio-description h3 a,\
				#copyright-wrapper a:hover,\
				.hb-effect-1 #main-nav > li > a::before,\
				.hb-effect-1 a::after,\
				.third-skin.hb-effect-1 #main-nav > li > a:hover,\
				.third-skin.hb-effect-1 #main-nav > li.current-menu-item > a,\
				.third-skin.hb-effect-1 #main-nav > li.sfHover > a,\
				.second-skin.hb-effect-9 #main-nav #nav-search > a:hover,\
				.hb-effect-10 #main-nav > li > a:hover,\
				.hb-effect-10 #main-nav > li #nav-search a:hover,\
				.hb-effect-10 #main-nav > li.current-menu-item > a,\
				.like-holder:hover,\
				.comments-holder:hover,\
				.share-holder:hover,\
				#main-nav ul.sub-menu li a:hover { color:"+newval+"!important; }\
				.light-style .feature-box i.ic-holder-1,\
				.light-style .feature-box.alternative i.ic-holder-1,\
				.light-style .feature-box h4.bold {\
					color: #f9f9f9 !important;\
				}\
				.light-style .feature-box-content p {\
					color: #ccc;\
				}\
				.like-holder.like-active i, .like-holder.like-active { color: #da4c26 !important; }\
				.hb-icon-container,\
				.feature-box i.ic-holder-1 {\
					border-color: "+newval+";\
				}\
				.main-navigation.default-skin #main-nav > li > a:hover > span,\
				.main-navigation.default-skin #main-nav > li.current-menu-item > a > span,\
				.main-navigation.default-skin #main-nav > li.sfHover > a > span,\
				.simple-read-more,\
				.team-member-box.tmb-2:hover .team-member-description,\
				.hb-logout-box small a:hover,\
				#pre-footer-area,\
				span[rel='tooltip'] { border-bottom-color: "+newval+"; }\
				.hb-pricing-item:hover,\
				.hb-process-steps ul:before,\
				.pace .pace-activity,\
				.wpb_tabs .nav-tabs li.active a {\
					border-top-color: "+newval+";\
				}\
				blockquote.pullquote,\
				.author-box,\
				#main-wrapper .widget_nav_menu ul.menu li.current-menu-item > a,\
				.hb-callout-box h3,\
				.pace .pace-activity,\
				.hb-tabs-wrapper.tour-style.left-tabs > .nav-tabs > li.active a,\
				.light-menu-dropdown #main-nav ul.sub-menu li a:hover,.light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a,.light-menu-dropdown #main-nav ul.sub-menu li.current-menu-item > a, .light-menu-dropdown #main-nav ul.sub-menu li.current-menu-ancestor > a, .light-menu-dropdown #main-nav ul.sub-menu li.sfHover > a {\
					border-left-color: "+newval+";\
				}\
				#main-wrapper .right-sidebar .widget_nav_menu ul.menu li.current-menu-item > a,\
				.hb-tabs-wrapper.tour-style.right-tabs > .nav-tabs > li.active a {\
					border-right-color: "+newval+";\
				}\
				#to-top:hover,\
				#contact-button:hover,\
				#contact-button.active-c-button,\
				.pagination ul li span,\
				.single .pagination span,\
				.single-post-tags a:hover,\
				div.overlay,\
				.portfolio-simple-wrap .standard-gallery-item:hover .hb-gallery-item-name:before,\
				.progress-inner,\
				.woocommerce .wc-new-badge,\
				#main-wrapper .coupon-code input.button:hover,\
				.woocommerce-page #main-wrapper button.button:hover,\
				#main-wrapper input.checkout-button { background-color:"+newval+"; }\
				#header-dropdown .close-map:hover,\
				#sticky-shop-button:hover,\
				#sticky-shop-button span,\
				.quote-post-format .quote-post-wrapper a,\
				.link-post-format .quote-post-wrapper a,\
				.status-post-format .quote-post-wrapper a,\
				span.highlight,\
				mark,\
				.feature-box:hover:not(.standard-icon-box) .hb-small-break,\
				.content-box i.box-icon,\
				.hb-button, input[type=submit], a.read-more,\
				.hb-effect-2 #main-nav > li > a > span::after,\
				.hb-effect-3 #main-nav > li > a::before,\
				.hb-effect-4 #main-nav > li > a::before,\
				.hb-effect-6 #main-nav > li > a::before,\
				.hb-effect-7 #main-nav > li > a span::after,\
				.hb-effect-8 #main-nav > li > a:hover span::before,\
				.hb-effect-9 #main-nav > li > a > span::before,\
				.hb-effect-9 #main-nav > li > a > span::after,\
				.hb-effect-10 #main-nav > li > a:hover span::before,\
				.hb-effect-10 #main-nav > li.current-menu-item > a span::before,\
				#main-nav > li.sfHover > a span::before,\
				#main-nav > li.current-menu-ancestor > a span::before,\
				.pace .pace-progress,\
				#main-wrapper .hb-bag-buttons a.checkout-button {background: "+newval+";}\
				.filter-tabs li.selected a, #main-wrapper .single_add_to_cart_button:hover {\
					background: "+newval+" !important;\
				}\
				table.focus-header th,\
				.second-skin #main-nav > li a:hover,\
				.second-skin #main-nav > li.current-menu-item > a,\
				.second-skin #main-nav > li.sfHover > a,\
				#header-inner.stuck .second-skin #main-nav > li > a:hover,\
				.second-skin #main-nav > li.current-menu-item > a,\
				.crsl-nav a:hover,\
				.feature-box:hover i.ic-holder-1 {\
					background: "+newval+";\
					color: #FFF;\
				}\
				.load-more-posts:hover,\
				.dropcap.fancy,\
				.tagcloud > a:hover,\
				.hb-icon.hb-icon-medium.hb-icon-container:hover {\
					background-color: "+newval+";\
					color: #FFF;\
				}\
				.filter-tabs li.selected a {\
					border-color: "+newval+" !important;\
				}\
				.hb-second-light:hover {background:#FFF!important;color:"+newval+"!important;}\
				.hb-effect-11 #main-nav > li > a:hover::before,\
				.hb-effect-11 #main-nav > li.sfHover > a::before,\
				.hb-effect-11 #main-nav > li.current-menu-item > a::before,\
				.hb-effect-11 #main-nav > li.current-menu-ancestor > a::before  {\
					color: "+newval+";\
					text-shadow: 7px 0 "+newval+", -7px 0 "+newval+";\
				}\
				#main-wrapper .product-loading-icon {\
					background: "+newval+";\
				}\
				.item-overlay-text {\
					background: #323436;\
					background: rgba(0,0,0,0.85);\
				}\
				.hb-button, input[type=submit]{\
					box-shadow: 0 3px 0 0 "+newval+";\
				}\
				.hb-button.special-icon i,\
				.hb-button.special-icon i::after {\
					background:"+newval+";\
				}\
				#main-wrapper a.active-language, #main-wrapper a.active-language:hover {color: #aaa !important; }\
				.feature-box:hover:not(.standard-icon-box):not(.alternative) i, #main-wrapper .hb-bag-buttons a:hover, #main-wrapper .hb-dropdown-box .hb-bag-buttons a:hover,\
				#main-wrapper .social-icons.dark li a:hover i, #main-wrapper #footer .social-icons.dark li a i,\
				#footer.dark-style ul.social-icons.light li a:hover,\
				#main-wrapper .hb-single-next-prev a:hover {color: #FFF !important;}\
			</style>" ).appendTo( "head" );
		});
	});


	/* TOP BAR SECTION
    ================================================== */
	wp.customize('hb_top_bar_bg_setting',function( value ) {
		value.bind(function(to) {
			$('#header-bar').css('background-color', to ? to : '' );
		});
	});

	wp.customize('hb_top_bar_text_color_setting',function( value ) {
		value.bind(function(to) {
			$('#header-bar, #fancy-search input[type=text]').css('color', to ? to : '' );
			jQuery("#hb-toremove-6").remove();
			jQuery("<style id='hb-toremove-6'>\
			#main-wrapper .hb-main-content a, #fancy-search ::-webkit-input-placeholder { color: "+to+"; }\
			</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_top_bar_link_color_setting',function( value ) {
		value.bind(function(to) {
			$('#header-bar a').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_top_bar_border_setting',function( value ) {
		value.bind(function(to) {
			$('#header-bar').css('border-bottom-color', to ? to : '' );
			$('#header-bar .top-widget').css('border-right-color', to ? to : '' );
			$('#header-bar .top-widget').css('border-left-color', to ? to : '' );
		});
	});


	/* NAVIGATION BAR SECTION
    ================================================== */
	wp.customize('hb_nav_bar_bg_setting',function( value ) {
		value.bind(function(newval) {
			$('#header-inner-bg').css('background-color', newval ? newval : '' );
		});
	});

	wp.customize('hb_nav_bar_stuck_bg_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("#hb-toremove-2").remove();
			jQuery("<style id='hb-toremove-2'>\
				#header-inner.stuck #header-inner-bg { background-color:"+newval+" !important; }\
				</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_nav_bar_border_setting',function( value ) {
		value.bind(function(newval) {
			$('#header-inner-bg').css('border-bottom-color', newval ? newval : '' );
			jQuery("#hb-toremove-3").remove();
			jQuery("<style id='hb-toremove-3'>\
				#main-nav li#nav-search::before {background: "+newval+"}\
				#header-inner.nav-type-2 .main-navigation {border-top-color: "+newval+"}\
				#header-inner.nav-type-2 #main-nav > li > a { border-right-color: "+newval+" }\
				#header-inner.nav-type-2 #main-nav > li:first-child > a, #header-inner.nav-type-2 li#nav-search > a { border-left-color: "+newval+" }\
				</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_nav_bar_stuck_border_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("<style id='hb-toremove-2'>\
				#header-inner.stuck #header-inner-bg { border-bottom-color:"+newval+" !important; }\
				#main-nav li#nav-search::before {background: "+newval+"}\
				</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_nav_bar_text_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("#hb-toremove-4").remove();
			jQuery("<style id='hb-toremove-4'>\
				#main-wrapper #main-nav > li > a, #main-wrapper #header-inner-bg { color:"+newval+" !important; }\
				</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_nav_bar_stuck_text_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("#hb-toremove-112").remove();
			jQuery("<style id='hb-toremove-112'>\
				#main-wrapper #header-inner.stuck #main-nav > li > a, #main-wrapper #header-inner.stuck #header-inner-bg { color:"+newval+" !important; }\
				</style>" ).appendTo( "head" );
		});
	});


	/* CALLOUT SECTION
    ================================================== */
	wp.customize('hb_pfooter_bg_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#pre-footer-area').css('background-color', newval ? newval : '' );
		});
	});

	wp.customize('hb_pfooter_text_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#pre-footer-area').css('color', newval ? newval : '' );
		});
	});



	/* FOOTER SECTION
    ================================================== */
	wp.customize('hb_footer_bg_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#footer').css('background-color', newval ? newval : '' );
		});
	});

	wp.customize('hb_footer_text_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#footer').css('color', newval ? newval : '' );
		});
	});

	wp.customize('hb_footer_link_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#footer a').css('color', newval ? newval : '' );
		});
	});


	wp.customize('hb_copyright_bg_setting',function( value ) {
		value.bind(function(to) {
			$('#copyright-wrapper').css('background', to ? to : '' );
		});
	});

	wp.customize('hb_copyright_text_setting',function( value ) {
		value.bind(function(to) {
			$('#copyright-wrapper').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_copyright_link_setting',function( value ) {
		value.bind(function(to) {
			$('#copyright-wrapper a').css('color', to ? to : '' );
		});
	});


	/* CONTENT SECTION
    ================================================== */
    wp.customize('hb_content_bg_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('body').css('background-color', newval ? newval : '' );
		});
	});

	wp.customize('hb_content_c_bg_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#main-wrapper').css('background-color', newval ? newval : '' );
		});
	});

	wp.customize('hb_content_text_color_setting',function( value ) {
		value.bind(function(newval) {
			jQuery('#main-wrapper .hb-main-content, #main-wrapper .hb-sidebar').css('color', newval ? newval : '' );
		});
	});

	wp.customize('hb_content_link_color_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("#hb-toremove-5").remove();
			jQuery("<style id='hb-toremove-5'>\
				#main-wrapper .hb-main-content a { color:"+newval+"; }\
				</style>" ).appendTo( "head" );
		});
	});

	wp.customize('hb_content_border_setting',function( value ) {
		value.bind(function(newval) {
			jQuery("#hb-toremove-7").remove();
			jQuery("<style id='hb-toremove-7'>\
				.portfolio-single-meta ul, .content-box, #main-wrapper .hb-accordion-pane, .hb-accordion-tab, .hb-box-cont, .hb-tabs-wrapper.tour-style .tab-content, .hb-tabs-wrapper .nav-tabs li a, .hb-callout-box, .hb-teaser-column .teaser-content. .hb-pricing-item, .hb-testimonial:after, .hb-testimonial, .tmb-2 .team-member-description, .recent-comments-content, .recent-comments-content:after, .hb-tweet-list.light li, .hb-tweet-list.light li:after, fieldset,table,.wp-caption-text, .gallery-caption, .author-box, .comments-list .children > li::before, .widget_nav_menu ul.menu, .comments-list li.comment > div.comment-body, .hb-dropdown-box, #contact-panel, .filter-tabs li a, #contact-panel::after, .hb-flexslider-wrapper.bordered-wrapper,.bordered-wrapper, iframe.fw {border-color:"+newval+";}\
				#main-content .left-sidebar .hb-main-content.col-9, table th, table th, table td, #main-content .hb-sidebar, .comments-list .children, .tmb-2 .team-member-img, .hb-tabs-wrapper .tab-content, div.pp_default .pp_close {border-left-color:"+newval+";}\
				table td, .hb-blog-small .meta-info, #main-wrapper .widget_nav_menu ul.menu ul li:first-child, #main-wrapper .bottom-meta-section, .comments-list .children > li::after, .tmb-2 .team-member-img, h5.hb-heading span:not(.special-amp):before, h4.hb-heading span:not(.special-amp):before,h4.hb-heading span:not(.special-amp):after,h5.hb-heading span:not(.special-amp):after,h3.hb-heading span:not(.special-amp):before,h3.hb-heading span:not(.special-amp):after,h4.lined-heading span:not(.special-amp):before,h4.lined-heading span:not(.special-amp):after, .hb-fw-separator, .hb-separator-s-1, .hb-separator-extra, .hb-separator-25, .hb-gal-standard-description .hb-small-separator {border-top-color:"+newval+";}\
				.pricing-table-caption, .pricing-table-price, #hb-page-title, .share-holder .hb-dropdown-box ul li, .hb-blog-small .meta-info, .hb_latest_posts_widget article, .most-liked-list li, ul.hb-ul-list.line-list li, ol.line-list li, ul.line-list li, #hb-blog-posts.unboxed-blog-layout article, .hb-tabs-wrapper .nav-tabs, #main-wrapper .wpb_content_element .wpb_tour_tabs_wrapper .wpb_tabs_nav a, .hb-tabs-wrapper .tab-content, .hb-tabs-wrapper.tour-style .nav-tabs li.active a, .hb-box-cont-header, .hb-separator.double-border, .portfolio-single-meta ul.meta-list li {border-bottom-color:"+newval+";}\
				#main-content .col-9.hb-main-content, #main-content .left-sidebar .hb-sidebar.col-3, .tmb-2 .team-member-img, .hb-tabs-wrapper .tab-content, .hb-tabs-wrapper.tour-style.right-tabs .nav-tabs > li.active a, div.pp_default .pp_nav {border-right-color:"+newval+";}\
				.pagination ul li a, .pagination ul li span.page-numbers.dots, .single .pagination a, .page-links a, .hb-skill-meter .hb-progress-bar, .hb-counter .count-separator span, .hb-small-break, hr {background-color: "+newval+";}\
				#main-wrapper .hb-tabs-wrapper:not(.wpb_tabs) ul li:last-child a, .darker-border .hb-separator {border-bottom-color: "+newval+" !important;}\
				.darker-border .hb-separator {border-top-color: "+newval+" !important;}\
				</style>" ).appendTo( "head" );
		});
	});

	
	wp.customize('hb_content_h1_setting',function( value ) {
		value.bind(function(to) {
			$('h1, h1.extra-large, h1 a, article.single h1.title').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_content_h2_setting',function( value ) {
		value.bind(function(to) {
			$('h2, #hb-page-title h2').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_content_h3_setting',function( value ) {
		value.bind(function(to) {
			$('h3, #respond h3, h3.title-class, .hb-callout-box h3, .hb-gal-standard-description h3').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_content_h4_setting',function( value ) {
		value.bind(function(to) {
			$('h4, .widget-item h4, .content-box h4').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_content_h5_setting',function( value ) {
		value.bind(function(to) {
			$('h5, #comments h5, #respond h5, .testimonial-author h5').css('color', to ? to : '' );
		});
	});

	wp.customize('hb_content_h6_setting',function( value ) {
		value.bind(function(to) {
			$('h6, h6.special, .blog-shortcode-1 h6').css('color', to ? to : '' );
		});
	});

	
} )( jQuery );