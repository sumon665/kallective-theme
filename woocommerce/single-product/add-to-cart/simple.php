<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$fav_ids = get_field('favourites', get_current_user_id());
$fav = array_diff(explode(";", $fav_ids), ['']);
if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	
	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<div class="product-details__actions">
		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		/*woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);*/

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		<input type="hidden" name="product_id" class="product_id" value="<?php echo $product->get_id();?>">
		<input type="hidden" name="qty" class="qty" value="1">
		<button type="button" class="btn-primary product-details__actions-cart ajax_add_to_cart">
			<span class="btn-label">Add to cart</span>
			<span class="icon icon-spinner"></span>
		</button>
		<button type="button" class="product-details__actions-favorites details toggleFav <?php if(!is_user_logged_in()) echo 'noAuth'; ?> <?php if(in_array($product->get_id(), $fav)) echo "_favorite";?>" data-id="<?php echo $product->get_id();?>">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M20.84 4.60987C20.3292 4.09888 19.7228 3.69352 19.0554 3.41696C18.3879 3.14039 17.6725 2.99805 16.95 2.99805C16.2275 2.99805 15.5121 3.14039 14.8446 3.41696C14.1772 3.69352 13.5708 4.09888 13.06 4.60987L12 5.66987L10.94 4.60987C9.9083 3.57818 8.50903 2.99858 7.05 2.99858C5.59096 2.99858 4.19169 3.57818 3.16 4.60987C2.1283 5.64156 1.54871 7.04084 1.54871 8.49987C1.54871 9.95891 2.1283 11.3582 3.16 12.3899L4.22 13.4499L12 21.2299L19.78 13.4499L20.84 12.3899C21.351 11.8791 21.7563 11.2727 22.0329 10.6052C22.3095 9.93777 22.4518 9.22236 22.4518 8.49987C22.4518 7.77738 22.3095 7.06198 22.0329 6.39452C21.7563 5.72706 21.351 5.12063 20.84 4.60987V4.60987Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>                        
		</button>
		</div>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
