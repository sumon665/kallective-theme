<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

//do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="cart-panel__header">
	<span class="_not-check-cart-view">Cart</span>
  <span class="_check-cart-view">Check my order</span>
	<span class="cart-panel-modal__close">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M18 6L6 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M6 6L18 18" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>            
	</span>
</div>

<?php if ( ! WC()->cart->is_empty() ) : ?>
<div class="cart-panel__body ">
	<ul class="woocommerce-mini-cart <?php echo esc_attr( $args['list_class'] ); ?> cart-panel-good-list">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php //echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php //echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="cart-panel-good">
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="cart-panel-good-left">
							<span class="product-tile__img">
							<?php echo $thumbnail; ?>
							</span>
						</a>
						<div class="cart-panel-good-info">
							<a href="<?php echo esc_url( $product_permalink ); ?>" class="cart-panel-good__name"><?php echo $product_name; ?></a>
							<div class="cart-panel-good__price">
							<?php $price = $_product->get_regular_price();
								$sale = $_product->get_sale_price();
								if($sale > 0 && !WC_Name_Your_Price_Helpers::is_nyp($_product)){
									echo "$ " . number_format($sale,2) . "<span>$ " . number_format($price,2) . "</span>";
								} else{
									echo "$ " . number_format($price,2);
								}
							?>
							</div>
							<div class="cart-panel-good__ctrs">
								<?php if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else { ?>
									<div class="control-number">
									<span class="control-number__btn _dec btnMinus" data-key="<?php echo $cart_item_key;?>" data-qty="<?php echo $cart_item['quantity']; ?>">
										<span class="icon icon-minus"></span>
									</span>
									<input type="text" value="<?php echo $cart_item['quantity']; ?>" data-key="<?php echo $cart_item_key;?>">
									<!-- <a href="/?wc-ajax=add_to_cart&add-to-cart=<?php echo $cart_item['product_id'];?>" data-quantity="1" data-product_id="<?php echo $cart_item['product_id'];?>" data-product_sku="" class="control-number__btn _inc product_type_simple add_to_cart_button ajax_add_to_cart btnPlus" >
										<span class="icon icon-plus"></span>
									</a> -->
									<span class="control-number__btn _inc" data-key="<?php echo $cart_item_key;?>" data-qty="<?php echo $cart_item['quantity']; ?>">
										<span class="icon icon-plus"></span>
									</span>
									</div>
								<?php } ?>
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove_from_cart_button cart-panel-good__remove btn-icon" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span class="icon icon-cross"></span></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_attr__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $cart_item_key ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								?>
							</div>
						</div>
					</div>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>
	</div>
	<div class="cart-panel__footer">
		<div class="cart-panel-subtotal">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action( 'woocommerce_widget_shopping_cart_total' );
			?>
		</div>
		<div class="cart-panel-checkout">
			<a href="/cart/" class="btn-primary _not-check-cart-view">Checkout</a>
			<span class="btn-secondary-outline cart-panel-modal__close _check-cart-view">It’s okay</span>
		</div>
	</div>

	<?php //do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<?php //do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>

	<?php //do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
<?php else : ?>

	<div class="cart-panel__body">
        <div class="cart-panel-empty">
          <p>Your cart is empty</p>
          <a href="/" class="btn-primary cart-panel-empty__link">Shop now</a>
        </div>
      </div>
<?php endif; ?>

<?php //do_action( 'woocommerce_after_mini_cart' ); ?>
