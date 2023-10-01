<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
?>

            <!-- FOOTER begin-->
            <tr>
              <td align="left" valign="top" style="padding: 40px 0px 0px 0px">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                <td align="center" valign="top">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fff;" class="wrapper">
                  <tr>
                    <td align="center" valign="top" style="padding: 40px 6.667% 40px 6.667%;">
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper">
                        <tr>
                          <td 
                            align="center" 
                            valign="top" 
                            style="padding: 0px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;text-align: center;"
                          >
                            Any questions? Contact us!
                          </td>
                        </tr>
                        <tr>
                          <td 
                            align="center" 
                            valign="top" 
                            style="padding: 0px 0px 0px 0px;text-align: center;font-family: Helvetica, Arial, sans-serif; color: #E63946; font-size: 16px;line-height: 24px;font-weight: bold;"
                          >
                            <a 
                              href="mailto:hello@thekallective.com"
                              target="_blank"
                              style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; text-decoration: none; text-decoration: none; color: #E63946; font-size: 16px;line-height: 24px;font-weight: bold;"
                            >hello@thekallective.com</a>
                          </td>
                        </tr>
                        <tr>
                          <td 
                            align="center" 
                            valign="top" 
                            style="padding: 8px 0px 0px 0px;text-align: center;"
                          >
                            <span style="padding: 8px 12px 0px 12px;display: inline-block; vertical-align: top;">
                              <a 
                                href="https://dev.thekallective.com/terms-conditions/"
                                target="_blank"
                                style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;line-height: 24px;font-weight: bold;text-decoration: none;text-decoration: none;"
                              >Terms of Use</a>
                            </span>
                            <span style="padding: 8px 12px 0px 12px;display: inline-block; vertical-align: top;">
                              <a 
                                href="https://dev.thekallective.com/privacy-policy/"
                                target="_blank"
                                style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;line-height: 24px;font-weight: bold;text-decoration: none;text-decoration: none;"
                              >Privacy Policy</a>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td 
                            align="center" 
                            valign="top" 
                            style="padding: 24px 0px 0px 0px;text-align: center;"
                          >
                            <span style="padding: 0px 12px 0px 12px;">
                              <a 
                                href="<?php echo get_option('facebook_url');?>"
                                target="_blank"
                                style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;line-height: 24px;font-weight: normal;text-decoration: none;"
                              >
                                <img alt="facebook" src="https://dev.thekallective.com/wp-content/themes/kallective/img/email-templates/facebook_grey.png" width="24" height="24"  style="display: block; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;" border="0"/>
                              </a>
                            </span>
                            <span style="padding: 0px 12px 0px 12px;">
                              <a 
                                href="<?php echo get_option('instagram_url');?>"
                                target="_blank"
                                style="display: inline-block; vertical-align: top; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;line-height: 24px;font-weight: normal;text-decoration: none;"
                              >
                                <img alt="instagram" src="https://dev.thekallective.com/wp-content/themes/kallective/img/email-templates/instagram_grey.png" width="24" height="24"  style="display: block; font-family: Helvetica, Arial, sans-serif; color: #9399A1; font-size: 16px;" border="0"/>
                              </a>
                            </span>
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
            <!-- FOOTER end-->
          </table>
        </div>
      </td>
    </tr>      
    </table>    
  </body>
</html>
