<h1 class="cabinet-layout__content-title visible-desktop"><?php echo __('Personal recommendations', 'kallective');?></h1>
<?php 
$exclude_ids = get_field('exclude_personal', get_current_user_id());
$products = wc_get_products([
  'post_status' => 'published',
  'limit' => -1,
  'meta_key'	=> 'personal',
  'meta_value'	=> 1,
  'exclude' => explode(";", $exclude_ids)
]); 
?>
<?php if(count($products)) :?>
<ul class="cabinet-recommendations">
<?php foreach($products as $product): ?>
  <li>
    <div class="cabinet-recommendations-item">
      <a href="<?php echo $product->get_permalink();?>" class="cabinet-recommendations-item__img">
        <?php echo $product->get_image();?>
      </a>
      <div class="cabinet-recommendations-item__info">
        <div class="cabinet-recommendations-item__category"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?></div>
        <a href="<?php echo $product->get_permalink();?>" class="cabinet-recommendations-item__name"><?php echo $product->get_title();?></a>
        <div class="cabinet-recommendations-item__price">
        <?php kallective_product_price($product);?>
        </div>
        <div class="cabinet-recommendations-item__btns">
          <a href="javascript:;" class="btn-icon cabinet-recommendations-item__btns-remove removeRecommend" data-id="<?php echo $product->get_id();?>"><i class="icon icon-cross"></i></a>
          <form action="<?php echo $product->get_permalink();?>">
                <button type="submit" class="btn-primary-outline cabinet-recommendations-item__btns-cart">
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
<?php else: ?>
<div class="cabinet-favorites-empty">
  <p class="cabinet-favorites-empty__txt"><?php echo __('You don\'t have active personal recommendations.', 'kallective');?></p>
  <a href="/" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Shop now', 'kallective');?></a>
</div> 
<?php endif; ?>