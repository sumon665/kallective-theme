<?php
/*
Template Name: Memberships
*/
get_header();
$cur_user = get_current_user_id();
the_post();
?>
<div class="wrapper">
    <div class="breadcrumbs-section">
        <?php woocommerce_breadcrumb([
            'wrap_before' => '<ul class="breadcrumbs">',
            'before' => '<li class="breadcrumbs__item">',
            'wrap_after' => '</ul>',
            'after' => '</li>',
            'delimiter' => ''
        ]); ?>
    </div>
    <div class="memberships-section">
        <h1 class="memberships-top"><?php the_title();?></h1>
        <div class="memberships-intro">
           <?php the_content();?>          
        </div>
        <?php $subs = wc_get_products(['type' => 'subscription', 'order' => 'ASC']); ?>
        <?php if($subs) :?>
        <div class="memberships-plan-row">
            <?php foreach($subs as $product):?>
            <?php $subscribed = wcs_user_has_subscription($cur_user, $product->get_id(), 'active'); ?>
            <div class="memberships-plan-col">
            <div class="memberships-plan-item">
                <?php $discount_text = get_field('discount_text');?>
                <?php if($discount_text):?>
                <span class="memberships-plan-item-economy hidden-mobile"><?php echo $discount_text;?></span>
                <?php endif;?>
                <?php $sale = $product->get_sale_price();
                      $regular = $product->get_regular_price();
                      $price = ($sale > 0) ? $sale : $regular;
                      $old = ($sale > 0) ? $regular : false;
                ?>
                <h2 class="memberships-plan-item__title"><?php echo $product->get_name(); ?></h2>
                <p class="memberships-plan-item__price">
                    <span class="memberships-plan-item-price"><span>$<?php echo $price;?></span> / <?php echo WC_Subscriptions_Product::get_period($product);?></span>
                    <?php if($old):?>
                    <span class="memberships-plan-item-price-old">$<?php echo $old;?></span>
                    <?php endif;?>
                </p>
                <div class="memberships-plan-item__desc">
                <?php echo $product->get_description(); ?>
                </div>
                <div class="memberships-plan-item__action">
                <?php if($subscribed):?>
                <div class="memberships-plan-item-subscribed">
                    <p class="memberships-plan-item-subscribed__top">
                    <i class="icon icon-check"></i>
                    <span><?php echo __('You have this membership', 'kallective');?></span>
                    </p>
                    <p class="memberships-plan-item-subscribed__btm"><?php echo __('You can unsubscribe at my cabinet page.', 'kallective');?></p>
                </div>
                <?php else :?>
                    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                        <input type="hidden" name="type" value="sub">
                        <input type="hidden" name="quantity" value="1" class="qty"> 
                        <button type="submit" class="btn-primary" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo __('Become a member', 'kallective');?></button>
                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                    </form>
                <?php endif;?>
                </div>
            </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</div>
<?php
get_footer();