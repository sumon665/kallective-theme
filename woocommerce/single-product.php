<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
?>
<div class="wrapper">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php $product_type = WC_Product_Factory::get_product_type(get_the_ID()); ?>
		<?php 
		if($product_type == 'lottery'){
			wc_get_template_part( 'content', 'single-lottery' ); 
		} else{
			wc_get_template_part( 'content', 'single-product' ); 
		}
		?>
	<?php endwhile; // end of the loop. ?>
	<?php if($product_type != 'lottery') :?>
	<?php $categs = wp_get_post_terms(get_the_ID(), 'product_cat');
		$deepest = null;
		foreach($categs as $categ){
			$children = get_terms( 'product_cat', array(
				'parent'    => $categ->term_id,
				'hide_empty' => false
			));
			if(!$children) {
				$deepest = $categ;
				break;
			}
		}
	?>
	<?php $related = wc_get_products(['status' => 'publish','category' => [$deepest->slug], 'orderby' => 'rand', 'exclude' => [get_the_ID()]]); ?>
	<?php if($deepest && count($related) > 2) :?>
	<div class="related-products-section">
		<h4 class="related-products-section__title"><?php echo __( 'Related Products', 'woocommerce' );?></h4>
		<div class="related-products">
		<?php foreach($related as $featured_product):  
			$post_object = get_post($featured_product->get_id());
			setup_postdata($GLOBALS['post'] =& $post_object);
			?>
			<div class="related-products__item">
				<?php get_template_part('template-parts/card', 'product'); ?>
			</div>
		<?php endforeach;
		wp_reset_postdata();
		?>
		</div>
	</div>
	<?php endif;?>
	<?php else: ?>
		<?php $products = wc_get_products([
			'post_status' => 'published',
			'limit' => -1,
			'type' => 'lottery'
		]); 
		?>
		<?php if($products): ?>
		<div class="related-raffles-section">
			<h3 class="related-raffles-section__title"><?php echo __( 'Related Raffles', 'woocommerce' );?></h3>
			<div class="challenges-list-wrap">
			<ul class="challenges-list">
				<?php foreach($products as $product): ?>
                    <li class="challenges-list__item">
                        <div class="challenges-item" data-countdown="<?php echo $product->get_countdown_timer_enddate(); ?>">
                            <a href="<?php echo $product->get_permalink();?>" class="challenges-item__img">
                                <img src="<?php echo $product->get_image();?>" alt="">
                            </a>
                            <div class="challenges-item-info">
                                <div class="challenges-item__date"><?php echo get_the_date( 'F d, Y', $product->get_id() ); ?></div>
                                <h3 class="challenges-item__name"><?php echo $product->get_title();?></h3>
                                <div class="challenges-item-timer"></div>
                                <div class="challenges-item__link">
                                <a href="<?php echo $product->get_permalink();?>" class="btn-primary">Join now</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
			</ul>
			</div>
		</div>
		<?php endif;?>
	<?php endif;?>
</div>
<?php
get_footer();
?>

