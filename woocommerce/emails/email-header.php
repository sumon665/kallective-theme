<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
  <head>
  <title>Reset password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
    body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} 
    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} 
    img{-ms-interpolation-mode: bicubic;} 

    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
    table{border-collapse: collapse !important;}
    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}

    a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
    }

    div[style*="margin: 16px 0;"] { margin: 0 !important; }
  </style>
  <!--[if gte mso 12]>
  <style type="text/css">
  .mso-right {
      padding-left: 20px;
  }
  </style>
  <![endif]-->
  </head>
  <body style="margin: 0 !important; padding: 0 !important;">
    <!-- Visually Hidden Preheader Text : BEGIN -->
    <div
    style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"
    ></div>
    <!-- Visually Hidden Preheader Text : END -->
    <table
      border="0" 
      align="center" 
      cellpadding="0" 
      cellspacing="0" 
      width="100%" 
      style="background-color: #F8F8F8;"
      bgcolor="#F8F8F8"
    >
    <tr>
      <td style="padding: 0px 0px 40px 0px;">
        <div style="width: 100%; max-width: 600px;margin: 0 auto;">
          <table 
            border="0" 
            align="center" 
            cellpadding="0" 
            cellspacing="0" 
            style="margin: 0 auto !important;width: 100%; max-width: 600px;"
          >
            <!-- HEADER begin-->
            <tr>
              <td>
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                <td align="center" valign="top">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapper" style="background-color: #1D3557;background: linear-gradient(#1D3557, #1D3557);">
                  <tr>
                    <td align="left" valign="top" style="padding: 32px 6.667% 32px 6.667%;">
                      <img alt="The Kallective" src="https://dev.thekallective.com/wp-content/themes/kallective/img/email-templates/logo_white.png" width="236" height="32"  style="display: block; font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;" border="0"/>
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
            <!-- HEADER end-->
