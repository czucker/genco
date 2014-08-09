<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

?>

<h4 class="hb-heading hb-center-heading cart-empty"><span><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></span></h4>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<p class="aligncenter"><a class="hb-button hb-small-button hb-third-dark" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" target="_self"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>