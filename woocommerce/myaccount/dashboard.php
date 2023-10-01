<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly.
}

$allowed_html = array(
'a' => array(
'href' => array(),
),
);
$current_user = wp_get_current_user();
$current_first_name = $current_user->first_name;
$current_last_name  = $current_user->last_name;
if(!$current_first_name){
	list($current_first_name, $current_last_name) = explode(" ", $current_user->user_nicename);
}
$current_email = $current_user->user_email;
?>

<h1 class="cabinet-layout__content-title visible-desktop">My Profile</h1>
<div class="cabinet-profile">
	<div class="cabinet-profile-row">
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">First Name</div>
		<div class="cabinet-profile-col__value"><?php echo $current_first_name;?></div>
	</div>
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">Last Name</div>
		<div class="cabinet-profile-col__value"><?php echo $current_last_name;?></div>
	</div>
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">Date of Birth</div>
		<div class="cabinet-profile-col__value">
			<?php 
			$date = date_create(get_field('birthday', $current_user->ID));
			echo date_format($date, 'm.d.Y'); 
			?>
		</div>
	</div>
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">Email</div>
		<div class="cabinet-profile-col__value"><?php echo $current_user->user_email;?></div>
	</div>
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">Phone Number</div>
		<div class="cabinet-profile-col__value"><?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?></div>
	</div>
	<div class="cabinet-profile-col">
		<div class="cabinet-profile-col__label">Current Password</div>
		<div class="cabinet-profile-col__value">*******</div>
	</div>
	</div>
	<div>
	<span class="btn-secondary-outline icon-left cabinet-profile__edit open-modal" data-modal="#profile-edit-modal">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
		Edit Information
	</span>
	</div>
</div>
<div class="profile-delivery-address">
	<h2 class="profile-delivery-address__title">Delivery Address</h2>
	<ul class="profile-delivery-address-list">
	<?php if(get_user_meta($current_user->ID, 'shipping_city', true)): ?>
	<li class="profile-delivery-address-item">
		<span class="profile-delivery-address-item__edit open-modal" data-modal="#address-modal">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="#1D3557" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>                      
		</span>
		<div class="profile-delivery-address-item__label">My address</div>
		<p class="profile-delivery-address-item__value">
			<?php echo get_user_meta($current_user->ID, 'shipping_address_2', true); ?> 
			<?php echo get_user_meta($current_user->ID, 'shipping_address_1', true); ?> 
			<?php echo get_user_meta($current_user->ID, 'shipping_city', true); ?>, 
			<?php echo get_user_meta($current_user->ID, 'shipping_state', true); ?> 
			<?php echo get_user_meta($current_user->ID, 'shipping_postcode', true); ?>
		</p>
	</li>
	<?php else: ?>
	<li class="profile-delivery-address-item">
		<div class="profile-delivery-address-item__add open-modal" data-modal="#address-modal">
		<i class="icon icon-plus"></i>Add address
		</div>
	</li>
	<?php endif;?>
	</ul>
</div>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

get_template_part( 'template-parts/modal', 'user' );
get_template_part( 'template-parts/modal', 'address' );
