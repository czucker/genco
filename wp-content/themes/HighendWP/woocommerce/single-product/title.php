<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post,$product;

?>
<h3 itemprop="name" class="hb-heading"><span><?php the_title(); ?></span></h3>
<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>.</span>

<?php endif; ?>