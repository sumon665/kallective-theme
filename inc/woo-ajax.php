<?php

add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );
add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );

function bodycommerce_ajax_add_to_cart_woo_callback() {

	ob_start();

	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	// $product_quantity = $_POST['product_quantity'];
	$variation_id = $_POST['variation_id'];
	$variation  = $_POST['variation'];


	error_log("Variation Product", 0);
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation  );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
			wc_add_to_cart_message( $product_id );
		}
		// Return fragments
		WC_AJAX::get_refreshed_fragments();
	}  else  {
		// $this->json_headers(); // REMOVED AS WAS THROWING AN ERROR

		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
			'error' => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id  )
		);
		echo json_encode( $data );
	}

	die();
}

add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
function bodycommerce_ajax_add_to_cart_woo_single_callback() {
	ob_start();
	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
	error_log("Simple Product", 0);
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity  ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
		wc_add_to_cart_message( $product_id );
		}

		// Return fragments
		WC_AJAX::get_refreshed_fragments();
	}  else  {

		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
			'error' => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
		);
		echo json_encode( $data );
	}

	die();
}

add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
	$fragments['span._count.header-cart-count'] = '<span class="_count header-cart-count ' . (WC()->cart->get_cart_contents_count() ===0 ? "hidden" : "") .  '">' . WC()->cart->get_cart_contents_count() . '</span>';
	$fragments['div.widget_shopping_cart_content'] = str_replace('class="widget_shopping_cart_content"', 'class="widget_shopping_cart_content cart-panel"', $fragments['div.widget_shopping_cart_content']);
    return $fragments;
}

add_action('wp_ajax_update_cart_quantity', 'update_cart_quantity');
add_action('wp_ajax_nopriv_update_cart_quantity', 'update_cart_quantity');
function update_cart_quantity(){
	global $woocommerce;
	$cartKeySanitized = filter_var($_POST['cart_item_key'], FILTER_SANITIZE_STRING);
	$cartQtySanitized = filter_var($_POST['cart_item_qty'], FILTER_SANITIZE_STRING);
	$item = $woocommerce->cart->get_cart_item($cartKeySanitized);
	$_product =  wc_get_product( $item['product_id'] ); 
	$max_qty = $_product->get_max_purchase_quantity();
	if($item['variation_id']){
		$_variation = wc_get_product($item['variation_id']);
		$max_qty = $_variation->get_max_purchase_quantity();
	}
	$data = [
		'result' => 'success',
	];
	if($max_qty >= $cartQtySanitized || $max_qty == -1){
		ob_start();
		$woocommerce->cart->set_quantity($cartKeySanitized,$cartQtySanitized);
		ob_get_clean();
	} else {
		$data = [
			'result' => 'error',
			'message' => 'Sorry, we do not have enough "' . $_product->get_name() . '" in stock to fulfill your order (' . $max_qty . ' available). We apologize for any inconvenience caused.',
			'qty' => $max_qty
		];
	}
	echo json_encode( $data );
	exit;
}