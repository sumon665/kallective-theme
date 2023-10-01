<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews product-tabs-reviews">
	<div id="comments">
		<?php if ( have_comments() ) : ?>
			<ul class="product-reviews-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ul>
			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<div class="product-reviews-empty">
				<p>This item has not any reviews yet. Be the first one!</p>
				<button type="button" class="btn-primary product-reviews-empty-open-modal <?php echo !is_user_logged_in() ? 'noAuth' : 'open-modal';?>" data-modal="#review-modal">Add new review</button>
			</div>
		<?php endif; ?>
	</div>
	<?php 
	$rating_count = $product->get_rating_count();
	$review_count = $product->get_review_count();
	$average      = $product->get_average_rating();
	$average_perc = $average / 5 * 100;
	$vals = [
		'5' => 0,
		'4' => 0,
		'3' => 0,
		'2' => 0,
		'1' => 0
	];
	if($review_count > 0){
		$args = array(
				'number'      => 100, 
				'status'      => 'approve', 
				'post_status' => 'publish', 
				'post_type'   => 'product',
				'post_id' 	  => $product->get_ID()
		);
		$comments = get_comments( $args );
		foreach($comments as $comment){
			$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
			$vals[$rating] ++;
		}
		foreach($vals as $key=>&$val){
			$val = round($val / $review_count * 100, 1);
		}
	}
	?>
	<div class="product-reviews-info">
		<div class="product-reviews-sum">
		<div class="product-reviews-sum-total">
			<b class="product-reviews-sum-total__rate"><?php echo round($average, 1);?><span class="visible-mobile">/5</span></b>
			<span class="product-reviews-sum-total__txt hidden-mobile">
			<?php if($review_count > 0): ?>
			Based on <br/><?php echo $review_count;?> reviews
			<?php else: ?>
			No one <br/>reviews yet
			<?php endif;?>
			</span>
			<div class="product-reviews-rate">
			<div class="product-reviews-rate__value" style="width: <?php echo $average_perc;?>%;"></div>
			</div>
		</div>
		<div class="product-reviews-sum-rates hidden-mobile">
			<?php foreach($vals as $k=>$val) : ?>
			<div class="product-reviews-sum-rates-item">
			<span class="product-reviews-sum-rates-item__label"><?php echo $k;?></span>
			<div class="product-reviews-sum-rates-item__value">
				<div style="width: <?php echo $val;?>%;"></div>
			</div>
			<span class="product-reviews-sum-rates-item__label"><?php echo $val;?>%</span>
			</div>
			<?php endforeach;?>
		</div>
		</div>
		<?php if($review_count > 0): ?>
		<button type="button" class="btn-secondary-outline product-reviews-open-modal <?php echo !is_user_logged_in() ? 'noAuth' : 'open-modal';?>" data-modal="#review-modal">Add new review</button>
		<?php endif;?>
	</div>
</div>
