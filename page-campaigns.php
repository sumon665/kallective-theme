<?php
/*
Template Name: Campaigns
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
            <h2 class="challenges-content__title"><?php echo __('Current Campaigns', 'kallective');?></h2>
            <?php $posts = get_posts([
                'post_type' => 'kampaign'
            ]);?>
            <!-- not empty begin -->
            <?php if(count($posts)) :?>
            <div class="challenges-list-wrap">
                <ul class="challenges-list">
                <?php foreach($posts as $post): ?>
                    <?php $img = get_post_meta($post->ID, '_listing-img', true);
                    $title = get_the_title( $post->ID );
                    $excerpt = get_the_excerpt( $post->ID );
                    $goal = get_post_meta($post->ID, '_organization-goal', true);
                    $collected = get_post_meta($post->ID, '_organization-collected', true);
                    ?>
                    <li class="challenges-list__item">
                        <div class="challenges-item">
                            <a href="<?php echo get_the_permalink($post->ID);?>" class="challenges-item__img">
                                <img src="<?php echo $img;?>" alt="">
                            </a>
                            <div class="challenges-item-info">
                                <div class="challenges-item__date"><?php echo get_the_date( 'F d, Y', $post->ID ); ?></div>
                                <h3 class="challenges-item__name"><?php echo $title;?></h3>
								<?php if($collected >= $goal):?>
								<p><b>$<?php echo $goal;?></b> raised</p>
								<?php else :?>
								<p>$<?php echo $collected;?> / <b>$<?php echo $goal;?></b> raised</p>
								<?php endif;?>
                                <div class="challenges-item__link">
                                <a href="<?php echo get_the_permalink($post->ID);?>" class="btn-primary"><?php echo __('Support this Campaign', 'kallective');?></a>
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
                <p><?php echo __('There are no active Campaigns available, please check back soon!', 'kallective');?></p>
            </div>
            <!-- empty end -->
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
get_footer();