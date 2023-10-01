<?php 

function kallective_form_field( $key, $args, $value = null ) {
	$defaults = array(
		'type'              => 'text',
		'label'             => '',
		'description'       => '',
		'placeholder'       => '',
		'maxlength'         => false,
		'required'          => false,
		'autocomplete'      => false,
		'id'                => $key,
		'class'             => array(),
		'label_class'       => array(),
		'input_class'       => array(),
		'return'            => false,
		'options'           => array(),
		'custom_attributes' => array(),
		'validate'          => array(),
		'default'           => '',
		'autofocus'         => '',
		'priority'          => '',
		'data_class'        => ''
	);

	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

	$required = '';
	if ( $args['required'] ) {
		$args['class'][] = 'validate-required';
		$required        = ' <span class="asterisk">*</span>';
	} 

	if ( is_string( $args['label_class'] ) ) {
		$args['label_class'] = array( $args['label_class'] );
	}

	if ( is_null( $value ) ) {
		$value = $args['default'];
	}

	// Custom attribute handling.
	$custom_attributes         = array();
	$args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

	if ( $args['maxlength'] ) {
		$args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
	}

	if ( ! empty( $args['autocomplete'] ) ) {
		$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
	}

	if ( true === $args['autofocus'] ) {
		$args['custom_attributes']['autofocus'] = 'autofocus';
	}

	if ( $args['description'] ) {
		$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
	}

	if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
		foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
			$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
		}
	}

	if ( ! empty( $args['validate'] ) ) {
		foreach ( $args['validate'] as $validate ) {
			$args['class'][] = 'validate-' . $validate;
		}
	}

	$field           = '';
	$label_id        = $args['id'];
	$sort            = $args['priority'] ? $args['priority'] : '';
	$field_container = '<div class="' . (($args['type'] == 'country') ? 'control-select' : 'control-input') . '" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';

	switch ( $args['type'] ) {
		case 'country':
			$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

			if ( 1 === count( $countries ) ) {

				$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

				$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

			} else {

				$field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="default">' . esc_html__( 'Select a country / region&hellip;', 'woocommerce' ) . '</option>';

				foreach ( $countries as $ckey => $cvalue ) {
					$field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
				}

				$field .= '</select>';

				$field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country / region', 'woocommerce' ) . '">' . esc_html__( 'Update country / region', 'woocommerce' ) . '</button></noscript>';

			}

			break;
		case 'state':
			/* Get country this state field is representing */
			$for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
			$states      = WC()->countries->get_states( $for_country );

			if ( is_array( $states ) && empty( $states ) ) {

				$field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

				$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

			} elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

				$field_container = '<div class="control-select" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';

				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'woocommerce' ) ) . '"  data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '">
					<option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';

				foreach ( $states as $ckey => $cvalue ) {
					$field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
				}

				$field .= '</select>';

			} else {

				$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

			}

			break;
		case 'textarea':
			$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

			break;
		case 'checkbox':
			$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
					<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

			break;
		case 'text':
		case 'password':
		case 'datetime':
		case 'datetime-local':
		case 'date':
		case 'month':
		case 'time':
		case 'week':
		case 'number':
		case 'email':
		case 'url':
		case 'tel':
			$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

			break;
		case 'hidden':
			$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-hidden ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

			break;
		case 'select':
			$field   = '';
			$options = '';

			if ( ! empty( $args['options'] ) ) {
				foreach ( $args['options'] as $option_key => $option_text ) {
					if ( '' === $option_key ) {
						// If we have a blank option, select2 needs a placeholder.
						if ( empty( $args['placeholder'] ) ) {
							$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
						}
						$custom_attributes[] = 'data-allow_clear="true"';
					}
					$options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_html( $option_text ) . '</option>';
				}

				$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
						' . $options . '
					</select>';
			}

			break;
		case 'radio':
			$label_id .= '_' . current( array_keys( $args['options'] ) );

			if ( ! empty( $args['options'] ) ) {
				foreach ( $args['options'] as $option_key => $option_text ) {
					$field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
					$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . esc_html( $option_text ) . '</label>';
				}
			}

			break;
	}

	if ( ! empty( $field ) ) {
		$field_html = '';

		if ( $args['label'] && 'checkbox' !== $args['type'] ) {
			$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="control-label ' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . wp_kses_post( $args['label'] ) . $required . '</label>';
		}

		$field_html .= '<span class="woocommerce-input-wrapper">' . $field;

		if ( $args['description'] ) {
			$field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
		}

		$field_html .= '</span>';

		$container_class = esc_attr( implode( ' ', $args['class'] ) );
		$container_id    = esc_attr( $args['id'] ) . '_field';
		$field           = sprintf( $field_container, $container_class, $container_id, $field_html );
	}

	/**
	 * Filter by type.
	 */
	$field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

	/**
	 * General filter on form fields.
	 *
	 * @since 3.4.0
	 */
	$field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

	if ( $args['return'] ) {
		return $field;
	} else {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $field;
	}
}

add_filter( 'woocommerce_checkout_fields', 'kallective_remove_fields', 9999 );
 
