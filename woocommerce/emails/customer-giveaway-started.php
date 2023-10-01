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
                The wait is over!
                </td>
            </tr>
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
                >
                Thanks for participating in the <b><?php echo $campaign->post_title;?></b> campaign.
                </td>
            </tr>
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
                >
                We have just reached our campaign goal and the giveaway event goes live on:
                </td>
            </tr>
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;"
                >
                <?php echo $date;?>
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
            <tr>
                <td 
                align="left" 
                valign="top" 
                style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: bold;"
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
<?php 
do_action( 'woocommerce_email_footer', $email );
