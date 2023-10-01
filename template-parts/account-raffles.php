<h1 class="cabinet-layout__content-title visible-desktop"><?php echo __('Raffles Dashboard', 'kallective');?></h1>
<?php if(!isset($args['lotteries']) || empty($args['lotteries'])) :?>
<!-- empty start -->
<div class="cabinet-favorites-empty" style="display: none;">
    <p class="cabinet-favorites-empty__txt"><?php echo __('You don\'t have a active raffles yet.', 'kallective');?></p>
    <a href="" class="btn-primary cabinet-favorites-empty__link"><?php echo __('Join now', 'kallective');?></a>
</div>
<!-- empty end -->
<?php else:?>
<!-- content start -->
<div class="cabinet-raffles-dashboard">
    <p class="cabinet-raffles-dashboard__title"><?php echo __('Raffles tickets', 'kallective');?></p>
    <ul class="cabinet-raffles-list">
    <?php foreach($args['lotteries'] as $l_id):
    $product = wc_get_product( $l_id ) ;

    if ( ! is_object( $product ) ) {
        continue ;
    }
    $price = $product->get_price();
    $amount = $price * count($product->get_user_purchased_tickets());
    $statuses = lty_get_lottery_statuses();
    $status = $statuses[$product->get_lty_lottery_status()];
    $status_class = "inactive";
    if(in_array($status, ['Lottery Started', 'Lottery Not Started', 'Lottery Finished'])) $status_class = "active";
    ?>
    <li>
        <div class="cabinet-raffles-item">
        <div class="cabinet-raffles-item__title"><?php echo __('Ticket', 'kallective');?> #<?php echo $product->get_id();?> </div>
        <p class="cabinet-raffles-item-details">
            <span class="_label"><?php echo __('Raffle name:', 'kallective');?> </span><?php echo $product->get_title();?>
        </p>
        <p class="cabinet-raffles-item-details">
            <span class="_label"><?php echo __('Start date:', 'kallective');?> </span><?php echo LTY_Date_Time::get_wp_format_datetime_from_gmt( $product->get_lty_start_date_gmt() , 'Y/m/d', ' ' , false );?>
        </p>
        <p class="cabinet-raffles-item-details">
            <span class="_label"><?php echo __('Ticket status:', 'kallective');?> </span><span class="cabinet-raffles-item-status _<?php echo $status_class;?>"><?php echo $status;?></span>
        </p>
        <p class="cabinet-raffles-item-total">
            <?php echo __('Total Amount:', 'kallective');?><span class="_value">$ <?php echo number_format($amount);?></span>
        </p>
        </div>
    </li>
    <?php endforeach;?>
    </ul>
</div>
<!-- content end -->
<?php endif;?>