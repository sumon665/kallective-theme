<?php 
$current_user = wp_get_current_user(); 
$current_first_name = $current_user->first_name;
$current_last_name  = $current_user->last_name;
$current_email      = $current_user->user_email;
if(!$current_first_name){
	list($current_first_name, $current_last_name) = explode(" ", $current_user->user_nicename);
}
?>
<div class="modal" id="profile-edit-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Edit information
        <span class="modal-header__close close-modal"></span>
      </div>
      <div class="modal-body">
        <form id="profile-edit-form" class="profile-edit-form" autocomplete="off" action="" method="post">
          <?php wp_nonce_field('update_user_data','update_user_data_nonce'); ?>
          <input type="hidden" name="action" value="update_user_data">
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">First name</div>
              <input type="text" name="account_first_name" value="<?php echo $current_first_name;?>" placeholder="William"> 
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Last Name</div>
              <input type="text" name="account_last_name" value="<?php echo $current_last_name;?>" placeholder="Dafoe">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Date of birth</div>
              <input type="date" value="<?php echo get_field('birthday', $current_user->ID); ?>" name="birthday" placeholder="02/23/1995">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Email</div>
              <input type="email" name="account_email" value="<?php echo $current_email;?>" placeholder="dafoe12@gmail.com">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Phone number</div>
              <input type="tel" pattern="[0-9]{6,12}" name="billing_phone" value="<?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?>" placeholder="12223324223">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Old password</div>
              <input type="password" name="password_current" required placeholder="●●●●●●●●●●●">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">New password</div>
              <input type="password" name="password_1" placeholder="●●●●●●●●●●●">
            </div>      
          </div>
          <div class="profile-edit-form__row">
            <div class="control-input">
              <div class="control-label">Repeat New password</div>
              <input type="password" name="password_2" placeholder="●●●●●●●●●●●">
            </div>      
          </div>
          <div>
            <button type="submit" class="btn-primary profile-edit-form__submit" id="profile-edit-form-submit">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>