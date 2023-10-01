<?php 

add_filter('woocommerce_account_menu_item_classes', 'kallective_account_menu_item_classes', 10, 2);
function kallective_account_menu_item_classes($classes, $endpoint){
	if(in_array('is-active', $classes)) $classes[] = "active";
	return $classes;
}

add_filter ( 'woocommerce_account_menu_items', 'kallective_remove_my_account_links' );
function kallective_remove_my_account_links( $menu_links ){
	
	unset( $menu_links['edit-address'] ); // Addresses
	unset( $menu_links['payment-methods'] ); // Payment Methods
	unset( $menu_links['edit-account'] ); // Account details
	
	$new_links = [];
	$new_links['orders'] = __('My orders', 'kallective');
	$new_links['favorites'] = __('Favorites', 'kallective');
	$new_links['dashboard'] = __('My Profile', 'kallective');
	$new_links['personal-recomendations'] = __('Personal recommendations', 'kallective');
	$new_links['memberships'] = __('Memberships', 'kallective');
	$new_links['waitlist'] = __('Waitlist', 'kallective');
	$new_links['customer-raffles'] = __('Raffles Dashboard', 'kallective');
	$new_links['customer-wallet'] = __('Credits', 'kallective');
	$new_links['campaigns'] = __('Campaigns', 'kallective');
	$new_links['customer-logout'] = __('Logout', 'kallective');
	return $new_links;
}

add_action( 'init', 'kallective_add_endpoint' );
function kallective_add_endpoint() {
	add_rewrite_endpoint( 'favorites', EP_PAGES );
	add_rewrite_endpoint( 'personal-recomendations', EP_PAGES );
	add_rewrite_endpoint( 'memberships', EP_PAGES );
	add_rewrite_endpoint( 'waitlist', EP_PAGES );
	add_rewrite_endpoint( 'customer-raffles', EP_PAGES );
	add_rewrite_endpoint( 'customer-wallet', EP_PAGES );
	add_rewrite_endpoint( 'campaigns', EP_PAGES );
}
add_action( 'woocommerce_account_favorites_endpoint', 'kallective_favorites_endpoint_content' );
function kallective_favorites_endpoint_content() {
	echo get_template_part( 'template-parts/account', 'favorites' );
}

add_action( 'woocommerce_account_personal-recomendations_endpoint', 'kallective_recommendations_endpoint_content' );
function kallective_recommendations_endpoint_content() {
	echo get_template_part( 'template-parts/account', 'recommendations' );
}

add_action( 'woocommerce_account_memberships_endpoint', 'kallective_memberships_endpoint_content' );
function kallective_memberships_endpoint_content() {
	echo get_template_part( 'template-parts/account', 'memberships' );
}

add_action( 'woocommerce_account_waitlist_endpoint', 'kallective_waitlist_endpoint_content' );
function kallective_waitlist_endpoint_content() {
	$waitlist = get_field('waitlist', 'user_' . get_current_user_id( ));
	$product_ids = [];
	if($waitlist) {
		$waitlist = json_decode($waitlist, true);
		foreach($waitlist as $p){
			if(!$p['bought'] && !in_array($p['product'], $products)) $product_ids[] = $p['product'];
		}
	}
	$products = [];
	if(!empty($product_ids)){
		$args = array( 
			'post_type'      => 'product' ,
			'post_status'    => 'publish' ,
			'posts_per_page' => -1 ,
			'fields'         => 'ids',
			'post__in'  => $product_ids ,
			'meta_key' => 'waitlist',
			'meta_value' => 1,
		);
		$products = get_posts($args);
	}
	echo get_template_part( 'template-parts/account', 'waitlist', ['products' => $products] );
}

add_action( 'woocommerce_account_customer-raffles_endpoint', 'kallective_raffles_endpoint_content' );
function kallective_raffles_endpoint_content() {
	$product_ids = lty_get_my_lotteries( get_current_user_id() , array( 'lty_ticket_buyer' , 'lty_ticket_winner' ) ) ;
	$args = array( 
		'post_type'      => 'product' ,
		'post_status'    => 'publish' ,
		'posts_per_page' => -1 ,
		'fields'         => 'ids',
		'post__in'  => $product_ids ,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_type' ,
				'field'    => 'name' ,
				'terms'    => 'lottery' ,
			)
		),
	);
	$lotteries = get_posts($args);
	echo get_template_part( 'template-parts/account', 'raffles', ['lotteries' => $lotteries]);
}

add_action( 'woocommerce_account_customer-wallet_endpoint', 'kallective_wallet_endpoint_content' );
function kallective_wallet_endpoint_content(){
	global $wpdb;
	$user_id = get_current_user_id();
	if (class_exists('Wallet')){
		$balance = Wallet::get_balance($user_id);
	}
	$args = "WHERE user_id={$user_id}";
	$transactions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fswcwallet_transaction {$args} ORDER BY transaction_id DESC");
	echo get_template_part( 'template-parts/account', 'wallet', ['transactions' => $transactions, 'balance' => $balance]);
}

add_action( 'woocommerce_account_campaigns_endpoint', 'kallective_campaigns_endpoint_content' );
function kallective_campaigns_endpoint_content() {
	global $wpdb;
	$user_id = get_current_user_id();
	$campaigns = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}kontributions WHERE `user_id`={$user_id}");
	echo get_template_part( 'template-parts/account', 'campaigns', ['campaigns' => $campaigns]);
}