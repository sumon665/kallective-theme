<?php
/**
 * Googleplus Button Template
 * 
 * Handles to load Googleplus button template
 * 
 * @package WooCommerce - Social Login
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<!-- show button -->
<div>
	<?php
	if( $button_type == 1 ) { ?>
		
		<a title="<?php esc_html_e( 'Connect with Google', 'wooslg');?>" href="javascript:void(0);" class="woo-slg-social-login-googleplus btn-secondary-outline login-social__btn icon-left">
			<i class="icon icon-login-google"></i>
			<?php echo !empty($button_text) ? $button_text : esc_html__( 'Sign in with Google', 'wooslg' ); ?>
		</a>
	<?php
	} else { ?>
	
		<a title="<?php esc_html_e( 'Connect with Google', 'wooslg');?>" href="javascript:void(0);" class="woo-slg-social-login-googleplus">
			<img src="<?php echo esc_url($gpimgurl);?>" alt="<?php esc_html_e( 'Google', 'wooslg');?>" />
		</a>
	<?php } ?>
</div>