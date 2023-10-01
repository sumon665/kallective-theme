<?php

defined( 'ABSPATH' ) || exit;

global $product;
$gift = lty_get_lottery_gift_products( false , $product , true ) ;
?>

<div class="breadcrumbs-section">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
        <a href="/" class="breadcrumbs__link">Main page</a>
        </li>
        <li class="breadcrumbs__item">
        <a href="/raffles/" class="breadcrumbs__link">Raffles</a>
        </li>
        <li class="breadcrumbs__item">
        <span class="breadcrumbs__current"><?php the_title();?></span>
        </li>
    </ul>
</div>
<div class="raffle-layout">
    <div class="raffle-layout-info">
    <h1 class="raffle-details__name hidden-desktop"><?php the_title();?></h1>
    <p class="raffle-details__desc hidden-desktop"><strong><?php echo $gift;?></strong> will be Given to Winner for Free.</p>
    <div class="raffle-layout-info__img">
        <div class="raffle-details-img">                
        <img src="<?php echo get_the_post_thumbnail_url( );?>" alt="">
        </div>
        <span class="raffle-layout-info__img-logo"></span>
    </div>
    <div class="raffle-layout-info__desc">
        <div class="raffle-details">
        <h1 class="raffle-details__name visible-desktop"><?php the_title();?></h1>
        <p class="raffle-details__desc visible-desktop"><strong><?php echo $gift;?></strong> will be Given to Winner for Free.</p>
        <div class="raffle-details-period">
            <?php if ( lty_display_date_starts_on_label_in_single_product() ) : ?>
                <p class="raffle-details-period__row">
                <span>Start date:</span> <?php echo LTY_Date_Time::get_wp_format_datetime($product->get_lty_start_date(), 'Y/m/d H:i') ; ?>
                </p>
            <?php endif;?>
            <?php if ( lty_display_date_ends_on_label_in_single_product() ) : ?>
                <p class="raffle-details-period__row">
                <span>End date:</span> <?php echo LTY_Date_Time::get_wp_format_datetime($product->get_lty_start_date(), 'Y/m/d H:i') ; ?>
                </p>
            <?php endif ; ?>
        </div>
        <div class="raffle-details-timer-block">
            <p class="raffle-details-timer-block__label"><?php echo esc_html( $product->get_date_ranges_text() ) ; ?></p>
            <div class="raffle-details-timer" data-countdown="<?php echo $product->get_countdown_timer_enddate(); ?>"></div>
        </div>
        <?php 
        $min = $product->get_lty_minimum_tickets();
        $max = $product->get_lty_maximum_tickets();
        $sold = $product->get_purchased_ticket_count();
        $percent = lty_get_progress_bar_percentage($product);
        $remaining = $max - $sold;
        ?>
        <div class="raffle-details-tickets">
            <p class="raffle-details-tickets__row">Minimum tickets: <b><?php echo $min;?></b></p>
            <p class="raffle-details-tickets__row">Limited to (tickets): <b><?php echo $max;?></b></p>
        </div>
        <div class="raffle-details-progress">
            <p class="raffle-details-progress__label">Tickets issued: <b><?php echo $sold;?></b></p>
            <div class="raffle-progress">
            <span class="raffle-progress__txt"><?php echo $sold;?>/<?php echo $max;?> (<?php echo $percent;?>%)</span>
            <div class="raffle-progress__value" style="width: <?php echo $percent;?>%;">
                <span class="raffle-progress__txt"><?php echo $sold;?>/<?php echo $max;?> (<?php echo $percent;?>%)</span>
            </div>
            </div>
            <p class="raffle-details-progress__tickets-left"><?php echo $remaining;?> tickets remaining</p>
        </div>
        <p class="raffle-details-winners">This ruffle will have <b><?php echo $product->get_lty_winners_count();?> winners!</b></p>
        <div>
        <form class="cart lty-participate-now" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action' , $product->get_permalink() ) ) ; ?>" method="post" enctype='multipart/form-data'>
        <?php
        /**
         * Hook: woocommerce_before_add_to_cart_button hook.
         *
         * */
        do_action( 'woocommerce_before_add_to_cart_button' ) ;

        if ( ! $product->is_manual_ticket() ) :

            /**
             * Hook: lty_before_add_to_cart_quantity hook.
             *
             * */
            do_action( 'lty_before_add_to_cart_quantity' ) ;

            /**
             * Hook: woocommerce_before_add_to_cart_quantity hook.
             *
             * */
            do_action( 'woocommerce_before_add_to_cart_quantity' ) ;

            // Display the quantity input fields.
            woocommerce_quantity_input( lty_get_quantity_input_arguments( $product ) ) ;

            /**
             * Hook: woocommerce_after_add_to_cart_quantity hook.
             *
             * */
            do_action( 'woocommerce_after_add_to_cart_quantity' ) ;

            /**
             * Hook: lty_after_add_to_cart_quantity hook.
             *
             * */
            do_action( 'lty_after_add_to_cart_quantity' ) ;

        endif ;
        ?>

        <input type="hidden" name="add-to-cart" class="product_id" value="<?php echo esc_attr( $product->get_id() ) ; ?>">
            
        <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ) ; ?>" class="ajax_add_to_cart btn-primary raffle-details-join">Join Ruffle</button>
        <?php
        /**
         * Hook: woocommerce_after_add_to_cart_button hook.
         *
         * */
        do_action( 'woocommerce_after_add_to_cart_button' ) ;

        /**
         * Hook: lty_after_add_to_cart_button hook.
         *
         * */
        do_action( 'lty_after_add_to_cart_button' ) ;
        ?>
        </form>
        </div>
        </div>
    </div>
    </div>
    <div class="raffle-tabs">
    <div class="tabs">
        <div class="tabs-header-wrap">
        <div class="tabs-header">
            <ul class="tabs-header-list">
            <li class="tabs-header-list__item active" data-tab="1">Description</li>
            <li class="tabs-header-list__item" data-tab="2">Details</li>
            </ul>
        </div>
        </div>
        <div class="tabs-content">
        <div class="tabs-content__item active" data-tab="1">
            <div class="raffle-tabs-description">
                <?php the_content();?>
            </div>
        </div>
        <div class="tabs-content__item" data-tab="2">
            <div class="raffle-tabs-description">
                <?php the_excerpt();?>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>