<?php 
$fav_ids = get_field('favourites', get_current_user_id());
$fav = array_diff(explode(";", $fav_ids), ['']);
?>

<div class="favorites-popover">
    <div class="favorites-popover__header">
		<?php echo __('Favorite items', 'kallective');?>
		<span class="favorites-popover__header-close close-favorites-popover visible-mobile"></span>
    </div>
    <?php if(!count($fav)) : ?>
    <div class="favorites-popover-empty">
        <?php echo __('Your favorites is currently empty', 'kallective');?>
    </div> 
    <?php else: ?>
    <?php $products = wc_get_products([
        'post_status' => 'published',
        'include' => $fav
    ]); ?>
    <div class="favorites-popover__body">
        <?php foreach($products as $product) : ?>
		<div class="favorites-popover-item">
      		<a href="<?php echo $product->get_permalink();?>" class="favorites-popover-item__img">
				<?php echo $product->get_image();?>
			</a>
			<div class="favorites-popover-item__info">
				<div class="favorites-popover-item__category"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?></div>
				<a href="<?php echo $product->get_permalink();?>" class="favorites-popover-item__name"><?php echo $product->get_title();?></a>
				<div class="favorites-popover-item__price">
				<?php kallective_product_price($product);?>
				</div>
			</div>
			<span class="favorites-popover-item__favorite toggleFav" data-id="<?php echo $product->get_id();?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M20.84 4.60987C20.3292 4.09888 19.7228 3.69352 19.0554 3.41696C18.3879 3.14039 17.6725 2.99805 16.95 2.99805C16.2275 2.99805 15.5121 3.14039 14.8446 3.41696C14.1772 3.69352 13.5708 4.09888 13.06 4.60987L12 5.66987L10.94 4.60987C9.9083 3.57818 8.50903 2.99858 7.05 2.99858C5.59096 2.99858 4.19169 3.57818 3.16 4.60987C2.1283 5.64156 1.54871 7.04084 1.54871 8.49987C1.54871 9.95891 2.1283 11.3582 3.16 12.3899L4.22 13.4499L12 21.2299L19.78 13.4499L20.84 12.3899C21.351 11.8791 21.7563 11.2727 22.0329 10.6052C22.3095 9.93777 22.4518 9.22236 22.4518 8.49987C22.4518 7.77738 22.3095 7.06198 22.0329 6.39452C21.7563 5.72706 21.351 5.12063 20.84 4.60987V4.60987Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
				<span><?php echo __('Remove', 'kallective');?></span>
			</span>
		</div>
		<?php endforeach;?>
    </div>
    <?php endif;?>
    <div class="favorites-popover__footer">
        <a href="/my-account/" class="btn-secondary-outline"><?php echo __('Go to favorites', 'kallective');?></a>
    </div>
</div>