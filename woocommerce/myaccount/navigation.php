<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_user = wp_get_current_user();
$current_user = wp_get_current_user();
$current_first_name = $current_user->first_name;
$current_last_name  = $current_user->last_name;
if(!$current_first_name){
	$f_name = explode(" ", $current_user->user_nicename);
	$current_first_name = $f_name[0];
	$current_last_name = isset($f_name[1]) ? $f_name[1] : "";
}
$current_email      = $current_user->user_email;
do_action( 'woocommerce_before_account_navigation' );
?>
<div class="cabinet-layout__menu">
	<div class="cabinet-user">
		<div class="cabinet-user__name"><?php echo $current_first_name . " " . $current_last_name; ?></div>
		<div class="cabinet-user__contacts">
			<span><?php echo $current_user->user_email;?></span>
			<span><?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?></span>
		</div>
	</div> 
	<div class="cabinet-nav-wrap">
		<div class="cabinet-nav">
			<div class="cabinet-nav__toggle hidden-desktop">My Profile</div>
			<ul class="cabinet-nav__list">
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<?php if($endpoint == 'members-area' || $endpoint == 'wc-smart-coupons') continue; ?>
					<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" >
							<?php if($endpoint == 'customer-logout') : ?>
							<i class="icon icon-logout"></i>
							<?php endif;?>
							<?php echo esc_html( $label ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php do_action( 'woocommerce_after_account_navigation' ); ?>