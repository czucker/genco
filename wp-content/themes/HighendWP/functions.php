<?php
/**
 * @package WordPress
 * @subpackage Highend
 */


    /* DEREGISTER WOOCOMMERCE IMPORTS
    ================================================== */
    add_action( 'wp_enqueue_scripts', 'hb_manage_woocommerce_styles', 99 );
    function hb_manage_woocommerce_styles() {
        if ( !class_exists('Woocommerce') ) return;
        //remove generator meta tag
        remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
     
        //first check that woo exists to prevent fatal errors
        if ( function_exists( 'is_woocommerce' ) ) {
            //dequeue scripts and styles
            if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
                add_filter( 'woocommerce_enqueue_styles', '__return_false' );
                wp_dequeue_style( 'woocommerce_frontend_styles' );
                wp_dequeue_style( 'woocommerce-layout-css' );
                wp_dequeue_style( 'woocommerce_fancybox_styles' );
                wp_dequeue_style( 'woocommerce_chosen_styles' );
                wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
                wp_dequeue_script( 'wc_price_slider' );
                wp_dequeue_script( 'wc-single-product' );
                wp_dequeue_script( 'wc-add-to-cart' );
                wp_dequeue_script( 'wc-cart-fragments' );
                wp_dequeue_script( 'wc-checkout' );
                wp_dequeue_script( 'wc-add-to-cart-variation' );
                wp_dequeue_script( 'wc-single-product' );
                wp_dequeue_script( 'wc-cart' );
                wp_dequeue_script( 'wc-chosen' );
                wp_dequeue_script( 'woocommerce' );
                wp_dequeue_script( 'prettyPhoto' );
                wp_dequeue_script( 'prettyPhoto-init' );
                wp_dequeue_script( 'jquery-blockui' );
                wp_dequeue_script( 'jquery-placeholder' );
                wp_dequeue_script( 'fancybox' );
                wp_dequeue_script( 'jqueryui' );
            }
        }
     
    }


    /* DEFINE
    ================================================== */
    define ( 'HBTHEMES_ROOT' , get_template_directory() );
    define ( 'HBTHEMES_INCLUDES' , get_template_directory() . '/includes' );
    define ( 'HBTHEMES_ADMIN' , get_template_directory() . '/admin' );
    define ( 'HBTHEMES_FUNCTIONS' , get_template_directory() . '/functions' );

    define('SHORTNAME', 'hb');
    define('THEMENAME', 'Highend');
    define('ADMIN_URL', get_admin_url());

    $theme_focus_color = "#00aeef";
    $shortname = SHORTNAME;
    $themename = THEMENAME;
    $themepath = get_template_directory_uri();


    /* THEME SETUP
    ================================================== */
    function hb_theme_setup() {
        global $shortname;
        global $themename;
        global $themepath;
        global $themeoptions;
        require_once(HBTHEMES_FUNCTIONS . '/theme-styles.php');
        require_once(HBTHEMES_FUNCTIONS . '/theme-scripts.php');

        if (defined('WP_ADMIN') && WP_ADMIN) {
            require_once('includes/tinymce/shortcode-popup.php');
            include get_template_directory() . '/includes/plugins/importer/importer.php';
        }

    }
    add_action('after_setup_theme', 'hb_theme_setup');


    /* CUSTOM ADMIN STYLES
    ================================================== */
    function my_admin_theme_style() {
        global $shortname;
        global $themename;
        global $themepath;
        wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/admin/assets/css/custom-admin.css');
    }
    add_action('admin_enqueue_scripts', 'my_admin_theme_style');


    /* ADMIN HB DASHBOARD WIDGET
    ================================================== */
    if (!function_exists('hb_dashboard_widget')){
        function hb_dashboard_widget() {
            $my_theme          = wp_get_theme();
            $menus_url         = ADMIN_URL . 'nav-menus.php';
            $front_page_url    = ADMIN_URL . 'options-reading.php';
            $theme_options_url = ADMIN_URL . 'themes.php?page=highend_options#_hb_general_settings'; 
            $widgets_url       = ADMIN_URL . 'widgets.php';

            // Fetch RSS news
            $hb_rss = new DOMDocument();
            $hb_rss->load('http://hb-themes.com/home/feed/');
            $limit = 1;
            $hb_feed = array();

            foreach ($hb_rss->getElementsByTagName('item') as $node) {
                $item = array ( 
                    'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                    'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                    'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                    'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                );
                array_push($hb_feed, $item);
            }

            echo '
                <div class="main clearfix" id="highend_widget_box">
                <p class="nbm">' . __('You are using', 'hbthemes') .' <strong>'. $my_theme->get( 'Name' ) . '</strong> ' . __('theme. Version','hbthemes') . ' ' . ' <strong>' . $my_theme->get('Version') . '.</strong>
                </p>

                <hr/>

                <p>' . __('First Steps', 'hbthemes') . '</p>
                <ul id="highend_links">
                    <li><a href="' . $theme_options_url . '">' . __('Highend Options', 'hbthemes' ) . '</a></li>
                    <li><a href="' . $front_page_url . '">'. __('Choose your front page', 'hbthemes') .'</a></li>
                    <li><a href="' . $menus_url . '">'. __('Manage menus', 'hbthemes') . '</a></li>
                    <li><a href="' . $widgets_url . '">' . __('Manage widgets', 'hbthemes') . '</a></li>
                </ul>

                <hr/>

                <p>Need help?</p>
                <ul id="highend_widget">
                    <li id="highend_docs"><a href="http://documentation.hb-themes.com/highend/index.html" target="_blank">' . __('Read the documentation', 'hbthemes') . '</a></li>
                    <li id="highend_videos"><a href="http://documentation.hb-themes.com/highend/index.html#video-tutorials" target="_blank">' . __('Watch video tutorials', 'hbthemes') . '</a></li>
                    <li id="highend_forum"><a href="http://forum.hb-themes.com" target="_blank">' . __('Visit support forum', 'hbthemes') . '</a></li>
                    <li id="highend_facebook"><a href="http://facebook.com/hbthemes" target="_blank">' . __('Find us on Facebook', 'hbthemes') . '</a></li>
                    <li id="highend_twitter"><a href="http://twitter.com/hbthemes" target="_blank">' . __('Follow us on Twitter', 'hbthemes') . '</a></li>
                    <li id="highend_customization"><a href="http://hb-themes.com/home/hire-us" target="_blank">' . __('Request a customization', 'hbthemes') . '</a></li>
                </ul>';

                if ( !empty($hb_feed) ){
                    echo '
                    <div class="hb-latest-news-section rss-widget">
                        <hr/>
                        <p>' . __('HB-Themes News', 'hbthemes') . '</p>';

                        for($x=0;$x<$limit;$x++) {
                            $title = str_replace(' & ', ' &amp; ', $hb_feed[$x]['title']);
                            $link = $hb_feed[$x]['link'];
                            $description = $hb_feed[$x]['desc'];
                            //$date = date('F d, Y', strtotime($hb_feed[$x]['date']));
                            echo '<a class="rsswidget" href="'.$link.'" title="'.$title.'" target="_blank">'.$title.'</a><br/>';
                            //echo '<small class="rss-date">'.$date.'</small>';
                            echo '<p class="rssSummary">'.$description.'</p>';
                        }

                    echo '</div>';
                }

                echo '<div class="clear"></div></div>';
        }


        function hb_add_dashboard_widgets() {
            wp_add_dashboard_widget(
                'elevate_dashboard_widget',
                'Highend',
                'hb_dashboard_widget'
            );  
        }


        if ( current_user_can( 'manage_options' ) ){
            add_action('wp_dashboard_setup', 'hb_add_dashboard_widgets');
        }
    }


    remove_filter('nav_menu_description', 'strip_tags');
    
    /* INCLUDES
    ================================================== */
    include(HBTHEMES_ADMIN . '/theme-custom-post-types.php');
    include(HBTHEMES_ADMIN . '/theme-custom-taxonomies.php');
    include(HBTHEMES_ADMIN . '/custom-walker/sweet-custom-menu.php');
    include(HBTHEMES_ADMIN . '/theme-customizer.php');

    require_once(HBTHEMES_INCLUDES . '/shortcodes.php');
    require_once(HBTHEMES_INCLUDES . '/scheme.php');
    require_once(HBTHEMES_ROOT . '/options-framework/bootstrap.php');
    require_once(HBTHEMES_ADMIN . '/theme-options-dependency.php');
    require_once(HBTHEMES_ADMIN . '/plugins/multiple-sidebars.php');
    require_once(HBTHEMES_ADMIN . '/metaboxes/metabox-dependency.php');
    require_once(HBTHEMES_ADMIN . '/metaboxes/meta-box-master/meta-box.php');
    require_once(HBTHEMES_ADMIN . '/metaboxes/gallery-multiupload.php');
    require_once(HBTHEMES_ADMIN . '/author-meta.php');
    require_once(HBTHEMES_FUNCTIONS . '/breadcrumbs.php');
    require_once(HBTHEMES_FUNCTIONS . '/testimonial-box.php');
    require_once(HBTHEMES_FUNCTIONS . '/testimonial-quote.php');
    require_once(HBTHEMES_FUNCTIONS . '/team-member-box.php');
    require_once(HBTHEMES_FUNCTIONS . '/image_dimensions.php');
    require_once(HBTHEMES_FUNCTIONS . '/theme-likes.php');
    require_once(HBTHEMES_FUNCTIONS . '/theme-thumbnails-resize.php');
    require_once(HBTHEMES_FUNCTIONS . '/pagination-standard.php');
    require_once(HBTHEMES_FUNCTIONS . '/pagination-ajax.php');
    require_once(HBTHEMES_INCLUDES . '/class-tgm-plugin-activation.php');
    
    


    /* WOOCOMMERCE STUFF
    ================================================== */
    if ( !is_multisite() ) {
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            require_once(HBTHEMES_INCLUDES . '/hb-woocommerce.php');
        }
    } else {
        require_once(HBTHEMES_INCLUDES . '/hb-woocommerce.php');
    }


    /* AUTOMATIC THEME UPDATES
    ================================================== */
    require_once('wp-updates-theme.php');
    new WPUpdatesThemeUpdater_500( 'http://wp-updates.com/api/2/theme', basename(get_template_directory()));


    /* TGMPA
    ================================================== */
    add_action('tgmpa_register', 'my_theme_register_required_plugins');
    function my_theme_register_required_plugins() {
        $plugins           = array(
            array(
                'name' => 'LayerSlider WP',
                'slug' => 'LayerSlider',
                'source' => 'http://hb-themes.com/repository/plugins/layerslider.zip',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false
            ),
            array(
                'name' => 'Revolution Slider',
                'slug' => 'revslider',
                'source' => 'http://hb-themes.com/repository/plugins/revslider.zip',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false
            ),
            array(
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
                'required' => false,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url'       => 'http://downloads.wordpress.org/plugin/contact-form-7.3.8.1.zip'
            ),
            array(
                'name' => 'Visual Composer - Live Drag & Drop Page Builder',
                'slug' => 'js_composer',
                'source' => 'http://hb-themes.com/repository/plugins/js_composer.zip',
                'required' => true,
                'force_activation' => false,
                'force_deactivation' => false
            )
        );
        // Change this to your theme text domain, used for internationalising strings
        $theme_text_domain = 'hbthemes';
        $config            = array(
            'domain' => $theme_text_domain, // Text domain - likely want to be the same as your theme.
            'default_path' => '', // Default absolute path to pre-packaged plugins
            'parent_menu_slug' => 'themes.php', // Default parent menu slug
            'parent_url_slug' => 'themes.php', // Default parent URL slug
            'menu' => 'install-required-plugins', // Menu slug
            'has_notices' => true, // Show admin notices or not
            'is_automatic' => false, // Automatically activate plugins after installation or not
            'message' => '', // Message to output right before the plugins table
            'strings' => array(
                'page_title' => __('Install Required Plugins', $theme_text_domain),
                'menu_title' => __('Install Plugins', $theme_text_domain),
                'installing' => __('Installing Plugin: %s', $theme_text_domain), // %1$s = plugin name
                'oops' => __('Something went wrong with the plugin API.', $theme_text_domain),
                'notice_can_install_required' => _n_noop('Highend theme requires the following plugin: %1$s.<br/>Please install this plugin.', 'Highend theme requires the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_can_install_recommended' => _n_noop('Highend theme recommends the following plugin: %1$s.', 'Highend theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s)
                'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s)
                'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s)
                'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s)
                'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
                'activate_link' => _n_noop('Activate installed plugin', 'Activate installed plugins'),
                'return' => __('Return to Required Plugins Installer', $theme_text_domain),
                'plugin_activated' => __('Plugin activated successfully.', $theme_text_domain),
                'complete' => __('All plugins installed and activated successfully. %s', $theme_text_domain), // %1$s = dashboard link
                'nag_type' => 'updated'
                // Determines admin notice type - can only be 'updated' or 'error'
            )
        );
        tgmpa($plugins, $config);
    }


    /* LAYER AND REVOLUTION SLIDER
    ================================================== */
    add_action('layerslider_ready', 'my_layerslider_overrides');
    function my_layerslider_overrides() {
        $GLOBALS['lsAutoUpdateBox'] = false;
    }
    function get_all_layer_sliders() {
        if (!is_layer_slider_activated())
            return;
        $sliders = array();
        if (function_exists('lsSliders')) {
            $all_sliders = lsSliders(1000000, true, true);
            if (!empty($all_sliders)) {
                foreach ($all_sliders as $slider) {
                    $sliders[$slider['id']] = $slider['name'];
                }
            }
        }
        return $sliders;
    }
    function is_layer_slider_activated() {
        $layerslider = ABSPATH . 'wp-content/plugins/LayerSlider/layerslider.php';
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (!is_plugin_active('LayerSlider/layerslider.php'))
            return false;
        return true;
    }
    function is_layer_slider_installed() {
        $layerslider = ABSPATH . 'wp-content/plugins/LayerSlider/layerslider.php';
        if (!file_exists($layerslider))
            return false;
        return true;
    }
    function get_all_revolution_sliders() {
        $revolutionslider     = array();
        $revolutionslider[''] = 'No Slider';
        if (class_exists('RevSlider')) {
            $slider     = new RevSlider();
            $arrSliders = $slider->getArrSliders();
            foreach ($arrSliders as $revSlider) {
                $revolutionslider[$revSlider->getAlias()] = $revSlider->getTitle();
            }
        }
        return $revolutionslider;
    }
    // Change VC Class Names
    function custom_vc_class($class_string, $tag) {
        if ($tag == 'vc_row' || $tag == 'vc_row_inner' || $tag == 'wpb_row') {
            $class_string = str_replace('vc_row-fluid', 'row', $class_string);
            $class_string = str_replace('wpb_row ', 'element-row ', $class_string);
        }
        if ($tag == 'vc_column' || $tag == 'vc_column_inner') {
            $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-$1', $class_string);
        }
        return $class_string;
    }


    /* DISABLE PLUGIN SETTINGS
    ================================================== */
    if ( function_exists('vc_set_as_theme') ){
        vc_set_as_theme(true);
    }

    if ( function_exists('set_revslider_as_theme') ){
        set_revslider_as_theme();
    }


    /* DE-REGISTER VISUAL COMPOSER SHORTCODES
    ================================================== */
    if (function_exists('vc_remove_element')) {
        //vc_remove_element("vc_accordion");
        //vc_remove_element("vc_accordion_tab");
        //vc_remove_element("vc_carousel");
        vc_remove_element("vc_cta_button");
        vc_remove_element("vc_cta_button2");
        vc_remove_element("vc_separator");
        //vc_remove_element("vc_flickr");
        vc_remove_element("vc_pie");
        vc_remove_element("vc_item");
        vc_remove_element("vc_items");
        vc_remove_element("vc_posts_grid");
        vc_remove_element("vc_posts_slider");
        vc_remove_element("vc_progress_bar");
        vc_remove_element("vc_gallery");
        vc_remove_element("vc_images_carousel");
        //vc_remove_element("vc_button");
        vc_remove_element("vc_message");
        vc_remove_element("vc_button2");
        //vc_remove_element("vc_tab");
        //vc_remove_element("vc_tabs");
        //vc_remove_element("vc_toggle");
        //vc_remove_element("vc_video");
        // vc_remove_element("vc_text_separator");
        vc_remove_element("vc_wp_categories");
        vc_remove_element("vc_wp_custommenu");
        vc_remove_element("vc_wp_links");
        vc_remove_element("vc_wp_meta");
        vc_remove_element("vc_wp_pages");
        vc_remove_element("vc_wp_posts");
        vc_remove_element("vc_wp_recentcomments");
        vc_remove_element("vc_wp_rss");
        vc_remove_element("vc_wp_search");
        vc_remove_element("vc_wp_tagcloud");
        vc_remove_element("vc_wp_text");
        vc_remove_element("vc_wp_calendar");
        vc_remove_element("vc_wp_archives");
        //vc_remove_element("vc_widget_sidebar");
        //vc_remove_element("vc_teaser_grid");
        //vc_remove_element("vc_single_image");
        //vc_remove_element("vc_tour");
        vc_remove_element("vc_gmaps");
        // vc_remove_element("vc_raw_html");
        // vc_remove_element("layerslider_vc");
        // vc_remove_element("rev_slider_vc");
        // vc_remove_element("vc_raw_js");
        // vc_remove_element("vc_facebook");
        // vc_remove_element("vc_tweetmeme");
        // vc_remove_element("vc_googleplus");
        // vc_remove_element("vc_pinterest");
        add_filter('vc_shortcodes_css_class', 'custom_vc_class', 10, 2);
    }


    /* REGISTER MENUS
    ================================================== */
    function hb_register_menu() {
        register_nav_menu('main-menu', __('Main Menu', 'hbthemes'));
        register_nav_menu('footer-menu', __('Footer Menu', 'hbthemes'));
        register_nav_menu('mobile-menu', __('Mobile Menu', 'hbthemes'));
        register_nav_menu('one-page-menu', __('One Page Menu', 'hbthemes'));
    }
    add_action('init', 'hb_register_menu');


    /* THEME SUPPORT
    ================================================== */
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array(
        'gallery',
        'image',
        'quote',
        'video',
        'audio',
        'link'
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('woocommerce');
    add_filter('widget_text', 'do_shortcode');
    add_filter('widget_text', 'shortcode_unautop');


    /* LANGUAGE SETUP
    ================================================== */
    add_action('after_setup_theme', 'hb_language_setup');
    function hb_language_setup() {
        load_theme_textdomain('hbthemes', HBTHEMES_ROOT . '/languages');
    }


    /* SET CONTENT WIDTH
    ================================================== */
    if (!isset($content_width)) {
        if (hb_options('hb_content_width') == '940px') {
            $content_width = 940;
        } else {
            $content_width = 1140;
        }
    }


    /* THEME OPTIONS
    ================================================== */
    function hb_init_options() {
        global $themeoptions;
        // Built path to options template array file
        $tmpl_opt      = HBTHEMES_ADMIN . '/theme-options.php';
        // Initialize the Option's object
        $themeoptions = new VP_Option(array(
            'is_dev_mode' => false,
            'option_key' => 'hb_highend_option',
            'page_slug' => 'highend_options',
            'template' => $tmpl_opt,
            'menu_page' => 'themes.php',
            'use_auto_group_naming' => true,
            'use_exim_menu' => true,
            'minimum_role' => 'edit_theme_options',
            'layout' => 'fixed',
            'page_title' => __('Highend Options', 'hbthemes'),
            'menu_label' => __('Highend Options', 'hbthemes')
        ));
    }
    add_action('after_setup_theme', 'hb_init_options');


    /* METABOXES
    ================================================== */
    function hb_init_metaboxes() {
        $mb_path_pricing_settings                          = HBTHEMES_ADMIN . '/metaboxes/meta-pricing-table-settings.php';
        $mb_path_featured_section_settings                 = HBTHEMES_ADMIN . '/metaboxes/meta-featured-page-section.php';
        $mb_path_testimonials_settings                     = HBTHEMES_ADMIN . '/metaboxes/meta-testimonials.php';
        $mb_path_contact_page_template_settings            = HBTHEMES_ADMIN . '/metaboxes/meta-contact-page-settings.php';
        $mb_path_post_format_settings                      = HBTHEMES_ADMIN . '/metaboxes/meta-post-format-settings.php';
        $mb_path_blog_page_template_settings               = HBTHEMES_ADMIN . '/metaboxes/meta-blog-page-settings.php';
        $mb_path_grid_blog_page_template_settings          = HBTHEMES_ADMIN . '/metaboxes/meta-blog-grid-page-settings.php';
        $mb_path_fw_blog_page_template_settings            = HBTHEMES_ADMIN . '/metaboxes/meta-blog-fw-page-settings.php';
        $mb_path_fw_gallery_page_template_settings         = HBTHEMES_ADMIN . '/metaboxes/meta-gallery-fw-page-settings.php';
        $mb_path_standard_portfolio_page_template_settings = HBTHEMES_ADMIN . '/metaboxes/meta-portfolio-standard-page-settings.php';
        $mb_path_standard_gallery_page_template_settings   = HBTHEMES_ADMIN . '/metaboxes/meta-gallery-standard-page-settings.php';
        $mb_path_general_settings                          = HBTHEMES_ADMIN . '/metaboxes/meta-general-settings.php';
        $mb_path_layout_settings                           = HBTHEMES_ADMIN . '/metaboxes/meta-layout-settings.php';
        $mb_path_background_settings                       = HBTHEMES_ADMIN . '/metaboxes/meta-background-settings.php';
        $mb_path_misc_settings                             = HBTHEMES_ADMIN . '/metaboxes/meta-misc-settings.php';
        $mb_path_portfolio_layout_settings                 = HBTHEMES_ADMIN . '/metaboxes/meta-portfolio-layout-settings.php';
        $mb_path_team_layout_settings                      = HBTHEMES_ADMIN . '/metaboxes/meta-team-layout-settings.php';
        $mb_path_portfolio_settings                        = HBTHEMES_ADMIN . '/metaboxes/meta-portfolio-settings.php';
        $mb_path_team_member_settings                      = HBTHEMES_ADMIN . '/metaboxes/meta-team-member-settings.php';
        $mb_path_clients_settings                          = HBTHEMES_ADMIN . '/metaboxes/meta-clients-settings.php';
        

       

        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'testimonial_type_settings',
            'types' => array(
                'hb_testimonials'
            ),
            'title' => __('Testimonial Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_testimonials_settings
        ));

        
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'clients_settings',
            'types' => array(
                'clients'
            ),
            'title' => __('Clients Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_clients_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'team_member_settings',
            'types' => array(
                'team'
            ),
            'title' => __('Team Member Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_team_member_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'portfolio_layout_settings',
            'types' => array(
                'portfolio'
            ),
            'title' => __('Portfolio Layout Settings', 'hbthemes'),
            'priority' => 'low',
            'is_dev_mode' => false,
            'context' => 'side',
            'template' => $mb_path_portfolio_layout_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'team_layout_settings',
            'types' => array(
                'team'
            ),
            'title' => __('Team Layout Settings', 'hbthemes'),
            'priority' => 'low',
            'is_dev_mode' => false,
            'context' => 'side',
            'template' => $mb_path_team_layout_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'layout_settings',
            'types' => array(
                'post',
                'page'
            ),
            'title' => __('Layout Settings', 'hbthemes'),
            'priority' => 'low',
            'is_dev_mode' => false,
            'context' => 'side',
            'template' => $mb_path_layout_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'pricing_settings',
            'types' => array(
                'hb_pricing_table'
            ),
            'title' => __('Pricing Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_pricing_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'gallery_fw_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Fullwidth Gallery Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_fw_gallery_page_template_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'post_format_settings',
            'types' => array(
                'post'
            ),
            'title' => __('Post Format Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_post_format_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'portfolio_standard_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Portfolio Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_standard_portfolio_page_template_settings
        ));

        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'gallery_standard_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Standard Gallery Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_standard_gallery_page_template_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'contact_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Contact Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_contact_page_template_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'blog_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Classic Blog Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_blog_page_template_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'blog_grid_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Grid Blog Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_grid_blog_page_template_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'blog_fw_page_settings',
            'types' => array(
                'page'
            ),
            'title' => __('Fullwidth Blog Template Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_fw_blog_page_template_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'portfolio_settings',
            'types' => array(
                'portfolio'
            ),
            'title' => __('Portfolio Page Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_portfolio_settings
        ));
        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'testimonial_settings',
            'types' => array(
                'testimonial'
            ),
            'title' => __('Testimonial Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_testimonials_settings
        ));


        $mb_post_settings                                  = new VP_Metabox(array(
            'id' => 'featured_section',
            'types' => array(
                'page',
                'team'
            ),
            'title' => __('Featured Section Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_featured_section_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'general_settings',
            'types' => array(
                'post',
                'page',
                'team',
                'portfolio',
                'faq'
            ),
            'title' => __('General Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_general_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'background_settings',
            'types' => array(
                'post',
                'page',
                'team',
                'portfolio',
                'faq'
            ),
            'title' => __('Background Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_background_settings
        ));
        $mb_post_settings                                                = new VP_Metabox(array(
            'id' => 'misc_settings',
            'types' => array(
                'post',
                'page',
                'team',
                'portfolio',
                'faq'
            ),
            'title' => __('Misc Settings', 'hbthemes'),
            'priority' => 'high',
            'is_dev_mode' => false,
            'template' => $mb_path_misc_settings
        ));
    }
    add_action('after_setup_theme', 'hb_init_metaboxes');


    /* RETRIEVE FROM THEME OPTIONS
    ================================================== */
    function hb_options($name) {
        if (function_exists('vp_option'))
            return vp_option("hb_highend_option." . $name);
        return;
    }


    /* CUSTOM WORDPRESS LOGIN LOGO
    ================================================== */
    add_action('login_head', 'hb_custom_login_logo');
    function hb_custom_login_logo() {
        if (hb_options('hb_wordpress_logo')) {
            echo '<style type="text/css">
                h1 a { background-image:url(' . hb_options('hb_wordpress_logo') . ') !important; background-size:contain !important; width:274px !important; height: 63px !important; }
            </style>';
        }
    }

    add_filter( 'login_headerurl', 'hb_custom_login_logo_url' );
    function hb_custom_login_logo_url($url) {
        return get_site_url();
    }



    /* REGISTER DEFAULT SIDEBAR
    ================================================== */
    register_sidebar( array(
        'name'         => __( 'Default Sidebar', 'hbthemes' ),
        'id'           => 'hb-default-sidebar',
        'description'  => __( 'This is a default sidebar for widgets. You can create unlimited sidebars in Appearance > Sidebar Manager. You need to select this sidebar in page meta settings to display it.','hbthemes' ),
        'before_widget' => '<div id="%1$s" class="widget-item %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));


    /* GET SIDEBARS
    ================================================== */
    function hb_get_sidebars() {
        return get_option('sbg_sidebars');
    }


    /* FOOTER WIDGET AREAS
    ================================================== */
    if (function_exists('register_sidebar')) {
        // default sidebar array
        $sidebar_attr = array(
            'name' => '',
            'description' => __('This is an area for widgets. Drag and drop your widgets here.', 'hbthemes'),
            'before_widget' => '<div id="%1$s" class="widget-item %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
        );
        $sidebar_id   = 0;
        $hb_sidebar   = array(
            "Footer 1",
            "Footer 2",
            "Footer 3",
            "Footer 4"
        );
        foreach ($hb_sidebar as $sidebar_name) {
            $sidebar_attr['name'] = $sidebar_name;
            $sidebar_attr['id']   = 'custom-sidebar' . $sidebar_id++;
            register_sidebar($sidebar_attr);
        }
    }


    /*  THEME WIDGETS
    ================================================== */
    include(HBTHEMES_INCLUDES . '/widgets/widget-most-commented-posts.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-latest-posts.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-most-liked-posts.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-recent-comments.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-testimonials.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-video.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-instagram.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-pinterest.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-flickr.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-dribbble.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-google.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-facebook.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-contact-info.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-social-icons.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-gmap.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-twitter.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-portfolio.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-portfolio-random.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-most-liked-portfolio.php');
    include(HBTHEMES_INCLUDES . '/widgets/widget-ads-300x250.php');


    /* ADD THUMBNAILS
    ================================================== */
    if (function_exists('add_image_size')) {
        add_image_size('classic-blog-thumb', 900, 9999); //300 pixels wide (and unlimited height)
        add_image_size('gallery-slider-thumb', 900, 350);
        add_image_size( 'blog-grid-thumb', 100, 999999, true );
    }


    /* LOAD MORE
    ================================================== */
    function wp_infinitepaginate() {
        $loopFile       = $_POST['loop_file'];
        $paged          = $_POST['page_no'];
        $col_count = "";
        $posts_per_page = get_option('posts_per_page');
        if ( isset($_POST['col_count'] ))
            $col_count      = $_POST['col_count'];
        
        query_posts(array(
            'paged' => $paged,
        ));
        get_template_part($loopFile);
        exit;
    }
    add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');
    add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');


    /* CURRENT TEMPLATE
    ================================================== */
    function get_current_template($echo = false) {
        if (!isset($GLOBALS['current_theme_template']))
            return false;
        if ($echo)
            echo $GLOBALS['current_theme_template'];
        else
            return $GLOBALS['current_theme_template'];
    }


    /* MAINTENANCE MODE
    ================================================== */
    function maintenace_mode() {
        $hidden_param = "";

        if (isset($_GET['hb_maintenance'])){
            $hidden_param = $_GET['hb_maintenance'];
        }
        
        if ((!current_user_can('edit_themes') && hb_options('hb_enable_maintenance')) || (!is_user_logged_in() && hb_options('hb_enable_maintenance')) || ($hidden_param == 'yes') ) {
            get_template_part('hb-maintenance');
            die();
        }
    }
    add_action('get_header', 'maintenace_mode');
    

    /* REDIRECT TO THEME OPTIONS AFTER ACTIVATE THEME
    ================================================== */
    if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {
        header('Location: ' . admin_url() . 'themes.php?page=highend_options#_hb_general_settings');
    }


    /* CUSTOM WP ADMIN BAR LINKS
    ================================================== */
    if ( current_user_can( 'manage_options' ) ){
        add_action('admin_bar_menu', 'toolbar_link_to_mypage', 140);
    }
    function toolbar_link_to_mypage($wp_admin_bar) {
        $theme_options_url = admin_url() . 'themes.php?page=highend_options#_hb_general_settings';
        $args              = array(
            'id' => 'highend_theme_options_link',
            'title' => 'Highend Options',
            'href' => $theme_options_url,
            'meta' => array(
                'class' => 'highend_theme_options_link'
            )
        );
        $wp_admin_bar->add_node($args);
    }
   
    if ( current_user_can( 'manage_options' ) ){
        add_action('admin_bar_menu', 'hb_support_in_toolbar', 142);
    }
    function hb_support_in_toolbar($wp_admin_bar) {
        $support_url = 'http://support.hb-themes.com';
        $args        = array(
            'id' => 'highend_support_link',
            'title' => __('Support','hbthemes'),
            'href' => $support_url,
            'meta' => array(
                'class' => 'highend_support_link'
            )
        );
        $wp_admin_bar->add_node($args);
    }
    if ( current_user_can( 'manage_options' ) ){
        add_action('admin_bar_menu', 'hb_docs_in_toolbar', 140);
    }
    function hb_docs_in_toolbar($wp_admin_bar) {
        $docs_url = 'http://documentation.hb-themes.com/highend';
        $args     = array(
            'id' => 'highend_docs_link',
            'title' => __('Theme Documentation','hbthemes'),
            'href' => $docs_url,
            'parent' => 'highend_support_link',
            'meta' => array(
                'class' => 'highend_docs_link'
            )
        );
        $wp_admin_bar->add_node($args);
    }
    if ( current_user_can( 'manage_options' ) ){
        add_action('admin_bar_menu', 'hb_forum_in_toolbar', 141);
    }
    function hb_forum_in_toolbar($wp_admin_bar) {
        $forum_url = 'http://forum.hb-themes.com';
        $args      = array(
            'id' => 'highend_forum_link',
            'title' => __('Support Forum', 'hbthemes'),
            'href' => $forum_url,
            'parent' => 'highend_support_link',
            'meta' => array(
                'class' => 'highend_forum_link'
            )
        );
        $wp_admin_bar->add_node($args);
    }
    if ( current_user_can( 'manage_options' ) ){
        add_action('admin_bar_menu', 'hb_tuts_in_toolbar', 141);
    }
    function hb_tuts_in_toolbar($wp_admin_bar) {
        $tuts_url = 'http://documentation.hb-themes.com/highend/index.html#video-tutorials';
        $args     = array(
            'id' => 'highend_tuts_link',
            'title' => __('Video Tutorials', 'hbthemes'),
            'href' => $tuts_url,
            'parent' => 'highend_support_link',
            'meta' => array(
                'class' => 'highend_tuts_link'
            )
        );
        $wp_admin_bar->add_node($args);
    }

    /* CUSTOM POST THUMBNAILS IN ADMIN
    ================================================== */
    add_filter('manage_posts_columns', 'tcb_add_post_thumbnail_column', 5);
    add_filter('manage_pages_columns', 'tcb_add_post_thumbnail_column', 5);
    function tcb_add_post_thumbnail_column($cols) {
        $cols['tcb_post_thumb'] = __('Featured Image', 'hbthemes');
        return $cols;
    }
    add_action('manage_posts_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);
    add_action('manage_pages_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);
    function tcb_display_post_thumbnail_column($col, $id) {
        switch ($col) {
            case 'tcb_post_thumb':
                if (function_exists('the_post_thumbnail'))
                    echo the_post_thumbnail('admin-list-thumb');
                else
                    echo 'Not supported in theme';
                break;
        }
    }
    add_image_size('admin-list-thumb', 100, 100, false);


    /* HIGHLIGHT SEARCH TERMS
    ================================================== */
    function search_excerpt_highlight($excerpt) {
        if (!is_search()) {
            return $excerpt;
        }
        if (!is_admin()) {
            $keys    = implode('|', explode(' ', get_search_query()));
            $excerpt = preg_replace('/(' . $keys . ')/iu', '<ins class="search-ins">\0</ins>', $excerpt);
        }
        return $excerpt;
    }
    add_filter('the_excerpt', 'search_excerpt_highlight');


    /* AJAX LIBRARY
    ================================================== */
    function add_ajax_library() {
        $html = '<script type="text/javascript">';
        $html .= 'var ajaxurl = "' . admin_url('admin-ajax.php') . '"';
        $html .= '</script>';
        echo $html;
    }
    add_action('wp_head', 'add_ajax_library');


    /* REMOVE QUERY PARAMS
    ================================================== */
    function hb_remove_query_params_css_js($src) {
        if (strpos($src, 'ver='))
            $src = remove_query_arg('ver', $src);
        return $src;
    }
    add_filter('style_loader_src', 'hb_remove_query_params_css_js', 9999);
    add_filter('script_loader_src', 'hb_remove_query_params_css_js', 9999);


    /* SHORTCODES IN TEXT WIDGET
    ================================================== */
    function theme_widget_text_shortcode($content) {
        $content          = do_shortcode($content);
        $new_content      = '';
        $pattern_full     = '{(\[raw\].*?\[/raw\])}is';
        $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
        $pieces           = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($pieces as $piece) {
            if (preg_match($pattern_contents, $piece, $matches)) {
                $new_content .= $matches[1];
            } else {
                $new_content .= do_shortcode($piece);
            }
        }
        return $new_content;
    }
    add_filter('widget_text', 'theme_widget_text_shortcode');
    add_filter('widget_text', 'do_shortcode');


    /* HEX TO RGBA
    ================================================== */
    function hb_color($color, $alpha) {
        if (!empty($color)) {
            if ($alpha >= 0.95) {
                return $color; // If alpha is equal 1 no need to convert to RGBA, so we are ok with it. :)
            } else {
                if ($color[0] == '#') {
                    $color = substr($color, 1);
                }
                if (strlen($color) == 6) {
                    list($r, $g, $b) = array(
                        $color[0] . $color[1],
                        $color[2] . $color[3],
                        $color[4] . $color[5]
                    );
                } elseif (strlen($color) == 3) {
                    list($r, $g, $b) = array(
                        $color[0] . $color[0],
                        $color[1] . $color[1],
                        $color[2] . $color[2]
                    );
                } else {
                    return false;
                }
                $r      = hexdec($r);
                $g      = hexdec($g);
                $b      = hexdec($b);
                $output = array(
                    'red' => $r,
                    'green' => $g,
                    'blue' => $b
                );
                return 'rgba(' . implode($output, ',') . ',' . $alpha . ')';
            }
        }
    }


    // retrieves the attachment ID from the file URL
    function hb_get_image_id($image_url) {
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
            return $attachment[0]; 
    }



    /* ADJUST COLOR BRIGHTNES
    ================================================== */
    function hb_darken_color($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Format the hex color string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }

        // Get decimal values
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));

        // Adjust number of steps and keep it inside 0 to 255
        $r = max(0,min(255,$r + $steps));
        $g = max(0,min(255,$g + $steps));  
        $b = max(0,min(255,$b + $steps));

        $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

        return '#'.$r_hex.$g_hex.$b_hex;
    }


    /* MAINTENANCE PAGE CHECK
    ================================================== */
    function hb_is_maintenance() {
        if ((!current_user_can('edit_themes') && hb_options('hb_enable_maintenance')) || (!is_user_logged_in() && hb_options('hb_enable_maintenance'))) {
            return true;
        }
        return false;
    }


    /* AJAX SEARCH
    ================================================== */
    add_action('init', 'hb_ajax_search_init');
    function hb_ajax_search_init() {
        add_action('wp_ajax_hb_ajax_search', 'hb_ajax_search');
        add_action('wp_ajax_nopriv_hb_ajax_search', 'hb_ajax_search');
    }
    function hb_ajax_search() {
        $search_term  = $_REQUEST['term'];
        $search_term  = apply_filters('get_search_query', $search_term);
        $search_array = array(
            's' => $search_term,
            'showposts' => 5,
            'post_type' => 'any',
            'post_status' => 'publish',
            'post_password' => '',
            'suppress_filters' => true
        );
        $query        = http_build_query($search_array);
        $posts        = get_posts($query);
        $suggestions  = array();
        global $post;
        foreach ($posts as $post):
            setup_postdata($post);
            $suggestion  = array();
            $format      = get_post_format(get_the_ID());
            $icon_to_use = 'hb-moon-file-3';
            if ($format == 'video') {
                $icon_to_use = 'hb-moon-play-2';
            } else if ($format == 'status' || $format == 'standard') {
                $icon_to_use = 'hb-moon-pencil';
            } else if ($format == 'gallery' || $format == 'image') {
                $icon_to_use = 'hb-moon-image-3';
            } else if ($format == 'audio') {
                $icon_to_use = 'hb-moon-music-2';
            } else if ($format == 'quote') {
                $icon_to_use = 'hb-moon-quotes-right';
            } else if ($format == 'link') {
                $icon_to_use = 'hb-moon-link-5';
            }
            $suggestion['label'] = esc_html($post->post_title);
            $suggestion['link']  = get_permalink();
            $suggestion['date']  = get_the_time('F j Y');
            $suggestion['image'] = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'thumbnail', array(
                'title' => ''
            )) : '<i class="' . $icon_to_use . '"></i>';
            $suggestions[]       = $suggestion;
        endforeach;
        // JSON encode and echo
        $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
        echo $response;
        exit;
    }


    /* AJAX MAIL
    ================================================== */
    add_action('wp_ajax_mail_action', 'sending_mail');
    add_action('wp_ajax_nopriv_mail_action', 'sending_mail');
    function sending_mail() {
        $site     = get_site_url();
        $subject  = __('New Message!', 'hbthemes');
        $email    = $_POST['contact_email'];
        $email_s  = filter_var($email, FILTER_SANITIZE_EMAIL);
        $comments = stripslashes($_POST['contact_comments']);
        $name     = stripslashes($_POST['contact_name']);
        $to       = hb_options('hb_contact_settings_email');
        $message  = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\nThis email was sent from $site";
        $headers  = 'From: ' . $name . ' <' . $email_s . '>' . "\r\n" . 'Reply-To: ' . $email_s;
        mail($to, $subject, $message, $headers);
        exit();
    }


    /* TIME AGO
    ================================================== */
    function hb_time_ago($time) {
        $periods    = array(
            "second",
            "minute",
            "hour",
            "day",
            "week",
            "month",
            "year",
            "decade"
        );
        $lengths    = array(
            "60",
            "60",
            "24",
            "7",
            "4.35",
            "12",
            "10"
        );
        $now        = time();
        $difference = $now - $time;
        $tense      = __('ago', 'hbthemes');
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= "s";
        }
        return "$difference $periods[$j] ago ";
    }


    function set_focus_color($color){
        global $theme_focus_color;
        $theme_focus_color = $color;
        return;
    }


    /* GET EXCERPT
    ================================================== */
    function hb_get_excerpt($text, $len) {
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out        = null;
        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {
                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out .= " " . $word;
        }
        return $out;
    }


    /* GET COMMENT EXCERPT
    ================================================== */
    function hb_get_comment_excerpt($comment_ID = 0, $num_words = 20) {
        $comment      = get_comment($comment_ID);
        $comment_text = strip_tags($comment->comment_content);
        $blah         = explode(' ', $comment_text);
        if (count($blah) > $num_words) {
            $k             = $num_words;
            $use_dotdotdot = 1;
        } else {
            $k             = count($blah);
            $use_dotdotdot = 0;
        }
        $excerpt = '';
        for ($i = 0; $i < $k; $i++) {
            $excerpt .= $blah[$i] . ' ';
        }
        $excerpt = trim($excerpt, '');
        $excerpt = trim($excerpt, ',');
        $excerpt .= ($use_dotdotdot) ? '...' : '';
        return apply_filters('get_comment_excerpt', $excerpt);
    }


    /* WIDGET UPLOAD SCRIPT
    ================================================== */
    add_action('admin_print_scripts-widgets.php', 'wp_ss_image_admin_scripts');
    function wp_ss_image_admin_scripts() {
        wp_enqueue_script('wp-ss-image-upload', get_template_directory_uri() . '/scripts/widget_upload.js', array(
            'jquery',
            'media-upload',
            'thickbox'
        ));
    }


    /* HIDE META
    ================================================== */
    add_action('admin_print_scripts-post-new.php', 'hb_hide_meta_admin_scripts');
    add_action('admin_print_scripts-post.php', 'hb_hide_meta_admin_scripts');
    function hb_hide_meta_admin_scripts() {
        wp_enqueue_script('hb-hide-meta', get_template_directory_uri() . '/admin/metaboxes/hide-meta.js', array(
            'jquery'
        ));
    }

    
    /* SHORTCODE PARAGRAPH FIX
    ================================================== */
    function shortcode_empty_paragraph_fix($content) {
        $array   = array(
            '<p>[' => '[',
            ']</p>' => ']',
            '<br/>[' => '[',
            ']<br/>' => ']',
            ']<br />' => ']',
            '<br />[' => '['
        );
        $content = strtr($content, $array);
        return $content;
    }
    add_filter('the_content', 'shortcode_empty_paragraph_fix');


    /* QUICK SHORTCODES
    ================================================== */
    add_shortcode('wp-link', 'wp_link_shortcode');
    function wp_link_shortcode() {
        return '<a href="http://wordpress.org" target="_blank">WordPress</a>';
    }

    add_shortcode('the-year', 'the_year_shortcode');
    function the_year_shortcode() {
        return date('Y');
    }

    /* MOBILE MENU
    ================================================== */
    function hb_mobile_menu(){       

		global $woocommerce;
		$cart_url = "";
		if ( class_exists('Woocommerce') ) {
			$cart_url = '<a class="mobile-menu-shop" href="'.$woocommerce->cart->get_cart_url().'"><i class="hb-moon-cart-checkout"></i></a>'. "\n";
		}
	
        if ( has_nav_menu ('mobile-menu') ) {
            $mobile_menu_args = array(
                'echo'            => false,
                'theme_location' => 'mobile-menu',
                'fallback_cb' => ''
            );
        } else {
            $mobile_menu_args = array(
                'echo'            => false,
                'theme_location' => 'main-menu',
                'fallback_cb' => ''
            );
        }
                                    
        $mobile_menu_output = "";                            
        $mobile_menu_output .= '<div id="mobile-menu-wrap">'. "\n";                            
        $mobile_menu_output .= '<form method="get" class="mobile-search-form" action="'.home_url().'/"><input type="text" placeholder="'.__("Search", "hbthemes").'" name="s" autocomplete="off" /></form>'. "\n";
        $mobile_menu_output .= '<a class="mobile-menu-close"><i class="hb-moon-arrow-right-5"></i></a>'. "\n";
		$mobile_menu_output .= $cart_url;
        $mobile_menu_output .= '<nav id="mobile-menu" class="clearfix">'. "\n";     
                                    
        if(function_exists('wp_nav_menu')) {
            $mobile_menu_output .= wp_nav_menu( $mobile_menu_args );
        }
        $mobile_menu_output .= '</nav>'. "\n";
        $mobile_menu_output .= '</div>'. "\n";
                                    
        return $mobile_menu_output;
    }