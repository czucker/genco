<?php

        $sticky_nav_class = "";
        $sticky_height = "";
        $regular_header_height = "";
        $header_layout_class = hb_options('hb_header_layout_style');
        $logo_height = "";
        $logo_url = hb_options('hb_logo_option');
        $retina_url = hb_options('hb_logo_option_retina');
        $site_name = get_bloginfo('name');
        $alternative_url = vp_metabox('misc_settings.hb_page_alternative_logo');
        $main_header_container = hb_options('hb_main_header_container');
        $hb_ajax_search = hb_options('hb_ajax_search');

        if ( $hb_ajax_search ){
            $hb_ajax_search = ' hb-ajax-search';
        }

        $search_in_header = ' data-search-header=0';
        if ( hb_options('hb_search_in_menu') ){
            $search_in_header = ' data-search-header=1';
        }

        if ( isset($_GET['focus_color']) && $_GET['focus_color'] == 'dark_elegance' ){
            $logo_url = $retina_url = 'http://hb-themes.com/themes/highend_wp/wp-content/uploads/2014/04/logo-retina-white.png';
        }

        if ( isset($_GET['header']) ){
            $header_val = $_GET['header'];

            if ($header_val == '2-1' || $header_val == '2-2' || $header_val == '2-3' || $header_val == '2-4')
                $header_layout_class = 'nav-type-2';

            if ($header_val == '3-1' || $header_val == '3-2'){
                $header_layout_class = 'nav-type-2 centered-nav';
            }

            if ($header_val == 'wide'){
                $main_header_container = 'container-wide';
            }
        }

        if ( vp_metabox('misc_settings.hb_special_header_style') ){
            $header_layout_class = 'nav-type-1';
        }

        // Only for Sticky Header && Nav Type 1
        if (hb_options('hb_sticky_header') && $header_layout_class == 'nav-type-1'){
            $sticky_nav_class = "sticky-nav ";
            $sticky_height = ' data-sticky-height="' . hb_options('hb_sticky_header_height') . '"';
            $regular_header_height = ' style="height: '. hb_options('hb_regular_header_height') .'px; line-height: '. hb_options('hb_regular_header_height') .'px;" data-height="' . hb_options('hb_regular_header_height') . '"';

            $logo_height = ' style="height:' . hb_options("hb_regular_header_height") . 'px; line-height: ' . hb_options("hb_regular_header_height") . 'px;"';
        }

        if ( $header_layout_class == 'nav-type-2 centered-nav' && hb_options('hb_sticky_header_alt') ){
            $sticky_nav_class = "sticky-nav ";
        }
        ?>
        <!-- BEGIN #header-inner -->
        <div id="header-inner" class="<?php echo $sticky_nav_class; echo $header_layout_class; echo $hb_ajax_search; ?> clearfix"<?php echo $regular_header_height; ?><?php echo $sticky_height; echo $search_in_header; ?> role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

            <!-- BEGIN #header-inner-bg -->
            <div id="header-inner-bg">
                
                <!-- BEGIN .container or .container-wide -->
                <div class="<?php if ( $header_layout_class == 'nav-type-1 nav-type-4' ) { echo 'container'; } else { echo $main_header_container; } ?>">
                    
                    <!-- BEGIN #logo -->
                    <div id="logo"<?php echo $logo_height; ?>>
                        <?php if ( hb_options('hb_logo_option') ) { ?>
                        <a href="<?php echo get_bloginfo ('url') ?>" class="image-logo">

                            <?php  if (vp_metabox('misc_settings.hb_page_alternative_logo')) {
                                $retina_url = $alternative_url;
                            ?>
                            <img src="<?php echo $alternative_url ?>" class="default" alt="<?php echo $site_name; ?>"/>
                            <?php } else { ?>
                            <img src="<?php echo $logo_url ?>" width="191" height="144" class="default" alt="<?php echo $site_name; ?>"/>
                            <?php } ?>

                            <?php if ( hb_options('hb_logo_option_retina') ){ ?>
                            <img src="<?php echo $retina_url; ?>" class="retina" width="191" height="144" alt="<?php echo $site_name; ?>"/>
                            <?php } ?>
                        </a>
                        <?php } else { ?>
                        <h1><a href="<?php echo get_bloginfo ('url') ?>" class="plain-logo"><?php echo $site_name ?></a></h1>
                        <?php } ?>
                    </div>
                    <!-- END #logo -->

                    <?php if ( $header_layout_class == 'nav-type-2' && hb_options('hb_header_right_text') ){?>
                    <div class="hb-site-tagline hb-center-me"><?php echo hb_options('hb_header_right_text'); ?></div>
                    <?php } ?>

                    <?php if ($header_layout_class == 'nav-type-2' || $header_layout_class == 'nav-type-2 centered-nav'){ ?>
                    </div>
                    <!-- END .container or .container-wide -->
                    <div class="clear"></div>
                    <?php } ?>

                    <?php
                        $menu_skin_class = hb_options('hb_header_layout_skin');
                        $menu_effect = ' ' . hb_options('hb_navigation_animation');
                    ?>

                    <?php  if (!vp_metabox('misc_settings.hb_disable_navigation')) { ?>

                    <!-- BEGIN .main-navigation -->
                    <nav class="main-navigation <?php echo $menu_skin_class; echo $menu_effect; echo ' ' . hb_options('hb_main_navigation_color'); ?> clearfix"<?php echo $regular_header_height; ?> role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

                        <?php if ($header_layout_class == 'nav-type-2' || $header_layout_class == 'nav-type-2 centered-nav'){ ?>
                        <!-- BEGIN .container or .container-wide -->
                        <div class="<?php echo $main_header_container; ?>">
                        <?php } ?>

                        <?php
                        if ( vp_metabox('misc_settings.hb_onepage') && has_nav_menu('one-page-menu') ) {
                            wp_nav_menu( 
                                array( 
                                    'theme_location'    => 'one-page-menu', 
                                    'menu_class'        => 'sf-menu ',
                                    'menu_id'           => 'main-nav', 
                                    'container'         => '',
                                    'link_before'       => '<span>',
                                    'link_after'        => '</span>',
                                    'walker'            =>  new hb_custom_walker
                                    )
                                );
                        } else if ( has_nav_menu( 'main-menu' ) ) {
                            // User has assigned menu to this location
                            wp_nav_menu( 
                                array( 
                                    'theme_location'    => 'main-menu', 
                                    'menu_class'        => 'sf-menu ',
                                    'menu_id'           => 'main-nav', 
                                    'container'         => '',
                                    'link_before'       => '<span>',
                                    'link_after'        => '</span>',
                                    'walker'            =>  new hb_custom_walker
                                    )
                                );
                        } else { ?>
                            <ul id="main-nav" class="empty-menu">
                                <li><?php _e('Please attach a menu to this menu location in Appearance > Menu.', 'hbthemes'); ?></li>
                            </ul>
                        <?php }
                        ?>

                        <!-- BEGIN #fancy-search -->
                        <div id="fancy-search">
                            <form id="fancy-search-form" action="<?php echo home_url( '/' ); ?>" novalidate="" autocomplete="off">
                                <input type="text" name="s" id="s" placeholder="<?php _e('Type keywords and press enter', 'hbthemes'); ?>" autocomplete="off">
                            </form>
                        <a href="#" id="close-fancy-search" class="no-transition"><i class="hb-moon-close-2"></i></a>
                        <span class="spinner"></span>
                        </div>
                        <!-- END #fancy-serach -->


                        <?php if (hb_options('hb_responsive')){ ?>
                        <a href="#" id="show-nav-menu"><i class="hb-moon-menu-6"></i></a>
                        <?php } ?>


                        <?php if ($header_layout_class == 'nav-type-2' || $header_layout_class == 'nav-type-2 centered-nav'){ ?>
                        <!-- END .container or .container-wide -->
                        </div>
                        <?php } ?>

                    </nav>
                    <!-- END .main-navigation -->
                    <?php } ?>

                        <?php if ($header_layout_class != 'nav-type-2' && $header_layout_class != 'nav-type-2 centered-nav'){ ?>
                        </div>
                        <!-- END .container or .container-wide -->
                        <?php } ?>
            </div>
            <!-- END #header-inner-bg -->

            <?php if ( hb_options('hb_enable_sticky_shop_button') && class_exists('Woocommerce') ){ 
                global $woocommerce;
                $cart_url = $woocommerce->cart->get_cart_url();
                $cart_count = $woocommerce->cart->cart_contents_count;
            ?>
            <a href="<?php echo $cart_url; ?>" id="sticky-shop-button"><i class="hb-moon-cart-checkout"></i><span><?php echo $cart_count; ?></span></a>
            <?php } ?>

        </div>
        <!-- END #header-inner -->