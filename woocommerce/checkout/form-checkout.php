<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

?>
<div class="cart-layout">
	<?php do_action( 'woocommerce_before_checkout_form', $checkout );
	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
	} 
	?>
	<div class="cart-layout-nav">
		<h1 class="cart-layout-nav__item" data-step="1"><a href="/cart/">Your cart</a></h1>
		<i class="cart-layout-nav__space visible-desktop"></i>
		<h2 class="cart-layout-nav__item active" data-step="2">Delivery</h2>
		<i class="cart-layout-nav__space visible-desktop"></i>
		<h3 class="cart-layout-nav__item">Order is processed</h3>
	</div>
	<div class="cart-layout-body">
	<div class="cart-step active" data-step="2">
		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		
		<div class="cart-delivery">
			<h3 class="cart-delivery-label">Contacts</h3>
			
			<?php 
			$fields = $checkout->get_checkout_fields( 'billing' );
			foreach ( $fields as $key => $field ) { ?>
				<div class="cart-delivery-row">
					<?php kallective_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				</div>
			<?php } ?>
			<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="ship_to_different_address" value="1" hidden type="hidden"/> 
			<h3 class="cart-delivery-label">Address</h3>
			<?php $fields = $checkout->get_checkout_fields( 'shipping' );
			foreach ( $fields as $key => $field ) { ?>
				<div class="cart-delivery-row">
					<?php kallective_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				</div>
			<?php } ?>
			<h3 class="cart-delivery-label">Payment</h3>
			<?php if ( ! is_ajax() ) {
				do_action( 'woocommerce_review_order_before_payment' );
			}
			?>
			<div id="payment" class="woocommerce-checkout-payment">
				<?php if ( WC()->cart->needs_payment() ) : ?>
						<?php
						if ( ! empty( $available_gateways ) ) {
							foreach ( $available_gateways as $gateway ) {
								wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
							}
						} else {
							echo '<div class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</div>'; // @codingStandardsIgnoreLine
						}
						?>
				<?php endif; ?>
				<div class="form-row place-order">
					<noscript>
						<?php
						/* translators: $1 and $2 opening and closing emphasis tags respectively */
						printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
						?>
						<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
					</noscript>

					<?php wc_get_template( 'checkout/terms.php' ); ?>

					<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

					<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

					<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

					<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
				</div>
			</div>
			<?php
			if ( ! is_ajax() ) {
				do_action( 'woocommerce_review_order_after_payment' );
			} ?>
			</div>
		</div>
		<div class="cart-layout-sticky " data-step-active="2">
			<div class="cart-summary _checkout"> 
			<div id="order_review" class="shop_table woocommerce-checkout-review-order-table"><?php do_action( 'woocommerce_checkout_order_review' ); ?></div>
				<div class="cart-summary-ctrls">
					<div class="cart-summary-ctrls-step _step-2">
						<div class="_desktop-down-buttons">
							<button class="btn-primary cart-summary-ctrls__item cart-delivery-place-order hidden-desktop">
                <span class="btn-label">Place Order</span>
                <span class="icon icon-spinner"></span>
              </button>
							<button type="button" class="btn-secondary-outline cart-summary-ctrls__item open-cart-panel" data-check-cart-view="1">Check my cart</button>
						</div>
						<div class="cart-promocode-form" id="cart-promocode-form"> <!-- '_success _error' classes for states-->
							<div class="control-input">
							<input type="text" name="promocode" placeholder="Enter Coupon Code Here" id="promoInp" value="">
							</div>
							<span class="cart-promocode-form__apply" id="promoApply">Apply</span>
							<i class="cart-promocode-form__icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
