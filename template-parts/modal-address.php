<?php 
$user_id = get_current_user_id();
$customer = new WC_Customer( $user_id ); 
?>

<div class="modal" id="address-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <?php if($customer->get_shipping_city()):?><?php echo __('Change address', 'kallective');?><?php else: ?><?php echo __('Add new address', 'kallective');?><?php endif;?>
          <span class="modal-header__close close-modal"></span>
        </div>
        <div class="modal-body">
          <form id="profile-address-form" class="profile-address-form" autocomplete="off" novalidate="novalidate" method="post"> 
          <?php wp_nonce_field('update_user_address','update_user_address_nonce'); ?>
          <input type="hidden" name="action" value="update_user_address">
            <div class="profile-address-form__row">
              <div class="profile-address-form__col">
                <div class="control-select">
                  <div class="control-label">Country</div>
                  <?php kallective_form_field( 'shipping_country', [ 
                    'type' => 'country', 
                    'custom_attributes' => ['data-class' => 'modal-select' ]
                  ], $customer->get_shipping_country() ); ?>
                </div>   
              </div>       
            </div>
            <div class="profile-address-form__row">
              <div class="profile-address-form__col">
                <div class="control-input">
                  <div class="control-label"><?php echo __('City', 'kallective');?></div>
                  <input type="text" name="shipping_city" value="<?php echo $customer->get_shipping_city();?>">
                </div> 
              </div>         
            </div>
            <div class="profile-address-form__row">
              <div class="profile-address-form__col">
                <div class="control-input">
                  <div class="control-label"><?php echo __('Address', 'kallective');?></div>
                  <input type="text" name="address" value="<?php echo $customer->get_shipping_address_1();?> <?php echo $customer->get_shipping_address_2();?>">
                </div>  
              </div>        
            </div>
            <div class="profile-address-form__row">
              <div class="profile-address-form__col _half">
                <div class="control-select">
                  <div class="control-label"><?php echo __('State', 'kallective');?></div>
                  <?php kallective_form_field( 'shipping_state', [ 
                    'type' => 'state', 
                    'custom_attributes' => ['data-class' => 'modal-select' ]
                  ], $customer->get_shipping_state()); ?>
                </div> 
              </div>
              <div class="profile-address-form__col _half">
                <div class="control-input">
                  <div class="control-label"><?php echo __('Postal Code', 'kallective');?></div>
                  <input type="text" name="shipping_postcode" value="<?php echo $customer->get_shipping_postcode();?>">
                </div> 
              </div>
            </div>
            <div>
              <button type="submit" class="btn-primary profile-address-form__submit" id="profile-address-form-submit"><?php if($customer->get_shipping_city()):?><?php echo __('Change Address', 'kallective');?><?php else: ?><?php echo __('Add Address', 'kallective');?><?php endif;?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>