<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
$classes[] = 'hb-woo-product';
$read_more = '';

$sidebar_layout = vp_metabox('layout_settings.hb_page_layout_sidebar'); 
$sidebar_name = vp_metabox('layout_settings.hb_choose_sidebar');

if(isset($_REQUEST['layout']) && !empty($_REQUEST['layout'])) {
	$sidebar_layout = $_REQUEST['layout'];
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

if ( $sidebar_layout == 'fullwidth' ){
	$classes[] = 'col-3 hb-animate-element top-to-bottom';
} else {
	$classes[] = 'col-4 hb-animate-element top-to-bottom';
}
?>

<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="hb-woo-image-wrap">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );

			if ( get_the_post_thumbnail() ){
				$image_object		= get_post_thumbnail_id();
				$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );

				$image = hb_resize ( $image_object, '', 526, 700, true);
				echo '<div class="woo-category-wrap"><img src="' . $image["url"] . '" width="'.$image["width"].'" height="'.$image["height"].'"></div>';
			} else {
				echo '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="526" height="700" />';
			}

			$product_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );

			if ( !empty( $product_gallery ) ) {
				$gallery = explode( ',', $product_gallery );
				$image_id  = $gallery[0];

				$image_src_hover = hb_resize ( $image_id, '', 526, 700, true);

				echo '<img src="'.$image_src_hover['url'].'" alt="'.get_the_title().'" class="product-hover-image" title="'.get_the_title().'">';
			}

			$postdate 		= get_the_time( 'Y-m-d' );			// Post date
			$postdatestamp 	= strtotime( $postdate );			// Timestamped post date
			$newness 		= 3; 	// Newness in days
			
			if ( $product->sale_price ){
				// Sale will be added through action hook
			}
			else if ( hb_is_out_of_stock() ) {	
				echo '<span class="out-of-stock-badge">' . __( 'Sold out', 'hbthemes' ) . '</span>';
			} else if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
				echo '<span class="wc-new-badge">' . __( 'New', 'hbthemes' ) . '</span>';
			}
		?>
		<?php get_star_rating(); ?>

		<?php echo '<span class="product-loading-icon preloading hb-spin"></span>'; ?>

		<?php
		$out_of_stock_class = ' add_to_cart_button';
		if ( hb_is_out_of_stock() ) {
			$out_of_stock_class = ' no-action';
		}
		if ( ! $product->is_in_stock() ) {
			$hb_add_to_cart = '<a href="'. apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ).'" class="hb-buy-button'.$out_of_stock_class.'">'. apply_filters( 'out_of_stock_add_to_cart_text', __( 'READ MORE', 'woocommerce' ) ).'</a>';
			$out_of_stock_badge = '<span class="hb-out-stock">'.__( 'OUT OF STOCK', 'woocommerce' ).'</span>';
		}
		else { ?>

			<?php

			switch ( $product->product_type ) {
			case "variable" :
				$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
				$label  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
				break;
			case "grouped" :
				$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
				$label  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
				break;
			case "external" :
				$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
				$label  = apply_filters( 'external_add_to_cart_text', __( 'View Details', 'woocommerce' ) );
				break;
			default :
				$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
				$label  = apply_filters( 'add_to_cart_text', __( 'Add to Cart', 'woocommerce' ) );
				$read_more = '<a href="'. get_permalink( $product->id ) .'" rel="nofollow" class="hb-more-details">' . __( 'View Details', 'woocommerce' ) . '</a>';
				break;
			}

			if ( $product->product_type != 'external' ) {
				$hb_add_to_cart = '<a href="'. $link .'" rel="nofollow" data-product_id="'.$product->id.'" class="hb-buy-button add_to_cart_button product_type_'.$product->product_type.'">'. $label.'</a>';
			}
			else {
				$hb_add_to_cart = '';
			}
		}
				?>

		<?php echo $hb_add_to_cart; ?>
		<?php echo $read_more; ?>
	</div>

	<div class="hb-product-meta-wrapper clearfix">
	<div class="hb-product-meta">

		<div class="hb-woo-product-details">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
			$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) ); ?>
			<div class="woo-cats"><?php echo $product->get_categories( ', ', '<span class="hb-woo-shop-cats">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span>' ); ?></div>
		</div>

		<?php
			if ( hb_options('hb_woo_enable_likes') ){
				echo hb_print_likes(get_the_ID());
			}
		?>

	</div>

	<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
	?>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</div>
</div>

<?php 

if ($sidebar_layout == 'fullwidth'){
	if ( $woocommerce_loop['loop'] % 4 == 0 ) {
		echo '<div class="clear"></div>';
	}
} else {
	if ( $woocommerce_loop['loop'] % 3 == 0 ) {
		echo '<div class="clear"></div>';
	}
} 

?>