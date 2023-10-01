<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

//thumbs
$attachment_ids = $product->get_gallery_image_ids();
$bdroppy_gal = $product->get_meta('_bdroppy_wcgallary');
$thumb_id = get_post_thumbnail_id();
if(!array_search($thumb_id, $attachment_ids)){
  $attachment_ids[] = $thumb_id;
}
if($product->is_type('variable')){
  foreach($product->get_available_variations() as $k=>$v){
    if($v['image_id']) $attachment_ids[] = $v['image_id'];
  }
}
$attachment_ids = array_unique($attachment_ids);
$attachment_urls = [];
foreach( $attachment_ids as $attachment_id ) {
  $attachment_urls[] = wp_get_attachment_url( $attachment_id );
}
if(count($bdroppy_gal)){
	foreach( $bdroppy_gal as $b_item ) {
	  $attachment_urls[] = $b_item['url'];
	}
}
$is_nyp = WC_Name_Your_Price_Helpers::is_nyp($product); 

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
    <div class="breadcrumbs-section">
			<?php woocommerce_breadcrumb([
				'wrap_before' => '<ul class="breadcrumbs">',
				'before' => '<li class="breadcrumbs__item">',
				'wrap_after' => '</ul>',
				'after' => '</li>',
				'delimiter' => ''
			]); ?>
		</div>
		
		<div class="product-layout _favorite">
          <div class="product-layout-info">
            <div class="product-details__name hidden-desktop"><?php the_title();?></div>
            <?php
            /*
            <p class="product-campaign-goal hidden-desktop">
              <b>Campaign Goal: <span class="color-accent">$100,000</span></b>
            </p>
            */
            ?>
            <p class="product-details__category hidden-desktop"><?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
            <br><?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
            </p>
            <div class="product-layout-info__img">
              <div class="product-gallery-wrap">
                <div class="product-gallery" data-images="<?php echo htmlspecialchars(json_encode($attachment_urls));?>">
                <?php foreach( $attachment_urls as $attachment_url ) {
                  echo '<img src="' . $attachment_url . '">';
                } ?>
                </div>
              </div>
            </div>
            <div class="product-layout-info__desc">
              <div class="product-details">
                <h1 class="product-details__name visible-desktop"><?php the_title();?></h1>
                <?php
                /*
                <div class="product-campaign-goal visible-desktop">
                  <p>
                    <b>Campaign Goal: <span class="color-accent">$100,000</span></b>
                  </p>
                </div>
                <div class="product-campaign-reverse">
                  <div class="product-campaign-description">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                  </div>
                  <div class="product-campaign-sponsor">
                    <div class="product-campaign-sponsor__logo">
                      <img src="<?php echo get_template_directory_uri( ); ?>/img/icons/thekallective-sponsor.svg" alt="thekallective">
                    </div>
                    <div class="product-campaign-sponsor__info">
                      <p class="color-light">Campaign Sponsor</p>
                      <p class="product-campaign-sponsor__info-value">The Kallective</p>
                    </div>
                  </div>                  
                </div>
                <div class="product-campaign-organizator-wrap">
                  <div class="product-campaign-organization">
                    <div class="product-campaign-organization__img hidden-mobile">
                      <img src="<?php echo get_template_directory_uri( ); ?>/img/icons/thekallective-sponsor.svg" alt="thekallective">
                    </div>
                    <div class="product-campaign-organization__info">
                      <p class="_top">
                        <span class="color-light">Organization</span>One Tree Planted
                      </p>
                      <p class="_btm">
                        <b>$100,000</b><span class="color-light">of $100,000 Goal</span>
                      </p>
                    </div>
                  </div>
                  <div class="product-campaign-organizator-controls">
                    <button type="button" class="btn-primary open-modal" data-modal="#campaign-contribute-modal">Contribute</button>
                    <button type="button" class="btn-secondary-outline">Releasing Soon</button>
                    <!-- <button type="button" class="btn-primary" disabled>Goal Achieved</button>
                    <button type="button" class="btn-primary open-modal" data-modal="#campaign-checkout-modal">Checkout Now</button> -->
                  </div>
                </div>
                <div class="product-campaign-countdown-wrap">
                  <p class="text-center">Giveaway Begins in:</p>
                  <div class="product-campaign-countdown">
                    <div class="product-campaign-countdown-item visible-desktop">
                      <span>00</span>
                      <p class="color-light">Days</p>
                    </div>
                    <div class="product-campaign-countdown-item">
                      <span>00</span>
                      <p class="color-light">Hrs</p>
                    </div>
                    <div class="product-campaign-countdown-item">
                      <span>00</span>
                      <p class="color-light">Mins</p>
                    </div>
                    <div class="product-campaign-countdown-item">
                      <span>00</span>
                      <p class="color-light">Secs</p>
                    </div>
                  </div>
                </div>
                */
                ?>
                <p class="product-details__category visible-desktop">
				        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?><br/>
				        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
                </p>
                <?php if(!$is_nyp) :?>
                  <div class="product-details-prices">
                    <div class="product-details__price">
                    <?php 
                      if($product->is_type( 'variable' )){
                        $min_price_for_display = number_format($product->get_variation_price('min', true),2);
		                    $max_price_for_display = number_format($product->get_variation_price('max', true),2);
                        if($min_price_for_display > 0){
                          if($min_price_for_display != $max_price_for_display) {
                            echo "$ $min_price_for_display - $ $max_price_for_display";
                          } else {
                            echo "$ $min_price_for_display";
                          }
                        }
                      } else if($product->is_type( 'simple' )){
                        $price = number_format($product->get_regular_price(), 2);
		                    $sale = number_format($product->get_sale_price(), 2);
                        if($sale > 0){
                          echo "$ $sale<span>$ $price</span>";
                        } else if($price > 0){
                          echo "$ $price";
                        }
                      }
                    ?>
                    </div>
                    
                    <div class="product-details-external-price">
                      <div class="product-details-external-price__item">
                        <img src="<?php echo get_template_directory_uri();?>/img/icons/ebay.svg" width="40" height="16" alt="ebay">
                        $55.00
                      </div>
                      <div class="product-details-external-price__item">
                        <img src="<?php echo get_template_directory_uri();?>/img/icons/amazon.svg" width="40" height="12" alt="amazon">
                        $35.45
                      </div>
                    </div>
                  </div>
                  <?php else : ?>
                   
                  <?php endif; ?>
                  <?php if($product->is_in_stock()):?>
                  <?php woocommerce_template_single_add_to_cart();?>
                  <?php elseif(!$product->is_in_stock() && get_field('waitlist') && is_user_logged_in()):?>
                  <?php $posts = get_posts( array(
                    'numberposts' => 1,
                    'meta_key'    => '_waitaccess',
                    'meta_value'  => 'yes',
                    'post_type'   => 'product',
                  ) ); 
                  if($posts[0]->ID){
                    $waitaccess_product = wc_get_product($posts[0]->ID);
                    $waitacces_in_cart = kallective_matched_cart_items($posts[0]->ID);
                    $product_in_waitlist = kallective_is_product_in_waitlist($product->get_id());
                  } 
                  ?>
                  <?php if($waitaccess_product && !$waitacces_in_cart && !$product_in_waitlist):?>
                  <div class="product-details-waitlist">
                    <span class="product-details-waitlist__title"><?php echo __( 'Upcoming release', 'woocommerce' );?></span>
                    <p class="product-details-waitlist__txt"><?php echo __( 'Use our "Upcoming release" function and be one of the first who will purchase this item.', 'woocommerce' );?></p>
                    <?php kallective_is_waitlist_access($waitaccess_product);?>
                    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $waitaccess_product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                        <input type="hidden" name="quantity" value="1" class="qty"> 
                        <input type="hidden" name="wait-product" value="<?php echo $product->get_id();?>">
                        <button type="submit" class="btn-primary product-details-waitlist__link" name="add-to-cart" value="<?php echo esc_attr( $waitaccess_product->get_id() ); ?>">Get your access — <?php kallective_product_price($waitaccess_product);?></button>
                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                    </form>
                  </div>
                  <?php elseif($waitaccess_product && $waitacces_in_cart):?>
                  <div class="product-details-waitlist">
                    <span class="product-details-waitlist__title"><?php echo __( 'Upcoming release', 'woocommerce' );?></span>
                    <p class="product-details-waitlist__txt"><?php echo __( 'Waitlist access is in your cart. Buy it to be one of the first who will purchase this item.', 'woocommerce' );?></p>
                  </div>  
                  <?php elseif($product_in_waitlist):?>
                    <div class="product-details-waitlist">
                    <span class="product-details-waitlist__title"><?php echo __( 'Upcoming release', 'woocommerce' );?></span>
                    <p class="product-details-waitlist__txt"><?php echo __( 'You are already in wailist!', 'woocommerce' );?></p>
                  </div>   
                  <?php endif;?>
                  <?php endif;?>
                  <div class="product-advantages">
                    <?php $advantages = get_field('advantages');?>
                    <?php if($advantages) :?>
                    <?php foreach($advantages as $adv):?>
                    <div class="product-advantages-row">
                    <?php echo $adv['row'];?>
                    </div>
                    <?php endforeach;?>
                    <?php else:?>
                    <div class="product-advantages-row">
                    Free Shipping for Kallective members
                    </div>
                    <div class="product-advantages-row">
                    100% Secure Checkout
                    </div>
                    <div class="product-advantages-row">
                    Make a difference and save even more
                    </div>
                    <div class="product-advantages-row">
                    Special prices for Kallective members
                    </div>
                    <?php endif;?>
                  </div>
              </div>
            </div>
          </div>
          <div class="product-tabs">
            <div class="tabs">
              <?php $qa = get_field('qa'); ?>
              <div class="tabs-header-wrap">
                <div class="tabs-header">
                  <div class="tabs-header__toggle visible-mobile">
                    <?php echo __( 'Overview', 'woocommerce' );?>
                  </div>
                  <ul class="tabs-header-list">
                    <li class="tabs-header-list__item active" data-tab="1"><?php echo __( 'Overview', 'woocommerce' );?></li>
                    <li class="tabs-header-list__item" data-tab="2"><?php echo __( 'Reviews', 'woocommerce' );?> (<?php echo $product->get_review_count(); ?>)</li>
                    <?php if($qa) : ?>
                    <li class="tabs-header-list__item" data-tab="3"><?php echo __( 'Q&A', 'woocommerce' );?> (<?php echo $qa ? count($qa) : 0; ?>)</li>
                    <?php endif;?>
                    <li class="tabs-header-list__item" data-tab="4"><?php echo __( 'Delivery', 'woocommerce' );?><span class="hidden-tablet"> information</span></li>
                    <?php
                    /*
                    <li class="tabs-header-list__item" data-tab="5">Campaign</li>
                    */
                    ?>
                  </ul>
                </div>
              </div>
              <div class="tabs-content">
                <div class="tabs-content__item active" data-tab="1">
                  <div class="product-tabs-description">
                    <div class="product-tabs-description-item">
                      <h3 class="product-tabs-description-item__label"><?php echo __( 'Description:', 'woocommerce' );?></h3>
                      <div class="product-tabs-description-item__value">
                      <?php the_content();?>
                      </div>
                    </div>
                    <div class="product-tabs-description-item">
                      <h3 class="product-tabs-description-item__label"><?php echo __( 'Additional information:', 'woocommerce' );?></h3>
                      <div class="product-tabs-description-item__value">
					            <?php wc_display_product_attributes($product);?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tabs-content__item" data-tab="2">
                  <?php comments_template('reviews', ['title' => 'reviews', 'priority'=> 30, 'callback' => 'comments_template']); ?>
                </div>
                <div class="tabs-content__item" data-tab="3">
                  <?php if(count($qa)) : ?>
                  <div class="product-tabs-faq">
                    <h3 class="product-tabs-faq__title"><?php echo __( 'Most common questions', 'woocommerce' );?></h3>
                    <?php foreach($qa as $q_item) : ?>
                    <div class="faq-accordion accordion-item">
                      <div class="faq-accordion__header accordion-item__header"><?php echo $q_item->post_title;?></div>
                      <div class="faq-accordion__body accordion-item__body">
                        <p><?php echo $q_item->post_content;?></p>
                      </div>
                    </div>
                    <?php endforeach;?>
                  </div>
                  <?php endif;?>
                </div>
                <div class="tabs-content__item" data-tab="4">
                    <div class="product-tabs-description-item__value">
                      <?php $delivery = get_field('delivery');
                      if(!$delivery) $delivery = get_option( 'delivery_inf' );
                      echo $delivery;?>
                    </div>
                </div>
                <?php
                /*
                <div class="tabs-content__item" data-tab="5">
                  <div class="product-tabs-description">
                    <div class="product-tabs-description-item">
                      <h3 class="product-tabs-description-item__label">Who you’ll be helping</h3>
                      <div class="product-tabs-description-item__value">
                        <p>
                          Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sienean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sionec eu libero sienean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero si.
                          <br/><br/>
                          Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sienean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sionec eu libero sienean ultricies mi vitae est. Mauris placerat eleifend leo.Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero si.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                */
                ?>
              </div>
            </div>
          </div>
        </div>
