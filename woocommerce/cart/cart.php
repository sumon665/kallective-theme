<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

 ?>

<div class="cart-layout">
	<?php do_action( 'woocommerce_before_cart' ); ?>
	<div class="cart-layout-nav">
		<h1 class="cart-layout-nav__item active" data-step="1">Your cart</h1>
		<i class="cart-layout-nav__space visible-desktop"></i>
		<h2 class="cart-layout-nav__item" data-step="2">Delivery</h2>
		<i class="cart-layout-nav__space visible-desktop"></i>
		<h3 class="cart-layout-nav__item">Order is processed</h3>
	</div>
	<!-- empty start -->
	<!-- <div class="cart-empty">
	<p class="cart-empty__txt">Your cart is empty yet</p>
	<a href="" class="btn-primary cart-empty__link">Shop now</a>
	</div> -->
	<!-- empty end -->
	<!-- not empty start -->
	<div class="cart-layout-body">
	<div class="cart-step active" data-step="1">
		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>
		<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
		<ul class="cart-good-list ">
			<?php $prices = [
				'without' => 0,
				'discount' => 0,
				'total' => 0
			]; ?>
			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) { ?>
			<?php $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$price_str = '';
				$price = $_product->get_regular_price();
				$prices['without'] += ($price * $cart_item['quantity']);
				$sale = $_product->get_sale_price();
				if($sale > 0 && !WC_Name_Your_Price_Helpers::is_nyp($_product)){
					$prices['discount'] += (($price - $sale) * $cart_item['quantity']);
					$price_str = "$ " . number_format($sale,2) . "<span>$ " . number_format($price,2) . "</span>";
				} else{
					$price_str = "$ " . number_format($price,2);
				}
				
			?>
			<li class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<div class="cart-good">
					<a href="<?php echo $product_permalink;?>" class="cart-good-left">
						<span class="product-tile__img">
						<?php echo $thumbnail;?>
						</span>
					</a>
					<div class="cart-good-info">
						<a href="<?php echo $product_permalink;?>" class="cart-good__name"><?php echo $_product->get_name();?></a>
						<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
						?>
						<div class="cart-good__price">
						<?php echo $price_str; ?>
						</div>
						<div class="cart-good__ctrs">
						<div class="control-number">
							<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '<input type="hidden" class="qty" name="cart[%s][qty]" value="1" />', $cart_item_key );
								echo $product_quantity;
							} else { 
								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									),
									$_product,
									false
								); ?>
								<span class="control-number__btn _dec btnMinus" data-key="<?php echo $cart_item_key;?>" data-qty="<?php echo $cart_item['quantity']; ?>">
								<span class="icon icon-minus"></span>
								</span>
								<input class="qty" id="quantity_<?php echo $cart_item_key;?>" type="text" name="cart[<?php echo $cart_item_key;?>][qty]" value="<?php echo $cart_item['quantity'];?>" >
								<span class="control-number__btn _inc btnPlus" data-key="<?php echo $cart_item_key;?>" data-qty="<?php echo $cart_item['quantity']; ?>">
									<span class="icon icon-plus"></span>
								</span>	
								<?php
							}
							?>
							
							
						</div>
						<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="cart-good__remove remove_from_cart" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="icon icon-cross"></span></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</div>
					</div>
				</div>
			</li>
			<?php } ?>
			
			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</ul>
		<div id="cart_controls" class="actions" style="display:none;">
		<?php if ( wc_coupons_enabled() ) { ?>
			<div class="coupon">
				<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</div>
		<?php } ?>
		<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
		<?php do_action( 'woocommerce_cart_actions' ); ?>
		<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</div>
		</div>
	</div>
	<div class="cart-layout-sticky cart_totals" data-step-active="1">
		<div class="cart-summary"> 
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
		</div>
		<div class="cart-summary-row _price order-total">
			<div class="cart-summary-row__label">Your price:</div>
			<div class="cart-summary-row__value"><?php wc_cart_totals_order_total_html(); ?></div>
		</div>
		<div class="cart-summary-ctrls">
			<div class="cart-summary-ctrls-step _step-1">
			<a href="/checkout/" class="btn-primary cart-summary-ctrls__item cart-checkout <?php if(!is_user_logged_in(  )):?>noAuth<?php endif;?>">Checkout</a>
			<a href="/" class="btn-secondary-outline cart-summary-ctrls__item">Continue shopping</a>
			</div>
			<div class="cart-summary-ctrls-step _step-2">
			<div class="_desktop-down-buttons">
				<button class="btn-primary cart-summary-ctrls__item cart-delivery-place-order hidden-desktop">Place Order</button>
				<button type="button" class="btn-secondary-outline cart-summary-ctrls__item open-cart-panel">Check my cart</button>
			</div>
			<form class="cart-promocode-form" id="cart-promocode-form" autocomplete="off"> <!-- '_success _error' classes for states-->
				<div class="control-input">
				<input type="text" name="promocode" placeholder="Promocode field">
				</div>
				<i class="cart-promocode-form__icon"></i>
			</form>
			</div>
		</div>
		</div>
	</div>
	</div>
	<!-- not empty end -->
</div>

<div class="cart-sticky-checkout hidden-desktop">
  <a href="/checkout/" class="btn-primary cart-checkout <?php if(!is_user_logged_in(  )):?>noAuth<?php endif;?>">
    Checkout
    <span class="icon icon-dot-white"></span>
    <?php wc_cart_totals_order_total_html(); ?>
  </a>  
</div>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		//do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

<?php if(is_user_logged_in()): ?>
<?php get_template_part( 'template-parts/section', 'related', ['type' => 'visited'] ); ?>
<?php endif;?>
