<h1 class="cabinet-layout__content-title visible-desktop"><?php echo __('Waitlist', 'kallective');?></h1>
<?php if(!isset($args['products']) || empty($args['products'])) :?>
<!-- empty start -->
<div class="cabinet-favorites-empty">
  <p class="cabinet-favorites-empty__txt"><?php echo __('You have no waitlist items.', 'kallective');?></p>
  <a href="/" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Shop now', 'kallective');?></a>
</div>
<!-- empty end -->
<?php else:?>
<ul class="cabinet-favorites">
  <?php foreach($args['products'] as $p_id):?>
  <?php $product = wc_get_product($p_id);?>
  <li>
    <div class="cabinet-favorites-item">
      <a href="<?php echo $product->get_permalink();?>" class="cabinet-favorites-item__img">
      <?php echo $product->get_image();?>
      </a>
      <div class="cabinet-favorites-item__info">
        <div class="cabinet-favorites-item__category"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?></div>
        <a href="<?php echo $product->get_permalink();?>" class="cabinet-favorites-item__name"><?php echo $product->get_title();?></a>
        <div class="cabinet-favorites-item__price"><?php kallective_product_price($product);?></div>
        <div class="cabinet-favorites-item__btns">
          <a href="javascript:;" class="btn-icon cabinet-favorites-item__btns-remove removeWaitlist" data-id="<?php echo $product->get_id();?>"><i class="icon icon-cross"></i></a>
          <?php if($product->is_in_stock()):?>
          <a href="<?php echo $product->get_permalink();?>" class="btn-primary-outline cabinet-favorites-item__btns-cart"><?php echo __('Go to shopping', 'kallective');?></a>
          <?php else:?>
          <p class="cabinet-waitlist-item-hint"><?php echo __('Item will upcoming soon', 'kallective');?></p>
          <?php endif;?>
        </div>
      </div>
    </div>
  </li>
  <?php endforeach;?>
</ul>
<?php endif;?>