<div class="modal campaign-checkout-modal" id="campaign-checkout-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span>Checkout</span>
        <span class="modal-header__close close-modal"></span>
      </div>
      <div class="modal-body">
        <div class="campaign-checkout-modal-purchasing-block" style="display: none;">
          <div class="campaign-checkout-modal-purchasing">
            <div class="campaign-checkout-modal-purchasing__icon">
              <i></i>
            </div>
            <div>
              <p>
                Purchasing
              </p>
              <p class="color-light">
                <span>Attempting to complete checkout process</span>
              </p>
            </div>
          </div>
          <button type="submit" class="btn-primary _loading campaign-checkout-modal-purchasing-btn" disabled>
            <span class="btn-label">Access Denied</span>
            <span class="icon icon-spinner"></span>
          </button>
        </div>
        <div class="campaign-checkout-modal-error-block" style="display: none;">
          <div class="campaign-checkout-modal-error">
            <p class="campaign-checkout-modal-error__title">Not eligible to participate</p>
            <p>You do not have a valid Access Pass to participate in this Giveaway Event.</p>
          </div>
          <button type="submit" class="btn-primary campaign-checkout-modal-error-btn">
            <span class="btn-label">Access Denied</span>
            <span class="icon icon-spinner"></span>
          </button>
        </div>
        <div class="campaign-checkout-modal-success text-center">
          <span class="campaign-checkout-modal-success__title">Congrats! <span>🎉</span></span>
          <p>You just received a free item as part of our Giveaway Event!</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal campaign-contribute-modal" id="campaign-contribute-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span>Make a contribution</span>
        <span class="modal-header__close close-modal"></span>
      </div>
      <div class="modal-body">
        <div class="campaign-contribute-modal-intro" style="display: none;">
          <i class="campaign-contribute-modal-intro__icon"></i>
          <p class="text-center campaign-contribute-modal-intro__txt">You need to purchase credits in order to participate in our marketplace campaigns.</p>
          <div class="campaign-contribute-modal-controls">
            <button type="button" class="btn-primary">Purchase Credits</button>
            <button type="button" class="btn-secondary-outline close-modal">Cancel</button>
          </div>
        </div>
        <div class="campaign-contribute-modal-credits" style="display: none;">
          <p class="campaign-contribute-modal-credits__txt">You are about to contribute to the One Tree Planted Campaign.</p>
          <span class="campaign-contribute-modal-credits__title">Your credits</span>
          <div class="campaign-contribute-modal-credits-input-row">
            <div class="control-input">
              <input type="text" placeholder="Enter credit amount">
            </div>
            <p>Credits</p>
          </div>
          <p class="campaign-contribute-modal-credits-row">
            <span class="color-light">Your balance</span>
            <span>250 Credits</span>
          </p>
          <p class="campaign-contribute-modal-credits-row">
            <span class="color-light">Total credits used</span>
            <span>5 Credits</span>
          </p>
          <p class="campaign-contribute-modal-credits-row">
            <span class="color-light">Remaining balance</span>
            <span>245 Credits</span>
          </p>
          <div class="campaign-contribute-modal-controls">
            <button type="button" class="btn-primary">Checkout Now</button>
            <button type="button" class="btn-secondary-outline close-modal">Cancel</button>
          </div>
        </div>
        <div class="campaign-contribute-modal-success text-center">
          <span class="campaign-contribute-modal-success__title">Thank You!</span>
          <p>You successfully contributed to the One Tree Planted Campaign</p>
        </div>
      </div>
    </div>
  </div>
</div>