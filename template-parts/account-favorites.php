<h1 class="cabinet-layout__content-title visible-desktop"><?php echo __('Favorites', 'kallective');?></h1>
<?php $fav_ids = get_field('favourites', get_current_user_id());
$fav = array_diff(explode(";", $fav_ids), ['']); ?>
<?php if(!count($fav)) : ?>
<div class="cabinet-favorites-empty">
  <p class="cabinet-favorites-empty__txt"><?php echo __('You haven\'t saved any items yet.', 'kallective');?></p>
  <a href="/" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Shop now', 'kallective');?></a>
</div> 
<?php else: ?>
<?php $products = wc_get_products([
    'post_status' => 'published',
    'include' => $fav
]); ?>
<ul class="cabinet-favorites">
<?php foreach($products as $product) : ?>
    <li>
    <div class="cabinet-favorites-item">
        <a href="<?php echo $product->get_permalink();?>" class="cabinet-favorites-item__img">
        <?php echo $product->get_image();?>
        </a>
        <div class="cabinet-favorites-item__info">
        <div class="cabinet-favorites-item__category"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?></div>
        <a href="<?php echo $product->get_permalink();?>" class="cabinet-favorites-item__name"><?php echo $product->get_title();?></a>
        <div class="cabinet-favorites-item__price">
        <?php kallective_product_price($product);?>
        </div>
        <div class="cabinet-favorites-item__btns">
            <a href="javascript:;" class="btn-icon cabinet-favorites-item__btns-remove toggleFav" data-id="<?php echo $product->get_id();?>"><i class="icon icon-cross"></i></a>
            <form action="<?php echo $product->get_permalink();?>">
                <button type="submit" class="btn-primary-outline cabinet-favorites-item__btns-cart">
                    <span class="btn-label"><?php echo __('Learn more', 'kallective');?></span>
                    <span class="icon icon-spinner"></span>
                </button>
            </form>
        </div>
        </div>
    </div>
    </li>
<?php endforeach;?>
</ul>
<div class="cabinet-favorites-empty" style="display:none;">
  <p class="cabinet-favorites-empty__txt"><?php echo __('You haven\'t saved any items yet.', 'kallective');?></p>
  <a href="/" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Shop now', 'kallective');?></a>
</div> 
<?php endif; ?>