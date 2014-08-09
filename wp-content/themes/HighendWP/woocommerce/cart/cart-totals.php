<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>
<div class="hb-woo-cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="hb-box-cont clearfix hb-cart-totals-wrap">
		<div class="hb-box-cont-header"><i class="hb-moon-cart-checkout"></i>
			<?php _e( 'Cart Totals', 'woocommerce' ); ?>
		</div>

		<div class="hb-box-cont-body">
			<ul class="nbm hb-cart-totals">
				<li class="clearfix">
					<span class="cart-total-title"><?php _e('Items in Cart', 'hbthemes'); ?></span>
					<span class="cart-total-value"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
				</li>

				<li class="clearfix">
					<span class="cart-total-title"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?></span>
					<span class="cart-total-value"><?php echo $woocommerce->cart->get_cart_subtotal(); ?></span>
				</li>

				<li class="clearfix hb-shipping-wrapper">
					<span class="cart-total-title"><?php _e( 'Shipping', 'woocommerce' ); ?></span>
					
					<?php
					$shipping_costs = 0;
					$shipping_costs = $woocommerce->cart->shipping_total + $woocommerce->cart->shipping_tax_total ;
					if ($shipping_costs != 0 && $shipping_costs != '0'){
						$shipping_costs = get_woocommerce_currency_symbol() . $shipping_costs;
					} else {
						$shipping_costs = __('Free', 'woocommerce');
					}
					?>
					<span class="cart-total-value"><?php echo $shipping_costs; ?></span>
				</li>

				<?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
					<li class="clearfix">
						<span class="cart-total-title"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
						<span class="cart-total-value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
					</li>
				<?php endforeach; ?>

				<?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
					<li class="clearfix">
						<span class="cart-total-title"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
						<span class="cart-total-value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
					</li>
				<?php endforeach; ?>

				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<li class="clearfix">
						<span class="cart-total-title"><?php echo esc_html( $fee->name ); ?></span>
						<span class="cart-total-value"><?php wc_cart_totals_fee_html( $fee ); ?></span>
					</li>
				<?php endforeach; ?>

				<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
					<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
							<li class="clearfix">
								<span class="cart-total-title"><?php echo esc_html( $tax->label ); ?></span>
								<span class="cart-total-value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
							</li>
						<?php endforeach; ?>
					<?php else : ?>
						<li class="clearfix">
							<span class="cart-total-title"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
							<span class="cart-total-value"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></span>
						</li>
					<?php endif; ?>
				<?php endif; ?>

				<li class="clearfix total-order-li">
					<span class="cart-total-title"><?php _e( 'Order Total', 'woocommerce' ); ?></span>
					<span class="cart-total-value"><?php wc_cart_totals_order_total_html(); ?></span>
				</li>

			</ul>
		</div>

	</div>

	<div data-initialindex="-1" id="hb-toggle-coupon" class="hb-toggle coupon-toggle">

		<div class="hb-accordion-single">
			<div class="hb-accordion-tab"><i class="hb-moon-gift"></i><?php _e('Apply Coupon', 'woocommerce'); ?><i class="icon-angle-right"></i></div>
			<div class="hb-accordion-pane">
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
					<div class="coupon-code">
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" />
						<input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />
						<?php do_action('woocommerce_cart_coupon'); ?>
					</div>
					</form>
				<?php } ?>
			</div>
		</div>

		<?php woocommerce_shipping_calculator(); ?>

	</div>

	<?php if ( WC()->cart->get_cart_tax() ) : ?>
		<p class="small-text"><small><?php

			$estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
				? sprintf( ' ' . __( ' (taxes estimated for %s)', 'woocommerce' ), WC()->countries->estimated_for_prefix() . __( WC()->countries->countries[ WC()->countries->get_base_country() ], 'woocommerce' ) )
				: '';

			printf( __( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce' ), $estimated_text );

		?></small></p>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>