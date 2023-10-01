<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

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
				Forgot your password?
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				No worries, we all forget our passwords sometimes.
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				Click the link below and create a new password for your account.
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #E63946; font-size: 16px;line-height: 24px;font-weight: bold;"
				>
				<a  href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>"
					target="_blank"
					style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #E63946; font-size: 16px;line-height: 24px;font-weight: bold; word-break: break-all;"
				><?php // phpcs:ignore ?>
					<?php esc_html_e( 'Click here to reset your password', 'woocommerce' ); ?>
				</a>
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
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
?>


