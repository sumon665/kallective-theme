<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>


	<div id="order_review" class="shop_table woocommerce-checkout-review-order-table">
		<!-- review order -->
		<?php 
		$prices = [
			'without' => 0,
			'discount' => 0,
			'total' => 0
		]; 

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$price = $_product->get_regular_price();
			$prices['without'] += ($price * $cart_item['quantity']);
			$sale = $_product->get_sale_price();
			if($sale > 0){
				$prices['discount'] += (($price - $sale) * $cart_item['quantity']);
				$price_str = "$ $sale<span>$ $price</span>";
			} else{
				$price_str = "$ $price";
			}
		}
		?>
		<span class="cart-summary-dropdown-toggle"><span>Show</span> discounts</span>              
		<div class="cart-summary-dropdown">
			<div class="cart-summary-row _sum">
				<div class="cart-summary-row__label">Without discount:</div>
				<div class="cart-summary-row__value">$<?php echo number_format($prices['without'], 2);?></div>
			</div>
			<div class="cart-summary-row _discount">
				<div class="cart-summary-row__label">Discount:</div>
				<div class="cart-summary-row__value">$<?php echo number_format($prices['discount'], 2);?></div>
      		</div>
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="cart-summary-row _coupon">
				<div class="cart-summary-row__label"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
				<div class="cart-summary-row__value"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="cart-summary-row _price order-total">
			<div class="cart-summary-row__label">Your price:</div>
			<div class="cart-summary-row__value"><?php wc_cart_totals_order_total_html(); ?></div>
		</div>
	</div>	

