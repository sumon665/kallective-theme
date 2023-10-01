<?php

function kallective_waitlist_option($array){
    $array['waitaccess'] = array(
        'id'            => '_waitaccess',
        'wrapper_class' => 'show_if_simple',
        'label'         => __( 'Wait Access', 'woocommerce' ),
        'description'   => __( 'Wait Access product is for waitlist pricing.', 'woocommerce' ),
        'default'       => 'no',
    );
    return $array;
}
add_filter( 'product_type_options', 'kallective_waitlist_option' );

function kallective_save_waitlist_meta($product){
    if ( isset( $_POST['_waitaccess'] ) && in_array( $product->get_type(), ['simple'] ) ) {
        $product->update_meta_data( '_waitaccess', 'yes' );
        $product->set_sale_price( '' );
    } else {
        $product->update_meta_data( '_waitaccess', 'no' );
    }
}
add_action( 'woocommerce_admin_process_product_object', 'kallective_save_waitlist_meta' );

function kallective_is_waitlist_access($product){
    if($product && $product->get_meta('_waitaccess') == 'yes') return true;
    return false;
}

function plugin_republic_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
    if( isset( $_POST['wait-product'] ) ) {
        $cart_item_data['wait-product'] = sanitize_text_field( $_POST['wait-product'] );
    }
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'plugin_republic_add_cart_item_data', 10, 3 );

function kallective_waitlist_get_item_data( $item_data, $cart_item_data ) {
    if( isset( $cart_item_data['wait-product'] ) ) {
        $product = wc_get_product($cart_item_data['wait-product']);
        $item_data[] = array(
            'key' => 'Product',
            'value' => '<a href="' . $product->get_permalink() . '">' . $product->get_title() . '</a>'
        );
    }
    return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'kallective_waitlist_get_item_data', 10, 2 );

add_action( 'woocommerce_add_order_item_meta', function ( $itemId, $values, $key ) {
    if ( isset( $values['wait-product'] ) ) {
        wc_add_order_item_meta( $itemId, 'wait-product', $values['wait-product'] );
    }
}, 10, 3 );

function kallective_on_waitlist_paid( $status, $order_id, $order ){
    $user = wp_get_current_user();
    $waitlist_ids = [];
	foreach ($order->get_items() as $item_id => $item) {
		$product = wc_get_product($item['product_id']);
        if(kallective_is_waitlist_access($product)){
            $wait_product = wc_get_order_item_meta($item_id, 'wait-product', true);
            $user_waitlist = get_field('waitlist', 'user_' . $user->ID);
            $user_waitlist = $user_waitlist ? json_decode($user_waitlist, true) : [];
            $user_waitlist[] = [
                'product' => $wait_product,
                'availible_at' => '0'
            ];
            update_field('waitlist', json_encode($user_waitlist), 'user_' . $user->ID);
            $waitlist_ids[] = $wait_product;
        } 
        if(get_field('waitlist', $item['product_id'])){
            $waitlist = get_field('waitlist', 'user_' . $user->ID);
            if($waitlist) {
                $waitlist = json_decode($waitlist, true);
                foreach($waitlist as $k => &$p){
                    if($p['product'] == $item['product_id']) $p['bought'] = 1;
                }
                update_field('waitlist', json_encode($waitlist), 'user_' . $user->ID);
            }
        }
	}
    if(count($waitlist_ids)){
        kallective_send_mail($user->user_email, 'Product(s) added to waitlist', 'emails/customer-waitlist-added-email.php', ['products' => $waitlist_ids]);
    }
	return $status;
}
add_filter( 'woocommerce_payment_complete_order_status', 'kallective_on_waitlist_paid', 10, 3 );

function kallective_remove_waitlist(){
	$good_id = intval($_POST['good_id']);
	$user_id = get_current_user_id();
	$waitlist = get_field('waitlist', 'user_' . $user_id);
    if($waitlist) {
		$waitlist = json_decode($waitlist, true);
		foreach($waitlist as $k => $p){
			if($p['product'] == $good_id) unset($waitlist[$k]);
		}
        update_field('waitlist', json_encode($waitlist), 'user_' . $user_id);
	}
}
add_action( 'wp_ajax_kallective_remove_waitlist', 'kallective_remove_waitlist' );

add_action( 'woocommerce_product_object_updated_props', 'kallective_on_waitlist_stock_update', 10, 2 );
function kallective_on_waitlist_stock_update( $product, $updated_props ){
	if(get_field('waitlist', $product->get_id()) && !empty($updated_props) && in_array('stock_status', $updated_props) && $product->is_in_stock()){
        $users = get_users([
            'meta_key'     => 'waitlist',
            'meta_compare' => 'EXISTS',
        ]);
        foreach($users as $user){
            $waitlist = get_field('waitlist', 'user_' . $user->ID);
            if($waitlist) {
                $waitlist = json_decode($waitlist, true);
                $avail_ids = [];
                foreach($waitlist as $k => &$p){
                    if($p['product'] == $product->get_id() && !$p['availible_at']){
                        $p['availible_at'] = time();
                        $avail_ids[] = $product->get_id();
                    }
                }
                if(count($avail_ids)){
                    kallective_send_mail($user->user_email, 'Product from waitlist is availible', 'emails/customer-waitlist-availible-email.php', ['products' => $avail_ids]);
                    update_field('waitlist', json_encode($waitlist), 'user_' . $user->ID);
                }
            }
        }
    }
}

function kallective_is_product_in_waitlist($product_id){
    $in_waitlist = false;
    $user = wp_get_current_user();
    $waitlist = get_field('waitlist', 'user_' . $user->ID);
    if($waitlist) {
        $waitlist = json_decode($waitlist, true);
        foreach($waitlist as $k => &$p){
            if($p['product'] == $product_id){
                $in_waitlist = true;
                break;
            }
        }
    }
    return $in_waitlist;
}

add_action( 'admin_head', 'cron_activation' );
function cron_activation() {
	if( ! wp_next_scheduled( 'kallective_daily_event' ) ) {
		wp_schedule_event( time(), 'daily', 'kallective_daily_event');
	}
}

add_action( 'kallective_daily_event', 'kallective_remind_waitlist' );
function kallective_remind_waitlist(){
    $users = get_users([
        'meta_key'     => 'waitlist',
        'meta_compare' => 'EXISTS',
    ]);
    foreach($users as $user){
        $waitlist = get_field('waitlist', 'user_' . $user->ID);
        if($waitlist) {
            $waitlist = json_decode($waitlist, true);
            foreach($waitlist as $k => &$p){
                if($p['availible_at'] && !isset($p['notified_at']) && !isset($p['bought'])){
                    $now = new DateTime();
                    $date_avail = new DateTime();
                    $date_avail->setTimestamp($p['availible_at']);
                    $interval = date_diff($now, $date_avail);
                    if($interval->days == 14){
                        kallective_send_mail($user->user_email, 'Product from waitlist is still availible', 'emails/customer-waitlist-still-availible-email.php', ['products' => [$p['product']]]);
                        $p['notified_at'] = time();
                    }
                }
            }
            update_field('waitlist', json_encode($waitlist), 'user_' . $user->ID);
        }
    }
}