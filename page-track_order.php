<?php
/*
Template Name: Track Order
*/

get_header();
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
    <div class="track-order-section">
        <h1 class="track-order-section__title"><?php echo __('Track Your Order', 'kallective');?></h1>
        <div class="track-order-content">
        <form class="track-order-form">
            <p><?php echo __('To track your order please enter your Order ID in the box below and press the "Track Order" button. This was given to you on your receipt and in the confirmation email you should have received.', 'kallective');?></p>
            <div class="track-order-form__row">
            <div class="control-input">
                <div class="control-label"><?php echo __('Order ID', 'kallective');?></div>
                <input type="text" placeholder="<?php echo __('Enter your order ID here', 'kallective');?>">
            </div> 
            </div>
            <div class="track-order-form__row">
            <div class="control-input">
                <div class="control-label"><?php echo __('E-mail', 'kallective');?></div>
                <input type="email" placeholder="Enter your e-mail here">
            </div> 
            </div>
            <div class="track-order-form__row">
            <button type="submit" class="btn-primary track-order-form__submit"><?php echo __('Track Order', 'kallective');?></button>
            </div>
        </form>
        </div>
    </div>
</div>
<?php
get_footer();