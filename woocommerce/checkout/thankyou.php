<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="thanks-section">
	<div class="wrapper">
		<div class="thanks-layout">
		<div class="thanks-layout__txt">
			<h1>Thank you for order!</h1>
			<p>You will get a track number to your e-mail.</p>
			<a href="/" class="btn-primary">Back to catalog</a>
		</div>
		<div class="thanks-layout__img">
			<img src="<?php echo get_template_directory_uri();?>/img/icons/logo-mini.svg" width="128" height="96" alt="logo">
		</div>
		</div>
	</div>
</section>
