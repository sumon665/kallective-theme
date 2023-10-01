<?php $user_id = get_current_user_id();?>
<?php if(function_exists('wc_memberships_get_user_active_memberships')) $user_memberships = wc_memberships_get_user_active_memberships();?>
<h1 class="cabinet-layout__content-title visible-desktop"><?php echo __('Memberships', 'kallective');?></h1>
<div class="cabinet-membership">
    <?php if($user_memberships) :?>
    <p class="cabinet-membership__title"><?php echo __('Active membership:', 'kallective');?></p>
        <div class="cabinet-membership__content">
        <?php foreach($user_memberships as $m): ?>
        <?php $subs = wcs_get_subscriptions_for_order($m->get_order()); ?>
		<?php if(!count($subs)) continue;?>
        <?php $product = $m->get_product(); ?>
        <div class="cabinet-membership-item">
            <?php if($product->is_type( 'subscription' )): ?>
            <div class="cabinet-membership-item__info">
            <p class="cabinet-membership-item-title"><?php echo $product->get_name();?></p>
            <p class="cabinet-membership-item-price">
                <span>$<?php echo $product->get_price();?></span> / <?php echo WC_Subscriptions_Product::get_period($product);?>
            </p>
            </div>
            <?php endif;?>
            <div class="cabinet-membership-item__actions">
            <?php if(count($subs)): ?>
            <?php $subscription = array_values($subs)[0]; ?>
            <?php $actions = wcs_get_all_user_actions_for_subscription( $subscription, get_current_user_id() ); 
            $cancel_url = "";
            foreach($actions as $action){
                if($action['name'] == 'Cancel') $cancel_url = $action['url'];
            } ?>
            <?php if($cancel_url) :?>
            <button 
                type="button" 
                class="btn-secondary-outline cabinet-membership-item-unsubscrive open-modal cancelSubModal"
                data-modal="#unsubscribe-membership-confirm-modal" data-url="<?php echo $cancel_url;?>"
            ><?php echo __('Unsubscribe', 'kallective');?></button>
            <?php endif;?>
            </div>
            <?php endif;?>
        </div>
        <?php endforeach;?>
    </div>
    <?php else : ?>
    <div class="cabinet-favorites-empty">
        <p class="cabinet-favorites-empty__txt"><?php echo __('You don\'t have a membership yet.', 'kallective');?></p>
        <a href="/memberships/" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Join now', 'kallective');?></a>
    </div>
    <?php endif;?>
</div>
<div class="modal unsubscribe-membership-confirm-modal" id="unsubscribe-membership-confirm-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <?php echo __('Confirmation', 'kallective');?>
          <span class="modal-header__close close-modal"></span>
        </div>
        <div class="modal-body">
          <div class="unsubscribe-membership-confirm-content">
            <!-- state 1 begin -->
            <div id="subStage1">
            <p class="unsubscribe-membership-confirm-content__txt">
              <?php echo __('Do you really would like to stop your membership? <br/>Your prices will be returned to usual mode.', 'kallective'); ?>
            </p>
            <div class="unsubscribe-membership-confirm-content__btns">
              <button type="button" class="btn-secondary-outline close-modal unsubscribe-membership-confirm-btn"><?php echo __('Cancel', 'kallective');?></button>
              <button type="button" class="btn-primary unsubscribe-membership-confirm-btn cancelSubConfirm" data-url=""><?php echo __('Unsubscribe', 'kallective');?></button>
            </div>
            </div>
            <!-- state 1 end -->
            <!-- state 2 begin -->
            <div id="subStage2" style="display: none;">
            <p class="unsubscribe-membership-confirm-content__txt">
              
              <?php echo __('Your membership has been stopped. <br/>Money will not be charged from your card in a next month.', 'kallective'); ?>
			</p>
            <div class="unsubscribe-membership-confirm-content__btns">
              <button type="button" class="btn-primary close-modal unsubscribe-membership-confirm-btn"><?php echo __('Understand', 'kallective');?></button>
            </div>
            </div>
            <!-- state 2 end -->
          </div>
        </div>
      </div>
    </div>
  </div>