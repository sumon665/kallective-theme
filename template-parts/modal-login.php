<div class="modal login-modal" id="login-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <span id="login-modal-title">Sign in</span>
          <span class="modal-header__close close-modal"></span>
        </div>
        <div class="modal-body">
          <div class="login-layout">
            <div class="login-layout__form">
              <form class="login-form" data-form="signin" data-title="Sign in" method="post" action="/my-account/">
                <div class="login-form-row">
                  <div class="control-input">
                    <label for="username" class="control-label"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?></label>
                    <input type="text"  name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                  </div>
                </div>
                <div class="login-form-row">
                  <div class="control-input">
                    <label for="password" class="control-label"><?php esc_html_e( 'Password', 'woocommerce' ); ?></label>
                    <input  type="password" name="password" id="password" autocomplete="current-password" />
                  </div>
                </div>
                <div class="login-form-row">
                  <p><span class="login-form__link" data-form="reset">Forgot password?</span></p>                  
                </div>
                <div class="login-form-row">
                  <!-- <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                  </label> -->
                  <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                  <button type="submit" class="btn-primary login-form__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                </div>
                <p class="text-center-mobile">Don’t have an account? <br class="visible-mobile"/><span class="login-form__link" data-form="signup">Sign Up!</span></p>
			        </form>
              <form action="/my-account/" class="login-form" method="post" <?php do_action( 'woocommerce_register_form_tag' ); ?> data-form="signup" data-title="Sign Up">
                <div class="login-form-row">
                  <div class="control-input">
                    <div class="control-label">Your Name</div>
                    <input type="text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>">
                  </div>
                </div>
                <div class="login-form-row">
                  <div class="control-input">
                    <div class="control-label">E-mail</div>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>">
                  </div>
                </div>
                <div class="login-form-row">
                  <div class="control-input">
                    <div class="control-label">Password</div>
                    <input type="password" name="password" id="reg_password" autocomplete="new-password">
                  </div>
                </div>
                <?php //do_action( 'woocommerce_register_form' ); ?>
                <div class="login-form-row">
                  <label class="control-checkbox">
                    <input type="checkbox" name="terms" required>
                    <i class="control-checkbox__icon">
                      <i class="_checked"></i>
                      <i class="_unchecked"></i>
                    </i>
                    <span class="control-checkbox__label">
                    I agree to <a href="/terms-conditions/">Terms & Conditions</a>
                    </span>
                  </label>                  
                </div>
                <div class="login-form-row">
                  <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                  <button type="submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" class="btn-primary login-form__submit">Sign Up</button>
                </div>
                <?php do_action( 'woocommerce_register_form_end' ); ?>
                <p class="text-center">Already have an account? <span class="login-form__link" data-form="signin">Sign In</span></p>
              </form>
              <form class="login-form" data-form="reset" data-title="Reset Password" method="post">
                <div class="login-form-row">
                  <p>We will send you an email with a link to reset your password.</p>                  
                </div>
                <div class="login-form-row">
                  <div class="control-input">
                    <div class="control-label">E-mail</div>
                    <input type="text" name="user_login" id="user_login" autocomplete="username">
                  </div>
                </div>                
                <div class="login-form-row">
                  <input type="hidden" name="wc_reset_password" value="true" />
                  <button type="submit" class="btn-primary login-form__submit" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>">Reset Password</button>
                </div>
                <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                <p class="text-center"><span class="login-form__link" data-form="signin">I remember my password</span></p>
				  
              </form>
            </div>
            <div class="login-layout__social">
              <form action="/my-account/" method="post" <?php do_action( 'woocommerce_register_form_tag' ); ?>>
                <span class="login-layout__social-divider">OR</span>
                <?php do_action( 'woocommerce_register_form_start' ); ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>