function kallective_remove_fields( $woo_checkout_fields_array ) {
 
	// she wanted me to leave these fields in checkout
	//unset( $woo_checkout_fields_array['billing']['billing_first_name'] );
	$woo_checkout_fields_array['billing']['billing_first_name']['label'] = __( 'Name', 'woocommerce' );
	$woo_checkout_fields_array['billing']['billing_first_name']['placeholder'] = __( 'Enter your name here', 'woocommerce' );
	unset( $woo_checkout_fields_array['billing']['billing_last_name'] );
	$woo_checkout_fields_array['billing']['billing_phone']['label'] = __( 'Phone number', 'woocommerce' );
	$woo_checkout_fields_array['billing']['billing_phone']['placeholder'] = __( 'Enter your phone number', 'woocommerce' );
	// unset( $woo_checkout_fields_array['billing']['billing_email'] );
	$woo_checkout_fields_array['billing']['billing_email']['placeholder'] = __( 'Enter your e-mail here', 'woocommerce' );
	unset( $woo_checkout_fields_array['order']['order_comments'] ); // remove order notes
	unset( $woo_checkout_fields_array['billing']['billing_company'] ); // remove company field
	unset( $woo_checkout_fields_array['billing']['billing_country'] );
	unset( $woo_checkout_fields_array['billing']['billing_address_1'] );
	unset( $woo_checkout_fields_array['billing']['billing_address_2'] );
	unset( $woo_checkout_fields_array['billing']['billing_city'] );
	unset( $woo_checkout_fields_array['billing']['billing_state'] ); // remove state field
	unset( $woo_checkout_fields_array['billing']['billing_postcode'] ); // remove zip code field

	unset( $woo_checkout_fields_array['shipping']['shipping_first_name'] );
	unset( $woo_checkout_fields_array['shipping']['shipping_last_name'] );
	unset( $woo_checkout_fields_array['shipping']['shipping_company'] );

	$woo_checkout_fields_array['shipping']['shipping_address_1']['placeholder'] = __( 'Enter your address here', 'woocommerce' );
	$woo_checkout_fields_array['shipping']['shipping_address_2']['label'] = __( 'Apartment, suite, unit, etc.', 'woocommerce' );
	$woo_checkout_fields_array['shipping']['shipping_address_2']['placeholder'] = __( 'Enter your apartment / suite / unit here', 'woocommerce' );
	$woo_checkout_fields_array['shipping']['shipping_city']['placeholder'] = __( 'Enter your town / city', 'woocommerce' );
	return $woo_checkout_fields_array;
}

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );
add_action( 'after_setup_theme', function() {
	add_theme_support( 'woocommerce' );
} );

add_filter( 'woocommerce_payment_complete_order_status', 'kallective_on_order_placed', 10, 3 );
function kallective_on_order_placed( $status, $order_id, $order ){
	if(!file_exists(ABSPATH . 'script/config.php') || !file_exists(ABSPATH . 'script/hubx_connect.php')) return $status;
	$config = include ABSPATH . 'script/config.php';
	require_once ABSPATH . 'script/hubx_connect.php';
	$details = [];
	foreach ($order->get_items() as $item) {
		$sku = get_post_meta($item['product_id'], '_sku', true);
		if(strpos($sku,'HUBX') === false) continue;
		file_put_contents(ABSPATH . 'hubx-log.txt', $sku, FILE_APPEND);
		$product = wc_get_product($item['product_id']);
		$details[] = [
			'VendorPartNumber' => str_replace($config["sku_prefix"], "", $sku),
			'UnitOfMeasure' => 'Each',
			'Quantity' => $item['quantity'],
			'UnitPrice' => $product->get_price()
		];
	}
	if(!count($details)) return $status;
	$access_token = getAccessToken($config['getTokenAPI'], [
        "client_id" => $config['client_id'],
        "client_secret" => $config['client_secret'],
        "grant_type" => $config['grant_type'],
    ]);
	$order = [
		'billingAddressCode' => $config['billingAddressCode'],
		'shippingAddressCode' => $config['shippingAddressCode'],
		'PurchaseOrderNumber' => $order_id,
		'details' => $details
	];
	file_put_contents(ABSPATH . 'hubx-log.txt', print_r($order, 1), FILE_APPEND);
	$res = restRequest($access_token, 'POST', $config['orderAPI'], $order);
	file_put_contents(ABSPATH . 'hubx-log.txt', print_r($res, 1), FILE_APPEND);
	return $status;
}

function kallective_matched_cart_items( $search_products ) {
    $count = 0; // Initializing

    if ( ! WC()->cart->is_empty() ) {
        // Loop though cart items
        foreach(WC()->cart->get_cart() as $cart_item ) {
            // Handling also variable products and their products variations
            $cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);

            // Handle a simple product Id (int or string) or an array of product Ids 
            if( ( is_array($search_products) && array_intersect($search_products, cart_item_ids) ) 
            || ( !is_array($search_products) && in_array($search_products, $cart_item_ids)))
                $count++; // incrementing items count
        }
    }
    return $count; // returning matched items count 
}

add_filter( 'woocommerce_payment_complete_order_status', 'kallective_on_credits_paid', 10, 3 );
function kallective_on_credits_paid( $status, $order_id, $order ){
	$user = wp_get_current_user();
	$credits = 0;
	$membership = '';
	foreach ($order->get_items() as $item_id => $item) {
		$product = wc_get_product($item['product_id']);
		$product_credits = $product->get_meta('_fsww_credit');
		if($product_credits > 0){
			$credits += $product_credits;
			$membership = $product->get_name();
		}
	}
	if($credits > 0){
		kallective_send_mail($user->user_email, 'Wallet top up', 'emails/customer-bought-credits.php', ['credits' => $credits, 'membership' => $membership]);
	}
	return $status;
}

add_action( 'kampaign_contribution', 'kallective_kampaign_contributed', 10, 3 );
function kallective_kampaign_contributed($ID, $user_id, $amount){
	$user = wp_get_current_user();
	$campaign = get_post($ID);
	kallective_send_mail($user->user_email, 'You successfully contributed to the Campaign', 'emails/customer-contributed-campaign.php', ['amount' => $amount, 'campaign' => $campaign]);
}