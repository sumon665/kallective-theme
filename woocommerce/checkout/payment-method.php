<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<label class="control-radio">
<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" data-id="<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
<i class="control-radio__icon">
	<i></i>
</i>
<span class="control-radio__label">
	<img src="<?php echo get_template_directory_uri();?>/img/icons/payment_<?php echo esc_attr( $gateway->id ); ?>.svg" width="41" height="24" alt="<?php echo $gateway->get_title();?>">
</span>
</label>
<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
	<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?> payment_method_desc <?php echo !$gateway->chosen ? "hidden" : "";?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
    <?php $gateway->payment_fields(); ?>
    <p class="_cvc-hint">*CVC code is the three numbers on the back of the card</p>
	</div>
<?php endif; ?>
