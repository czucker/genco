<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;

	parse_str($_SERVER['QUERY_STRING'], $params);
	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if( hb_options('hb_woo_count') ) {
		$per_page = hb_options('hb_woo_count');
	} else {
		$per_page = 12;
	}

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>
<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby">
		<?php
			$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by newness', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
			) );

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
				unset( $catalog_orderby['rating'] );

			foreach ( $catalog_orderby as $id => $name )
				echo '<option value="' . esc_attr( $id ) . '" ' . selected( $orderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
		?>
	</select>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' == $key )
				continue;
			
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>

<?php
	$pc='';
	$current_count = $per_page;
	if ( isset($_GET['product_count']) ) {
		if ( $_GET['product_count'] ){
			$current_count = $_GET['product_count'];
		}
	}

	$html = '';
	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('Show', 'woocommerce').' '.$current_count.' '.__(' Products', 'woocommerce').'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.hb_addURLParameter($query_string, 'product_count', $per_page).'">'.__('Show', 'woocommerce').' <strong>'.$per_page.' '.__('Products', 'woocommerce').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.hb_addURLParameter($query_string, 'product_count', $per_page*2).'">'.__('Show', 'woocommerce').' <strong>'.($per_page*2).' '.__('Products', 'woocommerce').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.hb_addURLParameter($query_string, 'product_count', $per_page*3).'">'.__('Show', 'woocommerce').' <strong>'.($per_page*3).' '.__('Products', 'woocommerce').'</strong></a></li>';
	$html .= '<li class="'.(($pc == $per_page*4) ? 'current': '').'"><a href="'.hb_addURLParameter($query_string, 'product_count', $per_page*4).'">'.__('Show', 'woocommerce').' <strong>'.($per_page*4).' '.__('Products', 'woocommerce').'</strong></a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';

	echo $html;
?>
<div class="clear"></div>
<div class="hb-separator-extra shop-separator"></div>