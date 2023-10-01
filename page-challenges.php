<?php
/*
Template Name: Challenges
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
            <h2 class="challenges-content__title"><?php echo __('Current Challenges', 'kallective');?></h2>
            <?php 
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => $post->ID,
                'order'          => 'ASC',
                'orderby'        => 'menu_order'
             ); 
             $challenges = get_posts($args);
            ?>
            <!-- not empty begin -->
            <?php if(count($challenges)) :?>
            <div class="challenges-list-wrap">
                <ul class="challenges-list">
                <?php foreach($challenges as $post): ?>
                    <?php setup_postdata($post); ?>
                    <li class="challenges-list__item">
                        <div class="challenges-item" data-countdown="<?php echo get_field('timer'); ?>">
                            <a href="<?php echo get_permalink();?>" class="challenges-item__img">
                                <img src="<?php echo get_the_post_thumbnail_url();?>" alt="">
                            </a>
                            <div class="challenges-item-info">
                                <div class="challenges-item__date"><?php echo get_the_date( 'F d, Y' ); ?></div>
                                <h3 class="challenges-item__name"><?php the_title();?></h3>
                                <div class="challenges-item-timer"></div>
                                <div class="challenges-item__link">
                                <a href="<?php echo get_permalink();?>" class="btn-primary"><?php echo __('Join now', 'kallective');?></a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
                <?php wp_reset_postdata(); ?>
                </ul>
            </div>
            <!-- not empty end -->
            <?php else: ?>
            <!-- empty begin -->
            <div class="challenges-empty">
                <p><?php echo __('There are no active Challenges available, please check back soon!', 'kallective');?></p>
            </div>
            <!-- empty end -->
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
get_footer();