<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product-category hb-woo-product col-<?php echo 12 / $woocommerce_loop['columns'] ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
			$dimensions    			= wc_get_image_size( $small_thumbnail_size );
			$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );


			if ( $thumbnail_id ) {
				$image = hb_resize ( $thumbnail_id, '', 526, 700, true);
			} else {
				$image = wc_placeholder_img_src();
			}


			if ( $image ) {
				$image = str_replace( ' ', '%20', $image );

				echo '<a href="'. get_term_link( $category->slug, 'product_cat' ) . '" class="woo-category-wrap"><img src="' . esc_url( $image["url"] ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '" />';
			}
		?>

		<div class="woo-cat-details">
		<h6 class="special">
			<?php
				echo $category->name;
			?>
		</h6>
		<?php if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' '. __("products", "woocommerce") . '</span>', $category );
		}
		?>
		</div>
		<?php if ( $image ) { ?> </a> <?php } ?>


		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>