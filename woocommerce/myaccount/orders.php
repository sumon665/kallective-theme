<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
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

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<!-- _completed _pending _denied-->
<h1 class="cabinet-layout__content-title visible-desktop">My orders</h1>
<?php if ( $has_orders ) : ?>
	<ul class="order-list">
		<?php
		foreach ( $customer_orders->orders as $customer_order ) {
			$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$item_count = $order->get_item_count() - $order->get_item_count_refunded();
			?>
			<?php
			$actions = wc_get_account_orders_actions( $order );
			if(in_array($order->get_status(), array('pending', 'on-hold'))){
				$status_class = '_pending';
			}
			if(in_array($order->get_status(), array('completed', 'processing'))){
				$status_class = '_completed';
			}
			if(in_array($order->get_status(), array('failed'))){
				$status_class = '_denied';
			}
			?>
			<li class="order-accordion accordion-item">
				<div class="order-accordion__header accordion-item__header">
					<div class="order-header">
					<div class="order-header__left">
						<p class="order-number">Order #<?php echo $order->get_order_number();?> <span class="order-date">(<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>)</span></p>
						<span class="order-status <?php echo $status_class;?> hidden-mobile"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span>
					</div>
					<div class="order-header__right">
						<p class="order-amount-label">Total Amount</p>
						<p class="order-amount"><?php echo $order->get_formatted_order_total();?></p>
						<span class="order-status <?php echo $status_class;?> visible-mobile"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span>
					</div>
					</div>
				</div>
				<div class="order-accordion__body accordion-item__body">
					<div class="order-body">
					<div class="order-body__left">
						<p class="order-body__label">Items:</p>
						<ul class="order-good-list">
						<?php foreach ($order->get_items() as $item) : ?>
						<?php $product = $item->get_product();?>
						<li class="order-good">
              				<a href="<?php echo get_permalink($product->get_id());?>" class="order-good__img">
							<?php echo $product->get_image();?>
							</a>
							<div class="order-good-info">
							<a href="<?php echo get_permalink($product->get_id());?>" class="order-good__name"><?php echo $product->get_title(); ?></a>
							<p class="order-good-info__btm">
								<span class="order-good__price">$<?php echo $item->get_total();?></span>
								<span class="order-good__qty">Quantity: <?php echo $item->get_quantity();?></span>
							</p>
							</div>
						</li>
						<?php endforeach;?>
						</ul>
					</div>
					<div class="order-body__right">
						<p class="order-body__label">Order Information:</p>
						<ul class="order-information">
						<li class="order-information__item">
							<p><span>Address:</span> <?php echo $order->get_shipping_address_1();?> <?php echo $order->get_shipping_address_2();?> <?php echo $order->get_shipping_city();?> <?php echo $order->get_shipping_state();?> <?php echo $order->get_shipping_postcode();?> </p>
						</li>
						<li class="order-information__item">
							<p><span>Payment Method:</span> <?php echo $order->get_payment_method_title();?></p>
						</li>
						<li class="order-information__item">
							<p><span>Recipient:</span> <?php echo $order->get_billing_first_name();?></p>
						</li>
						<li class="order-information__item">
							<p><span>Contacts:</span> <?php echo $order->get_billing_email();?></p>
						</li>
						</ul>
					</div>
					</div>
				</div>
			</li>
			<?php
		}
		?>
	</ul>
	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
<div class="cabinet-favorites-empty">
  <p class="cabinet-favorites-empty__txt">You don't have any orders yet.</p>
  <a href="/" class="btn-primary cabinet-favorites-empty__link">Shop now</a>
</div> 
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>



