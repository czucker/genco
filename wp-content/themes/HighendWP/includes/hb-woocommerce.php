<?php
/**
 * @package WordPress
 * @subpackage Highend
 */


	/* REMOVE ACTIONS
	================================================== */ 
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


	/* ADD ACTIONS
	================================================== */ 
	add_action( 'woocommerce_before_main_content', 'hb_woocommerce_output_content_wrapper', 10);
	add_action( 'woocommerce_after_main_content', 'hb_woocommerce_output_content_wrapper_end', 10);


	/* TRANSLATE
	================================================== */ 
	add_filter('gettext',  'translate_text');
	add_filter('ngettext',  'translate_text');

	function translate_text($translated) {
	     $translated = str_ireplace('Shipping and Handling',  'Shipping',  $translated);
	     return $translated;
	}



	/* LOOP COUNT
	================================================== */ 
	add_filter('loop_shop_per_page', 'hb_loop_shop_per_page');
	function hb_loop_shop_per_page(){
		global $data;

		$per_page = 12;
		$pc = 12;

		parse_str($_SERVER['QUERY_STRING'], $params);

		if( hb_options('hb_woo_count') ) {
			$per_page = hb_options('hb_woo_count');
		} else {
			$per_page = 12;
		}

		$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

		return $pc;
	}


	/* BEFORE MAIN CONTENT
	================================================== */
	function hb_woocommerce_output_content_wrapper() {
		global $post; 

		$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
		$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

		if(isset($_REQUEST['layout']) && !empty($_REQUEST['layout'])) {
			$sidebar_layout = $_REQUEST['layout'];
			$sidebar_name = hb_options('hb_woo_choose_sidebar');
		} else {
			if ( is_product() ) { 
				$sidebar_layout = hb_options('hb_woo_sp_layout_sidebar');
				$sidebar_name = hb_options('hb_woo_sp_choose_sidebar');
			}
			else { 
				$sidebar_layout = hb_options('hb_woo_layout_sidebar');
				$sidebar_name = hb_options('hb_woo_choose_sidebar');
			}
		}

		?>
		
		<div id="main-content">
			<div class="container">
				<div class="row <?php echo $sidebar_layout; ?> main-row">
					<div id="page-<?php the_ID(); ?>" class="hb-woo-wrapper">

						<!-- BEGIN .hb-main-content -->
						<?php if ( $sidebar_layout != 'fullwidth' ) { ?>
						<div class="col-9 hb-equal-col-height hb-main-content">
						<?php } else { ?>
						<div class="col-12 hb-main-content">
						<?php } ?>
	<?php }


	/* AFTER MAIN CONTENT
	================================================== */
	function hb_woocommerce_output_content_wrapper_end() {
		global $post; 

		$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
		$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

		if(isset($_REQUEST['layout']) && !empty($_REQUEST['layout'])) {
			$sidebar_layout = $_REQUEST['layout'];
			$sidebar_name = hb_options('hb_woo_choose_sidebar');
		} else {
			if ( is_single() ) { 
				$sidebar_layout = hb_options('hb_woo_sp_layout_sidebar');
				$sidebar_name = hb_options('hb_woo_sp_choose_sidebar');
			}
			else { 
				$sidebar_layout = hb_options('hb_woo_layout_sidebar');
				$sidebar_name = hb_options('hb_woo_choose_sidebar');
			}
		}

		?>
						</div>
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
				</div>
			</div>
		</div>
	<?php }



	/* WOOCOMMERCE STYLES
	================================================== */
	function hb_woocommerce_styles(){
		global $themepath;

		if(is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
			return;
		}
		wp_enqueue_style('hb-woocommerce', get_template_directory_uri().'/css/woocommerce.css', false, false, 'all');
	}
	add_action('wp_print_styles', 'hb_woocommerce_styles',12);



	/* MISC FUNCTIONS
	================================================== */
	function hb_is_out_of_stock() {
	    global $post;
	    $post_id = $post->ID;
	    $stock_status = get_post_meta($post_id, '_stock_status',true);
	    
	    if ($stock_status == 'outofstock') {
	    return true;
	    } else {
	    return false;
	    }
	}

	function get_star_rating(){
	    global $woocommerce, $product;

	    if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ){
	    	return;
	    } else {
	    	$average = $product->get_average_rating();

	    if ($average > 0){
		    echo '<div class="star-wrapper"><div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div></div>';
			}
		}
	}

	function hb_product_items_text($count) {
			
		$product_item_text = "";
		
    	if ( $count > 1 ) {
        	$product_item_text = str_replace('%', number_format_i18n($count), __('% products', 'woocommerce'));
        } elseif ( $count == 0 ) {
        	$product_item_text = __('0 products', 'woocommerce');
        } else {
        	$product_item_text = __('1 product', 'woocommerce');
        }
        
        return $product_item_text;
        
	}

	function hb_addURLParameter($url, $paramName, $paramValue) {
		$url_data = parse_url($url);
		if(!isset($url_data["query"]))
			$url_data["query"]="";

		$params = array();
		parse_str($url_data['query'], $params);
		$params[$paramName] = $paramValue;
		$url_data['query'] = http_build_query($params);
		return hb_build_url($url_data);
	}


	function hb_build_url($url_data) {
		$url="";
		if(isset($url_data['host'])){
			$url .= $url_data['scheme'] . '://';
			if (isset($url_data['user'])) {
				$url .= $url_data['user'];
				if (isset($url_data['pass'])) {
					$url .= ':' . $url_data['pass'];
				}
				$url .= '@';
			}
		$url .= $url_data['host'];
		if (isset($url_data['port'])) {
			$url .= ':' . $url_data['port'];
		}
	}
		if (isset($url_data['path'])) {
			$url .= $url_data['path'];
		}
		if (isset($url_data['query'])) {
			$url .= '?' . $url_data['query'];
		}
		if (isset($url_data['fragment'])) {
			$url .= '#' . $url_data['fragment'];
		}
		return $url;
	}


	/* CART DROPDOWN
    ================================================== */ 
    if (!function_exists('hb_woo_cart')) {
        function hb_woo_cart() {
        
            $cart_output = "";
            
            // Check if WooCommerce is active
            if ( class_exists('Woocommerce') ) {
            
                global $woocommerce;
                
                $cart_total = $woocommerce->cart->get_cart_total();
                $cart_count = $woocommerce->cart->cart_contents_count;
                $cart_count_text = hb_product_items_text($cart_count);
                $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
                
                $cart_output .= '<div id="top-cart-widget" class="top-widget float-right">';

                $cart_output .= '<a href="'.$woocommerce->cart->get_cart_url().'"><i class="hb-moon-cart-checkout"></i><span class="amount">'.$cart_total.'</span><i class="icon-angle-down"></i></a>';

                $cart_output .= '<div class="hb-dropdown-box cart-dropdown">';

                if ($cart_count == '0'){
                    $cart_output .= '<div class="hb-cart-count empty">';
                    $cart_output .= __('No products in the cart','woocommerce');
                } else {
                    $cart_output .= '<div class="hb-cart-count">';
                    $cart_output .= $cart_count_text . ' ' . __('in the cart.','woocommerce');
                }
                $cart_output .= '</div>'; 


                if ($cart_count != '0'){
	                // PRINT EACH ITEM
	                $cart_output .= '<div class="hb-cart-items">';
	                
	                foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {
	                
	                    $bag_product = $cart_item['data']; 
	                    $product_title = $bag_product->get_title();
	                    $product_short_title = (strlen($product_title) > 25) ? substr($product_title, 0, 22) . '...' : $product_title;
	                                                               
	                    if ($bag_product->exists() && $cart_item['quantity']>0) {                                            
	                        $cart_output .= '<div class="hb-item-product clearfix">';
	                      	$cart_output .= '<figure class="item-figure"><a class="hb-item-product-img" href="'.get_permalink($cart_item['product_id']).'">'.$bag_product->get_image().'</a></figure>';                      
	                        $cart_output .= '<div class="hb-item-product-details">';
	                        $cart_output .= '<div class="hb-item-product-title"><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $product_short_title, $bag_product) . '</a></div>';
	                        $cart_output .= '<div class="bag-product-price">'.$cart_item['quantity'].' x '.woocommerce_price($bag_product->get_price()).'</div>';
	                        $cart_output .= '</div>';
	                        $cart_output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key );
	                        
	                        $cart_output .= '</div>';
	                	}
	                }

	                $cart_output .= '</div>';
            	}

                // CART BUTTONS
                $cart_output .= '<div class="hb-bag-buttons">';
                    
                if ($cart_count != '0'){
                $cart_output .= '<a class="shop-button" href="'.esc_url( $woocommerce->cart->get_cart_url() ).'">'. __('View shopping cart', 'woocommerce').'</a>';
                $cart_output .= '<a class="checkout-button" href="'. esc_url( $woocommerce->cart->get_checkout_url() ).'">'.__('Proceed to checkout', 'woocommerce').'</a>';
            	} else {
            		$cart_output .= '<a class="checkout-button" href="'.esc_url( $shop_page_url ).'">'.__('Go to shop', 'woocommerce').'</a>';
            	}
                                    
                $cart_output .= '</div>';


                $cart_output .= '</div>';

                $cart_output .= '</div>';
            
            }
            
            return $cart_output;
        }
    }


    /* AJAX RELOAD
	================================================== */ 
	add_filter('add_to_cart_fragments', 'woocommerce_cart_link');

	function woocommerce_cart_link() {
	    global $woocommerce;
	    ob_start();

	    $cart_total = $woocommerce->cart->get_cart_total();
		$cart_count = $woocommerce->cart->cart_contents_count;
		$cart_count_text = hb_product_items_text($cart_count);
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );?>
                
		<div id="top-cart-widget" class="top-widget float-right">
        <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="hb-moon-cart-checkout"></i><span class="amount"><?php echo $cart_total; ?></span><i class="icon-angle-down"></i></a>

       <div class="hb-dropdown-box cart-dropdown">

		<?php if ($cart_count == '0'){ ?>
			<div class="hb-cart-count empty">
			<?php _e('No products in the cart','woocommerce');
		} else {?>
			<div class="hb-cart-count">
			<?php echo $cart_count_text . ' ' . __('in the cart.','woocommerce');
		} ?>
		</div>
		<?php if ($cart_count != '0'){ ?>
			<div class="hb-cart-items">
			<?php foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) {        
					$bag_product = $cart_item['data']; 
					$product_title = $bag_product->get_title();
					$product_short_title = (strlen($product_title) > 25) ? substr($product_title, 0, 22) . '...' : $product_title;
		                                                               
					if ($bag_product->exists() && $cart_item['quantity']>0) { ?>                                      
						<div class="hb-item-product clearfix">
						<figure class="item-figure"><a class="hb-item-product-img" href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo $bag_product->get_image(); ?></a></figure>
						<div class="hb-item-product-details">
						<div class="hb-item-product-title"><a href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo apply_filters('woocommerce_cart_widget_product_title', $product_short_title, $bag_product); ?></a></div>
						<div class="bag-product-price"><?php echo $cart_item['quantity'].' x '.woocommerce_price($bag_product->get_price()); ?></div>
						</div>
						<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key ); ?>
		                        
						</div>
						<?php }
					} ?>

				</div>
            	<?php } ?>

               <div class="hb-bag-buttons">
                    
                <?php if ($cart_count != '0'){ ?>
				<a class="shop-button" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>"><?php  _e('View shopping cart', 'woocommerce'); ?></a>
				<a class="checkout-button" href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>"><?php _e('Proceed to checkout', 'woocommerce'); ?></a>
            	<?php } else {
            		echo '<a class="checkout-button" href="'.esc_url( $shop_page_url ).'">'.__('Go to shop', 'woocommerce').'</a>';
            	} ?>
                                    
                </div>
			</div>

		</div>

	    <?php
	    $fragments['#top-cart-widget'] = ob_get_clean();
	    return $fragments;
	}

?>