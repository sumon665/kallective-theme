<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
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
				Welcome to The Kallective, <?php $user_login;?>
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				Thank you for coming on board to help us create impact in our communities.
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 8px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				As a thank, you'll always find many products and other special offers listed on our site, as well as creative new challenges for you to participate in.
				</td>
			</tr>
			<tr>
				<td 
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;line-height: 24px;font-weight: normal;"
				>
				In the meantime, please take a look at some of our recommendations for you:
				</td>
			</tr>
			<tr>
				<td
				align="left" 
				valign="top" 
				style="padding: 16px 0px 0px 0px;"
				>
				<?php $products = wc_get_products([
					'post_status' => 'published',
					'limit' => 2,
					'meta_key'	=> 'personal',
					'meta_value'	=> 1,
				]); 
				$cnt = 1;
				?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php foreach($products as $product): ?>
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
					<?php if($cnt == 1): ?>
					<!-- ITEM DIVIER begin -->
					<tr>
					<td
						style="border-bottom: 1px solid #E8ECEE;padding: 24px 0px 0px 0px;font-size: 1px;line-height: 1px;"
					></td>
					</tr>
					<!-- ITEM DIVIER end -->
					<?php endif;?>
					<?php $cnt++;?>
					<?php endforeach;?>
				</table>
				</td>
			</tr>
			<tr>
				<td
				align="left" 
				valign="top" 
				style="padding: 40px 0px 0px 0px;"
				>
				<table width="242" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td>
						<a 
						href="http://dev.thekallective.com/" 
						target="_blank" 
						style="text-align: center; text-decoration: none;text-decoration: none;font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;font-weight: bold;"
						>
						<img 
							alt="Sell all recommendations" 
							src="http://dev.thekallective.com/wp-content/themes/kallective/img/email-templates/see_all_recommendations.png" 
							width="242" 
							height="44" 
							style="display: block; font-family: Helvetica, Arial, sans-serif; color: #1D3557; font-size: 16px;border: none; outline: none;height: 44px;width: 242px;" 
							border="0"
						/>
						</a>
					</td>
					</tr>
				</table>
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



