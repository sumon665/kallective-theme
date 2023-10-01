<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
                We are glad to be interesting for you!
                </td>
            </tr>
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
                >
                We will check your request and contact you shortly.
                </td>
            </tr>
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 16px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;"
                >
                Thank you!
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
<?php do_action( 'woocommerce_email_footer', $email );