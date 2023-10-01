</div> <!-- page-content end -->
<footer class="footer">
      <div class="footer-top-section">
        <div class="wrapper">
          <div class="footer-top">
            <div class="footer-top-left">
              <div class="footer-top-menu-col">
                <h5 class="footer-top-menu-col__title"><?php echo __('Help', 'kallective');?></h5>
                <?php wp_nav_menu( [
                  'theme_location'  => 'footer-help',
                  'container'       => false, 
                  'menu_class'      => 'footer-top-menu', 
                ] ); ?>
              </div>
              <div class="footer-top-menu-col">
                <h5 class="footer-top-menu-col__title"><?php echo __('About', 'kallective');?></h5>
                <?php wp_nav_menu( [
                  'theme_location'  => 'footer-about',
                  'container'       => false, 
                  'menu_class'      => 'footer-top-menu', 
                ] ); ?>
              </div>
              <div class="footer-top-menu-col">
                <h5 class="footer-top-menu-col__title"><?php echo __('Business', 'kallective');?></h5>
                <?php wp_nav_menu( [
                  'theme_location'  => 'footer-business',
                  'container'       => false, 
                  'menu_class'      => 'footer-top-menu', 
                ] ); ?>
              </div>
            </div>
            <div class="footer-top-right">
              <div class="footer-subscribe"> <!-- _success --><!-- _loading -->   
                <div class="footer-subscribe-success">
                  <span><?php echo __('Congratulations!', 'kallective');?></span>
                  <p><?php echo __('Your promocode has been sent to your email.', 'kallective');?></p>
                </div>
                <div class="footer-subscribe-promo">
                  <p><?php echo __('Become an insider and find out about our upcoming offers first!', 'kallective');?></p>
                </div>
                <div class="footer-subscribe-form">
                  <?php echo do_shortcode('[contact-form-7 id="158" title="Join The List"]');?>
                </div>
              </div>
              <ul class="footer-social visible-desktop">
                <li>
                  <a href="<?php echo get_option('instagram_url');?>" target="_blank" rel="noopener noreferrer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M17 2H7C4.23858 2 2 4.23858 2 7V17C2 19.7614 4.23858 22 7 22H17C19.7614 22 22 19.7614 22 17V7C22 4.23858 19.7614 2 17 2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M16 11.3701C16.1234 12.2023 15.9812 13.0523 15.5937 13.7991C15.2062 14.5459 14.5931 15.1515 13.8416 15.5297C13.0901 15.908 12.2384 16.0397 11.4077 15.906C10.5771 15.7723 9.80971 15.3801 9.21479 14.7852C8.61987 14.1903 8.22768 13.4229 8.09402 12.5923C7.96035 11.7616 8.09202 10.91 8.47028 10.1584C8.84854 9.40691 9.45414 8.7938 10.2009 8.4063C10.9477 8.0188 11.7977 7.87665 12.63 8.00006C13.4789 8.12594 14.2648 8.52152 14.8716 9.12836C15.4785 9.73521 15.8741 10.5211 16 11.3701Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M17.5 6.5H17.51" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg> 
                  </a>
                </li>
                <li>
                  <a href="<?php echo get_option('facebook_url');?>" target="_blank" rel="noopener noreferrer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M18 2H15C13.6739 2 12.4021 2.52678 11.4645 3.46447C10.5268 4.40215 10 5.67392 10 7V10H7V14H10V22H14V14H17L18 10H14V7C14 6.73478 14.1054 6.48043 14.2929 6.29289C14.4804 6.10536 14.7348 6 15 6H18V2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg> 
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="footer-terms-social hidden-desktop">
            <ul class="footer-terms-privacy">
              <li><a href="/privacy-policy/"><?php echo __('Privacy policy', 'kallective');?></a></li>
              <li><a href="/terms-conditions/"><?php echo __('Terms & conditions', 'kallective');?></a></li>
            </ul>
            <ul class="footer-social">
              <li>
                <a href="<?php echo get_option('instagram_url');?>" target="_blank" rel="noopener noreferrer">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 2H7C4.23858 2 2 4.23858 2 7V17C2 19.7614 4.23858 22 7 22H17C19.7614 22 22 19.7614 22 17V7C22 4.23858 19.7614 2 17 2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 11.3701C16.1234 12.2023 15.9812 13.0523 15.5937 13.7991C15.2062 14.5459 14.5931 15.1515 13.8416 15.5297C13.0901 15.908 12.2384 16.0397 11.4077 15.906C10.5771 15.7723 9.80971 15.3801 9.21479 14.7852C8.61987 14.1903 8.22768 13.4229 8.09402 12.5923C7.96035 11.7616 8.09202 10.91 8.47028 10.1584C8.84854 9.40691 9.45414 8.7938 10.2009 8.4063C10.9477 8.0188 11.7977 7.87665 12.63 8.00006C13.4789 8.12594 14.2648 8.52152 14.8716 9.12836C15.4785 9.73521 15.8741 10.5211 16 11.3701Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.5 6.5H17.51" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg> 
                </a>
              </li>
              <li>
                <a href="<?php echo get_option('footer_url');?>" target="_blank" rel="noopener noreferrer">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2H15C13.6739 2 12.4021 2.52678 11.4645 3.46447C10.5268 4.40215 10 5.67392 10 7V10H7V14H10V22H14V14H17L18 10H14V7C14 6.73478 14.1054 6.48043 14.2929 6.29289C14.4804 6.10536 14.7348 6 15 6H18V2Z" stroke="#1D3557" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg> 
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-btm-section">
        <div class="wrapper">
          <div class="footer-btm">
            <p class="footer-btm-copy">&copy; <?php echo __('The Kallective 2021. All rights reserved', 'kallective');?></p>
            <ul class="footer-terms-privacy visible-desktop">
                <li><a href="/privacy-policy/"><?php echo __('Privacy Policy', 'kallective');?></a></li>
                <li><a href="/terms-conditions/"><?php echo __('Terms & Conditions', 'kallective');?></a></li>
            </ul>
            <ul class="footer-btm-icons">
                <li><img src="<?php echo get_template_directory_uri( ); ?>/img/icons/visa.svg" width="54" height="24" alt="visa"></li>
                <li><img src="<?php echo get_template_directory_uri( ); ?>/img/icons/mastercard.svg" width="54" height="24" alt="mastercard"></li>
                <li><img src="<?php echo get_template_directory_uri( ); ?>/img/icons/paypal.svg" width="54" height="24" alt="paypal"></li>
                <li><img src="<?php echo get_template_directory_uri( ); ?>/img/icons/discover.svg" width="54" height="24" alt="discover"></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <?php get_template_part( 'template-parts/modal', 'cart' ); ?>
  <?php get_template_part( 'template-parts/modal', 'login' ); ?>
  <?php if(is_product()){
    get_template_part( 'template-parts/modal', 'review' );
    get_template_part( 'template-parts/modal', 'sizes' );
  } ?>
  <?php wp_footer(); ?>