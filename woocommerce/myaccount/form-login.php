<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
<div class="login-content">
<h1 class="login-content__title">Sign In</h1>
<p class="login-content__txt">Sign in to your account below:</p>
<div class="login-content-layout" id="customer_login">

	<div class="login-content-layout__left">

<?php endif; ?>

    <?php /* <h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2> */ ?>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<div class="login-form-row">
                <div class="control-input">
				<label for="username" class="control-label"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required asterisk">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</div>
			</div>
			<div class="login-form-row">
                <div class="control-input">
					<label for="password" class="control-label"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required asterisk">*</span></label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
				</div>
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class="login-form-row">
				<!-- <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label> -->
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="btn-primary login-form__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
			</div>
			<div class="login-form-row">
				<p class="text-center"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="login-form__link" data-form="reset">Forgot password?</a></p>                  
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="login-content-layout__right">
  <div class="login-content-layout__right-divider"><span>OR</span></div>

    <div class="login-content-layout__right-form">
      <h2 class="login-content-layout__right-form__title"><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>
      <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

        <?php do_action( 'woocommerce_register_form_start' ); ?>

        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

          <div class="login-form-row">
            <div class="control-input">
              <label for="reg_username" class="control-label"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required asterisk">*</span></label>
              <input type="text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="login-form-row">
          <div class="control-input">
            <label for="reg_email" class="control-label"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required asterisk">*</span></label>
            <input type="email" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
          </div>
        </div>

        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
        <div class="login-form-row">
          <div class="control-input">
            <label for="reg_password" class="control-label"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required asterisk">*</span></label>
            <input type="password" name="password" id="reg_password" autocomplete="new-password" />
          </div>
        </div>

        <?php else : ?>

          <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

        <?php endif; ?>

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

      </form>
    </div>

	</div>

</div>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>