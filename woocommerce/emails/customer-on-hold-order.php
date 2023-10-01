<?php
/**
 * Customer on-hold order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-on-hold-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>


<!-- BODY begin-->
<tr>
	<td align="left" valign="top" style="padding: 0px 0px 40px 0px;background-color: #fff;">
	<!--[if (gte mso 9)|(IE)]>
	<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
	<tr>
	<td align="center" valign="top">
	<![endif]-->
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
		<tr>
		<td 
			align="left" 
			valign="top" 
			style="padding: 0px 6.667% 0px 6.667%;"
		>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 24px;line-height: 32px;font-weight: bold;"
				>
				<?php echo esc_html( $order->get_billing_first_name() ); ?>, thanks for your order!
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				Your order is on hold!
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				Your order number: <b><?php echo $order->get_order_number(); ?></b><br />
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				Details of your order:
				</td>
			</tr>
			<tr>
				<td
				align="left" 
				valign="top" 
				style="padding: 16px 0px 0px 0px;"
				>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php $cnt = 1;
				$items = $order->get_items();
				foreach ( $items as $item_id => $item ) :
					$product       = $item->get_product();
					$sku           = '';
					$purchase_note = '';
					$image         = '';

					if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
						continue;
					}

					if ( is_object( $product ) ) {
						$sku           = $product->get_sku();
						$purchase_note = $product->get_purchase_note();
					}

					?>
					<!-- ITEM begin -->
					<tr>
						<td
							align="center"
							valign="top"
							style="padding: 24px 0px 0px 0px;border: none;"
						>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td
								align="center"
								valign="middle"
								width="88"
								style="padding: 8px 0px 0px 0px;border: none;width: 88px;max-width: 88px;"
								>
								<table width="88" border="0" cellspacing="0" cellpadding="0" style="max-width: 88px;width: 88px;">
									<tr>
									<td>
										<a 
										href="<?php echo $product->get_permalink();?>" 
										target="_blank" 
										style="display: block; text-align: center; text-decoration: none;text-decoration: none;font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;font-weight: normal;width: 88px;"
										>
										<?php $image_id = $product->get_image_id(); ?>
										<?php $image_url = wp_get_attachment_image_url( $image_id, 'full' ); ?>
										<img 
											src="<?php echo $image_url;?>"
											alt=""
											style="display: block;max-width: 88px; max-height: 88px;width: auto; height: auto;"
											border="0"
											width="88"
										/>
										</a>
									</td>
									</tr>
								</table>
								</td>
								<td
								align="left"
								valign="top"
								style="padding: 8px 0px 0px 16px;border: none;width: auto; height: auto;"
								>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									<td 
										align="left" 
										valign="top" 
										style="padding: 0px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #999999; font-size: 16px;line-height: 24px;font-weight: normal;"
									>
									<?php $terms = get_terms([
										'taxonomy' => 'product_cat',
										'object_ids' => $product->get_id(),
										'fields' => 'names'
									]);?>
									<?php echo implode(",", $terms);?>
									</td>
									</tr>
									<tr>
									<td
										align="left" 
									valign="top" 
									style="padding: 4px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;"
									>
										<a 
										href="<?php echo $product->get_permalink();?>"
										target="_blank"
										style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;text-decoration: none;text-decoration: none;"
										><?php echo $product->get_title();?></a>
									</td>
									</tr>  
									<tr>
									<td 
										align="left" 
										valign="top" 
										style="padding: 4px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 20px;line-height: 32px;font-weight: bold;"
									>$<?php echo $product->get_price();?>
									</td>
									</tr>                                  
								</table>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<!-- ITEM end -->
					<?php if($cnt != count($items)) : ?>
					<!-- ITEM DIVIER begin -->
					<tr>
					<td
						style="border-bottom: 1px solid #E8ECEE;padding: 24px 0px 0px 0px;font-size: 1px;line-height: 1px;"
					></td>
					</tr>
					<!-- ITEM DIVIER end -->
					<?php endif;?>
					<?php $cnt ++; ?>
				<?php endforeach; ?>
				</table>
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;"
				>
				Total price: $<?php echo $order->get_total(); ?>
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 24px 0px 0px 0px;"
				>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td
					align="left" 
					valign="top" 
					style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
					>
					<b
						style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color:#9399A1; font-size: 16px;line-height: 24px;font-weight: bold;"
					>Address:</b> <?php echo $order->get_formatted_shipping_address(); ?>
					</td>
				</tr>
				<tr>
					<td
					align="left" 
					valign="top" 
					style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
					>
					<b
						style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color:#9399A1; font-size: 16px;line-height: 24px;font-weight: bold;"
					>Payment Method:</b> <?php echo $order->get_payment_method_title();?>
					</td>
				</tr>
				<tr>
					<td
					align="left" 
					valign="top" 
					style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
					>
					<b
						style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color:#9399A1; font-size: 16px;line-height: 24px;font-weight: bold;"
					>Recipient:</b> <?php echo $order->get_billing_first_name(); ?> <?php echo $order->get_billing_last_name(); ?>
					</td>
				</tr>
				<tr>
					<td
					align="left" 
					valign="top" 
					style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
					>
					<b
						style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color:#9399A1; font-size: 16px;line-height: 24px;font-weight: bold;"
					>E-mail</b> <?php echo $order->get_billing_email(); ?>
					</td>
				</tr>
				<tr>
					<td
					align="left" 
					valign="top" 
					style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
					>
					<b
						style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color:#9399A1; font-size: 16px;line-height: 24px;font-weight: bold;"
					>Phone number:</b> <?php echo $order->get_billing_phone(); ?>
					</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				If you found an issue, please, contact us to resolve it!<br />
				<a 
					href="mailto:hello@thekallective.com"
					target="_blank"
					style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #E63946; font-size: 16px;line-height: 24px;font-weight: bold;text-decoration: underline;"
				>hello@thekallective.com</a>
				</td>
			</tr>
			</table>
		</td>
		</tr>
	</table>
	<!--[if (gte mso 9)|(IE)]>
	</td>
	</tr>
	</table>
	<![endif]-->
	</td>
</tr>
<!-- BODY end-->
<?php 
do_action( 'woocommerce_email_footer', $email );
