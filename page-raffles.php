<?php
/*
Template Name: Raffles
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
    <div class="challenges-section">
        <p class="challenges-top"><?php the_title();?></p>
        <div class="challenges-intro">
        <?php the_content();?>          
        </div>
        <div class="challenges-content">
            <h2 class="challenges-content__title"><?php echo __('Current Raffles', 'kallective');?></h2>
            <?php 
            $lottery_statuses = array() ;
            if ( 'yes' == get_option( 'lty_settings_hide_lottery_finished_status_products' ) ) {
                $lottery_statuses[] = 'lty_lottery_finished' ;
            }

            if ( 'yes' == get_option( 'lty_settings_hide_lottery_failed_status_products' ) ) {
                $lottery_statuses[] = 'lty_lottery_failed' ;
            }

            if ( 'yes' == get_option( 'lty_settings_hide_lottery_closed_status_products' ) ) {
                $lottery_statuses[] = 'lty_lottery_closed' ;
            }
            $products = wc_get_products([
                'limit' => -1,
                'type' => 'lottery',
                'meta_query'     => array(
                    array(
                        'key'     => '_lty_lottery_status' ,
                        'value'   => $lottery_statuses ,
                        'compare' => 'NOT_IN'
                    ) ,
                )
            ]); 
            ?>
            <!-- not empty begin -->
            <?php if(count($products)) :?>
            <div class="challenges-list-wrap">
                <ul class="challenges-list">
                <?php foreach($products as $product): ?>
                    <li class="challenges-list__item">
                        <div class="challenges-item" data-countdown="<?php echo $product->get_countdown_timer_enddate(); ?>">
                            <a href="<?php echo $product->get_permalink();?>" class="challenges-item__img">
                                <img src="<?php echo $product->get_image();?>" alt="">
                            </a>
                            <div class="challenges-item-info">
                                <div class="challenges-item__date"><?php echo get_the_date( 'F d, Y', $product->get_id() ); ?></div>
                                <h3 class="challenges-item__name"><?php echo $product->get_title();?></h3>
                                <div class="challenges-item-timer"></div>
                                <div class="challenges-item__link">
                                <a href="<?php echo $product->get_permalink();?>" class="btn-primary"><?php echo __('Join now', 'kallective');?></a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
            <!-- not empty end -->
            <?php else: ?>
            <!-- empty begin -->
            <div class="challenges-empty">
                <p><?php echo __('There are no active Raffles available, please check back soon!', 'kallective');?></p>
            </div>
            <!-- empty end -->
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
get_footer();