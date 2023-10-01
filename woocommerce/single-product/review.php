<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$rating_perc = $rating / 5 * 100;
?>
<li class="product-reviews-item" id="comment-<?php comment_ID(); ?>">
<div class="product-reviews-item__author"><?php comment_author(); ?></div>
	<div class="product-reviews-item__date"><time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time></div>
	<div class="product-reviews-rate">
		<div class="product-reviews-rate__value" style="width: <?php echo $rating_perc;?>%;"></div>
	</div>
	<div class="product-reviews-item__body"><?php do_action( 'woocommerce_review_comment_text', $comment ); ?></div>
</li>
